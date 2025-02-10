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
                <h3 class="top-left-header"><?php echo lang('list_customer_due_receive'); ?> </h3>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('list_customer_due_receive'); ?>" data-id_name="datatable">
                <div class="btn_list m-right d-flex">
                    <a class="new-btn me-1" href="<?php echo base_url() ?>Customer_due_receive/addCustomerDueReceive">
                    <iconify-icon icon="solar:add-circle-broken" width="22"></iconify-icon> <?php echo lang('add_customer_due_receive'); ?>
                    </a>
                    <a class="new-btn me-1" href="<?php echo base_url() ?>Customer_due_receive/sendSMSAll">
                    <iconify-icon icon="solar:map-arrow-square-broken" width="22"></iconify-icon> <?php echo lang('send_sms'); ?>
                    </a>

                    <button type="button" class="dataFilterBy new-btn"><iconify-icon icon="solar:filter-broken"  width="22"></iconify-icon> <?php echo lang('filter_by');?></button>
                </div>
                
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('customer_due_receive'), 'secondSection'=> lang('list_customer_due_receive')])?>
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
                                <th class="w-10"><?php echo lang('ref_no'); ?></th>
                                <th class="w-10"><?php echo lang('date'); ?></th>
                                <th class="w-10"><?php echo lang('customer'); ?></th>
                                <th class="w-10 text-center"><?php echo lang('amount'); ?></th>
                                <th class="w-15"><?php echo lang('payment_methods'); ?></th>
                                <th class="w-20"><?php echo lang('note'); ?></th>
                                <th class="w-10"><?php echo lang('added_by'); ?></th>
                                <th class="w-10"><?php echo lang('added_date'); ?></th>
                                <th class="w-5"><?php echo lang('actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($customerDueReceives && !empty($customerDueReceives)) {
                                $i = count($customerDueReceives);
                            }
                            foreach ($customerDueReceives as $value) {
                                ?>                       
                                <tr> 
                                    <td><?php echo $i--; ?></td>
                                    <td><?php echo escape_output($value->reference_no); ?></td>
                                    <td><?php echo dateFormat($value->date); ?> </td>
                                    <td><?php echo getCustomerName($value->customer_id); ?></td>
                                    <td class="text-center"><?php echo getAmtCustom($value->amount); ?></td>
                                    <td><?php echo getPaymentName($value->payment_method_id); ?></td>
                                    <td><?php if ($value->note != NULL) echo escape_output($value->note); ?></td>
                                    <td><?php echo escape_output($value->added_by); ?></td>
                                    <td><?php echo dateFormat($value->added_date); ?></td>
                                    <td>
                                        <div class="btn_group_wrap">
                                            <a class="btn btn-unique" href="<?php echo base_url() ?>Customer_due_receive/print_invoice/<?php echo escape_output($this->custom->encrypt_decrypt($value->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-original-title="<?php echo lang('print_invoice'); ?>">
                                            <i class="fas fa-print"></i>
                                            </a>

                                            <a class="btn btn-cyan" href="<?php echo base_url() ?>Customer_due_receive/a4InvoicePDF/<?php echo escape_output($this->custom->encrypt_decrypt($value->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-original-title="<?php echo lang('download_invoice'); ?>">
                                            <i class="fas fa-download"></i>
                                            </a>

                                            <a class="delete btn btn-danger" href="<?php echo base_url() ?>Customer_due_receive/deleteCustomerDueReceive/<?php echo escape_output($this->custom->encrypt_decrypt($value->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php echo lang('delete'); ?>">
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
        <?php echo form_open(base_url() . 'Customer_due_receive/customerDueReceives') ?>
            <div class="row">
                <div class="col-sm-12 col-md-6 mb-2">
                    <div class="form-group">
                        <input  autocomplete="off" type="text" id="startDate" name="startDate" readonly class="form-control customDatepicker" placeholder="<?php echo lang('start_date'); ?>" value="<?php echo isset($_POST['startDate']) && $_POST['startDate'] ? $_POST['startDate'] : '' ?>">
                    </div>
                    <div class="alert alert-error error-msg startDate_err_msg_contnr ">
                        <p id="startDate_err_msg"></p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 mb-2">
                    <div class="form-group">
                        <input  autocomplete="off" type="text" id="endDate" name="endDate" readonly class="form-control customDatepicker" placeholder="<?php echo lang('end_date'); ?>" value="<?php echo isset($_POST['endDate']) && $_POST['endDate'] ? $_POST['endDate'] : '' ?>">
                    </div>
                    <div class="alert alert-error error-msg endDate_err_msg_contnr ">
                        <p id="endDate_err_msg"></p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 mb-2">
                    <div class="form-group">
                        <select  class="form-control select2 op_width_100_p" id="customer_id" name="customer_id">
                            <option value=""><?php echo lang('select_customer'); ?></option>
                            <?php
                            foreach ($customers as $value) {
                                ?>
                                <option <?php echo isset($_POST['customer_id']) && $_POST['customer_id'] ? ($_POST['customer_id'] == $value->id ? 'selected' : '') : '' ?> value="<?php echo escape_output($value->id) ?>"><?php echo escape_output($value->name) ?></option>
                            <?php } ?>
                        </select>
                        <div class="alert alert-error error-msg customer_id_err_msg_contnr ">
                            <p id="customer_id_err_msg"></p>
                        </div>
                    </div>
                </div>
                <?php
                if(isLMni()):
                ?>
                <div class="col-sm-12 col-md-6 mb-2">
                    <div class="form-group">
                        <select  class="form-control select2 ir_w_100" id="outlet_id" name="outlet_id">
                            <?php
                                $role = $this->session->userdata('role');
                                if($role == '1'){
                            ?>
                            <option value=""><?php echo lang('select_outlet') ?></option>
                            <?php } ?>
                            <?php
                            $outlets = getOutletsForReport();
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
                <div class="col-sm-12 col-md-6 mb-2">
                    <button type="submit" name="submit" value="submit" class="btn bg-blue-btn"><?php echo lang('submit'); ?></button>
                </div>
            </div>
        <?php echo form_close(); ?>
    </div>
</div>



<?php $this->view('updater/reuseJs')?>
<script src="<?php echo base_url(); ?>frequent_changing/js/addCustomerDueReceive.js"></script>

