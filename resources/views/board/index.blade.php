@extends('base')

@section('content')

<main class="container">
@foreach ($boardInfo as $info)
	<div style="background-color:#8932a3;" class="d-flex align-items-center p-3 my-3 text-white rounded shadow-sm">
		<div class="lh-1 flex-grow-1">
			<h1 class="h4 mb-0 text-white lh-1">{{ $info->board_name }}</h1>
		</div>
		<div class="lh-1">
			<a class="btn btn-light" href="{{ url($info->menu_id . '/write') }}">글쓰기</a>
		</div>
	</div>

  
  <div class="my-3 p-3 bg-body rounded shadow-sm">
    <div class="d-flex justify-content-between align-items-center mb-3">
	
      <h6 class="border-bottom pb-2 mb-0"><i class="fas fa-bullhorn"></i>&nbsp; {{ $info->message }}</h6>

      <!--<a class="btn btn-primary" href="#">버튼</a>-->
    </div>
@endforeach
	

	
    @foreach ($documentsWithCommentCounts as $item)
      <div class="d-flex text-body-secondary pt-3">
        <div class="pb-3 mb-0 small lh-sm border-bottom w-100">
          <div class="d-flex justify-content-between">
			<a href="{{ url($item['boardInfo2']->menu_id . '/' . $item['document']->id) }}">
            <strong class="text-gray-dark">{{ $item['document']->title }}</strong>
			</a>
            <a href="#">댓글 수 : {{ $item['commentCount'] }}</a>
          </div>
          <span>{{ $item['document']->name }}</span> | 
		  <span>{{ date('Y-m-d h:i', strtotime($item['document']->date)) }}</span> |
		  <span>조회 수 : {{ $item['document']->count }}</span>
        </div>
      </div>
    @endforeach
        <nav aria-label="Page navigation example">
            <ul class="mt-4 pagination justify-content-center">
                <li class="page-item">
                    <a class="page-link" href="{{ $page->previousPageUrl() }}" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                @for ($i = 1; $i <= $page->lastPage(); $i++)
                    <li class="page-item {{ $i == $page->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $page->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor
                <li class="page-item">
                    <a class="page-link" href="{{ $page->nextPageUrl() }}" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
  </div>
  
</main>
@endsection

