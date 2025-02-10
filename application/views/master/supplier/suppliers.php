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
                <h3 class="top-left-header"><?php echo lang('list_supplier'); ?> </h3>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('list_supplier'); ?>" data-id_name="datatable">
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('supplier'), 'secondSection'=> lang('list_supplier')])?>
        </div>
    </section>



    <div class="box-wrapper">

        <div class="text-right d-flex justify-content-end">
            <a class="new-btn me-1" href="<?php echo base_url() ?>Supplier/addEditSupplier">
                <iconify-icon icon="solar:add-circle-broken" width="22"></iconify-icon> <?php echo lang('add_supplier'); ?>
            </a>
            <a class="new-btn me-1" href="<?php echo base_url() ?>Supplier/uploadSupplier">
                <iconify-icon icon="solar:cloud-upload-broken" width="22"></iconify-icon> <?php echo lang('upload_supplier'); ?>
            </a>
            <a class="new-btn me-1" href="<?php echo base_url() ?>Supplier/debitSuppliers">
                <iconify-icon icon="solar:minus-circle-broken" width="22"></iconify-icon> <?php echo lang('debit_supplier'); ?>
            </a>
            <a class="new-btn me-1" href="<?php echo base_url() ?>Supplier/creditSuppliers">
                <iconify-icon icon="solar:add-circle-broken" width="22"></iconify-icon> <?php echo lang('credit_supplier'); ?>
            </a>
        </div>

        <div class="table-box"> 
            <div class="box-body">
                <div class="table-responsive"> 
                    <table id="datatable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="w-5"><?php echo lang('sn'); ?></th>
                                <th class="w-20"><?php echo lang('name'); ?></th>
                                <th class="w-10"><?php echo lang('contact_person'); ?></th>
                                <th class="w-15"><?php echo lang('phone'); ?></th>
                                <th class="w-15 text-center"><?php echo lang('current_balance'); ?></th>
                                <th class="w-10"><?php echo lang('added_by'); ?></th>
                                <th class="w-15"><?php echo lang('added_date'); ?></th>
                                <th class="w-5"><?php echo lang('actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $supplier_debit_sum = 0;
                            $supplier_credit_sum = 0;
                            if ($suppliers && !empty($suppliers)) {
                                $i = count($suppliers); 
                            }
                            foreach ($suppliers as $si) {
                                ?>                       
                                <tr> 
                                    <td class="op_center"><?php echo $i--; ?></td>
                                    <td><?php echo escape_output($si->name); ?></td> 
                                    <td><?php echo escape_output($si->contact_person); ?></td> 
                                    <td><?php echo escape_output($si->phone); ?></td> 
                                    <?php if($si->opening_balance < 0){?>
                                        <td class="text-center"><?php
                                            $supplier_debit_sum += $si->opening_balance;
                                            echo getAmtCustom(absCustom($si->opening_balance)); ?> (<?php echo lang('Debit');?>)</td> 
                                    <?php }else if($si->opening_balance > 0) { 
                                        $supplier_credit_sum += $si->opening_balance;
                                        ?>
                                        <td class="text-center"><?php echo getAmtCustom($si->opening_balance); ?> (<?php echo lang('Credit');?>)</td> 
                                    <?php }else { ?>
                                        <td class="text-center"><?php echo escape_output($si->opening_balance) == 0 ? '' : ''; ?></td> 
                                    <?php } ?>
                                    <td><?php echo escape_output($si->added_by); ?></td>  
                                    <td><?php echo date($this->session->userdata('date_format'), strtotime($si->added_date != '' ? $si->added_date : '')); ?></td>  
                                    <td class="text-center">
                                        <div class="btn_group_wrap">
                                            <a class="btn btn-cyan" href="<?php echo base_url() ?>Supplier/supplierDetails/<?php echo $this->custom->encrypt_decrypt($si->id, 'encrypt'); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-original-title="<?php echo lang('view_details'); ?>">
                                            <i class="far fa-eye"></i>
                                            </a>
                                            <a class="btn btn-warning" href="<?php echo base_url() ?>Supplier/addEditSupplier/<?php echo $this->custom->encrypt_decrypt($si->id, 'encrypt'); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-original-title="<?php echo lang('edit'); ?>">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            <a class="delete btn btn-danger" href="<?php echo base_url() ?>Supplier/deleteSupplier/<?php echo $this->custom->encrypt_decrypt($si->id, 'encrypt'); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php echo lang('delete'); ?>">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?> 
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <th><?php echo lang('Total_Credit_Amount'); ?></th>
                                <th class="text-center">
                                    <?php echo escape_output($supplier_credit_sum) == 0 ? '' : getAmtCustom($supplier_credit_sum); ?>
                                </th>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <th><?php echo lang('Total_Debit_Amount'); ?> </th>
                                <th class="text-center">
                                    <?php echo absCustom($supplier_debit_sum) == 0 ? '' : getAmtCustom(absCustom($supplier_debit_sum)); ?>
                                </th>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> 
    </div>
</div>
<?php $this->view('updater/reuseJs')?>