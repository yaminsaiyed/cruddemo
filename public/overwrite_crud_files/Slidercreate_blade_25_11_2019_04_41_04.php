@extends('layouts.admin_main')

@section('content')

<section class="content-header">
  <h1>
    Slider
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{ route('slider.index') }}">Slider</a></li>
    <li class="active">Add</li>
  </ol>
</section>
  

<section class="content">
  @include('flash_messages.admin_message')
    <!-- SELECT2 EXAMPLE -->
    {!! Form::open(['method'=>'POST','route'=>['slider.store'],'files'=>true,'role'=>'form','class'=>'form-data']) !!} 
      <div class="box box-default">
        <div class="box-header with-border">
         <h3 class="box-title"> Slider Add </h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
				<div class="col-md-6">
                <div class="form-group">
                  <label>Title <span class="text-danger">*</span> </label>
                  {!! Form::text('title',null,['class'=>'form-control','placeholder'=>'Title'])!!}
	                  <small class="text-danger">{{ $errors->first('title') }}</small>
	                </div>
	            </div>

				<div class="col-md-6">
                <div class="form-group">
                  <label>Subtitle  </label>
                  {!! Form::text('subtitle',null,['class'=>'form-control','placeholder'=>'Subtitle'])!!}
	                  
	                </div>
	            </div>

				<div class="col-md-6">
                <div class="form-group">
                  <label>Link  </label>
                  {!! Form::textarea('link',null,['class'=>'form-control','rows'=>'3','placeholder'=>'Link'])!!}
	                  
	                </div>
	            </div>

			<div class="col-md-6">
              <label>Image <span class="text-danger">*</span></label>
              <table class="table image-table">
                <tr>
                  <td style="vertical-align: middle;text-align: left;"><img class="profile-user-img watter_image" src="{{ \AppHelper::getImage(old('image')) }}" alt=" profile picture">
                  <div class="clearfix"></div>
                  <small class="text-danger file_error"></small>
                  <div class="clearfix"></div>
                  <div class="progress" style="display: none;">
                    <div class="progress-bar progress-bar-green" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                    </div>
                  </div>
                  </td>
                  <td  style="vertical-align: middle;text-align: left;"> 
                <span class="btn btn-primary btn-file">
                Choose File <input name="_image" type="file" class="inputFileUpload" save_folder="slider" input_file_key="_image"/>  
                </span>
                 </td>
                  <td  style="vertical-align: middle;text-align: left;"> 
                     
                  <button type="button" class="btn btn-danger remove_image" 
                   <?php 
                  if(empty(old('image'))){
                   echo 'style="display: none;"';
                  }
                  ?>
                  >Remove</button>

                  {!! Form::hidden('image',"",['class'=>'hidden_filename'])!!}
                </td>
                  
                </tr>
              </table>
              <small class="text-danger">{{ $errors->first('image') }}</small>

      </div>

				<div class="col-md-6">
                <div class="form-group">
                  <label>Sort Order  </label>
                  {!! Form::text('sort_order',null,['class'=>'form-control only_numbers','placeholder'=>'Sort Order'])!!}
                  
                </div>
            </div>

			<div class="col-md-6">
              <div class="form-group">
                <label>Status <span class="text-danger">*</span></label>

              {{Form::select('status', \AppHelper::getStatus(), '', ['class' => 'form-control select2 filter-select filter_status','style'=>'width: 100%','placeholder'=>'Please Select'])}}
              <small class="text-danger">{{ $errors->first('status') }}</small>
              </div>
            
            </div>
</div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
       <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-default">Reset</button>
        </div>

        
      </div>

      {!! Form::close() !!}


      <!-- /.box -->
      
</section>
    <!-- /.content -->@include('admin_elements.upload_elements.single_image')
@endsection