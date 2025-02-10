<link rel="stylesheet" href="<?php echo base_url(); ?>assets/cropper/cropper.min.css">
<!-- Main content -->
<section class="main-content-wrapper">
<h3 class="display_none">&nbsp;</h3>
    <?php
    if ($this->session->flashdata('exception')) {
        echo '<section class="alert-wrapper"><div class="alert alert-success alert-dismissible fade show"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <div class="alert-body"><i class="m-right fa fa-check"></i>';
        echo escape_output($this->session->flashdata('exception'));unset($_SESSION['exception']);
        echo '</div></div></section>';
    }
    ?>

    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo lang('login_page'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('login_page'), 'secondSection'=> lang('login_page')])?>
        </div>
    </section>


    <div class="box-wrapper">
        <div class="table-box">
            <?php
            $login_info = isset($company_information->login_page) && $company_information->login_page ? json_decode($company_information->login_page) : '';
            echo form_open_multipart(base_url('Authentication/logingPage')); ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12 mb-3 col-md-6">
                        <div class="form-group">
                            <label><?php echo lang('title'); ?> <span class="required_star">*</span></label>
                            <input  autocomplete="off" type="text" name="title" class="form-control" placeholder="<?php echo lang('title'); ?>" value="<?php echo isset($login_info->title) && $login_info->title ? $login_info->title : ''; ?>">
                        </div>
                        <?php if (form_error('title')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('title'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-sm-12 mb-3 col-md-6">
                        <div class="form-group">
                            <label><?php echo lang('short_description'); ?> <span class="required_star">*</span></label>
                            <textarea name="short_description" class="form-control" placeholder="<?php echo lang('short_description'); ?>" ><?php echo isset($login_info->short_description) && $login_info->short_description ? $login_info->short_description : ''; ?></textarea>
                        </div>
                        <?php if (form_error('short_description')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('short_description'); ?>
                            </div>
                        <?php } ?>
                    </div>


                    <div class="col-sm-12 mb-3 col-md-6">
                        <div class="form-group">
                            <div class="form-label-action">
                                <label><?php echo lang('login_page_img'); ?> <span class="required_star"><b>(Recommanded Size 550px X 470px)</b></span></label>
                            </div>
                            <div class="d-flex">
                                <input  type="file" name="login_page_img" class="form-control m-0" id="crop_image">
                                <input type="hidden" name="login_page_img" id="cropped_logo">
                                <?php
                                    $login_img = isset($login_info->login_page_img) && $login_info->login_page_img ? $login_info->login_page_img : '';
                                    $logoPath = base_url().'uploads/site_settings/'. $login_img;
                                ?>
                                <a href="javascript:void(0)" data-file_path="<?php echo escape_output($logoPath)?>" data-id="1" class="new-btn ms-2 show_preview">
                                    <iconify-icon icon="solar:eye-bold-duotone" width="18"></iconify-icon>
                                </a>
                            </div>
                            <input  type="hidden" name="login_page_img_old"
                            class="form-control" value="<?php echo $login_img; ?>">
                        </div>
                        <?php if (form_error('login_page_img')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('login_page_img'); ?></span>
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
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</section>




<div class="modal fade" id="logo_preview"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><?php echo lang('invoice_logo');?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12  op_center op_padding_10">
                        <img class="img-fluid" src="" alt="invoice-logo" id="show_id">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-blue-btn"
                     data-bs-dismiss="modal"><?php echo lang('close');?></button>
            </div>
        </div>
    </div>
</div>

<div id="crop_image_modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo lang('company_logo');?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <img class="img-fluid displayNone" src="-" alt="">
                </div>
                <br>
                <button id="crop_result" class="btn bg-blue-btn"><?php echo lang('crop');?></button>
            </div>
        </div>
    </div>
</div>



<script src="<?php echo base_url(); ?>assets/cropper/cropper.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/login_page_image_crop.js"></script>
