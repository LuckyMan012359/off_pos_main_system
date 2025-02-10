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
                <h3 class="top-left-header mt-2"><?php echo lang('add_expense'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('expense'), 'secondSection'=> lang('add_expense')])?>
        </div>
    </section>

    <!-- Main content -->
    <div class="box-wrapper">
        <div class="table-box">
            <?php echo form_open(base_url('Expense/addEditExpense')); ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('ref_no'); ?></label>
                            <input  autocomplete="off" type="text" id="reference_no" readonly name="reference_no" class="form-control" placeholder="<?php echo lang('ref_no'); ?>" value="<?php echo escape_output($reference_no); ?>">
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
                            <input  autocomplete="off" type="text"   name="date" readonly class="form-control customDatepicker" placeholder="<?php echo lang('date'); ?>" value="<?=date('Y-m-d',strtotime('today'))?>">
                        </div>
                        <?php if (form_error('date')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('date'); ?></span>
                            </div>
                        <?php } ?>
                    </div>    
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('amount'); ?> <span class="required_star">*</span></label>
                            <input  autocomplete="off" type="text" id="amount" name="amount" onfocus="this.select();"  class="form-control integerchk" placeholder="<?php echo lang('amount'); ?>" value="<?php echo set_value('amount'); ?>">
                        </div>
                        <?php if (form_error('amount')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('amount'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3"> 
                        <div class="form-group">
                            <label><?php echo lang('category'); ?> <span class="required_star">*</span></label>
                            <select  class="form-control select2 op_width_100_p" name="category_id">
                                <option value=""><?php echo lang('select'); ?></option>
                                <?php foreach ($expense_categories as $ec) { ?>
                                    <option value="<?php echo escape_output($ec->id) ?>" <?php echo set_select('category_id', $ec->id); ?>><?php echo escape_output($ec->name) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <?php if (form_error('category_id')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('category_id'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3"> 
                        <div class="form-group">
                            <label><?php echo lang('responsible_person'); ?></label>
                            <select  class="form-control select2 op_width_100_p" name="employee_id">
                                <option value=""><?php echo lang('select'); ?></option>
                                <?php foreach ($employees as $empls) { ?>
                                    <option value="<?php echo escape_output($empls->id) ?>" <?php echo set_select('employee_id', $empls->id); ?>><?php echo escape_output($empls->full_name) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <?php if (form_error('employee_id')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('employee_id'); ?></span>
                            </div>
                        <?php } ?>
                    </div>   
                    <div class="col-md-6 col-lg-4 mb-3">
                                <div class="form-group">
                                <label><?php echo lang('payment_methods'); ?> <span class="required_star">*</span></label>
                                <select  class="form-control select2 op_width_100_p" id="payment_method_id" name="payment_method_id">
                                    <option value=""><?php echo lang('select'); ?></option>
                                    <?php foreach ($paymentMethods as $ec) { ?>
                                        <option value="<?php echo escape_output($ec->id) ?>" <?php echo set_select('payment_method_id', $ec->id); ?>><?php echo escape_output($ec->name) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <?php if (form_error('payment_method_id')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('payment_method_id'); ?></span>
                                </div>
                            <?php } ?>
                    </div>  
                    <div class="col-md-6 col-lg-4 mb-3"> 
                            <div class="form-group">
                                <label><?php echo lang('note'); ?></label>
                                <input  class="form-control" name="note" placeholder="<?php echo lang('note'); ?> ..." value="<?php echo $this->input->post('note'); ?>">
                            </div> 
                            <?php if (form_error('note')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('note'); ?></span>
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
                <a class="btn bg-blue-btn text-decoration-none" href="<?php echo base_url() ?>Expense/expenses">
                    <iconify-icon icon="solar:undo-left-round-broken"></iconify-icon>
                    <?php echo lang('back'); ?>
                </a>
            </div>


            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>frequent_changing/js/expense.js"></script>