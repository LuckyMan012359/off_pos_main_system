<link rel="stylesheet" href="<?php echo base_url()?>frequent_changing/css/checkBotton2.css">


<input type="hidden" id="select" value="<?php echo lang('select');?>">
<input type="hidden" id="shop_name" value="<?php echo getBusinessName($this->session->userdata('company_id')) ?>">
<input type="hidden" id="price" value="<?php echo lang('price'); ?>">
<input type="hidden" id="code" value="<?php echo lang('code'); ?>">
<input type="hidden" id="Please_select_an_item" value="<?php echo lang('Please_select_an_item'); ?>">
<input type="hidden" id="status_change" value="<?php echo lang('status_change');?>">


<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/item.css">
<div class="main-content-wrapper">

<div class="ajax-message"></div>

    <?php
    if ($this->session->flashdata('exception')) {
        echo '<section class="alert-wrapper"><div class="alert alert-success alert-dismissible fade show"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></button>
        <div class="alert-body"><i class="icon fa fa-check me-2"></i>';
        echo escape_output($this->session->flashdata('exception'));unset($_SESSION['exception']);
        echo '</div></div></section>';
    }
    ?>
    <?php
    if ($this->session->flashdata('exception_error')) {

        echo '<section class="alert-wrapper"><div class="alert alert-danger alert-dismissible fade show"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></button>
        <div class="alert-body"><i class="icon fa fa-times me-2"></i>';
        echo escape_output($this->session->flashdata('exception_error'));unset($_SESSION['exception_error']);
        echo '</div></div></section>';
    }
    ?>


    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header"><?php echo lang('list_item'); ?></h3>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('list_item'); ?>" data-id_name="datatable">
                <div class="btn_list m-right d-flex">
           
                    <button type="button" class="dataFilterBy new-btn"><iconify-icon icon="solar:filter-broken"  width="22"></iconify-icon> <?php echo lang('filter_by');?></button>
                </div>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('item'), 'secondSection'=> lang('list_item')])?>
        </div>
    </section>



    <div class="box-wrapper">
        <form action="<?php echo base_url();?>Item/bulkDelete" method="POST">
            <div class="text-right d-flex justify-content-end page_sort_but_wrp">
                <a href="<?php echo base_url() ?>Item/addEditItem"
                    class="new-btn mb-2 ms-1"><iconify-icon icon="solar:add-circle-broken" width="22"></iconify-icon> <?php echo lang('add_item'); ?>
                </a>
                <div class="dropdown ms-1">
                    <button class="new-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <iconify-icon icon="solar:hourglass-broken" width="22"></iconify-icon>
                        <?php echo lang('other_options');?>
                    </button>
                    <ul class="dropdown-menu p-2">
                        <li>
                            <a href="<?php echo base_url() ?>Item/uploadItem" class="dropdown-item new-btn">
                                <iconify-icon icon="solar:upload-broken" width="22"></iconify-icon>
                                <?php echo lang('upload_item'); ?>
                            </a>
                        </li>
                        <li class="mt-1">
                            <a href="<?php echo base_url() ?>Item/uploadItemPhoto" class="dropdown-item new-btn">
                                <iconify-icon icon="solar:upload-broken" width="22"></iconify-icon>
                                <?php echo lang('upload_photo'); ?>
                            </a>
                        </li>
                        <li class="mt-1">
                            <a href="<?php echo base_url() ?>Item/itemBarcodeGenerator" class="dropdown-item new-btn">
                                <iconify-icon icon="solar:printer-2-broken" width="22"></iconify-icon>
                                <?php echo lang('item_barcode'); ?>
                            </a>
                        </li>
                        <li class="mt-1">
                            <a href="<?php echo base_url() ?>Item/itemBarcodeGeneratorLabel" class="dropdown-item new-btn">
                                <iconify-icon icon="solar:printer-2-broken" width="22"></iconify-icon> 
                                <?php echo lang('Print_Labels');?>
                            </a>
                        </li>
                    </ul>
                </div>
                <button type="submit" class="new-btn mb-2 ms-1">
                    <iconify-icon icon="solar:trash-bin-minimalistic-broken" width="22"></iconify-icon>
                    <?php echo lang('Delete_Item');?>
                </button>
            </div>
            <!-- End Filter Options -->
            <div class="table-box item_page_indicator">
                <div class="table-responsive">
                    <table id="datatable" class="table table-bordered table-striped items_ajax_page">
                        <thead>
                            <tr>
                                <th class="w-5" data-orderable="false">
                                    <label  class="container "> <?php echo lang('select_all'); ?>
                                        <input class="checkbox_itemAll" type="checkbox" id="checkbox_itemAll">
                                        <span class="checkmark"></span>
                                    </label>
                                </th>
                                <th class="w-5 text-left"><?php echo lang('sn'); ?></th>
                                <th class="w-20"><?php echo lang('name'); ?> (<?php echo lang('code'); ?>)</th>
                                <th class="w-10"><?php echo lang('type'); ?></th>
                                <th class="w-10"><?php echo lang('category'); ?></th>
                                <th class="w-12"><?php echo lang('purchase_price'); ?></th>
                                <th class="w-12"><?php echo lang('sale_price'); ?></th>
                                <th class="w-11"><?php echo lang('added_by'); ?></th>
                                <th class="w-10"><?php echo lang('added_date'); ?></th>
                                <th class="w-5 text-center"><?php echo lang('actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- DataTables -->



<div class="modal fade" id="barcode_print">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo lang('Bar_Code_Of');?>: <span class="item_name"></span></h4>
                <button type="button" class="btn-close m_close_trigger" data-bs-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true"><i data-feather="x"></i></span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12" id="variation_show_hide">
                        <select  id="set_variation_child" class="form-control select2">
                        </select>
                        <div class="error_variation mt-3"></div>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <input type="number" class="form-control no_of_item" placeholder="<?php echo lang('how_many');?>">
                            <input type="hidden" class="form-control item_id_r">
                            <input type="hidden" class="form-control item_type_r">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="new-btn w-100 justify-content-center" id="re_generate">
                            <iconify-icon icon="solar:hourglass-broken" width="22"></iconify-icon>
                            <?php echo lang('Generate');?>
                        </button>
                    </div>
                </div>
                <div class="row mt-3" id="barcode_wrap">
                </div>
            </div>
            <div class="modal-footer">
                <a  class="new-btn" id="print_barcode_wrap">
                    <iconify-icon icon="solar:printer-2-broken" width="22"></iconify-icon>
                    <?php echo lang('Print');?>
                </a>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="label_barcode_print">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo lang('Print_Label_Of');?>: <span class="label_item_name"></span></h4>
                <button type="button" class="btn-close m_close_trigger" data-bs-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true"><i data-feather="x"></i></span></button>
            </div>
            <div class="modal-body">
                <h6><?php echo lang('Each_image_will_be_printed_on_separate_page');?></h6>
                <div class="row">
                    <div class="col-md-12" id="label_variation_show_hide">
                        <select  id="lablel_set_variation_child" class="form-control select2">
                        </select>
                        <div class="label_error_variation mt-3"></div>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <input type="number" class="form-control label_no_of_item" placeholder="<?php echo lang('how_many');?>">
                            <input type="hidden" class="form-control label_item_id_r">
                            <input type="hidden" class="form-control label_item_type_r">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="new-btn w-100 justify-content-center" id="label_re_generate">
                            <iconify-icon icon="solar:hourglass-broken" width="22"></iconify-icon>
                            <?php echo lang('Generate');?>
                        </button>
                    </div>
                </div>
                <div class="row mt-3 justify-content-center" id="label_barcode_wrap">
                </div>
            </div>
            <div class="modal-footer">
                <a  class="new-btn" id="label_print_wrap">
                    <iconify-icon icon="solar:printer-2-broken" width="22"></iconify-icon>
                    <?php echo lang('Print');?>
                </a>
            </div>
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
        <?php echo form_open(base_url() . 'Item/items') ?>
        <div class="row">

            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <select name="category_id" id="category_id" class="form-control  select2 width_100_p" >
                        <option value=""><?php echo lang('category'); ?></option>
                        <?php foreach ($itemCategories as $ctry) { ?>
                            <option value="<?php echo escape_output($ctry->id) ?>" <?php echo set_select('category_id', $ctry->id); ?>><?php echo escape_output($ctry->name) ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <select name="supplier_id" id="supplier_id" class="form-control select2 width_100_p mx-2">
                        <option value=""><?php echo lang('supplier'); ?></option>
                        <?php foreach ($suppliers as $val) { ?>
                            <option value="<?php echo escape_output($val->id) ?>" <?php echo set_select('supplier_id', $val->id); ?>><?php echo escape_output($val->name) ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <button type="submit" name="submit" value="submit" class="new-btn">
                    <iconify-icon icon="solar:hourglass-broken" width="22"></iconify-icon>
                    <?php echo lang('submit'); ?>
                </button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>



<div class="modal fade" id="variation_view_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo lang('variation_of');?>: <span class="variation_name_set"></span></h4>
                <button type="button" class="btn-close m_close_trigger" data-bs-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true"><i data-feather="x"></i></span></button>
            </div>
            <div class="modal-body">
                <table class="table" id="modal_variation_html_set">

                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="new-btn" data-bs-dismiss="modal">
                    <iconify-icon icon="solar:close-circle-bold-duotone" width="22"></iconify-icon>
                    <?php echo lang('close'); ?>
                </button>
            </div>
        </div>
    </div>
</div>


<?php $this->load->view('updater/reuseJs2')?>
<script src="<?php echo base_url(); ?>frequent_changing/js/items.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/barcode/JsBarcode.all.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/barcode_print.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/item-barcode-print.js"></script>

