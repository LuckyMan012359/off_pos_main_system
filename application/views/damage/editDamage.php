<input type="hidden" id="The_Quantity_field_is_required" value="<?php echo lang('The_Quantity_field_is_required');?>">
<input type="hidden" id="Damage_Qty_Amt" value="<?php echo lang('Damage_Qty_Amt');?>">
<input type="hidden" id="Loss_Amt" value="<?php echo lang('Loss_Amt');?>">
<input type="hidden" id="Damage_amt" value="<?php echo lang('Damage_amt');?>">
<input type="hidden" id="responsible_person_field_required" value="<?php echo lang('responsible_person_field_required');?>">
<input type="hidden" id="date_field_required" value="<?php echo lang('date_field_required');?>">
<input type="hidden" id="at_least_item" value="<?php echo lang('at_least_item');?>">
<input type="hidden" id="note_field_cannot" value="<?php echo lang('note_field_cannot');?>">
<input type="hidden" id="Qty_Amount" value="<?php echo lang('qty');?>">
<input type="hidden" id="Unit_Price_l" value="<?php echo lang('unit_price');?>">
<input type="hidden" id="total" value="<?php echo lang('total');?>">
<input type="hidden" id="add_mode" value="Edit">
<input type="hidden" id="imei" value="<?php echo lang('imei_number');?>">
<input type="hidden" id="serial" value="<?php echo lang('serial_number');?>">
<input type="hidden" id="expiry_date_ln" value="<?php echo lang('expiry_date');?>">
<input type="hidden" id="quantity" value="<?php echo lang('quantity'); ?>">
<input type="hidden" id="imei" value="<?php echo lang('imei');?>">
<input type="hidden" id="serial" value="<?php echo lang('serial');?>">
<input type="hidden" id="expiry_date_ln" value="<?php echo lang('expiry_date');?>">
<input type="hidden" id="quantity" value="<?php echo lang('quantity'); ?>">


