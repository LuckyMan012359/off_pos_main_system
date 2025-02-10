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
                <h3 class="top-left-header mt-2"><?php echo lang('fixed_asset_stocks'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('fixed_asset_stocks'), 'secondSection'=> lang('fixed_asset_stocks')])?>
        </div>
    </section>


    <div class="box-wrapper">
        <div class="table-box"> 
            <!-- /.box-header -->
            <div class="table-responsive"> 
                <table id="datatable" class="table table-responsive table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="w-5"><?php echo lang('sn'); ?></th>
                            <th class="w-40"><?php echo lang('name'); ?></th>
                            <th class="w-30 text-center"><?php echo lang('stock'); ?> <?php echo lang('quantity'); ?></th>
                            <th class="w-25 text-right"><?php echo lang('price'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                         $totalQty = 0;
                         $totalQty = 0;
                         $totalPrice = 0;
                            if(isset($stocks) && $stocks){
                                $i = count($stocks);
                                foreach($stocks as $stock){
                                    $totalQty += $stock->current_stock_qty;
                                    $totalPrice += $stock->current_stock_price;
                        ?>
                                    <tr>
                                        <td><?php echo $i--; ?></td>
                                        <td><?php echo escape_output($stock->name) ?></td>
                                        <td class="text-center"><?php echo getAmtPCustom($stock->current_stock_qty) ?></td>
                                        <td><?php echo getAmtCustom($stock->current_stock_price) ?></td>
                                    </tr>
                        <?php }} ?>
                        <tr>
                            <th></th>
                            <th></th>
                            <th class="text-center"><?php echo getAmtPCustom($totalQty);?></th>
                            <th><?php echo getAmtCustom($totalPrice);?></th>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div> 
    </div>
</div>

<?php $this->load->view('updater/reuseJs')?>