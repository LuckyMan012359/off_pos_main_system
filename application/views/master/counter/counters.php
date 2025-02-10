<section class="main-content-wrapper">
<h3 class="display_none">&nbsp;</h3>

    <?php
    if ($this->session->flashdata('exception')) {
        echo '<section class="alert-wrapper">
        <div class="alert alert-success alert-dismissible fade show"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <div class="alert-body">
        <i class="m-right fa fa-check"></i>';
        echo escape_output($this->session->flashdata('exception'));unset($_SESSION['exception']);
        echo '</div></div></section>';
    }
    ?>

    <?php
    if ($this->session->flashdata('exception_error')) {

        echo '<section class="alert-wrapper"><div class="alert alert-danger alert-dismissible fade show"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></button>
        <div class="alert-body"><i class="icon fa fa-times me-2"></i>';
        echo escape_output($this->session->flashdata('exception_error'));unset($_SESSION['exception_error']);
        echo '</div></div></section>';
    }
    ?>

    
    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header"><?php echo lang('list_counter'); ?> </h3>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('list_counter'); ?>" data-id_name="datatable">
                <div class="btn_list m-right d-flex">
                    <a class="new-btn me-1" href="<?php echo base_url() ?>Counter/addEditCounter">
                    <iconify-icon icon="solar:add-circle-broken" width="22"></iconify-icon> <?php echo lang('add_counter'); ?>
                    </a>
                </div>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('counter'), 'secondSection'=> lang('list_counter')])?>
        </div>
    </section>



    <div class="box-wrapper">
        <!-- general form elements -->
        <div class="table-box">
            <!-- /.box-header -->
            <div class="table-responsive">
                <table id="datatable" class="table">
                    <thead>
                        <tr>
                            <th class="w-5"> <?php echo lang('sn'); ?></th>
                            <th class="w-20"><?php echo lang('counter_name'); ?></th>
                            <th class="w-15"><?php echo lang('printer'); ?></th>
                            <th class="w-15"><?php echo lang('outlet'); ?></th>
                            <th class="w-20"><?php echo lang('description'); ?></th>
                            <th class="w-10"><?php echo lang('added_by'); ?></th>
                            <th class="w-10"><?php echo lang('added_date'); ?></th>
                            <th class="w-5 text-center"><?php echo lang('actions'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($counters && !empty($counters)) {
                            $i = count($counters);
                        }
                        foreach ($counters as $value) {
                            ?>
                        <tr>
                            
                            <td class="text-center"><?php echo escape_output($i--); ?></td>
                            <td><?php echo escape_output($value->counter_name) ?></td>
                            <td><?php echo escape_output($value->printer) ?></td>
                            <td><?php echo escape_output($value->outlet_name) ?></td>
                            <td><?php echo escape_output($value->description) ?></td>
                            <td><?php echo escape_output($value->added_by) ?></td>
                            <td><?php echo dateFormat($value->added_date); ?></td>
                            <td class="text-center">
                                <div class="btn_group_wrap">
                                    <a class="btn btn-warning" href="<?php echo base_url() ?>Counter/addEditCounter/<?php echo escape_output($this->custom->encrypt_decrypt($value->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-original-title="<?php echo lang('edit'); ?>">
                                        <i class="far fa-edit"></i>
                                    </a>
                                    <a class="delete btn btn-danger" href="<?php echo base_url() ?>Counter/deleteCounter/<?php echo escape_output($this->custom->encrypt_decrypt($value->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php echo lang('delete'); ?>">
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
</section>
<!-- DataTables -->
<?php $this->view('updater/reuseJs')?>