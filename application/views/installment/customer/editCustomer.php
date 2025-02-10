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
                <h3 class="top-left-header mt-2"><?php echo lang('edit_installment_customer'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('installment_customer'), 'secondSection'=> lang('edit_installment_customer')])?>
        </div>
    </section>



    <div class="box-wrapper">
        <div class="table-box">
            <?php echo form_open_multipart(base_url('Installment/addEditCustomer/' . $encrypted_id)); ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="form-group">
                                <label><?php echo lang('customer_name'); ?> <span class="required_star">*</span></label>
                                <input  autocomplete="off" type="text" name="name" class="form-control" placeholder="<?php echo lang('customer_name'); ?>" value="<?=$customer_information->name?>">
                            </div>
                            <?php if (form_error('name')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('name'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="form-group">
                                <label><?php echo lang('phone'); ?> <span class="required_star">*</span></label>
                                <input  autocomplete="off" type="text" name="phone" class="form-control integerchk" placeholder="<?php echo lang('phone'); ?>" value="<?=$customer_information->phone?>">
                            </div>
                            <?php if (form_error('phone')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('phone'); ?></span>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="form-group">
                                <label><?php echo lang('email'); ?> <span class="required_star">*</span></label>
                                <input  autocomplete="off" type="text" name="email" class="form-control" placeholder="<?php echo lang('email'); ?>" value="<?=$customer_information->email?>">
                            </div>
                            <?php if (form_error('email')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('email'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="form-group">
                                <label><?php echo lang('present_address'); ?> <span class="required_star">*</span></label>
                                <textarea  name="address" class="form-control h-90" placeholder="<?php echo lang('present_address'); ?>"><?=$customer_information->address?></textarea>
                                <?php if (form_error('address')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <span class="error_paragraph"><?php echo form_error('address'); ?></span>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="form-group">
                                <label><?php echo lang('Permanent_Address'); ?> <span class="required_star">*</span></label>
                                <textarea  name="permanent_address" class="form-control h-90" placeholder="<?php echo lang('Permanent_Address'); ?>"><?=$customer_information->permanent_address?></textarea>
                                <?php if (form_error('permanent_address')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <span class="error_paragraph"><?php echo form_error('permanent_address'); ?></span>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="form-group">
                                <label><?php echo lang('Work_Address'); ?> <span class="required_star">*</span></label>
                                <textarea  name="work_address" class="form-control h-90" placeholder="<?php echo lang('Work_Address'); ?>"><?=$customer_information->work_address?></textarea>
                                <?php if (form_error('work_address')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <span class="error_paragraph"><?php echo form_error('work_address'); ?></span>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="form-group">
                                <label><?php echo lang('NID'); ?> <span class="required_star">*</span></label>
                                <div class="d-flex">
                                    <input  type="file" id="customer_nid"  name="customer_nid" class="form-control" accept="image/*">
                                    <a href="javascript:void(0)" class="new-btn h-40 ms-2 show_preview" data-bs-toggle="modal" data-bs-target="#exampleModal" get-title="<?php echo lang('customer_nid'); ?>" get-file="<?php echo escape_output($customer_information->customer_nid); ?>">
                                    <iconify-icon icon="solar:eye-bold-duotone" width="18"></iconify-icon>
                                    </a>
                                </div>
                                <input type="hidden" name="customer_nid_e" value="<?=$customer_information->customer_nid?>">
                                <?php if (form_error('customer_nid')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <span class="error_paragraph"><?php echo form_error('customer_nid'); ?></span>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="form-group">
                                <label><?php echo lang('photo'); ?> <span class="required_star">*</span></label>
                                <div class="d-flex">
                                    <input type="file" id="photo"  name="photo" class="form-control" accept="image/*">
                                    <a href="javascript:void(0)" class="new-btn h-40 ms-2 show_preview" data-bs-toggle="modal" data-bs-target="#exampleModal" get-title="<?php echo lang('customer_photo'); ?>" get-file="<?php echo escape_output($customer_information->photo); ?>">
                                        <iconify-icon icon="solar:eye-bold-duotone" width="18"></iconify-icon>
                                    </a>
                                </div>
                                <input type="hidden" name="photo_p" value="<?=$customer_information->photo?>">
                                <?php if (form_error('photo')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <span class="error_paragraph"><?php echo form_error('photo'); ?></span>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="form-group">
                                <label><?php echo lang('Guarantor_Name'); ?> <span class="required_star">*</span></label>
                                <input  autocomplete="off" type="text" name="g_name" class="form-control" placeholder="<?php echo lang('Guarantor_Name'); ?>" value="<?=$customer_information->g_name?>">
                            </div>
                            <?php if (form_error('g_name')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('g_name'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="form-group">
                                <label><?php echo lang('Guarantor_Mobile_No'); ?> <span class="required_star">*</span></label>
                                <input  autocomplete="off" type="text" name="g_mobile" class="form-control" placeholder="<?php echo lang('Guarantor_Mobile_No'); ?>" value="<?=$customer_information->g_mobile?>">
                            </div>
                            <?php if (form_error('g_mobile')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('g_mobile'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="clearfix"></div>

                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="form-group">
                                <label><?php echo lang('Guarantor_Present_Address'); ?> <span class="required_star">*</span></label>
                                <textarea id="g_pre_address" name="g_pre_address" class="form-control h-90" placeholder="<?php echo lang('Guarantor_Present_Address'); ?>"><?=$customer_information->g_pre_address?></textarea>
                                <?php if (form_error('g_pre_address')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <span class="error_paragraph"><?php echo form_error('g_pre_address'); ?></span>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="form-group">
                                <label><?php echo lang('Guarantor_Permanent_Address'); ?> <span class="required_star">*</span></label>
                                <textarea id="g_permanent_address" name="g_permanent_address" class="form-control h-90" placeholder="<?php echo lang('Guarantor_Permanent_Address'); ?>"><?=$customer_information->g_permanent_address?></textarea>
                                <?php if (form_error('g_permanent_address')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <span class="error_paragraph"><?php echo form_error('g_permanent_address'); ?></span>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="form-group">
                                <label><?php echo lang('Guarantor_Work_Address'); ?> <span class="required_star">*</span></label>
                                <textarea id="g_work_address"  name="g_work_address" class="form-control h-90" placeholder="<?php echo lang('Guarantor_Work_Address'); ?>"><?=$customer_information->g_work_address?></textarea>
                                <?php if (form_error('g_work_address')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <span class="error_paragraph"><?php echo form_error('g_work_address'); ?></span>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="clearfix"></div>



                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="form-group">
                                <label><?php echo lang('Guarantor_NID'); ?></label>
                                <div class="d-flex">
                                    <input type="file" name="g_nid" class="form-control" accept="image/*">
                                    <a href="javascript:void(0)" class="new-btn h-40 ms-2 show_preview" data-bs-toggle="modal" data-bs-target="#exampleModal" get-title="<?php echo lang('Guarantor_NID'); ?>" get-file="<?php echo escape_output($customer_information->g_nid); ?>">
                                        <iconify-icon icon="solar:eye-bold-duotone" width="18"></iconify-icon>
                                    </a>
                                </div>
                                <input type="hidden" name="g_nid_e" value="<?=$customer_information->g_nid?>">
                                <?php if (form_error('g_nid')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <span class="error_paragraph"><?php echo form_error('g_nid'); ?></span>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="form-group">
                                <label><?php echo lang('Guarantor_photo'); ?></label>
                                <div class="d-flex">
                                    <input type="file" name="g_photo" class="form-control" accept="image/*">
                                    <a href="javascript:void(0)" class="new-btn h-40 ms-2 show_preview" data-bs-toggle="modal" data-bs-target="#exampleModal" get-title="<?php echo lang('Guarantor_photo'); ?>" get-file="<?php echo escape_output($customer_information->g_photo); ?>">
                                        <iconify-icon icon="solar:eye-bold-duotone" width="18"></iconify-icon>
                                    </a>
                                </div>
                                <input type="hidden" name="g_photo_e" value="<?=$customer_information->g_photo?>">
                            </div>
                            <?php if (form_error('g_photo')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('g_photo'); ?></span>
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
                    <input type="hidden" id="set_save_and_add_more" name="add_more">
                    <button type="submit" name="submit" value="submit" class="btn bg-blue-btn" id="save_and_add_more">
                        <iconify-icon icon="solar:undo-right-round-broken"></iconify-icon>
                        <?php echo lang('save_and_add_more'); ?>
                    </button>
                    <a class="btn bg-blue-btn text-decoration-none" href="<?php echo base_url() ?>Installment/customers">
                        <iconify-icon icon="solar:undo-left-round-broken"></iconify-icon>
                        <?php echo lang('back'); ?>
                    </a>
                </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="exampleModal"  aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">&nbsp;</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12  op_center op_padding_10">
                        <img class="img-fluid" src="-" id="show_id_installment">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-blue-btn"
                data-bs-dismiss="modal"><?php echo lang('cancel');?></button>
            </div>
        </div>
    </div>
</div>



<script src="<?php echo base_url(); ?>frequent_changing/js/installment-list.js"></script>


