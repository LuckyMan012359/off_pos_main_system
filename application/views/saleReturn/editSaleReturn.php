<input type="hidden" id="date_required" value="<?php echo lang('date_required');?>">
<input type="hidden" id="customer_id_required" value="<?php echo lang('customer_id_required');?>">
<input type="hidden" id="account_field_required" value="<?php echo lang('account_field_required');?>">
<input type="hidden" id="sale_invoice_no_required" value="<?php echo lang('sale_invoice_no_required');?>">
<input type="hidden" id="item_id_required" value="<?php echo lang('item_id_required');?>">
<input type="hidden" id="sale_quantity_amount_required" value="<?php echo lang('sale_quantity_amount_required');?>">
<input type="hidden" id="return_quantity_amount_required" value="<?php echo lang('return_quantity_amount_required');?>">
<input type="hidden" id="unit_price_in_sale_required" value="<?php echo lang('unit_price_in_sale_required');?>">
<input type="hidden" id="unit_price_in_return_required" value="<?php echo lang('unit_price_in_return_required');?>">
<input type="hidden" id="return_quantity_amount_alert" value="<?php echo lang('return_quantity_amount_alert');?>">
<input type="hidden" id="return_price_alert" value="<?php echo lang('return_price_alert');?>">
<input type="hidden" id="Return_Note" value="<?php echo lang('Return_Note');?>">
<input type="hidden" id="return_quantity_alert" value="<?php echo lang('return_quantity_alert');?>">
<input type="hidden" id="ok" value="<?php echo lang('ok');?>">
<input type="hidden" id="sale_qty" value="<?php echo lang('sale_qty');?>">
<input type="hidden" id="return_qty" value="<?php echo lang('return_qty');?>">
<input type="hidden" id="return_unit_price" value="<?php echo lang('return_unit_price');?>">
<input type="hidden" id="sale_unit_price" value="<?php echo lang('sale_unit_price');?>">
<input type="hidden" id="is_edit" value="Yes">
<input type="hidden" id="old_slae_id" value="<?php echo $sale_return_details->sale_id ?>">


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
                <h2 class="top-left-header"><?php echo lang('edit_sale_return'); ?> </h2>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('sale_return'), 'secondSection'=> lang('edit_sale_return')])?>
        </div>
    </section>


    <!-- Main content -->
    <section class="box-wrapper">
    <h3 class="display_none">&nbsp;</h3>
        <div class="table-box">
            <?php echo form_open(base_url().'Sale_return/addEditSaleReturn/' . $encrypted_id, $arrayName = array('id' => 'sale_return_form')); ?> 
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('ref_no'); ?></label>
                            <input  autocomplete="off" type="text" id="reference_no" readonly
                                name="reference_no" class="form-control" placeholder="<?php echo lang('ref_no'); ?>"
                                value="<?php echo escape_output($sale_return_details->reference_no); ?>">
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
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('date'); ?> <span class="required_star">*</span></label>
                            <input  autocomplete="off" type="text"   name="date" readonly class="form-control customDatepicker" placeholder="<?php echo lang('date'); ?>" value="<?php echo $sale_return_details->date; ?>">
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
                            <label><?php echo lang('customer'); ?> <span class="required_star">*</span></label>
                            <select  class="form-control  select2 op_width_100_p" name="customer_id" id="customer_id">
                                <option value=""><?php echo lang('select'); ?></option>
                                <?php foreach ($customers as $value) { ?>
                                    <option value="<?php echo escape_output($value->id) ?>" <?php echo $sale_return_details->customer_id == $value->id ? 'selected' : '' ?>><?php echo escape_output($value->name) ?> <?php echo $value->phone ? '(' . escape_output($value->phone) . ')' : '' ?></option>
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
                
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('sale_invoice_no'); ?> <span class="required_star">*</span></label>
                            <select  class="form-control  select2 op_width_100_p" name="sale_id" id="sale_id">
                                <option value=""><?php echo lang('select'); ?></option> 
                            </select>
                        </div>
                        <?php if (form_error('sale_id')) { ?>
                        <div class="callout callout-danger my-2">
                            <span class="error_paragraph"><?php echo form_error('sale_id'); ?></span>
                        </div>
                        <?php } ?>
                        <div class="alert alert-error error-msg sale_id_err_msg_contnr ">
                            <p id="sale_id_err_msg"></p>
                        </div>
                    </div>
                
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('sale_item'); ?> <span class="required_star">*</span></label>
                            <select  class="form-control  select2 op_width_100_p" name="item_id" id="item_id">
                                <option value=""><?php echo lang('select'); ?></option> 
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
                        <div class="table-responsive" id="saleReturn_cart">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="w-5 text-left"><?php echo lang('sn'); ?></th>
                                        <th class="w-20"><?php echo lang('item'); ?> - <?php echo lang('brand'); ?> - <?php echo lang('code'); ?></th>
                                        <th class="w-15"><?php echo lang('expiry_IME_Serial'); ?></th>
                                        <th class="w-12"><?php echo lang('sale_quantity_amount'); ?></th>
                                        <th class="w-13"><?php echo lang('return_quantity_amount'); ?></th>
                                        <th class="w-10"><?php echo lang('unit_price_in_sale'); ?></th>
                                        <th class="w-10"><?php echo lang('unit_price_in_return'); ?></th>
                                        <th class="w-10"><?php echo lang('total'); ?></th>
                                        <th class="w-5"><?php echo lang('actions'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $i = 0;
                                    $g_total = 0;
                                    if ($sale_return_items && !empty($sale_return_items)) {
                                        foreach ($sale_return_items as $si) {
                                            $i++;
                                            $readonly = '';
                                            $p_type = '';
                                            $date_picker = '';
                                            $d_none = '';
                                            $p_placeholder = '';
                                            $validation_cls = '';
                                            $checkIMEISerialUnique = '';
                                            $g_total += (int)$si->unit_price_in_return * (int)$si->return_quantity_amount;

                                            

                                            if($si->item_type == 'General_Product' || $si->item_type == 0 || ($si->item_type == 'Medicine_Product' && $si->expiry_date_maintain == 'No')){
                                                $d_none = 'd-none';
                                            }else if($si->item_type == 'Variation_Product'){
                                                $d_none = 'd-none';
                                            }else if($si->item_type == 'Installment_Product'){
                                                $d_none = 'd-none';
                                            }else if ($si->item_type == 'Medicine_Product' && $si->expiry_date_maintain == 'Yes'){
                                                $p_type = 'Expiry Date:';
                                                $p_placeholder = '';
                                                $date_picker = 'customDatepicker'; 
                                                $validation_cls = 'countID2';
                                            }else if($si->item_type == 'IMEI_Product'){
                                                $p_type = 'IMEI:';
                                                $p_placeholder = lang('enter_imei_number');
                                                $readonly = 'readonly';
                                                $validation_cls = 'countID2';
                                                $checkIMEISerialUnique = 'checkIMEISerialUnique';
                                            }else if($si->item_type == 'Serial_Product'){
                                                $p_type = 'Serial:';
                                                $p_placeholder = lang('enter_serial_number');
                                                $readonly = 'readonly';
                                                $validation_cls = 'countID2';
                                                $checkIMEISerialUnique = 'checkIMEISerialUnique';
                                            }
                                            echo '<tr class="rowCount"  data-id="' . $i .'" data-item_id="'.$si->item_id.'" id="row_' . $i .'">
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <p id="sl_' . $i .'">' . $i . '</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <span>' . getItemNameCodeBrandByItemId($si->item_id).'</span>
                                                    </div>

                                                    <input type="hidden" id="item_id_' . $i .'" name="item_id[]" value="' . ($si->item_id) . '"/>
                                                    <input type="hidden" name="item_type[]" value="' . $si->item_type . '">
                                                    <input type="hidden" id="sale_item_id_' . $i .'" name="sale_item_id[]" value="' . ($si->sale_id) . '"/>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center form-group">
                                                        <small class="pe-1">' . $p_type . '</small>
                                                        <input readonly data-type="'.$si->item_type.'" data-countid="'.$i.'" type="text" autocomplete="off" id="serial_' . $i . '" name="expiry_imei_serial[]" class="'.$checkIMEISerialUnique.'  '.$validation_cls.'  '. $d_none .' form-control ' . $date_picker . '" placeholder="'.$p_placeholder.'" value="' . $si->expiry_imei_serial . '" >
                                                        <p class="imei-serial-err imei-serial-err-unique-'.$i.'"></p>
                                                    </div>
                                                </td>

                                                <td>
                                                    <div class="input-group">
                                                        <input '. $readonly .'  type="text" autocomplete="off" data-countid="'.$i.'" id="sale_quantity_amount_' . $i .'" name="sale_quantity_amount[]" onfocus="this.select();" class="form-control integerchk1 countID calculate_op qty_count" placeholder="'.lang('sale') . ' ' .lang('qty').'" value="' . $si->sale_quantity_amount . '" aria-describedby="basic-addon2">
                                                        <span class="input-group-text" id="basic-addon2">' . $si->sale_unit_name . '</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <input '. $readonly .'  type="text" autocomplete="off" data-countid="'.$i.'" id="return_quantity_amount_' . $i .'" name="return_quantity_amount[]" onfocus="this.select();" class="form-control integerchk1 countID calculate_op qty_count" placeholder="'.lang('return') . ' ' .lang('qty').'" value="' . $si->return_quantity_amount . '" aria-describedby="basic-addon2">
                                                        <span class="input-group-text" id="basic-addon2">' . $si->sale_unit_name . '</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="d-flex align-items-center">
                                                            <input type="text" autocomplete="off" id="unit_price_in_sale_' . $i .'" name="unit_price_in_sale[]" data-countid="'.$i.'" onfocus="this.select();" class="form-control integerchk1 calculate_op countID" placeholder="'. lang('return_quantity') .'" value="' . ($si->unit_price_in_sale) . '">
                                                        </div>
                                                    </div>
                                                </td>
                                                
                                                <td>
                                                    <div class="form-group">
                                                        <div class="d-flex align-items-center">
                                                            <input type="text" autocomplete="off" id="unit_price_in_return_' . $i .'" name="unit_price_in_return[]" data-countid="'.$i.'" onfocus="this.select();" class="form-control integerchk1 calculate_op countID" placeholder="'. lang('unit_price') .'" value="' . ($si->unit_price_in_return) . '">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="d-flex align-items-center">
                                                            <input type="text" autocomplete="off" id="total_' . $i .'" name="total[]" class="form-control" placeholder="'.lang('total').'" value="' . ($si->unit_price_in_return * $si->return_quantity_amount) . '" readonly>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="new-btn-danger deleter_op h-40" data-suffix="' . $i .'" data-item_id="'.$si->item_id.'">
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
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                        <div class="form-group mt-3">
                            <label><?php echo lang('g_total'); ?> <span class="required_star">*</span></label>
                            <input class="form-control integerchk1" readonly type="text"
                                name="grand_total" id="grand_total"
                            placeholder="<?php echo lang('g_total');?>" value="<?php echo $sale_return_details->total_return_amount; ?>">       
                        </div>
                    </div>
                </div>
                <div class="row justify-content-end">
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                        <div class="form-group mt-3">
                            <label><?php echo lang('paid'); ?> <span class="required_star"></span></label>
                            <input  autocomplete="off" class="form-control integerchk calculate_op" value="0" type="text" name="paid" id="paid" onfocus="this.select();"
                             placeholder="<?php echo lang('paid');?>" value="<?php echo $sale_return_details->paid; ?>">
                        </div>
                        <?php if (form_error('paid')) { ?>
                        <div class="callout callout-danger my-2">
                            <span class="error_paragraph"><?php echo form_error('paid'); ?></span>
                        </div>
                        <?php } ?>
                        <div class="alert alert-error error-msg paid_err_msg_contnr op_padding_5_important">
                            <p id="paid_err_msg"></p>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-end">
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                        <div class="form-group mt-3">
                            <label><?php echo lang('due'); ?></label>
                            <input class="form-control integerchk" type="text" name="due" id="due" readonly <?php echo set_value('due'); ?> placeholder="<?php echo lang('due');?>" value="<?php echo $sale_return_details->due; ?>">
                            <div class="alert alert-error error-msg due_id_err_msg_contnr op_padding_5_important">
                                <p id="due_id_err_msg"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-end">
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                        <div class="form-group mt-3">
                            <label><?php echo lang('payment_methods'); ?> <span
                                    class="required_star"></span></label>
                            <select  class="form-control select2 op_width_100_p" id="payment_method_id"
                                name="payment_method_id">
                                <option value=""><?php echo lang('select'); ?></option>
                                <?php foreach ($paymentMethods as $ec) { ?>
                                <option value="<?php echo escape_output($ec->id) ?>"
                                    <?php echo $ec->id == $sale_return_details->payment_method_id ? 'selected' : '' ?>><?php echo escape_output($ec->name) ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
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
                    <div class="col-12 mt-3">
                        <div class="form-group">
                            <label><?php echo lang('note');?></label>
                            <textarea  class="form-control" rows="2" id="note" name="note"
                                placeholder="<?php echo lang('note');?>..."><?php  echo $this->input->post('note'); ?></textarea>
                        </div>
                        <?php  if (form_error('note')) { ?>
                        <div class="callout callout-danger my-2">
                            <p><?php  echo form_error('note'); ?></p>
                        </div>
                        <?php  }  ?>
                        <div class="alert alert-error error-msg note_err_msg_contnr ">
                            <p id="note_err_msg"></p>
                        </div>
                    </div>
                    <input class="form-control" type="hidden" name="subtotal" id="subtotal">
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
                <a class="btn bg-blue-btn text-decoration-none" href="<?php echo base_url() ?>Sale_return/saleReturns">
                    <iconify-icon icon="solar:undo-left-round-broken"></iconify-icon>
                    <?php echo lang('back'); ?>
                </a>
            </div>
            <?php echo form_close(); ?>
        </div>
    </section>
</div>
<script src="<?php echo base_url(); ?>frequent_changing/js/add_sale_return.js"></script>

