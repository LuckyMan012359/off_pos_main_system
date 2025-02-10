<div class="main-content-wrapper">
    <?php
    if ($this->session->flashdata('exception')) {
        echo '<section class="alert-wrapper"><div class="alert alert-success alert-dismissible fade show"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></button>
        <div class="alert-body"><i class="icon fa fa-check me-2"></i>';
        echo escape_output($this->session->flashdata('exception'));unset($_SESSION['exception']);
        echo '</div></div></section>';
    }
    if ($this->session->flashdata('exception_1')) {
        echo '<section class="alert-wrapper"><div class="alert alert-danger alert-dismissible fade show"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></button>
        <div class="alert-body"><i class="icon fa fa-times"></i>';
        echo escape_output($this->session->flashdata('exception'));unset($_SESSION['exception']);
        echo '</div></div></section>';
    }
    ?>

    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header"><?php echo lang('list_installment_sale'); ?> </h3>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('list_installment_sale'); ?>" data-id_name="datatable">
                <div class="btn_list m-right d-flex">
                    <a class="new-btn me-1" href="<?php echo base_url() ?>Installment/addEditInstallmentSale">
                    <iconify-icon icon="solar:add-circle-broken" width="22"></iconify-icon> <?php echo lang('add_installment_sale'); ?>
                    </a>
                </div>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('installment_sale'), 'secondSection'=> lang('list_installment_sale')])?>
        </div>
    </section>


    <div class="box-wrapper">

        <div class="table-box">
            <!-- /.box-header -->
            <div class="table-responsive">
                <table id="datatable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="w-5"><?php echo lang('sn'); ?></th>
                            <th class="w-7"><?php echo lang('date'); ?></th>
                            <th class="w-12"><?php echo lang('customer_name'); ?></th>
                            <th class="w-10"><?php echo lang('product'); ?></th>
                            <th class="w-7 text-center"><?php echo lang('price'); ?></th>
                            <th class="w-7 text-center"><?php echo lang('discount'); ?></th>
                            <th class="w-7 text-center"><?php echo lang('shipping'); ?></th>
                            <th class="w-10 text-center"><?php echo lang('total'); ?></th>
                            <th class="w-10 text-center"><?php echo lang('down_payment'); ?></th>
                            <th class="w-7 text-center"><?php echo lang('remaining'); ?></th>
                            <th class="w-13 text-center"><?php echo lang('number_of_installment'); ?></th>
                            <th class="w-13 text-center"><?php echo lang('percentage_of_interest'); ?></th>
                            <th class="w-8 text-center"><?php echo lang('paid_till_today'); ?></th>
                            <th class="w-8 text-center"><?php echo lang('total_remaining'); ?></th>
                            <th class="w-5"><?php echo lang('added_by'); ?></th>
                            <th class="w-5"><?php echo lang('added_date'); ?></th>
                            <th class="op_width_1_p text-center"><?php echo lang('actions'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if ($installments && !empty($installments)) {
                                $i = count($installments);
                            }
                            foreach ($installments as $cust) {
                                $paid_till_today = getPaidAmountInstallment($cust->id);
                                ?>
                        <tr>
                            <td class="op_center"><?php echo $i--; ?></td>
                            <td><?php echo date($this->session->userdata('date_format'), strtotime($cust->date)); ?>
                            </td>
                            <td><?php echo getCustomerName($cust->customer_id); ?></td>
                            <td><?php echo getItemNameById($cust->item_id); ?></td>
                            <td class="text-center"><?php echo getAmtCustom($cust->price); ?></td>
                            <td class="text-center"><?php echo getAmtCustom($cust->discount); ?></td>
                            <td class="text-center"><?php echo getAmtCustom($cust->shipping_other); ?></td>
                            <td class="text-center"><?php echo getAmtCustom($cust->total); ?></td>
                            <td class="text-center"><?php echo getAmtCustom($cust->down_payment); ?></td>
                            <td class="text-center"><?php echo getAmtCustom($cust->price - $paid_till_today-$cust->down_payment); ?></td>
                            <td class="text-center"><?php echo escape_output($cust->number_of_installment); ?></td>
                            <td class="text-center"><?php echo escape_output($cust->percentage_of_interest); ?></td>
                            <td class="text-center"><?php echo getAmtCustom($paid_till_today+$cust->down_payment); ?></td>
                            <td class="text-center"><?php echo getAmtCustom($cust->remaining); ?></td>
                            <td><?php echo escape_output($cust->added_by); ?></td>
                            <td><?php echo date($this->session->userdata('date_format'), strtotime($cust->added_date != '' ? $cust->added_date : '')); ?></td>
                            <td>
                                <div class="btn_group_wrap">
                                    <a class="btn btn-deep-purple" href="<?php echo base_url() ?>Installment/installmentPrint/<?php echo escape_output($this->custom->encrypt_decrypt($cust->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-original-title="<?php echo lang('print_invoice'); ?>">
                                    <i class="fas fa-print"></i>
                                    </a>

                                    <a class="btn btn-unique" href="<?php echo base_url() ?>Installment/a4InvoicePDF/<?php echo escape_output($this->custom->encrypt_decrypt($cust->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-original-title="<?php echo lang('download_invoice'); ?>">
                                    <i class="fas fa-download"></i>
                                    </a>

                                    <a class="btn btn-cyan" href="<?php echo base_url() ?>Installment/viewDetails/<?php echo escape_output($this->custom->encrypt_decrypt($cust->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-original-title="<?php echo lang('view_details'); ?>">
                                    <i class="far fa-eye"></i>
                                    </a>
                                    <a class="btn btn-warning" href="<?php echo base_url() ?>Installment/addEditInstallmentSale/<?php echo escape_output($this->custom->encrypt_decrypt($cust->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-original-title="<?php echo lang('edit'); ?>">
                                    <i class="far fa-edit"></i>
                                    </a>
                                    <a class="delete btn btn-danger" href="<?php echo base_url() ?>Installment/deleteInstallmentSale/<?php echo escape_output($this->custom->encrypt_decrypt($cust->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php echo lang('delete'); ?>">
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
            <!-- /.box-body -->
        </div>

    </div>
</div>

<?php $this->view('updater/reuseJs'); ?>