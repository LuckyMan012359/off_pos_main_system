<?php
    $uri = $this->uri->segment(2);
    $is_collapse = $this->session->userdata('is_collapse');
    $wl = getWhiteLabel();
    $site_name = '';
    $site_footer = '';
    $site_title = '';
    $site_link = '';
    $site_logo = '';
    $site_favicon = '';
    if($wl){
        if($wl->site_name){
            $site_name = $wl->site_name;
        }
        if($wl->site_footer){
            $site_footer = $wl->site_footer;
        }
        if($wl->site_title){
            $site_title = $wl->site_title;
        }
        if($wl->site_link){
            $site_link = $wl->site_link;
        }
        if($wl->site_logo){
            $site_logo = $wl->site_logo;
        }
        if($wl->site_favicon){
            $site_favicon = $wl->site_favicon;
        }
    }

?>





<script src="<?php echo base_url('frequent_changing/js/setting.js'); ?>"></script>
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
                <h3 class="top-left-header mt-2"><?php echo lang('white_label'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('white_label'), 'secondSection'=> lang('white_label')])?>
        </div>
    </section>


    <div class="box-wrapper">
        <div class="table-box">
            <?php
            echo form_open_multipart(base_url('WhiteLabel/index')); ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12 mb-3 col-md-6">
                        <div class="form-group">
                            <label><?php echo lang('site_title'); ?> <span class="required_star">*</span></label>
                            <input  autocomplete="off" type="text" id="site_name" name="site_name" class="form-control" placeholder="<?php echo lang('site_name'); ?>" value="<?php echo escape_output($site_name); ?>">
                        </div>
                        <?php if (form_error('site_name')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('site_name'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-sm-12 mb-3 col-md-6">
                        <div class="form-group">
                            <label><?php echo lang('site_footer'); ?> <span class="required_star">*</span></label>
                            <input id="footer" name="site_footer" class="form-control" placeholder="<?php echo lang('site_footer'); ?>" value="<?php echo escape_output($site_footer); ?>">
                        </div>
                        <?php if (form_error('site_footer')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('site_footer'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-sm-12 mb-3 col-md-6">
                        <div class="form-group">
                            <label><?php echo lang('company_name'); ?> <span class="required_star">*</span></label>
                            <input  autocomplete="off" type="text" id="site_title" name="site_title" class="form-control" placeholder="<?php echo lang('site_title'); ?>" value="<?php echo escape_output($site_title); ?>">
                        </div>
                        <?php if (form_error('site_title')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('site_title'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-sm-12 mb-3 col-md-6">
                        <div class="form-group">
                            <label><?php echo lang('site_link'); ?> <span class="required_star">*</span></label>
                            <input  autocomplete="off" type="text" id="site_link" name="site_link" class="form-control" placeholder="<?php echo lang('site_link'); ?>" value="<?php echo escape_output($site_link); ?>">
                        </div>
                        <?php if (form_error('site_link')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('site_link'); ?>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="col-sm-12 mb-3 col-md-6">
                        <div class="form-group">
                            <div class="form-label-action">
                                <input type="hidden" name="site_logo_p" value="<?php echo escape_output($site_logo)?>">
                                <label><?php echo lang('site_logo'); ?> <?php echo lang('site_logo_size');?></label>
                            </div>
                            <div class="d-flex">
                                <input type="file" accept="image/*" name="site_logo" class="form-control">
                                <div class="ps-2">
                                    <a data-file_path="<?php echo base_url();?>/uploads/site_settings/<?php echo escape_output($site_logo);?>"  data-id="1" class="new-btn h-40  show_preview" href="javascript:void(0)"><iconify-icon icon="solar:eye-bold-duotone" width="18"></iconify-icon></a>
                                </div>
                            </div>
                        </div>
                        <?php if (form_error('site_logo')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('site_logo'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    
                    <div class="col-sm-12 mb-3 col-md-6">
                        <div class="form-group">
                            <div class="form-label-action">
                                <input type="hidden" name="site_favicon_p" value="<?php echo escape_output($site_favicon)?>">
                                <label><?php echo lang('site_favicon'); ?> <?php echo lang('site_favicon_size');?></label>
                            </div>
                            <div class="d-flex">
                                <input type="file" accept="image/*" name="site_favicon" class="form-control">
                                <div class="ps-2">
                                    <a data-file_path="<?php echo base_url();?>/uploads/site_settings/<?php echo escape_output($site_favicon);?>"  data-id="1" class="new-btn h-40 show_fav_preview" href="javascript:void(0)"><iconify-icon icon="solar:eye-bold-duotone" width="18"></iconify-icon></a>
                                </div>
                            </div>
                        </div>
                        <?php if (form_error('site_favicon')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('site_favicon'); ?>
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

    <div class="modal fade" id="logo_preview" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title">
                        <?php echo lang('site_logo'); ?> </h4>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true"><i data-feather="x"></i></span></button>
                </div>
                <div class="modal-bod">
                    <div class="bg-base">
                        <div class="row">
                            <div class="col-md-12 site_logo_parent_div">
                                <img class="site_logo_parent_img" src="<?php echo base_url();?>/uploads/site_settings/<?php echo escape_output($site_logo);?>" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-blue-btn" data-bs-dismiss="modal"><?php echo lang('close'); ?></button>
                </div>
            </div>

        </div>
    </div>
    

    <div class="modal fade" id="fav_preview" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title">
                        <?php echo lang('favicon_logo'); ?> </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true"><i data-feather="x"></i></span></button>
                </div>
                <div class="modal-bod">
                    <div class="row">
                        <div class="col-md-12 site_fav_parent_div">
                            <img class="site_logo_parent_img" src="<?php echo base_url();?>/uploads/site_settings/<?php echo escape_output($site_favicon);?>" id="show_fav_id" alt="">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-blue-btn" data-bs-dismiss="modal"><?php echo lang('close'); ?></button>
                </div>
            </div>

        </div>
    </div>
</section>
