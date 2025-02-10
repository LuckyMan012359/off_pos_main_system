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
                <h3 class="top-left-header"><?php echo lang('list_damage'); ?> </h3>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('list_damage'); ?>" data-id_name="datatable">
                <div class="btn_list m-right d-flex">
                    <a class="new-btn me-1" href="<?php echo base_url() ?>Damage/addEditDamage">
                    <iconify-icon icon="solar:add-circle-broken" width="22"></iconify-icon> <?php echo lang('add_damage'); ?>
                    </a>
                </div>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('damage'), 'secondSection'=> lang('list_damage')])?>
        </div>
    </section>



    <div class="box-wrapper">
        <div class="table-box"> 
            <div class="box-body">
                <div class="table-responsive"> 
                    <table id="datatable" class="table table-bordered table-striped damage_ajax_page">
                        <thead>
                            <tr>
                                <th class="w-5 text-left"><?php echo lang('sn'); ?></th>
                                <th class="w-10"><?php echo lang('ref_no'); ?></th>
                                <th class="w-10"><?php echo lang('date'); ?></th>
                                <th class="w-10"><?php echo lang('total_loss'); ?></th>
                                <th class="w-10"><?php echo lang('item_count'); ?></th>
                                <th class="w-15"><?php echo lang('responsible_person'); ?></th>
                                <th class="w-20"><?php echo lang('note'); ?></th>
                                <th class="w-10"><?php echo lang('added_by'); ?></th>
                                <th class="w-10"><?php echo lang('added_date'); ?></th>
                                <th class="w-5 text-center"><?php echo lang('actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> 
    </div>
</div>

<?php $this->load->view('updater/reuseJs2')?>
<script src="<?php echo base_url(); ?>frequent_changing/js/damages.js"></script>

