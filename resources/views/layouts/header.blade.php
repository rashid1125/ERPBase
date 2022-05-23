 <?php
 use App\Models\SettingConfigurations;
 $setting_configur = SettingConfigurations::all();
 ?>
 <!-- Navbar -->
 <nav class="main-header navbar navbar-expand navbar-white navbar-light">
     <!-- Left navbar links -->
     <ul class="navbar-nav">
         <li class="nav-item">
             <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
         </li>
         <li class="nav-item d-none d-sm-inline-block" data-toggle="tooltip" title="Dashboard!">
             <a href="{{ url('user/dashboard') }}" class="nav-link">Dashboard</a>
         </li>
         <li class="nav-item d-none d-sm-inline-block" data-toggle="tooltip" title="Transaction Wall!">
             <a href="{{ url('/wallmain') }}" class="nav-link">Transaction Wall</a>
         </li>
     </ul>

     <!-- Right navbar links -->
     <ul class="navbar-nav ml-auto">
         <!-- Navbar Search -->
         <li class="nav-item">
             <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                 <i class="fas fa-search"></i>
             </a>
             <div class="navbar-search-block">
                 <form class="form-inline">
                     <div class="input-group input-group-sm">
                         <input class="form-control form-control-navbar" type="search" placeholder="Search"
                             aria-label="Search">
                         <div class="input-group-append">
                             <button class="btn btn-navbar" type="submit">
                                 <i class="fas fa-search"></i>
                             </button>
                             <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                 <i class="fas fa-times"></i>
                             </button>
                         </div>
                     </div>
                 </form>
             </div>
         </li>

         <li class="nav-item" data-toggle="tooltip" title="<?php echo Session::get('uname') . '. From: ' . Session::get('company_name'); ?>">
             <a class="nav-link" href="#" role="button">
                 <i class="fas fa-info"></i>
             </a>
         </li>

         <li class="nav-item">
             <a class="nav-link" href="{{ url('/user/logout') }}" role="button" data-toggle="tooltip"
                 title="Sign-out!">
                 <i class="fas fa-sign-out-alt"></i>
             </a>
         </li>

         <li class="nav-item">
             <a class="nav-link" data-widget="fullscreen" href="#" role="button" data-toggle="tooltip"
                 title="Full Screen!">
                 <i class="fas fa-expand-arrows-alt"></i>
             </a>
         </li>

         <li class="nav-item">
             <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"
                 data-toggle="tooltip" title="Theme Setting!">
                 <i class="fas fa-th-large"></i>
             </a>
         </li>
     </ul>
 </nav>
 <!-- /.navbar -->


 {{-- Input Hidden Filds --}}
 <?php
 if (isset($setting_configur) && isset($setting_configur[0])) {
     $date_format = $setting_configur[0]['date_format_view'];
     $date_format_php = $setting_configur[0]['date_format_php'];
 } elseif (isset($setting) && isset($setting[0])) {
     $date_format = $setting[0]['date_format_view'];
     $date_format_php = $setting[0]['date_format_php'];
 } else {
     $date_format = _getSettingDateFormat('date_format_view');
     $date_format_php = _getSettingDateFormat();
 }
 ?>
 <input type="hidden" id="default_date_format" value="<?php echo $date_format ? $date_format : 'yyyy-mm-dd'; ?>">
 <input type="hidden" id="default_date_format_php" value="<?php echo $date_format_php ? $date_format_php : 'Y-m-d'; ?>">
