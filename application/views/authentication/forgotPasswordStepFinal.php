<?php
    $wl = getWhiteLabel();
    $site_name = '';
    $site_logo = '';
    $site_favicon = '';
    if($wl){
        if($wl->site_name){
            $site_name = $wl->site_name;
        }
        if($wl->site_footer){
            $site_footer = $wl->site_footer;
        }
        if($wl->site_logo){
            $site_logo = base_url()."uploads/site_settings/".$wl->site_logo;
        }
        if($wl->site_favicon){
            $site_favicon = base_url()."uploads/site_settings/".$wl->site_favicon;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo escape_output($site_name);?></title>
	<!-- Favicon -->
    <link rel="shortcut icon" href="<?php echo escape_output($site_favicon); ?>" type="image/x-icon">
    <link rel="icon" href="<?php echo escape_output($site_favicon); ?>" type="image/x-icon">
    <!-- jQuery 3.7.1 -->
    <script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Select2 -->
    <script src="<?php echo base_url(); ?>assets/bower_components/select2/dist/js/select2.full.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/select2/dist/css/select2.min.css">
	<!-- Bootstrap 5.0.1 -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/bootstrap.min.css">
	<!-- Style css -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/login-2.css">
</head>
<body>
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 col-lg-5 login-card-wrapper-2">
                    <div class="msg-wrap-2">
					<?php
					if ($this->session->flashdata('exception_1')) {
						echo '<div class="input-container"><div class="alert alert-danger alert-dismissible"> 
						<a type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></a>
						<div class="alert-body"><i class="icon fa fa-times"></i>';
						echo $this->session->flashdata('exception_1');unset($_SESSION['exception_1']);
						echo '</div></div></div>';
					}
					?>
					<?php
					if ($this->session->flashdata('exception')) {
						echo '<div class="input-container"><div class="alert alert-success alert-dismissible"> 
						<a type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></a>
						<div class="alert-body"><i class="icon fa fa-check me-2"></i>';
						echo $this->session->flashdata('exception');unset($_SESSION['exception']);
						echo '</div></div></div>';
					}
					?>
                    </div>
					<div class="wrap-2">
						<div class="login-wrap-2">
							<div class="d-flex justify-content-center logo-area">
								<a href="<?php echo base_url();?>">
									<img src="<?php echo $site_logo;?>" alt="site-logo">
								</a>
							</div>
							<div class="d-flex">
								<div class="w-100">
									<h3 class="mb-3 auth-title"><?php echo lang('reset_step_2');?></h3>
								</div>	
							</div>
							<?php echo form_open(base_url('forgot-password-step-final')); ?>
                                <div class="form-group mb-3">
                                    <label class="label" for="password"><?php echo lang('password');?></label>
                                    <input class="form-control" id="password" type="password" name="password" value="<?php if(APPLICATION_MODE == 'demo'){ echo "123456"; }else{ echo set_value('password');} ?>" required placeholder="<?php echo lang('password');?>">
                                    <?php if (form_error('password')) { ?>
                                        <div class="error_txt">
                                            <?php echo form_error('password'); ?>
                                        </div>
                                    <?php } ?>
                                </div>
								<div class="form-group mb-3">
									<label class="label" for="confirm_password"><?php echo lang('confirm_password'); ?></label>
                                    <input class="form-control" id="confirm_password" type="password" name="confirm_password" value="<?php echo set_value('confirm_password') ?>" required placeholder="<?php echo lang('confirm_password');?>">
                                    <div class="bar"></div>
                                    <?php if (form_error('confirm_password')) { ?>
                                        <div class="error_txt">
                                            <?php echo form_error('confirm_password'); ?>
                                        </div>
                                    <?php } ?>
                                    <input type="hidden" class="form-control" name="id" value="<?php echo escape_output($id); ?>">
                                    <input type="hidden" class="form-control" name="matchQuestion" value="<?php echo escape_output($matchQuestion); ?>">
                                    <input type="hidden" class="form-control" name="matchAnswer" value="<?php echo escape_output($matchAnswer); ?>">
								</div>
								<div class="mb-1">
									<button type="submit" name="submit" value="submit" class="btn login-button btn-2 rounded submit me-1"><span><?php echo lang('submit'); ?></button>
								</div>
							<?php echo form_close(); ?>
		        		</div>
		      		</div>
				</div>
			</div>
		</div>
	</section>
	<script src="<?php echo base_url(); ?>assets/bootstrap/bootstrap.bundle.min.js"></script>
</body>
</html>


