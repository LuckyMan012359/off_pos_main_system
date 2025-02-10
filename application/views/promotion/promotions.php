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


    <?php
    if ($this->session->flashdata('exception_err')) {
        echo '<section class="alert-wrapper"><div class="alert alert-danger alert-dismissible fade show"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></button>
        <div class="alert-body"><i class="icon fa fa-times me-2"></i>';
        echo escape_output($this->session->flashdata('exception_err'));unset($_SESSION['exception_err']);
        echo '</div></div></section>';
    }
    ?>



    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header"><?php echo lang('list_promotion'); ?> </h3>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('list_promotion'); ?>" data-id_name="datatable">
                <div class="btn_list m-right d-flex">
                    <a class="new-btn me-1" href="<?php echo base_url() ?>Promotion/addEditPromotion">
                    <iconify-icon icon="solar:add-circle-broken" width="22"></iconify-icon> <?php echo lang('add_promotion'); ?>
                    </a>
                </div>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('promotion'), 'secondSection'=> lang('list_promotion')])?>
        </div>
    </section>



    <div class="box-wrapper">
        <div class="table-box">
            <div class="box-body">
                <div class="table-responsive">
                    <table id="datatable" class="table">
                        <thead>
                            <tr>
                                <th class="w-5"> <?php echo lang('sn'); ?></th>
                                <th class="w-10"><?php echo lang('title'); ?></th>
                                <th class="w-8"><?php echo lang('type'); ?></th>
                                <th class="w-8"><?php echo lang('start_date'); ?></th>
                                <th class="w-8"><?php echo lang('end_date'); ?></th>
                                <th class="w-20"><?php echo lang('item'); ?></th>
                                <th class="w-8 text-center"><?php echo lang('coupon_code'); ?></th>
                                <th class="w-8 text-center"><?php echo lang('discount'); ?></th>
                                <th class="w-8"><?php echo lang('status'); ?></th>
                                <th class="w-10"><?php echo lang('added_by'); ?></th>
                                <th class="w-10"><?php echo lang('added_date'); ?></th>
                                <th class="w-5 text-center"><?php echo lang('actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($promotions && !empty($promotions)) {
                                $i = count($promotions);
                            }
                            foreach ($promotions as $promo) {
                                ?>
                            <tr>
                                <td class="ir_txt_center"><?php echo escape_output($i--); ?></td>
                                <td><?php echo escape_output($promo->title) ?></td>
                                <td>
                                    <?php 
                                    if($promo->type==1){
                                        echo 'Discount';
                                    } else if ($promo->type==2){
                                        echo 'Free Item';
                                    }else if($promo->type==3){
                                        echo 'Discount Coupon';
                                    }
                                    ?>
                                </td>
                                <td><?php echo escape_output(dateFormat($promo->start_date)); ?></td>
                                <td><?php echo escape_output(dateFormat($promo->end_date)); ?></td>
                                <td>
                                    <?php if($promo->type==1){
                                        echo getFoodMenuNameCodeById($promo->food_menu_id);
                                    } else if($promo->type == 2){
                                        echo "<b>" . lang('buy') .": </b>".getFoodMenuNameCodeById($promo->food_menu_id). "-" .$promo->qty. " " . lang('qty');
                                        echo "<br><b>" .lang('get'). ": </b>".getFoodMenuNameCodeById($promo->get_food_menu_id)."-".$promo->get_qty . " " . lang('qty');
                                    } else if($promo->type == 3){
                                    }
                                    ?>
                                </td>
                                <?php if($promo->type == 3):?>
                                    <td class="text-center"><?php echo escape_output($promo->coupon_code) ?></td>
                                <?php else:?>
                                    <td class="text-center">N/A</td>
                                <?php endif;?>
                                <?php if($promo->type == 1 || $promo->type == 3):?>
                                <td class="text-center">
                                    <?php echo escape_output($promo->discount ?? 'N/A')?>
                                </td>
                                <?php else:?>
                                    <td class="text-center">N/A</td>
                                <?php endif;?>
                                <td><?php echo escape_output($promo->status==1?lang('Active'):lang('Inactive')) ?></td>
                                <td><?php echo escape_output($promo->added_by); ?></td>
                                <td><?php echo date($this->session->userdata('date_format'), strtotime($promo->added_date != '' ? $promo->added_date : '')); ?></td>
                                <td>
                                    <div class="btn_group_wrap">
                                        <a class="btn btn-warning" href="<?php echo base_url() ?>Promotion/addEditPromotion/<?php echo $this->custom->encrypt_decrypt($promo->id, 'encrypt'); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-original-title="<?php echo lang('edit'); ?>">
                                        <i class="far fa-edit"></i>
                                        </a>
                                        <a class="delete btn btn-danger" href="<?php echo base_url() ?>Promotion/deletePromotion/<?php echo $this->custom->encrypt_decrypt($promo->id, 'encrypt'); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php echo lang('delete'); ?>">
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
 <!-- DataTables -->

<!-- DataTables -->
<?php $this->view('updater/reuseJs'); ?>
