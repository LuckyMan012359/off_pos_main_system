<input type="hidden" id="network_printer" value="<?php echo lang('network_printer');?>">
<input type="hidden" id="windows_printer" value="<?php echo lang('windows_printer');?>">
<input type="hidden" id="alert" value="<?php echo lang('alert');?>">
<input type="hidden" id="Add_Printer" value="<?php echo lang('add_printer');?>">
<input type="hidden" id="Edit_Printer" value="<?php echo lang('edit_printer');?>">
<input type="hidden" id="insert_success" value="<?php echo lang('insertion_success');?>">
<input type="hidden" id="update_success" value="<?php echo lang('update_success');?>">
<input type="hidden" id="delete_success" value="<?php echo lang('delete_success');?>">
<input type="hidden" id="title_required" value="<?php echo lang('title_required');?>">
<input type="hidden" id="Characters_Per_Line_required" value="<?php echo lang('Characters_Per_Line_required');?>">
<input type="hidden" id="Printer_IP_required" value="<?php echo lang('Printer_IP_required');?>">
<input type="hidden" id="Printer_Port_required" value="<?php echo lang('Printer_Port_required');?>">
<input type="hidden" id="Path_field_required" value="<?php echo lang('Path_field_required');?>">
<input type="hidden" id="Print_Server_URL_required" value="<?php echo lang('Print_Server_URL_required');?>">
<input type="hidden" id="Printer_Change_Successful" value="<?php echo lang('Printer_Change_Successful');?>">
<input type="hidden" id="Cash_Drawer_Change_Successful" value="<?php echo lang('Cash_Drawer_Change_Successful');?>">
<input type="hidden" id="select_ln" value="<?php echo lang('select');?>">


<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/printer_setup.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/notify/toastr.css" type="text/css">


