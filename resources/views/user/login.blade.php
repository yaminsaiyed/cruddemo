@extends('layouts.admin_login')

@section('content')
<div class="login-box">
    <!-- /.login-logo -->
    <div class="login-box-body">
        <div class="login-logo">
            <a href="javascript:;">
                <img src="<?php echo \AppHelper::getAdminSettingImage("company_logo"); ?>">
            </a>
        </div>

        @include('flash_messages.admin_message')

        {!! Form::open(['method'=>'POST','route'=>['admin.login_submit']]) !!}
        <div class="form-group has-feedback">
            <label>Username / Email Address</label>
            {!! Form::text('email',null,['class'=>'form-control','placeholder'=>'Username/Email Address'])!!}
            <small class="text-danger">{{ $errors->first('email') }}</small>
        </div>

        <div class="form-group has-feedback">
            <label>Password</label>
            {!! Form::password('password',['class'=>'form-control','placeholder'=>'Password'])!!}
            <small class="text-danger">{{ $errors->first('password') }}</small>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <button type="submit" class="btn btn-success btn-block">Sign In</button>
                <a href="{{ route('admin.forgot_password') }}" class="btn btn-default btn-block">I forgot my password</a>
            </div>
        </div>

        {!! Form::close() !!}
        <!-- /.social-auth-links -->
    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

@endsection