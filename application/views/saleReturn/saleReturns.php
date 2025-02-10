
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
                <h3 class="top-left-header"><?php echo lang('list_sale_return'); ?> </h3>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('list_sale_return'); ?>" data-id_name="datatable">
                <div class="btn_list m-right d-flex">
                    <a class="new-btn" href="<?php echo base_url() ?>Sale_return/addEditSaleReturn">
                    <iconify-icon icon="solar:add-circle-broken" width="22"></iconify-icon> <?php echo lang('add_sale_return'); ?>
                    </a>
                </div>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('sale_return'), 'secondSection'=> lang('list_sale_return')])?>
        </div>
    </section>




    <div class="box-wrapper">
        <div class="table-box">
            <div class="box-body">
                <div class="table-responsive">
                    <table id="datatable" class="table table-bordered table-striped sales_return_ajax_page">
                        <thead>
                        <tr>
                            <th class="w-5"><?php echo lang('sn'); ?></th>
                            <th class="w-10"><?php echo lang('reference_no'); ?></th>
                            <th class="w-10"><?php echo lang('date'); ?></th>
                            <th class="w-10"><?php echo lang('customer'); ?></th>
                            <th class="w-10"><?php echo lang('total_return_amount'); ?></th>
                            <th class="w-10"><?php echo lang('paid'); ?></th>
                            <th class="w-10"><?php echo lang('due'); ?></th>
                            <th class="w-10"><?php echo lang('note'); ?></th>
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
<script src="<?php echo base_url(); ?>frequent_changing/js/sale_return.js"></script>

