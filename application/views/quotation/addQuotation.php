<input type="hidden" id="Unit_Price_l" value="<?php echo lang('unit_price');?>">
<input type="hidden" id="Qty_Amount" value="<?php echo lang('qty');?>">
<input type="hidden" id="total" value="<?php echo lang('total');?>">
<input type="hidden" id="supplier_field_required" value="<?php echo lang('supplier_field_required');?>">
<input type="hidden" id="account_field_required" value="<?php echo lang('account_field_required');?>">
<input type="hidden" id="date_field_required" value="<?php echo lang('date_field_required');?>">
<input type="hidden" id="at_least_item" value="<?php echo lang('at_least_item');?>">
<input type="hidden" id="imei_number" value="<?php echo lang('imei_number');?>">
<input type="hidden" id="serial_number" value="<?php echo lang('serial_number');?>">
<input type="hidden" id="expiry_date_ln" value="<?php echo lang('expiry_date');?>">
<input type="hidden" id="select" value="<?php echo lang('select');?>">
<input type="hidden" id="low_qty_set" value="<?php echo lang('low_qty_set');?>">
<input type="hidden" id="current_due" value="<?php echo lang('current_due');?>">
<input type="hidden" id="Payment_Method_Exist" value="<?php echo lang('This_Payment_Method_Already_Exist');?>">
<input type="hidden" id="ok" value="<?php echo lang('ok');?>">
<input type="hidden" id="add_mode" value="Add">
<input type="hidden" id="name_field_required" value="<?php echo lang('name_field_required');?>">
<input type="hidden" id="The_Contact_field_required" value="<?php echo lang('The_Contact_field_required');?>">
<input type="hidden" id="The_Phone_field_is_required" value="<?php echo lang('The_Phone_field_is_required');?>">
<input type="hidden" id="The_customer_field_is_required" value="<?php echo lang('The_customer_field_is_required');?>">

