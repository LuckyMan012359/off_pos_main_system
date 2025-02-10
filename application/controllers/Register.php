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
    # This is Register Controller
    ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends Cl_Controller {

    /**
     * load constructor
     * @access public
     * @return void
     */    
    public function __construct() {
        parent::__construct();
        $this->load->library('excel'); //load PHPExcel library 
        $this->load->model('Authentication_model');
        $this->load->model('Common_model');
        $this->load->model('Register_model');
        $this->load->library('form_validation');
        $this->Common_model->setDefaultTimezone();
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
    }

    /**
     * openRegister
     * @access public
     * @param no
     * @return void
     */
    public function openRegister(){
        if (!$this->session->has_userdata('outlet_id')) {
            $this->session->set_flashdata('exception_2', lang('Please_click_on_green'));
            redirect('Outlet/outlets');
        }
        $data = array();
        $company_id = $this->session->userdata('company_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $data['payment_methods'] = $this->Common_model->getAllEnablePaymentMethod();
        $data['counters'] = $this->Common_model->getAllCounterListByOutletId($outlet_id, $company_id);
        $data['main_content'] = $this->load->view('register/openRegister', $data, TRUE);
        $this->load->view('userHome', $data);
    }


    /**
     * registerDetails
     * @access public
     * @param no
     * @return void
     */
    public function registerDetails(){
        $register_content = json_decode($this->session->userdata('register_content'));
        $register_status = $this->session->userdata('register_status');
        if (($register_content->register_sale != '' && $register_status == 2)  || $register_status == '' || $register_status == '2') {
            $this->session->set_flashdata('exception', lang('please_open_register'));
            $this->session->set_userdata("clicked_controller", $this->uri->segment(1));
            $this->session->set_userdata("clicked_method", $this->uri->segment(2));
            redirect('Register/openRegister');
        }
        $data = array();
        $data['main_content'] = $this->load->view('register/registerDetails', $data, TRUE);
        $this->load->view('userHome', $data);
    }


    /**
     * addBalance
     * @access public
     * @param int
     * @return void
     */
    public function addBalance($encrypted_id = ""){
        $company_id = $this->session->userdata('company_id');
        $register_status = array();
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('opening_balance', lang('opening_balance'), 'max_length[30]');
            $this->form_validation->set_rules('counter_id', lang('counter_name'), 'required|max_length[11]');
            if ($this->form_validation->run() == TRUE) {
                $register_status['register_status'] = 1;
                $this->session->set_userdata($register_status);
                $register_info = array();
                $register_info['opening_balance'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('opening_balance')));
                $register_info['counter_id'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('counter_id')));
                $register_info['closing_balance'] = 0.00;
                $register_info['opening_balance_date_time'] = date('Y-m-d H:i:s');
                $register_info['register_status'] = 1;
                $register_info['user_id'] = $this->session->userdata('user_id');
                $register_info['outlet_id'] = $this->session->userdata('outlet_id');
                $register_info['company_id'] = $this->session->userdata('company_id');
                $register_info['added_date'] = date('Y-m-d H:i:s');
                //This variable could not be escaped because this is array content
                $payment_names = $this->input->post($this->security->xss_clean('payment_names'));
                $payment_ids = $this->input->post($this->security->xss_clean('payment_ids'));
                $payments = $this->input->post($this->security->xss_clean('payments'));
                $arr = array();
                foreach ($payment_ids as $key=>$value){
                    $arr[] = $value."||".$payment_names[$key]."||".$payments[$key];
                }
                $register_info['opening_details'] = json_encode($arr);
                $register_id = $this->Common_model->insertInformation($register_info, "tbl_register");
                
                // Printer Session Data Set
                $count_id = $this->Common_model->getCounterIdByRegisterId($register_id);
                $printer_id = $this->Common_model->getPrinterIdByCounterId($count_id);
                $printer_info = $this->Common_model->getPrinterInfoById($printer_id);

                $print_arr = [
                    'print_format' => '',
                    'characters_per_line' => '',
                    'printer_ip_address' => '',
                    'printer_port' => '',
                    'qr_code_type' => '',
                    'invoice_print' => '',
                    'fiscal_printer_status' => '',
                    'print_server_url_invoice' => '',
                    'inv_qr_code_status' => ''
                ];
                if ($printer_info) {
                    $print_arr['printer_id'] = $printer_id;
                    $print_arr['print_format'] = $printer_info->print_format;
                    $print_arr['characters_per_line'] = $printer_info->characters_per_line;
                    $print_arr['printer_ip_address'] = $printer_info->printer_ip_address;
                    $print_arr['printer_port'] = $printer_info->printer_port;
                    $print_arr['qr_code_type'] = $printer_info->qr_code_type;
                    $print_arr['invoice_print'] = $printer_info->invoice_print;
                    $print_arr['fiscal_printer_status'] = $printer_info->fiscal_printer_status;
                    $print_arr['print_server_url_invoice'] = $printer_info->print_server_url_invoice;
                    $print_arr['inv_qr_code_status'] = $printer_info->inv_qr_code_status;
                }

                $this->session->set_userdata($print_arr);
                if (!$this->session->has_userdata('clicked_controller')) {
                    if ($this->session->userdata('role') == '1') {
                        redirect('Dashboard/dashboard');
                    } else {
                        redirect('Authentication/userProfile');
                    }
                } else {
                    $clicked_controller = $this->session->userdata('clicked_controller');
                    $clicked_method = $this->session->userdata('clicked_method');
                    $this->session->unset_userdata('clicked_controller');
                    $this->session->unset_userdata('clicked_method');
                    redirect($clicked_controller . '/' . $clicked_method);
                }
            }else {
                if (!$this->session->has_userdata('outlet_id')) {
                    $this->session->set_flashdata('exception_2', lang('Please_click_on_green'));
                    redirect('Outlet/outlets');
                }
                $company_id = $this->session->userdata('company_id');
                $outlet_id = $this->session->userdata('outlet_id');
                $data = array();
                $data['payment_methods'] = $this->Common_model->getAllEnablePaymentMethod();
                $data['counters'] = $this->Common_model->getAllCounterListByOutletId($outlet_id, $company_id);
                $data['main_content'] = $this->load->view('register/openRegister', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }else{
            if (!$this->session->has_userdata('outlet_id')) {
                $this->session->set_flashdata('exception_2', lang('Please_click_on_green'));
                redirect('Outlet/outlets');
            }
            $company_id = $this->session->userdata('company_id');
            $outlet_id = $this->session->userdata('outlet_id');
            $data = array();
            $data['payment_methods'] = $this->Common_model->getAllEnablePaymentMethod();
            $data['counters'] = $this->Common_model->getAllCounterListByOutletId($outlet_id, $company_id);
            $data['main_content'] = $this->load->view('register/openRegister', $data, TRUE);
            $this->load->view('userHome', $data);
        }
    }


    /**
     * checkRegisterAjax
     * @access public
     * @param no
     * @return object
     */
    public function checkRegisterAjax()
    {
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $checkRegister = $this->Register_model->checkRegister($user_id,$outlet_id);
        if(!is_null($checkRegister)){
            echo $checkRegister->status;    
        }else{
            echo "";
        }        
    }
}
