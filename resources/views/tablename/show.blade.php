@extends('layouts.admin_main')

@section('content')

<section class="content-header">
  <h1>
    Table Name
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{ route('tablename.index') }}">Table Name</a></li>
    <li class="active">View</li>
  </ol>
</section>
  

<section class="content">
<!-- SELECT2 EXAMPLE -->
   <div class="box box-default">
        <div class="box-header with-border">
         <h3 class="box-title"> Table Name View </h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="w0" class="table table-striped table-bordered detail-view">
            <tbody>
	            <tr>
	              <th>Id</th>
	              <td>{{$result->id}}</td>
	            </tr>
	            <tr>
	              <th>Name</th>
	              <td>{{$result->name}}</td>
	            </tr>
	            <tr>
	              <th>Description</th>
	              <td>{{$result->description}}</td>
	            </tr>
	            <tr>
	              <th>Long Description</th>
	              <td>{{$result->long_description}}</td>
	            </tr>
	            <tr>
	              <th>Very Long Description</th>
	              <td>{{$result->very_long_description}}</td>
	            </tr>
	            <tr>
	              <th>Date</th>
	              <td>{{\AppHelper::getDateFormat($result->date)}}</td>
	            </tr>
	            <tr>
	              <th>Time</th>
	              <td>{{\AppHelper::getTimeFormat($result->time)}}</td>
	            </tr>
	            <tr>
	              <th>Datetime</th>
	              <td>{{\AppHelper::getDateTimeFormat($result->datetime)}}</td>
	            </tr>
	            <tr>
	              <th>Price</th>
	              <td>{{$result->price}}</td>
	            </tr>
	            <tr>
	              <th>Country</th>
	              <td>{{$result->get_country->name}}</td>
	            </tr>
				<?php if(!empty($result->image)){ ?>
	            <tr>
	              <th>Image</th>
	              <td><img class="profile-user-img watter_image" src="{{ \AppHelper::getImage($result->image) }}" alt=" profile picture"></td>
	            </tr>
	        	<?php } ?>
				<?php if(!empty($result->image_two)){ ?>
	            <tr>
	              <th>Image Two</th>
	              <td><img class="profile-user-img watter_image" src="{{ \AppHelper::getImage($result->image_two) }}" alt=" profile picture"></td>
	            </tr>
	        	<?php } ?>
	            <tr>
	              <th>Status</th>
	              <td>{{($result->status==1?"Active":"Inactive")}}</td>
	            </tr>
	            <tr>
	              <th>Sort Order</th>
	              <td>{{$result->sort_order}}</td>
	            </tr>
	            <tr>
	              <th>Created At</th>
	              <td>{{\AppHelper::getDateTimeFormat($result->created_at)}}</td>
	            </tr>
	            <tr>
	              <th>Updated At</th>
	              <td>{{\AppHelper::getDateTimeFormat($result->updated_at)}}</td>
	            </tr></tbody>
           </table>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
       <div class="box-footer">
                <a href="{{ route('tablename.index')}}" class="btn btn-default">Back</a>
        </div>

        
      </div>

     
      <!-- /.box -->
      
</section>
    <!-- /.content -->

@endsection