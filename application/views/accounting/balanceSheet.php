<div class="main-content-wrapper">

    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header"><?php echo lang('Balance_Sheet'); ?> </h3>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('Balance_Sheet'); ?>" data-id_name="datatable">
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('Balance_Sheet'), 'secondSection'=> lang('Balance_Sheet')])?>
        </div>
    </section>

    <div class="box-wrapper">
        <div class="">
            <h4 class="op_center center_top_margin_0"><?php
                if (isset($account_id) && $account_id):
                    echo lang('Account').": <span>" . escape_output(getPaymentName($account_id)) . "</span>";
                else:
                    echo "&nbsp;";
                endif;
                ?></h4>
                <h4 class="op_center" ><?= isset($start_date) && $start_date && isset($end_date) && $end_date ? lang('report_date') . date($this->session->userdata('date_format'), strtotime($start_date)) . " - " . date($this->session->userdata('date_format'), strtotime($end_date)) : '' ?><?= isset($start_date) && $start_date && !$end_date ? lang('report_date') . date($this->session->userdata('date_format'), strtotime($start_date)) : '' ?><?= isset($end_date) && $end_date && !$start_date ? lang('report_date') . date($this->session->userdata('date_format'), strtotime($end_date)) : '' ?>&nbsp;</h4>
        </div>
        <div class="table-box">
            <div class="table-responsive">
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('Balance_Sheet'); ?>" data-id_name="datatable">
                <table id="datatable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th class="w-5"><?php echo lang('sn'); ?></th>
                        <th class="w-25"><?php echo lang('account_name'); ?></th>
                        <th class="w-25"><?php echo lang('Credit'); ?></th>
                        <th class="w-25"><?php echo lang('Debit'); ?></th>
                        <th class="w-20"><?php echo lang('balance'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i = 1;
                    $balance = 0;
                    $total_debit = 0;
                    $total_credit = 0;
                    $total_balance= 0;
                    if (isset($payment_methods) && $payment_methods):
                        foreach ($payment_methods as $key => $value) {
                            $balance = $value->credit_balance - $value->debit_balance;
                            $total_debit += $value->debit_balance;
                            $total_credit += $value->credit_balance;
                            $total_balance += $balance;
                            ?>
                            <tr>
                                <td class="on_text_2"><?php echo escape_output($i); ?></td>
                                <td><?php echo escape_output($value->name) ?></td>
                                <td><?php echo ($value->credit_balance == 0 ? '' : getAmtCustom($value->credit_balance))?></td>
                                <td><?php echo ($value->debit_balance == 0 ? '' : getAmtCustom($value->debit_balance))?></td>
                                <td  class="text-right">
                                    <?php if($balance > 0){ 
                                        echo getAmtCustom($balance) . ' (Credit)';
                                    }?>
                                    <?php if($balance < 0){ 
                                        echo getAmtCustom(absCustom($balance)) . ' (Debit)';
                                    }?>
                                </td>
                            </tr>
                            <?php
                            $i++;
                        }
                    endif;
                    ?>
                    <tr>
                        <th class="w-5"></th>
                        <th class="w-25"><?php echo lang('total'); ?></th>
                        <th class="w-25"><?php echo ($total_credit == 0 ? '' : getAmtCustom($total_credit))?></th>
                        <th class="w-25"><?php echo ($total_debit == 0 ? '' : getAmtCustom($total_debit))?></th>
                        <th>
                            <?php if($total_balance > 0){ 
                                echo getAmtCustom($total_balance) . ' (Credit)';
                            }?>
                            <?php if($total_balance < 0){ 
                                echo getAmtCustom(absCustom($total_balance)) . ' (Debit)';
                            }?>
                        </th>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<?php $this->view('updater/reuseJs'); ?>