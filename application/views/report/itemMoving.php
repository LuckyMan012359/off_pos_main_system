<input type="hidden" id="The_items_field_is_required" value="<?php echo lang('The_items_field_is_required') ?>">
<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/report.css">
<div class="main-content-wrapper">
    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo lang('item_moving_report') ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('report'), 'secondSection'=> lang('item_moving_report')])?>
        </div>
    </section>
    <div class="box-wrapper">
        <!-- Report Header Start -->
        <div class="report_header">
            <h3 class="company_name"><?php echo escape_output($this->session->userdata('business_name'));?> </h3>
            <h5 class="outlet_info">
                <strong><?php echo lang('item_moving_report'); ?></strong>
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
                <?php if(isset($item_id) && $item_id){ ?>
                    <strong><?php echo lang('item'); ?>: </strong> <?php echo getItemParentAndChildNameCode($item_id); ?>
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
            <div class="table-responsive">
                <input type="hidden" class="datatable_name"  data-filter="yes" data-title="<?php echo lang('item_moving_report'); ?>" data-id_name="datatable">
                <table id="datatable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="w-5"><?php echo lang('sn'); ?></th>
                            <th class="w-20"><?php echo lang('reference'); ?></th>
                            <th class="w-20"><?php echo lang('date_and_time'); ?></th>
                            <th class="w-25"><?php echo lang('type'); ?></th>
                            <th class="w-15 text-center"><?php echo lang('In'); ?> <?php echo lang('qty'); ?></th>
                            <th class="w-15 text-center"><?php echo lang('Out'); ?> <?php echo lang('qty'); ?></th>
                            <th class="w-15"><?php echo lang('outlet_name'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($itemMoving) && $itemMoving){
                        foreach($itemMoving as $key=>$item){   
                            if($key == 0){
                                $in_qty = $opening_item + $item->in_qty;
                            }else{
                                $in_qty = $item->in_qty;
                            }
                        ?>
                        <tr>
                            <td><?php echo $key + 1;?></td>
                            <td><?php echo escape_output($item->reference_no);?></td>
                            <td><?php echo dateFormat($item->date) ?></td>
                            <td><?php echo escape_output($item->type);?></td>
                            <td class="text-center"><?php echo escape_output($in_qty);?></td>
                            <td class="text-center"><?php echo escape_output($item->out_qty);?></td>
                            <td ><?php echo escape_output($item->outlet_name);?></td>
                        </tr>
                    <?php }} ?>
                    </tbody>
                </table>
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
        <?php echo form_open(base_url() . 'Report/itemMoving') ?>
        <div class="row">
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <input  autocomplete="off" type="text" name="startDate" readonly
                        class="form-control customDatepicker" placeholder="<?php echo lang('start_date'); ?>"
                        value="<?php echo set_value('startDate'); ?>">
                    <?php if (form_error('startDate')) { ?>
                    <div class="callout callout-danger my-2">
                        <span class="error_paragraph"><?php echo form_error('startDate'); ?></span>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <input  autocomplete="off" type="text" id="endMonth" name="endDate" readonly
                        class="form-control customDatepicker" placeholder="<?php echo lang('end_date'); ?>"
                        value="<?php echo set_value('endDate'); ?>">
                    <?php if (form_error('endDate')) { ?>
                    <div class="callout callout-danger my-2">
                        <span class="error_paragraph"><?php echo form_error('endDate'); ?></span>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <select class="form-control select2 op_width_100_p" name="item_id" id="item_id">
                        <option value=""><?php echo lang('select_item'); ?></option>
                        <?php foreach ($items as $value) { ?>
                        <option value="<?php echo escape_output($value->id) ?>" <?php echo set_select('item_id', $value->id); ?>>
                            <?php echo getItemNameCodeBrandByItemId($value->id) ?></option>
                        <?php } ?>
                    </select>
                    <div class="alert alert-error error-msg item_id_err_msg_contnr ">
                        <p id="item_id_err_msg"></p>
                    </div>
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
                <button type="submit" name="submit" value="submit" class="new-btn itemMoving">
                    <iconify-icon icon="solar:hourglass-broken" width="22"></iconify-icon>
                    <?php echo lang('submit'); ?>
                </button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>


<?php $this->view('updater/reuseJs_w_pagination'); ?>
<script src="<?php echo base_url();?>frequent_changing/js/report-js/master_report_validation.js"></script>