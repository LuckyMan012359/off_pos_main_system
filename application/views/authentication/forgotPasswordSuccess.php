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
							<h6><?= lang('An_auto_generated_password');?>.</h6>
                            <h6><?= lang('Please_check_your_Email');?>.</h6>
                            <a href="<?php echo base_url(); ?>Authentication/index" class="forgot-pass"><?= lang('Go_to_Loign_Page');?></a> 
		        		</div>
		      		</div>
				</div>
			</div>
		</div>
	</section>
	<script src="<?php echo base_url(); ?>assets/bootstrap/bootstrap.bundle.min.js"></script>
</body>
</html>


