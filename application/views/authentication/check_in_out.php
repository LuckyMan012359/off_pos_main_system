<!-- Main content -->
<section class="main-content-wrapper">
<h3 class="display_none">&nbsp;</h3>


    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo lang('check_in_out'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('check_in_out'), 'secondSection'=> lang('check_in_out')])?>
        </div>
    </section>



    <!-- general form elements -->
    <div class="box-wrapper">
        <div class="table-box">
            <div class="row">
                <div class="col-sm-12 col-md-4">
                   &nbsp;
                </div>

                <div class="col-sm-12 col-md-4">
                    <?php
                    $user_id = $this->session->userdata('user_id');
                    $attendance = getAttendance($user_id);
                    $attendance1 = getAttendance1($user_id);
                        $status_text = isset($attendance) && $attendance?lang('check_in'):lang('check_out');
                        $last_checkin_date_time = isset($attendance1) && $attendance1?$attendance1->out_time:'';
                    ?>
                    <div class="text-center">
                            <h5 class="text-center"><?php echo lang('LastCheckOutTime')?>: <?php echo escape_output($last_checkin_date_time)?></h5>
                        <?php if($attendance):?>
                            <a class="bg-red-btn" href="<?php echo base_url() ?>authentication/checkOut"><?php echo lang('checkOut')?></a>
                        <?php else:?>
                            <a class="bg-blue-btn" href="<?php echo base_url() ?>authentication/checkIn"><?php echo lang('checkIn')?></a>
                        <?php endif;?>
                    </div>

                </div>
                <div class="col-sm-12 col-md-4">
                    &nbsp;
                </div>
                <p>&nbsp;</p>
                <hr>

                <div class="table-box">
                    <!-- /.box-header -->
                    <input type="hidden" class="datatable_name" data-title="<?php echo lang('attendances'); ?>" data-id_name="datatable">
                    <div class="table-responsive">
                        <table id="datatable" class="table">
                            <thead>
                            <tr>
                                <th class="ir_w_1"> <?php echo lang('sn'); ?></th>
                                <th class="ir_w_11"><?php echo lang('ref_no'); ?></th>
                                <th class="ir_w_9"><?php echo lang('date'); ?></th>
                                <th class="ir_w_10"><?php echo lang('in_time'); ?></th>
                                <th class="ir_w_10"><?php echo lang('out_time'); ?></th>
                                <th class="ir_w_14"><?php echo lang('time_count'); ?></th>
                                <th class="text-center"><?php echo lang('note'); ?></th>
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
                                        <td><?php echo escape_output($value->reference_no) ?></td>
                                        <td><?php echo escape_output(date($this->session->userdata('date_format'), strtotime($value->date))); ?>
                                        </td>
                                        <td><?php echo escape_output($value->in_time) ?></td>
                                        <td>
                                            <?php
                                            if($value->out_time == '00:00:00'){
                                                 echo lang('n_a').'<br>';;
                                            }else{
                                                echo escape_output($value->out_time);
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if($value->out_time == '00:00:00'){
                                                echo lang('n_a');
                                            }else{
                                                $get_hour = getTotalHour($value->out_time,$value->in_time);
                                                echo (isset($get_hour) && $get_hour?$get_hour:'0.0')." ".lang('hour_s');
                                            }

                                            ?>
                                        </td>
                                        <td><?php if ($value->note != NULL) echo escape_output($value->note) ?></td>
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
    </div>
</section>
<?php $this->view('updater/reuseJs')?>