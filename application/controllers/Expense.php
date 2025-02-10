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
    # This is Expense Controller
    ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Expense extends Cl_Controller {

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
        $controller = "172";
        $function = "";
        if($segment_2=="addEditExpense"){
            $function = "add";
        }elseif($segment_2=="addEditExpense" && $segment_3){
            $function = "edit";
        }elseif($segment_2=="deleteExpense"){
            $function = "delete";
        }elseif($segment_2=="expenses"){
            $function = "list";
        }else{
            $this->session->set_flashdata('exception_1',lang('no_access'));
            redirect('Authentication/userProfile');
        }
        if(!checkAccess($controller,$function)){
            $this->session->set_flashdata('exception_1',lang('no_access'));
            redirect('Authentication/userProfile');
        }

        $register_content = json_decode($this->session->userdata('register_content'));
        $register_status = $this->session->userdata('register_status');
        if ($register_content->register_expense != '' && $register_status == 2) {
            $this->session->set_flashdata('exception', lang('please_open_register'));
            $this->session->set_userdata("clicked_controller", $this->uri->segment(1));
            $this->session->set_userdata("clicked_method", $this->uri->segment(2));
            redirect('Register/openRegister');
        }
    }


    /**
     * addEditExpense
     * @access public
     * @param no
     * @return void
     */
    public function addEditExpense($encrypted_id = "") {
        $encrypted_id = $encrypted_id;
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        $outlet_id = $this->session->userdata('outlet_id');
        $company_id = $this->session->userdata('company_id');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $add_more = $this->input->post($this->security->xss_clean('add_more'));
            $this->form_validation->set_rules('reference_no', lang('ref_no'), 'required|max_length[50]');
            $this->form_validation->set_rules('date',lang('date'), 'required|max_length[50]');
            $this->form_validation->set_rules('amount',lang('amount'), 'required|max_length[11]');
            $this->form_validation->set_rules('category_id',lang('category'), 'required|max_length[10]');
            $this->form_validation->set_rules('payment_method_id',lang('payment_methods'), 'required');
            $this->form_validation->set_rules('employee_id',lang('responsible_person'), 'max_length[10]');
            $this->form_validation->set_rules('note',lang('note'), 'max_length[255]');
            if ($this->form_validation->run() == TRUE) {
                $expnse_info = array();
                $expnse_info['reference_no'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('reference_no')));
                $expnse_info['date'] = date("Y-m-d", strtotime($this->input->post($this->security->xss_clean('date'))));
                $expnse_info['amount'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('amount')));
                $expnse_info['category_id'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('category_id')));
                $expnse_info['payment_method_id'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('payment_method_id')));
                $expnse_info['employee_id'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('employee_id')));
                $expnse_info['note'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('note')));
                $expnse_info['user_id'] = $this->session->userdata('user_id');
                $expnse_info['outlet_id'] = $this->session->userdata('outlet_id');
                $expnse_info['company_id'] = $this->session->userdata('company_id');
                if ($id == "") {
                    $expnse_info['added_date'] = date('Y-m-d H:i:s');
                    $this->Common_model->insertInformation($expnse_info, "tbl_expenses");
                    $this->session->set_flashdata('exception', lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($expnse_info, $id, "tbl_expenses");
                    $this->session->set_flashdata('exception', lang('update_success'));
                }
                if($add_more == 'add_more'){
                    redirect('Expense/addEditExpense');
                }else{
                    redirect('Expense/expenses');
                }
            } else {
                if ($id == "") {
                    $data = array();
                    $data['paymentMethods'] = $this->Common_model->getAllPaymentMethod();
                    $data['reference_no'] = $this->Common_model->generateReferenceNoForExpense($outlet_id);
                    $data['expense_categories'] = $this->Common_model->getAllExpenseCategoryASC();
                    $data['employees'] = $this->Common_model->getAllUsersNameMobile();
                    $data['main_content'] = $this->load->view('expense/addExpense', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['reference_no'] = $this->Common_model->generateReferenceNoForExpense($outlet_id);
                    $data['paymentMethods'] = $this->Common_model->getAllPaymentMethod();
                    $data['expense_categories'] = $this->Common_model->getAllExpenseCategoryASC();
                    $data['employees'] = $this->Common_model->getAllUsersNameMobile();
                    $data['expense_information'] = $this->Common_model->getDataById($id, "tbl_expenses");
                    $data['main_content'] = $this->load->view('expense/editExpense', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['reference_no'] = $this->Common_model->generateReferenceNoForExpense($outlet_id);
                $data['paymentMethods'] = $this->Common_model->getAllPaymentMethod();
                $data['expense_categories'] = $this->Common_model->getAllExpenseCategoryASC();
                $data['employees'] = $this->Common_model->getAllUsersNameMobile();
                $data['main_content'] = $this->load->view('expense/addExpense', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['reference_no'] = $this->Common_model->generateReferenceNoForExpense($outlet_id);
                $data['paymentMethods'] = $this->Common_model->getAllPaymentMethod();
                $data['expense_categories'] = $this->Common_model->getAllExpenseCategoryASC();
                $data['employees'] = $this->Common_model->getAllUsersNameMobile();
                $data['expense_information'] = $this->Common_model->getDataById($id, "tbl_expenses");
                $data['main_content'] = $this->load->view('expense/editExpense', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }


    /**
     * deleteExpense
     * @access public
     * @param int
     * @return void
     */
    public function deleteExpense($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $this->Common_model->deleteStatusChange($id, "tbl_expenses");
        $this->session->set_flashdata('exception',lang('delete_success'));
        redirect('Expense/expenses');
    }

    /**
     * expenses
     * @access public
     * @param no
     * @return void
     */
    public function expenses() {
        $outlet_id = $this->session->userdata('outlet_id');
        $data = array();
        $data['expenses'] = $this->Common_model->getAllByOutletId($outlet_id, "tbl_expenses");
        $data['main_content'] = $this->load->view('expense/expenses', $data, TRUE);
        $this->load->view('userHome', $data);
    }

}
