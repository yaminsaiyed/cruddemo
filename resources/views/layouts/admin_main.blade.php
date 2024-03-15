<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo \AppHelper::getAdminCompanyDetails("company_name"); ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @include('admin_elements.top_assets')

 
</head>
<body class="sidebar-mini skin-blue fixed">
<div class="wrapper">

@include('admin_elements.top_header')
  <!-- Left side column. contains the logo and sidebar -->
@include('admin_elements.left_sidebar')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->


@section('content')
@show

</div>

@include('admin_elements.footer')

 @include('admin_elements.control_sidebar') 


  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

  @include('admin_elements.footer_assets')

</body>
</html>
