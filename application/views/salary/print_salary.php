<?php 
$outlet_info = getOutletSetting();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo lang('generate_salary_for')?>: <?php echo escape_output($getSelectedRow->month); ?> - <?php echo escape_output($getSelectedRow->year); ?></title>
    <script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css">
    <script src="<?php echo base_url(); ?>assets/bootstrap/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/salary_print.css" type="text/css">
</head>
<body>


<div id="wrapper">
    <div id="receiptData">
        <div id="receipt-data">
            <div id="receipt-data">
                <div class="logo_header">
                    <table class="width_100_p">
                        <tr>
                            <td>
                                <h1 class="s_p_1 font-700"> <?php echo getSessionBusinessName(); ?> </h1>
                                <h3 class="s_p_1"><strong><?php echo lang('outlet'); ?>:</strong> <?php echo escape_output($outlet_info->outlet_name) ?> </h3>
                                <p class="s_p_3" ><strong><?php echo lang('address'); ?>:</strong> <?php echo escape_output($outlet_info->address) ?></p>
                                <p class="s_p_3" ><strong><?php echo lang('email'); ?>:</strong> <?php echo escape_output($outlet_info->email) ?></p>
                                <p class="s_p_3" ><strong><?php echo lang('phone'); ?>:</strong> <?php echo escape_output($outlet_info->phone) ?></p>
                                <div class="d-flex align-items-center">
                                    <span class="inv_black px-2"><?php echo lang('salary_sheet_for')?>: <?php echo escape_output($getSelectedRow->month); ?> - <?php echo escape_output($getSelectedRow->year); ?></span>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <br>
                    <table class="tbl width_100_p">
                        <tr class="s_p_4 p_txt_7">
                            <td class="w-5">#</td>
                            <td class="w-25"><?php echo lang('name'); ?></td>
                            <td class="w-5"><?php echo lang('salary'); ?></td>
                            <td class="w-5"><?php echo lang('addition'); ?></td>
                            <td class="w-5"><?php echo lang('subtraction'); ?></td>
                            <td class="w-15"><?php echo lang('total'); ?></td>
                            <td class="w-40"><?php echo lang('note'); ?></td>
                        </tr>
                        <?php
                        $getData = json_decode($getSelectedRow->details_info);
                        $salary_total = 0;
                        $addition = 0;
                        $subtraction = 0;
                        $total = 0;
                        $i = 1;
                        foreach ($getData as $usrs) {
                            if($usrs->p_status==1):
                            $total+=intval($usrs->total);
                            $addition+= intval($usrs->additional);
                            $subtraction+=intval($usrs->subtraction);
                            $salary_total+=intval($usrs->salary);
                            ?>
                            <tr class="row_counter" data-id="<?php echo escape_output($usrs->user_id); ?>">
                                <td class="c_center">
                                    <?php echo escape_output($i++); ?>
                                </td>
                                <td><?php echo escape_output($usrs->name); ?> </td>
                                <td><?php echo isset($usrs->salary) && $usrs->salary ? getAmtCustom($usrs->salary) : getAmtCustom(0) ?></td>
                                <td><?php echo isset($usrs->additional) && $usrs->additional ? getAmtCustom($usrs->additional) : getAmtCustom(0) ?></td>
                                <td><?php echo isset($usrs->subtraction) && $usrs->subtraction? getAmtCustom($usrs->subtraction) : getAmtCustom(0) ?></td>
                                <td><?php echo isset($usrs->total) && $usrs->total? getAmtCustom($usrs->total) : getAmtCustom(0) ?></td>
                                <td><?php echo isset($usrs->notes) && $usrs->notes?$usrs->notes:''?></td>
                            </tr>
                        <?php
                        endif;
                        }
                        ?>
                     
                        <tr>
                            <td colspan="2"><strong><?php echo lang('total');?></strong></td>
                            <td><strong><?php echo getAmtCustom($salary_total); ?></strong></td>
                            <td><strong><?php echo getAmtCustom($addition); ?></strong></td>
                            <td><strong><?php echo getAmtCustom($subtraction); ?></strong></td>
                            <td><strong><?php echo getAmtCustom($total); ?></strong></td>
                            <td></td>
                        </tr>
                    </table>
                </div>

            </div>
        </div>
        <div  class="clear_both"></div>
    </div>
    <footer>
        <div  class="p_txt_12">
            <div class="p_txt_13">

            </div>
            <div class="p_txt_13">
                <p>&nbsp;</p>
            </div>
            <div class="p_txt_13">
                <p>&nbsp;</p>
            </div>
            <div class="p_txt_15 text-right ">
                <span class="p_txt_14 border-top-A2A2A2 padding-top-10"><?php echo lang('authorized_signature'); ?></span>
            </div>
    </footer>
    <div class="p_txt_16 no_print">
        <hr>
        <span class="pull-right col-xs-12">
        <button onclick="window.print();" class="btn btn-block bg-blue-btn"><?php echo lang('print'); ?></button> </span>
        <div  class="clear_both"></div>
        <div class="p_txt_17">
            <div class="p_txt_18">
                Please follow these steps before you print for first tiem:
            </div>
            <p class="p_txt_19">
                1. Disable Header and Footer in browser's print setting<br>
                For Firefox: File &gt; Page Setup &gt; Margins &amp; Header/Footer &gt; Headers & Footers &gt; Make all --blank--<br>
                For Chrome: Menu &gt; Print &gt; Uncheck Header/Footer in More Options
            </p>
            <p class="p_txt_19">
                2. Set margin 0.5<br>
                For Firefox: File &gt; Page Setup &gt; Margins &amp; Header/Footer &gt; Headers & Footers &gt; Margins (inches) &gt; set all margins 0.5<br>
                For Chrome: Menu &gt; Print &gt; Set Margins to Default
            </p>
        </div>
        <div  class="clear_both"></div>
    </div>
    <script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>frequent_changing/js/common-print.js"></script>
</body>
</html>
