<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo lang('transfer');?> <?php echo lang('reference_no'); ?>: <?= $transfer->reference_no; ?></title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/inv_font.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/print_invoice_a4.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/inv_common.css">
</head>
<body>
    <div id="wrapper" class="m-auto border-2s-e4e5ea br-5 p-30">
        <div class="pb-20">
            <h2 class="text-center"><?php echo lang('Transfer_Invoice');?></h2>
        </div>
        <div>
            <div class="d-flex justify-content-between">
                <div>
                    <h3 class="pb-10"><?php echo lang('Sender_Outlet');?></h3>
                    <p class="pb-7"><?php echo escape_output($from_outlet->outlet_name) ?? ''; ?></p>
                    <p class="pb-7"><?php echo escape_output($from_outlet->address) ?? ''; ?></p>
                    <p class="pb-7"><?php echo escape_output($from_outlet->phone) ?? ''; ?></p>
                    <p class="pb-7"><?php echo escape_output($from_outlet->email) ?? ''; ?></p>

                    <h3 class="pb-10 pt-10"><?php echo lang('Sending_Details');?></h3>
                    <p class="pb-7 f-w-500 color-71"><span class="f-w-600"><?php echo lang('reference_no');?>:</span> <?php echo escape_output($transfer->reference_no); ?></p>
                    <p class="pb-7 f-w-500 color-71"><span class="f-w-600"><?php echo lang('date');?>:</span> <?php echo dateFormat($transfer->date); ?></p>
                    <p class="pb-7 f-w-500 color-71"><span class="f-w-600"><?php echo lang('name');?>:</span> <?php echo escape_output($user_info->full_name); ?></p>
                    <p class="pb-7 f-w-500 color-71"><span class="f-w-600"><?php echo lang('mobile');?>:</span> <?php echo escape_output($user_info->phone); ?></p>
                    <p class="pb-7 f-w-500 color-71"><span class="f-w-600"><?php echo lang('email');?>:</span> <?php echo escape_output($user_info->email_address); ?></p>
                </div>
                <div>
                    <h3 class="pb-10"><?php echo lang('Receiver_Outlet');?></h3>
                    <p class="pb-7"><?php echo escape_output($to_outlet->outlet_name) ?? ''; ?></p>
                    <p class="pb-7"><?php echo escape_output($to_outlet->address) ?? ''; ?></p>
                    <p class="pb-7"><?php echo escape_output($to_outlet->phone) ?? ''; ?></p>
                    <p class="pb-7"><?php echo escape_output($to_outlet->email) ?? ''; ?></p>
                </div>
            </div>
        </div>
        <div>
            <table class="table w-100 mt-20">
                <thead class="br-3 bg-00c53">
                    <tr>
                        <th class="w-5 pl-5"><?php echo lang('sn');?></th>
                        <th class="w-80"><?php echo lang('item');?> - <?php echo lang('brand'); ?> - <?php echo lang('code');?></th>
                        <th class="w-15 pr-5 text-right"><?php echo lang('qty');?></th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $i = 0;
                    if ($transfer_details && !empty($transfer_details)) {
                        foreach ($transfer_details as $pi) {
                            $i++;
                            echo '<tr class="op_border_white op_padding_6">' .
                            '<td><p>' . $i . '</p></td>' .
                            '<td><span>' . getItemNameCodeBrandByItemId($pi->ingredient_id) .'</span></td>' .
                            '<td class="text-right">' . $pi->quantity_amount . ' ' .  unitName(getPurchaseUnitIdByIgId($pi->ingredient_id)) . '</td>' .
                            '</tr>';
                        }
                    }
                ?>
                </tbody>
            </table>
        </div>
        <div class="d-grid g-template-c-50-40 grid-gap-10 pt-20">
            <?php if ($transfer->note_for_sender != "") {?>
            <div>
                <div class="pt-20">
                    <h4 class="d-block pb-10"><?php echo lang('Note_For_Sender');?></h4>
                    <div class="w-100 bg-240 h-120px p-15 b-1s-240">
                        <p>
                            <?php echo escape_output($transfer->note_for_sender); ?>
                        </p>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        <div class="d-flex justify-content-end mt-60">
            <div>
                <p class="color-71 d-inline b-t-1p-e4e5ea pt-10"><?php echo lang('Sender_Signature');?></p>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-80">
            <div>
                <p class="color-71 d-inline b-t-1p-e4e5ea pt-10"><?php echo lang('Receiver_Signature');?></p>
            </div>
        </div>
        <div class="d-flex justify-content-center pt-30">
            <button onclick="window.print();" type="button" class="print-btn"><?php echo lang('print');?></button>
        </div>
    </div>
    <script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>frequent_changing/js/onload_print.js"></script>
</body>
</html>