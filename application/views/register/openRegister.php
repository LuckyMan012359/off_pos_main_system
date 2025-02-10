<section class="main-content-wrapper">
<h3 class="display_none">&nbsp;</h3>
    <?php
    if ($this->session->flashdata('exception_3')) {

        echo '<section class="alert-wrapper"><div class="alert alert-danger alert-dismissible"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <div class="alert-body"><p><i class="m-right fa fa-check"></i>';
        echo escape_output($this->session->flashdata('exception_3'));unset($_SESSION['exception_3']);
        echo '</div></div></section>';
    }
    ?>
    <?php
    if ($this->session->flashdata('exception')) {
        echo '<section class="alert-wrapper"><div class="alert alert-danger alert-dismissible fade show"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></button>
        <div class="alert-body"><i class="icon fa fa-times me-2"></i>';
        echo escape_output($this->session->flashdata('exception'));unset($_SESSION['exception']);
        echo '</div></div></section>';
    }
    ?>

    <div class="content-header">
        <h3 class="top-left-header">
            <?php echo lang('open_register'); ?>
        </h3>
    </div>


    <div class="box-wrapper">
        <!-- general form elements -->
        <div class="table-box">
            <!-- form start -->
            <?php echo form_open(base_url('Register/addBalance')); ?>
            <input type="hidden" name="opening_balance" id="opening_balance" class="opening_balance_hidden" value="0">
            <div>
                <div class="row">
                    <?php 
                    foreach ($payment_methods as $value):
                        if($value->account_type != 'Loyalty Point'):
                    
                    ?>

                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                            <label><?php echo escape_output($value->name); ?></label>
                            <input type="hidden" value="<?php echo escape_output($value->name); ?>" name="payment_names[]">
                            <input type="hidden" value="<?php echo escape_output($value->id); ?>" name="payment_ids[]">
                            <input  onfocus="select();" type="text" name="payments[]" class="form-control cal_row"
                                placeholder="<?php echo lang('opening_balance'); ?>"
                                value="0">
                        </div>
                        <?php if (form_error('opening_balance')) { ?>
                        <div class="callout callout-danger my-2">
                            <?php echo form_error('opening_balance'); ?>
                        </div>
                        <?php } ?>
                    </div>
                    <?php 
                    endif;
                    endforeach;
                    ?>

                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                            <label for=""><?php echo lang('counter');?> <span class="required_star">*</span></label>
                            <select name="counter_id" id="counter_id" class="select2 form-control">
                                <option value=""><?php echo lang('select_counter') ?></option>
                                <?php foreach($counters as $counter){ ?>
                                <option value="<?php echo escape_output($counter->id) ?>"><?php echo escape_output($counter->name) ?></option>
                                <?php } ?>
                            </select>
                            <?php if (form_error('counter_id')) { ?>
                        <div class="callout callout-danger my-2">
                            <?php echo form_error('counter_id'); ?>
                        </div>
                        <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <p>&nbsp;</p>
            <a><?php echo lang('total_opening_balance'); ?>: <?php echo escape_output($this->session->userdata('currency')); ?><span class="total_opening_balance"><?php echo getAmt(0)?></span></a>
            <p>&nbsp;</p>
            <div class="box-footer">
                <button type="submit" name="submit" value="submit" class="btn bg-blue-btn">
                    <iconify-icon icon="solar:upload-minimalistic-broken"></iconify-icon>
                    <?php echo lang('submit'); ?>
                </button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
    <script src="<?php echo base_url('frequent_changing/js/opening_register.js'); ?>"></script>
</section>