@extends('layouts.admin_main')

@section('content')

<section class="content-header">
  <h1>
    Table Name
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{ route('tablename.index') }}">Table Name</a></li>
    <li class="active">Edit</li>
  </ol>
</section>
  

<section class="content">
  @include('flash_messages.admin_message')
    <!-- SELECT2 EXAMPLE -->
    {!! Form::open(['method'=>'PUT','route'=>['tablename.update',$result->id],'role'=>'form','class'=>'form-data','files'=>true]) !!} 
      <div class="box box-default">
        <div class="box-header with-border">
         <h3 class="box-title"> Table Name Edit </h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
				<div class="col-md-6">
                <div class="form-group">
                  <label>Name <span class="text-danger">*</span> </label>
                  {!! Form::text('name',$result->name,['class'=>'form-control','placeholder'=>'Name'])!!}
	                  <small class="text-danger">{{ $errors->first('name') }}</small>
	                </div>
	            </div>

				<div class="col-md-6">
                <div class="form-group">
                  <label>Description  </label>
                  {!! Form::text('description',$result->description,['class'=>'form-control','placeholder'=>'Description'])!!}
	                  
	                </div>
	            </div>
				<div class="clearfix"></div>
				<div class="col-md-12">
                <div class="form-group">
                  <label>Long Description  </label>
                  {!! Form::textarea('long_description',$result->long_description,['class'=>'form-control','rows'=>'3','id'=>'ckeditor1','rows'=>'10','cols'=>'80','placeholder'=>'Long Description'])!!}
	                  
	                </div>
	            </div>

				<div class="col-md-12">
                <div class="form-group">
                  <label>Very Long Description  </label>
                  {!! Form::textarea('very_long_description',$result->very_long_description,['class'=>'form-control','rows'=>'3','id'=>'ckeditor2','rows'=>'10','cols'=>'80','placeholder'=>'Very Long Description'])!!}
	                  
	                </div>
	            </div>
				<div class="clearfix"></div>
				<div class="col-md-6">
                <div class="form-group">
                  <label>Date <span class="text-danger">*</span> </label>
				<div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  {!! Form::text('date',\AppHelper::getDateFormat($result->date),['class'=>'form-control  pull-right datepicker','placeholder'=>'Date'])!!}
                  </div>
	                  <small class="text-danger">{{ $errors->first('date') }}</small>
	                </div>
	            </div>

				<div class="col-md-6">
				<div class="bootstrap-timepicker">
                <div class="form-group">
                  <label>Time <span class="text-danger">*</span> </label>
                   <div class="input-group">
                  {!! Form::text('time',\AppHelper::getTimeFormat($result->time),['class'=>'form-control timepicker','placeholder'=>'Time'])!!}
                  <div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                    </div>
                  </div>
	                  <small class="text-danger">{{ $errors->first('time') }}</small>
	                </div>
	                </div>
	            </div>
				<div class="clearfix"></div>
				<div class="col-md-6">
                <div class="form-group">
                  <label>Datetime <span class="text-danger">*</span> </label>
                  {!! Form::text('datetime',$result->datetime,['class'=>'form-control','placeholder'=>'Datetime'])!!}
	                  <small class="text-danger">{{ $errors->first('datetime') }}</small>
	                </div>
	            </div>

				<div class="col-md-6">
                <div class="form-group">
                  <label>Price <span class="text-danger">*</span> </label>
                  {!! Form::text('price',$result->price,['class'=>'form-control','placeholder'=>'Price'])!!}
	                  <small class="text-danger">{{ $errors->first('price') }}</small>
	                </div>
	            </div>
				<div class="clearfix"></div>
				<div class="col-md-6">
	              <div class="form-group">
	                <label>Country </label>

	              {{Form::select('country_id',$country_select_list,$result->country_id, ['class' => 'form-control select2','style'=>'width: 100%','placeholder'=>'Please Select'])}}
	              
	              </div>
	            
	            </div>

			<div class="col-md-6">
              <label>Image </label>
              <table class="table image-table">
                <tr>
                  <td style="vertical-align: middle;text-align: left;"><img class="profile-user-img watter_image" src="{{ \AppHelper::getImage($result->image) }}" alt=" profile picture">
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
                Choose File <input name="_image" type="file" class="inputFileUpload" save_folder="tablename" input_file_key="_image" crop_compress="compress" compress_size="800" crop_size="800X800"/>  
                </span>
                 </td>
                  <td  style="vertical-align: middle;text-align: left;"> 
                     
                  <button type="button" class="btn btn-danger remove_image" 
                  
                  <?php 
                  if(empty($result->image)){
                   echo 'style="display: none;"';
                  }
                  ?>
                  >Remove</button>

                  {!! Form::hidden('image',!empty($result->image)?$result->image:"",['class'=>'hidden_filename'])!!}
                </td>
                  
                </tr>
              </table>
              

      </div>
				<div class="clearfix"></div>
			<div class="col-md-6">
              <label>Image Two </label>
              <table class="table image-table">
                <tr>
                  <td style="vertical-align: middle;text-align: left;"><img class="profile-user-img watter_image" src="{{ \AppHelper::getImage($result->image_two) }}" alt=" profile picture">
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
                Choose File <input name="_image_two" type="file" class="inputFileUpload" save_folder="tablename" input_file_key="_image_two" crop_compress="compress" compress_size="800" crop_size="800X800"/>  
                </span>
                 </td>
                  <td  style="vertical-align: middle;text-align: left;"> 
                     
                  <button type="button" class="btn btn-danger remove_image" 
                  
                  <?php 
                  if(empty($result->image_two)){
                   echo 'style="display: none;"';
                  }
                  ?>
                  >Remove</button>

                  {!! Form::hidden('image_two',!empty($result->image_two)?$result->image_two:"",['class'=>'hidden_filename'])!!}
                </td>
                  
                </tr>
              </table>
              

      </div>

			<div class="col-md-6">
              <div class="form-group">
                <label>Status <span class="text-danger">*</span></label>

              {{Form::select('status', \AppHelper::getStatus(),$result->status, ['class' => 'form-control select2','style'=>'width: 100%','placeholder'=>'Please Select'])}}
              <small class="text-danger">{{ $errors->first('status') }}</small>
              </div>
            
            </div>
				<div class="clearfix"></div>
				<div class="col-md-6">
                <div class="form-group">
                  <label>Sort Order  </label>
                  {!! Form::text('sort_order',$result->sort_order,['class'=>'form-control only_numbers','placeholder'=>'Sort Order'])!!}
                  
                </div>
            </div>
</div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
       <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ route('tablename.index') }}" class="btn btn-default">Back</a>
        </div>

        
      </div>

      {!! Form::close() !!}


      <!-- /.box -->
      
</section>
    <!-- /.content -->
@include('admin_elements.input_elements.datepicker')

@include('admin_elements.input_elements.timepicker')

@include('admin_elements.input_elements.ckeditor')
@include('admin_elements.upload_elements.single_image_crop_compress')
@endsection