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
  # This is Servicing Controller
  ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Servicing extends Cl_Controller {

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
        
        // start check access function
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $controller = "75";
        $function = "";
        if($segment_2=="addEditServicing"){
            $function = "add";
        }elseif($segment_2 == "addEditServicing" && $segment_3){
            $function = "edit";
        }elseif($segment_2 == "deleteServicing"){
            $function = "delete";
        }elseif($segment_2 == "listServicing"){
            $function = "list";
        }elseif($segment_2 == "changeStatus"){
            $function = "status";
        }elseif($segment_2 == "print_invoice" || $segment_2 == "a4InvoicePDF"){
            $function = "print";
        }else{
            $this->session->set_flashdata('exception_1', lang('no_access'));
            redirect('Authentication/userProfile');
        }
        //helper function call
        if(!checkAccess($controller,$function)){
            $this->session->set_flashdata('exception_1', lang('no_access'));
            redirect('Authentication/userProfile');
        }
        //end check access function

    }


    /**
     * addEditServicing
     * @access public
     * @param int
     * @return void
     */
    public function addEditServicing($encrypted_id = ''){
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        $outlet_id = $this->session->userdata('outlet_id');
        $user_id = $this->session->userdata('user_id');
        $company_id = $this->session->userdata('company_id');

        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $add_more = $this->input->post($this->security->xss_clean('add_more'));
            $customer_id = $this->input->post($this->security->xss_clean('customer_id'));
            $this->form_validation->set_rules('product_name', lang('product_name'), 'required|max_length[55]');
            $this->form_validation->set_rules('product_model', lang('product_model'), 'max_length[55]');
            $this->form_validation->set_rules('problem_description', lang('problem_description'), 'max_length[500]');
            $this->form_validation->set_rules('receiving_date', lang('receiving_date'), 'required|max_length[55]');
            $this->form_validation->set_rules('delivery_date', lang('delivery_date'), 'max_length[55]');
            $this->form_validation->set_rules('customer_id', lang('customer'), 'required|max_length[11]');
            $this->form_validation->set_rules('servicing_charge', lang('servicing_charge'), 'required|max_length[10]');
            $this->form_validation->set_rules('paid_amount', lang('paid_amount'), 'max_length[10]');
            $this->form_validation->set_rules('due_amount', lang('due_amount'), 'max_length[10]');
            $this->form_validation->set_rules('status', lang('status'), 'required|max_length[200]');
            $this->form_validation->set_rules('employee_id', lang('employee'), 'required|max_length[11]');
            $this->form_validation->set_rules('payment_method_id', lang('payment_method'), 'required|max_length[11]');
            if ($this->form_validation->run() == TRUE) {
                $servicing_info = array();
                $servicing_info['product_name'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('product_name')));
                $servicing_info['product_model'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('product_model')));
                $servicing_info['problem_description'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('problem_description')));
                $servicing_info['servicing_charge'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('servicing_charge')));
                $servicing_info['paid_amount'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('paid_amount')));
                $servicing_info['due_amount'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('due_amount')));
                $servicing_info['receiving_date'] = $this->input->post($this->security->xss_clean('receiving_date'));
                $servicing_info['delivery_date'] = $this->input->post($this->security->xss_clean('delivery_date'));
                $servicing_info['customer_id'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('customer_id')));
                $servicing_info['employee_id'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('employee_id')));
                $servicing_info['status'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('status')));
                $servicing_info['payment_method_id'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('payment_method_id')));
                $servicing_info['outlet_id'] =$outlet_id; 
                $servicing_info['user_id'] =$user_id; 
                $servicing_info['company_id'] =$company_id;
                if ($id == "") {
                    $servicing_info['date'] = date('Y-m-d');
                    $servicing_info['added_date'] = date('Y-m-d H:i:s');
                    $this->Common_model->insertInformation($servicing_info, "tbl_servicing");
                    $this->session->set_flashdata('exception', lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($servicing_info, $id, "tbl_servicing");
                    $this->session->set_flashdata('exception',lang('update_success'));
                }
                if($add_more == 'add_more'){
                    redirect('Servicing/addEditServicing');
                }else{
                    redirect('Servicing/listServicing');
                }

            } else {
                if ($id == "") {
                    $data = array();
                    $data['customers'] = $this->Common_model->getAllByCustomerASC();
                    $data['employees'] = $this->Common_model->getAllUsersNameMobile();
                    $data['paymentMethods'] = $this->Common_model->getAllPaymentMethod();
                    $data['main_content'] = $this->load->view('servicing/addServicing', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['customers'] = $this->Common_model->getAllByCustomerASC();
                    $data['employees'] = $this->Common_model->getAllUsersNameMobile();
                    $data['paymentMethods'] = $this->Common_model->getAllPaymentMethod();
                    $data['servicing_details'] = $this->Common_model->getDataById($id, "tbl_servicing");
                    $data['main_content'] = $this->load->view('servicing/editServicing', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['customers'] = $this->Common_model->getAllByCustomerASC();
                $data['employees'] = $this->Common_model->getAllUsersNameMobile();
                $data['paymentMethods'] = $this->Common_model->getAllPaymentMethod();
                $data['main_content'] = $this->load->view('servicing/addServicing', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['customers'] = $this->Common_model->getAllByCustomerASC();
                $data['employees'] = $this->Common_model->getAllUsersNameMobile();
                $data['paymentMethods'] = $this->Common_model->getAllPaymentMethod();
                $data['servicing_details'] = $this->Common_model->getDataById($id, "tbl_servicing");
                $data['main_content'] = $this->load->view('servicing/editServicing', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }

    /**
     * deleteServicing
     * @access public
     * @param int
     * @return void
     */
    public function deleteServicing($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $this->Common_model->deleteStatusChange($id, "tbl_servicing");
        $this->session->set_flashdata('exception',lang('delete_success'));
        redirect('Servicing/listServicing');
    }


    /**
     * listServicing
     * @access public
     * @param no
     * @return void
     */
    public function listServicing(){
        $data = array();
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $status = $this->input->post($this->security->xss_clean('status'));
            $customer_id = $this->input->post($this->security->xss_clean('customer_id'));
            $data['servicing'] = $this->Common_model->getAllServicingProduct($status, $customer_id);
        }else{
            $data['servicing'] = $this->Common_model->getAllServicingProduct('', '');
        }
        $data['customers'] = $this->Common_model->getAllByCustomerASC();
        $data['main_content'] = $this->load->view('servicing/listServicing', $data, TRUE);
        $this->load->view('userHome', $data);
    }


    /**
     * changeStatus
     * @access public
     * @param int
     * @return json
     */
    public function changeStatus($id){
        $current_status = $this->input->post($this->security->xss_clean('current_status'));
        $this->Common_model->statusChange($id, 'status', $current_status, "tbl_servicing");
        $response = [
            'status' => '200',
            'message' => 'Data Successfully Saved',
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    /**
     * print_invoice
     * @access public
     * @param int
     * @return void
     */
    
    function print_invoice($encrypted_id=""){
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        $print_format = $this->session->userdata('print_format');
        $data = array();
        $data['outlet_info'] = $this->Common_model->getCurrentOutlet();
        $data['servicing_details'] = $this->Common_model->getDataById($id, "tbl_servicing");
        $customer_id = $data['servicing_details']->customer_id;
        $data['customer_info'] = $this->Common_model->getCustomerById($customer_id);
        if($print_format == '56mm' || $print_format == '80mm'){
            createDirectory('uploads/qr_code');
            $url_patient = base_url().'Servicing/qr_code_invoice/'.$data['servicing_details']->id;
            $qr_codes_path = "uploads/qr_code/".'servicing-'.$id.".png";
            $this->load->library('phpqrcode/qrlib');
            QRcode::png($url_patient, $qr_codes_path,'',4,1);
        }
        if ($print_format == '56mm') {
            $this->load->view('servicing/print_invoice56mm', $data);
        }elseif($print_format == '80mm') {
            $this->load->view('servicing/print_invoice80mm', $data);
        }elseif($print_format == 'A4 Print'){
            $this->load->view('servicing/print_invoice_a4', $data);
        }elseif($print_format == 'Half A4 Print'){
            $this->load->view('servicing/print_invoice_ha4', $data);
        }elseif($print_format == 'Letter Head'){
            $this->load->view('servicing/print_letter_head', $data);
        }
    }


    /**
     * a4InvoicePDF
     * @access public
     * @param int
     * @return void
     */
    function a4InvoicePDF($encrypted_id=""){
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        $pdfContent = array();
        $pdfContent['outlet_info'] = $this->Common_model->getCurrentOutlet();
        $pdfContent['servicing_details'] = $this->Common_model->getDataById($id, "tbl_servicing");
        $customer_id = $pdfContent['servicing_details']->customer_id;
        $pdfContent['customer_info'] = $this->Common_model->getCustomerById($customer_id);
        $mpdf = new \Mpdf\Mpdf();
        $html = $this->load->view('servicing/a4_invoice_pdf',$pdfContent,true);
        $mpdf->WriteHTML($html);
        $mpdf->Output('Servicing Invoice of ' . ' ' . $pdfContent['customer_info']->name . ' (' . $pdfContent['customer_info']->phone . ')' . '.pdf', "D");
    }

    /**
     * qr_code_invoice
     * @access public
     * @param int
     * @return void
     */
    public function qr_code_invoice($id){
        if(isset($id) && $id){
            $data['servicing_details'] = $this->Common_model->getDataById($id, "tbl_servicing");
            if ($this->session->userdata('print_format') == '56mm') {
                $this->load->view('servicing/print_invoice56mm',$data);
            }elseif ($this->session->userdata('print_format') == '80mm') {
                $this->load->view('servicing/print_invoice80mm',$data);
            }elseif($this->session->userdata('print_format') == 'A4 Print'){
                $this->load->view('servicing/print_invoice_a4_public',$data);
            }elseif($this->session->userdata('print_format') == 'Half A4 Print'){
                $this->load->view('servicing/print_invoice_ha4_public',$data);
            }
        }else{
            echo '<h1 class="red text-center mt-10-per">' . lang('Your_scanned') . lang('QR_code_is_not_valid') . '</h1>';
        }
    }
}
