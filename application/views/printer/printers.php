<section class="main-content-wrapper">
<h3 class="display_none">&nbsp;</h3>
        <?php
        if ($this->session->flashdata('exception')) {
            echo '<section class="alert-wrapper"><div class="alert alert-success alert-dismissible fade show"> 
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <div class="alert-body"><i class="m-right fa fa-check"></i>';
            echo escape_output($this->session->flashdata('exception'));unset($_SESSION['exception']);
            echo '</div></div></section>';
        }
        ?>

        <?php
        if ($this->session->flashdata('exception_r')) {
            echo '<section class="alert-wrapper"><div class="alert alert-danger alert-dismissible fade show"> 
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <p><i class="icon fa fa-times"></i>';
            echo escape_output($this->session->flashdata('exception_r'));unset($_SESSION['exception_r']);
            echo '</div></div></section>';
        }
        ?>

        <div class="content-header">
            <h3 class="top-left-header"><?php echo lang('printers'); ?></h3>
        </div>



        <div class="box-wrapper">
            <!-- general form elements -->
            <div class="table-box">
                <!-- /.box-header -->
                <div class="table-responsive">
                    <input type="hidden" class="datatable_name" data-title="<?php echo lang('Printer'); ?>" data-id_name="datatable">
                    <table id="datatable" class="table">
                        <thead>
                            <tr>
                                <th class="width_1_p"><?php echo lang('sn'); ?></th>
                                <th class="width_10_p" ><?php echo lang('title'); ?></th>
                                <th class="width_10_p" ><?php echo lang('printer_type'); ?></th>
                                <th class="width_10_p" ><?php echo lang('characters_per_line'); ?></th>
                                <th class="width_10_p" ><?php echo lang('printer_ip_address'); ?></th>
                                <th class="width_10_p" ><?php echo lang('printer_port_address'); ?></th>
                                <th class="width_10_p" ><?php echo lang('share_name'); ?></th>
                                <th class="width_2_p c_center not-export-col"><?php echo lang('actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($printer_ && !empty($printer_)) {
                                $i = count($printer_);
                            }
                            foreach ($printer_ as $usrs) {
                                    ?>
                                    <tr>
                                        <td class="c_center"><?php echo escape_output($i--); ?></td>
                                        <td><?php echo escape_output($usrs->title); ?></td>
                                        <td><?php echo escape_output($usrs->type); ?></td>
                                        <td><?php echo escape_output($usrs->characters_per_line); ?></td>
                                        <td><?php echo escape_output($usrs->printer_ip_address); ?></td>
                                        <td><?php echo escape_output($usrs->printer_port); ?></td>
                                        <td><?php echo escape_output($usrs->path); ?></td>
                                        <td class="c_center">
                                            <div class="btn-group  actionDropDownBtn">
                                                <button type="button" class="btn bg-blue-color dropdown-toggle" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i data-feather="more-vertical"></i>
                                                </button>

                                                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton1" role="menu">
                                                    <li>
                                                        <a href="<?php echo base_url() ?>printer/addEditPrinter/<?php echo escape_output($this->custom->encrypt_decrypt($usrs->id, 'encrypt')); ?>" ><i class="fa fa-edit"></i><?php echo lang('edit'); ?></a>
                                                    </li>
                                                    <li>
                                                        <a  class="delete"  href="<?php echo base_url() ?>printer/deletePrinter/<?php echo escape_output($this->custom->encrypt_decrypt($usrs->id, 'encrypt')); ?>" ><i class="fa fa-trash tiny-icon"></i><?php echo lang('delete'); ?></a>
                                                    </li>

                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    
    
</section>
<!-- DataTables -->
<?php $this->view('updater/reuseJs')?>
