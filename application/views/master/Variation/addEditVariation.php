
<input type="hidden" id="variation_value" value="<?php echo lang('variation_value');?>">
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
                <?php 
                if(isset($Variations)){
                    $language = lang('edit_variation');
                }else{
                    $language = lang('add_variation');
                }
                ?>
                <h3 class="top-left-header mt-2"><?php echo $language ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('variation'), 'secondSection'=> $language])?>
        </div>
    </section>



    <section class="box-wrapper">
    <h3 class="display_none">&nbsp;</h3>
        <div class="table-box"> 
            <?php echo form_open(base_url() . 'Variation/addEditVariation/' . (isset($Variations) ? $this->custom->encrypt_decrypt($Variations->id, 'encrypt') : ''), $arrayName = array('id' => 'add_variation', 'class' => 'mb-0')) ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label><?php echo lang('variation_name'); ?> <span class="required_star">*</span></label>
                            <input  autocomplete="off" type="text" name="variation_name" class="form-control" placeholder="<?php echo lang('variation_name'); ?>" value="<?php echo isset($Variations) && $Variations ? $Variations->variation_name : set_value('variation_name') ?>">
                        </div>
                        <?php if (form_error('variation_name')) { ?>
                            <div class="alert alert-error txt-uh-21">
                                <p><?php echo form_error('variation_name'); ?></p>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-12 mt-3">
                        <div class="div_row">
                                <?php
                                    if(isset($Variations->variation_value) && $Variations->variation_value):
                                        $vari_value = json_decode($Variations->variation_value);
                                    foreach ($vari_value as $key=>$value):
                                ?>
                                <div class="form-group">
                                    <?php
                                    if($key=="0"):
                                    ?>
                                    <label><?php echo lang('variation_value'); ?></label>
                                        <?php
                                        endif;
                                        ?>
                                        <div class="d-flex mb-3">
                                        <input  onfocus="select();" autocomplete="off"  name="variation_value[]" class="form-control check_required" value="<?=escape_output($value)?>" placeholder="<?php echo lang('variation_value'); ?>">
                                        <button type="button" class="remove_row color_red new-btn-danger h-40 ms-3"><iconify-icon icon="solar:trash-bin-minimalistic-broken" width="18"></iconify-icon></button></div>
                                </div>
                                <?php
                                    endforeach;
                                else:
                                ?>
                                <div class="form-group">
                                    <label><?php echo lang('variation_value'); ?></label>
                                    <div class="d-flex mb-3">
                                    <input  autocomplete="off"  onfocus="select();"  name="variation_value[]" class="form-control check_required" value="" placeholder="<?php echo lang('variation_value'); ?>"></td>
                                    <button type="button" class="remove_row color_red new-btn-danger h-40 ms-3"><iconify-icon icon="solar:trash-bin-minimalistic-broken" width="18"></iconify-icon></i></a>
                                    </div>
                                </div>
                                <?php
                                endif;
                                ?>
                            </div>
                            <div class="width_125px mb-2">
                                <a href="javascript:void(0)" class="new-btn btn-xs add_row "><iconify-icon icon="solar:add-circle-broken" width="22"></iconify-icon> <?php echo lang('add_row'); ?></a>
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
                <a class="btn bg-blue-btn text-decoration-none" href="<?php echo base_url() ?>Variation/variations">
                    <iconify-icon icon="solar:undo-left-round-broken"></iconify-icon>
                    <?php echo lang('back'); ?>
                </a>
            </div>

            <?php echo form_close(); ?>
        </div>
    </section>
</div>

<script src="<?php echo base_url(); ?>frequent_changing/js/add_variation.js"></script>