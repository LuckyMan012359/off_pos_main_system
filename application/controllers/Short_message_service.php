<?php
/*
    ###########################################################
    # PRODUCT NAME:   Off POS
    ###########################################################
    # AUTHER:   Doorsoft
    ###########################################################
    # EMAIL:   info@doorsoft.co
    ###########################################################
    # COPYRIGHTS:   RESERVED BY Door Soft
    ###########################################################
    # WEBSITE:   https://www.doorsoft.co
    ###########################################################
    # This is Short_message_service Controller
    ###########################################################
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Short_message_service extends Cl_Controller {


    /**
     * load constructor
     * @access public
     * @return void
     */   
    public function __construct() {
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->model('Authentication_model');
        $this->load->library('form_validation');
        $this->Common_model->setDefaultTimezone();
        $this->load->library('setupfile');
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $controller = "12";
        $function = "";
        if(($segment_2 == "smsService") || ($segment_2 == "SMSSetting") || ($segment_2 == 'sendSMS' && $segment_3 == 'test') || ($segment_2 == 'sendSMS' && $segment_3 == 'birthday') || ($segment_2 == 'sendSMS' && $segment_3 == 'anniversary') || ($segment_2 == 'sendSMS' && $segment_3 == 'custom') || $segment_2 == "send"){
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
     * send
     * @access public
     * @param no
     * @return void
     */
    public function send(){
        $this->setupfile->send("8801812391633", "Hello there this is message");
    }

    /**
     * smsService
     * @access public
     * @param no
     * @return void
     */
    public function smsService(){
        $data = array();
        $data['main_content'] = $this->load->view('shortMessageService/smsService', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    /**
     * sendSMS
     * @access public
     * @param string
     * @return void
     */
    public function sendSMS($type=''){
        $business_name = ($this->session->userdata('business_name'));
        $company_id = $this->session->userdata('company_id');
        $company = getCompanySMSAndStatus($company_id);
        if ($company->sms_enable_status == '2') {
            $this->session->set_flashdata('exception_2', 'Please configure SMS first');
            redirect('Short_message_service/smsService');
        }

        $data = array(); 
        $data['type'] = $type;
        $data['balance'] = 0;
        $today = date('Y-m-d');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('message', lang('message'), 'required|max_length[200]');
            if ($type == "test") {
                $this->form_validation->set_rules('number',lang('number'), 'required|max_length[50]'); 
            }
            if ($this->form_validation->run() == TRUE) { 
                $message = $this->input->post($this->security->xss_clean('message')); 
                $numbers = $this->input->post($this->security->xss_clean('number'));  
                if ($type == 'test') {
                    try {
                        smsSendOnly($message,$numbers);
                        $this->session->set_flashdata('exception', lang('SMS_Sent_Success'));
                    } catch (Exception $e) {
                        die('Error: ' . $e->getMessage());
                    }
                }else{ 
                    if ($type == 'birthday') {
                        $sms_count=  $this->db->query("SELECT name,phone from tbl_customers where `date_of_birth`='". $today."' AND company_id = $company_id")->result();
                        if($sms_count){
                            foreach($sms_count as $sms){
                                smsSendOnly($message,$sms->phone);
                            }
                            $this->session->set_flashdata('exception', lang('SMS_Sent_Success'));
                        }else{
                            $this->session->set_flashdata('exception_2', lang('no_customer_birthday_found_with_valid_number'));
                        }
                    }elseif ($type =='anniversary') {
                        $sms_count=  $this->db->query("SELECT name,phone from tbl_customers where `date_of_anniversary`='". $today."' AND company_id = $company_id")->result();
                        if($sms_count){
                            foreach($sms_count as $sms){
                                smsSendOnly($message,$sms->phone);
                            }
                            $this->session->set_flashdata('exception', lang('SMS_Sent_Success'));
                        }else{
                            $this->session->set_flashdata('exception_2', lang('no_customer_anniversary_found_with_valid_number'));
                        }
                    }elseif ($type =='customAll') {
                        $sms_count=  $this->db->query("select * from tbl_customers where company_id = $company_id")->result();
                        if($sms_count){
                            foreach($sms_count as $sms){
                                smsSendOnly($message,$sms->phone);
                            }
                            $this->session->set_flashdata('exception', lang('SMS_Sent_Success'));
                        }else{
                            $this->session->set_flashdata('exception_2', lang('no_customer_found_with_valid_number'));
                        }
                    }  
                    if (empty($sms_count)) {
                        redirect('Short_message_service/smsService');
                    }
                } 
                redirect('Short_message_service/smsService');
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
                    $data['sms_count'] = $this->db->query("select * from tbl_customers where `date_of_birth`='". $today."' AND company_id = $company_id")->result();
                }elseif ($type =='anniversary') {
                    $data['sms_count'] = $this->db->query("select * from tbl_customers where `date_of_anniversary`='". $today."' AND company_id = $company_id")->result();
                }elseif($type =='customAll'){
                    $data['sms_count'] = $this->db->query("select * from tbl_customers where company_id = $company_id")->result();
                }
                if ($type == 'balance') {
                    $data['main_content'] = $this->load->view('shortMessageService/checkBalance', $data, TRUE);
                }else{
                    $data['main_content'] = $this->load->view('shortMessageService/sendSMS', $data, TRUE);
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
                $data['sms_count'] = $this->db->query("select * from tbl_customers where `date_of_birth`='". $today."' AND company_id = $company_id")->result();
            }elseif ($type =='anniversary') {
                $data['sms_count'] = $this->db->query("select * from tbl_customers where `date_of_anniversary`='". $today."' AND company_id = $company_id")->result();
            }elseif($type =='customAll'){
                $data['sms_count'] = $this->db->query("select * from tbl_customers where company_id = $company_id")->result();
            }    
            if ($type == 'balance') {
                $data['main_content'] = $this->load->view('shortMessageService/checkBalance', $data, TRUE); 
            }else{ 
                $data['main_content'] = $this->load->view('shortMessageService/sendSMS', $data, TRUE);
            } 
            $this->load->view('userHome', $data); 
        }
    } 


    /**
     * SMSSetting
     * @access public
     * @param int
     * @return void
     */
    public function SMSSetting($encrypted_id='') {
        $company_id = $this->session->userdata('company_id');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('sms_service_provider',lang('sms_service_provider'), "max_length[50]");
            $this->form_validation->set_rules('sms_enable_status',lang('send_invoice_sms'), "required|max_length[10]");
            $sms_service_provider = htmlspecialcharscustom($this->input->post($this->security->xss_clean('sms_service_provider')));
            if($sms_service_provider==1){
                $this->form_validation->set_rules('field_1_0',lang('SID'), "required|max_length[250]");
                $this->form_validation->set_rules('field_1_1',lang('Token'), "required|max_length[250]");
                $this->form_validation->set_rules('field_1_2',lang('Twilio_Number'), "required|max_length[250]");
            }else if($sms_service_provider==2){
                $this->form_validation->set_rules('field_2_0',lang('profile_id'), "required|max_length[250]");
                $this->form_validation->set_rules('field_2_1',lang('password'), "required|max_length[250]");
                $this->form_validation->set_rules('field_2_2',lang('sender_id'), "required|max_length[250]");
                $this->form_validation->set_rules('field_2_3',lang('country_code'), "required|max_length[250]");
            }else if($sms_service_provider==3){
                $this->form_validation->set_rules('field_3_1',lang('api_key'), "required|max_length[250]");
                $this->form_validation->set_rules('field_3_2',lang('sender_id'), "required|max_length[250]");
            }else if($sms_service_provider==4){
                $this->form_validation->set_rules('field_4_0',lang('profile_id'), "required|max_length[250]");
                $this->form_validation->set_rules('field_4_1',lang('api_key'), "required|max_length[250]");
                $this->form_validation->set_rules('field_4_2',lang('sender_id'), "required|max_length[250]");
            }
            if ($this->form_validation->run() == TRUE) {
                $sms_info_json = array();
                $sms_info_json['field_1_0'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('field_1_0')));
                $sms_info_json['field_1_1'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('field_1_1')));
                $sms_info_json['field_1_2'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('field_1_2')));
                $sms_info_json['field_2_0'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('field_2_0')));
                $sms_info_json['field_2_1'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('field_2_1')));
                $sms_info_json['field_2_2'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('field_2_2')));
                $sms_info_json['field_2_3'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('field_2_3')));
                $sms_info_json['field_3_0'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('field_3_0')));
                $sms_info_json['field_3_1'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('field_3_1')));
                $sms_info_json['field_3_2'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('field_3_2')));
                $sms_info_json['field_4_0'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('field_4_0')));
                $sms_info_json['field_4_1'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('field_4_1')));
                $sms_info_json['field_4_2'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('field_4_2')));
                $sms_info = array();
                $sms_info['sms_service_provider'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('sms_service_provider')));
                $sms_info['sms_enable_status'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('sms_enable_status')));
                $sms_info['sms_details'] = json_encode($sms_info_json);
                $this->Common_model->updateInformation($sms_info, $company_id, "tbl_companies");
                $this->session->set_flashdata('exception', lang('update_success'));
                redirect('Short_message_service/SMSSetting');
            } else {
                $data = array();
                $data['sms_information'] = $this->Authentication_model->getSMSInformation($company_id);
                $data['company_id'] = ($company_id);
                $data['main_content'] = $this->load->view('shop_setting/sms_setting', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        } else {
            $data = array();
            $data['sms_information'] = $this->Authentication_model->getSMSInformation($company_id);
            $data['company_id'] = ($company_id);
            $data['main_content'] = $this->load->view('shop_setting/sms_setting', $data, TRUE);
            $this->load->view('userHome', $data);
        }
    }

}

