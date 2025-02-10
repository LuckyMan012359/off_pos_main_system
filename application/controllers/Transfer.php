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
  # This is Transfer Controller
  ###########################################################
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Transfer extends Cl_Controller {


    /**
     * load constructor
     * @access public
     * @return void
     */    
    public function __construct() {
        parent::__construct();
        $this->load->model('Authentication_model');
        $this->load->model('Transfer_model');
        $this->load->model('Sale_model');
        $this->load->model('Master_model');
        $this->load->model('Stock_model');
        $this->load->model('Common_model');
        $this->Common_model->setDefaultTimezone();
        $this->load->library('excel'); //load PHPExcel libraryz
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
        $controller = "125";
        $function = "";
        if(($segment_2=="addEditTransfer") || ($segment_2 == "outletWithoutSessionOutlet" || $segment_2 == "stockCheck" || $segment_2 == "getIMEINumberByOutlet" || $segment_2 == 'bulkImporForTransfer')){
            $function = "add";
        }elseif(($segment_2=="addEditTransfer" && $segment_3) || ($segment_2 == "outletWithoutSessionOutlet" || $segment_2 == "stockCheck" || $segment_2 == "getIMEINumberByOutlet" || $segment_2 == 'bulkImporForTransfer')){
            $function = "edit";
        }elseif($segment_2=="transferDetails"){
            $function = "view";
        }elseif($segment_2=="deleteTransfer"){
            $function = "delete";
        }elseif($segment_2=="transfers" || $segment_2 == "getAjaxData"){
            $function = "list";
        }elseif($segment_2=="changeStatus"){
            $function = "status_change";
        }elseif($segment_2=="printInvoice" || $segment_2 == 'a4InvoicePDF'){
            $function = "challan_invoice";
        }else{
            $this->session->set_flashdata('exception_1', lang('no_access'));
            redirect('Authentication/userProfile');
        }
        if(!checkAccess($controller,$function)){
            $this->session->set_flashdata('exception_1', lang('no_access'));
            redirect('Authentication/userProfile');
        }
    }



    /**
     * addEditTransfer
     * @access public
     * @param int
     * @return void
     */
    public function addEditTransfer($encrypted_id = "") {
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        $outlet_id = $this->session->userdata('outlet_id');
        $company_id = $this->session->userdata('company_id');
        $transfer_info = array();
        if ($id == "") {
            $transfer_info['reference_no'] = $this->Transfer_model->generatePurRefNo($outlet_id);
        } else {
            $transfer_info['reference_no'] = $this->Common_model->getDataById($id, "tbl_transfer")->reference_no;
        }
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $add_more = $this->input->post($this->security->xss_clean('add_more'));
            $this->form_validation->set_rules('reference_no', lang('ref_no'), 'required|max_length[50]');
            $this->form_validation->set_rules('from_outlet_id', lang('from_outlet'), 'required|max_length[50]');
            $this->form_validation->set_rules('to_outlet_id', lang('to_outlet'), 'required|max_length[50]');
            $this->form_validation->set_rules('note_for_sender', lang('note_for_sender'), 'max_length[300]');
            if ($id == "") {
                $this->form_validation->set_rules('status', lang('status'), 'required|max_length[50]');
            }
            $this->form_validation->set_rules('status', lang('select_status'), 'required');
            $this->form_validation->set_rules('date', lang('date'), 'required|max_length[50]');
            if ($this->form_validation->run() == TRUE) {
                $transfer_info['reference_no'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('reference_no')));
                $transfer_info['date'] = $this->input->post($this->security->xss_clean('date'));
                $transfer_info['note_for_sender'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('note_for_sender')));
                $transfer_info['note_for_receiver'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('note_for_receiver')));
                $transfer_info['status'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('status')));
                $transfer_info['user_id'] = $this->session->userdata('user_id');
                $transfer_info['outlet_id'] = $this->session->userdata('outlet_id');
                $transfer_info['company_id'] = $this->session->userdata('company_id');
                if($this->input->post($this->security->xss_clean('received_date'))){
                    $transfer_info['received_date'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('received_date')));
                }
                if ($id == "") {
                    $transfer_info['added_date'] = date('Y-m-d H:i:s');
                    $transfer_info['from_outlet_id'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('from_outlet_id')));
                    $transfer_info['to_outlet_id'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('to_outlet_id')));
                    $transfer_info['outlet_id'] = $this->session->userdata('outlet_id');
                    $transfer_id = $this->Common_model->insertInformation($transfer_info, "tbl_transfer");
                    $this->saveTransferIngredients($_POST['ingredient_id'], $transfer_id, $this->session->userdata('outlet_id'),$transfer_info['to_outlet_id'],$transfer_info['status'],'');
                    $this->session->set_flashdata('exception', lang('insertion_success'));
                } else {
                    $transfer_details = $this->Common_model->getDataById($id, "tbl_transfer");
                    $outlet_id = $this->session->userdata('outlet_id');
                    if($outlet_id!=$transfer_details->to_outlet_id  && $outlet_id==$transfer_details->outlet_id){
                        $transfer_info['from_outlet_id'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('from_outlet_id')));
                        $transfer_info['to_outlet_id'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('to_outlet_id')));
                        $transfer_info['outlet_id'] = $this->session->userdata('outlet_id');
                    }
                    $this->Common_model->updateInformation($transfer_info, $id, "tbl_transfer");
                    $this->Common_model->deletingMultipleFormData('transfer_id', $id, 'tbl_transfer_items');
                    $this->saveTransferIngredients($_POST['ingredient_id'], $id, $transfer_details->outlet_id,$transfer_info['to_outlet_id'],$transfer_info['status'],$transfer_details->to_outlet_id);
                    $this->session->set_flashdata('exception',lang('update_success'));
                }
                
                if($add_more == 'add_more'){
                    redirect('Transfer/addEditTransfer');
                }else{
                    redirect('Transfer/transfers');
                }
            } else {
                if ($id == "") {
                    $data = array();
                    $data['pur_ref_no'] = $this->Transfer_model->generatePurRefNo($outlet_id);
                    $data['items'] = $this->Common_model->getItemWithVariationForDrowdown();
                    $data['outlets'] = $this->Common_model->getAllOutletsASC();
                    $data['main_content'] = $this->load->view('transfer/addTransfer', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['items'] = $this->Common_model->getItemWithVariationForDrowdown();
                    $data['transfer_details'] = $this->Common_model->getDataById($id, "tbl_transfer");
                    $data['food_details'] = $this->Transfer_model->getFoodDetails($id);
                    $data['outlets'] = $this->Common_model->getAllOutletsASC();
                    $data['main_content'] = $this->load->view('transfer/editTransfer', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['pur_ref_no'] = $this->Transfer_model->generatePurRefNo($outlet_id);
                $data['items'] = $this->Common_model->getItemWithVariationForDrowdown();
                $data['outlets'] = $this->Common_model->getAllOutletsASC();
                $data['main_content'] = $this->load->view('transfer/addTransfer', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['items'] = $this->Common_model->getItemWithVariationForDrowdown();
                $data['transfer_details'] = $this->Common_model->getDataById($id, "tbl_transfer");
                $data['food_details'] = $this->Transfer_model->getFoodDetails($id);
                $data['outlets'] = $this->Common_model->getAllOutletsASC();
                $data['main_content'] = $this->load->view('transfer/editTransfer', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }
    /**
     * saveTransferIngredients
     * @access public
     * @param string
     * @param int
     * @param int
     * @param int
     * @param string
     * @param int
     * @return void
     */
    public function saveTransferIngredients($transfer_ingredients, $transfer_id, $from_outlet,$to_outlet,$status,$to_outlet_id='') {
        foreach ($transfer_ingredients as $row => $ingredient_id):
            $data_sale_consumptions_detail = array();
            $data_sale_consumptions_detail['status'] = $status;
            $data_sale_consumptions_detail['ingredient_id'] = $_POST['ingredient_id'][$row];
            $data_sale_consumptions_detail['quantity_amount'] = $_POST['quantity_amount'][$row];
            $data_sale_consumptions_detail['transfer_id'] = $transfer_id;
            $data_sale_consumptions_detail['item_type'] = $_POST['item_type'][$row];
            $data_sale_consumptions_detail['from_outlet_id'] = $from_outlet;
            if($to_outlet_id!=''){
                $data_sale_consumptions_detail['to_outlet_id'] = $to_outlet_id;
            }else{
                $data_sale_consumptions_detail['to_outlet_id'] = $to_outlet;
            }
            if (isset($_POST['expiry_imei_serial'])){
                $data_sale_consumptions_detail['expiry_imei_serial'] = $_POST['expiry_imei_serial'][$row];
            }
            $data_sale_consumptions_detail['outlet_id'] = $this->session->userdata('outlet_id');
            $data_sale_consumptions_detail['company_id'] = $this->session->userdata('company_id');
            $data_sale_consumptions_detail['del_status'] = 'Live';
            $this->db->insert('tbl_transfer_items',$data_sale_consumptions_detail);
        endforeach;

    }
    /**
     * transferDetails
     * @access public
     * @param int
     * @return void
     */
    public function transferDetails($id) {
        $encrypted_id = $id;
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $data = array();
        $data['encrypted_id'] = $encrypted_id;
        $data['transfer_details'] = $this->Common_model->getDataById($id, "tbl_transfer");
        $data['food_details'] = $this->Transfer_model->getFoodDetails($id);
        $data['main_content'] = $this->load->view('transfer/transferDetails', $data, TRUE);
        $this->load->view('userHome', $data);
    }


    /**
     * deleteTransfer
     * @access public
     * @param int
     * @return void
     */
    public function deleteTransfer($id) {
        $role = $this->session->userdata('role');
        if($role == "1"){
            $id = $this->custom->encrypt_decrypt($id, 'decrypt');
            $this->Common_model->deleteStatusChangeWithChild($id, $id, "tbl_transfer", "tbl_transfer_items", 'id', 'transfer_id');
            $this->session->set_flashdata('exception', lang('delete_success'));
        }else{
            $this->session->set_flashdata('exception_error', lang('error_transfer'));
        }
        redirect('Transfer/transfers');
    }



    /**
     * transfers
     * @access public
     * @param no
     * @return void
     */
    public function transfers() {
        $data = array();
        $data['main_content'] = $this->load->view('transfer/transfers', $data, TRUE);
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
        $outlet_id = $this->session->userdata('outlet_id');
        $transfers = $this->Transfer_model->make_datatables($company_id, $outlet_id);
        if ($transfers && !empty($transfers)) {
            $i = count($transfers);
        }
        $data = array();
        foreach($transfers as $transfer){
            $sub_array = array();
            $sub_array[] = $i--;
            $reference = '';
            $reference .= '<div>' . escape_output($transfer->reference_no) . '</div>';
            if ($transfer->status == 3 && $outlet_id != $transfer->from_outlet_id) {
                $reference .= '<div><img src="' . base_url() . 'assets/gif/new-transfer.gif"></div>';
            }
            $sub_array[] = ($reference);
            $sub_array[] = dateFormat($transfer->date);
            $sub_array[] = escape_output($transfer->from_outlet_name);
            $sub_array[] = escape_output($transfer->to_outlet_name);
            $status='';
            $status .= '<div data_id="' . escape_output($transfer->id) . '">
                <div class="form-group ' . ($transfer->status == '1' ? 'pointer-events-none' : '') . '">
                    <select name="status_trigger" id="status_trigger" class="form-control select2">';
                        if ($transfer->from_outlet_id == $outlet_id) {
                            $status .= '<option ' . ($transfer->status == '2' ? 'selected' : '') . ' value="2">' . lang('draft') . '</option>';
                            $status .= '<option ' . ($transfer->status == '3' ? 'selected' : '') . ' value="3">' . lang('sent') . '</option>';
                            $status .= '<option ' . ($transfer->from_outlet_id == $outlet_id ? 'disabled' : '') . ' ' . ($transfer->status == '1' ? 'selected' : '') . ' value="1">' . lang('received') . '</option>';
                        }
                        if ($transfer->to_outlet_id == $outlet_id) {
                            $status .= '<option ' . ($transfer->status == '3' ? 'selected' : '') . ' value="1">' . lang('send') . '</option>';
                            $status .= '<option ' . ($transfer->status == '1' ? 'selected' : '') . ' value="1">' . lang('received') . '</option>';
                        }
            $status .= '</select>
                </div>
            </div>';
            $sub_array[] = $status;
            $sub_array[] = dateFormat($transfer->received_date);
            $sub_array[] = escape_output($transfer->added_by);
            $sub_array[] = dateFormat($transfer->added_date);
            $html = '';
            $html .= ' <a class="btn btn-deep-purple" href="'.base_url().'Transfer/printInvoice/'.($this->custom->encrypt_decrypt($transfer->id, 'encrypt')).'" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="'. lang('challan_invoice') .'">
            <i class="fas fa-print"></i></a>';

            $html .= '<a class="btn btn-unique" href="' . base_url() . 'Transfer/a4InvoicePDF/' . $this->custom->encrypt_decrypt($transfer->id, 'encrypt') . '" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="' . lang('download_invoice') . '">
            <i class="fas fa-download"></i>
            </a>';

            $html .= ' <a class="btn btn-cyan" href="'.base_url().'Transfer/transferDetails/'.($this->custom->encrypt_decrypt($transfer->id, 'encrypt')).'" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="'. lang('view_details') .'">
            <i class="far fa-eye"></i></a>';
            if ($transfer->status != 1) {
                if ($transfer->from_outlet_id == $outlet_id) {
                    $html .= ' <a class="btn btn-warning" href="'.base_url().'Transfer/addEditTransfer/'.($this->custom->encrypt_decrypt($transfer->id, 'encrypt')).'" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="'. lang('edit') .'">
                    <i class="far fa-edit"></i></a>';
                }
            }
            if ($transfer->from_outlet_id == $outlet_id) {
                $html .= ' <a class="delete btn btn-danger" href="'.base_url().'Transfer/deleteTransfer/'.($this->custom->encrypt_decrypt($transfer->id, 'encrypt')).'" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="'. lang('delete') .'">
                <i class="fa-regular fa-trash-can"></i></a>';
            }
            $sub_array[] = '
            <div class="btn_group_wrap">
                '. $html .'
            </div>';
            $data[] = $sub_array;
        }
        $output = array(
            "recordsTotal" => $this->Transfer_model->get_all_data($company_id, $outlet_id),
            "recordsFiltered" => $this->Transfer_model->get_filtered_data($company_id, $outlet_id),
            "data" => $data
        );
        echo json_encode($output);
    }

    /**
     * changeStatus
     * @access public
     * @param no
     * @return void
     */
    public function changeStatus(){
        $id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('get_id')));
        $type = htmlspecialcharscustom($this->input->post($this->security->xss_clean('type_val')));
        $data = array();
        $data_details = array();
        $data['status'] = $type;
        $data_details['status'] = $type;
        if($type == 1){
            $data['received_date'] = date("Y-m-d h:i:s");
        }
        $this->Common_model->updateInformation($data, $id, 'tbl_transfer');
        $this->Common_model->updateInformationByColumn($data_details, $id, 'transfer_id', 'tbl_transfer_items');
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
        $data['transfer'] = $this->Common_model->getDataById($id, "tbl_transfer");
        $data['from_outlet'] = getOutletInfoById($data['transfer']->from_outlet_id);
        $data['to_outlet'] = getOutletInfoById($data['transfer']->to_outlet_id);
        $data['user_info'] = $this->Common_model->getDataById($data['transfer']->user_id, 'tbl_users');
        $data['transfer_details'] = $this->Common_model->getDataByField($id, "tbl_transfer_items", 'transfer_id');
        $this->load->view('transfer/print_invoice_a4', $data);
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
        $pdfContent['transfer'] = $this->Common_model->getDataById($id, "tbl_transfer");
        $pdfContent['transfer_details'] = $this->Common_model->getDataByField($id, "tbl_transfer_items", 'transfer_id');
        $pdfContent['from_outlet'] = getOutletInfoById($pdfContent['transfer']->from_outlet_id);
        $pdfContent['to_outlet'] = getOutletInfoById($pdfContent['transfer']->to_outlet_id);
        $pdfContent['user_info'] = $this->Common_model->getDataById($pdfContent['transfer']->user_id, 'tbl_users');
        $pdfContent['company_info'] = getCompanyInfo($this->session->userdata('company_id'));
        $mpdf = new \Mpdf\Mpdf();
        $html = $this->load->view('transfer/a4_invoice_pdf',$pdfContent,true);
        $mpdf->WriteHTML($html);
        $mpdf->Output('Transfer - Reference No -' . $pdfContent['transfer']->reference_no . '.pdf', "D");
    }


    /**
     * outletWithoutSessionOutlet
     * @access public
     * @param int
     * @return json
     */
    public function outletWithoutSessionOutlet($id) {
        $outlets = $this->Common_model->outletWithoutSessionOutlet($id);
        $response = [
            'status' => 'success',
            'data' => $outlets,
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    /**
     * stockCheck
     * @access public
     * @param int
     * @return json
     */
    public function stockCheck($id){
        $stock = $this->Stock_model->getStock('', $id, '','','');
        // pre($stock);
        $totalStock = 0;
        if (!empty($stock) && isset($stock)):
            foreach ($stock as $key => $value):
                $i_sale = $this->session->userdata('i_sale');
                $total_installment_sale = 0;
                if(isset($i_sale) && $i_sale=="Yes"){
                    $total_installment_sale = $value->total_installment_sale;
                }
                $totalStock = ($value->total_purchase * $value->conversion_rate) - $value->total_damage - $total_installment_sale - $value->total_sale  - $value->total_purchase_return + $value->total_sale_return  + $value->total_opening_stock;
            endforeach;
        endif;
        echo json_encode($totalStock);
    }


    /**
     * getIMEINumberByOutlet
     * @access public
     * @param no
     * @return json
     */
    public function getIMEINumberByOutlet(){
        $item_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('item_id')));
        $outlet_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('outlet_id')));
        $result = $this->Common_model->getIMEINumberByOutlet($item_id, $outlet_id);
        $response = [
            'status' => 'success',
            'data' => $result,
        ];	
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }


    /**
     * bulkImporForTransfer
     * @access public
     * @param no
     * @return json
     */
    public function bulkImporForTransfer(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['file'];
                $item_id = $_POST['item_id'];
                $item_type = $_POST['item_type'];
                $parepare_arr = [];
                if ($file['name'] == "Transfer_Bulk_Import.xlsx") {
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

                        $excel_data_unit_arr = [];
                        if ($totalrows >= 4 && $totalrows < 54) {
                            $imei_of_items = getIMEISerial($item_id);
                            $available_imei = '';
                            if($imei_of_items){
                                $available_imei = explode('||', $imei_of_items->allimei);
                            }
                            $arrayerror = '';
                            for ($i = 4; $i <= $totalrows; $i++) {
                                $imei = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(0, $i)->getValue() ?? '')); //Excel Column 0//Required
                                array_push($excel_data_unit_arr, $imei);
                                if($available_imei != ''){
                                    if (!in_array($imei, $available_imei)) {
                                        if($arrayerror == ''){
                                            $arrayerror.= lang('Row_Number') . ' ' . "$i" . ': ' . "$imei This IMEI Not Exist in our record!";
                                        }else{
                                            $arrayerror.= "<br>" . lang('Row_Number') . ' ' . "$i" . ': ' . "$imei This IMEI Not Exist in our record!";
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

                            $valueCounts = array_count_values($excel_data_unit_arr);
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
