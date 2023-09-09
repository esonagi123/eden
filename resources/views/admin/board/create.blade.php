@extends('admin/base')
﻿
@section('content')
<!-- admin\board\create.blade.php -->
<main class="content">
    <div class="container-fluid p-0">

	<div class="row">
		<div class="card-body d-flex justify-content-between align-items-center">
			<h1 class="h3 mb-3 col-11">게시판 추가</h1>
			<a class="" href="{{ route('admin.board.index') }}">이전</a>
		</div>
	</div>
		
	<div class="col-12 col-lg-12">
	<form method="get" action="{{ url('admin/board/store') }}">
		<div class="card">
			<div class="card-header">
				<h5 class="card-title mb-0">* 게시판 이름</h5>
			</div>
			<div class="card-body">
				<input type="text" class="form-control" name="board_name" placeholder="">
			</div>
		</div>

		<div class="card">
			<div class="card-header">
				<h5 class="card-title mb-0">* 메뉴 ID</h5>
			</div>
			<div class="card-body">
				<input type="text" class="form-control" name="menu_id" placeholder="게시판 URL로 사용됩니다.">
			</div>
		</div>

		<div class="card">
			<div class="card-header">
				<h5 class="card-title mb-0">안내메시지</h5>
			</div>
			<div class="card-body">
				<input type="text" class="form-control" name="message" placeholder="간단한 한 줄 공지사항을 작성할 수 있습니다.">
			</div>
		</div>

		<div class="card">
			<div class="card-header">
				<h5 class="card-title mb-0">* 비밀글 옵션</h5>
			</div>
			<div class="card-body">
				<div>
					<label class="form-check">
						<input class="form-check-input" type="radio" value="1" name="secret_option" checked="">
						<span class="form-check-label">
							사용 안함
						</span>
					</label>
					<label class="form-check"> 	
						<input class="form-check-input" type="radio" value="2" name="secret_option">
						<span class="form-check-label">
							비밀글 가능
						</span>
					</label>
					<label class="form-check"> 	
						<input class="form-check-input" type="radio" value="3" name="secret_option">
						<span class="form-check-label">
							비밀글 해제 불가
						</span>
					</label>					
				</div>
			</div>
		</div>

		<div class="card">
			<div class="card-header">
				<h5 class="card-title mb-0">* 접근 권한</h5>
			</div>
			<div class="card-body">
				<div>
					<label class="form-check">
						<input class="form-check-input" type="radio" value="public" name="secret" checked="">
						<span class="form-check-label">
							공개
						</span>
					</label>
					<label class="form-check"> 	
						<input class="form-check-input" type="radio" value="private" name="secret">
						<span class="form-check-label">
							비공개
						</span>
					</label>
				</div>
			</div>
		</div>
		<div class="d-flex justify-content-end">
			<button class="btn btn-primary" type="submit">저장</button>
		</div>
	</form>
	</div>
    </div>
</main>
@endsection()
