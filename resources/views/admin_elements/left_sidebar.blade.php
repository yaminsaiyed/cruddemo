<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <!-- <div class="user-panel">
              <div class="pull-left image">
                  <img src="{{ \AppHelper::getImage(Auth::user()->image) }}" class="img-circle" alt="User Image">
              </div>
              <div class="pull-left info">
                  <p><?php // echo Auth::user()->firstname . " " . Auth::user()->lastname; 
                        ?></p>
                  <a href="javascript:;"><i class="fa fa-circle text-success"></i> <?php // if (Auth::user()->role_id == 1) {
                                                                                    // echo 'Admin';
                                                                                    // } else {
                                                                                    // echo 'Online';
                                                                                    //  } 
                                                                                    ?></a>
              </div>
          </div> -->
        <!-- search form -->

        <!-- /.search form -->
        <?php
        $action = app('request')->route()->getAction();
        $controller_action = explode('@', class_basename($action['controller']));
        $current_controller = $controller_action[0];
        $current_action = $controller_action[1];
        ?>

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">Main Navigation</li>
            <li class="<?php echo ($current_action == "dashboard") ? "active" : ""; ?>"><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
            <li class="<?php echo ($current_controller == "SchoolController") ? "active" : ""; ?>"><a href="{{ route('school.index') }}"><i class="fa fa-graduation-cap"></i> <span>Schools</span></a></li>
            <li class="<?php echo ($current_controller == "SubscriptionController") ? "active" : ""; ?>"><a href="{{ route('subscription.index') }}"><i class="fa fa-pencil"></i> <span>Subscription</span></a></li>
            <li class="<?php echo ($current_controller == "SchoolSubscriptionController") ? "active" : ""; ?>"><a href="{{ route('schoolsubscription.index') }}"><i class="fa fa-book"></i> <span>School Subscription</span></a></li>

            <li class="header">Configuration</li>
            <li class="<?php echo ($current_controller == "SettingController") ? "active" : ""; ?>"><a href="{{ route('setting') }}"><i class="fa fa-fw fa-cogs"></i> <span>Setting</span></a></li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>