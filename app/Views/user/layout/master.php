<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>Trade</title>
        <!-- plugins:css -->
        <link rel="stylesheet" href="<?php echo base_url('assets/admin/vendors/feather/feather.css') ?>" />
        <link rel="stylesheet" href="<?php echo base_url('assets/admin/vendors/ti-icons/css/themify-icons.css') ?>" />
        <link rel="stylesheet" href="<?php echo base_url('assets/admin/vendors/css/vendor.bundle.base.css') ?>" />
        <!-- endinject -->
        <!-- Plugin css for this page -->
        <link rel="stylesheet" href="<?php echo base_url('assets/admin/vendors/datatables.net-bs4/dataTables.bootstrap4.css') ?>" />
        <link rel="stylesheet" href="<?php echo base_url('assets/admin/vendors/ti-icons/css/themify-icons.css') ?>" />
        <link rel="stylesheet" href="<?php echo base_url('assets/admin/vendors/mdi/css/materialdesignicons.min.css') ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/admin/js/select.dataTables.min.css') ?>" />
        <!-- End plugin css for this page -->
        <!-- inject:css -->
        <link rel="stylesheet" href="<?php echo base_url('assets/admin/css/vertical-layout-light/style.css') ?>" />
        <!-- endinject -->
        <!-- Favicon
		<link rel="shortcut icon" href="<?php echo base_url('assets/common/fav/favicon.ico')?>">
         -->
        <style>
            .errors p {
                margin-bottom: 0;
            }
            a label.badge {
                cursor: pointer;
                text-decoration: underline;
            }
			p.error {
				color: red;
			}
        </style>
        <?=$this->renderSection("style")?>
    </head>
    <body>
		<?=$this->renderSection("loader");?>
		<!--checking routes-->
		<?php
			$router = service('router'); 
			$route  = $router->getMatchedRoute(); 
		?>
        <div class="container-scroller">
            <!-- partial:partials/_navbar.html -->
            <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
                <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                    <a class="navbar-brand brand-logo mr-5" href="<?php echo base_url('account/dashboard') ?>"><img src="<?php echo base_url('assets/front/img/logo.png') ?>" class="mr-2" alt="logo" /></a>
                    <a class="navbar-brand brand-logo-mini" href="<?php echo base_url('account/dashboard') ?>"><img src="<?php echo base_url('assets/front/img/logo.png') ?>" alt="logo" /></a>
                </div>
                <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                        <span class="icon-menu"></span>
                    </button>
                    <ul class="navbar-nav navbar-nav-right">
                        <li class="nav-item nav-profile dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
							<?php $profile_picture_src = json_decode(getProfileMediaData($_SESSION['user_id']))->media_src;?>
                                <img src="<?php echo $profile_picture_src; ?>" alt="profile" />
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                                <a class="dropdown-item <?php if($route[0]=="account/profile") echo "active"; ?>" href="<?php echo base_url('account/profile')?>">
                                    <i class="ti-settings text-primary"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="<?php echo base_url('account/logout')?>">
                                    <i class="ti-power-off text-primary"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                        <span class="icon-menu"></span>
                    </button>
                </div>
            </nav>
            <!-- partial -->
            <div class="container-fluid page-body-wrapper">
                <!-- partial:partials/_settings-panel.html -->
                
                <!-- partial -->
                <!-- partial:partials/_sidebar.html -->
                
                <nav class="sidebar sidebar-offcanvas" id="sidebar">
                    <ul class="nav">
                        <li class="nav-item <?php if($route[0]=="account/dashboard") echo "active"; ?>">
                            <a class="nav-link" href="<?php echo base_url('account/dashboard') ?>">
                                <i class="icon-grid menu-icon"></i>
                                <span class="menu-title">Dashboard</span>
                            </a>
                        </li>
						<li class="nav-item  <?php if($route[0]=="account/documents") echo "active"; ?>">
                           <a class="nav-link" href="<?php echo base_url('account/documents') ?>" aria-controls="ui-products">
                                <i class="icon-paper  menu-icon"></i>
                                <span class="menu-title">Documents</span>
                            </a>
                        </li>
						<li class="nav-item  <?php if($route[0]=="account/stocks" || $route[0]=="account/stocks/view/([0-9]+)" ) echo "active"; ?>">
                           <a class="nav-link" href="<?php echo base_url('account/stocks') ?>" aria-controls="ui-products">
                                <i class="icon-bag  menu-icon"></i>
                                <span class="menu-title">Stock</span>
                            </a>
                        </li>
						<li class="nav-item  <?php if($route[0]=="account/historical" || $route[0]=="account/historical/view/([0-9]+)" ) echo "active"; ?>">
                           <a class="nav-link" href="<?php echo base_url('account/historical') ?>" aria-controls="ui-products">
                                <i class="icon-bag  menu-icon"></i>
                                <span class="menu-title">Rental Data</span>
                            </a>
                        </li>
						
                    </ul>
                </nav>
                <!-- partial -->
                <div class="main-panel">
                    <?=$this->renderSection("content")?>
                    <!-- partial:partials/_footer.html -->
                    <footer class="footer">
                        <div class="d-sm-flex justify-content-center justify-content-sm-between">
                            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">
                                Copyright © <?php echo date('Y') ?>. All rights reserved.
                            </span>
                            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="ti-heart text-danger ml-1"></i> <a href="https://www.nexustechies.com/" target="_blank"> Nexus Techies</a></span>
                        </div>
                    </footer>
                    <!-- partial -->
                </div>
                <!-- main-panel ends -->
            </div>
            <!-- page-body-wrapper ends -->
        </div>
        <!-- container-scroller -->

        <!-- plugins:js -->
        <script src="<?php echo base_url('assets/admin/vendors/js/vendor.bundle.base.js') ?>"></script>
        <!-- endinject -->
        <!-- Plugin js for this page -->
        <script src="<?php echo base_url('assets/admin/vendors/chart.js/Chart.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/admin/vendors/datatables.net/jquery.dataTables.js') ?>"></script>
        <script src="<?php echo base_url('assets/admin/vendors/datatables.net-bs4/dataTables.bootstrap4.js') ?>"></script>
        <script src="<?php echo base_url('assets/admin/js/dataTables.select.min.js') ?>"></script>

        <!-- End plugin js for this page -->
        <!-- inject:js -->
        <script src="<?php echo base_url('assets/admin/js/off-canvas.js') ?>"></script>
        <script src="<?php echo base_url('assets/admin/js/hoverable-collapse.js') ?>"></script>
        <script src="<?php echo base_url('assets/admin/js/template.js') ?>"></script>
        <script src="<?php echo base_url('assets/admin/js/settings.js') ?>"></script>
        <script src="<?php echo base_url('assets/admin/js/todolist.js') ?>"></script>
        <!-- endinject -->
        <!-- Custom js for this page-->
        <script src="<?php echo base_url('assets/admin/js/dashboard.js') ?>"></script>
        <script src="<?php echo base_url('assets/admin/js/Chart.roundedBarCharts.js') ?>"></script>
        <!-- End custom js for this page-->
        <?=$this->renderSection("script")?>
    </body>
</html>