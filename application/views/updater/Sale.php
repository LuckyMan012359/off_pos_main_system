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
    # This is Sale Controller
    ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');

use Omnipay\Common\CreditCard;
use Omnipay\Omnipay;
use Salla\ZATCA\GenerateQrCode;
use Salla\ZATCA\Tags\InvoiceDate;
use Salla\ZATCA\Tags\InvoiceTaxAmount;
use Salla\ZATCA\Tags\InvoiceTotalAmount;
use Salla\ZATCA\Tags\Seller;
use Salla\ZATCA\Tags\TaxNumber;
use Stripe\Charge;
use Stripe\Stripe;
class Sale extends Cl_Controller {

    /**
     * load constructor
     * @access public
     * @return void
     */    
    public function __construct() {
        parent::__construct();
        $this->load->model('Authentication_model');
        $this->load->model('Common_model');
        $this->load->model('Sale_model');
        $this->load->model('Master_model');
        $this->load->model('Stock_model');
        $this->load->model('Customer_due_receive_model');
        $this->load->library('form_validation');
        $this->Common_model->setDefaultTimezone();
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        if (!$this->session->has_userdata('outlet_id')) {
            $this->session->set_flashdata('exception_2', lang('Please_click_on_green'));
            $this->session->set_userdata("clicked_controller", $this->uri->segment(1));
            $this->session->set_userdata("clicked_method", $this->uri->segment(2));
            redirect('Outlet/outlets');
        }
        //start check access function
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $controller = "";
        $function = "";
        if($segment_2=="POS" || $segment_2 == "getAllCustomers" || $segment_2 == "registerDetailCalculationToShowAjax" || $segment_2 == "registerDetailCalculationToShow" || $segment_2 == "findCustomerCreditLimit" || $segment_2 == "get_all_holds_ajax" || $segment_2 == "get_customer_ajax" || $segment_2 == "get_single_hold_info_by_ajax" || $segment_2 == "stockCheckingForThisOutletById" || $segment_2 == "getExpiryByOutlet" || $segment_2 == "getVariationByItemId" || $segment_2 == "getIMEISerial" || $segment_2 == "closeRegister" || $segment_2 == "getOpeningDetails" || $segment_2 == "couponCodeValidate" || $segment_2 == "checUserDiscountPermission" || $segment_2 ==  'stripePayment' || $segment_2 == 'paypalPayment' || $segment_2 == 'get_new_hold_number_ajax' || $segment_2 == 'add_hold_by_ajax' || $segment_2 == 'checkAccess' || $segment_2 == 'add_customer_by_ajax' || $segment_2 == 'getTotalLoyaltyPoint' || $segment_2 == 'checkUniqueCustomerMobile' || $segment_2 == "singleExpiryDateStockCheck" || $segment_2 == 'groceryExperience' || $segment_2 == 'getComboItemCheck' || $segment_2 == 'checkingExisOrNotIMEISerial' || $segment_2 == 'delete_all_information_of_hold_by_ajax' || $segment_2 == 'searchByGenericName' || $segment_2 == 'todaysSummary'){
            $controller = "138";
            $function = "pos";
        }elseif($segment_2=="add_sale_by_ajax" || $segment_2=="get_all_information_of_a_sale" || $segment_2 == "get_all_information_of_a_sale_ajax" || $segment_2 == "update_order_status_ajax"){
            $controller = "138";
            $function = "add";
        }elseif($segment_2=="edit_sale"){
            $controller = "138";
            $function = "edit";
        }elseif($segment_2=="deleteSale" || $segment_2 == "delete_all_holds_with_information_by_ajax" || $segment_2 == "cancel_particular_order_ajax"){
            $controller = "138";
            $function = "delete";
        }elseif($segment_2=="sales" || $segment_2 == "getAjaxData" || $segment_2 == "get_last_10_sales_ajax"){
            $controller = "138";
            $function = "list";
        }elseif($segment_2=="print_invoice" || $segment_2 == "a4InvoicePDF"){
            $controller = "138";
            $function = "invoice";
        }elseif($segment_2=="print_challan"){
            $controller = "138";
            $function = "challan";
        }elseif($segment_2=="deliveryStatusChange"){
            $controller = "138";
            $function = "delivery_status";
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
        if (($register_content->register_sale != '' && $register_status == 2)  || $register_status == '' || $register_status == '2') {
            $this->session->set_flashdata('exception', lang('please_open_register'));
            $this->session->set_userdata("clicked_controller", $this->uri->segment(1));
            $this->session->set_userdata("clicked_method", $this->uri->segment(2));
            redirect('Register/openRegister');
        }
    }

    /**
     * groceryExperience
     * @access public
     * @param int
     * @return void
     */
    public function groceryExperience() {
        $company_id = $this->session->userdata('company_id');
        $grocery_value = htmlspecialcharscustom($this->input->post($this->security->xss_clean('grocery_value')));
        $update_company = [];
        $message = '';
        $update_company['grocery_experience'] = $grocery_value;
        $message = 'POS experience change successfully.';
        $this->session->set_userdata($update_company);
        $this->Common_model->updateInformation($update_company, $company_id, "tbl_companies");
        $response = [
            'status' => 'success',
            'message' => $message,
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
    /**
     * searchByGenericName
     * @access public
     * @param int
     * @return void
     */
    public function searchByGenericName() {
        $company_id = $this->session->userdata('company_id');
        $generic_name_search_option = htmlspecialcharscustom($this->input->post($this->security->xss_clean('generic_name_search_option')));
        $update_company = [];
        $message = '';
        $update_company['generic_name_search_option'] = $generic_name_search_option;
        if($generic_name_search_option == 'Yes'){
            $message = 'Generic name search facility has been enabled successfully!';
        }else{
            $message = 'Generic name search facility has been disabled successfully!';
        }
        $this->session->set_userdata($update_company);
        $this->Common_model->updateInformation($update_company, $company_id, "tbl_companies");
        $response = [
            'status' => 'success',
            'message' => $message,
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }


    /**
     * POS
     * @access public
     * @param int
     * @return void
     */
    public function POS($encrypted_id = "") {
        $company_id = $this->session->userdata('company_id');
        $data = array();
        $data['customers'] = $this->Common_model->getAllByCustomerByCompanyIdASC($company_id, 'tbl_customers');
        $data['denominations'] = $this->Common_model->getDenomination($company_id);
        $data['items'] = $this->Stock_model->getItemForPOS('', '', '','','');
        $data['item_categories'] = $this->Sale_model->getItemCategoriesBySorted($company_id, 'tbl_item_categories');
        $data['brands'] = $this->Common_model->getAllByCompanyId($company_id, 'tbl_brands');
        $data['waiters'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id,'tbl_users');
        $data['multipleCurrencies'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_multiple_currencies");
        $data['groups'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_customer_groups');
        $data['delivery_partners'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_delivery_partners');
        $data['payment_methods'] = $this->Sale_model->getAllPaymentMethodsForPOS();
        $this->load->view('sale/POS/main_screen', $data);
    }


    /**
     * add_sale_by_ajax
     * @access public
     * @param no
     * @return void
     */
    function add_sale_by_ajax(){
        $fiscal_printer_status = $this->session->userdata('fiscal_printer_status');
        $acc_type = array();
        $customer_name = htmlspecialcharscustom($this->input->post($this->security->xss_clean('customer_name')));
        $account_type = htmlspecialcharscustom($this->input->post($this->security->xss_clean('account_type')));
        $send_invoice_email = htmlspecialcharscustom($this->input->post($this->security->xss_clean('send_invoice_email')));
        $send_invoice_sms = htmlspecialcharscustom($this->input->post($this->security->xss_clean('send_invoice_sms')));
        $send_invoice_whatsapp = htmlspecialcharscustom($this->input->post($this->security->xss_clean('send_invoice_whatsapp')));
        $finalize_previous_due = htmlspecialcharscustom($this->input->post($this->security->xss_clean('finalize_previous_due')));
        $paid_amount = htmlspecialcharscustom($this->input->post($this->security->xss_clean('paid_amount')));
        $due_amount = htmlspecialcharscustom($this->input->post($this->security->xss_clean('due_amount')));
        $account_note = htmlspecialcharscustom($this->input->post($this->security->xss_clean('account_note')));
        $given_amount = htmlspecialcharscustom($this->input->post($this->security->xss_clean('given_amount')));
        $change_amount = htmlspecialcharscustom($this->input->post($this->security->xss_clean('change_amount')));

        if($account_type == 'Cash' && $account_type != ''){
            $p_note = htmlspecialcharscustom($this->input->post($this->security->xss_clean('p_note')));
            if($p_note != ''){
                $acc_type['p_note'] = $p_note;
            }
        }elseif($account_type == 'Bank_Account' && $account_type != ''){
            $check_issue_date = htmlspecialcharscustom($this->input->post($this->security->xss_clean('check_issue_date')));
            $check_no = htmlspecialcharscustom($this->input->post($this->security->xss_clean('check_no')));
            $check_expiry_date = htmlspecialcharscustom($this->input->post($this->security->xss_clean('check_expiry_date')));
            if($check_issue_date != ''){
                $acc_type['check_issue_date'] = $check_issue_date;
            }
            if($check_no != ''){
                $acc_type['check_no'] = $check_no;
            }
            if($check_expiry_date != ''){
                $acc_type['check_expiry_date'] = $check_expiry_date;
            }
        }elseif($account_type == 'Card' && $account_type != ''){
            $card_holder_name = htmlspecialcharscustom($this->input->post($this->security->xss_clean('card_holder_name')));
            $card_holding_number = htmlspecialcharscustom($this->input->post($this->security->xss_clean('card_holding_number')));
            if($card_holder_name != ''){
                $acc_type['card_holder_name'] = $card_holder_name;
            }
            if($card_holding_number != ''){
                $acc_type['card_holding_number'] = $card_holding_number;
            }
        }elseif($account_type == 'Mobile_Banking' && $account_type != ''){
            $mobile_no = htmlspecialcharscustom($this->input->post($this->security->xss_clean('mobile_no')));
            $transaction_no = htmlspecialcharscustom($this->input->post($this->security->xss_clean('transaction_no')));
            if($mobile_no != ''){
                $acc_type['mobile_no'] = $mobile_no;
            }
            if($transaction_no != ''){
                $acc_type['transaction_no'] = $transaction_no;
            }
        }elseif($account_type == 'Paypal' && $account_type != ''){
            $paypal_email = htmlspecialcharscustom($this->input->post($this->security->xss_clean('paypal_email')));
            if($paypal_email != ''){
                $acc_type['paypal_email'] = $paypal_email;
            }
        }elseif($account_type == 'Stripe' && $account_type != ''){
            $stripe_email = htmlspecialcharscustom($this->input->post($this->security->xss_clean('stripe_email')));
            if($stripe_email != ''){
                $acc_type['stripe_email'] = $stripe_email;
            }
        }
        $order_details = json_decode($this->input->post('order'));
        $sale_edit_id = trim_checker($order_details->sale_id);
        $sale_old_id = $this->custom->encrypt_decrypt($sale_edit_id, 'decrypt');
        $note = htmlspecialcharscustom($this->input->post($this->security->xss_clean('note')));
        $charge_type = htmlspecialcharscustom($this->input->post($this->security->xss_clean('charge_type')));
        $data = array();
        $sub_total_discount_finalize = $this->input->post($this->security->xss_clean('sub_total_discount_finalize'));
        $data['customer_id'] = trim_checker($order_details->customer_id);
        $data['employee_id'] = trim_checker($order_details->select_employee_id);
        $data['total_items'] = trim_checker($order_details->total_items_in_cart);
        $data['sub_total'] = trim_checker($order_details->sub_total);
        $data['sale_date'] = date("Y-m-d",strtotime(trim_checker($order_details->sale_date1)));
        $data['vat'] = trim_checker($order_details->total_vat);
        $data['total_payable'] = trim_checker($order_details->total_payable);
        $data['grand_total'] = trim_checker($order_details->total_payable);
        $data['total_item_discount_amount'] = trim_checker($order_details->total_item_discount_amount);
        $data['sub_total_with_discount'] = trim_checker($order_details->sub_total_with_discount);
        $data['sub_total_discount_amount'] = (int)($order_details->sub_total_discount_amount) ?? 0 + (int)$sub_total_discount_finalize ?? 0;
        $data['total_discount_amount'] = (int)$order_details->total_discount_amount ?? 0 + (int)$sub_total_discount_finalize ?? 0;
        $data['delivery_charge'] = trim_checker($order_details->delivery_charge);
        $data['sub_total_discount_value'] = trim_checker($order_details->sub_total_discount_value);
        $data['sub_total_discount_type'] = trim_checker($order_details->sub_total_discount_type);
        $data['account_type'] = trim_checker($account_type);
        $data['note'] = trim_checker($note);
        $data['charge_type'] = trim_checker($charge_type);
        if(!empty($acc_type)){
            $data['payment_method_type'] = json_encode($acc_type);
        }
        $delivery_partner = trim_checker($order_details->delivery_partner);
        if($delivery_partner){
            $data['delivery_partner_id'] = $delivery_partner;
            $data['delivery_status'] = 'Sent';
        }else{
            $data['delivery_status'] = 'Cash Received';
        }
        $data['rounding'] = trim_checker($order_details->rounding);
        $data['user_id'] = $this->session->userdata('user_id');
        $data['outlet_id'] = $this->session->userdata('outlet_id');
        $data['company_id'] = $this->session->userdata('company_id');
        $data['date_time'] = date('Y-m-d H:i:s');
        $data['order_date_time'] = date("Y-m-d H:i:s");
        $data['added_date'] = date("Y-m-d H:i:s");
        $data['order_time'] = date("H:i:s");
        $data['sale_vat_objects'] = json_encode($order_details->sale_vat_objects);
        $data['previous_due'] = $finalize_previous_due;
        $data['paid_amount'] = $paid_amount;
        $data['due_amount'] = $due_amount;
        $data['change_amount'] = $change_amount;
        $data['given_amount'] = $given_amount;
        $data['account_note'] = $account_note;
        $data['close_time'] = date('H:i:s');
        $this->db->trans_begin();
        if($sale_old_id > 0){
            $this->db->where('id', $sale_old_id);
            $this->db->update('tbl_sales', $data);
            $this->db->delete('tbl_sales_details', array('sales_id' => $sale_old_id));
            $this->db->delete('tbl_combo_item_sales', array('sale_id' => $sale_old_id));
            $this->db->delete('tbl_sale_payments', array('sale_id' => $sale_old_id));
            $sale_no = str_pad($sale_old_id, 6, '0', STR_PAD_LEFT);
            $sales_id = $sale_old_id;
            $is_new_item = 'No';
        }else{
            $is_new_item = 'Yes';
            $data['random_code'] = trim_checker($order_details->random_code);
            $this->db->insert('tbl_sales', $data);
            $sales_id = $this->db->insert_id();
            // INV No Make
            $invoice_prefix = $this->session->userdata('invoice_prefix');
            $inv_no_start_from = $this->session->userdata('inv_no_start_from');
            $sale_no = str_pad($sales_id, 6, '0', STR_PAD_LEFT);
            if($inv_no_start_from){
                $generated_sale_no = ((int)$inv_no_start_from - 1) + (int)$sale_no;
                $inv_no = $invoice_prefix.$generated_sale_no;
            }else{
                $inv_no = $invoice_prefix.$sale_no;
            }
            $sale_no_update_array = array('sale_no' => $inv_no);
            $this->db->where('id', $sales_id);
            $this->db->update('tbl_sales', $sale_no_update_array);
        }
        if($sales_id > 0 && count($order_details->items) > 0){
            $promo_parnt_id = '';
            foreach($order_details->items as $item){
                if($item->is_promo_item == "Yes"){
                    $p_price = 0;
                }else{
                    $p_price = getLastThreePurchaseAmount($item->item_id, '');
                }
                $item_data['food_menu_id'] = $item->item_id;
                $item_data['qty'] = trim_checker($item->item_quantity);
                $item_data['menu_price_without_discount'] = trim_checker($item->item_price_without_discount);
                $item_data['menu_price_with_discount'] = trim_checker($item->item_price_with_discount);
                $item_data['item_seller_id'] = trim_checker($item->item_seller_id);
                $item_data['expiry_imei_serial'] = trim_checker($item->expiry_imei_serial);
                $item_data['item_type'] = trim_checker($item->item_type);
                $item_data['menu_unit_price'] = trim_checker($item->item_unit_price);
                $item_data['purchase_price'] = trim_checker($p_price);
                $item_data['menu_taxes'] = trim_checker($item->item_vat);
                $item_data['menu_discount_value'] = trim_checker($item->item_discount);
                $item_data['discount_type'] = trim_checker($item->discount_type);
                $item_data['menu_note'] = trim_checker($item->item_description);
                $item_data['discount_amount'] = trim_checker($item->item_discount_amount);
                $item_data['is_promo_item'] = trim_checker($item->is_promo_item);
                $item_data['promo_parent_id'] = trim_checker($promo_parnt_id);
                $item_data['sales_id'] = trim_checker($sales_id);
                if($delivery_partner){
                    $item_data['delivery_status'] = 'Sent';
                }else{
                    $item_data['delivery_status'] = 'Cash Received';
                }
                if($customer_name != 'Walk-in Customer'){
                    $item_data['loyalty_point_earn'] = ($item->item_quantity * getLoyaltyPointByFoodMenu($item->item_id,''));
                }
                $item_data['user_id'] = $this->session->userdata('user_id');
                $item_data['outlet_id'] = $this->session->userdata('outlet_id');
                $item_data['company_id'] = $this->session->userdata('company_id');
                $item_data['del_status'] = 'Live';
                $this->db->insert('tbl_sales_details', $item_data);
                $sale_details_item_id = $this->db->insert_id();
                if($item->is_promo_item_exist){
                    $promo_parnt_id = $this->db->insert_id();
                }else{
                    $promo_parnt_id = '';
                }

                if($item->combo_item){
                    $combo_arr = [];
                    foreach($item->combo_item as $combo){
                        $combo_arr['sale_id'] = $sales_id;
                        $combo_arr['combo_sale_item_id'] = $sale_details_item_id;
                        $combo_arr['show_in_invoice'] = $combo->show_in_invoice;
                        $combo_arr['combo_item_id'] = $combo->combo_item_id;
                        $combo_arr['combo_item_qty'] = $combo->combo_item_qty;
                        $combo_arr['combo_item_price'] = $combo->combo_item_price;
                        $combo_arr['combo_item_seller_id'] = isset($combo->combo_item_seller) ? $combo->combo_item_seller : NULL;
                        $combo_arr['outlet_id'] = $this->session->userdata('outlet_id');
                        $combo_arr['user_id'] = $this->session->userdata('user_id');
                        $combo_arr['company_id'] = $this->session->userdata('company_id');
                        $combo_arr['del_status'] = 'Live';
                        $this->db->insert('tbl_combo_item_sales', $combo_arr);
                    }
                }


            }
        }


        // Get Sale Info
        $sale_details = $this->Common_model->getDataById($sales_id, "tbl_sales");

        if($fiscal_printer_status == 'ON'){
            //add variable for fiscal data
            $fiscal_data = '#*3#'.($this->session->userdata('user_id')).'#'.($this->session->userdata('full_name')).'#'.$sale_details->sale_no.'#'.$sale_details->id.'##0#';
            $fiscal_data .= '#!'.$sale_details->sale_no.'#'. $this->session->userdata('tax_title') . ' ' . ($this->session->userdata('tax_registration_no')).'##'.$this->session->userdata('business_name').'#'.($this->session->userdata('outlet_name')).'#'.($this->session->userdata('address')).'#'.(getSupperAdminName()).'#'.($this->session->userdata('full_name')).'#'.($this->session->userdata('phone')).'#'.($this->session->userdata('outlet_email')).'#';
            $ordera_details = $this->Common_model->getDataCustomName("tbl_sales_details","sales_id", $sales_id);
            foreach($ordera_details as $va){
                $fiscal_data .= '#^'.($va->food_menu_id).'#'.(getItemNameById($va->food_menu_id)).' '.($va->qty).'#'.($va->menu_price_without_discount).'#1.000#2#0#';
            }
        }

        // Multi Currency Payment AND Multy Payment
        $currency_type = htmlspecialcharscustom($this->input->post('is_multi_currency'));
        $multi_currency = htmlspecialcharscustom($this->input->post('multi_currency'));
        $multi_currency_rate = htmlspecialcharscustom($this->input->post('multi_currency_rate'));
        $multi_currency_amount = htmlspecialcharscustom($this->input->post('multi_currency_amount'));
        // This variable could not be escaped because this is json content
        $payment_object = $_POST['payment_object'];
        // $payment_details = $_POST['paymentAccountDetails'];
        $payment_note = $this->input->post($this->security->xss_clean('paymentAccountDetails'));
        if(isset($payment_object)){
            if($currency_type == 1){
                $data = array();
                $data['payment_id'] = getPaymentIdByPaymentName('Cash');
                $data['payment_name'] = "Cash";
                $data['amount'] = $multi_currency_amount;
                $data['multi_currency'] = $multi_currency;
                $data['multi_currency_rate'] = $multi_currency_rate;
                $data['currency_type'] = $currency_type;
                $data['date'] = date('Y-m-d');
                $data['added_date'] = date('Y-m-d H:i:s');
                $data['sale_id'] = $sales_id;
                $data['outlet_id'] = $this->session->userdata('outlet_id');
                $data['user_id'] = $this->session->userdata('user_id');
                $data['company_id'] = $this->session->userdata('company_id');
                $this->Common_model->insertInformation($data, "tbl_sale_payments");
                if($fiscal_printer_status == 'ON'){
                    $fiscal_data .= '#$2#Cash#1.0000#'.$multi_currency_amount.'#';
                }
            }else{
                $pk = 0;
                $payment_details = json_decode($payment_object);
                foreach ($payment_details as $value){
                    $data = array();
                    $data['payment_id'] = $value->payment_id;
                    $data['payment_name'] = $value->payment_name;
                    $data['amount'] = $value->amount;
                    $data['date'] = date('Y-m-d');
                    $data['added_date'] = date('Y-m-d H:i:s');
                    $data['sale_id'] = $sales_id;
                    if($value->payment_name == 'Loyalty Point'){
                        $data['usage_point'] = $value->usage_point;
                        $previous_id_update_array = array('loyalty_point_earn' => 0);
                        $this->db->where('sales_id', $sales_id);
                        $this->db->update('tbl_sales_details', $previous_id_update_array);
                    }
                    $data['payment_details'] = $payment_note[$pk];
                    $data['outlet_id'] = $this->session->userdata('outlet_id');
                    $data['user_id'] = $this->session->userdata('user_id');
                    $data['company_id'] = $this->session->userdata('company_id');
                    $this->Common_model->insertInformation($data, "tbl_sale_payments");
                    $pk++;
                    if($fiscal_printer_status == 'ON'){
                        $fiscal_data .= '#$'.$value->payment_id.'#'.$value->payment_name.'#1.0000#'.$value->amount.'#';
                    }
                }
            }
        }
        $this->db->trans_complete();
        $customer_info = getCustomeInfo(trim_checker($order_details->customer_id));
        $sale_obj = $this->get_all_information_of_a_sale($sales_id);
        $outlet_info = $this->Common_model->getCurrentOutlet();
        $smsMessage =  lang('Dear') . ' ' . $customer_info->name .", " . lang('recently_purchased_message') .  ' ' . $outlet_info->outlet_name . ' ' . lang('Your_Invoice_No') . ": ". $sale_obj->sale_no.", " . lang('amount') . ": ".getAmtPCustom($sale_obj->grand_total).", " . lang('paid') . ": ".getAmtPCustom($sale_obj->paid_amount).", " . lang('due') . ": ".getAmtPCustom($sale_obj->due_amount). ' ' . lang('on') . ' ' . $sale_obj->date_time . ' ' . lang('Thank_you_for_shopping_with_us') . ' ' . $outlet_info->outlet_name ." ". $outlet_info->phone;
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();

            $whatsapp_url = '';
            if($send_invoice_whatsapp == "on"){
                //send whatsapp message for invoice
                sendWhatsAppMessge($customer_info->phone, $smsMessage);
            }

            $re = array();
            $re['sales_id'] = $this->custom->encrypt_decrypt($sales_id, 'encrypt');
            $re['whatsapp_url'] = $whatsapp_url;
            $re['sales_next_ref'] = str_pad($sales_id + 1, 6, '0', STR_PAD_LEFT);

            if($send_invoice_email == "on"){
                $outlet_info = $this->Common_model->getCurrentOutlet();
                $sale_obj = $this->get_all_information_of_a_sale($sales_id);
                $pdfContent = array();
                $pdfContent['outlet_info'] = $outlet_info;
                $pdfContent['sale_object'] = $sale_obj;
                $customer_id = $pdfContent['sale_object']->customer_id;
                $pdfContent['customer_info'] = $this->Common_model->getCustomerById($customer_id);
                $sale_no = $pdfContent['sale_object']->sale_no.'.pdf';
                $mpdf = new \Mpdf\Mpdf();
                $html = $this->load->view('PDF/sale-invoice-pdf', $pdfContent, true);
                $mpdf->WriteHTML($html);
                if(createDirectory('uploads/sale-invoice-pdf')){
                    $mpdf->Output('uploads/sale-invoice-pdf/'. $sale_no);
                    $customer_info = $pdfContent['customer_info'];
                    if($customer_info->email){
                        $mail_data = [];
                        $mail_data['to'] = ["$customer_info->email"];
                        $mail_data['subject'] = 'Thank You for Your Recent Purchase!';
                        $mail_data['customer_name'] = $customer_info->name;
                        $mail_data['company_id'] = $this->session->userdata('company_id');
                        $mail_data['file_name'] = 'Attachment.pdf';
                        $file_v_path = base_url() . 'uploads/sale-invoice-pdf/' . $sale_no;
                        $file_v_path2 = ('uploads/sale-invoice-pdf/' . $sale_no);
                        $mail_data['file_path'] = $file_v_path;
                        $mail_data['template'] = $this->load->view('mail-template/sale-invoice-template', $mail_data, TRUE);
                        $company = getCompanyInfo();
                        if($company->smtp_enable_status == 1){
                            if($company->smtp_type == "Sendinblue"){
                                sendInBlue($mail_data);
                            }else{
                                sendEmailOnly($mail_data['subject'],$mail_data['template'],$customer_info->email,$file_v_path2,$mail_data['file_name'], $company->id);
                            }
                        }else{
                            $this->session->set_flashdata('exception_1', lang('your_smtp_not_configured'));
                        }
                    }
                } else {
                    echo "Something went wrong";
                }
            }
            //update fiscal invoice data on path uploads/fiscal-invoice/
            if($fiscal_printer_status == 'ON'){
                addFiscalInvoiceData($fiscal_data);
            }
            if($send_invoice_sms == "on"){
                if($customer_info->phone != ''){
                    smsSendOnly($smsMessage, $customer_info->phone);
                }
            }
            $re['is_new_item'] = $is_new_item;
            echo json_encode($re);
        }
    }

    /**
     * a4InvoicePDF
     * @access public
     * @param int
     * @return void
     */
    public function a4InvoicePDF($sale_id){
        $sale_id = $this->custom->encrypt_decrypt($sale_id, 'decrypt');
        $pdfContent = array();
        $pdfContent['outlet_info'] = $this->Common_model->getCurrentOutlet();
        $pdfContent['sale_object'] = $this->get_all_information_of_a_sale($sale_id);
        $customer_id = $pdfContent['sale_object']->customer_id;
        $sale_no = $pdfContent['sale_object']->sale_no.'.pdf';
        $pdfContent['customer_info'] = $this->Common_model->getCustomerById($customer_id);
        $mpdf = new \Mpdf\Mpdf();
        $html = $this->load->view('sale/a4_invoice_pdf',$pdfContent,true);
        $mpdf->WriteHTML($html);
        $mpdf->Output($sale_no, "D");
    }


    /**
     * print_invoice
     * @access public
     * @param int
     * @return void
     */
    function print_invoice($sale_id){
        if(ctype_digit($sale_id)){
            $sale_id = $sale_id;
        }else{
            $sale_id = $this->custom->encrypt_decrypt($sale_id, 'decrypt');
        }
        $print_format = $this->session->userdata('print_format');
        $qrcode_type = $this->session->userdata('qr_code_type');
        $data = array();
        $data['outlet_info'] = $this->Common_model->getCurrentOutlet();
        $data['sale_object'] = $this->get_all_information_of_a_sale($sale_id);
        $customer_id = $data['sale_object']->customer_id;
        $data['customer_info'] = $this->Common_model->getCustomerById($customer_id);
        if($print_format == '56mm' || $print_format == '80mm'){
            $url_patient = base_url().'authentication/qr_code_invoice/'.$data['sale_object']->random_code;
            if($qrcode_type == 'Zatca'){
                $text_json = json_decode($data['sale_object']->sale_vat_objects);
                $text_sum = 0;
                foreach($text_json as $text){
                    $text_sum += (float)($text->tax_field_amount);
                }
                $displayQRCodeAsBase64 = GenerateQrCode::fromArray([
                    new Seller(getUserName($data['sale_object']->user_id)),     
                    new TaxNumber($data['sale_object']->sale_no), 
                    new InvoiceDate($data['sale_object']->sale_date), 
                    new InvoiceTotalAmount($data['sale_object']->total_payable), 
                    new InvoiceTaxAmount($text_sum)
                ])->render();
                $qr_code_info = $displayQRCodeAsBase64;
                list($type, $qr_code_info) = explode(';', $qr_code_info);
                list(, $qr_code_info)      = explode(',', $qr_code_info);
                $qr_code_info_dep = base64_decode($qr_code_info);
                createDirectory('uploads/qr_code');
                file_put_contents("uploads/qr_code/".$sale_id.".png", $qr_code_info_dep);
            }else if($qrcode_type == 'Invoice Link'){
                createDirectory('uploads/qr_code');
                $qr_codes_path = "uploads/qr_code/".$sale_id.".png";
                $this->load->library('phpqrcode/qrlib');
                QRcode::png($url_patient, $qr_codes_path,'', 4, 1);
            }
        }
        if ($print_format == '56mm') {
            $this->load->view('sale/print_invoice56mm', $data);
        }elseif($print_format == '80mm') {
            $this->load->view('sale/print_invoice80mm', $data);
        }elseif($print_format == 'A4 Print'){
            $this->load->view('sale/print_invoice_a4', $data);
        }elseif($print_format == 'Half A4 Print'){
            $this->load->view('sale/print_invoice_ha4', $data);
        }elseif($print_format == 'Letter Head'){
            $this->load->view('sale/print_letter_head', $data);
        }
    }


    /**
     * print_challan
     * @access public
     * @param int
     * @return void
     */
    function print_challan($sale_id){
        if(ctype_digit($sale_id)){
            $sale_id = $sale_id;
        }else{
            $sale_id = $this->custom->encrypt_decrypt($sale_id, 'decrypt');
        }
        $data['outlet_info'] = $this->Common_model->getCurrentOutlet();
        $data['sale_object'] = $this->get_all_information_of_a_sale($sale_id);
        $customer_id = $data['sale_object']->customer_id;
        $data['customer_info'] = $this->Common_model->getCustomerById($customer_id);
        $this->load->view('sale/print_challan_a4',$data);
    }


    /**
     * edit_sale
     * @access public
     * @param int
     * @return void
     */
    public function edit_sale($id){
        $id = hex2bin($id);
        $company_id = $this->session->userdata('company_id');
        $data = array();
        $data['categories'] = $this->Sale_model->getItemCategories($company_id, 'tbl_item_categories');
        $data['units'] = $this->Common_model->getAllByCompanyId($company_id, 'tbl_units');
        $data['customers'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_customers');
        $data['items'] = $this->Stock_model->getItemForPOS('', '', '','','');
        foreach($data['items'] as $key=>$value){
            if(!empty($value->conversion_rate)){
                if($value->conversion_rate==0){
                    $data['items'][$key]->last_purchase_price=getLastPurchaseAmount($value->id)/1;
                }else{
                    $data['items'][$key]->last_purchase_price=round(getLastPurchaseAmount($value->id)/$value->conversion_rate,2);
                }
            }else{
                $data['items'][$key]->last_purchase_price=getLastPurchaseAmount($value->id)/1;
            }
        }
        // previous_ordered_products
        $data['item_categories'] = $this->Sale_model->getAllItemCategories();
        $data['brands'] = $this->Common_model->getAllByCompanyId($company_id, 'tbl_brands');
        $data['suppliers'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_suppliers');
        $data['waiters'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id,'tbl_users');
        $data['denominations'] = $this->Common_model->getDenomination($company_id);
        $data['groups'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_customer_groups');
        $data['autoCode'] = $this->Master_model->generateItemCode();
        $data['sale_id'] = $this->custom->encrypt_decrypt($id, 'encrypt');
        $data['sale_item'] = $this->Common_model->getSaleById($id);
        $data['sale_item_details'] = $this->Common_model->getSaleDetailsBySaleById($id);
        $data['payment_methods'] = $this->Sale_model->getAllPaymentMethodsForPOS();
        $this->load->view('sale/POS/main_screen', $data);
    }


    /**
     * deleteSale
     * @access public
     * @param int
     * @return void
     */
    public function deleteSale($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        if($this->session->userdata('role') == '1'){
            $isDeleted = $this->delete_specific_order_by_sale_id($id);
            if($isDeleted){
                $this->session->set_flashdata('exception', lang('delete_success'));
                redirect('Sale/sales');
            }else{
                $this->session->set_flashdata('exception_2', lang('Something_went_wrong'));
                redirect('Sale/sales');
            }
        }else{
            $this->session->set_flashdata('exception_2', lang('Only_admin_is_allowed_to_delete_sale'));
            redirect('Sale/sales');
        }
    }

    /**
     * sales
     * @access public
     * @param no
     * @return void
     */
    public function sales() {
        //end check access function
        $outlet_id = $this->session->userdata('outlet_id');
        $data = array();
        $data['lists'] = $this->Sale_model->getSaleList($outlet_id);
        $data['payment_methods'] = $this->Sale_model->getAllPaymentMethods();
        $data['main_content'] = $this->load->view('sale/sales', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    /**
     * getAjaxData
     * @access public
     * @param no
     * @return json
     */
    public function getAjaxData() {
        $outlet_id = $this->session->userdata('outlet_id');
        $delivery_status = htmlspecialcharscustom($this->input->post('delivery_status'));
        $sales = $this->Sale_model->make_datatables($outlet_id, $delivery_status);
        $data = array();
        if ($sales && !empty($sales)) {
            $i = count($sales);
        }
        foreach ($sales as $value){

            $html = '';
            if ($this->session->userdata('role') == '1'||checkAccess(138,'delete')){ 
                $html .= '<a class="delete btn btn-danger" href="'.base_url().'Sale/deleteSale/'. $this->custom->encrypt_decrypt($value->id, 'encrypt') .'" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="'.lang('delete').'">
                    <i class="fa-regular fa-trash-can"></i>
                </a>';
            }

            $delivery_html = '';
            $delivery_html='';
            $delivery_html .= '<div data_id="' . escape_output($value->id) . '">
                <div class="form-group ' . (($value->delivery_status == 'Cash Received' || $value->delivery_status == 'Returned' ) ? 'pointer-events-none' : '') . '">
                    <select name="delivery_status" id="delivery_status_trigger" class="form-control select2">
                        <option ' . ($value->delivery_status == 'Sent' ? 'selected' : '') . ' value="Sent">' . lang('Sent') . '</option>
                        <option ' . ($value->delivery_status == 'Returned' ? 'selected' : '') . ' value="Returned">' . lang('Returned') . '</option>
                        <option ' . ($value->delivery_status == 'Cash Received' ? 'selected' : '') . ' value="Cash Received">' . lang('Cash_Received') . '</option>
                    </select>
                </div>
            </div>';
            $sub_array =  array();
            $sub_array[] = $i--;
            $sub_array[] = $value->sale_no;
            $sub_array[] = dateFormat($value->date_time);
            $sub_array[] = $value->customer_name;
            $sub_array[] = getAmtCustom($value->total_payable);
            $sub_array[] = $delivery_html;
            $sub_array[] = $value->full_name;
            $sub_array[] = dateFormat($value->added_date);
            $sub_array[] =  '
            <div class="btn_group_wrap">
                <a class="btn btn-deep-purple view_challan" href="javascript:void(0)" sale_id="'. $this->custom->encrypt_decrypt($value->id, 'encrypt') .'" data-bs-toggle="tooltip" data-bs-placement="top"
                data-bs-original-title="'. lang('Challan') .'">
                    <i class="fas fa-print"></i>
                </a>
                <a class="btn btn-unique view_invoice" href="javascript:void(0)" sale_id="'. $this->custom->encrypt_decrypt($value->id, 'encrypt') .'" data-bs-toggle="tooltip" data-bs-placement="top"
                data-bs-original-title="'. lang('print_invoice') .'">
                    <i class="fas fa-print"></i>
                </a>
                <a class="btn btn-cyan pdf_invoice" href="javascript:void(0)" sale_id="'. $this->custom->encrypt_decrypt($value->id, 'encrypt') .'" data-bs-toggle="tooltip" data-bs-placement="top"
                data-bs-original-title="'. lang('download_invoice') .'">
                    <i class="fas fa-download"></i>
                </a>
                <a class="btn btn-warning edit_sale" href="'.base_url().'Sale/edit_sale/'.bin2hex($value->id).'/" sale_id="'.$value->id.'"  data-bs-toggle="tooltip" data-bs-placement="top"
                data-bs-original-title="'. lang('Edit_Sale') .'">
                    <i class="far fa-edit"></i>
                </a>
                '.$html.'
            </div>';
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->Sale_model->getDrawData()),
            "recordsTotal" => $this->Sale_model->get_all_data($outlet_id, $delivery_status),
            "recordsFiltered" => $this->Sale_model->get_filtered_data($outlet_id, $delivery_status),
            "data" => $data
        );
        echo json_encode($output);
    }



    /**
     * deliveryStatusChange
     * @access public
     * @param no
     * @return void
     */
    public function deliveryStatusChange(){
        $id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('get_id')));
        $type = htmlspecialcharscustom($this->input->post($this->security->xss_clean('type_val')));
        $data = array();
        $data_details = array();
        $data['delivery_status'] = $type;
        $data_details['delivery_status'] = $type;
        $this->session->set_flashdata('exception', lang('insertion_success'));
        $this->Common_model->updateInformation($data, $id, 'tbl_sales');
        $this->Common_model->updateInformationByCompanyId($data, $id, 'tbl_sales');
        $this->Common_model->updateInformationByColumn($data_details, $id, 'sales_id', 'tbl_sales_details');
        redirect('Sale/sales');
    }





    /**
     * getVariationByItemId
     * @access public
     * @param no
     * @return json
     */
    public function getVariationByItemId(){
        $item_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('item_id')));
        $result = $this->Common_model->getVariationByItemId($item_id);
        $response = [
            'status' => 'success',
            'data' => $result,
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    /**
     * getComboItemCheck
     * @access public
     * @param no
     * @return json
     */
    public function getComboItemCheck(){
        $item_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('item_id')));
        $result = [];
        $result['combo_items'] = $this->Common_model->getComboItemCheck($item_id);
        $result['sellers'] = $this->Common_model->getSalaryUsers();
        $response = [
            'status' => 'success',
            'data' => $result,
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }


    /**
     * stockCheckingForThisOutletById
     * @access public
     * @param no
     * @return json
     */
    public function stockCheckingForThisOutletById(){
        $item_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('item_id')));
        $result = $this->Common_model->stockCheckingForThisOutletById($item_id);
        $response = [
            'status' => 'success',
            'data' => $result,
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }


    /**
     * getIMEISerial
     * @access public
     * @param no
     * @return json
     */
    public function getIMEISerial(){
        $item_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('item_id')));
        $item_type = htmlspecialcharscustom($this->input->post($this->security->xss_clean('item_type')));
        $result = $this->Common_model->getIMEINumber($item_id, $item_type);
        $response = [
            'status' => 'success',
            'data' => $result,
        ];	
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    /**
     * checkingExisOrNotIMEISerial
     * @access public
     * @param no
     * @return json
     */
    public function checkingExisOrNotIMEISerial(){
        $item_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('item_id')));
        $item_type = htmlspecialcharscustom($this->input->post($this->security->xss_clean('item_type')));
        $result = $this->Common_model->checkingExisOrNotIMEISerial($item_id, $item_type);
        $response = [
            'status' => 'success',
            'data' => $result,
        ];	
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    /**
     * getIMEISerialByOutlet
     * @access public
     * @param no
     * @return json
     */
    public function getIMEISerialByOutlet(){
        $item_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('item_id')));
        $outlet_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('outlet_id')));
        $result = $this->Common_model->getIMEISerialByOutlet($item_id, $outlet_id);
        $response = [
            'status' => 'success',
            'data' => $result,
        ];	
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    /**
     * getExpiryByOutlet
     * @access public
     * @param no
     * @return json
     */
    public function getExpiryByOutlet(){
        $item_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('item_id')));
        $result = $this->Common_model->getExpiryByOutlet($item_id);
        $response = [
            'status' => 'success',
            'data' => $result,
        ];	
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    /**
     * singleExpiryDateStockCheck
     * @access public
     * @param no
     * @return json
     */
    public function singleExpiryDateStockCheck(){
        $item_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('item_id')));
        $expiry_date = htmlspecialcharscustom($this->input->post($this->security->xss_clean('expiry_imei_serial')));
        $result = $this->Common_model->singleExpiryDateStockCheck($item_id, $expiry_date);
        $response = [
            'status' => 'success',
            'data' => $result,
        ];	
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }


    /**
     * getTotalLoyaltyPoint
     * @access public
     * @param no
     * @return int
     */
    public function getTotalLoyaltyPoint(){
        $customer_id = json_decode($this->input->post('customer_id'));
        $customer_name = json_decode($this->input->post('customer_name'));
        if($customer_name == 'Walk-in Customer'){
            $data['status'] = false;
            $data['alert_txt'] = lang('loyalty_point_not_applicable_for_walk_in_customer');
        }else{
            $data['status'] = true;
        }
        $return_data = getTotalLoyaltyPoint($customer_id,$this->session->userdata('outlet_id'));
        $available_point = $return_data[1];
        $data['total_point'] = $available_point;
        echo json_encode($data);
    }


    /**
     * getAllCustomers
     * @access public
     * @param no
     * @return json
     */
    function getAllCustomers(){
        $result = $this->Common_model->getAllCustomersWithOpeningBalance();
        $response = [
            'status' => 'success',
            'data' => $result,
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    /**
     * findCustomerCreditLimit
     * @access public
     * @param int
     * @return json
     */
    public function findCustomerCreditLimit($customer_id=''){
        $data['credit_limit'] = $this->Common_model->findCustomerCreditLimit($customer_id);
        $data['due_amount'] = getCustomerDue($customer_id);
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }




    /**
     * couponCodeValidate
     * @access public
     * @param no
     * @return json
     */
    public function couponCodeValidate(){
        $date = date('Y-m-d');
        $couponCode = htmlspecialcharscustom($this->input->post($this->security->xss_clean('couponCode')));
        $getCoupon = checkCouponDiscountWithinDatePOS($date);
        if($getCoupon){
            if($getCoupon->coupon_code == $couponCode){
                $response = [
                    'status' => 'success',
                    'data' => $getCoupon->discount,
                ];	
                $this->output->set_content_type('application/json')->set_output(json_encode($response));
            }else{
                $response = [
                    'status' => 'error',
                    'message' => 'The Coupon code is not matched!',
                ];	
                $this->output->set_content_type('application/json')->set_output(json_encode($response));
            }
        }else{
            $response = [
                'status' => 'error',
                'message' => 'The Coupon applying date is over!',
            ];	
            $this->output->set_content_type('application/json')->set_output(json_encode($response));
        }
    }


    /**
     * checUserDiscountPermission
     * @access public
     * @param int
     * @return json
     */
    public function checUserDiscountPermission(){
        $date = date('Y-m-d');
        $discount_permission_code = htmlspecialcharscustom($this->input->post($this->security->xss_clean('discount_permission_code')));
        $user_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('user_id')));
        $getDiscount = checUserDiscountPermission($date, $user_id);
        if($getDiscount){
            if($user_id == '1'){
                $response = [
                    'status' => 'success',
                    'data' => $getDiscount->discount_amt,
                ];	
                $this->output->set_content_type('application/json')->set_output(json_encode($response));
            }else{
                if($getDiscount->discount_permission_code == $discount_permission_code){
                    $response = [
                        'status' => 'success',
                        'data' => $getDiscount->discount_amt,
                    ];	
                    $this->output->set_content_type('application/json')->set_output(json_encode($response));
                }else{
                    $response = [
                        'status' => 'error',
                        'message' => 'The Discount code is not matched!',
                    ];	
                    $this->output->set_content_type('application/json')->set_output(json_encode($response));
                }
            }
        }else{
            $response = [
                'status' => 'error',
                'message' => 'The Discount code applying date is over!',
            ];	
            $this->output->set_content_type('application/json')->set_output(json_encode($response));
        }
    }













    /**
     * check_version_file
     * @access public
     * @param no
     * @return string
     */
    public function check_version_file(){
        $version = htmlspecialcharscustom($this->input->post($this->security->xss_clean('version')));
        $return = file_exists(base_url()."application/controllers/1_0.txt");
        if (file_exists(base_url()."application/controllers/1_0.txt")) {
            echo "ache";
        }else{
            echo base_url()."application/controllers/1_0.txt";
        }
    }
    /**
     * getItemsWithStock
     * @access public
     * @param no
     * @return json
     */
    public function getItemsWithStock(){
        $items = $this->Stock_model->getStock('', '', '','','');
        $javascript_obects = "";
        $tmp_last_purchase_price = 0;
        $output_result = array();
        foreach($items as $single_menus){
            if($single_menus->last_purchase_price){
                $tmp_last_purchase_price = $single_menus->last_purchase_price;
            }else{
                $tmp_last_purchase_price = $single_menus->purchase_price;
            }
            $img_size = "uploads/site_settings/".$single_menus->photo;
            if(file_exists($img_size) && $single_menus->photo!=""){
                $image_path = base_url().'uploads/site_settings/'.$single_menus->photo;
            }else{
                $image_path = base_url().'uploads/site_settings/image_thumb.png';
            }
            $total_installment_sale = 0;
            if(isset($i_sale) && $i_sale=="Yes"){
                $total_installment_sale = $single_menus->total_installment_sale;
            }
            $totalStock1 = $single_menus->total_opening_stock + ($single_menus->total_purchase*$single_menus->conversion_rate) - $total_installment_sale - $single_menus->item_sold - $single_menus->total_damage - $single_menus->total_purchase_return + $single_menus->total_sale_return;
            $arr = array();
            if($totalStock1  && $totalStock1>0){
                $current_stock =  $totalStock1." ".$single_menus->sale_unit_name;
            }else{
                $current_stock = "0 ".$single_menus->sale_unit_name;
            }
            $arr = array();
            $arr['item_id'] = $single_menus->id;
            $arr['item_code'] = str_replace("'","",$single_menus->code);
            $arr['category_name'] = str_replace("'","",$single_menus->item_category_name);
            $arr['item_name'] = str_replace("'","",$single_menus->item_name);
            $arr['price'] = $this->session->userdata('currency')." ".$single_menus->sale_price;
            $arr['sale_unit_name'] = str_replace("'","",$single_menus->sale_unit_name);
            $arr['image'] = $image_path;
            $arr['tax_information'] = $single_menus->tax_information;
            $arr['sold_for'] = $single_menus->item_sold;
            $arr['item_type'] = $single_menus->type;
            $arr['whole_sale_price'] = $single_menus->whole_sale_price;
            $arr['last_purchase_price'] = $tmp_last_purchase_price;
            $arr['warranty'] = $single_menus->warranty;
            $arr['guarantee'] = $single_menus->guarantee;
            $arr['current_stock'] = $current_stock;
            $arr['brand_name'] = getBrand($single_menus->brand_id)?" - ".getBrand($single_menus->brand_id):'';
            $output_result[] = $arr;
        }
        echo  json_encode($output_result);
    }
    

    /**
     * getEncriptValue
     * @access public
     * @param no
     * @return json
     */
    function getEncriptValue() {
        $id = $this->custom->encrypt_decrypt($_GET['sales_id'], 'encrypt');
        $data['encriptID'] = $id;
        echo json_encode($data);
    }

    /**
     * getCustomerList
     * @access public
     * @param no
     * @return string
     */
    function getCustomerList() {
        $company_id = $this->session->userdata('company_id');
        $data1 = $this->db->query("SELECT * FROM tbl_customers
            WHERE company_id=$company_id")->result();
        foreach ($data1 as $value) {
            if ($value->name == "Walk-in Customer") {
                echo '<option value="' . $value->id . '" >' . $value->name . '</option>';
            }
        }
        foreach ($data1 as $value) {
            if ($value->name != "Walk-in Customer") {
                echo '<option value="' . $value->id . '" >' . $value->name . ' (' . $value->phone . ')' . '</option>';
            }
        }
        exit;
    }




    /**
     * getItemCode
     * @access public
     * @param no
     * @return json
     */
    public function getItemCode()
    {
        $return_code = $this->Master_model->generateItemCode();
        echo json_encode($return_code);
    }


    /**
     * add_customer_by_ajax
     * @access public
     * @param no
     * @return int
     */
    function add_customer_by_ajax(){
        $dob = explode("-",$this->input->post($this->security->xss_clean('customer_dob')));
        $doa = explode("-",$this->input->post($this->security->xss_clean('customer_doa')));
        $dob2 = explode(" - ",$this->input->post($this->security->xss_clean('customer_dob')));
        $doa2 = explode(" - ",$this->input->post($this->security->xss_clean('customer_doa')));
        $full_dob = null;
        $full_doa = null;
        if(count($dob)==3){
            $full_dob = $dob[2].'-'.$dob[1].'-'.$dob[0];
        }elseif(count($dob2)==3){
            $full_dob = $dob2[2].'-'.$dob2[1].'-'.$dob2[0];
        }
        if(count($doa)==3){
            $full_doa = $doa[2].'-'.$doa[1].'-'.$doa[0];
        }if(count($doa2)==3){
            $full_doa = $doa2[2].'-'.$doa2[1].'-'.$doa2[0];
        }
        $customer_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('customer_id')));
        $data['name'] = trim_checker(getPlanText(htmlspecialcharscustom(escapeQuot($this->input->post($this->security->xss_clean('customer_name'))))));
        $data['phone'] = trim_checker(htmlspecialcharscustom($this->input->post($this->security->xss_clean('customer_phone'))));
        $data['nid'] = trim_checker(htmlspecialcharscustom(escapeQuot($this->input->post($this->security->xss_clean('nid')))));
        $data['email'] = trim_checker($this->input->post($this->security->xss_clean('customer_email')));
        $data['opening_balance'] = trim_checker($this->input->post($this->security->xss_clean('opening_balance')));
        $data['opening_balance_type'] = trim_checker($this->input->post($this->security->xss_clean('opening_balance_type')));
        $data['credit_limit'] = trim_checker($this->input->post($this->security->xss_clean('credit_limit')));
        $data['group_id'] = trim_checker($this->input->post($this->security->xss_clean('group_id')));
        if($full_dob){
            $data['date_of_birth'] = date('Y-m-d',strtotime($full_dob));
        }
        if($full_doa){
            $data['date_of_anniversary'] = date('Y-m-d',strtotime($full_doa));
        }
        $data['address'] = getPlanText($this->input->post($this->security->xss_clean('customer_delivery_address')));
        $data['gst_number'] = $this->input->post($this->security->xss_clean('customer_gst_number'));
        $data['same_or_diff_state'] = $this->input->post($this->security->xss_clean('same_or_diff_state'));

        $discount = $this->input->post($this->security->xss_clean('customer_discount'));
        if($discount == ''){
            $data['discount'] = 0;
        }else{
            $data['discount'] = $this->input->post($this->security->xss_clean('customer_discount'));
        }
                    
        $data['price_type'] = trim_checker($this->input->post($this->security->xss_clean('customer_price_type')));            
        $data['user_id'] = $this->session->userdata('user_id');
        $data['user_id'] = $this->session->userdata('user_id');
        $data['company_id'] = $this->session->userdata('company_id');
        if($customer_id > 0 && $customer_id!=""){
            $this->db->where('id', $customer_id);
            $this->db->update('tbl_customers', $data);
        }else{
            $data['added_date'] = date('Y-m-d H:i:s');
            $this->db->insert('tbl_customers', $data);
            $customer_id = $this->db->insert_id();
        }
        echo $customer_id ;
    }

    public function checkUniqueCustomerMobile(){
        $phone_no = $this->input->post($this->security->xss_clean('customer_phone'));
        $result = $this->db->select('phone')
                   ->where('phone', $phone_no)
                   ->get('tbl_customers')
                   ->row();
        $number_find = $result ? $result->phone : null;
        $response = [
            'status' => 'success',
            'data' => $number_find,
        ];	
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }


    /**
     * get_all_information_of_a_sale_ajax
     * @access public
     * @param no
     * @return json
     */
    function get_all_information_of_a_sale_ajax(){
        $sales_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('sale_id')));
        if(ctype_digit($sales_id)){
            $sale_id = $sales_id;
        }else{
            $sale_id = $this->custom->encrypt_decrypt($sales_id, 'decrypt');
        }
        $sale_object = $this->get_all_information_of_a_sale($sale_id);
        echo json_encode($sale_object);
    }


    /**
     * get_all_information_of_a_sale
     * @access public
     * @param int
     * @return string
     */
    function get_all_information_of_a_sale($sales_id){
        $sales_information = $this->Sale_model->getSaleBySaleId($sales_id);
        $items_by_sales_id = $this->Sale_model->getAllItemsFromSalesDetailBySalesId($sales_id);
        $sale_object = $sales_information;
        $sale_object->items = $items_by_sales_id;
        return $sale_object;
    }
    /**
     * get_new_hold_number_ajax
     * @access public
     * @param no
     * @return int
     */
    function get_new_hold_number_ajax(){
        $outlet_id = $this->session->userdata('outlet_id');
        $user_id = $this->session->userdata('user_id');
        $number_of_holds_of_this_user_and_outlet = $this->get_current_hold();
        $number_of_holds_of_this_user_and_outlet++;
        echo $number_of_holds_of_this_user_and_outlet;
    }


    /**
     * get_current_hold
     * @access public
     * @param no
     * @return int
     */
    function get_current_hold(){
        $outlet_id = $this->session->userdata('outlet_id');
        $user_id = $this->session->userdata('user_id');
        $number_of_holds = $this->Sale_model->getNumberOfHoldsByUserAndOutletId($outlet_id,$user_id);
        return $number_of_holds;
    }


    /**
     * add_hold_by_ajax
     * @access public
     * @param no
     * @return int
     */
    public function add_hold_by_ajax(){
        $outlet_id = $this->session->userdata('outlet_id');
        $order_details = json_decode($this->input->post('order'));
        $hold_number = trim_checker($this->input->post('hold_number'));
        $data = array();
        $data['customer_id'] = trim_checker($order_details->customer_id);
        $data['employee_id'] = trim_checker($order_details->select_employee_id);
        $data['total_items'] = trim_checker($order_details->total_items_in_cart);
        $data['sub_total'] = trim_checker($order_details->sub_total);
        $data['vat'] = trim_checker($order_details->total_vat);
        $data['total_payable'] = trim_checker($order_details->total_payable);
        $data['total_item_discount_amount'] = trim_checker($order_details->total_item_discount_amount);
        $data['sub_total_with_discount'] = trim_checker($order_details->sub_total_with_discount);
        $data['sub_total_discount_amount'] = trim_checker($order_details->sub_total_discount_amount);
        $data['total_discount_amount'] = trim_checker($order_details->total_discount_amount);
        $data['delivery_charge'] = trim_checker($order_details->delivery_charge);
        $data['sub_total_discount_value'] = trim_checker($order_details->sub_total_discount_value);
        $data['sub_total_discount_type'] = trim_checker($order_details->sub_total_discount_type);
        $delivery_partner = trim_checker($order_details->delivery_partner);
        if($delivery_partner){
            $data['delivery_partner_id'] = $delivery_partner;
            $data['delivery_status'] = 'Sent';
        }else{
            $data['delivery_status'] = 'Cash Received';
        }
        $data['outlet_id'] = $outlet_id;
        $data['user_id'] = $this->session->userdata('user_id');
        $data['company_id'] = $this->session->userdata('company_id');
        $data['sale_date'] = date('Y-m-d');
        $data['date_time'] = date('Y-m-d H:i:s');
        $data['added_date'] = date('Y-m-d H:i:s');
        $data['sale_time'] = date('H:i:s');
        $data['sale_vat_objects'] = json_encode($order_details->sale_vat_objects);
        if($hold_number === 0 || $hold_number=== ""){
            $current_hold_order = $this->get_current_hold();
            echo "current hold".$current_hold_order."<br/>";
            $hold_number = $current_hold_order+1;
        }
        $data['hold_no'] = $hold_number;
        $this->db->insert('tbl_holds', $data);
        $holds_id = $this->db->insert_id();
        if($holds_id > 0 && count($order_details->items) > 0){
            foreach($order_details->items as $item){
                $item_data = array();
                $item_data['food_menu_id'] = trim_checker($item->item_id);
                $item_data['item_seller_id'] = trim_checker($item->item_seller_id) ? trim_checker($item->item_seller_id) : 0;
                $item_data['item_type'] = trim_checker($item->item_type);
                $item_data['qty'] = trim_checker($item->item_quantity);
                $item_data['menu_price_without_discount'] = trim_checker($item->item_price_without_discount);
                $item_data['menu_price_with_discount'] = trim_checker($item->item_price_with_discount);
                $item_data['menu_unit_price'] = trim_checker($item->item_unit_price);
                $item_data['menu_taxes'] = trim_checker($item->menu_taxes);
                $item_data['menu_discount_value'] = trim_checker($item->item_discount);
                $item_data['discount_type'] = trim_checker($item->discount_type);
                $item_data['expiry_imei_serial'] = trim_checker($item->expiry_imei_serial);
                if($delivery_partner){
                    $item_data['delivery_status'] = 'Sent';
                }else{
                    $item_data['delivery_status'] = 'Cash Received';
                }
                if($item->promo_item_id){
                    $promo_item = array();
                    $promo_item['promo_item_id'] = trim_checker($item->promo_item_id);
                    $promo_item['promo_item_name'] = trim_checker($item->promo_item_name);
                    $promo_item['promo_item_buy_qty'] = trim_checker($item->promo_item_buy_qty);
                    $promo_item['promo_item_get_qty'] = trim_checker($item->promo_item_get_qty);
                    $promo_item_object = json_encode($promo_item);
                    $item_data['promo_item_object'] = trim_checker($promo_item_object);
                }else{
                    $item_data['promo_item_object'] = '';
                }
                $item_data['menu_note'] = trim_checker($item->menu_note);
                $item_data['discount_amount'] = trim_checker($item->item_discount_amount);
                $item_data['holds_id'] = trim_checker($holds_id);
                $item_data['outlet_id'] = trim_checker($outlet_id);
                $item_data['is_promo_item'] = trim_checker($item->is_promo_item);
                $item_data['added_date'] = date('Y-m-d H:i:s');
                $item_data['user_id'] = $this->session->userdata('user_id');
                $item_data['company_id'] = $this->session->userdata('company_id');
                $item_data['del_status'] = 'Live';
                $this->db->insert('tbl_holds_details', $item_data);
            }
        }
        echo $holds_id;
    }


    /**
     * get_all_holds_ajax
     * @access public
     * @param no
     * @return json
     */
    public function get_all_holds_ajax(){
        $outlet_id = $this->session->userdata('outlet_id');
        $user_id = $this->session->userdata('user_id');
        $holds_information = $this->Sale_model->getHoldsByOutletAndUserId($outlet_id,$user_id);
        echo json_encode($holds_information);
    }


    /**
     * get_last_10_sales_ajax
     * @access public
     * @param no
     * @return json
     */
    public function get_last_10_sales_ajax(){
        $outlet_id = $this->session->userdata('outlet_id');
        $sales_information = $this->Sale_model->getLastTenSalesByOutletAndUserId($outlet_id);
        echo json_encode($sales_information);
    }

    /**
     * get_single_hold_info_by_ajax
     * @access public
     * @param no
     * @return json
     */
    public function get_single_hold_info_by_ajax()
    {
        $hold_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('hold_id')));
        $hold_information = $this->Sale_model->get_hold_info_by_hold_id($hold_id);
        $items_by_holds_id = $this->Sale_model->getAllItemsFromHoldsDetailByHoldsId($hold_id);
        $holds_details_objects = $items_by_holds_id;
        $hold_object = $hold_information[0];
        $hold_object->items = $holds_details_objects;
        echo json_encode($hold_object);
    }



    /**
     * getHoldSaleDetailsById
     * @access public
     * @param no
     * @return json
     */
    public function getFreeItemBySaleDetailsId()
    {
        $hold_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('hold_id')));
        $result = $this->Sale_model->getFreeItemBySaleDetailsId($hold_id);
        $response = [
            'status' => 'Success',
            'data' => $result
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }


    /**
     * delete_all_information_of_hold_by_ajax
     * @access public
     * @param no
     * @return void
     */
    public function delete_all_information_of_hold_by_ajax()
    {
        $hold_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('hold_id')));
        $this->db->delete('tbl_holds', array('id' => $hold_id));
        $this->db->delete('tbl_holds_details', array('holds_id' => $hold_id));
    }


    /**
     * check_customer_address_ajax
     * @access public
     * @param no
     * @return json
     */
    public function check_customer_address_ajax()
    {
        $customer_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('customer_id')));
        $customer_info = $this->Sale_model->getCustomerInfoById($customer_id);
        echo json_encode($customer_info);
    }

    /**
     * get_customer_ajax
     * @access public
     * @param no
     * @return json
     */
    public function get_customer_ajax()
    {
        $customer_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('customer_id')));
        $customer_info = $this->Sale_model->getCustomerInfoById($customer_id);
        echo json_encode($customer_info);
    }

    /**
     * cancel_particular_order_ajax
     * @access public
     * @param no
     * @return void
     */
    public function cancel_particular_order_ajax()
    {
        $sale_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('sale_id')));
        $this->delete_specific_order_by_sale_id($sale_id);
    }


    /**
     * delete_specific_order_by_sale_id
     * @access public
     * @param int
     * @return boolean
     */
    public function delete_specific_order_by_sale_id($sale_id){
        $sale_row =  $this->Common_model->getDataById($sale_id, "tbl_sales");
        $this->db->delete('tbl_sales', array('id' => $sale_id));
        $this->db->delete('tbl_sales_details', array('sales_id' => $sale_id));
        return true;
    }


    /**
     * delete_all_holds_with_information_by_ajax
     * @access public
     * @param no
     * @return int
     */
    public function delete_all_holds_with_information_by_ajax()
    {
        $outlet_id = $this->session->userdata('outlet_id');
        $user_id = $this->session->userdata('user_id');
        $this->db->delete('tbl_holds', array('user_id' => $user_id,'outlet_id' => $outlet_id));
        $this->db->delete('tbl_holds_details', array('user_id' => $user_id,'outlet_id' => $outlet_id));
        echo 1;
    }

    /**
     * change_date_of_a_sale_ajax
     * @access public
     * @param no
     * @return void
     */
    public function change_date_of_a_sale_ajax()
    {
        $sale_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('sale_id')));
        $change_date = htmlspecialcharscustom($this->input->post($this->security->xss_clean('change_date')));
        $data['sale_date'] = date('Y-m-d',strtotime($change_date));
        $data['order_time'] = date("H:i:s");
        $changes = array(
            'sale_date' => date('Y-m-d',strtotime($change_date)),
            'order_time' => date("H:i:s"),
            'date_time' => date('Y-m-d H:i:s',strtotime($change_date.' '.date("H:i:s")))
        );
        $this->db->where('id', $sale_id);
        $this->db->update('tbl_sales', $changes);
    }


    /**
     * getOpeningBalance
     * @access public
     * @param no
     * @return int
     */
    public function getOpeningBalance(){
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $date = date('Y-m-d');
        $getOpeningBalance = $this->Sale_model->getOpeningBalance($user_id,$outlet_id,$date);
        return $getOpeningBalance->amount;
    }


    /**
     * getOpeningDateTime
     * @access public
     * @param no
     * @return string
     */
    public function getOpeningDateTime(){
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $date = date('Y-m-d');
        $getOpeningDateTime = $this->Sale_model->getOpeningDateTime($user_id,$outlet_id,$date);
        return isset($getOpeningDateTime->opening_date_time) && $getOpeningDateTime->opening_date_time?$getOpeningDateTime->opening_date_time:'';
    }


    /**
     * getClosingDateTime
     * @access public
     * @param no
     * @return string
     */
    public function getClosingDateTime(){
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $date = date('Y-m-d');
        $getClosingDateTime = $this->Sale_model->getClosingDateTime($user_id,$outlet_id,$date);
        if(!empty($getClosingDateTime)){
            return $getClosingDateTime->closing_date_time;
        }else{
            return $getClosingDateTime;
        }
    }


    /**
     * getPurchasePaidSum
     * @access public
     * @param no
     * @return int
     */
    public function getPurchasePaidSum(){
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $date = date('Y-m-d');
        $summationOfPaidPurchase = $this->Sale_model->getSummationOfPaidPurchase($user_id,$outlet_id,$date);
        return $summationOfPaidPurchase->purchase_paid;
    }

    /**
     * getSupplierPaymentSum
     * @access public
     * @param no
     * @return int
     */
    public function getSupplierPaymentSum(){
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $date = date('Y-m-d');
        $summationOfSupplierPayment = $this->Sale_model->getSummationOfSupplierPayment($user_id,$outlet_id,$date);
        return $summationOfSupplierPayment->payment_amount;
    }


    /**
     * getCustomerDueReceiveAmountSum
     * @access public
     * @param string
     * @return int
     */
    public function getCustomerDueReceiveAmountSum($date){
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $summationOfCustomerDueReceive = $this->Sale_model->getSummationOfCustomerDueReceive($user_id,$outlet_id,$date);
        return $summationOfCustomerDueReceive->receive_amount;
    }

    /**
     * getPurchaseAmountSum
     * @access public
     * @param string
     * @return int
     */
    public function getPurchaseAmountSum($date){
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $data_result = $this->Sale_model->getPurchaseAmountSum($user_id,$outlet_id,$date);
        return $data_result->amount;
    }

    /**
     * getPurchaseReturnAmountSum
     * @access public
     * @param string
     * @return int
     */
    public function getPurchaseReturnAmountSum($date){
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $data_result = $this->Sale_model->getPurchaseReturnAmountSum($user_id,$outlet_id,$date);
        return $data_result->amount;
    }

    /**
     * getSaleReturnAmountSum
     * @access public
     * @param string
     * @return int
     */
    public function getSaleReturnAmountSum($date){
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $data_result = $this->Sale_model->getSaleReturnAmountSum($user_id,$outlet_id,$date);
        return $data_result->amount;
    }


    /**
     * getExpenseAmountSum1
     * @access public
     * @param string
     * @return int
     */
    public function getExpenseAmountSum1($date){
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $getExpenseAmountSum = $this->Sale_model->getExpenseAmountSum1($user_id,$outlet_id,$date);
        return $getExpenseAmountSum->amount;
    }

    /**
     * getSalePaidSum
     * @access public
     * @param string
     * @return int
     */
    public function getSalePaidSum($date){
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $getSalePaidSum = $this->Sale_model->getSalePaidSum($user_id,$outlet_id,$date);
        return $getSalePaidSum->amount;
    }

    /**
     * getSaleDueSum
     * @access public
     * @param string
     * @return int
     */
    public function getSaleDueSum($date){
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $getSaleDueSum = $this->Sale_model->getSaleDueSum($user_id,$outlet_id,$date);
        return $getSaleDueSum->amount;
    }


    /**
     * getSaleInCashSum
     * @access public
     * @param string
     * @return int
     */

    public function getSaleInCashSum($date){
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $getSaleInCashSum = $this->Sale_model->getSaleInCashSum($user_id,$outlet_id,$date);
        return $getSaleInCashSum->amount;
    }


    /**
     * getDownPaymentSum
     * @access public
     * @param string
     * @return int
     */
    public function getDownPaymentSum($date){
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $getDownPaymentSum = $this->Sale_model->getDownPaymentSum($user_id,$outlet_id,$date);
        return $getDownPaymentSum->amount;
    }


    /**
     * getInstallmentPaidAmountSum
     * @access public
     * @param string
     * @return int
     */
    public function getInstallmentPaidAmountSum($date){
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $getInstallmentPaidAmountSum = $this->Sale_model->getInstallmentPaidAmountSum($user_id,$outlet_id,$date);
        return $getInstallmentPaidAmountSum->amount;
    }

    /**
     * getSaleInPaypalSum
     * @access public
     * @param string
     * @return int
     */
    public function getSaleInPaypalSum($date){
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $getSaleInPaypalSum = $this->Sale_model->getSaleInPaypalSum($user_id,$outlet_id,$date);
        return $getSaleInPaypalSum->amount;
    }


    /**
     * getSaleReportByPayments
     * @access public
     * @param string
     * @return object
     */
    public function getSaleReportByPayments($date){
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $getSaleReportByPayments = $this->Sale_model->getSaleReportByPayments($user_id,$outlet_id,$date);
        return $getSaleReportByPayments;
    }
    /**
     * checkAccess
     * @access public
     * @param no
     * @return json
     */
    public function checkAccess(){
        $controller = $_GET['controller'];
        $function = $_GET['function'];
        echo json_encode(checkAccess($controller,$function));
    }


    /**
     * getSaleInStripeSum
     * @access public
     * @param no
     * @return int
     */
    public function getSaleInStripeSum(){
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $date = date('Y-m-d');
        $getSaleInStripeSum = $this->Sale_model->getSaleInStripeSum($user_id,$outlet_id,$date);
        return $getSaleInStripeSum->amount;
    }


 
    /**
     * todaysSummary
     * @access public
     * @param no
     * @return json
     */
    public function todaysSummary()
    {
        $todaysSummary = $this->Sale_model->todaysSummary();
        $response = [
            'status' => 'success',
            'data' => $todaysSummary,
        ];	
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }



    /**
     * registerDetailCalculationToShow
     * @access public
     * @param no
     * @return array
     */
    public function registerDetailCalculationToShow(){
        $register_content = json_decode($this->session->userdata('register_content'));
        $opening_date_time = $this->getOpeningDateTime();
        if($opening_date_time == 0){
            return $opening_date_time;
        }
        $opening_details = $this->getOpeningDetails();
        $opening_details_decode = json_decode($opening_details);
        $html_content = '<table id="datatable" class="table_register_details top_margin_15"> 
                <thead>
                    <tr>
                        <th class="w-17 text-start">'.lang('user').'</th>
                        <th class="w-35 font-normal">'.$this->session->userdata('full_name').'</th>
                        <th class="w-31"></th>
                        <th class="w-17"></th>
                    </tr> 
                </thead>
                <tbody>
                    <tr>
                        <th>'.lang('Time_Range').'</th>
                        <th class="font-normal">'.(date("Y-m-d h:m:s A",strtotime($opening_date_time))).' to '.(date("Y-m-d h:i:s A")).'</th>
                        <th></th>
                        <th></th>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <th>&nbsp;</th>
                        <th class="text_right">&nbsp;</th>
                    </tr>
                    <tr>
                        <th>'.lang('sn').'</th>
                        <th>'.lang('payment_method').'</th>
                        <th>'.lang('Transactions').'</th>
                        <th>'.lang('amount').'</th>
                    </tr>';
                    $array_p_name = array();
                    $array_p_amount = array();
                    if(isset($opening_details_decode) && $opening_details_decode){
                        foreach ($opening_details_decode as $key=>$value){
                            $key++;
                            $payments = explode("||",$value);
                            $opening_balance = $payments[2];
                            
                            if ($register_content->register_purchase === "Purchase") {
                                $total_purchase = $this->Sale_model->getAllPurchaseByPayment($opening_date_time,$payments[0]);
                            }else{
                                $total_purchase = 0;
                            }
                            if ($register_content->register_purchase_return === "Purchase Return") {
                                $total_purchase_return = $this->Sale_model->getAllPurchaseReturnByPayment($opening_date_time,$payments[0]);
                            }else{
                                $total_purchase_return = 0;
                            }
                            if ($register_content->register_supplier_payment === "Supplier Payment") {
                                $total_due_payment = $this->Sale_model->getAllDuePaymentByPayment($opening_date_time,$payments[0]);
                            }else{
                                $total_due_payment = 0;
                            }
                            if ($register_content->register_customer_due_receive === "Customer Due Receive") {
                                $total_due_receive = $this->Sale_model->getAllDueReceiveByPayment($opening_date_time,$payments[0]);
                            }else{
                                $total_due_receive = 0;
                            }
                            
                            if ($register_content->register_expense === "Expense") {
                                $total_expense = $this->Sale_model->getAllExpenseByPayment($opening_date_time,$payments[0]);
                            }else{
                                $total_expense = 0;
                            }
                            if ($register_content->register_sale === "Sale") {
                                $total_sale =  $this->Sale_model->getAllSaleByPayment($opening_date_time,$payments[0]);
                            }else{
                                $total_sale = 0;
                            }
                            if ($register_content->register_installment_down_payment === "Installment Down Payment") {
                                $down_payment = $this->Sale_model->getAllDownPayment($opening_date_time,$payments[0]);
                            }else{
                                $down_payment = 0;
                            }
                            if ($register_content->register_installment_collection === "Installment Collection") {
                                $installment_collection = $this->Sale_model->getAllInstallmentCollectionPayment($opening_date_time,$payments[0]);
                            }else{
                                $installment_collection = 0;
                            }
                            if ($register_content->register_sale_return === "Sale Return") {
                                $refund_amount = $this->Sale_model->getAllRefundByPayment($opening_date_time,$payments[0]);
                            }else{
                                $refund_amount = 0;
                            }
                            if ($register_content->register_servicing === "Servicing") {
                                $servicing = $this->Sale_model->getAllServicingAmount($opening_date_time,$payments[0]);
                            }else{
                                $servicing = 0;
                            }

                            $inline_total = $opening_balance - $total_purchase + $total_sale  + $total_due_receive - $total_due_payment - $total_expense + $refund_amount + $down_payment + $servicing + $installment_collection;
                            $array_p_name[] = $payments[1];
                            $array_p_amount[] = $inline_total;

                           
                            $html_content .= '<tr>
                                <td>'.$key.'</td>
                                <td>'.$payments[1].'</td>
                                <td>'.lang('op_balance_register').'</td>
                                <td>'.getAmtCustom($opening_balance).'</td>
                            </tr>';
                            
                            if ($register_content->register_purchase === "Purchase") {
                                $html_content .='<tr>
                                    <td></td>
                                    <td></td>
                                    <td>'.lang('purchase_register').'</td>
                                    <td>'.getAmtCustom($total_purchase).'</td>
                                </tr>';
                            }
                            if ($register_content->register_purchase_return === "Purchase Return") {
                                $html_content .='<tr>
                                    <td></td>
                                    <td></td>
                                    <td>'.lang('purchase_return_register').'</td>
                                    <td>'.getAmtCustom($total_purchase_return).'</td>
                                </tr>';
                            }
                            if ($register_content->register_supplier_payment === "Supplier Payment") {
                                $html_content .= '<tr>
                                    <td></td>
                                    <td></td>
                                    <td>'.lang('supplier_payment_register').'</td>
                                    <td>'.getAmtCustom($total_due_payment).'</td>
                                </tr>';
                            }
                            if ($register_content->register_sale === "Sale") {
                                $html_content .='<tr>
                                    <td></td>
                                    <td></td>
                                    <td>'.lang('sale_register_plus').'</td>
                                    <td>'.getAmtCustom($total_sale).'</td>
                                </tr>';

                                if($payments[0] == 2):
                                    $total_sale_mul_c_rows =  $this->Sale_model->getAllSaleByPaymentMultiCurrencyRows($opening_date_time,$payments[0]);
                                    if($total_sale_mul_c_rows){
                                        foreach ($total_sale_mul_c_rows as $value1):
                                            $html_content .= '<tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td>&nbsp;&nbsp;&nbsp;&nbsp;'.$value1->multi_currency.'</td>
                                                        <td>'.getAmtCustom($value1->total_amount).'</td>
                                                    </tr>';
                                        endforeach;
                                    }
                                endif;
                            }
                            if ($register_content->register_customer_due_receive === "Customer Due Receive") {
                                $html_content .= '<tr>
                                    <td></td>
                                    <td></td>
                                    <td>'.lang('customer_due_receive_register').'</td>
                                    <td>'.getAmtCustom($total_due_receive).'</td>
                                </tr>';
                            }
                            
                            if ($register_content->register_expense === "Expense") {
                                $html_content .= '<tr>
                                    <td></td>
                                    <td></td>
                                    <td>'.lang('expense_register').'</td>
                                    <td>'.getAmtCustom($total_expense).'</td>
                                </tr>';
                            }
                            if ($register_content->register_sale_return === "Sale Return") {
                                $html_content .= '<tr>
                                    <td></td>
                                    <td></td>
                                    <td>'.lang('sale_return_register').'</td>
                                    <td>'.getAmtCustom($refund_amount).'</td>
                                </tr>';
                            }
                            if ($register_content->register_installment_down_payment === "Installment Down Payment") {
                                $html_content .= '<tr>
                                    <td></td>
                                    <td></td>
                                    <td>'.lang('down_payment_register').'</td>
                                    <td>'.getAmtCustom($down_payment).'</td>
                                </tr>';
                            }
                            if ($register_content->register_installment_collection === "Installment Collection") {
                                $html_content .= '<tr>
                                    <td></td>
                                    <td></td>
                                    <td>'.lang('installment_collection_register').'</td>
                                    <td>'.getAmtCustom($installment_collection).'</td>
                                </tr>';
                            }

                            if ($register_content->register_servicing === "Servicing") {
                                $html_content .= '<tr>
                                    <td></td>
                                    <td></td>
                                    <td>'.lang('servicing_register').'</td>
                                    <td>'.getAmtCustom($servicing).'</td>
                                </tr>';
                            }
                            $html_content .= '<tr>
                                <td></td>
                                <td></td>
                                <th>'.lang('closing_balance').'</th>
                                <th>'.getAmtCustom($inline_total).'</th>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                            </tr>';
                        }
                    }
                    $html_content .= '<tr>
                        <th></th>
                        <th></th>
                        <th>'.lang('summary').'</th>
                        <th></th>
                    </tr>';
                    foreach ($array_p_name as $key=>$value){
                        $html_content .= '<tr>
                            <th></th>
                            <th></th>
                            <th>'.$value.'</th>
                            <th>'.getAmtCustom($array_p_amount[$key]).'</th>
                        </tr>';
                    }
                $html_content.='</tbody>
        </table>';
        $register_detail = array(
            'opening_date_time' => date('Y-m-d h:m A', strtotime($opening_date_time)),
            'closing_date_time' => $this->getClosingDateTime(),
            'html_content_for_div' => $html_content,
        );
        return $register_detail;
    }


    /**
     * getOpeningDetails
     * @access public
     * @param no
     * @return array
     */
    public function getOpeningDetails(){
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $date = date('Y-m-d');
        $getOpeningDetails = $this->Sale_model->getOpeningDetails($user_id,$outlet_id,$date);
        return isset($getOpeningDetails->opening_details) && $getOpeningDetails->opening_details?$getOpeningDetails->opening_details:'';
    }


    /**
     * registerDetailCalculationToShowAjax
     * @access public
     * @param no
     * @return json
     */
    public function registerDetailCalculationToShowAjax(){
        $all_register_info_values = $this->registerDetailCalculationToShow();
        echo json_encode($all_register_info_values);
    }

    /**
     * closeRegister
     * @access public
     * @param no
     * @return void
     */
    public function closeRegister(){
        $register_content = json_decode($this->session->userdata('register_content'));

        $register_status = array();
        $register_status['register_status'] = 2;
        $this->session->set_userdata($register_status);
        $company_id = $this->session->userdata('company_id');
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $opening_date_time = $this->getOpeningDateTime();
        $opening_details= $this->getOpeningDetails();
        $opening_details_decode = json_decode($opening_details);
        $total_closing = 0;
        $total_sale_all = 0;
        $total_sale_return_all = 0;
        $total_purchase_all = 0;
        $total_purchase_return_all = 0;
        $total_due_receive_all = 0;
        $total_due_payment_all = 0;
        $total_expense_all = 0;
        $total_servicing_all = 0;
        $total_downpayment_all = 0;
        $total_installmentcollection_all = 0;
        $payment_details = array();
        $others_currency = array();
        foreach ($opening_details_decode as $key=>$value){
            $payments = explode("||",$value);

            $opening_balance = $payments[2];
            
            if ($register_content->register_purchase === "Purchase") {
                $total_purchase = $this->Sale_model->getAllPurchaseByPayment($opening_date_time,$payments[0]);
            }else{
                $total_purchase = 0;
            }
            if ($register_content->register_purchase_return === "Purchase Return") {
                $total_purchase_return = $this->Sale_model->getAllPurchaseByReturn($opening_date_time,$payments[0]);
            }else{
                $total_purchase_return = 0;
            }
            if ($register_content->register_customer_due_receive === "Customer Due Receive") {
                $total_due_receive = $this->Sale_model->getAllDueReceiveByPayment($opening_date_time,$payments[0]);
            }else{
                $total_due_receive = 0;
            }
            if ($register_content->register_supplier_payment === "Supplier Payment") {
                $total_due_payment = $this->Sale_model->getAllDuePaymentByPayment($opening_date_time,$payments[0]);
            }else{
                $total_due_payment = 0;
            }
            if ($register_content->register_expense === "Expense") {
                $total_expense = $this->Sale_model->getAllExpenseByPayment($opening_date_time,$payments[0]);
            }else{
                $total_expense = 0;
            }
            if ($register_content->register_sale === "Sale") {
                $total_sale =  $this->Sale_model->getAllSaleByPayment($opening_date_time,$payments[0]);
            }else{
                $total_sale = 0;
            }
            if ($register_content->register_installment_down_payment === "Installment Down Payment") {
                $down_payment = $this->Sale_model->getAllDownPayment($opening_date_time,$payments[0]);
            }else{
                $down_payment = 0;
            }
            if ($register_content->register_installment_collection === "Installment Collection") {
                $installment_collection = $this->Sale_model->getAllInstallmentCollectionPayment($opening_date_time,$payments[0]);
            }else{
                $installment_collection = 0;
            }
            if ($register_content->register_sale_return === "Sale Return") {
                $refund_amount = $this->Sale_model->getAllRefundByPayment($opening_date_time,$payments[0]);
            }else{
                $refund_amount = 0;
            }
            if ($register_content->register_servicing === "Servicing") {
                $servicing = $this->Sale_model->getAllServicingAmount($opening_date_time,$payments[0]);
            }else{
                $servicing = 0;
            }

            if($payments[0] == 2):
                $total_sale_mul_c_rows =  $this->Sale_model->getAllSaleByPaymentMultiCurrencyRows($opening_date_time,$payments[0]);
                if($total_sale_mul_c_rows){
                    foreach ($total_sale_mul_c_rows as $value1):
                        $tmp_arr = array();
                        $tmp_arr['payment_name'] = $value1->multi_currency;
                        $tmp_arr['amount'] = getAmtCustom($value1->total_amount);
                        $others_currency[] = $tmp_arr;
                    endforeach;
                }
           endif;

            $total_sale_all += $total_sale;
            $total_sale_return_all += $refund_amount;
            $total_purchase_all += $total_purchase;
            $total_purchase_return_all += $total_purchase_return;
            $total_due_receive_all += $total_due_receive;
            $total_due_payment_all += $total_due_payment;
            $total_expense_all += $total_expense;
            $total_servicing_all += $servicing;
            $total_downpayment_all += $down_payment;
            $total_installmentcollection_all += $installment_collection;
            $inline_closing = ($opening_balance - $total_purchase + $total_sale  + $total_due_receive - $total_due_payment - $total_expense + $refund_amount + $down_payment + $servicing + $installment_collection);
            $total_closing += $inline_closing;
            $preview_amount = isset($payment_details[$payments[1]]) && $payment_details[$payments[1]]?$payment_details[$payments[1]]:0;
            $payment_details[$payments[1]] = $preview_amount + $inline_closing;
        }

        $changes = array(
            'closing_balance' => $total_closing,
            'closing_balance_date_time' => date("Y-m-d H:i:s"),
            'customer_due_receive' => $total_due_receive_all,
            'total_purchase' => $total_purchase_all,
            'total_servicing' => $total_servicing_all,
            'total_downpayment' => $total_downpayment_all,
            'total_installmentcollection' => $total_installmentcollection_all,
            'total_purchase_return' => $total_purchase_return_all,
            'total_due_payment' => $total_due_payment_all,
            'total_expense' => $total_expense_all,
            'sale_paid_amount' => $total_sale_all,
            'refund_amount' => $total_sale_return_all,
            'payment_methods_sale' => json_encode($payment_details),
            'others_currency' => json_encode($others_currency),
            'register_status' => 2
        );
        $this->db->where('outlet_id', $outlet_id);
        $this->db->where('user_id', $user_id);
        $this->db->where('company_id', $company_id);
        $this->db->where('opening_balance_date_time', $opening_date_time);
        $this->db->where('register_status', 1);
        $this->db->update('tbl_register', $changes);
        $this->session->unset_userdata('print_format');
        $this->session->unset_userdata('characters_per_line');
        $this->session->unset_userdata('printer_ip_address');
        $this->session->unset_userdata('printer_port');
        $this->session->unset_userdata('qr_code_type');
        $this->session->unset_userdata('invoice_print');
        $this->session->unset_userdata('print_server_url_invoice');
        $this->session->unset_userdata('inv_qr_code_status');
    }


    /**
     * stripePayment
     * @access public
     * @param no
     * @return json
     */
    public function stripePayment(){
        $payment_credentials = getCompanyPaymentMethod();
        $secret = $payment_credentials->stripe_api_key;
        try {
            $amount = $this->input->post('amount');
            if ($amount == 0 || $amount < 0) {
                echo json_encode(['status' => 'error', 'message' => 'Amount is required']);
                return;
            }
            Stripe::setApiKey($secret);
            $response = Charge::create([
                "amount" => $amount * 100,
                "currency" => "usd",
                "source" => $this->input->post('token'),
                "description" => "Sale Payment",
            ]);
            echo json_encode($response);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
    /**
     * stripePayment
     * @access public
     * @param no
     * @return json
     */
    public function stripeMainPayment(){
        $payment_credentials = getMainCompanyPaymentMethod();
        $secret = $payment_credentials->stripe_api_key;
        try {
            $amount = $this->input->post('amount');
            if ($amount == 0 || $amount < 0) {
                echo json_encode(['status' => 'error', 'message' => 'Amount is required']);
                return;
            }
            Stripe::setApiKey($secret);
            $response = Charge::create([
                "amount" => $amount * 100,
                "currency" => "usd",
                "source" => $this->input->post('token'),
                "description" => "Sale Payment",
            ]);
            echo json_encode($response);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    /**
     * paypalPayment
     * @access public
     * @param no
     * @return json
     */
    public function paypalMainPayment(){
        $payment_credentials = getMainCompanyPaymentMethod();
        $info = $this->input->post('info');
        $amount = $this->input->post('amount');
        if ($amount == 0 || $amount < 0) {
            echo json_encode(['status' => 'error', 'code' => 701, 'message' => 'Amount is required']);
            return;
        }
        $gateway = Omnipay::create('PayPal_Express');
        $gateway->setUsername($payment_credentials->paypal_user_name);
        $gateway->setPassword($payment_credentials->paypal_password);
        $gateway->setSignature($payment_credentials->paypal_signature);
        $card = new CreditCard(array(
            'number' => $info['credit_card_no'],
            'expiryMonth' => $info['payment_month'],
            'expiryYear' => $info['payment_year'],
            'cvv' => $info['payment_cvc'],
        ));
        $response = $gateway->purchase(array(
            'amount' => $amount,
            'currency' => 'USD',
            'card' => $card,
            'returnUrl' => 'https: //sandbox.paypal.com',
            'cancelUrl' => 'https: //sandbox.paypal.com',
        ))->send();
        if ($response->isSuccessful()) {
            echo json_encode(['status' => 'success', 'code' => 200, 'message' => $response->getMessage()]);
        }  elseif ($response->isRedirect()) {
            $response->redirect();
        } else {
            echo json_encode(['status' => 'error', 'code' => 300, 'message' => $response->getMessage()]);
        }
    }
}
