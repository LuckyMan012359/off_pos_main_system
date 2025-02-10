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
        echo $this->session->flashdata('exception_1');
        echo '</div></div></section>';
    }
    ?>


    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo lang('sms_setting'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('sms_setting'), 'secondSection'=> lang('sms_setting')])?>
        </div>
    </section>

    

    <!-- Main content -->
    <section class="box-wrapper">
    <h3 class="display_none">&nbsp;</h3>
        <div class="table-box">
            <?php echo form_open(base_url() . 'POS_setting/smsSetting/'.(isset($smsSetting) && $smsSetting->id?$smsSetting->id:''), $arrayName = array('id' => 'add_whitelabel','enctype'=>'multipart/form-data')) ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label><?php echo lang('SMS_Provider');?></label>
                            <select class="form-control select2" name="enable_status" id="enable_status">
                                <option <?=isset($smsSetting) && $smsSetting->enable_status=="0"?'selected':''?> <?php echo set_select('enable_status', "0"); ?>  value="0">None</option>
                                <option  <?=isset($smsSetting) && $smsSetting->enable_status=="1"?'selected':''?>   <?php echo set_select('enable_status', "1"); ?>   value="1">OnnorokomSMS</option>
                            </select>
                        </div>
                        <?php if (form_error('enable_status')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('enable_status'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="clearfix"></div>
                    <div class="clearfix"></div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label>SMS Username</label>
                            <input type="text" name="user_name" value="<?=isset($smsSetting) && $smsSetting->user_name?$smsSetting->user_name:set_value('user_name')?>" placeholder="User Name" id="user_name" class="form-control">
                        </div>
                        <?php if (form_error('user_name')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('user_name'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label>Password</label>
                            <input type="text" name="password" value="<?=isset($smsSetting) && $smsSetting->password?$smsSetting->password:set_value('password')?>" placeholder="Password" id="password" class="form-control">
                        </div>
                        <?php if (form_error('password')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('password'); ?></span>
                            </div>
                        <?php } ?>
                    </div> <div class="clearfix"></div>
                    <div class="col-md-12 op_display_none" >
                        <h3>For Text Local</h3>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-3 op_display_none" >
                        <div class="form-group mb-3">
                            <label>SMS Username</label>
                            <input type="text" name="user_name1" value="<?=isset($smsSetting) && $smsSetting->user_name1?$smsSetting->user_name1:set_value('user_name1')?>" placeholder="User Name" id="user_name1" class="form-control">
                        </div>
                        <?php if (form_error('user_name1')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('user_name1'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-3 op_display_none" >
                        <div class="form-group mb-3">
                            <label>Password</label>
                            <input type="text" name="password1" value="<?=isset($smsSetting) && $smsSetting->password1?$smsSetting->password1:set_value('password1')?>" placeholder="Password" id="password1" class="form-control">
                        </div>
                        <?php if (form_error('password1')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('password1'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-3 op_display_none" >
                        <div class="form-group mb-3">
                            <label>APIKey</label>
                            <input type="text" name="apikey" value="<?=isset($smsSetting) && $smsSetting->apikey?$smsSetting->apikey:set_value('apikey')?>" placeholder="APIKey" id="apikey" class="form-control">
                        </div>
                        <?php if (form_error('apikey')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('apikey'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
            
                    <div class="clearfix"></div>
                    <div class="col-md-6 op_display_none">
                        <?php
                        $s_field_5 = set_value('field_5');
                        ?>
                        <div class="form-group mb-3">
                            <label><input <?=isset($s_field_5) && $s_field_5==1?'checked':''?>  <?=isset($smsSetting->field_5) && $smsSetting->field_5==1?'checked':''?>  type="checkbox" name="field_5" value="1"> Customer will get SMS notification when an order is in delivered?</label>
                            <select name="field_5_v"  class="form-control">
                                <option <?php echo set_select('field_5_v', "No"); ?> <?=isset($smsSetting->field_5_v) && $smsSetting->field_5_v=="No"?'selected':''?> value="No">No</option>
                                <option <?php echo set_select('field_5_v', "Yes"); ?> <?=isset($smsSetting->field_5_v) && $smsSetting->field_5_v=="Yes"?'selected':''?> value="Yes">Yes</option>
                            </select>
                            <?php if (form_error('field_5_v')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('field_5_v'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                
                    <div class="clearfix"></div>


                </div>
            </div>

            <div class="box-footer">
                <button type="submit" name="submit" value="submit" class="btn bg-blue-btn">
                    <iconify-icon icon="solar:upload-minimalistic-broken"></iconify-icon>
                    <?php echo lang('submit'); ?>
                </button>
                <a class="btn bg-blue-btn text-decoration-none" href="<?php echo base_url() ?>POS_setting/setting">
                    <iconify-icon icon="solar:undo-left-round-broken"></iconify-icon>
                    <?php echo lang('back'); ?>
                </a>
            </div>

            <?php echo form_close(); ?>
        </div>
    </section>
</div>
<script src="<?php echo base_url(); ?>frequent_changing/js/sms_setting.js"></script>