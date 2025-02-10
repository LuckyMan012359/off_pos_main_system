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


<div class="main-content-wrapper">

    <script src="<?php echo base_url(); ?>frequent_changing/js/payment_collect.js"></script>
    <div class="content-header">
        <h3 class="top-left-header">
            <?php echo lang('collection_form'); ?>
        </h3>
    </div>

    <!-- Main content -->
    <div class="box-wrapper">
        <!-- general form elements -->
        <div class="table-box">
            <!-- form start -->
            <?php echo form_open_multipart(base_url('Installment/installmentCollections/' . $encrypted_id)); ?>
            <div class="row">
                <div class="col-md-7 col-lg-6">
                    <table class="table view_details_table">
                        <tbody>
                            <tr>
                                <td class="view_detail_border_right"><b><?php echo lang('customer_name');?></b></td>
                                <td class="view_detail_border_right"> <?= escape_output($payment_info->customer_name) ?></td>
                            </tr>
                            <tr>
                                <td class="view_detail_border_right"><b><?php echo lang('product');?></b></td>
                                <td class="view_detail_border_right"> <?= escape_output($payment_info->item_name) ?></td>
                            </tr>
                            <tr>
                                <td class="view_detail_border_right"><b><?php echo lang('payment_date');?></b></td>
                                <td class="view_detail_border_right"> <?= date($this->session->userdata('date_format'), strtotime($payment_info->payment_date)); ?></td>
                            </tr>
                            <tr>
                                <td class="view_detail_border_right"><b><?php echo lang('amount_of_installment');?></b></td>
                                <td class="view_detail_border_right"> <?=escape_output($payment_info->amount_of_payment)?></td>
                                <input type="hidden" name="amount_of_installment"  value="<?=escape_output($payment_info->amount_of_payment)?>">
                            </tr>
                            <tr>
                                <td class="view_detail_border_right"><b><?php echo lang('payment_status');?></b></td>
                                <td class="view_detail_border_right"> <?=escape_output($payment_info->paid_status)?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <hr>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="form-group">
                            <label><?php echo lang('paid_amount'); ?></label>
                            <input autocomplete="off" type="text" id="paid_amount" name="paid_amount" class="form-control integerchk" placeholder="<?php echo lang('paid_amount'); ?>" value="<?=($payment_info->paid_status == 'Paid')?$payment_info->paid_amount:$payment_info->amount_of_payment?>">
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="form-group">
                            <label><?php echo lang('paid_date'); ?> <span class="required_star">*</span></label>
                            <input  autocomplete="off" readonly type="text" name="paid_date" class="form-control date customDatepicker" placeholder="<?php echo lang('paid_date'); ?>" value="<?=date('Y-m-d',strtotime('today'))?>">
                        </div>
                        <?php if (form_error('paid_date')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('paid_date'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="form-group">
                            <label><?php echo lang('payment_methods'); ?> <span class="required_star">*</span></label>
                            <select  class="form-control select2 op_width_100_p" id="payment_method_id" name="payment_method_id">
                                <option value=""><?php echo lang('select'); ?></option>
                                <?php foreach ($paymentMethods as $ec) { ?>
                                    <option value="<?php echo escape_output($ec->id) ?>" 
                                    <?php
                                    if ($payment_info->payment_method_id == $ec->id) {
                                        echo "selected";
                                    }
                                    ?> data-type="<?php echo escape_output($ec->account_type); ?>">
                                        <?php echo escape_output($ec->name) ?></option>
                                <?php } ?>
                            </select>
                            <input type="hidden" id="account_type" name="account_type" value="<?php echo escape_output($payment_info->account_type);?>">
                        </div>
                        <?php if (form_error('payment_method_id')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('payment_method_id'); ?></span>
                            </div>
                        <?php } ?>

                        <div id="show_account_type" class="mt-3">
                        <?php
                        if($payment_info->payment_method_type != ''){
                        $payment_method_type = json_decode($payment_info->payment_method_type, TRUE);
                        foreach($payment_method_type as $key=>$p_type){ ?>
                            <div class="form-group mb-2">
                                <label><?php echo lang(escape_output($key));?></label>
                                <input type="text" name="<?php echo escape_output($key);?>" class="form-control" placeholder="" value="<?php echo escape_output($p_type);?>">
                            </div>
                        <?php } } ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" name="submit" value="submit" class="btn bg-blue-btn check_required_field">
                    <iconify-icon icon="solar:upload-minimalistic-broken"></iconify-icon>
                    <?php echo lang('submit'); ?>
                </button>
                <a class="btn bg-blue-btn" href="<?php echo base_url() ?>Installment/installmentCollections">
                    <iconify-icon icon="solar:undo-left-round-broken"></iconify-icon>
                    <?php echo lang('back'); ?>
                </a>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>