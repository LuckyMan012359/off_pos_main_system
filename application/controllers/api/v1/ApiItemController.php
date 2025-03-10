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
defined('BASEPATH') or exit('No direct script access allowed');

require(APPPATH . 'libraries/REST_Controller.php');

class ApiItemController extends REST_Controller
{
    /**
     * load constructor
     * @access public
     * @return void
     */
    public function __construct()
    {
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
    public function itemList_get()
    {
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
    public function addItem_post()
    {
        $item_info = json_decode(file_get_contents("php://input"), true);
        $company_info = getCompanyInfoByAPIKey($item_info['api_auth_key']);
        $outlet = $this->Common_model->getDataByField($item_info['domain'], 'tbl_outlets', 'domain');
        $error = false;
        if ($company_info && $outlet) {
            $itemErr = [];
            if ($item_info['name'] == '') {
                $error = true;
                $itemErr['name'] = 'The Name field is required';
            }
            if ($item_info['sale_price'] == '') {
                $error = true;
                $itemErr['sale_price'] = 'The Sale Price field is required';
            }
            if ($item_info['category_name'] == '') {
                $error = true;
                $itemErr['category_name'] = 'The Category Name field is required';
            }
            if ($item_info['unit_type'] == '') {
                $error = true;
                $itemErr['unit_type'] = 'The Unit Type field is required';
            }
            if ($error == false) {
                $company_id = $company_info->id;
                $unit_type = $item_info['unit_type'];
                $opening_stock = json_decode(str_replace("'", '"', $item_info['opening_stock']), true);
                $itemArr = array();

                $existItem = $this->Common_model->getDataByField($item_info['code'], 'tbl_items', 'code');

                if (empty($existItem)) {
                    $itemArr['code'] = $item_info['code'];
                } else {
                    $generated_code = $this->Master_model->generateItemCodeByCompanyId($company_id);
                    $product_code_start_from = $this->session->userdata('product_code_start_from');

                    if (!$product_code_start_from) {
                        $company_data = $this->Common_model->getDataById($company_id, 'tbl_companies');

                        $product_code_start_from = $company_data->inv_no_start_from;
                    }

                    $itemArr['code'] = ((int) $product_code_start_from - 1) + (int) $generated_code;
                }
                $itemArr['name'] = $item_info['name'];
                $itemArr['photo'] = $item_info['photo'];
                $itemArr['alternative_name'] = $item_info['alternative_name'];
                $itemArr['type'] = $item_info['type'];
                $itemArr['p_type'] = $item_info['type'];
                $itemArr['loyalty_point'] = $item_info['loyalty_point'];
                $itemArr['profit_margin'] = $item_info['profit_margin'];
                if ($item_info['category_name'] != '') {
                    $itemArr['category_id'] = $this->Common_model->fieldNameCheckingByFieldNameForAPI($item_info['category_name'], 'name', 'tbl_item_categories', 0, $company_id);
                } else {
                    $itemArr['category_id'] = '';
                }
                if ($item_info['brand_name'] != '') {
                    $itemArr['brand_id'] = $this->Common_model->fieldNameCheckingByFieldNameForAPI($item_info['brand_name'], 'name', 'tbl_brands', 0, $company_id);
                } else {
                    $itemArr['brand_id'] = '';
                }
                if ($item_info['supplier_name']) {
                    $itemArr['supplier_id'] = $this->Common_model->fieldNameCheckingByFieldNameForAPI($item_info['supplier_name'], 'name', 'tbl_suppliers', 0, $company_id);
                } else {
                    $itemArr['supplier_id'] = '';
                }
                $itemArr['alert_quantity'] = $item_info['alert_quantity'];
                if ($item_info['purchase_unit_name'] != '') {
                    $itemArr['purchase_unit_id'] = $this->Common_model->fieldNameCheckingByFieldNameForAPI($item_info['purchase_unit_name'], 'unit_name', 'tbl_units', 0, $company_id);
                } else {
                    $itemArr['purchase_unit_id'] = '';
                }
                if ($item_info['sale_unit_name'] != '') {
                    $itemArr['sale_unit_id'] = $this->Common_model->fieldNameCheckingByFieldNameForAPI($item_info['sale_unit_name'], 'unit_name', 'tbl_units', 0, $company_id);
                } else {
                    $itemArr['sale_unit_id'] = '';
                }
                if ($unit_type == 'Single Unit') {
                    $itemArr['conversion_rate'] = 1;
                    $itemArr['unit_type'] = 1;
                } elseif ($unit_type == 'Double Unit') {
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
                $itemArr['user_id'] = 0;
                $itemArr['company_id'] = $company_id;
                $tax_info = json_decode(str_replace("'", '"', $item_info['tax_information']), true);
                $tax_name = array();
                foreach ($tax_info as $tax) {
                    $tax_name[] = $tax['tax_field_name'];
                }
                $tax_string = implode(':', $tax_name) . ":";
                if ($tax_string === $company_info->tax_string) {
                    $itemArr['tax_information'] = json_encode($tax_info);
                    $itemArr['tax_string'] = $tax_string;
                    $insertedId = $this->Common_model->insertInformation($itemArr, "tbl_items");
                    $this->saveOpeningStock($opening_stock, $item_info['type'], $item_info['conversion_rate'], $insertedId, $itemArr['user_id'], $company_id);
                    if ($insertedId) {
                        $response = array(
                            'status' => 200,
                            'message' => 'Data inserted successful.',
                            'opening_stock' => $opening_stock,
                            'code' => $itemArr['code'],
                        );
                    } else {
                        $response = array(
                            'status' => 400,
                            'message' => 'Insertion failded something wrong',
                        );
                    }
                } else {
                    $response = array(
                        'status' => 404,
                        'message' => "Tax String doesn't match",
                        'data' => array('tax_string' => $company_info->tax_string, 'company_info' => $company_info, 'tax_info' => $tax_string),
                    );
                }
            } else {
                $response = array(
                    'status' => 400,
                    'message' => $itemErr,
                );
            }
        } else {
            $response = array(
                'status' => 500,
                'message' => 'API Key is not valid',
                'data' => $company_info,
                'api_auth_key' => $item_info['api_auth_key'],
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
    public function editItem_post()
    {
        $item_inof = json_decode(file_get_contents("php://input"), true);
        $item_id = $item_inof['id'];
        $item_data = $this->Common_model->getDataById($item_id, 'tbl_items');
        if ($item_data) {
            $response = [
                'status' => 200,
                'data' => $item_data,
            ];
        } else {
            $response = [
                'status' => 404,
                'data' => 'Data Not Found!',
            ];
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function uploadImage_post()
    {
        $upload_path = FCPATH . 'uploads/items/';

        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, true);
        }

        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['file_name'] = $_FILES['photo']['name'];

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('photo')) {
            $error = $this->upload->display_errors();
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => 'error',
                    'message' => $error
                ]));
        } else {
            $upload_data = $this->upload->data();
            $file_path = $upload_data['full_path'];

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => 'success',
                    'file_path' => $file_path,
                    'file_name' => $upload_data['file_name'],
                    'file_size' => $upload_data['file_size'],
                    'file_type' => $upload_data['file_type']
                ]));
        }
    }


    /**
     * updateItem_post
     * @access public
     * @param no
     * @return json
     */
    public function updateItem_post()
    {
        $item_info = json_decode(file_get_contents("php://input"), true);
        // $item_id = $item_info['id'];
        $item_code = $item_info['code'];
        $find_item_id = getItemData($item_code);
        $outlet = $this->Common_model->getDataByField($item_info['domain'], 'tbl_outlets', 'domain');
        $response = array(
            'status' => 500,
            'message' => 'API Key is not valid',
            'item_info' => $item_info,
            'opening_stock_data' => json_decode($item_info['opening_stock']),

        );
        if ($find_item_id && $outlet) {
            $item_updated_id = $find_item_id->id;
            $company_info = getCompanyInfoByAPIKey($item_info['api_auth_key']);
            if ($company_info) {
                $company_id = $company_info->id;
                $user_id = $company_info->user_id;
                $unit_type = $item_info['unit_type'];
                $opening_stock = json_decode(str_replace("'", '"', $item_info['opening_stock']), true);
                $itemArr = array();
                $itemArr['code'] = $item_info['code'];
                $itemArr['name'] = $item_info['name'];
                $itemArr['photo'] = $item_info['photo'];
                $itemArr['alternative_name'] = $item_info['alternative_name'];
                $itemArr['type'] = $item_info['type'];
                $itemArr['p_type'] = $item_info['type'];
                $itemArr['loyalty_point'] = $item_info['loyalty_point'];
                $itemArr['profit_margin'] = $item_info['profit_margin'];
                if ($item_info['category_name'] != '') {
                    $itemArr['category_id'] = $this->Common_model->fieldNameCheckingByFieldNameForAPI($item_info['category_name'], 'name', 'tbl_item_categories', $user_id, $company_id);
                } else {
                    $itemArr['category_id'] = '';
                }
                if ($item_info['brand_name'] != '') {
                    $itemArr['brand_id'] = $this->Common_model->fieldNameCheckingByFieldNameForAPI($item_info['brand_name'], 'name', 'tbl_brands', $user_id, $company_id);
                } else {
                    $itemArr['brand_id'] = '';
                }
                if ($item_info['supplier_name']) {
                    $itemArr['supplier_id'] = $this->Common_model->fieldNameCheckingByFieldNameForAPI($item_info['supplier_name'], 'name', 'tbl_suppliers', $user_id, $company_id);
                } else {
                    $itemArr['supplier_id'] = '';
                }
                $itemArr['alert_quantity'] = $item_info['alert_quantity'];
                if ($item_info['purchase_unit_name'] != '') {
                    $itemArr['purchase_unit_id'] = $this->Common_model->fieldNameCheckingByFieldNameForAPI($item_info['purchase_unit_name'], 'unit_name', 'tbl_units', $user_id, $company_id);
                } else {
                    $itemArr['purchase_unit_id'] = '';
                }
                if ($item_info['sale_unit_name'] != '') {
                    $itemArr['sale_unit_id'] = $this->Common_model->fieldNameCheckingByFieldNameForAPI($item_info['sale_unit_name'], 'unit_name', 'tbl_units', $user_id, $company_id);
                } else {
                    $itemArr['sale_unit_id'] = '';
                }
                if ($unit_type == 'Single Unit') {
                    $itemArr['conversion_rate'] = 1;
                    $itemArr['unit_type'] = 1;
                } elseif ($unit_type == 'Double Unit') {
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
                foreach ($tax_info as $tax) {
                    $tax_name[] = $tax['tax_field_name'];
                }
                $tax_string = implode(':', $tax_name);
                if ($tax_string === $company_info->tax_string) {
                    $itemArr['tax_information'] = json_encode($tax_info);
                    $itemArr['tax_string'] = $tax_string;
                } else {
                    $response = array(
                        'status' => 404,
                        'message' => "Tax String doesn't match",
                    );
                }
                $this->Common_model->updateInformation($itemArr, $item_updated_id, "tbl_items");

                $outlet_id = $this->Common_model->fieldNameCheckingByFieldNameForAPI($item_info['domain'], 'domain', 'tbl_outlets', $user_id, $company_id);

                $this->Common_model->deletingByMulipleFields('item_id', $item_updated_id, 'outlet_id', $outlet_id, 'tbl_set_opening_stocks');
                $this->updateOpeningStock($opening_stock, $item_info['type'], $item_info['conversion_rate'], $item_updated_id, $user_id, $company_id, $item_info['domain']);

                $opening_stocks = $this->Common_model->getDataByField($item_updated_id, 'tbl_set_opening_stocks', 'item_id');

                $preview_opening_stock_data = $this->Common_model->getDataByField($item_updated_id, 'tbl_set_opening_stocks', 'item_id');

                foreach ($preview_opening_stock_data as $key => $value) {
                    $outlet_info = $this->Common_model->getDataByField($value->outlet_id, 'tbl_outlets', 'id');
                    $value->outlet_data = $outlet_info;
                }

                $item_info['preview_opening_stock_data'] = $preview_opening_stock_data;

                $openingStockData = [];

                if ($itemArr['type'] != 'Variation_Product') {
                    foreach ($opening_stocks as $key => $op_stock) {
                        $outlet_data = $this->Common_model->getDataById($op_stock->outlet_id, 'tbl_outlets');
                        $openingStockData[] = [
                            "outlet_id" => $outlet_data->id,
                            "outlet_name" => $outlet_data->outlet_name,
                            "api_key" => $outlet_data->token,
                            "domain" => $outlet_data->domain,
                            "quantity" => $op_stock->stock_quantity,
                            "conversion_rate" => $item_info['conversion_rate'],
                            "item_description" => $op_stock->item_description
                        ];
                    }
                }

                if ($itemArr['type'] == 'Combo_Product') {
                    if (isset($_POST['combo_item_qty']) && $_POST['combo_item_qty']) {
                        foreach ($_POST['combo_item_qty'] as $key => $combo_item) {
                            $openingStockData[] = [
                                "combo_item_id" => $key,
                                "combo_item_quantity" => $combo_item,
                            ];
                        }
                    }
                }

                $item_info['opening_stock_data'] = $openingStockData;
                $item_info['p_type'] = $item_info['type'];

                if ($item_info['unit_type'] == 'Single Unit') {
                    $item_info['unit_type'] = 1;
                } else if ($item_info['unit_type'] == 'Double Unit') {
                    $item_info['unit_type'] = 2;
                }

                $nodejs_url = "http://localhost:5000/api/main/product/update-item";
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $nodejs_url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($item_info));
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen(json_encode($item_info))
                ]);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_exec($ch);
                curl_close($ch);

                $fmi = array();
                $fmi['item_id'] = $item_updated_id;
                $fmi['item_type'] = $item_info['type'];
                $fmi['item_description'] = $opening_stock[0]['item_description'];
                $fmi['stock_quantity'] = $opening_stock[0]['quantity'] * $item_info['conversion_rate'];
                $fmi['outlet_id'] = $this->Common_model->fieldNameCheckingByFieldNameForAPI($item_info['domain'], 'domain', 'tbl_outlets', $user_id, $company_id);
                $fmi['user_id'] = $user_id;
                $fmi['company_id'] = $company_id;

                foreach ($opening_stock as $key => $value) {
                    $fmi[$key] = $value;
                }

                if ($item_updated_id) {
                    $response = array(
                        'status' => 200,
                        'message' => 'Data updated successful.',
                        'data' => $opening_stock,
                        'item_info' => $item_info,
                        'itemArr' => $itemArr,
                        'type' => $item_info['type'],
                        'conversation_rate' => $item_info['conversion_rate'],
                        'updated_item_id' => $item_updated_id,
                        'user_id' => $user_id,
                        'company_id' => $company_id,
                        'outlet_id' => $this->Common_model->fieldNameCheckingByFieldNameForAPI($item_info['domain'], 'domain', 'tbl_outlets', $user_id, $company_id),
                        'item_description' => $opening_stock[0]['item_description'],
                        'fmi' => $fmi
                    );
                } else {
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
    public function deleteItem_post()
    {
        $item_info = json_decode(file_get_contents("php://input"), true);
        $item_id = $item_info['id'];
        $item_code = $item_info['code'];
        $find_item_id = getItemData($item_code);
        if ($find_item_id) {
            $company_info = getCompanyInfoByAPIKey($item_info['api_auth_key']);
            $outlet = $this->Common_model->getDataByField($item_info['domain'], 'tbl_outlets', 'domain');
            if ($company_info && $outlet) {
                $opening_stocks = $this->Common_model->getDataByField($find_item_id->id, 'tbl_set_opening_stocks', 'item_id');

                if (count($opening_stocks) > 1) {
                    $this->Common_model->deleteStatusChangeByMulipleFields($find_item_id->id, 'item_id', $outlet[0]->id, 'outlet_id', 'tbl_set_opening_stocks');
                } else {
                    $this->Common_model->deleteStatusChange($find_item_id->id, "tbl_items");
                    $this->Common_model->childItemDeleteStatusChange($find_item_id->id, "tbl_items");
                    $this->Common_model->openingStockItemDeleteStatusChange($find_item_id->id);
                }
                $response = [
                    'status' => 200,
                    'data' => 'Item Deleted Successfully',
                    'outlet' => $outlet[0]->id,
                    'outlet_id' => $outlet->id,
                    'outlet_data' => $outlet,
                ];
            } else {
                $response = array(
                    'status' => 500,
                    'message' => 'API Key is not valid',
                );
            }
        } else {
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
    public function saveOpeningStock($opening_stock, $item_type, $conversion_rate, $insertedId, $user_id, $company_id)
    {
        foreach ($opening_stock as $key => $op_stock) {
            $outlet_name = $op_stock['outlet_name'];
            $fmi = array();
            $fmi['item_id'] = $insertedId;
            $fmi['item_type'] = $item_type;
            $fmi['item_description'] = $op_stock['item_description'];
            $fmi['stock_quantity'] = $op_stock['quantity'] * $conversion_rate;
            $fmi['outlet_id'] = $this->Common_model->fieldNameCheckingByFieldNameForAPI($outlet_name, 'outlet_name', 'tbl_outlets', $user_id, $company_id);
            $fmi['user_id'] = $user_id;
            $fmi['company_id'] = $company_id;
            if ($op_stock['quantity'] != '') {
                $this->Common_model->insertInformation($fmi, 'tbl_set_opening_stocks');
            }
        }
    }

    public function updateOpeningStock($opening_stock, $item_type, $conversion_rate, $insertedId, $user_id, $company_id, $domain)
    {
        foreach ($opening_stock as $key => $op_stock) {
            $fmi = array();
            $fmi['item_id'] = $insertedId;
            $fmi['item_type'] = $item_type;
            $fmi['item_description'] = $op_stock['item_description'];
            $fmi['stock_quantity'] = $op_stock['quantity'] * $conversion_rate;
            $fmi['outlet_id'] = $this->Common_model->fieldNameCheckingByFieldNameForAPI($domain, 'domain', 'tbl_outlets', $user_id, $company_id);
            $fmi['user_id'] = $user_id;
            $fmi['company_id'] = $company_id;
            if ($op_stock['quantity'] != '') {
                $this->Common_model->insertInformation($fmi, 'tbl_set_opening_stocks');
            }

        }
    }
}

?>
