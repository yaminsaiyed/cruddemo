  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ asset('public/admin/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('public/admin/bower_components/font-awesome/css/font-awesome.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('public/admin/bower_components/Ionicons/css/ionicons.min.css') }}">
  <!-- Theme style -->

  <link rel="stylesheet" href="{{ asset('public/admin/bower_components/select2/dist/css/select2.min.css') }}">


  <link rel="stylesheet" href="{{ asset('public/admin/dist/css/AdminLTE.min.css') }}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  
  <link rel="stylesheet" href="{{ asset('public/admin/dist/css/skins/_all-skins.css') }}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

   <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <link rel="shortcut icon" type="image/x-icon" href="{{ \AppHelper::getAdminSettingImage('company_fav') }}"/>
 



  <script src="{{ asset('public/admin/bower_components/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('public/admin/dist/js/app.js') }}"></script>
   <!-- <script src="{!! asset('resources/js/app.js') !!}"></script> -->



<!-- advanced js and css start -->

<script src="{{ asset('public/admin/bower_components/select2/dist/js/select2.full.min.js') }}"></script>


<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2();
  });
</script>

<!-- select 2 me js and css end -->
<!-- advanced js and css end -->



