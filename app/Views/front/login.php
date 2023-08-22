<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Get Quotes from Trusted Trades People In Your Area Today. Builders, Landscapers, Gardeners, Cleaners, Electricians, Plumbers and more.">
        <title>MVP Admin</title>
        <!-- plugins:css -->
        <link rel="stylesheet" href="<?php echo base_url('assets/admin/vendors/feather/feather.css') ?>" />
        <link rel="stylesheet" href="<?php echo base_url('assets/admin/vendors/ti-icons/css/themify-icons.css') ?>" />
        <link rel="stylesheet" href="<?php echo base_url('assets/admin/vendors/css/vendor.bundle.base.css') ?>" />
        <!-- endinject -->
        <!-- Plugin css for this page -->
        <!-- End plugin css for this page -->
        <!-- inject:css -->
        <link rel="stylesheet" href="<?php echo base_url('assets/admin/css/vertical-layout-light/style.css') ?>" />
        <!-- endinject -->
        <!-- Favicon 
		<link rel="shortcut icon" href="<?php echo base_url('assets/common/fav/favicon.ico')?>">
        -->
        <link rel="canonical" href="https://www.mytrustedtrades.com/">
        <style>
            .errors p {
                margin-bottom: 0;
            }
        </style>
    </head>

    <body>
        <div class="container-scroller">
            <div class="container-fluid page-body-wrapper full-page-wrapper">
                <div class="content-wrapper d-flex align-items-center auth px-0">
                    <div class="row w-100 mx-0">
                        <div class="col-lg-4 mx-auto">
                            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                                <div class="brand-logo text-center">
                                    <img src="<?php echo base_url('assets/front/img/logo.png') ?>" alt="logo" />
                                </div>
                                <h4>Hello! let's get started</h4>
                                <h6 class="font-weight-light">Sign in to continue.</h6>
                                
                                <?php if (! empty($errors)) : ?>
                                    <div class="alert alert-danger errors">
                                    <?php foreach ($errors as $field => $error) : ?>
                                        <p><?= $error ?></p>
                                    <?php endforeach ?>
                                    </div>
                                <?php endif ?>

                                <?php 
                                if(session()->getFlashdata('flash_message'))
                                { ?>
                                    <div class="alert alert-<?php echo session()->getFlashdata('class'); ?>" style="display: block;">
                                        <button class="close" data-close="alert"></button>
                                        <span> <?php echo session()->getFlashdata('flash_message'); ?> </span>
                                    </div>
                                    <?php
                                }
                                ?>
                                
                                <form class="pt-3 login-form" method="post" action="<?php echo base_url('user'); ?>">
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-lg" name="email" id="exampleInputEmail1" placeholder="Email" />
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-lg" name="password" id="exampleInputPassword1" placeholder="Password" />
                                        <input type="hidden" name="s" value="ok">
                                    </div>
                                    <div class="mt-3">
                                        <a class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" href="javascript:;">SIGN IN</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->
            </div>
            <!-- page-body-wrapper ends -->
        </div>
        <!-- container-scroller -->
        <!-- plugins:js -->
        <script src="<?php echo base_url('assets/admin/vendors/js/vendor.bundle.base.js') ?>"></script>
        <!-- endinject -->
        <!-- Plugin js for this page -->
        <!-- End plugin js for this page -->
        <!-- inject:js -->
        <script src="<?php echo base_url('assets/admin/js/off-canvas.js') ?>"></script>
        <script src="<?php echo base_url('assets/admin/js/hoverable-collapse.js') ?>"></script>
        <script src="<?php echo base_url('assets/admin/js/template.js') ?>"></script>
        <script src="<?php echo base_url('assets/admin/js/settings.js') ?>"></script>
        <script src="<?php echo base_url('assets/admin/js/todolist.js') ?>"></script>
        <!-- endinject -->
		<script>
		$(document).on('click','.auth-form-btn',function(){
			$('form.login-form').submit();
		})
		</script>
    </body>
</html>
