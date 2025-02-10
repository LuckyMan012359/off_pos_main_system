<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/local/jquery-ui.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/drag_drop.css">
<div class="main-content-wrapper">
    <div id="ajax-message"></div>
<?php
    if ($this->session->flashdata('exception')) {
        echo '<section class="alert-wrapper">
        <div class="alert alert-success alert-dismissible fade show"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <div class="alert-body">
        <i class="m-right fa fa-check"></i>';
        echo escape_output($this->session->flashdata('exception'));unset($_SESSION['exception']);
        echo '</div></div></section>';
    }
    ?>

    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo lang('payment_method_sorting'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('payment_method'), 'secondSection'=> lang('payment_method_sorting')])?>
        </div>
    </section>

    <div class="box-wrapper">
        <div class="table-box">
            <div>
                <ul class="sort_category list-group">
                    <?php 
                        foreach ($payment_method as $payment){ 
                    ?>
                        <li class="list-group-item"  data-id="<?php echo escape_output($payment->id) ?>">
                        <span class="handle"><iconify-icon icon="jam:move" width="16"></iconify-icon></span> <?php echo escape_output($payment->name) ?></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/plugins/jQueryUI/jquery-ui.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/payment_method_sort.js"></script>
