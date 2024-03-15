@extends('layouts.admin_main')

@section('content')

<link rel="stylesheet" type="text/css" href="{{ asset('public/admin/treeview/css/checkTree.css') }}"/>

<script type="text/javascript" src="{{ asset('public/admin/treeview/js/checktree.js') }}"></script>
<section class="content-header">
  <h1>
    Permission Update
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Permission Update</li>
  </ol>
</section>
  

<section class="content">

  <div class="flash_messages">
    @include('flash_messages.admin_message')  
  </div>
  
     <!-- /.row -->
   <div class="row">
      <div class="col-xs-12">

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Role Name : <?php echo $role_details['name']; ?></h3>

          
             

            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="box-body table-responsive no-padding">
                  @include('flash_messages.admin_message')
                  {!! Form::open(['method'=>'POST','route'=>['permissionrole.permission_update_submit'],'role'=>'form','class'=>'form-data']) !!} 
                <div id="tree-container"></div>
                  <div class="box-footer">
                <button type="button" class="btn btn-primary kjkljkjllkjlk">Submit</button>
                <button type="reset" class="btn btn-default">Reset</button>
        </div>
                  {!! Form::close() !!}
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
<script>
      var mockData = [];
      mockData.push(<?php foreach ($permission_array as $permission_array_key => $permission_array_value): ?>{
          item:{
              id: 'id<?php echo $permission_array_key; ?>',
              label: '<?php echo $permission_array_value['parent']; ?>',
              value:0,
              checked: false,
              name:"parent[]"
          },
          children: [<?php foreach ($permission_array_value['child'] as $permission_child_key => $permission_child_value): ?>{
            item:{
                  id: 'id<?php echo $permission_array_key."-".$permission_child_key; ?>',
                  label: '<?php echo $permission_child_value['method']; ?>',
                  value:'<?php echo $permission_child_value['id']; ?>',
                  checked: '<?php echo (in_array($permission_child_value['id'], $selected_permission_role)?true:false); ?>',
                  name:"parent[]"
              }
          },<?php endforeach ?>]
      },<?php endforeach ?>);

   

    $(function(){

        $('#tree-container').checkTree({
            data: mockData
        });

    });

 
     

  </script>


   
@endsection