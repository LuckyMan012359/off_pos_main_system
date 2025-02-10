<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/report.css">
<section class="main-content-wrapper">
<h3 class="display_none"></h3>

    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo lang('tax_report'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('report'), 'secondSection'=> lang('tax_report')])?>
        </div>
    </section>


    <div class="box-wrapper">
        <!-- Report Header Start -->
        <div class="report_header">
            <h3 class="company_name"><?php echo escape_output($this->session->userdata('business_name'));?> </h3>
            <h5 class="outlet_info">
                <strong><?php echo lang('tax_report'); ?></strong>
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
                <input type="hidden" class="datatable_name"  data-filter="yes" data-title="<?php echo lang('vat_report'); ?>" data-id_name="datatable">
                    <table id="datatable" class="table">
                        <thead>
                            <tr>
                                <th><?php echo lang('sn'); ?></th>
                                <th><?php echo lang('invoice_no'); ?></th>
                                <th><?php echo lang('date_and_time'); ?></th>
                                <th class="text-center"><?php echo lang('total_sale'); ?></th>
                                <th><?php echo lang('applied_tax'); ?> <?php echo lang('amount'); ?></th>
                                <th class="text-right"><?php echo lang('total'); ?> <?php echo lang('tax'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $grandTotal = 0;
                            $vatTotal = 0;
                            if (isset($taxReport)):
                                foreach ($taxReport as $key => $value) {
                                    if($value->total_vat):
                                    $grandTotal+=$value->total_payable;
                                    $vatTotal+=$value->total_vat;
                                    $key++;
                                    ?>
                            <tr>
                                <td><?php echo escape_output($key--); ?></td>
                                <td><?php echo escape_output($value->sale_no) ?>
                                <td><?php echo dateFormat($value->date_time) ?></td>
                                <td class="text-center"><?php echo getAmtCustom($value->total_payable) ?></td>
                                <td>
                                    <?php
                                        $vat_json = json_decode($value->sale_vat_objects);
                                        foreach ($vat_json as $key=>$value1){
                                            if((float)$value1->tax_field_amount):
                                            echo escape_output($value1->tax_field_type).":".escape_output($value1->tax_field_amount);
                                            if($key<sizeof($vat_json)-1){
                                                echo ", ";
                                            }
                                            endif;
                                        }
                                    ?>
                                </td>
                                <td><?php echo getAmtCustom($value->total_vat) ?></td>
                            </tr>
                            <?php
                                endif;
                                }
                            endif;
                            ?>
                            <tr>
                                <th></th>
                                <th></th>
                                <th class="text-right"><?php echo lang('total'); ?></th>
                                <th class="text-center"><?php echo getAmtCustom($grandTotal) ?></th>
                                <th></th>
                                <th><?php echo getAmtCustom($vatTotal) ?></th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>





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
        <?php echo form_open(base_url() . 'Report/taxReport') ?>
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
                        <option value=""><?php echo lang('outlet') ?></option>
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
            <div class="col-sm-12 col-md-6 mb-2">
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
