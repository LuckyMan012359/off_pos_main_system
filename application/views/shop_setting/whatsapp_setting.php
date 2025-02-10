<?php 
$register_content = json_decode($outlet_information->register_content);
?>
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
                <h3 class="top-left-header mt-2"><?php echo lang('whatsapp_setting'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('setting'), 'secondSection'=> lang('setting')])?>
        </div>
    </section>


    <div class="box-wrapper">
        <div class="table-box">
            <?php
            $attributes = array('id' => 'restaurant_setting_form');
            echo form_open_multipart(base_url('Setting/whatsappSetting'),$attributes); ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('whatsapp_invoice_status'); ?>  <span
                                    class="required_star">*</span></label>
                            <select  class="form-control select2 whatsapp_invoice_enable_status" name="whatsapp_invoice_enable_status"
                                id="whatsapp_invoice_enable_status">
                                <option <?php echo set_select('whatsapp_invoice_enable_status','Enable')?> value="Enable" <?=($outlet_information->whatsapp_invoice_enable_status == 'Enable' ? 'selected':'')?>><?php echo lang('enable'); ?></option>
                                <option <?php echo set_select('whatsapp_invoice_enable_status','Disable')?> value="Disable" <?=($outlet_information->whatsapp_invoice_enable_status == 'Disable' ?'selected':'')?>><?php echo lang('disable'); ?></option>
                            </select>
                        </div>
                        <?php if (form_error('whatsapp_invoice_enable_status')) { ?>
                        <div class="callout callout-danger my-2">
                            <?php echo form_error('whatsapp_invoice_enable_status'); ?>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('whatsapp_app_key'); ?> <span class="required_star">*</span></label>
                            <input onfocus="select()" autocomplete="off" type="text" id="whatsapp_app_key" name="whatsapp_app_key"
                            class="form-control" placeholder="<?php echo lang('whatsapp_app_key'); ?>"
                            value="<?php echo escape_output( APPLICATION_MODE == "demo" ? 'XXXXXXXXXXXXXXXXXXXX' : $outlet_information->whatsapp_app_key ); ?>">
                        </div>
                        <?php if (form_error('whatsapp_app_key')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('whatsapp_app_key'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('whatsapp_authkey'); ?> <span class="required_star">*</span></label>
                            <input onfocus="select()" autocomplete="off" type="text" id="whatsapp_authkey" name="whatsapp_authkey"
                            class="form-control" placeholder="<?php echo lang('whatsapp_authkey'); ?>"
                            value="<?php echo escape_output(APPLICATION_MODE == "demo" ? 'XXXXXXXXXXXXXXXXXXXX' : $outlet_information->whatsapp_authkey); ?>">
                        </div>
                        <?php if (form_error('whatsapp_authkey')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('whatsapp_authkey'); ?></span>
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
    </div>
</div> 

<script src="<?php echo base_url(); ?>frequent_changing/js/edit_outlet.js"></script>