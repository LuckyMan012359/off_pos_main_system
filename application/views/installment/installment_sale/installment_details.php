<?php 


$company_info = getCompanyInfo($installment->company_id);
$outlet_info = getOutletInfoById($installment->outlet_id);
$outlet_info = getOutletInfoById($installment->outlet_id);
$customer_info = getCustomer($installment->customer_id);
?>


<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/view_details.css">

<div class="main-content-wrapper">

    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo lang('installment_sale_details'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('installment_sale'), 'secondSection'=> lang('installment_sale_details')])?>
        </div>
    </section>


    <div class="box-wrapper">
        <div class="table-box">
            <div id="printableArea" class="box-body">
                <div id="wrapper" class="m-auto border-2s-e4e5ea br-5 br-5">
                    <div>
                        <div class="row  mt-3">
                            
                            <div class="col-lg-6 col-md-6">
                                <h5 class="pb-2"><?php echo escape_output($this->session->userdata('business_name')); ?></h5>
                                <?php if($outlet_info->address != '' ){ ?>
                                    <p><?php echo escape_output($outlet_info->address);?></p>
                                <?php } ?>
                                <?php if($outlet_info->email != '' ){ ?>
                                    <p><?php echo lang('email');?>: <?php echo escape_output($outlet_info->email);?></p>
                                <?php } ?>
                                <?php if($outlet_info->phone != '' ){ ?>
                                    <p><?php echo lang('phone');?>: <?php echo escape_output($outlet_info->phone);?></p>
                                <?php } ?>
                            </div>
                            <div class="col-lg-6 col-md-6 text-right">
                            <?php
                                $invoice_logo = $this->session->userdata('invoice_logo');
                                if($invoice_logo):
                            ?>
                                <img src="<?php echo base_url()?>uploads/site_settings/<?php echo escape_output($invoice_logo)?>">
                            <?php
                                endif;
                            ?>
                            </div>
                            <div class="col-lg-12 col-md-12 mt-3">
                                <h5 class="pb-2"><?php echo lang('customer_info');?></h5>
                                <div class="d-flex">
                                    <div>
                                        <?php
                                            if($customer_info->photo){
                                                $c_photo_path = base_url() . "uploads/customers/" . escape_output($customer_info->photo);
                                            }else{
                                                $c_photo_path = base_url() . "uploads/site_settings/Gallery-PNG-File.png";
                                            }
                                        ?>
                                        
                                        <img src="<?php echo $c_photo_path;?>" alt="<?php echo escape_output($customer_info->name)?>" class="img-passport">
                                        
                                    </div>
                                    <div class="op_padding_left_5">
                                        <?php if($customer_info->name != '' ){ ?>
                                            <p><?php echo lang('name');?>: <?php echo escape_output($customer_info->name);?></p>
                                        <?php } ?>
                                        <?php if($customer_info->phone != '' ){ ?>
                                            <p><?php echo lang('phone');?>: <?php echo escape_output($customer_info->phone);?></p>
                                        <?php } ?>
                                        <?php if($customer_info->email != '' ){ ?>
                                            <p><?php echo lang('email');?>: <?php echo escape_output($customer_info->email);?></p>
                                        <?php } ?>
                                        <?php if($customer_info->permanent_address != '' ){ ?>
                                            <p><?php echo lang('permanent_address');?>: <?php echo escape_output($customer_info->permanent_address);?></p>
                                        <?php } ?>
                                        <?php if($customer_info->work_address != '' ){ ?>
                                            <p><?php echo lang('work_address');?>: <?php echo escape_output($customer_info->work_address);?></p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 mt-3">
                                <h5 class="pb-2"><?php echo lang('Guarantor_Information');?></h5>
                                <div class="d-flex">
                                    <div>
                                        <?php
                                            if($customer_info->g_photo){
                                                $g_photo_path = base_url() . "uploads/customers/" . escape_output($customer_info->g_photo);
                                            }else{
                                                $g_photo_path = base_url() . "uploads/site_settings/Gallery-PNG-File.png";
                                            }
                                        ?>
                                        <img src="<?php echo $g_photo_path;?>" alt="<?php echo escape_output($customer_info->g_name)?>" class="img-passport">
                                    </div>
                                    <div class="op_padding_left_5">
                                        <?php if($customer_info->g_name != '' ){ ?>
                                        <p><?php echo lang('name');?>: <?php echo escape_output($customer_info->g_name);?></p>
                                        <?php } ?>
                                        <?php if($customer_info->g_mobile != '' ){ ?>
                                            <p><?php echo lang('phone');?>: <?php echo escape_output($customer_info->g_mobile);?></p>
                                        <?php } ?>
                                        <?php if($customer_info->g_pre_address != '' ){ ?>
                                            <p><?php echo lang('present_address');?>: <?php echo escape_output($customer_info->g_pre_address);?></p>
                                        <?php } ?>
                                        <?php if($customer_info->g_permanent_address != '' ){ ?>
                                            <p><?php echo lang('permanent_address');?>: <?php echo escape_output($customer_info->g_permanent_address);?></p>
                                        <?php } ?>
                                    
                                        <?php if($customer_info->g_work_address != '' ){ ?>
                                            <p><?php echo lang('work_address');?>: <?php echo escape_output($customer_info->g_work_address);?></p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 mt-3">
                                <h5 class="pb-2"><?php echo lang('sale_information');?></h5>
                                <div class="d-grid grid-template-32 rid-gap-1">
                                <?php if($installment->date != '' ){ ?>
                                    <p><?php echo lang('sale_date');?>: <?php echo date($this->session->userdata('date_format'), strtotime($installment->date)); ?></p>
                                <?php } ?>
                                <?php if($installment->reference_no != '' ){ ?>
                                    <p><?php echo lang('reference_no');?>: <?php echo escape_output($installment->reference_no);?></p>
                                <?php } ?>
                                <?php if($product->name != '' ){ ?>
                                    <p><?php echo lang('product');?>: <?php echo escape_output($product->name . '(' . $product->code . ')');?></p>
                                <?php } ?>
                                <?php if($installment->price != '' ){ ?>
                                    <p><?php echo lang('price');?>: <?php echo getAmtCustom($installment->price);?></p>
                                <?php } ?>
                                <?php if($installment->percentage_of_interest != '' ){ ?>
                                    <p><?php echo lang('percentage_of_interest');?>: <?php echo escape_output($installment->percentage_of_interest);?></p>
                                <?php } ?>
                                <?php if($installment->percentage_of_interest != '' ){ ?>
                                    <p><?php echo lang('amount_of_interest');?>: <?php echo getAmtCustom($installment->price*$installment->percentage_of_interest/100);?></p>
                                <?php } ?>
                                <?php if($installment->down_payment != '' ){ ?>
                                    <p><?php echo lang('down_payment');?>: <?php echo getAmtCustom($installment->down_payment);?></p>
                                <?php } ?>
                                <?php if($installment->number_of_installment != '' ){ ?>
                                    <p><?php echo lang('number_of_installment');?>: <?php echo escape_output($installment->number_of_installment);?></p>
                                <?php } ?>
                                <?php
                                    $remaining_due = getInstallmentRemainingDue($installment->id);
                                ?>
                                <?php if($remaining_due){ ?>
                                    <p><?php echo lang('total_remaining_due');?>: <?php echo getAmtCustom($remaining_due);?></p>
                                <?php } ?>
                                
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="table-responsive"> 
                            <table class="table w-100 mt-20">
                                <thead class="br-3">
                                    <tr>
                                        <th class="w-5"><?php echo lang('sl');?></th>
                                        <th class="w-30"><?php echo lang('installment_date');?></th>
                                        <th class="w-15"><?php echo lang('paid_date');?></th>
                                        <th class="w-15"><?php echo lang('installment_amount');?></th>
                                        <th class="w-15"><?php echo lang('paid_amount');?></th>
                                        <th class="w-20 text-right"><?php echo lang('remaining_due');?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                    $totalInstallment = 0;
                                    $totalPaid = 0;
                                    foreach($installment_payments as $key=>$row){  
                                    $totalInstallment += $row->amount_of_payment;
                                    $totalPaid += $row->paid_amount;
                                    ?>
                                    <tr>
                                        <td><?php echo $key + 1 ?></td>
                                        <td><?php echo dateFormat($row->payment_date); ?></td>
                                        <td><?php echo dateFormat($row->paid_date); ?></td>
                                        <td><?php echo getAmtCustom($row->amount_of_payment); ?></td>
                                        <td><?php echo getAmtCustom($row->paid_amount); ?></td>
                                        <td class="text-right"><?php echo getAmtCustom($row->amount_of_payment - $row->paid_amount); ?></td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th class="text-right"><?php echo lang('total');?></th>
                                    <th><?php echo getAmtCustom($totalInstallment);?></th>
                                    <th><?php echo getAmtCustom($totalPaid);?></th>
                                    <th class="text-right"><?php echo getAmtCustom($remaining_due);?></th>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="box-footer">

                <a class="btn bg-blue-btn" href="<?php echo base_url() ?>Installment/installmentPrint/<?php echo $this->custom->encrypt_decrypt($installment->id, 'encrypt'); ?>" >
                    <iconify-icon icon="solar:printer-2-broken"></iconify-icon>
                    <?php echo lang('print'); ?>
                </a>
                <a href="<?php echo base_url() ?>Installment/addEditInstallmentSale/<?php echo $this->custom->encrypt_decrypt($installment->id, 'encrypt'); ?>" class="btn bg-blue-btn">
                    <iconify-icon icon="solar:pen-new-round-broken" class="me-2"></iconify-icon>
                    <?php echo lang('edit'); ?>
                </a>
                <a class="btn bg-blue-btn text-decoration-none" href="<?php echo base_url() ?>Report/installmentDueReport">
                    <iconify-icon icon="solar:undo-left-round-broken"></iconify-icon>
                    <?php echo lang('back'); ?>
                </a>
            </div>

        </div>
    </div>
</div>


<script src="<?php echo base_url(); ?>frequent_changing/js/print_trigger.js"></script>

