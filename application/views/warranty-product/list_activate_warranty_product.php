<input type="hidden" id="status_change" value="<?php echo lang('status_change');?>">
<div class="main-content-wrapper">
    <div id="message"></div>

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
                <h3 class="top-left-header"><?php echo lang('list_activated_warranty_product'); ?> </h3>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('list_activated_warranty_product'); ?>" data-id_name="datatable">
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('warranty_product'), 'secondSection'=> lang('list_activated_warranty_product')])?>
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
                                <th class="w-30"><?php echo lang('item_information'); ?></th>
                                <th class="w-30"><?php echo lang('customer_information'); ?></th>
                                <th class="w-30"><?php echo lang('sale_information'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($warranties && !empty($warranties)) {
                                $i = count($warranties);
                            }
                            foreach ($warranties as $value) {
                            ?>                       
                                <tr> 
                                    <td class="op_center"><?php echo $i--; ?></td>
                                    <td><?php echo '<strong>Item:</strong> ' . $value->item_name . ' (' . $value->item_code .')' . ' <br> <strong> IMEI/Serial: </strong>'. $value->expiry_imei_serial?></td>
                                    <td><?php echo $value->customer_name . ($value->customer_phone ? '(' . $value->customer_phone . ')' : '' )?></td>
                                    <td><?php echo '<strong>Sale No:</strong> ' . $value->sale_no . ' - ' . '<br> <strong>Sale Date:</strong> ' . dateFormat($value->date_time)?></td>
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

<?php $this->view('updater/reuseJs'); ?>
<script src="<?php echo base_url(); ?>frequent_changing/js/warranty.js"></script>
