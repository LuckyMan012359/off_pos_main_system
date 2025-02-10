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
                <h3 class="top-left-header mt-2"><?php echo lang('module_management'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('setting'), 'secondSection'=> lang('module_management')])?>
        </div>
    </section>

    <section class="box-wrapper">
    <h3 class="display_none">&nbsp;</h3>
        <div class="table-box">
            <?php
            $attributes = array('id' => 'module_management');
            echo form_open_multipart(base_url('Setting/moduleManagement'), $attributes); ?>
            <div class="box-body">
                <div class="row" id="will_login_section">
                    <label class="col-md-2 col-form-label">Menu Show <span class="required_star">*</span></label>
                    <div class="col-md-3">
                        <label class="container op_margin_top_6 op_color_dim_grey"> <?php echo lang('select_all'); ?>
                            <input class="checkbox_userAll" type="checkbox" id="checkbox_userAll">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                    <div class="clearfix"></div>
                    <span class="error_alert_atleast op_color_red op_margin_left_16" role="alert"></span>
                    <?php
                    foreach($module as $keys=>$value){
                    ?>
                        <div class="col-sm-12 my-2">
                            <table class="op_width_100_p op_margin_top_M_9">
                                <tbody>
                                <tr>
                                    <td width="30%">
                                        <hr class="op_border_bottom_nobel">
                                    </td>
                                    <td width="10%" class="op_center"><b
                                        class="op_font_weight_b"><?= escape_output($value->module_name)?></b></td>
                                    <td width="30%">
                                        <hr class="op_border_bottom_nobel">
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                           
                        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                            <div class="access-card">
                                <label class="container op_margin_top_6 op_color_dim_grey header-element"> <?="<b>".$value->module_name."</b>"?>
                                    <input class="checkbox_user_p  parent_class parent_class_<?php echo str_replace(' ', '_', $value->module_name)?>" data-name="<?php echo str_replace(' ', '_', $value->module_name)?>" type="checkbox">
                                    <span class="checkmark"></span>
                                </label>
                                <?php
                                $child_module = getChildModule($value->id);
                                foreach($child_module as $keys_f=>$value_f) { 
                                ?>
                                <div class="">

                                    <label class="container op_color_dark_grey"><?=$value_f->module_name?>
                                        <input type="checkbox" <?php echo $value_f->is_hide == 'NO' ? 'checked' : '' ?> class="checkbox_user child_class child_<?php echo str_replace(' ', '_', $value_f->module_name)?> child_<?php echo str_replace(' ', '_', $value->module_name)?>" data-parent_name="<?php echo str_replace(' ', '_', $value_f->module_name)?>">
                                        <span class="checkmark"></span>
                                        <input type="hidden" name="menu_id<?=$value_f->id?>" value="<?php echo $value_f->is_hide == 'NO' ? 'NO' : 'YES' ?>" class="hidden_all hidden_menu_<?php echo str_replace(' ', '_', $value_f->module_name)?>">
                                        <input type="hidden" name="menu_arr[]" value="<?=$value_f->id?>">
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
            <div class="box-footer">
                <button type="submit" name="submit" value="submit" class="btn bg-blue-btn">
                    <iconify-icon icon="solar:upload-minimalistic-broken"></iconify-icon>
                    <?php echo lang('submit'); ?>
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


<script src="<?php echo base_url(); ?>frequent_changing/js/module_management.js"></script>
