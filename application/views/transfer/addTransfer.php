<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/add_transfer.css">
<script src="<?php echo base_url('frequent_changing/js/add_transfer.js'); ?>"></script>

<input type="hidden" id="food_menu_already_remain" value="<?php echo lang('ingredient_already_remain'); ?>">
<input type="hidden" id="date_field_required" value="<?php echo lang('date_field_required'); ?>">
<input type="hidden" id="at_least_food_menu" value="<?php echo lang('at_least_food_menu'); ?>">
<input type="hidden" id="paid_field_required" value="<?php echo lang('paid_field_required'); ?>">
<input type="hidden" id="ingredient" value="<?php echo lang('ingredient'); ?>">
<input type="hidden" id="food_menu" value="<?php echo lang('food_menu'); ?>">
<input type="hidden" id="transfer_id_c" value="">
<input type="hidden" id="is_disabled_change" value="">
<input type="hidden" id="session_outlet_id" value="<?php echo escape_output($this->session->userdata('outlet_id'))?>">
<input type="hidden" id="draft" value="<?php echo lang('draft'); ?>">
<input type="hidden" id="sent" value="<?php echo lang('sent'); ?>">
<input type="hidden" id="received" value="<?php echo lang('received'); ?>">
<input type="hidden" id="select" value="<?php echo lang('select'); ?>">
<input type="hidden" id="select_from_outlet_id" value="<?php echo lang('select_from_outlet_id'); ?>">
<input type="hidden" id="select_to_outlet_id" value="<?php echo lang('select_to_outlet_id'); ?>">
<input type="hidden" id="select_status" value="<?php echo lang('select_status'); ?>">
<input type="hidden" id="outlet_id_session" value="<?php echo escape_output($this->session->userdata('outlet_id')); ?>">
<input type="hidden" id="role_session" value="<?php echo escape_output($this->session->userdata('role_session')); ?>">
<input type="hidden" id="quantity" value="<?php echo lang('quantity'); ?>">
<input type="hidden" id="add_mode" value="Add">
<input type="hidden" id="imei" value="<?php echo lang('imei_number');?>">
<input type="hidden" id="serial" value="<?php echo lang('serial_number');?>">
<input type="hidden" id="expiry_date_ln" value="<?php echo lang('expiry_date');?>">
<input type="hidden" id="need_skip" value="">
<input type="hidden" id="temp_outlet_id" value="">


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
                <h3 class="top-left-header mt-2"><?php echo lang('add_transfer'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('transfer'), 'secondSection'=> lang('add_transfer')])?>
        </div>
    </section>



    <div class="box-wrapper">
        <!-- general form elements -->
        <div class="table-box">
            <?php echo form_open(base_url() . 'Transfer/addEditTransfer', $arrayName = array('id' => 'transfer_form')) ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12 col-md-4 col-lg-3 mb-2">
                        <div class="form-group">
                            <label><?php echo lang('ref_no'); ?></label>
                            <input  type="text" id="reference_no" readonly name="reference_no"
                                class="form-control" placeholder="<?php echo lang('ref_no'); ?>"
                                value="<?php echo escape_output($pur_ref_no); ?>">
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
                                placeholder="<?php echo lang('date'); ?>" value="<?=date('Y-m-d',strtotime('today'))?>">
                        </div>
                        <?php if (form_error('date')) { ?>
                        <div class="callout callout-danger my-2">
                            <?php echo form_error('date'); ?>
                        </div>
                        <?php } ?>
                        <div class="callout callout-danger my-2 error-msg date_err_msg_contnr">
                            <p id="date_err_msg">
                            </p>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4 col-lg-3 mb-2">
                        <?php 
                            $role = $this->session->userdata('role');
                            $outlet_id = $this->session->userdata('outlet_id');
                        ?>
                        <div class="form-group <?= $role != '1' ? 'pointer-events-none' : '' ?>">
                            <label>
                                <?php
                                    echo lang('from_outlet'); 
                                    ?> 
                                <span class="required_star">*</span>
                            </label>
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
                                        <?php echo set_select('from_outlet_id', $value->id); ?>>
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
                            <label><?php echo lang('to_outlet'); ?> 
                                <span class="required_star">*</span></label>
                            <select class="form-control select2"
                                    name="to_outlet_id" id="to_outlet_id">
                                <option value=""><?php echo lang('select'); ?></option>
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
                                <option value="2"><?php echo lang('draft'); ?></option>
                                <option value="3"><?php echo lang('sent'); ?></option>
                                <?php if($role == '1') { ?>
                                <option disabled value="1"><?php echo lang('received'); ?></option>
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
                            <select  class="form-control select2 select2-hidden-accessible ir_w_100" id="item_id" >
                                <option value=""><?php echo lang('select'); ?></option>
                                <?php 
                                foreach ($items as $item) { 
                                    $string = ($item->parent_name != '' ? $item->parent_name . ' - ' : '') . ($item->name) . ($item->brand_name != '' ? ' - ' . $item->brand_name : '') . ( ' - ' . $item->code); 
    
                                ?>
                                    <option
                                    value="<?php echo escape_output($item->id . "||" . $string . "||" . $item->purchase_price. "||" . $item->sale_unit . "||" . $item->type . "||" .  $item->expiry_date_maintain) ?>"
                                    <?php echo set_select('item_id', $item->id); ?>>
                                    <?php echo escape_output($string) ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <?php if (form_error('item_id')) { ?>
                        <div class="callout callout-danger my-2">
                            <?php echo form_error('item_id'); ?>
                        </div>
                        <?php } ?>
                        <div class="callout callout-danger my-2 error-msg item_id_err_msg_contnr">
                            <p id="item_id_err_msg"></p>
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
                                        <th class="w-5"><?php echo lang('sn'); ?></th>
                                        <th class="w-35"><?php echo lang('item'); ?> - <?php echo lang('brand'); ?> - <?php echo lang('code'); ?></th>
                                        <th class="w-35"><?php echo lang('expiry_date_IME_Serial'); ?></th>
                                        <th class="w-20"><?php echo lang('quantity_amount'); ?></th>
                                        <th class="w-5 text-center"><?php echo lang('actions'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
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
                                        id="note_for_sender"><?php echo set_value('note_for_sender'); ?></textarea>
                        </div>
                        <?php if (form_error('note_for_sender')) { ?>
                        <div class="callout callout-danger my-2">
                            <?php echo form_error('note_for_sender'); ?>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="clearfix"></div>
                </div>
                <div class="row">
                    <input class="form-control" type="hidden" name="subtotal" id="subtotal">
                </div>
            </div>
            <input type="hidden" name="suffix_hidden_field" id="suffix_hidden_field">

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
                <h4 class="item_header modal-title">&nbsp;</h4>
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
                            <span class="modal_item_unit input-group-text new-btn h-40" id="basic-addon"></span>
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
                        <div class="d-flex">
                            <div class="imeiSerial_add_more mt-2">
                            </div>
                            <div class="bulk_imei_serial_upload tippyBtnCall" data-tippy-content="Bulk IMEI/Serial Import">
                                <div class="uplod_imei_el bulk_import_at_stock mt-2 h-40">
                                    <iconify-icon icon="solar:upload-minimalistic-broken" width="18" height="18"></iconify-icon>
                                </div>
                            </div>
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


<!-- Bulk Import Modal -->
<div class="modal fade" id="bulkImportModal"  role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form id="fileUploadForTransfer" enctype="multipart/form-data">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">
                    <?php echo lang('Bulk_Import_For_Transfer');?>
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                        <i data-feather="x">×</i>
                    </span>
                </button>
            </div>
            <div class="modal-body scroll_body">
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-error error-msg name_err_msg_contnr">
                            <p class="name_err_msg"></p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label class="control-label"><?php echo lang('Select_Bulk_Import_File');?> <span class="op_color_red"> *</span></label>
                            <input type="hidden" id="bulk_transfer_item_id">
                            <input type="hidden" id="bulk_transfer_item_type">
                            <input type="file" class="form-control" id="file" name="file" accept=".xlsx">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn bg-blue-btn">
                    <?php echo lang('submit'); ?>
                </button>
                <a class="btn bg-blue-btn" href="<?php echo base_url() ?>Authentication/downloadPDF/Transfer_Bulk_Import.xlsx">
                    <?php echo lang('download_sample'); ?>
                </a>
                <button type="button" class="btn bg-blue-btn" data-bs-dismiss="modal">
                    <?php echo lang('close'); ?>
                </button>
            </div>
            </form>  
        </div>
    </div>
</div>