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
    # This is Deposit Controller
    ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Deposit extends Cl_Controller {

    /**
     * load constructor
     * @access public
     * @return void
     */  
    public function __construct() {
        parent::__construct();
        $this->load->model('Authentication_model');
		$this->load->model('Deposit_model');
        $this->load->model('Common_model');
        $this->load->library('form_validation');
        $this->Common_model->setDefaultTimezone();
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        if (!$this->session->has_userdata('outlet_id')) {
            $this->session->set_flashdata('exception_2',lang('please_click_green_button'));
            $this->session->set_userdata("clicked_controller", $this->uri->segment(1));
            $this->session->set_userdata("clicked_method", $this->uri->segment(2));
            redirect('Outlet/outlets');
        }
        //start check access function
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $controller = "223";
        $function = "";
        if($segment_2=="addEditDeposit"){
            $function = "add";
        }elseif($segment_2=="addEditDeposit" && $segment_3){
            $function = "edit";
        }elseif($segment_2=="deleteDeposit"){
            $function = "delete";
        }elseif($segment_2=="deposits"){
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
     * addEditDeposit
     * @access public
     * @param int
     * @return void
     */
    public function addEditDeposit($encrypted_id = "") {
        $company_id = $this->session->userdata('company_id'); 
        $outlet_id = $this->session->userdata('outlet_id'); 
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        if($this->input->post('submit')) {
            $add_more = $this->input->post($this->security->xss_clean('add_more'));
            $this->form_validation->set_rules('reference_no', lang('ref_no'), 'required|max_length[50]');
            $this->form_validation->set_rules('amount', lang('amount'), 'required|max_length[11]');
            $this->form_validation->set_rules('payment_method_id',lang('payment_methods'), 'required');
            $this->form_validation->set_rules('date', lang('date'), 'required|max_length[50]');
            $this->form_validation->set_rules('type', lang('deposit_or_withdraw'), 'required');
            $this->form_validation->set_rules('note', lang('note'), 'max_length[255]');
            if ($this->form_validation->run() == TRUE) {
                $fmc_info = array();
		        $fmc_info['reference_no'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('reference_no')));
                $fmc_info['date'] = $this->input->post($this->security->xss_clean('date'));
                $fmc_info['type'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('type')));
                $fmc_info['note'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('note')));
		        $fmc_info['amount'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('amount')));
                $fmc_info['payment_method_id'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('payment_method_id')));
                $fmc_info['user_id'] = $this->session->userdata('user_id');
                $fmc_info['outlet_id'] = $this->session->userdata('outlet_id');
                $fmc_info['company_id'] = $this->session->userdata('company_id');
                if ($id == "") {
                    $fmc_info['added_date'] = date('Y-m-d H:i:s');
                    $this->Common_model->insertInformation($fmc_info, "tbl_deposits");
                    $this->session->set_flashdata('exception',lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($fmc_info, $id, "tbl_deposits");
                    $this->session->set_flashdata('exception',lang('delete_success'));
                }
                if($add_more == 'add_more'){
                    redirect('Deposit/addEditDeposit');
                }else{
                    redirect('Deposit/deposits');
                }
            } else {
                if ($id == "") {
                    $data = array();
                    $data['paymentMethods'] = $this->Common_model->getAllPaymentMethod();
		            $data['deposit_ref_no'] = $this->Deposit_model->generatePurRefNo($outlet_id);
                    $data['main_content'] = $this->load->view('master/deposit/addDeposit', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['paymentMethods'] = $this->Common_model->getAllPaymentMethod();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['deposit_information'] = $this->Common_model->getDataById($id, "tbl_deposits");
                    $data['main_content'] = $this->load->view('master/deposit/editDeposit', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['paymentMethods'] = $this->Common_model->getAllPaymentMethod();
		        $data['deposit_ref_no'] = $this->Deposit_model->generatePurRefNo($outlet_id);
                $data['main_content'] = $this->load->view('master/deposit/addDeposit', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['paymentMethods'] = $this->Common_model->getAllPaymentMethod();
                $data['encrypted_id'] = $encrypted_id;
                $data['deposit_information'] = $this->Common_model->getDataById($id, "tbl_deposits");
                $data['main_content'] = $this->load->view('master/deposit/editDeposit', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    } 
    
    /**
     * deleteDeposit
     * @access public
     * @param int
     * @return void
     */
    public function deleteDeposit($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $this->Common_model->deleteStatusChange($id, "tbl_deposits");
        $this->session->set_flashdata('exception', lang('delete_success'));
        redirect('Deposit/deposits');
    }


    
    /**
     * deposits
     * @access public
     * @param no
     * @return void
     */
    public function deposits() {
        $outlet_id = $this->session->userdata('outlet_id');
        $data = array();
        $data['deposit_lists'] = $this->Common_model->getAllByOutletId($outlet_id, "tbl_deposits");
        $data['main_content'] = $this->load->view('master/deposit/deposits', $data, TRUE);
        $this->load->view('userHome', $data);
    }


}
