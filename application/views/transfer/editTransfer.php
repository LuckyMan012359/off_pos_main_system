<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/add_transfer.css">
<input type="hidden" id="food_menu_already_remain" value="<?php echo lang('ingredient_already_remain'); ?>">
<input type="hidden" id="date_field_required" value="<?php echo lang('date_field_required'); ?>">
<input type="hidden" id="at_least_food_menu" value="<?php echo lang('at_least_food_menu'); ?>">
<input type="hidden" id="paid_field_required" value="<?php echo lang('paid_field_required'); ?>">
<input type="hidden" id="ingredient" value="<?php echo lang('ingredient'); ?>">
<input type="hidden" id="food_menu" value="<?php echo lang('food_menu'); ?>">
<input type="hidden" id="transfer_id_c" value="">
<input type="hidden" id="is_disabled_change" value="">
<input type="hidden" id="add_mode" value="Edit">
<input type="hidden" id="session_outlet_id" value="<?php echo escape_output($this->session->userdata('outlet_id'))?>">
<input type="hidden" id="draft" value="<?php echo lang('draft'); ?>">
<input type="hidden" id="sent" value="<?php echo lang('sent'); ?>">
<input type="hidden" id="received" value="<?php echo lang('received'); ?>">
<input type="hidden" id="select" value="<?php echo lang('select'); ?>">
<input type="hidden" id="select_from_outlet_id" value="<?php echo lang('select_from_outlet_id'); ?>">
<input type="hidden" id="select_to_outlet_id" value="<?php echo lang('select_to_outlet_id'); ?>">
<input type="hidden" id="select_status" value="<?php echo lang('select_status'); ?>">

<input type="hidden" id="quantity" value="<?php echo lang('quantity'); ?>">

<input type="hidden" id="add_edit_mode" value="edit_mode">
<input type="hidden" id="imei" value="<?php echo lang('imei');?>">
<input type="hidden" id="serial" value="<?php echo lang('serial');?>">
<input type="hidden" id="expiry_date_ln" value="<?php echo lang('expiry_date');?>">


