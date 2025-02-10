
<section class="main-content-wrapper">
<h3 class="display_none">&nbsp;</h3>
<input type="hidden" id="status_change" value="<?php echo lang('status_change');?>">


    <div class="ajax-message"></div>
        <?php
            if ($this->session->flashdata('exception')) {
                echo '<section class="alert-wrapper"><div class="alert alert-success alert-dismissible fade show"> 
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <div class="alert-body"><i class="m-right fa fa-check"></i>';
                        echo escape_output($this->session->flashdata('exception'));unset($_SESSION['exception']);
                        echo '</div></div>
                </section>';
            }
            if ($this->session->flashdata('exception_error')) {
            echo '<section class="alert-wrapper"><div class="alert alert-danger alert-dismissible fade show"> 
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <i class="icon fa fa-times"></i>';
                    echo escape_output($this->session->flashdata('exception_error'));
                    echo '</div></div></section>';
            }
            $plusSVG= '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus me-50 font-small-4"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>';

        ?>
        
        <section class="content-header">
            <div class="row justify-content-between">
                <div class="col-6 p-0">
                    <h3 class="top-left-header"><?php echo lang('list_transfer'); ?> </h3>
                    <input type="hidden" class="datatable_name" data-title="<?php echo lang('list_transfer'); ?>" data-id_name="datatable">
                    <div class="btn_list m-right d-flex">
                        <a class="new-btn me-1" href="<?php echo base_url() ?>Transfer/addEditTransfer">
                        <iconify-icon icon="solar:add-circle-broken" width="22"></iconify-icon> <?php echo lang('add_transfer'); ?>
                        </a>
                    </div>
                </div>
                <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('transfer'), 'secondSection'=> lang('list_transfer')])?>
            </div>
        </section>



        <div class="box-wrapper">
            <div class="table-box">
                <div class="table-responsive">
                    <table id="datatable" class="table table-responsive transfer_table">
                        <thead>
                            <tr>
                                <th class="w-5"><?php echo lang('sn'); ?></th>
                                <th class="w-10"><?php echo lang('ref_no'); ?></th>
                                <th class="w-10"><?php echo lang('date'); ?></th>
                                <th class="w-10"><?php echo lang('from_outlet');?></th>
                                <th class="w-10"><?php echo lang('to_outlet'); ?></th>
                                <th class="w-20"><?php echo lang('status'); ?></th>
                                <th class="w-10"><?php echo lang('received_date'); ?></th>
                                <th class="w-10"><?php echo lang('added_by'); ?></th>
                                <th class="w-10"><?php echo lang('added_date'); ?></th>
                                <th class="w-5"><?php echo lang('actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
 </section>
 <!-- DataTables -->



<?php $this->load->view('updater/reuseJs2')?>
<script src="<?php echo base_url(); ?>frequent_changing/js/transfer_list.js"></script>

