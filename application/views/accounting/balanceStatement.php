

<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/report.css">

<div class="main-content-wrapper">

    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header"><?php echo lang('Balance_Statement'); ?> </h3>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('Balance_Statement'); ?>" data-id_name="datatable">
                <div class="btn_list m-right d-flex">
                    <button type="button" class="dataFilterBy new-btn"><iconify-icon icon="solar:filter-broken"  width="22"></iconify-icon> <?php echo lang('filter_by');?></button>
                </div>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('Balance_Statement'), 'secondSection'=> lang('Balance_Statement')])?>
        </div>
    </section>
    


    <div class="box-wrapper">


        <!-- Header Start -->
        <div class="report_header">
            <h3 class="company_name"><?php echo escape_output($this->session->userdata('business_name'));?> </h3>
            <?php if (isset($account_id) && $account_id): ?>
            <h5 class="outlet_info">
                <strong><?php echo lang('Account'); ?>: </strong> <?=  escape_output(getPaymentName($account_id)); ?>
            </h5>
            <?php endif; ?>


            <?php if(isset($start_date)) { ?>
            <span class="outlet_info date_range">
                <strong><?php echo lang('date');?>:</strong>
                <?php
                    if(isset($start_date) && $start_date != '1970-01-01') {
                        echo date($this->session->userdata('date_format'), strtotime($start_date));
                    }
                    if((isset($start_date) && isset($end_date)) && ($start_date != '1970-01-01' && $end_date != '1970-01-01')){
                        echo ' - ';
                    }
                    if(isset($end_date) && $end_date != '1970-01-01') {
                        echo date($this->session->userdata('date_format'), strtotime($end_date));
                    }
                ?>
            </span>
            <?php } ?>
        </div>
        <!-- Header End -->
        
        <div class="table-box">
            <div class="table-responsive">
                <table id="datatable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th class="w-5"><?php echo lang('sn'); ?></th>
                        <th><?php echo lang('date'); ?></th>
                        <?php if (isset($account_id) && !$account_id){ ?>
                            <th><?php echo lang('account_name'); ?></th>
                        <?php } ?>
                        <th><?php echo lang('title'); ?></th>
                        <th><?php echo lang('note'); ?></th>
                        <th class="text-center"><?php echo lang('Credit'); ?></th>
                        <th class="text-center"><?php echo lang('Debit'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        $creditTotal = 0;
                        $debitTotal = 0;
                        foreach($balance_statement as $key=>$balance){ 
                        $creditTotal +=  (int)$balance->credit;
                        $debitTotal +=  (int)$balance->debit;
                        ?>
                            <tr>
                                <td><?php echo $key +1 ?></td>
                                <td><?php echo date($this->session->userdata('date_format'), strtotime($balance->date)) ?></td>
                                <td><?php echo escape_output($balance->type) ?></td>
                                <td><?php echo escape_output($balance->note) ?></td>
                                <td class="text-center"><?php echo ($balance->credit) != 0 ? getAmtCustom($balance->credit) : '' ?></td>
                                <td><?php echo ($balance->debit) != 0 ? getAmtCustom($balance->debit) : '' ?></td>
                            </tr>
                        <?php }  ?>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th class="text-center"><?php echo lang('total'); ?></th>
                            <th class="text-center"><?php echo ($creditTotal == 0 ? '' : getAmtCustom($creditTotal))?></th>
                            <th><?php echo ($debitTotal == 0 ? '' : getAmtCustom($debitTotal))?></th>
                        </tr>
                        <tr>
                            <?php $balance = $creditTotal - $debitTotal; ?>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th class="text-center"><?php echo lang('balance'); ?></th>
                            <th>
                                <?php if($balance > 0){ 
                                    echo getAmtCustom($balance);
                                }?>
                            </th>
                            <th>
                                <?php if($balance < 0){ 
                                    echo getAmtCustom(absCustom($balance));
                                }?>
                            </th>
                        </tr>
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
        <?php echo form_open(base_url() . 'Accounting/balanceStatement', $arrayName = array('id' => 'balanceStatement')) ?>
        <div class="row">
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group ">
                    <input autocomplete="off" type="text" id="startdate" name="startDate" readonly class="form-control customDatepicker" placeholder="<?php echo lang('start_date'); ?>" value="<?php echo isset($_POST['startDate']) && $_POST['startDate'] ? $_POST['startDate'] : '' ?>">
                </div>
                <div class="alert alert-error error-msg startdate_err_msg_contnr">
                    <p id="startdate_err_msg" class="text-left"></p>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group ">
                    <input autocomplete="off" type="text" id="endMonth" name="endDate" readonly class="form-control customDatepicker" placeholder="<?php echo lang('end_date'); ?>" value="<?php echo isset($_POST['endDate']) && $_POST['endDate'] ? $_POST['endDate'] : '' ?>">
                </div>
                <div class="alert alert-error error-msg enddate_err_msg_contnr">
                    <p id="enddate_err_msg" class="text-left"></p>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group ">
                    <select class="form-control select2"  id="account_id" name="account_id">
                        <option value=""><?php echo lang('Account'); ?></option>
                        <?php
                        foreach ($payment_methods as $value) {
                            ?>
                            <option <?php echo isset($_POST['account_id']) && $_POST['account_id'] ? ($_POST['account_id'] == $value->id ? 'selected' : '') : '' ?> value="<?php echo ($value->id) ?>"><?php echo ($value->name) ?></option>
                        <?php } ?>
                    </select>
                    <div class="alert alert-error error-msg account_err_msg_contnr">
                        <p id="account_err_msg" class="text-left"></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group ">
                    <select class="form-control select2"  id="type" name="type">
                        <option <?php echo isset($_POST['type']) && $_POST['type'] ? ($_POST['type'] == 'all' ? 'selected' : '') : '' ?>   value="all"><?php echo lang('all'); ?> <?php echo lang('type'); ?></option>
                        <option <?php echo isset($_POST['type']) && $_POST['type'] ? ($_POST['type'] == '1' ? 'selected' : '') : '' ?> value="1"><?php echo lang('Credit'); ?></option>
                        <option <?php echo isset($_POST['type']) && $_POST['type'] ? ($_POST['type'] == '2' ? 'selected' : '') : '' ?> value="2"><?php echo lang('Debit'); ?></option>
                    </select>
                </div>
            </div>
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

<?php $this->view('updater/reuseJs')?>
<script src="<?php echo base_url();?>frequent_changing/js/balancestatement.js"></script>
