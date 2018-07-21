<!DOCTYPE html>
<html lang="en" data-textdirection="LTR" class="loading">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta name="description" content="CRM for Chettinad Handloom | Manufacturers of Chettinad Handloom | Online store for Exclusive Chettinad Handloom sarees">
        <meta name="author" content="madowhat.com">
        <title>Login</title>
        <link rel="shortcut icon" type="image/x-icon" href="<?=ASSETS?>adminApp/core/favicon.ico">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-touch-fullscreen" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="default">
        <!-- BEGIN VENDOR CSS-->
        <link rel="stylesheet" type="text/css" href="<?=ASSETS?>adminApp/theme/app-assets/css/bootstrap.min.css">
        <!-- font icons-->
        <link rel="stylesheet" type="text/css" href="<?=ASSETS?>adminApp/theme/app-assets/fonts/icomoon.css">
        <link rel="stylesheet" type="text/css" href="<?=ASSETS?>adminApp/theme/app-assets/fonts/flag-icon-css/css/flag-icon.min.css">
        <link rel="stylesheet" type="text/css" href="<?=ASSETS?>adminApp/theme/app-assets/vendors/css/sliders/slick/slick.css">
        <link rel="stylesheet" type="text/css" href="<?=ASSETS?>adminApp/theme/app-assets/vendors/css/extensions/pace.css">
        <link rel="stylesheet" type="text/css" href="<?=ASSETS?>adminApp/theme/app-assets/vendors/css/forms/icheck/icheck.css">
        <link rel="stylesheet" type="text/css" href="<?=ASSETS?>adminApp/theme/app-assets/vendors/css/forms/icheck/custom.css">
        <!-- END VENDOR CSS-->
        <!-- BEGIN ROBUST CSS-->
        <link rel="stylesheet" type="text/css" href="<?=ASSETS?>adminApp/theme/app-assets/css/bootstrap-extended.min.css">
        <link rel="stylesheet" type="text/css" href="<?=ASSETS?>adminApp/theme/app-assets/css/app.min.css">
        <link rel="stylesheet" type="text/css" href="<?=ASSETS?>adminApp/theme/app-assets/css/colors.min.css">
        <link rel="stylesheet" type="text/css" href="<?=ASSETS?>adminApp/theme/assets/css/style.css">
        <!-- END ROBUST CSS-->
        <!-- BEGIN Page Level CSS-->
        <link rel="stylesheet" type="text/css" href="<?=ASSETS?>adminApp/theme/app-assets/css/core/menu/menu-types/horizontal-menu.min.css">
        <link rel="stylesheet" type="text/css" href="<?=ASSETS?>adminApp/theme/app-assets/css/core/menu/menu-types/vertical-overlay-menu.min.css">
        <link rel="stylesheet" type="text/css" href="<?=ASSETS?>adminApp/theme/app-assets/css/pages/login-register.min.css">
        <!-- END Page Level CSS-->
        <!-- BEGIN Custom CSS-->
        <link rel="stylesheet" type="text/css" href="<?=ASSETS?>adminApp/theme/assets/css/style.css">
        <link rel="stylesheet" type="text/css" href="<?=ASSETS?>adminApp/dev/css/custom.css">
        <!-- END Custom CSS-->
    </head>
    <body data-open="hover" data-menu="horizontal-menu" data-col="1-column" class="horizontal-layout horizontal-menu 1-column  blank-page blank-page">
        <!-- ////////////////////////////////////////////////////////////////////////////-->
        <div class="app-content container center-layout mt-2">
            <div class="content-wrapper">
                <div class="content-header row">
                </div>
                <div class="content-body"><section class="flexbox-container">
                        <div class="col-md-4 offset-md-4 col-xs-10 offset-xs-1  box-shadow-2 p-0">
                            <div class="card border-grey border-lighten-3 m-0">
                                <div class="card-header no-border">
                                    <div class="card-title text-xs-center">
                                        <div class="p-1"><img src="<?=ASSETS?>adminApp/core/appIcon.jpg" style="width:50%" alt="branding logo"></div>
                                    </div>
                                    <h6 style="margin:0px !important" class="card-subtitle line-on-side text-muted text-xs-center font-small-3 pt-2"><span>Login</span></h6>
                                </div>
                                <div class="card-body collapse in">
                                    <div class="card-block">
                                        <form class="form-horizontal form-simple" action="<?= base_url('dashboard')?>">
                                            <fieldset class="form-group position-relative has-icon-left mb-0">
                                                <input type="text" class="form-control form-control-lg input-lg" id="user-name" placeholder="Your Username" >
                                                <div class="form-control-position">
                                                    <i class="icon-head"></i>
                                                </div>
                                            </fieldset>
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input type="password" class="form-control form-control-lg input-lg" id="user-password" placeholder="Enter Password" >
                                                <div class="form-control-position">
                                                    <i class="icon-key3"></i>
                                                </div>
                                            </fieldset>
                                            <fieldset class="form-group row">
                                                <div class="col-md-6 col-xs-12 text-xs-center text-md-left">
                                                    <fieldset>
                                                        <input type="checkbox" id="remember-me" class="chk-remember">
                                                        <label for="remember-me"> Remember Me</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-6 col-xs-12 text-xs-center text-md-right"><a href="recover-password.html" class="card-link">Forgot Password?</a></div>
                                            </fieldset>
                                            <!--<button type="submit" class="btn btn-primary btn-lg btn-block"><i class="icon-unlock2"></i> Login</button>-->
                                            <a href="<?= base_url('dashboard')?>" class="btn btn-primary btn-lg btn-block"><i class="icon-unlock2"></i> Login</a>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                </div>
            </div>
        </div>
        <!-- ////////////////////////////////////////////////////////////////////////////-->

        <!-- BEGIN VENDOR JS-->
        <!-- build:js app-assets/js/vendors.min.js-->
        <script src="<?=ASSETS?>adminApp/theme/app-assets/js/core/libraries/jquery.min.js" type="text/javascript"></script>
        <script src="<?=ASSETS?>adminApp/theme/app-assets/vendors/js/ui/tether.min.js" type="text/javascript"></script>
        <script src="<?=ASSETS?>adminApp/theme/app-assets/js/core/libraries/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?=ASSETS?>adminApp/theme/app-assets/vendors/js/ui/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
        <script src="<?=ASSETS?>adminApp/theme/app-assets/vendors/js/ui/unison.min.js" type="text/javascript"></script>
        <script src="<?=ASSETS?>adminApp/theme/app-assets/vendors/js/ui/blockUI.min.js" type="text/javascript"></script>
        <script src="<?=ASSETS?>adminApp/theme/app-assets/vendors/js/ui/jquery.matchHeight-min.js" type="text/javascript"></script>
        <script src="<?=ASSETS?>adminApp/theme/app-assets/vendors/js/ui/jquery-sliding-menu.js" type="text/javascript"></script>
        <script src="<?=ASSETS?>adminApp/theme/app-assets/vendors/js/sliders/slick/slick.min.js" type="text/javascript"></script>
        <script src="<?=ASSETS?>adminApp/theme/app-assets/vendors/js/ui/screenfull.min.js" type="text/javascript"></script>
        <script src="<?=ASSETS?>adminApp/theme/app-assets/vendors/js/extensions/pace.min.js" type="text/javascript"></script>
        <!-- /build-->
        <!-- BEGIN VENDOR JS-->
        <!-- BEGIN PAGE VENDOR JS-->
        <script type="text/javascript" src="<?=ASSETS?>adminApp/theme/app-assets/vendors/js/ui/jquery.sticky.js"></script>
        <script src="<?=ASSETS?>adminApp/theme/app-assets/vendors/js/forms/icheck/icheck.min.js" type="text/javascript"></script>
        <script src="<?=ASSETS?>adminApp/theme/app-assets/vendors/js/forms/validation/jqBootstrapValidation.js" type="text/javascript"></script>
        <!-- END PAGE VENDOR JS-->
        <!-- BEGIN ROBUST JS-->
        <!-- build:js app-assets/js/app.min.js-->
        <script src="<?=ASSETS?>adminApp/theme/app-assets/js/core/app-menu.min.js" type="text/javascript"></script>
        <script src="<?=ASSETS?>adminApp/theme/app-assets/js/core/app.min.js" type="text/javascript"></script>
        <script src="<?=ASSETS?>adminApp/theme/app-assets/js/scripts/ui/fullscreenSearch.min.js" type="text/javascript"></script>
        <!-- /build-->
        <!-- END ROBUST JS-->
        <!-- BEGIN PAGE LEVEL JS-->
        <script src="<?=ASSETS?>adminApp/theme/app-assets/js/scripts/forms/form-login-register.min.js" type="text/javascript"></script>
        <script src="<?=ASSETS?>adminApp/dev/js/custom.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL JS-->
        
    </body>

</html>
