<input type="hidden" id="Unit_Price_l" value="<?php echo lang('unit_price');?>">
<input type="hidden" id="Qty_Amount" value="<?php echo lang('qty');?>">
<input type="hidden" id="total" value="<?php echo lang('total');?>">
<input type="hidden" id="date_field_required" value="<?php echo lang('date_field_required');?>">
<input type="hidden" id="at_least_item" value="<?php echo lang('at_least_item');?>">
<input type="hidden" id="ok" value="<?php echo lang('ok');?>">
<input type="hidden" id="add_mode" value="Add">
<script src="<?php echo base_url(); ?>frequent_changing/js/add_fixed_asset_stock.js"></script>

<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/add_edit_purchase.css">

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
                <h3 class="top-left-header mt-2"><?php echo lang('add_fixed_asset_stock_in'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('fixed_asset_stock'), 'secondSection'=> lang('add_fixed_asset_stock_in')])?>
        </div>
    </section>


    <div class="box-wrapper">
        <div class="table-box">
            <?php echo form_open_multipart(base_url() . 'Fixed_asset_stock/addEditStock', $arrayName = array('id' => 'fixed_asset_stock_form')) ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('ref_no'); ?></label>
                            <input  autocomplete="off" type="text" id="reference_no" readonly
                                name="reference_no" class="form-control" placeholder="<?php echo lang('ref_no'); ?>"
                                value="<?php echo $stock_ref_no; ?>">
                        </div>
                        <?php if (form_error('reference_no')) { ?>
                        <div class="callout callout-danger my-2">
                            <span class="error_paragraph"><?php echo form_error('reference_no'); ?></span>
                        </div>
                        <?php } ?>
                    </div>
                    
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('date'); ?> <span class="required_star">*</span></label>
                            <input  autocomplete="off" readonly type="text" name="date"
                                class="form-control customDatepicker" placeholder="<?php echo lang('date'); ?>"
                                value="<?=date('Y-m-d',strtotime('today'))?>">
                        </div>
                        <?php if (form_error('date')) { ?>
                        <div class="callout callout-danger my-2">
                            <span class="error_paragraph"><?php echo form_error('date'); ?></span>
                        </div>
                        <?php } ?>
                        <div class="alert alert-error error-msg date_err_msg_contnr ">
                            <p id="date_err_msg"></p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('items'); ?> <span class="required_star">*</span></label>
                            <select  class="form-control select2 select2-hidden-accessible op_width_100_p"
                                name="item_id" id="item_id">
                                <option value=""><?php echo lang('select'); ?></option>
                                <?php foreach ($items as $value) { ?>
                                <option value="<?php echo escape_output($value->id) ?>">
                                    <?php echo ($value->name) ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                        <?php if (form_error('item_id')) { ?>
                        <div class="callout callout-danger my-2">
                            <span class="error_paragraph"><?php echo form_error('item_id'); ?></span>
                        </div>
                        <?php } ?>
                        <div class="alert alert-error error-msg item_id_err_msg_contnr ">
                            <p id="item_id_err_msg"></p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('note'); ?></label>
                            <textarea  autocomplete="off" name="note" class="form-control" placeholder="<?php echo lang('note'); ?>"><?php echo set_value('note');?></textarea>
                        </div>
                        <?php if (form_error('note')) { ?>
                        <div class="callout callout-danger my-2">
                            <span class="error_paragraph"><?php echo form_error('note'); ?></span>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive" id="stock_cart">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="w-5"><?php echo lang('sn'); ?></th>
                                        <th class="w-30"><?php echo lang('item'); ?> - <?php echo lang('name'); ?></th>
                                        <th class="w-20"><?php echo lang('quantity_amount'); ?></th>
                                        <th class="w-20"><?php echo lang('unit_price'); ?></th>
                                        <th class="w-20"><?php echo lang('total'); ?></th>
                                        <th class="w-5"><?php echo lang('actions'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-end">
                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                        <div class="form-group mt-3">
                            <label><?php echo lang('g_total'); ?> <span class="required_star">*</span></label>
                            <input class="form-control integerchk1" readonly type="text"
                                name="grand_total" id="grand_total"
                                <?php echo set_value('grand_total'); ?> placeholder="<?php echo lang('grand_total');?>">    
                        </div>
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
                <a class="btn bg-blue-btn text-decoration-none" href="<?php echo base_url() ?>Fixed_asset_stock/listStock">
                    <iconify-icon icon="solar:undo-left-round-broken"></iconify-icon>
                    <?php echo lang('back'); ?>
                </a>
            </div>

            <?php echo form_close(); ?>
        </div>
        
    </div>
</div>







