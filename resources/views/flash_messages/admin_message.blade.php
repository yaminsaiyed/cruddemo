  @if ($success_message = Session::get('success_message'))
  <div class="box-body">
  <div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>{{ $success_message }}</strong>
    
   </div>
</div>
@endif


@if ($error_message = Session::get('error_message'))
  <div class="box-body">
  <div class="alert alert-danger alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>{{ $error_message }}</strong>
   </div>
   </div>
@endif

<script type="text/javascript">
  var SUCCESS_MESSAGE='<div class="box-body"><div class="alert alert-success alert-block"><button type="button" class="close" data-dismiss="alert">×</button><strong>FLASH_MESSAGE</strong></div></div>';

  var ERROR_MESSAGE='<div class="box-body"><div class="alert alert-danger alert-block"><button type="button" class="close" data-dismiss="alert">×</button><strong>FLASH_MESSAGE</strong></div></div>';

</script>