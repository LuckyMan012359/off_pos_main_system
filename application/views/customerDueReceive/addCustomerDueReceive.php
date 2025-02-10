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


<script src="<?php echo base_url(); ?>frequent_changing/js/addCustomerDueReceive.js"></script>
<input type="hidden" value="<?php echo lang('current_due'); ?>" id="current_due">
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
                <h3 class="top-left-header mt-2"><?php echo lang('add_customer_due_receive'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('customer_due_receive'), 'secondSection'=> lang('add_customer_due_receive')])?>
        </div>
    </section>

    <!-- Main content -->
    <div class="box-wrapper">
        <div class="table-box">
            <?php echo form_open(base_url('Customer_due_receive/addCustomerDueReceive')); ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('ref_no'); ?></label>
                            <input  autocomplete="off" type="text" id="reference_no" readonly name="reference_no" class="form-control" placeholder="<?php echo lang('ref_no'); ?>" value="<?php echo escape_output($reference_no); ?>">
                        </div>
                        <?php if (form_error('reference_no')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('reference_no'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-4 mb-3">

                        <div class="form-group">
                            <label><?php echo lang('date'); ?> <span class="required_star">*</span></label>
                            <input  autocomplete="off" type="text"  readonly name="date" class="form-control customDatepicker" placeholder="<?php echo lang('date'); ?>" value="<?=date('Y-m-d',strtotime('today'))?>">
                        </div>
                        <?php if (form_error('date')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('date'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('customer'); ?> <span class="required_star">*</span></label>
                            <select  class="form-control select2 op_width_100_p" id="customer_id" name="customer_id">
                                <option value=""><?php echo lang('select'); ?></option>
                                <?php foreach ($customers as $customer) { ?>
                                    <option value="<?php echo escape_output($customer->id) ?>" <?php echo set_select('customer_id', $customer->id); ?>><?php echo escape_output($customer->name ." ". $customer->phone)?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="alert alert-info" id="remaining_due"></div>
                        <?php if (form_error('customer_id')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('customer_id'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group"> 
                            <label><?php echo lang('amount'); ?> <span class="required_star">*</span></label>
                            <input  autocomplete="off" type="text" id="amount" name="amount" onfocus="this.select();" class="form-control op_width_100_p integerchk" placeholder="<?php echo lang('amount'); ?>" value="<?php echo set_value('amount'); ?>">
                        </div>
                        <?php if (form_error('amount')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('amount'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('payment_methods'); ?> <span class="required_star">*</span></label>
                            <select  class="form-control select2 op_width_100_p" id="payment_method_id" name="payment_method_id">
                                <option value=""><?php echo lang('select'); ?></option>
                                <?php foreach ($paymentMethods as $ec) { ?>
                                    <option value="<?php echo escape_output($ec->id) ?>" <?php echo set_select('payment_method_id', $ec->id); ?> data-type="<?php echo escape_output($ec->account_type); ?>"><?php echo escape_output($ec->name) ?></option>
                                <?php } ?>
                            </select>
                            <input type="hidden" id="account_type" name="account_type">
                        </div>
                        <?php if (form_error('payment_method_id')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('payment_method_id'); ?></span>
                            </div>
                        <?php } ?>

                        <div id="show_account_type" class="mt-3">

                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('note'); ?></label>
                            <textarea  class="form-control" name="note" placeholder="<?php echo lang('note'); ?> ..."><?php echo $this->input->post('note'); ?></textarea>
                        </div> 
                        <?php if (form_error('note')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('note'); ?></span>
                            </div>
                        <?php } ?>  
                    </div> 

                </div>
                <!-- /.box-body -->
            </div> 
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
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
                <a class="btn bg-blue-btn text-decoration-none" href="<?php echo base_url() ?>Customer_due_receive/customerDueReceives">
                    <iconify-icon icon="solar:undo-left-round-broken"></iconify-icon>
                    <?php echo lang('back'); ?>
                </a>
            </div>
            <?php echo form_close(); ?>
        </div> 
    </div>
</div>


