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
<input type="hidden" id="Payment_Method_Exist" value="<?php echo lang('This_Payment_Method_Already_Exist');?>">
<input type="hidden" id="current_due" value="<?php echo lang('current_due');?>">
<input type="hidden" id="ok" value="<?php echo lang('ok');?>">
<input type="hidden" id="add_mode" value="Edit">
<input type="hidden" id="name_field_required" value="<?php echo lang('name_field_required');?>">
<input type="hidden" id="The_Contact_field_required" value="<?php echo lang('The_Contact_field_required');?>">
<input type="hidden" id="The_Phone_field_is_required" value="<?php echo lang('The_Phone_field_is_required');?>">

<script src="<?php echo base_url(); ?>frequent_changing/js/add_purchase.js"></script>
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
                <h3 class="top-left-header mt-2"><?php echo lang('edit_purchase'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('purchase'), 'secondSection'=> lang('edit_purchase')])?>
        </div>
    </section>

    <div class="box-wrapper">
        <div class="table-box">
            <?php echo form_open_multipart(base_url() . 'Purchase/addEditPurchase/' . $encrypted_id, $arrayName = array('id' => 'purchase_form')) ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6 col-lg-4 mb-3"> 
                        <div class="form-group">
                            <label><?php echo lang('ref_no'); ?></label>
                            <input  autocomplete="off" type="text" id="reference_no" readonly name="reference_no" class="form-control" placeholder="<?php echo lang('ref_no'); ?>" value="<?php echo escape_output($purchase_details->reference_no); ?>">
                        </div>
                        <?php if (form_error('reference_no')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('reference_no'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3"> 
                        <div class="form-group"> 
                            <label><?php echo lang('supplier'); ?> <span class="required_star">*</span> </label>
                            <div class="d-flex">
                                <select  class="form-control select2 op_width_100_p" id="supplier_id" name="supplier_id">
                                    <option value=""><?php echo lang('select'); ?></option>
                                        <?php
                                        foreach ($suppliers as $splrs) {
                                            ?>
                                            <option value="<?php echo escape_output($splrs->id) ?>"
                                            <?php
                                            if ($purchase_details->supplier_id == $splrs->id) {
                                                echo "selected";
                                            }
                                            ?>><?php echo escape_output($splrs->name) ?></option>
                                        <?php } ?>
                                </select>
                                <button type="button" class="new-btn ms-1 add_supplier_by_ajax bg-blue-btn-p-14">
                                <iconify-icon icon="solar:add-circle-broken" width="22"></iconify-icon>
                                </button>
                            </div>
                            <div class="alert alert-info" id="remaining_balance"></div>

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
                    <div class="col-md-6 col-lg-4 mb-3"> 
                        <div class="form-group">
                            <label><?php echo lang('date'); ?> <span class="required_star">*</span></label>
                            <input  autocomplete="off" type="text"  name="date" readonly class="form-control customDatepicker" placeholder="<?php echo lang('date'); ?>" value="<?php echo $purchase_details->date; ?>">
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
                            <label><?php echo lang('supplier_invoice_no'); ?></label>
                            <input  autocomplete="off" type="text" id="invoice_no"  name="invoice_no" class="form-control" placeholder="<?php echo lang('invoice_no'); ?>" value="<?php echo escape_output($purchase_details->invoice_no); ?>">
                        </div>
                        <?php if (form_error('invoice_no')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('invoice_no'); ?></span>
                            </div>
                        <?php } ?>
                    
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group"> 
                            <label><?php echo lang('items'); ?> <span class="required_star">*</span></label>
                            <select  class="form-control select2 select2-hidden-accessible op_width_100_p" name="item_id" id="item_id">
                                <option value=""><?php echo lang('select'); ?></option>
                                <?php foreach ($items as $value) { 
                                $string = ($value->parent_name != '' ? $value->parent_name . ' - ' : '') . ($value->name) . ($value->brand_name != '' ? ' - ' . $value->brand_name : '') . ( ' - ' . $value->code);      
                                ?>
                                    <option value="<?php echo escape_output($value->id) . "|" . $string ."|" . $value->purchase_unit . "|" . $value->purchase_price. "|" . $value->conversion_rate . "|" .  $value->type . "|" .  $value->expiry_date_maintain ?>">
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
                    <div class="col-md-6 col-lg-4">
                        <div class="hidden-xs hidden-sm">&nbsp;</div>
                        <div class="d-flex">
                            <button data-tippy-content="<?php echo lang('item_sync_notification'); ?>" type="button" class="new-btn mt-1 h-40 me-2" id="sync_items">
                                <iconify-icon icon="solar:refresh-circle-broken" width="22"></iconify-icon>
                            </button>
                        </div>
                    </div>
                    <div class="hidden-lg hidden-sm">&nbsp;</div>
                </div> 
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive" id="purchase_cart">          
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="w-5"><?php echo lang('sn'); ?></th>
                                        <th class="w-20"><?php echo lang('item'); ?>-<?php echo lang('brand'); ?>-<?php echo lang('code'); ?></th>
                                        <th class="w-25"><?php echo lang('expiry_date_IME_Serial'); ?></th>
                                        <th class="w-15"><?php echo lang('quantity_amount'); ?></th>
                                        <th class="w-15"><?php echo lang('unit_price'); ?></th>
                                        <th class="w-15"><?php echo lang('total'); ?></th>
                                        <th class="w-5"><?php echo lang('actions'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    if ($purchase_items && !empty($purchase_items)) {
                                        foreach ($purchase_items as $pi) {
                                            $i++;
                                            $readonly = '';
                                            $p_type = '';
                                            $date_picker = '';
                                            $d_none = '';
                                            $p_placeholder = '';
                                            $validation_cls = '';
                                            $checkIMEISerialUnique = '';
                                            

                                            if($pi->item_type == 'General_Product' || $pi->item_type == 0 || ($pi->item_type == 'Medicine_Product' && $pi->expiry_date_maintain == 'No')){
                                                $d_none = 'd-none';
                                            }else if($pi->item_type == 'Variation_Product'){
                                                $d_none = 'd-none';
                                            }else if($pi->item_type == 'Installment_Product'){
                                                $d_none = 'd-none';
                                            }else if ($pi->item_type == 'Medicine_Product' && $pi->expiry_date_maintain == 'Yes'){
                                                $p_type = 'Expiry Date:';
                                                $p_placeholder = '';
                                                $date_picker = 'customDatepicker'; 
                                                $validation_cls = 'countID2';
                                            }else if($pi->item_type == 'IMEI_Product'){
                                                $p_type = 'IMEI:';
                                                $p_placeholder = lang('enter_imei_number');
                                                $readonly = 'readonly';
                                                $validation_cls = 'countID2';
                                                $checkIMEISerialUnique = 'checkIMEISerialUnique';
                                            }else if($pi->item_type == 'Serial_Product'){
                                                $p_type = 'Serial:';
                                                $p_placeholder = lang('enter_serial_number');
                                                $readonly = 'readonly';
                                                $validation_cls = 'countID2';
                                                $checkIMEISerialUnique = 'checkIMEISerialUnique';
                                            }

                                            echo '<tr class="rowCount"  data-counter="' . $i .'" data-item-id="'.$pi->item_id.'">
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <p id="sl_' . $i .'">' . $i . '</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <span>' . getItemNameCodeBrandByItemId($pi->item_id).'</span>
                                                    </div>
                                                    <input type="hidden" name="item_id[]" value="' . $pi->item_id . '">
                                                    <input type="hidden" name="item_type[]" value="' . $pi->item_type . '">
                                                    <input type="hidden" name="conversion_rate[]" value="' . ($pi->conversion_rate) . '">
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center form-group">
                                                        <small class="pe-1">' . $p_type . '</small>
                                                        <input '.$readonly.' data-type="'.$pi->item_type.'" data-countid="'.$i.'" type="text" autocomplete="off" id="serial_' . $i . '" name="expiry_imei_serial[]" class="'.$checkIMEISerialUnique.'  '.$validation_cls.'  '. $d_none .' form-control ' . $date_picker . '" placeholder="'.$p_placeholder.'" value="' . $pi->expiry_imei_serial . '" >
                                                        <p class="imei-serial-err imei-serial-err-unique-'.$i.'"></p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <input '. $readonly .'  type="text" autocomplete="off" data-countid="'.$i.'" id="quantity_amount_' . $i .'" name="quantity_amount[]" onfocus="this.select();" class="form-control integerchk1 countID calculate_op qty_count" placeholder="'.lang('qty').'" value="' . $pi->quantity_amount . '" aria-describedby="basic-addon2">
                                                        <span class="input-group-text" id="basic-addon2">' . $pi->purchase_unit_name . '</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="d-flex align-items-center">
                                                            <input type="text" autocomplete="off" id="unit_price_' . $i .'" name="unit_price[]" data-countid="'.$i.'" onfocus="this.select();" class="form-control integerchk1 calculate_op countID" placeholder="'. lang('unit_price') .'" value="' . getAmtPre($pi->unit_price) . '">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="d-flex align-items-center">
                                                            <input type="text" autocomplete="off" id="total_' . $i .'" name="total[]" class="form-control" placeholder="'.lang('total').'" value="' . getAmtPre($pi->total) . '" readonly>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="new-btn-danger deleter_op h-40" data-suffix="' . $i .'" data-item_id="'.$pi->item_id.'">
                                                    <iconify-icon icon="solar:trash-bin-minimalistic-broken" width="18"></iconify-icon>
                                                </button>
                                            </td>
                                        </tr>';
                                        }
                                    }
                                    ?>
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
                            <label><?php echo lang('discount'); ?>  (<?php echo lang('flat_or_percentage'); ?>)</label>
                            <input  class="form-control discount" type="text"  onfocus="select()" name="discount" id="discount" value="<?php echo escape_output($purchase_details->discount); ?>" placeholder="<?php echo lang('discount_type');?>">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                        <div class="form-group mt-3">
                            <label><?php echo lang('other'); ?></label>
                            <input  autocomplete="off" class="form-control integerchk1 calculate_op" type="text" name="other" id="other" onfocus="this.select();" value="<?php echo escape_output(getAmtPre($purchase_details->other)); ?>"  placeholder="<?php echo lang('other');?>">
                        </div>
                        <?php if (form_error('other')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('other'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                        <div class="form-group mt-3">
                            <label><?php echo lang('g_total'); ?> <span class="required_star">*</span></label>
                            <input  class="form-control integerchk1" readonly type="text" name="grand_total" id="grand_total" value="<?php echo escape_output(getAmtPre($purchase_details->grand_total)); ?>"  placeholder="<?php echo lang('grand_total');?>">
                        </div>
                    </div>
                </div>


                <div class="row justify-content-end">
                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                        <div class="form-group mt-3 mb-2">
                            <label><?php echo lang('payment_methods'); ?> <span class="required_star"></span></label>
                            <select  class="form-control select2 op_width_100_p" id="payment_method_id" name="payment_method_id">
                                <option value=""><?php echo lang('select'); ?></option>
                                <?php foreach ($paymentMethods as $ec) { ?>
                                    <option data-type="<?php echo escape_output($ec->name) ?>" value="<?php echo escape_output($ec->id) ?>"><?php echo escape_output($ec->name) ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <table class="table">
                            <tbody id="payment_received_type">
                                <?php foreach($multi_pay_method as $p_paythod){?>
                                <tr payment_id="<?php echo escape_output($p_paythod->payment_id) ?>" class="multi_pay_row">
                                    <td>
                                        <div class="input-group">
                                            <span class="input-group-text bg-template-c-white"><?php echo escape_output($p_paythod->payment_method_name); ?></span>
                                            <input type="hidden" value="<?php echo escape_output($p_paythod->payment_id) ?>" name="payment_id[]">
                                            <input type="text" class="integerchk form-control multi_payment_<?php echo escape_output($p_paythod->payment_id) ?> calculate_op" name="payment_value[]" value="<?php echo escape_output($p_paythod->amount) ?>">
                                            <span class="del_payment del_trigger input-group-text cursor-pointer new-btn-danger">
                                                <iconify-icon icon="solar:trash-bin-minimalistic-broken" width="18"></iconify-icon>
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <?php if (form_error('payment_method_id')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('payment_method_id'); ?></span>
                            </div>
                        <?php } ?>
                        <div class="alert alert-error error-msg payment_method_id_err_msg_contnr ">
                            <p id="payment_method_id_err_msg"></p>
                        </div>
                    </div>
                </div> 

                <div class="row justify-content-end">
                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                        <div class="form-group mt-3">
                            <label><?php echo lang('paid'); ?> <span class="required_star"></span></label>
                            <input  autocomplete="off" class="form-control integerchk1 calculate_op" type="text" name="paid" id="paid" onfocus="this.select();" value="<?php echo escape_output(getAmtPre($purchase_details->paid)); ?>"  placeholder="<?php echo lang('paid');?>" readonly>
                        </div>
                        <?php if (form_error('paid')) { ?>
                        <div class="callout callout-danger my-2">
                            <span class="error_paragraph"><?php echo form_error('paid'); ?></span>
                        </div>
                        <?php } ?>
                        <div class="alert alert-error error-msg paid_err_msg_contnr ">
                            <p id="paid_err_msg"></p>
                        </div>
                    </div>
                </div>
                
                <div class="row justify-content-end">
                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                        <div class="form-group mt-3">
                            <label><?php echo lang('due'); ?></label>
                            <input  class="form-control integerchk1 op_width_100_p" type="text" name="due" id="due" readonly value="<?php echo escape_output(getAmtPre($purchase_details->due_amount)); ?>"  placeholder="<?php echo lang('due');?>">
                        </div>
                    </div>
                </div>
                <div class="row justify-content-end">
                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                        <div class="form-group mt-3">
                            <label><?php echo lang('attachment'); ?></label>
                            <div class="d-flex align-items-center">
                                <input  class="form-control integerchk1 op_width_100_p m-0" type="file" name="attachment" id="attachment">
                                <button type="button" class="new-btn h-40 ms-1 show_attachment_trigger bg-blue-btn-p-14">
                                    <iconify-icon icon="solar:eye-bold-duotone" width="18"></iconify-icon>
                                </button>
                            </div>
                        </div>
                        <?php if (form_error('attachment')) { ?>
                        <div class="callout callout-danger my-2">
                            <span class="error_paragraph"><?php echo form_error('attachment'); ?></span>
                        </div>
                        <?php } ?>
                        <input type="hidden" name="attachment_p" value="<?php echo escape_output($purchase_details->attachment) ?>">
                    </div>
                </div>

                <div class="row justify-content-end">
                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3 mt-3">
                        <div class="form-group">
                            <div class="d-flex">
                                <label><?php echo lang('note');?></label>
                                <input type="hidden" name="note" id="note_hidden" value="<?php echo escape_output($purchase_details->note) ?>">
                                <i class="ps-2 fas fa-pen-nib font-a-i noteModalTrigger cursor-pointer new-icon-p-color"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <input  class="form-control" type="hidden" name="subtotal" id="subtotal">
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
                <a class="btn bg-blue-btn text-decoration-none" href="<?php echo base_url() ?>Purchase/purchases">
                    <iconify-icon icon="solar:undo-left-round-broken"></iconify-icon>
                    <?php echo lang('back'); ?>
                </a>
            </div>
            <?php echo form_close(); ?> 
        </div> 
    </div>
</div>

<!-- Cart Previw -->
<div class="modal fade" id="cartPreviewModal"  role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title item_header">&nbsp;</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true"><i data-feather="x"></i></span></button>
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
                        <div class="input-group">
                            <input type="number" autocomplete="off" min="1" class="form-control integerchk1"
                            onfocus="select();" name="qty_modal" id="qty_modal"
                            placeholder="<?php echo lang('quantity_amount'); ?>" value="" aria-describedby="basic-addon">
                            <span class="ps-1 modal_item_unit input-group-text" id="basic-addon"></span>
                        </div>
                        <input type="hidden" id="hidden_input_item_type">
                        <input type="hidden" id="hidden_input_item_id">
                        <input type="hidden" id="hidden_input_item_name">
                        <input type="hidden" id="hidden_input_expiry_date_maintain">
                    </div>
                    <div class="form-group mt-3 imei_p_f">
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

<!-- suppliers modal -->
<div class="modal fade" id="addSupplierModal"  role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">
                    <?php echo lang('add_supplier'); ?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i
                            data-feather="x">×</i></span></button>
                
            </div>
            <div class="modal-body scroll_body">
                <form id="add_supplier_form">
                    <div class="row">
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group mb-3">
                                <label class="control-label"><?php echo lang('supplier_name'); ?><span class="op_color_red"> *</span></label>
                                <input type="text" autocomplete="off" class="form-control" name="name" id="name_supplier"
                                    placeholder="<?php echo lang('supplier_name'); ?>" value="">
                                <div class="alert alert-error error-msg name_err_msg_contnr ">
                                    <p class="name_err_msg"></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group mb-3">
                                <label class="control-label"><?php echo lang('contact_person'); ?><span class="op_color_red"> *</span></label>
                                <input autocomplete="off" type="text" id="contact_person" name="contact_person"
                                    class="form-control" placeholder="<?php echo lang('contact_person'); ?>"
                                    value="<?php echo set_value('contact_person'); ?>">
                                <div class="alert alert-error error-msg contact_person_err_msg_contnr ">
                                    <p class="contact_person_err_msg"></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group mb-3">
                                <label class="control-label"><?php echo lang('phone'); ?><span class="op_color_red">
                                        *</span></label>
                                <input autocomplete="off" type="text" id="phone" name="phone" class="form-control"
                                    placeholder="<?php echo lang('phone'); ?>" value="<?php echo set_value('phone'); ?>">
                                <div class="alert alert-error error-msg phone_err_msg_contnr ">
                                    <p class="phone_err_msg"></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group mb-3">
                                <label class="control-label"><?php echo lang('email'); ?></label>
                                <input autocomplete="off" type="text" id="email" name="email" class="form-control"
                                    placeholder="<?php echo lang('email'); ?>" value="<?php echo set_value('email'); ?>">
                                <div class="alert alert-error error-msg email_err_msg_contnr ">
                                    <p class="email_err_msg"></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group">
                                <label>
                                    <?php echo lang('opening_balance'); ?>
                                </label>
                                <div class="d-flex align-items-center">
                                    <div class="op_webkit_fill_available"> 
                                        <div class="d-flex">
                                            <input  autocomplete="off" type="text"
                                                    name="opening_balance" class="form-control mr_3 integerchk"
                                                    placeholder="<?php echo lang('opening_balance'); ?>"
                                                    value="<?php echo set_value('opening_balance'); ?>">
                                                <select name="opening_balance_type" id="opening_balance_type" class="form-control select2">
                                                <option value="Debit" <?php echo set_select('opening_balance_type', 'Debit'); ?>><?php echo lang('debit');?></option>
                                                <option value="Credit" <?php echo set_select('opening_balance_type', 'Credit'); ?>><?php echo lang('credit');?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if (form_error('opening_balance')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('opening_balance'); ?></span>
                            </div>
                            <?php } ?>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group mb-3">
                                <label><?php echo lang('description'); ?></label>
                                <input  class="form-control" name="description" id="supplier_description"
                                    placeholder="<?php echo lang('description'); ?> ..." value="<?php echo $this->input->post('description'); ?>">
                            </div>
                            <?php if (form_error('description')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('description'); ?></span>
                            </div>
                            <?php } ?>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group mb-3">
                                <label><?php echo lang('address'); ?></label>
                                <textarea  class="form-control" name="address" id="supplier_address"
                                    placeholder="<?php echo lang('address'); ?>"><?php echo $this->input->post('address'); ?></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-blue-btn" id="addSupplier">  <?php echo lang('submit'); ?></button>
                <button type="button" class="btn bg-blue-btn"  data-bs-dismiss="modal"><?php echo lang('close'); ?></button>
            </div>
        </div>
    </div>
</div>
<!-- suppliers modal end -->


<!-- Show Image Modal -->
<div class="modal fade" id="show_attachment" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title">
                <?php echo lang('view_attachment'); ?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i
                data-feather="x"></i></span></button>
            </div>
            <div class="modal-body">
                <?php
                $extension = pathinfo($purchase_details->attachment, PATHINFO_EXTENSION);
                ?>
                <?php if($extension == 'pdf'){?>
                <div class="text-center">
                    <iframe src="<?php echo base_url();?>uploads/purchase-attachment/<?php echo escape_output($purchase_details->attachment); ?>" title="" width="100%" height="500"></iframe>
                </div>
                <?php }else if($purchase_details->attachment){?>
                <div class="text-center">
                    <img src="<?php echo base_url();?>uploads/purchase-attachment/<?php echo escape_output($purchase_details->attachment) ?>" alt="" width="300" height="300">
                </div>
                <?php } ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-blue-btn" data-bs-dismiss="modal"><?php echo lang('close'); ?></button>
            </div>
        </div>
    </div>
</div>


<!-- Notice Modal -->
<div class="modal fade" id="noteModal"  role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo lang('note'); ?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                        <i data-feather="x"></i>
                    </span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label><?php echo lang('note');?></label>
                    <textarea  class="form-control" rows="5" id="note_modal" 
                        placeholder="<?php echo lang('note');?>"><?php echo escape_output($purchase_details->note) ?></textarea>
                </div>
                <div class="alert alert-error error-msg note_err_msg_contnr ">
                    <p id="note_err_msg"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-blue-btn" id="noteSubmit">  <?php echo lang('submit'); ?></button>
                <button type="button" class="btn bg-blue-btn"  data-bs-dismiss="modal"><?php echo lang('close'); ?></button>
            </div>
        </div>
    </div>
</div>
