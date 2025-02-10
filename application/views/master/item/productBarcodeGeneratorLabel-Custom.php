<?php
$barcode_setting = getBarcodeSetting();
if($barcode_setting){
    $barcode_setting = json_decode($barcode_setting);
}else{
    $barcode_setting = '';
}
// pre($barcode_setting);
?>

<script src="<?php echo base_url(); ?>assets/plugins/barcode/JsBarcode.all.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>frequent_changing/css/print_barcode.css">
<div class="main-content-wrapper">

    <div class="ajax-message"></div>


    
    <section class="content-header"> 
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header"><?php echo lang('print_label'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('item'), 'secondSection'=> lang('print_label')])?>
        </div>
    </section>



    <div class="box-wrapper"> 
        <div class="table-box">
            <div class="box-body">
                <h5><?php echo lang('Barcode_Label_Setting');?></h5>
                <div class="row">
                    <div class="col-md-6 d-flex flex-column mb-3">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="hide_product_name" value="Yes" name="hide_product_name" <?php echo isset($barcode_setting) && $barcode_setting ? ($barcode_setting->hide_product_name == "true" ? 'checked' : '') : ''?>>
                            <label class="form-check-label" for="hide_product_name"><?php echo lang('Hide_Product_Name');?></label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="hide_product_code" value="Yes" name="hide_product_code" <?php echo isset($barcode_setting) && $barcode_setting ? ($barcode_setting->hide_product_code == "true" ? 'checked' : '') : ''?>>
                            <label class="form-check-label" for="hide_product_code"><?php echo lang('Hide_Product_Code');?></label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="hide_product_price" value="Yes" name="hide_product_price" <?php echo isset($barcode_setting) && $barcode_setting ? ($barcode_setting->hide_product_price == "true" ? 'checked' : '') : ''?>>
                            <label class="form-check-label" for="hide_product_price"><?php echo lang('Hide_Product_Price');?></label>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex flex-column mb-3">
                        <div class="d-flex">
                            <span class="me-2 op_margin_top_2">
                                <iconify-icon class="product_name_font_size_plus cursor-pointer" icon="solar:add-circle-broken" width="24" height="24" />
                            </span>
                            <span class="me-2 op_margin_top_2">
                                <iconify-icon class="product_name_font_size_minus cursor-pointer" icon="solar:minus-circle-broken" width="24" height="24" />
                            </span>
                            <p><?php echo lang('Product_Name_Font_Size');?></p>
                        </div>
                        <div class="d-flex">
                            <span class="me-2 op_margin_top_2">
                                <iconify-icon class="product_code_font_size_plus cursor-pointer" icon="solar:add-circle-broken" width="24" height="24" />
                            </span>
                            <span class="me-2 op_margin_top_2">
                                <iconify-icon class="product_code_font_size_minus cursor-pointer" icon="solar:minus-circle-broken" width="24" height="24" />
                            </span>
                            <p><?php echo lang('Product_Code_Font_Size');?></p>
                        </div>
                        <div class="d-flex">
                            <span class="me-2 op_margin_top_2">
                                <iconify-icon class="product_price_font_size_plus cursor-pointer" icon="solar:add-circle-broken" width="24" height="24" />
                            </span>
                            <span class="me-2 op_margin_top_2">
                                <iconify-icon class="product_price_font_size_minus cursor-pointer" icon="solar:minus-circle-broken" width="24" height="24" />
                            </span>
                            <p><?php echo lang('Product_Price_Font_Size');?></p>
                        </div>
                    </div>
                </div>

                <div class="d-flex mb-4">
                    <button type="submit" name="submit" value="submit" class="btn bg-blue-btn me-2" id="save_settings">
                        <iconify-icon icon="solar:upload-minimalistic-broken" class="op_margin_right_5"></iconify-icon>
                        <span><?php echo lang('Save_Settings');?></span>
                    </button>
                    <button type="button" class="btn bg-blue-btn" id="resent_default">
                        <iconify-icon icon="solar:refresh-broken" class="op_margin_right_5"></iconify-icon>
                        <span><?php echo lang('Reset_Settings');?></span>
                    </button>
                </div>


                <h5><?php echo lang('Each_image_will_be_printed_on_separate_page'); ?></h5>
                <div id="printableArea">
                    <div class="">
                        <?php
                        $total_item_count = sizeof($items);
                        for ($i = 0; $i < $total_item_count; $i++):   
                        for ($j = 0;
                                $j < $items[$i]['qty'];
                                $j++):
                            ?>
                            <div class="text-center border-1-default p-21" style="line-height: 0.5;">
                                <div class="product_name" style="display: <?php echo isset($barcode_setting) && $barcode_setting ? ($barcode_setting->hide_product_name == "true" ? 'none' : 'block') : ''?>;">
                                    <?php if($items[$i]['parent_id'] != 0) { ?>
                                        <span style="font-size: <?php echo isset($barcode_setting) && $barcode_setting ? $barcode_setting->name_font_size : '8'?>px; line-height: 1.2; padding-left: 14px;" d-font-size="<?php echo isset($barcode_setting) && $barcode_setting ? $barcode_setting->name_font_size : '8'?>" c-font-size="<?php echo isset($barcode_setting) && $barcode_setting ? $barcode_setting->name_font_size : '8'?>"><?= limit_string(getItemNameById($items[$i]['parent_id']), 30) ?></span>
                                    <?php } ?> 
                                    <span style="font-size: <?php echo isset($barcode_setting) && $barcode_setting ? $barcode_setting->name_font_size : '8'?>px; line-height: 1.2; padding-left: 14px;" d-font-size="<?php echo isset($barcode_setting) && $barcode_setting ? $barcode_setting->name_font_size : '8'?>" c-font-size="<?php echo isset($barcode_setting) && $barcode_setting ? $barcode_setting->name_font_size : '8'?>"><?= limit_string($items[$i]['item_name'], 30) ?></span>
                                     <?php if($items[$i]['parent_id'] != 0) { ?>
                                        (<span><?= $items[$i]['code'] ?></span>)
                                    <?php } ?>
                                </div>
                                <div>
                                    <img class="op__min_width_139" id="barcode<?= $items[$i]['id'] ?><?= $j ?>">
                                </div>
                                <div class="text-center item_description1">
                                   <p class="product_code" style="display: <?php echo isset($barcode_setting) && $barcode_setting ? ($barcode_setting->hide_product_code == "true" ? 'none' : 'block') : 'block'?>; font-size: <?php echo isset($barcode_setting) && $barcode_setting ? $barcode_setting->code_font_size : '10'?>px; line-height: 19px;" d-font-size="<?php echo isset($barcode_setting) && $barcode_setting ? $barcode_setting->code_font_size : '10'?>" c-font-size="<?php echo isset($barcode_setting) && $barcode_setting ? $barcode_setting->code_font_size : '10'?>"><?= $items[$i]['code'] ?></p>

                                   <p class="font-700 product_price" style="display: <?php echo isset($barcode_setting) && $barcode_setting ? ($barcode_setting->hide_product_price == "true" ? 'none' : 'block') : 'block'?>; font-size: <?php echo isset($barcode_setting) && $barcode_setting ? $barcode_setting->price_font_size : '16'?>px;line-height: 0px; padding-top: 0px;padding-bottom: 0px;" d-font-size="<?php echo isset($barcode_setting) && $barcode_setting ? $barcode_setting->price_font_size : '16'?>" c-font-size="<?php echo isset($barcode_setting) && $barcode_setting ? $barcode_setting->price_font_size : '16'?>"><?= getAmtCustom($items[$i]['sale_price']) ?></p>
                                </div>
                            </div>
                            <div style="page-break-after: always;"></div>
                        <?php
                        endfor;
                        ?>
                        <?php for ($j = 0;
                        $j < $items[$i]['qty'];
                        $j++):
                        ?>
                            <script>
                            // inline js used for dynamic barcode generate
                            JsBarcode("#barcode<?=$items[$i]['id']?><?=$j?>", "<?=$items[$i]['code']?>", {
                                    width: 1,
                                    height: 30,
                                    fontSize: 12,
                                    textMargin: -18,
                                    margin: 0,
                                    marginTop: 0,
                                    marginLeft: 10,
                                    marginRight: 10,
                                    marginBottom: 0,
                                    displayValue: false
                                });
                            </script>
                        <?php
                        endfor;
                        endfor;
                        ?>
                    </div>
                </div>                      
            </div>
            <div class="box-footer">
                <a id="print_trigger" class="btn bg-blue-btn me-2">
                    <iconify-icon icon="solar:printer-2-broken"></iconify-icon>
                    <?php echo lang('Print');?>
                </a>
                <a class="btn bg-blue-btn" href="<?php echo base_url() ?>Item/itemBarcodeGeneratorLabel">
                    <iconify-icon icon="solar:undo-left-round-broken"></iconify-icon>
                    <?php echo lang('back'); ?>
                </a>
            </div>
        </div>
    </div>
</div>


<script src="<?php echo base_url(); ?>frequent_changing/js/print_trigger.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/barcode_label.js"></script>