<div class="main-content-wrapper">
<?php
    if ($this->session->flashdata('exception')) {
        echo '<section class="alert-wrapper">
        <div class="alert alert-success alert-dismissible fade show"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <div class="alert-body">
        <i class="m-right fa fa-check"></i>';
        echo escape_output($this->session->flashdata('exception'));unset($_SESSION['exception']);
        echo '</div></div></section>';
    }
    ?>

    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo lang('add_warranty_product'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('warranty_product'), 'secondSection'=> lang('add_warranty_product')])?>
        </div>
    </section>

    <div class="box-wrapper">
        <div class="table-box">
            <?php echo form_open(base_url() . 'WarrantyProducts/addEditWarrantyProduct', $arrayName = array('id' => 'add_warranty_product_form')) ?>
            <div class="box-body">
                <div class="row imei_serial_search_wrap">
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('Search_Product_By_IMEI_Serial');?></label>
                            <input autocomplete="off" type="text" id="imei_serial" name="imei_serial" class="form-control" placeholder="<?php echo lang('Search_Product_By_IMEI_Serial');?>">
                            <ul class="search-results"></ul>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('product_name'); ?> <span class="required_star">*</span></label>
                            <input  autocomplete="off" type="text"  name="product_name" class="form-control product_name" placeholder="<?php echo lang('product_name'); ?>" value="<?php echo isset($item_name) && $item_name ? urldecode($item_name) : set_value('product_name'); ?>">
                        </div>
                        <?php if (form_error('product_name')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('product_name'); ?></span>
                            </div>
                        <?php } ?>
                        <div class="alert alert-error error-msg productname_err_msg_contnr ">
                            <p id="productname_err_msg"></p>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                        <label><?php echo lang('product_serial_no'); ?> <span class="required_star">*</span></label>
                            <input  autocomplete="off" type="text"  name="product_serial_no" class="form-control product_serial_no" placeholder="<?php echo lang('product_serial_no'); ?>" value="<?php echo isset($imei_serial) && $imei_serial ? urldecode($imei_serial) : set_value('product_serial_no'); ?>">
                        </div>
                        <?php if (form_error('product_serial_no')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('product_serial_no'); ?></span>
                            </div>
                        <?php } ?>
                        <div class="alert alert-error error-msg product_serial_no_err_msg_contnr ">
                            <p id="product_serial_no_err_msg"></p>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('Problem_Description'); ?></label>
                            <textarea  class="form-control" rows="2" id="description" name="description" placeholder="<?php echo lang('Problem_Description'); ?> ..."><?php echo set_value('description'); ?></textarea>
                        </div>
                        <?php if (form_error('description')) { ?>
                        <div class="callout callout-danger my-2">
                            <span class="error_paragraph"><?php echo form_error('description'); ?></span>
                        </div>
                        <?php } ?>
                        <div class="alert alert-error error-msg note_err_msg_contnr ">
                            <p id="note_err_msg"></p>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('Receiving_Date'); ?> <span class="required_star">*</span></label>
                            <input  autocomplete="off" type="text"  name="receiving_date" readonly class="form-control customDatepicker" placeholder="<?php echo lang('Receiving_Date'); ?>" value="<?php echo set_value('receiving_date', date('Y-m-d')); ?>">
                        </div>
                        <?php if (form_error('receiving_date')) { ?>
                        <div class="callout callout-danger my-2">
                            <span class="error_paragraph"><?php echo form_error('receiving_date'); ?></span>
                        </div>
                        <?php } ?>
                        <div class="alert alert-error error-msg receiving_date_err_msg_contnr ">
                            <p id="receiving_date_err_msg"></p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('Delivery_Date'); ?></label>
                            <input  autocomplete="off" type="text"  name="delivery_date" readonly class="form-control customDatepicker" placeholder="<?php echo lang('Delivery_Date'); ?>" value="<?php echo set_value('delivery_date'); ?>">
                        </div>
                        <?php if (form_error('delivery_date')) { ?>
                        <div class="callout callout-danger my-2">
                            <span class="error_paragraph"><?php echo form_error('delivery_date'); ?></span>
                        </div>
                        <?php } ?>
                        <div class="alert alert-error error-msg delivery_date_err_msg_contnr ">
                            <p id="delivery_date_err_msg"></p>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="form-group"> 
                            <label><?php echo lang('customer'); ?> <span class="required_star">*</span></label>
                            <select  class="form-control select2 select2-hidden-accessible op_width_100_p" name="customer_id" id="customer_id">
                                <option value=""><?php echo lang('select'); ?></option>
                                <?php foreach ($customers as $customer) { ?>
                                    <option 
                                        <?php 
                                        echo isset($customer_id) && $customer_id 
                                            ? ($customer_id == $customer->id ? 'selected' : '') 
                                            : ''; 
                                        ?> 
                                        value="<?= escape_output($customer->id)?>" 
                                        <?php echo set_select('customer_id', escape_output($customer->id))?>>
                                        <?php echo escape_output($customer->name) ?> 
                                        <?php echo $customer->phone ? '(' . escape_output($customer->phone) . ')' : '' ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>  
                        <?php if (form_error('customer_id')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('customer_id'); ?></span>
                            </div>
                        <?php } ?> 
                        <div class="alert alert-error error-msg customer_id_err_msg_contnr ">
                            <p id="customer_id_err_msg"></p>
                        </div>
                    </div> 

                    <div class="col-md-4 mb-3">
                        <div class="form-group"> 
                            <label><?php echo lang('status'); ?> <span class="required_star">*</span></label>
                            <select  class="form-control select2 op_width_100_p" name="current_status" id="current_status">
                                <option value="R_F_C"><?php echo lang('Received_From_Customer'); ?></option>
                            </select>
                        </div>  
                        <?php if (form_error('status')) { ?>
                        <div class="callout callout-danger my-2">
                            <span class="error_paragraph"><?php echo form_error('status'); ?></span>
                        </div>
                        <?php } ?>
                    </div>
                </div> 
            </div> 
            <div class="box-footer">
                <button type="submit" name="submit" value="submit" class="btn bg-blue-btn">
                    <iconify-icon icon="solar:upload-minimalistic-broken"></iconify-icon>
                    <?php echo lang('submit'); ?>
                </button>
                <input type="hidden" id="set_save_and_add_more" name="add_more">
                <button type="submit" name="submit" value="submit" class="btn bg-blue-btn" id="save_and_add_more">
                    <iconify-icon icon="solar:undo-right-round-broken"></iconify-icon>
                    <?php echo lang('save_and_add_more'); ?>
                </button>
                <a class="btn bg-blue-btn text-decoration-none" href="<?php echo base_url() ?>WarrantyProducts/listWarrantyProduct">
                    <iconify-icon icon="solar:undo-left-round-broken"></iconify-icon>
                    <?php echo lang('back'); ?>
                </a>
            </div>

            <?php echo form_close(); ?> 
        </div>
    </div>  
</div>
