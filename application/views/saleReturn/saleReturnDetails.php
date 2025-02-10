<?php 
$lng = $this->session->userdata('language');
$ln_text = isset($lng) && $lng && $lng == "bangla" ? "bangla" : '';

$company_info = getCompanyInfo($sale_return->company_id);
$outlet_info = getOutletInfoById($sale_return->outlet_id);
$customer_info = getCustomer($sale_return->customer_id);
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/view_details.css">

<div class="main-content-wrapper">

    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h2 class="top-left-header"><?php echo lang('sale_return_details'); ?> </h2>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('sale_return'), 'secondSection'=> lang('sale_return_details')])?>
        </div>
    </section>


    <div class="box-wrapper">
        <div class="table-box">
            <div class="box-body">
                <div id="wrapper" class="m-auto border-2s-e4e5ea br-5 br-5">
                    <div>
                        <div class="row  mt-3">
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
                                <h5 class="pb-2"><b><?php echo lang('customer_info');?></b></h5>
                                <?php if($customer_info->name != '' ){ ?>
                                    <p><?php echo lang('name');?>: <?php echo escape_output($customer_info->name);?></p>
                                <?php } ?>
                                <?php if($customer_info->phone != '' ){ ?>
                                    <p><?php echo lang('phone');?>: <?php echo escape_output($customer_info->phone);?></p>
                                <?php } ?>
                                <?php if($customer_info->email != '' ){ ?>
                                    <p><?php echo lang('email');?>: <?php echo escape_output($customer_info->email);?></p>
                                <?php } ?>
                                <?php if($customer_info->address != '' ){ ?>
                                    <p><?php echo lang('address');?>: <?php echo escape_output($customer_info->address);?></p>
                                <?php } ?>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <h5 class="pb-2"><b><?php echo lang('sale_return_info');?></b></h5>
                                <?php if($sale_return->date != '' ){ ?>
                                    <p><?php echo lang('date');?>: <?php echo date($this->session->userdata('date_format'), strtotime($sale_return->date)); ?></p>
                                <?php } ?>
                                <?php if($sale_return->reference_no != '' ){ ?>
                                    <p><?php echo lang('reference_no');?>: <?php echo escape_output($sale_return->reference_no);?></p>
                                <?php } ?>
                                <?php if($sale_return->payment_method_id != '' ){ ?>
                                    <p><?php echo lang('payment_method');?>: <?php echo getAllPaymentMethodById($sale_return->payment_method_id);?></p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h5 class="pt-4 font-width-700"><?php echo lang('Sale_Return_Summary');?></h5>
                        <div class="table-responsive"> 
                            <table class="table w-100 mt-20">
                                <thead class="br-3">
                                    <tr>
                                        <th class="w-5 text-center"><?php echo lang('sn');?></th>
                                        <th class="w-30 text-start"><?php echo lang('item');?> - <?php echo lang('brand');?> - <?php echo lang('code');?></th>
                                        <th class="w-20 text-start"><?php echo lang('expiry_IME_Serial');?></th>
                                        <th class="w-10 text-center"><?php echo lang('sale_qty_inv');?></th>
                                        <th class="w-10 text-center"><?php echo lang('return_qty_inv');?></th>
                                        <th class="w-10 text-center"><?php echo lang('sale_price');?></th>
                                        <th class="w-15 text-rigth pr-5"><?php echo lang('return_price');?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($item_name as $key=>$item){?>
                                    <tr>
                                        <td class="text-center"><?php echo lang('no_1');?></td>
                                        <td>
                                            <?php
                                                echo getItemNameCodeBrandByItemId($item->item_id);
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo escape_output($item->expiry_imei_serial);?>
                                        </td>
                                        <td class="text-center"><?php echo escape_output($item->sale_quantity_amount); ?> <?php echo escape_output(getSaleUnitNameByItemId($item->item_id));?></td>
                                        <td class="text-center"><?php echo escape_output($item->return_quantity_amount); ?> <?php echo escape_output(getSaleUnitNameByItemId($item->item_id));?></td>
                                        <td class="text-center"><?php echo getAmtCustom($ln_text=="bangla" ? banglaNumber($item->unit_price_in_sale) : $item->unit_price_in_sale)?></td>
                                        <td class="text-right">
                                            <?php echo getAmtCustom($ln_text=="bangla" ? banglaNumber($item->unit_price_in_return) : $item->unit_price_in_return)?>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="d-grid g-template-c-50-40 grid-gap-10 pt-20">
                        <div>
                            <?php if($sale_return->note){ ?>
                            <div class="pt-20">
                                <h5 class="d-block pb-10"><?php echo lang('note');?></h5>
                                <div class="w-100 h-120px p-15">
                                    <p>
                                        <?php echo escape_output($sale_return->note) ; ?>
                                    </p>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                        <div>
                            <div class="details_footer d-flex justify-content-between foot_common_bg">
                                <p class="color-71"><?php echo lang('total_return_amount');?></p>
                                <p><?php echo getAmtCustom($sale_return->total_return_amount) ?></p>
                            </div>
                            <div class="details_footer d-flex justify-content-between">
                                <p class="color-71"><?php echo lang('paid');?></p>
                                <p><?php echo getAmtCustom($sale_return->paid) ?></p>
                            </div>
                            <div class="details_footer d-flex justify-content-between">
                                <p class="color-71"><?php echo lang('due');?></p>
                                <p><?php echo getAmtCustom($sale_return->due) ?></p>
                            </div>
                            <div class="details_footer d-flex justify-content-between pt-10">
                                <p class="color-71"><?php echo lang('payment_method');?></p>
                                <p><?php echo getAllPaymentMethodById($sale_return->payment_method_id);?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
            
            <div class="box-footer">
                <a href="<?php echo base_url() ?>Sale_return/print_invoice/<?php echo $this->custom->encrypt_decrypt($encrypted_id, 'encrypt'); ?>"
                class="btn bg-blue-btn">
                    <iconify-icon icon="solar:printer-2-broken"></iconify-icon>
                    <?php echo lang('print'); ?>
                </a>
                <a class="btn bg-blue-btn text-decoration-none" href="<?php echo base_url() ?>Sale_return/saleReturns">
                    <iconify-icon icon="solar:undo-left-round-broken"></iconify-icon>
                    <?php echo lang('back'); ?>
                </a>
            </div>

        </div>
    </div>
</div>