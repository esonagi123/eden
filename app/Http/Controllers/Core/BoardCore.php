<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Response;
use App\Models\Board;
use App\Models\Document;
use App\Models\Comment;
use App\Models\File;

class BoardCore extends Controller
{
	public function index($id)
	{
		// 게시판 정보 불러오기
		$board = Board::where('menu_id', '=', $id)->first();
		$boardInfo['board'] = $board;
		
		// 불러온 게시판 레코드에서 board_id값 변수로 저장
		// $menu_id = $boardInfo['board']->menu_id;
		// 여기선 $id 가 menu_id 값이므로 쓸 필요 없다.
		
		// 주어진 게시판 ID에 해당하는 모든 게시글 불러오기 + 내림차순 정렬
		$documents = Document::where('board_id', '=', $id)->orderByDesc('date')->paginate(10);
		
		// 각 게시글의 정보와 댓글 수를 저장할 빈 배열을 선언
		$result = [];
		foreach ($documents as $document) {
			// 현재 게시글에 대한 댓글 수를 계산
			$commentCount = DB::table('comments')
				->where('document_id', $document->id)
				->count();
			
			// 현재 게시글의 정보와 댓글 수를 연관 배열로 저장
			$result[] = [
				'boardInfo2' => $board,
				'document' => $document,
				'commentCount' => $commentCount,
			];
		}
		
		// 게시판, 게시글 정보와 댓글 수를 포함한 배열을 뷰로 전달
		return view('board.index', [
			'boardInfo' => $boardInfo,
			'documentsWithCommentCounts' => $result,
			'page' => $documents,
		]);
	}


    public function create($id)
    {
		$board = Board::where('menu_id', '=', $id)->first();
		$boardID = $board->id;
		
		$rows = Board::find($boardID);
		
        return view('board.create', ['rows' => $rows]);
    }


    public function store(Request $request, $id)
    {
		$row = new Document;
		$this->save_row($request, $row);
		
		// 저장된 게시글의 $documentID 가져오기 (예: $row->id)
		$documentID = $row->id;
		
		// 세션에서 파일 횟수 및 파일명 불러오기
		$uploadedFileCount = session('uploadedFileCount', 0); // 저장된 파일 횟수

		for ($i = 1; $i <= $uploadedFileCount; $i++)
		{
			$uploadedFileName = session('uploadedFileName' . $i);
			
			// 파일 모델 업데이트
			$file = File::where('fileName', $uploadedFileName)->first();
			if ($file)
			{
				$file->targetID = $documentID;
				$file->valid = 1; // 1 = 유효
				$file->save();
			}
			// 업데이트가 완료된 세션 삭제
			session()->forget('uploadedFileName' . $i);
			
		}
		// 파일 횟수 세션과 파일명 세션 삭제
		session()->forget('uploadedFileCount');
		
		return redirect()->route('board.show', ['id' => $id, 'documentID' => $documentID]); 
 
    }

    public function comment_store(Request $request, $id, $documentID)
    {
		$row = new Comment;
		$this->comment_save($request, $row, $id, $documentID);
		// return redirect()->route('index'); 
		return redirect()->route('board.show', ['id' => $id, 'documentID' => $documentID]);
    }

    public function show($id, $documentID)
    {
		// $document = Document::where('id', '=', $documentID)->first();
		$document = Document::find($documentID);
		$comments = Comment::where('document_id', '=', $documentID)->get();
		$commentCount = DB::table('comments')->where('document_id', $documentID)->count();
		
        return view('board.show', [
			'document' => $document,
			'comments' => $comments,
			'commentCount' => $commentCount
			]);
    }

 
    public function edit($id, $documentID)
    {
		// 수정 권한이 있거나 세션에 'check' 변수가 있는 경우
		if (session()->exists("uid") == "esonagi123" || session()->exists("check"))
		{
			session()->forget('check');
			$board = Board::where('menu_id', '=', $id)->first();
			$document = Document::find($documentID);
			$files = File::where('targetType', 'document')->where('targetID', $documentID)->where('valid', 1)->get();
			
			return view('board.edit', [
				'board' => $board,
				'document' => $document,
				'files' => $files
			]);
		}
		else
		{
			return view('board.check', ['id' => $id, 'documentID' => $documentID]);
			
		}
    }
	
