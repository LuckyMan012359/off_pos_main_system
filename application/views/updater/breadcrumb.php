<div class="col-6 p-0">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?php echo base_url(); ?>Authentication/userProfile">
                <iconify-icon icon="fluent:home-20-regular"></iconify-icon>
            </a>
        </li>
        <?php if(isset($firstSection)){
            if(!isset($secondSection)){
        ?>
                <li class="breadcrumb-item active"><?php echo $firstSection ?></li>
            <?php }else{?>
                <li class="breadcrumb-item"><?php echo $firstSection ?></li>
            <?php }?>
        <?php }?>
        <?php if(isset($secondSection)){?>
            <li class="breadcrumb-item active"><?php echo $secondSection ?></li>
        <?php }?>
    </ol>
</div>