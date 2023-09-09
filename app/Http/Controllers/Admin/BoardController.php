<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Board;

class BoardController extends Controller
{

    public function index()
    {
        $rows = Board::all();
		// $row = DB::table('boards')->get();
		return view('admin.board.index', ['rows' => $rows]);
    }


    public function create()
    {
        return view('admin.board.create');
    }

    public function store(Request $request)
    {
		
		$row = new Board;
		$this->save_row($request, $row);
		return redirect()->route('admin.board.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $rows = Board::find($id);
		return view('admin.board.edit', ['rows' => $rows]);
    }

    public function update(Request $request)
    {
		$id = $request->id;
		$model = Board::find($id);
		$this->save_row($request, $model);
		return redirect()->route('admin.board.edit', ['id' => $id])->with('update_success', '수정 완료');
    }

    public function destroy($id)
    {
		$item = Board::find($id); // Item 모델로부터 해당 ID의 데이터를 찾습니다.

		if (!$item) {
			return redirect()->route('admin.board.index')->with('error', '삭제할 항목을 찾을 수 없습니다.');
		}

		$item->delete(); // 데이터를 삭제합니다.

		return redirect()->route('admin.board.index')->with('success', '항목이 성공적으로 삭제되었습니다.');
    }
	
	public function save_row(Request $request, $row)
    {
        $request->validate( [

            'board_name' => 'required'
			
        ] ,
        [
            'board_name.required' => '게시판 이름을 입력하세요.',
        ] );
		
		$row->board_name = $request->input('board_name');
		$row->menu_id = $request->input('menu_id');
		$row->message = $request->input('message');
		$row->secret_option = $request->input('secret_option');
		$row->secret = $request->input('secret');
		
        $row->save();
	}	
}
