<script src="<?php echo base_url(); ?>frequent_changing/js/add_servicing.js"></script>

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
                <h3 class="top-left-header mt-2"><?php echo lang('edit_servicing'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('servicing'), 'secondSection'=> lang('edit_servicing')])?>
        </div>
    </section>

    <div class="box-wrapper">
        <div class="table-box">
            <?php echo form_open(base_url() . 'Servicing/addEditServicing/' . $encrypted_id, $arrayName = array('id' => 'add_servicing')) ?>

            <div class="box-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('product_name'); ?> <span class="required_star">*</span></label>
                            <input  autocomplete="off" type="text"  name="product_name" class="form-control" placeholder="<?php echo lang('product_name'); ?>" value="<?php echo isset($servicing_details) && $servicing_details ? $servicing_details->product_name : '' ?>">
                        </div>
                        <?php if (form_error('product_name')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('product_name'); ?></span>
                            </div>
                        <?php } ?>
                        <div class="alert alert-error error-msg productname_err_msg_contnr ">
                            <p id="productname_err_msg"></p>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                        <label><?php echo lang('product_model'); ?></label>
                            <input  autocomplete="off" type="text"  name="product_model" class="form-control" placeholder="<?php echo lang('product_model'); ?>" value="<?php echo isset($servicing_details) && $servicing_details ? $servicing_details->product_model : '' ?>">
                        </div>
                        <?php if (form_error('product_model')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('product_model'); ?></span>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('Problem_Description'); ?></label>
                            <textarea  class="form-control" rows="2" id="problem_description" name="problem_description" placeholder="<?php echo lang('Problem_Description'); ?> ..."><?php echo set_value('problem_description'); ?><?php echo isset($servicing_details) && $servicing_details ? $servicing_details->problem_description : '' ?></textarea>
                        </div>
                        <?php if (form_error('problem_description')) { ?>
                        <div class="callout callout-danger my-2">
                            <span class="error_paragraph"><?php echo form_error('problem_description'); ?></span>
                        </div>
                        <?php } ?>
                        <div class="alert alert-error error-msg note_err_msg_contnr ">
                            <p id="note_err_msg"></p>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                        <label><?php echo lang('servicing_charge'); ?> <span class="required_star">*</span></label>
                            <input  autocomplete="off" type="text"  name="servicing_charge" id="servicing_charge" class="form-control integerchk" placeholder="<?php echo lang('servicing_charge'); ?>" value="<?php echo isset($servicing_details) && $servicing_details ? $servicing_details->servicing_charge : '' ?>">
                        </div>
                        <?php if (form_error('servicing_charge')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('servicing_charge'); ?></span>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                        <label><?php echo lang('paid_amount'); ?></label>
                            <input  autocomplete="off" type="text"  name="paid_amount" id="paid_amount_service" class="paid_amount form-control integerchk" placeholder="<?php echo lang('paid_amount'); ?>" value="<?php echo isset($servicing_details) && $servicing_details ? $servicing_details->paid_amount : '' ?>">
                        </div>
                        <?php if (form_error('paid_amount')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('paid_amount'); ?></span>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                        <label><?php echo lang('due_amount'); ?></label>
                            <input  autocomplete="off" type="text"  name="due_amount" id="due_amount" class="due_amount form-control integerchk" placeholder="<?php echo lang('due_amount'); ?>" value="<?php echo isset($servicing_details) && $servicing_details ? $servicing_details->due_amount : '' ?>">
                        </div>
                        <?php if (form_error('due_amount')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('due_amount'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('Receiving_Date'); ?> <span class="required_star">*</span></label>
                            <input  autocomplete="off" type="text"  name="receiving_date" readonly class="form-control customDatepicker" placeholder="<?php echo lang('Receiving_Date'); ?>" value="<?php echo isset($servicing_details) && $servicing_details ? $servicing_details->receiving_date : '' ?>">
                        </div>
                        <?php if (form_error('receiving_date')) { ?>
                        <div class="callout callout-danger my-2">
                            <span class="error_paragraph"><?php echo form_error('receiving_date'); ?></span>
                        </div>
                        <?php } ?>
                        <div class="alert alert-error error-msg receiving_date_err_msg_contnr ">
                            <p id="receiving_date_err_msg"></p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('Delivery_Date'); ?></label>
                            <input  autocomplete="off" type="text"  name="delivery_date" readonly class="form-control customDatepicker" placeholder="<?php echo lang('Delivery_Date'); ?>" value="<?php echo isset($servicing_details) && $servicing_details ? $servicing_details->delivery_date : '' ?>">
                        </div>
                        <?php if (form_error('delivery_date')) { ?>
                        <div class="callout callout-danger my-2">
                            <span class="error_paragraph"><?php echo form_error('delivery_date'); ?></span>
                        </div>
                        <?php } ?>
                        <div class="alert alert-error error-msg delivery_date_err_msg_contnr ">
                            <p id="delivery_date_err_msg"></p>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="form-group"> 
                            <label><?php echo lang('customer'); ?> <span class="required_star">*</span></label>
                            <select  class="form-control select2 select2-hidden-accessible op_width_100_p" name="customer_id" id="customer_id">
                                <option value=""><?php echo lang('select'); ?></option>
                                <?php foreach ($customers as $customer) { ?>
                                    <option <?php echo isset($servicing_details) && $servicing_details ? ($servicing_details->customer_id == $customer->id ? 'selected' : '') : '' ?> value="<?= escape_output($customer->id); ?>" <?php echo set_select('customer_id', escape_output($customer->id)); ?>><?php echo escape_output($customer->name) ?> <?php echo $customer->phone ? '(' . $customer->phone . ')' : ''?></option>
                                <?php } ?>
                            </select>
                        </div>  
                        <?php if (form_error('customer_id')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('customer_id'); ?></span>
                            </div>
                        <?php } ?> 
                        <div class="alert alert-error error-msg customer_id_err_msg_contnr ">
                            <p id="customer_id_err_msg"></p>
                        </div>
                    </div> 
                    <div class="col-md-4 mb-3">
                        <div class="form-group"> 
                            <label><?php echo lang('employee'); ?> <span class="required_star">*</span></label>
                            <select  class="form-control select2" name="employee_id" id="employee_id">
                                <option value=""><?php echo lang('select'); ?></option>
                                <?php foreach ($employees as $employee) { ?>
                                    <option <?php echo isset($servicing_details) && $servicing_details ? ($servicing_details->employee_id == $employee->id ? 'selected' : '') : '' ?> value="<?= escape_output($employee->id); ?>" <?php echo set_select('employee_id', escape_output($employee->id)); ?>><?php echo escape_output($employee->full_name) ?></option>
                                <?php } ?>
                            </select>
                        </div>  
                        <?php if (form_error('employee_id')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('employee_id'); ?></span>
                            </div>
                        <?php } ?> 
                        <div class="alert alert-error error-msg employee_id_err_msg_contnr ">
                            <p id="employee_id_err_msg"></p>
                        </div>
                    </div> 
                    
                    <div class="col-md-4 mb-3">
                        <div class="form-group"> 
                            <label><?php echo lang('status'); ?> <span class="required_star">*</span></label>
                            <select class="form-control select2" name="status" id="status">
                                <option <?php echo isset($servicing_details) && $servicing_details ? ($servicing_details->status == 'Received' ? 'selected' : '') : '' ?> value="Received"><?php echo lang('received'); ?></option>
                                <option <?php echo isset($servicing_details) && $servicing_details ? ($servicing_details->status == 'Delivered' ? 'selected' : '') : '' ?> value="Delivered"><?php echo lang('delivered'); ?></option>
                            </select>
                        </div>  
                        <?php if (form_error('status')) { ?>
                        <div class="callout callout-danger my-2">
                            <span class="error_paragraph"><?php echo form_error('status'); ?></span>
                        </div>
                        <?php } ?> 
                        <div class="alert alert-error error-msg item_id_err_msg_contnr ">
                            <p id="item_id_err_msg"></p>
                        </div> 
                    </div> 

                    <div class="col-md-4 mb-3">
                        <div class="form-group mb-2">
                            <label>
                                <?php echo lang('payment_methods'); ?> <span class="required_star"></span>
                            </label>
                            <select  class="form-control select2 op_width_100_p" id="payment_method_id"
                                name="payment_method_id">
                                <option value=""><?php echo lang('select'); ?></option>
                                <?php foreach ($paymentMethods as $method) { ?>
                                <option <?php echo escape_output($servicing_details->payment_method_id) == $method->id ? 'selected' : '' ?> value="<?php echo escape_output($method->id) ?>"
                                    <?php echo set_select('payment_method_id', $method->id); ?>><?php echo escape_output($method->name) ?>
                                </option>
                                <?php } ?>
                            </select>
                            <?php if (form_error('payment_method_id')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('payment_method_id'); ?></span>
                            </div>
                            <?php } ?> 
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
                <a class="btn bg-blue-btn text-decoration-none" href="<?php echo base_url() ?>Servicing/listServicing">
                    <iconify-icon icon="solar:undo-left-round-broken"></iconify-icon>
                    <?php echo lang('back'); ?>
                </a>
            </div>
            <?php echo form_close(); ?> 
        </div>
    </div>  
</div>
