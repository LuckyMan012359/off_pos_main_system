
<div class="main-content-wrapper">
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
                <h3 class="top-left-header"><?php echo lang('list_variation_attribute'); ?> </h3>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('list_variation_attribute'); ?>" data-id_name="datatable">
                <div class="btn_list m-right d-flex">
                    <a class="new-btn me-1" href="<?php echo base_url() ?>Variation/addEditVariation">
                    <iconify-icon icon="solar:add-circle-broken" width="22"></iconify-icon> <?php echo lang('add_variation'); ?>
                    </a>
                </div>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('variation'), 'secondSection'=> lang('list_variation_attribute')])?>
        </div>
    </section>



    <div class="box-wrapper">
        <div class="table-box">
            <div class="table-responsive">
                <input type="hidden" class="datatable_name"  data-filter="no" data-title="<?php echo lang('units'); ?>" data-id_name="datatable">
                <table id="datatable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="w-5"><?php echo lang('sn'); ?></th>
                            <th class="w-30"><?php echo lang('variation_name'); ?></th>
                            <th class="w-40"><?php echo lang('variation_value'); ?></th>
                            <th class="w-10"><?php echo lang('added_by'); ?></th>
                            <th class="w-10"><?php echo lang('added_date'); ?></th>
                            <th class="w-5"><?php echo lang('actions');?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($Variations && !empty($Variations)) {
                            $i = count($Variations);
                        }
                        foreach ($Variations as $vari) {
                            ?>                       
                            <tr>
                                <td><?php echo escape_output($i--); ?></td>
                                <td><?php echo escape_output($vari->variation_name); ?></td>
                                <td><?php
                                    if(isset($vari->variation_value) && $vari->variation_value){
                                        $obj = json_decode($vari->variation_value);
                                        foreach ($obj as $ky=>$value){
                                        echo escape_output($value);
                                            if($ky < (sizeof($obj) -1)){
                                                echo ", ";
                                            }
                                        }
                                    }
                                    ?></td>
                                <td><?php echo escape_output($vari->added_by); ?></td>
                                <td><?php echo date($this->session->userdata('date_format'), strtotime($vari->added_date != '' ? $vari->added_date : '')); ?></td>
                                <td>
                                    <div class="btn_group_wrap">
                                        <a class="btn btn-warning" href="<?php echo base_url() ?>Variation/addEditVariation/<?php echo $this->custom->encrypt_decrypt($vari->id, 'encrypt'); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-original-title="<?php echo lang('edit'); ?>">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <a class="delete btn btn-danger" href="<?php echo base_url() ?>Variation/deleteVariation/<?php echo $this->custom->encrypt_decrypt($vari->id, 'encrypt'); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php echo lang('delete'); ?>">
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
<div class="display_none btn_list">
    <!--check access-->
    <?php if(checkAccess(406,"create")): ?>
        <a class="btn btn-block btn-primary" href="<?php echo base_url(); ?>Variation/addEditVariation"><svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg> <?php echo lang('add_variation'); ?></a>
        <?php
    endif;
    ?>
</div>
<!-- DataTables -->
<?php $this->view('updater/reuseJs'); ?>