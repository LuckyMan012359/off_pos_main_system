<?php 

$supplier_info = getSupplierInfoById($purchase_return->supplier_id);
$company_info = getCompanyInfo($purchase_return->company_id);
$outlet_info = getOutletInfoById($purchase_return->outlet_id);

?>
<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/view_details.css">

<div class="main-content-wrapper">
    
    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h2 class="top-left-header"><?php echo lang('purchase_return_details'); ?> </h2>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('purchase_return'), 'secondSection'=> lang('purchase_return_details')])?>
        </div>
    </section>


    <div class="box-wrapper">
        <div class="table-box">
            <div class="box-body">
                <div id="wrapper" class="m-auto border-2s-e4e5ea br-5 br-5">
                    <div>
                        <div class="row  mt-3">
                            <div class="col-lg-3 col-md-6">
                                <h5 class="pb-2"><b><?php echo lang('Supplier_Info');?></b></h5>
                                <?php if($supplier_info->name != '' ){ ?>
                                    <p><?php echo lang('name');?>: <?php echo escape_output($supplier_info->name);?></p>
                                <?php } ?>
                                <?php if($supplier_info->phone != '' ){ ?>
                                    <p><?php echo lang('phone');?>: <?php echo escape_output($supplier_info->phone);?></p>
                                <?php } ?>
                                <?php if($supplier_info->email != '' ){ ?>
                                    <p><?php echo lang('email');?>: <?php echo escape_output($supplier_info->email);?></p>
                                <?php } ?>
                                <?php if($supplier_info->address != '' ){ ?>
                                    <p><?php echo lang('address');?>: <?php echo escape_output($supplier_info->address);?></p>
                                <?php } ?>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <h5 class="pb-2"><b><?php echo lang('company_info');?></b></h5>
                                <?php if($company_info->business_name != '' ){ ?>
                                    <p><?php echo lang('name');?>: <?php echo escape_output($company_info->business_name);?></p>
                                <?php } ?>
                                <?php if($company_info->phone != '' ){ ?>
                                    <p><?php echo lang('phone');?>: <?php echo escape_output($company_info->phone);?></p>
                                <?php } ?>
                                <?php if($company_info->email != '' ){ ?>
                                    <p><?php echo lang('email');?>: <?php echo escape_output($company_info->email);?></p>
                                <?php } ?>
                                <?php if($company_info->website != '' ){ ?>
                                    <p><?php echo lang('website');?>: <?php echo escape_output($company_info->website);?></p>
                                <?php } ?>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <h5 class="pb-2"><b><?php echo lang('outlet_info');?></b></h5>
                                <?php if($outlet_info->outlet_name != '' ){ ?>
                                    <p><?php echo lang('outlet_name');?>: <?php echo escape_output($outlet_info->outlet_name);?></p>
                                <?php } ?>
                                <?php if($outlet_info->phone != '' ){ ?>
                                    <p><?php echo lang('phone');?>: <?php echo escape_output($outlet_info->phone);?></p>
                                <?php } ?>
                                <?php if($outlet_info->email != '' ){ ?>
                                    <p><?php echo lang('email');?>: <?php echo escape_output($outlet_info->email);?></p>
                                <?php } ?>
                                <?php if($outlet_info->address != '' ){ ?>
                                    <p><?php echo lang('address');?>: <?php echo escape_output($outlet_info->address);?></p>
                                <?php } ?>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <h5 class="pb-2"><b><?php echo lang('purchase_return_info');?></b></h5>
                                <?php if($purchase_return->reference_no != '' ){ ?>
                                    <p><?php echo lang('reference_no');?>: <?php echo escape_output($purchase_return->reference_no);?></p>
                                <?php } ?>
                                <?php if($purchase_return->date != '' ){ ?>
                                    <p><?php echo lang('date');?>: <?php echo date($this->session->userdata('date_format'), strtotime($purchase_return->date)); ?></p>
                                <?php } ?>
                                <?php if($purchase_return->payment_method_id != '' ){ ?>
                                    <p><?php echo lang('payment_method');?>: <?php echo getAllPaymentMethodById($purchase_return->payment_method_id);?></p>
                                <?php } ?>
                                <?php if($purchase_return->return_status != '' ){ ?>
                                    <p>
                                        <?php echo lang('return_status');?>: 
                                        <?php if($purchase_return->return_status == 'taken_by_sup_pro_not_returned') { ?>
                                            <span><?php echo lang('taken_by_sup_pro_not_returned');?></span>
                                        <?php }elseif($purchase_return->return_status == 'taken_by_sup_money_returned'){ ?>
                                            <span><?php echo lang('taken_by_sup_money_returned');?></span>
                                        <?php }elseif($purchase_return->return_status == 'taken_by_sup_pro_returned'){ ?>
                                            <span><?php echo lang('taken_by_sup_pro_returned');?></span>
                                        <?php }else{ ?>
                                            <span><?php echo lang('draft');?></span>
                                        <?php } ?>
                                    </p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h5 class="pt-4 font-width-700"><?php echo lang('Purchse_Return_Summary');?></h5>
                        <div class="table-responsive"> 
                            <table class="table w-100 mt-20">
                                <thead class="br-3">
                                    <tr>
                                        <th class="w-5 text-left"><?php echo lang('sn');?></th>
                                        <th class="w-25 text-start"><?php echo lang('item');?>-<?php echo lang('code');?>-<?php echo lang('brand');?></th>
                                        <th class="w-25 text-start"><?php echo lang('expiry_IME_Serial');?></th>
                                        <th class="w-15 text-center"><?php echo lang('unit_price');?></th>
                                        <th class="w-10 text-center"><?php echo lang('qty');?></th>
                                        <th class="w-20 text-right pr-5"><?php echo lang('Total');?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $i = 0;
                                    if ($purchase_return_details && !empty($purchase_return_details)) {
                                        foreach ($purchase_return_details as $key=>$pi) {

                                            $p_type = '';
                                            if ($pi->item_type == 'Medicine_Product' && getItemExpiryStatus($pi->id) == 'Yes'){
                                                $p_type = 'Expiry Date:';
                                            }else if($pi->item_type == 'IMEI_Product'){
                                                $p_type = 'IMEI:';
                                            }else if($pi->item_type == 'Serial_Product'){
                                                $p_type = 'Serial:';
                                            }

                                    ?>
                                        <tr>
                                            <td class="text-left"><?php echo $key+1 ?></td>
                                            <td class="text-left"><span class=""><?php echo getItemNameCodeBrandByItemId($pi->item_id) ?></span></td>
                                            <td class="text-left">
                                                <span><?php echo $p_type . ' ' . $pi->expiry_imei_serial ?></span>
                                            </td>
                                            <td class="text-center"><?php echo escape_output($pi->return_quantity_amount) . ' ' . escape_output(getSaleUnitNameByItemId($pi->item_id))?></td>
                                            <td class="text-center"><?php echo getAmtCustom($pi->unit_price)?></td>
                                            <td class="text-right"><?php echo getAmtCustom($pi->total) ?></td>
                                        </tr>
                                    <?php 
                                        }
                                    }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="d-grid g-template-c-50-40 grid-gap-10 pt-20">
                        <div>
                            <div class="pt-20">
                                <?php if($purchase_return->note){?>
                                <h5 class="d-block pb-10"><?php echo lang('note');?></h5>
                                <div class="w-100">
                                    <p>
                                        <?php echo escape_output($purchase_return->note) ; ?>
                                    </p>
                                </div>
                                <?php } ?>
                            </div>
                        </div>

                        <div>
                            <div class="d-flex justify-content-between pt-10 p-10 bg-00c53 br-3">
                                <p class="f-w-600"><?php echo lang('grand_total');?></p>
                                <p><?php echo getAmtCustom($purchase_return->total_return_amount) ?></p>
                            </div>
                            <div class="d-flex justify-content-between mt-20 top_bottom_border_dotted">
                                <p class="f-w-600"><?php echo lang('Payment_Method'); ?></p>
                                <p><?php echo getAllPaymentMethodById($purchase_return->payment_method_id);?></p>
                            </div>

                            <?php
                            if($purchase_return->payment_method_type){
                            $payment_method = json_decode($purchase_return->payment_method_type, TRUE);
                            foreach($payment_method as $key=>$p_type){ ?>
                            <div class="d-flex justify-content-between">
                                <p class="f-w-600 pr-10"><?php echo lang($key);?></p>
                                <p><?php echo escape_output($p_type);?></p>
                            </div>
                            <?php }}  ?>
                        </div>



                        
                    </div>
                </div>
            </div> 
            <div class="box-footer"> 
                <a href="<?php echo base_url() ?>Purchase_return/printInvoice/<?php echo $this->custom->encrypt_decrypt($purchase_return->id, 'encrypt'); ?>"
                class="btn bg-blue-btn"><?php echo lang('print'); ?></a>
                <a href="<?php echo base_url() ?>Purchase_return/addEditPurchaseReturn/<?php echo $this->custom->encrypt_decrypt($purchase_return->id, 'encrypt'); ?>"
                class="btn bg-blue-btn"><?php echo lang('edit'); ?></a>
                <a href="<?php echo base_url() ?>Purchase_return/purchaseReturns"
                    class="btn bg-blue-btn"><?php echo lang('back'); ?></a>
            </div>
        </div>
    </div>
</div>