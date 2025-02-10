<script src="<?php echo base_url(); ?>assets/plugins/local/jquery.timepicker.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/add_attendance.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/local/jquery.timepicker.min.css">
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
                <h3 class="top-left-header mt-2"><?php echo lang('add_update_attendance'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('attendance'), 'secondSection'=> lang('add_update_attendance')])?>
        </div>
    </section>

    <!-- Main content -->
    <div class="box-wrapper">
        <div class="table-box">
            <?php echo form_open(base_url('Attendance/addEditAttendance/' . $encrypted_id) ); ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('ref_no'); ?></label>
                            <input autocomplete="off" type="text" id="reference_no" readonly name="reference_no" class="form-control" placeholder="<?php echo lang('ref_no'); ?>" value="<?php echo escape_output($reference_no); ?>">
                        </div>
                        <?php if (form_error('reference_no')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('reference_no'); ?></span>
                            </div>
                        <?php } ?>
                    </div> 
                    <div class="col-md-6 col-lg-4 mb-3"> 
                        <div class="form-group">
                            <label><?php echo lang('date'); ?> <span class="required_star">*</span></label>
                            <input autocomplete="off" type="text" id="date" readonly name="date" class="form-control" placeholder="<?php echo lang('date'); ?>" value="<?php if($encrypted_id == ''){ echo date('d-m-Y'); }else{ echo escape_output($attendance_details->date); }?>">
                        </div>
                        <?php if (form_error('date')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('date'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('employee'); ?> <span class="required_star">*</span></label>
                            <select class="form-control select2 op_width_100_p" id="employee_id" name="employee_id">
                                <option value=""><?php echo lang('select'); ?></option>
                                <?php foreach ($employees as $value) { ?>

                                    <?php if($encrypted_id == ''){ ?>
                                        <option value="<?php echo escape_output($value->id) ?>" <?php echo set_select('employee_id', $value->id); ?>><?php echo escape_output($value->full_name ."-". $value->phone)?></option>
                                    <?php }else{ ?>   
                                        <option value="<?php echo escape_output($value->id) ?>" 
                                        <?php
                                        if ($attendance_details->employee_id == $value->id) {
                                            echo "selected";
                                        }
                                        ?>>
                                        <?php echo escape_output($value->full_name ."-". $value->phone)?> 
                                        </option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="alert alert-info"></div>
                        <?php if (form_error('employee_id')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('employee_id'); ?></span>
                            </div>
                        <?php } ?>
                    </div> 
                    <div class="col-md-6 col-lg-4 mb-3" id="in_time_container">
                        <div class="form-group"> 
                            <label><?php echo lang('in_time'); ?> <?php if($encrypted_id == ''){ echo '<span class="required_star">*</span>'; } ?></label>
                            <input autocomplete="off" type="text" name="in_time" id="in_time" class="form-control op_width_100_p" placeholder="<?php echo lang('in_time'); ?>" value="<?php if($encrypted_id == ''){ echo set_value('in_time'); }else{ echo escape_output($attendance_details->in_time); }?>">
                        </div>
                        <?php if (form_error('in_time')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('in_time'); ?></span>
                            </div>
                        <?php } ?> 
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3" id="out_time_container">
                        <div class="form-group"> 
                            <label><?php echo lang('out_time'); ?> <?php if($encrypted_id != ''){ echo '<span class="required_star">*</span>'; } ?></label>
                            <input autocomplete="off" type="text" name="out_time" id="out_time" class="form-control op_width_100_p" placeholder="<?php echo lang('out_time'); ?>" value="<?php if($encrypted_id == ''){ echo set_value('out_time'); }else{ echo escape_output($attendance_details->out_time); }?>">
                        </div>
                        <?php if (form_error('out_time')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('out_time'); ?></span>
                            </div>
                        <?php } ?> 
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('note'); ?></label>
                            <input class="form-control" name="note" placeholder="<?php echo lang('note'); ?> ..." value="<?php if($encrypted_id == ''){}else{ echo escape_output($attendance_details->note); }?>">
                        </div> 
                        <?php if (form_error('note')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('note'); ?></span>
                            </div>
                        <?php } ?>  
                    </div> 
                </div>
            </div>  
            <input type="hidden" name="in_or_out" value="">
            <input type="hidden" id="encrypted_id" value="<?php echo ($encrypted_id != '') ? 1:0 ?>">
            
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
                <a class="btn bg-blue-btn text-decoration-none" href="<?php echo base_url() ?>Attendance/attendances">
                    <iconify-icon icon="solar:undo-left-round-broken"></iconify-icon>
                    <?php echo lang('back'); ?>
                </a>
            </div>


            <?php echo form_close(); ?>
        </div>
    </div>
</div>