<script src="<?php echo base_url();?>assets/fullcalendar-6.1.15/dist/index.global.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/flatpickr/flatpickr.min.css">
<script src="<?php echo base_url();?>assets/flatpickr/flatpickr.min.js"></script>


<link rel="stylesheet" href="<?php echo base_url() ?>frequent_changing/css/checkBotton.css">


<div class="main-content-wrapper">
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
                <h3 class="top-left-header"><?php echo lang('booking') ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('booking'), 'secondSection'=> lang('booking')])?>
        </div>
    </section>



    <div class="box-wrapper">
        <div class="table-box booking_management">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active booking_calender_trigger" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Booking Calender</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Booking List</button>
                        </li>
                    </ul>
                </div>
                <div>
                    <a class="new-btn me-1" id="add_booking_triger" href="javascript:void(0)">
                        <iconify-icon icon="solar:add-circle-broken" width="22"></iconify-icon>
                        Add Booking
                    </a>
                </div>
            </div>
        
            
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                    <div id="calendar"></div>
                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                    <div class="html_content"></div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Add Booking Modal -->
<div class="modal fade" id="add_booking" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title">
                Add Booking</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i data-feather="x">×</i></span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="booking_edit_hidden_id">
                <div class="row">
                    <div class="col-md-6 col-12 outlet_id">
                        <div class="form-group">
                            <label><?php echo lang('outlet');?></label>
                            <select  class="form-control select2" id="outlet_id" name="outlet_id">
                                <option value=""><?php echo lang('select_outlet');?></option>
                                <?php foreach($outlets as $key=>$outlet){?>
                                    <option value="<?php echo escape_output($outlet->id);?>"><?php echo escape_output($outlet->outlet_name);?></option>
                                <?php } ?>
                            </select>
                            <div class="alert alert-error error-msg outlet_id_err_msg_contnr modal_err_msg">
                                <p id="outlet_id_err_msg"></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12 customer_id">
                        <div class="form-group">
                            <label><?php echo lang('customer');?></label>
                            <select  class="form-control select2" id="customer_id" name="customer_id">
                                <option value=""><?php echo lang('select_customer');?></option>
                                <?php foreach($customers as $key=>$customer){?>
                                    <option value="<?php echo escape_output($customer->id);?>"><?php echo escape_output($customer->name);?></option>
                                <?php } ?>
                            </select>
                            <div class="alert alert-error error-msg customer_id_err_msg_contnr modal_err_msg">
                                <p id="customer_id_err_msg"></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12 service_seller_id">
                        <div class="form-group">
                            <label><?php echo lang('employee');?></label>
                            <select  class="form-control select2" id="service_seller_id" name="service_seller_id">
                                <option value=""><?php echo lang('select_employee');?></option>
                                <?php foreach($sellers as $key=>$seller){?>
                                    <option value="<?php echo escape_output($seller->id);?>"><?php echo escape_output($seller->full_name);?></option>
                                <?php } ?>
                            </select>
                            <div class="alert alert-error error-msg service_seller_id_err_msg_contnr modal_err_msg">
                                <p id="service_seller_id_err_msg"></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12 status">
                        <div class="form-group">
                            <label><?php echo lang('status');?></label>
                            <select  class="form-control select2" id="status" name="status">
                                <option value=""><?php echo lang('status');?></option>
                                <option value="Booked"><?php echo lang('Booked');?></option>
                                <option value="Waiting"><?php echo lang('Waiting');?></option>
                                <option value="Completed"><?php echo lang('Completed');?></option>
                                <option value="Cancelled"><?php echo lang('Cancelled');?></option>
                            </select>
                            <div class="alert alert-error error-msg status_err_msg_contnr modal_err_msg">
                                <p id="status_err_msg"></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label>Start Date</label>
                            <input autocomplete="off" type="text" class="form-control customDateTimePicker" id="start_date" placeholder="Start Date" readonly>
                            <div class="alert alert-error error-msg start_date_err_msg_contnr modal_err_msg">
                                <p id="start_date_err_msg"></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label >End Date</label>
                            <input autocomplete="off" type="text" class="form-control customDateTimePicker" id="end_date" placeholder="End Date" readonly>
                            <div class="alert alert-error error-msg end_date_err_msg_contnr modal_err_msg">
                                <p id="end_date_err_msg"></p>
                            </div>
                        </div>
                    </div>
                     
                    <div class="col-12">
                        <div class="form-group">
                            <label >Note</label>
                            <textarea name="note" id="note" class="form-control" placeholder="Note ..."></textarea>
                            <div class="alert alert-error error-msg note_err_msg_contnr modal_err_msg">
                                <p id="note_err_msg"></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <label class="container op_margin_top_6 op_color_dim_grey">                         
                            <input class="is_sent_invoice" type="checkbox" id="is_sent_invoice" name="is_sent_invoice">
                            <span class="checkmark"></span>
                            Send Mail
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-blue-btn add_booking_submit">  <?php echo lang('submit'); ?></button>
                <button type="button" class="btn bg-blue-btn"  data-bs-dismiss="modal"><?php echo lang('close'); ?></button>
            </div>
        </div>
    </div>
</div>

<?php $this->view('updater/reuseJs2'); ?>
<script src="<?php echo base_url();?>frequent_changing/js/booking.js"></script>

