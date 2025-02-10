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
  # This is Salary Controller
  ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Salary extends Cl_Controller {

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
            redirect('Outlet/outlets');
        }
        //start check access function
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $controller = "87";
        $function = "";
        if($segment_2=="generate"){
            $function = "add";
        }elseif($segment_2=="addEditSalary" && $segment_3){
            $function = "edit";
        }elseif($segment_2=="addEditSalary"){
            $function = "add";
        }elseif($segment_2=="printSalary" || $segment_2 == "a4InvoicePDF"){
            $function = "print";
        }elseif($segment_2=="deleteSalary"){
            $function = "delete";
        }
        if(!checkAccess($controller,$function)){
            $this->session->set_flashdata('exception_er', lang('no_access'));
            redirect('Authentication/userProfile');
        }
    }



    /**
     * addEditSalary
     * @access public
     * @param int
     * @return void
     */
    public function addEditSalary($encrypted_id = "") {
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        //all of fields should not be escaped, because this is an array field
        $month = htmlspecialcharscustom($this->input->post($this->security->xss_clean('month')));
        $year = htmlspecialcharscustom($this->input->post($this->security->xss_clean('year')));
        $user_id = $this->input->post($this->security->xss_clean('user_id'));
        $generated_salary = $this->input->post($this->security->xss_clean('generated_salary'));
        $salary = $this->input->post($this->security->xss_clean('salary'));
        $additional = $this->input->post($this->security->xss_clean('additional'));
        $subtraction = $this->input->post($this->security->xss_clean('subtraction'));
        $total = $this->input->post($this->security->xss_clean('total'));
        $notes = $this->input->post($this->security->xss_clean('notes'));

        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $final_arr = array();
            $total_amount = 0;
            for ($i=0;$i<sizeof($generated_salary);$i++){
                if($generated_salary[$i] == 2){
                    $txt = "product_id".$user_id[$i];
                    //This field should not be escaped, because this is an array field
                    $tmp_v = $this->input->post($txt);
                    $tmp = array();
                    $tmp['p_status'] = isset($tmp_v) && $tmp_v?1:'';
                    $tmp['user_id'] = $user_id[$i];
                    $tmp['name'] = userName($user_id[$i]);
                    $tmp['salary'] = $salary[$i];
                    $tmp['additional'] = $additional[$i];
                    $tmp['subtraction'] = $subtraction[$i];
                    $tmp['total'] = $total[$i];
                    $tmp['notes'] = $notes[$i];
                    $total_amount +=$total[$i];
                    $final_arr[] = $tmp;
                }
            }
            $data = array();
            $data['month'] = $month;
            $data['month_no'] = monthNumberByMonthName($month);
            $data['year'] = $year;
            $data['date'] = date("Y-m-d",strtotime('today'));
            $data['total_amount'] = $total_amount;
            $data['payment_id'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('payment_method_id')));
            $data['user_id'] = $this->session->userdata('user_id');
            $data['outlet_id'] = $this->session->userdata('outlet_id');
            $data['company_id'] = $this->session->userdata('company_id');
            $data['details_info'] = json_encode($final_arr);
            if($id==''){
                $data['added_date'] = date('Y-m-d H:i:s');
                $this->Common_model->insertInformation($data, "tbl_salaries");
                $this->session->set_flashdata('exception', lang('insertion_success'));
            }else{
                $this->Common_model->updateInformation($data, $id, "tbl_salaries");
                $this->session->set_flashdata('exception', lang('update_success'));
            }
            redirect('salary/generate');
        }else{
            if($id==''){
                redirect('salary/generate');
            }else{
                $company_id = $this->session->userdata('company_id');
                $data['paymentMethods'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_payment_methods");
                $data['getSelectedRow'] =   $this->Common_model->getDataById($id,'tbl_salaries');
                $data['main_content'] = $this->load->view('salary/addEditSalaryEdit', $data, TRUE);
                // echo "Hi";exit;
                $this->load->view('userHome', $data);
            }
        }
    }

    /**
     * deleteSalary
     * @access public
     * @param int
     * @return void
     */
    public function deleteSalary($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $this->Common_model->deleteStatusChange($id, "tbl_salaries");
        $this->session->set_flashdata('exception',  lang('delete_success'));
        redirect('salary/generate');
    }

    /**
     * generate
     * @access public
     * @param int
     * @return void
     */
    public function generate($id='') {
        $company_id = $this->session->userdata('company_id');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('month',  lang('month'), 'required|max_length[50]');
            $this->form_validation->set_rules('year',  lang('year'), 'required|max_length[50]');
            if ($this->form_validation->run() == TRUE) {
                $month = htmlspecialcharscustom($this->input->post('month'));
                $year = htmlspecialcharscustom($this->input->post('year'));
                $data = array();
                $data['month'] = $month;
                $data['year'] = $year;
                $checkExistingSalary = checkExistingSalary($month,$year);
                if($checkExistingSalary){
                    $this->session->set_flashdata('exception_r',  lang('salary_exist'));
                    redirect('salary/generate');
                }else{
                    $company_id = $this->session->userdata('company_id');
                    $data['paymentMethods'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_payment_methods");
                    $data['getSalaryUsers'] = $this->Common_model->getSalaryUsers();
                    $data['main_content'] = $this->load->view('salary/addEditSalary', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }else{
                $data = array();
                $data['salaries'] = $this->Common_model->getAllByCompanyIdWithAddedBy($company_id, "tbl_salaries");
                $data['main_content'] = $this->load->view('salary/salaries', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }else{
            $data = array();
            $data['salaries'] = $this->Common_model->getAllByCompanyIdWithAddedBy($company_id, "tbl_salaries");
            $data['main_content'] = $this->load->view('salary/salaries', $data, TRUE);
            $this->load->view('userHome', $data);
        }

    }

    /**
     * printSalary
     * @access public
     * @param int
     * @return void
     */

    public function printSalary($encrypted_id) {
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        $data['getSelectedRow'] =   $this->Common_model->getDataById($id,'tbl_salaries');
        $this->load->view('salary/print_salary', $data);
    }

    /**
     * a4InvoicePDF
     * @access public
     * @param int
     * @return void
     */

    public function a4InvoicePDF($encrypted_id) {
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        $pdfContent = array();
        $pdfContent['getSelectedRow'] =   $this->Common_model->getDataById($id,'tbl_salaries');
        $mpdf = new \Mpdf\Mpdf();
        $html = $this->load->view('salary/a4_invoice_pdf', $pdfContent, true);
        $mpdf->WriteHTML($html);
        $mpdf->Output('Generated Salary for -' . ($pdfContent['getSelectedRow']->month) . ($pdfContent['getSelectedRow']->year) . '.pdf', "D");
    }
}
