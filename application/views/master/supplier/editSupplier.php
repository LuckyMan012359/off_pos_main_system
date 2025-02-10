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
                <h3 class="top-left-header mt-2"><?php echo lang('edit_supplier'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('supplier'), 'secondSection'=> lang('edit_supplier')])?>
        </div>
    </section>


    <div class="box-wrapper">
        <div class="table-box">
            <!-- form start -->
            <?php echo form_open(base_url('Supplier/addEditSupplier/' . $encrypted_id)); ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6 col-lg-4">
                        <div class="form-group mb-3">
                            <label><?php echo lang('name'); ?> <span class="required_star">*</span></label>
                            <input  autocomplete="off" type="text" name="name" class="form-control"
                                placeholder="<?php echo lang('name'); ?>"
                                value="<?php echo escape_output($supplier_information->name); ?>">
                        </div>
                        <?php if (form_error('name')) { ?>
                        <div class="callout callout-danger my-2">
                            <span class="error_paragraph"><?php echo form_error('name'); ?></span>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="form-group mb-3">
                            <label><?php echo lang('contact_person'); ?> <span class="required_star">*</span></label>
                            <input  autocomplete="off" type="text" name="contact_person"
                                class="form-control" placeholder="<?php echo lang('contact_person'); ?>"
                                value="<?php echo escape_output($supplier_information->contact_person); ?>">
                        </div>
                        <?php if (form_error('contact_person')) { ?>
                        <div class="callout callout-danger my-2">
                            <span class="error_paragraph"><?php echo form_error('contact_person'); ?></span>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="form-group mb-3">
                            <label><?php echo lang('phone'); ?> <span class="required_star">*</span></label>
                            <input  autocomplete="off" type="text" name="phone"
                                class="form-control" placeholder="<?php echo lang('phone'); ?>"
                                value="<?php echo escape_output($supplier_information->phone); ?>">
                        </div>
                        <?php if (form_error('phone')) { ?>
                        <div class="callout callout-danger my-2">
                            <span class="error_paragraph"><?php echo form_error('phone'); ?></span>
                        </div>
                        <?php } ?>

                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="form-group mb-3">
                            <label><?php echo lang('email'); ?></label>
                            <input  autocomplete="off" type="text" name="email" class="form-control"
                                placeholder="<?php echo lang('email'); ?>"
                                value="<?php echo escape_output($supplier_information->email); ?>">
                        </div>
                        <?php if (form_error('email')) { ?>
                        <div class="callout callout-danger my-2">
                            <span class="error_paragraph"><?php echo form_error('email'); ?></span>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="d-flex justify-content-between">
                            <div class="form-group w-100 me-2">
                                <label><?php echo lang('opening_balance'); ?></label>
                                <input  autocomplete="off" type="text" id="opening_balance" name="opening_balance"
                                    class="form-control integerchk" placeholder="<?php echo lang('opening_balance'); ?>" value="<?php echo escape_output($supplier_information->opening_balance); ?>">
                                <?php if (form_error('opening_balance')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('opening_balance'); ?></span>
                                </div>
                                <?php } ?>
                            </div>
                            <div class="form-group w-100">
                                <label>&nbsp;</label>
                                <select  class="form-control select2" name="opening_balance_type" id="opening_balance_type">
                                    <option value="Debit" <?php echo escape_output($supplier_information->opening_balance_type) == "Debit" ? 'selected' : '' ?>><?php echo lang('debit');?></option>
                                    <option value="Credit" <?php echo escape_output($supplier_information->opening_balance_type) == "Credit" ? 'selected' : '' ?>><?php echo lang('credit');?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="form-group mb-3">
                            <label><?php echo lang('description'); ?></label>
                            <input  class="form-control" name="description"
                                placeholder="<?php echo lang('description'); ?>" value="<?php echo escape_output($supplier_information->description); ?>">
                        </div>
                        <?php if (form_error('description')) { ?>
                        <div class="callout callout-danger my-2">
                            <span class="error_paragraph"><?php echo form_error('description'); ?></span>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="form-group mb-3">
                            <label><?php echo lang('address'); ?></label>
                            <textarea  class="form-control" name="address"
                                placeholder="<?php echo lang('address'); ?>"><?php echo escape_output($supplier_information->address); ?>
                            </textarea>
                            <?php if (form_error('address')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('address'); ?></span>
                            </div>
                            <?php } ?>
                        </div>
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
                <a class="btn bg-blue-btn text-decoration-none" href="<?php echo base_url() ?>Supplier/suppliers">
                    <iconify-icon icon="solar:undo-left-round-broken"></iconify-icon>
                    <?php echo lang('back'); ?>
                </a>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>