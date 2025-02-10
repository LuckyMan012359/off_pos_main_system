<script src="<?php echo base_url(); ?>frequent_changing/js/upload_suppliers.js"></script>
<div class="main-content-wrapper">
    <?php
        if ($this->session->flashdata('exception')) {
        echo '<section class="alert-wrapper"><div class="alert alert-success alert-dismissible fade show"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></button>
        <div class="alert-body"><i class="icon fa fa-check me-2"></i>';
            echo ($this->session->flashdata('exception'));unset($_SESSION['exception']);
            echo '</div></div></section>';
        }
        if ($this->session->flashdata('exception_err')) {
        echo '<section class="alert-wrapper"><div class="alert alert-danger alert-dismissible fade show"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></button>
        <div class="alert-body"><i class="icon fa fa-times me-2"></i>';
            echo ($this->session->flashdata('exception_err'));unset($_SESSION['exception_err']);
            echo '</div></div></section>';
        }
        ?>


    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo lang('upload_supplier'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('supplier'), 'secondSection'=> lang('upload_supplier')])?>
        </div>
    </section>


    <div class="box-wrapper">
        <div class="table-box">
            <?php echo form_open_multipart(base_url('Supplier/ExcelDataAddSuppliers')); ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <label> <?php echo lang('upload_file'); ?> <span class="required_star">*</span></label>
                            <input  autocomplete="off" type="file" name="userfile" class="form-control"
                                placeholder="<?php echo lang('upload_file'); ?>"
                                value="<?php echo set_value('name'); ?>">
                        </div>
                        <div class="checkbox form-group">
                            <label><input type="checkbox" name="remove_previous" value="1">
                                <?php echo lang('remove_all_previous_data'); ?></label>
                        </div>
                        <?php if (form_error('userfile')) { ?>
                        <div class="callout callout-danger my-2">
                            <span class="error_paragraph"><?php echo form_error('userfile'); ?></span>
                        </div>
                        <?php } ?>
                    </div>

                </div>
            </div>
            <div class="box-footer">
                <button type="submit" name="submit" value="submit" class="btn bg-blue-btn">
                    <?php echo lang('submit'); ?></button>
                <a href="<?php echo base_url() ?>Supplier/suppliers" 
                        class="btn bg-blue-btn"><?php echo lang('back'); ?></a>
                <a class="btn bg-blue-btn"
                    href="<?php echo base_url() ?>Authentication/downloadPDF/Supplier_Upload.xlsx">
                    <?php echo lang('download_sample'); ?>
                </a>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>