<input type="hidden" id="stock_value_tooltip" value="<?php echo lang('stock_value_tooltip');?>">
<input type="hidden" id="The_items_field_is_required" value="<?php echo lang('The_items_field_is_required');?>">
<input type="hidden" id="The_outlet_field_is_required" value="<?php echo lang('The_outlet_field_is_required');?>">

<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/stock.css">
<div class="main-content-wrapper">

    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header"><?php echo lang('stock'); ?></h3>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('stock'); ?>" data-id_name="datatable">
                <div class="btn_list m-right d-flex">
                    <a href="<?= base_url() . 'Stock/getStockAlertList' ?>" class="new-btn me-1">
                        <iconify-icon icon="solar:danger-triangle-broken" width="22"></iconify-icon>
                        <?php echo lang('items_alert'); ?>
                    </a>
                    <button type="button" class="dataFilterBy new-btn"><iconify-icon icon="solar:filter-broken"  width="22"></iconify-icon> <?php echo lang('filter_by');?></button>
                </div>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('stock'), 'secondSection'=> lang('stock')])?>
        </div>
    </section>


    <div class="box-wrapper">
        <div class="table-box">
            <!-- /.box-header -->
            <div class="table-responsive">
                <table id="datatable" class="table table-bordered table-striped stock-list">
                    <thead>
                        <tr>
                            <th class="title w-5"><?php echo lang('sn'); ?></th>
                            <th class="title w-25"><?php echo lang('item'); ?>(<?php echo lang('code'); ?>)</th>
                            <th class="title w-10"><?php echo lang('category'); ?></th>
                            <th class="title w-20"><?php echo lang('stock_segmentation'); ?></th>
                            <th class="title w-15"><?php echo lang('total_stock_quantity'); ?></th>
                            <th class="title w-15">
                                <?php echo lang('LPP'); ?>/<?php echo lang('PP'); ?> 
                                <i data-tippy-content="<?php echo lang('LPP_PP'); ?>" class="fa-regular fa-circle-question tippyBtnCall font-16 theme-color"></i>
                            </th>
                            <th class="title w-10"><?php echo lang('total'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
</div>




<div class="filter-overlay"></div>
<div id="product-filter" class="filter-modal">
    <div class="filter-modal-body">
        <header>
            <h3 class="filter-modal-title"><span><?php echo lang('FilterOptions'); ?></span></h3>
            <button type="button" class="close-filter-modal" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">
                    <i data-feather="x"></i>
                </span>
            </button>
        </header>
        <?php echo form_open(base_url() . 'Stock/stock') ?>
            <div class="row">
                <div class="col-sm-12 col-md-6 mb-2">
                    <div class="form-group">
                        <select class="form-control select2 op_width_100_p" name="item_code" id="item_code_f">
                            <option value=""><?php echo lang('code'); ?></option>
                            <?php foreach ($items as $value) { ?>
                                <option value="<?php echo escape_output($value->code) ?>" <?php echo set_select('item_code', $value->code); ?>><?php echo escape_output($value->code) ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 mb-2">
                    <div class="form-group">
                        <select class="form-control select2 category_id op_width_100_p" name="category_id" id="category_id_f">
                            <option value=""><?php echo lang('category'); ?></option>
                            <?php foreach ($item_categories as $value) { ?>
                                <option value="<?php echo escape_output($value->id) ?>" <?php echo set_select('category_id', $value->id); ?>><?php echo escape_output($value->name) ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 mb-2">
                    <div class="form-group">
                        <select class="form-control select2 brand_id op_width_100_p" name="brand_id" id="brand_id_f">
                            <option value=""><?php echo lang('brand'); ?></option>
                            <?php foreach ($brands as $value) { ?>
                                <option value="<?php echo escape_output($value->id) ?>" <?php echo set_select('brand_id', $value->id); ?>><?php echo escape_output($value->name) ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 mb-2">
                    <div class="form-group">
                        <select class="form-control select2 op_width_100_p" name="item_id" id="item_id_f">
                            <option value=""><?php echo lang('item'); ?></option>
                            <?php foreach ($items as $value) { ?>
                                <option value="<?php echo escape_output($value->id) ?>" <?php echo set_select('item_id', $value->id); ?>><?php echo getItemNameById($value->parent_id); ?> <?php echo escape_output($value->name) . "(" . $value->code . ")" ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 mb-2">
                    <div class="form-group">
                        <input id="generic_name_f" type="text" class="form-control" name="generic_name" placeholder="<?php echo lang('generic_name') ?>" value="<?php echo set_value('generic_name'); ?>">
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 mb-2">
                    <div class="form-group">
                        <select  class="form-control select2 op_width_100_p" id="supplier_id_f" name="supplier_id">
                            <option value=""><?php echo lang('supplier'); ?></option>
                            <?php
                            foreach ($suppliers as $splrs) {
                                ?>
                                <option value="<?php echo escape_output($splrs->id) ?>" <?php echo set_select('supplier_id', $splrs->id); ?>><?php echo escape_output($splrs->name) ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 mb-2">
                    <button type="submit" name="submit" value="submit" class="btn bg-blue-btn"><?php echo lang('submit'); ?></button>
                </div>
            </div>
        <?php echo form_close(); ?>
    </div>
</div>


<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 stock_segment_title" id="exampleModalLabel">List</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                        <i data-feather="x"></i>
                    </span>
                </button>
            </div>
            
            <div class="modal-body stock_modal_print_btn">
                <div class="box-wrapper">
                    <div class="table-box">
                        <div class="table-responsive">
                            <table id="datatable2" class="table table-bordered table-striped datatable2">
                                <thead>
                                    <tr class="imeiHeading">
                                        <th class="w-5 text-left"><?php echo lang('sn'); ?></th>
                                        <th class="w-30"><?php echo lang('imei_serial_number'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                            <table id="datatable3" class="table table-bordered table-striped datatable3">
                                <thead>
                                    <tr>
                                        <th class="w-5 text-left"><?php echo lang('sn'); ?></th>
                                        <th class="w-30"><?php echo lang('expiry_date'); ?></th>
                                        <th class="w-30"><?php echo lang('quantity'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                            <table id="datatable4" class="table table-bordered table-striped datatable4">
                                <thead>
                                    <tr>
                                        <th class="w-5 text-left"><?php echo lang('sn'); ?></th>
                                        <th class="w-30"><?php echo lang('items'); ?></th>
                                        <th class="w-30"><?php echo lang('quantity'); ?></th>
                                        <th class="w-30">
                                            <?php echo lang('LPP'); ?>/<?php echo lang('PP'); ?> 
                                            <i data-tippy-content="<?php echo lang('LPP_PP'); ?>" class="fa-regular fa-circle-question tippyBtnCall font-16 theme-color"></i>
                                        </th>
                                        <th class="w-30"><?php echo lang('total'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-blue-btn" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<?php $this->load->view('updater/reuseJs2')?>
<script src="<?php echo base_url(); ?>frequent_changing/js/stock.js"></script>


