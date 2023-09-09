@extends('base')

@section('content')
<script src="https://cdn.tiny.cloud/1/tjtgh1g19ijslhffx1hwfpcnu729wk7cmytgbnp8nxepksjn/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<main class="container">

  <div class="my-3 p-3 bg-body rounded shadow-sm">
    <div class="d-flex justify-content-between align-items-center mb-3">
		<h6 class="border-bottom pb-2 mb-0">게시글 수정</h6>
		<a class="btn btn-secondary" onclick="history.back()">이전</a>
	</div>
	<form method="post" action="{{ url($document->board_id . '/' . $document->id . '/update') }}">
	@csrf
		<input type="hidden" name="board_id" id="board_id" value="{{ $document->board_id }}">
		<input type="hidden" name="name" value="{{ $document->name }}">
		<input type="hidden" name="pwd" value="{{ $document->pwd }}">
		
		<div class="mb-4">
		  <label for="title" class="form-label">제목</label>
		  <input type="text" class="form-control" id="title" name="title" value="{{ $document->title }}">
		</div>
		<div class="mb-4">
		  <label for="content" class="form-label">내용</label>
		  <textarea class="form-control" id="content" rows="25" name="content">{{ $document->content }}</textarea>
		</div>		
		
		<div class="mb-4">	
			<label for="file" class="form-label">파일 업로드</label>
			<input type="file" class="form-control" onchange="addFile(this);" multiple />
			<div class="file-list"></div>
			<!-- 응답 결과를 표시할 곳 -->
			<div id="imgPreview">
				@if ($files)
					@foreach($files as $file)
						<div id="file{{ $file->id }}" class="mt-2 filebox">
						   <img style="width:100px;" src="{{ $file->src }}">
						   <span class="name">{{ $file->fileName }}</span>
						   <a class="btn btn-danger" onclick="deleteFile( {{ $file->id }}, '{{ $file->fileName }}' );">삭제</a>
						   <a class="btn btn-secondary" onclick="insertImage( '{{ $file->src }}' );">본문삽입 ↑</a>
						</div>
					@endforeach
				@endif
			</div>		
		</div>
		
		<div class="d-flex justify-content-between align-items-center mb-3">
			@if ($board->secret_option == "1")
			<div class="form-check form-switch">
			  <input class="form-check-input" type="checkbox" role="switch" id="secret" disabled>
			  <label class="form-check-label" for="secret">비밀글 (사용 불가)</label>
			</div>
			@elseif ($board->secret_option == "2")
			<div class="form-check form-switch">
			  <input class="form-check-input" type="checkbox" role="switch" id="secret" value="private">
			  <label class="form-check-label" for="secret">비밀글</label>
			</div>
			@elseif ($board->secret_option == "3")
			<div class="form-check form-switch">
			  <input class="form-check-input" type="checkbox" role="switch" id="secret" value="private" checked disabled>
			  <label class="form-check-label" for="secret">비밀글</label>
			</div>
			@endif
			<h6 class="border-bottom pb-2 mb-0"></h6>
			<button class="btn btn-primary" type="submit">완료</button>
		</div>
		</div>
	</form>
 
</main>

