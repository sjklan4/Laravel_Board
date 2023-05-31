<h2>header</h2>

{{-- 로그인 된 유저가 있을때 실행되는 구문 --}}
@auth  
    <div><a href="{{route('users.logout')}}">로그아웃</a></div>
    <div><a href="{{route('users.withdraw')}}">탈퇴</a></div>
    <div><a href="{{route('users.userinfo')}}">회원정보</a></div>

@endauth
{{-- 비로그인 상태 --}}
@guest
<div><a href="{{route('users.login')}}">로그인</a></div>
@endguest
<hr>