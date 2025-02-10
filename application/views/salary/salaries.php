<input type="hidden" id="account_field_required" value="<?php echo lang('account_field_required') ?>">
<input type="hidden" id="The_Month_field_required" value="<?php echo lang('The_Month_field_required') ?>">
<input type="hidden" id="The_Year_field_required" value="<?php echo lang('The_Year_field_required') ?>">

<section class="main-content-wrapper">
<h3 class="display_none">&nbsp;</h3>
    <?php
    if ($this->session->flashdata('exception')) {
        echo '<section class="alert-wrapper"><div class="alert alert-success alert-dismissible fade show"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></button>
        <div class="alert-body"><i class="icon fa fa-check me-2"></i>';
        echo escape_output($this->session->flashdata('exception'));unset($_SESSION['exception']);
        echo '</div></div></section>';
    }
    ?>

    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo lang('list_salary_payroll'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('salary'), 'secondSection'=> lang('list_salary_payroll')])?>
        </div>
    </section>

    <div class="box-wrapper">
        <div class="table-box">
            <div class="box-body">
                <div class="table-responsive">
                    <input type="hidden" class="datatable_name"  data-filter="yes" data-title="<?php echo lang('salary'); ?>" data-id_name="datatable">

                    <table id="datatable" class="table table-responsive table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="w-5"><?php echo lang('sn'); ?></th>
                                <th class="w-30"><?php echo lang('month'); ?> - <?php echo lang('year'); ?></th>
                                <th class="w-30"><?php echo lang('total'); ?></th>
                                <th class="w-10"><?php echo lang('payment_method'); ?></th>
                                <th class="w-10"><?php echo lang('added_by'); ?></th>
                                <th class="w-10"><?php echo lang('added_date'); ?></th>
                                <th class="w-5 text-center"><?php echo lang('actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <?php
                            if ($salaries && !empty($salaries)) {
                                $i = count($salaries);
                            }
                            foreach ($salaries as $key=> $usrs) {
                                    ?>
                                    <tr>
                                        <td><?php echo escape_output($i--); ?></td>
                                        <td><?php echo escape_output($usrs->month); ?> - <?php echo escape_output($usrs->year); ?></td>
                                        <td><?php echo getAmtCustom($usrs->total_amount); ?></td>
                                        <td><?php echo getPaymentName($usrs->payment_id); ?></td>
                                        <td><?php echo escape_output($usrs->added_by); ?></td>
                                        <td>
                                            <?php echo date($this->session->userdata('date_format'), strtotime($usrs->added_date != '' ? $usrs->added_date : '')); ?>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn_group_wrap">
                                                <a class="printNow btn btn-deep-purple" href="javascript:void(0)" data-id="<?php echo escape_output($this->custom->encrypt_decrypt($usrs->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php echo lang('print_invoice');?>">
                                                <i class="fas fa-print"></i></a>
                                                </a>
                                                <a class="btn btn-unique" href="<?php echo base_url() ?>salary/a4InvoicePDF/<?php echo escape_output($this->custom->encrypt_decrypt($usrs->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php echo lang('download_invoice');?>">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                                <a class="btn btn-warning" href="<?php echo base_url() ?>salary/addEditSalary/<?php echo $this->custom->encrypt_decrypt($usrs->id, 'encrypt'); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                                data-bs-original-title="<?php echo lang('edit'); ?>">
                                                    <i class="far fa-edit"></i>
                                                </a>
                                                <a class="delete btn btn-danger" href="<?php echo base_url() ?>salary/deleteSalary/<?php echo $this->custom->encrypt_decrypt($usrs->id, 'encrypt'); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php echo lang('delete'); ?>">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>




<!-- Filter Options Modal -->
<div class="filter-overlay"></div>
<div id="product-filter" class="filter-modal">
    <div class="filter-modal-body">
        <header>
            <h3 class="filter-modal-title"><span><?php echo lang('add_salary_payroll'); ?></span></h3>
            <button type="button" class="close-filter-modal" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">
                    <i data-feather="x"></i>
                </span>
            </button>
        </header>
        <div class="">
        <?php
            $attributes = array('id' => 'generate');
            echo form_open_multipart(base_url('salary/generate/'), $attributes); ?>
            <div class="row">
                <div class="col-sm-12 col-md-6 mb-10">
                    <div class="form-group">
                        <select name="month" class="form-control select2 width_100_p s_month">
                            <option value=""><?php echo lang('month'); ?></option>
                            <option <?php echo set_select('month', "January");?> value="January"><?php echo lang('January'); ?></option>
                            <option <?php echo set_select('month', "February");?> value="February"><?php echo lang('February'); ?></option>
                            <option <?php echo set_select('month', "March");?> value="March"><?php echo lang('March'); ?></option>
                            <option <?php echo set_select('month', "April");?> value="April"><?php echo lang('April'); ?></option>
                            <option <?php echo set_select('month', "May");?> value="May"><?php echo lang('May'); ?></option>
                            <option <?php echo set_select('month', "June");?> value="June"><?php echo lang('June'); ?></option>
                            <option <?php echo set_select('month', "July");?> value="July"><?php echo lang('July'); ?></option>
                            <option <?php echo set_select('month', "August");?> value="August"><?php echo lang('August'); ?></option>
                            <option <?php echo set_select('month', "September");?> value="September"><?php echo lang('September'); ?></option>
                            <option <?php echo set_select('month', "October");?> value="October"><?php echo lang('October'); ?></option>
                            <option <?php echo set_select('month', "November");?> value="November"><?php echo lang('November'); ?></option>
                            <option <?php echo set_select('month', "December");?> value="December"><?php echo lang('December'); ?></option>
                        </select>
                        <div class="alert alert-error error-msg month_err_msg_contnr ">
                            <p class="month_err_msg"></p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 mb-10">
                    <div class="form-group">
                        <select name="year" class="form-control select2 width_100_p s_year">
                            <option value=""><?php echo lang('year'); ?></option>
                            <option <?php echo set_select('year', "2018");?>  value="2018"><?php echo lang('2018s'); ?></option>
                            <option <?php echo set_select('year', "2019");?>  value="2019"><?php echo lang('2019s'); ?></option>
                            <option <?php echo set_select('year', "2020");?>  value="2020"><?php echo lang('2020s'); ?></option>
                            <option <?php echo set_select('year', "2021");?>  value="2021"><?php echo lang('2021s'); ?></option>
                            <option <?php echo set_select('year', "2022");?>  value="2022"><?php echo lang('2022s'); ?></option>
                            <option <?php echo set_select('year', "2023");?>  value="2023"><?php echo lang('2023s'); ?></option>
                            <option <?php echo set_select('year', "2024");?>  value="2024"><?php echo lang('2024s'); ?></option>
                            <option <?php echo set_select('year', "2025");?>  value="2025"><?php echo lang('2025s'); ?></option>
                            <option <?php echo set_select('year', "2026");?>  value="2026"><?php echo lang('2026s'); ?></option>
                            <option <?php echo set_select('year', "2027");?>  value="2027"><?php echo lang('2027s'); ?></option>
                            <option <?php echo set_select('year', "2028");?>  value="2028"><?php echo lang('2028s'); ?></option>
                            <option <?php echo set_select('year', "2029");?>  value="2029"><?php echo lang('2029s'); ?></option>
                            <option <?php echo set_select('year', "2030");?>  value="2030"><?php echo lang('2030s'); ?></option>
                            <option <?php echo set_select('year', "2031");?>  value="2031"><?php echo lang('2031s'); ?></option>
                            <option <?php echo set_select('year', "2032");?>  value="2032"><?php echo lang('2032s'); ?></option>
                            <option <?php echo set_select('year', "2033");?>  value="2033"><?php echo lang('2033s'); ?></option>
                        </select>
                        <div class="alert alert-error error-msg year_err_msg_contnr ">
                            <p class="year_err_msg"></p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 mb-10">
                    <button type="submit" name="submit" value="submit" class="new-btn">
                        <iconify-icon icon="solar:hourglass-broken" width="22"></iconify-icon>
                        <?php echo lang('submit'); ?>
                    </button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<div class="display_none btn_list">
</div>
<?php $this->view('updater/reuseJs')?>
<script src="<?php echo base_url(); ?>frequent_changing/js/print_salary.js"></script>
