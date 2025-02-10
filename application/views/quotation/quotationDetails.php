<?php 

$customer_info = getCustomer($quotation_details->customer_id);
$company_info = getCompanyInfo($quotation_details->company_id);
$outlet_info = getOutletInfoById($quotation_details->outlet_id);
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/view_details.css">

<div class="main-content-wrapper">

    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo lang('quotation_details'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('quotation'), 'secondSection'=> lang('quotation_details')])?>
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
                                <h5 class="pb-2"><b><?php echo lang('quotation_info');?></b></h5>
                                <?php if($quotation_details->date != '' ){ ?>
                                    <p><?php echo lang('date');?>: <?php echo date($this->session->userdata('date_format'), strtotime($quotation_details->date)); ?></p>
                                <?php } ?>
                                <?php if($quotation_details->reference_no != '' ){ ?>
                                    <p><?php echo lang('reference_no');?>: <?php echo escape_output($quotation_details->reference_no);?></p>
                                <?php } ?>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-6 pb-3">
                                <div class="d-flex justify-content-xs-start justify-content-sm-center">
                                    <div>
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
                    <h5 class="pt-4 font-width-700"><span class="ont-700 pt-2 pb-2"><?php echo lang('quotation_details');?></span></h5>
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
                                if ($quotation_items && !empty($quotation_items)) {
                                    foreach ($quotation_items as $qi) {
                                        $i++;
                                        $p_type = '';
                                        if ($qi->item_type == 'Medicine_Product'){
                                            $p_type = 'Medicine';
                                        }else if($qi->item_type == 'IMEI_Product'){
                                            $p_type = 'IMEI';
                                        }else if($qi->item_type == 'Serial_Product'){
                                            $p_type = 'Serial';
                                        }
                                    ?>
                                        <tr>
                                            <td class="text-center">
                                                <span><?php echo  $i ?></span>
                                            </td>
                                            <td class="text-start">
                                                <span><?php echo getItemNameCodeBrandByItemId($qi->item_id) ?></span>
                                            </td>
                                            <td class="text-start">
                                                <span><?php echo $p_type . ' ' . $qi->expiry_imei_serial ?></span>
                                            </td>
                                            <td class="text-center"><?php echo escape_output($qi->quantity_amount) . ' ' . unitName(getUnitIdByIgId($qi->item_id)) ?></td>
                                            <td class="text-center"><?php echo getAmtCustom($qi->unit_price) ?></td>
                                            <td class="text-right"><?php echo getAmtCustom($qi->total) ?></td>
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
                                <?php if($quotation_details->note){ ?>
                                <h5 class="d-block pb-10"><?php echo lang('note');?></h5>
                                <div class="w-100 pt-10">
                                    <p>
                                        <?php echo escape_output($quotation_details->note) ; ?>
                                    </p>
                                </div> 
                                <?php } ?>
                            </div>
                        </div>
                        <div>
                            <div class="details_footer d-flex justify-content-between foot_common_bg br-3">
                                <?php
                                    $discount  = explode('%',$quotation_details->discount);
                                    $discount_ac = '';
                                    if(isset($discount[1]) && $discount[1]){
                                        $discount_ac = $quotation_details->discount;
                                    }else{
                                        $getSign = substr($quotation_details->discount, -1);
                                        if($getSign == "%"){
                                            $discount_ac = $discount[0] . "%";
                                        }else{
                                            $discount_ac = getAmtCustom($discount[0]);
                                        }
                                    }
                                ?>
                                <p class="color-71"><?php echo lang('discount');?></p>
                                <p><?php echo escape_output($discount_ac) ?></p>
                            </div>
                           
                            
                            <div class="details_footer d-flex justify-content-between br-3">
                                <p class="color-71"><?php echo lang('other');?></p>
                                <p><?php echo getAmtCustom($quotation_details->other) ?></p>
                            </div>
                            <div class="details_footer d-flex justify-content-between foot_common_bg br-3">
                                <p class="color-71"><?php echo lang('grand_total');?></p>
                                <p><?php echo getAmtCustom($quotation_details->grand_total) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="box-footer"> 
                <a href="<?php echo base_url() ?>Quotation/printInvoice/<?php echo $encrypted_id; ?>"
                class="btn bg-blue-btn"><?php echo lang('print'); ?></a>
                <a href="<?php echo base_url() ?>Quotation/addEditQuotation/<?php echo $encrypted_id; ?>"
                class="btn bg-blue-btn"><?php echo lang('edit'); ?></a>
                <a href="<?php echo base_url() ?>Quotation/quotations"
                    class="btn bg-blue-btn"><?php echo lang('back'); ?></a>
            </div>
        </div>
    </div>
</div>

