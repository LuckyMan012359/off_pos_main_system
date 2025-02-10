<script src="<?php echo base_url('frequent_changing/js/email_setting.js'); ?>"></script>

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
    <?php
    if ($this->session->flashdata('exception_1')) {

        echo '<section class="alert-wrapper"><div class="alert alert-danger alert-dismissible"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></button>
        <div class="alert-body"><i class="icon fa fa-check me-2"></i>';
        echo $this->session->flashdata('exception_1');unset($_SESSION['exception_1']);
        echo '</div></div></section>';
    }
    ?>


    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo lang('Email_Setting'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('Email_Setting'), 'secondSection'=> lang('Email_Setting')])?>
        </div>
    </section>

    <!-- Main content -->
    <section class="box-wrapper">
    <h3 class="display_none">&nbsp;</h3>
        <div class="table-box">

            <?php
            $company_id = $this->session->userdata('company_id');
            $company = getCompanyInfo();
            $smtEmail = isset($company->smtp_details) && $company->smtp_details?json_decode($company->smtp_details):'';
            ?>

            <?php echo form_open(base_url() . 'Email_setting/emailSetting', $arrayName = array('id' => 'add_whitelabel','enctype'=>'multipart/form-data')) ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label><?php echo lang('email_service_type'); ?> <span class="required_star">*</span></label>
                            <select class="form-control select2 smtp_type" name="smtp_type">
                                <option value="Gmail" <?php echo escape_output($company->smtp_type) == 'Gmail' ? 'selected' : '' ?>><?php echo lang('Gmail'); ?></option>
                                <option value="Sendinblue" <?php echo escape_output($company->smtp_type) == 'Sendinblue' ? 'selected' : '' ?>><?php echo lang('Sendinblue'); ?></option>
                            </select>
                        </div>
                        <?php if (form_error('smtp_type')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('smtp_type'); ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label>SMTP Host <span class="required_star">*</span></label>
                            <input type="text" name="host_name" placeholder="SMTP Host"  value="<?php echo isset($smtEmail) && $smtEmail->host_name?(APPLICATION_MODE == "demo" ? 'XXXXXXXXXXXXXXXXXXXX' : $smtEmail->host_name):set_value('host_name')?>" id="host_name" class="form-control">
                        </div>
                        <?php if (form_error('host_name')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('host_name'); ?></span>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label>Port Address <span class="required_star">*</span></label>
                            <input type="text" name="port_address" value="<?php echo isset($smtEmail) && $smtEmail->port_address?(APPLICATION_MODE == "demo" ? 'XXXXXXXXXXXXXXXXXXXX' : $smtEmail->port_address):set_value('port_address')?>"  placeholder="<?php echo lang('PortAddress'); ?>" id="port_address" class="form-control">
                        </div>
                        <?php if (form_error('port_address')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('port_address'); ?></span>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label>Encryption<span class="required_star">*</span></label>
                            <input type="text" name="encryption" value="<?php echo isset($smtEmail) && $smtEmail->encryption?(APPLICATION_MODE == "demo" ? 'XXXXXXXXXXXXXXXXXXXX' : $smtEmail->encryption):set_value('encryption')?>"  placeholder="<?php echo lang('encryption'); ?>" id="encryption" class="form-control">
                        </div>
                        <?php if (form_error('encryption')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('encryption'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="clearfix"></div>


                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label>Username <span class="required_star">*</span></label>
                            <input type="text" name="user_name" value="<?php echo isset($smtEmail) && $smtEmail->user_name?(APPLICATION_MODE == "demo" ? 'XXXXXXXXXXXXXXXXXXXX' : $smtEmail->user_name):set_value('user_name')?>" placeholder="User Name" id="user_name" class="form-control">
                        </div>
                        <?php if (form_error('user_name')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('user_name'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label>Password <span class="required_star">*</span></label>
                            <input type="text" name="password" value="<?php echo isset($smtEmail) && $smtEmail->password?(APPLICATION_MODE == "demo" ? 'XXXXXXXXXXXXXXXXXXXX' : $smtEmail->password):set_value('password')?>" placeholder="Password" id="password" class="form-control">
                        </div>
                        <?php if (form_error('password')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('password'); ?></span>
                            </div>
                        <?php } ?>
                    </div>


                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label>From Name <span class="required_star">*</span></label>
                            <input type="text" name="from_name" value="<?php echo isset($smtEmail) && $smtEmail->from_name?(APPLICATION_MODE == "demo" ? 'XXXXXXXXXXXXXXXXXXXX' : $smtEmail->from_name):set_value('from_name')?>" placeholder="<?php echo lang('from_name');?>" id="from_name" class="form-control">
                        </div>
                        <?php if (form_error('from_name')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('from_name'); ?></span>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label>From Email <span class="required_star">*</span></label>
                            <input type="email" name="from_email" value="<?php echo isset($smtEmail) && $smtEmail->from_email?(APPLICATION_MODE == "demo" ? 'XXXXXXXXXXXXXXXXXXXX' : $smtEmail->from_email):set_value('from_email')?>" placeholder="<?php echo lang('from_email');?>" id="from_email" class="form-control">
                        </div>
                        <?php if (form_error('from_email')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('from_email'); ?></span>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label>Status <span class="required_star">*</span></label>
                            <select class="form-control select2 width_100_p" name="smtp_enable_status">
                                <option <?php echo $company->smtp_enable_status=="1"?'selected':''?><?php echo set_select('smtp_enable_status', "1"); ?>  value="1"><?php echo lang('Enable'); ?></option>
                                <option  <?php echo $company->smtp_enable_status=="2"?'selected':''?><?php echo set_select('enable_status', "2"); ?>   value="2"><?php echo lang('Disable'); ?></option>
                            </select>
                        </div>
                        <?php if (form_error('smtp_enable_status')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('smtp_enable_status'); ?></span>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-md-12 hide_show_div">
                        <div class="form-group mb-3">
                            <label>API Key <span class="required_star">*</span></label>
                            <input type="text" name="api_key" value="<?php echo isset($smtEmail) && $smtEmail->api_key?(APPLICATION_MODE == "demo" ? 'XXXXXXXXXXXXXXXXXXXX' : $smtEmail->api_key):set_value('api_key')?>" placeholder="API Key" id="api_key" class="form-control">
                        </div>
                        <?php if (form_error('api_key')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('api_key'); ?></span>
                            </div>
                        <?php } ?>
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
    </section>
</div>
