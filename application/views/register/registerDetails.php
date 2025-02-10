<input type="hidden" id="copy_db_exp" value="<?php echo lang('copy'); ?>">
<input type="hidden" id="print_db_exp" value="<?php echo lang('print'); ?>">
<input type="hidden" id="excel_db_exp" value="<?php echo lang('excel'); ?>">
<input type="hidden" id="csv_db_exp" value="<?php echo lang('csv'); ?>">
<input type="hidden" id="pdf_db_exp" value="<?php echo lang('pdf'); ?>">

<link href="<?php echo base_url(); ?>frequent_changing/css/register_details.css" rel="stylesheet" type="text/css">

<section class="main-content-wrapper">
<h3 class="display_none">&nbsp;</h3>
    <?php
    if ($this->session->flashdata('exception_3')) {
        echo '<section class="alert-wrapper"><div class="alert alert-danger alert-dismissible"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <div class="alert-body"><i class="m-right fa fa-check"></i>';
        echo escape_output($this->session->flashdata('exception_3'));unset($_SESSION['exception_3']);
        echo '</div></div></section>';
    }
    ?>
    <input type="hidden" id="base_url_customer" value="<?php echo base_url()?>">
    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo lang('register_details'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('register_details'), 'secondSection'=> lang('register_details')])?>
        </div>
    </section>


    <div class="box-wrapper">
        <!-- general form elements -->
        <div class="table-box">
            <!-- form start -->
            <div class="box-body">
                <a href="<?php echo base_url();?>Sale/closeRegister" class="btn bg-blue-btn mb-3"><?php echo lang('close_register');?></a>
                <div class="row">
                    <input type="hidden" class="datatable_name" data-title="<?php echo lang('register_details'); ?>" data-id_name="datatable">
                    <div class="html_content userHome">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script src="<?php echo base_url(); ?>assets/POS/js/jquery-3.3.1.min.js"></script>
<script src="<?php echo base_url(); ?>assets/POS/js/datable.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/buttons.print.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/jszip.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/pdfmake.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/register_details.js"></script>