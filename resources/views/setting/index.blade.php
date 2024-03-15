@extends('layouts.admin_main')

@section('content')

<section class="content-header">
    <h1>
        Setting
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Setting</li>
    </ol>
</section>

<section class="content">
    @include('flash_messages.admin_message')
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#basic" data-toggle="tab">Basic</a></li>
                    <li><a href="#images" data-toggle="tab">Images</a></li>
                    {{-- <li><a href="#timeline" data-toggle="tab">Timeline</a></li> --}}
                </ul>

                {!! Form::open(['method'=>'POST','route'=>['setting_submit'],'class'=>'form-data','files' => true,'role'=>'form']) !!}
                <div class="tab-content">
                    <div class="tab-pane" id="timeline">
                    </div>
                    <!-- /.tab-pane -->

                    <div class="active tab-pane" id="basic">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Company Name <span class="text-danger">*</span></label>
                                        {!! Form::text('company_name',$result['company_name'],['class'=>'form-control','placeholder'=>'Company Name'])!!}
                                        <small class="text-danger">{{ $errors->first('company_name') }}</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Comapny Phone No. <span class="text-danger">*</span></label>
                                        {!! Form::text('company_phone',$result['company_phone'],['class'=>'form-control','placeholder'=>'Company Phone No.'])!!}
                                        <small class="text-danger">{{ $errors->first('company_phone') }}</small>
                                    </div>
                                </div>
                                <div class="clearfix"></div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Company Email <span class="text-danger">*</span></label>
                                        {!! Form::text('company_email',$result['company_email'],['class'=>'form-control','placeholder'=>'Company Email Address'])!!}
                                        <small class="text-danger">{{ $errors->first('company_email') }}</small>
                                    </div>
                                </div>
                               
                                <div class="col-md-6">
                                    <div class="form-group mb_0">
                                        <label>Company Address <span class="text-danger">*</span></label>
                                        {!! Form::textarea('company_address',$result['company_address'],['class'=>'form-control','rows'=>'3','placeholder'=>'Company Address'])!!}
                                        <small class="text-danger">{{ $errors->first('company_address') }}</small>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane" id="images">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6 mb_30">
                                    <label>Company Logo</label>
                                    <table class="table image-table mb_0">
                                        <tr>
                                            <td style="vertical-align: middle;text-align: left;">
                                                <div class="profile-user-img">
                                                    <img class=" watter_image" src="{{ \AppHelper::getImage($result['company_logo']) }}" alt="User profile picture">
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
                                                    Choose File <input name="_company_logo" type="file" class="inputFileUpload" save_folder="profile" input_file_key="_company_logo" crop_compress="compress" compress_size="800" crop_size="800X800"/>
                                                </span>
                                                <button type="button" class="btn btn-danger remove_image" <?php
                                                                                                            if (empty($result['company_logo'])) {
                                                                                                                echo 'style="display: none;"';
                                                                                                            }
                                                                                                            ?>>Remove</button>

                                                {!! Form::hidden('company_logo',!empty($result['company_logo'])?$result['company_logo']:"",['class'=>'hidden_filename'])!!}
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="col-md-6">
                                    <label>Favicon</label>
                                    <table class="table image-table mb_0">
                                        <tr>
                                            <td style="vertical-align: middle;text-align: left;">
                                                <div class="profile-user-img">
                                                    <img class="watter_image" src="{{ \AppHelper::getImage($result['company_fav']) }}" alt="User profile picture">
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
                                                    Choose File <input name="_company_fav" type="file" class="inputFileUpload" save_folder="profile" input_file_key="_company_fav" crop_compress="compress" compress_size="800" crop_size="800X800"/>
                                                </span>
                                                <button type="button" class="btn btn-danger remove_image" <?php
                                                                                                            if (empty($result['company_fav'])) {
                                                                                                                echo 'style="display: none;"';
                                                                                                            }
                                                                                                            ?>>Remove</button>
                                                {!! Form::hidden('company_fav',!empty($result['company_fav'])?$result['company_fav']:"",['class'=>'hidden_filename'])!!}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->

                    </div>
                    <!-- /.tab-pane -->
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <!-- /.tab-content -->

                {!! Form::close() !!}

            </div>
            <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

</section>
<!-- /.content -->
@include('admin_elements.upload_elements.single_image_crop_compress')
@endsection