<script src="<?php echo base_url(); ?>frequent_changing/js/add-quotation.js"></script>
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
                <h3 class="top-left-header mt-2"><?php echo lang('add_quotation'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('quotation'), 'secondSection'=> lang('add_quotation')])?>
        </div>
    </section>


    <div class="box-wrapper">
        <div class="table-box">
            <?php echo form_open_multipart(base_url() . 'Quotation/addEditQuotation', $arrayName = array('id' => 'quotation_form')) ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('ref_no'); ?></label>
                            <input  autocomplete="off" type="text" id="reference_no" readonly
                                name="reference_no" class="form-control" placeholder="<?php echo lang('ref_no'); ?>"
                                value="<?php echo $pur_ref_no; ?>">
                        </div>
                        <?php if (form_error('reference_no')) { ?>
                        <div class="callout callout-danger my-2">
                            <span class="error_paragraph"><?php echo form_error('reference_no'); ?></span>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('customer'); ?> (<?php echo lang('phone'); ?>)<span class="required_star">*</span></label>
                            <div class="d-flex">
                                <select  class="form-control select2 op_width_100_p" id="customer_id"
                                    name="customer_id">
                                    <option value=""><?php echo lang('select'); ?></option>
                                    <?php
                                    foreach ($customers as $customer) {
                                        ?>
                                    <option value="<?php echo escape_output($customer->id) ?>"
                                        <?php echo set_select('customer_id', $customer->id); ?>>
                                        <?php echo escape_output($customer->name) ?> <?php echo escape_output($customer->phone != '' ? '(' . $customer->phone . ')' : '') ?></option>
                                    <?php } ?>
                                </select>
                                <button type="button" class="new-btn ms-1 add_customer_by_ajax bg-blue-btn-p-14">
                                <iconify-icon icon="solar:add-circle-broken" width="22"></iconify-icon>
                                </button>
                            </div>
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
                    <div class="clearfix"></div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('items'); ?> <span class="required_star">*</span></label>
                            <select  class="form-control select2 select2-hidden-accessible op_width_100_p"
                                name="item_id" id="item_id">
                                <option value=""><?php echo lang('select'); ?></option>
                                <?php foreach ($items as $value) { 
                                    $string = ($value->parent_name != '' ? $value->parent_name . ' - ' : '') . ($value->name) . ($value->brand_name != '' ? ' - ' . $value->brand_name : '') . ( ' - ' . $value->code); 
                                ?>
                                <option value="<?php echo escape_output($value->id) . "|" . $string . "|" . $value->sale_unit . "|" . $value->sale_price. "|" . $value->conversion_rate . "|" .  $value->type ?>">
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
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive" id="quotation_cart">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="w-5"><?php echo lang('sn'); ?></th>
                                        <th class="w-17"><?php echo lang('item'); ?>-<?php echo lang('brand'); ?>-<?php echo lang('code'); ?></th>
                                        <th class="w-17"><?php echo lang('expiry_date_IME_Serial'); ?></th>
                                        <th class="w-15"><?php echo lang('unit_price'); ?></th>
                                        <th class="w-13"><?php echo lang('quantity_amount'); ?></th>
                                        <th class="w-13"><?php echo lang('total'); ?></th>
                                        <th class="w-15"><?php echo lang('description'); ?></th>
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
                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3 d-flex align-items-end">
                        <div class="form-group mt-3">
                            <p><strong><?php echo lang('total_item');?>:</strong> <span class="number_of_item">0</span> (<span class="total_quantity_sum">0</span>)</p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                        <div class="form-group mt-3">
                            <label><?php echo lang('discount'); ?>
                                (<?php echo lang('flat_or_percentage'); ?>)</label>
                            <input class="form-control discount calculate_op" type="text" onfocus="select()" name="discount" 
                                id="discount" <?php echo set_value('discount'); ?> placeholder="<?php echo lang('discount_type');?>">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                        <div class="form-group mt-3">
                            <label><?php echo lang('other'); ?></label>
                            <input  autocomplete="off" class="form-control integerchk calculate_op"
                            type="text" name="other" id="other" onfocus="this.select();"
                            <?php echo set_value('other'); ?> placeholder="<?php echo lang('other');?>">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                        <div class="form-group mt-3">
                            <label><?php echo lang('g_total'); ?> <span class="required_star">*</span></label>
                            <input class="form-control integerchk1" readonly type="text"
                                name="grand_total" id="grand_total"
                                <?php echo set_value('grand_total'); ?> placeholder="<?php echo lang('grand_total');?>">    
                        </div>
                    </div>
                </div>
                <div class="row justify-content-end">
                    <div class="col-12 mt-3">
                        <div class="form-group">
                            <label><?php echo lang('note');?></label>
                            <textarea  class="form-control" rows="2" id="note" name="note"
                                placeholder="<?php echo lang('note');?>..."><?php  echo set_value('note') ?></textarea>
                        </div>
                        <?php  if (form_error('note')) { ?>
                        <div class="callout callout-danger my-2">
                            <p><?php  echo form_error('note'); ?></p>
                        </div>
                        <?php  }  ?>
                    </div>
                </div>
            </div>
            <div class="box-footer mt-3">
                <button type="submit" name="submit" value="submit" class="btn bg-blue-btn">
                    <iconify-icon icon="solar:upload-minimalistic-broken"></iconify-icon>
                    <?php echo lang('submit'); ?>
                </button>
                <input type="hidden" id="set_save_and_add_more" name="add_more">
                <button type="submit" name="submit" value="submit" class="btn bg-blue-btn" id="save_and_add_more">
                    <iconify-icon icon="solar:undo-right-round-broken"></iconify-icon>
                    <?php echo lang('save_and_add_more'); ?>
                </button>
                <input type="hidden" id="set_save_and_download" name="save_download">
                <button type="submit" name="submit" value="submit" class="btn bg-blue-btn" id="save_and_download">
                    <iconify-icon icon="solar:cloud-download-broken"></iconify-icon>
                    <?php echo lang('save_and_download'); ?>
                </button>
                <input type="hidden" id="set_save_and_email" name="save_email">
                <button type="submit" name="submit" value="submit" class="btn bg-blue-btn" id="save_and_email">
                    <iconify-icon icon="solar:inbox-line-broken"></iconify-icon>
                    <?php echo lang('save_and_email'); ?>
                </button>
                <input type="hidden" id="set_save_and_print" name="save_print">
                <button type="submit" name="submit" value="submit" class="btn bg-blue-btn" id="save_and_print">
                    <iconify-icon icon="solar:printer-2-broken"></iconify-icon>
                    <?php echo lang('save_and_print'); ?>
                </button>
                <a href="<?php echo base_url() ?>Quotation/quotations" class="btn bg-blue-btn">
                    <iconify-icon icon="solar:undo-left-round-broken"></iconify-icon>
                    <?php echo lang('back'); ?>
                </a>
            </div>
            <?php echo form_close(); ?>
        </div>
        <input type="hidden" name="populate_click" id="populate_click" value="">
    </div>
</div>


<!-- Customer Modal -->
<div class="modal fade" id="addCustomerModal"  role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">
                    <?php echo lang('add_customer'); ?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i
                            data-feather="x">×</i></span></button>
                
            </div>
            <form id="add_customer_form">
                <div class="modal-body scroll_body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label><?php echo lang('customer_name'); ?> <span class="required_star">*</span></label>
                                <input  autocomplete="off" type="text" name="name" class="form-control"
                                    placeholder="<?php echo lang('customer_name'); ?>" id="c_name"
                                    value="<?php echo set_value('name'); ?>">
                            </div>
                            <div class="alert alert-error error-msg name_err_msg_contnr ">
                                <p id="name_err_msg"></p>
                            </div>
                            <?php if (form_error('name')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('name'); ?></span>
                            </div>
                            <?php } ?>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label><?php echo lang('phone'); ?> <span class="required_star">*</span></label>
                                <input  autocomplete="off" type="text" name="phone" id="c_phone"
                                    class="form-control" placeholder="<?php echo lang('phone'); ?>"
                                    value="<?php echo set_value('phone'); ?>">
                            </div>
                            <div class="alert alert-error error-msg phone_err_msg_contnr ">
                                <p id="phone_err_msg"></p>
                            </div>
                            <?php if (form_error('phone')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('phone'); ?></span>
                            </div>
                            <?php } ?>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label><?php echo lang('email'); ?></label>
                                <input  autocomplete="off" type="text" name="email" class="form-control"
                                    placeholder="<?php echo lang('email'); ?>" id="c_emaiil" value="<?php echo set_value('email'); ?>">
                            </div>
                            <?php if (form_error('email')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('email'); ?></span>
                            </div>
                            <?php } ?>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="d-flex justify-content-between">
                                <div class="form-group w-100 me-2">
                                    <label><?php echo lang('opening_balance'); ?></label>
                                    <input  autocomplete="off" type="text" id="c_op_balance" name="opening_balance"
                                        class="form-control integerchk" placeholder="<?php echo lang('opening_balance'); ?>" value="<?php echo set_value('opening_balance'); ?>">
                                </div>
                                <div class="form-group w-100">
                                    <label>&nbsp;</label>
                                    <select class="form-control select2" name="opening_balance_type" id="c_op_balance_type">
                                        <option value="Debit" <?php echo set_select('opening_balance_type', "Debit"); ?>><?php echo lang('debit');?></option>
                                        <option value="Credit" <?php echo set_select('opening_balance_type', "Credit"); ?>><?php echo lang('credit');?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label><?php echo lang('credit_limit'); ?></label>
                                <input  autocomplete="off" type="text" id="c_credit_limit" name="credit_limit"
                                    class="form-control integerchk" placeholder="<?php echo lang('credit_limit'); ?>" value="<?php echo set_value('credit_limit'); ?>">
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label><?php echo lang('default_discount'); ?></label>
                                <input  autocomplete="off" type="text" id="c_discount" name="discount"
                                    class="form-control integerchkPercent" placeholder="<?php echo lang('discount_type'); ?>" value="<?php echo set_value('discount'); ?>">
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label><?php echo lang('price_type'); ?></label>
                                <select class="form-control select2" name="price_type" id="c_price_type" >
                                    <option <?php echo set_select('price_type', 1)?> value="1"><?php echo lang('retail'); ?></option>
                                    <option <?php echo set_select('price_type', 2)?> value="2"><?php echo lang('wholesale'); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label><?php echo lang('group'); ?></label>
                                <select  class="form-control  select2 op_width_100_p" id="c_group_id" name="group_id">
                                    <option value=""><?php echo lang('select'); ?></option>
                                    <?php
                                    foreach ($groups as $splrs) {
                                        ?>
                                    <option value="<?php echo escape_output($splrs->id) ?>"
                                        <?php echo set_select('group_id', $splrs->id); ?>><?php echo escape_output($splrs->group_name) ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label><?php echo lang('address'); ?></label>
                                <textarea  name="address" class="form-control"  id="c_address"
                                    placeholder="<?php echo lang('address'); ?>"><?php echo set_value('address'); ?></textarea>
                            </div>
                        </div>
                        <?php if(collectGST()=="Yes"){?>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label> <?php echo lang('same_or_diff_state'); ?></label>
                                <select  class="form-control select2"  name="same_or_diff_state"
                                        id="c_same_or_diff_state">
                                    <option value=""><?php echo lang('select'); ?></option>
                                    <option <?php echo set_select('same_or_diff_state',1)?> value="1"><?php echo lang('same_state'); ?></option>
                                    <option <?php echo set_select('same_or_diff_state',2)?> value="2"><?php echo lang('different_state'); ?></option>
                                </select>
                            </div>
                            <?php if (form_error('same_or_diff_state')) { ?>
                                <div class="callout callout-danger my-2">
                                    <?php echo form_error('same_or_diff_state'); ?>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label><?php echo lang('gst_number'); ?></label>
                                <input  autocomplete="off" type="text" name="gst_number" id="c_gst_no" class="form-control"
                                    placeholder="<?php echo lang('gst_number'); ?>"
                                    value="<?php echo set_value('gst_number'); ?>">
                            </div>
                            <?php if (form_error('gst_number')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('gst_number'); ?></span>
                            </div>
                            <?php } ?>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-blue-btn" id="addCustomer">  <?php echo lang('submit'); ?></button>
                    <button type="button" class="btn bg-blue-btn"  data-bs-dismiss="modal"><?php echo lang('close'); ?></button>
                </div>
            </form>

        </div>
    </div>
</div>


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
                    <div class="form-group mb-3">
                        <label class="col-sm-4 control-label"><?php echo lang('quantity_amount'); ?><span
                                class="op_color_red"> *</span></label>
                        <div class="input-group">
                            <input type="number" autocomplete="off" min="1" class="form-control integerchk1"
                                onfocus="select();" name="qty_modal" id="qty_modal"
                                placeholder="<?php echo lang('quantity_amount'); ?>" value="" aria-describedby="basic-addon">
                            <span class="modal_item_unit input-group-text new-btn" id="basic-addon"></span>
                        </div>
                        <input type="hidden" id="hidden_input_item_type">
                        <input type="hidden" id="hidden_input_item_id">
                        <input type="hidden" id="hidden_input_item_name">
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
