<input type="hidden" id="date_required" value="<?php echo lang('date_required');?>">
<input type="hidden" id="supplier_id_required" value="<?php echo lang('supplier_id_required');?>">
<input type="hidden" id="account_field_required" value="<?php echo lang('account_field_required');?>">
<input type="hidden" id="purchase_invoice_no_required" value="<?php echo lang('purchase_invoice_no_required');?>">
<input type="hidden" id="item_id_required" value="<?php echo lang('item_id_required');?>">
<input type="hidden" id="return_price_alert" value="<?php echo lang('return_price_alert');?>">
<input type="hidden" id="status_filed_is_rquired" value="<?php echo lang('status_filed_is_rquired');?>">
<input type="hidden" id="Return_Note" value="<?php echo lang('Return_Note');?>">
<input type="hidden" id="check_expiry_date" value="<?php echo lang('check_expiry_date');?>">
<input type="hidden" id="check_no" value="<?php echo lang('check_no');?>">
<input type="hidden" id="check_issue_date" value="<?php echo lang('check_issue_date');?>">
<input type="hidden" id="mobile_no" value="<?php echo lang('mobile_no');?>">
<input type="hidden" id="transaction_no" value="<?php echo lang('transaction_no');?>">
<input type="hidden" id="card_holder_name" value="<?php echo lang('card_holder_name');?>">
<input type="hidden" id="card_holding_number" value="<?php echo lang('card_holding_number');?>">
<input type="hidden" id="paypal_email" value="<?php echo lang('paypal_email');?>">
<input type="hidden" id="stripe_email" value="<?php echo lang('stripe_email');?>">
<input type="hidden" id="note" value="<?php echo lang('note');?>">
<input type="hidden" id="quantity_ln" value="<?php echo lang('quantity');?>">
<input type="hidden" id="unit_price_ln" value="<?php echo lang('unit_price');?>">
<input type="hidden" id="imei_number" value="<?php echo lang('imei_number');?>">
<input type="hidden" id="serial_number" value="<?php echo lang('serial_number');?>">
<input type="hidden" id="expiry_date_ln" value="<?php echo lang('expiry_date');?>">
<input type="hidden" id="add_edit_mode" value="add_mode">


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
                <h2 class="top-left-header"><?php echo lang('add_edit_purchase_return'); ?> </h2>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('purchase_return'), 'secondSection'=> lang('add_edit_purchase_return')])?>
        </div>
    </section>




    <section class="box-wrapper">
    <h3 class="display_none">&nbsp;</h3>
        <div class="table-box">
            <?php echo form_open(base_url().'Purchase_return/addEditPurchaseReturn', $arrayName = array('id' => 'purchase_return_form')); ?> 
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('ref_no'); ?></label>
                            <input  autocomplete="off" type="text" id="reference_no" readonly
                                name="reference_no" class="form-control" placeholder="<?php echo lang('ref_no'); ?>"
                                value="<?php echo $ref_no; ?>">
                        </div>
                        <?php if (form_error('reference_no')) { ?>
                        <div class="callout callout-danger my-2">
                            <span class="error_paragraph"><?php echo form_error('reference_no'); ?></span>
                        </div>
                        <?php } ?>
                        <div class="alert alert-error error-msg name_err_msg_contnr ">
                            <p id="name_err_msg"></p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('supplier'); ?> <span class="required_star">*</span></label>
                            <select  class="form-control  select2 op_width_100_p" name="supplier_id" id="supplier_id">
                                <option value=""><?php echo lang('select'); ?></option>
                                <?php foreach ($suppliers as $value) { ?>
                                    <option value="<?php echo escape_output($value->id) ?>" <?php echo set_select('supplier_id', $value->id); ?>><?php echo escape_output($value->name) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <?php if (form_error('supplier_id')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('supplier_id'); ?></span>
                            </div>
                        <?php } ?>
                        <div class="alert alert-error error-msg supplier_id_err_msg_contnr ">
                            <p id="supplier_id_err_msg"></p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('status'); ?> <span class="required_star">*</span></label>
                            <select class="form-control  select2 op_width_100_p" name="status" id="status" data-swal-fire="">
                                <option value=""><?php echo lang('select'); ?></option>
                                <option value="draft" <?php echo set_select('status', 'draft'); ?>><?php echo lang('draft');?></option>
                                <option value="taken_by_sup_pro_not_returned" <?php echo set_select('status', 'taken_by_sup_pro_not_returned'); ?>><?php echo lang('taken_by_sup_pro_not_returned');?></option>
                                <option value="taken_by_sup_money_returned" <?php echo set_select('status', 'taken_by_sup_money_returned')?>><?php echo lang('taken_by_sup_money_returned');?></option>
                                <option value="taken_by_sup_pro_returned" <?php echo set_select('status', 'taken_by_sup_pro_returned'); ?>><?php echo lang('taken_by_sup_pro_returned');?></option>
                            </select>
                            <input type="hidden" id="status_hidden">
                        </div>
                        <?php if (form_error('status')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('status'); ?></span>
                            </div>
                        <?php } ?>
                        <div class="alert alert-error error-msg status_id_err_msg_contnr ">
                            <p id="status_id_err_msg"></p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('date'); ?> <span class="required_star">*</span></label>
                            <input  autocomplete="off" type="text"   name="date" readonly class="form-control customDatepicker" placeholder="<?php echo lang('date'); ?>" value="<?=date('Y-m-d',strtotime('today'))?>">
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
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('purchase_date'); ?></label>
                            <input  autocomplete="off" type="text"  name="purchase_date" readonly class="form-control customDatepicker" placeholder="<?php echo lang('purchase_date'); ?>" value="">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('pur_ref_no'); ?></label>
                            <input  autocomplete="off" type="text" id="pur_ref_no"
                                name="pur_ref_no" class="form-control" placeholder="<?php echo lang('pur_ref_no'); ?>">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('item'); ?> <span class="required_star">*</span></label>
                            <select  class="form-control select2 select2-hidden-accessible op_width_100_p"
                                name="item_id" id="item_id">
                                <option value=""><?php echo lang('select'); ?></option>
                                <?php foreach ($items as $value) { 
                                $string = ($value->parent_name != '' ? $value->parent_name . ' - ' : '') . ($value->name) . ($value->brand_name != '' ? ' - ' . $value->brand_name : '') . ( ' - ' . $value->code);     
                                ?>
                                <option value="<?php echo escape_output($value->id) . "|" . $string  ."|" . $value->sale_unit . "|" . $value->purchase_price  . "|" . $value->conversion_rate . "|" .  $value->type . "|" . $value->expiry_date_maintain ?>">
                                    <?php echo escape_output($string) ?>
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
                    <div class="col-md-12">
                        <div class="table-responsive" id="purchase_cart">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="w-5"><?php echo lang('sn'); ?></th>
                                        <th class="w-15"><?php echo lang('item'); ?> - <?php echo lang('code'); ?> - <?php echo lang('brand'); ?></th>
                                        <th class="w-25"><?php echo lang('expiry_date_IME_Serial'); ?></th>
                                        <th class="w-15"><?php echo lang('quantity_amount'); ?></th>
                                        <th class="w-15"><?php echo lang('unit_price'); ?></th>
                                        <th class="w-20"><?php echo lang('total'); ?></th>
                                        <th class="w-5"><?php echo lang('actions'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>

                        <div class="row justify-content-end">
                            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                                <div class="form-group mt-4 mb-3">
                                    <label><?php echo lang('g_total'); ?> <span class="required_star">*</span></label>
                                    <input class="form-control integerchk1" placeholder="<?php echo lang('grand_total');?>" readonly type="text" name="total_return_amount" id="grand_total"
                                    <?php echo set_value('grand_total'); ?>>       
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3 account_wrap d-none">
                                <div class="form-group mb-3">
                                    <label><?php echo lang('payment_methods'); ?> <span
                                            class="required_star">*</span></label>
                                    <select  class="form-control select2 op_width_100_p" id="payment_method_id"
                                        name="payment_method_id">
                                        <option value=""><?php echo lang('select'); ?></option>
                                        <?php foreach ($paymentMethods as $ec) { ?>
                                        <option value="<?php echo escape_output($ec->id) ?>" 
                                            <?php echo set_select('payment_method_id', $ec->id); ?> data-type="<?php echo escape_output($ec->account_type); ?>"><?php echo escape_output($ec->name) ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                    <input type="hidden" id="account_type" name="account_type">
                                </div>
                                <?php if (form_error('payment_method_id')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('payment_method_id'); ?></span>
                                </div>
                                <?php } ?>
                                <div class="alert alert-error error-msg payment_method_id_err_msg_contnr ">
                                    <p id="payment_method_id_err_msg"></p>
                                </div>
                                <div id="show_account_type">
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-12">
                                <div class="form-group textarea-h-100">
                                    <label><?php echo lang('note'); ?></label>
                                    <textarea  rows="4" cols="50" class="form-control" name="note" placeholder="<?php echo lang('note'); ?> ..."><?php echo set_value('note'); ?></textarea>
                                </div> 
                                <?php if (form_error('note')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('note'); ?></span>
                                </div>
                                <?php } ?> 
                            </div>
                        </div>
                    </div>
                </div> 
                <!-- /.box-body -->
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
                <a class="btn bg-blue-btn text-decoration-none" href="<?php echo base_url() ?>Purchase_return/purchaseReturns">
                    <iconify-icon icon="solar:undo-left-round-broken"></iconify-icon>
                    <?php echo lang('back'); ?>
                </a>
            </div>

            <?php echo form_close(); ?>
        </div>
    </section>
</div>
<script src="<?php echo base_url(); ?>frequent_changing/js/add_purchase_return.js"></script>


<!-- Cart Previw -->
<div class="modal fade" id="cartPreviewModal"  role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title item_header">&nbsp;</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                        <i data-feather="x"></i>
                    </span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo lang('unit_price'); ?><span class="op_color_red"> *</span></label>
                        <div class="mb-3">
                            <input type="text" autocomplete="off" class="form-control integerchk1"
                                onfocus="select();" name="unit_price_modal" id="unit_price_modal"
                                placeholder="<?php echo lang('unit_price'); ?>" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo lang('quantity_amount'); ?><span
                                class="op_color_red"> *</span></label>
                        <div class="mb-3 input-group">
                            <input type="number" autocomplete="off" min="1" class="form-control integerchk1"
                                onfocus="select();" name="qty_modal" id="qty_modal"
                                placeholder="<?php echo lang('quantity_amount'); ?>" value="" aria-describedby="basic-addon">
                            <span class="modal_item_unit input-group-text new-btn" id="basic-addon"></span>
                        </div>
                        <input type="hidden" id="hidden_input_item_type">
                        <input type="hidden" id="hidden_input_item_id">
                        <input type="hidden" id="hidden_input_item_name">
                        <input type="hidden" id="hidden_input_expiry_date_maintain">
                        <div class="alert alert-error error-msg modal_qty_err_msg_contnr ">
                            <p id="modal_qty_err_msg"></p>
                        </div>
                    </div>
                    <div class="form-group imei_p_f">
                        <label class="col-sm-4 control-label imei_serial_label"></label>
                        <div class="mb-3" id="imei_append">
                        </div>
                        <div class="imeiSerial_add_more">
                        </div>
                        <div class="expiry_add_more">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-blue-btn" id="addToCart">
                    <?php echo lang('add_to_cart'); ?>
                </button>
            </div>
        </div>
    </div>
</div>
