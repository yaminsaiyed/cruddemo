@extends('layouts.admin_main')

@section('content')

<section class="content-header">
  <h1>
    Cms Page
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{ route('cmspage.index') }}">Cms Page</a></li>
    <li class="active">Edit</li>
  </ol>
</section>
  

<section class="content">
  @include('flash_messages.admin_message')
    <!-- SELECT2 EXAMPLE -->
    {!! Form::open(['method'=>'PUT','route'=>['cmspage.update',$result->id],'role'=>'form','class'=>'form-data','files'=>true]) !!} 
      <div class="box box-default">
        <div class="box-header with-border">
         <h3 class="box-title"> Cms Page Edit </h3>

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
                  {!! Form::text('title',$result->title,['class'=>'form-control','placeholder'=>'Title'])!!}
	                  <small class="text-danger">{{ $errors->first('title') }}</small>
	                </div>
	            </div>

				<div class="col-md-6">
                <div class="form-group">
                  <label>Short Description  </label>
                  {!! Form::textarea('short_description',$result->short_description,['class'=>'form-control','rows'=>'3','placeholder'=>'Short Description'])!!}
	                  
	                </div>
	            </div>

				<div class="col-md-12">
                <div class="form-group">
                  <label>Long Description  </label>
                  {!! Form::textarea('long_description',null,['class'=>'form-control','rows'=>'3','id'=>'ckeditor1','rows'=>'10','cols'=>'80','placeholder'=>'Long Description'])!!}
	                  
	                </div>
	            </div>

				<div class="col-md-6">
                <div class="form-group">
                  <label>Meta Title  </label>
                  {!! Form::text('meta_title',$result->meta_title,['class'=>'form-control','placeholder'=>'Meta Title'])!!}
	                  
	                </div>
	            </div>

				<div class="col-md-6">
                <div class="form-group">
                  <label>Meta Description  </label>
                  {!! Form::text('meta_description',$result->meta_description,['class'=>'form-control','placeholder'=>'Meta Description'])!!}
	                  
	                </div>
	            </div>

				<div class="col-md-6">
                <div class="form-group">
                  <label>Meta Keyword  </label>
                  {!! Form::text('meta_keyword',$result->meta_keyword,['class'=>'form-control','placeholder'=>'Meta Keyword'])!!}
	                  
	                </div>
	            </div>

				<div class="col-md-6">
                <div class="form-group">
                  <label>Seo Keyword <span class="text-danger">*</span> </label>
                  {!! Form::text('seo_keyword',$result->seo_keyword,['class'=>'form-control','placeholder'=>'Seo Keyword'])!!}
	                  <small class="text-danger">{{ $errors->first('seo_keyword') }}</small>
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
                <a href="{{ route('cmspage.index') }}" class="btn btn-default">Back</a>
        </div>

        
      </div>

      {!! Form::close() !!}


      <!-- /.box -->
      
</section>
    <!-- /.content -->
@include('admin_elements.input_elements.ckeditor')

@endsection