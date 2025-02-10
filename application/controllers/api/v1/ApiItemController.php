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
  # This is ApiItemController
  ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH.'libraries/REST_Controller.php');

class ApiItemController extends REST_Controller
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
     * itemList_get
     * @access public
     * @param no
     * @return json
     */
    public function itemList_get(){
        $items = $this->API_model->getItemList();
        $response = [
            'status' => 200,
            'data' => $items,
        ];	
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    /**
     * addItem_post
     * @access public
     * @param no
     * @return json
     */
    public function addItem_post(){
        $item_info = json_decode(file_get_contents("php://input"), true);
        $company_info = getCompanyInfoByAPIKey($item_info['api_auth_key']);
        $error = false;
        if($company_info){
            $itemErr = [];
            if($item_info['name'] == ''){
                $error = true;
                $itemErr['name'] = 'The Name field is required';
            }
            if($item_info['sale_price'] == ''){
                $error = true;
                $itemErr['sale_price'] = 'The Sale Price field is required';
            }
            if($item_info['category_name'] == ''){
                $error = true;
                $itemErr['category_name'] = 'The Category Name field is required';
            }
            if($item_info['unit_type'] == ''){
                $error = true;
                $itemErr['unit_type'] = 'The Unit Type field is required';
            }
            if($error == false){
                $company_id = $company_info->id;
                $user_id = $company_info->user_id;
                $unit_type = $item_info['unit_type'];
                $opening_stock =  json_decode(str_replace("'", '"', $item_info['opening_stock']), true);
                $itemArr = array();
                $itemArr['code'] = $this->Master_model->generateItemCodeByCompanyId($company_id);
                $itemArr['name'] = $item_info['name'];
                $itemArr['alternative_name'] = $item_info['alternative_name'];
                $itemArr['type'] = $item_info['type'];
                $itemArr['p_type'] = $item_info['type'];
                if($item_info['category_name'] != ''){
                    $itemArr['category_id'] = $this->Common_model->fieldNameCheckingByFieldNameForAPI($item_info['category_name'], 'name', 'tbl_item_categories', $user_id, $company_id);
                }else{
                    $itemArr['category_id'] = '';
                } 
                if($item_info['brand_name'] != ''){
                    $itemArr['brand_id'] = $this->Common_model->fieldNameCheckingByFieldNameForAPI($item_info['brand_name'], 'name', 'tbl_brands', $user_id, $company_id);
                }else{
                    $itemArr['brand_id'] = '';
                }
                if($item_info['supplier_name']){
                    $itemArr['supplier_id'] =  $this->Common_model->fieldNameCheckingByFieldNameForAPI($item_info['supplier_name'], 'name', 'tbl_suppliers', $user_id, $company_id);
                }else{
                    $itemArr['supplier_id'] =  '';
                }
                $itemArr['alert_quantity'] = $item_info['alert_quantity'];
                if($item_info['purchase_unit_name'] != ''){
                    $itemArr['purchase_unit_id'] = $this->Common_model->fieldNameCheckingByFieldNameForAPI($item_info['purchase_unit_name'], 'unit_name', 'tbl_units', $user_id, $company_id);
                }else{
                    $itemArr['purchase_unit_id'] = '';
                }
                if($item_info['sale_unit_name'] != ''){
                    $itemArr['sale_unit_id'] = $this->Common_model->fieldNameCheckingByFieldNameForAPI($item_info['sale_unit_name'], 'unit_name', 'tbl_units', $user_id, $company_id);
                }else{
                    $itemArr['sale_unit_id'] = '';
                }
                if($unit_type == 'Single Unit'){
                    $itemArr['conversion_rate'] = 1;
                    $itemArr['unit_type'] = 1;
                }elseif($unit_type == 'Double Unit'){
                    $itemArr['conversion_rate'] = $item_info['conversion_rate'];
                    $itemArr['unit_type'] = 2;
                }
                $itemArr['purchase_price'] = $item_info['purchase_price'];
                $itemArr['whole_sale_price'] = $item_info['whole_sale_price'];
                $itemArr['warranty'] = $item_info['warranty'];
                $itemArr['warranty_date'] = $item_info['warranty_type'];
                $itemArr['guarantee'] = $item_info['guarantee'];
                $itemArr['guarantee_date'] = $item_info['guarantee_type'];
                $itemArr['description'] = $item_info['description'];
                $itemArr['sale_price'] = $item_info['sale_price'];
                $itemArr['added_date'] = date('Y-m-d H:i:s');
                $itemArr['user_id'] = $user_id;
                $itemArr['company_id'] = $company_id;
                $tax_info = json_decode(str_replace("'", '"', $item_info['tax_information']), true);
                $tax_name = array();
                foreach($tax_info as $tax){
                    $tax_name[] = $tax['tax_field_name'];
                }
                $tax_string = implode(':', $tax_name).":";
                if($tax_string === $company_info->tax_string){
                    $itemArr['tax_information'] = json_encode($tax_info);
                    $itemArr['tax_string'] = $tax_string;
                    $insertedId = $this->Common_model->insertInformation($itemArr, "tbl_items");
                    $this->saveOpeningStock($opening_stock, $item_info['type'], $item_info['conversion_rate'], $insertedId, $itemArr['user_id'], $company_id);
                    if($insertedId){
                        $response = array(
                            'status' => 200,
                            'message' => 'Data inserted successful.'
                        );
                    }else{
                        $response = array(
                            'status' => 400,
                            'message' => 'Insertion failded something wrong',
                        );
                    }
                }else{
                    $response = array(
                        'status' => 404,
                        'message' => "Tax String doesn't match",
                    );
                }
            }else{
                $response = array(
                    'status' => 400,
                    'message' => $itemErr,
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
     * editItem_post
     * @access public
     * @param no
     * @return json
     */
    public function editItem_post(){
        $item_inof = json_decode(file_get_contents("php://input"), true);
        $item_id = $item_inof['id'];
        $item_data = $this->Common_model->getDataById($item_id, 'tbl_items');
        if($item_data){
            $response = [
                'status' => 200,
                'data' => $item_data,
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
     * updateItem_post
     * @access public
     * @param no
     * @return json
     */
    public function updateItem_post(){
        $item_info = json_decode(file_get_contents("php://input"), true);
        $item_id = $item_info['id'];
        $find_item_id = $this->Common_model->getFindId($item_id, 'tbl_items');
        if($find_item_id){
            $item_updated_id = $find_item_id->id;
            $company_info = getCompanyInfoByAPIKey($item_info['api_auth_key']);
            if($company_info){
                $company_id = $company_info->id;
                $user_id = $company_info->user_id;
                $unit_type = $item_info['unit_type'];
                $opening_stock =  json_decode(str_replace("'", '"', $item_info['opening_stock']), true);
                $itemArr = array();
                $itemArr['name'] = $item_info['name'];
                $itemArr['alternative_name'] = $item_info['alternative_name'];
                $itemArr['type'] = $item_info['type'];
                $itemArr['p_type'] = $item_info['type'];
                if($item_info['category_name'] != ''){
                    $itemArr['category_id'] = $this->Common_model->fieldNameCheckingByFieldNameForAPI($item_info['category_name'], 'name', 'tbl_item_categories', $user_id, $company_id);
                }else{
                    $itemArr['category_id'] = '';
                } 
                if($item_info['brand_name'] != ''){
                    $itemArr['brand_id'] = $this->Common_model->fieldNameCheckingByFieldNameForAPI($item_info['brand_name'], 'name', 'tbl_brands', $user_id, $company_id);
                }else{
                    $itemArr['brand_id'] = '';
                }
                if($item_info['supplier_name']){
                    $itemArr['supplier_id'] =  $this->Common_model->fieldNameCheckingByFieldNameForAPI($item_info['supplier_name'], 'name', 'tbl_suppliers', $user_id, $company_id);
                }else{
                    $itemArr['supplier_id'] =  '';
                }
                $itemArr['alert_quantity'] = $item_info['alert_quantity'];
                if($item_info['purchase_unit_name'] != ''){
                    $itemArr['purchase_unit_id'] = $this->Common_model->fieldNameCheckingByFieldNameForAPI($item_info['purchase_unit_name'], 'unit_name', 'tbl_units', $user_id, $company_id);
                }else{
                    $itemArr['purchase_unit_id'] = '';
                }
                if($item_info['sale_unit_name'] != ''){
                    $itemArr['sale_unit_id'] = $this->Common_model->fieldNameCheckingByFieldNameForAPI($item_info['sale_unit_name'], 'unit_name', 'tbl_units', $user_id, $company_id);
                }else{
                    $itemArr['sale_unit_id'] = '';
                }
                if($unit_type == 'Single Unit'){
                    $itemArr['conversion_rate'] = 1;
                    $itemArr['unit_type'] = 1;
                }elseif($unit_type == 'Double Unit'){
                    $itemArr['conversion_rate'] = $item_info['conversion_rate'];
                    $itemArr['unit_type'] = 2;
                }
                $itemArr['purchase_price'] = $item_info['purchase_price'];
                $itemArr['whole_sale_price'] = $item_info['whole_sale_price'];
                $itemArr['warranty'] = $item_info['warranty'];
                $itemArr['warranty_date'] = $item_info['warranty_type'];
                $itemArr['guarantee'] = $item_info['guarantee'];
                $itemArr['guarantee_date'] = $item_info['guarantee_type'];
                $itemArr['description'] = $item_info['description'];
                $itemArr['sale_price'] = $item_info['sale_price'];
                $itemArr['user_id'] = $user_id;
                $itemArr['company_id'] = $company_id;
                // Tax
                $tax_info = json_decode(str_replace("'", '"', $item_info['tax_information']), true);
                $tax_name = array();
                foreach($tax_info as $tax){
                    $tax_name[] = $tax['tax_field_name'];
                }
                $tax_string = implode(':', $tax_name);
                if($tax_string === $company_info->tax_string){
                    $itemArr['tax_information'] = json_encode($tax_info);
                    $itemArr['tax_string'] = $tax_string;
                }else{
                    $response = array(
                        'status' => 404,
                        'message' => "Tax String doesn't match",
                    );
                }
                $this->Common_model->updateInformation($itemArr, $item_updated_id, "tbl_items");
                $this->Common_model->deletingMultipleFormData('item_id', $item_updated_id, 'tbl_set_opening_stocks');
                $this->saveOpeningStock($opening_stock, $item_info['type'], $item_info['conversion_rate'], $item_updated_id, $itemArr['user_id'], $company_id);
                if($item_updated_id){
                    $response = array(
                        'status' => 200,
                        'message' => 'Data updated successful.'
                    );
                }else{
                    $response = array(
                        'status' => 400,
                        'message' => 'Insertion failded something wrong',
                    );
                }
            } else {
                $response = array(
                    'status' => 500,
                    'message' => 'API Key is not valid',
                ); 
            }
        } else {
            $response = array(
                'status' => 404,
                'message' => 'Item Not Found',
            ); 
        }
        $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
    }


    /**
     * deleteItem_pos
     * @access public
     * @param no
     * @return json
     */
    public function deleteItem_post(){
        $item_info = json_decode(file_get_contents("php://input"), true);
        $item_id = $item_info['id'];
        $item_data2 = $this->Common_model->getFindId($item_id, 'tbl_items');
        if($item_data2){
            $this->Common_model->deleteStatusChange($item_id, "tbl_items");
            $this->Common_model->childItemDeleteStatusChange($item_id, "tbl_items");
            $this->Common_model->openingStockItemDeleteStatusChange($item_id);
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
     * saveOpeningStock
     * @access public
     * @param string
     * @param int
     * @param int
     * @param string
     * @return void
     */
    public function saveOpeningStock($opening_stock, $item_type, $conversion_rate, $insertedId, $user_id, $company_id) {
        foreach($opening_stock as $key=>$op_stock){
            $outlet_name = $op_stock['outlet_name'];
            $fmi = array();
            $fmi['item_id'] = $insertedId;
            $fmi['item_type'] = $item_type;
            $fmi['item_description'] = $op_stock['iem_description'];
            $fmi['stock_quantity'] = $op_stock['stock_quantity'] * $conversion_rate;
            $fmi['outlet_id'] = $this->Common_model->fieldNameCheckingByFieldNameForAPI($outlet_name, 'outlet_name', 'tbl_outlets', $user_id, $company_id);
            $fmi['user_id'] = $user_id;
            $fmi['company_id'] = $company_id;
            if($op_stock['stock_quantity'] != ''){
                $this->Common_model->insertInformation($fmi, 'tbl_set_opening_stocks');
            }
        }
    }

}

?>