<input type="hidden" id="delivery_status_change" value="<?php echo lang('delivery_status_change'); ?>">
<input type="hidden" id="account_field_required" value="<?php echo lang('account_field_required'); ?>">

<input type="hidden" id="base_url_hidden" value="<?php echo base_url(); ?>">
<div class="main-content-wrapper">
    <div class="ajax-message"></div>
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
                <h3 class="top-left-header"><?php echo lang('list_sale'); ?> </h3>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('list_sale'); ?>" data-id_name="datatable">
                <div class="btn_list m-right d-flex">
                    <a class="new-btn me-1" href="<?php echo base_url() ?>Sale/POS">
                    <iconify-icon icon="solar:add-circle-broken" width="22"></iconify-icon> <?php echo lang('add_sale'); ?>
                    </a>
                    <button type="button" class="dataFilterBy new-btn">
                        <iconify-icon icon="solar:filter-broken"  width="22"></iconify-icon> 
                        <?php echo lang('filter_by');?>
                    </button>
                </div>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('sale'), 'secondSection'=> lang('list_sale')])?>
        </div>
    </section>




    <div class="box-wrapper">
        <div class="table-box"> 
            <!-- /.box-header -->
            <div class="table-responsive"> 
                <table id="datatable" class="table table-bordered table-striped sales_ajax_page">
                    <thead>
                        <tr>
                            <th class="op_width_1_p op_center"><?php echo lang('sn'); ?></th>
                            <th class="w-10"><?php echo lang('ref_no'); ?></th>
                            <th class="w-15"><?php echo lang('date'); ?>(<?php echo lang('time'); ?>)</th>
                            <th class="w-13"><?php echo lang('customer'); ?></th>
                            <th class="w-12 text-center"><?php echo lang('total_payable'); ?></th>
                            <th class="w-20"><?php echo lang('delivery_status'); ?></th>
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
</div>



<div class="filter-overlay"></div>
<div id="product-filter" class="filter-modal">
    <div class="filter-modal-body">
        <header>
            <h3 class="filter-modal-title"><span><?php echo lang('FilterOptions'); ?></span></h3>
            <button type="button" class="close-filter-modal" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">
                    <i data-feather="x"></i>
                </span>
            </button>
        </header>
        <?php echo form_open(base_url() . 'Sale/sales') ?>
        <div class="row">
            <div class="col-sm-12 mb-2">
                <div class="form-group">
                    <select name="delivery_status" id="delivery_status_filter" class="form-control  select2 width_100_p" >
                        <option value=""><?php echo lang('select'); ?></option>
                        <option value="Sent" <?php echo set_select('delivery_status', 'Sent'); ?>><?php echo lang('Sent'); ?></option>
                        <option value="Returned" <?php echo set_select('delivery_status', 'Returned'); ?>><?php echo lang('Returned'); ?></option>
                        <option value="Cash Received" <?php echo set_select('delivery_status', 'Cash Received'); ?>><?php echo lang('Cash_Received'); ?></option>
                    </select>
                </div>
            </div>
            <div class="clear-fix"></div>
            <div class="col-sm-12 col-md-6">
                <button type="submit" name="submit" value="submit" class="new-btn">
                    <iconify-icon icon="solar:hourglass-broken" width="22"></iconify-icon>
                    <?php echo lang('submit'); ?>
                </button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>


<!-- DataTables -->
<?php $this->load->view('updater/reuseJs2')?>
<script src="<?php echo base_url(); ?>frequent_changing/js/sales.js"></script>