<script src="<?php echo base_url('frequent_changing/js/add_transfer.js'); ?>"></script>
<section class="main-content-wrapper">
<h3 class="display_none">&nbsp;</h3>

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
                <h3 class="top-left-header mt-2"><?php echo lang('edit_transfer'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('transfer'), 'secondSection'=> lang('edit_transfer')])?>
        </div>
    </section>



    <div class="box-wrapper">
        <!-- general form elements -->
        <div class="table-box">
            <?php echo form_open(base_url() . 'Transfer/addEditTransfer/' . $encrypted_id, $arrayName = array('id' => 'transfer_form')) ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12 col-md-4 col-lg-3 mb-2">
                        <div class="form-group">
                            <label><?php echo lang('ref_no'); ?></label>
                            <input  type="text" id="reference_no" readonly name="reference_no"
                                class="form-control" placeholder="<?php echo lang('ref_no'); ?>"
                                value="<?=$transfer_details->reference_no?>">
                        </div>
                        <?php if (form_error('reference_no')) { ?>
                        <div class="callout callout-danger my-2">
                            <?php echo form_error('reference_no'); ?>
                        </div>
                        <?php } ?>
                        <div class="callout callout-danger my-2 error-msg name_err_msg_contnr">
                            <p id="name_err_msg"></p>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4 col-lg-3 mb-2">
                        <div class="form-group">
                            <label><?php echo lang('date'); ?> <span class="required_star">*</span></label>
                            <input  readonly type="text" id="transfer_date" name="date" class="form-control"
                                placeholder="<?php echo lang('date'); ?>" value="<?=$transfer_details->date?>">
                        </div>
                        <?php if (form_error('date')) { ?>
                        <div class="callout callout-danger my-2">
                            <?php echo form_error('date'); ?>
                        </div>
                        <?php } ?>
                        <div class="callout callout-danger my-2 error-msg date_err_msg_contnr"">
                            <p id="date_err_msg">
                            </p>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4 col-lg-3 mb-2">
                        <?php 
                            $role = $this->session->userdata('role');
                            $outlet_id = $this->session->userdata('outlet_id');
                        ?>
                        <div class="form-group <?= $role != '1' ? 'pointer-events-none' : '' ?>"">
                            <label><?php echo lang('from_outlet');?><span class="required_star">*</span></label>
                            <select  class="form-control select2 select2-hidden-accessible ir_w_100"
                                    name="from_outlet_id" id="from_outlet_id">
                                <option value=""><?php echo lang('select'); ?></option>
                                <?php
                                foreach ($outlets as $value) {
                                ?>
                                    <?php if($role != '1') { ?>
                                        <option value="<?php echo escape_output($value->id) ?>"
                                        <?php echo set_select('from_outlet_id', $value->id); ?> <?php echo escape_output($value->id) == $outlet_id ? 'selected' : '' ?>>
                                        <?php echo escape_output($value->outlet_name) ?></option>
                                    <?php } else{ ?>
                                        <option value="<?php echo escape_output($value->id) ?>"
                                        <?php echo set_select('from_outlet_id', $value->id); ?> <?php echo escape_output($transfer_details->from_outlet_id) == $value->id ? 'selected' : '' ?>>
                                        <?php echo escape_output($value->outlet_name) ?></option>
                                    <?php }?>
                                <?php } ?>
                            </select>
                            <?php if (form_error('from_outlet_id')) { ?>
                                <div class="callout callout-danger my-2">
                                    <?php echo form_error('from_outlet_id'); ?>
                                </div>
                            <?php } ?>
                            <div class="callout callout-danger my-2 error-msg f_outlet_id_err_msg_contnr">
                                <p id="f_outlet_id_err_msg"></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4 col-lg-3 mb-2">
                        <div class="form-group">
                            <label>
                                <?php
                                    echo lang('to_outlet'); 
                                    ?> 
                                <span class="required_star">*</span></label>
                            <select  class="form-control select2 select2-hidden-accessible ir_w_100"
                                    name="to_outlet_id" id="to_outlet_id">
                                    <?php foreach ($outlets as $value) {
                                    ?>
                                        <?php 
                                        if ($value->id == $transfer_details->from_outlet_id):
                                            continue;
                                        endif;
                                        ?>

                                    <option <?=$transfer_details->to_outlet_id ==  $value->id ? 'selected' : ''?> value="<?php echo escape_output($value->id) ?>"><?php echo set_select('to_outlet_id', $value->id); ?>
                                        <?php echo escape_output($value->outlet_name) ?></option>
                                <?php
                                } ?>
                                
                            </select>
                            <?php if (form_error('to_outlet_id')) { ?>
                                <div class="callout callout-danger my-2">
                                    <?php echo form_error('to_outlet_id'); ?>
                                </div>
                            <?php } ?>
                            <div class="callout callout-danger my-2 error-msg t_outlet_id_err_msg_contnr">
                                <p id="t_outlet_id_err_msg"></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4 col-lg-3 mb-2">
                        <div class="form-group">
                            <label><?php echo lang('status'); ?> <span class="required_star">*</span></label>
                            <select  class="form-control select2 select2-hidden-accessible ir_w_100"
                                    name="status" id="status">
                                <option value=""><?php echo lang('select'); ?></option>
                                <option <?php echo escape_output($transfer_details->status) == 2 ? 'selected' : '' ?> value="2"><?php echo lang('draft'); ?></option>
                                <option <?php echo escape_output($transfer_details->status) == 3 ? 'selected' : '' ?> value="3"><?php echo lang('sent'); ?></option>
                                <?php if($role == '1') { ?>
                                <option disabled <?php echo escape_output($transfer_details->status) == 1 ? 'selected' : '' ?> value="1"><?php echo lang('received'); ?></option>
                                <?php } ?>
                            </select>
                            <?php if (form_error('status')) { ?>
                                <div class="callout callout-danger my-2">
                                    <?php echo form_error('status'); ?>
                                </div>
                            <?php } ?>
                            <div class="callout callout-danger my-2 error-msg status_err_msg_contnr">
                                <p id="status_err_msg"></p>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-sm-12 col-md-4 col-lg-3 mb-2">
                        <div class="form-group">
                            <label>
                                <?php 
                                    echo lang('items'); 
                                ?> 
                                <span class="required_star">*</span></label>
                            <select  class="form-control select2 select2-hidden-accessible" id="item_id">
                                <option value=""><?php echo lang('select'); ?></option>
                                <?php foreach ($items as $item) { 
                                    $string = ($item->parent_name != '' ? $item->parent_name . ' - ' : '') . ($item->name) . ($item->brand_name != '' ? ' - ' . $item->brand_name : '') . ( ' - ' . $item->code); 
                                ?>
                                    <option
                                    value="<?php echo escape_output($item->id . "||" . $string . "||" . $item->purchase_price. "||" . $item->sale_unit . "||" . $item->type . "||" .  $item->expiry_date_maintain) ?>"
                                    <?php echo set_select('ingredient_id', $item->id); ?>>
                                    <?php echo escape_output($string) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <?php if (form_error('ingredient_id')) { ?>
                        <div class="callout callout-danger my-2">
                            <?php echo form_error('ingredient_id'); ?>
                        </div>
                        <?php } ?>
                        <div class="callout callout-danger my-2 error-msg ingredient_id_err_msg_contnr">
                            <p id="ingredient_id_err_msg"></p>
                        </div>
                    </div>
                    <div class="hidden-lg hidden-sm">&nbsp;</div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table" id="transfer_cart">
                                <thead>
                                    <tr>
                                        <th class="w-5 text-left"><?php echo lang('sn'); ?></th>
                                        <th class="w-35"><?php echo lang('item'); ?> - <?php echo lang('brand'); ?> - <?php echo lang('code'); ?></th>
                                        <th class="w-35"><?php echo lang('expiry_date_IME_Serial'); ?></th>
                                        <th class="w-20"><?php echo lang('quantity_amount'); ?></th>
                                        <th class="w-5 text-center"><?php echo lang('actions'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    foreach ($food_details as $key=>$value):
                                        $readonly = '';
                                        $readonly2 = '';
                                        $date_picker = '';
                                        $checkIMEISerialUnique = '';
                                        $i_type = '';
                                        $readonly_expiry = '';
                                        $qtyReadonly = '';
                                        $d_none = '';


                                        if ($value->item_type == 'Medicine_Product' && $value->expiry_date_maintain == 'Yes'){
                                            $date_picker = 'customDatepicker';
                                            $readonly_expiry = 'readonly';
                                            $i_type = 'Expiry Date:';
                                            $d_none = "d-none";
                                        }elseif ($value->item_type == 'IMEI_Product'){
                                            $i_type = 'IMEI:';
                                            $readonly = 'readonly';
                                            $checkIMEISerialUnique = 'checkIMEISerialUnique';
                                            $qtyReadonly = 'readonly';
                                        }elseif ($value->item_type == 'Serial_Product'){
                                            $i_type = 'Serial:';
                                            $readonly = 'readonly';
                                            $checkIMEISerialUnique = 'checkIMEISerialUnique';
                                            $qtyReadonly = 'readonly';
                                        }elseif($value->item_type == 0 || $value->item_type == 'General_Product' || $value->item_type == 'Variation_Product' || $value->item_type == 'Installment_Product' || ($value->item_type == 'Medicine_Product' && $value->expiry_date_maintain == 'No')){
                                            $readonly2 = 'readonly';
                                            $d_none = "d-none";
                                        }

                                        $key++;
                                        ?>
                                        <tr class="rowCount" data-item_id="<?=$value->ingredient_id?>" row-counter="<?=$key?>" data-id="<?=$key?>" id="row_<?=$key?>">
                                            <td><p id="sl_<?=$key?>"><?=$key?></p></td>
                                            <td>
                                                <span> 
                                                    <?php echo getItemNameCodeBrandByItemId($value->ingredient_id)?> 
                                                </span>
                                                <input type="hidden" id="ingredient_id_<?=$key?>" name="ingredient_id[]" value="<?=$value->ingredient_id?>">
                                                <input type="hidden" id="<?=$key?>" name="item_type[]" value="<?php echo escape_output($value->item_type); ?>">
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center form-group">
                                                    <small class="pe-1"><?php echo $i_type ?></small>
                                                    <input <?php echo $readonly_expiry; ?> data-type="<?php echo escape_output($value->item_type) ?>" data-countid="<?php echo $key ?>" <?= $readonly2 . ' ' . $readonly ?> class="form-control <?php echo $checkIMEISerialUnique . $d_none ?>" id="serial_<?=$key?>" name="expiry_imei_serial[]" value="<?=$value->expiry_imei_serial?>">
                                                    <p class="imei-serial-err imei-serial-err-unique-<?php echo $key; ?>"></p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <input <?php echo $qtyReadonly;?> <?= $readonly ?> type="text" data-countID="<?=$key?>"  value="<?=$value->quantity_amount?>" id="quantity_amount<?=$key?>" name="quantity_amount[]" onfocus="this.select();" class="form-control integerchk aligning countID cal_culate quantity" placeholder="<?php echo lang('quantity');?>" aria-describedby="basic-addon2"><span class="input-group-text" id="basic-addon2"><?= (getSaleUnitNameByItemId($value->ingredient_id)) ?></span>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center">
                                                    <button type="button" class="new-btn-danger h-40 row_delete">
                                                        <iconify-icon icon="solar:trash-bin-minimalistic-broken" width="18"></iconify-icon>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                <?php
                                endforeach;
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-3">
                        <div class="form-group textarea-h-100">
                            <label><?php echo lang('note_for_sender'); ?></label>
                            <textarea class="form-control" placeholder="<?php echo lang('note_for_sender'); ?>" name="note_for_sender"
                                        id="note_for_sender"><?php echo escape_output($transfer_details->note_for_sender); ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="clearfix"></div>
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
                <a class="btn bg-blue-btn text-decoration-none" href="<?php echo base_url() ?>Transfer/transfers">
                    <iconify-icon icon="solar:undo-left-round-broken"></iconify-icon>
                    <?php echo lang('back'); ?>
                </a>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</section>



<!-- Cart Previw -->
<div class="modal fade" id="cartPreviewModal"  role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="item_header">&nbsp;</h5>
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
                            <span class="modal_item_unit input-group-text" id="basic-addon"></span>
                        </div>
                        <input type="hidden" id="hidden_input_item_type">
                        <input type="hidden" id="hidden_input_item_id">
                        <input type="hidden" id="hidden_input_item_name">
                        <input type="hidden" id="hidden_input_unit_name">
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