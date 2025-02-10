<link rel="stylesheet" href="<?php echo base_url()?>frequent_changing/css/checkBotton2.css">

<!-- Main content -->
<section class="main-content-wrapper">
<h3 class="display_none">&nbsp;</h3>

    <?php
    if ($this->session->flashdata('exception')) {

        echo '<section class="alert-wrapper"><div class="alert alert-success alert-dismissible fade show"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <div class="alert-body"><p><i class="m-right fa fa-check"></i>';
        echo escape_output($this->session->flashdata('exception'));unset($_SESSION['exception']);
        echo '</div></div></section>';
    }
    ?>

    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header"><?php echo lang('list_due_installment'); ?></h3>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('list_due_installment'); ?>" data-id_name="datatable">
                <div class="btn_list m-right d-flex">
                    <button type="button" class="dataFilterBy new-btn"><iconify-icon icon="solar:filter-broken"  width="22"></iconify-icon> <?php echo lang('filter_by');?></button>
                </div>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('installment_sale'), 'secondSection'=> lang('list_due_installment')])?>
        </div>
    </section>


    <div class="box-wrapper">
        <div class="table-box">
            <!-- form start -->
            <?php
            echo form_open_multipart(base_url('Installment/sendSMSForDueInstallmentCustomer')); ?>
            <div class="box-body table-responsive list_due_installment_wrapper">
                <table id="datatable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th class="w-10 text-left">
                            <label class="container width_83_p"> <?php echo lang('select_all'); ?>
                                <input class="checkbox_userAll" type="checkbox" id="checkbox_userAll">
                                <span class="checkmark"></span>
                            </label>
                        </th>
                        <th class="w-15" ><?php echo lang('customer_name'); ?> (<?php echo lang('phone');?>)</th>
                        <th class="w-10"><?php echo lang('amount_of_payment'); ?></th>
                        <th class="w-10"><?php echo lang('payment_date'); ?></th>
                        <th class="w-10 text-center"><?php echo lang('paid_amount'); ?></th>
                        <th class="w-10 text-center"><?php echo lang('down_payment'); ?></th>
                        <th class="w-15 text-center"><?php echo lang('remaining_due'); ?></th>
                        <th class="w-15"><?php echo lang('status'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $i=0;
                        if(!isset($due_installment)) return false;
                        foreach($due_installment as $row){
                        $i++; 
                    ?>
                        <tr class="row_counter" data-id="<?php echo escape_output($row->id); ?>">
                            <td>
                                <label class="container"><?php echo lang('select'); ?>
                                    <input type="checkbox"  class="checkbox_user" name="customer_id[]" value="<?php echo escape_output($row->customer_name)?>||<?php echo escape_output($row->customer_phone)?>||<?php echo escape_output($row->item_name)?> || <?php echo escape_output($row->added_date)?> ||<?php echo escape_output($row->amount_of_payment)?> ||<?php echo escape_output($row->payment_date)?>">
                                    <small class="checkmark"></small>
                                </label>
                            </td>
                            <td>
                                <?php echo escape_output($row->customer_name); ?>(<?php echo escape_output($row->customer_phone); ?>)
                            </td>
                            <td><?php echo getAmtCustom($row->amount_of_payment); ?></td>
                            <td><?php echo dateFormat($row->payment_date);?></td>
                            <td class="text-center"><?php echo getAmtCustom($row->paid_amount); ?></td>
                            <td class="text-center"><?php echo getAmtCustom($row->down_payment); ?></td>
                            <td class="text-center"><?php echo getAmtCustom($row->amount_of_payment - $row->paid_amount); ?></td>
                            <td class="text-right"><?php echo escape_output($row->paid_status); ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <div class="box-footer">
                <button type="submit" name="submit" value="submit" class="btn bg-blue-btn">
                    <iconify-icon icon="solar:upload-minimalistic-broken"></iconify-icon>
                    <?php echo lang('submit'); ?>
                </button>
                <a href="<?php echo base_url() ?>Installment/listDueInstallment" class="btn bg-blue-btn">
                    <iconify-icon icon="solar:undo-left-round-broken"></iconify-icon>
                    <?php echo lang('back'); ?>
                </a>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</section>







<div class="filter-overlay"></div>
<div id="product-filter" class="filter-modal">
    <div class="filter-modal-body">
        <header>
                <h3 class="filter-modal-title"><span><?php echo lang('FilterOptions'); ?></span></h3>
                <button type="button" class="close-filter-modal" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                        <i data-feather="x"></i>
                    </span>
                </button>
        </header>
        <?php echo form_open(base_url() . 'Installment/listDueInstallment', $arrayName = array('id' => 'listDueInstallment')) ?>
        <div class="row">
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <select  class="form-control select2 op_width_100_p" id="due_customer_id" name="due_customer_id">
                        <option value=""><?php echo lang('customer'); ?></option>
                        <?php
                        foreach ($customers as $value) {
                            ?>
                            <option value="<?php echo escape_output($value->id) ?>" <?php echo set_select('due_customer_id', $value->id); ?>><?php echo escape_output($value->name); ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <select  class="form-control select2 op_width_100_p" name="due_within">
                        <option value=""><?php echo lang('due_within'); ?></option>
                        <option value="3" <?php echo set_select('due_within', '3');?>><?php echo lang('Days_3'); ?></option>
                        <option value="7" <?php echo set_select('due_within', '7');?>><?php echo lang('Days_7'); ?></option>
                        <option value="15" <?php echo set_select('due_within', '15');?>><?php echo lang('Days_15'); ?></option>
                    </select>
                </div>
            </div>
            <?php
                if(isLMni()):
            ?>
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <select  class="form-control select2 ir_w_100" id="outlet_id" name="outlet_id">
                        <option value=""><?php echo lang('outlet'); ?></option>
                        <?php
                        $outlets = getAllOutlestByAssign();
                        foreach ($outlets as $value):
                        ?>
                            <option <?= set_select('outlet_id',$value->id)?>  value="<?php echo escape_output($value->id) ?>"><?php echo escape_output($value->outlet_name) ?></option>
                        <?php
                        endforeach;
                        ?>
                    </select>
                </div>
            </div>
            <?php
                endif;
            ?>
            <div class="col-12 mb-2">
                <button type="submit" name="submit" value="submit" class="new-btn">
                    <iconify-icon icon="solar:hourglass-broken" width="22"></iconify-icon>
                    <?php echo lang('submit'); ?>
                </button>
            </div>
        </div>
        
        
        <?php echo form_close(); ?>
    </div>
</div>




<script src="<?php echo base_url(); ?>frequent_changing/js/due-installment.js"></script>
<?php $this->view('updater/reuseJs')?>