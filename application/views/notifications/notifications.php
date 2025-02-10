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
    <div class="content-header">
        <h3 class="top-left-header"><?php echo lang('notification'); ?> </h3>
    </div>

    <div class="box-wrapper">
        <div class="table-box">
            <div class="table-responsive">
                <table id="datatable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="w-20"><?php echo lang('notification_note'); ?></th>
                            <th class="w-8"><?php echo lang('date'); ?></th>
                            <th class="w-10"><?php echo lang('actions'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if ($notifications && !empty($notifications)) {
                                $i = count($notifications);
                            }
                            foreach ($notifications as $notification) {
                            ?>
                        <tr class="decoration-none <?php echo escape_output($notification->read_status) == 0 ? 'unread-bg' : '' ?>">
                            <td><?php echo escape_output($notification->notifications_details) ?></td>
                            <td><?php echo date($this->session->userdata('date_format'), strtotime($notification->read_status)) ?></td>
                            <td>
                                <div class="d-flex align-items-cneter justify-content-between">
                                    <a href="<?php echo base_url();?>Notification/<?php echo escape_output($notification->read_status) == 0 ? 'notificationRead' : 'notificationUnRead' ?>/<?php echo $this->custom->encrypt_decrypt($notification->id, 'encrypt') ?>">
                                        <i class="fa <?php echo escape_output($notification->read_status) == 0 ? 'fa-eye-slash' : 'fa-eye' ?>"></i> <?php echo escape_output($notification->read_status) == 0 ? lang('mark_as_read') : lang('mark_as_unread'); ?>
                                    </a>
                                    <a class="decoration-none" href="<?php echo base_url();?>Notification/notificationDelete/<?php echo $this->custom->encrypt_decrypt($notification->id, 'encrypt');?>">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php }  ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- <?php $this->view('updater/reuseJs')?> -->