	public function auth(Request $request, $id, $documentID)
	{
        $request->validate( ['pwd' => 'required',], ['pwd.required' => '비밀번호를 입력하세요.',] );
		$inputPassword = $request->input('pwd');
		
		// 입력한 비밀번호와 데이터베이스에 저장된 비밀번호 해시를 비교
		$documentExists = DB::table('documents')->where('id', $documentID)->first();
		$hashedPassword = $documentExists->pwd;
		
		if ($documentExists && Hash::check($inputPassword, $hashedPassword))
		{
			// 인증 성공
			session()->put('check', true);
			
			if (session()->exists("document_destroy")) // document_destroy 세션이 있으면 문서 삭제
			{	
				session()->forget('document_destroy'); // 혹시 모르니 세션 지우기
				return redirect()->route('board.destroy', ['id' => $id, 'documentID' => $documentID]);
			}
			else // document_destroy 세션이 없으면 문서 수정
			{
				return redirect()->route('board.edit', ['id' => $id, 'documentID' => $documentID]);
			}			
		}
		else
		{
			// 인증 실패
			session()->flash('message', '비밀번호가 일치하지 않습니다.');
			if (session()->exists("document_destroy"))
			{
				session()->flash('document_destroy');			
				return view('board.check', ['id' => $id, 'documentID' => $documentID]);
			}
			else
			{
				return view('board.check', ['id' => $id, 'documentID' => $documentID]);
			}
		}
	}

    public function comment_edit($id, $documentID, $commentID)
    {
		// 수정 권한이 있거나 세션에 'check' 변수가 있는 경우
		if (session()->exists("uid") == "esonagi123" || session()->exists("check"))
		{
			// 조건 만족 시 세션을 지우기
			session()->forget('check');
			
			$board = Board::where('menu_id', '=', $id)->first();
			$document = Document::find($documentID);
			$comment = Comment::find($commentID);
			
			return view('board.comment_edit', [
				'board' => $board,
				'document' => $document,
				'comment' => $comment
			]);
		}
		else
		{
			return view('board.comment_check', ['id' => $id, 'documentID' => $documentID, 'commentID' => $commentID]);
		}
    }
	
	public function auth2(Request $request, $id, $documentID, $commentID) // 비회원 댓글 인증
	{
        $request->validate( ['pwd' => 'required'], ['pwd.required' => '비밀번호를 입력하세요.'] );
		$inputPassword = $request->input('pwd');
		
		// 입력한 비밀번호와 데이터베이스에 저장된 비밀번호 해시를 비교
		$documentExists = DB::table('comments')->where('id', $commentID)->first();
		$hashedPassword = $documentExists->pwd;
		
		if ($documentExists && Hash::check($inputPassword, $hashedPassword))
		{
			// 인증 성공
			session()->put('check', true);
			if (session()->exists("comment_destroy"))
			{
				session()->forget('comment_destroy');
				return redirect()->route('board.destroy2', ['id' => $id, 'documentID' => $documentID, 'commentID' => $commentID]);
			}
			else
			{
				return redirect()->route('board.edit2', ['id' => $id, 'documentID' => $documentID, 'commentID' => $commentID]);
			}
		}
		else
		{
			// 인증 실패
			session()->flash('message', '비밀번호가 일치하지 않습니다.');
			if (session()->exists("comment_destroy"))
			{
				session()->flash('comment_destroy');
				return view('board.comment_check', ['id' => $id, 'documentID' => $documentID, 'commentID' => $commentID]);
			}
			else
			{
				return view('board.comment_check', ['id' => $id, 'documentID' => $documentID, 'commentID' => $commentID]);
			}
		}
	}	

    public function update(Request $request, $id, $documentID)
    {
		// Route::post('{id}/{documentID}/update', [BoardCore::class, 'update'])->name('board.update');
		
		$row = Document::find($documentID);

        $request->validate( [

            'title' => 'required',
            'content' => 'required',

        ] ,
            [
                'title.required' => '제목을 입력하세요.',
                'content.required' => '내용을 입력하세요.',
            ] );

        $row->title = $request->input('title');
        $row->content = $request->input('content');
        $row->secret = $request->input('secret');
        $row->save();

		// 세션에서 파일 횟수 및 파일명 불러오기
		$uploadedFileCount = session('uploadedFileCount', 0); // 저장된 파일 횟수

		for ($i = 1; $i <= $uploadedFileCount; $i++)
		{
			$uploadedFileName = session('uploadedFileName' . $i);
			
			// 파일 모델 업데이트
			$file = File::where('fileName', $uploadedFileName)->first();
			if ($file)
			{
				$file->targetID = $documentID;
				$file->valid = 1; // 1 = 유효
				$file->save();
			}
			// 업데이트가 완료된 세션 삭제
			session()->forget('uploadedFileName' . $i);
			
		}
		// 파일 횟수 세션과 파일명 세션 삭제
		session()->forget('uploadedFileCount');

        return redirect()->route('board.show', ['id' => $id, 'documentID' => $documentID]);
	}

