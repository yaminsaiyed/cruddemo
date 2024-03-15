<style type="text/css">
    .admin-logo{height: 50px;width: 229px;margin-left: -15px;margin-bottom: 3px;}
</style>
<header class="main-header">
    <!-- Logo -->
    <a href="{{ route('admin.dashboard') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">
            <img src="<?php echo \AppHelper::getAdminSettingImage('company_fav'); ?>">
        </span>
        
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">
            <img src="<?php echo \AppHelper::getAdminSettingImage("company_logo"); ?>">
        </span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Messages: style can be found in dropdown.less-->
                {{-- notification bar here --}}
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ \AppHelper::getImage(Auth::user()->image) }}" class="user-image" alt="User Image">
                        <span class="hidden-xs"><?php echo Auth::user()->firstname . " " . Auth::user()->lastname; ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="{{ \AppHelper::getImage(Auth::user()->image) }}" class="img-circle" alt="User Image">
                            <p>
                                <?php echo Auth::user()->firstname . " " . Auth::user()->lastname; ?>
                                <?php if (Auth::user()->role_id == 1) : ?>
                                    <small><a style="color:#ffffff;" href="{{ route('permissionrole.role_list') }}">Role Permission</a></small>
                                <?php endif ?>
                            </p>
                        </li>
                        <!-- Menu Body -->

                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="">
                                <a href="{{ route('admin.profile') }}" class="btn btn-primary btn-flat">Profile</a>
                                <a href="{{ route('admin.logout') }}" class="btn btn-default btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <!-- Control Sidebar Toggle Button -->
                <!--  <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>  -->
            </ul>
        </div>
    </nav>
</header>