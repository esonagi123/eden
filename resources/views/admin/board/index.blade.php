@extends('admin/base')
﻿
@section('content')
<!-- admin\board\index.blade.php -->
<main class="content">
	<div class="row">
		<div class="card-body d-flex justify-content-between align-items-center">
			<h1 class="h3 mb-3 col-11">게시판 목록</h1>
			<a class="" href="{{ route('admin.board.create') }}">추가</a>
		</div>
	</div>
	
	<!-- 리스트 -->
	<div class="col-12">
		<div class="row">
			@foreach ($rows as $row)
				<div class="col-12 col-md-6 mb-3">
					<div class="card">
						<div class="card-body">
							@if ($row->secret == "public")
								<span class="badge text-bg-success">공개</span>
							@else
								<span class="badge text-bg-secondary">비공개</span>
							@endif
							<p style="margin-top: 10px; font-size: 20px;" class="card-title mb-0">{{ $row->board_name }}</p>
							<br>
							<div class="d-flex justify-content-end align-items-center">
								<a href="#" class="btn btn-secondary">이동</a>&nbsp;
								<a href="{{ url('admin/board/edit/' . $row->id) }}" class="btn btn-primary">수정</a>&nbsp;
								<a href="{{ url('admin/board/destroy/' . $row->id) }}" class="btn btn-danger" onclick="return confirm('정말로 삭제하시겠습니까?')">삭제</a>
							</div>
						</div>
					</div>
				</div>
			@endforeach
		</div>
	</div>

</main>
@endsection()
