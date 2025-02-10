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
    # This is Payment_getway Controller
    ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Payment_getway extends Cl_Controller {

    /**
     * load constructor
     * @access public
     * @return void
     */  
    public function __construct() {
        parent::__construct();
        $this->load->model('Authentication_model');
        $this->load->model('Common_model');
        $this->load->library('form_validation');
        $this->Common_model->setDefaultTimezone();

        //start check access function
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $controller = "335";
        $function = ""; 
        if($segment_2=="paymentGetway"){
            $function = "edit";
        }else{
            $this->session->set_flashdata('exception_1',lang('no_access'));
            redirect('Authentication/userProfile');
        }
        if(!checkAccess($controller,$function)){
            $this->session->set_flashdata('exception_1',lang('no_access'));
            redirect('Authentication/userProfile');
        }
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
    }


    /**
     * paymentGetway
     * @access public
     * @param int
     * @return void
     */
    public function paymentGetway() {
        $company_id = $this->session->userdata('company_id');
        $data = array();
        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('action_type_stripe', lang('status'), 'required|max_length[55]');
            $this->form_validation->set_rules('stripe_api_key', lang('Stripe_Secret_Key'), 'required|max_length[255]');
            $this->form_validation->set_rules('stripe_publishable_key', lang('Stripe_Publishable_Key'), 'required|max_length[255]');
            $this->form_validation->set_rules('action_type_paypal', lang('status'), 'required|max_length[55]');
            $this->form_validation->set_rules('paypal_user_name', lang('paypal_user_name'), 'required|max_length[255]');
            $this->form_validation->set_rules('paypal_password', lang('paypal_password'), 'required|max_length[255]');
            $this->form_validation->set_rules('paypal_signature', lang('paypal_signature'), 'required|max_length[255]');
            if ($this->form_validation->run() == TRUE) {
                $api_data = array();
                $api_data['action_type_stripe'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('action_type_stripe')));   
                $api_data['stripe_api_key'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('stripe_api_key')));
                $api_data['stripe_publishable_key'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('stripe_publishable_key')));
                $api_data['action_type_paypal'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('action_type_paypal'))); 

                $api_data['paypal_user_name'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('paypal_user_name')));
                $api_data['paypal_password'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('paypal_password')));
                $api_data['paypal_signature'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('paypal_signature')));

                $api_data['company_id'] = $this->session->userdata($this->security->xss_clean('company_id'));
                $api_data['user_id'] = $this->session->userdata($this->security->xss_clean('user_id'));
                $data_json['payment_api_setting'] = json_encode($api_data); 
                $this->Common_model->updateInformation($data_json, $company_id, 'tbl_companies');
                $this->session->set_flashdata('exception', lang('update_success')); 
                redirect('Payment_getway/paymentGetway');
            }else{
                $payment_getway = $this->Common_model->getCompanyPaymentGetway();
                $data['payment_getway'] = $payment_getway->payment_api_setting;
                $data['main_content'] = $this->load->view('shop_setting/payment_getway',$data, TRUE);
                $this->load->view('userHome', $data);
            }
        } else {
            $payment_getway = $this->Common_model->getCompanyPaymentGetway();
            $payment_info = $payment_getway->payment_api_setting;
            if($payment_info){
                $data['payment_getway'] = json_decode($payment_info);
            }else{
                $data['payment_getway'] = '';
            }
            $data['main_content'] = $this->load->view('shop_setting/payment_getway',$data, TRUE);
            $this->load->view('userHome', $data);
        }
    }



    /**
     * get_api
     * @access public
     * @param no
     * @return string
     */
    function get_api() {
		$company_id = $this->session->userdata('company_id');
        $data1 = $this->Common_model->getPaymentApiByCompanyId($company_id);
        /*This variable could not be escaped because this is json content*/
        echo ($data1->payment_api);
    }
    


}
