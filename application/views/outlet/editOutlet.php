<script src="<?php echo base_url(); ?>frequent_changing/js/add_outlet.js"></script>
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
                <h3 class="top-left-header mt-2"><?php echo lang('edit_outlet'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('outlet'), 'secondSection'=> lang('edit_outlet')])?>
        </div>
    </section>

    <!-- Main content -->
    <div class="box-wrapper">
        <div class="table-box">
            <!-- /.box-header -->
            <!-- form start -->
            <?php echo form_open(base_url() . 'Outlet/addEditOutlet/' . $encrypted_id, $arrayName = array('id' => 'outlet_form')) ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('outlet_code'); ?> <span class="required_star">*</span></label>
                            <input readonly  autocomplete="off" type="text" name="outlet_code"
                                class="form-control" onfocus="select();"
                                placeholder="<?php echo lang('outlet_code'); ?>"
                                value="<?php echo escape_output($outlet_information->outlet_code) ?>">
                        </div>
                        <?php if (form_error('outlet_code')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('outlet_code'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('outlet_name'); ?> <span class="required_star">*</span></label>
                            <input  autocomplete="off" type="text" name="outlet_name" class="form-control" placeholder="<?php echo lang('outlet_name'); ?>" value="<?php echo escape_output($outlet_information->outlet_name); ?>">
                        </div>
                        <?php if (form_error('outlet_name')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('outlet_name'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label>
                                <?php echo lang('phone'); ?> <span class="required_star">*</span>
                            </label>
                            <input  autocomplete="off" type="text" name="phone" class="form-control" placeholder="<?php echo lang('phone'); ?>" value="<?php echo escape_output($outlet_information->phone); ?>">
                        </div>
                        <?php if (form_error('phone')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('phone'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('email'); ?></label>
                            <input  autocomplete="off" type="text" name="email" class="form-control" placeholder="<?php echo lang('email'); ?>" value="<?php echo escape_output($outlet_information->email); ?>">
                        </div>
                        <?php if (form_error('email')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('email'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('Active_Status'); ?> <span class="required_star">*</span></label>
                            <select class="form-control select2" name="active_status" id="active_status">
                                <option value="active" <?php echo escape_output($outlet_information->active_status) == 'active' ? 'selected' : '' ?>><?php echo lang('Active'); ?></option>
                                <option value="inactive" <?php echo escape_output($outlet_information->active_status) == 'inactive' ? 'selected' : '' ?>><?php echo lang('Inactive'); ?></option>
                            </select>
                        </div>
                        <?php if (form_error('active_status')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('active_status'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('address'); ?> <span class="required_star">*</span></label>
                            <textarea  autocomplete="off" name="address" class="form-control" placeholder="<?php echo lang('address'); ?>"><?php echo escape_output($outlet_information->address); ?></textarea>
                        </div>
                        <?php if (form_error('address')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('address'); ?></span>
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
                <input type="hidden" id="set_save_and_add_more" name="add_more">
                <button type="submit" name="submit" value="submit" class="btn bg-blue-btn" id="save_and_add_more">
                    <iconify-icon icon="solar:undo-right-round-broken"></iconify-icon>
                    <?php echo lang('save_and_add_more'); ?>
                </button>
                <a class="btn bg-blue-btn text-decoration-none" href="<?php echo base_url() ?>Outlet/outlets">
                    <iconify-icon icon="solar:undo-left-round-broken"></iconify-icon>
                    <?php echo lang('back'); ?>
                </a>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</section>