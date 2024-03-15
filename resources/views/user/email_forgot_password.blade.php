<!DOCTYPE html>
<html>
<head>
	<title>Reset Password</title>
</head>
<body>
<p>Hello {!! $data['name'] !!}</p>
Please <a href="{!! route('admin.reset_password',$data['reset_token_hash']) !!}"> Click here </a> to reset your password
</body>
</html>