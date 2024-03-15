@extends('layouts.admin_main')

@section('content')

<section class="content-header">
  <h1>
    City
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{ route('city.index') }}">City</a></li>
    <li class="active">Edit</li>
  </ol>
</section>
  

<section class="content">
  @include('flash_messages.admin_message')
    <!-- SELECT2 EXAMPLE -->
    {!! Form::open(['method'=>'PUT','route'=>['city.update',$result->id],'role'=>'form','class'=>'form-data','files'=>true]) !!} 
      <div class="box box-default">
        <div class="box-header with-border">
         <h3 class="box-title"> City Edit </h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
				<div class="col-md-6">
	              <div class="form-group">
	                <label>State <span class="text-danger">*</span></label>

	              {{Form::select('state_id',$state_select_list,$result->state_id, ['class' => 'form-control select2','style'=>'width: 100%','placeholder'=>'Please Select'])}}
	              <small class="text-danger">{{ $errors->first('state_id') }}</small>
	              </div>
	            
	            </div>

				<div class="col-md-6">
                <div class="form-group">
                  <label>Name <span class="text-danger">*</span> </label>
                  {!! Form::text('name',$result->name,['class'=>'form-control','placeholder'=>'Name'])!!}
	                  <small class="text-danger">{{ $errors->first('name') }}</small>
	                </div>
	            </div>

			<div class="col-md-6">
              <div class="form-group">
                <label>Status <span class="text-danger">*</span></label>

              {{Form::select('status', \AppHelper::getStatus(),$result->status, ['class' => 'form-control select2 filter-select filter_status','style'=>'width: 100%','placeholder'=>'Please Select'])}}
              <small class="text-danger">{{ $errors->first('status') }}</small>
              </div>
            
            </div>

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
                <a href="{{ route('city.index') }}" class="btn btn-default">Back</a>
        </div>

        
      </div>

      {!! Form::close() !!}


      <!-- /.box -->
      
</section>
    <!-- /.content -->
@endsection