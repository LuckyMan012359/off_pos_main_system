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
                <h3 class="top-left-header"><?php echo lang('credit_suppliers'); ?> </h3>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('credit_suppliers'); ?>" data-id_name="datatable">
                <div class="btn_list m-right d-flex">
                    <a class="new-btn me-1" href="<?php echo base_url() ?>Supplier/suppliers">
                    <iconify-icon icon="solar:checklist-broken" width="22"></iconify-icon> <?php echo lang('suppliers'); ?>
                    </a>
                </div>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('supplier'), 'secondSection'=> lang('credit_suppliers')])?>
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
                                <th class="w-20"><?php echo lang('name'); ?></th>
                                <th class="w-10"><?php echo lang('contact_person'); ?></th>
                                <th class="w-15"><?php echo lang('phone'); ?></th>
                                <th class="w-15 text-center"><?php echo lang('Current_Credit_Amount'); ?></th>
                                <th class="w-10"><?php echo lang('added_by'); ?></th>
                                <th class="w-15"><?php echo lang('added_date'); ?></th>
                                <th class="w-5 text-center"><?php echo lang('actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $supplier_credit_sum = 0;
                            if ($credit_suppliers && !empty($credit_suppliers)) {
                                $i = count($credit_suppliers);
                            }
                            foreach ($credit_suppliers as $si) {
                                $supplier_credit_sum += $si->opening_balance;
                                ?>                       
                                <tr> 
                                    <td class="op_center"><?php echo $i--; ?></td>
                                    <td><?php echo escape_output($si->name); ?></td> 
                                    <td><?php echo escape_output($si->contact_person); ?></td> 
                                    <td><?php echo escape_output($si->phone); ?></td> 
                                    <td class="text-center"><?php echo getAmtCustom(absCustom($si->opening_balance)); ?></td> 
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
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th><?php echo lang('Total_Credit_Amount'); ?>: <?php echo getAmtCustom(absCustom($supplier_credit_sum)); ?></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> 
    </div>
</div>
<?php $this->view('updater/reuseJs')?>