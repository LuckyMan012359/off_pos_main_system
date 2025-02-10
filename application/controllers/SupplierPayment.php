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
    # This is SupplierPayment Controller
    ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class SupplierPayment extends Cl_Controller {


    /**
     * load constructor
     * @access public
     * @return void
     */  
    public function __construct() {
        parent::__construct();
        

        $this->load->model('Authentication_model');
        $this->load->model('Common_model');
        $this->load->model('Supplier_payment_model');
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
        $controller = "192";
        $function = "";

        if($segment_2=="addSupplierPayment" || $segment_2 == "getSupplierDue"){
            $function = "add";
        }elseif(($segment_2=="addSupplierPayment" && $segment_3) || ($segment_2 == "getSupplierDue")){
            $function = "edit";
        }elseif($segment_2=="deleteSupplierPayment"){
            $function = "delete";
        }elseif($segment_2=="supplierPayments"){
            $function = "list";
        }elseif($segment_2=="print_invoice" || $segment_2 == "a4InvoicePDF"){
            $function = "receipt";
        }else{
            redirect('Authentication/userProfile');
        }
        
        if(!checkAccess($controller,$function)){
            $this->session->set_flashdata('exception_1',lang('no_access'));
            redirect('Authentication/userProfile');
        } 

        $register_content = json_decode($this->session->userdata('register_content'));
        $register_status = $this->session->userdata('register_status');
        if ($register_content->register_supplier_payment != '' && $register_status == 2) {
            $this->session->set_flashdata('exception', lang('please_open_register'));
            $this->session->set_userdata("clicked_controller", $this->uri->segment(1));
            $this->session->set_userdata("clicked_method", $this->uri->segment(2));
            redirect('Register/openRegister');
        }
        
    }



    /**
     * addSupplierPayment
     * @access public
     * @param no
     * @return void
     */
    public function addSupplierPayment() {
        $outlet_id = $this->session->userdata('outlet_id');
        $company_id = $this->session->userdata('company_id');
        $splr_payment_info['reference_no'] = $this->Supplier_payment_model->generateSupplierPaymentRefNo($outlet_id);
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $add_more = $this->input->post($this->security->xss_clean('add_more'));
            $this->form_validation->set_rules('date', lang('date'), 'required|max_length[50]');
            $this->form_validation->set_rules('amount', lang('amount'), 'required|max_length[11]');
            $this->form_validation->set_rules('supplier_id', lang('supplier'), 'required|max_length[10]');
            $this->form_validation->set_rules('payment_method_id',lang('payment_methods'), 'required');
            $this->form_validation->set_rules('note', lang('note'), 'max_length[255]');
            if ($this->form_validation->run() == TRUE) {
                $splr_payment_info = array();
                $splr_payment_info['reference_no'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('reference_no')));
                $splr_payment_info['date'] = date("Y-m-d", strtotime($this->input->post($this->security->xss_clean('date'))));
                $splr_payment_info['amount'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('amount')));
                $splr_payment_info['supplier_id'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('supplier_id')));
                $splr_payment_info['payment_method_id'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('payment_method_id')));
                $splr_payment_info['note'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('note')));
                $splr_payment_info['user_id'] = $this->session->userdata('user_id');
                $splr_payment_info['outlet_id'] = $this->session->userdata('outlet_id');
                $splr_payment_info['company_id'] = $this->session->userdata('company_id');
                $splr_payment_info['added_date'] = date('Y-m-d H:i:s');
                $this->Common_model->insertInformation($splr_payment_info, "tbl_supplier_payments");
                $this->session->set_flashdata('exception', lang('insertion_success'));
                
                if($add_more == 'add_more'){
                    redirect('SupplierPayment/addSupplierPayment');
                }else{
                    redirect('SupplierPayment/supplierPayments');
                }

            } else {
                $data = array();
                $data['paymentMethods'] = $this->Common_model->getAllPaymentMethod();
                $data['suppliers'] = $this->Common_model->getAllSupplierNameMobile();
                $data['ref_no'] = $this->Supplier_payment_model->generateSupplierPaymentRefNo($outlet_id);
                $data['main_content'] = $this->load->view('supplierPayment/addSupplierPayment', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        } else {
            $data = array();
            $data['paymentMethods'] = $this->Common_model->getAllPaymentMethod();
            $data['suppliers'] = $this->Common_model->getAllSupplierNameMobile();
            $data['ref_no'] = $this->Supplier_payment_model->generateSupplierPaymentRefNo($outlet_id);
            $data['main_content'] = $this->load->view('supplierPayment/addSupplierPayment', $data, TRUE);
            $this->load->view('userHome', $data);
        }
    }

    /**
     * deleteSupplierPayment
     * @access public
     * @param int
     * @return void
     */
    public function deleteSupplierPayment($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $this->Common_model->deleteStatusChange($id, "tbl_supplier_payments");
        $this->session->set_flashdata('exception', lang('delete_success'));
        redirect('SupplierPayment/supplierPayments');
    }


    
    /**
     * supplierPayments
     * @access public
     * @param no
     * @return void
     */
    public function supplierPayments() {
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
            $supplier_id = $this->input->post($this->security->xss_clean('supplier_id'));
            $data['supplier_id'] = $supplier_id;
            $data['outlet_id'] = $outlet_id;
            $start_date = $this->input->post($this->security->xss_clean('startDate'));
            $end_date = $this->input->post($this->security->xss_clean('endDate'));
            $data['supplierPayments'] = $this->Common_model->getSupplierPayment($start_date, $end_date, $supplier_id, $outlet_id);  
        }else{
            $data['supplierPayments'] = $this->Common_model->getSupplierPayment('', '', '', $outlet_id);
        }
        $data['suppliers'] = $this->Common_model->getAllSupplierNameMobile();
        $data['main_content'] = $this->load->view('supplierPayment/supplierPayments', $data, TRUE);
        $this->load->view('userHome', $data);
    }


    /**
     * print_invoice
     * @access public
     * @param int
     * @return void
     */
    function print_invoice($id){
        $data = array();
        $data['receipt_object']=$this->get_information_of_a_receive($id);
        $data['outlet_info'] = $this->Common_model->getCurrentOutlet();
        $data['company_info'] = getCompanyInfo($this->session->userdata('companyu_id'));
        $this->load->view('supplierPayment/print_invoice',$data);
    }

    /**
     * a4InvoicePDF
     * @access public
     * @param int
     * @return void
     */
    function a4InvoicePDF($id){
        $pdfContent = array();
        $pdfContent['receipt_object'] = $this->get_information_of_a_receive($id);
        $pdfContent['outlet_info'] = $this->Common_model->getCurrentOutlet();
        $pdfContent['company_info'] = getCompanyInfo($this->session->userdata('companyu_id'));
        $mpdf = new \Mpdf\Mpdf();
        $html = $this->load->view('supplierPayment/a4_invoice_pdf',$pdfContent,true);
        $mpdf->WriteHTML($html);
        $mpdf->Output('Supplier Payment - Reference No -' . $pdfContent['receipt_object'][0]->reference_no . '.pdf', "D");
    }
    /**
     * get_information_of_a_receive
     * @access public
     * @param int
     * @return object
     */
    function get_information_of_a_receive($id){
        $id=$this->custom->encrypt_decrypt($id, 'decrypt');
        $receive_information=$this->Supplier_payment_model->getAllById($id, "tbl_supplier_payments");        
        return $receive_information;
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
}
