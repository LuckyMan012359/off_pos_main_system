

<div class="main-content-wrapper">

    <?php
    if ($this->session->flashdata('exception')) {
        echo '<section class="alert-wrapper"><div class="alert alert-success alert-dismissible fade show"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></button>
        <div class="alert-body"><i class="icon fa fa-check me-2"></i>';
        echo escape_output($this->session->flashdata('exception'));unset($_SESSION['exception']);
        echo '</div></div></section>';
    }
    ?> 

    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo lang('installment_collections'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('installment_sale'), 'secondSection'=> lang('installment_collections')])?>
        </div>
    </section>


    <div class="box-wrapper">
        <div class="table-box">
            <div class="box-body">
                <?php echo form_open(base_url() . 'Installment/installmentCollections', $arrayName = array('id' => 'purchaseReportByIngredient')) ?>
                <div class="row">
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('customer'); ?></label>
                            <select  class="form-control select2 op_width_100_p" id="customer_id" name="customer_id">
                                <option value=""><?php echo lang('customer'); ?></option>
                                <?php
                                foreach ($customers as $value) {
                                    ?>
                                    <option value="<?php echo escape_output($value->id) ?>" <?php echo set_select('customer_id', $value->id); ?>><?php echo escape_output($value->name); ?> <?php echo escape_output($value->phone ? '(' . $value->phone . ')' : ''); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <input type="hidden" name="hide_ins_id" id="hide_ins_id" value="<?php echo set_value('installment_id')?>">
                        <div class="form-group">
                            <label><?php echo lang('select_installment'); ?></label>
                            <select  class="form-control select2 op_width_100_p" id="installment_id" name="installment_id">
                                <option value=""><?php echo lang('select'); ?></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="d-flex">
                    <button type="submit" name="submit" value="submit" class="btn bg-blue-btn">
                        <iconify-icon icon="solar:upload-minimalistic-broken" class="me-1"></iconify-icon>
                        <?php echo lang('Submit');?>
                    </button>
                    <a href="javascript:void(0)" class="btn bg-blue-btn show_invoice ms-1" target="_blank">
                        <iconify-icon icon="solar:printer-2-broken" class="me-1"></iconify-icon>
                        <?php echo lang('print_invoice');?>
                    </a>
                </div>
                <?php if (isset($payments) && $payments && !empty($payments)) :?>
                <div class="table-box mt-3"> 
                    <!-- /.box-header -->
                    <div class="table-responsive"> 
                        <table id="datatable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th><?php echo lang('sl');?></th>
                                    <th><?php echo lang('installment')." ".lang('date');?></th>
                                    <th><?php echo lang('paid_date');?></th>
                                    <th class="text-center"><?php echo lang('installment_amount');?></th>
                                    <th class="text-center"><?php echo lang('paid_amount');?></th>
                                    <th class="text-center"><?php echo lang('remaining_due');?></th>
                                    <th><?php echo lang('status');?></th>
                                    <th><?php echo lang('payment_methods'); ?></th>
                                    <th class="text-right"><?php echo lang('actions');?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $i=0;
                                    if(!isset($installment_payments)) return false;
                                    foreach($installment_payments as $row){
                                    $i++; 
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo dateFormat($row->payment_date); ?></td>
                                    <td><?php echo dateFormat($row->paid_date); ?></td>
                                    <td class="text-center"><?php echo getAmtCustom($row->amount_of_payment); ?></td>
                                    <td class="text-center" ><?php echo getAmtCustom($row->paid_amount); ?></td>
                                    <td class="text-center"><?php echo getAmtCustom($row->amount_of_payment - $row->paid_amount); ?></td>
                                    <td><?php echo escape_output($row->paid_status); ?></td>
                                    <td><?php echo getPaymentName($row->payment_method_id); ?></td>

                                    <td class="text-center">
                                        <div class="btn_group_wrap">
                                            <a class="btn btn-warning" href="<?php echo base_url(); ?>Installment/installmentCollections/<?php echo $this->custom->encrypt_decrypt($row->id, 'encrypt'); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-original-title="<?php echo lang('edit'); ?>">
                                                <i class="far fa-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <div class="box-footer">
                            <a href="<?php echo base_url() ?>Installment/installmentCollections" class="btn bg-blue-btn">
                                <iconify-icon icon="solar:undo-left-round-broken"></iconify-icon>
                                <?php echo lang('back'); ?>
                            </a>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <?php endif; ?>
                <?php echo form_close(); ?>
            </div>
        </div> 
    </div>
</div>

<?php $this->view('updater/reuseJs')?>
<script src="<?php echo base_url(); ?>frequent_changing/js/installment_collection.js"></script>

