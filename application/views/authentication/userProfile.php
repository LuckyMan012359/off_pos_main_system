<div class="main-content-wrapper">
    <?php
    if ($this->session->flashdata('exception_1')) {
        echo '<section class="alert-wrapper"><div class="alert alert-danger alert-dismissible"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></button>
        <div class="alert-body"><i class="icon fa fa-times me-2"></i>';
        echo $this->session->flashdata('exception_1');unset($_SESSION['exception_1']);
        //This variable could not be escaped because this is html content
        echo '</div></div></section>';
    }
    ?>
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
                <h3 class="top-left-header mt-2"><?php echo lang('user_profile'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('user_profile'), 'secondSection'=> lang('user_profile')])?>
        </div>
    </section>


    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-5 col-xl-3 mt-2">
            <div class="user-profile-card">
                <div class="d-flex align-items-center">
                    <div class="media-size-email">
                        <?php 
                            $profile_photo = $this->session->userdata('photo'); 
                            if($profile_photo){
                        ?>
                            <img width="45" height="45" class="me-3 rounded-circle" src="<?php echo base_url()?>uploads/employees_image/<?php echo escape_output($this->session->userdata('photo'));?>" alt="Image">
                        <?php } else {?>
                            <img width="45" height="45" class="me-3 rounded-circle" src="<?php echo base_url()?>uploads/site_settings/default-admin.png" alt="Image">
                        <?php }?>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="m-0"><?php echo escape_output($this->session->userdata('full_name')); ?></h5>
                        <p class="text-muted my-1 font-weight-bolder text-lowercase overflow-wrap-anywhere">
                            <?php echo escape_output($this->session->userdata('email_address')); ?>
                        </p>
                    </div>
                </div>
                <!-- End User Profile Info -->

                <ul class="menu-list">
                    <li class="item">
                        <a href="<?php echo base_url();?>User/changeProfile">
                            <span class="iconbg badge-light-primary">
                                <iconify-icon icon="solar:user-check-broken" width="20"></iconify-icon>
                            </span>
                            <span class="user-profile-card-text">
                                <?php echo lang('change_profile'); ?>
                            </span>
                        </a>
                    </li>
                    <li class="item">
                        <a href="<?php echo base_url();?>User/changePassword">
                            <span class="iconbg badge-light-success">
                                <iconify-icon icon="solar:key-broken" width="20"></iconify-icon>
                            </span>
                            <span class="user-profile-card-text">
                                <?php echo lang('change_password'); ?>
                            </span>
                        </a>
                    </li>
                    <li class="item">
                        <a href="<?php echo base_url();?>User/securityQuestion">
                            <span class="iconbg badge-light-info">
                                <iconify-icon icon="solar:question-circle-broken" width="20"></iconify-icon>
                            </span>
                            <span class="user-profile-card-text">
                                <?php echo lang('SetSecurityQuestion'); ?>
                            </span>
                        </a>
                    </li>
                    <li class="item">
                        <a href="javascript:void(0)" class="logOutTrigger">
                            <span class="iconbg badge-light-danger">
                                <iconify-icon icon="solar:logout-broken" width="20"></iconify-icon>
                            </span>
                            <span class="user-profile-card-text">
                                <?php echo lang('logout'); ?>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- End User Profile -->
        <div class="col-sm-12 col-md-12 col-lg-7 col-xl-9 mt-2">
            <div class="table-card">
                <h2 class="top-left-header mb-0 mt-2 ms-3"><?php echo lang('list_sale'); ?></h2>
                <div class="card-body table-responsive profile_min_height">
                    <input type="hidden" class="datatable_name" data-title="@lang('index.ticket')" data-id_name="datatable">
                    <table id="datatable" class="table table-responsive">
                        <thead>
                            <tr>
                                <th class="w-5"><?php echo lang('sn'); ?></th>
                                <th class="w-15"><?php echo lang('sale_no'); ?></th>
                                <th class="w-19"><?php echo lang('customer'); ?></th>
                                <th class="w-10 text-center"><?php echo lang('items'); ?></th>
                                <th class="w-18 text-center"><?php echo lang('total_payable'); ?></th>
                                <th class="w-18 text-center"><?php echo lang('paid_amount'); ?></th>
                                <th class="w-15"><?php echo lang('sale_date'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($sales as $key => $sale): ?>
                            <tr>
                                <td><?php echo $key +1 ?></td>
                                <td><?php echo escape_output($sale->sale_no) ?></td>
                                <td><?php echo escape_output($sale->customer_name) ?><?php echo escape_output($sale->customer_phone) ? '(' . $sale->customer_name . ')' : '' ?></td>
                                <td class="text-center"><?php echo escape_output($sale->total_items) ?></td>
                                <td class="text-center"><?php echo getAmtCustom($sale->total_payable) ?></td>
                                <td class="text-center"><?php echo getAmtCustom($sale->paid_amount) ?></td>
                                <td><?php echo dateFormatWithTime($sale->date_time) ?></td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>


<?php $this->view('updater/reuseJs')?>


