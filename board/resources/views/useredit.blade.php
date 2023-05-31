<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="{{route('users.usereditpost')}}" method="post">
        @csrf
        @method('put')
        <label for="email">Email : </label>
        <input type="text" name="email" id="email" value= "{{old('email') !== null ? old('email') : $data->email}}" readonly>
        <br>
        <label for="bpassword">현재비밀번호 : </label>
        <input type="password" name="bpassword" id="bpassword">
        <br>
        <label for="password">변경 비밀번호 : </label>
        <input type="password" name="password" id="password">
        <br>
        <label for="passwordchk">변경 비밀번호확인 : </label>
        <input type="password" name="passwordchk" id="passwordchk">
        <br>
        <label for="name">name : </label>
        <input type="text" name="name" id="name"value= "{{old('name') !== null ? old('name') : $data->name}}">
        <br>
        <button type = "submit">변경</button>
    </form>
    

</body>
</html>