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
                <h3 class="top-left-header"><?php echo lang('list_customer_group'); ?> </h3>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('list_customer_group'); ?>" data-id_name="datatable">
                <div class="btn_list m-right d-flex">
                    <a class="new-btn me-1" href="<?php echo base_url() ?>Group/addEditGroup">
                    <iconify-icon icon="solar:add-circle-broken" width="22"></iconify-icon> <?php echo lang('add_customer_group'); ?>
                    </a>
                </div>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('group'), 'secondSection'=> lang('list_customer_group')])?>
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
                                <th class="w-25"><?php echo lang('group_name'); ?></th>
                                <th class="w-16"><?php echo lang('description'); ?></th>
                                <th class="w-20"><?php echo lang('added_by'); ?></th>
                                <th class="w-20"><?php echo lang('added_date'); ?></th>
                                <th class="op_width_6_p text-center"><?php echo lang('actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                    if ($Groups && !empty($Groups)) {
                                        $i = count($Groups);
                                    }
                                    foreach ($Groups as $group) {
                                        ?>
                            <tr>
                                <td class="op_center"><?php echo $i--; ?></td>
                                <td><?php echo escape_output($group->group_name); ?></td>
                                <td><?php echo escape_output($group->description); ?></td>
                                <td><?php echo escape_output($group->added_by); ?></td>
                                <td><?php echo date($this->session->userdata('date_format'), strtotime($group->added_date != '' ? $group->added_date : '')); ?></td>
                                <td>
                                    <div class="btn_group_wrap">
                                        <a class="btn btn-warning" href="<?php echo base_url() ?>Group/addEditGroup/<?php echo $this->custom->encrypt_decrypt($group->id, 'encrypt'); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-original-title="<?php echo lang('edit'); ?>">
                                        <i class="far fa-edit"></i>
                                        </a>
                                        <a class="delete btn btn-danger" href="<?php echo base_url() ?>Group/deleteGroup/<?php echo $this->custom->encrypt_decrypt($group->id, 'encrypt'); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php echo lang('delete'); ?>">
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
