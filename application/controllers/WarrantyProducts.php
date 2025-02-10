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
  # This is WarrantyProducts Controller
  ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class WarrantyProducts extends Cl_Controller {

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
        //start check access function
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $controller = "80";
        $function = "";
        if($segment_2=="addEditWarrantyProduct" || $segment_2 == 'addWarranty' || $segment_2 == 'searchWarrantyProducts' || $segment_2 == 'warrantyProductActive'){
            $function = "add";
        }elseif(($segment_2=="addEditWarrantyProduct" && $segment_3) || $segment_2 == "changeStatus" || $segment_2 == 'addWarranty' || $segment_2 == 'searchWarrantyProducts' || $segment_2 == 'warrantyProductActive'){
            $function = "edit";
        }elseif($segment_2=="deleteWarrantyProduct"){
            $function = "delete";
        }elseif($segment_2=="listWarrantyProduct" || $segment_2 == "warrantyAvailableStock" || $segment_2 == "warrantyAllStock" || $segment_2 == 'listActivatedWarrantyProduct'){
            $function = "list";
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
     * addWarranty
     * @access public
     * @param int
     * @return void
     */
    public function addWarranty($item_name='', $customer_id='', $imei_serial = ''){
        $company_id = $this->session->userdata('company_id');
        $data = array();
        $data['item_name'] = $item_name;
        $data['imei_serial'] = $imei_serial;
        $data['customer_id'] = $customer_id;
        $data['customers'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_customers");
        $data['main_content'] = $this->load->view('warranty-product/addWarrantyProduct', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    /**
     * searchWarrantyProducts
     * @access public
     * @param no
     * @return json
     */
    public function searchWarrantyProducts(){
        $imei_serial_no = $this->input->post($this->security->xss_clean('imei_serial_no'));
        $data = $this->Common_model->searchWarrantyProducts($imei_serial_no);
        $response = [
            'status' => 'success',
            'data' => $data,
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }


    /**
     * warrantyProductActive
     * @access public
     * @param no
     * @return json
     */
    public function warrantyProductActive(){
        $imei_serial_no = $this->input->post($this->security->xss_clean('imei_serial_no'));
        $data = $this->Common_model->warrantyProductActive($imei_serial_no);
        $response = [
            'status' => 'success',
            'data' => $data,
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }


    /**
     * warrantyProductActive
     * @access public
     * @param no
     * @return json
     */
    public function warrantyProductDeactive(){
        $imei_serial_no = $this->input->post($this->security->xss_clean('imei_serial_no'));
        $data = $this->Common_model->warrantyProductDeactive($imei_serial_no);
        $response = [
            'status' => 'success',
            'data' => $data,
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
    
    /**
     * addEditWarrantyProduct
     * @access public
     * @param int
     * @return void
     */
    public function addEditWarrantyProduct($encrypted_id = "") {
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        $outlet_id = $this->session->userdata('outlet_id');
        $user_id = $this->session->userdata('user_id');
        $company_id = $this->session->userdata('company_id');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $add_more = $this->input->post($this->security->xss_clean('add_more'));
            $customer = $this->input->post($this->security->xss_clean('customer_id'));
            $customer_r = explode("||", $customer);
            $this->form_validation->set_rules('product_name', lang('product_name'), 'required|max_length[50]');
            $this->form_validation->set_rules('product_serial_no', lang('product_serial_no'), 'required|max_length[50]');
            $this->form_validation->set_rules('description', lang('description'), 'max_length[200]');
            $this->form_validation->set_rules('receiving_date', lang('receiving_date'), 'required|max_length[55]');
            $this->form_validation->set_rules('delivery_date', lang('delivery_date'), 'max_length[55]');
            $this->form_validation->set_rules('customer_id', lang('customer'), 'required|max_length[10]');
            $this->form_validation->set_rules('current_status', lang('current_status'), 'required|max_length[55]');
            if ($this->form_validation->run() == TRUE) {
                $warranty_info = array();
                $warranty_info['product_name'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('product_name')));
                $warranty_info['product_serial_no'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('product_serial_no')));
                $warranty_info['description'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('description')));
                $warranty_info['receiving_date'] = $this->input->post($this->security->xss_clean('receiving_date'));
                $warranty_info['delivery_date'] = $this->input->post($this->security->xss_clean('delivery_date'));
                $warranty_info['current_status'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('current_status')));
                if($customer_r[0]){
                    $warranty_info['customer_id'] = $customer_r[0];
                }
                if($customer_r[1]){
                    $warranty_info['customer_name'] = $customer_r[1];
                }
                if($customer_r[2]){
                    $warranty_info['customer_mobile'] = $customer_r[2];
                }
                $warranty_info['outlet_id'] = $outlet_id; 
                $warranty_info['user_id'] =$user_id; 
                $warranty_info['company_id'] =$company_id;
                if ($id == "") {
                    $warranty_info['added_date'] = date('Y-m-d H:i:s');
                    $this->Common_model->insertInformation($warranty_info, "tbl_warranties");
                    $this->session->set_flashdata('exception', lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($warranty_info, $id, "tbl_warranties");
                    $this->session->set_flashdata('exception',lang('update_success'));
                }
                if($add_more == 'add_more'){
                    redirect('WarrantyProducts/addEditWarrantyProduct');
                }else{
                    redirect('WarrantyProducts/listWarrantyProduct');
                }

            } else {
                if ($id == "") {
                    $data = array();
                    $data['customers'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_customers");
                    $data['main_content'] = $this->load->view('warranty-product/addWarrantyProduct', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['customers'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_customers");
                    $data['warranty_details'] = $this->Common_model->getDataById($id, "tbl_warranties");
                    $data['main_content'] = $this->load->view('warranty-product/editWarrantyProduct', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['customers'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_customers");
                $data['main_content'] = $this->load->view('warranty-product/addWarrantyProduct', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['customers'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_customers");
                $data['warranty_details'] = $this->Common_model->getDataById($id, "tbl_warranties");
                $data['main_content'] = $this->load->view('warranty-product/editWarrantyProduct', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }



    /**
     * deleteWarrantyProduct
     * @access public
     * @param int
     * @return void
     */
    public function deleteWarrantyProduct($encrypted_id){
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        $this->Common_model->deleteStatusChange($id, "tbl_warranties");
        $this->session->set_flashdata('exception', lang('delete_success'));
        redirect('WarrantyProducts/listWarrantyProduct');
    }



    /**
     * listWarrantyProduct
     * @access public
     * @param no
     * @return void
     */
    public function listWarrantyProduct(){
        $data = array();
        $data['warranties'] = $this->Common_model->getAllWarrantyList();
        $data['main_content'] = $this->load->view('warranty-product/list_warranty', $data, TRUE);
        $this->load->view('userHome', $data);
    }



    /**
     * warrantyAvailableStock
     * @access public
     * @param no
     * @return void
     */
    public function warrantyAvailableStock(){
        $data = array();
        $data['warranty_available_stock'] = $this->Common_model->warrantyAvailableStock("tbl_warranties");
        $data['main_content'] = $this->load->view('warranty-product/show_only_stock', $data, TRUE);
        $this->load->view('userHome', $data);
    }


    /**
     * warrantyAllStock
     * @access public
     * @param no
     * @return void
     */
    public function warrantyAllStock(){
        $data = array();
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $outlet_id = $this->input->post($this->security->xss_clean('outlet_id'));
            $R_F_C = '';
            $S_T_V = '';
            $R_T_V = '';
            if(isset($_POST['Received_From_Customer'])){
               $R_F_C = 'R_F_C';
            }
            if(isset($_POST['Send_To_Vendor'])){
                $S_T_V = 'S_T_V';
            } 
            if(isset($_POST['Received_To_Vendor'])){
                $R_T_V = 'R_T_V';
            }
            $data['warranties_all_stock'] = $this->Common_model->warrantyAllStockByStatus($R_F_C, $S_T_V, $R_T_V, $outlet_id);
        } else {
            $data['warranties_all_stock'] = $this->Common_model->warrantyAllStock("tbl_warranties");
        }
        $data['main_content'] = $this->load->view('warranty-product/show_all_stock', $data, TRUE);
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
        $this->Common_model->statusChange($id, 'current_status', $current_status, "tbl_warranties");
        $response = [
            'status' => '200',
            'message' => 'Data Successfully Saved',
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }


}
