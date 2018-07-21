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
                        <!-- <h2 class="content-header-title mb-0">Qunatity settings</h2> -->
                        <div class="row breadcrumbs-top pull-right" style="">
                            <div class="breadcrumb-wrapper col-xs-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard')?>">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="javascript:void(0)">settings</a>
                                    </li>
                                    <li class="breadcrumb-item active">Material settings
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                
                    <div class="content-header-right text-md-right col-md-6 col-xs-12" style="margin-top:-25px">
                        <div class="form-group"></div> 
                        <!-- Round Outline Icon Buttons-->  
                        <button type="button" class="btn-icon btn btn-secondary btn-round" data-toggle="modal" data-target="#animation"><i class="icon-plus"></i></button>
                        <!-- <button type="button" class="btn-icon btn btn-secondary btn-round"><i class="icon-help2"></i></button>
                        <button type="button" class="btn-icon btn btn-secondary btn-round"><i class="icon-cog3"></i></button> -->
                        
                    </div>
                    <div class="content-header-lead col-xs-12 mt-2">
                        
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="content-body">
                    
                    <div class="col-md-2">
                        <?php 
                            $this->load->view('settings/side_menu');
                        ?>
                    </div>

                    <div class="col-md-10">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Material Type</h4>
                                <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="reload"><i class="icon-reload"></i></a></li>
                                        <li><a data-action="expand"><i class="icon-expand2"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body collapse-in">
                                
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Material Type</th>
                                                <th>Amount <small>(Per unit)</small></th>
                                                <th>Comments</th>
                                                <th>Status</th>
                                                <th>Controls</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i=1;
                                            foreach($data->result() as $key){
                                                ?>
                                                <tr>
                                                    <td><?=$i?></td>
                                                    <td><?=$key->material_name?></td>
                                                    <td><?=$key->unit_price?></td>
                                                    <td><?=$key->comments?></td>
                                                    <td><?=($key->is_active == 1)? "<span class='tag tag-success'>enabled</span>": "<span class='tag tag-dange r'>disabled</span>"?></td>
                                                    <td>
                                                        <button class="btn btn-xs no-bg control-but icon-pencil3"></button>
                                                        <?php
                                                        if($i != 1){
                                                            ?>
                                                            <button class="btn btn-xs no-bg control-but icon-trash" onclick="eraseMaterial('<?=$key->id?>','<?=$key->material_name?>')"></button>
                                                            <?php
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>    
                                                <?php
                                                $i++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                  
                </div>
            </div>
        </div>
        
        
        <div class="clearfix"></div>
        <?php
        $this->load->view('parts/footer_view');
        ?>
        
    <script type="text/javascript">
        function eraseMaterial(id,item){
            swal({
                title:"Are you sure?",
                text:"want to delete item '"+item+"'",
                type:"warning",
                showCancelButton:!0,
                confirmButtonColor:"#F6BB42",
                confirmButtonText:"Yes, delete it!",
                cancelButtonText:"No",
                closeOnCancel:1},
                function(isConfirm){
                    if(isConfirm){
                        $.ajax({
                            url:base_url+'settings/erase-material-type',
                            data:{id:id},
                            type:"post",
                            success:function(response){
                                
                            },
                            error:function(response){
                                swal("Sorry!","Internal Server Error","error");
                            }
                        });
                    }
                })
        }
    </script>

        <!-- Add New Material Type Modal -->
        <div class="modal text-xs-left" id="animation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel6" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="form" action="<?=base_url('settings/add-new-material-type')?>" method="POST" autocomplete="off">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel6"><i class=""></i>Add New Material Type</h4>
                </div>
                <div class="modal-body">
                    
							<div class="form-body">

								<div class="form-group">
									<label for="mt_name">Material Name</label>
									<input type="text" id="mt_name" class="form-control square" placeholder="name" name="mt_name" required>
								</div>
								<div class="form-group">
									<label>Amount<small>(per unit)</small></label>
									<div class="input-group">
										<span class="input-group-addon">INR</span>
										<input type="number" class="form-control square" placeholder="amount" aria-label="Amount (to the nearest dollar)" name="mt_amount" id="mt_amount" required>
										
									</div>
								</div>

								<div class="form-group">
									<label for="donationinput7">Comments</label>
									<textarea id="donationinput7" rows="5" class="form-control square" name="comments" id="comments" placeholder="comments"></textarea>
								</div>

							</div>
                </div>
                <div class="modal-footer">
                    <div class="">
                        <button type="button" class="btn btn-warning mr-1"  data-dismiss="modal">
                            <i class="icon-cross2"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="icon-check2"></i> Save
                        </button>
                    </div>
                    <!-- <button type="button" class="btn grey btn-outline-secondary">Close</button>
                    <button type="button" class="btn btn-outline-primary">Save changes</button> -->
                </div>
                </form>
            </div>
        </div>


    </body>

</html>
