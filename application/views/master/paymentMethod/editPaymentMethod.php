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
                <h3 class="top-left-header mt-2"><?php echo lang('edit_account'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('payment_method'), 'secondSection'=> lang('edit_account')])?>
        </div>
    </section>

    <div class="box-wrapper">
        <div class="table-box"> 
            <?php echo form_open(base_url('PaymentMethod/addEditPaymentMethod/' . $encrypted_id)); ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('account_name'); ?> <span class="required_star">*</span></label>
                            <input <?php echo $payment_method_information->is_deletable == 'No' ? 'readonly' : '' ?> autocomplete="off" type="text" name="name" class="form-control" placeholder="<?php echo lang('account_name'); ?>" value="<?php echo escape_output($payment_method_information->name); ?>">
                        </div>
                        <?php if (form_error('name')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('name'); ?></span>
                            </div>
                        <?php } ?>

                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('description'); ?></label>
                            <input <?php echo escape_output($payment_method_information->name) == 'Cash' ? 'readonly' : '' ?>  autocomplete="off" type="text" name="description" class="form-control" placeholder="<?php echo lang('description'); ?>" value="<?php echo escape_output($payment_method_information->description); ?>">
                        </div>
                        <?php if (form_error('description')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('description'); ?></span>
                            </div>
                        <?php } ?> 
                    </div> 
                    
                    
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('opening_balance'); ?></label>
                            <input  autocomplete="off" type="text" name="current_balance" class="form-control integerchk" placeholder="<?php echo lang('current_balance'); ?>" value="<?php echo escape_output($payment_method_information->current_balance); ?>">
                        </div>
                        <?php if (form_error('current_balance')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('current_balance'); ?></span>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('status'); ?> <span class="required_star">*</span></label>
                            <select name="status" id="status" class="form-control select2">
                                <option><?php echo lang('select');?></option>
                                <option <?php echo escape_output($payment_method_information->status == 'Enable' ? 'selected' : ''); ?> value="Enable"><?php echo lang('Enable');?></option>
                                <option <?php echo escape_output($payment_method_information->status == 'Disable' ? 'selected' : ''); ?> value="Disable"><?php echo lang('Disable');?></option>
                            </select>
                        </div>
                    </div>


                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('account_type'); ?> <span class="required_star">*</span></label>
                            <select <?php echo $payment_method_information->is_deletable == "No" ? 'disabled' : '' ?> name="account_type" id="account_type" class="form-control select2">
                                <option><?php echo lang('select');?></option>
                                <option value="Cash" <?php echo escape_output($payment_method_information->account_type == 'Cash' ? 'selected' : ''); ?>><?php echo lang('Cash');?></option>
                                <option value="Bank_Account" <?php echo escape_output($payment_method_information->account_type == 'Bank_Account' ? 'selected' : ''); ?>><?php echo lang('Bank_Account');?></option>
                                <option value="Card" <?php echo escape_output($payment_method_information->account_type == 'Card' ? 'selected' : ''); ?>><?php echo lang('Card');?></option>
                                <option value="Mobile_Banking" <?php echo escape_output($payment_method_information->account_type == 'Mobile_Banking' ? 'selected' : ''); ?>><?php echo lang('Mobile_Banking');?></option>
                                <option value="Paypal" <?php echo escape_output($payment_method_information->account_type == 'Paypal' ? 'selected' : ''); ?>><?php echo lang('Paypal');?></option>
                                <option value="Stripe" <?php echo escape_output($payment_method_information->account_type == 'Stripe' ? 'selected' : ''); ?>><?php echo lang('Stripe');?></option>
                            </select>
                            <?php if($payment_method_information->name == 'Cash'){ ?>
                                <input type="hidden" name="account_type" value="Cash">
                            <?php } ?>
                        </div>
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
                <a class="btn bg-blue-btn text-decoration-none" href="<?php echo base_url() ?>PaymentMethod/paymentMethods">
                    <iconify-icon icon="solar:undo-left-round-broken"></iconify-icon>
                    <?php echo lang('back'); ?>
                </a>
            </div>
            <?php echo form_close(); ?> 
        </div>
    </div>
</div>