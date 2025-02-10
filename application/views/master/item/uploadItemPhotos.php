<script src="<?php echo base_url(); ?>frequent_changing/js/upload-items.js"></script>
<div class="main-content-wrapper">
    <?php
    if ($this->session->flashdata('exception')) {
        echo '<div class="alert alert-success alert-dismissible"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></button>
        <div class="alert-body"><i class="icon fa fa-check me-2"></i>';
        echo escape_output($this->session->flashdata('exception'));unset($_SESSION['exception']);
        echo '</div></div>';
    }
    if ($this->session->flashdata('exception_err')) {
        echo '<div class="alert alert-danger alert-dismissible"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></button>
        <div class="alert-body"><i class="icon fa fa-check me-2"></i>';
        echo ($this->session->flashdata('exception_err'));unset($_SESSION['exception_err']);
        echo '</div></div>';
    }
    ?>

    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo lang('upload_item_photo'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('item'), 'secondSection'=> lang('upload_item_photo')])?>
        </div>
    </section>

    
    <div class="box-wrapper mt-3">
        <div class="table-box">
            <?php echo form_open_multipart(base_url('Item/uploadItemPhoto')); ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label><?php echo lang('upload_product_image'); ?>,<span class="size_changer text-red">(<?php echo lang('width_200_height_200');?></span>)<span class="required_star">*</span></label>
                            <input type="file" name="large_image[]" class="form-control width_100_p pull-left" id="large_image" multiple>
                        </div>
                        <?php if (form_error('large_image')) { ?>
                            <div class="alert alert-error txt-uh-21">
                                <p><?php echo form_error('large_image'); ?></p>
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
                <a class="btn bg-blue-btn" href="<?php echo base_url() ?>Item/items">
                    <iconify-icon icon="solar:undo-left-round-broken"></iconify-icon>
                    <?php echo lang('back'); ?>
                </a>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
