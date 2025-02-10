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
    # This is Customer_due_receive Controller
    ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_due_receive extends Cl_Controller {

    /**
     * load constructor
     * @access public
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('Authentication_model');
        $this->load->model('Common_model'); 
        $this->load->model('Master_model');
        $this->load->model('Customer_due_receive_model');
        $this->load->model('Sale_model');
        $this->load->library('form_validation');
        $this->Common_model->setDefaultTimezone();
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
        $controller = "198";
        $function = "";
        if(($segment_2=="addCustomerDueReceive") || ($segment_2 == "getCustomerDue")){
            $function = "add";
        }elseif(($segment_2=="addCustomerDueReceive" && $segment_3) || ($segment_2 == "getCustomerDue")){
            $function = "edit";
        }elseif($segment_2=="deleteCustomerDueReceive"){
            $function = "delete";
        }elseif($segment_2=="customerDueReceives"){
            $function = "list";
        }elseif($segment_2=="print_invoice" || $segment_2 == "a4InvoicePDF"){
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
        if ($register_content->register_customer_due_receive != '' && $register_status == 2) {
            $this->session->set_flashdata('exception', lang('please_open_register'));
            $this->session->set_userdata("clicked_controller", $this->uri->segment(1));
            $this->session->set_userdata("clicked_method", $this->uri->segment(2));
            redirect('Register/openRegister');
        }
    }

    /**
     * addCustomerDueReceive
     * @access public
     * @param no
     * @return void
     */
    public function addCustomerDueReceive(){
        $company_id = $this->session->userdata('company_id');
        $outlet_id = $this->session->userdata('outlet_id');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $add_more = $this->input->post($this->security->xss_clean('add_more'));
            $this->form_validation->set_rules('date', lang('date'), 'required|max_length[50]');
            $this->form_validation->set_rules('reference_no', lang('ref_no'), 'required|max_length[50]');
            $this->form_validation->set_rules('amount', lang('amount'), 'required|max_length[11]');
            $this->form_validation->set_rules('customer_id', lang('customer'), 'required|max_length[10]');
            $this->form_validation->set_rules('payment_method_id', lang('payment_methods'), 'required|max_length[10]');
            $this->form_validation->set_rules('note', lang('note'), 'max_length[255]');
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
                $cust_payment_info = array();
                $cust_payment_info['date'] = $this->security->xss_clean($this->input->post("date")); // get input date
                $cust_payment_info['amount'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('amount')));
                $cust_payment_info['reference_no'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('reference_no')));
                $cust_payment_info['customer_id'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('customer_id')));
                $cust_payment_info['payment_method_id'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('payment_method_id')));
                $cust_payment_info['note'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('note')));
                $cust_payment_info['account_type'] = $account_type;
                if(!empty($acc_type)){
                    $cust_payment_info['payment_method_type'] = json_encode($acc_type);
                }
                $cust_payment_info['user_id'] = $this->session->userdata('user_id');
                $cust_payment_info['outlet_id'] = $this->session->userdata('outlet_id');
                $cust_payment_info['company_id'] = $this->session->userdata('company_id');
                $cust_payment_info['added_date'] = date('Y-m-d H:i:s');
                $id=$this->Common_model->insertInformation($cust_payment_info, "tbl_customer_due_receives");
                $receive_information=$this->Customer_due_receive_model->getAllById($id, "tbl_customer_due_receives"); 
                $outletName = $this->session->userdata('outlet_name');
                $currency = $this->session->userdata('currency');
                $phone = $this->session->userdata('phone');
                $msg = "Dear ".$receive_information[0]->name .",we received your payment of 
                ".$currency ." ".$cust_payment_info['amount']." on ".$cust_payment_info['date'] .". 
                ".$outletName."
                ".$phone;
                smsSendOnly($msg, $receive_information[0]->phone);
                $this->session->set_flashdata('exception', lang('insertion_success'));
                if($add_more == 'add_more'){
                    redirect('Customer_due_receive/addCustomerDueReceive');
                }else{
                    redirect('Customer_due_receive/customerDueReceives');
                }
            } else {
                $data = array();
                $data['paymentMethods'] = $this->Common_model->getAllPaymentMethod();
                $data['reference_no'] = $this->Customer_due_receive_model->generateReferenceNo($outlet_id);
                $data['customers'] = $this->Common_model->getAllByCustomerASC();
                $data['main_content'] = $this->load->view('customerDueReceive/addCustomerDueReceive', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        } else {
            $data = array();
            $data['reference_no'] = $this->Customer_due_receive_model->generateReferenceNo($outlet_id);
            $data['paymentMethods'] = $this->Common_model->getAllPaymentMethod();
            $data['customers'] = $this->Common_model->getAllByCustomerASC();
            $data['main_content'] = $this->load->view('customerDueReceive/addCustomerDueReceive', $data, TRUE); 
            $this->load->view('userHome', $data);
        }
    }

    /**
     * deleteCustomerDueReceive
     * @access public
     * @param int
     * @return void
     */

     public function deleteCustomerDueReceive($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $this->Common_model->deleteStatusChange($id, "tbl_customer_due_receives");
        $this->session->set_flashdata('exception', lang('delete_success'));
        redirect('Customer_due_receive/customerDueReceives');
    }


    /**
     * customerDueReceives
     * @access public
     * @param no
     * @return void
     */
    public function customerDueReceives() {
        $data = array();
        $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
        if($outlet_id){
            $outlet_id = $outlet_id;
        }else{
            $outlet_id = $this->session->userdata('outlet_id');
        }
        if($this->input->post('submit')){
            $start_date = $this->input->post($this->security->xss_clean('startDate'));
            $end_date = $this->input->post($this->security->xss_clean('endDate'));
            if($start_date != ''){
                $this->form_validation->set_rules('endDate', lang('endDate'), 'required|max_length[50]');
            }else if($end_date != ''){
                $this->form_validation->set_rules('startDate', lang('startDate'), 'required|max_length[50]');
            }
            $customer_id = $this->input->post($this->security->xss_clean('customer_id'));
            $data['customer_id'] = $customer_id;
            $data['outlet_id'] = $outlet_id;
            $start_date = $this->input->post($this->security->xss_clean('startDate'));
            $end_date = $this->input->post($this->security->xss_clean('endDate'));
            $data['customerDueReceives'] = $this->Common_model->getCustomerDueReceive($start_date, $end_date, $customer_id, $outlet_id);  
        }else{
            $data['customerDueReceives'] = $this->Common_model->getCustomerDueReceive('', '', '', $outlet_id);
        }
        $data['customers'] = $this->Common_model->getAllCustomerNameMobile();
        $data['main_content'] = $this->load->view('customerDueReceive/customerDueReceives', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    
    /**
     * print_invoice
     * @access public
     * @param int
     * @return void
     */
    function print_invoice($id){
        $data=array();
        $data['receipt_object'] = $this->get_information_of_a_receive($id);
        $data['outlet_info'] = $this->Common_model->getCurrentOutlet();
        $this->load->view('customerDueReceive/print_invoice_a4',$data);              
    }

    /**
     * a4InvoicePDF
     * @access public
     * @param int
     * @return void
     */
    public function a4InvoicePDF($id) {
        $pdfContent = array();
        $pdfContent['receipt_object'] = $this->get_information_of_a_receive($id);
        $pdfContent['outlet_info'] = $this->Common_model->getCurrentOutlet();
        $pdfContent['company_info'] = getCompanyInfo($this->session->userdata('company_id'));
        $mpdf = new \Mpdf\Mpdf();
        $html = $this->load->view('customerDueReceive/a4_invoice_pdf',$pdfContent,true);
        $mpdf->WriteHTML($html);
        $mpdf->Output('Customer Due Receive - Reference No -' . $pdfContent['receipt_object'][0]->reference_no . '.pdf', "D");
    }
    /**
     * get_information_of_a_receive
     * @access public
     * @param int
     * @return object
     */
    function get_information_of_a_receive($id){
        $id=$this->custom->encrypt_decrypt($id, 'decrypt');
        $receive_information=$this->Customer_due_receive_model->getAllById($id, "tbl_customer_due_receives");        
        return $receive_information;
    }

    /**
     * getCustomerDue
     * @access public
     * @param no
     * @return int
     */
    public function getCustomerDue() {
        $customer_id = $_GET['customer_id']; 
        $remaining_due = getCustomerDue($customer_id);
        echo $remaining_due;
    }
}
