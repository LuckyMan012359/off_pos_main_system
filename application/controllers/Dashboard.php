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
    # This is Dashboard Controller
    ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Cl_Controller {

    /**
     * load constructor
     * @access public
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('Authentication_model');
        $this->load->model('Common_model');
        $this->load->model('Dashboard_model');
        $this->load->model('Sale_model');
        $this->load->model('Stock_model');
        $this->load->model('Report_model');
        $this->Common_model->setDefaultTimezone();
        $this->load->library('form_validation');
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
        $controller = "30";
        $function = "";
        if($segment_2=="dashboard" || $segment_2 ==  "operation_comparision_by_date_ajax" || $segment_2 == "comparison_sale_report_ajax_get" || $segment_2 == "get_sale_report_charge" || $segment_2 == "get_sale_report_charge_today"){
            $function = "view";
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
     * dashboard
     * @access public
     * @param no
     * @return void
     */
    public function dashboard() {
        $first_day_this_month  = isset($_POST['startDate']) && $_POST['startDate'] ? $_POST['startDate'] : date('Y-m-01');
        $last_day_this_month  = isset($_POST['endDate']) && $_POST['endDate'] ? $_POST['endDate'] : date('Y-m-t');
        $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id'] ? $_POST['outlet_id'] : '';
        if(!$outlet_id){
            $outlet_id = $this->session->userdata('outlet_id');
        }
        $data['top_ten_food_menu'] = $this->Dashboard_model->top_ten_food_menu($first_day_this_month, $last_day_this_month);
        $data['top_ten_customer'] = $this->Dashboard_model->top_ten_customer($first_day_this_month, $last_day_this_month);
        $data['customer_receivable'] = $this->Common_model->getAllDebitCustomers();
        $data['supplier_payable'] = $this->Report_model->getAllCreditSuppliers();
        $data['purchase_sum'] = $this->Dashboard_model->purchase_sum($first_day_this_month, $last_day_this_month);  
        $data['sale_sum'] = $this->Dashboard_model->sale_sum($first_day_this_month, $last_day_this_month);
        $data['service_sale_total'] = $this->Dashboard_model->serviceSaleTotalAmount($first_day_this_month, $last_day_this_month);
        $data['product_sale_total'] = $this->Dashboard_model->productSaleTotalAmount($first_day_this_month, $last_day_this_month);
        $data['waste_sum'] = $this->Dashboard_model->waste_sum($first_day_this_month, $last_day_this_month);  
        $data['expense_sum'] = $this->Dashboard_model->expense_sum($first_day_this_month, $last_day_this_month);  
        $data['income_sum'] = $this->Dashboard_model->income_sum($first_day_this_month, $last_day_this_month);
        $data['customer_due_receive_sum'] = $this->Dashboard_model->customer_due_receive_sum($first_day_this_month, $last_day_this_month);  
        $data['supplier_due_payment_sum'] = $this->Dashboard_model->supplier_due_payment_sum($first_day_this_month, $last_day_this_month);
        $data['down_payment'] = $this->Dashboard_model->getDownPayment($first_day_this_month, $last_day_this_month);
        $data['paid_amount'] = $this->Dashboard_model->getPaidAmount($first_day_this_month, $last_day_this_month);
        $data['main_content'] = $this->load->view('dashboard/dashboard', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    /**
     * operation_comparision_by_date_ajax
     * @access public
     * @param no
     * @return json
     */
    function operation_comparision_by_date_ajax(){
        $from_this_day = htmlspecialcharscustom($this->input->post($this->security->xss_clean('from_this_day')));
        $to_this_day = htmlspecialcharscustom($this->input->post($this->security->xss_clean('to_this_day')));
        $data = array();
        $data['purchase_sum'] = $this->Dashboard_model->purchase_sum($from_this_day, $to_this_day);  
        $data['sale_sum'] = $this->Dashboard_model->sale_sum($from_this_day, $to_this_day);  
        $data['waste_sum'] = $this->Dashboard_model->waste_sum($from_this_day, $to_this_day);  
        $data['expense_sum'] = $this->Dashboard_model->expense_sum($from_this_day, $to_this_day);  
        $data['customer_due_receive_sum'] = $this->Dashboard_model->customer_due_receive_sum($from_this_day, $to_this_day);  
        $data['supplier_due_payment_sum'] = $this->Dashboard_model->supplier_due_payment_sum($from_this_day, $to_this_day);
        $data['supplier_due_payment_sum'] = $this->Dashboard_model->supplier_due_payment_sum($from_this_day, $to_this_day);
        $data['from_this_day'] = $from_this_day;
        $data['to_this_day'] = $to_this_day;
        echo json_encode($data);
    }


    /**
     * comparison_sale_report_ajax_get
     * @access public
     * @param no
     * @return json
     */
    function comparison_sale_report_ajax_get() {
        $selectedMonth = $_GET['months'];
        $finalOutput = array();
        for ($i = $selectedMonth - 1; $i >= 0; $i--) {
            $dateCalculate = $i > 0 ? '-' . $i : $i;
            $sqlStartDate = date('Y-m-01', strtotime($dateCalculate . ' month'));
            $sqlEndDate = date('Y-m-31', strtotime($dateCalculate . ' month'));
            $saleAmount = $this->Common_model->comparison_sale_report($sqlStartDate, $sqlEndDate);
            $finalOutput[] = array(
                'month' => date('M-y', strtotime($dateCalculate . ' month')),
                'saleAmount' => !empty($saleAmount) ? $saleAmount->total_amount : 0.0,
            );
        }
        echo json_encode($finalOutput);
    }

    
    /**
     * get_sale_report_charge
     * @access public
     * @param no
     * @return json
     */
    function get_sale_report_charge(){
        $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
        $start_date  = isset($_POST['start_date']) && $_POST['start_date']?$_POST['start_date']:'';
        $end_date  = isset($_POST['end_date']) && $_POST['end_date']?$_POST['end_date']:'';
        $type  = isset($_POST['type']) && $_POST['type']?$_POST['type']:'';
        $action_type  = isset($_POST['action_type']) && $_POST['action_type']?$_POST['action_type']:'';
        if(!$outlet_id){
            $outlet_id = $this->session->userdata('outlet_id');
        }
        $return_date_day = array();
        $transaction_details_main = (object)$this->Report_model->getTotalTransaction($start_date, $end_date,$outlet_id);
        if($action_type=="revenue"){
            $day_wise_date = (getSaleDate($start_date,$end_date,$type));
             
            foreach ($day_wise_date as $key=>$value){
                $date_split = explode("||",$value);
                $start_date_generated = date("Y-m-d",strtotime($date_split[0]));
                $start_end_generated = date("Y-m-d",strtotime($date_split[1]));
                $profit_details = (object)$this->Report_model->profitLossReport($start_date_generated, $start_end_generated,$outlet_id,"1");
                $inline_array = array();
                $inline_array['y_value'] = ($profit_details->profit_total_sale - $profit_details->profit_total_discount ?? 0);
                $inline_array['y_label'] =$date_split[2];
                $inline_array['x_label'] =$date_split[3];
                $inline_array['x_label_tmp'] = lang('revenue');
                $return_date_day[] = $inline_array;
            }
        }else if($action_type=="profit"){
            $day_wise_date = (getSaleDate($start_date,$end_date,$type));
            foreach ($day_wise_date as $key=>$value){
                $date_split = explode("||",$value);
                $start_date_generated = date("Y-m-d",strtotime($date_split[0]));
                $start_end_generated = date("Y-m-d",strtotime($date_split[1]));
                $profit_details = (object)$this->Report_model->profitLossReport($start_date_generated, $start_end_generated,$outlet_id,"1");
                $inline_array = array();
                $inline_array['y_value'] = ($profit_details->profit_net);
                $inline_array['y_label'] = $date_split[2];
                $inline_array['x_label'] = $date_split[3];
                $inline_array['x_label_tmp'] = lang('profit');
                $return_date_day[] = $inline_array;
            }
        }else if($action_type=="transactions"){
            $day_wise_date = (getSaleDate($start_date,$end_date,$type));
            foreach ($day_wise_date as $key=>$value){
                $date_split = explode("||",$value);
                $start_date_generated = date("Y-m-d",strtotime($date_split[0]));
                $start_end_generated = date("Y-m-d",strtotime($date_split[1]));
                $profit_details = (object)$this->Report_model->getTotalTransaction($start_date_generated, $start_end_generated,$outlet_id);
                $inline_array = array();
                $inline_array['y_value'] = ($profit_details->total_transaction);
                $inline_array['y_label'] =$date_split[2];
                $inline_array['x_label'] =$date_split[3];
                $inline_array['x_label_tmp'] = lang('transactions');
                $return_date_day[] = $inline_array;
            }
        }else if($action_type=="customers"){
            $day_wise_date = (getSaleDate($start_date,$end_date,$type));
            foreach ($day_wise_date as $key=>$value){
                $date_split = explode("||",$value);
                $start_date_generated = date("Y-m-d",strtotime($date_split[0]));
                $start_end_generated = date("Y-m-d",strtotime($date_split[1]));
                $profit_details = (object)$this->Report_model->getTotalCustomer($start_date_generated, $start_end_generated,$outlet_id);
                $inline_array = array();
                $inline_array['y_value'] = ($profit_details->total_customers);
                $inline_array['y_label'] =$date_split[2];
                $inline_array['x_label'] =$date_split[3];
                $inline_array['x_label_tmp'] = lang('customers');
                $return_date_day[] = $inline_array;
            }
        }else if($action_type=="average_receipt"){
            $day_wise_date = (getSaleDate($start_date,$end_date,$type));
            foreach ($day_wise_date as $key=>$value){
                $date_split = explode("||",$value);
                $start_date_generated = date("Y-m-d",strtotime($date_split[0]));
                $start_end_generated = date("Y-m-d",strtotime($date_split[1]));
                $profit_details = (object)$this->Report_model->profitLossReport($start_date_generated, $start_end_generated, $outlet_id,"1");
                $inline_array = array();
                $inline_array['y_value'] = ($profit_details->profit_total_sale - $profit_details->profit_total_discount) / ($transaction_details_main->total_transaction);
                $inline_array['y_label'] =$date_split[2];
                $inline_array['x_label'] =$date_split[3];
                $inline_array['x_label_tmp'] = lang('average_receipt');
                $return_date_day[] = $inline_array;
            }
        }
        $return_array['data_points'] =  $return_date_day;
        $return_value_set_total_1 = 0;
        $return_value_set_total_2 = 0;
        $return_value_set_total_3 = 0;
        $return_value_set_total_4 = 0;
        $profit_details = (object)$this->Report_model->profitLossReport($start_date, $end_date,$outlet_id,"1");
        $customer_details = (object)$this->Report_model->getTotalCustomer($start_date, $end_date,$outlet_id);
        $return_value_set_total_1+=($profit_details->profit_total_sale - $profit_details->profit_total_discount ?? 0);
        $return_value_set_total_2+=$profit_details->profit_net ?? 0;
        $return_value_set_total_3+=$transaction_details_main->total_transaction;
        $return_value_set_total_4+=$customer_details->total_customers;
        $return_array['set_total_1'] =  getAmtPre($return_value_set_total_1);
        $return_array['set_total_2'] =  getAmtPre($return_value_set_total_2);
        $return_array['set_total_3'] =  getAmtPre($return_value_set_total_3);
        $return_array['set_total_4'] =  getAmtPre($return_value_set_total_4);
        echo json_encode($return_array);
    }

    /**
     * get_sale_report_charge_today
     * @access public
     * @param no
     * @return json
     */
    function get_sale_report_charge_today(){
        $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
        $start_date  = date('Y-m-d');
        $end_date  =date('Y-m-d');
        if(!$outlet_id){
            $outlet_id = $this->session->userdata('outlet_id');
        }
        $transaction_details_main = (object)$this->Report_model->getTotalTransaction($start_date, $end_date,$outlet_id);
        $return_value_set_total_1 = 0;
        $return_value_set_total_2 = 0;
        $return_value_set_total_3 = 0;
        $return_value_set_total_4 = 0;
        $profit_details = (object)$this->Report_model->profitLossReport($start_date, $end_date,$outlet_id,"1");
        $customer_details = (object)$this->Report_model->getTotalCustomer($start_date, $end_date,$outlet_id);
        $return_value_set_total_1 += ($profit_details->profit_total_sale - $profit_details->profit_total_discount ?? 0);
        $return_value_set_total_2 += $profit_details->profit_net ?? 0;
        $return_value_set_total_3 += $transaction_details_main->total_transaction;
        $return_value_set_total_4 += $customer_details->total_customers;
        $return_array['set_total_1'] =  getAmtPre($return_value_set_total_1);
        $return_array['set_total_2'] =  getAmtPre($return_value_set_total_2);
        $return_array['set_total_3'] =  getAmtPre($return_value_set_total_3);
        $return_array['set_total_4'] =  getAmtPre($return_value_set_total_4);
        echo json_encode($return_array);
    }
}
