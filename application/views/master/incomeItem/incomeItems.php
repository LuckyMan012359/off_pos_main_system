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
                <h3 class="top-left-header"><?php echo lang('list_income_item'); ?> </h3>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('list_income_item'); ?>" data-id_name="datatable">
                <div class="btn_list m-right d-flex">
                    <a class="new-btn me-1" href="<?php echo base_url() ?>IncomeItem/addEditIncomeItem">
                    <iconify-icon icon="solar:add-circle-broken" width="22"></iconify-icon> <?php echo lang('add_income_item'); ?>
                    </a>
                </div>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('income_item'), 'secondSection'=> lang('list_income_item')])?>
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
                                    <th class="w-30"><?php echo lang('income_item_name'); ?></th>
                                    <th class="w-40"><?php echo lang('description'); ?></th>
                                    <th class="w-10"><?php echo lang('added_by'); ?></th>
                                    <th class="w-10"><?php echo lang('added_date'); ?></th>
                                <th class="w-5"><?php echo lang('actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($incomeItems && !empty($incomeItems)) {
                                $i = count($incomeItems);
                            }
                            foreach ($incomeItems as $ei) {
                                ?>                       
                                <tr> 
                                    <td class="op_center"><?php echo $i--; ?></td>
                                    <td><?php echo escape_output($ei->name); ?></td> 
                                    <td><?php echo escape_output($ei->description); ?></td> 
                                    <td><?php echo escape_output($ei->added_by); ?></td>  
                                    <td><?php echo date($this->session->userdata('date_format'), strtotime($ei->added_date != '' ? $ei->added_date : '')); ?></td>  
                                    <td>
                                        <div class="btn_group_wrap">
                                            <a class="btn btn-warning" href="<?php echo base_url() ?>IncomeItem/addEditIncomeItem/<?php echo $this->custom->encrypt_decrypt($ei->id, 'encrypt'); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-original-title="<?php echo lang('edit'); ?>">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            <a class="delete btn btn-danger" href="<?php echo base_url() ?>IncomeItem/deleteIncomeItem/<?php echo $this->custom->encrypt_decrypt($ei->id, 'encrypt'); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php echo lang('delete'); ?>">
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