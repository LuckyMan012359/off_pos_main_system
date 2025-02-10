<section class="main-content-wrapper">
<h3 class="display_none">&nbsp;</h3>
    <?php
    if ($this->session->flashdata('exception')) {

        echo '<section class="alert-wrapper">
        <div class="alert alert-success alert-dismissible fade show"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <div class="alert-body">
        <p><i class="m-right fa fa-check"></i>';
        echo escape_output($this->session->flashdata('exception'));unset($_SESSION['exception']);
        echo '</p></div></div></section>';
    }
    ?>

    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header"><?php echo lang('list_multiple_currency'); ?> </h3>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('list_multiple_currency'); ?>" data-id_name="datatable">
                <div class="btn_list m-right d-flex">
                    <a class="new-btn me-1" href="<?php echo base_url() ?>MultipleCurrency/addEditMultipleCurrency">
                    <iconify-icon icon="solar:add-circle-broken" width="22"></iconify-icon> <?php echo lang('add_multiple_currency'); ?>
                    </a>
                </div>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('setting'), 'secondSection'=> lang('list_multiple_currency')])?>
        </div>
    </section>


    <div class="box-wrapper">
        <div class="table-box">
            <div class="table-responsive">
                <table id="datatable" class="table">
                    <thead>
                    <tr>
                        <th class="w-5"> <?php echo lang('sn'); ?></th>
                        <th class="w-15 "><?php echo lang('currency'); ?></th>
                        <th class="w-75 "><?php echo lang('conversion_rate'); ?></th>
                        <th class="w-5"><?php echo lang('actions'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($multipleCurrencies && !empty($multipleCurrencies)) {
                        $i = count($multipleCurrencies);
                    }
                    foreach ($multipleCurrencies as $multipleCurrency) {
                        ?>
                        <tr>
                            <td class="text-start"><?php echo escape_output($i--); ?></td>
                            <td><?php echo escape_output($multipleCurrency->currency); ?></td>
                            <td><?php echo escape_output($multipleCurrency->conversion_rate); ?></td>
                            <td class="text-center">
                                <div class="btn_group_wrap">
                                    <a class="btn btn-warning" href="<?php echo base_url() ?>MultipleCurrency/addEditMultipleCurrency/<?php echo $this->custom->encrypt_decrypt($multipleCurrency->id, 'encrypt'); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-original-title="<?php echo lang('edit'); ?>">
                                        <i class="far fa-edit"></i>
                                    </a>
                                    <a class="delete btn btn-danger" href="<?php echo base_url() ?>MultipleCurrency/deleteMultipleCurrency/<?php echo $this->custom->encrypt_decrypt($multipleCurrency->id, 'encrypt'); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php echo lang('delete'); ?>">
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
</section>
<?php $this->load->view('updater/reuseJs')?>
