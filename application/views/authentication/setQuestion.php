<!-- Main content -->
<section class="main-content-wrapper">
<h3 class="display_none">&nbsp;</h3>
<?php
    if ($this->session->flashdata('exception')) {
        echo '<section class="alert-wrapper"><div class="alert alert-success alert-dismissible fade show"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></button>
        <div class="alert-body"><i class="icon fa fa-check me-2"></i>';
        echo escape_output($this->session->flashdata('exception'));unset($_SESSION['exception']);
        echo '</div></div></section>';
    }
    ?>


    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo lang('SetSecurityQuestion'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('SetSecurityQuestion'), 'secondSection'=> lang('SetSecurityQuestion')])?>
        </div>
    </section>
    


    <div class="box-wrapper">
        <div class="table-box">
            <?= form_open(base_url('User/securityQuestion/' . (isset($profile_info) && $profile_info ? $this->custom->encrypt_decrypt($profile_info->id, 'encrypt') : ''))); ?>
            <div class="box-body"> 
                <div class="row">

                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('SecurityQuestion'); ?> <span class="required_star">*</span></label>
                            <select class="form-control select2 fly_3 select2" name="question" id="question">
                                <?php if(isset($profile_info) && ($profile_info->question!='')){ ?>
                                    <option value="<?php echo escape_output($profile_info->question); ?>" <?php echo "selected = 'selected'"?>><?php echo escape_output($profile_info->question); ?></option>
                                <?php } ?>
                                <?php foreach ($question as $value) {  ?>
                                    <option value="<?php echo escape_output($value); ?>" <?php if ($value == set_value('question')) echo "selected = 'selected'"?>><?php echo escape_output($value); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('SecurityAnswer'); ?> <span class="required_star">*</span></label>
                            <input type="text" name="answer" class="form-control" placeholder="<?php echo lang('SecurityAnswer'); ?>" value="<?= isset($profile_info) && $profile_info->answer ? $profile_info->answer : set_value('answer') ?>">
                        </div>
                        <?php if (form_error('answer')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('answer'); ?></span>
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
</section>