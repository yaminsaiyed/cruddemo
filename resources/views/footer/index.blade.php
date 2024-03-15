@extends('layouts.admin_main')

@section('content')

<section class="content-header">
    <h1>
        Footer
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Edit</li>
    </ol>
</section>


<section class="content">
    @include('flash_messages.admin_message')
    <!-- SELECT2 EXAMPLE -->
    {!! Form::open(['method'=>'PUT','route'=>['footer.index'],'role'=>'form','class'=>'form-data']) !!}
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title"> Footer Edit </h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Footer Description<span class="text-danger">*</span> </label>
                        {!! Form::textarea('footer_description',$result->footer_description,['class'=>'form-control','id'=>'ckeditor1','rows'=>'10','cols'=>'80','placeholder'=>'Long Description'])!!}
                        <small class="text-danger">{{ $errors->first('footer_description') }}</small>
                    </div>
                </div>


                <div class="clearfix"></div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Facebook</label>
                        {!! Form::textarea('social_link_one',$result->social_link_one,['class'=>'form-control','rows'=>'3','placeholder'=>'Facebook Link'])!!}
                        <small class="text-danger">{{ $errors->first('social_link_one') }}</small>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Google </label>
                        {!! Form::textarea('social_link_two',$result->social_link_two,['class'=>'form-control','rows'=>'3','placeholder'=>'Google Link'])!!}
                        <small class="text-danger">{{ $errors->first('social_link_two') }}</small>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Instagram </label>
                        {!! Form::textarea('social_link_three',$result->social_link_three,['class'=>'form-control','rows'=>'3','placeholder'=>'Instagram Link'])!!}
                        <small class="text-danger">{{ $errors->first('social_link_three') }}</small>
                    </div>
                </div>


                <div class="clearfix"></div>

            </div>
            <!-- /.row -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <button type="submit" class="btn btn-primary">Submit</button>

        </div>


    </div>

    {!! Form::close() !!}


    <!-- /.box -->

</section>
<!-- /.content -->

@include('admin_elements.input_elements.ckeditor')
@endsection