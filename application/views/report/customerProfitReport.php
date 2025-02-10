<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/report.css">
<div class="main-content-wrapper">

    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo lang('customerProfitReport'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('report'), 'secondSection'=> lang('customerProfitReport')])?>
        </div>
    </section>

    

    
    <div class="box-wrapper">
       
        <!-- Report Header Start -->
        <div class="report_header">
            <h3 class="company_name"><?php echo escape_output($this->session->userdata('business_name'));?> </h3>
            <h5 class="outlet_info">
                <strong><?php echo lang('customerProfitReport'); ?></strong>
            &nbsp;</h5>
            <?php if(isset($outlet_id)){
                $outlet_info = getOutletInfoById($outlet_id); 
            }?>
            <h5 class="outlet_info">
                <?php if(isset($outlet_id)){ ?>
                    <strong><?php echo lang('outlet'); ?>: </strong> <?= escape_output($outlet_info->outlet_name); ?>
                <?php }?>
            &nbsp;</h5>
            <h5 class="outlet_info">
                <?php if(isset($outlet_id)){ ?>
                    <strong><?php echo lang('address'); ?>: </strong> <?= escape_output($outlet_info->address); ?>
                <?php } ?>
            &nbsp;</h5>
            <h5 class="outlet_info">
                <?php if(isset($outlet_id)){ ?>
                    <strong><?php echo lang('email'); ?>: </strong> <?= escape_output($outlet_info->email); ?>
                <?php } ?>
            &nbsp;</h5>
            <h5 class="outlet_info">
                <?php if(isset($outlet_id)){ ?>
                    <strong><?php echo lang('phone'); ?>: </strong> <?= escape_output($outlet_info->phone); ?>
                <?php } ?>
            &nbsp;</h5>
            <?php if(isset($start_date) && $start_date != '' && $start_date != '1970-01-01' || isset($end_date) && $end_date != '' && $end_date != '1970-01-01'){ ?>
            <span class="outlet_info">
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
            </span>
            <?php } ?>
        </div>
        <!-- Report Header End -->

        <div class="table-box">
            <div class="box-body">

            <input type="hidden" class="datatable_name"  data-filter="yes" data-title="<?php echo lang('customerProfitReport'); ?>" data-id_name="datatable">

                <table id="datatable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th class="op_width_2_p op_center"><?php echo lang('sn'); ?></th>
                        <th><?php echo lang('date_and_time'); ?></th>
                        <th><?php echo lang('item'); ?></th>
                        <th><?php echo lang('qty'); ?></th>
                        <th><?php echo lang('purchase_price'); ?></th>
                        <th><?php echo lang('sale_price'); ?></th>
                        <th><?php echo lang('profit'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $total = 0;
                    if (isset($customerProfitReport)):

                        foreach ($customerProfitReport as $key => $value) {
                            $key++;
                            $lastPurchase = getLastPurchaseAmount($value->item_id);
                            $total_amount = ($value->totalQty*$value->sale_price)-($value->totalQty*$lastPurchase);
                            $total+=$total_amount;
                            ?>
                            <tr>
                                <td class="op_center"><?php echo $key; ?></td>
                                <td><?php echo dateFormat($value->sale_date); ?></td>
                                <td><?php echo escape_output($value->item_name); ?></td>
                                <td><?php echo escape_output($value->totalQty); ?></td>
                                <td><?php echo $lastPurchase."*".$value->totalQty." = ".getAmtCustom($value->totalQty*$lastPurchase); ?></td>
                                <td><?php echo $value->sale_price."*".$value->totalQty." = ".getAmtCustom($value->totalQty*$value->sale_price); ?></td>
                                <td><?php echo getAmtCustom($total_amount); ?></td>
                            </tr>
                            <?php
                        }
                    endif;
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th class="op_right"><?php echo lang('total'); ?></th>
                        <th><?=getAmtCustom($total)?></th>
                    </tr>
                    </tfoot>
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
        <?php echo form_open(base_url() . 'Report/customerProfitReport') ?>
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
                    <select  class="form-control select2 op_width_100_p" id="user_id" name="user_id">
                        <?php
                            $role = $this->session->userdata('role');
                            if($role == '1'){
                        ?>
                        <option value=""><?php echo lang('employee') ?></option>
                        <?php } ?>
                        <?php
                        foreach ($users as $value) {
                            ?>
                            <option value="<?php echo escape_output($value->id) ?>" <?php echo set_select('user_id', $value->id); ?>><?php echo escape_output($value->full_name) ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <?php
                if(isLMni()):
            ?>
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <select  class="form-control select2 ir_w_100" id="outlet_id" name="outlet_id">
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