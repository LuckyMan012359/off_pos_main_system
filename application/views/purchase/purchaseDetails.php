<?php 

$supplier_info = getSupplierInfoById($purchase_details->supplier_id);
$company_info = getCompanyInfo($purchase_details->company_id);
$outlet_info = getOutletInfoById($purchase_details->outlet_id);
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/view_details.css">

<div class="main-content-wrapper">

    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo lang('details_purchase'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('purchase'), 'secondSection'=> lang('details_purchase')])?>
        </div>
    </section>



    <div class="box-wrapper">
        <div class="table-box">
            <div id="printableArea" class="box-body">
                <div id="wrapper" class="m-auto border-2s-e4e5ea br-5 br-5">
                    <div>
                        <div class="row  mt-3">
                            <div class="col-sm-6">
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
                            <div class="col-sm-6">
                                <div class="d-flex justify-content-end">
                                    <?php
                                        $invoice_logo = $this->session->userdata('invoice_logo');
                                        if($invoice_logo):
                                    ?>
                                        <img src="<?=base_url()?>uploads/site_settings/<?=escape_output($invoice_logo)?>">
                                    <?php
                                        endif;
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="row  mt-4">
                            <div class="col-lg-4 col-md-6 col-sm-6 pb-3">
                                <h5 class="pb-2"><b><?php echo lang('purchase_info');?></b></h5>
                                <?php if($purchase_details->date != '' ){ ?>
                                    <p><?php echo lang('date');?>: <?php echo date($this->session->userdata('date_format'), strtotime($purchase_details->date)); ?></p>
                                <?php } ?>
                                <?php if($purchase_details->reference_no != '' ){ ?>
                                    <p><?php echo lang('reference_no');?>: <?php echo escape_output($purchase_details->reference_no);?></p>
                                <?php } ?>
                                <?php if($purchase_details->invoice_no != '' ){ ?>
                                    <p><?php echo lang('supplier_invoice_no');?>: <?php echo escape_output($purchase_details->invoice_no);?></p>
                                <?php } ?>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-6 pb-3">
                                <div class="d-flex justify-content-xs-start justify-content-sm-center">
                                    <div>
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
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-6 pb-3">
                                <div class="d-flex justify-content-xs-start justify-content-sm-end">
                                    <div>
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
                                </div>
                            </div>
                        </div>
                    </div>
                    <h5 class="pt-4 font-width-700"><span class="font-700 pt-2 pb-2"><?php echo lang('Purchse_Details');?></span></h5>
                    <div>
                        <div class="table-responsive"> 
                            <table class="table w-100 mt-20">
                                <thead class="br-3">
                                    <tr>
                                        <th class="w-5 text-center"><?php echo lang('sn');?></th>
                                        <th class="w-30 text-start"><?php echo lang('item');?>-<?php echo lang('code');?>-<?php echo lang('brand');?></th>
                                        <th class="w-15 text-start"><?php echo lang('expiry_IME_Serial');?></th>
                                        <th class="w-15 text-center"><?php echo lang('qty');?></th>
                                        <th class="w-15 text-center"><?php echo lang('unit_price');?></th>
                                        <th class="w-20 text-right pr-5"><?php echo lang('total');?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $i = 0;
                                if ($purchase_items && !empty($purchase_items)) {
                                    foreach ($purchase_items as $pi) {
                                        $i++;
                                        $p_type = '';
                                        if ($pi->item_type == 'Medicine_Product' && $pi->expiry_date_maintain == 'Yes'){
                                            $p_type = 'Expiry Date:';
                                        }else if($pi->item_type == 'IMEI_Product'){
                                            $p_type = 'IMEI:';
                                        }else if($pi->item_type == 'Serial_Product'){
                                            $p_type = 'Serial:';
                                        }
                                    ?>
                                        <tr>
                                            <td class="text-center">
                                                <span><?php echo  $i ?></span>
                                            </td>
                                            <td class="text-start">
                                                <span><?php echo getItemNameCodeBrandByItemId($pi->item_id) ?></span>
                                            </td>
                                            <td class="text-start">
                                                <span><?php echo $p_type . ' ' . $pi->expiry_imei_serial ?></span>
                                            </td>
                                            <td class="text-center"><?php echo escape_output($pi->quantity_amount) . ' ' . unitName(getUnitIdByIgId($pi->item_id)) ?></td>
                                            <td class="text-center"><?php echo getAmtCustom($pi->unit_price) ?></td>
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
                                <?php if($purchase_details->note){ ?>
                                <h5 class="d-block pb-10"><?php echo lang('note');?></h5>
                                <div class="w-100 pt-10">
                                    <p>
                                        <?php echo escape_output($purchase_details->note) ; ?>
                                    </p>
                                </div> 
                                <?php } ?>
                            </div>
                        </div>
                        <div>
                            <div class="details_footer d-flex justify-content-between foot_common_bg br-3">
                                <?php
                                    $discount  = explode('%',$purchase_details->discount);
                                    $discount_ac = '';
                                    if(isset($discount[1]) && $discount[1]){
                                        $discount_ac = $purchase_details->discount;
                                    }else{
                                        $getSign = substr($purchase_details->discount, -1);
                                        if($getSign == "%"){
                                            $discount_ac = $discount[0] . "%";
                                        }else{
                                            $discount_ac = getAmtCustom($discount[0]);
                                        }
                                    }
                                ?>
                                <p class="color-71"><?php echo lang('discount');?></p>
                                <p><?php echo ($discount_ac) ?></p>
                            </div>
                           
                            
                            <div class="details_footer d-flex justify-content-between br-3">
                                <p class="color-71"><?php echo lang('other');?></p>
                                <p><?php echo getAmtCustom($purchase_details->other) ?></p>
                            </div>
                            <div class="details_footer d-flex justify-content-between foot_common_bg br-3">
                                <p class="color-71"><?php echo lang('grand_total');?></p>
                                <p><?php echo getAmtCustom($purchase_details->grand_total) ?></p>
                            </div>
                            <div class="details_footer d-flex justify-content-between br-3">
                                <p class="color-71"><?php echo lang('paid_amount');?></p>
                                <p><?php echo getAmtCustom($purchase_details->paid) ?></p>
                            </div>
                            <div class="details_footer d-flex justify-content-between foot_common_bg br-3">
                                <p class="color-71"><?php echo lang('due_amount');?></p>
                                <p><?php echo getAmtCustom($purchase_details->due_amount) ; ?></p>
                            </div>
                            <div class="pt-3">
                                <p class="top_bottom_border_dotted pt-1 pb-1"><?php echo lang('Payment_Method'); ?></p>
                                <?php foreach ($multi_pay_method as $pay_method){ ?>
                                <div class="d-flex justify-content-between">
                                    <p><?php echo escape_output($pay_method->payment_method_name); ?></p>
                                    <p><?php echo getAmtCustom($pay_method->amount); ?></p>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="box-footer"> 
                <a href="<?php echo base_url() ?>Purchase/printInvoice/<?php echo $encrypted_id; ?>"
                class="btn bg-blue-btn me-1">
                    <iconify-icon icon="solar:printer-2-broken" class="me-1"></iconify-icon>
                    <?php echo lang('print'); ?>
                </a>
                <a href="<?php echo base_url() ?>Purchase/addEditPurchase/<?php echo $encrypted_id; ?>"
                class="btn bg-blue-btn me-1">
                    <iconify-icon icon="solar:pen-new-round-broken" class="me-1"></iconify-icon>
                    <?php echo lang('edit'); ?>
                </a>
                <a href="<?php echo base_url() ?>Purchase/purchases"
                    class="btn bg-blue-btn me-1">
                    <iconify-icon icon="solar:undo-left-round-broken" class="me-1"></iconify-icon>
                    <?php echo lang('back'); ?>
                </a>
            </div>
        </div>
    </div>
</div>

