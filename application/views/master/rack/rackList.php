<div class="main-content-wrapper">
    <?php
    if ($this->session->flashdata('exception')) {
        echo '<section class="alert-wrapper"><div class="alert alert-success alert-dismissible fade show">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></button>
        <div class="alert-body"<i class="icon fa fa-check"></i>';
        echo escape_output($this->session->flashdata('exception'));unset($_SESSION['exception']);
        echo '</div></div></section>';
    }
    ?>

    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header"><?php echo lang('list_rack'); ?> </h3>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('list_rack'); ?>" data-id_name="datatable">
                <div class="btn_list m-right d-flex">
                    <a class="new-btn me-1" href="<?php echo base_url() ?>Rack/addEditRack">
                    <iconify-icon icon="solar:add-circle-broken" width="22"></iconify-icon> <?php echo lang('add_rack'); ?>
                    </a>
                </div>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('rack'), 'secondSection'=> lang('list_rack')])?>
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
                            <th class="w-30"><?php echo lang('rack_name'); ?></th>
                            <th class="w-40"><?php echo lang('description'); ?></th>
                            <th class="w-10"><?php echo lang('added_by'); ?></th>
                            <th class="w-10"><?php echo lang('added_date'); ?></th>
                            <th class="w-5"><?php echo lang('actions'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($racks && !empty($racks)) {
                            $i = count($racks);
                        }
                        foreach ($racks as $fmc) {
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $i--; ?></td>
                                <td><?php echo escape_output($fmc->name); ?></td>
                                <td><?php echo escape_output($fmc->description); ?></td>
                                <td><?php echo escape_output($fmc->added_by); ?></td>
                                <td><?php echo date($this->session->userdata('date_format'), strtotime($fmc->added_date != '' ? $fmc->added_date : '')); ?></td>
                                <td class="text-center">
                                    <div class="btn_group_wrap">
                                        <a class="btn btn-warning" href="<?php echo base_url() ?>Rack/addEditRack/<?php echo $this->custom->encrypt_decrypt($fmc->id, 'encrypt'); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-original-title="<?php echo lang('edit'); ?>">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <a class="delete btn btn-danger" href="<?php echo base_url() ?>Rack/deleteRack/<?php echo $this->custom->encrypt_decrypt($fmc->id, 'encrypt'); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php echo lang('delete'); ?>">
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
<?php $this->load->view('updater/reuseJs')?>