<script>
	function generateUniqueFileName(fileName) {
		var timestamp = new Date().getTime(); // 현재 시간을 밀리초로 얻기
		var uniqueFileName = timestamp + '_' + fileName;
		return uniqueFileName;
	}

	var csrfToken = $('meta[name="csrf-token"]').attr('content');
	var selFile = document.querySelector("input[type=file]");
	
	var boardID = document.getElementById('board_id').value;
	var type = "document";

	var fileNo = 0;
	var filesArr = new Array();

	/* 첨부파일 추가 */
	function addFile(obj) {
		var maxFileCnt = 5;   // 첨부파일 최대 개수
		var attFileCnt = document.querySelectorAll('.filebox').length;    // 기존 추가된 첨부파일 개수
		var remainFileCnt = maxFileCnt - attFileCnt;    // 추가로 첨부가능한 개수
		var curFileCnt = obj.files.length;  // 현재 선택된 첨부파일 개수

		// 첨부파일 개수 확인
		if (curFileCnt > remainFileCnt) {
			alert("첨부파일은 최대 " + maxFileCnt + "개 까지 첨부 가능합니다.");
		} else {
			for (const file of obj.files) {
				var formData = new FormData();
				var fileName = file.name;
				var uniqueFileName = generateUniqueFileName(fileName);
				var fileSize = file.size;
				
				// 파일 객체를 FormData에 추가
				formData.append('file', file);

				// 파일 이름과 파일 크기도 FormData에 추가
				formData.append('fileName', fileName);
				formData.append('newFileName', uniqueFileName); // 파일명에 시간 붙이기
				formData.append('fileSize', fileSize);
				formData.append('boardID', boardID);
				formData.append('type', type);
				
				// 첨부파일 검증
				if (validation(file)) {
					// 파일 배열에 담기
					var reader = new FileReader();
					reader.onload = function () {
						filesArr.push(file);
					};
					reader.readAsDataURL(file);

					$.ajax({
						headers: {'X-CSRF-TOKEN': csrfToken},
						url: "{{ url('upload') }}", // AjaxController -> index 함수 실행
						type: "POST",
						data: formData, // $file = $request->file('file');
						//data:{fileName : fileName, fileSize : fileSize}, // ex) $request->input('id') == var movieID
						dataType: "json",
						contentType: false, // 파일 업로드 시 false로 설정. contentType: false 옵션을 사용하여 jQuery가 content-type을 자동으로 설정하지 않도록 해야 합니다.
						processData: false, // FormData 사용 시 false. 데이터를 문자열로 변환하지 않는다.	
						success: function(data) // data == $response
						{
							// 파일 업로드 성공 시, 에디터에 이미지 추가
							var imageUrl = data.imageUrl; // 이미지 URL
		
							// 에디터에 이미지 추가
							tinymce.activeEditor.execCommand('mceInsertContent', false, '<img src="' + imageUrl + '">');	
						
							$(".file-list").append(
								'<div id="file' + fileNo + '" class="mt-2 filebox">' +
								'   <img style="width:100px;" src="' + imageUrl + '">' +
								'   <span class="name">' + file.name + '</span>' +
								'   <a class="btn btn-danger" onclick="deleteFile(' + fileNo + ', \'' + uniqueFileName + '\');">삭제</a>' +
								'   <a class="btn btn-secondary" onclick="insertImage(' + imageUrl + ');">본문삽입 ↑</a>' +
								'</div>'
							);
							fileNo++;
							console.log(uniqueFileName);
						},
						error: function() {
							alert('파일 업로드에 실패했습니다.');
						}
					});

					// 목록 추가
/* 					let htmlData = '';
					htmlData += '<div id="file' + fileNo + '" class="filebox">';
					htmlData += '   <p class="name">' + file.name + '</p>';
					htmlData += '   <a class="delete" onclick="deleteFile(' + fileNo + ');"><i class="far fa-minus-square"></i></a>';
					htmlData += '</div>';
					$('.file-list').append(htmlData);
					fileNo++; */
				} else {
					continue;
				}
			}
		}
		// 초기화
		document.querySelector("input[type=file]").value = "";
	}

	/* 첨부파일 검증 */
	function validation(obj) {
		const fileTypes = ['application/pdf', 'image/gif', 'image/jpeg', 'image/png', 'image/bmp', 'image/tif', 'application/haansofthwp', 'application/x-hwp'];
		if (obj.name.length > 100) {
			alert("파일명이 100자 이상인 파일은 제외되었습니다.");
			return false;
		} else if (obj.size > (100 * 1024 * 1024)) {
			alert("최대 파일 용량인 100MB를 초과한 파일은 제외되었습니다.");
			return false;
		} else if (obj.name.lastIndexOf('.') == -1) {
			alert("확장자가 없는 파일은 제외되었습니다.");
			return false;
		} else if (!fileTypes.includes(obj.type)) {
			alert("첨부가 불가능한 파일은 제외되었습니다.");
			return false;
		} else {
			return true;
		}
	}

	/* 첨부파일 삭제 */
	function deleteFile(num, uniqueFileName) {
		var isConfirmed = confirm('파일이 완전 삭제됩니다.\n정말 삭제 하시겠습니까?');
		if (isConfirmed) {
			$.ajax({
				headers: {'X-CSRF-TOKEN': csrfToken},
				url: "{{ url('ajaxDestroy') }}", // AjaxController -> index 함수 실행
				type: "POST",
				data: { "newFileName" : uniqueFileName },
				dataType: "json",			
				success: function(data) // data == $response
				{
					// 파일 삭제 성공 시, 에디터 본문에서 해당 이미지를 삭제
					if (data.success) {
						var imageUrl = data.imageUrl; // 삭제된 이미지의 URL
						var editorContent = tinymce.activeEditor.getContent(); // 에디터 본문 내용 가져오기
						
						// 에디터 본문에서 삭제할 이미지를 검색하여 삭제
						var updatedContent = editorContent.replace('<img src="' + imageUrl + '">', '');

						// 에디터 본문 업데이트
						tinymce.activeEditor.setContent(updatedContent);
						
						// 리스트 삭제
						document.querySelector("#file" + num).remove();
						filesArr[num].is_delete = true;
						
						alert('파일을 삭제했습니다.');
					} else {
						alert('뭔가 이상해!!!');
					}
				},
				error: function() {
					alert('삭제 실패');
				}
			});
		} else {
			alert('파일 삭제를 취소했습니다.');
		}
	}
	
	function insertImage(imageUrl) {
		tinymce.activeEditor.execCommand('mceInsertContent', false, '<img src="' + imageUrl + '">');	
	}
	
	// TinyMCE ↓
    tinymce.init({
      selector: 'textarea',
      plugins: 'ai tinycomments mentions anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed permanentpen footnotes advtemplate advtable advcode editimage tableofcontents mergetags powerpaste tinymcespellchecker autocorrect a11ychecker typography inlinecss',
      toolbar: 'undo redo | fontsize | bold italic underline strikethrough | link image media table mergetags | align lineheight | tinycomments | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
      tinycomments_mode: 'embedded',
      tinycomments_author: 'Author name',
	  relative_urls: false,
	  remove_script_host: false,
      mergetags_list: [
        { value: 'First.Name', title: 'First Name' },
        { value: 'Email', title: 'Email' },
      ],
      ai_request: (request, respondWith) => respondWith.string(() => Promise.reject("See docs to implement AI Assistant")), 
	});
	// TinyMCE ↑
	
</script>

@endsection()

