<div class="main-content-wrapper">
<?php
if ($this->session->flashdata('exception')) {
    echo '<section class="alert-wrapper"><div class="alert alert-success alert-dismissible fade show"> 
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></button>
    <div class="alert-body"><i class="icon fa fa-check me-2"></i>';
    echo escape_output($this->session->flashdata('exception'));unset($_SESSION['exception']);
    echo '</div></div></section>';
}
if ($this->session->flashdata('exception_1')) {
    echo '<section class="alert-wrapper"><div class="alert alert-danger alert-dismissible"> 
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></button>
    <div class="alert-body"><i class="icon fa fa-times me-2"></i>';
    echo $this->session->flashdata('exception_1');unset($_SESSION['exception_1']);
    //This variable could not be escaped because this is html content
    echo '</div></div></section>';
}

?> 
    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header"><?php echo lang('list_quotation'); ?> </h3>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('list_quotation'); ?>" data-id_name="datatable">
                <div class="btn_list m-right d-flex">
                    <a class="new-btn me-1" href="<?php echo base_url() ?>Quotation/addEditQuotation">
                    <iconify-icon icon="solar:add-circle-broken" width="22"></iconify-icon> <?php echo lang('add_quotation'); ?>
                    </a>
                </div>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('quotation'), 'secondSection'=> lang('list_quotation')])?>
        </div>
    </section>

    <div class="box-wrapper">
        <div class="table-box"> 
            <!-- /.box-header -->
            <div class="table-responsive"> 
                <table id="datatable" class="table table-responsive table-bordered table-striped quotation_ajax_page">
                    <thead>
                        <tr>
                            <th class="w-5"><?php echo lang('sn'); ?></th>
                            <th class="w-10"><?php echo lang('ref_no'); ?></th>
                            <th class="w-10"><?php echo lang('date'); ?></th>
                            <th class="w-10"><?php echo lang('customer'); ?></th>
                            <th class="w-15"><?php echo lang('discount'); ?></th>
                            <th class="w-15"><?php echo lang('g_total'); ?></th>
                            <th class="w-15"><?php echo lang('added_by'); ?></th>
                            <th class="w-15"><?php echo lang('added_date'); ?></th>
                            <th class="w-5"><?php echo lang('actions'); ?></th>
                        </tr>
                    </thead>
                </table>
            </div>
            <!-- /.box-body -->
        </div> 
    </div>
</div>


<div class="modal fade" id="barcode_print">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><span class="item_name"><?php echo lang('print_barcode');?></span></h4>
                <button type="button" class="btn-close m_close_trigger" data-bs-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true"><i data-feather="x"></i></span></button>
            </div>
            <div class="modal-body">
                <div class="row mt-3" id="barcode_wrap">
                </div>
            </div>
            <div class="modal-footer">
                <a  class="btn bg-blue-btn" id="print_barcode_wrap"><?php echo lang('Print');?></a>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('updater/reuseJs2')?>
<script src="<?php echo base_url(); ?>frequent_changing/js/quotations.js"></script>