@extends('layouts.admin_main')

@section('content')

<section class="content-header">
  <h1>
    Country
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Country</li>
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
                  <label>Name </label>
                  {!! Form::text('name',null,['class'=>'form-control filter_name filter-input','placeholder'=>'Name'])!!}
	                </div>
	            </div>
				<div class="col-md-6">
                <div class="form-group">
                  <label>Sort Order </label>
                  {!! Form::text('sort_order',null,['class'=>'form-control only_numbers filter_sort_order filter-input','placeholder'=>'Sort Order'])!!}
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
              <h3 class="box-title">Country List</h3>

        <div class="box-tools pull-right">
           <a href="{{ route('country.create') }}" class="btn btn-primary">Add <i class="fa fa-plus"></i></a>
           <button type="button" class="btn btn-primary delete_records">Delete <i class="fa fa-fw fa-trash"></i></button>
           	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">Import <i class="fa fa-fw fa-file-excel-o"></i></button>
           	<div class="btn-group">
           <button type="button" class="btn btn-primary">Export <i class="fa fa-fw fa-cloud-download"></i></button>
                  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu btn-default" role="menu">
                    <li><a href="{{route('country.export_excel')}}">Export To Excel <i class="fa fa-fw fa-file-excel-o"></i></a></li>
                    <li><a href="{{route('country.export_csv')}}">Export To CSV <i class="fa fa-fw fa-file-excel-o"></i></a></li>
                  </ul>
                </div>
           <button type="button" class="btn btn-primary filter_btn">Filter <i class="fa fa-fw fa-filter"></i></button>
        </div>
             

            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="box-body table-responsive no-padding">
              <table id="Country" class="table table-bordered  table-striped" style="width: 100%;">
                 <thead>
                 <tr>
                  <th><input type="checkbox" name="check_all" class="check_all"/></th>
                  <th>ID</th><th>Name</th><th>Sort Order</th>
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
var table_id=$('#Country');
var delete_url="{{ route('country.multiple_delete') }}";
var status_url="{{ route('country.change_status') }}";
var table="";
$(document).ready(function(){
  //================= DATA TABLE START =================//
   table = table_id.DataTable({
        ajax :{
            url:"{{ route('country.index') }}",
            data: function (yns) {yns.name = $('.filter_name').val(),yns.sort_order = $('.filter_sort_order').val(),yns.status = $('.filter_status').val()
            },
            dataType: 'json',
            type: 'GET',
          },
          columns :[
						{data : 'checkbox'},
						{data : 'id'},
						{data : 'name'},
						{data : 'sort_order'},
						{data : 'status'},
						{data : 'action'},

          ],
          columnDefs: [{
            "targets": [0,1,5],
            "orderable": false,
            "className": "text-center",
            "visible": true,
          },{
            "targets": [3,4],
            "orderable": true,
            "className": "text-center",
            "visible": true,
          },{
            "targets": [2],
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
</script>
<style>
    .example-modal .modal {
      position: relative;
      top: auto;
      bottom: auto;
      right: auto;
      left: auto;
      display: block;
      z-index: 1;
    }

    .example-modal .modal {
      background: transparent !important;
    }
  </style>
<div class="modal fade" id="modal-default">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Import Country</h4>
          </div>
         
         {!! Form::open(['method'=>'POST','route'=>['country.import'],'role'=>'form','files'=>true,'class'=>'import_form']) !!} 
          <div class="modal-body">
            <table class="table image-table">
                
                <tr>
                  
                <td  style="vertical-align: middle;text-align: left;"> 
                <span style="width: 100%;height: 100%;" class="btn btn-primary btn-file">
                Choose File <input name="import" type="file" class="import_input" />  
                </span>
                 </td>
                                    
                </tr>


                <tr>
                  
                <td  style="vertical-align: middle;text-align: left;"> 
               <a style="width: 100%;height: 100%;"  href="{{ asset('public/import_sample_sheets/country.xlsx') }}" class="btn btn-primary pull-left">Download Sample</a>
                 </td>
                                    
                </tr>
              </table>
          </div>
        {!! Form::close() !!}
          <div class="modal-footer">
            
            
            
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
           
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

<script type="text/javascript">
  $(".import_input").change(function(){
     $(".import_form").submit();
  });

</script>@endsection