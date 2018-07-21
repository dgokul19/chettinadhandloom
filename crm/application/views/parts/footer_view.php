
<footer class="footer undefined footer-light navbar-shadow" style="">
    <p class="clearfix text-muted text-sm-center mb-0 px-2"><span class="float-md-left d-xs-block d-md-inline-block">Copyright  &copy; 2018 <a href="http://madowhat.com" target="_blank" class="text-bold-800 grey darken-2">Madowhat </a>, All rights reserved. </span><span class="float-md-right d-xs-block d-md-inline-block">Hand-crafted & Made with <i class="icon-heart5 pink"></i></span></p>
</footer>

<script type="text/javascript">
    var base_url = '<?=base_url()?>';
</script>

<!-- BEGIN VENDOR JS-->
<!-- build:js app-assets/js/vendors.min.js-->
<script src="<?= ASSETS ?>adminApp/theme/app-assets/js/core/libraries/jquery.min.js" type="text/javascript"></script>
<script src="<?= ASSETS ?>adminApp/theme/app-assets/vendors/js/ui/tether.min.js" type="text/javascript"></script>
<script src="<?= ASSETS ?>adminApp/theme/app-assets/js/core/libraries/bootstrap.min.js" type="text/javascript"></script>
<script src="<?= ASSETS ?>adminApp/theme/app-assets/vendors/js/ui/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
<script src="<?= ASSETS ?>adminApp/theme/app-assets/vendors/js/ui/unison.min.js" type="text/javascript"></script>
<script src="<?= ASSETS ?>adminApp/theme/app-assets/vendors/js/ui/blockUI.min.js" type="text/javascript"></script>
<script src="<?= ASSETS ?>adminApp/theme/app-assets/vendors/js/ui/jquery.matchHeight-min.js" type="text/javascript"></script>
<script src="<?= ASSETS ?>adminApp/theme/app-assets/vendors/js/ui/jquery-sliding-menu.js" type="text/javascript"></script>
<script src="<?= ASSETS ?>adminApp/theme/app-assets/vendors/js/sliders/slick/slick.min.js" type="text/javascript"></script>
<script src="<?= ASSETS ?>adminApp/theme/app-assets/vendors/js/ui/screenfull.min.js" type="text/javascript"></script>
<script src="<?= ASSETS ?>adminApp/theme/app-assets/vendors/js/extensions/pace.min.js" type="text/javascript"></script>
<script src="<?= ASSETS ?>adminApp/theme/app-assets/vendors/js/extensions/sweetalert.min.js" type="text/javascript"></script>
<!-- /build-->
<!-- BEGIN VENDOR JS-->
<!-- BEGIN PAGE VENDOR JS-->
<script type="text/javascript" src="<?= ASSETS ?>adminApp/theme/app-assets/vendors/js/ui/jquery.sticky.js"></script>
<script src="<?= ASSETS ?>adminApp/theme/app-assets/vendors/js/extensions/listjs/list.min.js" type="text/javascript"></script>
<!-- END PAGE VENDOR JS-->
<!-- BEGIN ROBUST JS-->
<!-- build:js app-assets/js/app.min.js-->
<script src="<?= ASSETS ?>adminApp/theme/app-assets/js/core/app-menu.min.js" type="text/javascript"></script>
<script src="<?= ASSETS ?>adminApp/theme/app-assets/js/core/app.min.js" type="text/javascript"></script>
<script src="<?= ASSETS ?>adminApp/theme/app-assets/js/scripts/ui/fullscreenSearch.min.js" type="text/javascript"></script>
<!-- /build-->
<!-- END ROBUST JS-->
<!-- BEGIN PAGE LEVEL JS-->
<script src="<?= ASSETS ?>adminApp/dev/js/custom.js" type="text/javascript"></script>
<!-- END PAGE LEVEL JS-->


<?php
if(isset($_SESSION['success_alert'])){
    ?>
    <script type="text/javascript">
        $(function () {
            swal("Success!","<?=$_SESSION['success_alert']?>","success");
        });
    </script>
    <?php
}
?>

<?php
if(isset($_SESSION['error_alert'])){
    ?>
    <script type="text/javascript">
        $(function () {
            swal("Sorry!","<?=$_SESSION['error_alert']?>","error");
        });
    </script>
    <?php
}
?>