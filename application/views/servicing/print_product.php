<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php echo lang('invoice_no');?>: <?php echo escape_output($sale_object->sale_no); ?></title>
        <meta http-equiv="cache-control" content="max-age=0">
        <meta http-equiv="cache-control" content="no-cache">
        <meta http-equiv="expires" content="0">
        <meta http-equiv="pragma" content="no-cache">
        <script src="/cdn-cgi/apps/head/Bx0hUCX-YaUCcleOh3fM_NqlPrk.js"></script>
        <link rel="stylesheet" href="theme.css" type="text/css">
        <script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css">
        <script src="<?php echo base_url(); ?>assets/bootstrap/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/custom_thems.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/print_invoice.css">
       
    </head>
    <body>
        <div id="wrapper">
            <div id="receiptData">

                <div id="receipt-data" class="op_size_optimize">
                    <div class="text-center">
                        <?php
                        $invoice_logo = $this->session->userdata('invoice_logo');
                        $show_hide = $this->session->userdata('show_hide');
                        if(isset($invoice_logo) && $invoice_logo && $show_hide=="Show"):
                            ?>
                            <img src="<?php echo base_url().'uploads/site_settings/'.$invoice_logo; ?>">
                            <?php
                            endif;
                        ?>
                        <h3>
                            <?php echo escape_output($this->session->userdata('outlet_name')); ?>
                        </h3>
                        <p><?php echo escape_output($this->session->userdata('address')); ?>
                            <br>
                            <?php echo lang('Tel');?>: <?php echo escape_output($this->session->userdata('phone')); ?>

                        </p>
                    </div>
                    
                    <div class="op_clear_both"></div>
                    <table class="table table-condensed">
                        <tbody>
                           
                        </tbody>
                        <tfoot>
                        


                            <tr>
                                <th><?php echo lang('Total_Item_S'); ?>: </th>
                                <th class="op_left"></th>
                            </tr>
                            <tr>
                                <th><?php echo lang('sub_total'); ?></th>
                                <th class="text-right"></th>
                            </tr>
                            
                                <tr>
                        <th><?php echo lang('total_discount'); ?>:</th>
                        <th class="text-right"></th>
                        </tr>
                            
                            <tr>
                        <th><?php echo lang('Delivery_Other'); ?>:</th>
                        <th class="text-right"></th>
                               
                        </tr>
                       
                       
                    </table>

                    <p class="text-center"> <?php echo $this->session->userdata('invoice_footer'); ?></p>

                </div>
                <div class="op_clear_both"></div>
                 
            </div>

            <div id="buttons" class="no-print op_padding_top_10 op_text_uppercase">
                <hr>



                <span class="pull-right col-xs-12">
                    <button onclick="window.print();" class="btn btn-block bg-blue-btn"><?php echo lang('print');?></button> </span>
                <div class="op_clear_both"></div>
                <div class="col-xs-12 op_bg_whitesmoke op_padding_10">
                    <p class="op_font_weight_b">
                        <?php echo lang('Please_don_t_forget_to_disble_the_header');?>
                    </p>
                    <p class="op_text_capitalize">
                        <strong><?php echo lang('FF');?>:</strong> <?php echo lang('File');?> &gt; <?php echo lang('Print_Setup');?>  &gt; <?php echo lang('Margin');?> &amp; <?php echo lang('Header_Footer_Make_all');?> 
                    </p>
                    <p class="op_text_capitalize">
                        <strong><?php echo lang('chrome');?>:</strong> <?php echo lang('menu');?> &gt; <?php echo lang('print');?> &gt; <?php echo lang('Disable_Header_Footer');?> &amp; <?php echo lang('Set_Margins_to_None');?> 
                    </p>
                </div>
                <div class="op_clear_both"></div>
            </div>
        </div>
        <script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>frequent_changing/js/onload_print.js"></script>
    </body>
</html>
