

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
                <h3 class="top-left-header"><?php echo lang('list_purchase_ruturn'); ?> </h3>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('list_purchase_ruturn'); ?>" data-id_name="datatable">
                <div class="btn_list m-right d-flex">
                    <a class="new-btn me-1" href="<?php echo base_url() ?>Purchase_return/addEditPurchaseReturn">
                    <iconify-icon icon="solar:add-circle-broken" width="22"></iconify-icon> <?php echo lang('add_purchase_return'); ?>
                    </a>
                    <button class="dataFilterBy new-btn"><iconify-icon icon="solar:filter-broken"  width="22"></iconify-icon><?php echo lang('filter_by');?></button>
                </div>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('purchase_return'), 'secondSection'=> lang('list_purchase_ruturn')])?>
        </div>
    </section>

    <div class="box-wrapper">
        <div class="table-box">
            <div class="box-body">
                <div class="table-responsive">
                    <table id="datatable" class="table table-bordered table-striped purchase_return_ajax_page">
                        <thead>
                        <tr>
                            <th class="w-5"><?php echo lang('sn'); ?></th>
                            <th class="w-10"><?php echo lang('ref_no'); ?></th>
                            <th class="w-10"><?php echo lang('date'); ?></th>
                            <th class="w-10"><?php echo lang('supplier'); ?></th>
                            <th class="w-15"><?php echo lang('total_return_amount'); ?></th>
                            <th class="w-25"><?php echo lang('note'); ?></th>
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
        <?php echo form_open(base_url() . 'Purchase_return/purchaseReturns') ?>
        <div class="row">
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <select  class="form-control  select2 op_width_100_p" name="supplier_id" id="supplier_id_filter">
                        <option value=""><?php echo lang('supplier'); ?></option>
                        <?php foreach ($suppliers as $value) { ?>
                            <option value="<?php echo escape_output($value->id) ?>" <?php echo set_select('supplier_id', $value->id); ?>><?php echo escape_output($value->name) ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <select  class="form-control  select2 op_width_100_p" name="status" id="status_filter">
                        <option value=""><?php echo lang('status'); ?></option>
                        <option value="draft" <?= set_select('status','draft')?>><?php echo lang('draft');?></option>
                        <option value="taken_by_sup_pro_not_returned" <?= set_select('status','taken_by_sup_pro_not_returned')?>><?php echo lang('taken_by_sup_pro_not_returned');?></option>
                        <option value="taken_by_sup_money_returned" <?= set_select('status','taken_by_sup_money_returned')?>><?php echo lang('taken_by_sup_money_returned');?></option>
                        <option value="taken_by_sup_pro_returned" <?= set_select('status','taken_by_sup_pro_returned')?>><?php echo lang('taken_by_sup_pro_returned');?></option>
                    </select>
                </div>            
            </div>
            
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <select  class="form-control select2 ir_w_100" id="outlet_id_filter" name="outlet_id">
                        <option value=""><?php echo lang('outlet'); ?></option>
                        <?php
                        $outlets = getAllOutlestByAssign();
                        foreach ($outlets as $value):
                            ?>
                            <option <?= set_select('outlet_id',$value->id)?>  value="<?php echo escape_output($value->id) ?>"><?php echo escape_output($value->outlet_name) ?></option>
                            <?php
                        endforeach;
                        ?>
                    </select>
                </div>
            </div>
            <div class="clear-fix"></div>
            <div class="col-sm-12 col-md-6 mb-2">
                <button type="submit" name="submit" value="submit" class="new-btn">
                    <iconify-icon icon="solar:hourglass-broken" width="22"></iconify-icon>
                    <?php echo lang('submit'); ?>
                </button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>




<?php $this->load->view('updater/reuseJs2')?>
<script src="<?php echo base_url(); ?>frequent_changing/js/purchase_return.js"></script>

