@extends('layouts.admin_main')

@section('content')

<section class="content-header">
    <h1>
        User Profile
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">User profile</li>
    </ol>
</section>

<section class="content">
    @include('flash_messages.admin_message')

    <div class="row">
        <div class="col-md-3 mb_30">
            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <div class="profile-user-img img-circle">
                        <img class="img-responsive" src="{{ \AppHelper::getImage(Auth::user()->image) }}" alt="User profile picture">
                    </div>
                    <h3 class="profile-username text-center"><?php echo Auth::user()->firstname . " " . Auth::user()->lastname; ?></h3>
                    <p class="text-muted text-center">Admin</p>
                    <a href="{{ route('admin.logout') }}" class="btn btn-primary btn-block"><b>Logout</b></a>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

            <!-- About Me Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Last Login Details</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body login_details">
                    <strong><i class="fa fa-fw fa-clock-o margin-r-5"></i>Date & Time</strong>
                    <p class="text-muted">{{ \AppHelper::getDateTimeFormat(isset($last_login->created_at)?$last_login->created_at:"") }}</p>
                    <hr>
                    <strong><i class="fa fa-map-marker margin-r-5"></i>Location</strong>
                    <p class="text-muted">{{ isset($last_login->last_login_location)?$last_login->last_login_location:"" }}</p>
                    <hr>
                    <strong><i class="fa fa-map-marker margin-r-5"></i>IP Address</strong>
                    <p class="text-muted">{{ isset($last_login->last_login_ip)?$last_login->last_login_ip:"" }}</p>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->

        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    {{-- <li class="active"><a href="#profile" data-toggle="tab">Profile</a></li>
                    <li><a href="#activity" data-toggle="tab">Login Activity</a></li>
                    <li><a href="#timeline" data-toggle="tab">Timeline</a></li> --}}
                </ul>
                <div class="tab-content">
                    <div class="tab-pane" id="timeline">
                    </div>
                    <!-- /.tab-pane -->

                    <div class="active tab-pane" id="profile">
                        {!! Form::open(['method'=>'POST','route'=>['profile_submit'],'class'=>'form-data','files' => true,'role'=>'form']) !!}
                        <div class="box-body">
                            <h3 class="box-title">Profile</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>First Name <span class="text-danger">*</span></label>
                                        {!! Form::text('firstname',$user['firstname'],['class'=>'form-control','placeholder'=>'First Name'])!!}
                                        <small class="text-danger">{{ $errors->first('firstname') }}</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Last Name <span class="text-danger">*</span></label>
                                        {!! Form::text('lastname',$user['lastname'],['class'=>'form-control','placeholder'=>'Last Name'])!!}
                                        <small class="text-danger">{{ $errors->first('lastname') }}</small>
                                    </div>
                                </div>
                                <div class="clearfix"></div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email <span class="text-danger">*</span></label>
                                        {!! Form::text('email',$user['email'],['class'=>'form-control','placeholder'=>'Email Address'])!!}
                                        <small class="text-danger">{{ $errors->first('email') }}</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Mobile <span class="text-danger">*</span></label>
                                        {!! Form::text('mobile',$user['mobile'],['class'=>'form-control','placeholder'=>'Mobile Number'])!!}
                                        <small class="text-danger">{{ $errors->first('mobile') }}</small>
                                    </div>
                                </div>
                                <div class="clearfix"></div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Password</label>
                                        {!! Form::password('password',['class'=>'form-control','placeholder'=>'Leave Blank If You Dont Want To Change'])!!}
                                        <small class="text-danger">{{ $errors->first('password') }}</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        {!! Form::password('confirm_password',['class'=>'form-control','placeholder'=>'Leave Blank If You Dont Want To Change'])!!}
                                        <small class="text-danger">{{ $errors->first('confirm_password') }}</small>
                                    </div>
                                </div>
                                <div class="clearfix"></div>

                                <div class="col-md-7">
                                    <label>Profile</label>
                                    <table class="table image-table mb_0">
                                        <tr>
                                            <td style="vertical-align: middle;text-align: left;">
                                                <div class="profile-user-img">
                                                    <img class="watter_image" src="{{ \AppHelper::getImage(Auth::user()->image) }}" alt="User profile picture">
                                                </div>
                                                <div class="clearfix"></div>
                                                <small class="text-danger file_error"></small>
                                                <div class="clearfix"></div>
                                                <div class="progress" style="display: none;">
                                                    <div class="progress-bar progress-bar-green" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="vertical-align: middle;text-align: left;">
                                                <span class="btn btn-default btn-file">
                                                    Choose File <input name="_profile" type="file" class="inputFileUpload" save_folder="profile" input_file_key="_profile" />
                                                </span>
                                                <button type="button" class="btn btn-danger remove_image" <?php
                                                                                                            if (empty($user['image'])) {
                                                                                                                echo 'style="display: none;"';
                                                                                                            }
                                                                                                            ?>>Remove</button>
                                                {!! Form::hidden('image',!empty($user['image'])?$user['image']:"",['class'=>'hidden_filename'])!!}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-5"></div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                        <!-- /.box-body -->


                        {!! Form::close() !!}
                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane" id="activity">
                        <div class="box-body">
                            <table class="table table-striped table-dark">
                                <tr>
                                    <th class="text-left">Location</th>
                                    <th class="text-left">Ip Address</th>
                                    <th class="text-left">Date & Time</th>
                                </tr>
                                @foreach($login_history as $login_history_value)
                                <tr>
                                    <td class="text-left">{{ $login_history_value['last_login_location'] }}</td>
                                    <td class="text-left">
                                        <span class="badge bg-green">{{$login_history_value['last_login_ip']}}</span>
                                    </td>
                                    <td class="text-left">{{ \AppHelper::getDateTimeFormat($login_history_value['created_at']) }}</td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->

@include('admin_elements.upload_elements.single_image')
@endsection