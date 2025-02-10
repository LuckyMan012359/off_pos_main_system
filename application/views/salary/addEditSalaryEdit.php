<link rel="stylesheet" href="<?php echo base_url()?>frequent_changing/css/checkBotton2.css">
<input type="hidden" id="precision" value="<?php echo escape_output($this->session->userdata('precision')) ?>">
<input type="hidden" id="account_field_required" value="<?php echo lang('account_field_required') ?>">

<!-- Main content -->
<section class="main-content-wrapper">
<h3 class="display_none">&nbsp;</h3>
    <?php
    if ($this->session->flashdata('exception')) {
        echo '<section class="alert-wrapper"><div class="alert alert-success alert-dismissible fade show"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <div class="alert-body"><p><i class="m-right fa fa-check"></i>';
        echo escape_output($this->session->flashdata('exception'));unset($_SESSION['exception']);
        echo '</div></div></section>';
    }
    ?>

    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo lang('edit_salary_payroll'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('salary'), 'secondSection'=> lang('edit_salary_payroll')])?>
        </div>
    </section>

    <div class="box-wrapper">
        <div class="table-box">
            <div class="row">
                <div class="col-md-12"><br>
                    <div class="form-group">
                        <h3 class="top-left-header txt-uh-82"><?php echo lang('salary_sheet_for'); ?>: <?php echo escape_output($getSelectedRow->month); ?> - <?php echo escape_output($getSelectedRow->year); ?></h3>
                    </div>
                </div>
            </div>



            <!-- form start -->
            <?php
            $attributes = array('id' => 'add_salary');
            echo form_open_multipart(base_url('salary/addEditSalary/'.$this->custom->encrypt_decrypt($getSelectedRow->id, 'encrypt')), $attributes); ?>
            <input type="hidden" name="month" value="<?php echo escape_output($getSelectedRow->month); ?>">
            <input type="hidden" name="year" value="<?php echo escape_output($getSelectedRow->year); ?>">
            <div class="box-body table-responsive salary_tbl_wrap">
                <table id="datatable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th class="w-10 text-left"><label  class="container width_83_p"> <?php echo lang('select_all'); ?>
                                <input class="checkbox_userAll" type="checkbox" id="checkbox_userAll">
                                <span class="checkmark"></span>
                            </label></th>
                        <th class="w-20"><?php echo lang('name'); ?></th>
                        <th class="w-10"><?php echo lang('salary'); ?></th>
                        <th class="w-10"><?php echo lang('addition'); ?></th>
                        <th class="w-10"><?php echo lang('subtraction'); ?></th>
                        <th class="w-10"><?php echo lang('total'); ?></th>
                        <th class="w-30"><?php echo lang('note'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $getData = json_decode($getSelectedRow->details_info);
                    foreach ($getData as $usrs) {
                            ?>
                            <tr class="row_counter" data-id="<?php echo escape_output($usrs->user_id); ?>">
                                <td>
                                    <table class="w-100">
                                        <tr>
                                            <td class="text-start">  
                                                <label class="container"><?php echo lang('select'); ?>
                                                    <input type="checkbox"  class="checkbox_user" value="1" <?php echo isset($usrs->p_status) && $usrs->p_status?'checked':''?> name="product_id<?php echo escape_output($usrs->user_id); ?>">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td>
                                    <?php echo escape_output($usrs->name); ?>
                                    <input type="hidden" name="user_id[]" value="<?php echo escape_output($usrs->user_id); ?>">
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" placeholder="<?php echo lang('salary_amount'); ?>" class="form-control"  id="salary_<?php echo escape_output($usrs->user_id); ?>" name="salary[]" value="<?php echo isset($usrs->salary) && $usrs->salary? getAmtPre($usrs->salary):getAmtPre(0)?>" readonly>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" placeholder="<?php echo lang('additional'); ?>" class="form-control cal_row integerchk" onfocus="select();" id="additional_<?php echo escape_output($usrs->user_id); ?>"  name="additional[]" value="<?php echo isset($usrs->additional) && $usrs->additional? getAmtPre($usrs->additional): getAmtPre(0)?>">
                                    </div>                                        
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" placeholder="<?php echo lang('subtraction'); ?>" class="form-control cal_row integerchk" onfocus="select();" id="subtraction_<?php echo escape_output($usrs->user_id); ?>"  name="subtraction[]" value="<?php echo isset($usrs->subtraction) && $usrs->subtraction? getAmtPre($usrs->subtraction) : getAmtPre(0)?>">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" placeholder="<?php echo lang('total'); ?>" class="form-control" readonly id="total_<?php echo escape_output($usrs->user_id); ?>"  name="total[]" value="<?php echo isset($usrs->total) && $usrs->total? getAmtPre($usrs->total) : getAmtPre(0)?>">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" placeholder="<?php echo lang('note'); ?>" class="form-control"  name="notes[]" value="<?php echo isset($usrs->notes) && $usrs->notes?$usrs->notes:''?>">
                                    </div>
                                </td>
                            </tr>
                            <?php
                    }
                    ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td><?php echo lang('salary'); ?> = <span class="total_salary"></span></td>
                        <td><?php echo lang('addition'); ?> = <span class="total_addition"></span></td>
                        <td><?php echo lang('subtraction'); ?> = <span class="total_subtraction"></span></td>
                        <td><?php echo lang('total'); ?> = <span class="total_amount"></span></td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
                <br>
                <div class="col-md-1"></div>
                <div class="clearfix"></div>
                <div class="col-md-8"></div>

                <div class="col-md-3 margin-left-auto">
                    <div class="form-group">
                        <label><?php echo lang('payment_methods'); ?> <span class="required_star"> *</span></label>
                        <select  class="form-control select2 width_100_p" id="payment_method_id" name="payment_method_id">
                            <option value=""><?php echo lang('select'); ?></option>
                            <?php foreach ($paymentMethods as $ec) { ?>
                                <option <?php echo isset($getSelectedRow->payment_id) && $getSelectedRow->payment_id==$ec->id?'selected':''?> value="<?php echo escape_output($ec->id) ?>" <?php echo set_select('payment_method_id', $ec->id); ?>><?php echo escape_output($ec->name) ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <?php if (form_error('payment_method_id')) { ?>
                        <div class="alert alert-error txt-uh-21">
                            <p><?php echo form_error('payment_method_id'); ?></p>
                        </div>
                    <?php } ?>
                    <div class="alert alert-error error-msg payment_method_id_err_msg_contnr alert-small">
                        <p id="payment_method_id_err_msg"></p>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" name="submit" value="submit" class="btn bg-blue-btn">
                    <iconify-icon icon="solar:upload-minimalistic-broken"></iconify-icon>
                    <?php echo lang('submit'); ?>
                </button>
                
                <a class="btn bg-blue-btn text-decoration-none" href="<?php echo base_url() ?>salary/generate">
                    <iconify-icon icon="solar:undo-left-round-broken"></iconify-icon>
                    <?php echo lang('back'); ?>
                </a>
            </div>

            <?php echo form_close(); ?>
        </div>
    </div>
</section>
<script src="<?php echo base_url(); ?>frequent_changing/js/salary.js"></script>
