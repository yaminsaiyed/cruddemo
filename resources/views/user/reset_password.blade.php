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

        {!! Form::open(['method'=>'POST','route'=>['admin.reset_password',$reset_token_hash]]) !!}

        <div class="form-group has-feedback">
            <label>Password</label>
            {!! Form::password('password',['class'=>'form-control','placeholder'=>'Please enter password'])!!}
            <small class="text-danger">{{ $errors->first('password') }}</small>
        </div>

        <div class="form-group has-feedback">
            <label>Confirm Password</label>
            {!! Form::password('confirm_password',['class'=>'form-control','placeholder'=>'Please enter confirm password'])!!}
            <small class="text-danger">{{ $errors->first('confirm_password') }}</small>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <button type="submit" class="btn btn-success btn-block">Submit</button>
                <a href="{{ route('admin.login') }}" class="btn btn-primary btn-block">Back to Login</a>
            </div>
        </div>

        {!! Form::close() !!}
    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

@endsection