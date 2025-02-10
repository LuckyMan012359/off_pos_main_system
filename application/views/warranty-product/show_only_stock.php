<input type="hidden" id="status_change" value="<?php echo lang('status_change');?>">


<div class="main-content-wrapper">
    <div id="message"></div>

    <?php
    if ($this->session->flashdata('exception')) {
        echo '<section class="alert-wrapper"><div class="alert alert-success alert-dismissible fade show"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></button>
        <div class="alert-body"><i class="icon fa fa-check me-2"></i>';
        echo escape_output($this->session->flashdata('exception'));unset($_SESSION['exception']);
        echo '</div></div></section>';
    }
    ?> 



    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo lang('warranty_product_available_in_stock'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('warranty_product'), 'secondSection'=> lang('warranty_product_available_in_stock')])?>
        </div>
    </section>

    <div class="box-wrapper">
        <div class="table-box"> 
            <div class="box-body">
                <div class="table-responsive"> 
                    <table id="datatable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="w-5"><?php echo lang('sn'); ?></th>
                                <th class="w-10"><?php echo lang('customer_name'); ?></th>
                                <th class="w-10"><?php echo lang('customer_mobile'); ?></th>
                                <th class="w-20"><?php echo lang('product_name'); ?></th>
                                <th class="w-10"><?php echo lang('p_serial_no'); ?></th>
                                <th class="w-15"><?php echo lang('receiving_date'); ?></th>
                                <th class="w-15"><?php echo lang('delivery_date'); ?></th>
                                <th class="w-15"><?php echo lang('current_status'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($warranty_available_stock && !empty($warranty_available_stock)) {
                                $i = count($warranty_available_stock);
                            }
                            foreach ($warranty_available_stock as $value) {
                            ?>                       
                                <tr> 
                                    <td class="op_center"><?php echo $i--; ?></td>
                                    <td><?php echo escape_output($value->customer_name); ?></td>
                                    <td><?php echo escape_output($value->customer_mobile); ?></td>
                                    <td><?php echo escape_output($value->product_name); ?></td>
                                    <td><?php echo escape_output($value->product_serial_no); ?></td>
                                    <td><?php echo date($this->session->userdata('date_format'), strtotime($value->receiving_date) ); ?></td>
                                    <td><?php echo date($this->session->userdata('date_format'), strtotime($value->delivery_date) ); ?></td>
                                    <td>
                                        <?php 
                                            if($value->current_status == 'R_F_C'){
                                                echo lang('Received_From_Customer');
                                            }elseif($value->current_status == 'R_T_V'){
                                                echo lang('Received_To_Vendor');
                                            }
                                        ?>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?> 
                        </tbody>
                        
                    </table>
                </div>
            </div>
        </div> 
    </div>
</div>

<?php $this->view('updater/reuseJs'); ?>
<script src="<?php echo base_url(); ?>frequent_changing/js/select2-inisialize.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/warranty.js"></script>