    public function comment_update(Request $request, $id, $documentID, $commentID)
    {	
		$row = Comment::find($commentID);

        $request->validate( ['comment' => 'required'] , ['comment.required' => '내용을 입력하세요.'] );

		$row->comment = $request->input('comment');
        $row->save();

        return redirect()->route('board.show', ['id' => $id, 'documentID' => $documentID]);
	}

    public function destroy($id, $documentID) // 게시글 삭제
    {
		// 수정 권한이 있거나 세션에 'check' 변수가 있는 경우
		if (session()->exists("uid") == "esonagi123" || session()->exists("check"))
		{		
			// 조건 만족 시 세션을 지우기
			session()->forget('check');			
			$document = Document::find($documentID);

			if (!$document)
			{
				return redirect()->route('board.show', ['id' => $id, 'documentID' => $documentID])->with('error', '삭제할 항목을 찾을 수 없습니다.');
			}
			
			// 파일 및 파일 데이터베이스 삭제
			$files = File::where('targetType', 'document')->where('targetID', $documentID)->get();
			if ($files)
			{
				foreach ($files as $file) {
					$fileName = $file->fileName;
					
					if ($fileName)
					{
						// 서버에서 파일 삭제 & DB 삭제
						Storage::delete('files/' . $fileName);
					}
					// 데이터베이스 레코드 삭제
					$file->delete();
				}
			}
			
			$document->delete();

			return redirect()->route('board.index', ['id' => $id]);
		}
		else
		{
			// 수정권한이 없거나 'check' 세션 변수가 없을 경우 'document_destroy' 세션 변수와 함께 리턴
			session()->flash('document_destroy');
			return view('board.check', ['id' => $id, 'documentID' => $documentID]);
		}		
    }

    public function destroy2($id, $documentID, $commentID) // 댓글 삭제
    {
		// 수정 권한이 있거나 세션에 'check' 변수가 있는 경우
		if (session()->exists("uid") == "esonagi123" || session()->exists("check"))
		{
			// 조건 만족 시 세션을 지우기
			session()->forget('check');
			
			$comment = Comment::find($commentID);

			if (!$comment)
			{
				return redirect()->route('board.show', ['id' => $id, 'documentID' => $documentID])->with('error', '삭제할 항목을 찾을 수 없습니다.');
			}

			$comment->delete();

			return redirect()->route('board.show', ['id' => $id, 'documentID' => $documentID]);
		}
		else
		{
			// 수정권한이 없거나 'check' 세션 변수가 없을 경우 'comment_destroy' 세션 변수와 함께 리턴
			session()->flash('comment_destroy');
			return view('board.comment_check', ['id' => $id, 'documentID' => $documentID, 'commentID' => $commentID]);
		}		
		
    }
	
	public function save_row(Request $request, $row)
    {
        $request->validate( [

            'title' => 'required',
			'content' => 'required',
			
        ] ,
        [
            'title.required' => '제목을 입력하세요.',
			'content.required' => '내용을 입력하세요.',
        ] );
		
		$serverTime = date('Y-m-d H:i:s'); // 현재 서버 시간
		
		$row->board_id = $request->input('board_id');
		$row->title = $request->input('title');
		$row->content = $request->input('content');
		$row->uid = $request->input('uid');
		$row->name = $request->input('name');
		
		// 비밀번호를 해시화하여 저장
		$hashedPassword = bcrypt($request->input('pwd'));
		$row->pwd = $hashedPassword;
		
		$row->secret = $request->input('secret');
		$row->date = $serverTime;
		$row->count = 0;
		
		$row->save();
		
		
	}
	
