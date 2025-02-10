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
    # This is Purchase Controller
    ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase extends Cl_Controller {
    /**
     * load constructor
     * @access public
     * @return void
     */    
    public function __construct() {
        parent::__construct();
        
        $this->load->model('Authentication_model');
        $this->load->model('Purchase_model');
        $this->load->model('Stock_model');
        $this->load->model('Common_model');
        $this->Common_model->setDefaultTimezone();
        $this->load->library('excel'); //load PHPExcel library
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
        $controller = "";
        $function = "";
        if($segment_2=="addEditPurchase" || $segment_2 == "getStockAlertListForPurchase" || $segment_2 == 'bulkImporForPurchase'){
            $controller = "109";
            $function = "add";
        }elseif($segment_2=="addEditPurchase" && $segment_3 || "getStockAlertListForPurchase" || $segment_2 == 'bulkImporForPurchase'){
            $controller = "109";
            $function = "edit";
        }elseif($segment_2=="purchaseDetails"){
            $controller = "109";
            $function = "view";
        }elseif($segment_2=="deletePurchase"){
            $controller = "109";
            $function = "delete";
        }elseif($segment_2=="purchases" || $segment_2 == "getAjaxData" || $segment_2 == "getPurchasesItems"){
            $controller = "109";
            $function = "list";
        }elseif($segment_2=="printInvoice" || $segment_2 == "a4InvoicePDF" || $segment_2 == "downloadAttachment"){
            $controller = "109";
            $function = "print";
        }elseif($segment_2=="addNewSupplierByAjax" || $segment_2 == "getSupplierBalance"){
            $controller = "117";
            $function = "add";
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
     * addEditPurchase
     * @access public
     * @param int
     * @return void
     */
    public function addEditPurchase($encrypted_id = "") {
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        $outlet_id = $this->session->userdata('outlet_id');
        $company_id = $this->session->userdata('company_id');
        $purchase_info = array();
        if ($id == "") {
            $purchase_info['reference_no'] = $this->Purchase_model->generatePurRefNo($outlet_id);
        } else {
            $purchase_info['reference_no'] = $this->Common_model->getDataById($id, "tbl_purchase")->reference_no;
        }
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $add_more = $this->input->post($this->security->xss_clean('add_more'));
            $this->form_validation->set_rules('reference_no', lang('ref_no'), 'required|max_length[50]');
            $this->form_validation->set_rules('supplier_id', lang('supplier'), 'required|max_length[50]');
            $this->form_validation->set_rules('date', lang('date'), 'required|max_length[50]');
            $this->form_validation->set_rules('note', lang('note'), 'max_length[300]');   
            $this->form_validation->set_rules('paid', lang('paid_amount'), 'numeric|max_length[50]');
            $this->form_validation->set_rules('invoice_no', lang('invoice_no'), 'max_length[100]');
            $this->form_validation->set_rules('attachment', lang('attachment'), 'callback_validate_attachment|max_length[255]');
            if ($this->form_validation->run() == TRUE) {
                $purchase_info['reference_no'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('reference_no')));
                $purchase_info['invoice_no'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('invoice_no')));
                $purchase_info['supplier_id'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('supplier_id')));
                $purchase_info['date'] = $this->input->post($this->security->xss_clean('date'));
                $purchase_info['note'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('note')));
                $purchase_info['other'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('other')));
                $purchase_info['grand_total'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('grand_total')));
                $purchase_info['paid'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('paid')));
                $purchase_info['due_amount'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('due')));
                $purchase_info['note'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('note')));
                $purchase_info['discount'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('discount')));
                $purchase_info['user_id'] = $this->session->userdata('user_id');
                $purchase_info['outlet_id'] = $this->session->userdata('outlet_id');
                $purchase_info['company_id'] = $this->session->userdata('company_id');
                if ($_FILES['attachment']['name'] != "") {
                    $purchase_info['attachment'] = $this->session->userdata('attachment');
                    $this->session->unset_userdata('attachment');
                }else{
                    $purchase_info['attachment'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('attachment_p')));
                }
                if ($id == "") {
                    $purchase_info['added_date'] = date('Y-m-d H:i:s');
                    $purchase_id = $this->Common_model->insertInformation($purchase_info, "tbl_purchase");
                    $this->savePurchaseDetails($_POST['item_id'], $purchase_id, 'tbl_purchase_details');
                    if(isset($_POST['payment_id']) && $_POST['payment_id']){
                        $this->savePaymentMethod($_POST['payment_id'], $purchase_id, 'tbl_purchase_payments');
                    }
                    $this->session->set_flashdata('exception', lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($purchase_info, $id, "tbl_purchase");
                    $this->Common_model->deletingMultipleFormData('purchase_id', $id, 'tbl_purchase_details');
                    $this->savePurchaseDetails($_POST['item_id'], $id, 'tbl_purchase_details');
                    $this->Common_model->deletingMultipleFormData('purchase_id', $id, 'tbl_purchase_payments');
                    if(isset($_POST['payment_id']) && $_POST['payment_id']){
                        $this->savePaymentMethod($_POST['payment_id'], $id, 'tbl_purchase_payments');
                    }
                    $this->session->set_flashdata('exception',lang('update_success'));
                }
                if($add_more == 'add_more'){
                    redirect('Purchase/addEditPurchase');
                }else{
                    redirect('Purchase/purchases');
                }
            } else {
                if ($id == "") {
                    $data = array();
                    $data['pur_ref_no'] = $this->Purchase_model->generatePurRefNo($outlet_id);
                    $data['paymentMethods'] = $this->Common_model->getAllPaymentMethod();
                    $data['suppliers'] = $this->Common_model->getAllSupplierNameMobile();
                    $data['items'] = $this->Common_model->getItemWithVariationForDrowdown();
                    $data['main_content'] = $this->load->view('purchase/addPurchase', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['paymentMethods'] = $this->Common_model->getAllPaymentMethod();
                    $data['purchase_details'] = $this->Common_model->getDataById($id, "tbl_purchase");
                    $data['suppliers'] = $this->Common_model->getAllSupplierNameMobile();
                    $data['items'] = $this->Common_model->getItemWithVariationForDrowdown();
                    $data['purchase_items'] = $this->Purchase_model->getPurchaseItems($id);
                    $data['multi_pay_method'] = $this->Purchase_model->purchasePayments($id);
                    $supplier_id = $data['purchase_details']->supplier_id;
                    $data['previous_due_amount'] = getSupplierDue($supplier_id);
                    $data['main_content'] = $this->load->view('purchase/editPurchase', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['pur_ref_no'] = $this->Purchase_model->generatePurRefNo($outlet_id);
                $data['paymentMethods'] = $this->Common_model->getAllPaymentMethod();
                $data['suppliers'] = $this->Common_model->getAllSupplierNameMobile();
                $data['items'] = $this->Common_model->getItemWithVariationForDrowdown();
                $data['main_content'] = $this->load->view('purchase/addPurchase', $data,TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['paymentMethods'] = $this->Common_model->getAllPaymentMethod();
                $data['purchase_details'] = $this->Common_model->getDataById($id, "tbl_purchase");
                $data['suppliers'] = $this->Common_model->getAllSupplierNameMobile();
                $data['items'] = $this->Common_model->getItemWithVariationForDrowdown();
                $data['purchase_items'] = $this->Purchase_model->getPurchaseItems($id);
                $data['multi_pay_method'] = $this->Purchase_model->purchasePayments($id);
                $supplier_id = $data['purchase_details']->supplier_id;
                $data['previous_due_amount'] = getSupplierDue($supplier_id);
                $data['main_content'] = $this->load->view('purchase/editPurchase', $data,TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }

    

    /**
     * savePurchaseDetails
     * @access public
     * @param string
     * @param int
     * @param string
     * @return void
     */
    public function savePurchaseDetails($purchase_items, $purchase_id, $table_name) {
        foreach ($purchase_items as $row => $item_id):
            $fmi = array();
            $fmi['item_id'] = $_POST['item_id'][$row];
            $fmi['item_type'] = $_POST['item_type'][$row];
            if (isset($_POST['expiry_imei_serial'])){
                $fmi['expiry_imei_serial'] = $_POST['expiry_imei_serial'][$row];
            }
            $fmi['unit_price'] = $_POST['unit_price'][$row];
            if(!empty((int)$_POST['conversion_rate'][$row])){
                $fmi['divided_price'] = round(($_POST['unit_price'][$row]/$_POST['conversion_rate'][$row]), 2);
            }else{
                $fmi['divided_price'] =$_POST['unit_price'][$row] / 1;
            }
            $fmi['quantity_amount'] = $_POST['quantity_amount'][$row];
            $fmi['total'] = $_POST['total'][$row];
            $fmi['purchase_id'] = $purchase_id;
            $fmi['outlet_id'] = $this->session->userdata('outlet_id');
            $fmi['company_id'] = $this->session->userdata('company_id');
            $this->Common_model->insertInformation($fmi, "tbl_purchase_details");
            setAveragePrice($item_id);
        endforeach;
    }

    /**
     * savePaymentMethod
     * @access public
     * @param string
     * @param int
     * @param string
     * @return void
     */
    public function savePaymentMethod($payment_method, $purchase_id, $table_name) {
        foreach ($payment_method as $row => $payment_id):
            $fmi = array();
            $fmi['added_date'] = date('Y-m-d');
            $fmi['purchase_id'] = $purchase_id;
            $fmi['payment_id'] = $_POST['payment_id'][$row];
            $fmi['amount'] = $_POST['payment_value'][$row];
            $fmi['outlet_id'] = $this->session->userdata('outlet_id');
            $fmi['user_id'] = $this->session->userdata('user_id');
            $fmi['company_id'] = $this->session->userdata('company_id');
            $this->Common_model->insertInformation($fmi, $table_name);
        endforeach;
    }

    /**
     * validate_attachment
     * @access public
     * @param no
     * @return void
     */
    public function validate_attachment() {
        if ($_FILES['attachment']['name'] != "") {
            $config['upload_path'] = './uploads/purchase-attachment';
            $config['allowed_types'] = 'jpg|jpeg|png|pdf';
            $config['max_size'] = '1000';
            $config['encrypt_name'] = TRUE;
            $config['detect_mime'] = TRUE;
            $this->load->library('upload', $config);

            if(createDirectory('uploads/purchase-attachment')){
                // Delete the old file if it exists
                $old_file = $this->session->userdata('attachment');
                if ($old_file && file_exists($config['upload_path'] . '/' . $old_file)) {
                    unlink($config['upload_path'] . '/' . $old_file);
                }
                if ($this->upload->do_upload("attachment")) {
                    $upload_info = $this->upload->data();
                    $file_name = $upload_info['file_name'];
                    // Check if the uploaded file is an image before resizing
                    $allowed_image_types = array('jpg', 'jpeg', 'png');
                    $ext = pathinfo($file_name, PATHINFO_EXTENSION);
                    if (in_array(strtolower($ext), $allowed_image_types)) {
                        $config['image_library'] = 'gd2';
                        $config['source_image'] = './uploads/purchase-attachment/' . $file_name;
                        $config['maintain_ratio'] = TRUE;
                        $this->load->library('image_lib', $config);
                        $this->image_lib->resize();
                    }
                    $this->session->set_userdata('attachment', $file_name);
                } else {
                    $this->form_validation->set_message('validate_attachment', $this->upload->display_errors());
                    return FALSE;
                }
            } else {
                echo "Something went wrong";
            }
        }
    }


    /**
     * purchaseDetails
     * @access public
     * @param int
     * @return void
     */
    public function purchaseDetails($id) {
        $encrypted_id = $id;
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $data = array();
        $data['encrypted_id'] = $encrypted_id;
        $data['purchase_details'] = $this->Common_model->getDataById($id, "tbl_purchase");
        $data['multi_pay_method'] = $this->Purchase_model->purchasePayments($id);
        $data['purchase_items'] = $this->Purchase_model->getPurchaseItems($id);
        $data['main_content'] = $this->load->view('purchase/purchaseDetails', $data, TRUE);
        $this->load->view('userHome', $data);
    }


    
    /**
     * deletePurchase
     * @access public
     * @param int
     * @return void
     */
    public function deletePurchase($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $this->Common_model->deleteStatusChangeWithChild($id, $id, "tbl_purchase", "tbl_purchase_details", 'id', 'purchase_id');
        $this->Common_model->deleteStatusChangeByFieldName($id, 'purchase_id', 'tbl_purchase_payments');
        $this->session->set_flashdata('exception', lang('delete_success'));
        redirect('Purchase/purchases');
    }


    /**
     * purchases
     * @access public
     * @param no
     * @return void
     */
    public function purchases() {
        $outlet_id = $this->session->userdata('outlet_id');
        $data = array();
        $data['suppliers'] = $this->Common_model->getAllSupplierNameMobile();
        $data['purchases'] = $this->Common_model->getAllByOutletId($outlet_id, "tbl_purchase");
        $data['main_content'] = $this->load->view('purchase/purchases', $data, TRUE);
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
        $start_date = $_POST['startDate'];
        $endDate = $_POST['endDate'];
        $supplier_id = htmlspecialcharscustom($this->input->post('supplier_id'));
        $outlet_id = htmlspecialcharscustom($this->input->post('outlet_id'));
        
        $purchases = $this->Purchase_model->make_datatables($company_id, $start_date, $endDate, $supplier_id, $outlet_id);
        if ($purchases && !empty($purchases)) {
            $i = count($purchases);
        }
        $data = array();
        foreach($purchases as $purchase){
            $sub_array = array();
            $sub_array[] = $i--;
            $sub_array[] = $purchase->reference_no;
            $sub_array[] = $purchase->invoice_no;
            $sub_array[] = dateFormat($purchase->added_date);
            $sub_array[] = ($purchase->supplier_name);
            $sub_array[] = getAmtCustom($purchase->grand_total);
            $sub_array[] = getAmtCustom($purchase->paid);
            $sub_array[] = getAmtCustom($purchase->due_amount);
            $sub_array[] = ($purchase->added_by);
            $sub_array[] = dateFormat($purchase->added_date);
            $html = '';
            $html .= '<a class="btn btn-unique print_barcode" href="javascript:void(0)" data-id="'. $this->custom->encrypt_decrypt($purchase->id, 'encrypt') .'" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="' . lang('print_barcode') . '">
                <i class="fas fa-print"></i>
            </a>';
            $html .= '<a class="btn btn-deep-purple" href="' . base_url() . 'Purchase/printInvoice/' . $this->custom->encrypt_decrypt($purchase->id, 'encrypt') . '" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="' . lang('print_invoice') . '">
                <i class="fas fa-print"></i>
            </a>';
            $html .= '<a class="btn btn-unique" href="' . base_url() . 'Purchase/a4InvoicePDF/' . $this->custom->encrypt_decrypt($purchase->id, 'encrypt') . '" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="' . lang('download_invoice') . '">
                <i class="fas fa-download"></i>
            </a>';

            if ($purchase->attachment != '') { 
                $html .= '<a class="btn btn-deep-purple" href="' . base_url() . 'Purchase/downloadAttachment/' . $purchase->attachment . '" data-bs-toggle="tooltip" data-bs-placement="top"
                data-bs-original-title="'. lang('download_attachment') .'"><i class="fas fa-download tiny-icon"></i></a>';
            }

            $html .= '<a class="btn btn-cyan" href="' . base_url() . 'Purchase/purchaseDetails/' . $this->custom->encrypt_decrypt($purchase->id, 'encrypt') . '" data-bs-toggle="tooltip" data-bs-placement="top"
                data-bs-original-title="'. lang('view_details') .'">
                <i class="far fa-eye"></i>
            </a>';
            
            $html .= '<a class="btn btn-warning" href="' . base_url() . 'Purchase/addEditPurchase/' . $this->custom->encrypt_decrypt($purchase->id, 'encrypt') . '" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="' . lang('edit') . '">
                <i class="far fa-edit"></i>
            </a>';

            $html .= '<a class="delete btn btn-danger" href="' . base_url() . 'Purchase/deletePurchase/' . $this->custom->encrypt_decrypt($purchase->id, 'encrypt') . '" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="' . lang('delete') . '">
                <i class="fa-regular fa-trash-can"></i>
            </a>';

            $sub_array[] = '
            <div class="btn_group_wrap">
            '.$html.'
            </div>';
            $data[] = $sub_array;
        }
        $output = array(
            "recordsTotal" => $this->Purchase_model->get_all_data($company_id, $start_date, $endDate, $supplier_id, $outlet_id),
            "recordsFiltered" => $this->Purchase_model->get_filtered_data($company_id, $start_date, $endDate, $supplier_id, $outlet_id),
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
    public function printInvoice($id) {
        $encrypted_id = $id;
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $data = array();
        $data['encrypted_id'] = $encrypted_id;
        $data['purchase_details'] = $this->Common_model->getDataById($id, "tbl_purchase");
        $data['purchase_items'] = $this->Purchase_model->getPurchaseItems($id);
        $data['multi_pay_method'] = $this->Purchase_model->purchasePayments($id);
        $data['outlet_info'] = $this->Common_model->getCurrentOutlet();
        $data['company_info'] = getCompanyInfo($this->session->userdata('company_id'));
        $this->load->view('purchase/print_invoice_a4', $data);
    }
    /**
     * a4InvoicePDF
     * @access public
     * @param int
     * @return void
     */
    public function a4InvoicePDF($id) {
        $encrypted_id = $id;
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $pdfContent = array();
        $pdfContent['encrypted_id'] = $encrypted_id;
        $pdfContent['purchase_details'] = $this->Common_model->getDataById($id, "tbl_purchase");
        $pdfContent['purchase_items'] = $this->Purchase_model->getPurchaseItems($id);
        $pdfContent['multi_pay_method'] = $this->Purchase_model->purchasePayments($id);
        $pdfContent['outlet_info'] = $this->Common_model->getCurrentOutlet();
        $pdfContent['company_info'] = getCompanyInfo($this->session->userdata('company_id'));
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
        $html = $this->load->view('purchase/a4_invoice_pdf',$pdfContent,true);
        $mpdf->WriteHTML($html);
        $mpdf->Output('Purchase Reference No -' . $pdfContent['purchase_details']->reference_no . '.pdf', "D");
    }


    /**
     * downloadAttachment
     * @access public
     * @param int
     * @return void
     */
    public function downloadAttachment($file = '') {
        $this->load->helper('download');
        $data = file_get_contents("uploads/purchase-attachment/" . $file); // Read the file's
        $name = $file;
        force_download($name, $data);
    }


    /**
     * addNewSupplierByAjax
     * @access public
     * @param no
     * @return json
     */
    function addNewSupplierByAjax() {
        $fmc_info = array();
        $fmc_info['name'] = ($this->input->post($this->security->xss_clean('name')));
        $fmc_info['contact_person'] = $this->input->post($this->security->xss_clean('contact_person'));
        $fmc_info['phone'] = $this->input->post($this->security->xss_clean('phone'));
        $fmc_info['email'] = $this->input->post($this->security->xss_clean('email'));
        $fmc_info['opening_balance'] = $this->input->post($this->security->xss_clean('opening_balance'));
        $fmc_info['opening_balance_type'] = $this->input->post($this->security->xss_clean('opening_balance_type'));
        $fmc_info['description'] = $this->input->post($this->security->xss_clean('supplier_description'));
        $fmc_info['address'] = $this->input->post($this->security->xss_clean('supplier_address'));
        $fmc_info['added_date'] = date('Y-m-d H:i:s');
        $fmc_info['user_id'] = $this->session->userdata('user_id');
        $fmc_info['company_id'] = $company_id = $this->session->userdata('company_id');
        $id = $this->Common_model->insertInformation($fmc_info, "tbl_suppliers");
        if($id){
            $return_data['id'] = $id;
            $return_data['supplier'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_suppliers');
        }
        echo json_encode($return_data);
    }


    /**
     * getSupplierList
     * @access public
     * @param no
     * @return string
     */
    function getSupplierList() {
        $company_id = $this->session->userdata('company_id');
        $data1 = $this->db->query("SELECT * FROM tbl_suppliers 
              WHERE company_id=$company_id")->result();
        echo '<option value="">'. lang('select') .'</option>';
        foreach ($data1 as $value) {
            echo '<option value="' . $value->id . '" >' . $value->name . '</option>';
        }
    }


    /**
     * getStockAlertListForPurchase
     * @access public
     * @param no
     * @return string
     */
    public function getStockAlertListForPurchase() {
        $supplier_id = $_POST['supplier_id'];
        $stock =  $this->Stock_model->getPullLowStock('', '', '',$supplier_id,'');
        $i = 0;
        $table_row = '';
        if (!empty($stock) && isset($stock)){
            foreach ($stock as $key => $value){
                $i++;
                $p_type = '';
                $date_picker = '';
                $d_none = '';
                $quantity = '';
                $p_placeholder = '';
                $validation_cls = '';

                if($value->type == 'General_Product' || $value->type == 0){
                    $quantity = $value->alert_quantity;
                    $d_none = 'd-none';
                }else if($value->type == 'Variation_Product'){
                    $quantity = $value->alert_quantity;
                    $d_none = 'd-none';
                }else if($value->type == 'Installment_Product'){
                    $quantity = $value->alert_quantity;
                    $d_none = 'd-none';
                }else if ($value->type == 'Medicine_Product'){
                    $p_type = 'Expiry Date:';
                    $p_placeholder = 'Expiry Date';
                    $quantity = $value->alert_quantity;
                    $date_picker = 'customDatepicker';
                    $validation_cls = 'countID2';
                }elseif($value->type == 'IMEI_Product'){
                    $p_type = 'IMEI:';
                    $p_placeholder = 'Enter IMEI Number';
                    $quantity = 1;
                    $validation_cls = 'countID2';
                }elseif($value->type == 'Serial_Product'){
                    $p_type = 'Serial:';
                    $p_placeholder = 'Enter Serial Number';
                    $quantity = 1;
                    $validation_cls = 'countID2';
                }
                $table_row .= '<tr class="rowCount"  data-counter="' . $i . '">
                    <td>
                        <div class="d-flex align-items-center">
                            <p id="sl_' . $i . '">' . $i . '</p>
                        </div>
                        <input type="hidden" name="item_id[]" value="' . $value->id . '"/>
                        <input type="hidden" name="item_type[]" value="'.$value->type.'"/>
                        <input type="hidden" name="conversion_rate[]" value="'.$value->conversion_rate.'"/>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <span>' . getItemNameCodeBrandByItemId($value->id).'</span>
                        </div>
                    </td>
                    
                    <td>
                        <div class="form-group">
                            <div class="d-flex align-items-center">
                                <small class="pe-1">'.$p_type.'</small>
                                <input  data-countid="'.$i.'" type="text" autocomplete="off" id="serial_'.$i.'" name="expiry_imei_serial[]" class="'. $d_none .' form-control '.$validation_cls.' '.$date_picker.'" placeholder="'.$p_placeholder.'">
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="text" autocomplete="off" data-countid="' . $i . '" id="quantity_amount_' . $i . '" name="quantity_amount[]" onfocus="this.select();" class="form-control integerchk countID calculate_op qty_count" value="'.$quantity. '"  placeholder="'. lang('Qty_Amount') .'" aria-describedby="basic-addon2">
                            <span class="input-group-text" id="basic-addon2">' . $value->purchase_unit . '</span>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="d-flex align-items-center">
                                <input type="text" autocomplete="off" data-countid="' . $i . '" id="unit_price_' . $i . '" name="unit_price[]" onfocus="this.select();" class="form-control integerchk1 calculate_op countID" placeholder="'. lang('unit_price') .'" value="'.$value->last_purchase_price.'">
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="d-flex align-items-center">
                                <input type="text" autocomplete="off" id="total_' . $i . '" name="total[]" class="form-control" placeholder="'. lang('Total') .'" readonly="">
                            </div>
                        </div>
                    </td>
                    <td>
                        <button type="button" class="new-btn-danger deleter_op h-40" data-suffix="'.$i.'" data-item_id="'.$value->id.'">
                            <iconify-icon icon="solar:trash-bin-minimalistic-broken" width="18"></iconify-icon>
                        </button>
                    </td>
                </tr>';
                
            }
        }
        echo $table_row;
    }

    /**
     * getCustomerDue
     * @access public
     * @param no
     * @return int
     */
    public function getSupplierBalance() {
        $supplier_id = $_GET['supplier_id']; 
        $remaining_due = getSupplierDue($supplier_id);
        echo $remaining_due;
    }





    /**
     * getPurchasesItems
     * @access public
     * @param no
     * @return json
     */
    public function getPurchasesItems(){
        $purchase_id = $this->input->post($this->security->xss_clean('purchase_id'));
        $id = $this->custom->encrypt_decrypt($purchase_id, 'decrypt');
        $results = $this->db->query("SELECT i.code, i.name as child_name, ii.name as parent_name 
            FROM tbl_purchase_details pd
            LEFT JOIN tbl_items i ON pd.item_id = i.id
            LEFT JOIN tbl_items ii ON i.parent_id = ii.id
            WHERE pd.purchase_id = $id 
            AND pd.del_status = 'Live'
        ")->result();
        $response = [
            'status' => 'success',
            'data' => $results,
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($response));

    }


    /**
     * bulkImporForPurchase
     * @access public
     * @param no
     * @return json
     */
    public function bulkImporForPurchase(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['file'];
                $item_id = $_POST['item_id'];
                $item_type = $_POST['item_type'];
                $parepare_arr = [];
                if ($file['name'] == "Purchase_Bulk_Import.xlsx") {
                    //Path of files were you want to upload on localhost (C:/xampp/htdocs/ProjectName/uploads/excel/
                    $configUpload['upload_path'] = FCPATH . 'assets/upload-sample/excel/';
                    $configUpload['allowed_types'] = 'xlsx';
                    $configUpload['max_size'] = '5000';
                    $this->load->library('upload', $configUpload);
                    if ($this->upload->do_upload('file')) {
                        $upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
                        $file_name = $upload_data['file_name']; //uploded file name
                        $extension = $upload_data['file_ext'];    // uploded file
                        $objReader = PHPExcel_IOFactory::createReader('Excel2007'); // For excel 2007
                        //Set to read only
                        $objReader->setReadDataOnly(true);
                        //Load excel file
                        $objPHPExcel = $objReader->load(FCPATH . 'assets/upload-sample/excel/' . $file_name);
                        $totalrows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();   //Count Numbe of rows avalable in excel
                        $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);

                        $excel_date_unit_arr = [];
                        if ($totalrows >= 4 && $totalrows < 54) {
                            $imei_of_items = getIMEISerial($item_id);
                            $available_imei = '';
                            if($imei_of_items && $imei_of_items->allimei){
                                $available_imei = explode('||', $imei_of_items->allimei);
                            }
                            $arrayerror = '';
                            for ($i = 4; $i <= $totalrows; $i++) {
                                $imei = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(0, $i)->getValue() ?? '')); //Excel Column 0//Required
                                array_push($excel_date_unit_arr, $imei);
                                if($available_imei != ''){
                                    if (in_array($imei, $available_imei)) {
                                        if ($arrayerror == '') {
                                            $arrayerror.= lang('Row_Number') . ' ' . "$i" . ': ' . lang('column_A_already_exist');
                                        }else{
                                            $arrayerror.= "<br>" . lang('Row_Number') . ' ' . "$i" . ': ' . lang('column_A_already_exist');
                                        }
                                    }
                                }
                                if ($imei == '') {
                                    if ($arrayerror == '') {
                                        $arrayerror.= lang('Row_Number') . ' ' . "$i" . ' ' . lang('column_A_required');
                                    } else {
                                        $arrayerror.= "<br>" . lang('Row_Number') . ' ' . "$i" . ' ' . lang('column_A_required');
                                    }
                                }
                            }

                            $valueCounts = array_count_values($excel_date_unit_arr);
                            $duplicates = array_filter($valueCounts, function($count) {
                                return $count > 1;
                            });
                            
                            foreach (array_keys($duplicates) as $duplicate) {
                                if($arrayerror == ''){
                                    $arrayerror.= lang('duplicate_value_cannot_accept') . ' ' . "$duplicate";
                                }else{
                                    $arrayerror.= "<br>" . lang('duplicate_value_cannot_accept') . ' ' . "$duplicate";
                                }
                            }

                            if ($arrayerror == '') {
                                for ($i = 4; $i <= $totalrows; $i++) {
                                    $imei = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(0, $i)->getValue() ?? '')); //Excel Column 0//Required
                                    array_push($parepare_arr, $imei);
                                }
                                unlink(FCPATH . 'assets/upload-sample/excel/' . $file_name); //File Deleted After uploading in database .
                                $response = [
                                    'status' => 'success',
                                    'message' => lang('Imported_successfully'),
                                    'data' => $parepare_arr,
                                ];
                            } else {
                                unlink(FCPATH . 'assets/upload-sample/excel/' . $file_name); //File Deleted After uploading in database .
                                $response = [
                                    'status' => 'error',
                                    'message' => lang('Required_Data_Missing') . "<br>" . ' ' . $arrayerror,
                                ];
                            }
                        } else {
                            unlink(FCPATH . 'assets/upload-sample/excel/' . $file_name); //File Deleted After uploading in database .
                            $response = [
                                'status' => 'error',
                                'message' => lang('Entry_is_more_than_50_or_No_entry_found'),
                            ];
                        }
                    } else {
                        $error = $this->upload->display_errors();
                        $response = [
                            'status' => 'error',
                            'message' => $error,
                        ];
                    }
                } else {
                    $response = [
                        'status' => 'error',
                        'message' => lang('We_can_not_accept_other_files'),
                    ];	
                }
            } else {
                $response = [
                    'status' => 'error',
                    'message' => lang('File_is_required'),
                ];	
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($response));
        }
    }

    
}