<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/damage.css">
<script src="<?php echo base_url(); ?>frequent_changing/js/add_damage.js"></script>

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
                <h3 class="top-left-header mt-2"><?php echo lang('edit_damage'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('damage'), 'secondSection'=> lang('edit_damage')])?>
        </div>
    </section>




    <div class="box-wrapper">
        <div class="table-box">
            <?php echo form_open(base_url() . 'Damage/addEditDamage/' . $encrypted_id, $arrayName = array('id' => 'damage_form')) ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('ref_no'); ?></label>
                            <input  autocomplete="off" type="text" id="reference_no" readonly name="reference_no" class="form-control" placeholder="<?php echo lang('ref_no'); ?>" value="<?php echo escape_output($damage_details->reference_no);?>">
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

                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('date'); ?> <span class="required_star">*</span></label>
                            <input  autocomplete="off" type="text"  name="date" id="damage_date" readonly class="form-control customDatepicker" placeholder="<?php echo lang('date'); ?>" value="<?php echo escape_output($damage_details->date); ?>">
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

                    <div class="col-md-4 mb-3">

                        <div class="form-group"> 
                            <label><?php echo lang('responsible_person'); ?> <span class="required_star">*</span></label>
                            <select  class="form-control select2 select2-hidden-accessible op_width_100_p" name="employee_id" id="employee_id">
                                <option value=""><?php echo lang('select'); ?></option>
                                <?php foreach ($employees as $empls) { ?>
                                    <option <?= $empls->id == $damage_details->employee_id ? 'selected' : '' ?> value="<?php echo escape_output($empls->id); ?>" <?php echo set_select('unit_id', $empls->id); ?>><?php echo escape_output($empls->full_name) ?></option>
                                <?php } ?>
                            </select>
                        </div>  
                        <?php if (form_error('employee_id')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('employee_id'); ?></span>
                            </div>
                        <?php } ?> 
                        <div class="alert alert-error error-msg employee_id_err_msg_contnr ">
                            <p id="employee_id_err_msg"></p>
                        </div>


                    </div> 
                </div> 
                <div class="row">
                    <div class="col-md-4 mb-3">

                        <div class="form-group"> 
                            <label><?php echo lang('items'); ?> <span class="required_star">*</span></label>
                            <select  class="form-control select2 op_width_100_p" name="item_id" id="item_id">
                                <option value=""><?php echo lang('select'); ?></option>
                                <?php
                                $ignoreID = array();
                                foreach ($items as $value) {
                                    $string = ($value->parent_name != '' ? $value->parent_name . ' - ' : '') . ($value->name) . ($value->brand_name != '' ? ' - ' . $value->brand_name : '') . ( ' - ' . $value->code); 
                                        ?>
                                        <option value="<?php echo escape_output($value->id . "|" . $string . "|" . $value->sale_unit . "|" . $value->last_three_purchase_avg . "|" . $value->type . "|" .  $value->expiry_date_maintain) ?>" <?php echo set_select('unit_id', $value->id); ?>>
                                            <?php echo escape_output($string) ?>
                                        </option>
                                    <?php
                                    
                                }
                                ?>
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
                    <div class="col-md-3">
                        <div class="hidden-xs hidden-sm">&nbsp;</div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="hidden-lg hidden-sm">&nbsp;</div>
                </div> 
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive" id="damage_cart">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="w-5"><?php echo lang('sn'); ?></th>
                                        <th class="w-25"><?php echo lang('item'); ?> - <?php echo lang('code'); ?> - <?php echo lang('brand'); ?></th>
                                        <th class="w-25"><?php echo lang('expiry_date_IME_Serial'); ?></th>
                                        <th class="w-10"><?php echo lang('damage'); ?> <?php echo lang('quantity_amount'); ?></th>
                                        <th class="w-15"><?php echo lang('loss_amount'); ?></th>
                                        <th class="w-20"><?php echo lang('total'); ?></th>
                                        <th class="w-5"><?php echo lang('actions'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $key = 0;
                                    if ($damage_items && !empty($damage_items)) {
                                        foreach ($damage_items as $di) {
                                            $key++;
                                            $readonly = '';
                                            $readonly2 = '';
                                            $date_picker = '';
                                            $dnone = '';
                                            $expiryDateExistCheck = '';
                                            $p_type = '';
                                            $readonly_expiry = '';
                                            $checkIMEISerialUnique = '';
                                            $imei_serial_exp_validate_cls = '';

                                            if ($di->item_type == 'Medicine_Product' && $di->expiry_date_maintain == 'Yes'){
                                                $p_type = 'Expiry Date:';
                                                $date_picker = 'customDatepicker';
                                                $expiryDateExistCheck = 'expiryDateExistCheck';
                                                $readonly_expiry = 'readonly';
                                                $imei_serial_exp_validate_cls = 'countID2';
                                            }elseif ($di->item_type == 'IMEI_Product'){
                                                $p_type = 'IMEI:';
                                                $readonly = 'readonly';
                                                $checkIMEISerialUnique = 'checkIMEISerialUnique';
                                                $imei_serial_exp_validate_cls = 'countID2';
                                            }elseif ($di->item_type == 'Serial_Product'){
                                                $p_type = 'Serial:';
                                                $readonly = 'readonly';
                                                $checkIMEISerialUnique = 'checkIMEISerialUnique';
                                                $imei_serial_exp_validate_cls = 'countID2';
                                            }elseif($di->item_type == 0 || $di->item_type == 'General_Product' || $di->item_type == 'Variation_Product' || $di->item_type == 'Installment_Product' || ($di->item_type == 'Medicine_Product' && $di->expiry_date_maintain == 'No')){
                                                $readonly2 = 'readonly';
                                                $dnone = 'd-none';
                                            }
                                            $name = getItemNameCodeBrandByItemId($di->item_id);
                                            echo '<tr class="rowCount" row-counter="'.$key.'" data-item-id="'.$di->item_id.'">
                                                <td>
                                                    <p id="sl_'.$key.'">'.$key.'</p>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <span class="op_padding_bottom_5">'.$name.'</span>
                                                        <input type="hidden" id="item_id_'.$key.'" name="item_id[]" value="'.$di->item_id.'">
                                                        <input type="hidden" id="'.$key.'" name="item_type[]" value="'.$di->item_type.'">
                                                        <input type="hidden" id="last_purchase_price_'.$key.'" name="last_purchase_price[]" value="'.$di->last_purchase_price.'">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center form-group">
                                                        <small class="pe-1">' . $p_type . '</small>
                                                        <input '.$readonly_expiry.' item-type="'.$di->item_type.'" data-countid="'.$key.'" '.$readonly . ' ' . $readonly2.' type="text" autocomplete="off" id="serial_'.$key.'" name="expiry_imei_serial[]" onfocus="this.select();" class="form-control '.$imei_serial_exp_validate_cls.'  '.$expiryDateExistCheck.' '.$checkIMEISerialUnique.' '.$dnone.'" value="'.$di->expiry_imei_serial.'">
                                                    </div>
                                                    <p class="imei-serial-err imei-serial-err-unique-'.$key.'"></p>
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <input '.$readonly.' type="text" data-countID="'.$key.'" id="damage_quantity_'.$key.'" name="damage_quantity[]" value="'.$di->damage_quantity.'" placeholder="'.lang('quantity').'" onfocus="this.select();" class="calculate_op form-control integerchk countID qty_count" aria-describedby="basic-addon2">
                                                        <span class="input-group-text" id="basic-addon2">'. unitName(getSaleUnitIdByIgId($di->item_id)) .'</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input type="text" autocomplete="off" id="loss_amount_'.$key.'" name="loss_amount[]" onfocus="this.select();" value="'.$di->loss_amount.'" class="calculate_op form-control integerchk" placeholder="'.lang('loss_amount').'">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center form-group">
                                                        <input type="text" autocomplete="off" id="total_'.$key.'" name="total_amount[]" class="form-control" placeholder="'.lang('total').'" value="'.$di->total_amount.'" readonly />
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <a class="new-btn-danger h-40 deleter_op">
                                                    <iconify-icon icon="solar:trash-bin-minimalistic-broken" width="18"></iconify-icon>
                                                    </a>
                                                </td>
                                            </tr>';
                                        }}
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-end">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><?php echo lang('total_loss'); ?></label>
                            <input class="form-control aligning_total_loss op_width_100_p" readonly type="text" name="total_loss" id="total_loss" value="<?php echo escape_output($damage_details->total_loss);?>">
                        </div>
                        <?php if (form_error('total_loss')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('total_loss'); ?></span>
                            </div>
                        <?php } ?>
                        <div class="alert alert-error error-msg total_loss_err_msg_contnr ">
                            <p id="total_loss_err_msg"></p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('note'); ?></label>
                            <textarea  class="form-control" rows="2" id="note" name="note" placeholder="<?php echo lang('note'); ?> ..."><?php echo $this->input->post('note'); ?></textarea>
                        </div>
                            <?php if (form_error('note')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('note'); ?></span>
                            </div>
                            <?php } ?>
                        <div class="alert alert-error error-msg note_err_msg_contnr ">
                            <p id="note_err_msg"></p>
                        </div>
                    </div>

                </div>
                <input type="hidden" name="suffix_hidden_field" id="suffix_hidden_field">
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
                <a class="btn bg-blue-btn text-decoration-none" href="<?php echo base_url() ?>Damage/damages">
                    <iconify-icon icon="solar:undo-left-round-broken"></iconify-icon>
                    <?php echo lang('back'); ?>
                </a>
            </div>
            <?php echo form_close(); ?> 
        </div>
    </div>  
</div>
<div class="modal fade" id="noticeModal"  role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i data-feather="x"></i></span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 hidden-lg hidden-sm">
                        <p class="foodMenuCartNotice">
                            <strong class="op_margin_left_39_p"><?php echo lang('notice'); ?></strong><br>
                            <?php echo lang('notice_text_1'); ?>
                        </p>
                    </div>
                    <div class="col-md-12 hidden-xs hidden-sm">
                        <p class="foodMenuCartNotice">
                            <strong class="op_margin_left_43_p"><?php echo lang('notice'); ?></strong><br>
                            <?php echo lang('notice_text_1'); ?>
                        </p>
                    </div>
                    <div class="col-md-12 hidden-xs hidden-lg">
                        <p class="foodMenuCartNotice">
                            <strong class="op_margin_left_43_p"><?php echo lang('notice'); ?></strong><br>
                            <?php echo lang('notice_text_1'); ?>
                        </p>
                    </div> 
                </div>
            </div>

        </div>
    </div>
</div> 


<!-- Cart Previw -->
<div class="modal fade" id="cartPreviewModal"  role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="item_header modal-title">&nbsp;</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                        <i data-feather="x"></i>
                    </span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="form-group mb-3">
                        <label class="col-sm-4 control-label"><?php echo lang('quantity_amount'); ?><span
                                class="op_color_red"> *</span></label>
                        <div class="input-group">
                            <input type="number" autocomplete="off" min="1" class="form-control integerchk1"
                                onfocus="select();" name="qty_modal" id="qty_modal"
                                placeholder="<?php echo lang('quantity_amount'); ?>" value="" aria-describedby="basic-addon">
                            <span class="new-btn modal_item_unit input-group-text" id="basic-addon"></span>
                        </div>
                        <input type="hidden" id="hidden_input_item_type">
                        <input type="hidden" id="hidden_input_item_id">
                        <input type="hidden" id="hidden_input_item_name">
                        <input type="hidden" id="last_three_purchase_avg">
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