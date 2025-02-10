<?php
    $wl = getWhiteLabel();
	$timeZones = getTimeZone();
	$pricing_plans = getAllPricingPlan();
	$payment_info = getMainCompanyPaymentMethod();
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
	<!-- Toastr js -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/notify/toastr.css" type="text/css">
	<!-- Style css -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/signup.css">
	<!--==================Web Manifest===================-->
	<link rel="manifest" href="<?php echo base_url(); ?>frequent_changing/progressive_app/manifest.json">
</head>
<body>
	<!-- Hidden Field -->
	<input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
	<input type="hidden" id="stripe_publish_key" value="<?php echo $payment_info->stripe_publishable_key; ?>">
	<!-- End Hidden Field -->


	<section class="ftco-section">
		<div class="container">
			<div class="login-wrap">
				<div class="d-flex justify-content-center logo-area">
					<a href="<?php echo base_url();?>">
						<img src="<?php echo $site_logo;?>" alt="site-logo">
					</a>
				</div>
				<div class="d-flex">
					<div class="w-100">
						<h3 class="mb-3 auth-title">Sign Up</h3>
					</div>	
				</div>
				<?php echo form_open(base_url() . 'Authentication/signup', $arrayName = array('autocomplete' => 'off', 'id'=>'singup_form')) ?>
				<div class="row form-wrapper">
					<input type="hidden" name="paid_status" id="paid_status" value="Success">
					<div class="col-sm-12 col-md-6">
						<div class="auth-cart">
							<h4>Authentication Access</h4>
							<div class="form-group mb-3">
								<label class="label" for="full_name">Author Name <span class="required_star">*</span></label></label>
								<input  class="form-control" placeholder="Author Name" type="text" id="full_name" name="full_name" value="<?php echo set_value('full_name'); ?>">
								<div class="error-msg author_name_err_msg_contnr callout callout-danger my-2">
									<div class="author_name_err_msg error_paragraph"></div>
								</div>
								<?php if (form_error('full_name')) { ?>
								<div class="callout callout-danger my-2">
									<div class="error_paragraph d-flex align-items-center">
										<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
											<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
											<path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
										</svg> 
										<span class="ps-2">
											<?php echo form_error('full_name'); ?>
										</span>
									</div>
								</div>
								<?php } ?>
							</div>
							<div class="form-group mb-3">
								<label class="label" for="email_address">Email Address <span class="required_star">*</span></label></label>
								<input  class="form-control" placeholder="Email Address"  type="text" id="email_address" name="email_address" value="<?php echo set_value('email_address'); ?>">
								<input type="hidden" id="unique_email_check">
								<div class="error-msg email_address_err_msg_contnr callout callout-danger my-2">
									<div class="email_address_err_msg error_paragraph"></div>
								</div>
								<?php if (form_error('email_address')) { ?>
								<div class="callout callout-danger my-2">
									<div class="error_paragraph d-flex align-items-center">
										<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
											<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
											<path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
										</svg> 
										<span class="ps-2">
											<?php echo form_error('email_address'); ?>
										</span>
									</div>
								</div>
								<?php } ?>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group mb-3">
										<label class="label" for="password">Password <span class="required_star">*</span></label></label>
										<input type="password" name="password" class="form-control" placeholder="Password" id="password">
										<div class="error-msg password_err_msg_contnr callout callout-danger my-2">
											<div class="password_err_msg error_paragraph"></div>
										</div>
										<?php if (form_error('password')) { ?>
										<div class="callout callout-danger my-2">
											<div class="error_paragraph d-flex align-items-center">
												<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
													<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
													<path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
												</svg> 
												<span class="ps-2">
													<?php echo form_error('password'); ?>
												</span>
											</div>
										</div>
										<?php } ?>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group mb-3">
										<label class="label" for="confirm_password">Confirm Password <span class="required_star">*</span></label></label>
										<input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm Password">
										<div class="error-msg confirm_password_err_msg_contnr callout callout-danger my-2">
											<div class="confirm_password_err_msg error_paragraph"></div>
										</div>
										<?php if (form_error('confirm_password')) { ?>
										<div class="callout callout-danger my-2">
											<div class="error_paragraph d-flex align-items-center">
												<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
													<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
													<path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
												</svg> 
												<span class="ps-2">
													<?php echo form_error('confirm_password'); ?>
												</span>
											</div>
										</div>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-12 col-md-6">
						<div class="auth-cart">
							<h4>Company Info</h4>
							<div class="form-group mb-3">
								<label class="label" for="business_name">Business Name <span class="required_star">*</span></label></label>
								<input  class="form-control" placeholder="Business Name"  type="text" id="business_name" name="business_name" value="<?php echo set_value('business_name'); ?>">

								<div class="error-msg business_name_err_msg_contnr callout callout-danger my-2">
									<div class="business_name_err_msg error_paragraph"></div>
								</div>

								<?php if (form_error('business_name')) { ?>
								<div class="callout callout-danger my-2">
									<div class="error_paragraph d-flex align-items-center">
										<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
											<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
											<path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
										</svg> 
										<span class="ps-2">
											<?php echo form_error('business_name'); ?>
										</span>
									</div>
								</div>
								<?php } ?>
							</div>
							<div class="form-group mb-3">
								<label class="label" for="phone">Phone <span class="required_star">*</span></label></label>
								<input type="text" name="phone" class="form-control" id="phone_number" placeholder="<?php echo lang('phone'); ?>" value="<?php echo set_value('phone'); ?>">

								<div class="error-msg phone_number_err_msg_contnr callout callout-danger my-2">
									<div class="phone_number_err_msg error_paragraph"></div>
								</div>
								<?php if (form_error('phone')) { ?>
								<div class="callout callout-danger my-2">
									<div class="error_paragraph d-flex align-items-center">
										<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
											<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
											<path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
										</svg> 
										<span class="ps-2">
											<?php echo form_error('phone'); ?>
										</span>
									</div>
								</div>
								<?php } ?>
							</div>
							<div class="form-group mb-3">
								<label class="label" for="zone">Zone <span class="required_star">*</span></label></label>
								<select name="zone_name" id="zone" class="select2 form-control">
									<option value="">Select</option>
									<?php foreach($timeZones as $zone){ ?>
										<option value="<?php echo escape_output($zone->zone_name) ?>" <?php echo set_select('zone_name', $zone->zone_name); ?>"><?php echo escape_output($zone->zone_name) ?></option>
									<?php } ?>
								</select>

								<div class="error-msg zone_err_msg_contnr callout callout-danger my-2">
									<div class="zone_err_msg error_paragraph"></div>
								</div>

								<?php if (form_error('zone_name')) { ?>
								<div class="callout callout-danger my-2">
									<div class="error_paragraph d-flex align-items-center">
										<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
											<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
											<path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
										</svg> 
										<span class="ps-2">
											<?php echo form_error('zone_name'); ?>
										</span>
									</div>
								</div>
								<?php } ?>
							</div>
						</div>
					</div>
					<div class="col-12 mt-4">
						<h4>Pricing Plan</h4>
					</div>
					<div class="col-md-6">
						<div class="form-group mb-3 d-flex flex-column">
							<label class="label" for="plan_id">Pricing Plan<span class="required_star">*</span></label></label>
							<select name="plan_id" id="plan_id" class="select2 form-control">
								<option data-pricing_plan='' value="">Select</option>
								<?php 
								foreach($pricing_plans as $plans){ ?>
									<option data-pricing_plan_status="<?php echo escape_output($plans->free_trial_status) ?>" value="<?php echo escape_output($plans->id) ?>" <?php echo set_select('plan_id', $plans->id); ?>><?php echo escape_output($plans->plan_name) ?></option>
								<?php } ?>
							</select>

							<div class="error-msg plan_id_err_msg_contnr callout callout-danger my-2">
								<div class="plan_id_err_msg error_paragraph"></div>
							</div>
							<?php if (form_error('plan_id')) { ?>
							<div class="callout callout-danger my-2">
								<div class="error_paragraph d-flex align-items-center">
									<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
										<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
										<path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
									</svg> 
									<span class="ps-2">
										<?php echo form_error('plan_id'); ?>
									</span>
								</div>
							</div>
							<?php } ?>
						</div>
					</div>
					<div class="col-md-6">
						<div class="pricing_plan_div">
							<div class="form-group mb-3 d-flex flex-column">
								<label class="label" for="payment_type">Payment Type <span class="required_star">*</span></label></label>
								<select name="payment_type" id="payment_type" class="select2 form-control">
									<option value="">Select</option>
									<option value="One Time">One Time</option>
									<option value="Recurring">Recurring</option>
								</select>
								<div class="error-msg payment_type_err_msg_contnr callout callout-danger my-2">
									<div class="payment_type_err_msg error_paragraph"></div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="pricing_plan_div">
							<div class="form-group mb-3 d-flex flex-column">
								<label class="label" for="payment_mothod">Payment Method <span class="required_star">*</span></label></label>
								<select name="payment_mothod" id="payment_mothod" class="select2 form-control">
									<option value="">Select</option>
									<option value="Paypal">Paypal</option>
									<option value="Stripe">Stripe</option>
								</select>
								<div class="error-msg payment_method_err_msg_contnr callout callout-danger my-2">
									<div class="payment_method_err_msg error_paragraph"></div>
								</div>
							</div>
						</div>
					</div>

					<div class="row pricing_plan_div">
						<div class="col-md-3">
							<div class="form-group mb-3">
								<label class="label" for="holder_name">Holder Name <span class="required_star">*</span></label></label>
								<input  class="form-control" placeholder="Holder Name"  type="text" id="holder_name" name="holder_name" value="<?php echo set_value('holder_name'); ?>">
								<div class="error-msg holder_name_err_msg_contnr callout callout-danger my-2">
									<div class="holder_name_err_msg error_paragraph"></div>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group mb-3">
								<label class="label" for="credit_card_no">Credit Card No <span class="required_star">*</span></label></label>
								<input  class="form-control" placeholder="Credit Card No"  type="text" id="credit_card_no" name="credit_card_no" value="<?php echo set_value('credit_card_no'); ?>">
								<div class="error-msg credit_card_no_err_msg_contnr callout callout-danger my-2">
									<div class="credit_card_no_err_msg error_paragraph"></div>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group mb-3">
								<label class="label" for="payment_month">Month <span class="required_star">*</span></label></label>
								<input  class="form-control" placeholder="Month"  type="text" id="payment_month" name="payment_month" value="<?php echo set_value('payment_month'); ?>">
								<div class="error-msg payment_month_err_msg_contnr callout callout-danger my-2">
									<div class="payment_month_err_msg error_paragraph"></div>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group mb-3">
								<label class="label" for="payment_year">Year <span class="required_star">*</span></label></label>
								<input  class="form-control" placeholder="Year"  type="text" id="payment_year" name="payment_year" value="<?php echo set_value('payment_year'); ?>">
								<div class="error-msg payment_year_err_msg_contnr callout callout-danger my-2">
									<div class="payment_year_err_msg error_paragraph"></div>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group mb-3">
								<label class="label" for="payment_cvc">CVC <span class="required_star">*</span></label></label>
								<input  class="form-control" placeholder="CVC"  type="text" id="payment_cvc" name="payment_cvc" value="<?php echo set_value('payment_cvc'); ?>">
								<div class="error-msg payment_cvc_err_msg_contnr callout callout-danger my-2">
									<div class="payment_cvc_err_msg error_paragraph"></div>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<button type="button" class="pay_button btn login-button btn-2 rounded">Click To Payment</button>
						</div>
					</div>
				</div>
				<div class="d-flex py-10 justify-content-center">
					<a href="<?php echo base_url()?>/Authentication/index" class="btn login-button btn-2 rounded me-1">back</a>
					<button type="submit" name="submit" value="submit" class="btn login-button btn-2 rounded submit me-1 signup-btn">sign up</button>
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</section>
	<script src="<?php echo base_url(); ?>assets/bootstrap/bootstrap.bundle.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/copyright.js"></script>
	<script src="<?php echo base_url(); ?>frequent_changing/js/stripe.js"></script>
	<script src="<?php echo base_url(); ?>frequent_changing/js/signup.js"></script>
    <script src="<?php echo base_url(); ?>frequent_changing/progressive_app/app_custom.js"></script>
	<script src="<?php echo base_url(); ?>frequent_changing/js/select-2-call.js"></script>
	<script src="<?php echo base_url(); ?>assets/notify/toastr.js"></script>
</body>
</html>

