<?php
/*
  ###########################################################
  # PRODUCT NAME:   Off POS
  ###########################################################
  # AUTHER:     Doorsoft
  ###########################################################
  # EMAIL:      info@doorsoft.co
  ###########################################################
  # COPYRIGHTS:     RESERVED BY Door Soft
  ###########################################################
  # WEBSITE:        https://www.doorsoft.co
  ###########################################################
  # This is Authentication Controller
  ###########################################################
 */

defined('BASEPATH') OR exit('No direct script access allowed');
use Salla\ZATCA\GenerateQrCode;
use Salla\ZATCA\Tags\InvoiceDate;
use Salla\ZATCA\Tags\InvoiceTaxAmount;
use Salla\ZATCA\Tags\InvoiceTotalAmount;
use Salla\ZATCA\Tags\Seller;
use Salla\ZATCA\Tags\TaxNumber;

use Omnipay\Common\CreditCard;
use Omnipay\Omnipay;
use Stripe\Charge;
use Stripe\Stripe;

class Authentication extends Cl_Controller {


    /**
     * load constructor
     * @access public
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('Authentication_model');
        $this->load->model('Common_model');
        $this->load->model('Sale_model');
        $this->load->model('Attendance_model');
        $this->Common_model->setDefaultTimezone();
        $this->load->library('form_validation');
    }


    /**
     * index
     * @access public
     * @param no
     * @return void
     */
    public function index() {
        if ($this->session->userdata('user_id')) {
            if ($this->session->userdata('role') == '1') {
				redirect("Authentication/userProfile");
            } else {
                if($this->session->userdata('menu_access') != ''){
                    if (in_array('Sale', $this->session->userdata('menu_access'))) {
                        redirect("Sale/POS");
                    }
                }
                redirect("Authentication/userProfile");
            }
        }else{
            $this->load->view('authentication/login');
        }
    }

    public function internetCheck() {
        echo 1;
    }


