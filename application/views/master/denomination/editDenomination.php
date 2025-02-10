<section class="main-content-wrapper">
<h3 class="display_none">&nbsp;</h3>

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
                <h3 class="top-left-header mt-2"><?php echo lang('edit_denomination'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('denomination'), 'secondSection'=> lang('edit_denomination')])?>
        </div>
    </section>


    <div class="box-wrapper">
        
        <div class="table-box">
            
            <?php echo form_open(base_url('denomination/addEditDenomination/' . $encrypted_id)); ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6 col-lg-4 mb-3">

                        <div class="form-group">
                            <label><?php echo lang('amount'); ?> <span class="required_star">*</span></label>
                            <input  type="text" name="amount" class="form-control integerchk"
                                placeholder="<?php echo lang('amount'); ?>"
                                value="<?php echo escape_output($denomination->amount) ?>">
                        </div>
                        <?php if (form_error('amount')) { ?>
                        <div class="callout callout-danger my-2">
                            <?php echo form_error('amount'); ?>
                        </div>
                        <?php } ?>

                    </div>

                    <div class="col-md-6 col-lg-8 mb-3">

                        <div class="form-group">
                            <label><?php echo lang('description'); ?></label>
                            <input  type="text" name="description" class="form-control"
                                    placeholder="<?php echo lang('description'); ?>" value="<?php echo escape_output($denomination->description) ?>" >
                        </div>
                        <?php if (form_error('description')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('description'); ?>
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
                <a class="btn bg-blue-btn text-decoration-none" href="<?php echo base_url() ?>Denomination/denominations">
                    <iconify-icon icon="solar:undo-left-round-broken"></iconify-icon>
                    <?php echo lang('back'); ?>
                </a>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
        
</section>