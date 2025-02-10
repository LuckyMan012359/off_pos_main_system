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
    # This is PaymentMethod Controller
    ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class PaymentMethod extends Cl_Controller {

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
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $controller = "218";
        $function = "";
        if($segment_2=="addEditPaymentMethod"){
            $function = "add";
        }elseif($segment_2=="addEditPaymentMethod" && $segment_3){
            $function = "edit";
        }elseif($segment_2=="deletePaymentMethod"){
            $function = "delete";
        }elseif($segment_2=="paymentMethods" || $segment_2 == 'sortPaymentMethod' || $segment_2 == 'sortPaymentMethodUpdate'){
            $function = "list";
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
     * addEditPaymentMethod
     * @access public
     * @param int
     * @return void
     */
    public function addEditPaymentMethod($encrypted_id = "") {
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        if($this->input->post('submit')) {
            $add_more = $this->input->post($this->security->xss_clean('add_more'));
            $paymentname = htmlspecialcharscustom($this->input->post($this->security->xss_clean('name')));
            $this->form_validation->set_rules('name', lang('account_name'), 'required|max_length[50]');
            if($paymentname != 'Loyalty Point' && $id == ''){
                $this->form_validation->set_rules('account_type', lang('account_type'), 'required|max_length[25]');
            }
            $this->form_validation->set_rules('current_balance', lang('opening_balance'), 'max_length[11]');
            $this->form_validation->set_rules('status', lang('status'), 'required');
            $this->form_validation->set_rules('description', lang('description'), 'max_length[255]');
            if ($this->form_validation->run() == TRUE) {
                $fmc_info = array();
                $fmc_info['name'] = $paymentname;
                $fmc_info['description'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('description')));
				$fmc_info['current_balance'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('current_balance')));
				$fmc_info['status'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('status')));
                if($paymentname == 'Loyalty Point'){
                    if($id == ''){
                        $fmc_info['account_type'] = 'Loyalty Point';
                    }
                }else{
                    if($id == ''){
                        $fmc_info['account_type'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('account_type')));
                    }
                }
                $fmc_info['user_id'] = $this->session->userdata('user_id');
                $fmc_info['company_id'] = $this->session->userdata('company_id');
                if ($id == "") {
                    $fmc_info['added_date'] = date('Y-m-d H:i:s');
                    $this->Common_model->insertInformation($fmc_info, "tbl_payment_methods");
                    $this->session->set_flashdata('exception',lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($fmc_info, $id, "tbl_payment_methods");
                    $this->session->set_flashdata('exception',lang('update_success'));
                }
                if($add_more == 'add_more'){
                    redirect('PaymentMethod/addEditPaymentMethod');
                }else{
                    redirect('PaymentMethod/paymentMethods');
                }
            } else {
                if ($id == "") {
                    $data = array();
                    $data['main_content'] = $this->load->view('master/paymentMethod/addPaymentMethod', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['payment_method_information'] = $this->Common_model->getDataById($id, "tbl_payment_methods");
                    $data['main_content'] = $this->load->view('master/paymentMethod/editPaymentMethod', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['main_content'] = $this->load->view('master/paymentMethod/addPaymentMethod', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['payment_method_information'] = $this->Common_model->getDataById($id, "tbl_payment_methods");
                $data['main_content'] = $this->load->view('master/paymentMethod/editPaymentMethod', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }

    
    /**
     * deletePaymentMethod
     * @access public
     * @param int
     * @return void
     */
    public function deletePaymentMethod($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $this->Common_model->deleteStatusChange($id, "tbl_payment_methods");
        $this->session->set_flashdata('exception', lang('delete_success'));
        redirect('PaymentMethod/paymentMethods');
    }

    /**
     * paymentMethods
     * @access public
     * @param no
     * @return void
     */
    public function paymentMethods() {
        $company_id = $this->session->userdata('company_id');
        $data = array();
        $data['paymentMethods'] = $this->Common_model->getAll($company_id, "tbl_payment_methods");
        $data['main_content'] = $this->load->view('master/paymentMethod/paymentMethods', $data, TRUE);
        $this->load->view('userHome', $data);
    }


    /**
     * sortPaymentMethod
     * @access public
     * @param no
     * @return void
     */
    public function sortPaymentMethod() {
        $company_id = $this->session->userdata('company_id');
        $data = array();
        $data['payment_method'] = $this->Common_model->getPaymentMethodBySortedId($company_id);
        $data['main_content'] = $this->load->view('master/paymentMethod/sortingPaymentMethod', $data, TRUE);
        $this->load->view('userHome', $data);
    }



    /**
     * sortPaymentMethodUpdate
     * @access public
     * @param no
     * @return void
     */
    public function sortPaymentMethodUpdate() {
        $data = array();
        if($this->input->post($this->security->xss_clean('ids'))){
            $arr = explode(',',$this->input->post('ids'));
            foreach($arr as $sortOrder => $id){
                $category = $this->db->query("SELECT id, sort_id FROM tbl_payment_methods where id=$id")->row();
                $data['sort_id'] = $sortOrder+1;
                $this->Common_model->updateInformation($data, $id, 'tbl_payment_methods');
            }
            $response = [
                'success'=>true,'message'=>'Payment Method Successfully Sorted'
            ];
            $this->output->set_content_type('application/json')->set_output(json_encode($response));
        }
    }

}
