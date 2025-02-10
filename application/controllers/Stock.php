<?php
/*
    ###########################################################
    # PRODUCT NAME:   Off POS
    ###########################################################
    # AUTHER:   Doorsoft
    ###########################################################
    # EMAIL:   info@doorsoft.co
    ###########################################################
    # COPYRIGHTS:   RESERVED BY Door Soft
    ###########################################################
    # WEBSITE:   https://www.doorsoft.co
    ###########################################################
    # This is Stock Controller
    ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock extends Cl_Controller {

    /**
     * load constructor
     * @access public
     * @return void
     */    
    public function __construct() {
        parent::__construct();
        $this->load->model('Authentication_model');
        $this->load->model('Common_model');
        $this->load->model('Stock_model');
        $this->load->model('Sale_model');
        $this->Common_model->setDefaultTimezone();
        $this->load->library('form_validation');
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        if (!$this->session->has_userdata('outlet_id')) {
            $this->session->set_flashdata('exception_2', lang('please_click_green_button'));
            $this->session->set_userdata("clicked_controller", $this->uri->segment(1));
            $this->session->set_userdata("clicked_method", $this->uri->segment(2));
            redirect('Outlet/outlets');
        }

        //start check access function
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $controller = "164";
        $function = "";
        if($segment_2=="stock" || $segment_2 == "getAjaxData" || $segment_2 == 'getStockAlertList' || $segment_2 == 'getStockAlertList' || $segment_2 == 'getLowStockAjaxData' || $segment_2 == 'getStockAlertListForDashboard' || $segment_2 == 'getStockAlertListForPurchase' || $segment_2 == 'getIngredientInfoAjax' || $segment_2 == 'getStockSegmentationOfItem'){
            $controller = "164";
            $function = "view";
        }else{
            $this->session->set_flashdata('exception_1',lang('no_access'));
            redirect('Authentication/userProfile');
        }
        if(!checkAccess($controller,$function)){
            $this->session->set_flashdata('exception_1',lang('no_access'));
            redirect('Authentication/userProfile');
        }


        $register_content = json_decode($this->session->userdata('register_content'));
        $register_status = $this->session->userdata('register_status');
        if ($register_content->register_purchase != '' && $register_status == 2) {
            $this->session->set_flashdata('exception', lang('please_open_register'));
            $this->session->set_userdata("clicked_controller", $this->uri->segment(1));
            $this->session->set_userdata("clicked_method", $this->uri->segment(2));
            redirect('Register/openRegister');
        }

    }



    /**
     * stock
     * @access public
     * @param no
     * @return void
     */
    public function stock() {
        $data = array();
        $item_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('item_id')));
        $company_id = $this->session->userdata('company_id');
        $data['item_id'] = $item_id;
        $data['item_categories'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_item_categories");
        $data['items'] = $this->Common_model->getAllDropdownItemByCompanyId($company_id, "tbl_items");
        $data['brands'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_brands');
        $data['suppliers'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_suppliers');
        $data['main_content'] = $this->load->view('stock/stock', $data, TRUE);
        $this->load->view('userHome', $data);
    }
    
    /**
     * getAjaxData
     * @access public
     * @param no
     * @return json
     */
    public function getAjaxData() {
        $generic_name = htmlspecialcharscustom($this->input->post($this->security->xss_clean('generic_name')));
        $item_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('item_id')));
        $item_code = htmlspecialcharscustom($this->input->post($this->security->xss_clean('item_code')));
        $brand_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('brand_id')));
        $category_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('category_id')));
        $supplier_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('supplier_id')));
        $stock = $this->Stock_model->make_datatables($item_id,$item_code,$brand_id,$category_id,$supplier_id, $generic_name);
        $alertQtySum = 0;
        $data = array();
        foreach($stock as $key=>$item){
            $sub_array = array();
            $generalStock = 0;
            $purchasePriceSum = 0;
            $purchaseUnitSum = 0;
            $saleUnitSum = 0;
            $itemStockAlertCls = '';
            if($item->type != 'Variation_Product'){
                if(((int)$item->stock_qty - (int)$item->out_qty) < $item->alert_quantity){
                    $itemStockAlertCls = 'stock-alert-color';
                    $alertQtySum ++;
                }
            }
            if($item->type == 'General_Product' || $item->type == 'Installment_Product' || ($item->type == 'Medicine_Product' && $item->expiry_date_maintain == 'No')){
                $generalStock = ((int)$item->stock_qty - (int)$item->out_qty);
                $genConvertedPrice = (float)$item->last_three_purchase_avg / (int)$item->conversion_rate;
                $purchasePriceSum = ($genConvertedPrice) * $generalStock;
                if($item->unit_type == '1'){
                    $saleUnitSum = (int)$generalStock;
                } else if($item->unit_type == '2'){
                    $purchaseUnitSum = (int)((int)$generalStock / $item->conversion_rate);
                    $saleUnitSum = ((int)$generalStock) % $item->conversion_rate;
                }
            }
            $sub_array[] = '<div class="'. $itemStockAlertCls .'">'. $key + 1 .'</div>';
            $sub_array[] = '<div class="'. $itemStockAlertCls .'">'. escape_output(str_word_limit($item->name, 6)) . '(' . escapeQuot($item->code) . ') </div>';
            $sub_array[] = '<div class="'. $itemStockAlertCls .'">'. escape_output($item->category_name) .'</div>';
            $variation = '';
            $variation .= '<div class="' . $itemStockAlertCls . '">';
            if ($item->type == 'Variation_Product') {
                if ($item->variations) {
                    $variations = explode("||", $item->variations);
                    foreach ($variations as $m => $val_custom) {
                        $variation_d = explode("|", $variations[$m]);
                        $variationStock = ((int)$variation_d[4] - (int)$variation_d[5]); /* $variation_d[4]Stock In - $variation_d[5]Stock Out = Current Stock  */
                        $generalStock += $variationStock;
                        $variationAlert = (int)($variation_d[2]); /* $variation_d[2] = Alert Quantity */
                        $variationConvertedPrice = ($variation_d[3] / $item->conversion_rate); /* $variation_d[3] = Last 3 Purchase AVG */
                        $purchasePriceSum += $variationConvertedPrice * $variationStock; /* Unit Price * Stock = Stock Amount */
                        if ($variationStock < $variationAlert) {
                            $alertQtySum++;
                        }
                        if ($item->unit_type == '1') {
                            $saleUnitSum += $variationStock;
                        } elseif ($item->unit_type == '2') {
                            $purchaseUnitSum += ((int)$variationStock / $item->conversion_rate);
                            $saleUnitSum += (((int)$variationStock) % $item->conversion_rate);
                        }
                    }
                }
                $variation .= '<button type="button" class="btn bg-blue-btn modal_trigger" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="'.$item->id.'" data-type="'.$item->type.'" data-name="'.$item->name . '(' . $item->code . ')' .'">Show All '. ($item->type == 'Variation_Product' ? 'Variation' : '').'</button>';
            } elseif ($item->type == 'IMEI_Product' || $item->type == 'Serial_Product') {
                $expStock = ((int)$item->stock_qty - (int)$item->out_qty);
                $expConvertedPrice = (float)$item->last_three_purchase_avg / (int)$item->conversion_rate;
                $purchasePriceSum = ($expConvertedPrice) * $expStock;
                $purchaseUnitSum = (int)$expStock;
                $saleUnitSum = (int)$expStock;
                $variation .= '<button type="button" class="btn bg-blue-btn modal_trigger" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="'.$item->id.'" data-type="'.$item->type.'" data-name="'.$item->name . '(' . $item->code . ')' .'">Show All '. ($item->type == 'IMEI_Product' ? 'IMEI' : 'Serial').'</button>';
            } elseif (($item->type == 'Medicine_Product' && $item->expiry_date_maintain == 'Yes')) {
                $purchasePriceSum = ((float)$item->last_three_purchase_avg / (int)$item->conversion_rate) * ((int)$item->stock_qty - (int)$item->out_qty);
                
                if (isset($item->allexpiry) && $item->allexpiry) {
                    $allexpiry = explode("||", $item->allexpiry);
                    foreach ($allexpiry as $ek => $expiry) {
                        $expiry_d = explode("|", $expiry);
                        $expSaleQtySum = ((int)$expiry_d[1] / $item->conversion_rate) * $item->conversion_rate;
                        $generalStock += $expSaleQtySum;
                        if ($item->unit_type == '1') {
                            $saleUnitSum += (int)$expiry_d[1]; /* $expiry_d[1] = Expiry Quantity  */
                        } elseif ($item->unit_type == '2') {
                            $purchaseUnitSum += ((int)((int)$expiry_d[1] / $item->conversion_rate));
                            $saleUnitSum += ((int)$expiry_d[1] % $item->conversion_rate);
                        }
                    }
                }
                $variation .= '<button type="button" class="btn bg-blue-btn modal_trigger" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="'.$item->id.'" data-type="'.$item->type.'" data-name="'.$item->name . '(' . $item->code . ')' .'">Show All '. ($item->type == 'Medicine_Product' ? 'Medicine' : '').'</button>';
            }
            $sub_array[] = $variation;
            $unitType = '';
            $unitType .= '<div class="' . $itemStockAlertCls . '">';
            if ($item->unit_type == '1') {
                $unitType .= getAmtPCustom($saleUnitSum) . ' ' . $item->sale_unit;
            } elseif ($item->unit_type == '2') {
                $unitType .= getAmtPCustom($purchaseUnitSum) . ' ' . $item->purchase_unit . ' ' . getAmtPCustom($saleUnitSum) . ' ' . $item->sale_unit . ' ';
                $unitType .= '(' . getAmtPCustom($generalStock) . $item->sale_unit . ')';
            }
            $unitType .= '</div>';
            $sub_array[] = $unitType;
            $sub_array[] = '<div class="'. $itemStockAlertCls .'">'. getAmtStock((int)$item->last_three_purchase_avg / (int)($item->conversion_rate)) .'</div>';
            $totalHtml = '';
            $totalHtml .= '<div class="' . $itemStockAlertCls . '">';
            $totalHtml .= getAmtStock($purchasePriceSum);
            $totalHtml .= '</div>';
            $sub_array[] = $totalHtml;
            $data[] = $sub_array;
        } 
        $output = array(
            "draw" => intval($this->Sale_model->getDrawData()),
            "recordsTotal" => $this->Stock_model->get_all_data($item_id,$item_code,$brand_id,$category_id,$supplier_id, $generic_name),
            "recordsFiltered" => $this->Stock_model->get_all_data($item_id,$item_code,$brand_id,$category_id,$supplier_id, $generic_name),
            "data" => $data, 
            "alertSum" => $alertQtySum,
        );
        echo json_encode($output);  
    }

    /**
     * getStockAlertList
     * @access public
     * @param no
     * @return void
     */
    public function getStockAlertList() {
        $data = array();
        $item_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('item_id')));
        $company_id = $this->session->userdata('company_id');
        $data['item_id'] = $item_id;
        $data['item_categories'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_item_categories");
        $data['items'] = $this->Common_model->getAllDropdownItemByCompanyId($company_id, "tbl_items");
        $data['brands'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_brands');
        $data['suppliers'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_suppliers');
        $data['main_content'] = $this->load->view('stock/stockAlertList', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    /**
     * getLowStockAjaxData
     * @access public
     * @param no
     * @return json
     */
    public function getLowStockAjaxData() {
        $generic_name = htmlspecialcharscustom($this->input->post($this->security->xss_clean('generic_name')));
        $item_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('item_id')));
        $item_code = htmlspecialcharscustom($this->input->post($this->security->xss_clean('item_code')));
        $brand_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('brand_id')));
        $category_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('category_id')));
        $supplier_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('supplier_id')));
        $stock = $this->Stock_model->make_datatablesLowStock($item_id,$item_code,$brand_id,$category_id,$supplier_id, $generic_name);
        // Stock Prepare Code
        $alertQtySum = 0;
        $data = array();
        foreach($stock as $key=>$item){
            $sub_array = array();
            $generalStock = 0;
            $purchasePriceSum = 0;
            $purchaseUnitSum = 0;
            $saleUnitSum = 0;
            if($item->type == 'General_Product' || $item->type == 'Installment_Product' || ($item->type == 'Medicine_Product' && $item->expiry_date_maintain == 'No')){
                $generalStock = ((int)$item->stock_qty - (int)$item->out_qty);
                $genConvertedPrice = (float)$item->last_three_purchase_avg / (int)$item->conversion_rate;
                $purchasePriceSum = ($genConvertedPrice) * $generalStock;
                if($item->unit_type == '1'){
                    $saleUnitSum = (int)$generalStock;
                } else if($item->unit_type == '2'){
                    $purchaseUnitSum = (int)((int)$generalStock / $item->conversion_rate);
                    $saleUnitSum = ((int)$generalStock) % $item->conversion_rate;
                }
            }
            $sub_array[] = '<div>'. $key + 1 .'</div>';
            $sub_array[] = '<div>'. escape_output($item->name) . '(' . escapeQuot($item->code) . ') </div>';
            $sub_array[] = '<div>'. escape_output($item->category_name) .'</div>';
            $variation = '';
            $variation .= '<div>';
            if ($item->type == 'Variation_Product') {
                    $variation .= '<div id="stockInnerTable">
                                    <ul>
                                        <li>
                                            <div>' . lang('item') . '(' . lang('code') . ')</div>
                                            <div>' . lang('quantity') . '</div>
                                            <div>' . lang('LPP') . '/' . lang('PP') . '<i data-tippy-content="' . lang('LPP_PP') . '" class="fa-regular fa-circle-question tippyBtnCall font-16 theme-color"></i></div>
                                        </li>';
                                        if ($item->variations) {
                                            $variations = explode("||", $item->variations);
                                            foreach ($variations as $m => $val_custom) {
                                                $variation_d = explode("|", $variations[$m]);
                                                $variationStock = ((int)$variation_d[4] - (int)$variation_d[5]); /* $variation_d[4]Stock In - $variation_d[5]Stock Out = Current Stock  */
                                                $variationAlert = (int)($variation_d[2]); /* $variation_d[2] = Alert Quantity */
                                                $variationConvertedPrice = ($variation_d[3] / $item->conversion_rate); /* $variation_d[3] = Last 3 Purchase AVG */
                                                $purchasePriceSum += $variationConvertedPrice * $variationStock; /* Unit Price * Stock = Stock Amount */
                                                $vItemStockAlertCls = '';
                                                if ((float)$variationStock < (float)$variationAlert) {
                                                    $generalStock += $variationStock;
                                                    $vItemStockAlertCls = ''; /* Alert Class */
                                                    $vQtyWithUnit = '';
                                                    if ($item->unit_type == '1') {
                                                        $saleUnitSum += $variationStock;
                                                        $vQtyWithUnit = escape_output(getAmtPCustom($variationStock)) . ' ' . $item->sale_unit;
                                                    } elseif ($item->unit_type == '2') {
                                                        $purchaseUnitSum += ((int)$variationStock / $item->conversion_rate);
                                                        $saleUnitSum += (((int)$variationStock) % $item->conversion_rate);
                                                        $vPurchaseUnit = getAmtPCustom((int)($variationStock / $item->conversion_rate)) . ' ' . $item->purchase_unit;
                                                        $vSaleUnit = getAmtPCustom(((int)$variationStock) % $item->conversion_rate) . ' ' . $item->sale_unit;
                                                        $vQtyWithUnit =  $vPurchaseUnit . ' ' . $vSaleUnit;
                                                    }
                                                    $variation .= '<li>
                                                                        <div class="'. $vItemStockAlertCls .'">' . $variation_d[0] . '(' . $variation_d[1] . ')</div>
                                                                        <div>';
                                                    if ($item->unit_type == '1') {
                                                        $variation .= $vQtyWithUnit;
                                                    } else if ($item->unit_type == '2') {
                                                        $variation .= $vQtyWithUnit . ' (' . getAmtPCustom($variationStock) . ' ' . $item->sale_unit . ')';
                                                    }
                                                    $variation .= '</div>
                                                                        <div class="'. $vItemStockAlertCls .'">' . getAmtStock(($variation_d[3]) / $item->conversion_rate) . '</div>
                                                    </li>';
                                                }

                                            }
                                        }
                                        $variation .= '</ul>
                </div>';
            }elseif ($item->type == 'IMEI_Product' || $item->type == 'Serial_Product') {
                $variation .= '<div id="stockInnerTable">
                                    <ul>
                                        <li>
                                            <div>' . lang('type') . '</div>
                                            <div>' . lang('imei_serial_number') . '</div>
                                        </li>';

                $expStock = ((int)$item->stock_qty - (int)$item->out_qty);
                $expConvertedPrice = (float)$item->last_three_purchase_avg / (int)$item->conversion_rate;
                $purchasePriceSum = ($expConvertedPrice) * $expStock;
                $purchaseUnitSum = (int)$expStock;
                $saleUnitSum = (int)$expStock;
                if ($item->allimei) {
                    $imaiSerial = explode("||", $item->allimei);
                    foreach ($imaiSerial as $k => $v) {
                        $imei_serial_type = $item->type == 'IMEI_Product' ? 'IMEI Number:' : 'Serial Number:';
                        $variation .= '<li>
                                            <div>' . $imei_serial_type . '</div>
                                            <div>' . $v . '</div>
                                        </li>';
                    }
                }
                $variation .= '</ul>
                            </div>';
            } elseif (($item->type == 'Medicine_Product' && $item->expiry_date_maintain == 'Yes')) {
                $expItemStockAlertCls = '';
                $purchasePriceSum = ((float)$item->last_three_purchase_avg / (int)$item->conversion_rate) * ((int)$item->stock_qty - (int)$item->out_qty);
                $variation .= '<div id="stockInnerTable">
                                    <ul>
                                        <li>
                                            <div>' . lang('expiry_date') . '</div>
                                            <div>' . lang('quantity') . '</div>
                                        </li>';
                if (isset($item->allexpiry) && $item->allexpiry) {
                    $allexpiry = explode("||", $item->allexpiry);
                    foreach ($allexpiry as $ek => $expiry) {
                        $expiry_d = explode("|", $expiry);
                        $expSaleQtySum = ((int)$expiry_d[1] / $item->conversion_rate) * $item->conversion_rate;
                        if($expiry_d[1] < $item->alert_quantity){
                            $generalStock += $expSaleQtySum;
                            $expQtyWithUnit = '';
                            if ($item->unit_type == '1') {
                                $saleUnitSum += (int)$expiry_d[1]; /* $expiry_d[1] = Expiry Quantity  */
                                $expQtyWithUnit = escape_output(getAmtPCustom((int)$expiry_d[1])) . ' ' . $item->sale_unit;
                            } elseif ($item->unit_type == '2') {
                                $purchaseUnitSum += ((int)$expiry_d[1] / $item->conversion_rate);
                                $saleUnitSum += ((int)$expiry_d[1] % $item->conversion_rate);
                                $expPurchaseUnit = getAmtPCustom((int)$expiry_d[1] / $item->conversion_rate) . ' ' . $item->purchase_unit;
                                $expSaleUnit = getAmtPCustom(((int)$expiry_d[1] % $item->conversion_rate)) . ' ' . $item->sale_unit;
                                $expQtyWithUnit =  $expPurchaseUnit . ' ' . $expSaleUnit;
                            }
                            $variation .= '<li>
                                                <div class="'.$expItemStockAlertCls.'">' . dateFormat($expiry_d[0]) . '</div>
                                                <div class="'.$expItemStockAlertCls.'">' . $expQtyWithUnit . '</div>
                                            </li>';
                        }

                    }
                }
                $variation .= '</ul>
                            </div>';
            }
            $variation .= '</div>';
            $sub_array[] = $variation;
            $unitType = '';
            $unitType .= '<div>';
            if ($item->unit_type == '1') {
                $unitType .= getAmtPCustom($saleUnitSum) . ' ' . $item->sale_unit;
            } elseif ($item->unit_type == '2') {
                $unitType .= getAmtPCustom($purchaseUnitSum) . ' ' . $item->purchase_unit . ' ' . getAmtPCustom($saleUnitSum) . ' ' . $item->sale_unit . ' ';
                $unitType .= '(' . getAmtPCustom($generalStock) . $item->sale_unit . ')';
            }
            $unitType .= '</div>';
            $sub_array[] = $unitType;
            if($saleUnitSum || $purchaseUnitSum){
                $sub_array[] = '<div>'. getAmtStock((int)$item->last_three_purchase_avg / (int)($item->conversion_rate)) .'</div>';
            } else {
                $sub_array[] = '<div>'. getAmtStock(0) .'</div>';
            }
            $totalHtml = '';
            $totalHtml .= '<div>';
            if($saleUnitSum || $purchaseUnitSum){
                $totalHtml .= getAmtStock($purchasePriceSum);
            } else {
                $totalHtml .= getAmtStock(0);
            }
            $totalHtml .= '</div>';
            $sub_array[] = $totalHtml;
            $data[] = $sub_array;
        } 
        $output = array(
            "draw" => intval($this->Sale_model->getDrawData()),
            "recordsTotal" => $this->Stock_model->get_all_data($item_id,$item_code,$brand_id,$category_id,$supplier_id, $generic_name),
            "recordsFiltered" => $this->Stock_model->get_all_data($item_id,$item_code,$brand_id,$category_id,$supplier_id, $generic_name),
            "data" => $data, 
            "alertSum" => $alertQtySum,
        );
        echo json_encode($output);  
    }


    /**
     * getStockAlertListForDashboard
     * @access public
     * @param no
     * @return object
     */
    public function getStockAlertListForDashboard() {
        $data = array();
        $data['stock'] = $this->Stock_model->getStock('', '', '', '', '');
        foreach ($data['stock'] as $key=>$value){
            if($value->p_type == 'Variation_Product'){
                $data['stock'][$key]->variations = $this->Stock_model->get_variation_products($value->id);
            }
        }
        return $data;
    }
    /**
     * getStockAlertListForPurchase
     * @access public
     * @param no
     * @return string
     */
    public function getStockAlertListForPurchase() {  
        $supplier_id = $_POST['supplier_id'];
        $stock =  $this->Stock_model->getStock('', '', '',$supplier_id,'');
        $totalStock = 0;
        $grandTotal = 0; 
        $i = 1;
        $table_row = '';
        $total_ = '';
        if (!empty($stock) && isset($stock)){
            foreach ($stock as $key => $value){
                $totalStock = $value->total_purchase  - $value->total_damage - $value->total_sale; 
                if ($totalStock <= $value->alert_quantity){ 
                    $table_row .= '<tr class="rowCount"  data-id="' . $i . '" id="row_' . $i . '">' . '<td class="pl_10"><p id="sl_' . $i . '">' . $i . '</p></td>' . '<td><span class="op_padding_bottom_5">' . $value->name. '</span></td>' . '<input type="hidden" id="item_id_' . $i . '" name="item_id[]" value="' . $value->id . '"/>' . '<td><input type="text" id="unit_price_' . $i . '" name="unit_price[]" onfocus="this.select();" class="form-control integerchk aligning" placeholder="'.lang('unit_price').'" value="' . $value->purchase_price . '" onkeyup="return calculateAll();"/><span class="label_aligning">' . $this->session->userdata('currency') . '</span></td>' . '<td><input type="text" data-countID="' . $i . '" id="quantity_amount_' . $i . '" name="quantity_amount[]" onfocus="this.select();" class="form-control integerchk aligning countID" placeholder="'.lang('Qty_Amount').'" value="' . absCustom($totalStock) . '"  onkeyup="return calculateAll();" ><span class="label_aligning">' . $value->unit_name . '</span></td>' . '<td><input type="text" id="total_' . $i . '" name="total[]" class="form-control integerchk aligning" placeholder="'.lang('total').'" value="' . $value->purchase_price * absCustom($totalStock) . '" readonly/><span class="label_aligning">' . $this->session->userdata('currency') . '</span></td>' . '<td><a class="btn btn-danger btn-xs" onclick="return deleter(' . $i . ',' . $value->id . ');" ><i class="fa fa-trash text-white"></i> </a></td>' . '</tr>';
                    $i++;
                }
            }
        }
        echo $table_row;   
    }
    
    /**
     * getIngredientInfoAjax
     * @access public
     * @param no
     * @return json
     */
    public function getIngredientInfoAjax() {
        $cat_id = $_GET['category_id'];
        if ($cat_id) {
            $results = $this->Stock_model->getDataByCatId($cat_id, "tbl_items");
        }
        echo json_encode($results);
    }


    



    /**
     * getStockSegmentationOfItem
     * @access public
     * @param no
     * @return string
     */
    public function getStockSegmentationOfItem(){
        $item_id = $this->input->post($this->security->xss_clean('item_id'));
        $item_type = $this->input->post($this->security->xss_clean('item_type'));
    
        $html = '';
        if ($item_type == 'IMEI_Product' || $item_type == 'Serial_Product') {
            $data = getIMEISerial($item_id);
            if ($data && $data->allimei) {
                $available_imei = explode('||', $data->allimei);
                $i = count($available_imei);
                foreach ($available_imei as $key => $value) {
                    $html .= '<tr>';
                    $html .= '<td class="text-left">' . $i-- . '</td>';
                    $html .= '<td>' . htmlspecialchars($value) . '</td>';
                    $html .= '</tr>';
                }
            }
        } else if ($item_type == 'Medicine_Product') {
            $data = $this->Common_model->getSingleExpiryItemWithStock($item_id);
            if ($data && $data->allexpiry) {
                $all_expiry = explode('||', $data->allexpiry);
                $i = count($all_expiry);
                foreach ($all_expiry as $m => $val_custom) {
                    $expiry_d = explode("|", $all_expiry[$m]);
                    if (count($expiry_d) < 2) {
                        continue;
                    }
                    $html .= '<tr>';
                    $html .= '<td class="text-left">' . $i-- . '</td>';
                    $html .= '<td>' . ($expiry_d[0]) . '</td>';
                    $html .= '<td>' . getAmtPCustom($expiry_d[1]) . '</td>';
                    $html .= '</tr>';
                }
            }
        } else if ($item_type == 'Variation_Product') {
            $data = $this->Common_model->getSingleVariationItemWithStock($item_id);
            if ($data && $data->variations) {
                $all_variation = explode('||', $data->variations);
                $i = count($all_variation);
                $data->conversion_rate = $data->conversion_rate ?: 1;
                foreach ($all_variation as $m => $val_custom) {
                    $variation_d = explode("|", $all_variation[$m]);
                    if (count($variation_d) < 6) {
                        continue;
                    }
                    $stock_available = $variation_d[4] - $variation_d[5];
                    $purchase_avg = $variation_d[3] / $data->conversion_rate;
                    $html .= '<tr>';
                    $html .= '<td class="text-left">' . $i-- . '</td>';
                    $html .= '<td>' . htmlspecialchars($variation_d[0] . ' (' . $variation_d[1] . ')') . '</td>';
                    $html .= '<td>' . getAmtPCustom($stock_available) . '</td>';
                    $html .= '<td>' . htmlspecialchars(getAmtStock($purchase_avg)) . '</td>';
                    $html .= '<td>' . htmlspecialchars(getAmtStock($stock_available * $purchase_avg)) . '</td>';
                    $html .= '</tr>';
                }
            }
        }
        echo json_encode($html);
    }
}