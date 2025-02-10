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
                <h3 class="top-left-header"><?php echo lang('list_role'); ?> </h3>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('list_role'); ?>" data-id_name="datatable">
                <div class="btn_list m-right d-flex">
                    <a class="new-btn me-1" href="<?php echo base_url() ?>Role/addEditRole">
                    <iconify-icon icon="solar:add-circle-broken" width="22"></iconify-icon> <?php echo lang('add_role'); ?>
                    </a>
                </div>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('role'), 'secondSection'=> lang('list_role')])?>
        </div>
    </section>



    <div class="box-wrapper">
        <div class="table-box">
            <div class="table-responsive">
                <table id="datatable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="w-5"><?php echo lang('sn'); ?></th>
                            <th class="w-80"><?php echo lang('role_name'); ?></th>
                            <th class="w-10"><?php echo lang('added_date'); ?></th>
                            <th class="w-5 text-center"><?php echo lang('actions'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($roles as $role) {  ?>
                            <tr>
                                <td class="op_center"><?php echo $i++; ?></td>
                                <td><?php echo escape_output($role->role_name); ?></td>
                                <td><?php echo dateFormat($role->added_date); ?></td>
                                <td class="text-center">
                                    <div class="btn_group_wrap">
                                        <?php if($role->id != '1'): ?>
                                        <a class="btn btn-warning" href="<?php echo base_url() ?>Role/addEditRole/<?php echo $this->custom->encrypt_decrypt($role->id, 'encrypt'); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-original-title="<?php echo lang('edit'); ?>">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <?php endif; ?>
                                        <?php if($role->id != '1' && $role->id != '2' && $role->id != '3'): ?>
                                        <a class="delete btn btn-danger" href="<?php echo base_url() ?>Role/deleteRole/<?php echo $this->custom->encrypt_decrypt($role->id, 'encrypt'); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php echo lang('delete'); ?>">
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