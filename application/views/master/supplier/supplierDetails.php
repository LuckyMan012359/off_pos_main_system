<div class="main-content-wrapper">
    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo lang('supplier_details_of'); ?> <?= escape_output($supplier_details->name)?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('supplier'), 'secondSection'=> lang('supplier_details_of') . ' ' . $supplier_details->name])?>
        </div>
    </section>

    <div class="box-wrapper">
        <div class="table-box">
            <div class="box-body" id="printableArea">
                <div class="row" id="supplier_details2">
                    <div class="col-xl-6 col-lg-6 col-md-10 col-sm-12">
                        <table class="table view_details_table">
                            <tr>
                                <td>
                                    <h4 class="m-0"><?php echo lang('information');?> <?php echo lang('of');?> <?php echo escape_output($supplier_details->name);?></h4>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="view_detail_border_right"><strong><?php echo lang('name');?></strong></td>
                                <td class="view_detail_border_right"> <?= escape_output($supplier_details->name)?></td>
                            </tr>
                            <?php if($supplier_details->contact_person != ''){ ?>
                            <tr>
                                <td class="view_detail_border_right"><strong><?php echo lang('contact_person');?></strong></td>
                                <td class="view_detail_border_right"> <?= escape_output($supplier_details->contact_person)?></td>
                            </tr>
                            <?php } ?>
                            <?php if($supplier_details->phone != ''){ ?>
                            <tr>
                                <td class="view_detail_border_right"><strong><?php echo lang('phone');?></strong></td>
                                <td class="view_detail_border_right"> <?= escape_output($supplier_details->phone)?></td>
                            </tr>
                            <?php } ?>
                            <?php if($supplier_details->email != ''){ ?>
                            <tr>
                                <td class="view_detail_border_right"><strong><?php echo lang('email');?></strong></td>
                                <td class="view_detail_border_right"> <?= escape_output($supplier_details->email)?></td>
                            </tr>
                            <?php } ?>
                            <?php 
                                $supplier_due =  companySupplierDue($supplier_details->id);
                            ?>
                            <tr>
                                <td class="view_detail_border_right"><strong><?php echo lang('opening_balance');?></strong></td>
                                <?php if($supplier_due < 0){?>
                                    <td class="view_detail_border_right"><?php echo absCustom($supplier_due); ?> (<?php echo lang('Debit');?>)</td> 
                                <?php }else if($supplier_due > 0) { ?>
                                    <td class="view_detail_border_right"><?php echo $supplier_due; ?> (<?php echo lang('Credit');?>)</td> 
                                <?php }else { ?>
                                    <td class="view_detail_border_right"><?php echo $supplier_due; ?></td> 
                                <?php } ?>
                            </tr>
                            <?php if($supplier_details->address != ''){ ?>
                            <tr>
                                <td class="view_detail_border_right"><strong><?php echo lang('address');?></strong></td>
                                <td class="view_detail_border_right"> <?= escape_output($supplier_details->address)?></td>
                            </tr>
                            <?php } ?>
                            <?php if($supplier_details->description != ''){ ?>
                            <tr>
                                <td class="view_detail_border_right"><strong><?php echo lang('description');?></strong></td>
                                <td class="view_detail_border_right"> <?= escape_output($supplier_details->description)?></td>
                            </tr>
                            <?php } ?>
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
                <a class="btn bg-blue-btn text-decoration-none" href="<?php echo base_url() ?>Supplier/suppliers">
                    <iconify-icon icon="solar:undo-left-round-broken"></iconify-icon>
                    <?php echo lang('back'); ?>
                </a>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>frequent_changing/js/print_trigger.js"></script>