<section class="main-content-wrapper">
<h3 class="display_none">&nbsp;</h3>
    <div class="ajax-message"></div>

    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo lang('printers_setup'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('printers_setup'), 'secondSection'=> lang('printers_setup')])?>
        </div>
    </section>

    <div class="box-wrapper">
        <div class="table-box"> 
            <div class="box-body">
                <div class="printers_wrap row">
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-3">
                        <div class="card all_printers email_card">
                            <iconify-icon icon="solar:printer-line-duotone" width="25"></iconify-icon>
                            <span class="email-title"><?php echo lang('printers');?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<div class="modal fade " id="allPrinters"  role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                <?php echo lang('list_printer'); ?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i
                data-feather="x"></i></span></button>
            </div>
            <div class="modal_message">
                <div class="ajax-modal-msg"></div>
                <div class="d-flex justify-content-end">
                    <button class="add_new_printer new-btn"><iconify-icon icon="solar:add-circle-broken" width="22"></iconify-icon> <?php echo lang('add_printer');?></button>
                </div>
            </div>
            <div class="modal-body modal_body_scroll">
                <table class="table all_printer printer_table_trigger">
                    <thead>
                        <tr>
                            <th class="w-5"><?php echo lang('sn'); ?></th>
                            <th class="w-10" ><?php echo lang('title'); ?></th>
                            <th class="w-10" ><?php echo lang('printer_type'); ?></th>
                            <th class="w-10" ><?php echo lang('characters_per_line'); ?></th>
                            <th class="w-10" ><?php echo lang('printer_ip_address'); ?></th>
                            <th class="w-10" ><?php echo lang('printer_port_address'); ?></th>
                            <th class="w-10" ><?php echo lang('share_name'); ?></th>
                            <th class="op_width_2_p c_center not-export-col"><?php echo lang('actions'); ?></th> 
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-blue-btn" data-bs-dismiss="modal"><?php echo lang('close'); ?></button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade " id="addPrinters"  role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    <span class="modal_title">&nbsp;</span>
                </h4>
                <button type="button" class="btn-close reset_trigger" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i
                data-feather="x"></i></span></button>
            </div>
            <form id="add_printer_form">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" id="edit_id" name="edit_id">

                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="form-group">
                                <label><?php echo lang('title'); ?> (<?php echo lang('to_identify_printer_easily');?>) <span class="required_star">*</span></label>
                                <input  autocomplete="off" type="text" name="title" class="form-control e_title" placeholder="<?php echo lang('title'); ?>" value="<?php echo set_value('title'); ?>">
                                <div class="alert alert-error error-msg title_err_msg_contnr ">
                                    <p class="title_err_msg"></p>
                                </div>
                            </div>
                        </div>
                        <div class="clear-fix"></div>
                        <div class="mb-3 col-lg-4 col-md-6">
                            <div class="form-group">
                                <label><?php echo lang('printing'); ?> <?php echo lang('Choice'); ?></label>
                                <select class="form-control printing select2" id="invoice_print"
                                        name="invoice_print">
                                    <option value="web_browser"><?php echo lang('browser_popup_print'); ?></option>
                                    <option value="live_server_print"><?php echo lang('direct_print'); ?></option>
                                </select>
                            </div>
                        </div>
                        <!-- <div class="mb-3 col-lg-4 col-md-6 hide_show_1">
                            <div class="form-group">
                                <label><?php echo lang('print_format'); ?> <span class="required_star">*</span></label>
                                <select name="print_format" id="print_format" class="select2 form-control">
                                    <option value="No Print"><?php echo lang('No_Print'); ?></option>
                                    <option value="56mm"><?php echo lang('p56mm'); ?></option>
                                    <option value="80mm"><?php echo lang('p80mm'); ?></option>
                                    <option value="A4 Print"><?php echo lang('A4_Print'); ?></option>
                                    <option value="Half A4 Print"><?php echo lang('Half_A4_Print'); ?></option>
                                    <option value="Letter Head"><?php echo lang('letter_head'); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 col-lg-4 col-md-6 hide_show_2">
                            <div class="form-group">
                                <label><?php echo lang('inv_qr_code_enable_status'); ?> <span class="required_star">*</span></label>
                                <select name="inv_qr_code_status" id="inv_qr_code_status" class="select2 form-control">
                                    <option value="Enable"><?php echo lang('Enable'); ?></option>
                                    <option value="Disable"><?php echo lang('Disable'); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 col-lg-4 col-md-6 hide_show_3">
                            <div class="form-group">
                                <label><?php echo lang('qr_code_type'); ?> <span class="required_star">*</span></label>
                                <select name="qr_code_type" class="select2 form-control" id="qr_code_type">
                                    <option value="Invoice Link"><?php echo lang('invoice_link_qr_code'); ?></option>
                                    <option value="Zatca"><?php echo lang('zatca_qr_code'); ?></option>
                                </select>
                            </div>
                        </div> -->
                        <div class="col-md-6 col-lg-4 mb-3 hide_show_4">
                            <div class="form-group">
                                <label><?php echo lang('printer_type'); ?> <span class="required_star">*</span></label>
                                <select class="form-control select2  e_type" name="type">
                                    
                                </select>
                            </div>
                            <?php if (form_error('type')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('type'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="clear-fix"></div>
                        <div class="col-md-6 col-lg-4 mb-3 hide_show_5">
                            <div class="form-group">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label>
                                        <?php echo lang('printer_ip_address'); ?> <span class="required_star">*</span>
                                    </label>
                                    <div class="ms-3 op_right op_font_18 op_cursor_pointer mb-4-px">
                                        <i data-tippy-content="<?php echo lang('printer_ip_tooltip'); ?>" class="fa-regular fa-circle-question tippyBtnCall font-16 theme-color"></i>
                                    </div>
                                </div>
                                <input  autocomplete="off" type="text" name="printer_ip_address" class="form-control e_printer_ip_address" placeholder="<?php echo lang('printer_ip_address'); ?>" value="<?php echo set_value('printer_ip_address'); ?>">
                                <div class="alert alert-error error-msg printer_ip_address_err_msg_contnr ">
                                    <p class="printer_ip_address_err_msg"></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-3 hide_show_6">
                            <div class="form-group">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label>
                                        <?php echo lang('printer_port_address'); ?> <span class="required_star">*</span>
                                    </label>
                                    <div class="ms-3 op_right op_font_18 op_cursor_pointer mb-4-px">
                                        <i data-tippy-content="<?php echo lang('printer_port_tooltip'); ?>" class="fa-regular fa-circle-question tippyBtnCall font-16 theme-color"></i>
                                    </div>
                                </div>
                                <input  autocomplete="off" type="text" name="printer_port" class="form-control e_printer_port" placeholder="<?php echo lang('printer_port_address'); ?>" value="<?php echo set_value('printer_port'); ?>">
                                <div class="alert alert-error error-msg printer_port_err_msg_contnr ">
                                    <p class="printer_port_err_msg"></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-3 hide_show_7">
                            <div class="form-group">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label>
                                        <?php echo lang('characters_per_line'); ?> <span class="required_star">*</span>
                                    </label>
                                    <div class="ms-3 op_right op_font_18 op_cursor_pointer mb-4-px">
                                        <i data-tippy-content="<?php echo lang('printer_per_line_tooltip'); ?>" class="fa-regular fa-circle-question tippyBtnCall font-16 theme-color"></i>
                                    </div>
                                </div>
                                <input  autocomplete="off" type="number"  name="characters_per_line" class="form-control e_characters_per_line" placeholder="<?php echo lang('characters_per_line'); ?>" value="46">
                                <div class="alert alert-error error-msg characters_per_line_err_msg_contnr ">
                                    <p class="characters_per_line_err_msg"></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-3 hide_show_8">
                            <div class="form-group">
                                <label><?php echo lang('share_name'); ?> <span class="required_star">*</span> </label> <a class="pull-right" href="https://youtu.be/IHBslN6kBlE" target="_blank"><?php echo lang('printer_path_tooltip'); ?></a>
                                <input  autocomplete="off" type="text" name="path" class="form-control e_path" placeholder="<?php echo lang('share_name'); ?>" value="<?php echo set_value('path'); ?>">
                                <div class="alert alert-error error-msg path_err_msg_contnr ">
                                    <p class="path_err_msg"></p>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 col-lg-4 col-md-6 hide_show_9">
                            <div class="form-group">
                                <label><?php echo lang('print_server_url'); ?> <span
                                            class="required_star">*</span></label>
                                            <a class="pull-right ipv_4_tooltip" href="<?php echo base_url()?>assets/images/ethernet_wifi.png" target="_blank"><?php echo lang('HowtogetIPv4Address'); ?></a>
                                <input  autocomplete="off" type="text" id="print_server_url_invoice"
                                        name="print_server_url_invoice" class="form-control"
                                        placeholder="<?php echo lang('print_server_url'); ?>"
                                        value=""> 
                                <div class="alert alert-error error-msg print_server_url_err_msg_err_msg_contnr ">
                                    <p class="print_server_url_err_msg"></p>
                                </div>
                            </div>
                        </div>
                        <div class="clear-fix"></div>
                        <div class="mb-3 col-lg-4 col-md-6 hide_show_10">
                            <div class="form-group">
                                <label><?php echo lang('fiscal_printer_status'); ?></label>
                                <select class="form-control printing select2" id="fiscal_printer_status"
                                        name="fiscal_printer_status">
                                    <option value="ON"><?php echo lang('on'); ?></option>
                                    <option value="OFF"><?php echo lang('off'); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 col-lg-4 col-md-6 hide_show_11">
                            <div class="form-group">
                                <label><?php echo lang('open_cash_drawer'); ?></label>
                                <select class="form-control select2"
                                        name="open_cash_drawer_when_printing_invoice" id="open_cash_drawer">
                                    <option value="ON"><?php echo lang('on'); ?></option>
                                    <option value="OFF"><?php echo lang('off'); ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn bg-blue-btn add_printer_submit"><?php echo lang('submit'); ?></button>
                    <button type="button" class="btn bg-blue-btn reset_trigger" data-bs-dismiss="modal"><?php echo lang('close'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>



<div class="modal fade " id="allAssignPrinter"  role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    <span><?php echo lang('List_Assign_Printer');?></span>
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i
                data-feather="x"></i></span></button>
            </div>
        
            <div class="modal-body modal_body_scroll">
                <table class="table  printer_table_trigger assignerPrinters">
                    <thead>
                        <tr>
                            <th class="w-5"><?php echo lang('sn'); ?></th>
                            <th class="w-33"><?php echo lang('user'); ?></th>
                            <th class="w-33"><?php echo lang('printer'); ?></th>
                            <th class="w-33"><?php echo lang('open_cash_drawer'); ?></th> 
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-blue-btn" data-bs-dismiss="modal"><?php echo lang('close'); ?></button>
            </div>
        </div>
    </div>
</div>


<script src="<?php echo base_url('frequent_changing/js/printer_setup.js');?>"></script>
<script src="<?php echo base_url(); ?>assets/notify/toastr.js"></script>