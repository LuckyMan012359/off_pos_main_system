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
    # This is Supplier Controller
    ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier extends Cl_Controller {

    /**
     * load constructor
     * @access public
     * @return void
     */    
    public function __construct() {
        parent::__construct();
        $this->load->model('Authentication_model');
        $this->load->model('Common_model');
        $this->load->library('excel'); //load PHPExcel library
        $this->load->library('form_validation');
        $this->Common_model->setDefaultTimezone();
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        //start check access function
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $controller = "117";
        $function = "";
        if($segment_2=="addEditSupplier"){
            $function = "add";
        }elseif($segment_2=="addEditSupplier" && $segment_3){
            $function = "edit";
        }elseif($segment_2=="supplierDetails"){
            $function = "view";
        }elseif($segment_2=="deleteSupplier"){
            $function = "delete";
        }elseif($segment_2=="suppliers"){
            $function = "list";
        }elseif($segment_2=="uploadSupplier" || $segment_2=="ExcelDataAddSuppliers" ){
            $function = "bulk_upload";
        }elseif($segment_2=="debitSuppliers"){
            $function = "debit_supplier";
        }elseif($segment_2=="creditSuppliers"){
            $function = "credit_supplier";
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
     * addEditSupplier
     * @access public
     * @param int
     * @return void
     */
    public function addEditSupplier($encrypted_id = "") {
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $add_more = $this->input->post($this->security->xss_clean('add_more'));
            $this->form_validation->set_rules('name', lang('name'), 'required|max_length[50]');
            $this->form_validation->set_rules('contact_person', lang('contact_person'), 'required|max_length[50]');
            $this->form_validation->set_rules('phone', lang('phone'), 'required|max_length[50]');
            $this->form_validation->set_rules('description',lang('description'), 'max_length[255]');
            $this->form_validation->set_rules('email', lang('email_address'), "valid_email|max_length[50]");
            $this->form_validation->set_rules('opening_balance', lang('opening_balance'), 'max_length[11]');
            $this->form_validation->set_rules('address', lang('address'), 'max_length[255]');
            if ($this->form_validation->run() == TRUE) {
                $fmc_info = array();
                $fmc_info['name'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('name')));
                $fmc_info['contact_person'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('contact_person')));
                $fmc_info['phone'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('phone')));
                $fmc_info['email'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('email')));
                $fmc_info['address'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('address')));
                $fmc_info['description'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('description')));
                $fmc_info['opening_balance'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('opening_balance')));
                $fmc_info['opening_balance_type'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('opening_balance_type')));
                $fmc_info['user_id'] = $this->session->userdata('user_id');
                $fmc_info['company_id'] = $this->session->userdata('company_id');
                if ($id == "") {
                    $fmc_info['added_date'] = date('Y-m-d H:i:s');
                    $this->Common_model->insertInformation($fmc_info, "tbl_suppliers");
                    $this->session->set_flashdata('exception', lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($fmc_info, $id, "tbl_suppliers");
                    $this->session->set_flashdata('exception',lang('update_success'));
                }
                if($add_more == 'add_more'){
                    redirect('Supplier/addEditSupplier');
                }else{
                    redirect('Supplier/suppliers');
                }
            } else {
                if ($id == "") {
                    $data = array();
                    $data['main_content'] = $this->load->view('master/supplier/addSupplier', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['supplier_information'] = $this->Common_model->getDataById($id, "tbl_suppliers");
                    $data['main_content'] = $this->load->view('master/supplier/editSupplier', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['main_content'] = $this->load->view('master/supplier/addSupplier', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['supplier_information'] = $this->Common_model->getDataById($id, "tbl_suppliers");
                $data['main_content'] = $this->load->view('master/supplier/editSupplier', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }

    /**
     * supplierDetails
     * @access public
     * @param int
     * @return void
     */
    public function supplierDetails($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $data['supplier_details'] = $this->Common_model->getDataById($id, "tbl_suppliers");
        $data['main_content'] = $this->load->view('master/supplier/supplierDetails', $data, TRUE);
        $this->load->view('userHome', $data);
    }


    /**
     * deleteSupplier
     * @access public
     * @param int
     * @return void
     */
    public function deleteSupplier($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $this->Common_model->deleteStatusChange($id, "tbl_suppliers");
        $this->session->set_flashdata('exception', lang('delete_success'));
        redirect('Supplier/suppliers');
    }

    /**
     * suppliers
     * @access public
     * @param no
     * @return void
     */

    public function suppliers() {
        $data = array();
        $data['suppliers'] = $this->Common_model->getAllSuppliersWithOpeningBalance();
        $data['main_content'] = $this->load->view('master/supplier/suppliers', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    /**
     * debitSuppliers
     * @access public
     * @param no
     * @return void
     */
    public function debitSuppliers() {
        $data = array();
        $data['debit_suppliers'] = $this->Common_model->getAllDebitSuppliers();
        $data['main_content'] = $this->load->view('master/supplier/debit_suppliers', $data, TRUE);
        $this->load->view('userHome', $data);
    }
    /**
     * creditSuppliers
     * @access public
     * @param no
     * @return void
     */

    public function creditSuppliers() {
        $data = array();
        $data['credit_suppliers'] = $this->Common_model->getAllCreditSuppliers();
        $data['main_content'] = $this->load->view('master/supplier/credit_suppliers', $data, TRUE);
        $this->load->view('userHome', $data);
    }


    /**
     * uploadSupplier
     * @access public
     * @param no
     * @return void
     */
    public function uploadSupplier(){
        $company_id = $this->session->userdata('company_id');
        $data = array();
        $data['main_content'] = $this->load->view('master/supplier/uploadsSupplier', $data, TRUE);
        $this->load->view('userHome', $data);
    }


    /**
     * ExcelDataAddSuppliers
     * @access public
     * @param no
     * @return void
     */
    public function ExcelDataAddSuppliers(){
        $company_id = $this->session->userdata('company_id');
        if ($_FILES['userfile']['name'] != "") {
            if ($_FILES['userfile']['name'] == "Supplier_Upload.xlsx") {
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
                            $contact_person = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(1, $i)->getValue()));
                            $phone = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(2, $i)->getValue()));
                            $email = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(3, $i)->getValue()));
                            $opening_balance = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(4, $i)->getValue()));
                            $op_balance_type = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(5, $i)->getValue()));
                            $description = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(6, $i)->getValue()));
                            $address = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(7, $i)->getValue()));
                            if ($name == '') {
                                if ($arrayerror == '') {
                                    $arrayerror.= lang('Row_Number') . " $i " . lang('column_A_required');
                                } else {
                                    $arrayerror.= "<br>" . lang('Row_Number') . " $i " . lang('column_A_required');
                                }
                            }
                            if ($contact_person == '') {
                                if ($arrayerror == '') {
                                    $arrayerror.= lang('Row_Number') . " $i " . lang('column_B_required');
                                } else {
                                    $arrayerror.= "<br>" . lang('Row_Number') . " $i " . lang('column_B_required');
                                }
                            }
                            if ($phone == '') {
                                if ($arrayerror == '') {
                                    $arrayerror.= lang('Row_Number') . " $i " . lang('column_C_required');
                                } else {
                                    $arrayerror.= "<br>" . lang('Row_Number') . " $i " . lang('column_C_required');
                                }
                            }
                        }
                        if ($arrayerror == '') {
                            if(!is_null($this->input->post('remove_previous'))){
                                $this->db->query("TRUNCATE table `tbl_suppliers`");
                            }
                            for ($i = 4; $i <= $totalrows; $i++) {
                                $name = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(0, $i)->getValue()));
                                $contact_person = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(1, $i)->getValue()));
                                $phone = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(2, $i)->getValue()));
                                $email = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(3, $i)->getValue()));
                                $opening_balance = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(4, $i)->getValue()));
                                $op_balance_type = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(5, $i)->getValue()));
                                $description = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(6, $i)->getValue()));
                                $address = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(7, $i)->getValue()));
                                $supplier_info = array();
                                $supplier_info['name'] = $name;
                                $supplier_info['contact_person'] = $contact_person;
                                $supplier_info['phone'] = $phone;
                                $supplier_info['email'] = $email;
                                $supplier_info['opening_balance'] = $opening_balance;
                                $supplier_info['opening_balance_type'] = $op_balance_type;
                                $supplier_info['description'] = $description;
                                $supplier_info['address'] = $address;
                                $supplier_info['added_date'] = date('Y-m-d H:i:s');
                                $supplier_info['user_id'] = $this->session->userdata('user_id');
                                $supplier_info['company_id'] = $this->session->userdata('company_id');
                                $this->Common_model->insertInformation($supplier_info, "tbl_suppliers");
                            }
                            unlink(FCPATH . 'assets/upload-sample/excel/' . $file_name); //File Deleted After uploading in database .
                            $this->session->set_flashdata('exception', lang('Imported_successfully'));
                            redirect('Supplier/suppliers');
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
                $this->session->set_flashdata('exception_err', lang('supplier_bulk_upload_error_and_guide'));
            }
        } else {
            $this->session->set_flashdata('exception_err', lang('File_is_required'));
        }
        redirect('Supplier/uploadSupplier');
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

}
