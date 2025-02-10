

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


    <?php
    if ($this->session->flashdata('exception_err')) {
        echo '<section class="alert-wrapper"><div class="alert alert-danger alert-dismissible fade show"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></button>
        <div class="alert-body"><i class="icon fa fa-times me-2"></i>';
        echo escape_output($this->session->flashdata('exception_err'));unset($_SESSION['exception_err']);
        echo '</div></div></section>';
    }
    ?>
    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header"><?php echo lang('list_attendance'); ?> </h3>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('list_attendance'); ?>" data-id_name="datatable">
                <div class="btn_list m-right d-flex">
                    <a class="new-btn me-1" href="<?php echo base_url() ?>Attendance/addEditAttendance">
                    <iconify-icon icon="solar:add-circle-broken" width="22"></iconify-icon> <?php echo lang('add_update_attendance'); ?>
                    </a>
                </div>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('attendance'), 'secondSection'=> lang('list_attendance')])?>
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
                                    <th class="w-10"><?php echo lang('ref_no'); ?></th>
                                    <th class="w-10"><?php echo lang('date'); ?></th>
                                    <th class="w-10"><?php echo lang('employee'); ?></th>
                                    <th class="w-10"><?php echo lang('in_time'); ?></th>
                                    <th class="w-10"><?php echo lang('out_time'); ?></th>
                                    <th class="w-10"><?php echo lang('update_time'); ?></th>
                                    <th class="w-10"><?php echo lang('time_count'); ?></th>
                                    <th class="w-20"><?php echo lang('note'); ?></th>
                                    <th class="w-10"><?php echo lang('added_by'); ?></th>
                                    <th class="w-10"><?php echo lang('added_date'); ?></th>
                                    <th class="w-5"><?php echo lang('actions'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($attendances && !empty($attendances)) {
                                    $i = count($attendances); 
                                foreach ($attendances as $value) {
                                    ?>                       
                                    <tr> 
                                        <td><?php echo escape_output($i--); ?></td>
                                        <td><?php echo escape_output($value->reference_no); ?></td>
                                        <td><?php echo escape_output(date($this->session->userdata('date_format'), strtotime($value->date))); ?></td>
                                        <td><?php echo escape_output(employeeName($value->employee_id)); ?></td>
                                        <td><?php echo escape_output($value->in_time); ?></td>
                                        <td>
                                            <?php 
                                            if($value->out_time == '00:00:00'){ 
                                                echo 'N/A<br>';  
                                            }else{ 
                                                echo escape_output($value->out_time); 
                                            } 
                                            ?> 
                                        </td>
                                        <td>
                                            <?php 
                                                echo '<a href="'. base_url().'Attendance/addEditAttendance/'.($this->custom->encrypt_decrypt($value->id, 'encrypt')) .'">'.lang('Update_Time').'</a>';
                                            ?>
                                        </td>
                                        <td>
                                            <?php  
                                            if($value->out_time == '00:00:00'){ 
                                                echo 'N/A'; 
                                            }else{ 
                                                $to_time = strtotime($value->out_time);
                                                $from_time = strtotime($value->in_time);
                                                $minute = round(absCustom($to_time - $from_time) / 60,2); 
                                                $hour = round(absCustom($minute) / 60,2);
                                                echo escape_output($hour." Hour");
                                            }

                                            ?> 
                                        </td>
                                        <td><?php if ($value->note != NULL) echo escape_output($value->note); ?></td>
                                        <td><?php echo escape_output($value->added_by); ?></td>
                                        <td><?php echo date($this->session->userdata('date_format'), strtotime($value->added_date != '' ? $value->added_date : '')); ?></td>
                                        <td class="text-center">
                                            <div class="btn_group_wrap">
                                                <a class="delete btn btn-danger" href="<?php echo base_url() ?>Attendance/deleteAttendance/<?php echo escape_output($this->custom->encrypt_decrypt($value->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php echo lang('delete'); ?>">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                } }
                                ?> 
                            </tbody>
                          
                        </table>
                    </div>
                    <!-- /.box-body -->
        </div> 
    </div>
</div>

<?php $this->view('updater/reuseJs')?>