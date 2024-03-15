@extends('layouts.admin_main')

@section('content')

<section class="content-header">
  <h1>
    Table Name
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Table Name</li>
  </ol>
</section>

<section class="content">

  <div class="flash_messages">
    @include('flash_messages.admin_message')  
  </div>
    <div class="row">
      <div class="col-xs-12">

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Table Name List</h3>

        <div class="box-tools pull-right">
           <a href="{{ route('tablename.create') }}" class="btn btn-primary">Add <i class="fa fa-plus"></i></a>
           <button type="button" class="btn btn-primary delete_records">Delete <i class="fa fa-fw fa-trash"></i></button>
           	<div class="btn-group">
           <button type="button" class="btn btn-primary">Export <i class="fa fa-fw fa-cloud-download"></i></button>
                  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu btn-default" role="menu">
                    <li><a href="{{route('tablename.export_excel')}}">Export To Excel <i class="fa fa-fw fa-file-excel-o"></i></a></li>
                    <li><a href="{{route('tablename.export_csv')}}">Export To CSV <i class="fa fa-fw fa-file-excel-o"></i></a></li>
                  </ul>
                </div>
        </div>
             

            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="box-body table-responsive no-padding">
              <table id="TableName" class="table table-bordered  table-striped" style="width: 100%;">
                 <thead>
                 <tr>
                  <th><input type="checkbox" name="check_all" class="check_all"/></th>
                  <th>Sr No</th>
                  		<th>Id</th>
                  		<th>Name</th>
                  		<th>Description</th>
                  		<th>Long Description</th>
                  		<th>Very Long Description</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
				<tr>
				<th></th>
				<th></th>
                
				<th>{!! Form::text('id',null,['class'=>'form-control id filter-input','placeholder'=>'Id'])!!}</th>
				<th>{!! Form::text('name',null,['class'=>'form-control name filter-input','placeholder'=>'Name'])!!}</th>
				<th>{!! Form::text('description',null,['class'=>'form-control description filter-input','placeholder'=>'Description'])!!}</th>
				<th>{!! Form::text('long_description',null,['class'=>'form-control long_description filter-input','placeholder'=>'Long Description'])!!}</th>
				<th>{!! Form::text('very_long_description',null,['class'=>'form-control very_long_description filter-input','placeholder'=>'Very Long Description'])!!}</th>
				<th>{{Form::select('status', \AppHelper::getStatus(), '', ['class' => 'form-control select2 filter-select status','style'=>'width: 100%','placeholder'=>'Please Select'])}}</th>
                <th class="text-center"> <button type="submit" class="btn btn-default reset_filter">Reset</button></th>
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
var table_id=$('#TableName');
var delete_url="{{ route('tablename.multiple_delete') }}";
var status_url="{{ route('tablename.change_status') }}";
var table="";
$(document).ready(function(){
  //================= DATA TABLE START =================//
   table = table_id.DataTable({
				responsive: true,
				orderCellsTop: true,
        ajax :{
            url:"{{ route('tablename.index') }}",
            data: function (yns) {yns.id = $('.id').val(),yns.name = $('.name').val(),yns.description = $('.description').val(),yns.long_description = $('.long_description').val(),yns.very_long_description = $('.very_long_description').val(),yns.status = $('.status').val()
            },
            dataType: 'json',
            type: 'GET',
          },
          columns :[
						{data : 'checkbox',orderable:false,className:'text-center'},
						{data : 's_no',orderable:false,className:'text-center'},
						{data : 'id',orderable:true,className:'text-left'},
						{data : 'name',orderable:true,className:'text-left'},
						{data : 'description',orderable:true,className:'text-left'},
						{data : 'long_description',orderable:true,className:'text-left'},
						{data : 'very_long_description',orderable:true,className:'text-left'},
						{data : 'status',orderable:true,className:'text-center'},
						{data : 'action',orderable:false,className:'text-center'},

          ],
          "order": [[2, 'desc']],

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