    /**
     * planCheck
     * @access public
     * @param no
     * @return json
     */
    public function planCheck(){
        $plan_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('plan_id')));
        $plan = $this->Common_model->getDataById($plan_id, "tbl_pricing_plans");
        if($plan){
            $response = [
                'status' => 'success',
                'data' => $plan
            ];
        }else{
            $response = [
                'status' => 'error',
                'data' => 'Plan Not Found'
            ];
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }


    /**
     * uniqueEmailValidateInSignup
     * @access public
     * @param no
     * @return json
     */
    public function uniqueEmailValidateInSignup(){
        $email_address = htmlspecialcharscustom($this->input->post($this->security->xss_clean('email_address')));
        $result = $this->Common_model->checkExistingAdminAll($email_address);
        if($result){
            $response = [
                'status' => 'success',
            ];
        }else{
            $response = [
                'status' => 'error',
            ];
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }


    /**
     * stripePayment
     * @access public
     * @param no
     * @return json
     */
    public function stripeMainPayment(){
        $payment_credentials = getMainCompanyPaymentMethod();
        $plan_id = $this->input->post($this->security->xss_clean('plan_id'));
        $plan = $this->Common_model->getDataById($plan_id, "tbl_pricing_plans");
        $secret = $payment_credentials->stripe_api_key;
        try {
            $amount = $plan->plan_cost;
            if ($amount == 0 || $amount < 0) {
                echo json_encode(['status' => 'error', 'message' => 'Amount is required']);
                return;
            }
            Stripe::setApiKey($secret);
            $response = Charge::create([
                "amount" => $amount * 100,
                "currency" => "usd",
                "source" => $this->input->post('token'),
                "description" => "Sale Payment",
            ]);
            echo json_encode($response);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    /**
     * stripePayment
     * @access public
     * @param no
     * @return json
     */
    public function stripeMainPaymentOnetime(){
        $payment_credentials = getMainCompanyPaymentMethod();
        $payment_company_id = $this->input->post($this->security->xss_clean('payment_company_id'));
        $company_id = $this->custom->encrypt_decrypt($payment_company_id, 'decrypt');
        $company_info = $this->Common_model->getDataById($company_id, "tbl_companies");
        $plan = $this->Common_model->getDataById($company_info->plan_id, "tbl_pricing_plans");
        $company_update = array();
        $company_update['expired_date'] = date('Y-m-d', strtotime($company_info->expired_date . " + $company_info->access_day days"));
        $secret = $payment_credentials->stripe_api_key;
        try {
            $amount = $plan->plan_cost;
            if ($amount == 0 || $amount < 0) {
                echo json_encode(['status' => 'error', 'message' => 'Amount is required']);
                return;
            }
            Stripe::setApiKey($secret);
            $response = Charge::create([
                "amount" => $amount * 100,
                "currency" => "usd",
                "source" => $this->input->post('token'),
                "description" => "Sale Payment",
            ]);
            $this->Common_model->updateInformation($company_update, $company_id, "tbl_companies");
            echo json_encode($response);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    /**
     * paypalPayment
     * @access public
     * @param no
     * @return json
     */
    public function paypalMainPayment(){
        $payment_credentials = getMainCompanyPaymentMethod();
        $plan_id = $this->input->post($this->security->xss_clean('plan_id'));
        $plan = $this->Common_model->getDataById($plan_id, "tbl_pricing_plans");
        $info = $this->input->post('info');
        $amount = $plan->plan_cost;
        if ($amount == 0 || $amount < 0) {
            echo json_encode(['status' => 'error', 'code' => 701, 'message' => 'Amount is required']);
            return;
        }
        $gateway = Omnipay::create('PayPal_Express');
        $gateway->setUsername($payment_credentials->paypal_user_name);
        $gateway->setPassword($payment_credentials->paypal_password);
        $gateway->setSignature($payment_credentials->paypal_signature);
        $card = new CreditCard(array(
            'number' => $info['credit_card_no'],
            'expiryMonth' => $info['payment_month'],
            'expiryYear' => $info['payment_year'],
            'cvv' => $info['payment_cvc'],
        ));
        $response = $gateway->purchase(array(
            'amount' => $amount,
            'currency' => 'USD',
            'card' => $card,
            'returnUrl' => 'https: //sandbox.paypal.com',
            'cancelUrl' => 'https: //sandbox.paypal.com',
        ))->send();
        if ($response->isSuccessful()) {
            echo json_encode(['status' => 'success', 'code' => 200, 'message' => $response->getMessage()]);
        }  elseif ($response->isRedirect()) {
            $response->redirect();
        } else {
            echo json_encode(['status' => 'error', 'code' => 300, 'message' => $response->getMessage()]);
        }
    }
    /**
     * paypalPayment
     * @access public
     * @param no
     * @return json
     */
    public function paypalMainPaymentOnetime(){
        $payment_credentials = getMainCompanyPaymentMethod();
        $payment_company_id = $this->input->post($this->security->xss_clean('payment_company_id'));
        $company_id = $this->custom->encrypt_decrypt($payment_company_id, 'decrypt');
        $company_info = $this->Common_model->getDataById($company_id, "tbl_companies");
        $plan = $this->Common_model->getDataById($company_info->plan_id, "tbl_pricing_plans");
        $company_update = array();
        $company_update['expired_date'] = date('Y-m-d', strtotime($company_info->expired_date . " + $company_info->access_day days"));
        $info = $this->input->post('info');
        $amount = $plan->plan_cost;
        if ($amount == 0 || $amount < 0) {
            echo json_encode(['status' => 'error', 'code' => 701, 'message' => 'Amount is required']);
            return;
        }
        $gateway = Omnipay::create('PayPal_Express');
        $gateway->setUsername($payment_credentials->paypal_user_name);
        $gateway->setPassword($payment_credentials->paypal_password);
        $gateway->setSignature($payment_credentials->paypal_signature);
        $card = new CreditCard(array(
            'number' => $info['credit_card_no'],
            'expiryMonth' => $info['payment_month'],
            'expiryYear' => $info['payment_year'],
            'cvv' => $info['payment_cvc'],
        ));
        $response = $gateway->purchase(array(
            'amount' => $amount,
            'currency' => 'USD',
            'card' => $card,
            'returnUrl' => 'https: //sandbox.paypal.com',
            'cancelUrl' => 'https: //sandbox.paypal.com',
        ))->send();
        if ($response->isSuccessful()) {
            $this->Common_model->updateInformation($company_update, $company_id, "tbl_companies");
            echo json_encode(['status' => 'success', 'code' => 200, 'message' => $response->getMessage()]);
        }  elseif ($response->isRedirect()) {
            $response->redirect();
        } else {
            echo json_encode(['status' => 'error', 'code' => 300, 'message' => $response->getMessage()]);
        }
    }



    /**
     * signup
     * @access public
     * @return object
     * @param no
     */
    public function signup() {
        if (htmlspecialcharscustom($this->input->post('submit'))) {

            // Validation
            $this->form_validation->set_rules('full_name', 'Author Name', 'required|max_length[50]');
            $this->form_validation->set_rules('email_address', 'Email Address', "required|valid_email|is_unique[tbl_users.email_address]|max_length[55]");
		    $this->form_validation->set_rules('password', lang('password'), 'required|max_length[50]|min_length[6]');
            $this->form_validation->set_rules('confirm_password', lang('confirm_password'), 'required|max_length[50]|min_length[6]|matches[password]');
		    $this->form_validation->set_rules('business_name', 'Business Name', 'required');
		    $this->form_validation->set_rules('phone', 'Phone Number', 'required');
		    $this->form_validation->set_rules('zone_name', 'Zone Name', 'required');
		    $this->form_validation->set_rules('plan_id', 'Pricing Plan', 'required');

            if ($this->form_validation->run() == TRUE) {
                $plan_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('plan_id')));
                $full_name = htmlspecialcharscustom($this->input->post($this->security->xss_clean('full_name')));
                $author_email = htmlspecialcharscustom($this->input->post($this->security->xss_clean('email_address')));

                // Registraton Info
                $company_info= array();
                $company_info['business_name'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('business_name')));
                $company_info['phone'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('phone')));
                $company_info['zone_name'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('zone_name')));
                $company_info['email'] = $author_email;
                $company_info['plan_id'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('plan_id')));


                // Master Company Data
                $main_company = getMainCompany();
                $company_info['currency_position'] = isset($main_company->currency_position) && $main_company->currency_position ? $main_company->currency_position : '';
                $company_info['precision'] = isset($main_company->precision) && $main_company->precision ? $main_company->precision:'';
                $company_info['payment_settings'] = isset($main_company->payment_settings) && $main_company->payment_settings ? $main_company->payment_settings:'';
                $company_info['sms_setting_check'] = isset($main_company->sms_setting_check) && $main_company->sms_setting_check ? $main_company->sms_setting_check:'';
                $company_info['tax_title'] = isset($main_company->tax_title) && $main_company->tax_title ? $main_company->tax_title:'';
                $company_info['tax_registration_no'] = isset($main_company->tax_registration_no) && $main_company->tax_registration_no ? $main_company->tax_registration_no:'';
                $company_info['tax_is_gst'] = isset($main_company->tax_is_gst) && $main_company->tax_is_gst ? $main_company->tax_is_gst:'';
                $company_info['tax_setting'] = isset($main_company->tax_setting) && $main_company->tax_setting?$main_company->tax_setting:'';
                $company_info['tax_string'] = isset($main_company->tax_string) && $main_company->tax_string?$main_company->tax_string:'';
                $company_info['sms_enable_status'] = isset($main_company->sms_enable_status) && $main_company->sms_enable_status?$main_company->sms_enable_status:'';
                $company_info['smtp_enable_status'] = isset($main_company->smtp_enable_status) && $main_company->smtp_enable_status?$main_company->smtp_enable_status:'';
                $company_info['language_manifesto'] = isset($main_company->language_manifesto) && $main_company->language_manifesto?$main_company->language_manifesto:'';
                $company_info['date_format'] = isset($main_company->date_format) && $main_company->date_format?$main_company->date_format:'';
                $company_info['currency'] = isset($main_company->currency) && $main_company->currency?$main_company->currency:'';
                $company_info['direct_cart'] = "No";
                $company_info['onscreen_keyboard_status'] = "Enable";
                $company_info['product_display'] = "Image View";
                $company_info['default_cursor_position'] = "Search Box";
                $company_info['allow_less_sale'] = "No";
                $company_info['register_content'] = isset($main_company->register_content) && $main_company->register_content?$main_company->register_content:'';
                $company_info['invoice_footer'] = isset($main_company->invoice_footer) && $main_company->invoice_footer?$main_company->invoice_footer:'';
                $company_info['collect_tax'] = isset($main_company->collect_tax) && $main_company->collect_tax?$main_company->collect_tax:'';
                $company_info['is_saas'] = "Yes";
                // White Label
                $company_info['white_label']  = $main_company->white_label;

                // Payment API Setting
                $payment_api_data = array();
                $payment_api_data['action_type_stripe'] = 'Disable';
                $payment_api_data['stripe_api_key'] = '';
                $payment_api_data['stripe_publishable_key'] = '';
                $payment_api_data['action_type_paypal'] = 'Disable';
                $payment_api_data['paypal_user_name'] = '';
                $payment_api_data['paypal_password'] = '';
                $payment_api_data['paypal_signature'] = '';
                $company_info['payment_api_setting'] = json_encode($payment_api_data);

                // SMS Setting json
                $sms_info_json = array();
                $sms_info_json['field_1_0'] = '';
                $sms_info_json['field_1_1'] = '';
                $sms_info_json['field_1_2'] = '';
                $sms_info_json['field_2_0'] = '';
                $sms_info_json['field_2_1'] = '';
                $sms_info_json['field_2_2'] = '';
                $sms_info_json['field_2_3'] = '';
                $sms_info_json['field_3_0'] = '';
                $sms_info_json['field_3_1'] = '';
                $sms_info_json['field_3_2'] = '';
                $sms_info_json['field_4_0'] = '';
                $sms_info_json['field_4_1'] = '';
                $sms_info_json['field_4_2'] = '';
                $company_info['sms_enable_status'] = 2;
                $company_info['sms_details'] = json_encode($sms_info_json);

                // SMTP Setting json
                $smtp_info_json = array();
                $smtp_info_json['host_name']  = 'smtp.gmail.com';
                $smtp_info_json['port_address']  = '465';
                $smtp_info_json['encryption']  = 'ssl';
                $smtp_info_json['user_name']  = '';
                $smtp_info_json['password']  = '';
                $smtp_info_json['from_name']  = '';
                $smtp_info_json['from_email']  = '';
                $smtp_info_json['api_key']  = '';
                $company_info['smtp_type'] = 'Sendinblue';
                $company_info['smtp_enable_status'] = 2;
                $company_info['smtp_details'] = json_encode($smtp_info_json);
                /*getting active random code*/
                $active_code = uniqid();
                $company_info['active_code'] = $active_code;

                $plan = $this->Common_model->getDataById($plan_id, "tbl_pricing_plans");
                if($plan->free_trial_status == 'Paid'){
                    $company_info['plan_cost'] = $plan->plan_cost;
                    $company_info['is_active'] = 1;
                    $company_info['del_status'] = "Live";
                }else if($plan->free_trial_status == 'Free'){
                    $company_info['is_active'] = 2;
                    $company_info['del_status'] = "Deleted";
                }
                $company_info['payment_clear'] = "Yes";
                $company_info['number_of_maximum_users'] = $plan->number_of_maximum_users;
                $company_info['number_of_maximum_outlets'] = $plan->number_of_maximum_outlets;
                $company_info['number_of_maximum_invoices'] = $plan->number_of_maximum_invoices;
                $company_info['access_day'] = $plan->trail_days;
                $company_info['user_id'] = 1;
                $today = date('Y-m-d');
                $company_info['created_date'] = $today;
                $company_info['expired_date'] = date('Y-m-d', strtotime($today . " + $plan->trail_days days"));
                $inserted_company_id = $this->Common_model->insertInformation($company_info, "tbl_companies");
                if($inserted_company_id){
                    // Walking Customer Insert
                    $walking_customer = [];
                    $walking_customer['name'] = 'Walk-in Customer';
                    $walking_customer['opening_balance'] = '0';
                    $walking_customer['opening_balance_type'] = 'Debit';
                    $walking_customer['credit_limit'] = '0';
                    $walking_customer['customer_type'] = 'default';
                    $walking_customer['price_type'] = '1';
                    $walking_customer['discount'] = '0';
                    $walking_customer['user_id'] = 1;
                    $walking_customer['company_id'] = $inserted_company_id;
                    if($plan->free_trial_status == 'Paid'){
                        $walking_customer['del_status'] = 'Live';
                    }else if($plan->free_trial_status == 'Free'){
                        $walking_customer['del_status'] = 'Deleted';
                    }
                    $this->Common_model->insertInformation($walking_customer, "tbl_customers");
                    // Payment Method Insert
                    $accounts = [
                        (object)[
                            'name' => 'Cash',
                            'account_type' => 'Cash',
                        ],
                        (object)[
                            'name' => 'Bank',
                            'account_type' => 'Bank_Account',
                        ],
                        (object)[
                            'name' => 'Paypal',
                            'account_type' => 'Paypal',
                        ],
                        (object)[
                            'name' => 'Stripe',
                            'account_type' => 'Stripe',
                        ],
                        (object)[
                            'name' => 'Loyalty Point',
                            'account_type' => 'Loyalty Point',
                        ]
                    ];

                    // Iterate through each account and insert into the database
                    foreach ($accounts as $account) {
                        $account_data = [];
                        $account_data['name'] = $account->name;
                        $account_data['account_type'] = $account->account_type;
                        $account_data['current_balance'] = 0;
                        $account_data['status'] = 'Enable';
                        $account_data['is_deletable'] = 'No';
                        $account_data['added_date'] = date('Y-m-d H:i:s');
                        $account_data['user_id'] = 1;
                        $account_data['company_id'] = $inserted_company_id;
                        if($plan->free_trial_status == 'Paid'){
                            $account_data['del_status'] = 'Live';
                        }else if($plan->free_trial_status == 'Free'){
                            $account_data['del_status'] = 'Deleted';
                        }
                        // Insert the account data into the database
                        $this->Common_model->insertInformation($account_data, "tbl_payment_methods");
                    }
                    if($inserted_company_id){
                        $admin_data = array();
                        $admin_data['full_name'] = $full_name;
                        $admin_data['phone'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('phone')));
                        $admin_data['email_address'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('email_address')));
                        $admin_data['password'] = md5(($this->input->post($this->security->xss_clean('password'))));
                        $admin_data['role'] = 1;
                        $admin_data['company_id'] = $inserted_company_id;
                        $admin_data['will_login'] = "Yes";
                        $admin_data['sale_price_modify'] = "Yes";
                        $admin_data['is_saas'] = "Yes";
                        if($plan->free_trial_status == 'Paid'){
                            $admin_data['del_status'] = "Live";
                        }else if($plan->free_trial_status == 'Free'){
                            $admin_data['del_status'] = "Deleted";
                        }
                        $this->Common_model->insertInformation($admin_data, "tbl_users");
                    }
                    if($plan->free_trial_status == 'Free'){
                        //send success message for supper admin
                        $business = $company_info['business_name'];
                        $message = 'Congratulations, "'.$business.'" Shop sign-up has been successful.
                        For active your account- <a href="'.base_url().'active-now/'.$active_code.'">Active Now</a>';
                        if($main_company->smtp_enable_status == 1){
                            $mail_data = [];
                            $mail_data['to'] = ["$author_email"];
                            $mail_data['subject'] = 'Shop Signup Varification';
                            $mail_data['file_name'] = '';
                            $mail_data['company_id'] = 1;
                            $mail_data['company_info'] = $main_company;
                            $mail_data['message'] = $message;
                            $mail_data['user_name'] = $full_name;
                            $mail_data['template'] = $this->load->view('mail-template/signup-template', $mail_data, TRUE);
                            if($main_company->smtp_type == "Sendinblue"){
                                $emailSent = sendInBlueMain($mail_data);
                            }else{
                                $emailSent = sendEmailOnly(
                                    $mail_data['subject'],
                                    $mail_data['template'],
                                    $author_email,
                                    '',
                                    $mail_data['file_name'],
                                    $main_company->id
                                );
                            }
                            if ($emailSent) {
                                $this->session->set_flashdata('exception', "Congratulations Shop sign-up has been successful. Check your mail and active the account");
                            } else {
                                $this->session->set_flashdata('exception_1', "Mail Sent failed, Contact with administrator");
                            }
                        } else {
                            $this->session->set_flashdata('exception_1', "Signup Success, Mail Configuration is disabled, to activate the account contact with administrator");
                        }
                    }else{
                        $this->session->set_flashdata('exception', "Congratulations Shop sign-up has been successful. Login Please");
                    }
                    redirect('Authentication/index');
                }else{
                    $this->session->set_flashdata('exception_1', "Something went wrong!");
                    redirect('Authentication/signup');
                }
            } else {
                $this->load->view('authentication/signup');
            }
        } else {
            $this->load->view('authentication/signup');
        }
    }


    /**
     * active_company
     * @access public
     * @param string
     * @return void
     */
    public function activeCompany($code){
        $companies_info = $this->Common_model->getCustomDataByParams("active_code", $code, "tbl_companies");
        if(isset($companies_info->active_code) && $companies_info->active_code == $code && $companies_info->is_active == 2){
            $data['is_active'] = 1;
            $data['del_status'] = 'Live';
            $this->Common_model->delStatusLiveForCompanyActive($companies_info->id, 'tbl_users');
            $this->Common_model->delStatusLiveForCompanyActive($companies_info->id, 'tbl_payment_methods');
            $this->Common_model->delStatusLiveForCompanyActive($companies_info->id, 'tbl_customers');
            $this->Common_model->updateInformation($data, $companies_info->id, "tbl_companies");
            $this->session->set_flashdata('exception',"Your account successfully activated");
        }else if(isset($companies_info->active_code) && $companies_info->active_code == $code && $companies_info->is_active == 1){
            $this->session->set_flashdata('exception_1',"Your account already active");
        }else{
            $this->session->set_flashdata('exception_1', "You clicked URL not valid");
        }
        redirect('Authentication/index');
    }


    /**
     * downloadPDF
     * @access public
     * @param string
     * @return void
     */
    public function downloadPDF($file = "") {
        $this->load->helper('download');
        $data = file_get_contents("assets/upload-sample/sample/" . $file); // Read the file's
        $name = $file;
        force_download($name, $data);
    }


    /**
     * loginCheck
     * @access public
     * @param no
     * @return void
     */
    public function loginCheck() {
        if($this->input->post('submit') != 'submit'){
            redirect("Authentication/index");
        }
        $this->form_validation->set_rules('email_address', lang('email_address'), 'required|max_length[50]');
        $this->form_validation->set_rules('password', lang('password'), "required|max_length[25]");
        if ($this->form_validation->run() == TRUE) {
            $email_address = htmlspecialcharscustom($this->input->post($this->security->xss_clean('email_address')));
            $password = md5($this->input->post($this->security->xss_clean('password')));
            $user_information = $this->Authentication_model->getUserInformation($email_address, $password);
            if ($user_information) {
                $view_purchase_price =  '';
                $company_info = $this->Authentication_model->getCompanyInformation($user_information->company_id);
                $module_hide_show = getAllChildModule();
                $moduleArr = [];
                if($module_hide_show){
                    foreach($module_hide_show as $module){
                        array_push($moduleArr, $module->module_name.'-YES');
                    }
                }
                if($user_information->id == '1' && $user_information->role == "1"){
                    $getAccess = $this->Common_model->getAllAccess();
                }else{
                    if($company_info->id != '1'){
                        $today = date('Y-m-d');
                        if($company_info->expired_date < $today){
                            $this->session->set_flashdata('exception_1', "Your Account expired on " . dateFormatMaster($company_info->expired_date) . ", please make your payment or contact with admin.");
                            redirect('Authentication/index');
                        }
                        if($company_info->is_active == '2' || $company_info->del_status == 'Deleted'){
                            $this->session->set_flashdata('exception_1', 'This Company is not active or Payment is not clear');
                            redirect('Authentication/index');
                        }
                    }
                    if($user_information->will_login == 'No'){
                        $this->session->set_flashdata('exception_1', lang('incorrect_email_password'));
                        redirect('Authentication/index');
                    }
                    if ($user_information->active_status != 'Active') {
                        $this->session->set_flashdata('exception_1', lang('user_not_active'));
                        redirect('Authentication/index');
                    }
                    $getAccess = $this->Common_model->getRolePermissionByRoleId($user_information->role);
                }
                $menu_access_container = array();
                if($user_information->role=="1" && $user_information->id == "1"){
                    if (isset($getAccess)) {
                        foreach ($getAccess as $value) {
                            array_push($menu_access_container, $value->function_name."-".$value->parent_id);
                            if($value->function_name == 'view_purchase_price' && $value->parent_id == '138'){
                                $view_purchase_price =  'Yes';
                            }
                        }
                    }
                }else{
                    if (isset($getAccess)) {
                        $getAccesRow = '';
                        foreach ($getAccess as $value) {
                            $getAccesRow = $this->Common_model->getAllByCustomRowId($value->access_child_id,"id",'tbl_access');
                            if($getAccesRow){
                                array_push($menu_access_container, $getAccesRow->function_name."-".$getAccesRow->parent_id);
                                if($getAccesRow->function_name == 'view_purchase_price' && $getAccesRow->parent_id == '138'){
                                    $view_purchase_price =  'Yes';
                                }
                            }
                        }
                    }
                }

                //User Information
                $register_status = $this->Common_model->getRegisterStatus($user_information->id);
                // Initialize default printer settings
                $login_session = [
                    'print_format' => '',
                    'characters_per_line' => '',
                    'printer_ip_address' => '',
                    'printer_port' => '',
                    'qr_code_type' => '',
                    'invoice_print' => '',
                    'fiscal_printer_status' => '',
                    'open_cash_drawer_when_printing_invoice' => '',
                    'print_server_url_invoice' => '',
                    'inv_qr_code_status' => '',
                    'register_status' => $register_status,
                    'view_purchase_price' => $view_purchase_price,
                    'function_access' => $menu_access_container,
                ];

                // Check register status
                if ($register_status == '1') {
                    $counter_id = $this->Common_model->getCounterIdFromRegister($user_information->id);
                    if ($counter_id) {
                        $printer_id = $this->Common_model->getPrinterIdByCounterId($counter_id);
                        $printer_info = $this->Common_model->getPrinterInfoById($printer_id);
                        if ($printer_info) {
                            $login_session['print_format'] = $printer_info->print_format;
                            $login_session['characters_per_line'] = $printer_info->characters_per_line;
                            $login_session['printer_ip_address'] = $printer_info->printer_ip_address;
                            $login_session['printer_port'] = $printer_info->printer_port;
                            $login_session['qr_code_type'] = $printer_info->qr_code_type;
                            $login_session['invoice_print'] = $printer_info->invoice_print;
                            $login_session['fiscal_printer_status'] = $printer_info->fiscal_printer_status;
                            $login_session['open_cash_drawer_when_printing_invoice'] = $printer_info->open_cash_drawer_when_printing_invoice;
                            $login_session['print_server_url_invoice'] = $printer_info->print_server_url_invoice;
                            $login_session['inv_qr_code_status'] = $printer_info->inv_qr_code_status;
                        }
                    }
                }


                $login_session['invoice_configuration'] = $company_info->invoice_configuration;
                $login_session['inv_logo_is_show'] = $company_info->inv_logo_is_show;
                $login_session['grocery_experience'] = $company_info->grocery_experience;
                $login_session['generic_name_search_option'] = $company_info->generic_name_search_option;
                $login_session['register_content'] = $company_info->register_content;
                $login_session['printer_id'] = $user_information->printer_id ?? '';
                $login_session['open_cash_drawer'] = $user_information->open_cash_drawer ?? '';
                $login_session['user_id'] = $user_information->id;
                $login_session['language'] = $user_information->language;
                $login_session['sale_price_modify'] = $user_information->sale_price_modify;
                $login_session['full_name'] = $user_information->full_name;
                $login_session['email_address'] = $user_information->email_address;
                $login_session['role'] = $user_information->role;
                $login_session['photo'] = $user_information->photo;
                $login_session['session_outlets'] = $user_information->outlet_id;
                $login_session['company_id'] = $user_information->company_id;
                $login_session['user_is_saas'] =$user_information->is_saas;

                //Company Information
                $login_session['invoice_prefix'] = $company_info->invoice_prefix;
                $login_session['business_name'] = $company_info->business_name;
                $login_session['currency'] = $company_info->currency;
                $login_session['currency_position'] = $company_info->currency_position;
                $login_session['time_zone'] = $company_info->zone_name;
                $login_session['date_format'] = $company_info->date_format;
                $login_session['email'] =$company_info->email;
                $login_session['precision'] =$company_info->precision;
                $login_session['default_cursor_position'] =$company_info->default_cursor_position;
                $login_session['product_display'] =$company_info->product_display;
                $login_session['onscreen_keyboard_status'] =$company_info->onscreen_keyboard_status;
                $login_session['inv_no_start_from'] =$company_info->inv_no_start_from;
                $login_session['product_code_start_from'] =$company_info->product_code_start_from;
                $login_session['default_customer'] =$company_info->default_customer;
                $login_session['letter_head_gap'] =$company_info->letter_head_gap;
                $login_session['letter_footer_gap'] =$company_info->letter_footer_gap;

                $login_session['decimals_separator'] =$company_info->decimals_separator;
                $login_session['thousands_separator'] =$company_info->thousands_separator;
                $login_session['term_conditions'] =$company_info->term_conditions;
                $login_session['default_payment'] =$company_info->default_payment;
                $login_session['tax_is_gst'] = $company_info->tax_is_gst;
                $login_session['collect_tax'] = $company_info->collect_tax;
                $login_session['tax_type'] = $company_info->tax_type;
                $login_session['tax_registration_no'] = $company_info->tax_registration_no;
                $login_session['tax_title'] = $company_info->tax_title;
                $login_session['invoice_footer'] = $company_info->invoice_footer;
                $login_session['sms_setting_check'] = $company_info->sms_setting_check;
                $login_session['invoice_logo'] = $company_info->invoice_logo;
                $login_session['show_hide'] = $company_info->show_hide;
                $login_session['i_sale'] = $company_info->i_sale;
                $login_session['direct_cart'] = $company_info->direct_cart;
                $login_session['purchase_price_show_hide'] = $company_info->purchase_price_show_hide;
                $login_session['invoice_prefix'] = $company_info->invoice_prefix;
                $login_session['whole_price_show_hide'] = $company_info->whole_price_show_hide;
                $login_session['allow_less_sale'] = $company_info->allow_less_sale ?? '';
                $login_session['item_modal_status'] = $company_info->item_modal_status;
                $login_session['pos_total_payable_type'] = $company_info->pos_total_payable_type;
                $login_session['is_loyalty_enable'] =$company_info->is_loyalty_enable;
                $login_session['minimum_point_to_redeem'] =$company_info->minimum_point_to_redeem;
                $login_session['loyalty_rate'] =$company_info->loyalty_rate;
                $login_session['whatsapp_invoice_enable_status'] =$company_info->whatsapp_invoice_enable_status;
                $login_session['company_is_saas'] = $company_info->is_saas;
                $login_session['is_collapse'] = 'No';
                $login_session['module_show_hide'] = $moduleArr;
                // Login Time Update
                $login_update = array();
                $login_update['last_login'] = date('Y-m-d H:i:s');
                $this->Common_model->updateInformation($login_update, $user_information->id, "tbl_users");
                //Menu access information

                $this->session->set_userdata($login_session);
                if($user_information->outlet_id){
                    $outlet = explode(",", $user_information->outlet_id);
                    $outlet_details = $this->Common_model->getDataById($outlet[0], 'tbl_outlets');
                    if($outlet_details){
                        $outlet_session = array();
                        $outlet_session['outlet_name'] = $outlet_details->outlet_name;
                        $outlet_session['address'] = $outlet_details->address;
                        $outlet_session['phone'] = $outlet_details->phone;
                        $this->session->set_userdata($outlet_session);
                    }
                }
                if ($user_information->role == '1') {
                    redirect("Outlet/outlets");
                } else {
                    redirect("Authentication/userProfile");
                }
            }else {
                $this->session->set_flashdata('exception_1', lang('incorrect_email_password_or_user_not_active'));
                redirect('Authentication/index');
            }
        } else {
            $this->load->view('authentication/login');
        }
    }


    /**
     * paymentNotClear
     * @access public
     * @param no
     * @return void
     */
    public function paymentNotClear() {
        if (!$this->session->has_userdata('customer_id')) {
            redirect('Authentication/index');
        }
        $this->load->view('authentication/paymentNotClear');
    }



    /**
     * userProfile
     * @access public
     * @param no
     * @return void
     */
    public function userProfile() {
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['sales'] = $this->Common_model->getSaleInfoByUserId($user_id);
        $data['main_content'] = $this->load->view('authentication/userProfile', $data, TRUE);
        $this->load->view('userHome', $data);
    }


    /**
     * companyProfile
     * @access public
     * @param no
     * @return void
     */
    public function companyProfile() {
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        $data = array();
        $company_id = $this->session->userdata('company_id');
        $data['company_information'] = $this->Common_model->getDataById($company_id, 'tbl_companies');
        $data['main_content'] = $this->load->view('authentication/updateCompanyProfile', $data, TRUE);
        $this->load->view('outlet/outletHome', $data);
    }





    /**
     * passwordChange
     * @access public
     * @param no
     * @return void
     */
    public function passwordChange() {
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        if ($this->input->post('submit') == 'submit') {
            $this->form_validation->set_rules('old_password',lang('old_password'), 'required|max_length[50]');
            $this->form_validation->set_rules('new_password', lang('new_password'), 'required|max_length[50]|min_length[6]');
            if ($this->form_validation->run() == TRUE) {
                $old_password = htmlspecialcharscustom($this->input->post($this->security->xss_clean('old_password')));
                $user_id = $this->session->userdata('user_id');
                $password_check = $this->Authentication_model->passwordCheck($old_password, $user_id);
                if ($password_check) {
                    $new_password = htmlspecialcharscustom($this->input->post($this->security->xss_clean('new_password')));
                    $this->Authentication_model->updatePassword($new_password, $user_id);
                    $this->session->set_flashdata('exception', lang('password_changed'));
                    redirect('Authentication/passwordChange');
                } else {
                    $this->session->set_flashdata('exception_1', lang('old_password_not_match'));
                    redirect('Authentication/passwordChange');
                }
            } else {
                $data = array();
                $data['main_content'] = $this->load->view('authentication/passwordChange', $data, TRUE);
                $this->load->view('outlet/outletHome', $data);
            }
        } else {
            $data = array();
            $data['main_content'] = $this->load->view('authentication/passwordChange', $data, TRUE);
            $this->load->view('outlet/outletHome', $data);
        }
    }


    /**
     * forgot password
     * @access public
     * @param no
     * @return void
     */
    public function forgotPassword() {
        $this->load->view('authentication/forgotPassword');
    }


    /**
     * forgotPasswordStepOne
     * @access public
     * @param no
     * @return void
     */
    public function forgotPasswordStepOne() {
        $this->form_validation->set_rules('email_address', lang('email_phone'), 'required');
        if ($this->form_validation->run() == TRUE) {
            $email_address = htmlspecialcharscustom($this->input->post($this->security->xss_clean('email_address')));
            $user_information = $this->Authentication_model->getAccountByMobileNo($email_address);
            //If user exists
            if ($user_information) {
                $data = array();
                $data['id'] = $user_information->id;
                $data['matchAnswer'] = $user_information->answer;
                $data['matchQuestion'] = $user_information->question;
                $json = file_get_contents("./assets/sample-questions/sampleQustions.json");
                $obj  = json_decode($json);
                $data['question'] = $obj;
                $this->load->view('authentication/forgotPasswordStepTwo', $data);
            } else {
                $this->session->set_flashdata('exception_1', 'Email Address not found!');
                redirect('Authentication/forgotPasswordStepOne');
            }
        } else {
            $this->load->view('authentication/forgotPasswordStepOne');
        }
    }

    /**
     * forgotPasswordStepTwo
     * @access public
     * @param no
     * @return void
     */
    public function forgotPasswordStepTwo() {
        $data['matchQuestion'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('matchQuestion')));
        $data['matchAnswer'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('matchAnswer')));
        $data['id'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('id')));
        $json = file_get_contents("./assets/sample-questions/sampleQustions.json");
        $obj  = json_decode($json);
        $data['question'] = $obj;
        $this->form_validation->set_rules('answer', 'Answer', 'required');
        if ($this->form_validation->run() == TRUE) {
            $answer = htmlspecialcharscustom($this->input->post($this->security->xss_clean('answer')));
            $question = htmlspecialcharscustom($this->input->post($this->security->xss_clean('question')));
            $matchQuestion = htmlspecialcharscustom($this->input->post($this->security->xss_clean('matchQuestion')));
            $matchAnswer = htmlspecialcharscustom($this->input->post($this->security->xss_clean('matchAnswer')));
            if($matchQuestion == $question){
                if($matchAnswer == $answer){
                    $this->session->set_flashdata('exception_1', '');
                    $this->load->view('authentication/forgotPasswordStepFinal', $data);
                }else{
                    $this->session->set_flashdata('exception_1', 'Incorrect answer!');
                    $this->load->view('authentication/forgotPasswordStepTwo', $data);
                }
            } else {
                $this->session->set_flashdata('exception_1', 'Incorrect question!');
                $this->load->view('authentication/forgotPasswordStepTwo', $data);
            }
        } else {
            $this->load->view('authentication/forgotPasswordStepTwo', $data);
        }
    }


    /**
     * forgotPasswordStepDone
     * @access public
     * @param no
     * @return void
     */
    public function forgotPasswordStepDone() {
        $data['id'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('id')));
        $data['matchQuestion'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('matchQuestion')));
        $data['matchAnswer'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('matchAnswer')));
        $this->form_validation->set_rules('password', lang('password'), 'required');
        $this->form_validation->set_rules('confirm_password', lang('confirm_password'), 'required|matches[password]');
        if ($this->form_validation->run() == TRUE) {
            $password = htmlspecialcharscustom($this->input->post($this->security->xss_clean('password')));
            $user_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('id')));
            $this->Authentication_model->updatePassword(md5($password), $user_id);
            $this->session->set_flashdata('exception',lang('password_changed'));
            redirect('Authentication/index');
        } else {
            $this->load->view('authentication/forgotPasswordStepFinal', $data);
        }
    }





    /**
     * sendAutoPassword
     * @access public
     * @param no
     * @return void
     */
    public function sendAutoPassword() {
        if ($this->input->post('submit') == 'submit') {
            $this->form_validation->set_rules('email_address', lang('email_address'), 'required|valid_email|callback_checkEmailAddressExistance');
            if ($this->form_validation->run() == TRUE) {
                $email_address = htmlspecialcharscustom($this->input->post($this->security->xss_clean('email_address')));
                $user_details = $this->Authentication_model->getAccountByMobileNo($email_address);
                $user_id = $user_details->id;
                $auto_generated_password = mt_rand(100000, 999999);
                $this->Authentication_model->updatePassword($auto_generated_password, $user_id);
                $this->load->library('email');
                $config['protocol'] = 'sendmail';
                $config['mailpath'] = '/usr/sbin/sendmail';
                $config['charset'] = 'iso-8859-1';
                $config['wordwrap'] = TRUE;
                $this->email->initialize($config);
                mail($email_address, lang('change_password'), lang('Your_new_password_is') . $auto_generated_password);
                $this->load->view('authentication/forgotPasswordSuccess');
            } else {
                $this->load->view('authentication/forgotPassword');
            }
        } else {
            $this->load->view('authentication/forgotPassword');
        }
    }


    /**
     * checkEmailAddressExistance
     * @access public
     * @param no
     * @return boolean
     */
    public function checkEmailAddressExistance() {
        $email_address = htmlspecialcharscustom($this->input->post($this->security->xss_clean('email_address')));
        $checkEmailAddressExistance = $this->Authentication_model->getAccountByMobileNo($email_address);
        if (count($checkEmailAddressExistance) <= 0) {
            $this->form_validation->set_message('checkEmailAddressExistance', lang('Email_address_does_not_exist'));
            return false;
        } else {
            return true;
        }
    }


    /**
     * logOut
     * @access public
     * @param no
     * @return void
     */
    public function logOut() {
        //User Information
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('session_outlets');
        $this->session->unset_userdata('session_service_center');
        $this->session->unset_userdata('full_name');
        $this->session->unset_userdata('phone');
        $this->session->unset_userdata('email_address');
        $this->session->unset_userdata('sale_price_modify');
        $this->session->unset_userdata('role');
        $this->session->unset_userdata('customer_id');
        $this->session->unset_userdata('company_id');
        $this->session->unset_userdata('register_status');
        $this->session->unset_userdata('grocery_experience');
        $this->session->unset_userdata('generic_name_search_option');
        //Shop Information
        $this->session->unset_userdata('outlet_id');
        $this->session->unset_userdata('outlet_name');
        $this->session->unset_userdata('business_name');
        $this->session->unset_userdata('address');
        $this->session->unset_userdata('collect_tax');
        $this->session->unset_userdata('tax_type');
        $this->session->unset_userdata('tax_registration_no');
        $this->session->unset_userdata('tax_title');
        $this->session->unset_userdata('print_select');
        $this->session->unset_userdata('kot_print');
        $this->session->unset_userdata('qty_setting_check');
        $this->session->unset_userdata('i_sale');
        $this->session->unset_userdata('purchase_price_show_hide');
        $this->session->unset_userdata('whole_price_show_hide');
        $this->session->unset_userdata('item_modal_status');
        $this->session->unset_userdata('sms_setting_check');
        $this->session->unset_userdata('invoice_prefix');
        $this->session->unset_userdata('letter_head_gap');
        $this->session->unset_userdata('letter_footer_gap');
        //company Information
        $this->session->unset_userdata('currency');
        $this->session->unset_userdata('currency_position');
        $this->session->unset_userdata('time_zone');
        $this->session->unset_userdata('date_format');
        $this->session->unset_userdata('function_access');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('precision');
        $this->session->unset_userdata('default_cursor_position');
        $this->session->unset_userdata('product_display');
        $this->session->unset_userdata('onscreen_keyboard_status');
        $this->session->unset_userdata('inv_no_start_from');
        $this->session->unset_userdata('product_code_start_from');
        $this->session->unset_userdata('decimals_separator');
        $this->session->unset_userdata('thousands_separator');
        $this->session->unset_userdata('pos_total_payable_type');
        $this->session->unset_userdata('is_loyalty_enable');
        $this->session->unset_userdata('minimum_point_to_redeem');
        $this->session->unset_userdata('loyalty_rate');
        $this->session->unset_userdata('whatsapp_invoice_enable_status');
        $this->session->unset_userdata('register_content');
        $this->session->unset_userdata('printer_id');
        $this->session->unset_userdata('photo');
        $this->session->unset_userdata('language');
        $this->session->unset_userdata('zone_name');
        $this->session->unset_userdata('term_conditions');
        $this->session->unset_userdata('default_customer');
        $this->session->unset_userdata('default_payment');
        $this->session->unset_userdata('tax_is_gst');
        $this->session->unset_userdata('invoice_footer');
        $this->session->unset_userdata('invoice_logo');
        $this->session->unset_userdata('show_hide');
        $this->session->unset_userdata('allow_less_sale');
        $this->session->unset_userdata('is_collapse');
        $this->session->unset_userdata('direct_cart');
        $this->session->unset_userdata('website');
        $this->session->unset_userdata('direct_cart');
        $this->session->unset_userdata('installment_days');
        $this->session->unset_userdata('check_update_session');
        $this->session->unset_userdata('print_format');
        $this->session->unset_userdata('characters_per_line');
        $this->session->unset_userdata('printer_ip_address');
        $this->session->unset_userdata('printer_port');
        $this->session->unset_userdata('qr_code_type');
        $this->session->unset_userdata('invoice_print');
        $this->session->unset_userdata('fiscal_printer_status');
        $this->session->unset_userdata('open_cash_drawer_when_printing_invoice');
        $this->session->unset_userdata('print_server_url_invoice');
        $this->session->unset_userdata('inv_qr_code_status');
        $this->session->unset_userdata('user_is_saas');
        $this->session->unset_userdata('company_is_saas');
        $this->session->unset_userdata('invoice_configuration');
        $this->session->unset_userdata('inv_logo_is_show');
        $this->session->set_flashdata('exception', lang('logout_success'));
        redirect('Authentication/index');
    }



    /**
     * setting
     * @access public
     * @param int
     * @return void
     */

    public function setting($id = '') {
        $segment_2 = $this->uri->segment(2);
        $controller = "";
        $function = "";
        if($segment_2 == "Setting"){
            $controller = "1";
            $function = "edit";
        }else{
            $this->session->set_flashdata('exception_1',lang('no_access'));
            redirect('Authentication/userProfile');
        }
        if(!checkAccess($controller,$function)){
            $this->session->set_flashdata('exception_1',lang('no_access'));
            redirect('Authentication/userProfile');
        }
        $company_id = $this->session->userdata('company_id');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('date_format', lang('date_format'), "required|max_length[50]");
            $this->form_validation->set_rules('time_zone', lang('country_time_zone'), "required|max_length[50]");
            $this->form_validation->set_rules('currency',lang('currency'), "required|max_length[3]");
            if ($this->form_validation->run() == TRUE) {
                $org_information = array();
                $org_information['date_format'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('date_format')));
                $org_information['time_zone'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('time_zone')));
                $org_information['currency'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('currency')));
                $org_information['white_label_status'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('white_label_status')));
                $org_information['company_id'] = $this->session->userdata('company_id');
                $this->Common_model->updateInformation($org_information, $id, "tbl_companies");
                $this->session->set_flashdata('exception', lang('update_success'));
                //set session on update
                $this->session->set_userdata('currency', $org_information['currency']);
                $this->session->set_userdata('time_zone', $org_information['time_zone']);
                $this->session->set_userdata('date_format', $org_information['date_format']);
                redirect('Authentication/setting/'.$org_information['company_id']);
            } else {
                $data = array();
                $data['setting_information'] = $this->Authentication_model->getSettingInformation($company_id);
                $data['time_zones'] = $this->Common_model->getAllForDropdown("tbl_time_zone");
                $data['main_content'] = $this->load->view('authentication/setting', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        } else {
            $data = array();
            $data['setting_information'] = $this->Authentication_model->getSettingInformation($company_id);
            $data['time_zones'] = $this->Common_model->getAllForDropdown("tbl_time_zone");
            $data['main_content'] = $this->load->view('authentication/setting', $data, TRUE);
            $this->load->view('userHome', $data);
        }
    }



    /**
     * setlanguage
     * @access public
     * @param string
     * @return void
     */
    public function setlanguage($value=''){
        if($value==''){
            $value = $_POST['language'];
        }
        $id = $this->session->userdata('user_id');
        $language=$value;
        if ($language == "") {
            $language = "english";
        }
        if(!checkAvailableLang($value)){
            $language = "english";
        }
        $data['language']=$language;
        $this->session->set_userdata('language', $language);
        $this->db->WHERE('id',$id);
        $this->db->update('tbl_users',$data);
        redirect($_SERVER["HTTP_REFERER"]);
    }




    /**
     * databaseBackup
     * @access public
     * @param no
     * @return void
     */
    public function databaseBackup(){
        // Load the DB utility class
        $this->load->dbutil();
        // Backup your entire database and assign it to a variable
        $backup = $this->dbutil->backup();
        $file_name = date("Y_m_d_h_i_s")."_pos.sql.zip";
        // Load the file helper and write the file to your server
        $this->load->helper('file');
        write_file('database_backup/'.$file_name, $backup);
        // Load the download helper and send the file to your desktop
        $this->load->helper('download');
        force_download($file_name, $backup);
    }



    /**
     * customer_panel
     * @access public
     * @param no
     * @return void
     */
    public function customer_panel() {
       if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        $this->load->view('authentication/customer_panel');
    }



    /**
     * checkQTY
     * @access public
     * @param no
     * @return json
     */
    public function checkQTY() {
        $item_id = escape_output($_POST['item_id']);
        $total_stock = getCurrentStock($item_id);
        echo json_encode($total_stock);
    }

    /**
     * put_customer_panel_data
     * @access public
     * @param no
     * @return void
     */
    public function put_customer_panel_data() {
        $order_details = json_decode($this->input->post('order'));
        $data_main = array();
        $data_item_con = array();
        if(count($order_details->items) > 0){
            foreach($order_details->items as $item){
                $data_item = array();
                $data_item['item_name'] = $item->item_name;
                $data_item['item_qty'] =  $item->item_quantity;
                $data_item['item_price'] = $item->item_unit_price;
                $data_item['discount'] = $item->discount;
                $data_item['item_note'] = $item->item_note;
                $data_item['item_g_w'] = $item->item_g_w;
                $data_item['item_total_price_table'] = $item->item_total_price_table;
                $data_item_con[] = $data_item;
            }
        }
        $data_main['items'] =$data_item_con;
        $data_item_other = array();
        $data_item_other['total_item'] = trim_checker($order_details->total_items_in_cart);
        $data_item_other['total_sub_total'] = trim_checker($order_details->sub_total);;
        $data_item_other['total_discount'] = trim_checker($order_details->actual_discount);
        $data_item_other['sub_total_discount'] = trim_checker($order_details->sub_total_discount);
        $data_item_other['sub_total_discount_value'] = trim_checker($order_details->sub_total_discount_value);
        $data_item_other['total_discount_amount'] = trim_checker($order_details->total_discount_amount);
        $data_item_other['total_tax'] = trim_checker($order_details->total_vat);
        $data_item_other['total_charge'] = trim_checker($order_details->delivery_charge);
        $data_item_other['total_payable'] = trim_checker($order_details->total_payable);
        $data_main['others'] =$data_item_other;
        $user_id = $this->session->userdata('user_id');
        $fp = fopen("assets/c_display_jsons/cart_data_user_".$user_id.".json", 'w');
        fwrite($fp, json_encode($data_main));
        fclose($fp);
    }

    /**
     * customer_panel_data
     * @access public
     * @param no
     * @return json
     */
    public function customer_panel_data() {
        $user_id = $this->session->userdata('user_id');
        $str = file_get_contents("assets/c_display_jsons/cart_data_user_".$user_id.".json");
        $json_a = json_decode($str);
        $html = '';
        $reversedItems = array_reverse($json_a->items);
        foreach ($reversedItems as $value){
            $note = '';
            if($value->item_note){
                $note = "Note: $value->item_note";
            }
            $html.='<div class="single-item-wrap">
                        <div class="single-item">
                            <div class="item-name">
                                <span>'. $value->item_name .'</span>
                            </div>
                            <div class="item-price c-text-center">
                                <span>'. $value->item_price .'</span>
                            </div>
                            <div class="item-quantity c-text-center">
                                <span>'. $value->item_qty .'</span>
                            </div>
                            <div class="item-discount c-text-center">
                                <span>'. $value->discount .'</span>
                            </div>
                            <div class="item-subtotal c-text-right">
                                <span>'. $value->item_total_price_table .'</span>
                            </div>
                        </div>
                        <p class="item-note">'. $note .'</p>
                    </div>';
        }
        $return_arr ['items_html'] = $html;
        $return_arr['total_item'] = $json_a->others->total_item;
        $return_arr['total_sub_total'] = $json_a->others->total_sub_total;
        $return_arr['total_discount'] = $json_a->others->sub_total_discount_value;
        $return_arr['total_tax'] = $json_a->others->total_tax;
        $return_arr['total_discount_amount'] = $json_a->others->total_discount_amount;
        $return_arr['total_charge'] = $json_a->others->total_charge;
        $return_arr['total_payable'] = $json_a->others->total_payable;
        echo json_encode($return_arr);
    }


    /**
     * is_online
     * @access public
     * @param no
     * @return string
     */
    public function is_online(){
        echo "Success";
    }

    /**
     * get_prom_details
     * @access public
     * @param no
     * @return string
     */
    public function get_prom_details() {
        $data = getTodayPromoDetails();
        $html = '';
        foreach ($data as $value){
            if($value->type==1){
                $html .='<div class="promo-single-item">
                            <div class="promo-item-d">
                                <p>'.$value->title.'</p>
                            </div>
                            <div class="promo-item-d">
                                <p>'.escape_output($value->type==1?'Discount':'Free Item').'</p>
                            </div>
                            <div class="promo-item-d">
                                <p>'.getFoodMenuNameById($value->food_menu_id)."(".getFoodMenuCodeById($value->food_menu_id).")".'</p>
                            </div>
                            <div class="promo-item-d">
                                <p>'.(getDiscountSymbol($value->discount)).(isset($value->discount) && $value->discount?$value->discount:0).'</p>
                            </div>
                        </div>';
            }else{
                $html .='<div class="promo-single-item">
                    <div class="promo-item-d">
                        <p>'.escape_output($value->title).'</p>
                    </div>
                    <div class="promo-item-d">
                        <p>'.escape_output($value->type==1?'Discount':'Free Item').'</p>
                    </div>
                    <div class="promo-item-d">
                        <p>'."<b>Buy: </b>".getFoodMenuNameById($value->food_menu_id)."(".getFoodMenuCodeById($value->food_menu_id).") - ".$value->qty."(qty) <br><b>Get: </b>".getFoodMenuNameById($value->get_food_menu_id)."(".getFoodMenuCodeById($value->get_food_menu_id).") - ".$value->get_qty."(qty)".'</p>
                    </div>
                    <div class="promo-item-d">
                        <p>-</p>
                    </div>
                </div>';
            }
        }
        echo json_encode($html);
    }





    /**
     * qr_code_invoice
     * @access public
     * @param int
     * @return void
     */
    public function qr_code_invoice($code){
        if(isset($code) && $code){
            $data['sale_object'] = $this->getSaleDetailsByCode($code);
            $data['customer_info'] = $this->Common_model->getCustomerById($data['sale_object']->customer_id);
            $data['outlet_info'] = $this->Common_model->getDataById($data['sale_object']->outlet_id, 'tbl_outlets');
            $data['company_info'] = $this->Common_model->getDataById($data['sale_object']->company_id, 'tbl_companies');
            $this->session->set_userdata('company_id', $data['sale_object']->company_id);
            $this->load->view('sale/qr_code_view',$data);
        }else{
            echo '<h1 class="red text-center mt-10-per">' . lang('Your_scanned') . lang('QR_code_is_not_valid') . '</h1>';
        }
    }

    /**
     * getSaleDetailsByCode
     * @access public
     * @param int
     * @return string
     */
    function getSaleDetailsByCode($code){
        $sales_information = $this->Sale_model->getSaleBySaleCode($code);
        $items_by_sales_id = $this->Sale_model->getAllItemsFromSalesDetailBySalesId($sales_information[0]->sales_id);
        $sales_details_objects = $items_by_sales_id;
        $sale_object = $sales_information[0];
        $sale_object->items = $sales_details_objects;
        return $sale_object;
    }


    /**
     * checkInOut
     * @access public
     * @param no
     * @return void
     */
    public function checkInOut() {
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        $user_id = $this->session->userdata('user_id');
        $data = array();
        $data['attendances'] = $this->db->query("select * from tbl_attendance where employee_id=$user_id and del_status='Live' order by id desc")->result();
        $data['main_content'] = $this->load->view('authentication/check_in_out', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    /**
     * checkOut
     * @access public
     * @param no
     * @return void
     */
    public function checkOut()
    {
        $user_id = $this->session->userdata('user_id');
        $attendance = getAttendance($user_id);
        if($attendance){
            $information = array();
            $information['out_time'] = date('Y-m-d H:i:s');
            $information['is_closed'] = 2;
            $this->Common_model->updateInformation($information, $attendance->id, "tbl_attendance");
        }
        $this->session->set_flashdata('exception', lang('insertion_success_checkout'));
        redirect('authentication/checkInOut');
    }


    /**
     * checkIn
     * @access public
     * @param no
     * @return void
     */
    public function checkIn()
    {
        $user_id = $this->session->userdata('user_id');
        $information = array();
        $information['reference_no'] = $this->Attendance_model->generateReferenceNo();
        $information['date'] = date("Y-m-d", strtotime('today'));
        $information['employee_id'] = $user_id;
        $information['in_time'] = date('Y-m-d H:i:s');
        $information['out_time'] = '';
        $information['note'] = "--";
        $information['is_closed'] = 1;
        $information['user_id'] = $this->session->userdata('user_id');
        $information['company_id'] = $this->session->userdata('company_id');
        $this->Common_model->insertInformation($information, "tbl_attendance");
        $this->session->set_flashdata('exception', lang('insertion_success_checkin'));
        redirect('authentication/checkInOut');
    }


    /**
     * checkAccess
     * @access public
     * @param no
     * @return json
     */
    public function checkAccess(){
        $controller = $_GET['controller'];
        $function = $_GET['function'];
        echo json_encode(checkAccess($controller,$function));
    }



    // Print Server
    public function callPrintServer(){
        $sale_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('sale_id')));
        if($sale_id){
            $sale_id = $this->custom->encrypt_decrypt($sale_id, 'decrypt');
            $sale = $this->Common_model->getDataById($sale_id, "tbl_sales");
            $company_id = $this->session->userdata('company_id');
            $outlet_id = $this->session->userdata('outlet_id');
            $print_server_url_invoice = $this->session->userdata('print_server_url_invoice');
            $printer_id = $this->session->userdata('printer_id');
            $open_cash_drawer = $this->session->userdata('open_cash_drawer');
            $company = $this->Common_model->getDataById($company_id, "tbl_companies");
            $outlet = $this->Common_model->getDataById($outlet_id, "tbl_outlets");
            if(isset($printer_id) && $printer_id){
                $data = array();
                $data['print_type'] = "invoice";
                $data['logo'] = $company->invoice_logo;
                $data['open_cash_drawer_when_printing_invoice'] = $open_cash_drawer;
                $data['store_name'] = $outlet->outlet_name;
                $data['address'] = $outlet->address;
                $data['phone'] = $outlet->phone;
                $data['collect_tax'] = $company->collect_tax;
                $data['tax_title'] = $company->tax_title;
                $data['tax_registration_no'] = $company->tax_registration_no;
                $data['invoice_footer'] = $company->invoice_footer;
                //printer config
                $printer = getPrinterInfo(isset($printer_id) && $printer_id?$printer_id:'');
                $data['type'] = $printer->type;
                $data['printer_ip_address'] = $printer->printer_ip_address;
                $data['printer_port'] = $printer->printer_port;
                $data['path'] = $printer->path;
                $data['open_cash_drawer_when_printing_invoice'] = $printer->open_cash_drawer_when_printing_invoice;
                $data['characters_per_line'] = $printer->characters_per_line;
                $data['profile_'] = $printer->profile_;
                $data['date'] = date($company->date_format, strtotime($sale->sale_date));
                $data['time_inv'] = date('h:i A',strtotime($sale->order_time));
                $data['random_code'] = base_url()."invoice/".$sale->random_code;

                $data['sales_associate'] = userName($sale->user_id);
                //added_by_Zakir
                $customer_details = getCustomerData($sale->customer_id);
                //end;
                $data['customer_name'] = (isset($customer_details->name) && $customer_details->name?$customer_details->name:'---');
                $data['customer_address'] = '';

                if(isset($customer_details->address) &&  $customer_details->address!=NULL  && $customer_details->address!=""){
                    $data['customer_address'] = (isset($customer_details->address) && $customer_details->address?$customer_details->address:'---');
                }
                $data['gst_number'] = '';
                if(isset($customer_details->gst_number) &&  $customer_details->gst_number!=NULL  && $customer_details->gst_number!=""){
                    $data['gst_number'] = (isset($customer_details->gst_number) && $customer_details->address?$customer_details->gst_number:'');
                }

                $items = "\n";

                $count  = 1;
                $totalItems = 0;
                $items_object = $this->Common_model->getItemDetailsDataById($sale_id, "sales_id", "tbl_sales_details");
                foreach($items_object as $r=>$value){
                    $totalItems++;
                    $menu_unit_price = getAmtP($value->menu_unit_price);
                    $items .= printText(("#".$count." ".(getItemNameCodeById($value->food_menu_id ))), $printer->characters_per_line)."\n";
                    $items .= printLine("   ".($value->qty." x ".$menu_unit_price. ":  ". ((getAmt($value->menu_price_with_discount)))), $printer->characters_per_line, ' ')."\n";
                    $count++;
                }

                $data['sale_no_p'] = $sale->sale_no;
                $data['date_format_p'] = $company->date_format;;
                $data['items'] = $items;
                $totals = "";
                $totals.= printLine("".lang("Total_Item_s"). ": " .  $totalItems, $printer->characters_per_line)."\n";
                if($sale->sub_total && $sale->sub_total!="0.00"):
                    $totals.= printLine(lang("sub_total"). ": " .(getAmt($sale->sub_total)), $printer->characters_per_line)."\n";
                endif;
                if($sale->total_discount_amount && $sale->total_discount_amount!="0.00"):
                    $totals.= printLine(lang("Disc_Amt_p"). ": " .(getAmt($sale->total_discount_amount)), $printer->characters_per_line)."\n";
                endif;

                if($sale->delivery_charge && $sale->delivery_charge!="0.00"):
                    $totals.= printLine(lang("charge"). ": " .($sale->delivery_charge).($sale->charge_type), $printer->characters_per_line)."\n";
                endif;


                if ($company->collect_tax=='Yes' && ($sale->sale_vat_objects!=NULL)):
                    $tax = '';
                    if($sale->sale_vat_objects != ''){
                        $tax = json_decode($sale->sale_vat_objects);
                    }

                    if($tax) {
                        $i = 0;
                        foreach($tax as $t){

                            if(setReadonly(5,$t->tax_field_type)):
                                if ($t->tax_field_amount && $t->tax_field_amount != "0.00"):
                                    $totals .= printLine(" " . ($t->tax_field_type) . ":  " . (getAmt($t->tax_field_amount)), $printer->characters_per_line, ' ') . "\n";
                                endif;
                            endif;
                        }
                    }
                endif;
                if($sale->rounding && $sale->rounding!="0.00"):
                    $totals.= printLine(lang("rounding"). ": " .(getAmt($sale->rounding)), $printer->characters_per_line)."\n";
                endif;
                if($sale->total_payable && $sale->total_payable!="0.00"):
                    $totals.= printLine(lang("total_payable"). ": " .(getAmt($sale->total_payable)), $printer->characters_per_line)."\n";
                endif;
                if($sale->paid_amount && $sale->paid_amount!="0.00"):
                    $totals.= printLine(lang("paid_amount"). ": " .(getAmt($sale->paid_amount)), $printer->characters_per_line)."\n";
                endif;

                if($sale->due_amount && $sale->due_amount!="0.00"):
                    $totals.= printLine(lang("due_amount"). ": " .(getAmt($sale->due_amount)), $printer->characters_per_line)."\n";
                endif;

                $data['totals'] = $totals;
                //payment details
                $payments = "";
                $salePaymentDetails = salePaymentDetails($sale->id,$outlet_id);
                if(isset($salePaymentDetails) && $salePaymentDetails):
                    foreach($salePaymentDetails as $p_name):
                        $payments .= printLine(($p_name->payment_name) . ":  ".($p_name->amount), $printer->characters_per_line, ' ') . "\n";
                    endforeach;
                endif;

                 $data['payments'] = $payments;
                 $return_data['printer_server_url'] = getIPv4WithFormat($print_server_url_invoice);
                 $return_data['content_data'] = $data;
                 $return_data['print_type'] = "Invoice";
                 echo json_encode($return_data);
            }

        }
    }




    /**
     * logingPage
     * @access public
     * @param int
     * @return void
     */
    public function logingPage($id = '') {
        $company_id = $this->session->userdata('company_id');

        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('title', lang('title'), 'required|max_length[40]');
            $this->form_validation->set_rules('short_description', lang('short_description'), 'required|max_length[125]');
            if ($this->form_validation->run() == TRUE) {
                $loginArr = array();
                $loginArr['title'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('title')));
                $loginArr['short_description'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('short_description')));
                // Base64 Image Convert Into Image
                if($_POST['login_page_img'] != ''){
                    //generate png files from base_64 data
                    $data = escape_output($_POST['login_page_img']);
                    list($type, $data) = explode(';', $data);
                    list(, $data)      = explode(',', $data);
                    $data = base64_decode($data);
                    $imageName = time().'.png';
                    createDirectory('uploads/site_settings');
                    file_put_contents('uploads/site_settings/'.$imageName, $data);
                    $media_path = $imageName;
                    $this->session->set_userdata('login_page_img', $media_path);
                    $loginArr['login_page_img'] = htmlspecialcharscustom($media_path);
                }else{
                    $loginArr['login_page_img'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('login_page_img_old')));
                }

                $return['login_page']  = json_encode($loginArr);
                $this->Common_model->updateInformation($return, $company_id, "tbl_companies");
                $this->session->set_flashdata('exception', lang('update_success'));
                $this->session->set_userdata($loginArr);
                //update for progressive app.
                updateAppInfo();
                redirect('Authentication/logingPage');
            } else {
                $data = array();
                $data['company_information'] = $this->Common_model->getDataById($company_id, "tbl_companies");
                $data['main_content'] = $this->load->view('shop_setting/login-page-dynamic', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        } else {
            $data = array();
            $data['company_information'] = $this->Common_model->getDataById($company_id, "tbl_companies");
            $data['main_content'] = $this->load->view('shop_setting/login-page-dynamic', $data, TRUE);
            $this->load->view('userHome', $data);
        }
    }


    /**
     * payment
     * @access public
     * @param int
     * @return void
     */
    public function payment($company_id='') {
        $company_dec_id = $this->custom->encrypt_decrypt($company_id, 'decrypt');
        $company_info = $this->Common_model->getDataById($company_dec_id, 'tbl_companies');
        $data['company_info'] = $company_info;
        $data['plan_details'] = $this->Common_model->getDataById($company_info->plan_id, 'tbl_pricing_plans');
        $this->load->view('saas/onetime_payment', $data);
    }

}