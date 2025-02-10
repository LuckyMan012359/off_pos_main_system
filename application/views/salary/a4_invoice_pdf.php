<?php 
$outlet_info = getOutletSetting();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo lang('generate_salary_for')?>: <?php echo escape_output($getSelectedRow->month); ?> - <?php echo escape_output($getSelectedRow->year); ?></title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/pdf_common.css">
</head>
<body>
    <div id="wrapper" class="m-auto b-r-5 p-30" >
        <table>
            <tr>
                <td class="w-100 text-center">
                    <h1 class="font-700 text-center"> <?php echo getSessionBusinessName(); ?> </h1>
                    <h3 class="text-center"><strong><?php echo lang('outlet'); ?>:</strong> <?php echo escape_output($outlet_info->outlet_name) ?> </h3>
                    <p class="text-center"><strong><?php echo lang('address'); ?>:</strong> <?php echo escape_output($outlet_info->address) ?></p>
                    <p class="text-center"><strong><?php echo lang('email'); ?>:</strong> <?php echo escape_output($outlet_info->email) ?></p>
                    <p class="text-center"><strong><?php echo lang('phone'); ?>:</strong> <?php echo escape_output($outlet_info->phone) ?></p>
                    <?php if($this->session->userdata('collect_tax') == 'Yes'){ ?>
                        <p class="pb-7 f-w-900 rgb-71"><?php echo $this->session->userdata('tax_title'); ?>: <?php echo $this->session->userdata('tax_registration_no'); ?></p>
                    <?php } ?>
                    <div class="d-flex align-items-center">
                        <span class="inv_black px-2"><?php echo lang('salary_sheet_for')?>: <?php echo escape_output($getSelectedRow->month); ?> - <?php echo escape_output($getSelectedRow->year); ?></span>
                    </div>
                </td>
            </tr>
        </table>
        <br>
        <table class="w-100" id="salary-table">
            <tr>
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
</body>
</html>