<?php 
    if($outlet_information->register_content) {
        $register_content = json_decode($outlet_information->register_content);
    } else {
        $register_content = '';
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
                <h3 class="top-left-header mt-2"><?php echo lang('setting'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('setting'), 'secondSection'=> lang('setting')])?>
        </div>
    </section>


    <div class="box-wrapper">
        <div class="table-box">
            <?php
            $attributes = array('id' => 'restaurant_setting_form');
            echo form_open_multipart(base_url('Setting/index'),$attributes); ?>
            <div class="box-body">

                <h3 class="top-left-header">Business Setting</h3>
                <hr>
                <div class="row">
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('Business_Name'); ?> <span class="required_star">*</span></label>
                            <input  autocomplete="off" type="text" id="business_name" name="business_name"
                            class="form-control" placeholder="<?php echo lang('Business_Name'); ?>"
                            value="<?php echo escape_output($outlet_information->business_name); ?>">
                        </div>
                        <?php if (form_error('business_name')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('business_name'); ?></span>
                            </div>
                        <?php } ?>
                        <div class="callout callout-danger my-2 op_display_none"
                        id="business_name_error">
                        <p><?php echo lang('The_Shop_Name_field_is_required'); ?></p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('address'); ?></label>
                            <textarea id="address" name="address" class="form-control" placeholder="<?php echo lang('address'); ?>"><?php echo escape_output(isset($outlet_information->address) && $outlet_information->address?$outlet_information->address:set_value('address')); ?></textarea>
                        </div>
                        <?php if (form_error('address')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('address'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('website'); ?></label>
                            <input  autocomplete="off" type="text" id="website" name="website"
                            class="form-control" placeholder="<?php echo lang('website'); ?>"
                            value="<?php echo escape_output($outlet_information->website); ?>">
                        </div>
                        <?php if (form_error('website')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('website'); ?></span>
                            </div>
                        <?php } ?>
                        <div class="callout callout-danger my-2 op_display_none" id="address_error">
                            <p><?php echo lang('The_website_field_is_required'); ?></p>
                        </div>

                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('email'); ?> <span class="required_star">*</span></label>
                            <input  autocomplete="off" type="text" id="email" name="email"
                            class="form-control" placeholder="<?php echo lang('email'); ?>"
                            value="<?php echo escape_output($outlet_information->email); ?>">
                        </div>
                        <?php if (form_error('email')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('email'); ?></span>
                            </div>
                        <?php } ?>
                        <div class="callout callout-danger my-2 op_display_none" id="email_error">
                            <p><?php echo lang('The_Email_field_is_required'); ?></p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('phone'); ?> <span class="required_star">*</span></label>
                                <div class="ms-3 op_right op_font_18 op_cursor_pointer mb-4-px">
                                    <i data-tippy-content="<?php echo lang('Not_for_login_for_showing_in_print_receipt'); ?>" class="fa-regular fa-circle-question tippyBtnCall font-16 theme-color"></i>
                                </div>
                            </div>
                            <input  autocomplete="off" type="text" id="phone" name="phone"
                            class="form-control" placeholder="<?php echo lang('phone'); ?>"
                            value="<?php echo escape_output($outlet_information->phone); ?>">
                        </div>
                        <?php if (form_error('phone')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('phone'); ?></span>
                            </div>
                        <?php } ?>
                        <div class="callout callout-danger my-2 op_display_none" id="phone_error">
                            <p><?php echo lang('The_Phone_field_is_required'); ?></p>
                        </div>
                    </div>
                    <div class="mb-3 col-md-6 col-lg-3">
                        <div class="form-group">
                            <label> <?php echo lang('date_format'); ?> <span
                                class="required_star">*</span></label>
                                <select  class="form-control select2" name="date_format"
                                id="date_format">
                                <option value=""><?php echo lang('select'); ?></option>
                                <option
                                <?= isset($outlet_information) && $outlet_information->date_format == "d/m/Y" ? 'selected' : '' ?>
                                value="d/m/Y"><?php echo lang('D_M_Y');?></option>
                                <option
                                <?= isset($outlet_information) && $outlet_information->date_format == "m/d/Y" ? 'selected' : '' ?>
                                value="m/d/Y"><?php echo lang('M_D_Y');?></option>
                                <option
                                <?= isset($outlet_information) && $outlet_information->date_format == "Y/m/d" ? 'selected' : '' ?>
                                value="Y/m/d"><?php echo lang('Y_M_D');?></option>
                            </select>
                        </div>
                        <?php if (form_error('date_format')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('date_format'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="mb-3 col-md-6 col-lg-3">
                        <div class="form-group">
                            <label><?php echo lang('Time_Zone'); ?> <span class="required_star">*</span></label>
                            <select  class="form-control select2" id="zone_name" name="zone_name">
                                <option value=""><?php echo lang('select'); ?></option>
                                <?php
                                foreach ($zone_names as $zone_name) { ?>
                                    <option
                                    <?php echo isset($outlet_information) && $outlet_information->zone_name == $zone_name->zone_name ? 'selected' : '' ?> value="<?php echo escape_output($zone_name->zone_name) ?>">
                                    <?php echo escape_output($zone_name->zone_name) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <?php if (form_error('zone_name')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('zone_name'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="mb-3 col-md-6 col-lg-3">
                        <div class="form-group">
                            <label><?php echo lang('currency'); ?> <span class="required_star">*</span></label>
                            <input autocomplete="off" type="text" name="currency"
                            class="form-control" placeholder="<?php echo lang('currency'); ?>"
                            value="<?php echo escape_output($outlet_information->currency); ?>">
                        </div>
                        <?php if (form_error('currency')) { ?>
                        <div class="callout callout-danger my-2">
                            <?php echo form_error('currency'); ?>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="mb-3 col-md-6 col-lg-3">
                        <div class="form-group">
                            <label> <?php echo lang('Currency_Position'); ?> <span
                                class="required_star">*</span></label>
                                <select  class="form-control select2" name="currency_position"
                                id="currency_position">
                                <option
                                <?= isset($outlet_information) && $outlet_information->currency_position == "Before Amount" ? 'selected' : '' ?>
                                value="Before Amount"><?php echo lang('Before_Amount');?></option>
                                <option
                                <?= isset($outlet_information) && $outlet_information->currency_position == "After Amount" ? 'selected' : '' ?>
                                value="After Amount"><?php echo lang('After_Amount');?></option>
                            </select>
                        </div>
                        <?php if (form_error('currency_position')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('currency_position'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="mb-3 col-md-6 col-lg-3">

                        <div class="form-group">
                            <label> <?php echo lang('Precision'); ?></label>
                            <select  class="form-control select2" name="precision" id="precision">
                                <option
                                    <?= isset($outlet_information) && $outlet_information->precision == "" ? 'selected' : '' ?>
                                    value=""><?php echo lang('none');?></option>
                                <option
                                    <?= isset($outlet_information) && $outlet_information->precision == "1" ? 'selected' : '' ?>
                                    value="1"><?php echo lang('Digit_1');?></option>
                                <option
                                    <?= isset($outlet_information) && $outlet_information->precision == "2" ? 'selected' : '' ?>
                                    value="2"><?php echo lang('Digit_2');?></option>
                                <option
                                    <?= isset($outlet_information) && $outlet_information->precision == "3" ? 'selected' : '' ?>
                                    value="3"><?php echo lang('Digit_3');?></option>
                            </select>
                        </div>
                        <?php if (form_error('precision')) { ?>
                        <div class="callout callout-danger my-2">
                            <?php echo form_error('precision'); ?>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="mb-3 col-md-6 col-lg-3">
                        <div class="form-group">
                            <label> <?php echo lang('decimals_separator'); ?> <span
                                        class="required_star">*</span></label>
                            <select  class="form-control select2" name="decimals_separator"
                                    id="decimals_separator">
                                <option
                                    <?= isset($outlet_information) && $outlet_information->decimals_separator == "." ? 'selected' : '' ?>
                                        value="."><?php echo lang('separator_dot'); ?></option>
                                <option
                                    <?= isset($outlet_information) && $outlet_information->decimals_separator == "," ? 'selected' : '' ?>
                                        value=","><?php echo lang('separator_comma'); ?></option>
                                <option
                                    <?= isset($outlet_information) && $outlet_information->decimals_separator == " " ? 'selected' : '' ?>
                                        value=" "><?php echo lang('space'); ?></option>
                            </select>
                        </div>
                        <?php if (form_error('decimals_separator')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('decimals_separator'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="mb-3 col-md-6 col-lg-3">
                        <div class="form-group">
                            <label> <?php echo lang('thousands_separator'); ?></label>
                            <select  class="form-control select2" name="thousands_separator"
                                    id="thousands_separator">

                                <option
                                    <?= isset($outlet_information) && $outlet_information->thousands_separator == "" ? 'selected' : '' ?>
                                        value=""><?php echo lang('separator_none'); ?></option>
                                <option
                                    <?= isset($outlet_information) && $outlet_information->thousands_separator == "." ? 'selected' : '' ?>
                                        value="."><?php echo lang('separator_dot'); ?></option>
                                <option
                                    <?= isset($outlet_information) && $outlet_information->thousands_separator == "," ? 'selected' : '' ?>
                                        value=","><?php echo lang('separator_comma'); ?></option>
                                <option
                                    <?= isset($outlet_information) && $outlet_information->thousands_separator == " " ? 'selected' : '' ?>
                                        value=" "><?php echo lang('space'); ?></option>
                            </select>
                        </div>
                        <?php if (form_error('thousands_separator')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('thousands_separator'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    
                    
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label>
                                    <?php echo lang('installment_notification_days'); ?> 
                                    <span class="required_star">*</span>
                                </label>
                                <div class="ms-3 op_right op_font_18 op_cursor_pointer mb-4-px">
                                    <i data-tippy-content="<?php echo lang('How_many_days_before_installment_payment'); ?>" class="fa-regular fa-circle-question tippyBtnCall font-16 theme-color"></i>
                                </div>
                            </div>
                            <select  class="form-control select2" name="installment_days"
                                id="installment_days">
                                <option value="3" <?=($outlet_information->installment_days==3?'selected':'')?>><?php echo lang('Days_3'); ?></option>
                                <option value="7" <?=($outlet_information->installment_days==7?'selected':'')?>><?php echo lang('Days_7'); ?></option>
                                <option value="15" <?=($outlet_information->installment_days==15?'selected':'')?>><?php echo lang('Days_15'); ?></option>
                            </select>
                        </div>
                        <?php if (form_error('installment_days')) { ?>
                        <div class="callout callout-danger my-2">
                            <?php echo form_error('installment_days'); ?>
                        </div>
                        <?php } ?>
                    </div>
                    
                    
                    
                    
                    <div class="clearfix"></div>

                    
                    
                    <div class="clearfix"></div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label>
                                    <?php echo lang('api_token'); ?> 
                                    <span class="required_star">*</span> 
                                </label>
                                <div class="ms-3 op_right op_font_18 op_cursor_pointer mb-4-px">
                                    <i  data-tippy-content="<?php echo lang('api_token'); ?>" class="fa-regular fa-circle-question tippyBtnCall font-16 theme-color"></i>
                                </div> 
                            </div>
                            <div class="d-flex">
                                <input readonly autocomplete="off" type="text" id="api_key"
                                name="api_token" class="form-control integerchk m-0"
                                placeholder="<?php echo lang('api_token'); ?>"
                                value="<?php echo escape_output($outlet_information->api_token); ?>">
                                <button type="button" class="new-btn ms-2" id="generateKey">
                                <?php echo lang('Generate');?>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="form-group radio_button_problem">
                            <div class="d-flex align-items-center">
                                <label><?php echo lang('Register_Content'); ?> <span class="required_star">*</span></label>
                                <div class="ms-3 op_right op_font_18 op_cursor_pointer mb-4-px">
                                    <i data-tippy-content="<?php echo lang('direct_add_to_cart_msg'); ?>" class="fa-regular fa-circle-question tippyBtnCall font-16 theme-color"></i>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="expense_" value="Expense" name="register_expense" <?php echo isset($register_content->register_expense) && $register_content->register_expense == 'Expense' ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="expense_"><?php echo lang('expense');?></label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="purchase_" value="Purchase" name="register_purchase" <?php echo isset($register_content->register_purchase) && $register_content->register_purchase == 'Purchase' ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="purchase_"><?php echo lang('purchase');?></label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="purchase_return_" value="Purchase Return" name="register_purchase_return" <?php echo isset($register_content->register_purchase_return) && $register_content->register_purchase_return == 'Purchase Return' ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="purchase_return_"><?php echo lang('purchase_return');?></label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="supplier_payment_" value="Supplier Payment" name="register_supplier_payment" <?php echo isset($register_content->register_supplier_payment) && $register_content->register_supplier_payment == 'Supplier Payment' ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="supplier_payment_"><?php echo lang('supplier_payment');?></label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="sale_" value="Sale" name="register_sale" <?php echo isset($register_content->register_sale) && $register_content->register_sale == 'Sale' ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="sale_"><?php echo lang('sale');?></label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="sale_return_" value="Sale Return" name="register_sale_return" <?php echo isset($register_content->register_sale_return) && $register_content->register_sale_return == 'Sale Return' ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="sale_return_"><?php echo lang('sale_return');?></label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="installment_down_payment_" value="Installment Down Payment" name="register_installment_down_payment" <?php echo isset($register_content->register_installment_down_payment) && $register_content->register_installment_down_payment == 'Installment Down Payment' ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="installment_down_payment_"><?php echo lang('installment_down_payment');?></label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="installment_collection_" value="Installment Collection" name="register_installment_collection" <?php echo isset($register_content->register_installment_collection) && $register_content->register_installment_collection == 'Installment Collection' ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="installment_collection_"><?php echo lang('installment_collection');?></label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" value="Customer Due Receive" id="customer_due_receive_" name="register_customer_due_receive" <?php echo isset($register_content->register_customer_due_receive) && $register_content->register_customer_due_receive == 'Customer Due Receive' ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="customer_due_receive_"><?php echo lang('customer_due_receive');?></label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="servicing_" value="Servicing" name="register_servicing" <?php echo isset($register_content->register_servicing) && $register_content->register_servicing == 'Servicing' ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="servicing_"><?php echo lang('servicing');?></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <h3 class="top-left-header pt-3">POS Setting</h3>
                <hr>
                <div class="row">
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('Allow_Overselling'); ?> <span class="required_star">*</span></label>
                            <select class="form-control select2" name="allow_less_sale">
                                <option
                                <?=$outlet_information->allow_less_sale && $outlet_information->allow_less_sale=="Yes"?'selected':''?>
                                value="Yes"><?php echo lang('yes');?></option>
                                <option
                                <?=$outlet_information->allow_less_sale && $outlet_information->allow_less_sale=="No"?'selected':''?>
                                value="No"><?php echo lang('no');?></option>
                            </select>

                        </div>
                        <?php if (form_error('allow_less_sale')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('allow_less_sale'); ?></span>
                            </div>
                        <?php } ?>

                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <label> <?php echo lang('Default_Customer'); ?> <span class="required_star">*</span></label>
                            <select  class="form-control select2" name="default_customer" id="default_customer">
                                <option value=""><?php echo lang('select'); ?></option>
                                <?php
                                foreach ($customers as $value1){
                                ?>
                                    <option <?=($outlet_information->default_customer == $value1->id ? 'selected':'')?> value="<?=escape_output($value1->id)?>"><?=escape_output($value1->name)?></option>
                                <?php
                                }
                            ?>
                            </select>
                        </div>
                            <?php if (form_error('default_customer')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('default_customer'); ?>
                            </div>
                            <?php } ?>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <label> <?php echo lang('Default_Payment_Method'); ?> <span class="required_star">*</span></label>
                            <select  class="form-control select2" name="default_payment"
                                id="default_payment">
                                <option value=""><?php echo lang('select'); ?></option>
                                <?php
                            foreach ($paymentMethods as $value){
                                ?>
                                <option
                                    <?=($outlet_information->default_payment==$value->id?'selected':'')?>
                                    value="<?=escape_output($value->id)?>"><?=escape_output($value->name)?>
                                </option>
                                <?php
                            }
                            ?>
                            </select>
                        </div>
                        <?php if (form_error('default_payment')) { ?>
                        <div class="callout callout-danger my-2">
                            <?php echo form_error('default_payment'); ?>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label><?php echo lang('Rounding'); ?></label>
                                <div class="ms-3 op_right op_font_18 op_cursor_pointer mb-4-px">
                                    <i data-tippy-content="<?php echo lang('rounding_note'); ?>" class="fa-regular fa-circle-question tippyBtnCall font-16 theme-color"></i>
                                </div>
                            </div>

                            <select  class="form-control select2" name="pos_total_payable_type"
                                id="pos_total_payable_type">
                                <option value="0" <?=($outlet_information->pos_total_payable_type== 0 ?'selected':'')?>>
                                    <?php echo lang('none'); ?>
                                </option>
                                <option value="1" <?=($outlet_information->pos_total_payable_type== 1 ?'selected':'')?>>
                                    <?php echo lang('round_whole_number'); ?>
                                </option>
                                <option value="0.05" <?=($outlet_information->pos_total_payable_type == 0.05 ? 'selected':'')?>>
                                    <?php echo lang('round_decimal_number_0_05'); ?>
                                </option>
                                <option value="0.01" <?=($outlet_information->pos_total_payable_type == 0.01 ? 'selected':'')?>>
                                    <?php echo lang('round_decimal_number_1'); ?>
                                </option>
                                <option value="0.5" <?=($outlet_information->pos_total_payable_type == 0.5 ? 'selected':'')?>>
                                    <?php echo lang('round_decimal_number_0_5'); ?>
                                </option>
                            </select>
                        </div>
                        <?php if (form_error('pos_total_payable_type')) { ?>
                        <div class="callout callout-danger my-2">
                            <?php echo form_error('pos_total_payable_type'); ?>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('default_cursor_position'); ?> <span
                                    class="required_star">*</span></label>
                            <select  class="form-control select2" name="default_cursor_position"
                                id="default_cursor_position" <?php echo APPLICATION_MODE == 'demo' && APPLICATION_DEMO_TYPE == 'Pharmacy' ? 'disabled' : '';?>>
                                <option value="Search Box" <?=($outlet_information->default_cursor_position== 'Search Box' ? 'selected':'')?>><?php echo lang('Search_Box'); ?></option>
                                <option value="Barcode Box" <?=($outlet_information->default_cursor_position== 'Barcode Box' ?'selected':'')?>><?php echo lang('Barcode_Box'); ?></option>
                            </select>
                        </div>
                        <?php if (form_error('default_cursor_position')) { ?>
                        <div class="callout callout-danger my-2">
                            <?php echo form_error('default_cursor_position'); ?>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('Display_Product'); ?> <span
                                    class="required_star">*</span></label>
                            <select  class="form-control select2" name="product_display"
                                id="product_display">
                                <option value="Image View" <?=($outlet_information->product_display== 'Image View' ? 'selected':'')?>><?php echo lang('Image_View'); ?></option>
                                <option value="Box View" <?=($outlet_information->product_display== 'Box View' ?'selected':'')?>><?php echo lang('Box_View'); ?></option>
                            </select>
                        </div>
                        <?php if (form_error('product_display')) { ?>
                        <div class="callout callout-danger my-2">
                            <?php echo form_error('product_display'); ?>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('onscreen_keyboard_status'); ?> <span
                                    class="required_star">*</span></label>
                            <select  class="form-control select2" name="onscreen_keyboard_status"
                                id="onscreen_keyboard_status">
                                <option value="Enable" <?=($outlet_information->onscreen_keyboard_status== 'Enable' ? 'selected':'')?>><?php echo lang('enable'); ?></option>
                                <option value="Disable" <?=($outlet_information->onscreen_keyboard_status== 'Disable' ?'selected':'')?>><?php echo lang('disable'); ?></option>
                            </select>
                        </div>
                        <?php if (form_error('onscreen_keyboard_status')) { ?>
                        <div class="callout callout-danger my-2">
                            <?php echo form_error('onscreen_keyboard_status'); ?>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('inv_no_start_from'); ?> <span class="required_star">*</span></label>
                            <input type="text" class="form-control integerchk" name="inv_no_start_from" placeholder="<?php echo lang('inv_no_start_from') ?>" value="<?php echo escape_output($outlet_information->inv_no_start_from)?>" maxlength="10">  
                        </div>
                        <?php if (form_error('inv_no_start_from')) { ?>
                        <div class="callout callout-danger my-2">
                            <?php echo form_error('inv_no_start_from'); ?>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('POS_Experience'); ?> <span class="required_star">*</span></label>
                            <select class="select2" name="grocery_experience" <?php echo APPLICATION_MODE == 'demo' ? 'disabled' : '';?>>
                                <option value=""><?php echo lang('POS_Experience'); ?></option>
                                <option value="Regular" <?php echo $outlet_information->grocery_experience == 'Regular' ? 'selected' : ''?>><?php echo lang('Regular'); ?></option>
                                <option value="Medicine" <?php echo $outlet_information->grocery_experience == 'Medicine' ? 'selected' : ''?>><?php echo lang('Medicine'); ?></option>
                                <option value="Grocery" <?php echo $outlet_information->grocery_experience == 'Grocery' ? 'selected' : ''?>><?php echo lang('Grocery'); ?></option>
                            </select>
                        </div>
                        <?php if (form_error('grocery_experience')) { ?>
                        <div class="callout callout-danger my-2">
                            <?php echo form_error('grocery_experience'); ?>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group radio_button_problem">
                            <div class="d-flex align-items-center">
                                <label><?php echo lang('Direct_Add_To_Cart'); ?> <span class="required_star">*</span></label>
                                <div class="ms-3 op_right op_font_18 op_cursor_pointer mb-4-px">
                                    <i data-tippy-content="<?php echo lang('direct_add_to_cart_msg'); ?>" class="fa-regular fa-circle-question tippyBtnCall font-16 theme-color"></i>
                                </div>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="direct_cart"
                                        value="Yes" <?php echo escape_output($outlet_information->direct_cart) === 'Yes' ? 'checked' : '' ?>><?php echo lang('yes'); ?>
                                </label>
                                <label>
                                    <input type="radio" name="direct_cart"
                                        value="No" <?php echo escape_output($outlet_information->direct_cart) === 'No' ? 'checked' : '' ?>>
                                        <?php echo lang('no'); ?> 
                                </label>
                            </div>
                        </div>
                    </div>

                    
                </div>

                <h3 class="top-left-header pt-3">Item Setting</h3>
                <hr>

                <div class="row">
                    <div class="mb-3 col-sm-12 col-md-4 col-lg-3">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label>
                                    <?php echo lang('loyalty_point'); ?> <span class="required_star">*</span>
                                </label>
                                <div class="ms-3 op_right op_font_18 op_cursor_pointer mb-4-px">
                                    <i data-tippy-content="<?php echo lang('is_loyalty_enable_tooltip'); ?>" class="fa-regular fa-circle-question tippyBtnCall font-16 theme-color"></i>
                                </div>
                            </div>
                            <select tabindex="12" class="form-control select2" name="is_loyalty_enable"
                                    id="is_loyalty_enable">
                                <option
                                    <?= isset($outlet_information) && $outlet_information->is_loyalty_enable == "disable" ? 'selected' : '' ?>
                                        value="disable"><?php echo lang('disable'); ?></option>
                                <option
                                    <?= isset($outlet_information) && $outlet_information->is_loyalty_enable == "enable" ? 'selected' : '' ?>
                                        value="enable"><?php echo lang('enable'); ?></option>
                            </select>
                        </div>
                        <?php if (form_error('is_loyalty_enable')) { ?>
                        <div class="callout callout-danger my-2">
                            <?php echo form_error('is_loyalty_enable'); ?>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="mb-3 col-sm-12 col-md-4 col-lg-3 div_loyalty">
                        <div class="form-group">
                            <label>
                                <?php echo lang('minimum_point_to_redeem'); ?> 
                            </label>
                            <input autocomplete="off" type="number" id="minimum_point_to_redeem"
                                    name="minimum_point_to_redeem" class="form-control"
                                    placeholder="<?php echo lang('minimum_point_to_redeem'); ?>"
                                    value="<?php echo escape_output($outlet_information->minimum_point_to_redeem); ?>">
                        </div>
                        <?php if (form_error('minimum_point_to_redeem')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('minimum_point_to_redeem'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="mb-3 col-sm-12 col-md-4 col-lg-3 div_loyalty">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label>
                                    <?php echo lang('loyalty_rate'); ?> 
                                </label>
                                <div class="ms-3 op_right op_font_18 op_cursor_pointer mb-4-px">
                                    <i data-tippy-content="<?php echo lang('loyalty_rate_tooltip'); ?>" class="fa-regular fa-circle-question tippyBtnCall font-16 theme-color"></i>
                                </div> 
                            </div>
                            <input autocomplete="off" type="text" id="loyalty_rate"
                                    name="loyalty_rate" class="form-control integerchk"
                                    placeholder="<?php echo lang('loyalty_rate'); ?>"
                                    value="<?php echo escape_output($outlet_information->loyalty_rate); ?>">
                        </div>
                        <?php if (form_error('loyalty_rate')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('loyalty_rate'); ?>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('product_code_start_from'); ?> <span class="required_star">*</span></label>
                            <input type="text" class="form-control integerchk" name="product_code_start_from" placeholder="<?php echo lang('product_code_start_from') ?>" value="<?php echo escape_output($outlet_information->product_code_start_from)?>" maxlength="10">  
                        </div>
                        <?php if (form_error('product_code_start_from')) { ?>
                        <div class="callout callout-danger my-2">
                            <?php echo form_error('product_code_start_from'); ?>
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
            </div>
        <?php echo form_close(); ?>
        </div>
    </div>
</div>




<div id="show_how_tax_title_works_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo lang('how_tax_title_works'); ?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>
                    <?php echo lang('Which_will_be_shown_in_Invoice');?>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-blue-btn" data-bs-dismiss="modal"><?php echo lang('close');?></button>
            </div>
        </div>
    </div>
</div>

<div id="what_will_happen_if_i_say_yes_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo lang('if_i_say_yes');?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>
                    <?php echo lang('You_will_get_two_additional_reports');?>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-blue-btn" data-bs-dismiss="modal"><?php echo lang('close');?></button>
            </div>
        </div>
    </div>
</div>

<div id="show_how_tax_fields_work_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo lang('how_tax_fields_work');?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>
                    <?php echo lang('All_of_these_input_fields_will_be_appeared');?>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-blue-btn" data-bs-dismiss="modal"><?php echo lang('close');?></button>
            </div>
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
                $logoPath = !empty($outlet_information->invoice_logo) ? base_url().'uploads/site_settings/'.$outlet_information->invoice_logo : '';
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