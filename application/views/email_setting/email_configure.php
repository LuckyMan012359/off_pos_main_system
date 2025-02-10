
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
                <h3 class="top-left-header mt-2"><?php echo lang('email_service_option'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('email_service'), 'secondSection'=> lang('email_service_option')])?>
        </div>
    </section>


    <!-- Main content -->
    <div class="box-wrapper">
        <div class="table-box">
            <div class="box-body">
                <div class="row"> 
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-3">
                        <div class="form-group">
                            <a class="email_card" href="<?php echo base_url();?>Email_setting/emailSetting">
                                <iconify-icon icon="solar:settings-bold-duotone" width="25"></iconify-icon>
                                <span class="email-title">
                                    <?php echo lang('configure_email'); ?>
                                </span>
                            </a>
                        </div>  
                    </div> 
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-3">
                        <div class="form-group">
                            <a class="email_card" href="<?php echo base_url();?>Email_setting/sendEmail/test">
                                <iconify-icon icon="icon-park-solid:mail-unpacking" width="25"></iconify-icon>
                                <span class="email-title">
                                    <?php echo lang('send_test_email'); ?>
                                </span>
                            </a>
                        </div>  
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-3">
                        <div class="form-group">
                            <a class="email_card" href="<?php echo base_url();?>Email_setting/sendEmail/birthday">
                                <iconify-icon icon="icon-park-solid:email-delect" width="25"></iconify-icon>
                                <span class="email-title">
                                    <?php echo lang('email_birthday_customer'); ?>
                                </span>
                            </a>
                        </div>  
                    </div> 
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-3">
                        <div class="form-group">
                            <a class="email_card" href="<?php echo base_url();?>Email_setting/sendEmail/anniversary">
                                <iconify-icon icon="icon-park-solid:email-delect" width="25"></iconify-icon>
                                <span class="email-title">
                                    <?php echo lang('email_anniversary_customer'); ?>
                                </span>
                            </a>
                        </div>  
                    </div>   

                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-3">
                        <div class="form-group">
                            <a class="email_card" href="<?php echo base_url();?>Email_setting/sendEmail/custom">
                                <iconify-icon icon="icon-park-solid:mail-unpacking" width="25"></iconify-icon>
                                <span class="email-title">
                                    <?php echo lang('send_custom_email_all_customer'); ?>
                                </span>
                            </a>
                        </div>  
                    </div>  
                </div>
            </div>  
        </div>
    </div>
</div>