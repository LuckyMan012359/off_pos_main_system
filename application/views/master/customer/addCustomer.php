<script src="<?php echo base_url(); ?>frequent_changing/js/add_customer.js"></script>

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
                <h3 class="top-left-header mt-2"><?php echo lang('add_customer'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('customer'), 'secondSection'=> lang('add_customer')])?>
        </div>
    </section>


    <!-- Main content -->
    <section class="box-wrapper">
    <h3 class="display_none">&nbsp;</h3>
        <div class="table-box">
            <?php echo form_open(base_url('Customer/addEditCustomer')); ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('customer_name'); ?> <span class="required_star">*</span></label>
                            <input  autocomplete="off" type="text" name="name" class="form-control"
                                placeholder="<?php echo lang('customer_name'); ?>"
                                value="<?php echo set_value('name'); ?>">
                        </div>
                        <?php if (form_error('name')) { ?>
                        <div class="callout callout-danger my-2">
                            <span class="error_paragraph"><?php echo form_error('name'); ?></span>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('phone'); ?> <span class="required_star">*</span></label>
                            <input  autocomplete="off" type="text" name="phone"
                                class="form-control" placeholder="<?php echo lang('phone'); ?>"
                                value="<?php echo set_value('phone'); ?>">
                        </div>
                        <?php if (form_error('phone')) { ?>
                        <div class="callout callout-danger my-2">
                            <span class="error_paragraph"><?php echo form_error('phone'); ?></span>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('email'); ?></label>
                            <input  autocomplete="off" type="text" name="email" class="form-control"
                                placeholder="<?php echo lang('email'); ?>" value="<?php echo set_value('email'); ?>">
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
                                <input  autocomplete="off" type="text" name="opening_balance"
                                    class="form-control integerchk" placeholder="<?php echo lang('opening_balance'); ?>" value="<?php echo set_value('opening_balance'); ?>">
                                <?php if (form_error('opening_balance')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <?php echo form_error('opening_balance'); ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="form-group w-100">
                                <label>&nbsp;</label>
                                <select class="form-control select2" name="opening_balance_type" id="opening_balance_type">
                                    <option value="Debit" <?php echo set_select('opening_balance_type', "Debit"); ?>><?php echo lang('debit');?></option>
                                    <option value="Credit" <?php echo set_select('opening_balance_type', "Credit"); ?>><?php echo lang('credit');?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('credit_limit'); ?></label>
                            <input  autocomplete="off" type="text" id="credit_limit" name="credit_limit"
                                class="form-control integerchk" placeholder="<?php echo lang('credit_limit'); ?>" value="<?php echo set_value('credit_limit'); ?>">
                        </div>
                        <?php if (form_error('credit_limit')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('credit_limit'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('default_discount'); ?></label>
                            <input  autocomplete="off" type="text" id="discount" name="discount"
                                class="form-control integerchkPercent" placeholder="<?php echo lang('discount_type'); ?>" value="<?php echo set_value('discount'); ?>">
                        </div>
                        <?php if (form_error('discount')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('discount'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('price_type'); ?></label>
                            <select class="form-control select2" name="price_type" id="price_type" >
                                <option <?php echo set_select('price_type', 1)?> value="1"><?php echo lang('retail'); ?></option>
                                <option <?php echo set_select('price_type', 2)?> value="2"><?php echo lang('wholesale'); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('group'); ?></label>
                            <div class="d-flex">
                                <select  class="form-control  select2 op_width_100_p" id="group_id" name="group_id">
                                    <option value=""><?php echo lang('select'); ?></option>
                                    <?php
                                    foreach ($groups as $splrs) {
                                        ?>
                                    <option value="<?php echo escape_output($splrs->id) ?>"
                                        <?php echo set_select('group_id', $splrs->id); ?>><?php echo escape_output($splrs->group_name) ?>
                                    </option>
                                    <?php } ?>
                                </select>
                                <button type="button" class="new-btn ms-1 add_group_by_ajax bg-blue-btn-p-14">
                                <iconify-icon icon="solar:add-circle-broken" width="22"></iconify-icon>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('address'); ?></label>
                            <textarea  name="address" class="form-control"
                                placeholder="<?php echo lang('address'); ?>"><?php echo set_value('address'); ?></textarea>
                        </div>
                        <?php if (form_error('address')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('address'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <?php if(collectGST()=="Yes"){?>
                    <div class="col-sm-12 mb-2 col-md-4">
                        <div class="form-group">
                            <label> <?php echo lang('same_or_diff_state'); ?> <span class="required_star">*</span></label>
                            <select  class="form-control select2" name="same_or_diff_state"
                                    id="same_or_diff_state">
                                <option value=""><?php echo lang('select'); ?></option>
                                <option <?php echo set_select('same_or_diff_state',1)?> value="1"><?php echo lang('same_state'); ?></option>
                                <option <?php echo set_select('same_or_diff_state',2)?> value="2"><?php echo lang('different_state'); ?></option>
                            </select>
                        </div>
                        <?php if (form_error('same_or_diff_state')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('same_or_diff_state'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('gst_number'); ?> <span class="required_star">*</span></label>
                            <input  autocomplete="off" type="text" name="gst_number" class="form-control"
                                placeholder="<?php echo lang('gst_number'); ?>"
                                value="<?php echo set_value('gst_number'); ?>">
                        </div>
                        <?php if (form_error('gst_number')) { ?>
                        <div class="callout callout-danger my-2">
                            <span class="error_paragraph"><?php echo form_error('gst_number'); ?></span>
                        </div>
                        <?php } ?>
                    </div>
                    <?php } ?>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('date_of_birth'); ?></label>
                            <input autocomplete="off" type="text" name="date_of_birth"
                                class="form-control customDatepicker" placeholder="<?php echo lang('date_of_birth'); ?>"
                                value="<?php echo set_value('date_of_birth'); ?>">
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('date_of_anniversary'); ?></label>
                            <input  autocomplete="off" type="text" name="date_of_anniversary"
                                class="form-control customDatepicker" placeholder="<?php echo lang('date_of_anniversary'); ?>"
                                value="<?php echo set_value('date_of_anniversary'); ?>">
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
                <a class="btn bg-blue-btn text-decoration-none" href="<?php echo base_url() ?>Customer/customers">
                    <iconify-icon icon="solar:undo-left-round-broken"></iconify-icon>
                    <?php echo lang('back'); ?>
                </a>
            </div>
            <?php echo form_close(); ?>
        </div>
    </section>
</div>




<!-- Customer Group Modal -->
<div class="modal fade " id="addCustomerGroupModal" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title">
                <?php echo lang('add_customer_group'); ?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i
                data-feather="x"></i></span></button>
            </div>
            <div class="modal-body">
                <form id="add_customer_group_form">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="col-sm-4 control-label"><?php echo lang('group_name'); ?><span class="op_color_red">
                                        *</span></label>
                                <input type="text" autocomplete="off" class="form-control" name="name" id="group_name"
                                    placeholder="<?php echo lang('group_name'); ?>">
                                <div class="alert alert-error error-msg group_name_err_msg_contnr">
                                    <p class="group_name_err_msg"></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="control-label"><?php echo lang('description'); ?></label>
                                <input autocomplete="off" type="text" id="description_group" name="description"
                                    class="form-control" placeholder="<?php echo lang('description'); ?>" value="<?php echo set_value('description'); ?>">  
                                <div class="alert alert-error error-msg sdescription_err_msg_contnr ">
                                    <p class="description_err_msg"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-blue-btn" id="addGroup"><?php echo lang('submit'); ?></button>
                <button type="button" class="btn bg-blue-btn" data-bs-dismiss="modal"><?php echo lang('close'); ?></button>
            </div>
        </div>
    </div>
</div>
