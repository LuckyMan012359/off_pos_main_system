<input type="hidden" id="stock_value_tooltip" value="<?php echo lang('stock_value_tooltip');?>">
<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/stock.css">


<div class="main-content-wrapper">


    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header"><?php echo lang('low_stock'); ?></h3>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('low_stock'); ?>" data-id_name="datatable">
                <div class="btn_list m-right d-flex">
                    <button type="button" class="dataFilterBy new-btn"><iconify-icon icon="solar:filter-broken"  width="22"></iconify-icon> <?php echo lang('filter_by');?></button>
                </div>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('stock'), 'secondSection'=> lang('low_stock')])?>
        </div>
    </section>


    <div class="box-wrapper">
        <div class="table-box">
            <!-- /.box-header -->
            <div class="table-responsive">
                <table id="datatable" class="table table-bordered table-striped stock-list">
                    <thead>
                        <tr>
                            <th class="title w-1"><?php echo lang('sn'); ?></th>
                            <th class="title w-25"><?php echo lang('item'); ?>(<?php echo lang('code'); ?>)</th>
                            <th class="title w-10"><?php echo lang('category'); ?></th>
                            <th class="title w-30"><?php echo lang('stock_segmentation'); ?></th>
                            <th class="title w-15"><?php echo lang('total_stock_quantity'); ?></th>
                            <th class="title w-10">
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
        <?php echo form_open(base_url() . 'Stock/getStockAlertList') ?>
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


<?php $this->load->view('updater/reuseJs2')?>
<script src="<?php echo base_url(); ?>frequent_changing/js/low_stock.js"></script>


