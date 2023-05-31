<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>
</head>
<body>
    @if(count($errors) > 0)
    @foreach ($errors->all() as $error)
        <div>{{$error}}</div>
    @endforeach
@endif

    <form action="{{route('boards.update',['board' => $data->id])}}" method="post">
        @csrf
        {{-- 내부에서 put으로 셋팅해야 post나 get을 통해서 보내줄수 있다.  --}}
        @method('put')  
        <label for="title">제목 : </label>
        <input type="text" name="title" id="title" value= "{{old('title') !== null ? old('title') : $data->title}}"> 
        {{-- 삼항 같은 방식 : count($errors) >0 이 부분을 old{{'title'}} !== null 대신 입력 해도 된다. --}}
        <br>
        <label for="content">내용 : </label>
        <textarea name="content" id="content" placeholder = "여다쓰지?">{{old('content') !== null ? old('content') : $data->content}}</textarea>
         {{-- 삼항 같은 방식 : count($errors) >0 이 부분을 old{{'content'}} !== null 대신 입력 해도 된다. --}}
        <br>
        <button type = "submit">수정</button>
        <button type = "button" onclick="location.href='{{Route('boards.show', ['board' => $data->id])}}'">취소</button>
    </form>
    
</body>
</html>