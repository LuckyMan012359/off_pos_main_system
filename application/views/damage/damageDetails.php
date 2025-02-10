<?php 
$company_info = getCompanyInfo($damage_details->company_id);
$outlet_info = getOutletInfoById($damage_details->outlet_id);
$employee_info = getDataById($damage_details->employee_id, 'tbl_users');
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/view_details.css">

<div class="main-content-wrapper">


    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo lang('details_damage'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('damage'), 'secondSection'=> lang('details_damage')])?>
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
                                <h5 class="pb-2"><b><?php echo lang('responsible_person');?></b></h5>
                                <?php if($employee_info->full_name != '' ){ ?>
                                    <p><?php echo lang('name');?>: <?php echo escape_output($employee_info->full_name);?></p>
                                <?php } ?>
                                <?php if($employee_info->phone != '' ){ ?>
                                    <p><?php echo lang('phone');?>: <?php echo escape_output($employee_info->phone);?></p>
                                <?php } ?>
                                <?php if($employee_info->email_address != '' ){ ?>
                                    <p><?php echo lang('email');?>: <?php echo escape_output($employee_info->email_address);?></p>
                                <?php } ?>
                                
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <h5 class="pb-2"><b><?php echo lang('damage_info');?></b></h5>
                                <?php if($damage_details->reference_no != '' ){ ?>
                                    <p><?php echo lang('reference_no');?>: <?php echo escape_output($damage_details->reference_no);?></p>
                                <?php } ?>
                                <?php if($damage_details->date != '' ){ ?>
                                    <p><?php echo lang('date');?>: <?php echo date($this->session->userdata('date_format'), strtotime($damage_details->date)); ?></p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h5 class="pt-4 font-width-700"><?php echo lang('damage_summary');?></h5>
                        <div class="table-responsive"> 
                            <table class="table w-100 mt-20">
                                <thead>
                                        <tr>
                                            <th class="w-25"><?php echo lang('item'); ?> - <?php echo lang('brand'); ?> - <?php echo lang('code'); ?></th>
                                            <th class="w-25"><?php echo lang('quantity_amount'); ?></th>
                                            <th class="w-25"><?php echo lang('loss_amount'); ?></th>
                                        </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    if ($damage_items && !empty($damage_items)) {
                                        foreach ($damage_items as $value) {
                                            $i++;
                                            echo '<tr id="row_' . $i . '">' .
                                            '<td class="w-20"><span class="op_padding_bottom_5">' . getItemNameCodeBrandByItemId($value->item_id) . '</span></td>' .
                                            '<td class="w-15">' . $value->damage_quantity . unitName(getSaleUnitIdByIgId($value->item_id)) . '</td>' .
                                            '<td class="w-15">' . getAmtCustom($value->loss_amount) . '</td>' .
                                            '</tr>';
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
                                <h5 class="d-block pb-10"><?php echo lang('note');?></h5>
                                <div class="w-100">
                                    <p>
                                        <?php echo escape_output($damage_details->note) ; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="details_footer d-flex justify-content-between foot_common_bg">
                                <p class="color-71"><?php echo lang('loss_amount');?></p>
                                <p><?php echo getAmtCustom($damage_details->total_loss) ; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="box-footer"> 
                <a href="<?php echo base_url() ?>Damage/addEditDamage/<?php echo $this->custom->encrypt_decrypt($damage_details->id, 'encrypt'); ?>"
                class="btn bg-blue-btn"><?php echo lang('edit'); ?></a>
                <a href="<?php echo base_url() ?>Damage/damages"
                    class="btn bg-blue-btn"><?php echo lang('back'); ?></a>
            </div>
        </div>
    </div>
</div>