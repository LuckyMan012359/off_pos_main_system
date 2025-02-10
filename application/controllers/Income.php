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
    # This is Income Controller
    ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Income extends Cl_Controller {

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
        if (!$this->session->has_userdata('outlet_id')) {
            $this->session->set_flashdata('exception_2',lang('please_click_green_button'));
            $this->session->set_userdata("clicked_controller", $this->uri->segment(1));
            $this->session->set_userdata("clicked_method", $this->uri->segment(2));
            redirect('Outlet/outlets');
        }
        //start check access function
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $controller = "182";
        $function = "";
        if($segment_2=="addEditIncome"){
            $function = "add";
        }elseif($segment_2=="addEditIncome" && $segment_3){
            $function = "edit";
        }elseif($segment_2=="deleteIncome"){
            $function = "delete";
        }elseif($segment_2=="incomes"){
            $function = "list";
        }else{
            $this->session->set_flashdata('exception_1',lang('no_access'));
            redirect('Authentication/userProfile');
        }
        if(!checkAccess($controller,$function)){
            $this->session->set_flashdata('exception_1',lang('no_access'));
            redirect('Authentication/userProfile');
        }
        //end check access function
    }

    /**
     * addEditIncome
     * @access public
     * @param int
     * @return void
     */
    public function addEditIncome($encrypted_id = "") {
        $encrypted_id = $encrypted_id;
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        $outlet_id = $this->session->userdata('outlet_id');
        $company_id = $this->session->userdata('company_id');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $add_more = $this->input->post($this->security->xss_clean('add_more'));
            
            $this->form_validation->set_rules('date',lang('date'), 'required|max_length[50]');
            $this->form_validation->set_rules('amount',lang('amount'), 'required|max_length[11]');
            $this->form_validation->set_rules('category_id',lang('category'), 'required|max_length[10]');
            $this->form_validation->set_rules('payment_method_id',lang('payment_methods'), 'required');
            $this->form_validation->set_rules('employee_id',lang('responsible_person'), 'required|max_length[10]');
            $this->form_validation->set_rules('note',lang('note'), 'max_length[255]');
            if ($this->form_validation->run() == TRUE) {
                $acc_type = array();
                $account_type = htmlspecialcharscustom($this->input->post($this->security->xss_clean('account_type')));
                if($account_type == 'Cash' && $account_type != ''){
                    $p_note = htmlspecialcharscustom($this->input->post($this->security->xss_clean('p_note')));
                    if($p_note != ''){
                        $acc_type['p_note'] = $p_note;
                    }
                }elseif($account_type == 'Bank_Account' && $account_type != ''){
                    $check_issue_date = htmlspecialcharscustom($this->input->post($this->security->xss_clean('check_issue_date')));
                    $check_no = htmlspecialcharscustom($this->input->post($this->security->xss_clean('check_no')));
                    $check_expiry_date = htmlspecialcharscustom($this->input->post($this->security->xss_clean('check_expiry_date')));
                    if($check_issue_date != ''){
                        $acc_type['check_issue_date'] = $check_issue_date;
                    }
                    if($check_no != ''){
                        $acc_type['check_no'] = $check_no;
                    }
                    if($check_expiry_date != ''){
                        $acc_type['check_expiry_date'] = $check_expiry_date;
                    }
                }elseif($account_type == 'Card' && $account_type != ''){
                    $card_holder_name = htmlspecialcharscustom($this->input->post($this->security->xss_clean('card_holder_name')));
                    $card_holding_number = htmlspecialcharscustom($this->input->post($this->security->xss_clean('card_holding_number')));
                    if($card_holder_name != ''){
                        $acc_type['card_holder_name'] = $card_holder_name;
                    }
                    if($card_holding_number != ''){
                        $acc_type['card_holding_number'] = $card_holding_number;
                    }
                }elseif($account_type == 'Mobile_Banking' && $account_type != ''){
                    $mobile_no = htmlspecialcharscustom($this->input->post($this->security->xss_clean('mobile_no')));
                    $transaction_no = htmlspecialcharscustom($this->input->post($this->security->xss_clean('transaction_no')));
                    if($mobile_no != ''){
                        $acc_type['mobile_no'] = $mobile_no;
                    }
                    if($transaction_no != ''){
                        $acc_type['transaction_no'] = $transaction_no;
                    }
                }elseif($account_type == 'Paypal' && $account_type != ''){
                    $paypal_email = htmlspecialcharscustom($this->input->post($this->security->xss_clean('paypal_email')));
                    if($paypal_email != ''){
                        $acc_type['paypal_email'] = $paypal_email;
                    }
                }elseif($account_type == 'Stripe' && $account_type != ''){
                    $stripe_email = htmlspecialcharscustom($this->input->post($this->security->xss_clean('stripe_email')));
                    if($stripe_email != ''){
                        $acc_type['stripe_email'] = $stripe_email;
                    }
                }

                $incomes = array();
                $incomes['reference_no'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('reference_no')));
                $incomes['date'] = date("Y-m-d", strtotime($this->input->post($this->security->xss_clean('date'))));
                $incomes['amount'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('amount')));
                $incomes['category_id'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('category_id')));
                $incomes['payment_method_id'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('payment_method_id')));
                $incomes['employee_id'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('employee_id')));
                $incomes['added_date'] = date('Y-m-d H:i:s');
                $incomes['note'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('note')));
                $incomes['account_type'] = $account_type;
                if(!empty($acc_type)){
                    $incomes['payment_method_type'] = json_encode($acc_type);
                }
                $incomes['user_id'] = $this->session->userdata('user_id');
                $incomes['outlet_id'] = $this->session->userdata('outlet_id');
                $incomes['company_id'] = $this->session->userdata('company_id');
                if ($id == "") {
                    $incomes['added_date'] = date('Y-m-d H:i:s');
                    $this->Common_model->insertInformation($incomes, "tbl_incomes");
                    $this->session->set_flashdata('exception', lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($incomes, $id, "tbl_incomes");
                    $this->session->set_flashdata('exception', lang('update_success'));
                }
                if($add_more == 'add_more'){
                    redirect('Income/addEditIncome');
                }else{
                    redirect('Income/incomes');
                }
            } else {
                if ($id == "") {
                    $data = array();
                    $data['reference_no'] = $this->Common_model->generateReferenceNoForIncome($outlet_id);
                    $data['paymentMethods'] = $this->Common_model->getAllPaymentMethod();
                    $data['income_categories'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_income_items");
                    $data['employees'] = $this->Common_model->getAllUsersNameMobile();
                    $data['main_content'] = $this->load->view('income/addIncome', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['reference_no'] = $this->Common_model->generateReferenceNoForIncome($outlet_id);
                    $data['paymentMethods'] = $this->Common_model->getAllPaymentMethod();
                    $data['income_categories'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_income_items");
                    $data['employees'] = $this->Common_model->getAllUsersNameMobile();
                    $data['income_information'] = $this->Common_model->getDataById($id, "tbl_incomes");
                    $data['main_content'] = $this->load->view('income/editIncome', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['reference_no'] = $this->Common_model->generateReferenceNoForIncome($outlet_id);
                $data['paymentMethods'] = $this->Common_model->getAllPaymentMethod();
                $data['income_categories'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_income_items");
                $data['employees'] = $this->Common_model->getAllUsersNameMobile();
                $data['main_content'] = $this->load->view('income/addIncome', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['reference_no'] = $this->Common_model->generateReferenceNoForIncome($outlet_id);
                $data['paymentMethods'] = $this->Common_model->getAllPaymentMethod();
                $data['income_categories'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_income_items");
                $data['employees'] = $this->Common_model->getAllUsersNameMobile();
                $data['income_information'] = $this->Common_model->getDataById($id, "tbl_incomes");
                $data['main_content'] = $this->load->view('income/editIncome', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }

    /**
     * deleteIncome
     * @access public
     * @param int
     * @return void
     */
    public function deleteIncome($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $this->Common_model->deleteStatusChange($id, "tbl_incomes");
        $this->session->set_flashdata('exception',lang('delete_success'));
        redirect('Income/incomes');
    }

    /**
     * incomes
     * @access public
     * @param no
     * @return void
     */
    public function incomes() {
        $outlet_id = $this->session->userdata('outlet_id');
        $data = array();
        $data['incomes'] = $this->Common_model->getAllByOutletId($outlet_id, "tbl_incomes");
        $data['main_content'] = $this->load->view('income/incomes', $data, TRUE);
        $this->load->view('userHome', $data);
    }

}
