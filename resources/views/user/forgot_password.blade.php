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

        {!! Form::open(['method'=>'POST','route'=>['admin.forgot_password']]) !!}

        <div class="form-group has-feedback">
            <label>Email Address</label>
            {!! Form::text('email',null,['class'=>'form-control','placeholder'=>'Email Address'])!!}
            <small class="text-danger">{{ $errors->first('email') }}</small>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <button type="submit" class="btn btn-success btn-block">Submit</button>
                <a href="{{ route('admin.login') }}" class="btn btn-default btn-block">Back to Login</a>
            </div>
        </div>

        {!! Form::close() !!}
    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

@endsection