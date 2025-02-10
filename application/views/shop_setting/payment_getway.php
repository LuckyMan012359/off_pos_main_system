<div class="main-content-wrapper">
    <?php
    if ($this->session->flashdata('exception')) {
        echo '<section class="alert-wrapper"><div class="alert alert-success alert-dismissible fade show"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></button>
        <div class="alert-body"><i class="icon fa fa-check me-2"></i>';
        echo escape_output($this->session->flashdata('exception'));unset($_SESSION['exception']);
        echo '</div></div></section>';
    }
    ?>

    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo lang('payment_getway'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('payment_getway'), 'secondSection'=> lang('payment_getway')])?>
        </div>
    </section>


    <div class="box-wrapper">
        <div class="table-box">
            <?php
            $attributes = array('id' => 'payment_getway');
            echo form_open_multipart(base_url('Payment_getway/paymentGetway'),$attributes); ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-12">
                        <h5><?php echo lang('Strip');?></h5>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <label> <?php echo lang('status'); ?> <span
                            class="required_star">*</span></label>
                            <select  class="form-control select2" name="action_type_stripe" id="action_type_stripe">
                                <?php if($payment_getway){?>
                                <option <?php echo escape_output($payment_getway->action_type_stripe) == 'Enable' ? 'selected' : '';?> value="Enable"><?php echo lang('Enable'); ?></option>
                                <option <?php echo escape_output($payment_getway->action_type_stripe) == 'Disable' ? 'selected' : '';?> value="Disable"><?php echo lang('Disable'); ?></option>
                                <?php } else{ ?>
                                    <option value=""><?php echo lang('select'); ?> <?php echo lang('status'); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="clear-fix"></div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label> <?php echo lang('Stripe_Secret_Key'); ?> <span
                            class="required_star">*</span></label>
                            <input type="text" class="form-control" name="stripe_api_key" id="stripe_api_key" placeholder="<?php echo lang('Stripe_Secret_Key'); ?>" value="<?php echo escape_output(APPLICATION_MODE == "demo" ? 'XXXXXXXXXXXXXXXXXXXX' : $payment_getway->stripe_api_key);?>">
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label> <?php echo lang('Stripe_Publishable_Key'); ?> <span
                            class="required_star">*</span></label>
                            <input type="text" class="form-control" name="stripe_publishable_key" id="stripe_publishable_key" placeholder="<?php echo lang('Stripe_Publishable_Key'); ?>" value="<?php echo escape_output(APPLICATION_MODE == "demo" ? 'XXXXXXXXXXXXXXXXXXXX' : $payment_getway->stripe_publishable_key);?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <h5><?php echo lang('Paypal'); ?></h5>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <label> <?php echo lang('status'); ?> <span
                            class="required_star">*</span></label>
                            <select  class="form-control select2" name="action_type_paypal" id="action_type_paypal">
                                <?php if($payment_getway){?>
                                <option <?php echo escape_output($payment_getway->action_type_paypal) == 'Enable' ? 'selected' : '';?> value="Enable"><?php echo lang('Enable'); ?></option>
                                <option <?php echo escape_output($payment_getway->action_type_paypal) == 'Disable' ? 'selected' : '';?> value="Disable"><?php echo lang('Disable'); ?></option>
                                <?php } else{ ?>
                                    <option value=""><?php echo lang('select'); ?> <?php echo lang('status'); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="clear-fix"></div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label> <?php echo lang('paypal_user_name'); ?> <span
                            class="required_star">*</span></label>
                            <input type="text" class="form-control" name="paypal_user_name"  placeholder="<?php echo lang('paypal_user_name'); ?>" value="<?php echo escape_output(APPLICATION_MODE == "demo" ? 'XXXXXXXXXXXXXXXXXXXX' : $payment_getway->paypal_user_name);?>">
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label> <?php echo lang('paypal_password'); ?> <span
                            class="required_star">*</span></label>
                            <input type="text" class="form-control" name="paypal_password" placeholder="<?php echo lang('paypal_password'); ?>" value="<?php echo escape_output(APPLICATION_MODE == "demo" ? 'XXXXXXXXXXXXXXXXXXXX' : $payment_getway->paypal_password);?>">
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label> <?php echo lang('paypal_signature'); ?> <span
                            class="required_star">*</span></label>
                            <input type="text" class="form-control" name="paypal_signature" placeholder="<?php echo lang('paypal_signature'); ?>" value="<?php echo escape_output(APPLICATION_MODE == "demo" ? 'XXXXXXXXXXXXXXXXXXXX' : $payment_getway->paypal_signature);?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" name="submit" value="submit" class="btn bg-blue-btn">
                    <iconify-icon icon="solar:upload-minimalistic-broken"></iconify-icon>
                    <?php echo lang('submit'); ?>
                </button>
            </div>
        <?php echo form_close(); ?>
        </div>
    </div>
</div>









