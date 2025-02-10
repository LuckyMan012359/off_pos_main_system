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
            <h3 class="top-left-header mt-2"><?php echo lang('General_Information'); ?></h3>
        </div>
        <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('General_Information'), 'secondSection'=> lang('General_Information')])?>
    </div>
</section>

<!-- Main content -->
<section class="box-wrapper">
<h3 class="display_none">&nbsp;</h3>
    <div class="table-box"> 
        <!-- /.box-header -->
        <!-- form start -->
        <?php echo form_open(base_url('Authentication/updateCompanyProfile')); ?>
        <div class="box-body">
            <div class="row">
                <div class="col-md-4">

                    <div class="form-group">
                        <label><?= lang('Customer_ID');?></label>
                        <?php echo escape_output($this->session->userdata('customer_id')); ?>
                    </div> 

                </div> 

                <div class="col-md-4">
                    <div class="form-group">
                        <label><?= lang('Outlet_Quantity');?></label>
                        <?php echo escape_output($this->session->userdata('outlet_quantity')); ?>
                    </div>  
                </div>  

                <div class="col-md-4">
                    <div class="form-group">
                        <label><?= lang('Signup_Date');?></label>
                        <?php echo date($this->session->userdata('date_format'), strtotime(companyInformation($this->session->userdata('company_id'))->signup_date)); ?>
                    </div>  
                </div>  

            </div> 
            <div class="row">

                <div class="col-md-4">

                    <div class="form-group">
                        <label><?= lang('Owner_Name');?></label>
                        <?php echo escape_output($this->session->userdata('full_name')); ?>
                    </div> 

                </div> 

                <div class="col-md-4">
                    <div class="form-group">
                        <label><?= lang('Owner_Phone');?></label>
                        <?php echo escape_output($this->session->userdata('phone')); ?>
                    </div>  
                </div>  

                <div class="col-md-4">
                    <div class="form-group">
                        <label><?= lang('Owner_Email');?></label>
                        <?php echo escape_output($this->session->userdata('email_address')); ?>
                    </div>  
                </div>  

            </div> 
        </div>
        <!-- /.box-body -->

        <div class="box-footer">
            <a href="<?php echo base_url() ?>Outlet/outlets"><button type="button" class="btn bg-blue-btn"><?= lang('Back_to_Outlet_List');?></button></a>
        </div>
        <?php echo form_close(); ?>
    </div>
</section>