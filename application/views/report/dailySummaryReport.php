<input type="hidden" id="The_outle_field_is_required" value="<?php echo lang('The_outlet_field_is_required');?>">
<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/report.css">
<div class="main-content-wrapper dailySummaryReportWrapper">

    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo lang('daily_summary_report'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('report'), 'secondSection'=> lang('daily_summary_report')])?>
        </div>
    </section>


    <div class="box-wrapper"> 


        <div class="text-right d-flex justify-content-end">
            <button class="new-btn justify-content-end" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">
                <iconify-icon icon="solar:filter-broken"  width="22"></iconify-icon> <?php echo lang('filter_by');?>
            </button>
        </div>
        

        <!-- Report Header Start -->
        <div class="report_header">
            <h3 class="company_name"><?php echo escape_output($this->session->userdata('business_name'));?> </h3>
            <h5 class="outlet_info">
                <strong><?php echo lang('daily_summary_report'); ?></strong>
            </h5>
            <?php if(isset($outlet_id) && $outlet_id){
                $outlet_info = getOutletInfoById($outlet_id); 
            }?>
            <h5 class="outlet_info">
                <?php if(isset($outlet_id) && $outlet_id){ ?>
                    <strong><?php echo lang('outlet'); ?>: </strong> <?php echo escape_output($outlet_info->outlet_name); ?>
                <?php } else if(isset($outlet_id) && $outlet_id == ''){?>
                    <strong><?php echo lang('outlet'); ?>: </strong> <?php echo lang('all_outlets') ?>
                <?php } ?>
            </h5>
            <h5 class="outlet_info">
                <?php if(isset($outlet_id) && $outlet_id){ ?>
                    <strong><?php echo lang('address'); ?>: </strong> <?php echo escape_output($outlet_info->address); ?>
                <?php } ?>
            </h5>
            <h5 class="outlet_info">
                <?php if(isset($outlet_id) && $outlet_id){ ?>
                    <strong><?php echo lang('email'); ?>: </strong> <?php echo escape_output($outlet_info->email); ?>
                <?php } ?>
            </h5>
            <h5 class="outlet_info">
                <?php if(isset($outlet_id) && $outlet_id){ ?>
                    <strong><?php echo lang('phone'); ?>: </strong> <?php echo escape_output($outlet_info->phone); ?>
                <?php } ?>
            </h5>
            <?php if(isset($selectedDate) && $outlet_id && $selectedDate && $selectedDate != '1970-01-01'){ ?>
            <h5 class="outlet_info">
                <strong><?php echo lang('date');?>:</strong>
                <?php
                    if(!empty($selectedDate) && $selectedDate != '1970-01-01') {
                        echo dateFormat($selectedDate);
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
                    <input type="hidden" class="datatable_name"  data-filter="yes" data-title="<?php echo lang('daily_summary_report'); ?>" data-id_name="datatable">

                    <h4 class="op_font_weight_b op_margin_top_30 text-left"><?php echo lang('purchases');?></h4>
                    <table class="table table-striped">    
                        <thead>
                            <tr>
                                <th class="op_font_weight_b w-5"><?php echo lang('sn'); ?></th>
                                <th class="w-15"><?php echo lang('ref_no'); ?></th>
                                <th class="w-20"><?php echo lang('supplier'); ?></th> 
                                <th class="w-20 text-center"><?php echo lang('g_total'); ?></th>
                                <th class="w-20 text-center"><?php echo lang('paid'); ?></th>
                                <th class="w-20"><?php echo lang('due'); ?></th> 
                            </tr> 
                        </thead>
                            <tbody>
                            <?php  
                                $sum_of_gtotal = 0;
                                $sum_of_paid = 0;
                                $sum_of_due = 0;
                                if (!empty($result['purchases']) && isset($result['purchases'])):
                                    foreach ($result['purchases'] as $key => $value): 
                                        $sum_of_gtotal += $value->grand_total; 
                                        $sum_of_paid += $value->paid;  
                                        $sum_of_due += $value->due_amount;  
                                        $key++;
                                        ?>
                                        <tr>
                                            <td><?php echo $key ?></td>
                                            <td><?php echo escape_output($value->reference_no); ?></td>
                                            <td><?php echo escape_output($value->supplier_name) ?></td>  
                                            <td class="text-center"><?php echo getAmtCustom(escape_output($value->grand_total)); ?></td>
                                            <td class="text-center"><?php echo getAmtCustom(escape_output($value->paid)); ?></td> 
                                            <td><?php echo getAmtCustom(escape_output($value->due_amount)); ?></td> 
                                        </tr>
                                        <?php
                                    endforeach;
                                endif;
                            ?>
                            </tbody>
                        <tfoot>
                            <tr> 
                                <td></td> 
                                <td></td> 
                                <td class="op_font_weight_b op_right"><?php echo lang('total'); ?></td>  
                                <td class="text-center"><?php echo getAmtCustom($sum_of_gtotal) ?></td>
                                <td class="text-center"><?php echo getAmtCustom($sum_of_paid) ?></td>
                                <td><?php echo getAmtCustom($sum_of_due) ?></td>
                            </tr>
                        </tfoot>
                    </table> 

                    <h4 class="op_font_weight_b op_margin_top_30 text-left"><?php echo lang('purchase_return');?></h4>
                    <table class="table table-striped">    
                        <thead>
                            <tr>
                                <th class="op_font_weight_b w-5"><?php echo lang('sn'); ?></th>
                                <th class="w-35"><?php echo lang('reference_no'); ?></th>
                                <th class="w-40"><?php echo lang('supplier'); ?></th> 
                                <th class="w-20"><?php echo lang('amount'); ?></th>
                            </tr> 
                        </thead>
                            <tbody>
                            <?php  
                                $sum_of_total_return_amount = 0;
                                $sum_of_paid = 0;
                                $sum_of_due = 0;
                                if (!empty($result['purchase_return']) && isset($result['purchase_return'])):
                                    foreach ($result['purchase_return'] as $key => $value): 
                                        $sum_of_total_return_amount += $value->total_return_amount; 
                                        $key++;
                                        ?>
                                        <tr>
                                            <td><?php echo $key ?></td>
                                            <td><?php echo escape_output($value->reference_no); ?></td>
                                            <td><?php echo escape_output($value->supplier_name) ?></td>  
                                            <td><?php echo getAmtCustom($value->total_return_amount); ?></td>
                                        </tr>
                                        <?php
                                    endforeach;
                                endif;
                            ?>
                            </tbody>
                        <tfoot>
                            <tr> 
                                <td></td> 
                                <td></td> 
                                <td class="op_font_weight_b"><?php echo lang('total'); ?></td>  
                                <td><?php echo getAmtCustom($sum_of_total_return_amount) ?></td>
                            </tr>
                        </tfoot>
                    </table> 

                    <h4 class="op_font_weight_b op_margin_top_30 text-left"><?php echo lang('supplier_due_payment'); ?></h4>
                    <table class="table table-striped">    
                        <thead>
                            <tr>
                                <th class="w-5 op_font_weight_b"><?php echo lang('sn'); ?></th>
                                <th class="w-30"><?php echo lang('reference_no'); ?></th>
                                <th class="w-35"><?php echo lang('supplier'); ?></th> 
                                <th class="w-30"><?php echo lang('amount'); ?></th>
                            </tr> 
                        </thead>
                        <tbody>
                        <?php  
                            $sum_of_samount = 0; 
                            if (!empty($result['supplier_due_payments']) && isset($result['supplier_due_payments'])):
                                foreach ($result['supplier_due_payments'] as $key => $value): 
                                    $sum_of_samount += $value->amount;  
                                    $key++;
                                    ?>
                                    <tr>
                                        <td><?php echo $key ?></td>
                                        <td><?php echo getAmtCustom($value->reference_no); ?></td>
                                        <td><?php echo escape_output($value->supplier_name); ?></td>
                                        <td><?php echo getAmtCustom($value->amount); ?></td>
                                    </tr>
                                    <?php
                                endforeach;
                            endif;
                        ?>
                        </tbody>
                        <tfoot>
                        <tr>   
                            <td></td>
                            <td></td>
                            <td class="op_font_weight_b op_right"><?php echo lang('total'); ?></td>  
                            <td><?php echo getAmtCustom($sum_of_samount) ?></td>
                            <td></td>                            
                        </tr>
                        </tfoot>
                        
                    </table> 

                    <h4 class="op_font_weight_b op_margin_top_30 text-left"><?php echo lang('sales'); ?></h4>
                    <table class="table table-striped">    
                        <thead>
                            <tr>
                                <th class="op_font_weight_b"><?php echo lang('sn'); ?></th>
                                <th><?php echo lang('invoice_no'); ?></th>
                                <th><?php echo lang('customer'); ?></th>
                                <th class="text-center"><?php echo lang('sub_total'); ?></th>
                                <th class="text-center"><?php echo lang('tax'); ?></th>
                                <th class="text-center"><?php echo lang('charge'); ?></th>
                                <th class="text-center"><?php echo lang('discount'); ?></th> 
                                <th class="text-center"><?php echo lang('total_payable'); ?></th>
                                <th class="text-center"><?php echo lang('paid'); ?></th>
                                <th><?php echo lang('due'); ?></th>  
                            </tr> 
                        </thead>
                        <tbody>
                        <?php
                            $sum_of_stotal_payable = 0;
                            $sum_of_sdisc_actual = 0;
                            $sum_of_spaid_amount = 0;
                            $sum_of_sdue_amount = 0;
                            $sum_of_sdelivery_charge = 0;
                            $sum_of_svat = 0;
                            $sum_of_ssub_total = 0;
                            if (!empty($result['sales']) && isset($result['sales'])):
                                foreach ($result['sales'] as $key => $value):
                                    $sum_of_stotal_payable += $value->total_payable;
                                    $sum_of_sdisc_actual += $value->total_discount_amount;
                                    $sum_of_spaid_amount += $value->paid_amount;
                                    $sum_of_sdue_amount += $value->due_amount;
                                    $sum_of_sdelivery_charge += $value->total_discount_amount;
                                    $sum_of_svat += $value->vat;
                                    $sum_of_ssub_total += $value->sub_total;
                                    $key++;
                        ?>
                            <tr>
                                <td><?php echo escape_output($key); ?></td>
                                <td><?php echo escape_output($value->sale_no); ?></td>
                                <td><?php echo escape_output($value->customer_name) ?></td>
                                <td class="text-center"><?php echo getAmtCustom($value->sub_total) ?></td>
                                <td class="text-center"><?php echo getAmtCustom($value->vat) ?></td>
                                <td class="text-center"><?php echo getAmtCustom($value->delivery_charge) ?></td>
                                <td class="text-center"><?php echo getAmtCustom($value->total_discount_amount); ?></td>
                                <td class="text-center"><?php echo getAmtCustom($value->total_payable); ?></td>
                                <td class="text-center"><?php echo getAmtCustom($value->paid_amount); ?></td>
                                <td><?php echo getAmtCustom($value->due_amount); ?></td>
                            </tr>
                            <?php endforeach; endif; ?>
                        </tbody>
                            <tfoot>
                                <tr>  
                                    <td></td> 
                                    <td></td>
                                    <td class="op_font_weight_b op_right text-left"><?php echo lang('total'); ?></td>  
                                    <td class="text-center"><?php echo getAmtCustom($sum_of_ssub_total) ?></td>
                                    <td class="text-center"><?php echo getAmtCustom($sum_of_svat) ?></td>
                                    <td class="text-center"><?php echo getAmtCustom($sum_of_sdelivery_charge) ?></td>
                                    <td class="text-center"><?php echo getAmtCustom($sum_of_sdisc_actual) ?></td>
                                    <td class="text-center"><?php echo getAmtCustom($sum_of_stotal_payable) ?></td>
                                    <td class="text-center"><?php echo getAmtCustom($sum_of_spaid_amount) ?></td>
                                    <td><?php echo getAmtCustom($sum_of_sdue_amount) ?></td>
                                </tr>
                            </tfoot>
                    </table> 

                    <h4 class="op_font_weight_b op_margin_top_30 text-left"><?php echo lang('sale_return'); ?></h4>
                    <table class="table table-striped">    
                        <thead>
                            <tr>
                                <th class="op_font_weight_b"><?php echo lang('sn'); ?></th>
                                <th><?php echo lang('ref_no'); ?></th>
                                <th><?php echo lang('customer'); ?></th>
                                <th><?php echo lang('return_amount'); ?></th>
                            </tr> 
                        </thead>
                        <tbody>
                            <?php
                            $sum_of_stotal_payable = 0;
                            if (!empty($result['sale_return']) && isset($result['sale_return'])):
                                foreach ($result['sale_return'] as $key => $value):
                                    $sum_of_stotal_payable += $value->total_return_amount;
                                    $key++;
                            ?>
                            <tr>
                                <td><?php echo escape_output($key); ?></td>
                                <td><?php echo escape_output($value->reference_no) ?></td>
                                <td><?php echo escape_output($value->customer_name . '(' . $value->phone . ')')  ?></td>
                                <td><?php echo getAmtCustom($value->total_return_amount); ?></td>
                            </tr>
                            <?php endforeach; endif; ?>
                        </tbody>
                        <tfoot>
                            <tr>  
                                <td></td> 
                                <td class="op_font_weight_b op_right"><?php echo lang('total'); ?></td>  
                                <td><?php echo getAmtCustom($sum_of_stotal_payable) ?></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table> 

                    <h4 class="op_font_weight_b op_margin_top_30 text-left"><?php echo lang('customer_due_receive'); ?></h4>
                    <table class="table table-striped">    
                        <thead>
                            <tr>
                                <th class="op_font_weight_b"><?php echo lang('sn'); ?></th>
                                <th class="w-30"><?php echo lang('reference_no'); ?></th>
                                <th class="w-30"><?php echo lang('customer'); ?></th> 
                                <th class="w-35"><?php echo lang('amount'); ?></th>
                            </tr> 
                        </thead>
                        <?php  
                            $sum_of_camount = 0; 
                            if (!empty($result['customer_due_receives']) && isset($result['customer_due_receives'])):
                                foreach ($result['customer_due_receives'] as $key => $value): 
                                    $sum_of_camount += $value->amount;  
                                    $key++;
                                    ?>
                                    <tr>
                                        <td><?php echo $key ?></td>
                                        <td><?php echo escape_output($value->reference_no); ?></td>
                                        <td><?php echo escape_output($value->customer_name); ?></td>
                                        <td><?php echo getAmtCustom($value->amount); ?></td>
                                    </tr>
                                    <?php
                                endforeach;
                            endif;
                        ?>
                        <tfoot>
                        <tr>   
                            <td></td>
                            <td></td>
                            <td class="op_font_weight_b"><?php echo lang('total'); ?></td>  
                            <td><?php echo getAmtCustom($sum_of_camount) ?></td>
                        </tr>
                        </tfoot>
                    </table>
                    
                    <h4 class="op_font_weight_b op_margin_top_30 text-left"><?php echo lang('expense'); ?></h4>
                    <table class="table table-striped">    
                        <thead>
                            <tr>
                                <th class="op_font_weight_b"><?php echo lang('sn'); ?></th>
                                <th><?php echo lang('reference_no'); ?></th>
                                <th><?php echo lang('expense_category'); ?></th>
                                <th><?php echo lang('responsible_person'); ?></th>
                                <th class="text-center"><?php echo lang('amount'); ?></th>
                                <th><?php echo lang('payment_method'); ?></th>
                            </tr> 
                        </thead>
                        <?php  
                            $sum_of_eamount = 0; 
                            if (!empty($result['expenses']) && isset($result['expenses'])):
                                foreach ($result['expenses'] as $key => $value): 
                                    $sum_of_eamount += $value->amount;  
                                    $key++;
                                    ?>
                                    <tr>
                                        <td><?php echo $key ?></td>
                                        <td><?php echo escape_output($value->reference_no) ?></td>
                                        <td><?php echo escape_output($value->expense_category); ?></td>  
                                        <td><?php echo escape_output($value->responsible_person_name); ?></td>
                                        <td class="text-center"><?php echo getAmtCustom($value->amount) ?></td>
                                        <td><?php echo escape_output($value->payment_name); ?></td>
                                    </tr>
                                    <?php
                                endforeach;
                            endif;
                        ?>
                        <tfoot>
                        <tr>   
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="op_font_weight_b op_right"><?php echo lang('total'); ?></td>  
                            <td class="text-center"><?php echo getAmtCustom($sum_of_eamount) ?></td>
                            <td></td>
                        </tr>
                        </tfoot>
                    </table> 

                    <h4 class="op_font_weight_b op_margin_top_30 text-left"><?php echo lang('income'); ?></h4>
                    <table class="table table-striped">    
                        <thead>
                            <tr>
                                <th class="op_font_weight_b"><?php echo lang('sn'); ?></th>
                                <th><?php echo lang('reference_no'); ?></th>
                                <th><?php echo lang('income_category'); ?></th>
                                <th><?php echo lang('responsible_person'); ?></th>
                                <th class="text-center"><?php echo lang('amount'); ?></th>
                                <th><?php echo lang('payment_method'); ?></th>
                            </tr> 
                        </thead>
                        <?php  
                            $sum_of_iamount = 0; 
                            if (!empty($result['incomes']) && isset($result['incomes'])):
                                foreach ($result['incomes'] as $key => $value): 
                                    $sum_of_iamount += $value->amount;  
                                    $key++;
                                    ?>
                                    <tr>
                                        <td><?php echo $key ?></td>
                                        <td><?php echo escape_output($value->reference_no) ?></td>
                                        <td><?php echo escape_output($value->income_category_name); ?></td>  
                                        <td><?php echo escape_output($value->responsible_person_name); ?></td>
                                        <td class="text-center"><?php echo getAmtCustom($value->amount) ?></td>
                                        <td><?php echo escape_output($value->payment_name); ?></td> 
                                    </tr>
                                    <?php
                                endforeach;
                            endif;
                        ?>
                        <tfoot>
                        <tr>   
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="op_font_weight_b op_right"><?php echo lang('total'); ?></td>  
                            <td class="text-center"><?php echo getAmtCustom($sum_of_iamount) ?></td>
                            <td></td>
                        </tr>
                        </tfoot>
                    </table> 

                    <?php if(!moduleIsHideCheck('Damage-YES')){ ?>
                    <h4 class="op_font_weight_b op_margin_top_30 text-left"><?php echo lang('damage'); ?></h4>
                    <table class="table table-striped">    
                        <thead>
                        <tr>
                            <th class="op_font_weight_b"><?php echo lang('sn'); ?></th>
                            <th><?php echo lang('ref_no'); ?></th>
                            <th class="text-center"><?php echo lang('loss_amount'); ?></th> 
                            <th><?php echo lang('responsible_person'); ?></th> 
                            <th><?php echo lang('items'); ?></th> 
                        </tr> 
                        </thead>
                        <tbody>
                        <?php  
                            $sum_of_wamount = 0; 
                            if (!empty($result['wastes']) && isset($result['wastes'])):
                                foreach ($result['wastes'] as $key => $value): 
                                    $sum_of_wamount += $value->total_loss;  
                                    $key++;
                                    ?>
                                    <tr>
                                        <td><?php echo $key ?></td>
                                        <td><?php echo escape_output($value->reference_no); ?></td> 
                                        <td class="text-center"><?php echo getAmtCustom($value->total_loss); ?></td>
                                        <td><?php echo escape_output($value->responsible_person); ?></td>
                                        <td>
                                        <?php 
                                            $damageItems = damageItemDetailsByDamageId($value->id);
                                            if($damageItems){
                                                echo "<strong>Name(Code)-Qty(Unit)-Price</strong><br>";
                                                foreach($damageItems as $d){
                                                    echo escape_output($d->item_name). '(' . $d->code . ')-' . $d->damage_quantity . '('  . $d->unit_name . ')-' . getAmtCustom($d->loss_amount) . '<br>';
                                                }
                                            }
                                        ?>
                                        </td> 
                                    </tr>
                                    <?php
                                endforeach;
                            endif;
                        ?>
                        </tbody>
                            <tfoot>
                                <tr>   
                                    <td></td>
                                    <td class="op_font_weight_b op_right"><?php echo lang('total'); ?></td>  
                                    <td class="text-center"><?php echo getAmtCustom($sum_of_wamount) ?></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                    </table> 
                    <?php } ?>
            
                    <?php if(!moduleIsHideCheck('Installment Sale-YES')){ ?>
                    <h4 class="op_font_weight_b op_margin_top_30 text-left"><?php echo lang('installment_collection'); ?></h4>
                    <table class="table table-striped">    
                        <thead>
                            <tr>
                                <th class="op_font_weight_b"><?php echo lang('sn'); ?></th>
                                <th><?php echo lang('invoice_no'); ?></th>
                                <th><?php echo lang('customer'); ?></th>
                                <th><?php echo lang('amount'); ?></th> 
                            </tr> 
                        </thead>
                        <tbody>
                        <?php  
                            $sum_of_wamount = 0; 
                            if (!empty($result['installments']) && isset($result['installments'])):
                                foreach ($result['installments'] as $key => $value): 
                                    $sum_of_wamount += $value->paid_amount;  
                                    $key++;
                                    ?>
                                    <tr>
                                        <td><?php echo $key ?></td>
                                        <td><?php echo escape_output($value->reference_no); ?></td> 
                                        <td><?php echo escape_output($value->customer_name); ?></td> 
                                        <td><?php echo getAmtCustom($value->paid_amount); ?></td>
                                    </tr>
                                    <?php
                                endforeach;
                            endif;
                        ?>
                        </tbody>
                        <tfoot>
                        <tr>   
                            <td></td>
                            <td></td>
                            <td class="op_font_weight_b op_right"><?php echo lang('total'); ?></td>  
                            <td><?php echo getAmtCustom($sum_of_wamount) ?></td>
                        </tr>
                        </tfoot>
                    </table> 

                    <h4 class="op_font_weight_b op_margin_top_30 text-left"><?php echo lang('installment_down_payment'); ?></h4>
                    <table class="table table-striped">    
                        <thead>
                            <tr>
                                <th class="op_font_weight_b"><?php echo lang('sn'); ?></th>
                                <th><?php echo lang('reference_no'); ?></th> 
                                <th><?php echo lang('customer'); ?></th> 
                                <th><?php echo lang('amount'); ?></th> 
                            </tr> 
                        </thead>
                        <tbody>
                        <?php  
                            $sum_of_damount = 0; 
                            if (!empty($result['installments_down_payment']) && isset($result['installments_down_payment'])):
                                foreach ($result['installments_down_payment'] as $key => $value): 
                                    $sum_of_damount += $value->down_payment;  
                                    $key++;
                                    ?>
                                    <tr>
                                        <td><?php echo $key ?></td>
                                        <td><?php echo escape_output($value->reference_no); ?></td> 
                                        <td><?php echo escape_output($value->customer_name); ?></td> 
                                        <td><?php echo getAmtCustom($value->down_payment); ?></td> 
                                    </tr>
                                    <?php
                                endforeach;
                            endif;
                        ?>
                        </tbody>
                        <tfoot>
                        <tr>   
                            <td></td>
                            <td></td>
                            <td class="op_font_weight_b op_right"><?php echo lang('total'); ?></td>  
                            <td><?php echo getAmtCustom($sum_of_damount) ?></td>
                        </tr>
                        </tfoot>
                    </table> 
                    <?php } ?>


                    <?php if(!moduleIsHideCheck('Servicing-YES')){ ?>
                    <h4 class="op_font_weight_b op_margin_top_30 text-left"><?php echo lang('servicing'); ?></h4>
                    <table class="table table-striped">    
                        <thead>
                            <tr>
                                <th class="op_font_weight_b"><?php echo lang('sn'); ?></th>
                                <th><?php echo lang('customer'); ?></th> 
                                <th class="text-center"><?php echo lang('servicing_charge'); ?></th> 
                                <th class="text-center"><?php echo lang('paid_amount'); ?></th> 
                                <th><?php echo lang('due_amount'); ?></th> 
                            </tr> 
                        </thead>
                        <tbody>
                        <?php  
                            $sum_of_service = 0; 
                            $sum_of_paid = 0; 
                            $sum_of_due = 0; 
                            if (!empty($result['total_servicing']) && isset($result['total_servicing'])):
                                foreach ($result['total_servicing'] as $key => $value): 
                                    $sum_of_service = $value->servicing_charge; 
                                    $sum_of_paid += $value->paid_amount; 
                                    $sum_of_due += $value->due_amount; 
                                    $key++;
                                    ?>
                                    <tr>
                                        <td><?php echo $key ?></td>
                                        <td><?php echo escape_output($value->customer_name); ?></td> 
                                        <td class="text-center"><?php echo getAmtCustom($value->servicing_charge); ?></td> 
                                        <td class="text-center"><?php echo getAmtCustom($value->paid_amount); ?></td> 
                                        <td><?php echo getAmtCustom($value->due_amount); ?></td> 
                                    </tr>
                                    <?php
                                endforeach;
                            endif;
                        ?>
                        </tbody>
                        <tfoot>
                        <tr>    
                            <td></td>
                            <td class="op_font_weight_b op_right"><?php echo lang('total'); ?></td>  
                            <td class="text-center"><?php echo getAmtCustom($sum_of_service) ?></td>
                            <td class="text-center"><?php echo getAmtCustom($sum_of_paid) ?></td>
                            <td><?php echo getAmtCustom($sum_of_due) ?></td>
                        </tr>
                        </tfoot>
                    </table> 
                    <?php } ?>
                </div>
            </div>
        </div> 
    </div>  
</div>



<div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="exampleModalToggleLabel"><?php echo lang('FilterOptions');?></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                        data-feather="x"></i></button>
            </div>
            <div class="modal-body">
                <?php echo form_open(base_url() . 'Report/dailySummaryReport', ['id' => 'dailySummaryReport']) ?>
                <div class="row">
                    <div class="col-sm-12 col-md-6 mb-2">
                        <div class="form-group">
                            <input  autocomplete="off" type="text" name="date" class="form-control customDatepicker dailySummaryDate" placeholder="<?php echo lang('date'); ?>" value="<?php echo isset($_POST['date']) && $_POST['date'] ? $_POST['date'] : date('Y-m-d',strtotime('today')) ?>">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 mb-2">
                        <div class="form-group">
                            <select  class="form-control select2 ir_w_100" id="outlet_id" name="outlet_id">
                                <?php if(($this->session->userdata('role')) == '1'){ ?>
                                <option <?php echo set_select('outlet_id', '') ?>  value=""><?php echo lang('select_outlet') ?></option>
                                <?php } ?>
                                <?php
                                $outlets = getOutletsForReport();
                                foreach ($outlets as $value):
                                    ?>
                                    <option <?php echo set_select('outlet_id',$value->id)?>  value="<?php echo escape_output($value->id) ?>"><?php echo escape_output($value->outlet_name) ?></option>
                                    <?php
                                endforeach;
                                ?>
                            </select>
                            <div class="alert alert-error error-msg outlet_id_err_msg_contnr ">
                                <p id="outlet_id_err_msg"></p>
                            </div>
                        </div>
                    </div>
                    <div class="clear-fix"></div>
                    <div class="d-flex">
                        <button type="submit" name="submit" value="submit" class="new-btn me-2 dailySummaryReport">
                            <iconify-icon icon="solar:hourglass-broken" width="22"></iconify-icon>
                            <?php echo lang('submit'); ?>
                        </button>
                        <a class="new-btn printURLSet" href="<?php echo base_url(); ?>Report/printDailySummaryReport/<?php echo date('Y-m-d');?>">
                            <iconify-icon icon="solar:printer-2-broken" width="22"></iconify-icon>
                            <?php echo lang('print'); ?>
                        </a>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>


<?php $this->view('updater/reuseJs'); ?>
<script src="<?php echo base_url();?>frequent_changing/js/report-js/master_report_validation.js"></script>



