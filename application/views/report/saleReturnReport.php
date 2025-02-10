<!-- shuvo -->
<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/report.css">
<div class="main-content-wrapper">

    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo lang('sale_return_report'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('report'), 'secondSection'=> lang('sale_return_report')])?>
        </div>
    </section>


    <div class="box-wrapper">
        
    
        <!-- Report Header Start -->
        <div class="report_header">
            <h3 class="company_name"><?php echo escape_output($this->session->userdata('business_name'));?> </h3>
            <h5 class="outlet_info">
                <strong><?php echo lang('sale_return_report'); ?></strong>
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
                <?php if(isset($report_generate_time) && $report_generate_time){
                    echo $report_generate_time;
                } ?>
            </h5>
        </div>
        <!-- Report Header End -->

    
        <div class="table-box">
            <div class="box-body">
                <div class="table-responsive">
                    <input type="hidden" class="datatable_name"  data-filter="yes" data-title="<?php echo lang('customer_due_receive_report'); ?>" data-id_name="datatable">
                    <table id="datatable"  class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="w-5"><?php echo lang('sn'); ?></th>
                                <th class="w-15"><?php echo lang('reference_no'); ?></th>
                                <th class="w-15"><?php echo lang('date_and_time'); ?></th>
                                <th class="w-10"><?php echo lang('customer'); ?></th>
                                <th class="w-20"><?php echo lang('sale_invoice_no'); ?></th>
                                <th class="w-20"><?php echo lang('item'); ?></th>
                                <th class="w-15"><?php echo lang('payment_method'); ?></th>
                                <th class="w-15"><?php echo lang('amount'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $grandTotal = 0;
                            $countTotal = 0;
                            if (isset($saleReturnReport)):
                                foreach ($saleReturnReport as $key => $value) {
                                    $grandTotal+=$value->total_return_amount;
                                    $key++;
                                    ?>
                                    <tr>
                                        <td><?php echo $key; ?></td>
                                        <td><?php echo escape_output($value->reference_no) ?></td>
                                        <td><?php echo dateFormat($value->added_date) ?></td>
                                        <td><?php echo escape_output($value->customer_name); ?></td>
                                        <td><?php echo escape_output($value->sale_no); ?></td>
                                        <td>
                                            <?php $items = getSaleReturnItemsBySaleRetunId($value->id);
                                                if($items){
                                                    echo "<strong>Name(Code)-Qty(Unit)-Price</strong><br>";
                                                    foreach($items as $item){
                                                        echo escape_output($item->name). '(' . $item->code . ')-'. $item->return_quantity_amount . '(' . $item->unit_name . ')-' . getAmtCustom($item->return_price) . "<br>";
                                                    }
                                                }
                                                
                                            ?>

                                        </td>
                                        <td><?php echo escape_output($value->payment_name);?></td>
                                        <td><?php echo getAmtCustom($value->total_return_amount); ?></td>
                                    </tr>
                                    <?php
                                }
                            endif;
                            ?>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th class="text-right"><?php echo lang('total'); ?> </th>
                                <th><?= getAmtCustom($grandTotal) ?></th>
                            </tr>
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
        <?php echo form_open(base_url() . 'Report/saleReturnReport') ?>
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
                    <select  class="form-control select2" id="customer_id" name="customer_id">
                        <?php
                            $role = $this->session->userdata('role');
                            if($role == '1'){
                        ?>
                        <option value=""><?php echo lang('select') ?> <?php echo lang('customer') ?></option>
                        <?php } ?>
                        <?php
                        foreach ($customers as $value):
                            ?>
                            <option <?php isset($customer_id) && $customer_id && $customer_id == $value->id ? 'selected' : '' ?> <?= set_select('customer_id',$value->id)?>  value="<?php echo escape_output($value->id) ?>"><?php echo escape_output($value->name) ?></option>
                            <?php
                        endforeach;
                        ?>
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
