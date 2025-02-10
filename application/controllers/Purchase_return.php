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
    # This is Purchase_return Controller
    ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_return extends Cl_Controller {

    /**
     * load constructor
     * @access public
     * @return void
     */    
    public function __construct() {
        parent::__construct();
        
        $this->load->model('Authentication_model');
        $this->load->model('Common_model');
        $this->load->model('Purchase_model');
        $this->load->model('Stock_model');
        $this->load->library('form_validation');
        $this->Common_model->setDefaultTimezone();
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        if (!$this->session->has_userdata('outlet_id')) {
            $this->session->set_flashdata('exception_2',lang('please_click_green_button'));
            $this->session->set_userdata("clicked_controller", $this->uri->segment(1));
            $this->session->set_userdata("clicked_method", $this->uri->segment(2));
            redirect('Outlet/outlets');
        }
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $controller = "211";
        $function = "";
        if(($segment_2=="addEditPurchaseReturn") || ($segment_2 == "stockCheck" || $segment_2 == "getSupplierPurchases" || $segment_2 == "getItemsOfPurchase" || $segment_2 == "getPurchaseItemDetails")){
            $function = "add";
        }elseif(($segment_2=="addEditPurchaseReturn" && $segment_3) || ($segment_2 == "stockCheck" || $segment_2 == "getSupplierPurchases" || $segment_2 == "getItemsOfPurchase" || $segment_2 == "getPurchaseItemDetails")){
            $function = "edit";
        }elseif($segment_2=="purchaseReturnDetails"){
            $function = "view";
        }elseif($segment_2=="deletePurchaseReturn"){
            $function = "delete";
        }elseif($segment_2=="purchaseReturns" || $segment_2 == "getAjaxData"){
            $function = "list";
        }elseif($segment_2=="printInvoice" || $segment_2 == "a4InvoicePDF"){
            $function = "print";
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
        if ($register_content->register_purchase_return != '' && $register_status == 2) {
            $this->session->set_flashdata('exception', lang('please_open_register'));
            $this->session->set_userdata("clicked_controller", $this->uri->segment(1));
            $this->session->set_userdata("clicked_method", $this->uri->segment(2));
            redirect('Register/openRegister');
        }
    }

    
    /**
     * addEditPurchaseReturn
     * @access public
     * @param int
     * @return void
     */
    public function addEditPurchaseReturn($encrypted_id = "") {
        $data = array ();
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        $outlet_id = $this->session->userdata('outlet_id');
        $user_id = $this->session->userdata('user_id');
        $company_id = $this->session->userdata('company_id');
        if ($id == "") {
            $purchase_info['reference_no'] = $this->Purchase_model->generatePurReturnRefNo($outlet_id);
        } else {
            $purchase_info['reference_no'] = $this->Common_model->getDataById($id, "tbl_purchase_return")->reference_no;
        }
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $add_more = $this->input->post($this->security->xss_clean('add_more'));
            $this->form_validation->set_rules('date',lang('date'), 'required|max_length[55]'); 
            $this->form_validation->set_rules('pur_ref_no',lang('pur_ref_no'), 'max_length[55]'); 
            $this->form_validation->set_rules('note',lang('note'), 'max_length[255]'); 
            $status = htmlspecialcharscustom($this->input->post($this->security->xss_clean('status')));
            if($status === 'taken_by_sup_money_returned'){
                $this->form_validation->set_rules('payment_method_id',lang('payment_methods'), 'required|max_length[50]'); 
            }
            if ($this->form_validation->run() == TRUE) {
                $acc_type = array();
                $account_type = htmlspecialcharscustom($this->input->post($this->security->xss_clean('account_type')));
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
                $data = array();
                $data['reference_no'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('reference_no')));
                $data['pur_ref_no'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('pur_ref_no')));
                $data['date'] = $this->input->post($this->security->xss_clean('date'));
                $data['purchase_date'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('purchase_date')));
                $data['supplier_id'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('supplier_id')));
                $data['return_status'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('status')));
                $data['total_return_amount'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('total_return_amount')));
                $data['payment_method_id'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('payment_method_id')));
                $data['account_type'] = $account_type;
                if(!empty($acc_type)){
                    $data['payment_method_type'] = json_encode($acc_type);
                }
                $data['note'] = htmlspecialcharscustom($this->input->post('note'));
                $data['user_id'] = $user_id;
                $data['outlet_id'] = $outlet_id;
                $data['company_id'] = $company_id;
                $status = $this->input->post($this->security->xss_clean('status'));
                if ($id == "") {
                    $data['added_date'] = date('Y-m-d H:i:s');
                    $pur_return_id = $this->Common_model->insertInformation($data, "tbl_purchase_return");
                    $this->savePurchaseReturnDetails($_POST['item_id'], $pur_return_id, $status, 'tbl_purchase_return_details');
                    $this->session->set_flashdata('exception', lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($data, $id, "tbl_purchase_return");
                    $this->Common_model->deletingMultipleFormData('pur_return_id', $id, 'tbl_purchase_return_details');
                    $this->savePurchaseReturnDetails($_POST['item_id'], $id, $status, 'tbl_purchase_return_details');
                    $this->session->set_flashdata('exception',lang('update_success'));
                }
                if($add_more == 'add_more'){
                    redirect('Purchase_return/addEditPurchaseReturn');
                }else{
                    redirect('Purchase_return/purchaseReturns');
                }
            } else {
                if ($id == "") {
                    $data = array();
                    $data['paymentMethods'] = $this->Common_model->getAllPaymentMethod();
                    $data['ref_no'] = $this->Purchase_model->generatePurReturnRefNo($outlet_id);
                    $data['suppliers'] = $this->Common_model->getAllSupplierNameMobile();
                    $data['items'] = $this->Common_model->getItemWithVariationForDrowdown();
                    $data['main_content'] = $this->load->view('purchaseReturn/addPurchaseReturn', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['paymentMethods'] = $this->Common_model->getAllPaymentMethod();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['suppliers'] = $this->Common_model->getAllSupplierNameMobile();
                    $data['purchase_return'] = $this->Common_model->getDataById($id, "tbl_purchase_return");
                    $data['purchase_return_items'] = $this->Purchase_model->getPurchaseReturnItems($id, "tbl_purchase_return_details");
                    $data['items'] = $this->Common_model->getItemWithVariationForDrowdown();
                    $data['main_content'] = $this->load->view('purchaseReturn/editPurchaseReturn', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['paymentMethods'] = $this->Common_model->getAllPaymentMethod();
                $data['ref_no'] = $this->Purchase_model->generatePurReturnRefNo($outlet_id);
                $data['suppliers'] = $this->Common_model->getAllSupplierNameMobile();
                $data['items'] = $this->Common_model->getItemWithVariationForDrowdown();
                $data['main_content'] = $this->load->view('purchaseReturn/addPurchaseReturn', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['paymentMethods'] = $this->Common_model->getAllPaymentMethod();
                $data['encrypted_id'] = $encrypted_id;
                $data['suppliers'] = $this->Common_model->getAllSupplierNameMobile();
                $data['purchase_return'] = $this->Common_model->getDataById($id, "tbl_purchase_return");
                $data['purchase_return_items'] = $this->Purchase_model->getPurchaseReturnItems($id, "tbl_purchase_return_details");
                $data['items'] = $this->Common_model->getItemWithVariationForDrowdown();
                $data['main_content'] = $this->load->view('purchaseReturn/editPurchaseReturn', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    } 


    /**
     * savePurchaseReturnDetails
     * @access public
     * @param string
     * @param int
     * @param string
     * @param string
     * @return void
     */
    public function savePurchaseReturnDetails($purchase_return_items, $pur_return_id, $status, $table_name) {
        foreach ($purchase_return_items as $row => $item_id):
            $fmi = array();
            $fmi['pur_return_id'] = $pur_return_id;
            $fmi['return_status'] = $status;
            $fmi['expiry_imei_serial'] = $_POST['expiry_imei_serial'][$row];
            $fmi['expiry_imei_serial_in'] = $_POST['expiry_imei_serial_in'][$row] ?? '';
            $fmi['return_note'] = $_POST['return_note'][$row];
            $fmi['item_id'] = $_POST['item_id'][$row];
            $fmi['item_type'] = $_POST['item_type'][$row];
            $fmi['return_quantity_amount'] = $_POST['quantity'][$row];
            $fmi['unit_price'] = $_POST['unit_price'][$row];
            $fmi['total'] = $_POST['total'][$row];
            $fmi['user_id'] = $this->session->userdata('user_id');
            $fmi['outlet_id'] = $this->session->userdata('outlet_id');
            $fmi['company_id'] = $this->session->userdata('company_id');
            $this->Common_model->insertInformation($fmi, "tbl_purchase_return_details");
        endforeach;
    }

    
    /**
     * purchaseReturnDetails
     * @access public
     * @param int
     * @return void
     */
    public function purchaseReturnDetails($id){
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $data = array();
        $data['purchase_return'] = $this->Common_model->getDataById($id, "tbl_purchase_return");
        $data['purchase_return_details'] = $this->Common_model->getPurchaseReturnDetailsByReturnId($id, "tbl_purchase_return_details");
        $data['main_content'] = $this->load->view('purchaseReturn/purchaseReturnDetails', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    /**
     * deletePurchaseReturn
     * @access public
     * @param int
     * @return void
     */
    public function deletePurchaseReturn($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $this->Common_model->deleteStatusChangeWithChild($id, $id, "tbl_purchase_return", "tbl_purchase_return_details", 'id', 'pur_return_id');
        $this->session->set_flashdata('exception', lang('delete_success'));
        redirect('Purchase_return/purchaseReturns');
    }

    /**
     * purchaseReturns
     * @access public
     * @param no
     * @return void
     */
    public function purchaseReturns() {
        $company_id = $this->session->userdata('company_id');
        $data = array();
        $data['suppliers'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_suppliers");
        $data['main_content'] = $this->load->view('purchaseReturn/purchaseReturns', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    /**
     * getAjaxData
     * @access public
     * @param no
     * @return json
     */
    public function getAjaxData() {
        $company_id = $this->session->userdata('company_id');
        $supplier_id = htmlspecialcharscustom($this->input->post('supplier_id'));
        $outlet_id = htmlspecialcharscustom($this->input->post('outlet_id'));
        if($outlet_id){
            $outlet_id = $outlet_id;
        }else{
            $outlet_id = $this->session->userdata('outlet_id');
        }
        $status = htmlspecialcharscustom($this->input->post('status'));
        $purchases_return = $this->Purchase_model->make_datatablesForPurchaseReturn($company_id, $outlet_id, $status, $supplier_id);
        if ($purchases_return && !empty($purchases_return)) {
            $i = count($purchases_return);
        }
        $data = array();
        foreach($purchases_return as $purchase){
            $sub_array = array();
            $sub_array[] = $i--;
            $sub_array[] = escape_output($purchase->reference_no);
            $sub_array[] = dateFormat($purchase->date);
            $sub_array[] = escape_output($purchase->supplier_name);
            $sub_array[] = getAmtCustom($purchase->total_return_amount);
            $sub_array[] = escape_output($purchase->note);
            $sub_array[] = escape_output($purchase->added_by);
            $sub_array[] = dateFormat($purchase->added_date);
            $html = '';
            $html .= '<a class="btn btn-deep-purple" href="' . base_url() . 'Purchase_return/printInvoice/' . $this->custom->encrypt_decrypt($purchase->id, 'encrypt') . '" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="' . lang('print_invoice') . '">
            <i class="fas fa-print"></i></a>
            </a>';
            $html .= '<a class="btn btn-unique" href="' . base_url() . 'Purchase_return/a4InvoicePDF/' . $this->custom->encrypt_decrypt($purchase->id, 'encrypt') . '" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="' . lang('download_invoice') . '">
            <i class="fas fa-download"></i>
            </a>';
            $html .= ' <a class="btn btn-cyan" href="'.base_url().'Purchase_return/purchaseReturnDetails/'.($this->custom->encrypt_decrypt($purchase->id, 'encrypt')).'" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="'. lang('view_details') .'"><i class="far fa-eye"></i></a>';
            $html .= ' <a class="btn btn-warning" href="'.base_url().'Purchase_return/addEditPurchaseReturn/'.($this->custom->encrypt_decrypt($purchase->id, 'encrypt')).'" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="'. lang('edit') .'"><i class="far fa-edit"></i></a>';
            $html .= ' <a class="delete btn btn-danger" href="'.base_url().'Purchase_return/deletePurchaseReturn/'.($this->custom->encrypt_decrypt($purchase->id, 'encrypt')).'" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="'. lang('delete') .'"><i class="fa-regular fa-trash-can"></i></a>';
            $sub_array[] = '<div class="btn_group_wrap">
            '.$html.'
            </div>';
            $data[] = $sub_array;
        }
        $output = array(
            "recordsTotal" => $this->Purchase_model->get_all_dataForPurchaseReturn($company_id, $outlet_id, $status, $supplier_id),
            "recordsFiltered" => $this->Purchase_model->get_filtered_dataForPurchaseReturn($company_id, $outlet_id, $status, $supplier_id),
            "data" => $data
        );
        echo json_encode($output);
    }


    /**
     * printInvoice
     * @access public
     * @param int
     * @return void
     */
    public function printInvoice($id){
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $data = array();
        $data['purchase_return'] = $this->Common_model->getDataById($id, "tbl_purchase_return");
        $data['purchase_return_details'] = $this->Common_model->getPurchaseReturnDetailsByReturnId($id, "tbl_purchase_return_details");
        $data['outlet_info'] = $this->Common_model->getCurrentOutlet();
        $data['company_info'] = getCompanyInfo($this->session->userdata('company_id'));
        $this->load->view('purchaseReturn/print_invoice_a4', $data);
    }


    /**
     * a4InvoicePDF
     * @access public
     * @param int
     * @return void
     */
    public function a4InvoicePDF($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $pdfContent = array();
        $pdfContent['purchase_return'] = $this->Common_model->getDataById($id, "tbl_purchase_return");
        $pdfContent['purchase_return_details'] = $this->Common_model->getPurchaseReturnDetailsByReturnId($id, "tbl_purchase_return_details");
        $pdfContent['outlet_info'] = $this->Common_model->getCurrentOutlet();
        $pdfContent['company_info'] = getCompanyInfo($this->session->userdata('company_id'));
        $mpdf = new \Mpdf\Mpdf();
        $html = $this->load->view('purchaseReturn/a4_invoice_pdf',$pdfContent,true);
        $mpdf->WriteHTML($html);
        $mpdf->Output('Purchase Return - Reference No -' . $pdfContent['purchase_return']->reference_no . '.pdf', "D");
    }

    /**
     * stockCheck
     * @access public
     * @param int
     * @return json
     */
    public function stockCheck($id){
        $stock = $this->Stock_model->getStock('', $id, '','','');
        $totalStock = 0;
        if (!empty($stock) && isset($stock)):
            foreach ($stock as $key => $value):
                $i_sale = $this->session->userdata('i_sale');
                $total_installment_sale = 0;
                if(isset($i_sale) && $i_sale=="Yes"){
                    $total_installment_sale = $value->total_installment_sale;
                }
                $totalStock = ($value->total_purchase * $value->conversion_rate) - $total_installment_sale - $value->total_damage - $value->total_sale  - $value->total_purchase_return + $value->total_sale_return  + $value->total_opening_stock;
            endforeach;
        endif;
        echo json_encode($totalStock);
    }




    /**
     * getSupplierPurchases
     * @access public
     * @param no
     * @return string
     */
    public function getSupplierPurchases() {
        $supplier_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('supplier_id')));
        $supplier_purchases = $this->db->query("select id, supplier_id, reference_no, grand_total, date from tbl_purchase where supplier_id='$supplier_id' and del_status='Live'")->result();
        $invoice_dropdown = '<option value="">'.lang('select').'</option>';
        if (!empty($supplier_purchases)) {
            foreach ($supplier_purchases as $value){
                $invoice_dropdown .= '<option value="'. $value->id .'">Inoice: '. $value->reference_no .' Date: '. date($this->session->userdata('date_format'), strtotime($value->date)) .' Grand Total: '. $value->grand_total . $this->session->userdata('currency') .'</option>';
            }
        }
        echo $invoice_dropdown;
    }

    /**
     * BalancgetItemsOfPurchasee_Statement
     * @access public
     * @param no
     * @return string
     */
    public function getItemsOfPurchase() {
        $purchase_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('purchase_id')));
        $purchase_items = $this->db->query("select id,  item_type, expiry_imei_serial, unit_price, quantity_amount, item_id, purchase_id from tbl_purchase_details where purchase_id='$purchase_id' and del_status='Live'")->result();
        $item_dropdown = '<option value="">'.lang('select').'</option>';
        if (!empty($purchase_items)) { 
            foreach ($purchase_items as $value){
                $item_dropdown .= '<option purchase-id="'.$value->purchase_id.'" item_type="'.$value->item_type.'" expiry_imei_serial="'.$value->expiry_imei_serial.'" quantity_amount="'.$value->quantity_amount.'" item_price="'.$value->unit_price.'" item_name="'.foodMenuName($value->item_id).'" value="'. $value->item_id .'">'. foodMenuName($value->item_id) .'</option>';
            }
        }
        echo $item_dropdown;
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

}
