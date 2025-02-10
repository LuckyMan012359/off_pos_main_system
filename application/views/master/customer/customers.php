

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
                <h3 class="top-left-header"><?php echo lang('list_customer'); ?> </h3>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('list_customer'); ?>" data-id_name="datatable">
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('customer'), 'secondSection'=> lang('list_customer')])?>
        </div>
    </section>


    <div class="box-wrapper">
        <div class="text-right d-flex justify-content-end">
            <a class="new-btn me-1" href="<?php echo base_url() ?>Customer/addEditCustomer">
                <iconify-icon icon="solar:add-circle-broken" width="22"></iconify-icon> <?php echo lang('add_customer'); ?>
            </a>
            <a class="new-btn me-1" href="<?php echo base_url() ?>customer/uploadCustomer">
                <iconify-icon icon="solar:cloud-upload-broken" width="22"></iconify-icon> <?php echo lang('upload_customer'); ?>
            </a>
            <a class="new-btn me-1" href="<?php echo base_url() ?>customer/debitCustomers">
                <iconify-icon icon="solar:minus-circle-broken" width="22"></iconify-icon> <?php echo lang('debit_customers'); ?>
            </a>
            <a class="new-btn me-1" href="<?php echo base_url() ?>customer/creditCustomers">
                <iconify-icon icon="solar:add-circle-broken" width="22"></iconify-icon> <?php echo lang('credit_customers'); ?>
            </a>
        </div>

        <div class="table-box"> 
            <div class="box-body">
                <div class="table-responsive"> 
                    <table id="datatable" class="table">
                        <thead>
                            <tr>
                                <th class="w-5"><?php echo lang('sn'); ?></th>
                                <th class="w-15"><?php echo lang('customer_name'); ?></th>   
                                <th class="w-10"><?php echo lang('phone'); ?></th>
                                <th class="w-10"><?php echo lang('email'); ?></th>
                                <th class="w-10 text-center"><?php echo lang('opening_balance'); ?></th>
                                <th class="w-10"><?php echo lang('added_by'); ?></th>
                                <th class="w-10"><?php echo lang('added_date'); ?></th>
                                <th class="w-5 text-center"><?php echo lang('actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($customers && !empty($customers)) {
                                $i = count($customers);
                            }
                            foreach ($customers as $cust) {
                                ?>                       
                                <tr> 
                                    <td class="op_center"><?php echo $i--; ?></td>
                                    <td><?php echo escape_output($cust->name); ?></td> 
                                    <td><?php echo escape_output($cust->phone); ?></td> 
                                    <td><?php echo escape_output($cust->email); ?></td>

                                    <?php if($cust->opening_balance == 0){ ?>
                                        <td class="text-center"><?php echo getAmtCustom(0); ?></td>
                                    <?php }else if($cust->opening_balance > 0){ ?>
                                        <td class="text-center"><?php echo getAmtCustom($cust->opening_balance); ?>(Debit)</td>
                                    <?php }else{ ?>
                                        <td class="text-center"><?php echo getAmtCustom(absCustom($cust->opening_balance)); ?>(Credit)</td>
                                    <?php } ?>
                                    <td><?php echo escape_output($cust->added_by); ?></td>
                                    <td><?php echo dateFormat($cust->added_date); ?></td>
                                    <td>
                                        <?php if ($cust->name != "Walk-in Customer") { ?> 
                                            <div class="btn_group_wrap">
                                                <a class="btn btn-cyan" href="<?php echo base_url() ?>Customer/customerDetails/<?php echo escape_output($this->custom->encrypt_decrypt($cust->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                                data-bs-original-title="<?php echo lang('details'); ?>">
                                                <i class="far fa-eye"></i>
                                                </a>
                                                <a class="btn btn-warning" href="<?php echo base_url() ?>Customer/addEditCustomer/<?php echo escape_output($this->custom->encrypt_decrypt($cust->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                                data-bs-original-title="<?php echo lang('edit'); ?>">
                                                <i class="far fa-edit"></i>
                                                </a>
                                                <a class="delete btn btn-danger" href="<?php echo base_url() ?>Customer/deleteCustomer/<?php echo escape_output($this->custom->encrypt_decrypt($cust->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php echo lang('delete'); ?>">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </a>
                                            </div>
                                        <?php } ?>
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

<?php $this->load->view('updater/reuseJs',true); ?>
