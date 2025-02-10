<?php 
    if($company_info->invoice_configuration) {
        $invoice_configuration = json_decode($company_info->invoice_configuration);
    } else {
        $invoice_configuration = '';
    }
?>


<link rel="stylesheet" href="<?php echo base_url(); ?>assets/cropper/cropper.min.css">


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
                <h3 class="top-left-header mt-2"><?php echo lang('invoice_configuration'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('setting'), 'secondSection'=> lang('invoice_configuration')])?>
        </div>
    </section>


    <div class="box-wrapper">
        <div class="table-box">
            <?php
            $attributes = array('id' => 'restaurant_setting_form');
            echo form_open_multipart(base_url('Setting/invoiceSetting'),$attributes); ?>
            <div class="box-body">
                <div class="row justify-content-center option-div-group">
                    <div class="col-12 mt-3 mb-3">
                        <h6 class="inv_heading_design mb-2">Invoice Size (All of our available sizes)</h6>
                    </div>
                    <div class="col-md-2 text-center">
                        <div class="form-group">
                            <div class="option-div invoice_format_element <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->invoice_format_or_size == '56mm' ? 'active' : '')  : 'active'?>">
                                <div class="inv-icon">
                                    <iconify-icon icon="solar:book-bookmark-broken" width="60"></iconify-icon>
                                    <i class="fa fa-check-circle pull-right icon"></i>
                                    <input name="invoice_format_or_size"  type="radio" value="56mm" <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->invoice_format_or_size == '56mm' ? 'checked' : '')  : 'checked'?>>
                                </div>
                                <h6 class="a_inv_title">Tharmal 56mm</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 text-center">
                        <div class="form-group">
                            <div class="option-div invoice_format_element <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->invoice_format_or_size == '80mm' ? 'active' : '')  : ''?>">
                                <div class="inv-icon">
                                    <iconify-icon icon="solar:book-bookmark-broken" width="60"></iconify-icon>
                                    <i class="fa fa-check-circle pull-right icon"></i>
                                    <input name="invoice_format_or_size"  type="radio" value="80mm" <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->invoice_format_or_size == '80mm' ? 'checked' : '')  : ''?>>
                                </div>
                                <h6 class="a_inv_title">Tharmal 80mm</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 text-center">
                        <div class="form-group">
                            <div class="option-div invoice_format_element <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->invoice_format_or_size == 'A4 Print' ? 'active' : '')  : ''?>">
                                <div class="inv-icon">
                                    <iconify-icon icon="solar:book-bookmark-broken" width="60"></iconify-icon>
                                    <i class="fa fa-check-circle pull-right icon"></i>
                                    <input name="invoice_format_or_size"  type="radio" value="A4 Print" <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->invoice_format_or_size == 'A4 Print' ? 'checked' : '')  : ''?>>
                                </div>
                                <h6 class="a_inv_title">A4 Print</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 text-center">
                        <div class="form-group">
                            <div class="option-div invoice_format_element <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->invoice_format_or_size == 'Half A4 Print' ? 'active' : '')  : ''?>">
                                <div class="inv-icon">
                                    <iconify-icon icon="solar:book-bookmark-broken" width="60"></iconify-icon>
                                    <i class="fa fa-check-circle pull-right icon"></i>
                                    <input name="invoice_format_or_size"  type="radio" value="Half A4 Print" <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->invoice_format_or_size == 'Half A4 Print' ? 'checked' : '')  : ''?>>
                                </div>
                                <h6 class="a_inv_title">Half A4 Print</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 text-center">
                        <div class="form-group">
                            <div class="option-div invoice_format_element <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->invoice_format_or_size == 'Letter Head' ? 'active' : '')  : ''?>">
                                <div class="inv-icon">
                                    <iconify-icon icon="solar:book-bookmark-broken" width="60"></iconify-icon>
                                    <i class="fa fa-check-circle pull-right icon"></i>
                                    <input name="invoice_format_or_size"  type="radio" value="Letter Head" <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->invoice_format_or_size == 'Letter Head' ? 'checked' : '')  : ''?>>
                                </div>
                                <h6 class="a_inv_title">Letter Head</h6>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row option-div-group numbering_wrap">
                    <div class="col-12 mt-3 mb-3">
                        <h6 class="inv_heading_design mb-2"><?php echo lang('numbering');?></h6>
                    </div>

                    <div class="col-md-3 mb-3">
                        <div class="form-group">
                            <div class="option-div option-div-2 numbering_format_element <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->schema_type == 'XXXX' ? 'active' : '') : ''?>">
                                <h4><?php echo lang('FORMAT');?>: <br>XXXX <i class="fa fa-check-circle pull-right icon"></i></h4>
                                <input name="schema_type" class="schema_type"  type="radio" value="XXXX" <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->schema_type == 'XXXX' ? 'checked' : '') : 'checked'?>>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="form-group">
                            <?php $invFormat = date('Y').'-XXXX';?>
                            <div class="option-div option-div-2 numbering_format_element <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->schema_type == 'Y-XXXX' ? 'active' : '') : 'active'?>">
                                <h4><?php echo lang('FORMAT');?>: <br><?php echo date('Y');?>-XXXX <i class="fa fa-check-circle pull-right icon"></i></h4>
                                <input name="schema_type" class="schema_type" type="radio" value="<?php echo $invFormat ?>" <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->schema_type == 'Y-XXXX' ? 'checked' : '') : ''?>>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <p class="mb-0"><?php echo lang('Preview');?></p>
                        <p class="inv-format-number"></p>
                    </div>

                    <div class="clear-fix"></div>

                    <div class="col-md-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('Numbering_Types');?> <span class="required_star">*</span></label>
                            </div>
                            <select  class="form-control select2" id="inv_numbering_type" name="inv_numbering_type">
                                <option <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->inv_numbering_type == 'Sequential' ? 'selected' : '') : 'selected'?> value="Sequential"><?php echo lang('Sequential');?></option>
                                <option <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->inv_numbering_type == 'Random' ? 'selected' : '') : ''?> value="Random"><?php echo lang('Random');?></option>
                            </select>
                        </div>
                        <?php if (form_error('inv_numbering_type')) { ?>
                        <div class="callout callout-danger my-2">
                            <span class="error_paragraph"><?php echo form_error('inv_numbering_type'); ?></span>
                        </div>
                        <?php } ?>
                    </div>

                    <div class="col-md-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('Numbering_of_digits');?> <span class="required_star">*</span></label>
                            </div>
                            <select  class="form-control select2" id="inv_number_of_digit" name="inv_number_of_digit">
                                <?php for($i = 4; $i <= 10; $i++){?>
                                    <option <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->inv_number_of_digit == $i ? 'selected' : '') : ''?> value="<?php echo $i ?>"><?php echo $i ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <?php if (form_error('inv_number_of_digit')) { ?>
                        <div class="callout callout-danger my-2">
                            <span class="error_paragraph"><?php echo form_error('inv_number_of_digit'); ?></span>
                        </div>
                        <?php } ?>
                    </div>

                    <div class="col-md-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('Prefix');?></label>
                            </div>
                            <input  autocomplete="off" type="text" name="inv_prefix" id="inv_prefix"
                            class="form-control" placeholder="Prefix"
                            value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->inv_prefix : ''?>">
                        </div>
                        <?php if (form_error('inv_prefix')) { ?>
                        <div class="callout callout-danger my-2">
                            <span class="error_paragraph"><?php echo form_error('inv_prefix'); ?></span>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-3 mb-3 start_from_wrap">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('Start_From');?> <span class="required_star">*</span></label>
                            </div>
                            <input  autocomplete="off" type="text" name="inv_start_from" id="inv_start_from"
                            class="form-control" placeholder="<?php echo lang('Start_From');?>"
                            value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->inv_start_from : '1'?>">
                        </div>
                        <?php if (form_error('inv_start_from')) { ?>
                        <div class="callout callout-danger my-2">
                            <span class="error_paragraph"><?php echo form_error('inv_start_from'); ?></span>
                        </div>
                        <?php } ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mt-3 mb-3">
                        <h6 class="inv_heading_design mb-2"><?php echo lang('invoice_logo');?></h6>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('inv_logo_is_show');?></label>
                            </div>
                            <select class="form-control select2" name="inv_logo_is_show" id="inv_logo_is_show">
                                <option <?php echo isset($company_info) && $company_info ? ($company_info->inv_logo_is_show == 'Yes' ? 'selected' : '') : 'selected'?> value="Yes"><?php echo lang('yes'); ?></option>
                                <option <?php echo isset($company_info) && $company_info ? ($company_info->inv_logo_is_show == 'No' ? 'selected' : '') : ''?> value="No"><?php echo lang('no'); ?></option>
                            </select>
                            <?php if (form_error('inv_logo_is_show')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('inv_logo_is_show'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="form-label-action">
                                <label><?php echo lang('invoice_logo'); ?> <span class="required_star">(Max 1 MB, Type: jpeg/gif/png)</span></label>
                            </div>
                            <div class="d-flex">
                                <input  type="file" name="invoice_logo" class="form-control m-0" id="crop_image">
                                <input type="hidden" name="logo_image" id="cropped_logo">
                                <?php
                                    $logoPath = !empty($company_info->invoice_logo) ? base_url().'uploads/site_settings/'.$company_info->invoice_logo : '';
                                ?>
                                <a href="javascript:void(0)" data-file_path="<?php echo escape_output($logoPath)?>" data-id="1" class="new-btn ms-2 show_preview">
                                    <iconify-icon icon="solar:eye-bold-duotone" width="18"></iconify-icon>
                                </a>
                            </div>
                            <input  type="hidden" name="invoice_logo_p"
                            class="form-control" value="<?php echo escape_output($company_info->invoice_logo); ?>">
                        </div>
                        <?php if (form_error('invoice_logo')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('invoice_logo'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mt-3 mb-3">
                        <h6 class="inv_heading_design mb-2"><?php echo lang('Invoice_Letterhead');?></h6>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('Show_Letterhead');?></label>
                                <div class="ms-3 op_right op_font_18 op_cursor_pointer mb-4-px">
                                    <i data-tippy-content="Only applicable for A4 and Letter size invoice" class="fa-regular fa-circle-question tippyBtnCall font-16 theme-color"></i>
                                </div>
                            </div>
                            <select class="form-control select2" name="show_letter_head" id="show_letter_head">
                                <option  value="Yes" <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->show_letter_head == 'Yes' ? 'selected' : '') : ''?>><?php echo lang('yes'); ?></option>
                                <option <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->show_letter_head == 'No' ? 'selected' : '') : 'selected'?> value="No"><?php echo lang('no'); ?></option>
                            </select>
                            <?php if (form_error('show_letter_head')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('show_letter_head'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3 letter_head_gap_wrap">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('letter_head_gap'); ?></label>
                                <div class="ms-3 op_right op_font_18 op_cursor_pointer mb-4-px">
                                    <i data-tippy-content="<?php echo lang('letter_head_gap_msg'); ?>" class="fa-regular fa-circle-question tippyBtnCall font-16 theme-color"></i>
                                </div>
                            </div>
                            <input  autocomplete="off" type="text" name="letter_head_gap" id="letter_head_gap"
                            class="form-control" placeholder="<?php echo lang('letter_head_gap');?>"
                            value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->letter_head_gap  : '200px'?>">
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3 letter_footer_gap_wrap">
                        <div class="form-group ">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('letter_footer_gap'); ?></label>
                                <div class="ms-3 op_right op_font_18 op_cursor_pointer mb-4-px">
                                    <i data-tippy-content="<?php echo lang('letter_head_gap_msg'); ?>" class="fa-regular fa-circle-question tippyBtnCall font-16 theme-color"></i>
                                </div>
                            </div>
                            <input  autocomplete="off" type="text" name="letter_footer_gap" id="letter_footer_gap"
                            class="form-control" placeholder="<?php echo lang('letter_footer_gap');?>"
                            value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->letter_footer_gap  : '100px'?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mt-3 mb-3">
                        <h6 class="inv_heading_design mb-2"><?php echo lang('Heading_and_Label'); ?></h6>
                    </div>

                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('invoice_heading');?> <span class="required_star">*</span></label>
                            </div>
                            <input class="form-control" type="text" id="invoice_heading" name="invoice_heading" placeholder="<?php echo lang('invoice_heading');?>" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->invoice_heading  : 'Invoice'?>">
                            <?php if (form_error('invoice_heading')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('invoice_heading'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('invoice_heading_arabic');?></label>
                            </div>
                            <input class="form-control" type="text" id="invoice_heading_arabic" name="invoice_heading_arabic" placeholder="<?php echo lang('invoice_heading_arabic');?>" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->invoice_heading_arabic  : ''?>">
                            <?php if (form_error('invoice_heading_arabic')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('invoice_heading_arabic'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('Heading_Suffix_for_Due_Invoice');?></label>
                            </div>
                            <input class="form-control" type="text" id="invoice_heading_due" name="invoice_heading_due" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->invoice_heading_due  : 'Due'?>" placeholder="<?php echo lang('Heading_Suffix_for_Due_Invoice');?>">
                            <?php if (form_error('invoice_heading_due')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('invoice_heading_due'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('Heading_Suffix_for_Paid_Invoice');?></label>
                            </div>
                            <input class="form-control" type="text" id="invoice_heading_paid" name="invoice_heading_paid" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->invoice_heading_paid  : 'Paid'?>" placeholder="<?php echo lang('Heading_Suffix_for_Paid_Invoice');?>">
                            <?php if (form_error('invoice_heading_paid')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('invoice_heading_paid'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('invoice_no_label');?> <span class="required_star">*</span></label>
                            </div>
                            <input type="text" class="form-control" id="invoice_no_label" name="invoice_no_label" placeholder="<?php echo lang('invoice_no_label');?>" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->invoice_no_label  : 'Invoice No'?>">
                            <?php if (form_error('invoice_no_label')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('invoice_no_label'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('invoice_no_label_arabic');?></label>
                            </div>
                            <input type="text" class="form-control" id="invoice_no_label_arabic" name="invoice_no_label_arabic" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->invoice_no_label_arabic  : ''?>" placeholder="<?php echo lang('invoice_no_label_arabic');?>">
                            <?php if (form_error('invoice_no_label_arabic')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('invoice_no_label_arabic'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('invoice_date_label');?> <span class="required_star">*</span></label>
                            </div>
                            <input class="form-control" type="text" id="invoice_date_label" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->invoice_date_label  : 'Date'?>" name="invoice_date_label" placeholder="<?php echo lang('invoice_date_label');?>">
                            <?php if (form_error('invoice_date_label')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('invoice_date_label'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('invoice_date_label_arabic');?></label>
                            </div>
                            <input class="form-control" type="text" id="invoice_date_label_arabic" name="invoice_date_label_arabic" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->invoice_date_label_arabic  : ''?>" placeholder="<?php echo lang('invoice_date_label_arabic');?>">
                            <?php if (form_error('invoice_date_label_arabic')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('invoice_date_label_arabic'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('invoice_show_due_date');?> <span class="required_star">*</span></label>
                            </div>
                            <select class="form-control select2" name="invoice_show_due_date" id="invoice_show_due_date">
                                <option <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->invoice_show_due_date == 'Yes' ? 'selected' : '')  : ''?> value="Yes"><?php echo lang('yes'); ?></option>
                                <option <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->invoice_show_due_date == 'No' ? 'selected' : '')  : ''?> value="No"><?php echo lang('no'); ?></option>
                            </select>
                            <?php if (form_error('invoice_show_due_date')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('invoice_show_due_date'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('invoice_due_date_label');?> <span class="required_star">*</span></label>
                            </div>
                            <input type="text" class="form-control" id="invoice_due_date_label" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->invoice_due_date_label  : 'Due Date'?>" name="invoice_due_date_label" placeholder="<?php echo lang('invoice_due_date_label');?>">
                            <?php if (form_error('invoice_due_date_label')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('invoice_due_date_label'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('invoice_due_date_label_arabic');?></label>
                            </div>
                            <input type="text" class="form-control" id="invoice_due_date_label_arabic" name="invoice_due_date_label_arabic" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->invoice_due_date_label_arabic  : ''?>" placeholder="<?php echo lang('invoice_due_date_label_arabic');?>">
                            <?php if (form_error('invoice_due_date_label_arabic')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('invoice_due_date_label_arabic'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>


                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('sales_person_label');?> <span class="required_star">*</span></label>
                            </div>
                            <input class="form-control" type="text" id="sales_person_label" name="sales_person_label" placeholder="<?php echo lang('sales_person_label');?>" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->sales_person_label  : 'Sales Person'?>">
                            <?php if (form_error('sales_person_label')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('sales_person_label'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('Commission_Agent_Label');?> <span class="required_star">*</span></label>
                            </div>
                            <input class="form-control" type="text" id="commission_agent_label" name="commission_agent_label" placeholder="<?php echo lang('Commission_Agent_Label');?>" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->commission_agent_label  : 'Commission Agent'?>">
                            <?php if (form_error('commission_agent_label')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('commission_agent_label'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('show_business_name');?> <span class="required_star">*</span></label>
                            </div>
                            <select class="form-control select2" name="show_business_name" id="show_business_name">
                                <option <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->show_business_name == 'Yes' ? 'selected' : '')  : ''?> value="Yes"><?php echo lang('yes'); ?></option>
                                <option <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->show_business_name == 'No' ? 'selected' : '')  : ''?> value="No"><?php echo lang('no'); ?></option>
                            </select>
                            <?php if (form_error('show_business_name')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('show_business_name'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('business_name_arabic');?> </label>
                            </div>
                            <input class="form-control" type="text" id="business_name_arabic" name="business_name_arabic" placeholder="<?php echo lang('business_name_arabic');?>" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->business_name_arabic  : ''?>">
                            <?php if (form_error('business_name_arabic')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('business_name_arabic'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('Show_Business_Tax_Number');?> <span class="required_star">*</span></label>
                            </div>
                            <select class="form-control select2" name="show_business_tax_number" id="show_business_tax_number">
                                <option <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->show_business_tax_number == 'Yes' ? 'selected' : '')  : ($this->session->userdata('collect_tax') == 'Yes' ? 'selected' : '')?> value="Yes"><?php echo lang('yes'); ?></option>
                                <option <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->show_business_tax_number == 'No' ? 'selected' : '')  : ''?> value="No"><?php echo lang('no'); ?></option>
                            </select>
                            <?php if (form_error('show_business_tax_number')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('show_business_tax_number'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('Business_Tax_Number_Label');?> <span class="required_star">*</span></label>
                            </div>
                            <input class="form-control" type="text" id="business_tax_number_label" name="business_tax_number_label" placeholder="<?php echo lang('Business_Tax_Number_Label');?>" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->business_tax_number_label  : 'Business Tax Number'?>">
                            <?php if (form_error('business_tax_number_label')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('business_tax_number_label'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('customer_label');?> <span class="required_star">*</span></label>
                            </div>
                            <input class="form-control" type="text" id="customer_label" name="customer_label" placeholder="<?php echo lang('customer_label');?>" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->customer_label  : 'Customer'?>">
                            <?php if (form_error('customer_label')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('customer_label'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('customer_tax_number_label');?> <span class="required_star">*</span></label>
                            </div>
                            <input class="form-control" type="text" id="customer_tax_number_label" name="customer_tax_number_label" placeholder="<?php echo lang('customer_tax_number_label');?>" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->customer_tax_number_label  : 'Customer Tax Number'?>">
                            <?php if (form_error('customer_tax_number_label')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('customer_tax_number_label'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('show_customer_phone_number');?> <span class="required_star">*</span></label>
                            </div>
                            <select class="form-control select2" name="show_customer_phone_number" id="show_customer_phone_number">
                                <option <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->show_customer_phone_number == 'Yes' ? 'selected' : '')  : 'selected'?> value="Yes"><?php echo lang('yes'); ?></option>
                                <option <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->show_customer_phone_number == 'No' ? 'selected' : '')  : ''?> value="No"><?php echo lang('no'); ?></option>
                            </select>
                            <?php if (form_error('show_customer_phone_number')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('show_customer_phone_number'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('show_customer_email');?> <span class="required_star">*</span></label>
                            </div>
                            <select class="form-control select2" name="show_customer_email" id="show_customer_email">
                                <option <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->show_customer_email == 'Yes' ? 'selected' : '')  : ''?> value="Yes"><?php echo lang('yes'); ?></option>
                                <option <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->show_customer_email == 'No' ? 'selected' : '')  : 'selected'?> value="No"><?php echo lang('no'); ?></option>
                            </select>
                            <?php if (form_error('show_customer_email')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('show_customer_email'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('show_customer_address');?> <span class="required_star">*</span></label>
                            </div>
                            <select class="form-control select2" name="show_customer_address" id="show_customer_address">
                                <option <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->show_customer_address == 'Yes' ? 'selected' : '')  : 'selected'?> value="Yes"><?php echo lang('yes'); ?></option>
                                <option <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->show_customer_address == 'No' ? 'selected' : '')  : ''?> value="No"><?php echo lang('no'); ?></option>
                            </select>
                            <?php if (form_error('show_customer_address')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('show_customer_address'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('item_label');?> <span class="required_star">*</span></label>
                            </div>
                            <input class="form-control" type="text" id="item_label" name="item_label" placeholder="Item Label" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->item_label  : 'Item'?>">
                            <?php if (form_error('item_label')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('item_label'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('item_label_arabic');?></label>
                            </div>
                            <input class="form-control" type="text" id="item_label_arabic" name="item_label_arabic" placeholder="Item Label Arabic" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->item_label_arabic  : ''?>">
                            <?php if (form_error('item_label_arabic')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('item_label_arabic'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('price_label');?> <span class="required_star">*</span></label>
                            </div>
                            <input class="form-control" type="text" id="price_label" name="price_label" placeholder="Price Label" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->price_label  : 'Price'?>">
                            <?php if (form_error('price_label')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('price_label'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('price_label_arabic');?></label>
                            </div>
                            <input class="form-control" type="text" id="price_label_arabic" name="price_label_arabic" placeholder="<?php echo lang('price_label_arabic');?>" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->price_label_arabic  : ''?>">
                            <?php if (form_error('price_label_arabic')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('price_label_arabic'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('quantity_label');?> <span class="required_star">*</span></label>
                            </div>
                            <input class="form-control" type="text" id="quantity_label" name="quantity_label" placeholder="Quantity Label" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->quantity_label  : 'Qty'?>">
                            <?php if (form_error('quantity_label')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('quantity_label'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('quantity_label_arabic');?></label>
                            </div>
                            <input class="form-control" type="text" id="quantity_label_arabic" name="quantity_label_arabic" placeholder="Quantity Label Arabic" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->quantity_label_arabic  : ''?>">
                            <?php if (form_error('quantity_label_arabic')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('quantity_label_arabic'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('item_discount_label');?> <span class="required_star">*</span></label>
                            </div>
                            <input class="form-control" type="text" id="item_discount_label" name="item_discount_label" placeholder="<?php echo lang('item_discount_label');?>" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->item_discount_label  : 'Discount'?>">
                            <?php if (form_error('item_discount_label')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('item_discount_label'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('item_discount_label_arabic');?></label>
                            </div>
                            <input class="form-control" type="text" id="item_discount_label_arabic" name="item_discount_label_arabic" placeholder="<?php echo lang('item_discount_label_arabic');?>" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->item_discount_label_arabic  : ''?>">
                            <?php if (form_error('item_discount_label_arabic')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('item_discount_label_arabic'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>


                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('subtotal_label');?> <span class="required_star">*</span></label>
                            </div>
                            <input class="form-control" type="text" id="subtotal_label" name="subtotal_label" placeholder="<?php echo lang('subtotal_label');?>" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->subtotal_label  : 'Subtotal'?>">
                            <?php if (form_error('subtotal_label')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('subtotal_label'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('subtotal_label_arabic');?></label>
                            </div>
                            <input class="form-control" type="text" id="subtotal_label_arabic" name="subtotal_label_arabic" placeholder="<?php echo lang('subtotal_label_arabic');?>" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->subtotal_label_arabic  : ''?>">
                            <?php if (form_error('subtotal_label_arabic')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('subtotal_label_arabic'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('total_label');?> <span class="required_star">*</span></label>
                            </div>
                            <input class="form-control" type="text" id="total_label" name="total_label" placeholder="<?php echo lang('total_label');?>" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->total_label  : 'Total'?>">
                            <?php if (form_error('total_label')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('total_label'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('total_label_arabic');?></label>
                            </div>
                            <input class="form-control" type="text" id="total_label_arabic" name="total_label_arabic" placeholder="<?php echo lang('total_label_arabic');?>" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->total_label_arabic  : ''?>">
                            <?php if (form_error('total_label_arabic')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('total_label_arabic'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>


                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('total_item_label');?> <span class="required_star">*</span></label>
                            </div>
                            <input class="form-control" type="text" id="total_item_label" name="total_item_label" placeholder="<?php echo lang('total_item_label');?>" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->total_item_label  : 'Total Item'?>">
                            <?php if (form_error('total_item_label')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('total_item_label'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('total_item_label_arabic');?></label>
                            </div>
                            <input class="form-control" type="text" id="total_item_label_arabic" name="total_item_label_arabic" placeholder="<?php echo lang('total_item_label_arabic');?>" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->total_item_label_arabic  : ''?>">
                            <?php if (form_error('total_item_label_arabic')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('total_item_label_arabic'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>



                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('tax_label');?> <span class="required_star">*</span></label>
                            </div>
                            <input class="form-control" type="text" id="tax_label" name="tax_label" placeholder="<?php echo lang('tax_label');?>" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->tax_label  : 'Tax'?>">
                            <?php if (form_error('tax_label')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('tax_label'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('tax_label_arabic');?></label>
                            </div>
                            <input class="form-control" type="text" id="tax_label_arabic" name="tax_label_arabic" placeholder="<?php echo lang('tax_label_arabic');?>" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->tax_label_arabic  : ''?>">
                            <?php if (form_error('tax_label_arabic')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('tax_label_arabic'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('charge_label');?> <span class="required_star">*</span></label>
                            </div>
                            <input class="form-control" type="text" id="charge_label" name="charge_label" placeholder="<?php echo lang('charge_label');?>" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->charge_label  : 'Charge'?>">
                            <?php if (form_error('charge_label')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('charge_label'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('charge_label_arabic');?> </label>
                            </div>
                            <input class="form-control" type="text" id="charge_label_arabic" name="charge_label_arabic" placeholder="<?php echo lang('charge_label_arabic');?>" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->charge_label_arabic  : ''?>">
                            <?php if (form_error('charge_label_arabic')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('charge_label_arabic'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('discount_label');?> <span class="required_star">*</span></label>
                            </div>
                            <input class="form-control" type="text" id="discount_label" name="discount_label" placeholder="<?php echo lang('discount_label');?>" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->discount_label  : 'Discount'?>">
                            <?php if (form_error('discount_label')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('discount_label'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('discount_label_arabic');?> </label>
                            </div>
                            <input class="form-control" type="text" id="discount_label_arabic" name="discount_label_arabic" placeholder="<?php echo lang('discount_label_arabic');?>" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->discount_label_arabic  : ''?>">
                            <?php if (form_error('discount_label_arabic')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('discount_label_arabic'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>


                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('delivery_partner_label');?> <span class="required_star">*</span></label>
                            </div>
                            <input class="form-control" type="text" id="delivery_partner_label" name="delivery_partner_label" placeholder="<?php echo lang('delivery_partner_label');?>" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->delivery_partner_label  : 'Delivery Partner'?>">
                            <?php if (form_error('delivery_partner_label')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('delivery_partner_label'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('delivery_partner_label_arabic');?> </label>
                            </div>
                            <input class="form-control" type="text" id="delivery_partner_label_arabic" name="delivery_partner_label_arabic" placeholder="<?php echo lang('delivery_partner_label_arabic');?>" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->delivery_partner_label_arabic  : ''?>">
                            <?php if (form_error('delivery_partner_label_arabic')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('delivery_partner_label_arabic'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('rounding_label');?> <span class="required_star">*</span></label>
                            </div>
                            <input class="form-control" type="text" id="rounding_label" name="rounding_label" placeholder="<?php echo lang('rounding_label');?>" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->rounding_label  : 'Rounding'?>">
                            <?php if (form_error('rounding_label')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('rounding_label'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('rounding_label_arabic');?> </label>
                            </div>
                            <input class="form-control" type="text" id="rounding_label_arabic" name="rounding_label_arabic" placeholder="<?php echo lang('rounding_label_arabic');?>" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->rounding_label_arabic  : ''?>">
                            <?php if (form_error('rounding_label_arabic')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('rounding_label_arabic'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>


                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('total_payable_label');?> <span class="required_star">*</span></label>
                            </div>
                            <input class="form-control" type="text" id="total_payable_label" name="total_payable_label" placeholder="<?php echo lang('total_payable_label');?>" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->total_payable_label  : 'Total Payable'?>">
                            <?php if (form_error('total_payable_label')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('total_payable_label'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('total_payable_label_arabic');?> </label>
                            </div>
                            <input class="form-control" type="text" id="total_payable_label_arabic" name="total_payable_label_arabic" placeholder="<?php echo lang('total_payable_label_arabic');?>" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->total_payable_label_arabic  : ''?>">
                            <?php if (form_error('total_payable_label_arabic')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('total_payable_label_arabic'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <!-- Azhar New Added -->
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('previous_balance_label');?> <span class="required_star">*</span></label>
                            </div>
                            <input class="form-control" type="text" id="previous_balance_label" name="previous_balance_label" placeholder="<?php echo lang('previous_balance_label');?>" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->previous_balance_label  : 'Previous Balance '?>">
                            <?php if (form_error('previous_balance_label')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('previous_balance_label'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('previous_balance_label_arabic');?></label>
                            </div>
                            <input class="form-control" type="text" id="previous_balance_label_arabic" name="previous_balance_label_arabic" placeholder="<?php echo lang('previous_balance_label_arabic');?>" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->previous_balance_label_arabic  : ''?>">
                            <?php if (form_error('previous_balance_label_arabic')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('previous_balance_label_arabic'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('paid_amount_label');?> <span class="required_star">*</span></label>
                            </div>
                            <input class="form-control" type="text" id="paid_amount_label" name="paid_amount_label" placeholder="<?php echo lang('paid_amount_label');?>" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->paid_amount_label  : 'Paid Amount'?>">
                            <?php if (form_error('paid_amount_label')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('paid_amount_label'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('paid_amount_label_arabic');?> </label>
                            </div>
                            <input class="form-control" type="text" id="paid_amount_label_arabic" name="paid_amount_label_arabic" placeholder="<?php echo lang('paid_amount_label_arabic');?>" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->paid_amount_label_arabic  : ''?>">
                            <?php if (form_error('paid_amount_label_arabic')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('paid_amount_label_arabic'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('due_amount_label');?> <span class="required_star">*</span></label>
                            </div>
                            <input class="form-control" type="text" id="due_amount_label" name="due_amount_label" placeholder="<?php echo lang('due_amount_label');?>" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->due_amount_label  : 'Due Amount'?>">
                            <?php if (form_error('due_amount_label')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('due_amount_label'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('due_amount_label_arabic');?> </label>
                            </div>
                            <input class="form-control" type="text" id="due_amount_label_arabic" name="due_amount_label_arabic" placeholder="<?php echo lang('due_amount_label_arabic');?>" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->due_amount_label_arabic  : ''?>">
                            <?php if (form_error('due_amount_label_arabic')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('due_amount_label_arabic'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('due_receive_label');?> <span class="required_star">*</span></label>
                            </div>
                            <input class="form-control" type="text" id="due_receive_label" name="due_receive_label" placeholder="<?php echo lang('due_receive_label');?>" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->due_receive_label  : 'Due Receive'?>">
                            <?php if (form_error('due_receive_label')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('due_receive_label'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('due_receive_label_arabic');?> </label>
                            </div>
                            <input class="form-control" type="text" id="due_receive_label_arabic" name="due_receive_label_arabic" placeholder="<?php echo lang('due_receive_label_arabic');?>" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->due_receive_label_arabic  : ''?>">
                            <?php if (form_error('due_receive_label_arabic')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('due_receive_label_arabic'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('advance_receive_label');?> <span class="required_star">*</span></label>
                            </div>
                            <input class="form-control" type="text" id="advance_receive_label" name="advance_receive_label" placeholder="<?php echo lang('advance_receive_label');?>" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->advance_receive_label  : 'Advance Receive'?>">
                            <?php if (form_error('advance_receive_label')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('advance_receive_label'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('advance_receive_label_arabic');?> </label>
                            </div>
                            <input class="form-control" type="text" id="advance_receive_label_arabic" name="advance_receive_label_arabic" placeholder="<?php echo lang('advance_receive_label_arabic');?>" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->advance_receive_label_arabic  : ''?>">
                            <?php if (form_error('advance_receive_label_arabic')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('advance_receive_label_arabic'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('given_amount_label');?> <span class="required_star">*</span></label>
                            </div>
                            <input class="form-control" type="text" id="given_amount_label" name="given_amount_label" placeholder="<?php echo lang('given_amount_label');?>" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->given_amount_label  : 'Given Amount'?>">
                            <?php if (form_error('given_amount_label')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('given_amount_label'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('given_amount_label_arabic');?> </label>
                            </div>
                            <input class="form-control" type="text" id="given_amount_label_arabic" name="given_amount_label_arabic" placeholder="<?php echo lang('given_amount_label_arabic');?>" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->given_amount_label_arabic  : ''?>">
                            <?php if (form_error('given_amount_label_arabic')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('given_amount_label_arabic'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('change_amount_label');?> <span class="required_star">*</span></label>
                            </div>
                            <input class="form-control" type="text" id="change_amount_label" name="change_amount_label" placeholder="<?php echo lang('change_amount_label');?>" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->change_amount_label  : 'Change Amount'?>">
                            <?php if (form_error('change_amount_label')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('change_amount_label'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('change_amount_label_arabic');?> </label>
                            </div>
                            <input class="form-control" type="text" id="change_amount_label_arabic" name="change_amount_label_arabic" placeholder="<?php echo lang('change_amount_label_arabic');?>" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->change_amount_label_arabic  : ''?>">
                            <?php if (form_error('change_amount_label_arabic')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('change_amount_label_arabic'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('servicing_charge_label');?> <span class="required_star">*</span></label>
                            </div>
                            <input class="form-control" type="text" id="servicing_charge_label" name="servicing_charge_label" placeholder="<?php echo lang('servicing_charge_label');?>" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->servicing_charge_label  : 'Servicing Charge'?>">
                            <?php if (form_error('servicing_charge_label')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('servicing_charge_label'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('servicing_charge_label_arabic');?> </label>
                            </div>
                            <input class="form-control" type="text" id="servicing_charge_label_arabic" name="servicing_charge_label_arabic" placeholder="<?php echo lang('servicing_charge_label_arabic');?>" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->servicing_charge_label_arabic  : ''?>">
                            <?php if (form_error('servicing_charge_label_arabic')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('servicing_charge_label_arabic'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('show_payment_method');?> <span class="required_star">*</span></label>
                            </div>
                            <select class="form-control select2" name="show_payment_method" id="show_payment_method">
                                <option <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->show_payment_method == 'Yes' ? 'selected' : '')  : 'selected'?> value="Yes"><?php echo lang('yes'); ?></option>
                                <option <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->show_payment_method == 'No' ? 'selected' : '')  : ''?> value="No"><?php echo lang('no'); ?></option>
                            </select>
                            <?php if (form_error('show_payment_method')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('show_payment_method'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('payment_method_label');?> <span class="required_star">*</span></label>
                            </div>
                            <input class="form-control" type="text" id="payment_method_label" name="payment_method_label" placeholder="<?php echo lang('payment_method_label');?>" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->payment_method_label  : 'Payment Method'?>">
                            <?php if (form_error('payment_method_label')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('payment_method_label'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('payment_method_label_arabic');?> </label>
                            </div>
                            <input class="form-control" type="text" id="payment_method_label_arabic" name="payment_method_label_arabic" placeholder="<?php echo lang('payment_method_label_arabic');?>" value="<?php echo isset($invoice_configuration) && $invoice_configuration ? $invoice_configuration->payment_method_label_arabic  : ''?>">
                            <?php if (form_error('payment_method_label_arabic')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('payment_method_label_arabic'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mt-3 mb-3">
                        <h6 class="inv_heading_design mb-2"><?php echo lang('Product_Details_Section');?></h6>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('show_brand');?> <span class="required_star">*</span></label>
                            </div>
                            <select class="form-control select2" name="show_brand" id="show_brand">
                                <option <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->show_brand == 'Yes' ? 'selected' : '')  : ''?> value="Yes"><?php echo lang('yes'); ?></option>
                                <option <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->show_brand == 'No' ? 'selected' : '')  : 'selected'?> value="No"><?php echo lang('no'); ?></option>
                            </select>
                            <?php if (form_error('show_brand')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('show_brand'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('show_product_code');?> <span class="required_star">*</span></label>
                            </div>
                            <select class="form-control select2" name="show_product_code" id="show_product_code">
                                <option <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->show_product_code == 'Yes' ? 'selected' : '')  : ''?> value="Yes"><?php echo lang('yes'); ?></option>
                                <option <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->show_product_code == 'No' ? 'selected' : '')  : 'selected'?> value="No"><?php echo lang('no'); ?></option>
                            </select>
                            <?php if (form_error('show_product_code')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('show_product_code'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('show_product_imei_serial_number');?> <span class="required_star">*</span></label>
                                <div class="ms-3 op_right op_font_18 op_cursor_pointer mb-4-px">
                                    <i data-tippy-content="Applicable only for IMEI or Serial type items" class="fa-regular fa-circle-question tippyBtnCall font-16 theme-color"></i>
                                </div>
                            </div>
                            <select class="form-control select2" name="show_product_imei_serial_number" id="show_product_imei_serial_number">
                                <option <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->show_product_imei_serial_number == 'Yes' ? 'selected' : '')  : ''?> value="Yes"><?php echo lang('yes'); ?></option>
                                <option <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->show_product_imei_serial_number == 'No' ? 'selected' : '')  : ''?> value="No"><?php echo lang('no'); ?></option>
                            </select>
                            <?php if (form_error('show_product_imei_serial_number')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('show_product_imei_serial_number'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('show_product_image');?> <span class="required_star">*</span></label>
                            </div>
                            <select class="form-control select2" name="show_product_image" id="show_product_image">
                                <option <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->show_product_image == 'Yes' ? 'selected' : '')  : ''?> value="Yes"><?php echo lang('yes'); ?></option>
                                <option <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->show_product_image == 'No' ? 'selected' : '')  : ''?> value="No"><?php echo lang('no'); ?></option>
                            </select>
                            <?php if (form_error('show_product_image')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('show_product_image'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>


                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('show_warranty_period');?> <span class="required_star">*</span></label>
                                <div class="ms-3 op_right op_font_18 op_cursor_pointer mb-4-px">
                                    <i data-tippy-content="Applicable only if the item has warranty" class="fa-regular fa-circle-question tippyBtnCall font-16 theme-color"></i>
                                </div>
                            </div>
                            <select class="form-control select2" name="show_warranty_period" id="show_warranty_period">
                                <option <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->show_warranty_period == 'Yes' ? 'selected' : '')  : 'selected'?> value="Yes"><?php echo lang('yes'); ?></option>
                                <option <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->show_warranty_period == 'No' ? 'selected' : '')  : ''?> value="No"><?php echo lang('no'); ?></option>
                            </select>
                            <?php if (form_error('show_warranty_period')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('show_warranty_period'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>


                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('show_warranty_expiry_date');?> <span class="required_star">*</span></label>
                                <div class="ms-3 op_right op_font_18 op_cursor_pointer mb-4-px">
                                    <i data-tippy-content="Applicable only if the item has warranty" class="fa-regular fa-circle-question tippyBtnCall font-16 theme-color"></i>
                                </div>
                            </div>
                            <select class="form-control select2" name="show_warranty_expiry_date" id="show_warranty_expiry_date">
                                <option <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->show_warranty_expiry_date == 'Yes' ? 'selected' : '')  : 'selected'?> value="Yes"><?php echo lang('yes'); ?></option>
                                <option <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->show_warranty_expiry_date == 'No' ? 'selected' : '')  : 'selected'?> value="No"><?php echo lang('no'); ?></option>
                            </select>
                            <?php if (form_error('show_warranty_expiry_date')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('show_warranty_expiry_date'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('show_guarantee_period');?> <span class="required_star">*</span></label>
                                <div class="ms-3 op_right op_font_18 op_cursor_pointer mb-4-px">
                                    <i data-tippy-content="Applicable only if the item has guarantee" class="fa-regular fa-circle-question tippyBtnCall font-16 theme-color"></i>
                                </div>
                            </div>
                            <select class="form-control select2" name="show_guarantee_period" id="show_guarantee_period">
                                <option <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->show_guarantee_period == 'Yes' ? 'selected' : '')  : 'selected'?> value="Yes"><?php echo lang('yes'); ?></option>
                                <option <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->show_guarantee_period == 'No' ? 'selected' : '')  : ''?> value="No"><?php echo lang('no'); ?></option>
                            </select>
                            <?php if (form_error('show_guarantee_period')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('show_guarantee_period'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    

                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('show_guarantee_expiry_date');?> <span class="required_star">*</span></label>
                                <div class="ms-3 op_right op_font_18 op_cursor_pointer mb-4-px">
                                    <i data-tippy-content="Applicable only if the item has guarantee" class="fa-regular fa-circle-question tippyBtnCall font-16 theme-color"></i>
                                </div>
                            </div>
                            <select class="form-control select2" name="show_guarantee_expiry_date" id="show_guarantee_expiry_date">
                                <option <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->show_guarantee_expiry_date == 'Yes' ? 'selected' : '')  : 'selected'?> value="Yes"><?php echo lang('yes'); ?></option>
                                <option <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->show_guarantee_expiry_date == 'No' ? 'selected' : '')  : ''?> value="No"><?php echo lang('no'); ?></option>
                            </select>
                            <?php if (form_error('show_guarantee_expiry_date')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('show_guarantee_expiry_date'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>


                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('show_total_in_words');?> <span class="required_star">*</span></label>
                            </div>
                            <select class="form-control select2" name="show_total_in_words" id="show_total_in_words">
                                <option <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->show_total_in_words == 'Yes' ? 'selected' : '')  : 'selected'?> value="Yes"><?php echo lang('yes'); ?></option>
                                <option <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->show_total_in_words == 'No' ? 'selected' : '')  : ''?> value="No"><?php echo lang('no'); ?></option>
                            </select>
                            <?php if (form_error('show_total_in_words')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('show_total_in_words'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>


                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('word_format');?> <span class="required_star">*</span></label>
                            </div>
                            <select class="form-control select2" name="word_format" id="word_format">
                                <option <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->word_format == 'International' ? 'selected' : '')  : ''?> value="International"><?php echo lang('international');?></option>
                                <option <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->word_format == 'Indian' ? 'selected' : '')  : 'selected'?> value="Indian"><?php echo lang('indian');?></option>
                            </select>
                            <?php if (form_error('word_format')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('word_format'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mt-3 mb-3">
                        <h6 class="inv_heading_design mb-2"><?php echo lang('footer');?></h6>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('Invoice_Terms_Conditions'); ?></label>
                                <div class="ms-3 op_right op_font_18 op_cursor_pointer mb-4-px">
                                    <i data-tippy-content="<?php echo lang('a4_printer_msg'); ?>" class="fa-regular fa-circle-question tippyBtnCall font-16 theme-color"></i>
                                </div>
                            </div>
                            <!-- This variable could not be escaped because this is html content -->
                            <textarea id="term_conditions" name="term_conditions"><?php echo escape_output($company_info->term_conditions); ?></textarea>
                            <?php if (form_error('term_conditions')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('term_conditions'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('invoice_footer'); ?></label>
                                <div class="ms-3 op_right op_font_18 op_cursor_pointer mb-4-px">
                                    <i data-tippy-content="<?php echo lang('invoice_footer_msg'); ?>" class="fa-regular fa-circle-question tippyBtnCall font-16 theme-color"></i>
                                </div>
                            </div>
                            <textarea id="invoice_footer" name="invoice_footer"><?php echo escape_output($company_info->invoice_footer); ?></textarea>
                            <?php if (form_error('invoice_footer')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('invoice_footer'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                        <?php if (form_error('invoice_footer')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('invoice_footer'); ?></span>
                            </div>
                        <?php } ?>
                    </div>

                    
                    
                    <!-- <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('show_outlet_label');?></label>
                                <div class="ms-3 op_right op_font_18 op_cursor_pointer mb-4-px">
                                    <i data-tippy-content="<?php echo lang('show_outlet_label');?>" class="fa-regular fa-circle-question tippyBtnCall font-16 theme-color"></i>
                                </div>
                            </div>
                            <select class="form-control select2" name="show_outlet_label" id="show_outlet_label">
                                <option value="Yes"><?php echo lang('yes'); ?></option>
                                <option value="No"><?php echo lang('no'); ?></option>
                            </select>
                            <?php if (form_error('show_outlet_label')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('show_outlet_label'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('show_sale_person');?></label>
                                <div class="ms-3 op_right op_font_18 op_cursor_pointer mb-4-px">
                                    <i data-tippy-content="<?php echo lang('show_sale_person');?>" class="fa-regular fa-circle-question tippyBtnCall font-16 theme-color"></i>
                                </div>
                            </div>
                            <select class="form-control select2" name="show_sale_person" id="show_sale_person">
                                <option value="Yes"><?php echo lang('yes'); ?></option>
                                <option value="No"><?php echo lang('no'); ?></option>
                            </select>
                            <?php if (form_error('show_sale_person')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('show_sale_person'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('show_payment_information');?></label>
                                <div class="ms-3 op_right op_font_18 op_cursor_pointer mb-4-px">
                                    <i data-tippy-content="<?php echo lang('show_payment_information');?>" class="fa-regular fa-circle-question tippyBtnCall font-16 theme-color"></i>
                                </div>
                            </div>
                            <select class="form-control select2" name="show_payment_information" id="show_payment_information">
                                <option value="Yes"><?php echo lang('yes'); ?></option>
                                <option value="No"><?php echo lang('no'); ?></option>
                            </select>
                            <?php if (form_error('show_payment_information')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('show_payment_information'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div> -->
                </div>

                <div class="row qr_code_options">
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('qr_code_option');?> <span class="required_star">*</span></label>
                            </div>
                            <select  class="form-control select2" id="qr_code_option" name="qr_code_option">
                                <option <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->qr_code_option == 'ZATCA QR Code' ? 'selected' : '') : 'selected'?> value="ZATCA QR Code"><?php echo lang('Zatka_QR_Code');?></option>
                                <option <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->qr_code_option == 'Regular QR Code' ? 'selected' : '') : ''?> value="Regular QR Code"><?php echo lang('regular_qr_code');?></option>
                            </select>
                        </div>
                        <?php if (form_error('qr_code_option')) { ?>
                        <div class="callout callout-danger my-2">
                            <span class="error_paragraph"><?php echo form_error('qr_code_option'); ?></span>
                        </div>
                        <?php } ?>
                    </div>

                    <div class="clear-fix"></div>

                    
                    <div class="col-12 mt-3 mb-3">
                        <h6 class="mb-2"><?php echo lang('regular_qr_code_information');?></h6>
                    </div>

                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="qr_code_business" value="Yes" name="qr_code_business" <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->qr_code_business == 'Yes' ? 'checked' : '') : '' ?>>
                            <label class="form-check-label" for="qr_code_business"><?php echo lang('qr_code_business');?></label>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="qr_code_address" value="Yes" name="qr_code_address" <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->qr_code_address == 'Yes' ? 'checked' : '') : '' ?>>
                            <label class="form-check-label" for="qr_code_address"><?php echo lang('qr_code_address');?></label>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="qr_code_taxnumber" value="Yes" name="qr_code_taxnumber" <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->qr_code_taxnumber == 'Yes' ? 'checked' : '') : '' ?>>
                            <label class="form-check-label" for="qr_code_taxnumber"><?php echo lang('qr_code_taxnumber');?></label>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="qr_code_invoice_no" value="Yes" name="qr_code_invoice_no" <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->qr_code_invoice_no == 'Yes' ? 'checked' : '') : '' ?>>
                            <label class="form-check-label" for="qr_code_invoice_no"><?php echo lang('qr_code_invoice_no');?></label>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="qr_code_invoice_date_time" value="Yes" name="qr_code_invoice_date_time" <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->qr_code_invoice_date_time == 'Yes' ? 'checked' : '') : '' ?>>
                            <label class="form-check-label" for="qr_code_invoice_date_time"><?php echo lang('qr_code_invoice_date_time');?></label>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="qr_code_subtotal" value="Yes" name="qr_code_subtotal" <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->qr_code_subtotal == 'Yes' ? 'checked' : '') : '' ?>>
                            <label class="form-check-label" for="qr_code_subtotal"><?php echo lang('qr_code_subtotal');?></label>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="qr_code_charge" value="Yes" name="qr_code_charge" <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->qr_code_charge == 'Yes' ? 'checked' : '') : '' ?>>
                            <label class="form-check-label" for="qr_code_charge"><?php echo lang('qr_code_charge');?></label>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="qr_code_tax" value="Yes" name="qr_code_tax" <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->qr_code_tax == 'Yes' ? 'checked' : '') : '' ?>>
                            <label class="form-check-label" for="qr_code_tax"><?php echo lang('qr_code_tax');?></label>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="qr_code_total_payable" value="Yes" name="qr_code_total_payable" <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->qr_code_total_payable == 'Yes' ? 'checked' : '') : '' ?>>
                            <label class="form-check-label" for="qr_code_total_payable"><?php echo lang('qr_code_total_payable');?></label>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="qr_code_customer_name" value="Yes" name="qr_code_customer_name" <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->qr_code_customer_name == 'Yes' ? 'checked' : '') : '' ?>>
                            <label class="form-check-label" for="qr_code_customer_name"><?php echo lang('qr_code_customer_name');?></label>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="qr_code_invoice_url" value="Yes" name="qr_code_invoice_url" <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->qr_code_invoice_url == 'Yes' ? 'checked' : '') : '' ?>>
                            <label class="form-check-label" for="qr_code_invoice_url"><?php echo lang('qr_code_invoice_url');?></label>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="qr_code_outlet" value="Yes" name="qr_code_outlet" <?php echo isset($invoice_configuration) && $invoice_configuration ? ($invoice_configuration->qr_code_outlet == 'Yes' ? 'checked' : '') : '' ?>>
                            <label class="form-check-label" for="qr_code_outlet"><?php echo lang('qr_code_outlet');?></label>
                        </div>
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
</div>


<div class="modal fade" id="logo_preview"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><?php echo lang('invoice_logo');?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <?php
                $logoPath = !empty($company_info->invoice_logo) ? base_url().'uploads/site_settings/'.$company_info->invoice_logo : '';
            ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12  op_center op_padding_10">
                        <img class="img-fluid" src="<?php echo $logoPath ?>" alt="invoice-logo" id="show_id">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-blue-btn"
                     data-bs-dismiss="modal"><?php echo lang('close');?></button>
            </div>
        </div>
    </div>
</div>


<div id="crop_image_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo lang('company_logo');?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <img class="img-fluid displayNone" src="-" alt="">
                </div>
                <br>
                <button id="crop_result" class="btn bg-blue-btn"><?php echo lang('crop');?></button>
            </div>
        </div>
    </div>
</div>


<script src="<?php echo base_url(); ?>assets/ck-editor/ckeditor.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/edit_outlet.js"></script>
<script src="<?php echo base_url(); ?>assets/cropper/cropper.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/image_crop.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/settings.js"></script>