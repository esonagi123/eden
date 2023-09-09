@extends('base')

@section('content')
<main class="container">

  <div class="my-3 p-3 bg-body rounded shadow-sm">
			<div class="post comment-form">
			  <h5 class="mb-3">댓글 작성</h5>
			  <form method="post" action="{{ url($document->board_id . '/' . $document->id . '/' . $comment->id . '/update') }}">
				@csrf
				<textarea class="form-control" rows="3" name="comment">{{ $comment->comment }}</textarea>
				<button type="submit" class="btn btn-primary mt-2">댓글 등록</button>
			  </form>
			</div>
	</div>
</main>


@endsection()

