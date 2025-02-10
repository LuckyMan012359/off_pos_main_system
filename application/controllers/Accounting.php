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
  # This is Accounting Controller
  ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Accounting extends Cl_Controller {

    /**
     * load constructor
     * @access public
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->model('Authentication_model');
        $this->load->model('Accounting_model');
        $this->Common_model->setDefaultTimezone();
        $this->load->library('form_validation');
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }

        //start check access function
        $segment_2 = $this->uri->segment(2);
        $controller = "";
        $function = "";
        if($segment_2=="balanceStatement"){
            $controller = "228";
            $function = "list";
        }elseif($segment_2=="trialBalance"){
            $controller = "230";
            $function = "list";
        }elseif($segment_2=="balanceSheet"){
            $controller = "232";
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
     * balanceStatement
     * @access public
     * @param no
     * @return void
     */
    public function balanceStatement() {
        $company_id = $this->session->userdata('company_id');
        if($this->input->post('submit')){
            $start_date = $this->input->post($this->security->xss_clean('startDate'));
            $end_date = $this->input->post($this->security->xss_clean('endDate'));
            $type = htmlspecialcharscustom($this->input->post($this->security->xss_clean('type')));
            $data['type'] = $type;
            $data['startDate'] = $start_date;
            $data['endDate'] = $end_date;
            if($start_date != ''){
                $this->form_validation->set_rules('endDate', lang('endDate'), 'required|max_length[50]');
            }else if($end_date != ''){
                $this->form_validation->set_rules('startDate', lang('startDate'), 'required|max_length[50]');
            }
            $this->form_validation->set_rules('account_id', lang('account'), 'required|max_length[50]');
            $start_date = date('Y-m-d',strtotime($this->input->post($this->security->xss_clean('startDate'))));
            $end_date = date('Y-m-d',strtotime($this->input->post($this->security->xss_clean('endDate'))));
            $account_id = ($this->input->post($this->security->xss_clean('account_id')));
            $data['account_id'] = $account_id;
            $finalArr = [];
            $op_balance = $this->Accounting_model->getOpeningBalance($account_id, $start_date, $type);
            $opArr = array();
            $opArr['type']="Opening Balance";
            $opArr['date']= $op_balance[2];
            $opArr['account_type']= '';
            $opArr['note']= '';
            $opArr['credit']= (int)$op_balance[0];
            $opArr['debit']= (int)$op_balance[1];
            $opArr = (object) $opArr;
            if($type == 1 || $type=="all"){
                $creditBalanceStatement = $this->Accounting_model->creditBalanceStatement($start_date, $end_date, $account_id);
            }else{
                $creditBalanceStatement = [];
            }
            if($type == 2 || $type=="all"){
                $debitBalanceStatement = $this->Accounting_model->debitBalanceStatement($start_date, $end_date, $account_id);
            }else{
                $debitBalanceStatement = [];
            }
            $finalArr = array_merge($debitBalanceStatement, $finalArr);
            $finalArr = array_merge($creditBalanceStatement, $finalArr);
            array_splice($finalArr, 0, 0, [$opArr]);
            $data['balance_statement'] = $finalArr;
        }else{
            $data['balance_statement'] = [];
        }
        $data['payment_methods'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_payment_methods");
        $data['main_content'] = $this->load->view('accounting/balanceStatement', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    /**
     * trialBalance
     * @access public
     * @param no
     * @return void
     */
    public function trialBalance() {
        $data = array();
        if($this->input->post('submit')){
            $this->form_validation->set_rules('date', lang('date'), 'required');
            if ($this->form_validation->run() == TRUE) {
                $start_date = date('Y-m-d',strtotime($this->input->post($this->security->xss_clean('date'))));
                $data['start_date'] = $start_date; 
                $data['trial_balance'] = $this->Accounting_model->trialBalance($start_date);
            }
        }
        $data['main_content'] = $this->load->view('accounting/trialBalance', $data, TRUE);
        $this->load->view('userHome', $data);

    }

    /**
     * balanceSheet
     * @access public
     * @param no
     * @return void
     */
    public function balanceSheet() {
        $company_id = $this->session->userdata('company_id');
        $data = array();
        $data['payment_methods'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_payment_methods");
        foreach ($data['payment_methods'] as $key=>$value){
            $getInfo = $this->Accounting_model->getBalanceSheet($value->id);
            $data['payment_methods'][$key]->credit_balance = $getInfo[0];
            $data['payment_methods'][$key]->debit_balance = $getInfo[1];
        }
        $data['main_content'] = $this->load->view('accounting/balanceSheet', $data, TRUE);
        $this->load->view('userHome', $data);
    }
}
