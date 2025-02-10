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
    # This is Ajax_View Controller
    ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax_View extends Cl_Controller {

    /**
     * load constructor
     * @access public
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->model('Ajax_model');
        $this->load->model('Stock_model');
        $this->load->model('Sale_model');
        $this->load->library('form_validation');
        $this->Common_model->setDefaultTimezone();
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
    }


    /**
     * getAjaxData
     * @access public
     * @param no
     * @return json
     */
    public function getAjaxData() {
        $outlet_id = $this->session->userdata('outlet_id');
        $saleReturns = $this->Common_model->getAllByOutletIdSaleReturn($outlet_id);
        $saleReturns_num_rows = $this->Common_model->getAllByOutletIdNumRows($outlet_id);
        $saleReturns_Total = $this->Common_model->getAllByOutletId($outlet_id, "tbl_sale_return");
        $data = array();
        foreach ($saleReturns as $row){
            $sub_array =  array();
            $sub_array[] = $row->date;
            $sub_array[] = $row->amount;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($_POST['draw']),
            "recordsTotal" => sizeof($saleReturns_Total),
            "recordsFiltered" => $saleReturns_num_rows,
            "data" => $data
        );
        echo json_encode($output);
    }


    /**
     * getCustomerSales
     * @access public
     * @param no
     * @return string
     */
    public function getCustomerSales() {
        $customer_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('customer_id')));
        $customer_sales = $this->db->query("select id, customer_id, sale_no, total_items, total_payable, sale_date from tbl_sales where customer_id='$customer_id' and del_status='Live'")->result();
        $invoice_dropdown = '<option value="">'.lang('select').'</option>';
        if (!empty($customer_sales)) {
            foreach ($customer_sales as $value){
                $invoice_dropdown .= '<option value="'. $value->id .'">Inoice: '. $value->sale_no .' Date: '. date($this->session->userdata('date_format'), strtotime($value->sale_date)) .' Total Item: '. $value->total_items .' Payable: '. $value->total_payable. $this->session->userdata('currency') .'</option>';
            }
        }
        echo $invoice_dropdown;
    }

    /**
     * getItemsOfSale
     * @access public
     * @param no
     * @return string
     */
    public function getItemsOfSale() {
        $sale_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('sale_id')));
        $sale_items = $this->db->query("SELECT sd.id, sd.food_menu_id, i.name.i.code 
        FROM tbl_sales_details sd 
        JOIN tbl_items i ON i.id = sd.food_menu_id
        WHERE sd.sales_id='$sale_id' AND sd.del_status='Live'")->result();
        $item_dropdown = '<option value="">'.lang('select').'</option>';
        if (!empty($sale_items)) {
            foreach ($sale_items as $value){
                $item_dropdown .= '<option value="'. $value->food_menu_id .'">'. $value->name . '(' . $value->code . ')' .'</option>';
            }
        }
        echo $item_dropdown;
    }



    /**
     * getSaleItemDetails
     * @access public
     * @param no
     * @return json
     */
    public function getSaleItemDetails() {
        $item_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('item_id')));
        $sale_item_details = $this->db->query("select qty, menu_price_with_discount from tbl_sales_details  where food_menu_id='$item_id' and del_status='Live'")->row();
        echo json_encode($sale_item_details);
    }

    /**
     * getPurchaseItemDetails
     * @access public
     * @param no
     * @return json
     */
    public function getPurchaseItemDetails() {
        $item_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('item_id')));
        $purchase_item_details = $this->db->query("select quantity_amount, total from tbl_purchase_details  where item_id='$item_id' and del_status='Live'")->row();
        echo json_encode($purchase_item_details);
    }

    /**
     * getItemsOfPurchase
     * @access public
     * @param no
     * @return string
     */
    public function getItemsOfPurchase() {
        $purchase_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('purchase_id')));
        $purchase_items = $this->db->query("select id, item_id from tbl_purchase_details where purchase_id='$purchase_id' and del_status='Live'")->result();
        $item_dropdown = '<option value="">'.lang('select').'</option>';
        if (!empty($purchase_items)) {
            foreach ($purchase_items as $value){
                $item_dropdown .= '<option value="'. $value->item_id .'">'. foodMenuName($value->item_id) .'</option>';
            }
        }
        echo $item_dropdown;
    }


    /**
     * getStockAlertListForPurchase
     * @access public
     * @param no
     * @return string
     */
    public function getStockAlertListForPurchase() {
        $supplier_id = $_POST['supplier_id'];
        $stock = $this->Stock_model->getStock('', '', '',$supplier_id,'');
        $totalStock = 0;
        $grandTotal = 0;
        $i = 1;
        $table_row = '';
        $total_ = '';
        if (!empty($stock) && isset($stock)){
            foreach ($stock as $key => $value){
                $totalStock = $value->total_purchase  - $value->total_damage - $value->total_sale;
                if ($totalStock <= $value->alert_quantity){
                    $table_row .= '<tr class="rowCount"  data-id="' . $i . '" id="row_' . $i . '">' .
                        '<td class="pl_10"><p id="sl_' . $i . '">' . $i . '</p></td>' .
                        '<td><span class="op_padding_bottom_5">' . $value->name. '</span></td>' .
                        '<input type="hidden" id="item_id_' . $i . '" name="item_id[]" value="' . $value->id . '"/>' .
                        '<td><input type="text" id="unit_price_' . $i . '" name="unit_price[]" onfocus="this.select();" class="form-control integerchk aligning" placeholder="Unit Price" value="' . $value->purchase_price . '" onkeyup="return calculateAll();"/><span class="label_aligning">' . $this->session->userdata('currency') . '</span></td>' .
                        '<td><input type="text" data-countID="' . $i . '" id="quantity_amount_' . $i . '" name="quantity_amount[]" onfocus="this.select();" class="form-control integerchk aligning countID" placeholder="Qty/Amount" value="' . absCustom($totalStock) . '"  onkeyup="return calculateAll();" ><span class="label_aligning">' . $value->unit_name . '</span></td>' .
                        '<td><input type="text" id="total_' . $i . '" name="total[]" class="form-control integerchk aligning" placeholder="Total" value="' . $value->purchase_price * absCustom($totalStock) . '" readonly/><span class="label_aligning">' . $this->session->userdata('currency') . '</span></td>' .
                        '<td><a class="btn btn-danger btn-xs" onclick="return deleter(' . $i . ',' . $value->id . ');" ><i class="fa fa-trash text-white"></i> </a></td>' .
                        '</tr>';
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
        $outlet_id = $this->session->userdata('outlet_id');
        if ($cat_id) {
            $results = $this->Stock_model->getDataByCatId($cat_id, "tbl_items");
        } else {
            $results = $this->Stock_model->getAllByOutletIdForDropdown($outlet_id, "tbl_items");
        }
        echo json_encode($results);
    }


    /**
     * getCustomerDue
     * @access public
     * @param no
     * @return int
     */
    public function getCustomerDue() {
        $customer_id = $_GET['customer_id'];
        $remaining_due = $this->Customer_due_receive_model->getCustomerDue($customer_id);
        echo $remaining_due;
    }


    /**
     * getSupplierDue
     * @access public
     * @param no
     * @return int
     */
    public function getSupplierDue() {
        $supplier_id = $_GET['supplier_id'];
        $remaining_due = getSupplierDue($supplier_id);
        echo $remaining_due;
    }

    /**
     * set_collapse
     * @access public
     * @param no
     * @return json
     */
    public function set_collapse() {
        $value = htmlspecialcharscustom($this->input->post($this->security->xss_clean('status')));
        $this->session->set_userdata('is_collapse',$value);
        echo json_encode('success');
    }

}
