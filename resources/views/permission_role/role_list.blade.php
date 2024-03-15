@extends('layouts.admin_main')

@section('content')

<section class="content-header">
  <h1>
    Role List
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Role List</li>
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
              <h3 class="box-title">Role List</h3>

        
             

            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="box-body table-responsive no-padding">
              <table id="Area" class="table table-bordered  table-striped" style="width: 100%;">
                 <thead>
                 <tr>
                  <th>ID</th><th>Role Name</th><th>Description</th><th>Action</th>
                </tr>
                <?php foreach ($role_list as $row): ?>
                <tr>
                  <td>{{ $row['id'] }}</td>
                  <td><b>{{ $row['name'] }}</b></td>
                  <td>{{ $row['description'] }}</td>
                  <td><a href="{{ route('permissionrole.permission_update',$row['id']) }}" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a></td>
                </tr>  
                <?php endforeach ?>
                
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
@endsection