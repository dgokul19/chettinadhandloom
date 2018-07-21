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
