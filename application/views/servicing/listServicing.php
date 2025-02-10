<input type="hidden" id="status_change" value="<?php echo lang('status_change');?>">
<div class="main-content-wrapper">
    <div id="message"></div>

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
                <h3 class="top-left-header"><?php echo lang('list_servicing'); ?> </h3>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('list_servicing'); ?>" data-id_name="datatable">
                <div class="btn_list m-right d-flex">
                    <a class="new-btn me-1" href="<?php echo base_url() ?>Servicing/addEditServicing">
                    <iconify-icon icon="solar:add-circle-broken" width="22"></iconify-icon> <?php echo lang('add_servicing'); ?>
                    </a>
                    <button type="button" class="dataFilterBy new-btn"><iconify-icon icon="solar:filter-broken"  width="22"></iconify-icon> <?php echo lang('filter_by');?></button>
                </div>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('servicing'), 'secondSection'=> lang('list_servicing')])?>
        </div>
    </section>



    <div class="box-wrapper">
        <div class="table-box"> 
            <div class="box-body">
                <div class="table-responsive"> 
                    <table id="datatable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="w-5"><?php echo lang('sn'); ?></th>
                                <th class="w-10"><?php echo lang('customer_name'); ?></th>
                                <th class="w-10"><?php echo lang('product_name'); ?></th>
                                <th class="w-10 text-center"><?php echo lang('servicing_charge'); ?></th>
                                <th class="w-10 text-center"><?php echo lang('paid_amount'); ?></th>
                                <th class="w-10 text-center"><?php echo lang('due_amount'); ?></th>
                                <th class="w-10"><?php echo lang('receiving_date'); ?></th>
                                <th class="w-10"><?php echo lang('delivery_date'); ?></th>
                                <th class="w-10"><?php echo lang('status'); ?> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</th>
                                <th class="w-10"><?php echo lang('added_by'); ?></th>
                                <th class="w-10"><?php echo lang('added_date'); ?></th>
                                <th class="w-5"><?php echo lang('actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($servicing && !empty($servicing)) {
                                $i = count($servicing);
                            }
                            foreach ($servicing as $value) {
                            ?>                       
                                <tr> 
                                    <td class="op_center"><?php echo $i--; ?></td>
                                    <td><?php echo escape_output($value->customer_name); ?></td>
                                    <td><?php echo escape_output($value->product_name); ?></td>
                                    <td class="text-center"><?php echo getAmtCustom($value->servicing_charge); ?></td>
                                    <td class="text-center"><?php echo getAmtCustom($value->paid_amount); ?></td>
                                    <td class="text-center"><?php echo getAmtCustom($value->due_amount); ?></td>
                                    <td><?php echo dateFormat($value->receiving_date); ?></td>
                                    <td><?php echo dateFormat($value->delivery_date); ?></td>
                                    <td>
                                        <select  class="form-control select2 status_change" name="status" id="status" item-id="<?php echo escape_output($value->id);?>">
                                            <option <?php echo escape_output($value->status) == 'Received' ? 'selected' : '' ?> value="Received"><?php echo lang('received');?></option>
                                            <option <?php echo escape_output($value->status) == 'Delivered' ? 'selected' : '' ?> value="Delivered"><?php echo lang('delivered');?></option>
                                        </select>
                                    </td>
                                    <td><?php echo escape_output($value->added_by); ?></td>
                                    <td><?php echo dateFormat($value->added_date); ?></td>
                                    <td>
                                        <div class="btn_group_wrap">
                                            <a class="view_invoice btn btn-deep-purple" href="javascript:void(0)" invoice_id="<?php echo escape_output($this->custom->encrypt_decrypt($value->id, 'encrypt')); ?>" onclick="viewInvoice(<?php echo escape_output($this->custom->encrypt_decrypt($value->id, 'encrypt')); ?>)" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php echo lang('print_invoice');?>">
                                            <i class="fas fa-print"></i></a>
                                            </a>
                                            <a class="btn btn-unique" href="<?php echo base_url() ?>Servicing/a4InvoicePDF/<?php echo escape_output($this->custom->encrypt_decrypt($value->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php echo lang('download_invoice');?>">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            
                                            <a class="btn btn-warning" href="<?php echo base_url() ?>Servicing/addEditServicing/<?php echo escape_output($this->custom->encrypt_decrypt($value->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-original-title="<?php echo lang('edit'); ?>">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            <a class="delete btn btn-danger" href="<?php echo base_url() ?>Servicing/deleteServicing/<?php echo escape_output($this->custom->encrypt_decrypt($value->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php echo lang('delete'); ?>">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </a>
                                        </div>

                                    </td>
                                </tr>
                            <?php
                            }
                            ?> 
                        </tbody>
                        
                    </table>
                </div>
            </div>
        </div> 
    </div>
</div>



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
        <?php echo form_open(base_url() . 'Servicing/listServicing') ?>
        <div class="row">
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <select name="customer_id" id="customer_id" class="form-control  select2" >
                        <option value=""><?php echo lang('customer'); ?></option>
                        <?php foreach ($customers as $customer) { ?>
                            <option value="<?php echo escape_output($customer->id) ?>" <?php echo set_select('customer_id', $customer->id); ?>><?php echo escape_output($customer->name) ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <select name="status" class="form-control select2 mx-2">
                        <option value=""><?php echo lang('status'); ?></option>
                        <option value="Received" <?php echo set_select('status', 'Received'); ?>><?php echo lang('received') ?></option>
                        <option value="Delivered" <?php echo set_select('status', 'Delivered'); ?>><?php echo lang('delivered') ?></option>
                    </select>
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <button type="submit" name="submit" value="submit" class="new-btn">
                    <iconify-icon icon="solar:hourglass-broken" width="22"></iconify-icon>
                    <?php echo lang('submit'); ?>
                </button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>

<?php $this->view('updater/reuseJs'); ?>
<script src="<?php echo base_url(); ?>frequent_changing/js/servicing.js"></script>
