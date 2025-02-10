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


<input type="hidden" id="imei" value="<?php echo lang('imei_number');?>">
<input type="hidden" id="serial" value="<?php echo lang('serial_number');?>">
<input type="hidden" id="expiry_date_ln" value="<?php echo lang('expiry_date');?>">

<input type="hidden" id="add_edit_mode" value="edit_mode">




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
                <h2 class="top-left-header"><?php echo lang('edit_purchase_return'); ?> </h2>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('purchase_return'), 'secondSection'=> lang('edit_purchase_return')])?>
        </div>
    </section>


    <div class="box-wrapper">
        <div class="table-box">
            <?php echo form_open(base_url().'Purchase_return/addEditPurchaseReturn/'. $encrypted_id, $arrayName = array('id' => 'purchase_return_form')); ?> 
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('ref_no'); ?></label>
                            <input  autocomplete="off" type="text" id="reference_no" readonly
                                name="reference_no" class="form-control" placeholder="<?php echo lang('ref_no'); ?>"
                                value="<?php echo escape_output($purchase_return->reference_no); ?>">
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
                                    <option value="<?php echo escape_output($value->id) ?>" <?php echo escape_output($purchase_return->supplier_id) == $value->id ? 'selected' : ''?>><?php echo escape_output($value->name) ?></option>
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
                            <select  class="form-control  select2 op_width_100_p" name="status" id="status">
                                <option value=""><?php echo lang('select'); ?></option>
                                <option value="draft" <?= $purchase_return->return_status == 'draft' ? 'selected' : '' ?>><?php echo lang('draft');?></option>
                                <option value="taken_by_sup_pro_not_returned" <?= $purchase_return->return_status == 'taken_by_sup_pro_not_returned' ? 'selected' : '' ?>><?php echo lang('taken_by_sup_pro_not_returned');?></option>
                                <option value="taken_by_sup_money_returned" <?= $purchase_return->return_status == 'taken_by_sup_money_returned' ? 'selected' : '' ?>><?php echo lang('taken_by_sup_money_returned');?></option>
                                <option value="taken_by_sup_pro_returned" <?= $purchase_return->return_status == 'taken_by_sup_pro_returned' ? 'selected' : '' ?>><?php echo lang('taken_by_sup_pro_returned');?></option>
                            </select>
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
                            <input  autocomplete="off" type="text"   name="date" readonly class="form-control customDatepicker" placeholder="<?php echo lang('date'); ?>" value="<?php echo escape_output($purchase_return->date); ?>">
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
                            <input  autocomplete="off" type="text"  name="purchase_date" readonly class="form-control customDatepicker" placeholder="<?php echo lang('purchase_date'); ?>" value="<?php echo escape_output($purchase_return->purchase_date); ?>">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('pur_ref_no'); ?></label>
                            <input  autocomplete="off" type="text" id="pur_ref_no"
                                name="pur_ref_no" class="form-control" placeholder="<?php echo lang('pur_ref_no'); ?>" value="<?php echo escape_output($purchase_return->pur_ref_no); ?>">
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
                                    <?php echo escape_output($string); ?>
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
                                <?php
                                    $i = 0;
                                    $grand_total = 0;
                                    if ($purchase_return_items && !empty($purchase_return_items)) {
                                        foreach ($purchase_return_items as $item) {
                                            $i++;
                                            $readonly = '';
                                            $p_type = '';
                                            $date_picker = '';
                                            $d_none = '';
                                            $p_placeholder = '';
                                            $validation_cls = '';
                                            $checkIMEISerialUnique = '';
                                            $expiryDateExistCheck = '';
                                            $return_unique_match = '';
                                            $readonly_expiry = '';

                                            if($item->item_type == 'General_Product' || $item->item_type == 0 || ($item->item_type == 'Medicine_Product' && $item->expiry_date_maintain == 'No') ){
                                                $d_none = 'd-none';
                                            }else if($item->item_type == 'Variation_Product'){
                                                $d_none = 'd-none';
                                            }else if($item->item_type == 'Installment_Product'){
                                                $d_none = 'd-none';
                                            }else if ($item->item_type == 'Medicine_Product' && $item->expiry_date_maintain == 'Yes'){
                                                $p_type = 'Return Expiry Date';
                                                $p_placeholder = '';
                                                $date_picker = 'customDatepicker'; 
                                                $validation_cls = 'countID2';
                                                $expiryDateExistCheck = 'expiryDateExistCheck';
                                                $readonly_expiry = 'readonly';
                                            }else if($item->item_type == 'IMEI_Product'){
                                                $p_type = 'Return IMEI';
                                                $p_placeholder = lang('enter_imei_number');
                                                $readonly = 'readonly';
                                                $validation_cls = 'countID2';
                                                $checkIMEISerialUnique = 'checkIMEISerialUnique';
                                                $return_unique_match = 'return_unique_match';
                                            }else if($item->item_type == 'Serial_Product'){
                                                $p_type = 'Return Serial';
                                                $p_placeholder = lang('enter_serial_number');
                                                $readonly = 'readonly';
                                                $validation_cls = 'countID2';
                                                $checkIMEISerialUnique = 'checkIMEISerialUnique';
                                                $return_unique_match = 'return_unique_match';

                                            }
                                            $imeiSerial = '';
                                            if($purchase_return->return_status == 'taken_by_sup_pro_returned'  && $item->expiry_date_maintain == 'Yes'){
                                                $imeiSerial = '<div class="d-flex align-items-center form-group mt-2">
                                                    <small class="pe-1">'.$p_type.'</small>
                                                    <input item-type="'.$item->item_type.'" '.$readonly.' data-countid="'.$i.'" type="text" autocomplete="off" id="rSerial_'.$i.'" name="expiry_imei_serial_in[]" onfocus="this.select();" class="'.$date_picker.' '.$return_unique_match.' '. $d_none .'  form-control '.$validation_cls.'" value="'.$item->expiry_imei_serial_in.'" >
                                                </div>
                                                <p class="imei-serial-err return-imei-serial-err-unique-'.$i.'"></p>';
                                            }else{
                                                $imeiSerial = '<div class="d-flex align-items-center form-group mt-2">
                                                    <small class="pe-1"></small>
                                                    <input data-countid="'.$i.'" type="hidden" autocomplete="off" id="rSerial_'.$i.'" name="expiry_imei_serial_in[]" onfocus="this.select();" class="'. $d_none .'  form-control" value="" >
                                                </div>';
                                            }

                                            echo '<tr class="rowCount" row-counter="'.$i.'" data-item-id="'.$item->item_id.'">
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <p id="sl_' . $i .'">' . $i . '</p>
                                                        <input type="hidden" id="item_id_'.$i.'" name="item_id[]" value="' . $item->item_id . '">
                                                        <input type="hidden" name="item_type[]" value="' . $item->item_type . '">
                                                        <input type="hidden" name="conversion_rate[]" value="' . ($item->conversion_rate) . '">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <span>' . getItemNameCodeBrandByItemId($item->item_id) .'</span>
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <textarea class="form-control h-50" id="return_note_'.$i.'" name="return_note[]" placeholder="'.lang('Return_Note').'">'.$item->return_note.'</textarea>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center form-group">
                                                        <small class="pe-1">'.$p_type.'</small>
                                                        <input '.$readonly_expiry.' item-type="'.$item->item_type.'" '.$readonly.' data-countid="'.$i.'" type="text" autocomplete="off" id="serial_'.$i.'" name="expiry_imei_serial[]" onfocus="this.select();" class="'.$checkIMEISerialUnique.' '.$expiryDateExistCheck.' '. $d_none .'  form-control '.$validation_cls.'" value="'.$item->expiry_imei_serial.'" >
                                                    </div>
                                                    <p class="imei-serial-err imei-serial-err-unique-'.$i.'"></p>
                                                    '. $imeiSerial .'
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <input '.$readonly.' type="text" data-countid="'.$i.'" autocomplete="off" id="quantity_'.$i.'" name="quantity[]" onfocus="this.select();" class="form-control integerchk countID calculate_op quantity" value="'.$item->return_quantity_amount.'"  placeholder="'.lang('quantity').'" aria-describedby="basic-addon2">
                                                        <span class="input-group-text" id="basic-addon2">'. ($item->sale_unit_name) .'</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="d-flex align-items-center">
                                                            <input data-countid="'.$i.'" type="text" autocomplete="off" unit_price="'.$item->unit_price.'" id="unit_price_'.$i.'" name="unit_price[]" onfocus="this.select();" class="form-control integerchk calculate_op unit_price" placeholder="'.lang('unit_price').'" value="'.getAmtPre($item->unit_price).'">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="d-flex align-items-center">
                                                            <input type="text" autocomplete="off" id="total_'.$i.'" name="total[]" class="form-control" value="'.getAmtPre($item->return_quantity_amount * $item->unit_price).'" readonly />
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="button" class="new-btn-danger row_delete h-40" data-suffix="" data-item_id="">
                                                        <iconify-icon icon="solar:trash-bin-minimalistic-broken" width="18"></iconify-icon>
                                                    </button>
                                                </td>
                                            </tr>';
                                            $total_count = $item->return_quantity_amount * $item->unit_price;
                                            $grand_total += $total_count;
                                        }
                                    }
                                ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="row justify-content-end">
                            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                                <div class="form-group mt-4 mb-3">
                                    <label><?php echo lang('g_total'); ?> <span class="required_star">*</span></label>
                                    <input class="form-control integerchk1" readonly type="text" name="total_return_amount" id="grand_total"
                                    <?php echo set_value('grand_total'); ?> value="<?php echo getAmtPre($grand_total); ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-end">
                            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3 account_wrap <?php echo escape_output($purchase_return->return_status) === 'taken_by_sup_money_returned' ? '' : 'd-none' ?>" >
                                <div class="form-group mb-3">
                                    <label><?php echo lang('payment_methods'); ?> <span
                                            class="required_star"></span></label>
                                    <select  class="form-control select2 op_width_100_p" id="payment_method_id"
                                        name="payment_method_id">
                                        <option value=""><?php echo lang('select'); ?></option>
                                        <?php foreach ($paymentMethods as $ec) { ?>
                                        <option value="<?php echo escape_output($ec->id) ?>"
                                            <?php echo set_select('payment_method_id', $ec->id); ?> <?php echo escape_output($purchase_return->payment_method_id) == $ec->id ? 'selected' : '' ?> data-type="<?php echo escape_output($ec->account_type); ?>"><?php echo escape_output($ec->name) ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                    <input type="hidden" id="account_type" name="account_type" value="<?php echo escape_output($purchase_return->account_type);?>">
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
                                <?php
                                $payment_method_type = $purchase_return->payment_method_type;
                                if($payment_method_type != ''){
                                $payment_m_type = json_decode($purchase_return->payment_method_type, TRUE);
                                foreach($payment_m_type as $key=>$p_type){ ?>
                                    <div class="form-group mb-2">
                                        <label><?php echo lang(escape_output($key));?></label>
                                        <input type="text" name="<?php echo escape_output($key);?>" class="form-control" placeholder="" value="<?php echo escape_output($p_type);?>">
                                    </div>
                                <?php } } ?>
                                </div>

                            </div>
                        </div>

                        <div class="row justify-content-end">
                            <div class="col-12">
                                <div class="form-group">
                                    <label><?php echo lang('note'); ?></label>
                                    <textarea  class="form-control" name="note" placeholder="<?php echo lang('note'); ?> ..."><?= escape_output($purchase_return->note) ?></textarea>
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
    </div>
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
