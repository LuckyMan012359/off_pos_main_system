<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/view_details.css">
<div class="main-content-wrapper">

    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo lang('customer_details_of'); ?>: <?= escape_output($customer_details->name)?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('customer'), 'secondSection'=> lang('customer_details_of') . ' ' . $customer_details->name])?>
        </div>
    </section>


    <div class="box-wrapper">
        <div class="table-box">
            <div class="box-body" id="printableArea">
                <div class="row" id="customer_details2">
                    <div class="col-xl-6 col-lg-6 col-md-10 col-sm-12">
                        <table class="table view_details_table">
                            <tr>
                                <td>
                                    <h4 class="m-0"><?php echo lang('information');?> <?php echo lang('of');?> <?php echo escape_output($customer_details->name);?></h4>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="view_detail_border_right"><strong><?php echo lang('name');?></strong></td>
                                <td class="view_detail_border_right"> <?= escape_output($customer_details->name)?></td>
                            </tr>
                            <?php if($customer_details->phone != ''){ ?>
                            <tr>
                                <td class="view_detail_border_right"><strong><?php echo lang('phone');?></strong></td>
                                <td class="view_detail_border_right"> <?= escape_output($customer_details->phone)?></td>
                            </tr>
                            <?php } ?>
                            <?php if($customer_details->email != ''){ ?>
                            <tr>
                                <td class="view_detail_border_right"><strong><?php echo lang('email');?></strong></td>
                                <td class="view_detail_border_right"> <?= escape_output($customer_details->email)?></td>
                            </tr>
                            <?php } ?>
                            <?php if($customer_details->address != ''){ ?>
                            <tr>
                                <td class="view_detail_border_right"><strong><?php echo lang('address');?></strong></td>
                                <td class="view_detail_border_right"> <?= escape_output($customer_details->address)?></td>
                            </tr>
                            <?php } ?>
                            <?php if($customer_details->nid != ''){ ?>
                            <tr>
                                <td class="view_detail_border_right"><strong><?php echo lang('father_name_NID');?></strong></td>
                                <td class="view_detail_border_right"> <?= escape_output($customer_details->nid)?></td>
                            </tr>
                            <?php } ?>
                            <?php 
                                $customer_due =  companyCustomerDue($customer_details->id);
                            ?>
                            <tr>
                                <td class="view_detail_border_right"><strong><?php echo lang('opening_balance');?></strong></td>
                                <?php if($customer_due < 0){?>
                                    <td class="view_detail_border_right"><?php echo getAmtCustom(absCustom($customer_due)); ?> (<?php echo lang('Credit');?>)</td> 
                                <?php }else if($customer_due > 0) { ?>
                                    <td class="view_detail_border_right"><?php echo getAmtCustom(absCustom($customer_due)); ?> (<?php echo lang('Debit');?>)</td> 
                                <?php }else { ?>
                                    <td class="view_detail_border_right"><?php echo getAmtCustom($customer_due); ?></td> 
                                <?php } ?>
                            </tr>
                            <?php if($customer_details->credit_limit != ''){ ?>
                            <tr>
                                <td class="view_detail_border_right"><strong><?php echo lang('credit_limit');?></strong></td>
                                <td class="view_detail_border_right"> <?= getAmtCustom($customer_details->credit_limit)?></td>
                            </tr>
                            <?php } ?>
                            
                            <?php 
                            $group_name = getGroup($customer_details->group_id);
                            if($group_name){ ?>
                            <tr>
                                <td class="view_detail_border_right"><strong><?php echo lang('group');?></strong></td>
                                <td class="view_detail_border_right"> <?= escape_output($group_name)?></td>
                            </tr>
                            <?php } ?>
                            <?php if($customer_details->date_of_birth != ''){ ?>
                            <tr>
                                <td class="view_detail_border_right"><strong><?php echo lang('date_of_birth');?></strong></td>
                                <td class="view_detail_border_right"><?php echo date($this->session->userdata('date_format'), strtotime($customer_details->date_of_birth != '' ? $customer_details->date_of_birth : '')); ?></td>
                            </tr>
                            <?php } ?>
                            <?php if($customer_details->date_of_anniversary != ''){ ?>
                            <tr>
                                <td class="view_detail_border_right"><strong><?php echo lang('date_of_anniversary');?></strong></td>
                                <td class="view_detail_border_right"><?php echo date($this->session->userdata('date_format'), strtotime($customer_details->date_of_anniversary != '' ? $customer_details->date_of_anniversary : '')); ?></td>
                            </tr>
                            <?php } ?>
                            <?php if($customer_details->permanent_address != ''){ ?>
                            <tr>
                                <td class="view_detail_border_right"><strong><?php echo lang('permanent_address');?></strong></td>
                                <td class="view_detail_border_right"> <?= escape_output($customer_details->permanent_address)?></td>
                            </tr>
                            <?php } ?>
                            <?php if($customer_details->work_address != ''){ ?>
                            <tr>
                                <td class="view_detail_border_right"><strong><?php echo lang('work_address');?></strong></td>
                                <td class="view_detail_border_right"> <?= escape_output($customer_details->work_address)?></td>
                            </tr>
                            <?php } ?>
                            <?php if($customer_details->customer_nid != ''){ ?>
                            <tr>
                                <td class="view_detail_border_right"><strong><?php echo lang('customer_nid');?></strong></td>
                                <td class="view_detail_border_right">
                                    <img src="<?php echo base_url();?>/uploads/customers/<?php echo escape_output($customer_details->customer_nid); ?>" alt="<?php echo escape_output($customer_details->customer_nid); ?>">
                                </td>
                            </tr>
                            <?php } ?>
                            <?php if($customer_details->g_name != ''){ ?>
                            <tr>
                                <td class="view_detail_border_right"><strong><?php echo lang('guarantor_name');?></strong></td>
                                <td class="view_detail_border_right"> <?= escape_output($customer_details->g_name)?></td>
                            </tr>
                            <?php } ?>
                            <?php if($customer_details->g_mobile != ''){ ?>
                            <tr>
                                <td class="view_detail_border_right"><strong><?php echo lang('guarantor_mobile');?></strong></td>
                                <td class="view_detail_border_right"> <?= escape_output($customer_details->g_mobile)?></td>
                            </tr>
                            <?php } ?>
                            <?php if($customer_details->g_nid != ''){ ?>
                            <tr>
                                <td class="view_detail_border_right"><strong><?php echo lang('guarantor_nid');?></strong></td>
                                <td class="view_detail_border_right"><img height="210" width="325" src="<?php echo base_url();?>/uploads/customers/<?php echo escape_output($customer_details->g_nid); ?>" alt=""></td>
                            </tr>
                            <?php } ?>
                            <?php if($customer_details->g_photo != ''){ ?>
                            <tr>
                                <td class="view_detail_border_right"><strong><?php echo lang('guarantor_photo');?></strong></td>
                                <td class="view_detail_border_right"><img src="<?php echo base_url();?>/uploads/customers/<?php echo escape_output($customer_details->g_photo); ?>" alt="" width="170" height="192"></td>
                            </tr>
                            <?php } ?>
                            <?php if($customer_details->g_pre_address != ''){ ?>
                            <tr>
                                <td class="view_detail_border_right"><strong><?php echo lang('guarantor_present_address');?></strong></td>
                                <td class="view_detail_border_right"> <?= escape_output($customer_details->g_pre_address)?></td>
                            </tr>
                            <?php } ?>
                            <?php if($customer_details->g_permanent_address != ''){ ?>
                            <tr>
                                <td class="view_detail_border_right"><strong><?php echo lang('guarantor_permanent_address');?></strong></td>
                                <td class="view_detail_border_right"> <?= escape_output($customer_details->g_permanent_address)?></td>
                            </tr>
                            <?php } ?>
                            <?php if($customer_details->g_work_address != ''){ ?>
                            <tr>
                                <td class="view_detail_border_right"><strong><?php echo lang('guarantor_work_address');?></strong></td>
                                <td class="view_detail_border_right"> <?= escape_output($customer_details->g_work_address)?></td>
                            </tr>
                            <?php } ?>
                            <?php if($customer_details->photo != ''){ ?>
                            <tr>
                                <td class="view_detail_border_right"><strong><?php echo lang('photo');?></strong></td>
                                <td class="view_detail_border_right"><img src="<?php echo base_url();?>/uploads/customers/<?php echo escape_output($customer_details->photo); ?>" alt="" width="170" height="192"></td>
                            </tr>
                            <?php } ?>
                            <?php if($customer_details->discount != '0'){ ?>
                            <tr>
                                <td class="view_detail_border_right"><strong><?php echo lang('discount');?></strong></td>
                                <td class="view_detail_border_right"> <?= escape_output($customer_details->discount)?></td>
                            </tr>
                            <?php } ?>
                            <?php if($customer_details->price_type != ''){ ?>
                            <tr>
                                <td class="view_detail_border_right"><strong><?php echo lang('price_type');?></strong></td>
                                <td class="view_detail_border_right"> <?= escape_output($customer_details->price_type == 1 ? 'Retail' : 'Wholesale')?></td>
                            </tr>
                            <?php } ?>

                            <?php if(collectGST()=="Yes"){?>
                            <?php if($customer_details->same_or_diff_state != ''){ ?>
                            <tr>
                                <td class="view_detail_border_right"><strong><?php echo lang('same_or_diff_state');?></strong></td>
                                <td class="view_detail_border_right"> <?= escape_output($customer_details->same_or_diff_state == 1 ? 'Same State' : 'Different State')?></td>
                            </tr>
                            <?php } }?>
                            <?php if(collectGST()=="Yes"){?>
                            <?php if($customer_details->gst_number != ''){ ?>
                            <tr>
                                <td class="view_detail_border_right"><strong><?php echo lang('gst_number');?></strong></td>
                                <td class="view_detail_border_right"> <?= escape_output($customer_details->gst_number)?></td>
                            </tr>
                            <?php } }?>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <a href="javascript:void(0)" class="btn bg-blue-btn" id="print_trigger">
                    <iconify-icon icon="solar:printer-2-broken"></iconify-icon>
                    <?php echo lang('print'); ?>
                </a>
                <a class="btn bg-blue-btn" href="<?php echo base_url() ?>Customer/customers">
                    <iconify-icon icon="solar:undo-left-round-broken"></iconify-icon>
                    <?php echo lang('back'); ?>
                </a>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>frequent_changing/js/print_trigger.js"></script>
