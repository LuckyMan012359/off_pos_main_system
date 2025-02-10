<div class="main-content-wrapper">
    <?php
    if ($this->session->flashdata('exception')) {

        //This variable could not be escaped because this is html content
        echo '<section class="alert-wrapper"><div class="alert alert-success alert-dismissible fade show"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></button>
        <div class="alert-body"><i class="icon fa fa-check me-2"></i>';
        echo escape_output($this->session->flashdata('exception'));unset($_SESSION['exception']);
        //This variable could not be escaped because this is html content
        echo '</div></div></section>';
    }
    ?>

    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo lang('change_profile'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('change_profile'), 'secondSection'=> lang('change_profile')])?>
        </div>
    </section>


    <!-- Main content -->
    <div class="box-wrapper">
        <div class="table-box">
            <?php 
            $attributes = array('id' => 'change_profile');
            echo form_open_multipart(base_url('User/changeProfile/' . (isset($encrypted_id) && $encrypted_id?$encrypted_id:'')), $attributes); ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('name'); ?> <span class="required_star">*</span></label>
                            <input  autocomplete="off" type="text" name="full_name" class="form-control" placeholder="<?php echo lang('name'); ?>" value="<?= isset($profile_info) && $profile_info->full_name ? $profile_info->full_name : set_value('full_name') ?>">
                        </div>
                        <?php if (form_error('full_name')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('full_name'); ?></span>
                            </div>
                        <?php } ?>
                    </div>


                    <div class="col-md-6 col-lg-4 mb-3">

                        <div class="form-group">
                            <label><?php echo lang('email_address'); ?> <span class="required_star">*</span></label>
                            <input  autocomplete="off" type="text" name="email_address" class="form-control" placeholder="<?php echo lang('email_address'); ?>" value="<?= isset($profile_info) && $profile_info->email_address ? $profile_info->email_address : set_value('email_address') ?>">
                        </div>
                        <?php if (form_error('email_address')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('email_address'); ?></span>
                            </div>
                        <?php } ?>

                    </div>

                    <div class="col-md-6 col-lg-4 mb-3">

                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label>
                                    <?php echo lang('phone'); ?> <span class="required_star">*</span>
                                </label>
                                <div class="ms-3 op_right op_font_18 op_cursor_pointer mb-4-px">
                                    <i data-tippy-content="<?php echo lang('login_with_number_msg'); ?>" class="fa-regular fa-circle-question tippyBtnCall font-16 theme-color"></i>
                                </div>
                            </div>

                            <input  autocomplete="off" type="text" name="phone" class="form-control integerchk" placeholder="<?php echo lang('phone'); ?>" value="<?= isset($profile_info) && $profile_info->phone ? $profile_info->phone : set_value('phone') ?>">
                        </div>
                        <?php if (form_error('phone')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('phone'); ?></span>
                            </div>
                        <?php } ?>
                    </div> 
               
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label> <?php echo lang('photo');?> </label> 
                            <div class="d-flex align-items-center">
                                <input type="file" name="photo" class="form-control m-0">
                                <input type="hidden" name="photo_old" class="m-0" value="<?= isset($profile_info) && $profile_info->photo ? $profile_info->photo : '' ?>">
                                <button id="view_photo" type="button" class="new-btn h-40 ms-1" data-bs-toggle="modal" data-bs-target="#view_photo_modal">
                                    <iconify-icon icon="solar:eye-bold-duotone" width="18"></iconify-icon>
                                </button>
                            </div>
                        </div>
                        <?php if (form_error('photo')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('photo'); ?></span>
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
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<div id="view_photo_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title"><?php echo lang('photo'); ?></h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i
                data-feather="x"></i></span>
            </button>
            </div>
            <div class="modal-body">
                <p class="text-center"> 
                    <?php if (!empty($profile_info->photo)) { ?>
                    <img class="profile_photo" src="<?php echo base_url().'uploads/employees_image/'. $profile_info->photo ?>" alt="">
                    <?php 
                        }else{ 
                            echo "<h5>".lang('Not_Available')."</h5>";
                        } 
                    ?>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-blue-btn" data-bs-dismiss="modal"><?php echo lang('close');?></button>
            </div>
        </div>
    </div>
</div> 