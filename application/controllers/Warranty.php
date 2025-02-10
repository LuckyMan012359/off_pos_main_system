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
  # This is Warranty Controller
  ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Warranty extends Cl_Controller {

    /**
     * load constructor
     * @access public
     * @return void
     */    
    public function __construct() {
        parent::__construct();
        $this->load->model('Authentication_model');
        $this->load->model('Common_model');
        $this->load->model('Sale_model');
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
        $controller = "85";
        $function = "";
        if($segment_2=="checkWarranty" || $segment_2 == "getInvoiceByCustomerId" ||  $segment_2 == "print_invoice"){
            $function = "filter";
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
     * checkWarranty
     * @access public
     * @param no
     * @return void
     */   
    public function checkWarranty()
    {
        $data = array();
        $data['allCustomers'] = $this->Common_model->getAllCustomerNameMobile();
        $data['main_content'] = $this->load->view('warranty/check_warranty', $data, TRUE);
        $this->load->view('userHome', $data);
    }


    /**
     * getInvoiceByCustomerId
     * @access public
     * @param no
     * @return string
     */
    public function getInvoiceByCustomerId(){
        $customer_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('customer_id')));
        $customer_sales = $this->Common_model->getSaleInvoiceByCustomerId($customer_id);
        $invoice_dropdown = '<option value="">'.lang('select_invoice').'</option>';
        if (!empty($customer_sales)) { 
            foreach ($customer_sales as $value){
                $invoice_dropdown .= '<option value="'. $this->custom->encrypt_decrypt($value->id, 'encrypt') .'">Inoice: '. $value->sale_no .' Date: '. date($this->session->userdata('date_format'), strtotime($value->sale_date)) .' Total Item: '. $value->total_items .' Payable: '. $value->total_payable. $this->session->userdata('currency') .'</option>';
            }
        }
        echo $invoice_dropdown;
    }


    /**
     * get_all_information_of_a_sale
     * @access public
     * @param int
     * @return string
     */
    function get_all_information_of_a_sale($sales_id){
        $sales_information = $this->Sale_model->getSaleBySaleId($sales_id);
        $items_by_sales_id = $this->Sale_model->getAllItemsFromSalesDetailBySalesId($sales_id);
        $sales_details_objects = $items_by_sales_id;
        $sale_object = $sales_information;
        $sale_object->items = $sales_details_objects;
        return $sale_object;
    }

    /**
     * print_invoice
     * @access public
     * @param int
     * @return void
     */
    function print_invoice($sale_id=""){
        $sale_id = $this->custom->encrypt_decrypt($sale_id, 'decrypt');
        if($sale_id){
            $data = array();
            $data['sale_object'] = $this->get_all_information_of_a_sale($sale_id);
            $data['outlet_info'] = $this->Common_model->getCurrentOutlet();
            $customer_id = $data['sale_object']->customer_id;
            $data['customer_info'] = $this->Common_model->getCustomerById($customer_id);
            $this->load->view('warranty/print_invoice_a4', $data);
        }
    }
}
