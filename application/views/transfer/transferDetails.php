<?php 

$company_info = getCompanyInfo($transfer_details->company_id);
$from_outlet = getOutletInfoById($transfer_details->from_outlet_id);
if($transfer_details->to_outlet_id){
    $to_outlet= getOutletInfoById($transfer_details->to_outlet_id);
}else{
    $to_outlet = '';
}
$outlet_id = $this->session->userdata('outlet_id');
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/view_details.css">

<div class="main-content-wrapper">

    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo lang('details_transfer'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('transfer'), 'secondSection'=> lang('details_transfer')])?>
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
                                <h5 class="pb-2"><b><?php echo lang('from_outlet');?></b></h5>
                                <?php if($from_outlet->outlet_name != '' ){ ?>
                                    <p><?php echo lang('outlet_name');?>: <?php echo escape_output($from_outlet->outlet_name);?></p>
                                <?php } ?>
                                <?php if($from_outlet->phone != '' ){ ?>
                                    <p><?php echo lang('phone');?>: <?php echo escape_output($from_outlet->phone);?></p>
                                <?php } ?>
                                <?php if($from_outlet->email != '' ){ ?>
                                    <p><?php echo lang('email');?>: <?php echo escape_output($from_outlet->email);?></p>
                                <?php } ?>
                                <?php if($from_outlet->address != '' ){ ?>
                                    <p><?php echo lang('address');?>: <?php echo escape_output($from_outlet->address);?></p>
                                <?php } ?>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <h5 class="pb-2"><b><?php echo lang('to_outlet');?></b></h5>
                                <?php if($to_outlet){?>
                                <?php if($to_outlet->outlet_name != '' ){ ?>
                                    <p><?php echo lang('outlet_name');?>: <?php echo escape_output($to_outlet->outlet_name);?></p>
                                <?php } ?>
                                <?php if($to_outlet->phone != '' ){ ?>
                                    <p><?php echo lang('phone');?>: <?php echo escape_output($to_outlet->phone);?></p>
                                <?php } ?>
                                <?php if($to_outlet->email != '' ){ ?>
                                    <p><?php echo lang('email');?>: <?php echo escape_output($to_outlet->email);?></p>
                                <?php } ?>
                                <?php if($to_outlet->address != '' ){ ?>
                                    <p><?php echo lang('address');?>: <?php echo escape_output($to_outlet->address);?></p>
                                <?php } ?>
                                <?php } ?>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <h5 class="pb-2"><b><?php echo lang('transfer_info');?></b></h5>
                                <?php if($transfer_details->reference_no != '' ){ ?>
                                    <p><?php echo lang('reference_no');?>: <?php echo escape_output($transfer_details->reference_no);?></p>
                                <?php } ?>
                                <?php if($transfer_details->date != '' ){ ?>
                                    <p><?php echo lang('transfer_date');?>: <?php echo dateFormat($transfer_details->date); ?></p>
                                <?php } ?>
                                <?php if($transfer_details->received_date != '' ){ ?>
                                    <p><?php echo lang('received_date');?>: <?php echo dateFormat($transfer_details->received_date); ?></p>
                                <?php } ?>
                                <?php if($transfer_details->status != '' ){ ?>
                                    <p>
                                        <?php echo lang('transfer_status');?>:
                                        <?php if($transfer_details->status == 1) { ?>
                                            <span class="received_status"><?= lang('received'); ?></span>
                                        <?php } elseif($transfer_details->status == 3){ ?>
                                            <span class="send_status"><?= lang('send'); ?></span>
                                        <?php }else{ ?>
                                            <span class="draft_status"><?= lang('draft'); ?></span>
                                        <?php } ?>
                                    </p>
                                <?php } ?>
                            </div>
                            
                        </div>
                    </div>
                    <div>
                        <h5 class="pt-4 font-width-700"><?php echo lang('Transfer_Summary');?></h5>
                        <div class="table-responsive"> 
                            <table class="table w-100 mt-20">
                                <thead>
                                    <tr>
                                        <th class="text-left w-10"><?php echo lang('sn'); ?></th>
                                        <th class="w-50 text-start">
                                            <span class="transfer_type_name"><?php echo lang('item');?></span> - <?php echo lang('brand'); ?> - <?php echo lang('code'); ?>
                                        </th>
                                        <th class="w-15 text-start"><?php echo lang('expiry_IME_Serial');?></th>
                                        <th class="w-40 text-right"><?php echo lang('quantity_amount'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($food_details as $key=>$value):
                                    $key++;
                                    $p_type = '';
                                    if ($value->item_type == 'Medicine_Product' && $value->expiry_date_maintain == 'Yes'){
                                        $p_type = 'Expiry Date:';
                                    }else if($value->item_type == 'IMEI_Product'){
                                        $p_type = 'IMEI:';
                                    }else if($value->item_type == 'Serial_Product'){
                                        $p_type = 'Serial:';
                                    }
                                    ?>
                                    <tr class="rowCount" data-item_id="<?=$value->ingredient_id?>" data-id="<?=$key?>" id="row_<?=$key?>">
                                        <td><p id="sl_<?=$key?>"><?=$key?></p></td>
                                        <td class="text-start"><span><?php echo getItemNameCodeBrandByItemId($value->ingredient_id) ?> </td>
                                        <td class="text-start">
                                            <span><?php echo $p_type . ' ' . $value->expiry_imei_serial ?></span>
                                        </td>
                                        <td class="text-right"><?php echo ($value->quantity_amount)?> <?php echo unitName(getPurchaseUnitIdByIgId($value->ingredient_id)); ?></td>
                                    </tr>
                                    <?php
                                endforeach;
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="d-grid g-template-c-50-40 grid-gap-10 pt-20">
                        <div>
                            <?php if($transfer_details->note_for_sender){ ?>
                            <div class="pt-20">
                                <h5 class="d-block pb-10"><?php echo lang('note');?></h5>
                                <div class="w-100">
                                    <p>
                                        <?php echo escape_output($transfer_details->note_for_sender) ; ?>
                                    </p>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="box-footer"> 
                <a href="<?php echo base_url() ?>Transfer/printInvoice/<?php echo $this->custom->encrypt_decrypt($transfer_details->id, 'encrypt'); ?>"
                class="btn bg-blue-btn">
                <iconify-icon icon="solar:printer-2-broken"></iconify-icon>
                <?php echo lang('print'); ?></a>
                <?php
                    if($transfer_details->status!=1):
                        if($transfer_details->from_outlet_id == $outlet_id):
                ?>
                <a href="<?php echo base_url() ?>Transfer/addEditTransfer/<?php echo $this->custom->encrypt_decrypt($transfer_details->id, 'encrypt'); ?>"
                class="btn bg-blue-btn">
                <iconify-icon icon="solar:pen-new-round-broken"></iconify-icon>
                <?php echo lang('edit'); ?></a>
                <?php
                    endif;
                    endif;
                ?>
                <a href="<?php echo base_url() ?>Transfer/transfers"
                    class="btn bg-blue-btn">
                    <iconify-icon icon="solar:undo-left-round-broken"></iconify-icon>
                    <?php echo lang('back'); ?>
                </a>
            </div>
        </div>
    </div>
</div>