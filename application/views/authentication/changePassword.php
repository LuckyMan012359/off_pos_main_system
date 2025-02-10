<!-- Content Header (Page header) -->
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
        echo '<section class="alert-wrapper"><div class="alert alert-danger alert-dismissible fade show"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></button>
        <div class="alert-body"><i class="icon fa fa-times"></i>';
        echo escape_output($this->session->flashdata('exception_1'));unset($_SESSION['exception_1']);
        echo '</div></div></section>';
    }
    ?>

    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo lang('change_password'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('change_password'), 'secondSection'=> lang('change_password')])?>
        </div>
    </section>


    <!-- Main content -->
    <div class="box-wrapper">
        <div class="table-box"> 
            <?php echo form_open(base_url('User/changePassword')); ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4 mb-3"> 
                        <div class="form-group">
                            <label><?php echo lang('old_password'); ?> <span class="required_star">*</span></label>
                            <input  autocomplete="off" type="password" name="old_password" class="form-control" placeholder="<?php echo lang('old_password'); ?>">
                        </div>
                        <?php if (form_error('old_password')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('old_password'); ?></span>
                            </div>
                        <?php } ?>  
                    </div>

                    <div class="col-md-4 mb-3">  
                        <div class="form-group">
                            <label><?php echo lang('new_password'); ?> <span class="required_star">*</span></label>
                            <input  autocomplete="off" type="password" name="new_password" class="form-control" placeholder="<?php echo lang('new_password'); ?>">
                        </div>
                        <?php if (form_error('new_password')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('new_password'); ?></span>
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
            </div>
            <?php echo form_close(); ?>
        </div>
    </div> 
</div>