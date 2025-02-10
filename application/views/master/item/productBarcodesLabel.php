
<?php

if ($this->session->flashdata('exception')) {
    echo '<section class="alert-wrapper"><div class="alert alert-success alert-dismissible fade show"> 
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></button>
    <i class="fa fa-check"></i>';
    echo escape_output($this->session->flashdata('exception'));unset($_SESSION['exception']);
    echo '</div></div></section>';
}
?>
<link rel="stylesheet" href="<?= base_url()?>frequent_changing/css/checkBotton2.css">

<section class="main-content-wrapper">
<h3 class="display_none">&nbsp;</h3>

    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header"><?php echo lang('Print_Labels'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('item'), 'secondSection'=> lang('Print_Labels')])?>
        </div>
    </section>



    <div class="box-wrapper">
        <?php echo form_open(base_url() . 'Item/itemBarcodeGeneratorLabel', $arrayName = array('id' => 'productBarcodeGenerator', 'enctype' => 'multipart/form-data')) ?>
        <div class="table-box">
            <div class="box-body" id="item_barcode_design">
                <table id="datatable" class="table table-bordered dataTable table-striped">
                    <thead>
                    <tr>
                        <th class="w-10">
                            <label class="container op_width_89_p"> <?php echo lang('select_all'); ?>
                                <input class="checkbox_userAll" type="checkbox" id="checkbox_userAll">
                                <span class="checkmark"></span>
                            </label>
                        </th>
                        <th class="w-16"><?php echo lang('name'); ?></th>
                        <th class="w-2"><?php echo lang('code'); ?></th>
                        <th class="w-10"><?php echo lang('category'); ?></th>
                        <th class="w-7"><?php echo lang('sale_price'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($items && !empty($items)) {
                        $i = count($items);
                    }
                    foreach ($items as $ingrnts) {
                        ?>
                        <tr>
                            <td class="op_center">
                                <div class="d-flex">
                                    <div>
                                        <label class="container"><?php echo lang('select'); ?>
                                            <input type="checkbox"  class="checkbox_user" data-menu_id="<?=$ingrnts->id?>" value="<?=$ingrnts->id."|".$ingrnts->name."|".$ingrnts->code."|".$ingrnts->sale_price ."|".$ingrnts->parent_id?>" name="item_id[]"?>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div>
                                        <input class="op_width_100_p op_center" disabled type="number" min="1" id="qty<?=$ingrnts->id?>" name="qty[]" value="">
                                    </div>
                                </div>
                            </td>
                            <td>
                                <?php 
                                if($ingrnts->parent_id != 0){
                                    echo getItemNameById($ingrnts->parent_id) . "-";
                                }
                                echo  escape_output($ingrnts->name) ?>
                            </td>
                            <td><?php echo escape_output($ingrnts->code); ?></td>
                            <td><?php echo categoryName($ingrnts->category_id); ?></td>
                            <td><?php echo getAmtCustom($ingrnts->sale_price); ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <div class="box-footer">
                <button type="submit" name="submit" value="submit" class="btn bg-blue-btn">
                    <iconify-icon icon="solar:upload-minimalistic-broken"></iconify-icon>
                    <?php echo lang('submit'); ?>
                </button>
                <a class="btn bg-blue-btn" href="<?php echo base_url() ?>Item/items">
                    <iconify-icon icon="solar:undo-left-round-broken"></iconify-icon>
                    <?php echo lang('back'); ?>
                </a>
            </div>
        </div>

        
        <?php echo form_close(); ?>
    </div>
</section>
<!-- DataTables -->
<?php $this->load->view('updater/reuseJs') ?>
<script src="<?php echo base_url(); ?>frequent_changing/js/productBarcodeLabel.js"></script>
