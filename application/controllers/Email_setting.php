<?php
/*
    ###########################################################
    # PRODUCT NAME:   Off POS
    ###########################################################
    # AUTHER:   Door Soft
    ###########################################################
    # EMAIL:   info@doorsoft.co
    ###########################################################
    # COPYRIGHTS:   RESERVED BY Door Soft
    ###########################################################
    # WEBSITE:   https://www.doorsoft.co
    ###########################################################
    # This is Email_setting Controller
    ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Email_setting extends Cl_Controller {
    /**
     * load constructor
     * @access public
     * @return void
     */    
    public function __construct() {
        parent::__construct();
        $this->load->model('Authentication_model');
        $this->load->model('Common_model');
        $this->load->model('Outlet_model');
        $this->load->library('form_validation');
        $this->Common_model->setDefaultTimezone();
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $controller = "10";
        $function = "";
        if(($segment_2 == "emailConfiguration") || ($segment_2 == "emailSetting") || ($segment_2 == 'sendEmail' && $segment_3 == 'test') || ($segment_2 == 'sendEmail' && $segment_3 == 'birthday') || ($segment_2 == 'sendEmail' && $segment_3 == 'anniversary') || ($segment_2 == 'sendEmail' && $segment_3 == 'custom') || $segment_2 == "emailService"){
            $function = "edit";
        }else{
            $this->session->set_flashdata('exception_1',lang('no_access'));
            redirect('Authentication/userProfile');
        }
        if(!checkAccess($controller,$function)){
            $this->session->set_flashdata('exception_1',lang('no_access'));
            redirect('Authentication/userProfile');
        }
    }

    /**
     * emailConfiguration
     * @access public
     * @param no
     * @return void
     */
    public function emailConfiguration(){
        $data = array();
        $data['main_content'] = $this->load->view('email_setting/email_configure', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    /**
     * emailSetting
     * @access public
     * @param int
     * @return void
     */
    public function emailSetting($id = '') {
        $id = $this->session->userdata('company_id');
        if ($this->input->post('submit')) {
            $enable_status  = htmlspecialcharscustom($this->input->post('enable_status'));
            $smtp_type  = htmlspecialcharscustom($this->input->post('smtp_type'));
            if($enable_status=="Enable"){
                $this->form_validation->set_rules('smtp_type', lang('send_invoice_email'), "required");
                $this->form_validation->set_rules('host_name', lang('SMTPHost'), "required");
                $this->form_validation->set_rules('port_address', lang('PortAddress'), "required");
                $this->form_validation->set_rules('user_name', lang('Username'), "required");
                $this->form_validation->set_rules('password', lang('Password'), "required");
                if($smtp_type == "Sendinblue"){
                    $this->form_validation->set_rules('api_key', lang('api_key'), "required");
                }
                $this->form_validation->set_rules('encryption', lang('encryption'), "required");
                $this->form_validation->set_rules('from_name', lang('from_name'), "required");
                $this->form_validation->set_rules('from_email', lang('from_email'), "required");
                if ($this->form_validation->run() == TRUE) {
                    $data = array();
                    $data['host_name']  = htmlspecialcharscustom($this->input->post('host_name'));
                    $data['port_address']  = htmlspecialcharscustom($this->input->post('port_address'));
                    $data['encryption']  = htmlspecialcharscustom($this->input->post('encryption'));
                    $data['user_name']  = htmlspecialcharscustom($this->input->post('user_name'));
                    $data['password']  = htmlspecialcharscustom($this->input->post('password'));
                    $data['from_name']  = htmlspecialcharscustom($this->input->post('from_name'));
                    $data['from_email']  = htmlspecialcharscustom($this->input->post('from_email'));
                    if($smtp_type == "Sendinblue"){
                        $data['api_key']  = htmlspecialcharscustom($this->input->post('api_key'));
                    }else{
                        $data['api_key'] = "";
                    }
                    $data_payment_setting['smtp_details'] = json_encode($data);
                    $data_payment_setting['smtp_enable_status']  = htmlspecialcharscustom($this->input->post('smtp_enable_status'));
                    $data_payment_setting['smtp_type']  = htmlspecialcharscustom($this->input->post('smtp_type'));
                    $this->Common_model->updateInformation($data_payment_setting, $id, "tbl_companies");
                    $this->session->set_flashdata('exception', lang('update_success'));
                    redirect('Email_setting/emailSetting');
                }else{
                    $data = array();
                    $data['main_content'] = $this->load->view('shop_setting/emailSetting', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }else{
                $data = array();
                $data['host_name']  = htmlspecialcharscustom($this->input->post('host_name'));
                $data['port_address']  = htmlspecialcharscustom($this->input->post('port_address'));
                $data['encryption']  = htmlspecialcharscustom($this->input->post('encryption'));
                $data['user_name']  = htmlspecialcharscustom($this->input->post('user_name'));
                $data['password']  = htmlspecialcharscustom($this->input->post('password'));
                $data['from_name']  = htmlspecialcharscustom($this->input->post('from_name'));
                $data['from_email']  = htmlspecialcharscustom($this->input->post('from_email'));
                if($smtp_type == "Sendinblue"){
                    $data['api_key']  = htmlspecialcharscustom($this->input->post('api_key'));
                }else{
                    $data['api_key'] = "";
                }
                $data_payment_setting['smtp_details'] = json_encode($data);
                $data_payment_setting['smtp_enable_status']  = htmlspecialcharscustom($this->input->post('smtp_enable_status'));
                $data_payment_setting['smtp_type']  = htmlspecialcharscustom($this->input->post('smtp_type'));
                $this->Common_model->updateInformation($data_payment_setting, $id, "tbl_companies");
                $this->session->set_flashdata('exception', lang('update_success'));
                redirect('Email_setting/emailSetting');
            }
        } else {
            $data = array();
            $data['main_content'] = $this->load->view('shop_setting/emailSetting', $data, TRUE);
            $this->load->view('userHome', $data);
        }
    }

    

    /**
     * sendEmail
     * @access public
     * @param string
     * @return void
     */
    public function sendEmail($type=''){
        $business_name = ($this->session->userdata('business_name'));
        $company_id = $this->session->userdata('company_id');
        $company = getCompanySMTPAndStatus($company_id);
        if (!($company->smtp_enable_status)) {
            $this->session->set_flashdata('exception_2', lang('your_smtp_not_configure'));
            redirect('Email_setting/emailService');
        }
        $data = array(); 
        $data['type'] = $type;
        $data['balance'] = 0;
        $today = date('Y-m-d');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('message', lang('message'), 'required|max_length[200]');
            if ($type == "test") {
                $this->form_validation->set_rules('email',lang('email'), 'required|max_length[50]'); 
            }
            if ($this->form_validation->run() == TRUE) { 
                $emails = $this->input->post($this->security->xss_clean('email'));  
                $message = $this->input->post($this->security->xss_clean('message')); 
                if ($type == 'test') {
                    try {
                        $mail_data = [];
                        $mail_data['to'] = ["$emails"];
                        $mail_data['subject'] = "Hello Message";
                        $mail_data['message'] = $message;
                        $mail_data['template'] = $this->load->view('mail-template/test-mail-template', $mail_data, TRUE);
                        if($company->smtp_enable_status == 1){
                            if($company->smtp_type == "Sendinblue"){
                                sendInBlue($mail_data);
                            }else{
                                sendEmailOnly($mail_data['subject'],$mail_data['template'],$emails);
                            }
                            $this->session->set_flashdata('exception', lang('Email_Sent_Success'));
                        }else{
                            $this->session->set_flashdata('exception_1', lang('your_smtp_not_configured'));
                        }
                    } catch (Exception $e) {
                        die('Error: ' . $e->getMessage());
                    }
                }else{ 
                    if ($type == 'birthday') {
                        $email_count =  $this->db->query("SELECT name,phone,email  from tbl_customers where `date_of_birth`='". $today."' AND company_id = $company_id")->result();
                        if($email_count){
                            foreach($email_count as $email){
                                if($email->email){
                                    $mail_data = [];
                                    $mail_data['to'] = ["$email->email"];
                                    $mail_data['subject'] = "Special offer for your birthday!!";
                                    $mail_data['message'] = $message;
                                    $mail_data['customer_name'] = $email->name;
                                    $mail_data['template'] = $this->load->view('mail-template/birthday-mail-template', $mail_data, TRUE);
                                    if($company->smtp_type == "Sendinblue"){
                                        sendInBlue($mail_data);
                                    }else{
                                        sendEmailOnly($mail_data['subject'],$mail_data['template'], $email->email);
                                    }
                                }
                            }
                            $this->session->set_flashdata('exception', lang('Email_Sent_Success'));
                        }else{
                            $this->session->set_flashdata('exception_2', lang('no_customer_birthday_found_with_valid_email'));
                        }
                    }elseif ($type =='anniversary') {
                        $email_count=  $this->db->query("SELECT name,phone,email from tbl_customers where `date_of_anniversary`='". $today."' AND company_id = $company_id")->result();
                        if($email_count){
                            foreach($email_count as $email){
                                if($email->email){
                                    $mail_data = [];
                                    $mail_data['to'] = ["$email->email"];
                                    $mail_data['subject'] = "Special offer for your anniversary!!";
                                    $mail_data['message'] = $message;
                                    $mail_data['customer_name'] = $email->name;
                                    $mail_data['template'] = $this->load->view('mail-template/anniversary-mail-template', $mail_data, TRUE);
                                    if($company->smtp_type == "Sendinblue"){
                                        sendInBlue($mail_data);
                                    }else{
                                        sendEmailOnly($mail_data['subject'],$mail_data['template'], $email->email);
                                    }
                                }
                            }
                            $this->session->set_flashdata('exception', lang('Email_Sent_Success'));
                        }else{
                            $this->session->set_flashdata('exception_2', lang('no_customer_anniversary_found_with_valid_email'));
                        }
                    }elseif ($type =='custom') {
                        $email_count=  $this->db->query("SELECT name,phone,email from tbl_customers where company_id = $company_id")->result();
                        if($email_count){
                            foreach($email_count as $email){
                                if($email->email){
                                    $mail_data = [];
                                    $mail_data['to'] = ["$email->email"];
                                    $mail_data['subject'] = "Special offer for today!!";
                                    $mail_data['message'] = $message;
                                    $mail_data['customer_name'] = $email->name;
                                    $mail_data['template'] = $this->load->view('mail-template/bulk_email_to_customer', $mail_data, TRUE);
                                    if($company->smtp_type == "Sendinblue"){
                                        sendInBlue($mail_data);
                                    }else{
                                        sendEmailOnly($mail_data['subject'],$mail_data['template'], $email->email);
                                    }
                                }
                            }
                            $this->session->set_flashdata('exception', lang('Email_Sent_Success'));
                        }else{
                            $this->session->set_flashdata('exception_2', lang('no_customer_found_with_valid_email'));
                        }
                    }  
                    if (empty($email_count)) {
                        redirect('Email_setting/emailService');
                    }
                } 
                redirect('Email_setting/emailService');
            } else {
                $day = '';
                $outlet_name = $this->session->userdata('outlet_name');
                if ($type == 'birthday') {
                    $day = "Birthday";
                }elseif ($type =='anniversary') {
                    $day = "Anniversary";
                }
                if ($type == 'birthday' || $type == 'anniversary') {
                    $data['message'] = "Wishing you Happy $day from $business_name. Please come to our shop and enjoy discount in your special day.";
                }else{
                    $data['message'] = "";
                }
                $data['outlet_name'] = $outlet_name;
                $today = date('Y-m-d');
                if ($type == 'birthday') {
                    $data['email_count'] = $this->db->query("select * from tbl_customers where `date_of_birth`='". $today."' AND company_id = $company_id")->result();
                }elseif ($type =='anniversary') {
                    $data['email_count'] = $this->db->query("select * from tbl_customers where `date_of_anniversary`='". $today."' AND company_id = $company_id")->result();
                }elseif($type =='customAll'){
                    $data['email_count'] = $this->db->query("select * from tbl_customers where company_id = $company_id")->result();
                }
                if ($type == 'balance') {
                    $data['main_content'] = $this->load->view('shortMessageService/checkBalance', $data, TRUE);
                }else{
                    $data['main_content'] = $this->load->view('email_setting/send_email', $data, TRUE);
                }
                $this->load->view('userHome', $data);
            }
        }else{
            $day = '';
            $outlet_name = $this->session->userdata('outlet_name');
            if ($type == 'birthday') {
                $day = "Birthday";
            }elseif ($type =='anniversary') {
                $day = "Anniversary";
            }  
            if ($type == 'birthday' || $type == 'anniversary') {
                $data['message'] = "Wishing you Happy $day from $business_name. Please come to our shop and enjoy discount in your special day.";
            }else{
                $data['message'] = "";
            } 
            $data['outlet_name'] = $outlet_name;
            $today = date('Y-m-d');
            if ($type == 'birthday') {
                $data['email_count'] = $this->db->query("select * from tbl_customers where `date_of_birth`='". $today."' AND company_id = $company_id")->result();
            }elseif ($type =='anniversary') {
                $data['email_count'] = $this->db->query("select * from tbl_customers where `date_of_anniversary`='". $today."' AND company_id = $company_id")->result();
            }elseif($type =='customAll'){
                $data['email_count'] = $this->db->query("select * from tbl_customers where company_id = $company_id")->result();
            }    
            if ($type == 'balance') {
                $data['main_content'] = $this->load->view('shortMessageService/checkBalance', $data, TRUE); 
            }else{ 
                $data['main_content'] = $this->load->view('email_setting/send_email', $data, TRUE);
            } 
            $this->load->view('userHome', $data); 
        }
    } 


    /**
     * emailService
     * @access public
     * @param no
     * @return void
     */
    public function emailService(){
        $data = array();
        $data['main_content'] = $this->load->view('email_setting/email_configure', $data, TRUE);
        $this->load->view('userHome', $data);
    }
}
