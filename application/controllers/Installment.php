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
    # This is Installment Controller
    ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Installment extends Cl_Controller {


    /**
     * load constructor
     * @access public
     * @return void
     */    
    public function __construct() {
        parent::__construct();
        $this->load->model('Authentication_model');
        $this->load->model('Common_model');
        $this->load->library('form_validation');
        $this->load->model('Purchase_model');
        $this->load->model('Installment_model');
        $this->load->library('excel'); //load PHPExcel library
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
        //start check access function
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $controller = "";
        $function = "";
        if($segment_2 == "addEditCustomer"){
            $controller = "93";
            $function = "add";
        }elseif($segment_2 == "addEditCustomer" && $segment_3){
            $controller = "93";
            $function = "edit";
        }elseif($segment_2 == "customerDetails"){
            $controller = "93";
            $function = "view";
        }elseif($segment_2 == "deleteCustomer"){
            $controller = "93";
            $function = "delete";
        }elseif($segment_2 == "customers"){
            $controller = "93";
            $function = "list";
        }elseif($segment_2 == "sendSMSForDueInstallmentCustomer"){
            $controller = "93";
            $function = "sms_send";
        }elseif($segment_2 == "addEditInstallmentSale"){
            $controller = "100";
            $function = "add";
        }elseif($segment_2 == "addEditInstallmentSale" && $segment_3){
            $controller = "100";
            $function = "edit";
        }elseif($segment_2 == "viewDetails"){
            $controller = "100";
            $function = "view";
        }elseif($segment_2 == "deleteInstallmentSale"){
            $controller = "100";
            $function = "delete";
        }elseif($segment_2 == "installmentSales"){
            $controller = "100";
            $function = "list"; 
        }elseif($segment_2 == "installmentPrint" || $segment_2 == "a4InvoicePDF"){
            $controller = "100";
            $function = "print";
        }elseif($segment_2 == "installmentCollections"){
            $controller = "100";
            $function = "installment_collection";
        }elseif($segment_2 == "listDueInstallment"){
            $controller = "100";
            $function = "due_installment";
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
     * addEditCustomer
     * @access public
     * @param int
     * @return void
     */
    public function addEditCustomer($encrypted_id = "") {
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $add_more = $this->input->post($this->security->xss_clean('add_more'));
            $this->form_validation->set_rules('name', lang('name'), 'required|max_length[50]');
            $this->form_validation->set_rules('phone', lang('phone'), 'required|max_length[30]');
            $this->form_validation->set_rules('email', lang('email_address'), "valid_email|max_length[50]");
            $this->form_validation->set_rules('address', lang('present_address'), "required|max_length[255]");
            $this->form_validation->set_rules('permanent_address', lang('Permanent_Address'), "required|max_length[255]");
            $this->form_validation->set_rules('work_address', lang('Work_Address'), "required|max_length[300]");
            $this->form_validation->set_rules('g_name', lang('Guarantor_Name'), "required|max_length[50]");
            $this->form_validation->set_rules('g_mobile', lang('Guarantor_Mobile_No'), "required|max_length[30]");
            $this->form_validation->set_rules('g_pre_address', lang('Guarantor_Present_Address'), "required|max_length[255]");
            $this->form_validation->set_rules('g_permanent_address', lang('Guarantor_Permanent_Address'), "required|max_length[255]");
            $this->form_validation->set_rules('g_work_address', lang('Guarantor_Work_Address'), "required|max_length[255]");
            $this->form_validation->set_rules('customer_nid', lang('NID'), "callback_validate_customer|max_length[55]");
            $this->form_validation->set_rules('photo', lang('photo'), 'callback_validate_photo|max_length[55]');
            $this->form_validation->set_rules('g_nid', lang('Guarantor_NID'), "callback_validate_g_nid|max_length[255]");
            $this->form_validation->set_rules('g_photo', lang('Guarantor_photo'), "callback_validate_g_photo|max_length[255]");
            if ($this->form_validation->run() == TRUE) {
                $customer_info = array();
                $customer_info['name'] = htmlspecialcharscustom(escapeQuot($this->input->post($this->security->xss_clean('name'))));
                $customer_info['phone'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('phone')));
                $customer_info['email'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('email')));
                $c_address = escapeQuot($this->input->post($this->security->xss_clean('address'))); #clean the address
                $customer_info['address'] = preg_replace("/[\n\r]/"," ",$c_address); #remove new line from address
                $customer_info['permanent_address'] = escapeQuot($this->input->post($this->security->xss_clean('permanent_address')));
                $customer_info['work_address'] = escapeQuot($this->input->post($this->security->xss_clean('work_address')));
                $customer_info['customer_nid'] = escapeQuot($this->input->post($this->security->xss_clean('customer_nid')));
                $customer_info['g_name'] = escapeQuot($this->input->post($this->security->xss_clean('g_name')));
                $customer_info['g_mobile'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('g_mobile')));
                $customer_info['g_nid'] = escapeQuot($this->input->post($this->security->xss_clean('g_nid')));
                $customer_info['g_pre_address'] = escapeQuot($this->input->post($this->security->xss_clean('g_pre_address')));
                $customer_info['g_permanent_address'] = escapeQuot($this->input->post($this->security->xss_clean('g_permanent_address')));
                $customer_info['g_work_address'] = escapeQuot($this->input->post($this->security->xss_clean('g_work_address')));
                if ($_FILES['photo']['name'] != "") {
                    $customer_info['photo'] = $this->session->userdata('photo');
                    $this->session->unset_userdata('photo');
                }else{
                    $customer_info['photo'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('photo_p')));
                }
                if ($_FILES['customer_nid']['name'] != "") {
                    $customer_info['customer_nid'] = $this->session->userdata('customer_nid');
                    $this->session->unset_userdata('customer_nid');
                }else{
                    $customer_info['customer_nid'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('customer_nid_e')));
                }
                if ($_FILES['g_nid']['name'] != "") {
                    $customer_info['g_nid'] = $this->session->userdata('g_nid');
                    $this->session->unset_userdata('g_nid');
                }else{
                    $customer_info['g_nid'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('g_nid_e')));
                }
                if ($_FILES['g_photo']['name'] != "") {
                    $customer_info['g_photo'] = $this->session->userdata('g_photo');
                    $this->session->unset_userdata('g_photo');
                }else{
                    $customer_info['g_photo'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('g_photo_e')));
                }
                $customer_info['customer_type'] = "installment";
                $customer_info['user_id'] = $this->session->userdata('user_id');
                $customer_info['company_id'] = $this->session->userdata('company_id');
                if ($id == "") {
                    $customer_info['added_date'] = date('Y-m-d H:i:s');
                    $this->Common_model->insertInformation($customer_info, "tbl_customers");
                    $this->session->set_flashdata('exception', lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($customer_info, $id, "tbl_customers");
                    $this->session->set_flashdata('exception',lang('update_success'));
                }
                
                if($add_more == 'add_more'){
                    redirect('Installment/addEditCustomer');
                }else{
                    redirect('Installment/customers');
                }
            } else {
                if ($id == "") {
                    $data = array();
                    $data['main_content'] = $this->load->view('installment/customer/addCustomer', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['customer_information'] = $this->Common_model->getDataById($id, "tbl_customers");
                    $data['main_content'] = $this->load->view('installment/customer/editCustomer', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['main_content'] = $this->load->view('installment/customer/addCustomer', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['customer_information'] = $this->Common_model->getDataById($id, "tbl_customers");
                $data['main_content'] = $this->load->view('installment/customer/editCustomer', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }

    /**
     * validate_photo
     * @access public
     * @param no
     * @return void
     */
    public function validate_photo() {
        if ($_FILES['photo']['name'] != "") {
            $config['upload_path'] = './uploads/customers';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = '1000';
            $config['encrypt_name'] = TRUE;
            $config['detect_mime'] = TRUE;
            $this->load->library('upload', $config);

            if(createDirectory('uploads/customers')){
                // Delete the old file if it exists
                $old_file = $this->session->userdata('photo');
                if ($old_file && file_exists($config['upload_path'] . '/' . $old_file)) {
                    unlink($config['upload_path'] . '/' . $old_file);
                }
                if ($this->upload->do_upload("photo")) {
                    $upload_info = $this->upload->data();
                    $file_name = $upload_info['file_name'];
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = './uploads/customers/' . $file_name;
                    $config['maintain_ratio'] = TRUE;
                    $config['width'] = 170;
                    $config['height'] = 210;
                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();
                    $this->session->set_userdata('photo', $file_name);
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
     * validate_customer
     * @access public
     * @param no
     * @return void
     */
    public function validate_customer() {
        if ($_FILES['customer_nid']['name'] != "") {
            $config['upload_path'] = './uploads/customers';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = '1000';
            $config['encrypt_name'] = TRUE;
            $config['detect_mime'] = TRUE;
            $this->load->library('upload', $config);
            if(createDirectory('uploads/customers')){
                // Delete the old file if it exists
                $old_file = $this->session->userdata('customer_nid');
                if ($old_file && file_exists($config['upload_path'] . '/' . $old_file)) {
                    unlink($config['upload_path'] . '/' . $old_file);
                }
                if ($this->upload->do_upload("customer_nid")) {
                    $upload_info = $this->upload->data();
                    $file_name = $upload_info['file_name'];
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = './uploads/customers/' . $file_name;
                    $config['maintain_ratio'] = TRUE;
                    $config['width'] = 324;
                    $config['height'] = 205;
                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();
                    $this->session->set_userdata('customer_nid', $file_name);
                } else {
                    $this->form_validation->set_message('validate_customer', $this->upload->display_errors());
                    return FALSE;
                }
            } else {
                echo "Something went wrong";
            }
        }
    }


    /**
     * validate_g_nid
     * @access public
     * @param no
     * @return void
     */
    public function validate_g_nid() {
        if ($_FILES['g_nid']['name'] != "") {
            $config['upload_path'] = './uploads/customers';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = '1000';
            $config['encrypt_name'] = TRUE;
            $config['detect_mime'] = TRUE;
            $this->load->library('upload', $config);


            if(createDirectory('uploads/customers')){
                // Delete the old file if it exists
                $old_file = $this->session->userdata('g_nid');
                if ($old_file && file_exists($config['upload_path'] . '/' . $old_file)) {
                    unlink($config['upload_path'] . '/' . $old_file);
                }
                if ($this->upload->do_upload("g_nid")) {
                    $upload_info = $this->upload->data();
                    $file_name = $upload_info['file_name'];
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = './uploads/customers/' . $file_name;
                    $config['maintain_ratio'] = TRUE;
                    $config['width'] = 320;
                    $config['height'] = 200;
                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();
                    $this->session->set_userdata('g_nid', $file_name);
                } else {
                    $this->form_validation->set_message('validate_customer', $this->upload->display_errors());
                    return FALSE;
                }
            } else {
                echo "Something went wrong";
            }


            
        }
    }


    /**
     * validate_g_photo
     * @access public
     * @param no
     * @return void
     */
    public function validate_g_photo() {
        if ($_FILES['g_photo']['name'] != "") {
            $config['upload_path'] = './uploads/customers';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = '1000';
            $config['encrypt_name'] = TRUE;
            $config['detect_mime'] = TRUE;
            $this->load->library('upload', $config);

            if(createDirectory('uploads/customers')){
                // Delete the old file if it exists
                $old_file = $this->session->userdata('g_photo');
                if ($old_file && file_exists($config['upload_path'] . '/' . $old_file)) {
                    unlink($config['upload_path'] . '/' . $old_file);
                }
                if ($this->upload->do_upload("g_photo")) {
                    $upload_info = $this->upload->data();
                    $file_name = $upload_info['file_name'];
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = './uploads/customers/' . $file_name;
                    $config['maintain_ratio'] = TRUE;
                    $config['width'] = 170;
                    $config['height'] = 192;
                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();
                    $this->session->set_userdata('g_photo', $file_name);
                } else {
                    $this->form_validation->set_message('validate_customer', $this->upload->display_errors());
                    return FALSE;
                }
            } else {
                echo "Something went wrong";
            }
        }
    }


    /**
     * customerDetails
     * @access public
     * @param int
     * @return void
     */
    public function customerDetails($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $data = array();
        $data['customer_information'] = $this->Common_model->getDataById($id, "tbl_customers");
        $data['main_content'] = $this->load->view('installment/customer/viewDetails', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    /**
     * deleteCustomer
     * @access public
     * @param int
     * @return void
     */
    public function deleteCustomer($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $this->Common_model->deleteStatusChange($id, "tbl_customers");
        $this->session->set_flashdata('exception',lang('delete_success'));
        redirect('Installment/customers');
    }

    /**
     * customers
     * @access public
     * @param no
     * @return void
     */
    public function customers() {
        $company_id = $this->session->userdata('company_id');
        $data = array();
        $data['customers'] = $this->Common_model->getCustomerByType($company_id, "tbl_customers","installment");
        $data['main_content'] = $this->load->view('installment/customer/customers', $data, TRUE);
        $this->load->view('userHome', $data);
    }


    /**
     * sendSMSForDueInstallmentCustomer
     * @access public
     * @param no
     * @return void
     */
    public function sendSMSForDueInstallmentCustomer(){
        $company_id = $this->session->userdata('company_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $user_id = $this->session->userdata('user_id');
        $getCustomer = $this->input->post($this->security->xss_clean('customer_id'));
        $data = array();
        foreach($getCustomer as $key=>$customer){
            $information = explode("||",$customer);
            $message_content = 'Dear ' . $information[0] .' For purchasing '. $information[2].' on '. date($this->session->userdata('date_format'), strtotime($information[3])) .' you have an installment payment of '. getAmtCustom($information[4]) .' on '. date($this->session->userdata('date_format'), strtotime($information[5])) .'.
            Please make your payment.
            Regards,
            '.getUserName($user_id).'
            '.getOutletName($outlet_id).'';
            smsSendOnly($message_content, $information[1]);

            // $data['notifications_details'] =  'Notify '.$information[0].' to pay about '. $information[2] .'product, installment payment of '. getAmtCustom($information[4]) .' on '. date($this->session->userdata('date_format'), strtotime($information[5]));
            // $data['visible_status'] = '1';
            // $data['date'] = date('Y-d-m');
            // $data['outlet_id'] = $outlet_id;
            // $data['company_id'] = $company_id;
            // $data['date'] = date('Y-d-m');
            // $this->Common_model->insertInformation($data, "tbl_notifications");
        }
        redirect('Installment/listDueInstallment');
    }


    /**
     * addEditInstallmentSale
     * @access public
     * @param int
     * @return void
     */
    public function addEditInstallmentSale($encrypted_id = "") {
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        $company_id = $this->session->userdata('company_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $user_id = $this->session->userdata('user_id');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $item_type = $this->input->post($this->security->xss_clean('item_type'));
            $add_more = $this->input->post($this->security->xss_clean('add_more'));
            $this->form_validation->set_rules('date', lang('date'), 'required|max_length[50]');
            $this->form_validation->set_rules('reference_no', lang('invoice_no'), 'required|max_length[30]');
            $this->form_validation->set_rules('customer_id', lang('customer'), "required|max_length[11]");
            $this->form_validation->set_rules('payment_method_id', lang('payment_method_id'), "max_length[55]");
            $this->form_validation->set_rules('item_id', lang('product'), "required|max_length[11]");
            $this->form_validation->set_rules('price', lang('price'), "required|max_length[255]");
            $this->form_validation->set_rules('discount', lang('discount'), "max_length[30]");
            $this->form_validation->set_rules('shipping_other', lang('shipping_other'), "max_length[30]");
            $this->form_validation->set_rules('total', lang('total'), "required|max_length[255]");
            $this->form_validation->set_rules('down_payment', lang('down_payment'), "max_length[55]");
            $this->form_validation->set_rules('remaining', lang('remaining'), "required|max_length[255]");
            $this->form_validation->set_rules('number_of_installment', lang('number_of_installment'), "required|max_length[255]");
            $this->form_validation->set_rules('percentage_of_interest', lang('percentage_of_interest'), "max_length[55]");
            $this->form_validation->set_rules('installment_type', lang('Installment_Schedule'), "required|max_length[255]");
            if($item_type == 'IMEI_Product' || $item_type == 'Serial_Product'){
                $this->form_validation->set_rules('expiry_imei_serial', lang('imei_serial'), "required|max_length[255]");
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
                $data['date'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('date')));
                $data['reference_no'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('reference_no')));
                $data['customer_id'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('customer_id')));
                $data['payment_method_id'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('payment_method_id')));
                $data['item_id'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('item_id')));
                $data['price'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('price')));
                $data['discount'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('discount')));
                $data['shipping_other'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('shipping_other')));
                $data['total'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('total')));
                $data['down_payment'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('down_payment')));
                $data['remaining'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('remaining')));
                $data['number_of_installment'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('number_of_installment')));
                $data['percentage_of_interest'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('percentage_of_interest')));
                $data['installment_type'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('installment_type')));
                if($item_type == 'IMEI_Product' || $item_type == 'Serial_Product'){
                    $data['item_type'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('item_type')));
                    $data['expiry_imei_serial'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('expiry_imei_serial')));
                }
                $data['account_type'] = $account_type;
                if(!empty($acc_type)){
                    $data['payment_method_type'] = json_encode($acc_type);
                }
                $data['user_id'] = $user_id;
                $data['outlet_id'] = $outlet_id;
                $data['company_id'] = $company_id;
                if ($id == "") {
                    $data['added_date'] = date('Y-m-d H:i:s');
                    $id =  $this->Common_model->insertInformation($data, "tbl_installments");
                    $this->savePayments($_POST['amount_of_payment'], $id);
                    $this->session->set_flashdata('exception', lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($data, $id, "tbl_installments");
                    $this->Common_model->deletingMultipleFormData('installment_id', $id, 'tbl_installment_items');
                    $this->savePayments($_POST['amount_of_payment'], $id);
                    $this->session->set_flashdata('exception',lang('update_success'));
                }
                if($add_more == 'add_more'){
                    redirect('Installment/addEditInstallmentSale');
                }else{
                    redirect('Installment/installmentSales');
                }
            } else {
                if ($id == "") {
                    $data = array();
                    $data['paymentMethods'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_payment_methods");
                    $data['customers'] = $this->Common_model->getCustomerByType($company_id, "tbl_customers","installment");
                    $data['ref_no'] = $this->Purchase_model->getRefInstall($outlet_id);
                    $data['products'] = $this->Common_model->getItemsForInstallmentSale();
                    $data['main_content'] = $this->load->view('installment/installment_sale/addInstallmentSale', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['paymentMethods'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_payment_methods");
                    $data['customers'] = $this->Common_model->getCustomerByType($company_id, "tbl_customers","installment");
                    $data['products'] = $this->Common_model->getItemsForInstallmentSale();
                    $data['installment'] = $this->Common_model->getDataById($id, "tbl_installments");
                    $data['installment_payments'] = $this->Installment_model->getInstallmentPayments($id);
                    $data['main_content'] = $this->load->view('installment/installment_sale/editInstallmentSale', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['paymentMethods'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_payment_methods");
                $data['customers'] = $this->Common_model->getCustomerByType($company_id, "tbl_customers","installment");
                $data['ref_no'] = $this->Purchase_model->getRefInstall($outlet_id);
                $data['products'] = $this->Common_model->getItemsForInstallmentSale();
                $data['main_content'] = $this->load->view('installment/installment_sale/addInstallmentSale', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['paymentMethods'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_payment_methods");
                $data['customers'] = $this->Common_model->getCustomerByType($company_id, "tbl_customers","installment");
                $data['products'] = $this->Common_model->getItemsForInstallmentSale();
                $data['installment'] = $this->Common_model->getDataById($id, "tbl_installments");
                $data['installment_payments'] = $this->Installment_model->getInstallmentPayments($id);
                $data['main_content'] = $this->load->view('installment/installment_sale/editInstallmentSale', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }
    

    /**
     * viewDetails
     * @access public
     * @param int
     * @return void
     */
    public function viewDetails($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $data = array();
        $data['installment'] = $this->Common_model->getDataById($id, "tbl_installments");
        $data['info'] = $this->Common_model->getDataById($data['installment']->customer_id, "tbl_customers");
        $data['product'] = $this->Common_model->getDataById($data['installment']->item_id, "tbl_items");
        $data['installment_payments'] = $this->Installment_model->getInstallmentPayments($id);
        $data['main_content'] = $this->load->view('installment/installment_sale/installment_details', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    /**
     * deleteInstallmentSale
     * @access public
     * @param int
     * @return void
     */
    public function deleteInstallmentSale($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $this->Common_model->deleteStatusChangeWithChild($id, $id, "tbl_installments", " tbl_installment_items", 'id', 'installment_id');
        $this->session->set_flashdata('exception', lang('delete_success'));
        redirect('Installment/installmentSales');
    }


    /**
     * installmentSales
     * @access public
     * @param no
     * @return void
     */
    public function installmentSales() {
        $outlet_id = $this->session->userdata('outlet_id');
        $data = array();
        $data['installments'] = $this->Common_model->getAllByOutletId($outlet_id, "tbl_installments");
        $data['main_content'] = $this->load->view('installment/installment_sale/installment_sales', $data, TRUE);
        $this->load->view('userHome', $data);
    }


    /**
     * installmentCollections
     * @access public
     * @param int
     * @return void
     */
    public function installmentCollections($encrypted_id='') {
        $company_id = $this->session->userdata('company_id');
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        if($id!=''){
            if (htmlspecialcharscustom($this->input->post('submit'))) {
                $this->form_validation->set_rules('payment_method_id',lang('payment_methods'), 'required');
                if ($this->form_validation->run() == TRUE){
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
                    $data['paid_date'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('paid_date')));
                    $data['paid_amount'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('paid_amount')));
                    $paid_amount_c = $data['paid_amount'];
                    $amount_of_installment = htmlspecialcharscustom($this->input->post($this->security->xss_clean('amount_of_installment')));
                    if ($amount_of_installment == $paid_amount_c){
                        $data['paid_status'] = 'Paid';
                    }elseif($paid_amount_c == 0){
                        $data['paid_status'] = 'Unpaid';
                    }elseif($amount_of_installment > $paid_amount_c){
                        $data['paid_status'] = 'Partially Paid';
                    }
                    $data['payment_method_id'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('payment_method_id')));
                    $data['account_type'] = $account_type;
                    if(!empty($acc_type)){
                        $data['payment_method_type'] = json_encode($acc_type);
                    }
                    $this->Common_model->updateInformation($data, $id, "tbl_installment_items");
                    $this->session->set_flashdata('exception',lang('update_success'));
                    redirect('Installment/installmentCollections');
                }else{
                    $data['encrypted_id'] = $encrypted_id;
                    $data['paymentMethods'] = $this->Common_model->getAll($company_id, "tbl_payment_methods");
                    $data['payment_info'] = $this->Installment_model->getInstallmentPaymentInfo($id);
                    $data['main_content'] = $this->load->view('installment/installment_sale/payment_collect_form', $data, TRUE); 
                }
            } else {
                $data['encrypted_id'] = $encrypted_id;
                $data['paymentMethods'] = $this->Common_model->getAll($company_id, "tbl_payment_methods");
                $data['payment_info'] = $this->Installment_model->getInstallmentPaymentInfo($id);
                $data['main_content'] = $this->load->view('installment/installment_sale/payment_collect_form', $data, TRUE);
            }
        }else{
            $company_id = $this->session->userdata('company_id');
            $customer_id = $this->input->post($this->security->xss_clean('customer_id'));
            $installment_encrypt_id = $this->input->post($this->security->xss_clean('installment_id'));
            $installment_id = $this->custom->encrypt_decrypt($installment_encrypt_id, 'decrypt');
            $paid_status = $this->input->post($this->security->xss_clean('paid_status'));
            $data['customers'] = $this->Common_model->getCustomerByType($company_id, "tbl_customers","installment");
            $data['installment_payments'] = $this->Installment_model->getInstallmentPayments($installment_id);
            $data['encrypted_id'] = $encrypted_id;
            $data['payment_info'] = $this->Installment_model->getInstallmentPaymentInfo($installment_id);
            if ($this->input->post('submit') && $customer_id && $installment_id) {
                $data['payments'] = $this->Installment_model->getAllInstallmentPayments($customer_id,$installment_id,$paid_status);
            }
            $data['paymentMethods'] = $this->Common_model->getAll($company_id, "tbl_payment_methods");
            $data['main_content'] = $this->load->view('installment/installment_sale/installmentCollections', $data, TRUE);
        }
        $this->load->view('userHome', $data);
    }


    /**
     * installmentPrint
     * @access public
     * @param int
     * @return void
     */
    public function installmentPrint($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $data = array();
        $data['installment'] = $this->Common_model->getDataById($id, "tbl_installments");
        $data['outlet_info'] = $this->Common_model->getCurrentOutlet();
        $data['info'] = $this->Common_model->getDataById($data['installment']->customer_id, "tbl_customers");
        $data['product'] = $this->Common_model->getDataById($data['installment']->item_id, "tbl_items");
        $data['installment_payments'] = $this->Installment_model->getInstallmentPayments($id);
        $this->load->view('installment/installment_sale/print_invoice_a4',$data);
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
        $pdfContent['installment'] = $this->Common_model->getDataById($id, "tbl_installments");
        $pdfContent['outlet_info'] = $this->Common_model->getCurrentOutlet();
        $pdfContent['info'] = $this->Common_model->getDataById($pdfContent['installment']->customer_id, "tbl_customers");
        $pdfContent['product'] = $this->Common_model->getDataById($pdfContent['installment']->item_id, "tbl_items");
        $pdfContent['installment_payments'] = $this->Installment_model->getInstallmentPayments($id);
        $mpdf = new \Mpdf\Mpdf();
        $html = $this->load->view('installment/installment_sale/a4_invoice_pdf',$pdfContent,true);
        $mpdf->WriteHTML($html);
        $mpdf->Output('Installment Sale Invoice - Reference No -'. $pdfContent['installment']->reference_no . '.pdf', "D");
    }

    
    /**
     * listDueInstallment
     * @access public
     * @param no
     * @return void
     */
    public function listDueInstallment(){
        $company_id = $this->session->userdata('company_id');
        $data = array();
        $data['customers'] = $this->Common_model->getCustomerByType($company_id, "tbl_customers","installment");
        $customer_id = $this->input->post($this->security->xss_clean('due_customer_id'));
        $due_within = $this->input->post($this->security->xss_clean('due_within'));
        $outlet_id = $this->input->post($this->security->xss_clean('outlet_id'));
        $start_date =  date('Y-m-d');
        if ($due_within == "3"){
            $due_date =  date('Y-m-d',strtotime('+3 days'));
        }elseif($due_within == "7"){
            $due_date =  date('Y-m-d',strtotime('+7 days'));
        }elseif($due_within == "15"){
            $due_date =  date('Y-m-d',strtotime('+15 days'));
        }else{
            $due_date =  date('Y-m-d',strtotime('+3 days'));
        }
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $data['due_installment'] = $this->Installment_model->dueInstallmentWithin($customer_id, $start_date, $due_date, $outlet_id);
        }else{
            $data['due_installment'] = $this->Installment_model->dueInstallment();
        }
        $data['due_within'] = $due_within;
        $data['due_customer_id'] = $customer_id;
        $data['outlet_id'] = $outlet_id;
        $data['main_content'] = $this->load->view('installment/installment_sale/listDueInstallment', $data, TRUE);
        $this->load->view('userHome', $data);
    }


    /**
     * savePayments
     * @access public
     * @param int
     * @param int
     * @return void
     */
    public function savePayments($amount_of_payment, $install_id) {
        foreach ($amount_of_payment as $row => $payment):
            $fmi = array();
            $fmi['installment_id'] = $install_id;
            $fmi['amount_of_payment'] = $payment;
            $fmi['payment_date'] = $_POST['payment_date'][$row];
            $fmi['paid_status'] = $_POST['paid_status'][$row];
            $fmi['added_date'] = date('Y-m-d H:i:s');
            $fmi['user_id'] = $this->session->userdata('user_id');
            $fmi['outlet_id'] = $this->session->userdata('outlet_id');
            $fmi['company_id'] = $this->session->userdata('company_id');
            $this->Common_model->insertInformation($fmi, "tbl_installment_items");
        endforeach;
    }


}
