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
    # This is Quotation Controller
    ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Quotation extends Cl_Controller {
    /**
     * load constructor
     * @access public
     * @return void
     */    
    public function __construct() {
        parent::__construct();
        
        $this->load->model('Authentication_model');
        $this->load->model('Quotation_model');
        $this->load->model('Stock_model');
        $this->load->model('Common_model');
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
        $controller = "";
        $function = "";
        if($segment_2=="addEditQuotation" || $segment_2 == "getStockAlertListForPurchase"){
            $controller = "239";
            $function = "add";
        }elseif($segment_2=="addEditQuotation" && $segment_3 || "getStockAlertListForPurchase"){
            $controller = "239";
            $function = "edit";
        }elseif($segment_2=="quotationDetails"){
            $controller = "239";
            $function = "view";
        }elseif($segment_2=="deleteQuotation"){
            $controller = "239";
            $function = "delete";
        }elseif($segment_2=="quotations" || $segment_2 == "getAjaxData" || $segment_2 == "getQuotationItems"){
            $controller = "239";
            $function = "list";
        }elseif($segment_2=="printInvoice" || $segment_2 == "a4InvoicePDF" || $segment_2 == "downloadAttachment" || $segment_2 == 'quotationMailSend'){
            $controller = "239";
            $function = "print";
        }elseif($segment_2=="addNewCustomerByAjax"){
            $controller = "239";
            $function = "add";
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
     * addEditQuotation
     * @access public
     * @param int
     * @return void
     */
    public function addEditQuotation($encrypted_id = "") {
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        $outlet_id = $this->session->userdata('outlet_id');
        $company_id = $this->session->userdata('company_id');
        $quotation_info = array();
        if ($id == "") {
            $quotation_info['reference_no'] = $this->Quotation_model->generateQuotationRefNo($outlet_id);
        } else {
            $quotation_info['reference_no'] = $this->Common_model->getDataById($id, "tbl_quotations")->reference_no;
        }
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $add_more = $this->input->post($this->security->xss_clean('add_more'));
            $save_download = $this->input->post($this->security->xss_clean('save_download'));
            $save_email = $this->input->post($this->security->xss_clean('save_email'));
            $save_print = $this->input->post($this->security->xss_clean('save_print'));

            $this->form_validation->set_rules('reference_no', lang('ref_no'), 'required|max_length[50]');
            $this->form_validation->set_rules('customer_id', lang('customer'), 'required|max_length[50]');
            $this->form_validation->set_rules('date', lang('date'), 'required|max_length[50]');
            $this->form_validation->set_rules('note', lang('note'), 'max_length[300]');
            if ($this->form_validation->run() == TRUE) {
                $quotation_info['reference_no'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('reference_no')));
                $quotation_info['customer_id'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('customer_id')));
                $quotation_info['date'] = $this->input->post($this->security->xss_clean('date'));
                $quotation_info['note'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('note')));
                $quotation_info['other'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('other')));
                $quotation_info['grand_total'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('grand_total')));
                $quotation_info['note'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('note')));
                $quotation_info['discount'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('discount')));
                $quotation_info['user_id'] = $this->session->userdata('user_id');
                $quotation_info['outlet_id'] = $this->session->userdata('outlet_id');
                $quotation_info['company_id'] = $this->session->userdata('company_id');
                
                if ($id == "") {
                    $quotation_info['added_date'] = date('Y-m-d H:i:s');
                    $quotation_id = $this->Common_model->insertInformation($quotation_info, "tbl_quotations");
                    $this->saveQuotationDetails($_POST['item_id'], $quotation_id, 'tbl_quotation_details');
                    $this->session->set_flashdata('exception', lang('insertion_success'));
                    if($save_download == 'save_download'){
                        $encrypt_id = $this->custom->encrypt_decrypt($quotation_id, 'encrypt');
                        $this->a4InvoicePDF($encrypt_id);
                    }
                    if($save_email == 'save_email'){
                        $this->quotationMailSend($quotation_id);
                    }
                    if($save_print == 'save_print'){
                        $encrypt_id = $this->custom->encrypt_decrypt($quotation_id, 'encrypt');
                        redirect('Quotation/printInvoice/'.$encrypt_id);
                    }
                } else {
                    $this->Common_model->updateInformation($quotation_info, $id, "tbl_quotations");
                    $this->Common_model->deletingMultipleFormData('quotation_id', $id, 'tbl_quotation_details');
                    $this->saveQuotationDetails($_POST['item_id'], $id, 'tbl_quotation_details');
                    $this->session->set_flashdata('exception',lang('update_success'));
                    if($save_download == 'save_download'){
                        $encrypt_id = $this->custom->encrypt_decrypt($id, 'encrypt');
                        $this->a4InvoicePDF($encrypt_id);
                    }
                    if($save_email == 'save_email'){
                        $this->quotationMailSend($id);
                    }
                    if($save_print == 'save_print'){
                        $encrypt_id = $this->custom->encrypt_decrypt($id, 'encrypt');
                        redirect('Quotation/printInvoice/'.$encrypt_id);
                    }
                }
                if($add_more == 'add_more'){
                    redirect('Quotation/addEditQuotation');
                }else{
                    redirect('Quotation/quotations');
                }
            } else {
                if ($id == "") {
                    $data = array();
                    $data['pur_ref_no'] = $this->Quotation_model->generateQuotationRefNo($outlet_id);
                    $data['customers'] = $this->Common_model->getAllCustomerNameMobile();
                    $data['groups'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_customer_groups');
                    $data['items'] = $this->Common_model->getItemWithVariationForDrowdown();
                    $data['main_content'] = $this->load->view('quotation/addQuotation', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['quotation_details'] = $this->Common_model->getDataById($id, "tbl_quotations");
                    $data['customers'] = $this->Common_model->getAllCustomerNameMobile();
                    $data['groups'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_customer_groups');
                    $data['items'] = $this->Common_model->getItemWithVariationForDrowdown();
                    $data['quotation_items'] = $this->Quotation_model->getQuotationItems($id);
                    $data['main_content'] = $this->load->view('quotation/editQuotation', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['pur_ref_no'] = $this->Quotation_model->generateQuotationRefNo($outlet_id);
                $data['customers'] = $this->Common_model->getAllCustomerNameMobile();
                $data['groups'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_customer_groups');
                $data['items'] = $this->Common_model->getItemWithVariationForDrowdown();
                $data['main_content'] = $this->load->view('quotation/addQuotation', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['quotation_details'] = $this->Common_model->getDataById($id, "tbl_quotations");
                $data['customers'] = $this->Common_model->getAllCustomerNameMobile();
                $data['groups'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_customer_groups');
                $data['items'] = $this->Common_model->getItemWithVariationForDrowdown();
                $data['quotation_items'] = $this->Quotation_model->getQuotationItems($id);
                $data['main_content'] = $this->load->view('quotation/editQuotation', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }

    

    /**
     * saveQuotationDetails
     * @access public
     * @param string
     * @param int
     * @param string
     * @return void
     */
    public function saveQuotationDetails($quotation_items, $quotation_id, $table_name) {
        foreach ($quotation_items as $row => $item_id):
            $fmi = array();
            $fmi['item_id'] = $_POST['item_id'][$row];
            $fmi['item_type'] = $_POST['item_type'][$row];
            if (isset($_POST['expiry_imei_serial'])){
                $fmi['expiry_imei_serial'] = $_POST['expiry_imei_serial'][$row];
            }
            $fmi['unit_price'] = $_POST['unit_price'][$row];
            $fmi['quantity_amount'] = $_POST['quantity_amount'][$row];
            $fmi['total'] = $_POST['total'][$row];
            $fmi['quotation_id'] = $quotation_id;
            $fmi['outlet_id'] = $this->session->userdata('outlet_id');
            $fmi['company_id'] = $this->session->userdata('company_id');
            $this->Common_model->insertInformation($fmi, "tbl_quotation_details");
        endforeach;
    }


    /**
     * quotationDetails
     * @access public
     * @param int
     * @return void
     */
    public function quotationDetails($id) {
        $encrypted_id = $id;
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $data = array();
        $data['encrypted_id'] = $encrypted_id;
        $data['quotation_details'] = $this->Common_model->getDataById($id, "tbl_quotations");
        $data['quotation_items'] = $this->Quotation_model->getQuotationItems($id);
        $data['main_content'] = $this->load->view('quotation/quotationDetails', $data, TRUE);
        $this->load->view('userHome', $data);
    }


    
    /**
     * deleteQuotation
     * @access public
     * @param int
     * @return void
     */
    public function deleteQuotation($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $this->Common_model->deleteStatusChangeWithChild($id, $id, "tbl_quotations", "tbl_quotation_details", 'id', 'quotation_id');
        $this->session->set_flashdata('exception', lang('delete_success'));
        redirect('Quotation/quotations');
    }


    /**
     * quotations
     * @access public
     * @param no
     * @return void
     */
    public function quotations() {
        $outlet_id = $this->session->userdata('outlet_id');
        $data = array();
        $data['quotations'] = $this->Common_model->getAllByOutletId($outlet_id, "tbl_quotations");
        $data['main_content'] = $this->load->view('quotation/quotation', $data, TRUE);
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
        $quotations = $this->Quotation_model->make_datatables($company_id);
        if ($quotations && !empty($quotations)) {
            $i = count($quotations);
        }
        $data = array();
        foreach($quotations as $quotation){
            $sub_array = array();
            $sub_array[] = $i--;
            $sub_array[] = escape_output($quotation->reference_no);
            $sub_array[] = dateFormat($quotation->added_date);
            $sub_array[] = escape_output($quotation->customer_name);
            $sub_array[] = ($quotation->discount);
            $sub_array[] = getAmtCustom($quotation->grand_total);
            $sub_array[] = escape_output($quotation->added_by);
            $sub_array[] = dateFormat($quotation->added_date);
            $html = '';
            
            $html .= '<a class="btn btn-deep-purple" href="' . base_url() . 'Quotation/printInvoice/' . $this->custom->encrypt_decrypt($quotation->id, 'encrypt') . '" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="' . lang('print_invoice') . '">
                <i class="fas fa-print"></i>
            </a>';
            $html .= '<a class="btn btn-unique" href="' . base_url() . 'Quotation/a4InvoicePDF/' . $this->custom->encrypt_decrypt($quotation->id, 'encrypt') . '" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="' . lang('download_invoice') . '">
                <i class="fas fa-download"></i>
            </a>';

            $html .= '<a class="btn btn-cyan" href="' . base_url() . 'Quotation/quotationDetails/' . $this->custom->encrypt_decrypt($quotation->id, 'encrypt') . '" data-bs-toggle="tooltip" data-bs-placement="top"
                data-bs-original-title="'. lang('view_details') .'">
                <i class="far fa-eye"></i>
            </a>';
            
            $html .= '<a class="btn btn-warning" href="' . base_url() . 'Quotation/addEditQuotation/' . $this->custom->encrypt_decrypt($quotation->id, 'encrypt') . '" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="' . lang('edit') . '">
                <i class="far fa-edit"></i>
            </a>';

            $html .= '<a class="delete btn btn-danger" href="' . base_url() . 'Quotation/deleteQuotation/' . $this->custom->encrypt_decrypt($quotation->id, 'encrypt') . '" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="' . lang('delete') . '">
                <i class="fa-regular fa-trash-can"></i>
            </a>';

            $sub_array[] = '
            <div class="btn_group_wrap">
            '.$html.'
            </div>';
            $data[] = $sub_array;
        }
        $output = array(
            "recordsTotal" => $this->Quotation_model->get_all_data($company_id),
            "recordsFiltered" => $this->Quotation_model->get_filtered_data($company_id),
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
        $data['quotation_details'] = $this->Common_model->getDataById($id, "tbl_quotations");
        $data['quotation_items'] = $this->Quotation_model->getQuotationItems($id);
        $data['outlet_info'] = $this->Common_model->getCurrentOutlet();
        $data['company_info'] = getCompanyInfo($this->session->userdata('company_id'));
        $this->load->view('quotation/print_invoice_a4', $data);
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
        $pdfContent['quotation_details'] = $this->Common_model->getDataById($id, "tbl_quotations");
        $pdfContent['quotation_items'] = $this->Quotation_model->getQuotationItems($id);
        $pdfContent['outlet_info'] = $this->Common_model->getCurrentOutlet();
        $pdfContent['company_info'] = getCompanyInfo($this->session->userdata('company_id'));
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
        $html = $this->load->view('quotation/a4_invoice_pdf',$pdfContent,true);
        $mpdf->WriteHTML($html);
        $mpdf->Output('Quotation Reference No -' . $pdfContent['quotation_details']->reference_no . '.pdf', "D");
    }

    /**
     * quotationMailSend
     * @access public
     * @param int
     * @return void
     */
    public function quotationMailSend($quatation_id){
        $pdfContent = array();
        $pdfContent['quotation_details'] = $this->Common_model->getQuotationInfo($quatation_id);
        $pdfContent['quotation_items'] = $this->Common_model->getAllQuotationDetails($quatation_id);
        $customer_email = $pdfContent['quotation_details']->customer_email;
        $customer_name = $pdfContent['quotation_details']->customer_name;
        $pdfContent['outlet_info'] = $this->Common_model->getCurrentOutlet();
        $pdfContent['company_info'] = getCompanyInfo($this->session->userdata('company_id'));
        $mpdf = new \Mpdf\Mpdf();
        $html = $this->load->view('PDF/quatation-invoice-pdf',$pdfContent, TRUE);
        $mpdf->WriteHTML($html);

        // Make Directory If Does't exist
        if(createDirectory('uploads/quatation-invoice-pdf')){
            $mpdf->Output('uploads/quatation-invoice-pdf/quatation-invoice-pdf'. $quatation_id . '.pdf');
            if($customer_email != ''){
                $mail_data = [];
                $mail_data['to'] = ["$customer_email"];
                $mail_data['subject'] = lang('Quotation_for_Product_Purchase_Inquiry');
                $mail_data['customer_name'] = $customer_name;
                $mail_data['file_name'] = 'Attachment.pdf';
                $file_v_path = base_url() . 'uploads/quatation-invoice-pdf/quatation-invoice-pdf' . $quatation_id . '.pdf';
                $file_v_path2 = ('uploads/quatation-invoice-pdf/quatation-invoice-pdf' . $quatation_id . '.pdf');
                $mail_data['file_path'] = $file_v_path;
                $mail_data['template'] = $this->load->view('mail-template/quatation-invoice-template', $mail_data, TRUE);
                $company = getMainCompany();
                if($company->smtp_enable_status == 1){
                    if($company->smtp_type == "Sendinblue"){
                        sendInBlue($mail_data);
                    }else{
                        sendEmailOnly($mail_data['subject'],$mail_data['template'],$customer_email,$file_v_path2,$mail_data['file_name'], $company->id);
                    }
                } else {
                    $this->session->set_flashdata('exception_1', lang('your_smtp_not_configured'));
                }
            }
        } else {
            echo "Something went wrong";
        }
    }




    /**
     * addNewCustomerByAjax
     * @access public
     * @param no
     * @return json
     */
    function addNewCustomerByAjax() {
        $fmc_info = array();
        $fmc_info['name'] = ($this->input->post($this->security->xss_clean('name')));
        $fmc_info['contact_person'] = $this->input->post($this->security->xss_clean('contact_person'));
        $fmc_info['phone'] = $this->input->post($this->security->xss_clean('phone'));
        $fmc_info['email'] = $this->input->post($this->security->xss_clean('email'));
        $fmc_info['opening_balance'] = $this->input->post($this->security->xss_clean('opening_balance'));
        $fmc_info['opening_balance_type'] = $this->input->post($this->security->xss_clean('opening_balance_type'));
        $fmc_info['description'] = $this->input->post($this->security->xss_clean('customer_description'));
        $fmc_info['address'] = $this->input->post($this->security->xss_clean('customer_address'));
        $fmc_info['added_date'] = date('Y-m-d H:i:s');
        $fmc_info['user_id'] = $this->session->userdata('user_id');
        $fmc_info['company_id'] = $company_id = $this->session->userdata('company_id');
        $id = $this->Common_model->insertInformation($fmc_info, "tbl_customers");
        if($id){
            $return_data['id'] = $id;
            $return_data['customers'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_customers');
        }
        echo json_encode($return_data);
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
        echo '<option value="">'. lang('select') .'</option>';
        foreach ($data1 as $value) {
            echo '<option value="' . $value->id . '" >' . $value->name . '</option>';
        }
    }





    /**
     * getQuotationItems
     * @access public
     * @param no
     * @return json
     */
    public function getQuotationItems(){
        $quotation_id = $this->input->post($this->security->xss_clean('quotation_id'));
        $id = $this->custom->encrypt_decrypt($quotation_id, 'decrypt');
        $results = $this->db->query("SELECT i.code, i.name as child_name, ii.name as parent_name 
            FROM tbl_quotation_details pd
            LEFT JOIN tbl_items i ON pd.item_id = i.id
            LEFT JOIN tbl_items ii ON i.parent_id = ii.id
            WHERE pd.quotation_id = $id 
            AND pd.del_status = 'Live'
        ")->result();
        $response = [
            'status' => 'success',
            'data' => $results,
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($response));

    }
}
