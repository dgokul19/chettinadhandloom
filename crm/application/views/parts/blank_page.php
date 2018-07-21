<!DOCTYPE html>
<html lang="en" data-textdirection="LTR" class="loading">

    <?php
    $this->load->view('parts/header_view');
    ?>
    <body data-open="hover" data-menu="horizontal-menu" data-col="2-columns" class="horizontal-layout horizontal-menu 2-columns ">

        <?php
        $this->load->view('parts/ribbon_bar_view');
        $this->load->view('parts/menu_view');
        ?>
        
        
        <div class="app-content container center-layout mt-2" style="min-height:615px">
            <div class="content-wrapper">
                <div class="content-header row">
                    <div class="content-header-left col-md-6 col-xs-12">
                        <h2 class="content-header-title mb-0">Product Categories</h2>
                        <div class="row breadcrumbs-top pull-right" style="">
                            <div class="breadcrumb-wrapper col-xs-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard')?>">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">Products</a>
                                    </li>
                                    <li class="breadcrumb-item active">Categories
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <div class="content-header-right text-md-right col-md-6 col-xs-12">
                        <div class="form-group"></div>
                        <!-- Round Outline Icon Buttons-->                        
                        <button type="button" class="btn-icon btn btn-secondary btn-round"><i class="icon-bell4"></i></button>
                        <button type="button" class="btn-icon btn btn-secondary btn-round"><i class="icon-help2"></i></button>
                        <button type="button" class="btn-icon btn btn-secondary btn-round"><i class="icon-cog3"></i></button>
                    </div>
                    <div class="content-header-lead col-xs-12 mt-2">
                        
                    </div>
                </div>
                <div class="content-body">
                    
                </div>
            </div>
        </div>
        
        
        <?php
        $this->load->view('parts/footer_view');
        ?>
        
    </body>

</html>
