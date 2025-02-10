<link rel="stylesheet" href="<?php echo base_url() ?>frequent_changing/css/checkBotton.css">
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
                <h3 class="top-left-header mt-2"><?php echo lang('edit_role'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('role'), 'secondSection'=> lang('edit_role')])?>
        </div>
    </section>

    <section class="box-wrapper">
    <h3 class="display_none">&nbsp;</h3>
        <div class="table-box">
            <?php
            $attributes = array('id' => 'add_user');
            echo form_open_multipart(base_url('Role/addEditRole/' . $encrypted_id), $attributes); ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('role_name'); ?> <span class="required_star">*</span></label>
                            <input  autocomplete="off" type="text" name="role_name" class="form-control" placeholder="<?php echo lang('role_name'); ?>"
                                value="<?php echo escape_output($role_details->role_name); ?>">
                        </div>
                        <?php if (form_error('role_name')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('role_name'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <div id="will_login_section">
                    <div class="row">
                        <label class="col-md-2 col-form-label"><?php echo lang('menu_access'); ?> <span class="required_star">*</span></label>
                        <div class="col-md-3">
                            <label class="container op_margin_top_6 op_color_dim_grey"> <?php echo lang('select_all'); ?>
                                <input class="checkbox_userAll" type="checkbox" id="checkbox_userAll">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="clearfix"></div>
                        <span class="error_alert_atleast op_color_red op_margin_left_16" role="alert"></span>
                        <?php
                        $ignoreModule = array();
                        foreach($access_modules as $keys=>$value){
                            if (!in_array($value->main_module_id, $ignoreModule)) {
                                $ignoreModule[] = $value->main_module_id;
                                ?>
                                <div class="col-sm-12 my-2">
                                    <table class="op_width_100_p op_margin_top_M_9">
                                        <tbody>
                                        <tr>
                                            <td width="30%">
                                                <hr class="op_border_bottom_nobel">
                                            </td>
                                            <td width="10%" class="op_center"><b
                                                class="op_font_weight_b"><?=getMainModuleName($value->main_module_id)?></b></td>
                                            <td width="30%">
                                                <hr class="op_border_bottom_nobel">
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="access-card">
                                    <label class="container op_margin_top_6 op_color_dim_grey header-element"> <?="<b>".$value->label_name."</b>"?>
                                        <input class="checkbox_user_p  parent_class parent_class_<?php echo str_replace(' ', '_', $value->module_name)?>" data-name="<?php echo str_replace(' ', '_', $value->module_name)?>" type="checkbox">
                                        <span class="checkmark"></span>
                                    </label>

                                <!-- <hr class="op_margin_top_9 op_margin_bottom_9"> -->
                                    <?php
                                    foreach($value->functions as $keys_f=>$value_f) {
                                        $checked = '';
                                        $access_id_ = $value_f->id;
                                        if (isset($selected_modules_arr)):
                                            foreach ($selected_modules_arr as $uma) {
                                                if (in_array($access_id_, $selected_modules_arr)) {
                                                    $checked = 'checked';
                                                } else {
                                                    $checked = '';
                                                }
                                            }
                                        endif;
                                        ?>

                                        <div class="">
                                            <label class="container op_color_dark_grey"><?=$value_f->label_name?>
                                                <input type="checkbox" <?=$checked?> class="checkbox_user child_class child_<?php echo str_replace(' ', '_', $value->module_name)?>" data-parent_name="<?php echo str_replace(' ', '_', $value->module_name)?>" value="<?=$value->id?>|<?=$value_f->id?>" name="access_id[]">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
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
                    <a class="btn bg-blue-btn text-decoration-none" href="<?php echo base_url() ?>Role/listRole">
                        <iconify-icon icon="solar:undo-left-round-broken"></iconify-icon>
                        <?php echo lang('back'); ?>
                    </a>
                </div>
            <?php echo form_close(); ?>
        </div>
    </section>
</div>


<script src="<?php echo base_url(); ?>frequent_changing/js/add_role.js"></script>
