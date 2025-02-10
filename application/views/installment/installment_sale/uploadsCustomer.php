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

            <!-- /.box-header -->
            <!-- form start -->
            <?php echo form_open_multipart(base_url('Installment/installmentCollections/' . $encrypted_id)); ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="form-group">
                            <label><?php echo lang('customer_name'); ?></label>
                            <input  autocomplete="off" readonly type="text" name="date" class="form-control" placeholder="<?php echo lang('customer_name'); ?>" value="<?=$payment_info->customer_name?>">
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 col-xl-3">

                        <div class="form-group">
                            <label><?php echo lang('product'); ?></label>
                            <input autocomplete="off" readonly type="text" name="date" class="form-control" placeholder="<?php echo lang('product'); ?>" value="<?=$payment_info->item_name?>">
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 col-xl-3">

                        <div class="form-group">
                            <label><?php echo lang('payment_date'); ?></label>
                            <input autocomplete="off" readonly type="text" name="date" class="form-control" placeholder="<?php echo lang('payment_date'); ?>" value="<?=$payment_info->payment_date?>">
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 col-xl-3">

                        <div class="form-group">
                            <label><?php echo lang('amount_of_installment'); ?></label>
                            <input autocomplete="off" readonly type="text" name="amount_of_payment" class="form-control" placeholder="<?php echo lang('amount_of_installment'); ?>" value="<?=$payment_info->amount_of_payment?>">
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 col-xl-3">

                        <div class="form-group">
                            <label><?php echo lang('payment_status'); ?></label>
                            <input autocomplete="off" readonly type="text" name="date" class="form-control" placeholder="<?php echo lang('payment_status'); ?>" value="<?=$payment_info->paid_status?>">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <hr>

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
                                        ?>>
                                            <?php echo escape_output($ec->name) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <?php if (form_error('payment_method_id')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('payment_method_id'); ?></span>
                                </div>
                            <?php } ?>
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