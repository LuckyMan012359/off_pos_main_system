<input type="hidden" id="The_items_field_is_required" value="<?php echo lang('The_items_field_is_required');?>">
<input type="hidden" id="The_customer_field_is_required" value="<?php echo lang('The_customer_field_is_required');?>">
<input type="hidden" id="The_supplier_field_is_required" value="<?php echo lang('The_supplier_field_is_required');?>">
<input type="hidden" id="The_date_field_is_required" value="<?php echo lang('The_date_field_is_required');?>">

<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/report.css">
<script src="<?php echo base_url(); ?>frequent_changing/js/report-js/master_report_validation.js"></script>

<div class="main-content-wrapper">

    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo lang('productPurchaseReport'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('report'), 'secondSection'=> lang('productPurchaseReport')])?>
        </div>
    </section>

    <div class="box-wrapper">
        <!-- Report Header Start -->
        <div class="report_header">
            <h3 class="company_name"><?php echo escape_output($this->session->userdata('business_name'));?> </h3>
            <h5 class="outlet_info">
                <strong><?php echo lang('productPurchaseReport'); ?></strong>
            </h5>
            <?php if(isset($outlet_id) && $outlet_id){
                $outlet_info = getOutletInfoById($outlet_id); 
            }?>
            <h5 class="outlet_info">
                <?php if(isset($outlet_id) && $outlet_id){ ?>
                    <strong><?php echo lang('outlet'); ?>: </strong> <?= escape_output($outlet_info->outlet_name); ?>
                <?php }?>
            </h5>
            <h5 class="outlet_info">
                <?php if(isset($outlet_id) && $outlet_id){ ?>
                    <strong><?php echo lang('address'); ?>: </strong> <?= escape_output($outlet_info->address); ?>
                <?php } ?>
            </h5>
            <h5 class="outlet_info">
                <?php if(isset($outlet_id) && $outlet_id){ ?>
                    <strong><?php echo lang('email'); ?>: </strong> <?= escape_output($outlet_info->email); ?>
                <?php } ?>
            </h5>
            <h5 class="outlet_info">
                <?php if(isset($outlet_id) && $outlet_id){ ?>
                    <strong><?php echo lang('phone'); ?>: </strong> <?= escape_output($outlet_info->phone); ?>
                <?php } ?>
            </h5>
            <?php if(isset($start_date) && $start_date != '' && $start_date != '1970-01-01' || isset($end_date) && $end_date != '' && $end_date != '1970-01-01'){ ?>
            <h5 class="outlet_info">
                <strong><?php echo lang('date');?>:</strong>
                <?php
                    if(!empty($start_date) && $start_date != '1970-01-01') {
                        echo dateFormat($start_date);
                    }
                    if((isset($start_date) && isset($end_date)) && ($start_date != '1970-01-01' && $end_date != '1970-01-01')){
                        echo ' - ';
                    }
                    if(!empty($end_date) && $end_date != '1970-01-01') {
                        echo dateFormat($end_date);
                    }
                ?>
            </h5>
            <?php } ?>
            <h5 class="outlet_info">
                <?php if(isset($items_id) && $items_id){ ?>
                    <strong><?php echo lang('product'); ?>: </strong> <?php echo getItemParentAndChildNameCode($items_id); ?>
                <?php } ?>
            </h5>
            <h5 class="outlet_info">
                <?php if(isset($menu_note) && $menu_note){ ?>
                    <strong><?php echo lang('imei_serial'); ?>: </strong> <?php echo ($menu_note); ?>
                <?php } ?>
            </h5>
            <h5 class="outlet_info">
                <?php if(isset($supplier_id) && $supplier_id){ ?>
                    <strong><?php echo lang('supplier'); ?>: </strong> <?php echo getSupplierName($supplier_id); ?>
                <?php } ?>
            </h5>
            <h5 class="outlet_info">
                <?php if(isset($report_generate_time) && $report_generate_time){
                    echo $report_generate_time;
                } ?>
            </h5>
        </div>
        <!-- Report Header End -->



        <div class="table-box">
            <div class="box-body">
                <div class="table-responsive">
                    
                    <input type="hidden" class="datatable_name"  data-filter="yes" data-title="<?php echo lang('productPurchaseReport'); ?>" data-id_name="datatable">

                    <table id="datatable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="w-5"><?php echo lang('sn'); ?></th>
                                <th><?php echo lang('reference_no'); ?></th>
                                <th><?php echo lang('date_and_time'); ?></th>
                                <th><?php echo lang('supplier'); ?></th>
                                <th><?php echo lang('product'); ?></th>
                                <th class="text-center"><?php echo lang('quantity_amount'); ?></th>
                                <th class="text-center"><?php echo lang('unit_price'); ?></th>
                                <th class="text-right"><?php echo lang('total'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $pGrandTotal = 0;
                            if (isset($productPurchaseReport)):
                                foreach ($productPurchaseReport as $key => $value) {
                                    $key++;
                                    ?>
                                    <tr>
                                        <td><?php echo $key; ?></td>
                                        <td><?php echo escape_output($value->reference_no) ?></td>
                                        <td><?php echo dateFormat($value->added_date) ?></td>
                                        <td>
                                            <?php echo escape_output($value->supplier_name) ?><br>
                                            <?php
                                                if($value->expiry_imei_serial != ''){
                                                    echo checkItemShortType($value->type) . ": " . $value->expiry_imei_serial . "<br>";
                                                }
                                            ?>
                                        </td>
                                        <td><?php echo escape_output($value->name) . "(" . $value->code . ")" ?></td>
                                        <td class="text-center"><?php echo getAmtCustom($value->totalQuantity_amount) ?> <?php echo escape_output($value->purchase_unit_name) ?></td>
                                        <td class="text-center"><?php echo getAmtCustom($value->unit_price) ?></td>
                                        <td><?php echo getAmtCustom($value->unit_price*$value->totalQuantity_amount) ?></td>
                                    </tr>
                                    <?php
                                }
                            endif;
                            ?>
                        </tbody>
                    </table>
                </div>
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
        <?php echo form_open(base_url() . 'Report/productPurchaseReport', $arrayName = array('id' => 'productPurchaseReport')) ?>
        <div class="row">
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <input  autocomplete="off" type="text" name="startDate" readonly class="form-control customDatepicker" placeholder="<?php echo lang('start_date'); ?>" value="<?php echo set_value('startDate'); ?>">
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <input  autocomplete="off" type="text" id="endMonth" name="endDate" readonly class="form-control customDatepicker" placeholder="<?php echo lang('end_date'); ?>" value="<?php echo set_value('endDate'); ?>">
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <select  class="form-control select2 op_width_100_p" id="items_id" name="items_id">
                        <option value=""><?php echo lang('select'); ?> <?php echo lang('product'); ?></option>
                        <?php
                        foreach ($items as $value) {
                            ?>
                            <option value="<?php echo escape_output($value->id) ?>" <?php echo set_select('items_id', $value->id); ?>><?php echo getItemNameCodeBrandByItemId($value->id); ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="alert alert-error error-msg items_id_err_msg_contnr ">
                    <p id="items_id_err_msg"></p>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <select  class="form-control select2 op_width_100_p" id="supplier_id" name="supplier_id">
                        <option value=""><?php echo lang('select'); ?> <?php echo lang('supplier'); ?></option>
                        <?php
                        foreach ($suppliers as $value) {
                            ?>
                            <option value="<?php echo escape_output($value->id) ?>" <?php echo set_select('supplier_id', $value->id); ?>><?php echo ($value->name); ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="alert alert-error error-msg supplier_id_err_msg_contnr ">
                    <p id="supplier_id_err_msg"></p>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <input  autocomplete="off" type="text" id="menu_note" name="menu_note" class="form-control" placeholder="<?php echo lang('IMEI_Serial'); ?>" value="<?php echo set_value('menu_note'); ?>">
                </div>
            </div>
            <?php
                if(isLMni()):
            ?>
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <select  class="form-control select2 ir_w_100" id="outlet_id" name="outlet_id">
                        <?php
                            $role = $this->session->userdata('role');
                            if($role == '1'){
                        ?>
                        <option value=""><?php echo lang('select_outlet') ?></option>
                        <?php } ?>
                        <?php
                        $outlets = getOutletsForReport();
                        foreach ($outlets as $value):
                            ?>
                            <option <?= set_select('outlet_id',$value->id)?>  value="<?php echo escape_output($value->id) ?>"><?php echo escape_output($value->outlet_name) ?></option>
                            <?php
                        endforeach;
                        ?>
                    </select>
                </div>
            </div>
            <?php
                endif;
            ?>
            <div class="clear-fix"></div>
            <div class="col-12 mb-2">
                <button type="submit" name="submit" value="submit" class="new-btn">
                    <iconify-icon icon="solar:hourglass-broken" width="22"></iconify-icon>
                    <?php echo lang('submit'); ?>
                </button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>

<?php $this->view('updater/reuseJs_w_pagination'); ?>