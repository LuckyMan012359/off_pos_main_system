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
                <h3 class="top-left-header"><?php echo lang('list_account'); ?> </h3>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('list_account'); ?>" data-id_name="datatable">
                <div class="btn_list m-right d-flex">
                    <a class="new-btn me-1" href="<?php echo base_url() ?>PaymentMethod/sortPaymentMethod">
                        <iconify-icon icon="solar:checklist-broken" width="22"></iconify-icon> <?php echo lang('payment_method_sorting'); ?>
                    </a>
                    <a class="new-btn me-1" href="<?php echo base_url() ?>PaymentMethod/addEditPaymentMethod">
                    <iconify-icon icon="solar:add-circle-broken" width="22"></iconify-icon> <?php echo lang('add_account'); ?>
                    </a>
                </div>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('payment_method'), 'secondSection'=> lang('list_account')])?>
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
                                <th class="w-25"><?php echo lang('account_name'); ?></th>
                                <th class="w-30"><?php echo lang('account_type'); ?></th>
                                <th class="w-20"><?php echo lang('status'); ?></th>
                                <th class="w-20 text-center"><?php echo lang('balance'); ?></th>
                                <th class="w-10"><?php echo lang('added_by'); ?></th>
                                <th class="w-10"><?php echo lang('added_date'); ?></th>
                                <th class="w-5"><?php echo lang('actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if ($paymentMethods && !empty($paymentMethods)) {
                                    $i = count($paymentMethods);
                                }
                                foreach ($paymentMethods as $value) {
                                $balance = 0; 
                                $balance = $value->current_balance+$value->total_sale-$value->total_purchase+$value->total_customer_due_receive-$value->total_supplier_due_payment+$value->total_down_payment+$value->total_installment_collection+$value->total_deposit - $value->total_withdraw+$value->total_purchase_return_amount-$value->total_expense-$value->total_salary_amount-$value->total_sale_return+$value->total_income;
                            ?>
                            <tr>
                                <td class="op_center"><?php echo $i--; ?></td>
                                <td><?php echo escape_output($value->name); ?></td>
                                <td><?php echo escape_output($value->account_type) ?></td>
                                <td><?php echo escape_output($value->status); ?></td>
                                <td class="text-center"><?php echo getAmtCustom($balance); ?></td>
                                <td><?php echo userName($value->user_id); ?></td>
                                <td><?php echo dateFormat($value->added_date); ?></td>
                                <td>
                                    <div class="btn_group_wrap">
                                        <a class="btn btn-warning" href="<?php echo base_url() ?>PaymentMethod/addEditPaymentMethod/<?php echo escape_output($this->custom->encrypt_decrypt($value->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-original-title="<?php echo lang('edit'); ?>">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <?php if($value->is_deletable == 'Yes'){ ?>
                                        <a class="delete btn btn-danger" href="<?php echo base_url() ?>PaymentMethod/deletePaymentMethod/<?php echo escape_output($this->custom->encrypt_decrypt($value->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php echo lang('delete'); ?>">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </a>
                                        <?php } ?>
                                    </div>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->view('updater/reuseJs'); ?>
