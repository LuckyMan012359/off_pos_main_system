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
  # This is ApiSaleController
  ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH.'libraries/REST_Controller.php');

class ApiSaleController extends REST_Controller
{
    /**
     * load constructor
     * @access public
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('API_model');
        $this->load->model('Common_model');
        $this->load->model('Master_model');
        $this->load->library('form_validation');
    }


    /**
     * saleList_get
     * @access public
     * @param no
     * @return json
     */
    public function saleList_get(){
        $sales = $this->API_model->getSaleList();
        $response = [
            'status' => 200,
            'data' => $sales,
        ];	
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    /**
     * addSale_post
     * @access public
     * @param no
     * @return json
     */
    public function addSale_post(){
        $sale_info = json_decode(file_get_contents("php://input"), true);
        $company_info = getCompanyInfoByAPIKey($sale_info['api_auth_key']);
        $error = false;
        if($company_info){
            $saleErr = [];
            if($sale_info['customer_name'] == ''){
                $error = true;
                $saleErr['customer_name'] = 'The Customer Name field is required';
            }
            if($sale_info['total_items'] == ''){
                $error = true;
                $saleErr['total_items'] = 'The Total Items field is required';
            }
            if($sale_info['total_payable'] == ''){
                $error = true;
                $saleErr['total_payable'] = 'The Total Payable field is required';
            }
            if($error == false){
                $company_id = $company_info->id;
                $user_id = $company_info->user_id;
                $saleArr = array();
                $saleArr['customer_id'] = $this->Common_model->fieldNameCheckingByFieldNameForAPI($sale_info['customer_name'], 'name', 'tbl_customers', $user_id, $company_id);
                $saleArr['total_items'] = $sale_info['total_items'];
                $saleArr['sub_total'] = $sale_info['sub_total'];
                $saleArr['paid_amount'] = $sale_info['paid_amount'];
                $saleArr['previous_due'] = $sale_info['previous_due'];
                $saleArr['due_amount'] = $sale_info['due_amount'];
                $saleArr['disc'] = $sale_info['disc'];
                $saleArr['disc_actual'] = $sale_info['disc_actual'];
                $saleArr['vat'] = $sale_info['vat'];
                $saleArr['rounding'] = $sale_info['rounding'];
                $saleArr['total_payable'] = $sale_info['total_payable'];
                $saleArr['total_item_discount_amount'] = $sale_info['total_item_discount_amount'];
                $saleArr['sub_total_with_discount'] = $sale_info['sub_total_with_discount'];
                $saleArr['sub_total_discount_amount'] = $sale_info['sub_total_discount_amount'];
                $saleArr['total_discount_amount'] = $sale_info['total_discount_amount'];
                $saleArr['delivery_charge'] = $sale_info['delivery_charge'];
                $saleArr['charge_type'] = $sale_info['charge_type'];
                $saleArr['sub_total_discount_value'] = $sale_info['sub_total_discount_value'];
                $saleArr['sub_total_discount_type'] = $sale_info['sub_total_discount_type'];
                $saleArr['sale_date'] = date('Y-m-d');
                $saleArr['date_time'] = date('Y-m-d H:i:s');
                $saleArr['grand_total'] = $sale_info['grand_total'];
                $saleArr['delivery_partner_id'] = $this->Common_model->fieldNameCheckingByFieldNameForAPI($sale_info['delivery_partner_name'], 'partner_name', 'tbl_delivery_partners', $user_id, $company_id);
                $saleArr['delivery_status'] = $sale_info['delivery_status'];
                $saleArr['due_date_time'] = $sale_info['due_date_time'];
                $saleArr['account_note'] = $sale_info['account_note'];
                $saleArr['account_type'] = $sale_info['account_type'];
                $sale_vat_objects =  json_decode(str_replace("'", '"', $sale_info['sale_vat_objects']), true);
                $saleArr['sale_vat_objects'] = json_encode($sale_vat_objects);
                $saleArr['random_code'] = $sale_info['random_code'];
                $saleArr['note'] = $sale_info['note'];
                $saleArr['order_date_time'] = date("Y-m-d H:i:s");
                $saleArr['added_date'] = date('Y-m-d H:i:s');;
                $saleArr['user_id'] = $user_id;
                $saleArr['outlet_id'] = $this->Common_model->fieldNameCheckingByFieldNameForAPI($sale_info['outlet_name'], 'outlet_name', 'tbl_outlets', $user_id, $company_id);
                $saleArr['company_id'] = $company_id;
                $sale_details =  json_decode(str_replace("'", '"', $sale_info['items']), true);
                $payment_details =  json_decode(str_replace("'", '"', $sale_info['payment_details']), true);
                $insertedId = $this->Common_model->insertInformation($saleArr, "tbl_sales");
                $this->saveSaleDetails($sale_details, $insertedId, $user_id, $saleArr['outlet_id'], $company_id);
                $this->saveSalePaymentDetails($payment_details, $insertedId, $user_id, $saleArr['outlet_id'], $company_id);
                if($insertedId){
                    $response = array(
                        'status' => 200,
                        'message' => 'Sale successfully complete',
                    ); 
                } else {
                    $response = array(
                        'status' => 400,
                        'message' => "Sale failded something wrong",
                    ); 
                }
            } else {
                $response = array(
                    'status' => 400,
                    'message' => $saleErr,
                ); 
            }

        } else {
            $response = array(
                'status' => 500,
                'message' => 'API Key is not valid',
            ); 
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }


    
    /**
     * editSale_post
     * @access public
     * @param no
     * @return json
     */
    public function editSale_post(){
        $sale_info = json_decode(file_get_contents("php://input"), true);
        $sale_id = $sale_info['id'];
        $sale_data = $this->Common_model->getDataById($sale_id, 'tbl_sales');
        if($sale_data){
            $response = [
                'status' => 200,
                'data' => $sale_data,
            ];
        }else{
            $response = [
                'status' => 404,
                'data' => 'Data Not Found!',
            ];
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }


    /**
     * updateSale_post
     * @access public
     * @param no
     * @return json
     */
    public function updateSale_post(){
        $find_sale_id = json_decode(file_get_contents("php://input"), true);
        $sale_id = $find_sale_id['id'];
        $find_sale_id = $this->Common_model->getFindId($sale_id, 'tbl_sales');
        if($find_sale_id){
            $sale_updated_id = $find_sale_id->id;
            $sale_info = json_decode(file_get_contents("php://input"), true);
            $company_info = getCompanyInfoByAPIKey($sale_info['api_auth_key']);
            $error = false;
            if($company_info){
                $saleErr = [];
                if($sale_info['customer_name'] == ''){
                    $error = true;
                    $saleErr['customer_name'] = 'The Customer Name field is required';
                }
                if($sale_info['total_items'] == ''){
                    $error = true;
                    $saleErr['total_items'] = 'The Total Items field is required';
                }
                if($sale_info['total_payable'] == ''){
                    $error = true;
                    $saleErr['total_payable'] = 'The Total Payable field is required';
                }
                if($error == false){
                    $company_id = $company_info->id;
                    $user_id = $company_info->user_id;
                    $saleArr = array();
                    $saleArr['customer_id'] = $this->Common_model->fieldNameCheckingByFieldNameForAPI($sale_info['customer_name'], 'name', 'tbl_customers', $user_id, $company_id);
                    $saleArr['total_items'] = $sale_info['total_items'];
                    $saleArr['sub_total'] = $sale_info['sub_total'];
                    $saleArr['paid_amount'] = $sale_info['paid_amount'];
                    $saleArr['previous_due'] = $sale_info['previous_due'];
                    $saleArr['due_amount'] = $sale_info['due_amount'];
                    $saleArr['disc'] = $sale_info['disc'];
                    $saleArr['disc_actual'] = $sale_info['disc_actual'];
                    $saleArr['vat'] = $sale_info['vat'];
                    $saleArr['rounding'] = $sale_info['rounding'];
                    $saleArr['total_payable'] = $sale_info['total_payable'];
                    $saleArr['total_item_discount_amount'] = $sale_info['total_item_discount_amount'];
                    $saleArr['sub_total_with_discount'] = $sale_info['sub_total_with_discount'];
                    $saleArr['sub_total_discount_amount'] = $sale_info['sub_total_discount_amount'];
                    $saleArr['total_discount_amount'] = $sale_info['total_discount_amount'];
                    $saleArr['delivery_charge'] = $sale_info['delivery_charge'];
                    $saleArr['charge_type'] = $sale_info['charge_type'];
                    $saleArr['sub_total_discount_value'] = $sale_info['sub_total_discount_value'];
                    $saleArr['sub_total_discount_type'] = $sale_info['sub_total_discount_type'];
                    $saleArr['sale_date'] = date('Y-m-d');
                    $saleArr['date_time'] = date('Y-m-d H:i:s');
                    $saleArr['grand_total'] = $sale_info['grand_total'];
                    $saleArr['delivery_partner_id'] = $this->Common_model->fieldNameCheckingByFieldNameForAPI($sale_info['delivery_partner_name'], 'partner_name', 'tbl_delivery_partners', $user_id, $company_id);
                    $saleArr['delivery_status'] = $sale_info['delivery_status'];
                    $saleArr['due_date_time'] = $sale_info['due_date_time'];
                    $saleArr['account_note'] = $sale_info['account_note'];
                    $saleArr['account_type'] = $sale_info['account_type'];
                    $sale_vat_objects =  json_decode(str_replace("'", '"', $sale_info['sale_vat_objects']), true);
                    $saleArr['sale_vat_objects'] = json_encode($sale_vat_objects);
                    $saleArr['random_code'] = $sale_info['random_code'];
                    $saleArr['note'] = $sale_info['note'];
                    $saleArr['order_date_time'] = date("Y-m-d H:i:s");
                    $saleArr['added_date'] = date('Y-m-d H:i:s');;
                    $saleArr['user_id'] = $user_id;
                    $saleArr['outlet_id'] = $this->Common_model->fieldNameCheckingByFieldNameForAPI($sale_info['outlet_name'], 'outlet_name', 'tbl_outlets', $user_id, $company_id);
                    $saleArr['company_id'] = $company_id;
                    $sale_details =  json_decode(str_replace("'", '"', $sale_info['items']), true);
                    $payment_details =  json_decode(str_replace("'", '"', $sale_info['payment_details']), true);
                    $this->Common_model->updateInformation($saleArr, $sale_updated_id, "tbl_sales");
                    $this->Common_model->deletingMultipleFormData('sales_id', $sale_updated_id, 'tbl_sales_details');
                    $this->Common_model->deletingMultipleFormData('sale_id', $sale_updated_id, 'tbl_sale_payments');
                    $this->saveSaleDetails($sale_details, $sale_updated_id, $user_id, $saleArr['outlet_id'], $company_id);
                    $this->saveSalePaymentDetails($payment_details, $sale_updated_id, $user_id, $saleArr['outlet_id'], $company_id);
                    if($sale_updated_id){
                        $response = array(
                            'status' => 200,
                            'message' => 'Sale successfully complete',
                        ); 
                    } else {
                        $response = array(
                            'status' => 400,
                            'message' => "Sale failded something wrong",
                        ); 
                    }
                } else {
                    $response = array(
                        'status' => 400,
                        'message' => $saleErr,
                    ); 
                }

            }else{
                $response = array(
                    'status' => 500,
                    'message' => 'API Key is not valid',
                ); 
            }
        }else {
            $response = array(
                'status' => 404,
                'message' => 'Sale Not Found',
            ); 
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }


    /**
     * deleteSale_post
     * @access public
     * @param no
     * @return json
     */
    public function deleteSale_post(){
        $find_sale_id = json_decode(file_get_contents("php://input"), true);
        $sale_id = $find_sale_id['id'];
        $find_sale_id = $this->Common_model->getFindId($sale_id, 'tbl_sales');
        if($find_sale_id){
            $this->Common_model->deleteStatusChange($sale_id, "tbl_sales");
            $this->Common_model->updatingMultipleFormData('sales_id', $sale_id, 'tbl_sales_details');
            $this->Common_model->updatingMultipleFormData('sale_id', $sale_id, 'tbl_sale_payments');
            $response = [
                'status' => 200,
                'data' => 'Item Deleted Successfully',
            ];
        }else{
            $response = [
                'status' => 404,
                'data' => 'Data Not Found!',
            ];
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }



    /**
     * saveSaleDetails
     * @access public
     * @param string
     * @param int
     * @param int
     * @param string
     * @param int
     * @return void
     */
    public function saveSaleDetails($sale_details, $insertedId, $user_id, $outlet_name, $company_id) {
        foreach($sale_details as $key=>$sale){
            $fmi = array();

            if($sale['is_promo_item'] == "Yes"){
                $p_price = 0;
            }else{
                $p_price = getLastThreePurchaseAmount($sale['item_id'], '');
            }
            $fmi['food_menu_id'] = $sale['item_id'];
            $fmi['qty'] = $sale['quantity'];
            $fmi['menu_price_without_discount'] = $sale['menu_price_without_discount'];
            $fmi['menu_price_with_discount'] = $sale['menu_price_with_discount'];
            $fmi['menu_unit_price'] = $sale['menu_unit_price'];
            $fmi['purchase_price'] = trim_checker($p_price);
            $fmi['menu_taxes'] = getItemTaxByItemId($sale['item_id']);
            $fmi['menu_discount_value'] = $sale['menu_discount_value'];
            $fmi['discount_type'] = $sale['discount_type'];
            $fmi['menu_note'] = $sale['menu_note'];
            $fmi['discount_amount'] = $sale['discount_amount'];
            $fmi['item_type'] = $sale['item_type'];
            $fmi['expiry_imei_serial'] = $sale['expiry_imei_serial'];
            $fmi['sales_id'] = $insertedId;
            $fmi['is_promo_item'] = $sale['is_promo_item'];
            $fmi['promo_parent_id'] = $sale['promo_parent_id'];
            $fmi['item_seller_id'] = $sale['item_seller_id'];
            $fmi['delivery_status'] = $sale['delivery_status'];
            $fmi['loyalty_point_earn'] = $sale['loyalty_point_earn'];
            $fmi['outlet_id'] = $outlet_name;
            $fmi['user_id'] = $user_id;
            $fmi['company_id'] = $company_id;
            $this->Common_model->insertInformation($fmi, 'tbl_sales_details');
        }
    }


    /**
     * saveSaleDetails
     * @access public
     * @param string
     * @param int
     * @param int
     * @param string
     * @param int
     * @return void
     */
    public function saveSalePaymentDetails($sale_payment_details, $insertedId, $user_id, $outlet_name, $company_id) {
        foreach($sale_payment_details as $key=>$payment_details){
            $fmi = array();
            $fmi['payment_id'] = $this->Common_model->fieldNameCheckingByFieldNameForAPI($payment_details['payment_name'], 'name', 'tbl_payment_methods', $user_id, $company_id);
            $fmi['date'] = date('Y-m-d');
            $fmi['currency_type'] = $payment_details['currency_type'];
            $fmi['multi_currency'] = $payment_details['multi_currency'];
            $fmi['multi_currency_rate'] = $payment_details['multi_currency_rate'];
            $fmi['amount'] = $payment_details['amount'];
            $fmi['usage_point'] = $payment_details['usage_point'];
            $fmi['sale_id'] = $insertedId;
            $fmi['added_date'] = date('Y-m-d H:i:s');
            $fmi['user_id'] = $user_id;
            $fmi['outlet_id'] = $outlet_name;
            $fmi['company_id'] = $company_id;
            $this->Common_model->insertInformation($fmi, 'tbl_sale_payments');
        }
    }




}

?>