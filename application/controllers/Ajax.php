<?php

use PHP_CodeSniffer\Util\Common;
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
    # This is Ajax Controller
    ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends Cl_Controller {

    /**
     * load constructor
     * @access public
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->model('Ajax_model');
        $this->load->model('Master_model');
        $this->load->model('Stock_model');
        $this->load->model('Installment_model');
        $this->load->model('Sale_model');
        $this->load->model('Report_model');
        $this->load->library('form_validation');
        $this->Common_model->setDefaultTimezone();
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
    }

    /**
     * addBrandByAjax
     * @access public
     * @param no
     * @return json
     */
    public function addBrandByAjax() {
        $brandData = array();
        $brandData['name'] = $this->input->post($this->security->xss_clean('name'));
        $brandData['description'] = $this->input->post($this->security->xss_clean('description'));
        $brandData['added_date'] = date('Y-m-d H:i:s');
        $brandData['user_id'] = $this->session->userdata('user_id');
        $brandData['company_id'] = $this->session->userdata('company_id');
        $id = $this->Common_model->insertInformation($brandData, "tbl_brands");
        $return_data = array();
        if($id){
            $return_data['id'] = $id;
            $return_data['brands'] = $this->Sale_model->getItemBrand($this->session->userdata('company_id'), 'tbl_brands');
        }
        echo json_encode($return_data);
    }

    /**
     * getAllItems
     * @access public
     * @param no
     * @return json
     */
    public function getAllItems() {
        $items = $this->Common_model->getItemWithVariationForDrowdown();
        if($items){
            $response = [
                'status' => 'success',
                'data' => $items,
            ];
        }else{
            $response = [
                'status' => 'error',
                'data' => 'No data found!',
            ];
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }
   

    /**
     * addSupplierByAjax
     * @access public
     * @param no
     * @return json
     */
    function addSupplierByAjax(){
        $fmc_info = [];
        $fmc_info['name'] = getPlanText(htmlspecialcharscustom($this->input->get($this->security->xss_clean('name'))));
        $fmc_info['contact_person'] = $this->input->get($this->security->xss_clean('contact_person'));
        $fmc_info['phone'] = $this->input->get($this->security->xss_clean('phone'));
        $fmc_info['email'] = $this->input->get($this->security->xss_clean('email'));
        $fmc_info['opening_balance'] = $this->input->get($this->security->xss_clean('opening_balance'));
        $fmc_info['opening_balance_type'] = $this->input->get($this->security->xss_clean('opening_balance_type'));
        $fmc_info['address'] = $this->input->get($this->security->xss_clean('address'));
        $fmc_info['description'] = $this->input->get($this->security->xss_clean('description'));
        $fmc_info['user_id'] = $this->session->userdata('user_id');
        $fmc_info['added_date'] = date('Y-m-d H:i:s');
        $fmc_info['company_id'] = $company_id = $this->session->userdata('company_id');
        $id = $this->Common_model->insertInformation($fmc_info, "tbl_suppliers");
        if($id){
            $return_data['id'] = $id;
            $return_data['supplier'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_suppliers');
        }
        echo json_encode($return_data);
    }


    /**
     * addCategoryByAjax
     * @access public
     * @param no
     * @return json
     */
    public function addCategoryByAjax() {
        $data = array();
        $data['name'] = $this->input->post($this->security->xss_clean('name'));
        $data['description'] = $this->input->post($this->security->xss_clean('description'));
        $data['added_date'] = date('Y-m-d H:i:s');
        $data['user_id'] = $this->session->userdata('user_id');
        $data['company_id'] = $this->session->userdata('company_id');
        $id = $this->Common_model->insertInformation($data, "tbl_item_categories");
        $return_data = array();
        if($id){
            $return_data['id'] = $id;
            $return_data['categories'] = $this->Sale_model->getItemCategories($this->session->userdata('company_id'), 'tbl_item_categories');
        }
        echo json_encode($return_data);
    }


    /**
     * addRackByAjax
     * @access public
     * @param no
     * @return json
     */
    public function addRackByAjax() {
        $data = array();
        $data['name'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('name')));
        $data['description'] = $this->input->post($this->security->xss_clean('description'));
        $data['added_date'] = date('Y-m-d H:i:s');
        $data['user_id'] = $this->session->userdata('user_id');
        $data['company_id'] = $this->session->userdata('company_id');
        $id = $this->Common_model->insertInformation($data, "tbl_racks");
        $return_data = array();
        if($id){
            $return_data['id'] = $id;
            $return_data['racks'] = $this->Common_model->getAllByCompanyId($this->session->userdata('company_id'), 'tbl_racks');
        }
        echo json_encode($return_data);
    }
    /**
     * addGroupByAjax
     * @access public
     * @param no
     * @return json
     */
    public function addGroupByAjax() {
        $data = array();
        $data['group_name'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('name')));
        $data['description'] = $this->input->post($this->security->xss_clean('description'));
        $data['added_date'] = date('Y-m-d H:i:s');
        $data['user_id'] = $this->session->userdata('user_id');
        $data['company_id'] = $this->session->userdata('company_id');
        $id = $this->Common_model->insertInformation($data, "tbl_customer_groups");
        $return_data = array();
        if($id){
            $return_data['id'] = $id;
            $return_data['groups'] = $this->Common_model->getAllByCompanyId($this->session->userdata('company_id'), 'tbl_customer_groups');
        }
        echo json_encode($return_data);
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
            $installmentAmount = 0;

            $i_sale = $this->session->userdata('i_sale');
            if(isset($i_sale) && $i_sale=="Yes"){
                $installmentAmount_temp  = $this->Common_model->installDownAndPaidAmount($sqlStartDate, $sqlEndDate);
                $installmentAmount = $installmentAmount_temp;
            }

            $finalOutput[] = array(
                'month' => date('M-y', strtotime($dateCalculate . ' month')),
                'saleAmount' => ($saleAmount+$installmentAmount) ? ($saleAmount+$installmentAmount) : 0.0,
            );
        }
        echo json_encode($finalOutput);
    }

    /**
     * addUnitByAjax
     * @access public
     * @param no
     * @return json
     */
    public function addUnitByAjax() {
        $data = array();
        $data['unit_name'] = htmlspecialcharscustom($this->input->get($this->security->xss_clean('unit_name')));
        $data['description'] = htmlspecialcharscustom($this->input->get($this->security->xss_clean('description')));
        $data['added_date'] = date('Y-m-d H:i:s');
        $data['user_id'] = $this->session->userdata('user_id');
        $data['company_id'] = $this->session->userdata('company_id');
        $id = $this->Common_model->insertInformation($data, "tbl_units");

        $return_data = array();
        if($id){
            $return_data['id'] = $id;
            $return_data['units'] = $this->Common_model->getAllByCompanyId($this->session->userdata('company_id'), 'tbl_units');
        }
        echo json_encode($return_data);
    }

    

    /**
     * getInvoiceInfo
     * @access public
     * @param no
     * @return json
     */
    public function getInvoiceInfo() {
        $customer_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('customer_id')));
        $result = $this->Installment_model->getInvoiceInfo($customer_id);
        $html = "<option value=''>".lang('select_invoice')."</option>";
        foreach ($result as $val){
            $html .= '<option value="'.$this->custom->encrypt_decrypt($val->id, 'encrypt').'">'.$val->reference_no."-".(date($this->session->userdata('date_format'), strtotime($val->date)))."-".$val->item_name."-".$val->total.'</option>';
        }
        echo json_encode($html);
    }

    /**
     * saveItemImage
     * @access public
     * @param no
     * @return json
     */
    public function saveItemImage()
    {
        $data = $_POST['image'];
        list($type, $data) = explode(';', $data);
        list(, $data)      = explode(',', $data);
        $data = base64_decode($data);
        $imageName = time().'.png';
        if(createDirectory('uploads/items')){
            file_put_contents('uploads/items/'.$imageName, $data);
            $data_return['image_name'] = $imageName;
            echo json_encode($data_return);
        } else {
            echo "Something went wrong";
        }
    }
    /**
     * bulkImageUpdate
     * @access public
     * @param no
     * @return json
     */
    public function bulkImageUpdate()
    {
        $data = $_POST['image'];
        $item_id = $_POST['item_id'];
        $item_old_photo = $_POST['item_old_photo'];
        list($type, $data) = explode(';', $data);
        list(, $data)      = explode(',', $data);
        $data = base64_decode($data);
        $imageName = time().'.png';
        if(createDirectory('uploads/items')){
            file_put_contents('uploads/items/'.$imageName, $data);
            $data_return['image_name'] = $imageName;
            $id = $this->custom->encrypt_decrypt($item_id, 'decrypt');
            
            $old_image_path = FCPATH . 'uploads/items/' . $item_old_photo;
            // Check if the file exists and is a file before attempting to delete it
            if (file_exists($old_image_path) && is_file($old_image_path)) {
                // Attempt to delete the file
                unlink($old_image_path);  
            }
            
            $data = array();
            $data['photo'] = $imageName;
            $this->Common_model->updateInformation($data, $id, 'tbl_items');
            $response = [
                'status' => 'success',
                'message' => 'Item  image update successfully',
                'image_name' => $imageName,
                'i_id' => $id,
            ];	
            $this->output->set_content_type('application/json')->set_output(json_encode($response));
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Something went wrong',
            ];	
            $this->output->set_content_type('application/json')->set_output(json_encode($response));
        }
    }


    /**
     * saveUserImage
     * @access public
     * @param no
     * @return json
     */
    public function saveUserImage()
    {
        $data = $_POST['image'];
        list($type, $data) = explode(';', $data);
        list(, $data)      = explode(',', $data);
        $data = base64_decode($data);
        $imageName = time().'.png';
        if(createDirectory('uploads/employees_image')){
            file_put_contents('uploads/employees_image/'.$imageName, $data);
            $data_return['image_name'] = $imageName;
            echo json_encode($data_return);
        } else {
            echo "Something went wrong";
        }
    }

    /**
     * change_status_notification
     * @access public
     * @param no
     * @return void
     */
    public function change_status_notification() {
        $id = $this->input->get('id');
        $value = $this->input->get('value');
        $this->Common_model->change_status_notification($id,$value);
    }

    /**
     * delete_row_notification
     * @access public
     * @param no
     * @return json
     */
    public function delete_row_notification() {
        $id = $this->input->get('id');
        $this->Common_model->deleteStatusChange($id, "tbl_notifications");
        $notifications_read_count = $this->db->where('del_status','Live')
        ->where('outlet_id',$this->session->userdata('outlet_id'))
        ->where('company_id',$this->session->userdata('company_id'))
        ->where('visible_status','1')
        ->get('tbl_notifications')
        ->result();
        $total = sizeof($notifications_read_count);
        $data['total_unread'] = $total;
        echo json_encode($data);
    }


    /**
     * putSetting
     * @access public
     * @param no
     * @return json
     */
    public function putSetting()
    {
        $outlet_id = $this->session->userdata('outlet_id');
        $outlet_info = array();
        $outlet_info['sms_setting_check'] = $this->input->get($this->security->xss_clean('sms_setting_check'));
        $outlet_info['qty_setting_check'] = $this->input->get($this->security->xss_clean('qty_setting_check'));
        $this->Common_model->updateInformation($outlet_info, $outlet_id, "tbl_outlets");
        $outlet_session['sms_setting_check'] = $this->input->get($this->security->xss_clean('sms_setting_check'));
        $outlet_session['qty_setting_check'] = $this->input->get($this->security->xss_clean('qty_setting_check'));
        $this->session->set_userdata($outlet_session);
        echo json_encode("Success");
    }



    /**
     * checkQty
     * @access public
     * @param no
     * @return json
     */
    public function checkQty()
    {
        $curr_qty = htmlspecialcharscustom($this->input->post($this->security->xss_clean('curr_qty')));
        $item_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('item_id')));
        $value = $this->Stock_model->getStockByItemId($item_id);
        $i_sale = $this->session->userdata('i_sale');
        $total_installment_sale = 0;
        if(isset($i_sale) && $i_sale=="Yes"){
            $total_installment_sale = $value->total_installment_sale;
        }
        $totalStock = $value->total_opening_stock + ($value->total_purchase*$value->conversion_rate) - $value->total_sale - $value->total_damage - $total_installment_sale - $value->total_purchase_return + $value->total_sale_return;
       if($curr_qty<$totalStock){
          echo json_encode('available');
       }else{
           echo json_encode('');
       }

    }



    /**
     * date_wise_dashboard_report_ajax_get
     * @access public
     * @param no
     * @return json
     */
    public function date_wise_dashboard_report_ajax_get(){
        $start_date = $_GET['start_date'];
        $end_date = date('Y-m-d', strtotime($_GET['end_date'] . ' +1 day'));
        $outlet_id = $this->session->userdata('outlet_id');
        $data=array();
        $data['total_purchase']=$this->Report_model->total_purchase($start_date,$end_date,$outlet_id);
        $data['total_sales']=$this->Report_model->total_sales($start_date,$end_date,$outlet_id);
        $data['purchase_due']=$this->Report_model->purchase_due($start_date,$end_date,$outlet_id);
        $data['sales_due']=$this->Report_model->sales_due($start_date,$end_date,$outlet_id);
        $data['total_purchase_return']=$this->Report_model->total_purchase_return($start_date,$end_date,$outlet_id);
        $data['total_sales_return']=$this->Report_model->total_sales_return($start_date,$end_date,$outlet_id);
        $data['expense']=$this->Report_model->expense($start_date,$end_date,$outlet_id);
        $data['income']=$this->Report_model->income($start_date,$end_date,$outlet_id);
        echo json_encode($data);
    }



    /**
     * getVariationDetails
     * @access public
     * @param no
     * @return sring
     */
    public function getVariationDetails()
    {
        $variant_id = htmlspecialcharscustom($this->input->post('variant_id'));
        $row_id = htmlspecialcharscustom($this->input->post('row_id'));
        $selected_value = htmlspecialcharscustom($this->input->post('selected_value'));
        $variant = $this->Common_model->getDataById($variant_id,"tbl_variations");
        $html = '';
        $splt = explode("|||",$selected_value);
        $tmp_arr = array();
        if($variant){
            $vari_value = json_decode($variant->variation_value);
            $html.='<option value="">'.lang('Select').'</option>';
            foreach ($vari_value as $key=>$value){
                $tmp_arr[] = $value;
                $selected = '';
                if (in_array($value, $splt)) {
                    $selected = 'selected';
                }
                $html.='<option '.$selected.' class="at_id'.$row_id.'" value="'.$value.'">'.$value.'</option>';
            }
            if($splt){
                foreach ($splt as $k=>$v){
                    if (!in_array($v, $tmp_arr)) {
                        if($splt[$k]){
                            $html.='<option selected class="at_id'.$row_id.'" value="'.$splt[$k].'">'.$splt[$k].'</option>';
                        }
                    }
                }
            }
        }
        echo $html;
    }



    /**
     * getItemVariationDetails
     * @access public
     * @param int
     * @return object
     */

    function getItemVariationDetails($item_id){
        $variation_items = $this->Common_model->getItemVariationDetails($item_id);
        echo $variation_items;
    }




    /**
     * installmentNotification
     * @access public
     * @param no
     * @return void
     */

    function installmentNotification(){
        $session_days = $this->session->userdata('installment_days');
        $end_date =  date('Y-m-d', strtotime('+'. $session_days . 'days'));
        $this->Common_model->installmentNotification($end_date);
    }

    /**
     * customerDue
     * @access public
     * @param no
     * @return void
    */

    function customerDue(){
        $customer_id = htmlspecialcharscustom($this->input->post('customer_id'));
        $customer_due = getCustomerDue($customer_id);
        echo $customer_due;
    }



    /**
     * openingStockQuantityCheck
     * @access public
     * @param no
     * @return void
     */

    function openingStockQuantityCheck(){
        $item_id = $this->input->get($this->security->xss_clean('item_id'));
        $outlet_id = $this->input->get($this->security->xss_clean('outlet_id'));
        $stockResult = $this->Common_model->openingStockCheck($item_id, $outlet_id);
        if($stockResult){
            echo $stockResult->stock_quantity;
        }
    }

    
    /**
     * addCustomerByAjax
     * @access public
     * @param no
     * @return json
     */
    public function addCustomerByAjax(){
        $customer_info = array();
        $customer_info['name'] = htmlspecialcharscustom($this->input->post('name'));
        $customer_info['phone'] = htmlspecialcharscustom($this->input->post('phone'));
        $customer_info['email'] = htmlspecialcharscustom($this->input->post('email'));
        $customer_info['address'] = htmlspecialcharscustom($this->input->post('address'));
        $customer_info['opening_balance'] = htmlspecialcharscustom($this->input->post('opening_balance'));
        $customer_info['opening_balance_type'] = htmlspecialcharscustom($this->input->post('opening_balance_type'));
        $customer_info['credit_limit'] = htmlspecialcharscustom($this->input->post('credit_limit'));
        $customer_info['group_id'] = htmlspecialcharscustom($this->input->post('group_id'));
        $customer_info['discount'] = htmlspecialcharscustom($this->input->post('discount'));
        $customer_info['price_type'] = htmlspecialcharscustom($this->input->post('price_type'));
        $customer_info['gst_number'] = htmlspecialcharscustom($this->input->post('gst_number'));
        $customer_info['same_or_diff_state'] = htmlspecialcharscustom($this->input->post('same_or_diff_state'));
        $customer_info['user_id'] = $this->session->userdata('user_id');
        $customer_info['company_id'] = $this->session->userdata('company_id');
        $customer_info['added_date'] = date('Y-m-d H:i:s');
        $inserted_id = $this->Common_model->insertInformation($customer_info, "tbl_customers");
        if($inserted_id){
            $allCustomer = $this->Common_model->getAllCustomerNameMobile();
            $response = [
                'status' => 'success',
                'message' => $allCustomer,
                'last_id' => $inserted_id,
            ];	
        }else{
            $response = [
                'status' => 'error',
                'message' => "Something went wrong",
            ];	
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }


    /**
     * barcodeLabelSetting
     * @access public
     * @param no
     * @return json
     */
    public function barcodeLabelSetting(){
        $company_id = $this->session->userdata('company_id');
        $barcode_setting = array();
        $barcode_setting['hide_product_name'] = htmlspecialcharscustom($this->input->post('hide_product_name'));
        $barcode_setting['hide_product_code'] = htmlspecialcharscustom($this->input->post('hide_product_code'));
        $barcode_setting['hide_product_price'] = htmlspecialcharscustom($this->input->post('hide_product_price'));
        $barcode_setting['name_font_size'] = htmlspecialcharscustom($this->input->post('name_font_size'));
        $barcode_setting['code_font_size'] = htmlspecialcharscustom($this->input->post('code_font_size'));
        $barcode_setting['price_font_size'] = htmlspecialcharscustom($this->input->post('price_font_size'));

        $setting = array();
        $setting['barcode_setting'] = json_encode($barcode_setting);
        $this->Common_model->updateInformation($setting, $company_id, "tbl_companies");
        $response = [
            'status' => 'success',
            'message' => lang('Information_updated_successfully'),
        ];	
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
}
