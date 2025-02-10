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
    # This is Item Controller
    ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Item extends Cl_Controller {

    /**
     * load constructor
     * @access public
     * @return void
     */    
    public function __construct() {
        parent::__construct();
        $this->load->model('Authentication_model');
        $this->load->model('Common_model');
        $this->load->library('excel'); //load PHPExcel library
        $this->load->model('Master_model');
        $this->load->model('Stock_model');
        $this->load->model('Outlet_model');
        $this->load->library('form_validation');
        $this->Common_model->setDefaultTimezone();
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        //start check access function
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $controller = "49";
        $function = "";
        if(($segment_2=="addEditItem") || ($segment_2 == "getItem" || $segment_2 == "getVariationItem" || $segment_2 == "imeiSerialStockCheck" || $segment_2 == "imeiSerialCheck" || $segment_2 == "stockQtyCheck" || $segment_2 == 'bulkItemUpdate' || $segment_2 == 'getBulkAjaxData' || $segment_2 == 'bulkPriceUpdate' || $segment_2=="changeStatus")){
            $function = "add";
        }elseif(($segment_2=="addEditItem" && $segment_2) || ($segment_2 == "getItem" || $segment_2 == "getVariationItem" || $segment_2 == "imeiSerialStockCheck" || $segment_2 == "imeiSerialCheck" || $segment_2 == "stockQtyCheck" || $segment_2 == 'bulkItemUpdate' || $segment_2 == 'getBulkAjaxData' || $segment_2 == 'bulkPriceUpdate' || $segment_2=="changeStatus")){
            $function = "edit";
        }elseif($segment_2=="itemDetails"){
            $function = "view";
        }elseif($segment_2=="changeStatus"){
            $function = "enable_disable_status";
        }elseif($segment_2=="deleteItem"){
            $function = "delete";
        }elseif($segment_2=="items" || $segment_2 == "getAjaxData"){
            $function = "list";
        }elseif($segment_2=="uploadItem"){
            $function = "upload_item";
        }elseif($segment_2=="uploadItemPhoto"){
            $function = "upload_photo";
        }elseif($segment_2=="itemBarcodeGenerator"){
            $function = "print_barcode";
        }elseif($segment_2=="itemBarcodeGeneratorLabel"){
            $function = "print_label";
        }elseif($segment_2=="bulkDelete"){
            $function = "bulkdelete";
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
     * addEditItem
     * @access public
     * @param int
     * @return void
     */
    public function addEditItem($encrypted_id = "") {
        $company_id = $this->session->userdata('company_id');
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $add_more = $this->input->post($this->security->xss_clean('add_more'));
            // Get Default Input value for condition checking
            $type = htmlspecialcharscustom($this->input->post('type'));
            $expiry_date_maintain = htmlspecialcharscustom($this->input->post('expiry_date_maintain'));
            // Global validation
            $this->form_validation->set_rules('type', lang('type'), 'required|max_length[30]');
            $this->form_validation->set_rules('name', lang('name'), 'required|max_length[100]');
            $this->form_validation->set_rules('alternative_name', lang('alternative_name'), 'max_length[100]');
            $this->form_validation->set_rules('code', lang('code'), 'required|max_length[20]');
            $this->form_validation->set_rules('category_id', lang('category'), 'required|max_length[20]');
            $this->form_validation->set_rules('rack_id', lang('rack'), 'max_length[20]');
            $this->form_validation->set_rules('description', lang('description'), 'max_length[200]');
            // Set Single Unit And Double Unit
            if($type == 'IMEI_Product' || $type == 'Serial_Product' || $type == 'Installment_Product' || $type == 'Combo_Product'){
                $unit_type = 1;
            }else{
                $unit_type = htmlspecialcharscustom($this->input->post('unit_type'));
            }
            // If Product Type Not Variaton
            if($type != 'Variation_Product' && $type != 'Combo_Product'){
                $this->form_validation->set_rules('sale_price', lang('sale_price'), 'required|numeric|max_length[50]');
                $opening_stock = htmlspecialcharscustom($this->input->post('opening_stock'));
                $purchase_price = htmlspecialcharscustom($this->input->post('purchase_price'));
                if($opening_stock && $purchase_price == '' && $type != 'Service_Product'){
                    $this->form_validation->set_rules('purchase_price', lang('purchase_price'), 'required|numeric|max_length[50]');
                }
            }
            // If Product Type Not Variaton
            if($type != 'Service_Product' && $type != 'Combo_Product'){
                if ($unit_type == 1){
                    $this->form_validation->set_rules('unit_id', lang('unit'), 'required');
                }elseif($unit_type == 2){
                    $this->form_validation->set_rules('purchase_unit_id', lang('purchase_unit'), 'required');
                    $this->form_validation->set_rules('sale_unit_id', lang('sale_unit'), 'required');
                    $this->form_validation->set_rules('conversion_rate', lang('conversion_rate'), 'required');
                }
            }
            // This commented field conn't delete, untill implement all type product
            // Tax Validation Except Installment Type Product
            if($type != 'Installment_Product'){
                $tax_information = array();
                $tax_string = '';
                //This field should not be escaped, because this is an array field
                if(!empty(($_POST['tax_field_percentage']))){
                    foreach($this->input->post('tax_field_percentage') as $key=>$value){
                        //all of fields should not be escaped, because this is an array field
                        $single_info = array(
                            'tax_field_id' => $this->input->post('tax_field_id')[$key],
                            'tax_field_company_id' => $this->input->post('tax_field_company_id')[$key],
                            'tax_field_name' => $this->input->post('tax_field_name')[$key],
                            'tax_field_percentage' => ($this->input->post('tax_field_percentage')[$key]=="") ? 0 : $this->input->post('tax_field_percentage')[$key]
                        );
                        $tax_string.=($this->input->post('tax_field_name')[$key]).":";
                        array_push($tax_information, $single_info);
                    }
                }
                $tax_information = json_encode($tax_information);
            }
            // Unique Product Code Generate
            if ($id == "") {
                $code = escapeQuot($this->input->post('code'));
                $status = checkItemUnique($code);
                if($status=="Yes"){
                    $this->session->set_flashdata('exception_error', lang('duplicate_code'));
                    redirect('Item/items');
                }
            }
            if ($this->form_validation->run() == TRUE) {
                // pre($_POST);
                $product_info = array();
                    $product_info['name'] = htmlspecialcharscustom($this->input->post('name'));
                    $product_info['alternative_name'] = htmlspecialcharscustom($this->input->post('alternative_name'));
                    if($encrypted_id == ''){
                        $product_info['expiry_date_maintain'] = escapeQuot(htmlspecialcharscustom($this->input->post('expiry_date_maintain')));
                    }
                    $product_info['generic_name'] = escapeQuot(htmlspecialcharscustom($this->input->post('generic_name')));
                    $product_info['type'] = escapeQuot(htmlspecialcharscustom($this->input->post('type')));
                    $product_info['category_id'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('category_id')));
                    $product_info['rack_id'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('rack_id')));
                    $product_info['code'] = htmlspecialcharscustom($this->input->post('code'));
                    $product_info['brand_id'] = htmlspecialcharscustom($this->input->post('brand_id'));
                    $product_info['alert_quantity'] = htmlspecialcharscustom($this->input->post('alert_quantity'));
                    if($type == 'IMEI_Product' || $type == 'Serial_Product' || $type == 'Installment_Product'){
                        $product_info['unit_type'] = 1;
                    }else{
                        $product_info['unit_type'] = htmlspecialcharscustom($this->input->post('unit_type'));
                    }
                    if($unit_type == 1){
                        $product_info['purchase_unit_id'] = htmlspecialcharscustom($this->input->post('unit_id'));
                        $product_info['sale_unit_id'] = htmlspecialcharscustom($this->input->post('unit_id'));
                        $product_info['conversion_rate'] = 1;
                        $conversion_rate = 1;
                    }elseif($unit_type == 2){
                        $product_info['purchase_unit_id'] = htmlspecialcharscustom($this->input->post('purchase_unit_id'));
                        $product_info['sale_unit_id'] = htmlspecialcharscustom($this->input->post('sale_unit_id'));
                        $product_info['conversion_rate'] = htmlspecialcharscustom($this->input->post('conversion_rate'));
                        $conversion_rate = htmlspecialcharscustom($this->input->post('conversion_rate'));
                    }
                    $product_info['loyalty_point'] = htmlspecialcharscustom($this->input->post('loyalty_point'));
                    $product_info['supplier_id'] = htmlspecialcharscustom($this->input->post('supplier_id'));
                    $product_info['purchase_price'] = htmlspecialcharscustom($this->input->post('purchase_price'));
                    $product_info['profit_margin'] = htmlspecialcharscustom($this->input->post('profit_margin'));
                    $product_info['whole_sale_price'] = htmlspecialcharscustom($this->input->post('whole_sale_price'));
                    $product_info['warranty'] = htmlspecialcharscustom($this->input->post('warranty'));
                    $product_info['warranty_date'] = htmlspecialcharscustom($this->input->post('warranty_date'));
                    $product_info['guarantee'] = htmlspecialcharscustom($this->input->post('guarantee'));
                    $product_info['guarantee_date'] = htmlspecialcharscustom($this->input->post('guarantee_date'));
                    $product_info['description'] = escapeQuot(htmlspecialcharscustom($this->input->post('description')));
                    if($type != 'Installment_Product'){
                        $product_info['tax_information'] = $tax_information;
                        $product_info['tax_string'] = $tax_string;
                    }
                    $product_info['sale_price'] = htmlspecialcharscustom($this->input->post('sale_price'));
                    $product_info['photo'] = htmlspecialcharscustom($this->input->post('image_url'));
                    $product_info['p_type'] = htmlspecialcharscustom($this->input->post('type'));
                    $product_info['user_id'] = $this->session->userdata('user_id');
                    $product_info['company_id'] = $this->session->userdata('company_id');
                    if ($id == "") {
                        $product_info['last_three_purchase_avg'] = htmlspecialcharscustom($this->input->post('purchase_price'));
                        $product_info['last_purchase_price'] = htmlspecialcharscustom($this->input->post('purchase_price'));
                        $product_info['added_date'] = date('Y-m-d H:i:s');
                        if(APPLICATION_L){
                            if(APPLICATION_LI){
                                $this->session->set_flashdata('exception_error', lang('insert_err_i'));
                                redirect('Item/items');
                            } else {
                                $id = $this->Common_model->insertInformation($product_info, "tbl_items");
                            }
                        } else {
                            $id = $this->Common_model->insertInformation($product_info, "tbl_items");
                        }
                        if($type != 'Variation_Product'){
                            if(isset($_POST['outlets']) && $_POST['outlets']){
                                $this->saveOpeningStock($_POST['outlets'], $_POST['quantity'], $type, $id, $product_info['conversion_rate']);
                            }
                        }
                        if($type == 'Combo_Product'){
                            if(isset($_POST['combo_item_qty']) && $_POST['combo_item_qty']){
                                $this->saveComboProducts($_POST['combo_item_qty'], $id);
                            }
                        }
                        // Product Code Generate
                        $generated_code = $this->Master_model->generateItemCode();
                        $product_code_start_from = $this->session->userdata('product_code_start_from');
                        if($product_code_start_from){
                            $data['autoCode'] = ((int)$product_code_start_from - 1) + (int)$generated_code;
                        }else{
                            $data['autoCode'] = $generated_code;
                        }
                        $this->session->set_flashdata('exception', lang('insertion_success'));
                    }else {
                        $this->Common_model->updateInformation($product_info, $id, "tbl_items");
                        setAveragePrice($id);
                        // Product Code Generate
                        $generated_code = $this->Master_model->generateItemCode();
                        $product_code_start_from = $this->session->userdata('product_code_start_from');
                        if($product_code_start_from){
                            $data['autoCode'] = ((int)$product_code_start_from - 1) + (int)$generated_code;
                        }else{
                            $data['autoCode'] = $generated_code;
                        }
                        if($type != 'Variation_Product'){
                            $this->Common_model->deletingMultipleFormData('item_id', $id, 'tbl_set_opening_stocks');
                            if(isset($_POST['outlets']) && $_POST['outlets']){
                                $this->saveOpeningStock($_POST['outlets'], $_POST['quantity'], $type, $id, $product_info['conversion_rate']);
                            }
                        }
                        if($type == 'Combo_Product'){
                            $this->Common_model->deletingMultipleFormData('combo_id', $id, 'tbl_combo_items');
                            if(isset($_POST['combo_item_qty']) && $_POST['combo_item_qty']){
                                $this->saveComboProducts($_POST['combo_item_qty'], $id);
                            }
                        }
                        $this->session->set_flashdata('exception', lang('update_success'));
                    }
                    if($type == 'Variation_Product'){
                        //update parent variation details
                        $variations = $this->input->post($this->security->xss_clean('variations'));
                        if($variations){
                            $main_arr = array();
                            foreach ($variations as $key=>$value){
                                $index_name = "child_row_attribute".$key;
                                $child_row_attribute = isset($_POST[$index_name]) && $_POST[$index_name] ?  $_POST[$index_name] : '';
                                $sub_arr = array();
                                $sub_arr['variation_name'] = getVariationName($value);
                                $sub_arr['attribute_id'] = $value;
                                $sub_arr['child_row_attribute'] = json_encode($child_row_attribute);
                                $main_arr[] = json_encode($sub_arr);
                            }
                            $par_array['variation_details'] = json_encode($main_arr);
                            $this->Common_model->updateInformation($par_array, $id, "tbl_items");
                        }
                        $this->Common_model->deleteCustomRow($id,"parent_id","tbl_items");
                        //This field should not be escaped, because this is an array field
                        $default_sale_price_variation = ($this->input->post($this->security->xss_clean('default_sale_price_variation')));
                        if($default_sale_price_variation){
                            foreach ($default_sale_price_variation as $key=>$value){
                                $da_arr = array();
                                $da_arr['parent_id'] = $id;
                                $da_arr['sale_price'] = $value;
                                $da_arr['type'] = '0';
                                //This field should not be escaped, because this is an array field
                                $da_arr['category_id'] = htmlspecialcharscustom($this->input->post('category_id'));
                                $da_arr['rack_id'] = htmlspecialcharscustom($this->input->post('rack_id'));
                                $da_arr['brand_id'] = htmlspecialcharscustom($this->input->post('brand_id'));
                                $da_arr['tax_information'] = $tax_information;
                                $da_arr['tax_string'] = $tax_string;
                                $da_arr['user_id'] = $this->session->userdata('user_id');
                                $da_arr['company_id'] = $this->session->userdata('company_id');
                                //all of variables should not be escaped, because this is an array field
                                $da_arr['name'] = ($_POST['variation_name'][$key]);
                                $da_arr['unit_type'] = htmlspecialcharscustom($this->input->post('unit_type'));
                                $da_arr['purchase_price'] = ($_POST['default_purchase_price_variation'][$key]);
                                $da_arr['last_three_purchase_avg'] = ($_POST['default_purchase_price_variation'][$key]);
                                $da_arr['last_purchase_price'] = ($_POST['default_purchase_price_variation'][$key]);
                                $da_arr['whole_sale_price'] = ($_POST['default_whole_sale_price_variation'][$key]);
                                $da_arr['warranty'] = htmlspecialcharscustom($this->input->post('warranty'));
                                $da_arr['warranty_date'] = htmlspecialcharscustom($this->input->post('warranty_date'));
                                $da_arr['guarantee'] = htmlspecialcharscustom($this->input->post('guarantee'));
                                $da_arr['guarantee_date'] = htmlspecialcharscustom($this->input->post('guarantee_date'));
                                $da_arr['code'] = ($_POST['code_variation'][$key]);
                                $da_arr['alert_quantity'] = ($_POST['alert_quantity_variation'][$key]);
                                $da_arr['unit_type'] = htmlspecialcharscustom($this->input->post('unit_type'));
                                if($unit_type == 1){
                                    $da_arr['purchase_unit_id'] = htmlspecialcharscustom($this->input->post('unit_id'));
                                    $da_arr['sale_unit_id'] = htmlspecialcharscustom($this->input->post('unit_id'));
                                    $da_arr['conversion_rate'] = 1;
                                }elseif($unit_type == 2){
                                    $da_arr['purchase_unit_id'] = htmlspecialcharscustom($this->input->post('purchase_unit_id'));
                                    $da_arr['sale_unit_id'] = htmlspecialcharscustom($this->input->post('sale_unit_id'));
                                    $da_arr['conversion_rate'] = $product_info['conversion_rate'];
                                }
                                $da_arr['supplier_id'] = $product_info['supplier_id'];
                                //This fields should not be escaped, because this is an array field
                                $da_arr['photo'] = isset($_POST['variation_product_images'][$key]) && ($_POST['variation_product_images'][$key])?($_POST['variation_product_images'][$key]):"";
                                // This fields should not be escaped, because this is an array field
                                if(isset($_POST['old_variation_id'][$key]) && ($_POST['old_variation_id'][$key])){
                                    $da_arr['del_status'] = "Live";
                                    //This field should not be escaped, because this is an array field
                                    $this->Common_model->updateInformation($da_arr, ($_POST['old_variation_id'][$key]), "tbl_items");
                                    $this->Common_model->deletingMultipleFormData('item_id', $_POST['old_variation_id'][$key], 'tbl_set_opening_stocks');
                                    foreach($_POST["outlets$key"] as $row_2 => $outlet){
                                        $stock_qty_check = (int)$_POST["quantity".$key][$row_2] * (int)$conversion_rate;
                                        if($stock_qty_check > 0){
                                            $fmi = array();
                                            $fmi['item_id'] = $_POST['old_variation_id'][$key];
                                            $fmi['item_type'] = $type;
                                            $fmi['stock_quantity'] = $stock_qty_check;
                                            $fmi['outlet_id'] = $outlet;
                                            $fmi['user_id'] = $this->session->userdata('user_id');
                                            $fmi['company_id'] = $this->session->userdata('company_id');
                                            $this->Common_model->insertInformation($fmi, 'tbl_set_opening_stocks');
                                        }
                                    }
                                }else{
                                    $da_arr['added_date'] = date('Y-m-d H:i:s');
                                    $inser_id = $this->Common_model->insertInformation($da_arr, "tbl_items");
                                    if(isset($_POST["opening_stock_variation"]) && $_POST["opening_stock_variation"]){
                                        foreach($_POST["outlets$key"] as $row_2 => $outlet){
                                            $stock_qty_check = (int)$_POST["quantity".$key][$row_2] * (int)$conversion_rate;
                                            if($stock_qty_check > 0){
                                                $fmi = array();
                                                $fmi['item_id'] = $inser_id;
                                                $fmi['item_type'] = $type;
                                                $fmi['stock_quantity'] = $stock_qty_check;
                                                $fmi['outlet_id'] = $outlet;
                                                $fmi['user_id'] = $this->session->userdata('user_id');
                                                $fmi['company_id'] = $this->session->userdata('company_id');
                                                $this->Common_model->insertInformation($fmi, 'tbl_set_opening_stocks');
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    if($add_more == 'add_more'){
                        redirect('Item/addEditItem');
                    }else{
                        redirect('Item/items');
                    }
            } else {
                if ($id == "") {
                    $data = array();
                    $data['units'] = $this->Common_model->getAllByCompanyId($company_id, 'tbl_units');
                    $data['categories'] = $this->Common_model->getAllByCompanyId($company_id, 'tbl_item_categories');
                    // Product Code Generate
                    $generated_code = $this->Master_model->generateItemCode();
                    $product_code_start_from = $this->session->userdata('product_code_start_from');
                    if($product_code_start_from){
                        $data['autoCode'] = ((int)$product_code_start_from - 1) + (int)$generated_code;
                    }else{
                        $data['autoCode'] = $generated_code;
                    }
                    $data['items'] = $this->Common_model->getAllItemsWithoutCombo($company_id);
                    $data['Variations'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_variations");
                    $data['brands'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_brands");
                    $data['racks'] = $this->Common_model->getAllByCompanyIdForDropdownProduct($company_id, 'tbl_racks');
                    $data['outlets'] = $this->Common_model->getAllOutletByCompany();
                    $data['suppliers'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_suppliers');
                    $data['main_content'] = $this->load->view('master/item/addItem', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['items'] = $this->Common_model->getAllItemsWithoutCombo($company_id);
                    $data['combo_items'] = $this->Common_model->getComboChildItemByComboId($id);
                    $data['units'] = $this->Common_model->getAllByCompanyId($company_id, 'tbl_units');
                    $data['categories'] = $this->Common_model->getAllByCompanyId($company_id, 'tbl_item_categories');
                    $data['suppliers'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_suppliers');
                    $data['brands'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_brands");
                    $data['racks'] = $this->Common_model->getAllByCompanyIdForDropdownProduct($company_id, 'tbl_racks');
                    $data['Variations'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_variations");
                    $data['outlets'] = $this->Common_model->getAllOutletByCompany();
                    // Product Code Generate
                    $generated_code = $this->Master_model->generateItemCode();
                    $product_code_start_from = $this->session->userdata('product_code_start_from');
                    if($product_code_start_from){
                        $data['autoCode'] = ((int)$product_code_start_from - 1) + (int)$generated_code;
                    }else{
                        $data['autoCode'] = $generated_code;
                    }
                    $data['item_details'] = $this->Common_model->getItemDetailsWithOpeningStockByItemId($id);
                    $data['item_type_info'] = $this->Common_model->getItemDetailsDataById($id, "item_id", "tbl_set_opening_stocks");
                    $data['stockDetails'] = getOpeningStockDetails($id);
                    $data['main_content'] = $this->load->view('master/item/editItem', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
            
        } else {
            if ($id == "") {
                $data = array();
                $data['units'] = $this->Common_model->getAllByCompanyId($company_id, 'tbl_units');
                $data['categories'] = $this->Common_model->getAllByCompanyId($company_id, 'tbl_item_categories');
                // Product Code Generate
                $generated_code = $this->Master_model->generateItemCode();
                $product_code_start_from = $this->session->userdata('product_code_start_from');
                if($product_code_start_from){
                    $data['autoCode'] = ((int)$product_code_start_from - 1) + (int)$generated_code;
                }else{
                    $data['autoCode'] = $generated_code;
                }
                $data['items'] = $this->Common_model->getAllItemsWithoutCombo($company_id);
                $data['Variations'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_variations");
                $data['brands'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_brands");
                $data['racks'] = $this->Common_model->getAllByCompanyIdForDropdownProduct($company_id, 'tbl_racks');
                $data['outlets'] = $this->Common_model->getAllOutletByCompany();
                $data['suppliers'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_suppliers');
                $data['main_content'] = $this->load->view('master/item/addItem', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['items'] = $this->Common_model->getAllItemsWithoutCombo($company_id);
                $data['combo_items'] = $this->Common_model->getComboChildItemByComboId($id);
                $data['units'] = $this->Common_model->getAllByCompanyId($company_id, 'tbl_units');
                $data['categories'] = $this->Common_model->getAllByCompanyId($company_id, 'tbl_item_categories');
                $data['suppliers'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_suppliers');
                $data['brands'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_brands");
                $data['racks'] = $this->Common_model->getAllByCompanyIdForDropdownProduct($company_id, 'tbl_racks');
                $data['Variations'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_variations");
                $data['outlets'] = $this->Common_model->getAllOutletByCompany();
                // Product Code Generate
                $generated_code = $this->Master_model->generateItemCode();
                $product_code_start_from = $this->session->userdata('product_code_start_from');
                if($product_code_start_from){
                    $data['autoCode'] = ((int)$product_code_start_from - 1) + (int)$generated_code;
                }else{
                    $data['autoCode'] = $generated_code;
                }
                $data['item_details'] = $this->Common_model->getItemDetailsWithOpeningStockByItemId($id);
                $data['item_type_info'] = $this->Common_model->getItemDetailsDataById($id, "item_id", "tbl_set_opening_stocks");
                $data['stockDetails'] = getOpeningStockDetails($id);
                $data['variation_products'] = $this->Common_model->getAllByCustomId($id,"parent_id","tbl_items",$order='');
                $data['main_content'] = $this->load->view('master/item/editItem', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }


    /**
     * bulkItemUpdate
     * @access public
     * @param no
     * @return void
     */
    public function bulkItemUpdate(){
        $data = array();
        $data['main_content'] = $this->load->view('master/item/bulk_item_update', $data, TRUE);
        $this->load->view('userHome', $data);
    }
    /**
     * bulkPriceUPdate
     * @access public
     * @param no
     * @return void
     */
    public function bulkPriceUPdate(){
        $item_id = htmlspecialcharscustom($this->input->post('item_id'));
        $id = $this->custom->encrypt_decrypt($item_id, 'decrypt');
        $data = array();
        $data['sale_price'] = htmlspecialcharscustom($this->input->post('sale_price'));
        $data['whole_sale_price'] = htmlspecialcharscustom($this->input->post('whole_sale_price'));
        $this->Common_model->updateInformation($data, $id, 'tbl_items');
        $response = [
            'status' => 'success',
            'message' => 'Data Successfully updated',
        ];	
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }


    /**
     * validate_photo
     * @access public
     * @param no
     * @return void
     */
    public function validate_photo() {
        if ($_FILES['photo']['name'] != "") {
            $config['upload_path'] = './uploads/site_settings';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = '2048';
            $config['maintain_ratio'] = TRUE;
            $config['encrypt_name'] = TRUE;
            $config['detect_mime'] = TRUE;
            $this->load->library('upload', $config);
            if(createDirectory('uploads/site_settings')){
                // Delete the old file if it exists
                $old_file = $this->session->userdata('photo');
                if ($old_file && file_exists($config['upload_path'] . '/' . $old_file)) {
                    unlink($config['upload_path'] . '/' . $old_file);
                }
                if ($this->upload->do_upload("photo")) {
                    $upload_info = $this->upload->data();
                    $photo = $upload_info['file_name'];
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = './uploads/site_settings/'.$photo;
                    $config['maintain_ratio'] = FALSE;
                    $config['width'] = 142;
                    $config['height'] = 80;
                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();
                    $this->session->set_userdata('photo', $upload_info['file_name']);
                } else {
                    $this->form_validation->set_message('validate_photo', $this->upload->display_errors());
                    return FALSE;
                }
            } else {
                echo "Something went wrong";
            }
        }
    }

    /**
     * saveItemDetails
     * @access public
     * @param string
     * @param string
     * @param int
     * @param string
     * @return void
     */
    public function saveItemDetails($expiry_imei_serial, $type, $id, $table_name) {
        foreach ($expiry_imei_serial as $row => $item_id):
            $fmi = array();
            $fmi['item_id'] = $id;
            $fmi['item_type'] = $type;
            if (isset($_POST['expiry_imei_serial'])){
                $fmi['expiry_imei_serial'] = $_POST['expiry_imei_serial'][$row];
            }
            $fmi['user_id'] = $this->session->userdata('user_id');
            $fmi['company_id'] = $this->session->userdata('company_id');
            $this->Common_model->insertInformation($fmi, $table_name);
        endforeach;
    }


    /**
     * saveComboProducts
     * @access public
     * @param string
     * @param int
     * @param int
     * @param int
     * @return void
     */
    public function saveComboProducts($combo_item_qty, $id) {
        foreach ($combo_item_qty as $row => $qty):
            $fmi = array();
            $fmi['combo_id'] = $id;
            if($_POST['item_show_in_invoice']){
                $fmi['show_invoice'] = $_POST['item_show_in_invoice'][$row] == 'on' ? 'Yes' : 'No';
            }else{
                $fmi['show_invoice'] = 'No';
            }
            $fmi['item_id'] = $_POST['combo_item_id'][$row];
            $fmi['quantity'] = $_POST['combo_item_qty'][$row];
            $fmi['unit_price'] = $_POST['combo_item_unitprice'][$row];
            $fmi['company_id'] = $this->session->userdata('company_id');
            $this->Common_model->insertInformation($fmi, 'tbl_combo_items');
        endforeach;
    }
    /**
     * saveOpeningStock
     * @access public
     * @param string
     * @param int
     * @param int
     * @param int
     * @return void
     */
    public function saveOpeningStock($outlets, $quantity, $type, $id, $conversion_rate) {
        foreach ($outlets as $row => $outlet):
            $fmi = array();
            $fmi['item_id'] = $id;
            $fmi['item_type'] = $type;
            $fmi['item_description'] = $_POST['item_description'][$row];
            $fmi['stock_quantity'] = (int)$_POST['quantity'][$row] *  (int)$conversion_rate;
            $fmi['outlet_id'] = $outlet;
            $fmi['user_id'] = $this->session->userdata('user_id');
            $fmi['company_id'] = $this->session->userdata('company_id');
            if($_POST['quantity'][$row] != ''){
                $this->Common_model->insertInformation($fmi, 'tbl_set_opening_stocks');
            }
        endforeach;
    }

    /**
     * saveOpeningStockVariation
     * @access public
     * @param string
     * @param string
     * @param int
     * @param int
     * @return void
     */
    public function saveOpeningStockVariation($variations, $type, $id, $conversion_rate) {
        foreach ($variations as $row => $variation){
            foreach($_POST['outlets'][$row] as $row_2 => $outlet){
                $fmi = array();
                $fmi['item_id'] = $id;
                $fmi['item_type'] = $type;
                $fmi['stock_quantity'] = (int)$_POST["quantity".$row][$row_2] *  (int)$conversion_rate;
                $fmi['outlet_id'] = $outlet;
                $fmi['user_id'] = $this->session->userdata('user_id');
                $fmi['company_id'] = $this->session->userdata('company_id');
                $this->Common_model->insertInformation($fmi, 'tbl_set_opening_stocks');
            }
        }
    }

    /**
     * kepOldVariation
     * @access public
     * @param no
     * @return json
     */
    public function kepOldVariation() {
        $data_item = htmlspecialcharscustom($this->input->post('data_item'));
        $stock = $this->Common_model->kepOldVariation($data_item);
        if($stock){
            $response = [
                'status' => 200,
                'data'=> $stock,
            ];
        }else{
            $response = [
                'status' => 404,
                'data'=> '',
            ];
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    /**
     * itemDetails
     * @access public
     * @param int
     * @return void
     */
    public function itemDetails($id) {
        $encrypted_id = $id;
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $data = array();
        $data['variations'] = getRelatedVariation($id);
        $data['encrypted_id'] = $encrypted_id;
        $data['item_details'] = $this->Common_model->getDataById($id, "tbl_items");
        $data['item_opening_stock'] = $this->Common_model->getItemOpeningStock($id);
        $data['main_content'] = $this->load->view('master/item/itemDetails', $data, TRUE);
        $this->load->view('userHome', $data);
    }



    /**
     * deleteItem
     * @access public
     * @param int
     * @return void
     */
    public function deleteItem($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $this->Common_model->deleteStatusChange($id, "tbl_items");
        $this->Common_model->childItemDeleteStatusChange($id, "tbl_items");
        $this->Common_model->comboItemDeleteStatusChange($id);
        $this->Common_model->openingStockItemDeleteStatusChange($id);
        $this->session->set_flashdata('exception', lang('delete_success'));
        redirect('Item/items');
    }

    /**
     * changeStatus
     * @access public
     * @param int
     * @return void
     */
    public function changeStatus() {
        $get_id = $this->input->post('get_id');
        $status = $this->input->post('status');
        $id = $this->custom->encrypt_decrypt($get_id, 'decrypt');
        $this->Common_model->enableDisableStatusChange($id, $status);
        $this->Common_model->childItemEnableDisableStatusChange($id, $status);
        $response = [
            'status' => 'success',
        ];	
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    /**
     * bulkDelete
     * @access public
     * @param int
     * @return void
     */
    public function bulkDelete(){
        foreach($_POST['bulk_item'] as $item){
            $this->Common_model->bulkItemDeleteWithVariationAndOpeningStock($item);
        }
        $this->session->set_flashdata('exception', lang('delete_success'));
        redirect('Item/items');
    }


    /**
     * items
     * @access public
     * @param no
     * @return void
     */
    public function items() {
        //after redirect from dummy data build.zip file will removed. added by Zakir
        if(file_exists('build.zip')){
            unlink('build.zip');
        }
        $company_id = $this->session->userdata('company_id');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('category_id', lang('category'), 'max_length[50]');
            if ($this->form_validation->run() == TRUE) {
                $data = array();
                $data['suppliers'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_suppliers");
                $data['itemCategories'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_item_categories");
                $data['main_content'] = $this->load->view('master/item/items', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['suppliers'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_suppliers");
                $data['itemCategories'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_item_categories");
                $data['main_content'] = $this->load->view('master/item/items', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        } else {
            $data = array();
            $data['suppliers'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_suppliers");
            $data['itemCategories'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_item_categories");
            $data['main_content'] = $this->load->view('master/item/items', $data, TRUE);
            $this->load->view('userHome', $data);
        }
    }


    /**
     * getAjaxData
     * @access public
     * @param no
     * @return json
     */
    public function getAjaxData() {
        $company_id = $this->session->userdata('company_id');
        $category_id = htmlspecialcharscustom($this->input->post('category_id'));
        $supplier_id = htmlspecialcharscustom($this->input->post('supplier_id'));
        $products = $this->Master_model->make_datatables($company_id,$category_id,$supplier_id);
        $data = array();
        if ($products && !empty($products)) {
            $i = count($products);
        }
        $row_count = 0;
        foreach ($products as $value){
            if($value->del_status=="Live"):
                $variations = $this->Common_model->getVariationItem($value->id);
                $row_count++;
                $html = '';
                /*check access*/
                if(checkAccess(49,"print_barcode")):
                $html .= ' <a class="btn btn-deep-purple print_barcode" href="javascript:void(0)" data-bs-toggle="tooltip" data-item-type="'.escape_output($value->type).'" data-item="'. escape_output($value->id) . '" data-bs-placement="top" data-bs-original-title="'. lang('print_barcode') .'">
                <i class="fas fa-print"></i>
                </a>';
                endif;
                /*check access*/
                if(checkAccess(49,"print_label")):
                $html .= ' <a class="btn btn-unique print_label" href="javascript:void(0)" data-bs-toggle="tooltip" data-item-type="'.escape_output($value->type).'" data-item="'. escape_output($value->id) . '" data-bs-placement="top" data-bs-original-title="'. lang('print_label') .'">
                <i class="fas fa-print"></i>
                </a>';
                endif;
                /*check access*/
                if(checkAccess(49,"view")):
                    $html .= ' <a class="btn btn-cyan" href="'.base_url().'Item/itemDetails/'.($this->custom->encrypt_decrypt($value->id, 'encrypt')).'" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="'. lang('view_details') .'">
                    <i class="far fa-eye"></i>
                    </a>';
                endif;
                /*check access*/
                if(checkAccess(49,"edit")):
                    $html .= ' <a class="btn btn-warning" href="'.base_url().'Item/addEditItem/'.($this->custom->encrypt_decrypt($value->id, 'encrypt')).'" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="'. lang('edit') .'">
                    <i class="far fa-edit"></i>';
                endif;
                /*check access*/
                if(checkAccess(49,"delete")):
                    $html .= ' <a class="delete btn btn-danger" href="'.base_url().'Item/deleteItem/'.($this->custom->encrypt_decrypt($value->id, 'encrypt')).'" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="'. lang('delete') .'">
                    <i class="fa-regular fa-trash-can"></i>';
                endif;
            $sub_array =  array();
            $sub_array[] = '
                <td>
                    <label class="container">' . lang('select') . '
                        <input type="checkbox" class="checkbox_item" value="'.$value->id.'" name="bulk_item[]">
                        <span class="checkmark"></span>
                    </label>
                </td>';
            $sub_array[] = $i--;
            if(isset($variations) && $variations){
                $var_htl = '<tr><th>'.lang('name').'('.lang('code').')</th><th>'.lang('sale_price').'</th><th>'.lang('purchase_price').'</th></tr>';
                foreach ($variations as $variation){
                $var_htl.="<tr><td>".escape_output($variation->name) . "(" . $variation->code . ")</td><td>". getAmtCustom($variation->sale_price)."</td><td>". (isset($variation->purchase_price) && $variation->purchase_price ? getAmtCustom($variation->purchase_price):'0.00'). "</td></tr>";
                }
                $sub_array[] = '<span class="get_variation_name">' . $value->name. '</span>' . '<br><button id="view_variation" type="button" class="new-btn"><i class="far fa-eye"></i>'."<table class='table d-none' id='variation_html'>".$var_htl."</table>";
            
            }else{
                $sub_array[] = $value->name . " " . "(" . $value->code . ")";
            }
            $sub_array[] = escape_output(checkSingleItemType($value->type));
            $sub_array[] = escape_output($value->category_name);
            $sub_array[] = (isset($value->purchase_price) && $value->purchase_price ? getAmtCustom($value->purchase_price):getAmtCustom(0));
            $sub_array[] = getAmtCustom($value->sale_price);
            $sub_array[] = escape_output($value->full_name);
            $sub_array[] = date($this->session->userdata('date_format'), strtotime($value->added_date != '' ? $value->added_date : ''));
            $sub_array[] = '
            <div class="btn_group_wrap">
                '. $html .'
            </div>';
            $data[] = $sub_array;
            endif;
        }
        $output = array(
            "recordsTotal" => $this->Master_model->get_all_data($company_id,$category_id,$supplier_id),
            "recordsFiltered" => $this->Master_model->get_filtered_data($company_id,$category_id,$supplier_id),
            "data" => $data
        );
        echo json_encode($output);
    }
    /**
     * getBulkAjaxData
     * @access public
     * @param no
     * @return json
     */
    public function getBulkAjaxData() {
        $company_id = $this->session->userdata('company_id');
        $products = $this->Master_model->make_bulkdatatables($company_id);
        $data = array();
        if ($products && !empty($products)) {
            $row_count = count($products); // Set row count based on total products
        } else {
            $row_count = 0;
        }
        foreach ($products as $value) {
            $sale_html = '';
            $whole_sale_html = '';
            $action_html = '';
            $status_html = '';
            $image_html = '';
            $sub_array = [];
            $sale_html .= '<div class="form-group">
                <input  autocomplete="off" type="text" onfocus="this.select();" name="sale_price[]" class="form-control integerchk sale_price" placeholder="'.lang('sale_price').'" value="'.($value->sale_price).'">  
            </div>';
            $whole_sale_html .= '<div class="form-group">
                <input ' . ($value->type == 'Service_Product' ? 'readonly' : '') .'  autocomplete="off" type="text" onfocus="this.select();" name="whole_sale_price[]" class="form-control integerchk whole_sale_price" placeholder="'.lang('whole_sale_price').'" value="'.($value->whole_sale_price).'">  
            </div>';
            $action_html .= '<button data_id="'.$this->custom->encrypt_decrypt($value->id, 'encrypt').'" class="btn bg-blue-btn single_item_btn" type="button">'.lang('update').'</button>';
            $status_html .= '<div data_id="'. $this->custom->encrypt_decrypt($value->id, 'encrypt'). '">
                <div class="form-group">
                    <select name="status_trigger" id="status_trigger" class="form-control select2">
                        <option '.($value->enable_disable_status == 'Enable' ? 'selected' : '').' value="Enable">'.lang('enable').'</option>
                        <option '.($value->enable_disable_status == 'Disable' ? 'selected' : '').' value="Disable">'.lang('disable').'</option>
                    </select>
                </div>
            </div>';
            $file_path = FCPATH . 'uploads/items/' . $value->photo;
            $img_src = file_exists($file_path) && $value->photo 
                ? base_url() . 'uploads/items/' . $value->photo 
                : base_url() . 'uploads/site_settings/image_thumb.png';
            $image_html = '<div class="d-flex align-items-center">
                <div class="bulk_img_up">
                    <img class="image_setter_' . $value->id . '" src="' . $img_src . '" alt="item-image" width="85" height="85">
                </div>
                <a data_old_photo="' . $value->photo . '" href="javascript:void(0)" data_id="' . $this->custom->encrypt_decrypt($value->id, 'encrypt') . '" class="bulk_img_up ms-3 tippyBtnCall cursor-pointer add_image_for_crop" data-tippy-content="' . lang('image_update') . '">
                    <i class="fa-regular fa-image"></i>
                </a>
            </div>';
            // Here $row_count decrements for each row
            $sub_array[] = $row_count--;
            $sub_array[] = escape_output($value->name . '('. $value->code . ')');
            $sub_array[] = $sale_html;
            $sub_array[] = $whole_sale_html;
            $sub_array[] = $action_html;
            $sub_array[] = $status_html;
            $sub_array[] = $image_html;
            $data[] = $sub_array;
        }
        $output = array(
            "recordsTotal" => $this->Master_model->get_all_data($company_id),
            "recordsFiltered" => $this->Master_model->get_filtered_data($company_id),
            "data" => $data
        );
        echo json_encode($output);
    }

    /**
     * Balance_Statement
     * @access public
     * @param no
     * @return void
     */
    public function uploadItem() {
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            if ($_FILES['userfile']['name'] != "") {
                if ($_FILES['userfile']['name'] == "Item_Upload.xlsx") {
                    //Path of files were you want to upload on localhost (C:/xampp/htdocs/ProjectName/uploads/excel/
                    $configUpload['upload_path'] = FCPATH . 'assets/upload-sample/excel/';
                    $configUpload['allowed_types'] = 'xls|xlsx';
                    $configUpload['max_size'] = '5000';
                    $this->load->library('upload', $configUpload);
                    if ($this->upload->do_upload('userfile')) {
                        $upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
                        $file_name = $upload_data['file_name']; //uploded file name
                        $extension = $upload_data['file_ext'];    // uploded file 
                        //$objReader =PHPExcel_IOFactory::createReader('Excel5');     //For excel 2003
                        $objReader = PHPExcel_IOFactory::createReader('Excel2007'); // For excel 2007
                        //Set to read only
                        $objReader->setReadDataOnly(true);
                        //Load excel file
                        $objPHPExcel = $objReader->load(FCPATH . 'assets/upload-sample/excel/' . $file_name);
                        $totalrows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();   //Count Numbe of rows avalable in excel
                        $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
                        // Get Company Vat
                        $company_vat = get_company_vat();
                        if ($totalrows >= 4 && $totalrows < 54) {
                            $arrayerror = '';
                            for ($i = 4; $i <= $totalrows; $i++) {
                                $type = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(0, $i)->getValue() ?? '')); //Excel Column 0//Required
                                $name = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(1, $i)->getValue() ?? '')); //Excel Column 1//Required
                                $sale_price = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(2, $i)->getValue() ?? '')); //Excel Column 2//Required
                                $whole_sale_price = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(3, $i)->getValue() ?? '')); //Excel Column 3
                                $purchase_price = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(4, $i)->getValue() ?? '')); //Excel Column 4
                                $category_id = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(5, $i)->getValue() ?? '')); //Excel Column 5
                                $code = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(6, $i)->getValue() ?? '')); //Excel Column 6
                                $supplier_id = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(7, $i)->getValue() ?? '')); //Excel Column 7
                                $unit_type = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(8, $i)->getValue() ?? '')); //Excel Column 8//Required
                                $purchase_unit_id = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(9, $i)->getValue() ?? '')); //Excel Column 9//Required if Unit type = Double_Unit
                                $sale_unit_id = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(10, $i)->getValue() ?? '')); //Excel Column 10//Required if Unit type = Single_Unit
                                $conversion_rate = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(11, $i)->getValue() ?? '')); //Excel Column 11//Required if Unit type = Double_Unit
                                $warranty = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(12, $i)->getValue() ?? '')); //Excel Column 12
                                $warranty_type = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(13, $i)->getValue() ?? '')); //Excel Column 13
                                $guarantee = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(14, $i)->getValue() ?? '')); //Excel Column 14
                                $guarantee_type = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(15, $i)->getValue() ?? '')); //Excel Column 15
                                $brand_id = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(16, $i)->getValue() ?? '')); //Excel Column 16
                                $outlets = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(17, $i)->getValue() ?? '')); //Excel Column 17
                                $outlet_stock_value = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(18, $i)->getValue() ?? '')); //Excel Column 18
                                $alert_quantity = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(19, $i)->getValue() ?? '')); //Excel Column 21
                                $description = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(20, $i)->getValue() ?? '')); //Excel Column 20
                                $image = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(21, $i)->getValue() ?? '')); //Excel Column 21
                                $vat_name = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(22, $i)->getValue() ?? '')); //Excel Column 22
                                $vat_percent = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(23, $i)->getValue() ?? '')); //Excel Column 23  

                                if ($type == '') {
                                    if ($arrayerror == '') {
                                        $arrayerror.= lang('Row_Number') . ' ' . "$i" . ' ' . lang('column_A_required');
                                    } else {
                                        $arrayerror.= "<br>" . lang('Row_Number') . ' ' . "$i" . ' ' . lang('column_A_required');
                                    }
                                }
                                if ($name == '') {
                                    if ($arrayerror == '') {
                                        $arrayerror.= lang('Row_Number') . ' ' . "$i" . ' ' . lang('column_B_required');
                                    } else {
                                        $arrayerror.= "<br>" . lang('Row_Number') . ' ' . "$i" . ' ' . lang('column_B_required');
                                    }
                                }

                                if ($sale_price == '' ||  !is_numeric($sale_price)) {
                                    if ($arrayerror == '') {
                                        $arrayerror.= lang('Row_Number') . ' ' . "$i" . ' ' . lang('column_C_required_or_can_not_be_text');
                                    } else {
                                        $arrayerror.= "<br>" . lang('Row_Number') . ' ' . "$i" . ' ' . lang('column_C_required_or_can_not_be_text');
                                    }
                                }
                                $tmp_outlet_name = explode(',',$outlets);
                                $tmp_outlet_stock_value = explode(',',$outlet_stock_value);
                                $sum_of_stock = 0;
                                for($x = 0; $x < count($tmp_outlet_stock_value); $x++){
                                    $sum_of_stock += (int)$tmp_outlet_stock_value[$x] ;
                                }
                                if ($outlets || $outlet_stock_value) {
                                    if(sizeof($tmp_outlet_name) != sizeof($tmp_outlet_stock_value)){                                        
                                        if ($arrayerror == '') {
                                            $arrayerror.= lang('Row_Number') . ' ' . "$i" . ' ' . lang('R_and_S_does_not_match');
                                        } else {
                                            $arrayerror.= "<br>" . lang('Row_Number') . ' ' . "$i" . ' ' . lang('R_and_S_does_not_match');
                                        }
                                    }
                                    
                                }
                                $status = checkItemUnique($code);
                                if($status=="Yes"){
                                    if ($arrayerror == '') {
                                        $arrayerror.= lang('Row_Number') . ' ' . "$i" . ' ' . lang('column_J_item_code_already_exist');
                                    } else {
                                        $arrayerror.= "<br>" . lang('Row_Number') . ' ' . "$i" . ' ' . lang('column_J_item_code_already_exist');
                                    }
                                }
                                if ($unit_type == '') {
                                    if ($arrayerror == '') {
                                        $arrayerror.= lang('Row_Number') . ' ' . "$i" . ' ' . lang('column_I_required');
                                    } else {
                                        $arrayerror.= "<br>" . lang('Row_Number') . ' ' . "$i" . ' ' . lang('column_I_required');
                                    }
                                }
                                // For Single Unit Validation
                                if ($unit_type == 'Single_Unit') {
                                    if ($sale_unit_id == '') {
                                        if ($arrayerror == '') {
                                            $arrayerror.= lang('Row_Number') . ' ' . "$i" . ' ' . lang('column_K_required');
                                        } else {
                                            $arrayerror.= "<br>" . lang('Row_Number') . ' ' . "$i" . ' ' . lang('column_K_required');
                                        }
                                    }
                                // For Double Unit Validaton
                                }else if($unit_type == 'Double_Unit'){
                                    if ($purchase_unit_id == '') {
                                        if ($arrayerror == '') {
                                            $arrayerror.= lang('Row_Number') . ' ' . "$i" . ' ' . lang('column_J_required');
                                        } else {
                                            $arrayerror.= "<br>" . lang('Row_Number') . ' ' . "$i" . ' ' . lang('column_J_required');
                                        }
                                    }
                                    if ($sale_unit_id == '') {
                                        if ($arrayerror == '') {
                                            $arrayerror.= lang('Row_Number') . ' ' . "$i" . ' ' . lang('column_K_required');
                                        } else {
                                            $arrayerror.= "<br>" . lang('Row_Number') . ' ' . "$i" . ' ' . lang('column_K_required');
                                        }
                                    }
                                    if ($conversion_rate == ''  ||  !is_numeric($conversion_rate)) {
                                        if ($arrayerror == '') {
                                            $arrayerror.= lang('Row_Number') . ' ' . "$i" . ' ' . lang('column_L_required_or_can_not_be_text');
                                        } else {
                                            $arrayerror.= "<br>" . lang('Row_Number') . ' ' . "$i" . ' ' . lang('column_L_required_or_can_not_be_text');
                                        }
                                    }
                                }else{
                                    if ($arrayerror == '') {
                                        $arrayerror.= lang('Something_went_wrong_about_single_unit_or_double_unit');
                                    } 
                                }
                                if ($alert_quantity != '' && !is_numeric($alert_quantity)) {
                                    if ($arrayerror == '') {
                                        $arrayerror.= lang('Row_Number') . ' ' . "$i" . ' ' . lang('column_T_required_or_can_not_be_text');
                                    } else {
                                        $arrayerror.= "<br>" . lang('Row_Number') . ' ' . "$i" . ' ' . lang('column_T_required_or_can_not_be_text');
                                    }
                                }
                                if($vat_name != 'None'){
                                    $val_organize = str_replace(",",":",$vat_name);
                                    $vat_match = strcmp($val_organize . ':', $company_vat);
                                    if($vat_match != 0){
                                        if ($arrayerror == '') {
                                            $arrayerror.= lang('Row_Number') . ' ' . "$i" . ' ' . lang('column_W_doesnt_math_with_the_system');
                                        } else {
                                            $arrayerror.= "<br>" . lang('Row_Number') . ' ' . "$i" . ' ' . lang('column_W_doesnt_math_with_the_system');
                                        }
                                    }
                                    $tmp_vat_name = explode(',',$vat_name);
                                    $tmp_vat_percent = explode(',',$vat_percent);
                                    if ($vat_name || $tmp_vat_percent) {
                                        if(sizeof($tmp_vat_name) != sizeof($tmp_vat_percent)){
                                            if ($arrayerror == '') {
                                                $arrayerror.= lang('Row_Number') . ' ' . "$i" . ' ' . lang('W_and_Y_does_not_match');
                                            } else {
                                                $arrayerror.= "<br>" . lang('Row_Number') . ' ' . "$i" . ' ' . lang('W_and_Y_does_not_match');
                                            }
                                        } 
                                    }
                                }
                                
                            }
                            if ($arrayerror == '') {
                                if(!is_null($this->input->post('remove_previous'))){
                                    $this->db->query("TRUNCATE table `tbl_items`");
                                }
                                $company = getCompanyInfo();
                                $outlet_taxes = json_decode($company->tax_setting);
                                $company_id = $this->session->userdata('company_id');
                                for ($i = 4; $i <= $totalrows; $i++) {
                                    $type = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(0, $i)->getValue() ?? '')); //Excel Column 0//Required
                                    $name = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(1, $i)->getValue() ?? '')); //Excel Column 1//Required
                                    $sale_price = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(2, $i)->getValue() ?? '')); //Excel Column 2//Required
                                    $whole_sale_price = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(3, $i)->getValue() ?? '')); //Excel Column 3
                                    $purchase_price = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(4, $i)->getValue() ?? '')); //Excel Column 4
                                    $category_id = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(5, $i)->getValue() ?? '')); //Excel Column 5
                                    $category_id = $this->get_cat_id($category_id);
                                    $code = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(6, $i)->getValue() ?? '')); //Excel Column 6
                                    $code = isset($code) && $code ? $code : $this->Master_model->generateItemCode();
                                    $supplier_id = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(7, $i)->getValue() ?? '')); //Excel Column 7
                                    $supplier_id = $this->get_supplier_id($supplier_id);
                                    $unit_type = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(8, $i)->getValue() ?? '')); //Excel Column 8//Required
                                    if($unit_type == 'Single_Unit'){
                                        $sale_unit_id = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(10, $i)->getValue() ?? '')); //Excel Column 10//Required if Unit type = Single_Unit
                                        $sale_unit_id = isset($sale_unit_id) && $sale_unit_id ? $this->get_unit_id($sale_unit_id) : '';
                                        $purchase_unit_id = $sale_unit_id;
                                        $conversion_rate = 1;
                                    }else if ($unit_type == 'Double_Unit'){
                                        $purchase_unit_id = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(9, $i)->getValue() ?? '')); //Excel Column 9//Required if Unit type = Double_Unit
                                        $purchase_unit_id = isset($purchase_unit_id) && $purchase_unit_id ? $this->get_unit_id($purchase_unit_id) : '';
                                        $sale_unit_id = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(10, $i)->getValue() ?? '')); //Excel Column 10//Required if Unit type = Single_Unit
                                        $sale_unit_id = isset($sale_unit_id) && $sale_unit_id ? $this->get_unit_id($sale_unit_id) : '';
                                        $conversion_rate = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(11, $i)->getValue() ?? '')); //Excel Column 11//Required if Unit type = Double_Unit
                                    }
                                    $warranty = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(12, $i)->getValue() ?? '')); //Excel Column 12
                                    $warranty_type = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(13, $i)->getValue() ?? '')); //Excel Column 13
                                    if($warranty_type == 'Day'){
                                        $warranty_type = 'day';
                                    }else if($warranty_type == 'Month'){
                                        $warranty_type = 'month';
                                    }else if($warranty_type == 'Year'){
                                        $warranty_type = 'year';
                                    }
                                    $guarantee = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(14, $i)->getValue() ?? '')); //Excel Column 14
                                    $guarantee_type = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(15, $i)->getValue() ?? '')); //Excel Column 15
                                    if($guarantee_type == 'Day'){
                                        $guarantee_type = 'day';
                                    }else if($guarantee_type == 'Month'){
                                        $guarantee_type = 'month';
                                    }else if($guarantee_type == 'Year'){
                                        $guarantee_type = 'year';
                                    }
                                    $brand_id = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(16, $i)->getValue() ?? '')); //Excel Column 16
                                    $brand_id = $this->get_brand_id($brand_id);
                                    $outlets = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(17, $i)->getValue() ?? '')); //Excel Column 17
                                    $outlet_stock_value = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(18, $i)->getValue() ?? '')); //Excel Column 18
                                    $alert_quantity = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(19, $i)->getValue() ?? '')); //Excel Column 21
                                    $description = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(20, $i)->getValue() ?? '')); //Excel Column 20
                                    $image = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(21, $i)->getValue() ?? '')); //Excel Column 21
                                    $vat_name = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(22, $i)->getValue() ?? '')); //Excel Column 22
                                    $vat_percent = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(23, $i)->getValue() ?? '')); //Excel Column 23 
                                    $generic_name = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(24, $i)->getValue() ?? '')); //Excel Column 24 
                                    $item_info = array();
                                    $item_info['type'] = $type;
                                    $item_info['name'] = $name;
                                    $item_info['sale_price'] = $sale_price;
                                    $item_info['whole_sale_price'] = $whole_sale_price;
                                    $item_info['purchase_price'] = $purchase_price;
                                    // $item_info['opening_stock'] = $opening_stock;
                                    $item_info['category_id'] = $category_id;
                                    $item_info['code'] = $code;
                                    $item_info['supplier_id'] = $supplier_id;
                                    if($unit_type == 'Single_Unit'){
                                        $item_info['unit_type'] = 1;
                                        $item_info['purchase_unit_id'] = $sale_unit_id;
                                        $item_info['sale_unit_id'] = $sale_unit_id;
                                        $item_info['conversion_rate'] = 1;
                                    }else if($unit_type == 'Double_Unit'){
                                        $item_info['unit_type'] = 2;
                                        $item_info['purchase_unit_id'] = $purchase_unit_id;
                                        $item_info['sale_unit_id'] = $sale_unit_id;
                                        $item_info['conversion_rate'] = $conversion_rate;
                                    }
                                    $item_info['warranty'] = $warranty;
                                    $item_info['warranty_date'] = $warranty_type;
                                    $item_info['guarantee'] = $guarantee;
                                    $item_info['guarantee_date'] = $guarantee_type;
                                    $item_info['brand_id'] = $brand_id;
                                    $item_info['alert_quantity'] = $alert_quantity;
                                    $item_info['description'] = $description;
                                    if($image){
                                        $item_info['photo'] = $image;
                                    }
                                    if($vat_name != 'None'){
                                        $tmp_vat_name = explode(',',$vat_name);
                                        $tmp_vat_percent = explode(',',$vat_percent);
                                        $tax_information = array();
                                        $tax_string = '';
                                        foreach($outlet_taxes as $key=>$value){
                                            foreach($tmp_vat_name as $key1=>$value1){
                                                if($value->tax == $value1){
                                                    $get_tax = isset($tmp_vat_percent[$key1]) && $tmp_vat_percent[$key1] ? $tmp_vat_percent[$key1] : 0;
                                                    $single_info = array(
                                                        'tax_field_id' => $value->id,
                                                        'tax_field_company_id' => $company_id,
                                                        'tax_field_name' => $value->tax,
                                                        'tax_field_percentage' => $get_tax
                                                    );
                                                    $tax_string.=($value->tax).":";
                                                    array_push($tax_information,$single_info);
                                                }
                                            }
                                        }
                                        $item_info['tax_information'] = json_encode($tax_information);
                                        $item_info['tax_string'] = $tax_string;
                                    }
                                    $item_info['generic_name'] = $generic_name;
                                    $item_info['user_id'] = $this->session->userdata('user_id');
                                    $item_info['added_date'] = date('Y-m-d H:i:s');
                                    $item_info['company_id'] = $this->session->userdata('company_id');
                                    $inserted_id = $this->Common_model->insertInformation($item_info, "tbl_items");
                                    $tmp_outlet_name = explode(',',$outlets);
                                    $tmp_outlet_stock_value = explode(',',$outlet_stock_value);
                                    foreach ($tmp_outlet_name as $row => $outlet):
                                        $fmi = array();
                                        $fmi['item_id'] = $inserted_id;
                                        $fmi['item_type'] = $type;
                                        $fmi['stock_quantity'] = (int)$tmp_outlet_stock_value[$row] * (int)$conversion_rate;
                                        $fmi['outlet_id'] = $this->get_outlet_id(trim_checker($outlet));
                                        $fmi['user_id'] = $this->session->userdata('user_id');
                                        $fmi['company_id'] = $this->session->userdata('company_id');
                                        $this->Common_model->insertInformation($fmi, 'tbl_set_opening_stocks');
                                    endforeach;
                                }
                                unlink(FCPATH . 'assets/upload-sample/excel/' . $file_name); //File Deleted After uploading in database .
                                $this->session->set_flashdata('exception', lang('Imported_successfully'));
                                redirect('Item/items');
                            } else {
                                unlink(FCPATH . 'assets/upload-sample/excel/' . $file_name); //File Deleted After uploading in database .
                                $this->session->set_flashdata('exception_err', lang('Required_Data_Missing') . ' ' . $arrayerror);
                            }
                        } else {
                            unlink(FCPATH . 'assets/upload-sample/excel/' . $file_name); //File Deleted After uploading in database .
                            $this->session->set_flashdata('exception_err', lang('Entry_is_more_than_50_or_No_entry_found'));
                        }
                    } else {
                        $error = $this->upload->display_errors();
                        $this->session->set_flashdata('exception_err', "$error");
                    }
                } else {
                    $this->session->set_flashdata('exception_err', lang('We_can_not_accept_other_files'));
                }
            } else {
                $this->session->set_flashdata('exception_err', lang('File_is_required'));
            }
            redirect('Item/uploadItem');
        }else{
            $data = array();
            $data['main_content'] = $this->load->view('master/item/uploadItems', $data, TRUE);
            $this->load->view('userHome', $data);
        }
    }

    /**
     * uploadItemPhoto
     * @access public
     * @param no
     * @return void
     */
    public function uploadItemPhoto() {
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            if (!empty($_FILES['large_image']['name'][0])) {
                $this->load->library('upload');
                $dataInfo = array();
                $files = $_FILES;
                $cpt = count($files['large_image']['name']);
                // Set upload options once
                $config = $this->set_upload_options();
                $config['detect_mime'] = FALSE;
                createDirectory('uploads/items');
                for ($i = 0; $i < $cpt; $i++) {
                    $_FILES['file']['name'] = $files['large_image']['name'][$i];
                    // pre($files['large_image']['type'][$i]);
                    $_FILES['file']['type'] = $files['large_image']['type'][$i];
                    $_FILES['file']['tmp_name'] = $files['large_image']['tmp_name'][$i];
                    $_FILES['file']['error'] = $files['large_image']['error'][$i];
                    $_FILES['file']['size'] = $files['large_image']['size'][$i];
                    // Initialize upload with options
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $dataInfo[] = $this->upload->data(); // Store uploaded file data
                    } else {
                        // Handle errors for each file
                        $upload_errors = $this->upload->display_errors();
                        // Optionally store or display the error message
                        echo "File upload failed for file {$files['large_image']['name'][$i]}: {$upload_errors}";
                    }
                }
                $this->session->set_flashdata('exception', lang('insertion_success'));
                redirect('Item/items');
            } else {
                $this->session->set_flashdata('error', 'Please select image to upload.');
                redirect('Item/uploadItemPhoto');
            }
        } else {
            $data = array();
            $data['main_content'] = $this->load->view('master/item/uploadItemPhotos', $data, TRUE);
            $this->load->view('userHome', $data);
        }
    }
    
    private function set_upload_options() {   
        // Upload configuration options
        $config = array();
        $config['upload_path'] = './uploads/items/';
        $config['allowed_types'] = '*';
        $config['max_size'] = '0'; // No limit on file size
        $config['overwrite'] = FALSE; // Do not overwrite existing files
        return $config;
    }

    /**
     * itemBarcodeGenerator
     * @access public
     * @param no
     * @return void
     */
    public function itemBarcodeGenerator() {
        $company_id = $this->session->userdata('company_id');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $item_id = $this->input->post($this->security->xss_clean('item_id'));
            $qty = $this->input->post($this->security->xss_clean('qty'));
            $arr = array();
            for ( $i=0; $i<sizeof($item_id); $i++){
                $value = explode("|",$item_id[$i]);
                $arr[] = array(
                    'id' => $value[0],
                    'item_name' => $value[1],
                    'code' => $value[2],
                    'sale_price' => $value[3],
                    'parent_id' => $value[4],
                    'qty' => $qty[$i],
                    'outlet_name' => $this->session->userdata('outlet_name'),
                );
            }
            $data = array();
            $data['items'] = $arr;
            $data['main_content'] = $this->load->view('master/item/productBarcodeGenerator', $data, TRUE);
            $this->load->view('userHome', $data);
        } else {
            $data = array();
            $data['items'] = $this->Common_model->getAllItemsWithVariation();
            $data['main_content'] = $this->load->view('master/item/productBarcodes', $data, TRUE);
            $this->load->view('userHome', $data);
        }

    }
    /**
     * itemBarcodeGeneratorLabel
     * @access public
     * @param no
     * @return void
     */
    public function itemBarcodeGeneratorLabel() {
        $company_id = $this->session->userdata('company_id');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $item_id = $this->input->post($this->security->xss_clean('item_id'));
            $qty = $this->input->post($this->security->xss_clean('qty'));
            $arr = array();
            for ($i=0;$i<sizeof($item_id);$i++){
                $value = explode("|",$item_id[$i]);
                $arr[] = array(
                    'id' => $value[0],
                    'item_name' => $value[1],
                    'code' => $value[2],
                    'sale_price' => $value[3],
                    'parent_id' => $value[4],
                    'qty' => $qty[$i],
                    'outlet_name' => $this->session->userdata('outlet_name'),
                );
            }
            $data = array();
            $data['items'] = $arr;
            $data['main_content'] = $this->load->view('master/item/productBarcodeGeneratorLabel', $data, TRUE);
            $this->load->view('userHome', $data);
        } else {
            $data = array();
            $data['items'] = $this->Common_model->getAllItemsWithVariation();
            $data['main_content'] = $this->load->view('master/item/productBarcodesLabel', $data, TRUE);
            $this->load->view('userHome', $data);
        }
    }

    /**
     * getItem
     * @access public
     * @param int
     * @return json
     */
    public function getItem($id){
        $data['item_info'] = getItemForBarcodeById($id);
        $data['item_id'] = $id;
        $response = [
            'status' => 'success',
            'data' => $data,
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
    /**
     * getVariationItem
     * @access public
     * @param int
     * @return json
     */
    public function getVariationItem($id) {
        $return_data = array();
        if($id){
            $return_data['id'] = $id;
            $return_data['item_name'] = $this->Common_model->getItemNameById($id);
            $return_data['items'] = $this->Common_model->getVariationItem($id);
        }
        echo json_encode($return_data);
    }

    /**
     * imeiSerialStockCheck
     * @access public
     * @param no
     * @return json
     */
    public function imeiSerialStockCheck(){
        $item_id = htmlspecialcharscustom($this->input->post('item_id'));
        $outlet_id = htmlspecialcharscustom($this->input->post('outlet_id'));
        $stock = $this->Common_model->imeiSerialStockCheck($item_id, $outlet_id);
        if($stock){
            $response = [
                'status' => 200,
                'data'=> $stock,
            ];
        }else{
            $response = [
                'status' => 404,
                'data'=> '',
            ];
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    /**
     * imeiSerialCheck
     * @access public
     * @param no
     * @return string
     */
    public function imeiSerialCheck() {
        $type = htmlspecialcharscustom($this->input->post('type'));
        $imeiSerial = htmlspecialcharscustom($this->input->post('imeiSerial'));
        $result = $this->Common_model->imeiSerialCheck($type,$imeiSerial);
        echo $result;
    }

    /**
     * stockQtyCheck
     * @access public
     * @param no
     * @return json
     */
    public function stockQtyCheck(){
        $item_id = htmlspecialcharscustom($this->input->post('item_id'));
        $outlet_id = htmlspecialcharscustom($this->input->post('outlet_id'));
        $stock = $this->Common_model->stockQtyCheck($item_id, $outlet_id);
        $response = [
            'status' => 'success',
            'data' => $stock,
        ];	
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }









    // ================== Need To Check =====================
    /**
     * get_cat_id
     * @access public
     * @param int
     * @return int
     */
    public function get_cat_id($category){
        $category = $this->Master_model->getCategoryId($category);
        return $category;
    }

    /**
     * get_brand_id
     * @access public
     * @param int
     * @return int
     */
    public function get_brand_id($brand){
        $brand = $this->Master_model->getBrandId($brand);
        return $brand;
    }

    /**
     * get_supplier_id
     * @access public
     * @param int
     * @return int
     */
    public function get_supplier_id($supplier_id){
        $supplier_id = $this->Master_model->getSupplierId($supplier_id);
        return $supplier_id;
    }

    /**
     * get_unit_id
     * @access public
     * @param int
     * @return int
     */
    public function get_unit_id($ingredint_unit) {
        $company_id = $this->session->userdata('company_id');
        $user_id = $this->session->userdata('user_id');
        $id = $this->db->query("SELECT id FROM tbl_units WHERE company_id=$company_id and unit_name='" . $ingredint_unit . "'")->row('id');
        if ($id != '') {
            return $id;
        } else {
            $data = array('unit_name' => $ingredint_unit, 'company_id' => $company_id);
            $query = $this->db->insert('tbl_units', $data);
            $id = $this->db->insert_id();
            return $id;
        }
    }

    /**
     * get_outlet_id
     * @access public
     * @param string
     * @return int
     */
    public function get_outlet_id($outlet_name) {
        $user_id = $this->session->userdata('user_id');
        $company_id = $this->session->userdata('company_id');
        $id = $this->db->query("SELECT id FROM tbl_outlets WHERE company_id=$company_id and outlet_name='" . $outlet_name . "'")->row('id');
        if ($id != '') {
            return $id;
        } else {
            $outlet_code = $this->Outlet_model->generateOutletCode();
            $data = array('outlet_name' => $outlet_name, 'outlet_code'=> $outlet_code, 'added_date' => date('Y-m-d H:i:s'), 'user_id' => $user_id, 'company_id' => $company_id);
            $query = $this->db->insert('tbl_outlets', $data);
            $id = $this->db->insert_id();
            return $id;
        }
    }

    /**
     * getSupplierId
     * @access public
     * @param string
     * @return int
     */
    public function getSupplierId($supplier) {
        $company_id = $this->session->userdata('company_id');
        $id = $this->db->query("SELECT id FROM tbl_suppliers WHERE company_id=$company_id and name='" . $supplier . "'")->row('id');
        if ($id != '') {
            return $id;
        } else {
            $data = array('name' => $supplier, 'company_id' => $company_id);
            $this->db->insert('tbl_suppliers', $data);
            $id = $this->db->insert_id();
            return $id;
        }
    }
    
    /**
     * getBrandId
     * @access public
     * @param string
     * @return int
     */
    public function getBrandId($brand) {
        $company_id = $this->session->userdata('company_id');
        $id = $this->db->query("SELECT id FROM tbl_brands WHERE company_id=$company_id and name='" . $brand . "'")->row('id');
        if ($id != '') {
            return $id;
        } else {
            $data = array('name' => $brand, 'company_id' => $company_id);
            $this->db->insert('tbl_brands', $data);
            $id = $this->db->insert_id();
            return $id;
        }
    }
    
    /**
     * get_item_id
     * @access public
     * @param string
     * @return int
     */
    public function get_item_id($foodingredints) {
        $company_id = $this->session->userdata('company_id');
        $user_id = $this->session->userdata('user_id');
        $id = $this->db->query("SELECT id FROM tbl_items WHERE company_id=$company_id and user_id=$user_id and name='" . $foodingredints . "'")->row('id');
        if ($id) {
            return $id;
        } else {
            $id = 0;
            return $id;
        }
    }
}
