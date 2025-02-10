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
    # This is Customer Controller
    ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends Cl_Controller {


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
        $this->load->library('excel'); //load PHPExcel library
        $this->Common_model->setDefaultTimezone();
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        //start check access function
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $controller = "147";
        $function = "";
        if($segment_2=="addEditCustomer"){
            $function = "add";
        }elseif($segment_2=="addEditCustomer" && $segment_3){
            $function = "edit";
        }elseif($segment_2=="customerDetails"){
            $function = "view";
        }elseif($segment_2=="deleteCustomer"){
            $function = "delete";
        }elseif($segment_2=="customers" || $segment_2 == "creditCustomers" || $segment_2 == "debitCustomers" || $segment_2 == "sendSMSToDueCustomer" || $segment_2 == "sendSMSForAllDueCustomer"){
            $function = "list";
        }elseif($segment_2=="uploadCustomer" || $segment_2=="ExcelDataAddCustomers" ){
            $function = "bulk_upload";
        }else{
            $this->session->set_flashdata('exception_1',lang('no_access'));
            redirect('Authentication/userProfile');
        }
        if(!checkAccess($controller,$function)){
            $this->session->set_flashdata('exception_1',lang('no_access'));
            redirect('Authentication/userProfile');
        }
        //end check access function
    }

    

    /**
     * addEditCustomer
     * @access public
     * @param int
     * @return void
     */
    public function addEditCustomer($encrypted_id = "") {
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        $company_id = $this->session->userdata('company_id');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $add_more = $this->input->post($this->security->xss_clean('add_more'));
            $this->form_validation->set_rules('name', lang('name'), 'required|max_length[50]');
            if($encrypted_id){
                $this->form_validation->set_rules('phone', lang('phone'), "required|max_length[50]");
                $this->form_validation->set_rules('email', lang('email_address'), "valid_email|max_length[50]");
            }else{
                $this->form_validation->set_rules('phone', lang('phone'), "required|max_length[50]|is_unique[tbl_customers.phone]");
                $this->form_validation->set_rules('email', lang('email_address'), "valid_email|is_unique[tbl_customers.email]");
            }
            $this->form_validation->set_rules('address', lang('address'), "max_length[255]");
            $this->form_validation->set_rules('discount', lang('discount'), "max_length[11]");
            $this->form_validation->set_rules('credit_limit', lang('credit_limit'), "max_length[11]");
            $this->form_validation->set_rules('opening_balance', lang('opening_balance'), "max_length[11]");
            if(collectGST()=="Yes"){
                $this->form_validation->set_rules('gst_number', lang('gst_number'), 'required|max_length[50]');
                $this->form_validation->set_rules('same_or_diff_state', lang('same_or_diff_state'), 'required|max_length[11]');
            }
            if ($this->form_validation->run() == TRUE) {
                $customer_info = array();
                $customer_info['name'] = getPlanText(htmlspecialcharscustom(escapeQuot($this->input->post($this->security->xss_clean('name')))));
                $customer_info['phone'] = escapeQuot($this->input->post($this->security->xss_clean('phone')));
                $customer_info['email'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('email')));
                $customer_info['date_of_birth'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('date_of_birth')));
                $customer_info['date_of_anniversary'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('date_of_anniversary')));
                $customer_info['address'] = getPlanText(htmlspecialcharscustom($this->input->post($this->security->xss_clean('address'))));
                $customer_info['opening_balance'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('opening_balance')));
                $customer_info['opening_balance_type'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('opening_balance_type')));
                $customer_info['credit_limit'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('credit_limit')));
                $customer_info['nid'] = escapeQuot($this->input->post($this->security->xss_clean('nid')));
                $customer_info['group_id'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('group_id')));
                $customer_info['discount'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('discount')));
                $customer_info['price_type'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('price_type')));
                if(collectGST()=="Yes"){
                    $customer_info['gst_number'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('gst_number')));
                    $customer_info['same_or_diff_state'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('same_or_diff_state')));
                }
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
                    redirect('Customer/addEditCustomer');
                }else{
                    redirect('Customer/customers');
                }

            } else {
                if ($id == "") {
                    $data = array();
                     $data['groups'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_customer_groups');
                    $data['main_content'] = $this->load->view('master/customer/addCustomer', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                     $data['groups'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_customer_groups');
                    $data['customer_information'] = $this->Common_model->getDataById($id, "tbl_customers");
                    $data['main_content'] = $this->load->view('master/customer/editCustomer', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                 $data['groups'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_customer_groups');
                $data['main_content'] = $this->load->view('master/customer/addCustomer', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['groups'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_customer_groups');
                $data['customer_information'] = $this->Common_model->getDataById($id, "tbl_customers");
                $data['main_content'] = $this->load->view('master/customer/editCustomer', $data, TRUE);
                $this->load->view('userHome', $data);
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
        $data['customer_details'] = $this->Common_model->getDataById($id, "tbl_customers");
        $data['main_content'] = $this->load->view('master/customer/customerDetails', $data, TRUE);
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
        redirect('Customer/customers');
    }


    /**
     * customers
     * @access public
     * @param no
     * @return void
     */
    public function customers() {
        $data = array();
        $data['customers'] = $this->Common_model->getAllCustomersWithOpeningBalance();
        $data['main_content'] = $this->load->view('master/customer/customers', $data, TRUE);
        $this->load->view('userHome', $data);
    }


    /**
     * uploadCustomer
     * @access public
     * @param no
     * @return void
     */
    public function uploadCustomer(){
        $data = array();
        $data['main_content'] = $this->load->view('master/customer/uploadsCustomer', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    
    /**
     * creditCustomers
     * @access public
     * @param no
     * @return void
     */
    public function creditCustomers() {
        $data = array();
        $data['customers'] = $this->Common_model->getAllCreditCustomers();
        $data['main_content'] = $this->load->view('master/customer/credit_customers', $data, TRUE);
        $this->load->view('userHome', $data);
    }


    /**
     * debitCustomers
     * @access public
     * @param no
     * @return void
     */
    public function debitCustomers() {
        $data = array();
        $data['customers'] = $this->Common_model->getAllDebitCustomers();
        $data['main_content'] = $this->load->view('master/customer/debit_customers', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    
    /**
     * ExcelDataAddCustomers
     * @access public
     * @param no
     * @return void
     */
    public function ExcelDataAddCustomers(){
        $company_id = $this->session->userdata('company_id');
        if ($_FILES['userfile']['name'] != "") {
            if ($_FILES['userfile']['name'] == "Customer_Upload.xlsx") {
                //Path of files were you want to upload on localhost (C:/xampp/htdocs/ProjectName/uploads/excel/)
                $configUpload['upload_path'] = FCPATH . 'assets/upload-sample/excel/';
                $configUpload['allowed_types'] = 'xls|xlsx';
                $configUpload['max_size'] = '5000';
                $this->load->library('upload', $configUpload);
                if ($this->upload->do_upload('userfile')) {
                    $upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
                    $file_name = $upload_data['file_name']; //uploded file name
                    $extension = $upload_data['file_ext'];    // uploded file extension
                    //$objReader =PHPExcel_IOFactory::createReader('Excel5');     //For excel 2003
                    $objReader = PHPExcel_IOFactory::createReader('Excel2007'); // For excel 2007
                    //Set to read only
                    $objReader->setReadDataOnly(true);
                    //Load excel file
                    $objPHPExcel = $objReader->load(FCPATH . 'assets/upload-sample/excel/' . $file_name);
                    $totalrows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();   //Count Numbe of rows avalable in excel
                    $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
                    //loop from first data untill last data
                    if ($totalrows < 54) {
                        $arrayerror = '';
                        for ($i = 4; $i <= $totalrows; $i++) {
                            $name = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(0, $i)->getValue()));
                            $phone = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(1, $i)->getValue()));
                            $email = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(2, $i)->getValue()));
                            $opening_balance = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(3, $i)->getValue()));
                            $opening_balance_type = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(4, $i)->getValue()));
                            $credit_limit = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(5, $i)->getValue()));
                            $discount = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(6, $i)->getValue()));
                            $price_type = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(7, $i)->getValue()));
                            $address = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(8, $i)->getValue()));
                            $dob = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(9, $i)->getValue()));
                            $doa = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(10, $i)->getValue()));
                            if ($name == '') {
                                if ($arrayerror == '') {
                                    $arrayerror.= lang('Row_Number') . " $i " . lang('column_A_required');
                                } else {
                                    $arrayerror.= "<br>" . lang('Row_Number') . " $i " . lang('column_A_required');
                                }
                            }
                            if ($phone == '') {
                                if ($arrayerror == '') {
                                    $arrayerror.= lang('Row_Number') . " $i " . lang('column_B_required');
                                } else {
                                    $arrayerror.= "<br>" . lang('Row_Number') . " $i " . lang('column_B_required');
                                }
                            }
                            if ($email != '' && $this->validateEmail($email)== false) {
                                if ($arrayerror == '') {
                                    $arrayerror.= lang('Row_Number') . " $i " . lang('column_C_required');
                                } else {
                                    $arrayerror.= "<br>" . lang('Row_Number') . " $i " . lang('column_C_required');
                                }
                            }
                        }
                        if ($arrayerror == '') {
                            if(!is_null($this->input->post('remove_previous'))){
                                $this->db->query("DELETE FROM tbl_customers WHERE name != 'Walk-in Customer'");
                            }
                            for ($i = 4; $i <= $totalrows; $i++) {
                                $name = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(0, $i)->getValue()));
                                $phone = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(1, $i)->getValue()));
                                $email = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(2, $i)->getValue()));
                                $opening_balance = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(3, $i)->getValue()));
                                $opening_balance_type = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(4, $i)->getValue()));
                                $credit_limit = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(5, $i)->getValue()));
                                $discount = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(6, $i)->getValue()));
                                $price_type = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(7, $i)->getValue()));
                                $address = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(8, $i)->getValue()));
                                $dob = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(9, $i)->getValue()));
                                $doa = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(10, $i)->getValue()));
                                $customer_info = array();
                                $customer_info['name'] = $name;
                                $customer_info['phone'] = $phone;
                                $customer_info['email'] = $email;
                                $customer_info['opening_balance'] = $opening_balance;
                                $customer_info['opening_balance_type'] = $opening_balance_type;
                                $customer_info['credit_limit'] = $credit_limit;
                                $customer_info['discount'] = $discount;
                                $customer_info['price_type'] = $price_type;
                                $customer_info['address'] = $address;
                                $customer_info['date_of_birth'] = excelDateConverter($dob);
                                $customer_info['date_of_anniversary'] = excelDateConverter($doa);
                                $customer_info['added_date'] = date('Y-m-d H:i:s');
                                $customer_info['user_id'] = $this->session->userdata('user_id');
                                $customer_info['company_id'] = $this->session->userdata('company_id');
                                $this->Common_model->insertInformation($customer_info, "tbl_customers");
                            }
                            unlink(FCPATH . 'assets/upload-sample/excel/' . $file_name); //File Deleted After uploading in database .
                            $this->session->set_flashdata('exception', lang('Imported_successfully'));
                            redirect('Customer/customers');
                        } else {
                            unlink(FCPATH . 'assets/upload-sample/excel/' . $file_name); //File Deleted After uploading in database .
                            $this->session->set_flashdata('exception_err', lang('Required_Data_Missing') . " : $arrayerror");
                        }
                    } else {
                        unlink(FCPATH . 'assets/upload-sample/excel/' . $file_name); //File Deleted After uploading in database .
                        $this->session->set_flashdata('exception_err', lang('Entry_is_more_than_50'));
                    }
                } else {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('exception_err', "$error");
                }
            } else {
                $this->session->set_flashdata('exception_err', lang('customer_bulk_upload_error_and_guide'));
            }
        } else {
            $this->session->set_flashdata('exception_err', lang('File_is_required'));
        }
        redirect('Customer/uploadCustomer');
    }


    /**
     * validateEmail
     * @access public
     * @param string
     * @return string
     */
    function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }


    /**
     * isValidDate
     * @access public
     * @param string
     * @return boolean
     */
    function isValidDate($date){
        if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date)) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * sendSMSToDueCustomer
     * @access public
     * @param no
     * @return json
     */
    public function sendSMSToDueCustomer(){
        $mobile = $this->input->post($this->security->xss_clean('mobile'));
        $message = $this->input->post($this->security->xss_clean('message'));
        try {
            smsSendOnly($message,$mobile); 
            $data = lang('payment_reminder_success');
            $response = [
                'status' => 'success',
                'data' => $data,
            ];
        } catch (Exception $e) {
            $data = lang('payment_reminder_failed');
            $response = [
                'status' => 'error',
                'data' => $data,
            ];
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    /**
     * sendSMSForAllDueCustomer
     * @access public
     * @param no
     * @return json
     */
    public function sendSMSForAllDueCustomer(){
        $getCustomer = $this->input->post($this->security->xss_clean('customer_id'));
        $bulk_message = htmlspecialcharscustom($this->input->post($this->security->xss_clean('bulk_message')));
        try{
            foreach($getCustomer as $key=>$customer){
                $information = explode("||",$customer);
                $name_replace = str_replace('[CUSTOMER_NAME]', $information[0], $bulk_message);
                $message_body = str_replace('[CUSTOMER_DUE]', $information[2], $name_replace);
                smsSendOnly($message_body, $information[1]);
                $data = lang('payment_reminder_success');
                $response = [
                    'status' => 'success',
                    'data' => $data,
                ];
            }
        } catch(Exception $e) {
            $data = lang('payment_reminder_failed');
            $response = [
                'status' => 'error',
                'data' => $data,
            ];
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }


}
