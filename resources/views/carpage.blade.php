<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
</head>

<body data-spy="scroll" data-offset="0" data-target="#navigation">
<form action="{{ url('api/postCarUrl') }}" method="post">
   编号：<input type="text"  name="number" />
    验证码：<input type="text" name="code" />
    <input type="hidden" name="time" value="{{$data['time']}}" />
    <input type="hidden" name="file" value="{{$data['file']}}" />
    <img src="{{ $data['img'] }}" />
    <input type="submit" value="提交"/>
</form>
</body>
</html>
