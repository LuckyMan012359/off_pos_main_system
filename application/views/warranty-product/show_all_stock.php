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
                <h3 class="top-left-header mt-2"><?php echo lang('warranty_product_all_in_stock'); ?></h3>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('warranty_product_all_in_stock'); ?>" data-id_name="datatable">
                <div class="btn_list m-right d-flex">
                    <button type="button" class="dataFilterBy new-btn"><iconify-icon icon="solar:filter-broken"  width="22"></iconify-icon> <?php echo lang('filter_by');?></button>
                </div>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('warranty_product'), 'secondSection'=> lang('warranty_product_all_in_stock')])?>
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
                            if ($warranties_all_stock && !empty($warranties_all_stock)) {
                                $i = count($warranties_all_stock);
                            }
                            foreach ($warranties_all_stock as $value) {
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
                                            }elseif($value->current_status == 'S_T_V'){
                                                echo lang('Send_To_Vendor');
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



<div class="filter-overlay"></div>
<div id="product-filter" class="filter-modal">
    <div class="filter-modal-body">
        <header>
                <h3 class="filter-modal-title"><span><?php echo lang('FilterOptions'); ?></span></h3>
                <button type="button" class="close-filter-modal" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                        <i data-feather="x"></i>
                    </span>
                </button>
        </header>
        <?php echo form_open(base_url() . 'WarrantyProducts/warrantyAllStock', array('id' => 'warrantyAllStock')) ?>
        <div class="row">
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <label class="container op_margin_top_6 op_color_dim_grey">
                        <?php echo lang('Received_From_Customer'); ?>
                        <input class="checkbox_userAll" type="checkbox" id="Received_From_Customer" name="Received_From_Customer"
                            <?php echo set_checkbox('Received_From_Customer', 'on', isset($_POST['Received_From_Customer'])); ?> >
                        <span class="checkmark"></span>
                    </label>
                </div>
                <div class="form-group">
                    <label class="container op_margin_top_6 op_color_dim_grey">
                        <?php echo lang('Send_To_Vendor'); ?>
                        <input class="checkbox_userAll" type="checkbox" id="Send_To_Vendor" name="Send_To_Vendor"
                            <?php echo set_checkbox('Send_To_Vendor', 'on', isset($_POST['Send_To_Vendor'])); ?> >
                        <span class="checkmark"></span>
                    </label>
                </div>
                <div class="form-group">
                    <label class="container op_margin_top_6 op_color_dim_grey">
                        <?php echo lang('Received_To_Vendor'); ?>
                        <input class="checkbox_userAll" type="checkbox" id="Received_To_Vendor" name="Received_To_Vendor"
                            <?php echo set_checkbox('Received_To_Vendor', 'on', isset($_POST['Received_To_Vendor'])); ?> >
                        <span class="checkmark"></span>
                    </label>
                </div>
            </div>

            <?php if(isLMni()): ?>
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <select class="form-control select2 ir_w_100" id="outlet_id" name="outlet_id">
                        <option value=""><?php echo lang('outlet'); ?></option>
                        <?php
                        $outlets = getAllOutlestByAssign();
                        foreach ($outlets as $value):
                        ?>
                            <option <?= set_select('outlet_id', $value->id, isset($_POST['outlet_id']) && $_POST['outlet_id'] == $value->id) ?>
                                    value="<?php echo escape_output($value->id); ?>">
                                <?php echo escape_output($value->outlet_name); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <?php endif; ?>
        
            <div class="col-12 mb-2">
                <button type="submit" name="submit" value="submit" class="new-btn">
                    <iconify-icon icon="solar:hourglass-broken" width="22"></iconify-icon>
                    <?php echo lang('submit'); ?>
                </button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>


<?php $this->view('updater/reuseJs'); ?>

