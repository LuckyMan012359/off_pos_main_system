
<div class="main-content-wrapper">

    <?php
    if ($this->session->flashdata('exception_2')) {

        echo '<section class="alert-wrapper"><div class="alert alert-danger alert-dismissible"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></button>
        <div class="alert-body"><i class="icon fa fa-check me-2"></i>';
        echo escape_output($this->session->flashdata('exception_2'));unset($_SESSION['exception_2']);
        echo '</div></div></section>';
    }
    ?>  

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
                <h3 class="top-left-header mt-2"><?php echo lang('sms_service_option'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('sms_service'), 'secondSection'=> lang('sms_service_option')])?>
        </div>
    </section>



    <!-- Main content -->
    <div class="box-wrapper">
        <div class="table-box">
            <div class="box-body">
                <div class="row"> 
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-3">
                        <div class="form-group">
                            <a class="email_card" href="<?php echo base_url();?>Short_message_service/SMSSetting">
                                <iconify-icon icon="fa6-solid:comment-sms" width="25"></iconify-icon>
                                <span class="email-title">
                                    <?php echo lang('configure_sms'); ?>
                                </span>
                            </a>
                        </div>  
                    </div> 
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-3">
                        <div class="form-group">
                            <a class="email_card" href="<?php echo base_url();?>Short_message_service/sendSMS/test">
                                <iconify-icon icon="fa6-solid:comment-sms" width="25"></iconify-icon>
                                <span class="email-title">
                                    <?php echo lang('send_test_sms'); ?>
                                </span>
                            </a>
                        </div>  
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-3">
                        <div class="form-group">
                            <a class="email_card" href="<?php echo base_url();?>Short_message_service/sendSMS/birthday">
                                <iconify-icon icon="fa6-solid:comment-sms" width="25"></iconify-icon>
                                <span class="email-title">
                                    <?php echo lang('sms_birthday_customer'); ?>
                                </span>
                            </a>
                        </div>  
                    </div> 
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-3">
                        <div class="form-group">
                            <a class="email_card" href="<?php echo base_url();?>Short_message_service/sendSMS/anniversary">
                                <iconify-icon icon="fa6-solid:comment-sms" width="25"></iconify-icon>
                                <span class="email-title">
                                    <?php echo lang('sms_anniversary_customer'); ?>
                                </span>
                            </a>
                        </div>  
                    </div>   

                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-3">
                        <div class="form-group">
                            <a class="email_card" href="<?php echo base_url();?>Short_message_service/sendSMS/custom">
                                <iconify-icon icon="fa6-solid:comment-sms" width="25"></iconify-icon>
                                <span class="email-title">
                                    <?php echo lang('send_custom_sms_all_customer'); ?>
                                </span>
                            </a>
                        </div>  
                    </div>  
                </div>
            </div>  
        </div>
    </div>
</div>