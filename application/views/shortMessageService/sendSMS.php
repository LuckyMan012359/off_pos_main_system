<div class="main-content-wrapper">

    <?php  
    $title = lang('send') . ' ' . ucfirst($type) . ' ' . lang('sms');
    ?>

    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo $title; ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('sms_settings'), 'secondSection'=> $title])?>
        </div>
    </section>


    <section class="box-wrapper">
    <h3 class="display_none">&nbsp;</h3>
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="table-box">
                <!-- /.box-header -->
                <!-- form start -->
                <?php echo form_open(base_url('Short_message_service/sendSMS/'.$type)); ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <?php if($type == "test"){?>
                                <div class="form-group mb-3">
                                    <label><?php echo lang('number'); ?> <span class="required_star">*</span></label>
                                    <input  autocomplete="off" type="text" name="number" class="form-control" placeholder="<?php echo lang('number'); ?>" value="<?php echo set_value('number');?>">
                                </div>
                                <?php if (form_error('number')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <span class="error_paragraph"><?php echo form_error('number'); ?></span>
                                    </div>
                                <?php } ?>
                            <?php } ?>

                            <div class="form-group mb-3">
                                <label><?php echo lang('message'); ?> <span class="required_star">*</span></label> 
                                <textarea  class="form-control" name="message" placeholder="<?php echo lang('message'); ?> ... " value="<?php echo set_value('message');?>"><?php echo $message; ?></textarea>
                            </div>
                            <?php if (form_error('message')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('message'); ?></span>
                                </div>
                            <?php } ?>

                            <?php if($type == 'customAll'){?>
                                <div class="form-group mb-3">
                                    <?php echo lang('only'); ?> <b><?php echo count($sms_count); ?></b> <?php echo lang('customer_has_valid'); ?>
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
                    <a class="btn bg-blue-btn text-decoration-none" href="<?php echo base_url() ?>Short_message_service/smsService">
                        <iconify-icon icon="solar:undo-left-round-broken"></iconify-icon>
                        <?php echo lang('back'); ?>
                    </a>
                </div>

                <?php echo form_close(); ?>
            </div>
        </div>
    </section>
</div>