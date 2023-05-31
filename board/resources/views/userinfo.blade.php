<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>userinfo</title>
</head>
<body>
    <div>
        userNo : {{$data->id}}
        <br>
        Email : {{$data->email}}
        <br>
        Name : {{$data->name}}
        <br>
    </div>
    <br>
    <div><a href="{{route('users.useredit')}}">회원정보변경</a></div>

</body>
</html>