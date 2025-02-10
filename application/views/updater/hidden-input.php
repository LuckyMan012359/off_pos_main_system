<!-- All hidden input field data will be used in js file. -->
<span id="segment-fetcher" data-id="<?php echo get_url_segments();?>"></span>
<input type="hidden" name="datatable_showing" id="datatable_showing" value="<?php echo lang('Showing')?>">
<input type="hidden" name="Showing_to" id="Showing_to" value="<?php echo lang('Showing_to')?>">
<input type="hidden" name="Showing_from" id="Showing_from" value="<?php echo lang('Showing_from')?>">
<input type="hidden" name="Showing_entries" id="Showing_entries" value="<?php echo lang('Showing_entries')?>">
<input type="hidden" name="First" id="show_First" value="<?php echo lang('First')?>">
<input type="hidden" name="Last" id="show_Last" value="<?php echo lang('Last')?>">
<input type="hidden" name="Next" id="show_Next" value="<?php echo lang('Next')?>">
<input type="hidden" name="Prev" id="show_Prev" value="<?php echo lang('Prev')?>">
<input type="hidden" name="no_data_in_table" id="no_data_in_table" value="<?php echo lang('no_data_in_table')?>">
<input type="hidden" name="no_match_data_in_table" id="no_match_data_in_table" value="<?php echo lang('no_match_data_in_table')?>">
<input type="hidden" id="base_url_" value="<?php echo base_url(); ?>">
<input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
<input type="hidden" id="currency_" value="<?php echo escape_output($this->session->userdata('currency')); ?>">
<input type="hidden" id="i_sale_" value="<?php echo escape_output($this->session->userdata('i_sale'))?>">
<input type="hidden" id="warning" value="<?php echo lang('alert'); ?>">
<input type="hidden" id="a_error" value="<?php echo lang('error'); ?>">
<input type="hidden" id="ok" value="<?php echo lang('ok'); ?>">
<input type="hidden" id="yes" value="<?php echo lang('yes'); ?>">
<input type="hidden" id="cancel" value="<?php echo lang('cancel'); ?>">
<input type="hidden" id="are_you_sure" value="<?php echo lang('are_you_sure'); ?>">
<input type="hidden" id="csrf_name_" value="<?php echo $this->security->get_csrf_token_name(); ?>">
<input type="hidden" id="csrf_value_" value="<?php echo $this->security->get_csrf_hash(); ?>">
<input type="hidden" id="register_status" value="<?php echo escape_output($this->session->userdata('register_status')); ?>">
<input type="hidden" id="print_type" value="<?php echo escape_output($this->session->userdata('print_format')); ?>">
<input type="hidden" id="op_precision" value="<?php echo escape_output($this->session->userdata('precision'))?>"><input type="hidden" id="scrollwindow" value="<?php echo base_url()?>">
<input type="hidden" id="op_decimals_separator" value="<?php echo escape_output($this->session->userdata('decimals_separator'))?>">
<input type="hidden" id="op_thousands_separator" value="<?php echo escape_output($this->session->userdata('thousands_separator'))?>">
<input type="hidden" id="not_closed_yet" value="<?php echo lang('not_closed_yet'); ?>">
<input type="hidden" id="opening_balance" value="<?php echo lang('opening_balance'); ?>">
<input type="hidden" id="paid_amount" value="<?php echo lang('paid_amount'); ?>">
<input type="hidden" id="sale_text" value="<?php echo lang('sale'); ?>">
<input type="hidden" id="customer_due_receive" value="<?php echo lang('customer_due_receive'); ?>">
<input type="hidden" id="total_purchases" value="<?php echo lang('total_purchases'); ?>">
<input type="hidden" id="total_purchase_return" value="<?php echo lang('total_purchase_return'); ?>">
<input type="hidden" id="total_sale_return" value="<?php echo lang('total_sale_return'); ?>">
<input type="hidden" id="in_ln" value="<?php echo lang('in_ln'); ?>">
<input type="hidden" id="down_payment" value="<?php echo lang('down_payment'); ?>">
<input type="hidden" id="installment_paid_amount_text" value="<?php echo lang('installment_paid_amount'); ?>">
<input type="hidden" id="filter_by" value="<?php echo lang('filter_by'); ?>">
<input type="hidden" id="dummy_data_delete_alert" value="<?php echo lang('dummy_data_delete_alert'); ?>">
<input type="hidden" id="select" value="<?php echo lang('select'); ?>">
<input type="hidden" id="no_permission_for_this_module" value="<?php echo lang('no_permission_for_this_module'); ?>">
<input type="hidden" id="the_name_field_is_required" value="<?php echo lang('the_name_field_is_required'); ?>">
<input type="hidden" id="do_you_save_the_change" value="<?php echo lang('do_you_save_the_change'); ?>">
<input type="hidden" id="save" value="<?php echo lang('save'); ?>">
<input type="hidden" id="dont_save" value="<?php echo lang('dont_save'); ?>">
<input type="hidden" id="onscreen_keyboard_status" value="<?php echo escape_output($this->session->userdata('onscreen_keyboard_status')); ?>">
<input type="hidden" id="copy_db_exp" value="<?php echo lang('copy'); ?>">
<input type="hidden" id="print_db_exp" value="<?php echo lang('print'); ?>">
<input type="hidden" id="excel_db_exp" value="<?php echo lang('excel'); ?>">
<input type="hidden" id="csv_db_exp" value="<?php echo lang('csv'); ?>">
<input type="hidden" id="pdf_db_exp" value="<?php echo lang('pdf'); ?>">
<input type="hidden" id="export_db" value="<?php echo lang('export'); ?>">
<input type="hidden" id="APPLICATION_DEMO_TYPE" value="<?php echo APPLICATION_DEMO_TYPE ?>">
<input type="hidden" id="APPLICATION_MODE" value="<?php echo APPLICATION_MODE ?>">


