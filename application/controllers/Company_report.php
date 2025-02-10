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
    # This is Company_report Controller
    ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Company_report extends Cl_Controller {

    /**
     * load constructor
     * @access public
     * @return void
     */    
    public function __construct() {
        parent::__construct();
        $this->load->model('Authentication_model');
        $this->load->model('Common_model');
        $this->load->model('Report_model');
        $this->load->model('Installment_model');
        $this->load->model('Stock_model');
        $this->load->model('Supplier_payment_model');
        $this->load->library('form_validation');
        $this->Common_model->setDefaultTimezone();
        
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        //start check access function
        $segment_1 = $this->uri->segment(1);
        $segment_2 = $this->uri->segment(2);
        $controller = "249";
        $function = "";
        if($segment_1=="Company_report" && $segment_2 == "supplierLedgerReport"){
            $function = "supplier_ledger";
        }elseif($segment_1=="Company_report" && $segment_2 == "supplierBalanceReport"){
            $function = "supplier_balance_report";
        }elseif($segment_1=="Company_report" && $segment_2 == "customerBalanceReport"){
            $function = "customer_balance_report";
        }elseif($segment_1=="Company_report" && $segment_2 == "customerLedgerReport"){
            $function = "customer_ledger";
        }elseif($segment_1=="Company_report" && $segment_2 == "cashFlowReport"){
            $function = "cash_flow_report";
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
     * supplierLedgerReport
     * @access public
     * @param no
     * @return void
     * Added By Azhar
     */
    public function supplierLedgerReport() {
        $data = array();
        $data['type'] = '';
        $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
        $data['outlet_id'] = $outlet_id;
        if($this->input->post('submit')){
            $start_date = $this->input->post($this->security->xss_clean('startDate'));
            $end_date = $this->input->post($this->security->xss_clean('endDate'));
            $type = htmlspecialcharscustom($this->input->post($this->security->xss_clean('type')));
            $ledger_type = htmlspecialcharscustom($this->input->post($this->security->xss_clean('ledger_type')));
            $data['type'] = $type;
            $data['ledger_type'] = $ledger_type;
            if($start_date != ''){
                $this->form_validation->set_rules('endDate', lang('endDate'), 'required|max_length[50]');
            }else if($end_date != ''){
                $this->form_validation->set_rules('startDate', lang('startDate'), 'required|max_length[50]');
            }
            $this->form_validation->set_rules('supplier_id', lang('supplier'), 'required|max_length[50]');
            $supplier_id = ($this->input->post($this->security->xss_clean('supplier_id')));
            $data['supplier_id'] = $supplier_id;
            $s_type = getSupplierOpeningBalanceType($supplier_id);
            if($start_date != '' && $end_date != '' && $supplier_id != ''){
                $start_date = date('Y-m-d',strtotime($this->input->post($this->security->xss_clean('startDate'))));
                $end_date = date('Y-m-d',strtotime($this->input->post($this->security->xss_clean('endDate'))));
                $openingBalanceCalculation = getSupplierOpeningBalance($supplier_id, $start_date);
                $data['sum_of_op_before_date'] = $openingBalanceCalculation;
                $data['supplierLedger'] = $this->Report_model->supplierLedgerReportWithDateRange($start_date, $end_date, $s_type, $supplier_id, $outlet_id);  
            }else if($supplier_id != ''){
                $data['supplierLedger'] = $this->Report_model->supplierLedgerReportWithDateRange('', '', $s_type, $supplier_id, $outlet_id);
                
            }
        }
        $data['suppliers'] = $this->Common_model->getAllSupplierNameMobile();
        $data['main_content'] = $this->load->view('report/supplierLedgerReport', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    /**
     * supplierBalanceReport
     * @access public
     * @param no
     * @return void
     */
    public function supplierBalanceReport() {
        $data = array();
        $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
        $data['outlet_id'] = $outlet_id;
        if($this->input->post('submit')){
            $type = $this->input->post($this->security->xss_clean('type'));
            if($type == 'Debit'){
                $data['suppliers'] = $this->Report_model->getAllDebitSuppliers();
            }else if($type == 'Credit'){
                $data['suppliers'] = $this->Report_model->getAllCreditSuppliers();
            }else{
                $data['suppliers'] = $this->Report_model->getAllSuppliersWithOpeningBalance();
            }
            $data['type'] = $type;
        }else{
            $data['suppliers'] = $this->Report_model->getAllSuppliersWithOpeningBalance();
            $data['type'] = '';
        }
        $data['main_content'] = $this->load->view('report/supplierBalanceReport', $data, TRUE);
        $this->load->view('userHome', $data);
    }



    /**
     * customerLedgerReport
     * @access public
     * @param no
     * @return void
     * Added By Azhar
     */
    public function customerLedgerReport() {
        $data = array();
        $data['type'] = '';
        $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
        $data['outlet_id'] = $outlet_id;
        if($this->input->post('submit')){
            $start_date = $this->input->post($this->security->xss_clean('startDate'));
            $end_date = $this->input->post($this->security->xss_clean('endDate'));
            $type = htmlspecialcharscustom($this->input->post($this->security->xss_clean('type')));
            $ledger_type = htmlspecialcharscustom($this->input->post($this->security->xss_clean('ledger_type')));
            $data['type'] = $type;
            $data['ledger_type'] = $ledger_type;
            if($start_date != ''){
                $this->form_validation->set_rules('endDate', lang('endDate'), 'required|max_length[50]');
            }else if($end_date != ''){
                $this->form_validation->set_rules('startDate', lang('startDate'), 'required|max_length[50]');
            }
            $this->form_validation->set_rules('customer_id', lang('customer'), 'required|max_length[50]');
            $customer_id = ($this->input->post($this->security->xss_clean('customer_id')));
            if($customer_id != ''){
                $c_type = getCustomerOpeningBalanceType($customer_id);
            }
            $data['customer_id'] = $customer_id;
            if($start_date != '' && $end_date != '' && $customer_id != ''){
                $start_date = $this->input->post($this->security->xss_clean('startDate'));
                $end_date = $this->input->post($this->security->xss_clean('endDate'));
                $openingBalanceCalculation = getCustomerOpeningBalance($customer_id, $start_date, $customer_id);
                $data['sum_of_op_before_date'] = $openingBalanceCalculation;
                $data['customerLedger'] = $this->Report_model->customerLedgerReportWithDateRange($start_date, $end_date, $c_type, $customer_id, $outlet_id);
            }else if($customer_id != ''){
                $data['customerLedger'] = $this->Report_model->customerLedgerReportWithDateRange('', '', $c_type, $customer_id, $outlet_id);
            }
        }
        $data['customers'] = $this->Common_model->getAllCustomerNameMobile();
        $data['main_content'] = $this->load->view('report/customerLedgerReport', $data, TRUE);
        $this->load->view('userHome', $data);
    }



    /**
     * customerBalanceReport
     * @access public
     * @param no
     * @return void
     */
    public function customerBalanceReport() {
        $data = array();
        $company_id = $this->session->userdata('company_id');
        if($this->input->post('submit')){
            $type = $this->input->post($this->security->xss_clean('type'));
            $group_id = $this->input->post($this->security->xss_clean('group_id'));
            if($type == 'Debit'){
                $data['customers'] = $this->Report_model->getAllDebitCustomers($group_id);
            }else if($type == 'Credit'){
                $data['customers'] = $this->Report_model->getAllCreditCustomers($group_id);
            }else{
                $data['customers'] = $this->Report_model->getAllCustomersWithOpeningBalance($group_id);
            }
            $data['type'] = $type;
            $data['group_id'] = $group_id;
        }else{
            $data['customers'] = $this->Report_model->getAllCustomersWithOpeningBalance('');
        }
        $data['Groups'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_customer_groups"); 
        $data['main_content'] = $this->load->view('report/customerBalanceReport', $data, TRUE);
        $this->load->view('userHome', $data);
    }




    /**
     * cashFlowReport
     * @access public
     * @param no
     * @return void
     * Added By Azhar
     */
    public function cashFlowReport() {
        $data = array();
        $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
        $data['outlet_id'] = $outlet_id;
        if($this->input->post('submit')){
            $start_date = $this->input->post($this->security->xss_clean('startDate'));
            $end_date = $this->input->post($this->security->xss_clean('endDate'));
            if($start_date != ''){
                $this->form_validation->set_rules('endDate', lang('endDate'), 'required|max_length[50]');
            }else if($end_date != ''){
                $this->form_validation->set_rules('startDate', lang('startDate'), 'required|max_length[50]');
            }
            if($start_date != '' && $end_date != ''){
                $start_date = $this->input->post($this->security->xss_clean('startDate'));
                $end_date = $this->input->post($this->security->xss_clean('endDate'));
                $openingBalanceCalculation = getCashOpeningBalance($start_date);
                $data['sum_of_op_before_date'] = $openingBalanceCalculation;
                $data['cashFlowReport'] = $this->Report_model->cashFlowReport($start_date, $end_date, $outlet_id);
            }else{
                $data['cashFlowReport'] = $this->Report_model->cashFlowReport('', '', $outlet_id);
            }
        }
        $data['main_content'] = $this->load->view('report/cashFlowReport', $data, TRUE);
        $this->load->view('userHome', $data);
    }

}
