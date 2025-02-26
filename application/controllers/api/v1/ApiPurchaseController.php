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
  # This is ApiPurchaseController
  ###########################################################
 */
defined('BASEPATH') or exit('No direct script access allowed');

require(APPPATH . 'libraries/REST_Controller.php');

class ApiPurchaseController extends REST_Controller
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
     * addSale_post
     * @access public
     * @param no
     * @return json
     */
    public function addPurchase_post()
    {
        $purchase_info = json_decode(file_get_contents("php://input"), true);
        $supplier_info = $purchase_info['supplier_info'];
        $company_info = getCompanyInfoByAPIKey($purchase_info['api_auth_key']);
        $outlet_info = getOutletInfoByAPIKey($purchase_info['api_auth_key']);
        $error = false;
        if ($company_info && $outlet_info->domain === $purchase_info['domain']) {
            $purchaseArr = array();

            $purchaseArr['reference_no'] = $purchase_info['reference_no'];
            $purchaseArr['invoice_no'] = $purchase_info['invoice_no'];
            $purchaseArr['supplier_id'] = $this->Common_model->getSupplierDataByMulipleField($supplier_info['name'], 'name', 'tbl_suppliers', 0, $company_info->id, $supplier_info);
            $purchaseArr['date'] = $purchase_info['date'];
            $purchaseArr['other'] = $purchase_info['other'];
            $purchaseArr['grand_total'] = $purchase_info['grand_total'];
            $purchaseArr['paid'] = $purchase_info['paid'];
            $purchaseArr['due_amount'] = $purchase_info['due_amount'];
            $purchaseArr['note'] = $purchase_info['note'];
            $purchaseArr['discount'] = $purchase_info['discount'];
            $purchaseArr['user_id'] = 0;
            $purchaseArr['outlet_id'] = $this->Common_model->fieldNameCheckingByFieldNameForAPI($outlet_info->outlet_name, 'outlet_name', 'tbl_outlets', 0, $company_info->id);
            $purchaseArr['company_id'] = $company_info->id;
            $purchaseArr['added_date'] = $purchase_info['added_date'];
            $purchaseArr['verify_code'] = $purchase_info['verify_code'];

            if ($purchase_info['attachment']) {
                $purchaseArr['attachment'] = $purchase_info['attachment'];
            }

            $item_info = [];

            foreach ($purchase_info['code'] as $key => $value) {
                $item_data = $this->Common_model->getDataByField($value, 'tbl_items', 'code');
                $item_info[] = $item_data[0]->id;
            }

            if (count($item_info) > 0) {
                $purchase_id = $this->Common_model->insertInformation($purchaseArr, "tbl_purchase");
                $this->savePurchaseDetails($item_info, $purchase_id, 'tbl_purchase_details', $purchase_info);

                if (isset($purchase_info['payment_id']) && $purchase_info['payment_id']) {
                    $this->savePaymentMethod($purchase_info['payment_id'], $purchase_id, 'tbl_purchase_payments', $purchase_info);
                }
            }

            if ($purchase_id) {
                $response = array(
                    'status' => 200,
                    'message' => "Purchase create successfully",
                    "data" => $purchaseArr,
                    'outlet_data' => $outlet_info->outlet_name,
                    'company_info' => $company_info
                );
            } else {
                $response = array(
                    'status' => 400,
                    'message' => "Purchase failded something wrong",
                );
            }
        } else {
            $response = array(
                'status' => 500,
                'message' => 'API Key is not valid',
                'outlet_info' => $outlet_info,
                'company_info' => $company_info,
                'supplier_info' => $supplier_info
            );
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
    public function updatePurchase_post()
    {
        $find_purchase_id = json_decode(file_get_contents("php://input"), true);

        $verify_code = $find_purchase_id['verify_code'];

        $find_purchase_id = $this->Common_model->getDataByField($verify_code, 'tbl_purchase', 'verify_code');

        if ($find_purchase_id) {
            $purchase_updated_id = $find_purchase_id[0]->id;
            $purchase_info = json_decode(file_get_contents("php://input"), true);

            $supplier_info = $purchase_info['supplier_info'];
            $company_info = getCompanyInfoByAPIKey($purchase_info['api_auth_key']);
            $outlet_info = getOutletInfoByAPIKey($purchase_info['api_auth_key']);
            $error = false;
            if ($company_info && $outlet_info->domain === $purchase_info['domain']) {
                $purchaseArr = array();

                $purchaseArr['reference_no'] = $purchase_info['reference_no'];
                $purchaseArr['supplier_id'] = $this->Common_model->getSupplierDataByMulipleField($supplier_info['name'], 'name', 'tbl_suppliers', 0, $company_info->id, $supplier_info);
                $purchaseArr['invoice_no'] = $purchase_info['invoice_no'];
                $purchaseArr['supplier_id'] = $purchase_info['supplier_id'];
                $purchaseArr['other'] = $purchase_info['other'];
                $purchaseArr['grand_total'] = $purchase_info['grand_total'];
                $purchaseArr['paid'] = $purchase_info['paid'];
                $purchaseArr['due_amount'] = $purchase_info['due_amount'];
                $purchaseArr['note'] = $purchase_info['note'];
                $purchaseArr['discount'] = $purchase_info['discount'];
                $purchaseArr['user_id'] = 0;
                $purchaseArr['outlet_id'] = $this->Common_model->fieldNameCheckingByFieldNameForAPI($outlet_info->outlet_name, 'outlet_name', 'tbl_outlets', 0, $company_info->id);
                $purchaseArr['company_id'] = $company_info->id;

                if ($purchase_info['attachment']) {
                    $purchaseArr['attachment'] = $purchase_info['attachment'];
                }

                $item_info = [];

                foreach ($purchase_info['code'] as $key => $value) {
                    $item_data = $this->Common_model->getDataByField($value, 'tbl_items', 'code');
                    $item_info[] = $item_data[0]->id;
                }

                if (count($item_info) > 0) {
                    $this->Common_model->updateInformation($purchaseArr, $purchase_updated_id, "tbl_purchase");
                    $this->Common_model->deletingMultipleFormData('purchase_id', $purchase_updated_id, 'tbl_purchase_details');
                    $this->savePurchaseDetails($item_info, $purchase_updated_id, 'tbl_purchase_details', $purchase_info);
                    $this->Common_model->deletingMultipleFormData('purchase_id', $purchase_updated_id, 'tbl_purchase_payments');
                    if (isset($purchase_info['payment_id']) && $purchase_info['payment_id']) {
                        $this->savePaymentMethod($purchase_info['payment_id'], $purchase_updated_id, 'tbl_purchase_payments', $purchase_info);
                    }
                }

                if ($purchase_updated_id) {
                    $response = array(
                        'status' => 200,
                        'message' => "Purchase create successfully",
                        'ids' => $item_info,
                    );
                } else {
                    $response = array(
                        'status' => 400,
                        'message' => "Purchase failded something wrong",
                    );
                }
            } else {
                $response = array(
                    'status' => 500,
                    'message' => 'API Key is not valid',
                    'outlet_info' => $outlet_info,
                    'api_key' => $purchase_info['api_auth_key']
                );
            }
        } else {
            $response = array(
                'status' => 404,
                'message' => 'Sale Not Found',
                'ramdom_code' => $verify_code,
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
    public function deletePurchase_post()
    {
        $find_purchase_id = json_decode(file_get_contents("php://input"), true);
        $verify_code = $find_purchase_id['verify_code'];
        $find_purchase_id = $this->Common_model->getDataByField($verify_code, 'tbl_purchase', 'verify_code');
        if ($find_purchase_id) {
            $purchase_id = $find_purchase_id[0]->id;
            $purchase_info = json_decode(file_get_contents("php://input"), true);
            $company_info = getCompanyInfoByAPIKey($purchase_info['api_auth_key']);
            $outlet_info = getOutletInfoByAPIKey($purchase_info['api_auth_key']);
            if ($company_info && $outlet_info->domain === $purchase_info['domain']) {
                $this->Common_model->deleteStatusChangeWithChild($purchase_id, $purchase_id, "tbl_purchase", "tbl_purchase_details", 'id', 'purchase_id');
                $this->Common_model->deleteStatusChangeByFieldName($purchase_id, 'purchase_id', 'tbl_purchase_payments');
                $response = [
                    'status' => 200,
                    'data' => 'Purchase Deleted Successfully',
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
                'data1' => json_decode(file_get_contents("php://input"), true),
                'random_code' => $verify_code,
            ];
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }


    public function savePurchaseDetails($purchase_items, $purchase_id, $table_name, $purchase_info)
    {
        foreach ($purchase_items as $row => $item_id):
            if ($item_id != null) {
                $fmi = array();
                $fmi['item_id'] = $purchase_info['item_id'][$row];
                $fmi['item_type'] = $purchase_info['item_type'][$row];
                if (isset($purchase_info['expiry_imei_serial'])) {
                    $fmi['expiry_imei_serial'] = $purchase_info['expiry_imei_serial'][$row];
                }
                $fmi['unit_price'] = $purchase_info['unit_price'][$row];
                if (!empty((int) $purchase_info['conversion_rate'][$row])) {
                    $fmi['divided_price'] = round(($purchase_info['unit_price'][$row] / $purchase_info['conversion_rate'][$row]), 2);
                } else {
                    $fmi['divided_price'] = $purchase_info['unit_price'][$row] / 1;
                }
                $fmi['quantity_amount'] = $purchase_info['quantity_amount'][$row];
                $fmi['total'] = $purchase_info['total'][$row];
                $fmi['purchase_id'] = $purchase_id;
                $fmi['outlet_id'] = $this->session->userdata('outlet_id');
                $fmi['company_id'] = $this->session->userdata('company_id');
                $this->Common_model->insertInformation($fmi, "tbl_purchase_details");
                setAveragePrice($item_id);
            }
        endforeach;
    }

    public function savePaymentMethod($payment_method, $purchase_id, $table_name, $purchase_info)
    {
        foreach ($payment_method as $row => $payment_id):
            $fmi = array();
            $fmi['added_date'] = date('Y-m-d');
            $fmi['purchase_id'] = $purchase_id;
            $fmi['payment_id'] = $purchase_info['payment_id'][$row];
            $fmi['amount'] = $purchase_info['payment_value'][$row];
            $fmi['outlet_id'] = $this->session->userdata('outlet_id');
            $fmi['user_id'] = $this->session->userdata('user_id');
            $fmi['company_id'] = $this->session->userdata('company_id');
            $this->Common_model->insertInformation($fmi, $table_name);
        endforeach;
    }

    public function uploadAttachment_post()
    {
        $upload_path = FCPATH . 'uploads/purchase-attachment/';

        // Ensure the directory exists
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, true);
        }

        // Configure file upload settings
        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
        // Set a unique name for the uploaded file to avoid collisions
        $config['file_name'] = $_FILES['photo']['name'];

        $this->load->library('upload', $config);

        // Check for upload success
        if (!$this->upload->do_upload('photo')) {
            // Handle upload failure
            $error = $this->upload->display_errors();
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => 'error',
                    'message' => $error
                ]));
        } else {
            // Successfully uploaded
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
}

?>
