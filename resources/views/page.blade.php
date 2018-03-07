<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
</head>

<body data-spy="scroll" data-offset="0" data-target="#navigation">
<form action="{{ url('api/postUrl') }}" method="post">
    证件：<input type="text"  name="card" />
    手机：<input type="text" name="mobile" />
    FILE：<input type="text" name="file" value="{{ $data['file'] }}"  disabled/>
    验证码：<input type="text" name="code" />
    <img src="{{ $data['img'] }}" />
    <input type="submit" value="提交"/>
</form>
</body>
</html>
