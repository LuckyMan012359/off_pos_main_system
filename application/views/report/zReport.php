<link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/custom/report.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/datatable.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/report.css">

<section class="main-content-wrapper">
    <h3 class="display_none">&nbsp;</h3>
    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo lang('z_report'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('report'), 'secondSection'=> lang('z_report')])?>
        </div>
    </section>

    <div class="box-wrapper">
        <div class="table-box">
            <div class="table-responsive">
                <div class="report_header">
                    <h3 class="text-center company_name"><?php echo escape_output($this->session->userdata('business_name'));?> </h3>
                    <h5 class="outlet_info">
                        <strong><?php echo lang('z_report'); ?></strong>
                    </h5>
                    <?php if(isset($selectedDate) && $selectedDate != '' && $selectedDate != '1970-01-01' || isset($end_date) && $end_date != '' && $end_date != '1970-01-01'){ ?>
                    <h5 class="outlet_info">
                        <strong><?php echo lang('date');?>:</strong>
                        <?php if(!empty($selectedDate) && $selectedDate != '1970-01-01') {
                            echo dateFormat($selectedDate);
                        }?>
                    </h5>
                    <?php } ?>
                </div>
                <?php echo form_open(base_url() . 'Report/zReport')?>
                <div class="row my-3">
                    <div class="col-sm-12 mb-2 col-md-3">
                        <div class="form-group">
                            <input type="text" name="date" readonly class="form-control customDatepicker"
                            placeholder="<?php echo lang('date'); ?>" value="<?php echo $selectedDate; ?>">
                        </div>
                    </div>
                    <div class="col-sm-12 mb-2 col-md-3">
                        <div class="form-group">
                            <select class="form-control select2 w-100" id="outlet_id" name="outlet_id">
                                <?php
                                $outlets = getAllOutlestByAssign();
                                foreach ($outlets as $value):
                                    ?>
                                    <option <?= set_select('outlet_id',$value->id)?>  value="<?php echo escape_output($value->id) ?>"><?php echo escape_output($value->outlet_name) ?></option>
                                    <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12 mb-2 col-md-2">
                        <div class="form-group">
                            <button type="submit" name="submit" value="submit" class="new-btn h-40"><?php echo lang('submit'); ?>
                            </button>
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
                <?php $total_amount = 0;?>
                <table id="datatable" class="table">
                    <thead>
                    <tr>
                        <th class="w-3"></th>
                        <th class="w-31"><div class="pull-left m-0"><?php echo lang('z_report'); ?></div></th>
                        <th class="w-35"><div class="pull-left m-0"><?php echo escape_output($this->session->userdata('outlet_name')); ?></div></th>
                        <th class="w-31"><div class="pull-left m-0"><?= isset($selectedDate) && $selectedDate ? lang('date').": " . date($this->session->userdata('date_format'), strtotime($selectedDate)) : '' ?></div></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="w-3"></td>
                        <td class="w-31"></td>
                        <td class="w-35"></td>
                        <td class="w-31"></td>
                    </tr>
                    <tr>
                        <th class="w-3"></th>
                        <th class="w-31">
                            <div class="m-0 pull-left"><?php echo lang('SalesandTaxesSummary'); ?></div>
                        </th>
                        <th class="w-35"></th>
                        <th class="w-31"></th>
                    </tr>
                    <tr>
                        <td class="w-3"></td>
                        <td class="w-31"><?php echo lang('TotalFoodSales'); ?> (<?php echo lang('without_tax'); ?>) <?php echo lang('include_discount');?></td>
                        <td class="w-35"></td>
                        <td class="w-31 text-start"><?php echo getAmtCustom($sub_total_foods->sub_total_foods); $total_amount+=$sub_total_foods->sub_total_foods?></td>
                    </tr>
                    <tr>
                        <td class="w-3"></td>
                        <td class="w-31"><?php echo lang('sale_due_amount'); ?> (-) </td>
                        <td class="w-35"></td>
                        <td class="w-31 text-start"><?php echo getAmtCustom($sub_total_foods->total_due); $total_amount-=$sub_total_foods->total_due?></td>
                    </tr>
                    <tr>
                        <td class="w-3"></td>
                        <td class="w-31"><?php echo lang('sale_return_amount'); ?> (-) </td>
                        <td class="w-35"></td>
                        <td class="w-31 text-start"><?php echo getAmtCustom($sub_total_foods->total_return); $total_amount-=$sub_total_foods->total_return?></td>
                    </tr>
                    <tr>
                        <td class="w-3"></td>
                        <td class="w-31"><?php echo lang('purchase'); ?> (-) </td>
                        <td class="w-35"></td>
                        <td class="w-31 text-start"><?php echo getAmtCustom($purchase_sum); $total_amount-=$purchase_sum?></td>
                    </tr>
                    <tr>
                        <td class="w-3"></td>
                        <td class="w-31"><?php echo lang('purchase_return'); ?> (+) </td>
                        <td class="w-35"></td>
                        <td class="w-31 text-start"><?php echo getAmtCustom($purchase_return_sum); $total_amount+=$purchase_return_sum?></td>
                    </tr>
                    <tr>
                        <td class="w-3"></td>
                        <td class="w-31"><?php echo lang('installment_down_and_collection_register'); ?></td>
                        <td class="w-35"></td>
                        <td class="w-31 text-start"><?php echo getAmtCustom($installment_sum); $total_amount+=$installment_sum?></td>
                    </tr>
                    <tr>
                        <td class="w-3"></td>
                        <td class="w-31"><?php echo lang('DeliveryCharge'); ?> (+)</td>
                        <td class="w-35"></td>
                        <td class="w-31 text-start"><?php echo getAmtCustom($totals_sale_delivery->total_charge);$total_amount+=$totals_sale_delivery->total_charge?></td>
                    </tr>
                    <?php
                    $inline_tax_total = 0;
                    $tax_type = $this->session->userdata("tax_type");
                    if($taxes_foods && $taxes_foods):
                        foreach ($taxes_foods as $ky=>$tax):
                            if($tax_type!=2){
                                $total_amount+=$tax;
                            }
                            $inline_tax_total+=$tax;
                        ?>
                    <tr>
                        <td class="w-3"></td>
                        <td class="w-31"><?php echo escape_output($ky); ?> (<?php echo lang('tax'); ?>)</td>
                        <td class="w-35"></td>
                        <td class="w-31 text-start"><?php echo getAmtCustom($tax)?></td>
                    </tr>
                    <?php
                        endforeach;
                    endif?>
                    <tr>
                        <td class="w-3"></td>
                        <td class="w-31"><?php echo lang('customer_due_receive'); ?> (+)</td>
                        <td class="w-35"></td>
                        <td class="w-31 text-start"><?php echo getAmtCustom($totalDueReceived);$total_amount+=$totalDueReceived?></td>
                    </tr>
                    <tr>
                        <td class="w-3"></td>
                        <td class="w-31"><?php echo lang('discount'); ?> (-)</td>
                        <td class="w-35"></td>
                        <td class="w-31 text-start"><?php echo getAmtCustom($total_discount_amount_foods->total_discount_amount_foods);$total_amount-=$total_discount_amount_foods->total_discount_amount_foods?></td>
                    </tr>

                    <tr>
                        <td class="w-3"></td>
                        <th class="w-31"><?php echo lang('total'); ?> <?php echo lang('amount'); ?></th>
                        <td class="w-35"></td>
                        <th class="w-31 text-start"><?php echo getAmtCustom($total_amount)?></th>
                    </tr>

                    <tr>
                        <td class="w-3"></td>
                        <td class="w-31"></td>
                        <td class="w-35"></td>
                        <td class="w-31 text-start"></td>
                    </tr>

                    <tr>
                        <th class="w-3"></th>
                        <th class="w-31">
                            <div class="m-0 pull-left"><?php echo lang('PaymentMethodWiseBreakdown'); ?>(<?php echo lang('paid_amount'); ?>)</div>
                        </th>
                        <th class="w-35"></th>
                        <th class="w-31"></th>
                    </tr>
                    <?php
                    foreach ($get_all_sale_payment as $key=>$val_1):
                        $key++;
                        $usage_point = '';
                        if($val_1->payment_id== 'Loyalty Point'){
                            $usage_point.=' ('.lang('UsagePoints').': '.$val_1->usage_point.")";
                        }
                        ?>
                        <tr>
                            <td class="w-3"></td>
                            <td class="w-31"><?php echo escape_output($val_1->name.$usage_point)?></td>
                            <td class="w-35"></td>
                            <td class="w-31 text-start"><?php echo getAmtCustom($val_1->total_amount)?></td>

                        </tr>
                    <?php endforeach;?>
                    <tr>
                        <td class="w-3"></td>
                        <td class="w-31"></td>
                        <td class="w-35"></td>
                        <td class="w-31 text-start"></td>
                    </tr>
                    <tr>
                        <th class="w-3"></th>
                        <th class="w-31">
                            <div class="m-0 pull-left"><?php echo lang('payment_in_others_currencies'); ?>(<?php echo lang('paid_amount'); ?>)</div>
                        </th>
                        <th class="w-35"></th>
                        <th class="w-31 text-start"></th>
                    </tr>
                    <?php
                    foreach ($get_all_other_sale_payment as $key=>$val_1):
                        $key++;
                        ?>
                        <tr>
                            <td class="w-3"></td>
                            <td class="w-35"><?php echo escape_output($val_1->multi_currency)?></td>
                            <td class="w-35"></td>
                            <td class="w-31 text-start"><?php echo getAmtCustom($val_1->total_amount)?></td>

                        </tr>
                    <?php endforeach;?>
                    <tr>
                        <td class="w-3"></td>
                        <td class="w-31"></td>
                        <td class="w-35"></td>
                        <td class="w-31 text-start"></td>
                    </tr>
                    <tr>
                        <th class="w-3"></th>
                        <th class="w-31"><div class="m-0 pull-left"><?php echo lang('item_wise_sales'); ?></div></th>
                        <th class="w-35"></th>
                        <th class="w-31 text-start"></th>
                    </tr>
                    <tr>
                        <th class="w-3"></th>
                        <th class="w-31"><?php echo lang('food_menus'); ?></th>
                        <th class="w-35"><?php echo lang('quantity'); ?></th>
                        <th class="w-31 text-start"><?php echo lang('amount'); ?></th>
                    </tr>
                    <?php  if (isset($totalFoodSales)):
                            $total = 0;
                            foreach ($totalFoodSales as $key=>$total_fs):
                                $total+=$total_fs->net_sales;
                                $key++;
                                ?>
                                <tr>
                                    <td class="w-3"></td>
                                    <td class="w-31"><?php echo escape_output($total_fs->parent_name ? $total_fs->parent_name . ' ('. $total_fs->menu_name . ')' : $total_fs->menu_name)?></td> 
                                    <td class="w-35"><?php echo getAmtPCustom($total_fs->totalQty)?></td>
                                    <td class="w-31 text-start"><?php echo getAmtCustom($total_fs->net_sales)?></td>
                                </tr>
                    <?php
                        endforeach;
                    ?>
                        <tr>
                            <td class="w-3"></td>
                            <td class="w-31"></td>
                            <th class="w-35 pull-right"><?php echo lang('total')?></th>
                            <th class="w-31 text-start"><?php echo getAmtCustom($total)?></th>
                        </tr>
                    <?php
                        endif;
                    ?>
                 <?php  if (isset($getAllPurchasePaymentZreport)):?>
                     <tr>
                         <td class="w-3"></td>
                         <td class="w-31"></td>
                         <td class="w-35"></td>
                         <td class="w-31 text-start"></td>
                     </tr>
                    <tr>
                        <th class="w-3"></th>
                        <th class="w-31">
                            <div class="m-0 pull-left"><?php echo lang('purchase'); ?> (<?php echo lang('paid_amount'); ?>)</div>
                        </th>
                        <th class="w-35"></th>
                        <th class="w-31 text-start"></th>
                    </tr>
                    <?php
                    foreach ($getAllPurchasePaymentZreport as $key=>$val_1):
                        $key++;
                        ?>
                        <tr>
                            <td class="w-3"></td>
                            <td class="w-31"><?php echo escape_output($val_1->name)?></td>
                            <td class="w-35"></td>
                            <td class="w-31 text-start"><?php echo getAmtCustom($val_1->total_amount)?></td>

                        </tr>
                    <?php
                    endforeach;
                 endif;
                  if (isset($getAllExpensePaymentZreport)):?>
                      <tr>
                          <td class="w-3"></td>
                          <td class="w-31"></td>
                          <td class="w-35"></td>
                          <td class="w-31 text-start"></td>
                      </tr>
                    <tr>
                        <th class="w-3"></th>
                        <th class="w-31">
                            <div class="m-0 pull-left"><?php echo lang('expense'); ?></div>
                        </th>
                        <th class="w-35"></th>
                        <th class="w-31 text-start"></th>
                    </tr>

                    <?php
                    foreach ($getAllExpensePaymentZreport as $key=>$val_1):
                        $key++;
                        ?>
                        <tr>
                            <td class="w-3"></td>
                            <td class="w-31"><?php echo escape_output($val_1->name)?></td>
                            <td class="w-35"></td>
                            <td class="w-31 text-start"><?php echo getAmtCustom($val_1->total_amount)?></td>

                        </tr>
                    <?php endforeach;?>
                    <?php
                    endif;
                  if (isset($getAllSupplierPaymentZreport)):?>
                      <tr>
                          <td class="w-3"></td>
                          <td class="w-31"></td>
                          <td class="w-35"></td>
                          <td class="w-31 text-start"></td>
                      </tr>
                    <tr>
                        <th class="w-3"></th>
                        <th class="w-31">
                            <div class="m-0 pull-left"><?php echo lang('supplier_payment'); ?></div>
                        </th>
                        <th class="w-35"></th>
                        <th class="w-31 text-start"></th>
                    </tr>

                    <?php
                    foreach ($getAllSupplierPaymentZreport as $key=>$val_1):
                        $key++;
                        ?>
                        <tr>
                            <td class="w-3"></td>
                            <td class="w-31"><?php echo escape_output($val_1->name)?></td>
                            <td class="w-35"></td>
                            <td class="w-31 text-start"><?php echo getAmtCustom($val_1->total_amount)?></td>

                        </tr>
                    <?php endforeach;?>
                    <?php
                    endif;
                    ?>
                    <?php
                  if (isset($getAllCustomerDueReceiveZreport)):?>
                      <tr>
                          <td class="w-3"></td>
                          <td class="w-31"></td>
                          <td class="w-35"></td>
                          <td class="w-31 text-start"></td>
                      </tr>
                    <tr>
                        <th class="w-3"></th>
                        <th class="w-31">
                            <div class="m-0 pull-left"><?php echo lang('customer_due_receives'); ?></div>
                        </th>
                        <th class="w-35"></th>
                        <th class="w-31 text-start"></th>
                    </tr>

                    <?php
                    foreach ($getAllCustomerDueReceiveZreport as $key=>$val_1):
                        $key++;
                        ?>
                        <tr>
                            <td class="w-3"></td>
                            <td class="w-31"><?php echo escape_output($val_1->name)?></td>
                            <td class="w-35"></td>
                            <td class="w-31 text-start"><?php echo getAmtCustom($val_1->total_amount)?></td>

                        </tr>
                    <?php endforeach;?>
                    <?php
                    endif;
                    ?>
                    <tr>
                        <td class="w-3"></td>
                        <td class="w-31"></td>
                        <td class="w-35"></td>
                        <td class="w-31 text-start"></td>
                    </tr>
                    <tr>
                        <th class="w-3"></th>
                        <th class="w-31">
                            <div class="m-0 pull-left"><?php echo lang('TotalInHand'); ?></div></th>
                        <th class="w-35"></th>
                        <th class="w-31 text-start"></th>
                    </tr>
                    <tr>
                        <th class="w-3"></th>
                        <th class="w-31"><?php echo lang('payment_method'); ?></th>
                        <th class="w-35"><?php echo lang('Transactions'); ?></th>
                        <th class="w-31 text-start"><?php echo lang('amount'); ?></th>
                    </tr>

                    <?php
                    if (isset($registers)):
                        $html_content='';
                        foreach ($registers as $key => $value) {
                                $key++;
                                if($value->name != 'Loyalty Point'):
                            $html_content .= '<tr>
                            <td class="w-3"></td>
                            <td class="w-31">'.$value->name.'</td>
                            <td class="w-35">'.lang('register_detail_3').'</td>
                            <td class="w-31 text-start">'.getAmtCustom($value->paid_sales).'</td>
                        </tr>';
                                    if($value->name== 'Cash'):
                                        $outlet_id = $this->session->userdata('outlet_id');
                                        $total_sale_mul_c_rows =  getAllSaleByPaymentMultiCurrencyRows($selectedDate,$value->id,$outlet_id);
                                        if($total_sale_mul_c_rows){
                                            foreach ($total_sale_mul_c_rows as $value1):
                                                $html_content .= '<tr>
                                        <td></td>
                                        <td></td>
                                        <td>'.$value1->multi_currency.'</td>
                                        <td class="text-start">'.getAmtCustom($value1->total_amount).'</td>
                                    </tr>';
                                            endforeach;
                                        }

                                    endif;
                                else:
                                    $html_content .= '<tr>
                                        <td></td>
                                        <td>'.$value->name.'</td>
                                        <td>'.lang('is_loyalty_enable').'</td>
                                        <td class="text-start">'.getAmtCustom($value->paid_sales).'</td>
                                    </tr>';
                                    endif;
                        if($value->id != 'Loyalty Point'):
                            
                        $html_content .= '
                        <tr>
                            <td></td>
                            <td></td>
                            <td>'.lang('sale_return_register').'</td>
                            <td class="text-start">'.getAmtCustom($value->sale_return).'</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>'.lang('register_detail_2').'</td>
                            <td class="text-start">'.getAmtCustom($value->purchase).'</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>'.lang('purchase_return_register').'</td>
                            <td class="text-start">'.getAmtCustom($value->purchase_return).'</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>'.lang('installment_down_and_collection_register').'</td>
                            <td class="text-start">'.getAmtCustom($value->installment).'</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>'.lang('register_detail_5').'</td>
                            <td class="text-start">'.getAmtCustom($value->due_receive).'</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>'.lang('register_detail_6').'</td>
                            <td class="text-start">'.getAmtCustom($value->due_payment).'</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>'.lang('register_detail_7').'</td>
                            <td class="text-start">'.getAmtCustom($value->expense).'</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <th>'.lang('balance').'</th>
                            <th class="text-start">'.getAmtCustom($value->inline_total).'</th>
                        </tr>';
                            endif;
                        }
                        $html_content .= '<tr>
                        <th></th>
                        <th>
                            <div class="m-0 pull-left">'.lang('InHandSummary').'</div>
                        </th>
                        <th></th>
                        <th></th>
                    </tr>';
                        foreach ($total_payments as $key=>$val_1){
                            $separate = explode("||",$val_1);
                            $html_content .= '<tr>
                                <th></th>
                                <th></th>
                                <th>'.$separate[0].'</th>
                                <th class="text-start">'.getAmtCustom($separate[1]).'</th>
                        </tr>';
                        }
                        /*This variable could not be escaped because this is html content*/
                        echo ($html_content);
                    endif;
                    ?>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
</section>

<?php $this->view('updater/reuseJs_w_pagination'); ?>
