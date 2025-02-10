

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
                <h3 class="top-left-header"><?php echo lang('list_installment_customer'); ?> </h3>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('list_installment_customer'); ?>" data-id_name="datatable">
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('installment_customer'), 'secondSection'=> lang('list_installment_customer')])?>
        </div>
    </section>



    <div class="box-wrapper">
        <div class="text-right d-flex justify-content-end">
            <a class="new-btn me-1" href="<?php echo base_url() ?>Installment/addEditCustomer">
                <iconify-icon icon="solar:add-circle-broken" width="22"></iconify-icon> <?php echo lang('add_installment_customer'); ?>
            </a>
            <a class="new-btn me-1" href="<?php echo base_url() ?>Installment/listDueInstallment">
                <iconify-icon icon="solar:map-arrow-square-bold-duotone" width="22"></iconify-icon>
                <?php echo lang('send_sms_to_all_due_customer'); ?>
            </a>
        </div>
        <div class="table-box">
            <div class="box-body">
                <div class="table-responsive">
                    <table id="datatable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="w-5"><?php echo lang('sn'); ?></th>
                                <th class="w-15"><?php echo lang('customer_name'); ?>/<?php echo lang('phone'); ?></th>
                                <th class="w-15"><?php echo lang('present_address'); ?></th>
                                <th class="w-5"><?php echo lang('c_nid'); ?></th>
                                <th class="w-5"><?php echo lang('c_photo'); ?></th>
                                <th class="w-15"><?php echo lang('Guarantor_Name'); ?>/<?php echo lang('phone'); ?></th>
                                <th class="w-15"><?php echo lang('Guarantor_Present_Address'); ?></th>
                                <th class="w-5"><?php echo lang('g_nid'); ?></th>
                                <th class="w-5"><?php echo lang('g_photo'); ?></th>
                                <th class="w-5"><?php echo lang('added_by'); ?></th>
                                <th class="w-5"><?php echo lang('added_date'); ?></th>
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
                                <td><?php echo escape_output($cust->name); ?> (<a class="text-decoration-none" href="tel:<?php echo escape_output($cust->phone); ?>"><?php echo escape_output($cust->phone); ?></a>)</td>
                                <td><?php echo escape_output($cust->address); ?></td>
                                <td>
                                    <button type="button" get-title="<?php echo lang('customer_nid'); ?>" get-file="<?php echo escape_output($cust->customer_nid); ?>" class="new-btn h-40 show_preview btn-sm" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="far fa-eye"></i></button>
                                </td>
                                <td>
                                    <button type="button" get-title="<?php echo lang('customer_photo'); ?>" get-file="<?php echo escape_output($cust->photo); ?>" class="new-btn h-40 show_preview btn-sm" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="far fa-eye"></i></button>
                                </td>
                                <td><?php echo escape_output($cust->g_name); ?> (<a class="text-decoration-none" href="tel:<?php echo escape_output($cust->g_mobile); ?>"><?php echo escape_output($cust->g_mobile); ?></a>)</td>
                                <td><?php echo escape_output($cust->g_pre_address); ?></td>
                                <td>
                                    <button type="button" get-title="<?php echo lang('Guarantor_NID'); ?>" get-file="<?php echo escape_output($cust->g_nid); ?>" class="new-btn h-40 show_preview btn-sm" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="far fa-eye"></i></button>
                                </td>
                                <td>
                                    <button type="button" get-title="<?php echo lang('Guarantor_photo'); ?>" get-file="<?php echo escape_output($cust->g_photo); ?>" class="new-btn h-40 show_preview btn-sm" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="far fa-eye"></i></button>
                                </td>
                                <td><?php echo escape_output($cust->added_by); ?></td>
                                <td><?php echo date($this->session->userdata('date_format'), strtotime($cust->added_date != '' ? $cust->added_date : '')); ?></td>
                                <td class="text-center">
                                    <?php if ($cust->name != "Walk-in Customer") { ?>
                                    <div class="btn_group_wrap">
                                        <a class="btn btn-cyan" href="<?php echo base_url() ?>Installment/customerDetails/<?php echo escape_output($this->custom->encrypt_decrypt($cust->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-original-title="<?php echo lang('details'); ?>">
                                        <i class="far fa-eye"></i>
                                        </a>
                                        <a class="btn btn-warning" href="<?php echo base_url() ?>Installment/addEditCustomer/<?php echo escape_output($this->custom->encrypt_decrypt($cust->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-original-title="<?php echo lang('edit'); ?>">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <a class="delete btn btn-danger" href="<?php echo base_url() ?>Installment/deleteCustomer/<?php echo escape_output($this->custom->encrypt_decrypt($cust->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php echo lang('delete'); ?>">
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

<!-- Modal -->
<div class="modal fade" id="exampleModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">&nbsp;</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12  op_center op_padding_10">
                        <img class="img-fluid" src="-" id="show_id_installment" alt="">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-blue-btn"
                    data-dismiss="modal"  data-bs-dismiss="modal"><?php echo lang('close');?></button>
            </div>
        </div>
    </div>
</div>



<?php $this->view('updater/reuseJs'); ?>
<script src="<?php echo base_url(); ?>frequent_changing/js/installment-list.js"></script>
