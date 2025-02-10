<script src="<?php echo base_url(); ?>assets/plugins/barcode/JsBarcode.all.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>frequent_changing/css/print_barcode.css">
<div class="main-content-wrapper">

    
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
                                <div>
                                    <?php if($items[$i]['parent_id'] != 0) { ?>
                                        <span style="font-size: 8px;line-height: 1.2; padding-left: 14px;"><?= limit_string(getItemNameById($items[$i]['parent_id']), 25) ?></span>
                                    <?php } ?>
                                    <span style="font-size: 8px;line-height: 1.2; padding-left: 14px;"><?= limit_string($items[$i]['item_name'], 25) ?></span>
                                     <?php if($items[$i]['parent_id'] != 0) { ?>
                                        (<span><?= $items[$i]['code'] ?></span>)
                                    <?php } ?>
                                </div>
                                <div>
                                    <img class="op__min_width_139" id="barcode<?= $items[$i]['id'] ?><?= $j ?>">
                                </div>
                                <div class="text-center item_description1">
                                   <p style="font-size: 10px; line-height: 19px;"><?= $items[$i]['code'] ?></p>
                                   <p class="font-700" style="font-size: 16px;line-height: 0px; padding-top: 0px;padding-bottom: 0px;"><?= getAmtCustom($items[$i]['sale_price']) ?></p>
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
                <a id="print_trigger" class="btn bg-blue-btn"><?php echo lang('Print');?></a>
                <a class="btn bg-blue-btn" href="<?php echo base_url() ?>Item/itemBarcodeGeneratorLabel"><?php echo lang('back'); ?></a>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>frequent_changing/js/print_trigger.js"></script>
