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
                <h3 class="top-left-header"><?php echo lang('list_fixed_asset_stock_in'); ?> </h3>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('list_fixed_asset_stock_in'); ?>" data-id_name="datatable">
                <div class="btn_list m-right d-flex">
                    <a class="new-btn me-1" href="<?php echo base_url() ?>Fixed_asset_stock/addEditStock">
                    <iconify-icon icon="solar:add-circle-broken" width="22"></iconify-icon> <?php echo lang('add_stock_in'); ?>
                    </a>
                </div>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('fixed_asset_stock'), 'secondSection'=> lang('list_fixed_asset_stock_in')])?>
        </div>
    </section>


    <div class="box-wrapper">
        <div class="table-box"> 
            <!-- /.box-header -->
            <div class="table-responsive"> 
                <table id="datatable" class="table table-responsive table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="w-5"><?php echo lang('sn'); ?></th>
                            <th class="w-15"><?php echo lang('ref_no'); ?></th>
                            <th class="w-20"><?php echo lang('date'); ?></th>
                            <th class="w-15 text-center"><?php echo lang('grand_total'); ?></th>
                            <th class="w-20"><?php echo lang('added_by'); ?></th>
                            <th class="w-20"><?php echo lang('added_date'); ?></th>
                            <th class="w-5 text-center"><?php echo lang('actions'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(isset($fixed_items_stock) && $fixed_items_stock){
                                $i = count($fixed_items_stock);
                                foreach($fixed_items_stock as $stock){
                        ?>
                                    <tr>
                                        <td><?php echo $i--; ?></td>
                                        <td><?php echo escape_output($stock->reference_no) ?></td>
                                        <td><?php echo dateFormat($stock->date) ?></td>
                                        <td class="text-center"><?php echo getAmtCustom($stock->grand_total) ?></td>
                                        <td><?php echo employeeName($stock->user_id) ?></td>
                                        <td><?php echo dateFormat($stock->added_date) ?></td>
                                        <td class="text-center">
                                            <div class="btn_group_wrap">
                                                <a class="btn btn-warning" href="<?php echo base_url() ?>Fixed_asset_stock/addEditStock/<?php echo $this->custom->encrypt_decrypt($stock->id, 'encrypt'); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                                data-bs-original-title="<?php echo lang('edit'); ?>">
                                                    <i class="far fa-edit"></i>
                                                </a>
                                                <a class="delete btn btn-danger" href="<?php echo base_url() ?>Fixed_asset_stock/deleteStock/<?php echo $this->custom->encrypt_decrypt($stock->id, 'encrypt'); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php echo lang('delete'); ?>">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </a>
                                            </div>

                                        </td>
                                    </tr>
                        <?php }} ?>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div> 
    </div>
</div>

<?php $this->load->view('updater/reuseJs')?>