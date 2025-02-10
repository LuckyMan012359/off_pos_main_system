<div class="main-content-wrapper">

    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo lang('view_installment_customer'); ?>: <?= escape_output($customer_information->name)?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('installment_customer'), 'secondSection'=> lang('view_installment_customer') . ' ' . $customer_information->name])?>
        </div>
    </section>

    <div class="box-wrapper">
        <div class="table-box">
            <div id="printableArea" class="box-body">
                <div class="col-md-6">
                    <table class="table view_details_table">
                        <tr>
                            <td>
                                <h4 class="m-0"><?php echo lang('information');?> <?php echo lang('of');?> <?php echo escape_output($customer_information->name);?></h4>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="view_detail_border_right"><strong><?php echo lang('customer_name');?></strong></td>
                            <td class="view_detail_border_right"> <?= escape_output($customer_information->name)?></td>
                        </tr>
                        <tr>
                            <td class="view_detail_border_right"><strong><?php echo lang('phone');?></strong></td>
                            <td class="view_detail_border_right"> <?= escape_output($customer_information->phone)?></td>
                        </tr>
                        <tr>
                            <td class="view_detail_border_right"><strong><?php echo lang('email');?></strong></td>
                            <td class="view_detail_border_right"> <?= escape_output($customer_information->email)?></td>
                        </tr>
                        <tr>
                            <td class="view_detail_border_right"><strong><?php echo lang('present_address');?></strong></td>
                            <td class="view_detail_border_right"> <?= escape_output($customer_information->address)?></td>
                        </tr>
                        <tr>
                            <td class="view_detail_border_right"><strong><?php echo lang('Permanent_Address');?></strong></td>
                            <td class="view_detail_border_right"> <?= escape_output($customer_information->permanent_address)?></td>
                        </tr>
                        <tr>
                            <td class="view_detail_border_right"><strong><?php echo lang('Work_Address');?></strong></td>
                            <td class="view_detail_border_right"> <?= escape_output($customer_information->work_address)?></td>
                        </tr>
                        <tr>
                            <td class="view_detail_border_right"><strong><?php echo lang('customer_nid');?></strong></td>
                            <td class="view_detail_border_right"> <img src="<?php echo base_url();?>uploads/customers/<?php echo escape_output($customer_information->customer_nid);?>" alt="" width="320" height="200"></td>
                        </tr>
                        <tr>
                            <td class="view_detail_border_right"><strong><?php echo lang('customer_photo');?></strong></td>
                            <td class="view_detail_border_right"> <img src="<?php echo base_url();?>uploads/customers/<?php echo escape_output($customer_information->photo);?>" alt="" width="170" height="192"></td>
                        </tr>
                        <tr>
                            <td class="view_detail_border_right"><strong><?php echo lang('Guarantor_Name');?></strong></td>
                            <td class="view_detail_border_right"> <?= escape_output($customer_information->g_name)?></td>
                        </tr>
                        <tr>
                            <td class="view_detail_border_right"><strong><?php echo lang('Guarantor_phone');?></strong></td>
                            <td class="view_detail_border_right"> <?= escape_output($customer_information->g_mobile)?></td>
                        </tr>
                        <tr>
                            <td class="view_detail_border_right"><strong><?php echo lang('Guarantor_Present_Address');?></strong></td>
                            <td class="view_detail_border_right"> <?= escape_output($customer_information->g_pre_address)?></td>
                        </tr>
                        <tr>
                            <td class="view_detail_border_right"><strong><?php echo lang('Guarantor_Permanent_Address');?></td>
                            <td class="view_detail_border_right"> <?= escape_output($customer_information->g_permanent_address)?></td>
                        </tr>
                        <tr>
                            <td class="view_detail_border_right"><strong><?php echo lang('Guarantor_Work_Address');?></td>
                            <td class="view_detail_border_right"> <?= escape_output($customer_information->g_work_address)?></td>
                        </tr>
                        <tr>
                            <td class="view_detail_border_right"><strong><?php echo lang('Guarantor_NID');?></td>
                            <td class="view_detail_border_right"> <img src="<?php echo base_url();?>uploads/customers/<?php echo escape_output($customer_information->g_nid);?>" alt="" width="320" height="200"></td>
                        </tr>
                        <tr>
                            <td class="view_detail_border_right"><strong><?php echo lang('Guarantor_photo');?></td>
                            <td class="view_detail_border_right"> <img src="<?php echo base_url();?>uploads/customers/<?php echo escape_output($customer_information->g_photo);?>" alt="" width="170" height="192"></td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="box-footer">
                <a  class="btn bg-blue-btn" id="print_trigger">
                    <iconify-icon icon="solar:printer-2-broken"></iconify-icon>
                    <?php echo lang('print'); ?>
                </a>
                <a class="btn bg-blue-btn text-decoration-none" href="<?php echo base_url() ?>Installment/customers">
                    <iconify-icon icon="solar:undo-left-round-broken"></iconify-icon>
                    <?php echo lang('back'); ?>
                </a>
            </div>

        </div>
    </div>
</div>





<script src="<?php echo base_url(); ?>frequent_changing/js/print_trigger.js"></script>



