<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/report.css">
<div class="main-content-wrapper">

    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo lang('salary_report'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('report'), 'secondSection'=> lang('salary_report')])?>
        </div>
    </section>

    <div class="box-wrapper">
        <!-- Report Header Start -->
        <div class="report_header">
            <h3 class="company_name"><?php echo escape_output($this->session->userdata('business_name'));?> </h3>
            <h5 class="outlet_info">
                <strong><?php echo lang('salary_report'); ?></strong>
            </h5>
            <?php if(isset($outlet_id) && $outlet_id){
                $outlet_info = getOutletInfoById($outlet_id); 
            }?>
            <h5 class="outlet_info">
                <?php if(isset($outlet_id) && $outlet_id){ ?>
                    <strong><?php echo lang('outlet'); ?>: </strong> <?= escape_output($outlet_info->outlet_name); ?>
                <?php }?>
            </h5>
            <h5 class="outlet_info">
                <?php if(isset($outlet_id) && $outlet_id){ ?>
                    <strong><?php echo lang('address'); ?>: </strong> <?= escape_output($outlet_info->address); ?>
                <?php } ?>
            </h5>
            <h5 class="outlet_info">
                <?php if(isset($outlet_id) && $outlet_id){ ?>
                    <strong><?php echo lang('email'); ?>: </strong> <?= escape_output($outlet_info->email); ?>
                <?php } ?>
            </h5>
            <h5 class="outlet_info">
                <?php if(isset($outlet_id) && $outlet_id){ ?>
                    <strong><?php echo lang('phone'); ?>: </strong> <?= escape_output($outlet_info->phone); ?>
                <?php } ?>
            </h5>
            <?php if(isset($start_date) && $start_date != '' && $start_date != '1970-01-01' || isset($end_date) && $end_date != '' && $end_date != '1970-01-01'){ ?>
            <h5 class="outlet_info">
                <strong><?php echo lang('date');?>:</strong>
                <?php
                    if(!empty($start_date) && $start_date != '1970-01-01') {
                        echo dateFormat($start_date);
                    }
                    if((isset($start_date) && isset($end_date)) && ($start_date != '1970-01-01' && $end_date != '1970-01-01')){
                        echo ' - ';
                    }
                    if(!empty($end_date) && $end_date != '1970-01-01') {
                        echo dateFormat($end_date);
                    }
                ?>
            </h5>
            <?php } ?>
            <h5 class="outlet_info">
                <?php if(isset($report_generate_time) && $report_generate_time){
                    echo $report_generate_time;
                } ?>
            </h5>
        </div>
        <!-- Report Header End -->

        <div class="table-box">
            <div class="box-body">
                <div class="table-responsive">
                <input type="hidden" class="datatable_name"  data-filter="yes" data-title="<?php echo lang('salary_report'); ?>" data-id_name="datatable">
                    <table id="datatable"  class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="w-5"><?php echo lang('sn'); ?></th>
                                <th><?php echo lang('date_and_time'); ?></th>
                                <th><?php echo lang('year'); ?></th>
                                <th><?php echo lang('month'); ?></th>
                                <th><?php echo lang('payment_method'); ?></th>
                                <th><?php echo lang('amount'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $grandTotal = 0;
                            $countTotal = 0;
                            if (isset($salaryReport)):
                                foreach ($salaryReport as $key => $value) {
                                    $grandTotal+=$value->total_amount;
                                    $key++;
                                    ?>
                                    <tr>
                                        <td><?php echo $key; ?></td>
                                        <td><?php echo dateFormat($value->added_date) ?></td>
                                        <td><?php echo escape_output($value->year) ?></td>
                                        <td><?php echo $value->month ?></td>
                                        <td><?php echo $value->payment_method_name ?></td>
                                        <td><?php echo getAmtCustom($value->total_amount) ?></td>
                                    </tr>
                                    <?php
                                }
                            endif;
                            ?>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th class="text-right"><?php echo lang('total'); ?> </th>
                                <th><?= getAmtCustom($grandTotal) ?></th>
                            </tr>
                        </tbody>
                    </table>
                </div>
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
        <?php echo form_open(base_url() . 'Report/salaryReport') ?>
        <div class="row">
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <select name="startMonth" class="form-control select2">
                        <option value=""><?php echo lang('start'); ?> <?php echo lang('month'); ?></option>
                        <option <?php echo isset($startMonth) && $startMonth == 'January' ? 'selected' : '' ?> <?php echo set_select('month', "January");?> value="January"><?php echo lang('January'); ?></option>
                        <option <?php echo isset($startMonth) && $startMonth == 'February' ? 'selected' : '' ?> <?php echo set_select('month', "February");?> value="February"><?php echo lang('February'); ?></option>
                        <option <?php echo isset($startMonth) && $startMonth == 'March' ? 'selected' : '' ?> <?php echo set_select('month', "March");?> value="March"><?php echo lang('March'); ?></option>
                        <option <?php echo isset($startMonth) && $startMonth == 'April' ? 'selected' : '' ?> <?php echo set_select('month', "April");?> value="April"><?php echo lang('April'); ?></option>
                        <option <?php echo isset($startMonth) && $startMonth == 'May' ? 'selected' : '' ?> <?php echo set_select('month', "May");?> value="May"><?php echo lang('May'); ?></option>
                        <option <?php echo isset($startMonth) && $startMonth == 'June' ? 'selected' : '' ?> <?php echo set_select('month', "June");?> value="June"><?php echo lang('June'); ?></option>
                        <option <?php echo isset($startMonth) && $startMonth == 'July' ? 'selected' : '' ?> <?php echo set_select('month', "July");?> value="July"><?php echo lang('July'); ?></option>
                        <option <?php echo isset($startMonth) && $startMonth == 'August' ? 'selected' : '' ?> <?php echo set_select('month', "August");?> value="August"><?php echo lang('August'); ?></option>
                        <option <?php echo isset($startMonth) && $startMonth == 'September' ? 'selected' : '' ?> <?php echo set_select('month', "September");?> value="September"><?php echo lang('September'); ?></option>
                        <option <?php echo isset($startMonth) && $startMonth == 'October' ? 'selected' : '' ?> <?php echo set_select('month', "October");?> value="October"><?php echo lang('October'); ?></option>
                        <option <?php echo isset($startMonth) && $startMonth == 'November' ? 'selected' : '' ?> <?php echo set_select('month', "November");?> value="November"><?php echo lang('November'); ?></option>
                        <option <?php echo isset($startMonth) && $startMonth == 'December' ? 'selected' : '' ?> <?php echo set_select('month', "December");?> value="December"><?php echo lang('December'); ?></option>
                    </select>
                    <div class="alert alert-error error-msg month_err_msg_contnr ">
                        <p class="month_err_msg"></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <select name="endMonth" class="form-control select2">
                        <option value=""><?php echo lang('end'); ?> <?php echo lang('month'); ?></option>
                        <option <?php echo isset($endMonth) && $endMonth == 'January' ? 'selected' : '' ?> <?php echo set_select('month', "January");?> value="January"><?php echo lang('January'); ?></option>
                        <option <?php echo isset($endMonth) && $endMonth == 'February' ? 'selected' : '' ?> <?php echo set_select('month', "February");?> value="February"><?php echo lang('February'); ?></option>
                        <option <?php echo isset($endMonth) && $endMonth == 'March' ? 'selected' : '' ?> <?php echo set_select('month', "March");?> value="March"><?php echo lang('March'); ?></option>
                        <option <?php echo isset($endMonth) && $endMonth == 'April' ? 'selected' : '' ?> <?php echo set_select('month', "April");?> value="April"><?php echo lang('April'); ?></option>
                        <option <?php echo isset($endMonth) && $endMonth == 'May' ? 'selected' : '' ?> <?php echo set_select('month', "May");?> value="May"><?php echo lang('May'); ?></option>
                        <option <?php echo isset($endMonth) && $endMonth == 'June' ? 'selected' : '' ?> <?php echo set_select('month', "June");?> value="June"><?php echo lang('June'); ?></option>
                        <option <?php echo isset($endMonth) && $endMonth == 'July' ? 'selected' : '' ?> <?php echo set_select('month', "July");?> value="July"><?php echo lang('July'); ?></option>
                        <option <?php echo isset($endMonth) && $endMonth == 'August' ? 'selected' : '' ?> <?php echo set_select('month', "August");?> value="August"><?php echo lang('August'); ?></option>
                        <option <?php echo isset($endMonth) && $endMonth == 'September' ? 'selected' : '' ?> <?php echo set_select('month', "September");?> value="September"><?php echo lang('September'); ?></option>
                        <option <?php echo isset($endMonth) && $endMonth == 'October' ? 'selected' : '' ?> <?php echo set_select('month', "October");?> value="October"><?php echo lang('October'); ?></option>
                        <option <?php echo isset($endMonth) && $endMonth == 'November' ? 'selected' : '' ?> <?php echo set_select('month', "November");?> value="November"><?php echo lang('November'); ?></option>
                        <option <?php echo isset($endMonth) && $endMonth == 'December' ? 'selected' : '' ?> <?php echo set_select('month', "December");?> value="December"><?php echo lang('December'); ?></option>
                    </select>
                    <div class="alert alert-error error-msg month_err_msg_contnr ">
                        <p class="month_err_msg"></p>
                    </div>
                </div>
            </div>
            
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <select name="startYear" class="form-control select2">
                        <option value=""><?php echo lang('start'); ?> <?php echo lang('year'); ?></option>
                        <option <?php echo isset($startYear) && $startYear == '2018' ? 'selected' : '' ?> <?php echo set_select('year', "2018");?>  value="2018"><?php echo lang('2018s'); ?></option>
                        <option <?php echo isset($startYear) && $startYear == '2019' ? 'selected' : '' ?> <?php echo set_select('year', "2019");?>  value="2019"><?php echo lang('2019s'); ?></option>
                        <option <?php echo isset($startYear) && $startYear == '2020' ? 'selected' : '' ?> <?php echo set_select('year', "2020");?>  value="2020"><?php echo lang('2020s'); ?></option>
                        <option <?php echo isset($startYear) && $startYear == '2021' ? 'selected' : '' ?> <?php echo set_select('year', "2021");?>  value="2021"><?php echo lang('2021s'); ?></option>
                        <option <?php echo isset($startYear) && $startYear == '2022' ? 'selected' : '' ?> <?php echo set_select('year', "2022");?>  value="2022"><?php echo lang('2022s'); ?></option>
                        <option <?php echo isset($startYear) && $startYear == '2023' ? 'selected' : '' ?> <?php echo set_select('year', "2023");?>  value="2023"><?php echo lang('2023s'); ?></option>
                        <option <?php echo isset($startYear) && $startYear == '2024' ? 'selected' : '' ?> <?php echo set_select('year', "2024");?>  value="2024"><?php echo lang('2024s'); ?></option>
                        <option <?php echo isset($startYear) && $startYear == '2025' ? 'selected' : '' ?> <?php echo set_select('year', "2025");?>  value="2025"><?php echo lang('2025s'); ?></option>
                        <option <?php echo isset($startYear) && $startYear == '2026' ? 'selected' : '' ?> <?php echo set_select('year', "2026");?>  value="2026"><?php echo lang('2026s'); ?></option>
                        <option <?php echo isset($startYear) && $startYear == '2027' ? 'selected' : '' ?> <?php echo set_select('year', "2027");?>  value="2027"><?php echo lang('2027s'); ?></option>
                        <option <?php echo isset($startYear) && $startYear == '2028' ? 'selected' : '' ?> <?php echo set_select('year', "2028");?>  value="2028"><?php echo lang('2028s'); ?></option>
                        <option <?php echo isset($startYear) && $startYear == '2029' ? 'selected' : '' ?> <?php echo set_select('year', "2029");?>  value="2029"><?php echo lang('2029s'); ?></option>
                        <option <?php echo isset($startYear) && $startYear == '2030' ? 'selected' : '' ?> <?php echo set_select('year', "2030");?>  value="2030"><?php echo lang('2030s'); ?></option>
                        <option <?php echo isset($startYear) && $startYear == '2031' ? 'selected' : '' ?> <?php echo set_select('year', "2031");?>  value="2031"><?php echo lang('2031s'); ?></option>
                        <option <?php echo isset($startYear) && $startYear == '2032' ? 'selected' : '' ?> <?php echo set_select('year', "2032");?>  value="2032"><?php echo lang('2032s'); ?></option>
                        <option <?php echo isset($startYear) && $startYear == '2033' ? 'selected' : '' ?> <?php echo set_select('year', "2033");?>  value="2033"><?php echo lang('2033s'); ?></option>
                    </select>
                    <div class="alert alert-error error-msg year_err_msg_contnr ">
                        <p class="year_err_msg"></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <select name="endYear" class="form-control select2">
                        <option value=""><?php echo lang('end'); ?> <?php echo lang('year'); ?></option>
                        <option <?php echo isset($endYear) && $endYear == '2018' ? 'selected' : '' ?> <?php echo set_select('year', "2018");?>  value="2018"><?php echo lang('2018s'); ?></option>
                        <option <?php echo isset($endYear) && $endYear == '2019' ? 'selected' : '' ?> <?php echo set_select('year', "2019");?>  value="2019"><?php echo lang('2019s'); ?></option>
                        <option <?php echo isset($endYear) && $endYear == '2020' ? 'selected' : '' ?> <?php echo set_select('year', "2020");?>  value="2020"><?php echo lang('2020s'); ?></option>
                        <option <?php echo isset($endYear) && $endYear == '2021' ? 'selected' : '' ?> <?php echo set_select('year', "2021");?>  value="2021"><?php echo lang('2021s'); ?></option>
                        <option <?php echo isset($endYear) && $endYear == '2022' ? 'selected' : '' ?> <?php echo set_select('year', "2022");?>  value="2022"><?php echo lang('2022s'); ?></option>
                        <option <?php echo isset($endYear) && $endYear == '2023' ? 'selected' : '' ?> <?php echo set_select('year', "2023");?>  value="2023"><?php echo lang('2023s'); ?></option>
                        <option <?php echo isset($endYear) && $endYear == '2024' ? 'selected' : '' ?> <?php echo set_select('year', "2024");?>  value="2024"><?php echo lang('2024s'); ?></option>
                        <option <?php echo isset($endYear) && $endYear == '2025' ? 'selected' : '' ?> <?php echo set_select('year', "2025");?>  value="2025"><?php echo lang('2025s'); ?></option>
                        <option <?php echo isset($endYear) && $endYear == '2026' ? 'selected' : '' ?> <?php echo set_select('year', "2026");?>  value="2026"><?php echo lang('2026s'); ?></option>
                        <option <?php echo isset($endYear) && $endYear == '2027' ? 'selected' : '' ?> <?php echo set_select('year', "2027");?>  value="2027"><?php echo lang('2027s'); ?></option>
                        <option <?php echo isset($endYear) && $endYear == '2028' ? 'selected' : '' ?> <?php echo set_select('year', "2028");?>  value="2028"><?php echo lang('2028s'); ?></option>
                        <option <?php echo isset($endYear) && $endYear == '2029' ? 'selected' : '' ?> <?php echo set_select('year', "2029");?>  value="2029"><?php echo lang('2029s'); ?></option>
                        <option <?php echo isset($endYear) && $endYear == '2030' ? 'selected' : '' ?> <?php echo set_select('year', "2030");?>  value="2030"><?php echo lang('2030s'); ?></option>
                        <option <?php echo isset($endYear) && $endYear == '2031' ? 'selected' : '' ?> <?php echo set_select('year', "2031");?>  value="2031"><?php echo lang('2031s'); ?></option>
                        <option <?php echo isset($endYear) && $endYear == '2032' ? 'selected' : '' ?> <?php echo set_select('year', "2032");?>  value="2032"><?php echo lang('2032s'); ?></option>
                        <option <?php echo isset($endYear) && $endYear == '2033' ? 'selected' : '' ?> <?php echo set_select('year', "2033");?>  value="2033"><?php echo lang('2033s'); ?></option>
                    </select>
                    <div class="alert alert-error error-msg year_err_msg_contnr ">
                        <p class="year_err_msg"></p>
                    </div>
                </div>
            </div>
            <?php
                if(isLMni()):
            ?>
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <select  class="form-control select2 ir_w_100" id="outlet_id" name="outlet_id">
                        <?php
                            $role = $this->session->userdata('role');
                            if($role == '1'){
                        ?>
                        <option value=""><?php echo lang('outlet') ?></option>
                        <?php } ?>
                        <?php
                        $outlets = getOutletsForReport();
                        foreach ($outlets as $value):
                            ?>
                            <option <?= set_select('outlet_id',$value->id)?>  value="<?php echo escape_output($value->id) ?>"><?php echo escape_output($value->outlet_name) ?></option>
                            <?php
                        endforeach;
                        ?>
                    </select>
                </div>
            </div>
            <?php
                endif;
            ?>
            <div class="clear-fix"></div>
            <div class="col-12 mb-2">
                <button type="submit" name="submit" value="submit" class="new-btn">
                    <iconify-icon icon="solar:hourglass-broken" width="22"></iconify-icon>
                    <?php echo lang('submit'); ?>
                </button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>

<?php $this->view('updater/reuseJs_w_pagination'); ?>

