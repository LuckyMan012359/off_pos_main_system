<div class="main-content-wrapper">
<?php
if($this->session->flashdata('exception')){
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
                <h3 class="top-left-header"><?php echo lang('list_deposit_or_withdraw'); ?> </h3>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('list_deposit_or_withdraw'); ?>" data-id_name="datatable">
                <div class="btn_list m-right d-flex">
                    <a class="new-btn me-1" href="<?php echo base_url() ?>Deposit/addEditDeposit">
                    <iconify-icon icon="solar:add-circle-broken" width="22"></iconify-icon> <?php echo lang('add_deposit_or_withdraw'); ?>
                    </a>
                </div>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('deposit_or_withdraw'), 'secondSection'=> lang('list_deposit_or_withdraw')])?>
        </div>
    </section>



    <div class="box-wrapper">
        <div class="table-box"> 
            <div class="box-body">
                <div class="table-responsive"> 
                    <table id="datatable" class="table table-responsive table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="w-5"><?php echo lang('sn'); ?></th>
                                <th class="w-15"><?php echo lang('ref_no'); ?></th>
                                <th class="w-15"><?php echo lang('date'); ?></th>
                                <th class="w-20 text-center"><?php echo lang('amount'); ?></th>
                                <th class="w-10"><?php echo lang('deposit_or_withdraw'); ?></th>
                                <th class="w-15"><?php echo lang('payment_methods'); ?></th>
                                <th class="w-10"><?php echo lang('added_by'); ?></th>
                                <th class="w-10"><?php echo lang('added_date'); ?></th>
                                <th class="w-5"><?php echo lang('actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if($deposit_lists && !empty($deposit_lists)){
                                $i = count($deposit_lists);
                            }
                            foreach ($deposit_lists as $prchs) {
                                ?>                       
                                <tr> 
                                    <td><?php echo $i--; ?></td> 
                                    <td><?php echo escape_output($prchs->reference_no); ?></td> 
                                    <td><?php echo date($this->session->userdata('date_format'), strtotime($prchs->date)); ?></td> 
                                    <td class="text-center"><?php echo getAmtCustom($prchs->amount); ?></td>
                                    <td><?php echo escape_output($prchs->type); ?></td>
                                    <td><?php echo getPaymentName($prchs->payment_method_id); ?></td>
                                    <td><?php echo escape_output($prchs->added_by); ?></td>  
                                    <td><?php echo date($this->session->userdata('date_format'), strtotime($prchs->added_date != '' ? $prchs->added_date : '')); ?></td>  
                                    <td class="text-center">
                                        <div class="btn_group_wrap">
                                            <a class="btn btn-warning" href="<?php echo base_url() ?>Deposit/addEditDeposit/<?php echo $this->custom->encrypt_decrypt($prchs->id, 'encrypt'); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-original-title="<?php echo lang('edit'); ?>">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            <a class="delete btn btn-danger" href="<?php echo base_url() ?>Deposit/deleteDeposit/<?php echo $this->custom->encrypt_decrypt($prchs->id, 'encrypt'); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php echo lang('delete'); ?>">
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

<?php $this->view('updater/reuseJs')?>