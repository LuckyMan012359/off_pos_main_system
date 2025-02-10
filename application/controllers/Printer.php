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
  # This is Printer Controller
  ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Printer extends Cl_Controller {
    
    /**
     * load constructor
     * @access public
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->model('Authentication_model');
        $this->Common_model->setDefaultTimezone();
        $this->load->library('form_validation');
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $controller = "";
        $function = "";
        if($segment_2=="addEditPrinter"){
            $controller = "14";
            $function = "add";
        }elseif($segment_2=="editPrinter"){
            $controller = "14";
            $function = "edit";
        }elseif($segment_2=="deletePrinter"){
            $controller = "14";
            $function = "delete";
        }elseif($segment_2=="printers" || $segment_2 == "printerSetup"){
            $controller = "14";
            $function = "list";
        }elseif($segment_2 == "assignPrinter" || $segment_2=="listAssignPrinter" || $segment_2 == "changeCashDrawer"){
            $controller = "21";
            $function = "edit";
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
     * addEditPrinter
     * @access public
     * @param no
     * @return json
     */
    public function addEditPrinter() {
        $company_id = $this->session->userdata('company_id');
        $edit_id = htmlspecialcharscustom($this->input->post('edit_id'));
        $type = htmlspecialcharscustom($this->input->post('type'));
        $invoice_print = htmlspecialcharscustom($this->input->post('invoice_print'));
        if($invoice_print == 'live_server_print'){
            if($type == 'network'){
                $this->form_validation->set_rules('printer_ip_address', lang('printer_ip_address'), 'required|max_length[20]');
                $this->form_validation->set_rules('printer_port', lang('printer_port'), 'required|max_length[20]');
            }else{
                $this->form_validation->set_rules('path', lang('path'), 'required|max_length[20]');
            }
            $this->form_validation->set_rules('characters_per_line',  lang('characters_per_line'), 'required|max_length[300]');
            $this->form_validation->set_rules('print_server_url_invoice',  lang('print_server_url_invoice'), 'required|max_length[300]');
        }
        $this->form_validation->set_rules('title',  lang('title'), 'required|max_length[300]');
        $this->form_validation->set_rules('type', lang('type'), 'required|max_length[20]');
        if ($this->form_validation->run() == TRUE) {
            $data= array();
            $data['path'] = htmlspecialcharscustom($this->input->post('path'));
            $data['title'] = htmlspecialcharscustom($this->input->post('title'));
            $data['fiscal_printer_status'] = htmlspecialcharscustom($this->input->post('fiscal_printer_status'));
            $data['type'] = htmlspecialcharscustom($this->input->post('type'));
            $data['profile_'] = "default";
            $data['characters_per_line'] = htmlspecialcharscustom($this->input->post('characters_per_line'));
            $data['printer_ip_address'] = htmlspecialcharscustom($this->input->post('printer_ip_address'));
            $data['printer_port'] = htmlspecialcharscustom($this->input->post('printer_port'));
            $data['print_format_invoice'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('print_format')));
            $data['print_format'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('print_format')));
            $data['qr_code_type'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('qr_code_type')));
            $data['invoice_print'] = htmlspecialcharscustom($this->input->post('invoice_print'));
            $data['print_server_url_invoice'] = htmlspecialcharscustom($this->input->post('print_server_url_invoice'));
            $data['inv_qr_code_status'] = htmlspecialcharscustom($this->input->post('inv_qr_code_status'));
            $data['open_cash_drawer_when_printing_invoice'] = htmlspecialcharscustom($this->input->post('open_cash_drawer_when_printing_invoice'));
            $data['company_id'] = $this->session->userdata('company_id');
            $data['user_id'] = $this->session->userdata('user_id');

            $printer_id = '';
            if ($edit_id) {
                $this->Common_model->updateInformation($data, $edit_id, "tbl_printers");
            } else {
                $data['added_date'] = date('Y-m-d H:i:s');
                $printer_id = $this->Common_model->insertInformation($data, "tbl_printers");
            }
            $return_data = $this->Common_model->getAllByCompanyId($company_id, 'tbl_printers');
            $session_data = [];
            $session_data['print_format'] = htmlspecialcharscustom($this->input->post('print_format'));
            $session_data['characters_per_line'] = htmlspecialcharscustom($this->input->post('characters_per_line'));
            $session_data['printer_ip_address'] = htmlspecialcharscustom($this->input->post('printer_ip_address'));
            $session_data['printer_port'] = htmlspecialcharscustom($this->input->post('printer_port'));
            $session_data['qr_code_type'] = htmlspecialcharscustom($this->input->post('qr_code_type'));
            $session_data['invoice_print'] = htmlspecialcharscustom($this->input->post('invoice_print'));
            $session_data['fiscal_printer_status'] = htmlspecialcharscustom($this->input->post('fiscal_printer_status'));
            $session_data['open_cash_drawer_when_printing_invoice'] = htmlspecialcharscustom($this->input->post('open_cash_drawer_when_printing_invoice'));
            $session_data['print_server_url_invoice'] = htmlspecialcharscustom($this->input->post('print_server_url_invoice'));
            $session_data['inv_qr_code_status'] = htmlspecialcharscustom($this->input->post('inv_qr_code_status'));
            $this->session->set_userdata($session_data);
            $response = [
                'status' => 'success',
                'printer_id' => $printer_id,
                'data' => $return_data,
            ];
            $this->output->set_content_type('application/json')->set_output(json_encode($response));
        }else{
            $response = [
                'status' => 'error',
                'data' => 'Required field are not fill up.',
            ];
            $this->output->set_content_type('application/json')->set_output(json_encode($response));
        }
    }

    /**
     * editPrinter
     * @access public
     * @param no
     * @return json
     */
    public function editPrinter() {
        $item_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('item_id')));
        $return_data = $this->Common_model->getDataById($item_id, 'tbl_printers');
        $response = [
            'status' => 'success',
            'data' => $return_data,
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }


    /**
     * deletePrinter
     * @access public
     * @param int
     * @return json
     */
    public function deletePrinter($id) {
        $company_id = $this->session->userdata('company_id');
        $this->Common_model->deleteStatusChange($id, "tbl_printers");
        $return_data = $this->Common_model->getAllByCompanyId($company_id, 'tbl_printers');
        $response = [
            'status' => 'success',
            'data' => $return_data,
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    /**
     * printers
     * @access public
     * @param no
     * @return json
     */
    public function printers() {
        $company_id = $this->session->userdata('company_id');
        $return_data = $this->Common_model->getAllByCompanyId($company_id, 'tbl_printers');  
        $response = [
            'status' => 'success',
            'data' => $return_data,
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    /**
     * printerSetup
     * @access public
     * @param no
     * @return void
     */
    public function printerSetup(){
        $company_id = $this->session->userdata('company_id');
        $data = array();
        $data['outlet_information'] = $this->Common_model->getDataById($company_id, "tbl_companies");
        $data['zone_names'] = $this->Common_model->getAllForDropdown("tbl_time_zone");
        $data['customers'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_customers");
        $data['printers'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_printers");
        $data['paymentMethods'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_payment_methods");
        $data['cashiers'] = $this->Common_model->getAllCashier($company_id);
        $data['main_content'] = $this->load->view('printer/printer_setup', $data, TRUE);
        $this->load->view('userHome', $data);
    }


   

    /**
     * assignPrinter
     * @access public
     * @param int
     * @return json
     */
    public function assignPrinter($id = '') {
        $outlet_id = $this->session->userdata('outlet_id');
        $company_id = $this->session->userdata('company_id');
        $this->form_validation->set_rules('cashier_id', lang('cashier_id'), 'required|max_length[11]');
        $this->form_validation->set_rules('cashier_printer', lang('cashier_printer'), 'required|max_length[11]');
        $id = htmlspecialcharscustom($this->input->post('cashier_id'));
        if ($this->form_validation->run() == TRUE) {
            $data = array();
            $data['printer_id'] = htmlspecialcharscustom($this->input->post('cashier_printer'));
            $data['outlet_id'] = $outlet_id;
            $data['company_id'] = $company_id;
            $this->Common_model->updateInformation($data, $id, "tbl_users");
            $response = [
                'status' => 'success',
            ];
            $this->output->set_content_type('application/json')->set_output(json_encode($response));
        }
    }

    /**
     * listAssignPrinter
     * @access public
     * @param no
     * @return json
     */
    public function listAssignPrinter(){
        $company_id = $this->session->userdata('company_id');
        $return_data = array();
        $return_data['printers'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_printers");
        $return_data['cashiers'] = $this->Common_model->getAllCashier($company_id);
        $response = [
            'status' => 'success',
            'data' => $return_data,

        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }


    /**
     * changeCashDrawer
     * @access public
     * @param int
     * @return json
     */
    public function changeCashDrawer($id = '') {
        $outlet_id = $this->session->userdata('outlet_id');
        $company_id = $this->session->userdata('company_id');
        $this->form_validation->set_rules('cashier_id', lang('cashier_id'), 'required|max_length[11]');
        $this->form_validation->set_rules('open_cash_drawer', lang('open_cash_drawer'), 'required|max_length[11]');
        $id = htmlspecialcharscustom($this->input->post('cashier_id'));
        if ($this->form_validation->run() == TRUE) {
            $data = array();
            $data['open_cash_drawer'] = htmlspecialcharscustom($this->input->post('open_cash_drawer'));
            $data['outlet_id'] = $outlet_id;
            $data['company_id'] = $company_id;
            $this->Common_model->updateInformation($data, $id, "tbl_users");
            $response = [
                'status' => 'success',
            ];
            $this->output->set_content_type('application/json')->set_output(json_encode($response));
        }
    }




}
