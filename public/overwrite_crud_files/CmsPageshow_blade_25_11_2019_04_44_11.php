@extends('layouts.admin_main')

@section('content')

<section class="content-header">
  <h1>
    Cms Page
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Cms Page</li>
  </ol>
</section>

<section class="content">

  <div class="flash_messages">
    @include('flash_messages.admin_message')  
  </div>
  
     <!-- /.row -->
  
     <div class="box box-primary filter_box" style="display: none;">
       <!--  <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-fw fa-filter"></i> Filter</h3>
        </div> -->
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
				<div class="col-md-6">
                <div class="form-group">
                  <label>Title </label>
                  {!! Form::text('title',null,['class'=>'form-control filter_title filter-input','placeholder'=>'Title'])!!}
	                </div>
	            </div>
				<div class="col-md-6">
                <div class="form-group">
                  <label>Short Description </label>
                  {!! Form::text('short_description',null,['class'=>'form-control filter_short_description filter-input','placeholder'=>'Short Description'])!!}
	                </div>
	            </div>
				<div class="col-md-6">
                <div class="form-group">
                  <label>Long Description </label>
                  {!! Form::text('long_description',null,['class'=>'form-control filter_long_description filter-input','placeholder'=>'Long Description'])!!}
	                </div>
	            </div>
				<div class="col-md-6">
                <div class="form-group">
                  <label>Meta Title </label>
                  {!! Form::text('meta_title',null,['class'=>'form-control filter_meta_title filter-input','placeholder'=>'Meta Title'])!!}
	                </div>
	            </div>
				<div class="col-md-6">
                <div class="form-group">
                  <label>Meta Description </label>
                  {!! Form::text('meta_description',null,['class'=>'form-control filter_meta_description filter-input','placeholder'=>'Meta Description'])!!}
	                </div>
	            </div><div class="col-md-6">
              <div class="form-group">
                <label>Status</label>

              {{Form::select('status', \AppHelper::getStatus(), '', ['class' => 'form-control select2 filter-select filter_status','style'=>'width: 100%','placeholder'=>'Please Select'])}}

              </div>
            
            </div></div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
          <!-- /.box-body -->
              <div class="box-footer">
               <button type="submit" class="btn btn-primary pull-left filter_btn">Hide</button>
                <button type="submit" class="btn btn-default pull-right reset_filter">Reset</button>
              </div>

              <!-- /.box-footer -->
      </div>

  

      <div class="row">
      <div class="col-xs-12">

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Cms Page List</h3>

        <div class="box-tools pull-right">
           <a href="{{ route('cmspage.create') }}" class="btn btn-primary">Add <i class="fa fa-plus"></i></a>
           <button type="button" class="btn btn-primary delete_records">Delete <i class="fa fa-fw fa-trash"></i></button>
           <button type="button" class="btn btn-primary filter_btn">Filter <i class="fa fa-fw fa-filter"></i></button>
        </div>
             

            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="box-body table-responsive no-padding">
              <table id="CmsPage" class="table table-bordered  table-striped" style="width: 100%;">
                 <thead>
                 <tr>
                  <th><input type="checkbox" name="check_all" class="check_all"/></th>
                  <th>ID</th><th>Title</th><th>Short Description</th><th>Long Description</th><th>Meta Title</th><th>Meta Description</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                 </thead>
               <tbody>
               </tbody>
                
              </table>
        

            </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->


    </section>
    <!-- /.content -->
      
@include('admin_elements.datatable.configuration')
<script>
var table_id=$('#CmsPage');
var delete_url="{{ route('cmspage.multiple_delete') }}";
var status_url="{{ route('cmspage.change_status') }}";
var table="";
$(document).ready(function(){
  //================= DATA TABLE START =================//
   table = table_id.DataTable({
        ajax :{
            url:"{{ route('cmspage.index') }}",
            data: function (yns) {yns.title = $('.filter_title').val(),yns.short_description = $('.filter_short_description').val(),yns.long_description = $('.filter_long_description').val(),yns.meta_title = $('.filter_meta_title').val(),yns.meta_description = $('.filter_meta_description').val(),yns.status = $('.filter_status').val()
            },
            dataType: 'json',
            type: 'GET',
          },
          columns :[
						{data : 'checkbox'},
						{data : 'id'},
						{data : 'title'},
						{data : 'short_description'},
						{data : 'long_description'},
						{data : 'meta_title'},
						{data : 'meta_description'},
						{data : 'status'},
						{data : 'action'},

          ],
          columnDefs: [{
            "targets": [0,1,8],
            "orderable": false,
            "className": "text-center",
            "visible": true,
          },{
            "targets": [7],
            "orderable": true,
            "className": "text-center",
            "visible": true,
          },{
            "targets": [2,3,4,5,6],
            "orderable": true,
            "className": "text-left",
            "visible": true,
          },],
          "order": [[2, 'asc']],

        processing : DATATABLE_PROCESSING,
        responsive: DATATABLE_RESPONSIVE,
        serverSide :DATATABLE_SERVERSIDE,
        searching: DATATABLE_SEARCHING,
        bStateSave: DATATABLE_BSTATESAVE, // save datatable state(pagination, sort, etc) in cookie.
        language: DATATABLE_LANGUAGE,
        dom:DATATABLE_DOM,
        //l - length changing input control ,f - filtering input,t - The table!,i - Table information summary ,p - pagination control,r - processing display element
        lengthMenu: DATATABLE_LENGTHMENU,
        pageLength: DATATABLE_PAGELENGTH, // default record count per page                  
    });
  //================= DATA TABLE END =================//
});
</script>@endsection