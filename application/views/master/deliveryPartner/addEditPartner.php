<div class="main-content-wrapper">


<?php
    if ($this->session->flashdata('exception')) {
        echo '<section class="alert-wrapper">
        <div class="alert alert-success alert-dismissible fade show"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <div class="alert-body">
        <i class="m-right fa fa-check"></i>';
        echo escape_output($this->session->flashdata('exception'));unset($_SESSION['exception']);
        echo '</div></div></section>';
    }
    ?>

    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo lang('add_delivery_partner'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('delivery_partner'), 'secondSection'=> lang('add_delivery_partner')])?>
        </div>
    </section>


    <div class="box-wrapper">
        <div class="table-box">  
            <!-- form start -->
            <?php echo form_open(base_url('Delivery_partner/addEditPartner')); ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6 col-lg-4 mb-3">

                        <div class="form-group">
                            <label><?php echo lang('partner_name'); ?> <span class="required_star">*</span></label>
                            <input  autocomplete="off" type="text" name="partner_name" class="form-control" placeholder="<?php echo lang('partner_name'); ?>" value="<?php echo set_value('partner_name'); ?>">
                        </div>
                        <?php if (form_error('partner_name')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('partner_name'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 col-lg-8 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('description'); ?></label>
                            <input autocomplete="off" type="text" name="description" class="form-control" placeholder="<?php echo lang('description'); ?>" value="<?php echo set_value('description'); ?>">
                        </div>
                        <?php if (form_error('description')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('description'); ?></span>
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
                <input type="hidden" id="set_save_and_add_more" name="add_more">
                <button type="submit" name="submit" value="submit" class="btn bg-blue-btn" id="save_and_add_more">
                    <iconify-icon icon="solar:undo-right-round-broken"></iconify-icon>
                    <?php echo lang('save_and_add_more'); ?>
                </button>
                <a class="btn bg-blue-btn text-decoration-none" href="<?php echo base_url() ?>Delivery_partner/listPartner">
                    <iconify-icon icon="solar:undo-left-round-broken"></iconify-icon>
                    <?php echo lang('back'); ?>
                </a>
            </div>

            <?php echo form_close(); ?>
        </div>
    </div>
</div>