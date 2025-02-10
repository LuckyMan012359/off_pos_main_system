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

<input type="hidden" id="The_customer_field_is_required" value="<?php echo lang('The_customer_field_is_required');?>">
<input type="hidden" id="The_items_field_is_required" value="<?php echo lang('The_items_field_is_required');?>">
<input type="hidden" id="The_price_field_is_required" value="<?php echo lang('The_price_field_is_required');?>">
<input type="hidden" id="The_number_of_installment_required" value="<?php echo lang('The_number_of_installment_required');?>">
<input type="hidden" id="The_total_field_is_required" value="<?php echo lang('The_total_field_is_required');?>">
<input type="hidden" id="The_installment_duration_field_is_required" value="<?php echo lang('The_installment_duration_field_is_required');?>">
<input type="hidden" id="The_down_payment_field_is_required" value="<?php echo lang('The_down_payment_field_is_required');?>">
<input type="hidden" id="The_remaining_field_is_required" value="<?php echo lang('The_remaining_field_is_required');?>">


<script src="<?php echo base_url(); ?>frequent_changing/js/edit_installment_sale.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/addInstallmentSale.css">
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
                <h3 class="top-left-header mt-2"><?php echo lang('edit_installment_sale'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('installment_sale'), 'secondSection'=> lang('edit_installment_sale')])?>
        </div>
    </section>


    <div class="box-wrapper">
        <div class="table-box">
            <!-- /.box-header -->
            <!-- form start -->
            <?php echo form_open(base_url() . 'Installment/addEditInstallmentSale/' . $encrypted_id, $arrayName = array('id' => 'installment_form')); ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12 col-lg-6 row">
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label><?php echo lang('date'); ?> <span class="required_star">*</span></label>
                                <input  autocomplete="off" readonly type="text" name="date" class="form-control date customDatepicker" placeholder="<?php echo lang('date'); ?>" value="<?=$installment->date?>">
                            </div>
                            <?php if (form_error('date')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('date'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label><?php echo lang('invoice_no'); ?> <span class="required_star">*</span></label>
                                <input  autocomplete="off" readonly type="text" name="reference_no" class="form-control" placeholder="<?php echo lang('invoice_no'); ?>" value="<?=$installment->reference_no?>">
                            </div>
                            <?php if (form_error('reference_no')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('reference_no'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label><?php echo lang('customer'); ?> <span class="required_star">*</span></label>
                                <select class="form-control select2" name="customer_id" id="customer_id">
                                    <option value=""><?php echo lang('select'); ?></option>
                                    <?php
                                    foreach ($customers as $value):
                                        $string = ($value->name) . ($value->brand_name != '' ? ' - ' . $value->brand_name : '') . ( ' - ' . $value->code); 
                                        ?>
                                        <option <?=$installment->customer_id && $installment->customer_id == $value->id?'selected':''?> value="<?=$value->id?>">
                                            <?php echo escape_output($string) ?>
                                        </option>
                                        <?php
                                    endforeach;
                                    ?>
                                </select>
                            </div>
                            <?php if (form_error('customer_id')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('customer_id'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label><?php echo lang('product'); ?> <span class="required_star">*</span></label>
                                <select class="form-control select2 item_id" name="item_id" id="item_id">
                                    <option value=""><?php echo lang('select'); ?></option>
                                    <?php
                                    foreach ($products as $value):
                                        ?>
                                        <option <?=$installment->item_id && $installment->item_id == $value->id?'selected':''?> data-item-type="<?=$value->type?>" data-price="<?=$value->sale_price?>" value="<?=$value->id?>"><?=$value->name?>(<?=$value->code?>)</option>
                                        <?php
                                    endforeach;
                                    ?>
                                </select>
                            </div>
                            <?php if (form_error('item_id')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('item_id'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-md-6 mb-3 imeiSerialHideShow">
                            <div class="form-group">
                                <label><?php echo lang('imei_serial'); ?> <span class="required_star">*</span></label>
                                <input readonly  autocomplete="off" onfocus="select()" id="expiry_imei_serial" type="text" name="expiry_imei_serial" class="form-control integerchk" placeholder="<?php echo lang('imei_serial'); ?>" value="<?=$installment->expiry_imei_serial?>">
                                <input type="hidden" id="item_type" name="item_type" value="<?=$installment->item_type?>">
                            </div>
                            <div class="alert alert-error error-msg imei_serial_field_err_msg_contnr ">
                                <p id="imei_serial_field_err_msg"></p>
                            </div> 
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label><?php echo lang('price'); ?> <span class="required_star">*</span></label>
                                <input  autocomplete="off" onfocus="select()" id="price" type="text" name="price" class="form-control change_data integerchk" placeholder="<?php echo lang('price'); ?>" value="<?=getAmtPre($installment->price)?>">
                            </div>
                            <?php if (form_error('price')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('price'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label><?php echo lang('discount'); ?></label> 
                                <input  autocomplete="off" onfocus="select()" type="text" id="discount" name="discount" class="form-control change_data discount integerchk" placeholder="<?php echo lang('discount'); ?>" value="<?=getAmtPre($installment->discount)?>">
                            </div>
                            <?php if (form_error('discount')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('discount'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label><?php echo lang('number_of_installment'); ?> <span class="required_star">*</span></label>
                                <input  autocomplete="off" min="1" type="number" id="number_of_installment" name="number_of_installment" class="form-control" placeholder="<?php echo lang('number_of_installment'); ?>" value="<?=$installment->number_of_installment?>">
                            </div>
                            <?php if (form_error('number_of_installment')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('number_of_installment'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label><?php echo lang('percentage_of_interest'); ?> <span class="required_star">*</span></label>
                                <input  autocomplete="off" min="0" type="number" id="percentage_of_interest" name="percentage_of_interest" class="form-control change_data integerchk" placeholder="<?php echo lang('percentage_of_interest'); ?>" value="<?=$installment->percentage_of_interest?>">
                            </div>
                            <?php if (form_error('percentage_of_interest')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('percentage_of_interest'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label><?php echo lang('shipping_other'); ?></label>
                                <input  autocomplete="off" type="text" id="shipping_other" name="shipping_other" class="form-control change_data integerchk" placeholder="<?php echo lang('shipping_other'); ?>" value="<?=getAmtPre($installment->shipping_other)?>">
                            </div>
                            <?php if (form_error('shipping_other')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('shipping_other'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label><?php echo lang('total'); ?> <span class="required_star">*</span></label>
                                <input  autocomplete="off" readonly type="text" id="total" name="total" class="form-control integerchk" placeholder="<?php echo lang('total'); ?>" value="<?=escape_output(getAmtPre($installment->total))?>">
                            </div>
                            <?php if (form_error('total')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('total'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label><?php echo lang('down_payment'); ?></label>
                                <input  autocomplete="off" type="text" id="down_payment_cal" name="down_payment" class="form-control change_data integerchk" placeholder="<?php echo lang('down_payment'); ?>" value="<?=getAmtPre($installment->down_payment)?>">
                            </div>
                            <?php if (form_error('down_payment')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('down_payment'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label><?php echo lang('remaining'); ?> <span class="required_star">*</span></label>
                                <input  autocomplete="off" readonly id="remaining" type="text" name="remaining" class="form-control integerchk" placeholder="<?php echo lang('remaining'); ?>" value="<?=escape_output(getAmtPre($installment->remaining))?>">
                            </div>
                            <?php if (form_error('remaining')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('remaining'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label><?php echo lang('down_payment_account'); ?> <span class="required_star">*</span></label>
                                <select  class="form-control select2 op_width_100_p" id="payment_method_id" name="payment_method_id">
                                    <option value=""><?php echo lang('select'); ?></option>
                                    <?php foreach ($paymentMethods as $ec) { ?>
                                        <option value="<?php echo escape_output($ec->id) ?>" 
                                            <?php
                                            if ($installment->payment_method_id == $ec->id) {
                                                echo "selected";
                                            }
                                            ?> data-type="<?php echo escape_output($ec->account_type); ?>">
                                            <?php echo escape_output($ec->name) ?></option>
                                    <?php } ?>
                                </select>
                                <input type="hidden" id="account_type" name="account_type" value="<?php echo escape_output($installment->account_type);?>">
                            </div>
                            <?php if (form_error('payment_method_id')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('payment_method_id'); ?></span>
                                </div>
                            <?php } ?>
                            <div class="alert alert-error error-msg payment_method_id_err_msg_contnr ">
                                <p id="payment_method_id_err_msg"></p>
                            </div>

                            <div id="show_account_type" class="mt-3">
                            <?php
                                $payment_method_type = $installment->payment_method_type;
                                if($payment_method_type != ''){
                                $payment_m_type = json_decode($installment->payment_method_type, TRUE);
                                foreach($payment_m_type as $key=>$p_type){ ?>
                                <div class="form-group mb-2">
                                    <label><?php echo lang(escape_output($key));?></label>
                                    <input type="text" name="<?php echo escape_output($key);?>" class="form-control" placeholder="" value="<?php echo escape_output($p_type);?>">
                                </div>
                            <?php } } ?>
                            </div>
                        </div> 
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label><?php echo lang('Installment_Schedule'); ?> <span class="required_star">*</span></label>
                                    <div class="ms-3 op_right op_font_18 op_cursor_pointer">
                                        <i data-tippy-content="<?php echo lang('Weekly_then_enter_7'); ?>" class="fa-regular fa-circle-question tippyBtnCall font-16 theme-color"></i>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <input  autocomplete="off" min="1" type="number" id="installment_type" name="installment_type" class="form-control w-95-p" placeholder="<?php echo lang('Installment_Schedule');?>" value="<?=$installment->installment_type?>">
                                    <button data-tippy-content="<?php echo lang('must_click_notification'); ?>" class="new-btn h-40 ms-2 next_button tippyBtnCall">
                                        <?php echo lang('next'); ?>
                                        <iconify-icon icon="solar:arrow-right-broken" width="18"></iconify-icon>
                                    </button>
                                </div>
                            </div>
                            <?php if (form_error('installment_type')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('installment_type'); ?></span>
                                </div>
                            <?php } ?>  
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6">
                        <h3 class="margin_top_0 inst-heading"><?php echo lang('installments'); ?></h3>
                        <table class="table table-border">
                            <thead>
                            <tr>
                                <th><?php echo lang('sn'); ?></th>
                                <th><?php echo lang('amount_of_installment'); ?></th>
                                <th><?php echo lang('payment_date'); ?></th>
                                <th><?php echo lang('delete'); ?></th>
                            </tr>

                            </thead>
                            <tbody class="show_tb_data">
                            <?php
                                $i = 1;
                                foreach ($installment_payments as $vl):
                            ?>
                                    <input type="hidden" name="paid_status[]" value="<?=$vl->paid_status?>">
                                    <tr>
                                        <td valign="middle"><?=$i?></td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control amount_of_payment check_required integerchk1" value="<?=escape_output(getAmtPre($vl->amount_of_payment))?>" onfocus="select()" name="amount_of_payment[]">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control customDatepicker  check_required" value="<?=$vl->payment_date?>" readonly="" name="payment_date[]">
                                            </div>
                                        </td>
                                        <td>
                                            <button type="button" class="new-btn-danger h-40">
                                                <iconify-icon icon="solar:trash-bin-minimalistic-broken" width="18" class="delete_row del-btn-c"></iconify-icon>
                                            </button>
                                        </td>
                                    </tr>

                            <?php
                                    $i++;
                                endforeach;
                            ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th class="op_right"><?php echo lang('total'); ?></th>
                                <th><span class="total_amount op_padding_left_12"></span></th>
                                <th></th>
                                <th></th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
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
                <a class="btn bg-blue-btn text-decoration-none" href="<?php echo base_url() ?>Installment/installmentSales">
                    <iconify-icon icon="solar:undo-left-round-broken"></iconify-icon>
                    <?php echo lang('back'); ?>
                </a>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>



<!-- IMEI Serial Modal -->
<div class="modal fade" id="imei_serial_modal" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">&nbsp;</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i
                data-feather="x"></i></span></button>
            </div>
            <div class="modal-body scroll_body">
                <input type="hidden" class="modal_hidden_type">
                <div class="form-group">
                    <label>
                        <span class="imei_serial_label"></span> <span class="required_star">*</span>
                    </label>
                    <select name="expiry_imei_serial" id="IMEI_Serial" class="form-control select2">
                    </select>
                    <div class="alert alert-error error-msg imei_serial_err_msg_contnr ">
                        <p id="imei_serial_err_msg"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-blue-btn" id="imei_serial_submit"><?php echo lang('submit'); ?></button>
                <button type="button" class="btn bg-blue-btn" data-bs-dismiss="modal"><?php echo lang('close'); ?></button>
            </div>
        </div>
    </div>
</div>





