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
                <h3 class="top-left-header mt-2"><?php echo lang('edit_income'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('income'), 'secondSection'=> lang('edit_income')])?>
        </div>
    </section>

    <div class="box-wrapper">
    <!-- general form elements -->
        <div class="table-box">
            <!-- /.box-header -->
            <!-- form start -->
            <?php echo form_open(base_url('Income/addEditIncome/' . $encrypted_id)); ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('ref_no'); ?></label>
                            <input  autocomplete="off" type="text" id="reference_no" readonly name="reference_no" class="form-control" placeholder="<?php echo lang('ref_no'); ?>" value="<?php echo escape_output($income_information->reference_no); ?>">
                        </div>
                        <?php if (form_error('reference_no')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('reference_no'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">

                        <div class="form-group">
                            <label><?php echo lang('date'); ?> <span class="required_star">*</span></label>
                            <input  autocomplete="off" type="text" name="date" readonly class="form-control customDatepicker" placeholder="<?php echo lang('date'); ?>" value="<?php echo date("Y-m-d", strtotime($income_information->date)); ?>">
                        </div>
                        <?php if (form_error('date')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('date'); ?></span>
                            </div>
                        <?php } ?>
                    </div>   
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('amount'); ?> <span class="required_star">*</span></label>
                            <input id="amount"  autocomplete="off" type="text" name="amount" onfocus="this.select();"  class="form-control integerchk" placeholder="<?php echo lang('amount'); ?>" value="<?php echo escape_output($income_information->amount); ?>">
                        </div>
                        <?php if (form_error('amount')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('amount'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                
                    <div class="col-md-6 col-lg-4 mb-3">
                            <div class="form-group">
                                <label><?php echo lang('category'); ?> <span class="required_star">*</span></label>
                                <select  class="form-control select2 op_width_100_p" name="category_id">
                                    <option value=""><?php echo lang('select'); ?></option>
                                    <?php foreach ($income_categories as $ec) { ?>
                                        <option value="<?php echo escape_output($ec->id) ?>" 
                                        <?php
                                        if ($income_information->category_id == $ec->id) {
                                            echo "selected";
                                        }
                                        ?>>
                                            <?php echo escape_output($ec->name) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <?php if (form_error('category_id')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('category_id'); ?></span>
                                </div>
                            <?php } ?>

                    </div>
                        
                    <div class="col-md-6 col-lg-4 mb-3"> 
                        <div class="form-group">
                            <label><?php echo lang('responsible_person'); ?> <span class="required_star">*</span></label>
                            <select  class="form-control select2 op_width_100_p" name="employee_id">
                                <option value=""><?php echo lang('select'); ?></option>
                                <?php foreach ($employees as $empls) { ?>
                                    <option value="<?php echo escape_output($empls->id) ?>" 
                                    <?php
                                    if ($income_information->employee_id == $empls->id) {
                                        echo "selected";
                                    }
                                    ?>>
                                        <?php echo escape_output($empls->full_name) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <?php if (form_error('employee_id')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('employee_id'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    
                    
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('payment_methods'); ?> <span class="required_star">*</span></label>
                            <select  class="form-control select2 op_width_100_p" id="payment_method_id" name="payment_method_id">
                                <option value=""><?php echo lang('select'); ?></option>
                                <?php foreach ($paymentMethods as $ec) { ?>
                                    <option value="<?php echo escape_output($ec->id) ?>" 
                                        <?php
                                        if ($income_information->payment_method_id == $ec->id) {
                                            echo "selected";
                                        }
                                        ?> data-type="<?php echo escape_output($ec->account_type); ?>">
                                        <?php echo escape_output($ec->name) ?></option>
                                <?php } ?>
                            </select>
                            <input type="hidden" id="account_type" name="account_type" value="<?php echo escape_output($income_information->account_type);?>">

                        </div>
                        <?php if (form_error('payment_method_id')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('payment_method_id'); ?></span>
                            </div>
                        <?php } ?>

                        <div id="show_account_type" class="mt-3">
                        <?php
                        $payment_method_type = $income_information->payment_method_type;
                        if($payment_method_type != ''){
                        $payment_m_type = json_decode($income_information->payment_method_type, TRUE);
                        foreach($payment_m_type as $key=>$p_type){ ?>
                            <div class="form-group mb-2">
                                <label><?php echo lang(escape_output($key));?></label>
                                <input type="text" name="<?php echo escape_output($key);?>" class="form-control" placeholder="" value="<?php echo escape_output($p_type);?>">
                            </div>
                        <?php } } ?>
                        </div>




                    </div> 
                    
                    
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('note'); ?></label>
                            <input  class="form-control" name="note" placeholder="<?php echo lang('note'); ?> ..." value="<?php echo escape_output($income_information->note); ?>">
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
                <a class="btn bg-blue-btn text-decoration-none" href="<?php echo base_url() ?>Income/incomes">
                    <iconify-icon icon="solar:undo-left-round-broken"></iconify-icon>
                    <?php echo lang('back'); ?>
                </a>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>frequent_changing/js/expense.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/income.js"></script>