<?php
$wl = getWhiteLabel();
$login = getLoginInfo();
$site_name = '';
$site_logo = '';
$site_favicon = '';
if ($wl) {
	if ($wl->site_name) {
		$site_name = $wl->site_name;
	}
	if ($wl->site_footer) {
		$site_footer = $wl->site_footer;
	}
	if ($wl->site_logo) {
		$site_logo = base_url() . "uploads/site_settings/" . $wl->site_logo;
	}
	if ($wl->site_favicon) {
		$site_favicon = base_url() . "uploads/site_settings/" . $wl->site_favicon;
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo escape_output($site_name); ?></title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?php echo escape_output($site_favicon); ?>" type="image/x-icon">
    <link rel="icon" href="<?php echo escape_output($site_favicon); ?>" type="image/x-icon">
    <!-- jQuery 3.7.1 -->
    <script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Iconify Font -->
    <script src="<?php echo base_url(); ?>assets/iconify/js/iconify.min.js"></script>
    <!-- Select2 -->
    <script src="<?php echo base_url(); ?>assets/bower_components/select2/dist/js/select2.full.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/select2/dist/css/select2.min.css">

    <!-- Bootstrap 5.0.1 -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/bootstrap.min.css">
    <!-- Style css -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/login-2.css">
    <!--==================Web Manifest===================-->
    <link rel="manifest" href="<?php echo base_url(); ?>frequent_changing/progressive_app/manifest.json">
</head>

<body>
    <?php
	$s_status = ((defined('FCCPATH') && FCCPATH) ? FCCPATH : '');
	?>
    <input type="hidden" id="APPLICATION_SaaS_TYPE" value="<?php echo isServiceAccess('1', '1', 'sGmsJaFJE') ?>">
    <input type="hidden" id="APPLICATION_MODE" value="<?php echo APPLICATION_MODE ?>">
    <input type="hidden" id="fccpath" value="<?php echo $s_status ?>">
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-10 login-card-wrapper">
                    <div class="login-parent-wrapper">
                        <div class="input-container_custom"></div>
                        <?php
						if ($this->session->flashdata('exception_1')) {
							echo '<div class="input-container input-container_custom"><div class="alert alert-danger alert-dismissible">
							<a type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></a>
							<div class="alert-body"><i class="icon fa fa-times"></i>';
							echo $this->session->flashdata('exception_1');
							unset($_SESSION['exception_1']);
							echo '</div></div></div>';
						}
						if ($this->session->flashdata('exception')) {
							echo '<div class="input-container"><div class="alert alert-success alert-dismissible">
							<a type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></a>
							<div class="alert-body"><i class="icon fa fa-check me-2"></i>';
							echo $this->session->flashdata('exception');
							unset($_SESSION['exception']);
							echo '</div></div></div>';
						}
						?>
                        <div class="wrap d-md-flex">
                            <?php
							$login_img = isset($login->login_page_img) && $login->login_page_img ? $login->login_page_img : '';
							$logoPath = base_url() . 'uploads/site_settings/' . $login_img;
							?>
                            <div class="img business-grap" style="background-image: url('<?php echo $logoPath; ?>');">
                                <div class="overlay">
                                    <div>
                                        <h4><?php echo isset($login->title) && $login->title ? escape_output($login->title) : '' ?>
                                        </h4>
                                        <p><?php echo isset($login->short_description) && $login->short_description ? escape_output($login->short_description) : '' ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="login-wrap">
                                <div class="d-flex justify-content-center logo-area">
                                    <a href="<?php echo base_url(); ?>">
                                        <?php if ($s_status == "Bangladesh"): ?>
                                        <img src="<?php echo base_url(); ?>assets/images/logo.png" alt="site-logo">
                                        <?php else: ?>
                                        <img src="<?php echo $site_logo; ?>" alt="site-logo">
                                        <?php endif ?>
                                    </a>
                                </div>
                                <div class="d-flex">
                                    <div class="w-100">
                                        <h3 class="mb-3 auth-title"><?php echo lang('please_login'); ?></h3>
                                    </div>
                                </div>
                                <?php echo form_open(base_url() . 'Authentication/loginCheck', $arrayName = array('autocomplete' => 'off')) ?>
                                <div class="form-group mb-3">
                                    <label class="label"
                                        for="name"><?php echo lang('email_address'); ?>/<?php echo lang('phone'); ?></label>
                                    <input class="form-control"
                                        placeholder="<?php echo lang('email_address'); ?>/<?php echo lang('phone'); ?>"
                                        type="text" id="phone_number" autocomplete="off" required name="email_address"
                                        value="">
                                    <?php if (form_error('email_address')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <span class="error_paragraph"><?php echo form_error('email_address'); ?></span>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="label" for="password"><?php echo lang('password'); ?></label>
                                    <div class="password_wrap">
                                        <input type="password" autocomplete="off" name="password" value=""
                                            class="form-control password" placeholder="<?php echo lang('password'); ?>">
                                        <span class="view_ctrl">
                                            <iconify-icon icon="solar:password-broken"></iconify-icon>
                                        </span>
                                    </div>
                                    <?php if (form_error('password')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <span class="error_paragraph"><?php echo form_error('password'); ?></span>
                                    </div>
                                    <?php } ?>
                                </div>



                                <?php if (APPLICATION_MODE == 'demo' && isServiceAccess('1', '1', 'sGmsJaFJE')) { ?>
                                <div class="form-group py-10">
                                    <label class="label login-as">Login As</label>
                                    <div class="login-radio-wrap">
                                        <div class="login-radio-1">
                                            <input type="radio" id="test1" class="login_radio" name="login-radio-group"
                                                value="Sass Admin">
                                            <label for="test1">SaaS Admin</label>
                                        </div>
                                        <div>
                                            <input type="radio" id="test2" class="login_radio" name="login-radio-group"
                                                value="Shop Admin">
                                            <label for="test2">Shop Admin Access</label>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                                <div class="d-flex py-10">
                                    <button type="submit" name="submit" value="submit"
                                        class="btn login-button btn-2 rounded submit me-1 login_trigger"><?= lang('login'); ?></button>
                                    <?php if (isServiceAccess('1', '1', 'sGmsJaFJE')) { ?>
                                    <a href="<?php echo base_url(); ?>Authentication/signup"
                                        class="btn login-button btn-2 rounded submit me-1">Sign Up</a>
                                    <?php } ?>
                                    <?php if (APPLICATION_MODE == 'demo') { ?>
                                    <a target="_blank" class="btn login-button"
                                        href="<?php echo (defined('FCCPATH') && FCCPATH == 'Bangladesh') ? 'https://rumble.com/v5r88e8-348064640.html' : 'https://youtu.be/wtrn0uUxfC8?si=RKwcjlHSixegQeX3' ?>">
                                        How to start
                                    </a>
                                    <?php } ?>
                                </div>
                                <div class="d-flex justify-content-end forgot-pass-wrap">
                                    <a href="<?php echo base_url() ?>forgot-password-step-one"
                                        class="forgot-pass"><?= lang('forgot_password'); ?>?</a>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <?php if (APPLICATION_MODE == 'demo') { ?>
    <a href="<?php echo isServiceAccess2('', '', 'sGmsJaFJE') == 'Not SaaS' ? ((defined('FCCPATH') && FCCPATH == 'Bangladesh') ? 'https://dsbeta.work/lcdemo/biponi.php' : 'https://dsbeta.work/dsdemo/off_pos.php') : 'https://api.whatsapp.com/send?phone=880181231633' ?>"
        target="_blank" class="btn buy-now">
        <iconify-icon icon="solar:cart-large-broken" width="18" class="me-2"></iconify-icon> Buy Now
    </a>
    <?php } ?>


    <script src="<?php echo base_url(); ?>assets/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/origin.js"></script>
    <script src="<?php echo base_url(); ?>frequent_changing/js/select-2-call.js"></script>
    <script src="<?php echo base_url(); ?>frequent_changing/progressive_app/app_custom.js"></script>
    <script src="<?php echo base_url(); ?>frequent_changing/js/login.js"></script>
</body>

</html>