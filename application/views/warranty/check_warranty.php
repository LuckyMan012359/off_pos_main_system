<script src="<?php echo base_url('frequent_changing/js/check_warranty.js'); ?>"></script>



<div class="main-content-wrapper">

    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo lang('check_warranty'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('check_warranty'), 'secondSection'=> lang('check_warranty')])?>
        </div>
    </section>


    <div class="box-wrapper">
        <div class="table-box">
            <?php  
                echo form_open(base_url() . 'Warranty/checkWarranty');
            ?>
            <div class="box-body">
                <h3 class="top-left-header">Search Warranty Product By Invoice</h3>
                <hr>
                <div class="row">
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="form-group">
                            <label for="customer_id" class="form-label"><?php echo lang('customers');?></label>
                            <select name="customer_id" id="customer_id" class="form-control select2">
                                <option value=""><?php echo lang('select_customer');?></option>
                                <?php foreach($allCustomers as $customer){ ?>
                                <option value="<?php echo escape_output($customer->id);?>"><?php echo escape_output($customer->name);?> <?php echo escape_output($customer->phone) != '' ?  ' (' . $customer->phone . ')' : '';?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="form-group">
                            <label for="sele_invoice" class="form-label"><?php echo lang('sale_invoice');?></label>
                            <select name="sele_invoice" id="sele_invoice" class="form-control select2">
                                <option value=""><?php echo lang('select_invoice');?></option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="box-footer">
                <button type="submit" name="submit" value="submit" class="btn bg-blue-btn">
                    <iconify-icon icon="solar:upload-minimalistic-broken"></iconify-icon>
                    <?php echo lang('submit'); ?>
                </button>
            </div>

            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>frequent_changing/js/add_warranty.js"></script>




