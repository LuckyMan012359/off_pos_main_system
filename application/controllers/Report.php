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
    # This is Report Controller
    ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends Cl_Controller {

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
        if (!$this->session->has_userdata('outlet_id')) {
            $this->session->set_flashdata('exception_2', lang('Please_click_on_Enter_button_of_an_outlet'));
            $this->session->set_userdata("clicked_controller", $this->uri->segment(1));
            $this->session->set_userdata("clicked_method", $this->uri->segment(2));
            redirect('Outlet/outlets');
        }

        //start check access function
        $segment_1 = $this->uri->segment(1);
        $segment_2 = $this->uri->segment(2);
        $controller = "249";
        $function = "";
        if(($segment_1=="Report" && $segment_2 == "registerReport") || ($segment_1=="Report" && $segment_2 == "registerIndividualByDate")){
            $function = "register_report";
        }elseif($segment_1=="Report" && $segment_2 == "customerDueReceiveReport"){
            $function = "customer_receive_report";
        }elseif($segment_1=="Report" && $segment_2 == "dailySummaryReport" || $segment_1=="Report" && $segment_2 == "printDailySummaryReport" ){
            $function = "daily_summary_report";
        }elseif($segment_1=="Report" && $segment_2 == "saleReport" || $segment_2 == 'dueSaleReport'){
            $function = "sale_report";
        }elseif($segment_1=="Report" && $segment_2 == "serviceSaleReport"){
            $function = "service_sale_report";
        }elseif($segment_1=="Report" && $segment_2 == "comboServiceReport"){
            $function = "service_sale_report";
        }elseif($segment_1=="Report" && $segment_2 == "employeeSaleReport"){
            $function = "employee_sale_report";
        }elseif($segment_1=="Report" && $segment_2 == "productSaleReport"){
            $function = "product_sale_report";
        }elseif($segment_1=="Report" && $segment_2 == "detailedSaleReport"){
            $function = "detailed_sale_report";
        }elseif($segment_1=="Report" && ($segment_2 == "stockReport" || $segment_2 == 'expiryStock' )){
            $function = "stock_report";
        }elseif($segment_1=="Report" && $segment_2 == "getStockAlertList"){
            $function = "low_stock_report";
        }elseif($segment_1=="Report" && $segment_2 == "profitLossReport"){
            $function = "profit_loss_report";
        }elseif($segment_1=="Report" && $segment_2 == "productProfitReport"){
            $function = "product_profit_report";
        }elseif($segment_1=="Report" && $segment_2 == "attendanceReport"){
            $function = "attendance_report";
        }elseif($segment_1=="Report" && $segment_2 == "purchaseReportByDate"){
            $function = "purchase_report";
        }elseif($segment_1=="Report" && $segment_2 == "productPurchaseReport"){
            $function = "product_purchase_report";
        }elseif($segment_1=="Report" && $segment_2 == "expenseReport"){
            $function = "expense_report";
        }elseif($segment_1=="Report" && $segment_2 == "incomeReport"){
            $function = "income_report";
        }elseif($segment_1=="Report" && $segment_2 == "salaryReport"){
            $function = "salary_report";
        }elseif($segment_1=="Report" && $segment_2 == "purchaseReturnReport"){
            $function = "purchase_return_report";
        }elseif($segment_1=="Report" && $segment_2 == "saleReturnReport"){
            $function = "sale_return_report";
        }elseif($segment_1=="Report" && $segment_2 == "damageReport"){
            $function = "damage_report";
        }elseif($segment_1=="Report" && $segment_2 == "installmentReport"){
            $function = "installment_report";
        }elseif($segment_1=="Report" && $segment_2 == "installmentDueReport"){
            $function = "installment_due_report";
        }elseif($segment_1=="Report" && $segment_2 == "taxReport"){
            $function = "tax_report";
        }elseif($segment_1=="Report" && $segment_2 == "servicingReport"){
            $function = "servicing_report";
        }elseif($segment_1=="Report" && $segment_2 == "itemMoving"){
            $function = "item_tracing_report";
        }elseif($segment_1=="Report" && $segment_2 == "priceHistory"){
            $function = "price_history_report";
        }elseif($segment_1=="Report" && $segment_2 == "cashFlowReport"){
            $function = "cash_flow_report";
        }elseif($segment_1=="Report" && $segment_2 == "zReport"){
            $function = "zReport";
        }elseif($segment_1=="Report" && $segment_2 == "availableLoyaltyPointReport"){
            $function = "available_loyalty_point";
        }elseif($segment_1=="Report" && $segment_2 == "usageLoyaltyPointReport"){
            $function = "usage_loyalty_point";
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
     * registerReport
     * @access public
     * @param no
     * @return void
     */
    public function registerReport(){
        $data = array();
        $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id'] ? $_POST['outlet_id'] : '';
        $data['outlet_id'] = $outlet_id;
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $data['report_generate_time'] = generatedOnCurrentDateTime();
            $start_date = date("Y-m-d", strtotime($this->input->post('startDate')));
            $registerDetails = htmlspecialcharscustom($this->input->post($this->security->xss_clean('registerDetails')));
            $user_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('user_id')));
            $data['register_info'] = $this->Report_model->getRegisterInformation($registerDetails);
            $data['start_date'] = $start_date;
            $data['user_id'] = $user_id;
        }
        $data['users'] = $this->Common_model->getAllUsersNameMobileForReportDropdown();
        $data['main_content'] = $this->load->view('report/registerReport', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    /**
     * registerIndividualByDate
     * @access public
     * @param no
     * @return void
     */
    public function registerIndividualByDate() {
        $selectDate = htmlspecialcharscustom($this->input->post($this->security->xss_clean('selectDate')));
        $user_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('user_id')));
        $outlet_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('outlet_id')));
        $registerDetails = $this->Report_model->registerDetailsByDate($selectDate, $user_id, $outlet_id);
        $response = [
            'status' => 'success',
            'data' =>  $registerDetails,
        ];	
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }  

    
    /**
     * customerDueReceiveReport
     * @access public
     * @param no
     * @return void
     */
    public function customerDueReceiveReport() {
        $data = array();
        $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id'] ? $_POST['outlet_id'] : '';
        $data['outlet_id'] = $outlet_id;
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $data['report_generate_time'] = generatedOnCurrentDateTime();
            $start_date = $this->input->post($this->security->xss_clean('startDate'));
            $end_date = $this->input->post($this->security->xss_clean('endDate'));
            $customer_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('customer_id')));
            $data['customer_id'] = $customer_id;
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $data['customerDueReceive'] = $this->Report_model->customerDueReceiveReport($start_date, $end_date, $customer_id, $outlet_id);
        }
        $data['customers'] = $this->Common_model->getAllCustomerNameMobile();
        $data['main_content'] = $this->load->view('report/customerDueReceive', $data, TRUE);
        $this->load->view('userHome', $data);
    }


    /**
     * dailySummaryReport
     * @access public
     * @param no
     * @return void
     */
    public function dailySummaryReport() {
        $data = array();
        $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id'] ? $_POST['outlet_id']:'';
        $data['outlet_id'] = $outlet_id;
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $data['report_generate_time'] = generatedOnCurrentDateTime();
            if($this->input->post('date')) {
                $selectedDate = date("Y-m-d", strtotime($this->input->post('date')));
            } else {
                $selectedDate = '';
            }
            $data['result'] = $this->Report_model->dailySummaryReport($selectedDate,$outlet_id);
            $data['selectedDate'] = $selectedDate;
        } else {
            $selectedDate = date("Y-m-d");
            $data['result'] = $this->Report_model->dailySummaryReport($selectedDate,$outlet_id);
            $data['selectedDate'] = $selectedDate;
        }
        $data['main_content'] = $this->load->view('report/dailySummaryReport', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    /**
     * printDailySummaryReport
     * @access public
     * @param string
     * @return void
     */
    public function printDailySummaryReport($selectedDate = ''){
        $data = array();
        $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id'] ? $_POST['outlet_id']:'';
        $data['outlet_id'] = $outlet_id;
        $data['result'] = $this->Report_model->dailySummaryReport($selectedDate,$outlet_id);
        $data['selectedDate'] = $selectedDate;
        $this->load->view('report/printDailySummaryReport', $data);
    }

    /**
     * saleReport
     * @access public
     * @param no
     * @return void
     */
    public function saleReport() {
        $data = array();
        $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
        $data['outlet_id'] = $outlet_id;
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $data['report_generate_time'] = generatedOnCurrentDateTime();
            $start_date = htmlspecialcharscustom($this->input->post($this->security->xss_clean('startDate')));
            $end_date = htmlspecialcharscustom($this->input->post($this->security->xss_clean('endDate')));
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $data['saleReport'] = $this->Report_model->saleReport($start_date, $end_date, $outlet_id);
        }
        $data['main_content'] = $this->load->view('report/saleReport', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    /**
     * dueSaleReport
     * @access public
     * @param no
     * @return void
     */
    public function dueSaleReport() {
        $data = array();
        $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id'] ? $_POST['outlet_id'] : '';
        $data['outlet_id'] = $outlet_id;
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $data['report_generate_time'] = generatedOnCurrentDateTime();
            $start_date = htmlspecialcharscustom($this->input->post($this->security->xss_clean('startDate')));
            $end_date = htmlspecialcharscustom($this->input->post($this->security->xss_clean('endDate')));
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $data['dueSaleReport'] = $this->Report_model->dueSaleReport($start_date, $end_date, $outlet_id);
        }
        $data['main_content'] = $this->load->view('report/dueSaleReport', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    /**
     * serviceSaleReport
     * @access public
     * @param no
     * @return void
     */
    public function serviceSaleReport() {
        $data = array();
        $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
        $data['outlet_id'] = $outlet_id;
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $data['report_generate_time'] = generatedOnCurrentDateTime();
            $start_date = htmlspecialcharscustom($this->input->post($this->security->xss_clean('startDate')));
            $end_date = htmlspecialcharscustom($this->input->post($this->security->xss_clean('endDate')));
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $data['serviceSaleReport'] = $this->Report_model->serviceSaleReport($start_date, $end_date, $outlet_id);
        }
        $data['main_content'] = $this->load->view('report/serviceSaleReport', $data, TRUE);
        $this->load->view('userHome', $data);
    }


    /**
     * comboServiceReport
     * @access public
     * @param no
     * @return void
     */
    public function comboServiceReport() {
        $data = array();
        $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
        $data['outlet_id'] = $outlet_id;
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $data['report_generate_time'] = generatedOnCurrentDateTime();
            $start_date = htmlspecialcharscustom($this->input->post($this->security->xss_clean('startDate')));
            $end_date = htmlspecialcharscustom($this->input->post($this->security->xss_clean('endDate')));
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $data['comboServiceReport'] = $this->Report_model->comboServiceReport($start_date, $end_date, $outlet_id);
            // pre($data['comboServiceReport']);
        }
        $data['main_content'] = $this->load->view('report/comboServiceReport', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    /**
     * employeeSaleReport
     * @access public
     * @param no
     * @return void
     */
    public function employeeSaleReport() {
        $data = array();
        $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
        $data['outlet_id'] = $outlet_id;
        $data['product_invoice'] = '';
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $data['report_generate_time'] = generatedOnCurrentDateTime();
            $start_date = htmlspecialcharscustom($this->input->post($this->security->xss_clean('startDate')));
            $end_date = htmlspecialcharscustom($this->input->post($this->security->xss_clean('endDate')));
            $user_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('user_id')));
            $product_invoice = htmlspecialcharscustom($this->input->post($this->security->xss_clean('product_invoice')));
            $data['user_id'] = $user_id;
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $data['product_invoice'] = $product_invoice;
            if($product_invoice == 'Combo_Product_Wise'){
                $data['employeeSaleReport'] = $this->Report_model->commboWiseEmployeeReport($start_date, $end_date, $outlet_id, $user_id, $product_invoice);
            }else if($product_invoice == 'Invoice_Wise'){
                $data['employeeSaleReport'] = $this->Report_model->saleWiseEmployeeReport($start_date, $end_date, $outlet_id, $user_id, $product_invoice);
            }else{
                $data['employeeSaleReport'] = $this->Report_model->productWiseEmployeeReport($start_date, $end_date, $outlet_id, $user_id, $product_invoice);
            }
            $data['userInfo'] = getUserName($user_id);
        }
        // pre($data['employeeSaleReport']);
        $data['users'] = $this->Common_model->getAllUsersNameMobileForReportDropdown();
        $data['main_content'] = $this->load->view('report/employeeSaleReport', $data, TRUE);
        $this->load->view('userHome', $data);
    }


    /**
     * productSaleReport
     * @access public
     * @param no
     * @return void
     */
    public function productSaleReport() {
        $data = array();
        $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
        $data['outlet_id'] = $outlet_id;
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $data['report_generate_time'] = generatedOnCurrentDateTime();
            $start_date = htmlspecialcharscustom($this->input->post($this->security->xss_clean('startDate')));
            $end_date = htmlspecialcharscustom($this->input->post($this->security->xss_clean('endDate')));
            $items_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('items_id')));
            $customer_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('customer_id')));
            $data['items_id'] = $items_id;
            $data['customer_id'] = $customer_id;
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $data['productSaleReport'] = $this->Report_model->productSaleReport($start_date, $end_date, $items_id, $customer_id, $outlet_id);
        }
        $data['items'] = $this->Common_model->getAllItemNameCodeWithoutVariation();
        $data['users'] = $this->Common_model->getAllUsersNameMobileForReportDropdown();
        $data['customers'] = $this->Common_model->getAllCustomerNameMobile();
        $data['main_content'] = $this->load->view('report/productSaleReport', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    /**
     * detailedSaleReport
     * @access public
     * @param no
     * @return void
     */
    public function detailedSaleReport() {
        $data = array();
        $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
        $data['outlet_id'] = $outlet_id;
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $data['report_generate_time'] = generatedOnCurrentDateTime();
            $start_date = htmlspecialcharscustom($this->input->post($this->security->xss_clean('startDate')));
            $end_date = htmlspecialcharscustom($this->input->post($this->security->xss_clean('endDate')));
            $user_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('user_id')));
            $data['user_id'] = $user_id;
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $data['detailedSaleReport'] = $this->Report_model->detailedSaleReport($start_date, $end_date, $user_id, $outlet_id);
            if (!empty($data['detailedSaleReport'])) {
                foreach ($data['detailedSaleReport'] as $key=>$value){
                    $data['detailedSaleReport'][$key]->items = $this->Common_model->getDataCustomName("tbl_sales_details","sales_id", $value->id);
                }
            }
        }
        $data['users'] = $this->Common_model->getAllUsersNameMobileForReportDropdown();
        $data['main_content'] = $this->load->view('report/detailedSaleReport', $data, TRUE);
        $this->load->view('userHome', $data);
    }
    
    /**
     * stockReport
     * @access public
     * @param no
     * @return void
     */
    public function stockReport() {
        $data = array();
        $company_id = $this->session->userdata('company_id');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $data['report_generate_time'] = generatedOnCurrentDateTime();
            $generic_name = htmlspecialcharscustom($this->input->post($this->security->xss_clean('generic_name')));
            $item_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('item_id')));
            $item_code = htmlspecialcharscustom($this->input->post($this->security->xss_clean('item_code')));
            $brand_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('brand_id')));
            $category_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('category_id')));
            $supplier_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('supplier_id')));
            $outlet_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('outlet_id')));
            $data['stock'] = $this->Report_model->getStockReport($item_id,$item_code,$brand_id,$category_id,$supplier_id, $generic_name, $outlet_id);
            $data['item_code'] = $item_code;
            $data['category_id'] = $category_id;
            $data['brand_id'] = $brand_id;
            $data['generic_name'] = $generic_name;
            $data['supplier_id'] = $supplier_id;
            $data['outlet_id'] = $outlet_id;
            $data['item_id'] = $item_id;
        }
        $data['item_categories'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_item_categories");
        $data['items'] = $this->Common_model->getAllDropdownItemByCompanyId($company_id, "tbl_items");
        $data['brands'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_brands');
        $data['suppliers'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_suppliers');
        $data['main_content'] = $this->load->view('report/stockReport', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    /**
     * expiryStock
     * @access public
     * @param no
     * @return void
     */
    public function expiryStock() {
        $data = array();
        $company_id = $this->session->userdata('company_id');
        $data['expire_within'] = '';
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $data['report_generate_time'] = generatedOnCurrentDateTime();
            $generic_name = htmlspecialcharscustom($this->input->post($this->security->xss_clean('generic_name')));
            $expire_within = htmlspecialcharscustom($this->input->post($this->security->xss_clean('expire_within')));
            $outlet_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('outlet_id')));
            $data['stock'] = $this->Report_model->getExpiryStock($generic_name, $outlet_id);
            $data['generic_name'] = $generic_name;
            $data['expire_within'] = $expire_within;
            $data['outlet_id'] = $outlet_id;
        }
        $data['item_categories'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_item_categories");
        $data['items'] = $this->Common_model->getAllDropdownItemByCompanyId($company_id, "tbl_items");
        $data['brands'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_brands');
        $data['suppliers'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_suppliers');
        $data['main_content'] = $this->load->view('report/expiryStock', $data, TRUE);
        $this->load->view('userHome', $data);
    }


    /**
     * getStockAlertList
     * @access public
     * @param no
     * @return void
     */
    public function getStockAlertList() {
        $data = array();
        $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
        $data['outlet_id'] = $outlet_id;
        $company_id = $this->session->userdata('company_id');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $data['report_generate_time'] = generatedOnCurrentDateTime();
            $generic_name = htmlspecialcharscustom($this->input->post($this->security->xss_clean('generic_name')));
            $item_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('item_id')));
            $item_code = htmlspecialcharscustom($this->input->post($this->security->xss_clean('item_code')));
            $brand_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('brand_id')));
            $category_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('category_id')));
            $supplier_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('supplier_id')));
            $outlet_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('outlet_id')));
            $data['stock'] = $this->Report_model->getStockAlertList($item_id,$item_code,$brand_id,$category_id,$supplier_id, $generic_name, $outlet_id);
            $data['item_code'] = $item_code;
            $data['category_id'] = $category_id;
            $data['brand_id'] = $brand_id;
            $data['generic_name'] = $generic_name;
            $data['supplier_id'] = $supplier_id;
            $data['outlet_id'] = $outlet_id;
            $data['item_id'] = $item_id;
        }
        $data['item_categories'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_item_categories");
        $data['items'] = $this->Common_model->getAllDropdownItemByCompanyId($company_id, "tbl_items");
        $data['brands'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_brands');
        $data['suppliers'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_suppliers');
        $data['main_content'] = $this->load->view('report/stockAlertList', $data, TRUE);
        $this->load->view('userHome', $data);
    }


    /**
     * profitLossReport
     * @access public
     * @param no
     * @return void
     */
    public function profitLossReport(){
        $data = array();
        $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
        $calculation_formula  = isset($_POST['calculation_formula']) && $_POST['calculation_formula']?$_POST['calculation_formula']:'';
        $data['calculation_formula'] = $calculation_formula;
        $data['outlet_id'] = $outlet_id;
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $data['report_generate_time'] = generatedOnCurrentDateTime();
            if(htmlspecialcharscustom($this->input->post('startDate'))){
                $start_date = date("Y-m-d", strtotime(htmlspecialcharscustom($this->input->post('startDate'))));
            }else{
                $start_date = '';
            }
            if(htmlspecialcharscustom($this->input->post('endDate'))){
                $end_date = date("Y-m-d", strtotime(htmlspecialcharscustom($this->input->post('endDate'))));
            }else{
                $end_date = '';
            }
            $data['saleReportByDate'] = $this->Report_model->profitLossReport($start_date,$end_date,$outlet_id, $calculation_formula);
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
        }
        $data['main_content'] = $this->load->view('report/profitLossReport', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    /**
     * productProfitReport
     * @access public
     * @param no
     * @return void
     */
    public function productProfitReport() {
        $data = array();
        $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
        $calculation_formula  = isset($_POST['calculation_formula']) && $_POST['calculation_formula']?$_POST['calculation_formula']:'';
        $data['calculation_formula'] = $calculation_formula;
        $data['outlet_id'] = $outlet_id;
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $data['report_generate_time'] = generatedOnCurrentDateTime();
            $item_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('item_id')));
            $start_date = htmlspecialcharscustom($this->input->post($this->security->xss_clean('startDate')));
            $end_date = htmlspecialcharscustom($this->input->post($this->security->xss_clean('endDate')));
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $data['item_id'] = $item_id;
            $data['productProfitReport'] = $this->Report_model->productProfitReport($item_id,$start_date, $end_date, $outlet_id);
        }
        $data['items'] = $this->Common_model->getAllItemNameCodeWithoutVariation();
        $data['main_content'] = $this->load->view('report/productProfitReport', $data, TRUE);
        $this->load->view('userHome', $data);
    }


    /**
     * attendanceReport
     * @access public
     * @param no
     * @return void
     */
    public function attendanceReport() {
        $data = array();
        $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
        $data['outlet_id'] = $outlet_id;
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $data['report_generate_time'] = generatedOnCurrentDateTime();
            $start_date = htmlspecialcharscustom($this->input->post($this->security->xss_clean('startDate')));
            $end_date = htmlspecialcharscustom($this->input->post($this->security->xss_clean('endDate')));
            $employee_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('employee_id')));
            $data['employee_id'] = $employee_id;
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $data['attendanceReport'] = $this->Report_model->attendanceReport($start_date, $end_date, $employee_id);
        }
        $data['employees'] = $this->Common_model->getAllUsersNameMobileForReportDropdown();
        $data['main_content'] = $this->load->view('report/attendanceReport', $data, TRUE);
        $this->load->view('userHome', $data);
    }  



    /**
     * purchaseReportByDate
     * @access public
     * @param no
     * @return void
     */
    public function purchaseReportByDate() {
        $data = array();
        $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
        $data['outlet_id'] = $outlet_id;
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $data['report_generate_time'] = generatedOnCurrentDateTime();
            $start_date = htmlspecialcharscustom($this->input->post($this->security->xss_clean('startDate')));
            $end_date = htmlspecialcharscustom($this->input->post($this->security->xss_clean('endDate')));
            $supplier_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('supplier_id')));
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $data['supplier_id'] = $supplier_id;
            $data['purchaseReportByDate'] = $this->Report_model->purchaseReportByDate($start_date, $end_date, $supplier_id, $outlet_id);
        }
        $data['suppliers'] = $this->Common_model->getAllSupplierNameMobile();
        $data['main_content'] = $this->load->view('report/purchaseReportByDate', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    /**
     * productPurchaseReport
     * @access public
     * @param no
     * @return void
     */
    public function productPurchaseReport() {
        $data = array();
        $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
        $data['outlet_id'] = $outlet_id;
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $data['report_generate_time'] = generatedOnCurrentDateTime();
            $start_date = htmlspecialcharscustom($this->input->post($this->security->xss_clean('startDate')));
            $end_date = htmlspecialcharscustom($this->input->post($this->security->xss_clean('endDate')));
            $items_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('items_id')));
            $supplier_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('supplier_id')));
            $menu_note = htmlspecialcharscustom($this->input->post($this->security->xss_clean('menu_note')));
            $data['items_id'] = $items_id;
            $data['supplier_id'] = $supplier_id;
            $data['menu_note'] = $menu_note;
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $data['productPurchaseReport'] = $this->Report_model->productPurchaseReport($start_date, $end_date, $items_id, $supplier_id, $menu_note, $outlet_id);
        }
        $data['items'] = $this->Common_model->getAllItemNameCodeWithoutVariation();
        $data['suppliers'] = $this->Common_model->getAllSupplierNameMobile();
        $data['main_content'] = $this->load->view('report/productPurchaseReport', $data, TRUE);
        $this->load->view('userHome', $data);
    }


    /**
     * expenseReport
     * @access public
     * @param no
     * @return void
     */
    public function expenseReport() {
        $data = array();
        $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
        $data['outlet_id'] = $outlet_id;
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $data['report_generate_time'] = generatedOnCurrentDateTime();
            $start_date = $this->input->post($this->security->xss_clean('startDate'));
            $end_date = $this->input->post($this->security->xss_clean('endDate'));
            $expense_item_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('expense_item_id')));
            $data['expense_item_id'] = $expense_item_id;
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $data['expenseReport'] = $this->Report_model->expenseReport($start_date, $end_date, $expense_item_id, $outlet_id);
        }
        $data['expense_items'] = $this->Common_model->getAllExpenseCategory();
        $data['main_content'] = $this->load->view('report/expenseReport', $data, TRUE);
        $this->load->view('userHome', $data);
    }



    /**
     * incomeReport
     * @access public
     * @param no
     * @return void
     */
    public function incomeReport() {
        $data = array();
        $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
        $data['outlet_id'] = $outlet_id;
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $data['report_generate_time'] = generatedOnCurrentDateTime();
            $start_date = $this->input->post($this->security->xss_clean('startDate'));
            $end_date = $this->input->post($this->security->xss_clean('endDate'));
            $income_item_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('income_item_id')));
            $data['income_item_id'] = $income_item_id;
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $data['incomeReport'] = $this->Report_model->incomeReport($start_date, $end_date, $income_item_id, $outlet_id);
        }
        $data['income_items'] = $this->Common_model->getAllIncomeCategory();
        $data['main_content'] = $this->load->view('report/incomeReport', $data, TRUE);
        $this->load->view('userHome', $data);
    }


    /**
     * salaryReport
     * @access public
     * @param no
     * @return void
     */
    public function salaryReport() {
        $data = array();
        $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
        $data['outlet_id'] = $outlet_id;
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $data['report_generate_time'] = generatedOnCurrentDateTime();
            $startMonth = $this->input->post($this->security->xss_clean('startMonth'));
            $endMonth = $this->input->post($this->security->xss_clean('endMonth'));
            $startYear = $this->input->post($this->security->xss_clean('startYear'));
            $endYear = $this->input->post($this->security->xss_clean('endYear'));
            $startMonthNo = monthNumberByMonthName($startMonth);
            $endMonthNo = monthNumberByMonthName($endMonth);
            $data['startMonth'] = $startMonth;
            $data['endMonth'] = $endMonth;
            $data['startYear'] = $startYear;
            $data['endYear'] = $endYear;
            $data['salaryReport'] = $this->Report_model->salaryReport($startMonthNo,$endMonthNo,$startYear,$endYear,$outlet_id);
        }
        $data['main_content'] = $this->load->view('report/salaryReport', $data, TRUE);
        $this->load->view('userHome', $data);
    }


    /**
     * purchaseReturnReport
     * @access public
     * @param no
     * @return void
     */
    public function purchaseReturnReport() {
        $data = array();
        $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
        $data['outlet_id'] = $outlet_id;
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $data['report_generate_time'] = generatedOnCurrentDateTime();
            $start_date = $this->input->post($this->security->xss_clean('startDate'));
            $end_date = $this->input->post($this->security->xss_clean('endDate'));
            $supplier_id = $this->input->post($this->security->xss_clean('supplier_id'));
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $data['supplier_id'] = $supplier_id;
            $data['purchaseReturnReport'] = $this->Report_model->purchaseReturnReport($start_date, $end_date, $supplier_id, $outlet_id);
        }
        $data['suppliers'] = $this->Common_model->getAllSupplierNameMobile();
        $data['main_content'] = $this->load->view('report/purchaseReturnReport', $data, TRUE);
        $this->load->view('userHome', $data);
    }




    /**
     * saleReturnReport
     * @access public
     * @param no
     * @return void
     */
    public function saleReturnReport() {
        $data = array();
        $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
        $data['outlet_id'] = $outlet_id;
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $data['report_generate_time'] = generatedOnCurrentDateTime();
            $start_date = $this->input->post($this->security->xss_clean('startDate'));
            $end_date = $this->input->post($this->security->xss_clean('endDate'));
            $customer_id = $this->input->post($this->security->xss_clean('customer_id'));
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $data['customer_id'] = $customer_id;
            $data['saleReturnReport'] = $this->Report_model->saleReturnReport($start_date, $end_date, $customer_id, $outlet_id);
        } 
        $data['customers'] = $this->Common_model->getAllCustomerNameMobile();
        $data['main_content'] = $this->load->view('report/saleReturnReport', $data, TRUE);
        $this->load->view('userHome', $data);
    }



    /**
     * damageReport
     * @access public
     * @param no
     * @return void
     */
    public function damageReport() {
        $data = array();
        $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
        $data['outlet_id'] = $outlet_id;
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $data['report_generate_time'] = generatedOnCurrentDateTime();
            $startDate = $this->input->post($this->security->xss_clean('startDate'));
            $endDate = $this->input->post($this->security->xss_clean('endDate'));
            $employee_id = $this->input->post($this->security->xss_clean('user_id'));
            $data['damageReport'] = $this->Report_model->damageReport($startDate, $endDate, $employee_id, $outlet_id);
            $data['startDate'] = $startDate;
            $data['endDate'] = $endDate;
            $data['employee_id'] = $employee_id;
        }
        $data['users'] = $this->Common_model->getAllUsersNameMobileForReportDropdown();
        $data['main_content'] = $this->load->view('report/damageReport', $data, TRUE);
        $this->load->view('userHome', $data);
    }


    /**
     * installmentReport
     * @access public
     * @param no
     * @return void
     */
    public function installmentReport() {
        $data = array();
        $company_id = $this->session->userdata('company_id');
        $customer_id = $this->input->post($this->security->xss_clean('customer_id'));
        $installment_encrypt_id = $this->input->post($this->security->xss_clean('installment_id'));
        $installment_id = $this->custom->encrypt_decrypt($installment_encrypt_id, 'decrypt');
        $paid_status = $this->input->post($this->security->xss_clean('paid_status'));
        $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
        $data['outlet_id'] = $outlet_id;
        $data['customer_id'] = $customer_id;
        $data['paid_status'] = $paid_status;
        $data['customers'] = $this->Common_model->getCustomerByType($company_id, "tbl_customers", "installment");
        if ($this->input->post('submit')) {
            $data['payments'] = $this->Installment_model->getAllInstallmentPayments($customer_id,$installment_id,$paid_status,$outlet_id);
        }
        $data['main_content'] = $this->load->view('report/installmentCollectionReport', $data, TRUE);
        $this->load->view('userHome', $data);
    }


    /**
     * installmentDueReport
     * @access public
     * @param no
     * @return void
     */
    public function installmentDueReport() {
        $data = array();
        $company_id = $this->session->userdata('company_id');
        $customer_id = $this->input->post($this->security->xss_clean('customer_id'));
        $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
        $data['outlet_id'] = $outlet_id;
        $data['customers'] = $this->Common_model->getCustomerByType($company_id, "tbl_customers","installment");
        $data['customer_id'] = $customer_id;
        if($this->input->post('submit')  && $customer_id){
            $data['installments'] = $this->Report_model->installmentDueReport($outlet_id, $customer_id);
        }  
        $data['main_content'] = $this->load->view('report/installmentDueReport', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    
    /**
     * taxReport
     * @access public
     * @param no
     * @return void
     */
    public function taxReport(){
        $data = array();
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $data['report_generate_time'] = generatedOnCurrentDateTime();
            $outlet_id = isset($_POST['outlet_id']) && $_POST['outlet_id'] ? $_POST['outlet_id'] : '';
            $data['outlet_id'] = $outlet_id;
            $start_date = htmlspecialcharscustom($this->input->post($this->security->xss_clean('startDate')));
            $data['start_date'] = $start_date;
            $end_date = htmlspecialcharscustom($this->input->post($this->security->xss_clean('endDate')));
            $data['end_date'] = $end_date;
            $data['taxReport'] = $this->Report_model->taxReport($start_date, $end_date, $outlet_id);
        }
        $data['main_content'] = $this->load->view('report/taxReport', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    /**
     * servicingReport
     * @access public
     * @param no
     * @return void
     */
    public function servicingReport() {
        $data = array();
        $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
        $data['outlet_id'] = $outlet_id;
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $data['report_generate_time'] = generatedOnCurrentDateTime();
            $start_date = $this->input->post($this->security->xss_clean('startDate'));
            $end_date = $this->input->post($this->security->xss_clean('endDate'));
            $employee_id = $this->input->post($this->security->xss_clean('employee_id'));
            $status = $this->input->post($this->security->xss_clean('status'));
            
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $data['servicingReport'] = $this->Report_model->servicingReport($start_date, $end_date, $status, $employee_id, $outlet_id);
        }
        $data['employees'] = $this->Common_model->getAllUsersNameMobile();
        $data['main_content'] = $this->load->view('report/servicingReport', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    /**
     * itemMoving
     * @access public
     * @param no
     * @return void
     */
    public function itemMoving() {
        $data = array();
        $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
        $data['outlet_id'] = $outlet_id;
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $data['report_generate_time'] = generatedOnCurrentDateTime();
            $item_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('item_id')));
            $start_date = htmlspecialcharscustom($this->input->post($this->security->xss_clean('startDate')));
            $end_date = htmlspecialcharscustom($this->input->post($this->security->xss_clean('endDate')));
            $outlet_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('outlet_id')));
            $opening_item = getOpeningItemTracking($item_id, $start_date, $outlet_id);
            $data['itemMoving'] = $this->Report_model->itemMoving($start_date, $end_date, $item_id, $outlet_id);
            $data['item_id'] = $item_id;
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $data['opening_item'] = $opening_item;
        }
        $data['items'] = $this->Common_model->getAllItemNameCodeWithoutVariation();
        $data['main_content'] = $this->load->view('report/itemMoving', $data, TRUE);
        $this->load->view('userHome', $data);
    }


    
    /**
     * priceHistory
     * @access public
     * @param no
     * @return void
     */
    public function priceHistory() {
        $data = array();
        $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
        $data['outlet_id'] = $outlet_id;
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $data['report_generate_time'] = generatedOnCurrentDateTime();
            $item_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('item_id')));
            $start_date = htmlspecialcharscustom($this->input->post($this->security->xss_clean('startDate')));
            $end_date = htmlspecialcharscustom($this->input->post($this->security->xss_clean('endDate')));
            $opening_item = getOpeningItemTracking($item_id, $start_date, $outlet_id);
            $data['priceHistory'] = $this->Report_model->priceHistory($start_date, $end_date, $item_id, $outlet_id);
            $data['item_id'] = $item_id;
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $data['opening_item'] = $opening_item;
        }
        $data['items'] = $this->Common_model->getAllItemNameCodeWithoutVariation();
        $data['main_content'] = $this->load->view('report/priceHistory', $data, TRUE);
        $this->load->view('userHome', $data);
    }


    /**
     * zReport
     * @access public
     * @param no
     * @return void
     */
    public function zReport() {
        $data = array();
        $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
        if(!$outlet_id){
            $outlet_id = $this->session->userdata('outlet_id');
        }
        

        $data['outlet_id'] = $outlet_id;
        $selected_submit_post = htmlspecialcharscustom($this->input->post($this->security->xss_clean('date')));
        $selectedDate = (isset($selected_submit_post) && $selected_submit_post?$selected_submit_post:date("Y-m-d"));
        $data['sub_total_foods'] = $this->Report_model->sub_total_foods($selectedDate,$outlet_id);
        $data['totalDueReceived'] = $this->Report_model->totalDueReceived($selectedDate,$outlet_id);
        $data['taxes_foods'] = $this->Report_model->taxes_foods($selectedDate,$outlet_id);
        $data['total_discount_amount_foods'] = $this->Report_model->total_discount_amount_foods($selectedDate,$outlet_id);
        $data['totalFoodSales'] = $this->Report_model->totalFoodSales($selectedDate,$selectedDate,$outlet_id,"DESC");
        $data['totals_sale_others'] = $this->Report_model->totalTaxDiscountChargeTips($selectedDate,$outlet_id);
        $data['totals_sale_delivery'] = $this->Report_model->totalCharge($selectedDate,$outlet_id,"delivery");
        $data['get_all_sale_payment'] = $this->Report_model->getAllSalePaymentZReport($selectedDate,$outlet_id);
        $data['get_all_other_sale_payment'] = $this->Report_model->getAllOtherSalePaymentZReport($selectedDate,$outlet_id);
        $data['getAllPurchasePaymentZreport'] = $this->Report_model->getAllPurchasePaymentZreport($selectedDate,$outlet_id);
        $data['getAllExpensePaymentZreport'] = $this->Report_model->getAllExpensePaymentZreport($selectedDate,$outlet_id);
        $data['getAllSupplierPaymentZreport'] = $this->Report_model->getAllSupplierPaymentZreport($selectedDate,$outlet_id);
        $data['getAllCustomerDueReceiveZreport'] = $this->Report_model->getAllCustomerDueReceiveZreport($selectedDate,$outlet_id);

        $data['purchase_sum'] = $this->Report_model->getAllPurchaseByPayment($selectedDate,'',$outlet_id);
        $data['purchase_return_sum'] = $this->Report_model->getAllPurchaseReturnByPayment($selectedDate, '', $outlet_id);
        $data['installment_sum'] = $this->Report_model->getAllInstallmentDownPaymentAndCollectionByPayment($selectedDate, '', $outlet_id);

        $data['registers'] = getAllPaymentMethods('no');
        $array_p_name = array();
        foreach ($data['registers'] as $ky=>$vl){
            $data['registers'][$ky]->paid_sales = $this->Report_model->getAllSaleByPayment($selectedDate,$vl->id,$outlet_id);
            $data['registers'][$ky]->purchase = $this->Report_model->getAllPurchaseByPayment($selectedDate,$vl->id,$outlet_id);
            $data['registers'][$ky]->due_receive = $this->Report_model->getAllDueReceiveByPayment($selectedDate,$vl->id,$outlet_id);
            $data['registers'][$ky]->due_payment = $this->Report_model->getAllDuePaymentByPayment($selectedDate,$vl->id,$outlet_id);
            $data['registers'][$ky]->expense = $this->Report_model->getAllExpenseByPayment($selectedDate,$vl->id,$outlet_id);
            $data['registers'][$ky]->sale_return = $this->Report_model->getAllSaleReturnByPayment($selectedDate, $vl->id, $outlet_id);
            $data['registers'][$ky]->purchase_return = $this->Report_model->getAllPurchaseReturnByPayment($selectedDate, $vl->id, $outlet_id);
            $data['registers'][$ky]->installment = $this->Report_model->getAllInstallmentDownPaymentAndCollectionByPayment($selectedDate, $vl->id, $outlet_id);

            $inline_total = $data['registers'][$ky]->paid_sales - $data['registers'][$ky]->purchase + $data['registers'][$ky]->due_receive - $data['registers'][$ky]->due_payment - $data['registers'][$ky]->expense - $data['registers'][$ky]->sale_return + $data['registers'][$ky]->purchase_return + $data['registers'][$ky]->installment;

            $data['registers'][$ky]->inline_total = $inline_total;
            $array_p_name[] = $vl->name. "||". $inline_total;
        }

        $data['total_payments'] = $array_p_name;
        $data['selectedDate'] = $selectedDate;
        $data['main_content'] = $this->load->view('report/zReport', $data, TRUE);
        $this->load->view('userHome', $data);
    }


    /**
     * availableLoyaltyPointReport
     * @access public
     * @param no
     * @return void
     */
    public function availableLoyaltyPointReport() {
        $data = array();
        $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id'] ? $_POST['outlet_id'] : '';
        if(!$outlet_id){
            $outlet_id = $this->session->userdata('outlet_id');
        }
        $customer_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('customer_id')));
        $data['customer_id'] = $customer_id;
        $data['outlet_id'] = $outlet_id;
        $data['customers'] = $this->Report_model->availableLoyaltyPointReport($customer_id,$outlet_id);
        $data['customers_dropdown'] = $this->Common_model->getAllCustomerNameMobile();
        $data['main_content'] = $this->load->view('report/loyalty_point_available_report', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    /**
     * usageLoyaltyPointReport
     * @access public
     * @param no
     * @return void
     */
    public function usageLoyaltyPointReport() {
        $data = array();
        if($this->input->post('submit')){
            $start_date = $this->input->post($this->security->xss_clean('startDate'));
            $end_date = $this->input->post($this->security->xss_clean('endDate'));
            $customer_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('customer_id')));
            $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id'] ? $_POST['outlet_id'] : '';
            if(!$outlet_id){
                $outlet_id = $this->session->userdata('outlet_id');
            }
            $data['outlet_id'] = $outlet_id;
            $data['customer_id'] = $customer_id;
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $data['customers'] = $this->Report_model->usageLoyaltyPointReport($start_date, $end_date,$customer_id,$outlet_id);
            $data['customers_dropdown'] = $this->Common_model->getAllCustomerNameMobile();
            $data['main_content'] = $this->load->view('report/loyalty_point_usage_report', $data, TRUE);
            $this->load->view('userHome', $data);
        }else{
            $data['customers_dropdown'] = $this->Common_model->getAllCustomerNameMobile();
            $data['main_content'] = $this->load->view('report/loyalty_point_usage_report', $data, TRUE);
            $this->load->view('userHome', $data);
        }
    }
}
