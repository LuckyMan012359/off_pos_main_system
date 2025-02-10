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
                <h3 class="top-left-header mt-2"><?php echo lang('add_account'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('payment_method'), 'secondSection'=> lang('add_account')])?>
        </div>
    </section>


    <div class="box-wrapper">
        <div class="table-box"> 
            <!-- form start -->
            <?php echo form_open(base_url('PaymentMethod/addEditPaymentMethod')); ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('account_name'); ?> <span class="required_star">*</span></label>
                            <input  autocomplete="off" type="text" name="name" class="form-control" placeholder="<?php echo lang('account_name'); ?>" value="<?php echo set_value('name'); ?>">
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
                            <input  autocomplete="off" type="text" name="description" class="form-control" placeholder="<?php echo lang('description'); ?>" value="<?php echo set_value('description'); ?>">
                        </div>
                        <?php if (form_error('description')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('description'); ?></span>
                            </div>
                        <?php } ?>  
                    </div> 
                    
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('opening_balance'); ?> <span class="required_star">*</span></label>
                            <input  autocomplete="off" type="text" name="current_balance" class="form-control integerchk" placeholder="<?php echo lang('current_balance'); ?>" value="<?php echo set_value('current_balance'); ?>">
                        </div>
                        <?php if (form_error('current_balance')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('current_balance'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('status'); ?></label>
                            <select name="status" id="status" class="form-control select2">
                                <option><?php echo lang('select');?></option>
                                <option <?php echo set_select('status', 'Enable'); ?> value="Enable"><?php echo lang('Enable');?></option>
                                <option <?php echo set_select('status', 'Debit'); ?> value="Disable"><?php echo lang('Disable');?></option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('account_type'); ?> <span class="required_star">*</span></label>
                            <select name="account_type" id="account_type" class="form-control select2">
                                <option><?php echo lang('select');?></option>
                                <option <?php echo set_select('account_type', 'Cash'); ?> value="Cash"><?php echo lang('Cash');?></option>
                                <option <?php echo set_select('account_type', 'Bank_Account'); ?> value="Bank_Account"><?php echo lang('Bank_Account');?></option>
                                <option <?php echo set_select('account_type', 'Card'); ?> value="Card"><?php echo lang('Card');?></option>
                                <option <?php echo set_select('account_type', 'Mobile_Banking'); ?> value="Mobile_Banking"><?php echo lang('Mobile_Banking');?></option>
                                <option <?php echo set_select('account_type', 'Paypal'); ?> value="Paypal"><?php echo lang('Paypal');?></option>
                                <option <?php echo set_select('account_type', 'Stripe'); ?> value="Stripe"><?php echo lang('Stripe');?></option>
                            </select>
                        </div>
                    </div>
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
                <a class="btn bg-blue-btn text-decoration-none" href="<?php echo base_url() ?>PaymentMethod/paymentMethods">
                    <iconify-icon icon="solar:undo-left-round-broken"></iconify-icon>
                    <?php echo lang('back'); ?>
                </a>
            </div>

            <?php echo form_close(); ?>
        </div>
    </div>
</div>