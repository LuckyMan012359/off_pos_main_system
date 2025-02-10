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
                <h3 class="top-left-header"><?php echo lang('list_employee'); ?> </h3>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('list_employee'); ?>" data-id_name="datatable">
                <div class="btn_list m-right d-flex">
                    <a class="new-btn me-1" href="<?php echo base_url() ?>User/addEditUser">
                    <iconify-icon icon="solar:add-circle-broken" width="22"></iconify-icon> <?php echo lang('add_employee'); ?>
                    </a>
                </div>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('employee'), 'secondSection'=> lang('list_employee')])?>
        </div>
    </section>




    <div class="box-wrapper">
        <div class="table-box">
            <div class="table-responsive">
                <table id="datatable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="w-5"><?php echo lang('sn'); ?></th>
                            <th class="w-15"><?php echo lang('name'); ?></th>
                            <th class="w-10"><?php echo lang('designation'); ?></th>
                            <th class="w-15"><?php echo lang('phone'); ?></th>
                            <th class="w-20"><?php echo lang('email'); ?></th>
                            <th class="w-10"><?php echo lang('status'); ?></th>
                            <th class="w-15"><?php echo lang('outlet_name'); ?></th>
                            <th class="w-10"><?php echo lang('added_date'); ?></th>
                            <th class="w-5 text-center"><?php echo lang('actions'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($users as $usrs) {  ?>
                                <tr>
                                    <td class="op_center"><?php echo $i++; ?></td>
                                    <td><?php echo escape_output($usrs->full_name); ?></td>
                                    <td><?php echo escape_output($usrs->role_name);?></td>
                                    <td><?php echo escape_output($usrs->phone); ?></td>
                                    <td><?php echo escape_output($usrs->email_address); ?></td>
                                    <td><?php echo escape_output($usrs->active_status); ?></td>
                                    <td>
                                        <?php 
                                        if($usrs->outlet_id != ""){
                                        $outlets = explode(",",$usrs->outlet_id);
                                        foreach($outlets as $key=>$oulte){ ?>
                                            <span>
                                                <?php echo escape_output(getOutletName($oulte)); ?>
                                                <?php if ($key !== array_key_last($outlets)) {
                                                    echo "<strong>,</strong>";
                                                } ?>
                                            </span><br>
                                        <?php }} ?>
                                    </td>
                                    <td><?php echo date($this->session->userdata('date_format'), strtotime($usrs->account_creation_date != '' ? $usrs->account_creation_date : '')); ?></td>
                                    <td class="text-center">
                                        <div class="btn_group_wrap">
                                            <?php if ($usrs->id != '1') { ?>
                                                <?php if ($usrs->active_status == 'Active') { ?>
                                                    <a class="btn btn-unique" href="<?php echo base_url() ?>User/deactivateUser/<?php echo $this->custom->encrypt_decrypt($usrs->id, 'encrypt'); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                                    data-bs-original-title="<?php echo lang('deactivate'); ?>">
                                                    <i class="far fa-times-circle"></i>
                                                    </a>
                                                <?php } else { ?>
                                                    <a class="btn btn-deep-purple" href="<?php echo base_url() ?>User/activateUser/<?php echo $this->custom->encrypt_decrypt($usrs->id, 'encrypt'); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                                    data-bs-original-title="<?php echo lang('activate'); ?>">
                                                    <i class="far fa-check-circle"></i>
                                                    </a>
                                                <?php } ?>
                                            <?php } ?>
                                            <a class="btn btn-warning" href="<?php echo base_url() ?>User/addEditUser/<?php echo $this->custom->encrypt_decrypt($usrs->id, 'encrypt'); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-original-title="<?php echo lang('edit'); ?>">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            <?php if($usrs->id != '1'): ?>
                                            <a class="delete btn btn-danger" href="<?php echo base_url() ?>User/deleteUser/<?php echo $this->custom->encrypt_decrypt($usrs->id, 'encrypt'); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php echo lang('delete'); ?>">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </a>
                                            <?php endif; ?>
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

<?php $this->view('updater/reuseJs');