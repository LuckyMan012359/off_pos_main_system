<link rel="stylesheet" href="<?php echo base_url() ?>frequent_changing/css/custom_check_box.css">

<section class="main-content-wrapper">
<h3 class="display_none">&nbsp;</h3>

    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo lang('add_printer'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('printer'), 'secondSection'=> lang('add_printer')])?>
        </div>
    </section>


    <div class="box-wrapper">
        <div class="table-box"> 
            <?php 
            $attributes = array('id' => 'add_Printer');
            echo form_open_multipart(base_url('printer/addEditPrinter/'), $attributes); ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6 col-lg-4 col-xl-3 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('title'); ?> (<?php echo lang('to_identify_printer_easily');?>) <span class="required_star">*</span></label>
                            <input  autocomplete="off" type="text" name="title" class="form-control" placeholder="<?php echo lang('title'); ?>" value="<?php echo set_value('title'); ?>">
                        </div>
                        <?php if (form_error('title')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('title'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="clear-fix"></div>
                    <div class="col-md-6 col-lg-4 col-xl-3 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('printer_type'); ?> <span class="required_star">*</span></label>
                            <select class="form-control select2" id="type" name="type">
                                <option <?php echo set_select('type',"network") ?> value="network"><?php echo lang('network_printer'); ?></option>
                                <option <?php echo set_select('type',"windows") ?> value="windows"><?php echo lang('windows_printer'); ?></option>
                            </select>
                        </div>
                        <?php if (form_error('type')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('type'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="clear-fix"></div>
                    <div class="col-md-6 col-lg-4 col-xl-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label>
                                    <?php echo lang('characters_per_line'); ?> <span class="required_star">*</span>
                                </label>
                                <div class="ms-3 op_right op_font_18 op_cursor_pointer mb-4-px">
                                    <i data-tippy-content="<?php echo lang('printer_per_line_tooltip'); ?>" class="fa-regular fa-circle-question tippyBtnCall font-16 theme-color"></i>
                                </div>
                            </div>
                            <input  autocomplete="off" type="number" name="characters_per_line" class="form-control" placeholder="<?php echo lang('characters_per_line'); ?>" value="<?php echo set_value('characters_per_line'); ?>">
                        </div>
                        <?php if (form_error('characters_per_line')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('characters_per_line'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 col-lg-4 col-xl-3 mb-3 network_div1">
                        <div class="form-group">

                            <div class="d-flex justify-content-between align-items-center">
                                <label>
                                    <?php echo lang('printer_ip_address'); ?> <span class="required_star">*</span>
                                </label>
                                <div class="ms-3 op_right op_font_18 op_cursor_pointer mb-4-px">
                                    <i data-tippy-content="<?php echo lang('printer_ip_tooltip'); ?>" class="fa-regular fa-circle-question tippyBtnCall font-16 theme-color"></i>
                                </div>
                            </div>
                            <input  autocomplete="off" type="text" name="printer_ip_address" class="form-control" placeholder="<?php echo lang('printer_ip_address'); ?>" value="<?php echo set_value('printer_ip_address'); ?>">
                        </div>
                        <?php if (form_error('printer_ip_address')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('printer_ip_address'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 col-lg-4 col-xl-3 mb-3 network_div1">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label>
                                    <?php echo lang('printer_port_address'); ?> <span class="required_star">*</span>
                                </label>
                                <div class="ms-3 op_right op_font_18 op_cursor_pointer mb-4-px">
                                    <i data-tippy-content="<?php echo lang('printer_port_tooltip'); ?>" class="fa-regular fa-circle-question tippyBtnCall font-16 theme-color"></i>
                                </div>
                            </div>
                            <input  autocomplete="off" type="text" name="printer_port" class="form-control" placeholder="<?php echo lang('printer_port_address'); ?>" value="<?php echo set_value('printer_port'); ?>">
                        </div>
                        <?php if (form_error('printer_port')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('printer_port'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 col-lg-4 col-xl-3 mb-3 receipt_printer_div txt_11">
                        <div class="form-group">
                            <label><?php echo lang('share_name'); ?> <span class="required_star">*</span> </label> <a class="pull-right" href="https://youtu.be/IHBslN6kBlE" target="_blank"><?php echo lang('printer_path_tooltip'); ?></a>
                            <input  autocomplete="off" type="text" name="path" class="form-control" placeholder="<?php echo lang('share_name'); ?>" value="<?php echo set_value('path'); ?>">
                        </div>
                        <?php if (form_error('path')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('path'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="box-footer">             
                <button type="submit" name="submit" value="submit" class="btn bg-blue-btn">
                    <?php echo lang('submit'); ?>
                </button>
                <a class="btn bg-blue-btn" href="<?php echo base_url() ?>printer/printers">
                    <?php  echo lang('back'); ?>
                </a>      
            </div>

            

            <?php echo form_close(); ?>
        </div>
    </div>
</section>
<script src="<?php echo base_url('frequent_changing/js/printer.js');?>"></script>