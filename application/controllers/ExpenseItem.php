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
    # This is ExpenseItem Controller
    ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class ExpenseItem extends Cl_Controller {

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
        //start check access function
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $controller = "177";
        $function = "";
        if($segment_2=="addEditExpenseItem"){
            $function = "add";
        }elseif($segment_2=="addEditExpenseItem" && $segment_3){
            $function = "edit";
        }elseif($segment_2=="deleteExpenseItem"){
            $function = "delete";
        }elseif($segment_2=="expenseItems"){
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
     * addEditExpenseItem
     * @access public
     * @param int
     * @return void
     */
    public function addEditExpenseItem($encrypted_id = "") {
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $add_more = $this->input->post($this->security->xss_clean('add_more'));
            $this->form_validation->set_rules('name', lang('name'), 'required|max_length[50]');
            $this->form_validation->set_rules('description', lang('description'), 'max_length[255]');
            if ($this->form_validation->run() == TRUE) {
                $fmc_info = array();
                $fmc_info['name'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('name')));
                $fmc_info['description'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('description')));
                $fmc_info['user_id'] = $this->session->userdata('user_id');
                $fmc_info['company_id'] = $this->session->userdata('company_id');
                if ($id == "") {
                    $fmc_info['added_date'] = date('Y-m-d H:i:s');
                    $this->Common_model->insertInformation($fmc_info, "tbl_expense_items");
                    $this->session->set_flashdata('exception', lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($fmc_info, $id, "tbl_expense_items");
                    $this->session->set_flashdata('exception', lang('update_success'));
                }
                
                if($add_more == 'add_more'){
                    redirect('ExpenseItem/addEditExpenseItem');
                }else{
                    redirect('ExpenseItem/expenseItems');
                }

            } else {
                if ($id == "") {
                    $data = array();
                    $data['main_content'] = $this->load->view('master/expenseItem/addExpenseItem', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['expense_item_information'] = $this->Common_model->getDataById($id, "tbl_expense_items");
                    $data['main_content'] = $this->load->view('master/expenseItem/editExpenseItem', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['main_content'] = $this->load->view('master/expenseItem/addExpenseItem', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['expense_item_information'] = $this->Common_model->getDataById($id, "tbl_expense_items");
                $data['main_content'] = $this->load->view('master/expenseItem/editExpenseItem', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }

    /**
     * deleteExpenseItem
     * @access public
     * @param int
     * @return void
     */
    public function deleteExpenseItem($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $this->Common_model->deleteStatusChange($id, "tbl_expense_items");
        $this->session->set_flashdata('exception',lang('delete_success'));
        redirect('ExpenseItem/expenseItems');
    }

    /**
     * expenseItems
     * @access public
     * @param no
     * @return void
     */
    public function expenseItems() {
        $company_id = $this->session->userdata('company_id');
        $data = array();
        $data['expenseItems'] = $this->Common_model->getAllByCompanyIdWithAddedBy($company_id, "tbl_expense_items");
        $data['main_content'] = $this->load->view('master/expenseItem/expenseItems', $data, TRUE);
        $this->load->view('userHome', $data);
    }


}
