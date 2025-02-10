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
                <h3 class="top-left-header"><?php echo lang('list_warranty_products'); ?> </h3>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('list_warranty_products'); ?>" data-id_name="datatable">
                <div class="btn_list m-right d-flex">
                    <a class="new-btn me-1" href="<?php echo base_url() ?>WarrantyProducts/addEditWarrantyProduct">
                    <iconify-icon icon="solar:add-circle-broken" width="22"></iconify-icon> <?php echo lang('add_warranty_product'); ?>
                    </a>
                    <a class="new-btn me-1" href="<?php echo base_url() ?>WarrantyProducts/warrantyAllStock">
                    <iconify-icon icon="solar:checklist-broken" width="22"></iconify-icon> <?php echo lang('show_all'); ?>
                    </a>
                </div>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('warranty_product'), 'secondSection'=> lang('list_warranty_products')])?>
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
                                <th class="w-12"><?php echo lang('customer_name'); ?></th>
                                <th class="w-10"><?php echo lang('customer_mobile'); ?></th>
                                <th class="w-15"><?php echo lang('product_name'); ?></th>
                                <th class="w-10"><?php echo lang('p_serial_no'); ?></th>
                                <th class="w-8"><?php echo lang('receiving_date'); ?></th>
                                <th class="w-8"><?php echo lang('delivery_date'); ?></th>
                                <th class="w-15"><?php echo lang('current_status'); ?></th>
                                <th class="w-8"><?php echo lang('added_by'); ?></th>
                                <th class="w-8"><?php echo lang('added_date'); ?></th>
                                <th class="w-5"><?php echo lang('actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($warranties && !empty($warranties)) {
                                $i = count($warranties);
                            }
                            foreach ($warranties as $value) {
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
                                        <select  class="form-control select2 status_change" name="current_status" id="current_status" item-id="<?php echo escape_output($value->id);?>" <?php echo $value->current_status == 'D_T_C' ? 'disabled' : '' ?>>
                                            <option <?php echo escape_output($value->current_status) == 'R_F_C' ? 'selected' : '' ?> value="R_F_C" class="select2"><?php echo lang('Received_From_Customer');?></option>
                                            <option <?php echo escape_output($value->current_status) == 'S_T_V' ? 'selected' : '' ?> value="S_T_V" class="select2"><?php echo lang('Send_To_Vendor');?></option>
                                            <option <?php echo escape_output($value->current_status) == 'R_T_V' ? 'selected' : '' ?> value="R_T_V" class="select2"><?php echo lang('Received_To_Vendor');?></option>
                                            <option  <?php echo  $value->current_status == 'D_T_C' ? 'selected' : '' ?> value="D_T_C" class="select2"><?php echo lang('Delivered_To_Customer');?></option>
                                        </select>
                                    </td>
                                    <td><?php echo escape_output($value->added_by); ?></td>
                                    <td><?php echo date($this->session->userdata('date_format'), strtotime($value->added_date != '' ? $value->added_date : '')); ?></td>
                                    <td class="text-center">
                                        <div class="btn_group_wrap">
                                            <a class="btn btn-warning" href="<?php echo base_url() ?>WarrantyProducts/addEditWarrantyProduct/<?php echo escape_output($this->custom->encrypt_decrypt($value->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-original-title="<?php echo lang('edit'); ?>">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            <a class="delete btn btn-danger" href="<?php echo base_url() ?>WarrantyProducts/deleteWarrantyProduct/<?php echo escape_output($this->custom->encrypt_decrypt($value->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php echo lang('delete'); ?>">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </a>
                                        </div>

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
<script src="<?php echo base_url(); ?>frequent_changing/js/warranty.js"></script>
