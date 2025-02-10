
<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/report.css">

<div class="main-content-wrapper">



    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header"><?php echo lang('Trial_Balance'); ?> </h3>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('Trial_Balance'); ?>" data-id_name="datatable">
                <div class="btn_list m-right d-flex">
                    <button type="button" class="dataFilterBy new-btn"><iconify-icon icon="solar:filter-broken"  width="22"></iconify-icon> <?php echo lang('filter_by');?></button>
                </div>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('Trial_Balance'), 'secondSection'=> lang('Trial_Balance')])?>
        </div>
    </section>
    

    <div class="box-wrapper">

        <!-- Header Start -->
        <div class="report_header">
            <h3 class="company_name"><?php echo escape_output($this->session->userdata('business_name'));?> </h3>
            <?php if(isset($start_date)){ ?>
                <h5 class="outlet_info">
                    <strong><?php echo lang('date');?>:</strong>
                    <?php
                        if(!empty($start_date) && $start_date != '1970-01-01') {
                            echo date($this->session->userdata('date_format'), strtotime($start_date));
                        } 
                    ?>
                </h5>
            <?php }else{ ?>
                <h5 class="outlet_info">
                    <strong><?php echo lang('date');?>:</strong>
                    <?php echo date($this->session->userdata('date_format'), strtotime(date('Y-m-d'))); ?>
                </h5>
            <?php } ?>
        </div>
        <!-- Header End -->


        <div class="table-box">
            <div class="body-box">
                <div class="table-responsive">
                    
                    <input type="hidden" class="datatable_name" data-title="<?php echo lang('Trail_Balance'); ?>" data-id_name="datatable">
                    <table id="datatable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th class="w-5"><?php echo lang('sn'); ?></th>
                            <th class="w-33"><?php echo lang('title'); ?></th>
                            <th class="w-33"><?php echo lang('Debit'); ?></th>
                            <th class="op_width_33_p text-right"><?php echo lang('Credit'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $sumOfDebit = 0;
                        $sumOfCredit = 0;
                        if(isset($trial_balance) && $trial_balance){
                            foreach($trial_balance as $kye=>$trial){
                                $sumOfDebit += $trial->debit;
                                $sumOfCredit += $trial->credit;
                        ?>
                        <tr>
                            <td><?php echo $kye+1;?></td>
                            <td><?php echo escape_output($trial->type);?></td>
                            <td><?php echo getAmtCustom($trial->debit);?></td>
                            <td><?php echo getAmtCustom($trial->credit);?></td>
                        </tr>
                        <?php }} ?>
                        <tr>
                            <th></th>
                            <th><?php echo lang('total');?></th>
                            <th><?php echo getAmtCustom($sumOfDebit);?></th>
                            <th><?php echo getAmtCustom($sumOfCredit);?></th>
                        </tr>
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
        <?php echo form_open(base_url() . 'Accounting/trialBalance', $arrayName = array('id' => 'trialBalance')) ?>
        <div class="row">
            <div class="col-sm-12 col-md-12 mb-2">
                <div class="form-group">
                    <input autocomplete="off" type="text"  name="date" readonly class="form-control customDatepicker" placeholder="<?php echo lang('date'); ?>" value="<?php echo set_value('date'); ?>">
                </div>
                <?php if (form_error('date')) { ?>
                    <div class="alert alert-error txt-uh-21">
                        <span class="error_paragraph"><?php echo form_error('date'); ?></span>
                    </div>
                <?php } ?>
            </div>
            <div class="col-sm-12 col-md-12 mb-2">
                <button type="submit" name="submit" value="submit" class="new-btn">
                    <iconify-icon icon="solar:hourglass-broken" width="22"></iconify-icon>
                    <?php echo lang('submit'); ?>
                </button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<?php $this->view('updater/reuseJs')?>