	public function comment_save($request, $row, $id, $documentID)
    {
        $request->validate( ['comment' => 'required'], ['comment.required' => '댓글을 입력하세요.',] );
		
		// $serverTime = date('Y-m-d H:i:s'); // 현재 서버 시간
		$serverTime = now(); // 현재 서버 시간
		
		$row->board_id = $id;
		$row->document_id = $documentID;
		$row->comment = $request->input('comment');
		$row->name = $request->input('name');

		// 비밀번호를 해시화하여 저장
		$hashedPassword = bcrypt($request->input('pwd'));
		$row->pwd = $hashedPassword;

		$row->date = $serverTime;
        
		$row->save();
	}
	

	
/* 	public function file_save($request, $type)
	{
		// 유효성 검사 - 파일 타입 및 크기 확인

		$file = $request->file('file');
		$serverTime = now();
		
		$file_name = $file->getClientOriginalName();
		$file_size = $file->getSize(); // 바이트 단위

		// 파일 저장 경로 설정
		$file_path = 'public/files';
		// $file->storeAs('public/files', $file_name);

		$request->file('file')->store('images', 'public');
		
		// 데이터베이스에 파일 정보 저장
		$fileModel = new File();
		$fileModel->targetType = $type;
		// $fileModel->targetID = $targetID;
		$fileModel->menuID = $request->input('board_id');
		$fileModel->memberID = $request->input('name');
		$fileModel->fileName = $file_name;
		$fileModel->fileSize = $file_size;
		$fileModel->src = Storage::url($file_path . '/' . $file_name);
		$fileModel->regDate = $serverTime;
		$fileModel->save();

	} */
	
	public function ajax_upload(Request $request)
	{
		// $file = $request->file('file');

		if ($request->hasFile('file')) {
			// 파일이 유효한 경우
			$file = $request->file('file');
			
			$newFileName = $request->input('newFileName');
			// 파일 저장 경로 설정
			$file_path = 'files';
			$file->storeAs($file_path, $newFileName);

			// 데이터베이스에 파일 정보 저장
			$serverTime = now();
			$fileModel = new File();
			$fileModel->targetType = $request->input('type');
			$fileModel->menuID = $request->input('boardID');
			// $fileModel->memberID = $request->input('name');
			$fileModel->fileName = $newFileName; // 날짜 붙인 파일명
			$fileModel->original_fileName = $request->input('fileName'); // 원본 파일명
			$fileModel->fileSize = $request->input('fileSize');
			$fileModel->src = Storage::url($file_path . '/' . $newFileName);
			$fileModel->regDate = $serverTime;
			$fileModel->valid = 2;
			
			$fileModel->save();
			
			// 세션에 파일명 저장
			$uploadedFileCount = session('uploadedFileCount', 0); // 기존 저장된 파일 횟수를 불러옴
			$uploadedFileCount++; // 새 파일이 업로드되었으므로 횟수를 증가시킴
			session(['uploadedFileCount' => $uploadedFileCount]); // 세션에 새 파일 횟수를 저장
			session(['uploadedFileName' . $uploadedFileCount => $newFileName]); // 세션에 새 파일명을 저장			
			
			// 파일 업로드 성공 시, 이미지 URL 반환
			$src = Storage::url($file_path . '/' . $newFileName);
			$response = [
				'success' => true,
				'imageUrl' => $src, // 이미지 URL
			];
		} else {
			// 파일이 유효하지 않은 경우
			$response = [
				'success' => false,
				'message' => '파일 업로드에 실패했습니다.',
			];
		}

		// JSON 형식으로 응답
		return response()->json($response);
	}
	
	public function ajax_destroy(Request $request)
	{			
		$file = $request->input('newFileName'); // JavaScript에서 전달한 파일 이름
		$fileModel = File::where('fileName', '=', $file)->first(); // 파일 모델에서 해당 파일을 찾음
		
		 if ($fileModel)
		 {
			// DB에서 파일을 찾은 경우 
			$src = $fileModel->src;
			
			// 서버에서 파일 삭제 & DB 삭제
			Storage::delete('files/' . $file);
			// unlink(storage_path('public/files/'.$newFileName));
			
			// 데이터베이스에서 파일 정보 삭제
			$fileModel->delete();
			
			$response = [
				'success' => true,
				'imageUrl' => $src, // 삭제할 이미지 URL
				'message' => '파일 삭제에 성공했습니다.',
			];
		 }
		 else
		 {
			// 파일을 찾지 못한 경우
			$response = [
				'success' => false,
				'message' => '파일을 찾을 수 없습니다.',
			];			 
		 }

		// JSON 형식으로 응답
		return response()->json($response);
	}	
}
