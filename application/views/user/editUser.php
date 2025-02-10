<link rel="stylesheet" href="<?= base_url('assets/') ?>buttonCSS/checkBotton.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/crop/croppie.css">
<script src="<?php echo base_url(); ?>assets/bower_components/crop/croppie.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>frequent_changing/css/addUser.css">


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
                <h3 class="top-left-header mt-2"><?php echo lang('edit_employee'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('employee'), 'secondSection'=> lang('edit_employee')])?>
        </div>
    </section>

    <section class="box-wrapper">
    <h3 class="display_none">&nbsp;</h3>
        <div class="table-box">
            <?php
            $attributes = array('id' => 'add_user');
            echo form_open_multipart(base_url('User/addEditUser/' . $encrypted_id), $attributes); ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('name'); ?> <span class="required_star">*</span></label>
                            <input  autocomplete="off" type="text" name="full_name" class="form-control" placeholder="<?php echo lang('name'); ?>"
                                value="<?php echo escape_output($user_details->full_name); ?>">
                        </div>
                        <?php if (form_error('full_name')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('full_name'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('user_email_phone'); ?> <span class="required_star"> *</span></label>
                            <input  autocomplete="off" type="text" name="email_address" class="form-control" placeholder="<?php echo lang('user_email_phone'); ?>" value="<?php echo escape_output($user_details->email_address); ?>">
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('phone'); ?> <span class="required_star">*</span></label>
                            <input  autocomplete="off" type="text" name="phone" class="form-control integerchk" placeholder="<?php echo lang('phone'); ?>" value="<?php echo escape_output($user_details->phone); ?>">
                        </div>
                        <?php if (form_error('phone')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('phone'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('salary'); ?> <span class="required_star">*</span></label>
                            <input  autocomplete="off" type="number" name="salary" class="form-control" placeholder="<?php echo lang('salary'); ?>" value="<?php echo escape_output($user_details->salary); ?>">
                        </div>
                        <?php if (form_error('salary')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('salary'); ?></span>
                            </div>
                        <?php } ?>  
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('designation'); ?><span class="required_star"> *</span></label>
                            <select <?php echo $user_details->id == 1 ? 'disabled' : '' ?> name="designation" class="form-control select2">
                                <option><?php echo lang('select'); ?></option>
                                <?php foreach($roles as $role){?>
                                <option <?php echo escape_output($user_details->role) == $role->id ? 'selected' : '' ?> value="<?php echo escape_output($role->id) ?>" <?php echo set_select('designation', $role->id); ?>><?php echo escape_output($role->role_name) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <?php if (form_error('designation')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('designation'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label>
                                    <?php echo lang('commission'); ?> <span class="required_star">*</span>
                                </label>
                                <div class="ms-3 op_right op_font_18 op_cursor_pointer mb-4-px">
                                    <i data-tippy-content="<?php echo lang('commission_message'); ?>" class="fa-regular fa-circle-question tippyBtnCall font-16 theme-color"></i>
                                </div>
                            </div>
                            <input  autocomplete="off" type="text" name="commission" class="form-control" placeholder="<?php echo lang('commission'); ?>" value="<?php echo escape_output($user_details->commission); ?>">
                            </select>
                        </div>
                        <?php if (form_error('commission')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('commission'); ?></span>
                            </div>
                        <?php } ?>
                    </div>

                    <?php 
                        if (in_array('discountPermission-287', $this->session->userdata("function_access"))) {
                    ?>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('discount_permission_code'); ?></label>
                            <input  autocomplete="off" type="text" name="discount_permission_code" class="form-control" placeholder="<?php echo lang('discount_permission_code'); ?>" value="<?php echo escape_output($user_details->discount_permission_code) ?>">
                        </div>
                        <?php if (form_error('discount_permission_code')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('discount_permission_code'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('discount_pro'); ?></label>
                            <input  autocomplete="off" type="text" name="discount_amt" class="form-control" placeholder="<?php echo lang('discount_type'); ?>" value="<?php echo escape_output($user_details->discount_amt) ?>">
                        </div>
                        <?php if (form_error('discount_amt')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('discount_amt'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('start'); ?> <?php echo lang('date'); ?></label>
                            <input  autocomplete="off" readonly type="text" name="start_date" class="form-control customDatepicker" placeholder="<?php echo lang('start_date'); ?>" value="<?php echo escape_output($user_details->start_date) ?>">
                        </div>
                        <?php if (form_error('start_date')) { ?>
                        <div class="callout callout-danger my-2">
                            <span class="error_paragraph"><?php echo form_error('start_date'); ?></span>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('end'); ?> <?php echo lang('date'); ?></label>
                            <input  autocomplete="off" readonly type="text" name="end_date" class="form-control customDatepicker" placeholder="<?php echo lang('end_date'); ?>" value="<?php echo escape_output($user_details->end_date) ?>">
                        </div>
                        <?php if (form_error('end_date')) { ?>
                        <div class="callout callout-danger my-2">
                            <span class="error_paragraph"><?php echo form_error('end_date'); ?></span>
                        </div>
                        <?php } ?>
                    </div>
                    <?php } ?>
                    <?php 
                        if (in_array('salePriceModify-287', $this->session->userdata("function_access"))) {
                    ?>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('sale_price_modify'); ?></label>
                            <select name="sale_price_modify" class="form-control select2">
                                <option><?php echo lang('select'); ?></option>
                                <option value="Yes" <?php echo $user_details->sale_price_modify == 'Yes' ? 'selected': ''?>><?php echo lang('yes');?></option>
                                <option value="No" <?php echo $user_details->sale_price_modify == 'No' ? 'selected': ''?>><?php echo lang('no');?></option>
                            </select>
                        </div>
                        <?php if (form_error('sale_price_modify')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('sale_price_modify'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <?php } ?>

                    <div class="col-md-6 col-lg-4 mb-3 multiple_select_placeholder">
                        <div class="form-group">
                            <label>
                                <?php echo lang('outlet'); ?>
                            </label>
                            <select name="outlet_id[]" class="form-control select2" multiple data-placeholder="<?php echo lang('select'); ?>">
                                <option><?php echo lang('select');?></option>
                                <?php
                                if($user_details->outlet_id != ""){
                                foreach($outlets as $outlet): 
                                    $data  = ''; 
                                    if($user_details->outlet_id){
                                        if(in_array($outlet->id, explode(",",$user_details->outlet_id))){
                                            $data = 'selected';
                                        }
                                    }
                                ?>
                                <option  value="<?= $outlet->id; ?>" <?php echo $data; ?>><?= $outlet->outlet_name; ?></option>
                                <?php endforeach; }else{?>
                                    <?php foreach($outlets as $outlet): ?>
                                    <option <?php echo set_select('outlet_id', $outlet->id); ?> value="<?= $outlet->id; ?>"><?= $outlet->outlet_name; ?></option>
                                    <?php endforeach; ?>
                                <?php } ?>
                            </select>
                        </div>
                        <?php if (form_error('outlet_id')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('outlet_id'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3 mt-26">
                        <button type="button"
                            class="new-btn h-40 add_image_for_crop op_display_inline_flex" >
                            <iconify-icon icon="solar:add-circle-broken" width="18"></iconify-icon>
                            <?php echo lang('add_image'); ?>
                        </button>
                        <input type="hidden" value="" name="photo" id="image_url">
                        <button type="button"
                            class="new-btn h-40 show_image_trigger op_display_inline_flex">
                            <iconify-icon icon="solar:eye-bold-duotone" width="18"></iconify-icon></button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group radio_button_problem">
                            <label><?php echo lang('will_login'); ?>  <span class="required_star">*</span></label>
                            <div class="radio">
                                <label class="me-5">
                                    <input <?php echo set_checkbox('will_login',"Yes")?> type="radio" name="will_login" id="will_login_yes"
                                        value="Yes" <?php if($user_details->will_login=="Yes"){echo "checked";} ?>><?php echo lang('yes'); ?> 
                                </label>
                                <label>
                                    <input type="radio" <?php echo set_checkbox('will_login',"No")?> name="will_login" id="will_login_no" value="No" <?php if($user_details->will_login=="No"){echo "checked";} ?>><?php echo lang('no'); ?>
                                </label>
                            </div>
                        </div>
                        <?php if (form_error('will_login')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('will_login'); ?></span>
                            </div>
                        <?php } ?> 
                    </div>
                </div>

                <div id="will_login_section">
                    <div class="row">
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="form-group">
                                <label><?php echo lang('password'); ?> <span class="required_star">*</span></label>
                                <input  autocomplete="off" type="password" name="password" class="form-control" placeholder="<?php echo lang('password'); ?>" value="" autocomplete="off">
                                <input type="hidden" name="getOldP" value="<?php echo escape_output($user_details->password) == '' ? 0 : 1 ?>">
                            </div>
                            <?php if (form_error('password')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('password'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="form-group">
                                <label><?php echo lang('confirm_password'); ?> <span class="required_star">*</span></label>
                                <input  autocomplete="off" type="password" name="confirm_password" class="form-control" placeholder="<?php echo lang('confirm_password'); ?>" value="" autocomplete="off">
                            </div>
                            <?php if (form_error('confirm_password')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('confirm_password'); ?></span>
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
                <a class="btn bg-blue-btn text-decoration-none" href="<?php echo base_url() ?>User/users">
                    <iconify-icon icon="solar:undo-left-round-broken"></iconify-icon>
                    <?php echo lang('back'); ?>
                </a>
            </div>
            <?php echo form_close(); ?>
        </div>
    </section>
</div>

<div class="modal fade" id="AddUserImageModal"  role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div id="upload-demo" class="upload_demo_single"></div>
                    </div>
                    <div class="col-md-12 text-center">
                        <strong><?php echo lang('select_image'); ?></strong>
                        <br>
                        <input type="file" class="form-control" id="upload">
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-blue-btn upload-result"><?php echo lang('crop'); ?></button>
                <button type="button" class="btn bg-blue-btn" data-bs-dismiss="modal"><?php echo lang('cancel'); ?></button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="show_image"  role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">
                <?php echo lang('view_image'); ?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i
                data-feather="x"></i></span></button>
            </div>
            <div class="modal-body">
                <div id="upload-demo-i" class="text-center">
                    <?php if(!empty($user_details->photo)){?>
                    <img class="img-responsive op_margin_bottom_5"
                        src="<?= base_url() . "uploads/employees_image/" . $user_details->photo ?>" alt="Photo">
                    <?php } else{?>
                        <img class="img-responsive op_margin_bottom_5"
                        src="<?= base_url() . 'uploads/site_settings/image_blank.png' ?>" alt="Photo" height="100" width="100">
                    <?php } ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-blue-btn" data-bs-dismiss="modal"><?php echo lang('close'); ?></button>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>frequent_changing/js/add_user.js"></script>
