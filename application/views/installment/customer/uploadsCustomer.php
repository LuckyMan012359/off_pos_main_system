<script src="<?php echo base_url(); ?>frequent_changing/js/upload_customer.js"></script>
<div class="main-content-wrapper">
<?php
    if ($this->session->flashdata('exception')) {
    echo '<div class="alert alert-success alert-dismissible"> 
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></button>
    <div class="alert-body"><i class="icon fa fa-check me-2"></i>';
        echo escape_output($this->session->flashdata('exception'));unset($_SESSION['exception']);
        echo '</p></div>';
    }
    if ($this->session->flashdata('exception_err')) {

        echo '<div class="alert alert-danger alert-dismissible"> 
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></button>
    <div class="alert-body"><i class="icon fa fa-check me-2"></i>';
        echo escape_output($this->session->flashdata('exception_err'));unset($_SESSION['exception_err']);
        echo '</p></div>';
    }
?> 
            
    <div class="content-header">
        <h3 class="top-left-header">
            <?php echo lang('upload_installment_customer'); ?>
        </h3>  
    </div>

    <div class="box-wrapper">
        <div class="table-box"> 
            <!-- form start -->
            <?php echo form_open_multipart(base_url('Installment/ExcelDataAddCustomers')); ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label> <?php echo lang('upload_file'); ?> <span class="required_star">*</span></label>
                            <input  autocomplete="off" type="file" name="userfile" class="form-control" placeholder="<?php echo lang('upload_file'); ?>" value="<?php echo set_value('name'); ?>">
                        </div>
                        <div class="checkbox form-group">
                        <label><input type="checkbox" name="remove_previous" value="1"> <?php echo lang('remove_all_previous_data'); ?></label>
                        </div>
                        <?php if (form_error('userfile')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('userfile'); ?></span>
                            </div>
                        <?php } ?> 
                    </div>                     

                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" name="submit" value="submit" class="btn bg-blue-btn">
                    <iconify-icon icon="solar:upload-minimalistic-broken"></iconify-icon>
                    <?php echo lang('submit'); ?>
                </button>
                
                <a class="btn bg-blue-btn text-decoration-none" href="<?php echo base_url() ?>Installment/customers">
                    <iconify-icon icon="solar:undo-left-round-broken"></iconify-icon>
                    <?php echo lang('back'); ?>
                </a>
                <a class="btn bg-blue-btn text-decoration-none" href="<?php echo base_url() ?>Authentication/downloadPDF/Customer_Upload.xlsx">
                    <iconify-icon icon="solar:cloud-download-broken"></iconify-icon>
                    <?php echo lang('download_sample'); ?>
                </a>
            </div>

            <?php echo form_close(); ?>
        </div>
    </div>
</div>

