@extends('layouts.admin_main')

@section('content')

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
                
               <?php foreach ($permission_array as $permission_array_key => $permission_array_value){ ?>   
                <section>
                  <h3><label><input type="checkbox" /> <?php echo $permission_array_value['parent']; ?></label></h3>
                  <div class="children">
                    <?php foreach ($permission_array_value['child'] as $permission_child_key => $permission_child_value): ?>
                    <label><input type="checkbox" name="role_permission_id[]" value="<?php echo $permission_child_value['id']; ?>" <?php echo (in_array($permission_child_value['id'], $selected_permission_role)?"checked":""); ?>/><?php echo $permission_child_value['method']; ?></label> &nbsp; &nbsp;
                    <?php endforeach ?>
                  </div>
                </section>
              <?php } ?>
             
              <input type="hidden" name="role_id" value="<?php echo $role_details['id']; ?>">

        <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
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
    
<script type="text/javascript">
     (function ($) {
    $.fn.cbFamily = function (children) {
        return this.each(function () {
            var $this = $(this);
            var els;
            if ($.isFunction(children)) {
                els = children.call($this);
            } else {
                els = $(children);
            }
            $this.bind("click.cbFamily", function () {
                els.prop('checked', this.checked).change();
            });

            function checkParent() {
                $this.prop('checked',
                    els.length == els.filter("input:checked").length);
            }

            els.bind("click.cbFamily", function () {
                if ($this.prop('checked') && !this.checked) {
                    $this.prop('checked', false).change();
                }
                if (this.checked) {
                    checkParent();
                    $this.change();
                }
            });

            // Check parents if required on initialization
            checkParent();
        });
    };
})(jQuery);

  $("h3 input:checkbox").cbFamily(function (){
    return $(this).parents("h3").next().find("input:checkbox");
  });
</script>
@endsection