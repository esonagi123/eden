@extends('base')

@section('content')

<main class="mt-5 container">
	<form method="post" action="{{ url($id . '/' . $documentID . '/' . $commentID . '/auth2') }}">
	@csrf
		<input type="hidden" name="board_id" value="">
		<h1 class="h3 mb-3 fw-normal">비밀번호를 입력하세요.</h1>

		<!-- 유효성 검사 오류 메시지 -->
		@error('pwd')
		<div class="mb-3 alert alert-danger">{{ $message }}</div>
		@enderror
		
		@if(session()->has('message'))
			<div class="alert alert-warning">
				{{ session('message') }}
			</div>
		@endif
		<div class="form-floating">
		  <input type="password" class="form-control" id="floatingPassword" placeholder="비밀번호" name="pwd">
		  <label for="floatingPassword">비밀번호</label>
		</div>



		<button id="submit" class="mt-4 btn btn-primary w-100 py-2" type="submit">확인</button>
	</form>
 
</main>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // 확인 버튼 클릭 시
    document.getElementById('submit').addEventListener('click', function () {
      var passwordInput = document.getElementById('floatingPassword');
      var passwordValue = passwordInput.value.trim(); // 입력 값에서 공백 제거

      if (passwordValue === '') {
        // 비밀번호 입력값이 비어있는 경우
        alert('비밀번호를 입력하세요.');
		event.preventDefault(); // 폼 제출 방지
      } else {
        // 비밀번호가 비어있지 않은 경우, 여기에 원하는 로직 추가
        // 예: 폼 제출
      }
    });
  });
</script>
@endsection()