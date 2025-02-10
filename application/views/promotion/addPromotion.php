<script src="<?php echo base_url('frequent_changing/js/add_promotion.js'); ?>"></script>
<section class="main-content-wrapper">
<h3 class="display_none">&nbsp;</h3>
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
                <h3 class="top-left-header mt-2"><?php echo lang('add_promotion'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('promotion'), 'secondSection'=> lang('add_promotion')])?>
        </div>
    </section>


    <div class="box-wrapper">
        <!-- general form elements -->
        <div class="table-box">
            <?php echo form_open(base_url() . 'Promotion/addEditPromotion', $arrayName = array('id' => 'promotion_form')) ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12 mb-3 col-md-3">
                        <div class="form-group">
                            <label><?php echo lang('type'); ?> <span class="required_star">*</span></label>
                            <select class="form-control select2 type" name="type" id="type">
                                <option value=""><?php echo lang('select'); ?></option>
                                <option value="1" <?php echo set_select('type',1)?>><?php echo lang('discount'); ?></option>
                                <option value="3" <?php echo set_select('type',3)?>><?php echo lang('discount_coupon_entire'); ?></option>
                                <option value="2" <?php echo set_select('type',2)?>><?php echo lang('free_item'); ?></option>
                            </select>
                        </div>
                        <?php if (form_error('type')) { ?>
                        <div class="callout callout-danger my-2">
                            <?php echo form_error('type'); ?>
                        </div>
                        <?php } ?>
                    </div>

                    <div class="col-sm-12 mb-3 col-md-3">
                        <div class="form-group">
                            <label><?php echo lang('title'); ?> <span class="required_star">*</span></label>
                            <input  type="text" id="title" name="title" class="form-control"
                                placeholder="eg: Black friday offer" value="<?php echo set_value('title'); ?>">
                        </div>
                        <?php if (form_error('title')) { ?>
                        <div class="callout callout-danger my-2">
                            <?php echo form_error('title'); ?>
                        </div>
                        <?php } ?>

                    </div>

                    <div class="col-sm-12 mb-3 col-md-3">
                        <div class="form-group">
                            <label><?php echo lang('start_date'); ?> <span class="required_star">*</span></label>
                            <input  type="text"  name="start_date" readonly class="form-control customDatepicker"
                                placeholder="<?php echo lang('start_date'); ?>" value="<?php echo date("Y-m-d",strtotime('today')); ?>">
                        </div>
                        <?php if (form_error('start_date')) { ?>
                        <div class="callout callout-danger my-2">
                            <?php echo form_error('start_date'); ?>
                        </div>
                        <?php } ?>

                    </div>
                    <div class="col-sm-12 mb-3 col-md-3">
                        <div class="form-group">
                            <label><?php echo lang('end_date'); ?> <span class="required_star">*</span></label>
                            <input  type="text"  name="end_date" readonly class="form-control customDatepicker"
                                placeholder="<?php echo lang('end_date'); ?>" value="<?php echo set_value('end_date'); ?>">
                        </div>
                        <?php if (form_error('end_date')) { ?>
                        <div class="callout callout-danger my-2">
                            <?php echo form_error('end_date'); ?>
                        </div>
                        <?php } ?>

                    </div>
                    <div class="col-sm-12 mb-3 col-md-3 display_none discount_div">
                        <div class="form-group select_promotion">
                            <label><?php echo lang('items'); ?> <span class="required_star">*</span></label>
                            <select  class="form-control select2 " name="food_menu_id"
                                id="food_menu_id">
                                <option value=""><?php echo lang('select'); ?></option>
                                <?php
                                foreach ($items as $value) {
                                ?>
                                <option <?php echo set_select('food_menu_id',$value->id)?> value="<?php echo escape_output($value->id) ?>">
                                <?php 
                                $string = ($value->parent_name != '' ? $value->parent_name . ' - ' : '') . ($value->name) . ($value->brand_name != '' ? ' - ' . $value->brand_name : '') . ( ' - ' . $value->code);  
                                echo escape_output($string);
                                ?>
                                </option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <?php if (form_error('food_menu_id')) { ?>
                        <div class="callout callout-danger my-2">
                            <?php echo form_error('food_menu_id'); ?>
                        </div>
                        <?php } ?>
                    </div>

                    <div class="col-sm-12 mb-3 col-md-3 display_none coupon_code">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label>
                                    <?php echo lang('coupon_code'); ?> <span class="required_star">*</span>
                                </label>
                                <div class="ms-3 op_right op_font_18 op_cursor_pointer mb-4-px">
                                    <i data-tippy-content="<?php echo lang('coupon_code_guide'); ?>" class="fa-regular fa-circle-question tippyBtnCall font-16 theme-color"></i>
                                </div> 
                            </div>
                            <input  type="text" name="coupon_code"  class="form-control"
                                    placeholder="<?php echo lang('coupon_code');?>" value="<?php echo set_value('coupon_code'); ?>">
                        </div>
                        <?php if (form_error('coupon_code')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('coupon_code'); ?>
                            </div>
                        <?php } ?>

                    </div>

                

                    <div class="col-sm-12 mb-3 col-md-3 discount_both">
                        <div class="form-group">
                            <label><?php echo lang('discount_pro'); ?> <span class="required_star">*</span></label>
                            <input  type="text" name="discount"  class="form-control"
                                    placeholder="<?php echo lang('discount_type');?>" value="<?php echo set_value('discount'); ?>">
                        </div>
                        <?php if (form_error('discount')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('discount'); ?>
                            </div>
                        <?php } ?>

                    </div>

                    <div class="clearfix"></div>
                    <div class="col-sm-12 mb-3 col-md-3 display_none free_item_div">
                        <div class="form-group select_promotion">
                            <label><?php echo lang('buy'); ?> <span class="required_star">*</span></label>
                            <select  class="form-control select2 " name="buy_food_menu_id"
                                    id="buy_food_menu_id">
                                <option value=""><?php echo lang('select'); ?></option>
                                <?php foreach ($items as $value) {  ?>
                                    <option <?php echo set_select('buy_food_menu_id',$value->id)?> value="<?php echo escape_output($value->id) ?>">
                                    <?php 
                                    $string = ($value->parent_name != '' ? $value->parent_name . ' - ' : '') . ($value->name . ' - ' . $value->code) . ($value->brand_name != '' ? ' - ' . $value->brand_name : ''); 
                                    echo escape_output($string);
                                    ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <?php if (form_error('buy_food_menu_id')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('buy_food_menu_id'); ?>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="col-sm-12 mb-3 col-md-3 display_none free_item_div">
                        <div class="form-group">
                            <label><?php echo lang('buy'); ?> <?php echo lang('quantity'); ?> <span class="required_star">*</span></label>
                            <input  type="text" name="qty" class="form-control integerchk"
                                    placeholder="<?php echo lang('buy'); ?> <?php echo lang('quantity'); ?>" value="<?php echo set_value('qty'); ?>">
                        </div>
                        <?php if (form_error('qty')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('qty'); ?>
                            </div>
                        <?php } ?>
                    </div>


                    <div class="col-sm-12 mb-3 col-md-3 display_none free_item_div">
                        <div class="form-group select_promotion">
                            <label><?php echo lang('get'); ?> <span class="required_star">*</span></label>
                            <select  class="form-control select2 " name="get_food_menu_id"
                                    id="get_food_menu_id">
                                <option value=""><?php echo lang('select'); ?></option>
                                <?php
                                foreach ($items as $value) {
                                ?>
                                <option <?php echo set_select('get_food_menu_id',$value->id)?> value="<?php echo escape_output($value->id) ?>">
                                <?php 
                                $string = ($value->parent_name != '' ? $value->parent_name . ' - ' : '') . ($value->name . ' - ' . $value->code) . ($value->brand_name != '' ? ' - ' . $value->brand_name : ''); 
                                echo escape_output($string);
                                ?>
                                </option> 
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <?php if (form_error('get_food_menu_id')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('get_food_menu_id'); ?>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="col-sm-12 mb-3 col-md-3 display_none free_item_div">
                        <div class="form-group">
                            <label><?php echo lang('get'); ?> <?php echo lang('quantity'); ?> <span class="required_star">*</span></label>
                            <input  type="text" name="get_qty" class="form-control integerchk"
                                    placeholder="<?php echo lang('get'); ?> <?php echo lang('quantity'); ?>" value="<?php echo set_value('get_qty'); ?>">
                        </div>
                        <?php if (form_error('get_qty')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('get_qty'); ?>
                            </div>
                        <?php } ?>

                    </div>
                    <div class="col-sm-12 mb-3 col-md-3">
                        <div class="form-group">
                            <label><?php echo lang('status'); ?></label>
                            <select class="form-control select2 status" name="status" id="status">
                                <option value="1" <?php echo set_select('status',1)?>><?php echo lang('Active'); ?></option>
                                <option value="2" <?php echo set_select('status',2)?>><?php echo lang('Inactive'); ?></option>
                            </select>
                        </div>
                        <?php if (form_error('reference_no')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('reference_no'); ?>
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
                <a class="btn bg-blue-btn text-decoration-none" href="<?php echo base_url() ?>Promotion/promotions">
                    <iconify-icon icon="solar:undo-left-round-broken"></iconify-icon>
                    <?php echo lang('back'); ?>
                </a>
            </div>

            <?php echo form_close(); ?>
        </div>
    </div>
</section>