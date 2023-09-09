@extends('base')
﻿
@section('content')
  <style>
    .container {
      
    }
    .post {
      background-color: white;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
      margin-bottom: 20px;
    }
    .post-title {
      font-size: 24px;
      margin-bottom: 5px;
      color: #333;
    }
    .post-meta {
      color: #6c757d;
      font-size: 14px;
      margin-bottom: 15px;
    }
    .post-content {
      font-size: 16px;
      line-height: 1.6;
      color: #555;
    }
    .action-btns {
      display: flex;
      justify-content: space-between;
      margin-top: 20px;
    }
    .action-btns button {
      padding: 10px 20px;
      border-radius: 5px;
    }
    .comment-list {
      list-style: none;
      padding: 0;
      margin-top: 20px;
    }
    .comment-list li {
      border-bottom: 1px solid #dee2e6;
      padding: 10px 0;
    }
    .comment-actions {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: 10px;
    }
    .comment-actions button {
      background: none;
      border: none;
      font-size: 14px;
      cursor: pointer;
      color: #999;
      transition: color 0.2s;
    }
    .comment-actions button:hover {
      color: #333;
    }
    .comment-form {
      margin-top: 20px;
    }
    .comment-form textarea {
      width: 100%;
      resize: vertical;
      border-radius: 5px;
      padding: 10px;
      border: 1px solid #ccc;
    }
    .comment-form button {
      margin-top: 10px;
    }
  </style>
  
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="post">
          <h3 class="post-title">{{ $document->title }}</h3>
          <p class="post-meta">{{ $document->name }} | {{ date('Y-m-d h:i', strtotime($document->date)) }} | 조회수: {{ $document->count }}</p>
          <p class="post-content mt-5 mb-5">{!! $document->content !!}</p>
		  <br>
          <div class="btn-group">
			<a class="btn btn-primary" href="{{ url($document->board_id . '/' . $document->id . '/edit') }}">내용 수정</a>
            <a class="btn btn-danger" href="{{ url($document->board_id . '/' . $document->id . '/destroy') }}" onclick="return confirm('정말로 삭제하시겠습니까?')">내용 삭제</a>
          </div>
        </div>
		
		@if (!$commentCount)
			<div class="post comment-form">
			  <h5 class="mb-3">댓글 작성</h5>
			  <form method="post" action="{{ url($document->board_id . '/' . $document->id . '/newComment') }}">
				@csrf
				<textarea class="form-control" rows="3" name="comment"></textarea>
				<div class="mt-4 mb-4 row">
				  <div class="col-md-6 mb-3">
					<label for="name" class="form-label">글쓴이</label>
					<input type="text" class="form-control" id="name" name="name" placeholder="">
				  </div>
				  <div class="col-md-6">
					<label for="password" class="form-label">비밀번호</label>
					<input type="password" class="form-control" id="password" name="pwd" placeholder="">
				  </div>
				</div>
				<button type="submit" class="btn btn-primary mt-2">댓글 등록</button>
			  </form>
			</div>
		@else
			<div class="post">
			  <h5>댓글</h5>
			  <ul class="comment-list">
				@foreach ($comments as $item)
				  <li>
					<div class="">
						<span class="comment-content">{{ $item->name }}</span>|
						<span class="">{{ $item->date }}</span>
					</div>
					<div class="comment-text">
					  <span class="comment-content">{{ $item->comment }}</span>
					  <input type="text" class="comment-edit-input" style="display:none;">
					</div>
					<div class="comment-actions">
					  <a id="edit-comment" href="{{ url($item->board_id . '/' . $item->document_id . '/' . $item->id . '/edit') }}">수정</a>
					  <a class="delete-comment" href="{{ url($item->board_id . '/' . $item->document_id . '/' . $item->id . '/destroy') }}" onclick="return confirm('정말로 삭제하시겠습니까?')">삭제</a>
					</div>
				  </li>
				@endforeach
			  </ul>
			</div>

			<div class="post comment-form">
			  <h5 class="mb-3">댓글 작성</h5>
			  <form method="post" action="{{ url($document->board_id . '/' . $document->id . '/newComment') }}">
				@csrf
				<textarea class="form-control" rows="3" name="comment"></textarea>
				<div class="mt-4 mb-4 row">
				  <div class="col-md-6 mb-3">
					<label for="name" class="form-label">글쓴이</label>
					<input type="text" class="form-control" id="name" name="name" placeholder="">
				  </div>
				  <div class="col-md-6">
					<label for="password" class="form-label">비밀번호</label>
					<input type="password" class="form-control" id="password" name="pwd" placeholder="">
				  </div>
				</div>
				<button type="submit" class="btn btn-primary mt-2">댓글 등록</button>
			  </form>
			</div>
		@endif
		
        <div class="post">
          <a href="{{ url($document->board_id) }}" class="btn btn-secondary">목록으로 돌아가기</a>
        </div>
      </div>
    </div>
  </div>


@endsection