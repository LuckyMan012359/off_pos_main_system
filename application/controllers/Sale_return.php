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
    # This is Sale_return Controller
    ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Sale_return extends Cl_Controller {


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
        $segment_3 = $this->uri->segment(3);
        $controller = "204";
        $function = "";

        if(($segment_2=="addEditSaleReturn") || ($segment_2 == "getCustomerSales" || $segment_2 == "getItemsOfSale" || $segment_2 == "getSaleItemDetails")){
            $function = "add";
        }elseif(($segment_2=="addEditSaleReturn" && $segment_3) || ($segment_2 == "getCustomerSales" || $segment_2 == "getItemsOfSale" || $segment_2 == "getSaleItemDetails")){
            $function = "edit";
        }elseif($segment_2=="saleReturnDetails"){
            $function = "view";
        }elseif($segment_2=="deleteSaleReturn"){
            $function = "delete";
        }elseif($segment_2=="saleReturns" || $segment_2 == "getAjaxData"){
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
        if ($register_content->register_sale_return != '' && $register_status == 2) {
            $this->session->set_flashdata('exception', lang('please_open_register'));
            $this->session->set_userdata("clicked_controller", $this->uri->segment(1));
            $this->session->set_userdata("clicked_method", $this->uri->segment(2));
            redirect('Register/openRegister');
        }
    }


    /**
     * addEditSaleReturn
     * @access public
     * @param int
     * @return void
     */
    public function addEditSaleReturn($encrypted_id = "") {
        $encrypted_id = $encrypted_id;
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        $outlet_id = $this->session->userdata('outlet_id');
        $user_id = $this->session->userdata('user_id');
        $company_id = $this->session->userdata('company_id');
        if ($id == "") {
            $sale_return_info['reference_no'] = $this->Sale_model->generateSaleReturnRefNo($outlet_id);
        } else {
            $sale_return_info['reference_no'] = $this->Common_model->getDataById($id, "tbl_sale_return")->reference_no;
        }

        if (htmlspecialcharscustom($this->input->post('submit'))) {
            // pre($_POST);
            $add_more = $this->input->post($this->security->xss_clean('add_more'));
            $this->form_validation->set_rules('date',lang('date'), 'required|max_length[50]');
            if ($this->form_validation->run() == TRUE) {
                $data = array();
                $data['date'] = $this->input->post($this->security->xss_clean('date'));
                $data['reference_no'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('reference_no')));
                $data['customer_id'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('customer_id')));
                $data['payment_method_id'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('payment_method_id')));
                $data['total_return_amount'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('grand_total')));
                $data['paid'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('paid')));
                $data['due'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('due')));
                $data['note'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('note')));
                $data['sale_id'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('sale_id')));
                $data['user_id'] = $this->session->userdata('user_id');
                $data['outlet_id'] = $this->session->userdata('outlet_id');
                $data['company_id'] = $this->session->userdata('company_id');
                if ($id == "") {
                    $data['added_date'] = date("Y-m-d H:i:s");
                    $sale_return_id = $this->Common_model->insertInformation($data, "tbl_sale_return");
                    $this->saveSaleReturnDetails($_POST['item_id'], $sale_return_id, 'tbl_sale_return_details');
                    $this->session->set_flashdata('exception', lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($data, $id, "tbl_sale_return");
                    $this->Common_model->deletingMultipleFormData('sale_return_id', $id, 'tbl_sale_return_details');
                    $this->saveSaleReturnDetails($_POST['item_id'], $id, 'tbl_sale_return_details');
                    $this->session->set_flashdata('exception', lang('update_success'));
                }
                if($add_more == 'add_more'){
                    redirect('Sale_return/addEditSaleReturn');
                }else{
                    redirect('Sale_return/saleReturns');
                }
            } else {
                if ($id == "") {
                    $data = array();
                    $data['paymentMethods'] = $this->Common_model->getAllPaymentMethod();
                    $data['ref_no'] = $this->Sale_model->generateSaleReturnRefNo($outlet_id);
                    $data['customers'] = $this->Common_model->getAllByCustomerASC();
                    $data['main_content'] = $this->load->view('saleReturn/addSaleReturn', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['paymentMethods'] = $this->Common_model->getAllPaymentMethod();
                    $data['customers'] = $this->Common_model->getAllByCustomerASC();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['sale_return_items'] = $this->Common_model->saleReturnItems($id);
                    $data['main_content'] = $this->load->view('saleReturn/editSaleReturn', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['paymentMethods'] = $this->Common_model->getAllPaymentMethod();
                $data['ref_no'] = $this->Sale_model->generateSaleReturnRefNo($outlet_id);
                $data['customers'] = $this->Common_model->getAllByCustomerASC();
                $data['main_content'] = $this->load->view('saleReturn/addSaleReturn', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['paymentMethods'] = $this->Common_model->getAllPaymentMethod();
                $data['customers'] = $this->Common_model->getAllByCustomerASC();
                $data['encrypted_id'] = $encrypted_id;
                $data['sale_return_details'] = $this->Common_model->getDataById($id, "tbl_sale_return");
                $data['sale_return_items'] = $this->Common_model->saleReturnItems($id);

                $data['main_content'] = $this->load->view('saleReturn/editSaleReturn', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    } 


    /**
     * saveSaleReturnDetails
     * @access public
     * @param string
     * @param int
     * @param string
     * @return void
     */
    public function saveSaleReturnDetails($sale_return_items, $sale_return_id, $table_name) {
        foreach ($sale_return_items as $row => $item_id):
            $fmi = array();
            $fmi['sale_return_id'] = $sale_return_id;
            $fmi['item_id'] = $_POST['item_id'][$row];
            $fmi['sale_id'] = $_POST['sale_item_id'][$row];
            $fmi['menu_taxes'] = getTaxStringBySaleAndItemId($_POST['sale_item_id'][$row], $_POST['item_id'][$row]);
            $fmi['sale_quantity_amount'] = $_POST['sale_quantity_amount'][$row];
            $fmi['return_quantity_amount'] = $_POST['return_quantity_amount'][$row];
            $fmi['unit_price_in_sale'] = $_POST['unit_price_in_sale'][$row];
            $fmi['unit_price_in_return'] = $_POST['unit_price_in_return'][$row];
            $fmi['item_type'] = $_POST['item_type'][$row];
            $fmi['expiry_imei_serial'] = $_POST['expiry_imei_serial'][$row];
            $fmi['user_id'] = $this->session->userdata('user_id');
            $fmi['outlet_id'] = $this->session->userdata('outlet_id');
            $fmi['company_id'] = $this->session->userdata('company_id');
            $this->Common_model->insertInformation($fmi, "tbl_sale_return_details");
        endforeach;
    }

    /**
     * saleReturnDetails
     * @access public
     * @param int
     * @return void
     */
    public function saleReturnDetails($id=""){
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $data = array();
        $data['sale_return'] = $this->Common_model->getDataById($id, 'tbl_sale_return');
        $customer_id = $data['sale_return']->customer_id;
        $data['customer_info'] = $this->Common_model->getCustomerById($customer_id);
        $data['encrypted_id'] = $id;
        $data['item_name'] = $this->Common_model->getDataByField($data['sale_return']->id, "tbl_sale_return_details", 'sale_return_id');
        $data['main_content'] = $this->load->view('saleReturn/saleReturnDetails', $data, TRUE);
        $this->load->view('userHome', $data);
    }



    /**
     * deleteSaleReturn
     * @access public
     * @param int
     * @return void
     */
    public function deleteSaleReturn($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $this->Common_model->deleteStatusChangeWithChild($id, $id, "tbl_sale_return", "tbl_sale_return_details", 'id', 'sale_return_id');
        $this->session->set_flashdata('exception',lang('delete_success'));
        redirect('Sale_return/saleReturns');
    }

    /**
     * saleReturns
     * @access public
     * @param no
     * @return void
     */
    public function saleReturns() {
        $data = array();
        $data['main_content'] = $this->load->view('saleReturn/saleReturns', $data, TRUE);
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
        $sale_returns = $this->Sale_model->make_datatablesForSaleReturn($company_id, $outlet_id);
        if ($sale_returns && !empty($sale_returns)) {
            $i = count($sale_returns);
        }
        $data = array();
        foreach($sale_returns as $return){
            $sub_array = array();
            $sub_array[] = $i--;
            $sub_array[] = escape_output($return->reference_no);
            $sub_array[] = dateFormat($return->date);
            $sub_array[] = escape_output($return->customer_name);
            $sub_array[] = getAmtCustom($return->total_return_amount);
            $sub_array[] = getAmtCustom($return->paid);
            $sub_array[] = getAmtCustom($return->due);
            $sub_array[] = str_word_limit($return->note, 10);
            $sub_array[] = escape_output($return->added_by);
            $sub_array[] = dateFormat($return->added_date);
            $html = '';

            $html .= '<a class="btn btn-deep-purple" href="' . base_url() . 'Sale_return/print_invoice/' . $this->custom->encrypt_decrypt($return->id, 'encrypt') . '" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="' . lang('print_invoice') . '">
            <i class="fas fa-print"></i></a>';

            $html .= '<a class="btn btn-unique" href="' . base_url() . 'Sale_return/a4InvoicePDF/' . $this->custom->encrypt_decrypt($return->id, 'encrypt') . '" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="' . lang('download_invoice') . '">
                <i class="fas fa-download"></i>
            </a>';

            $html .= ' <a class="btn btn-cyan" href="'.base_url().'Sale_return/saleReturnDetails/'.($this->custom->encrypt_decrypt($return->id, 'encrypt')).'" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="'. lang('view_details') .'"><i class="far fa-eye"></i></a>';

            $html .= '<a class="btn btn-warning" href="' . base_url() . 'Sale_return/addEditSaleReturn/' . $this->custom->encrypt_decrypt($return->id, 'encrypt') . '" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="' . lang('edit') . '">
                <i class="far fa-edit"></i>
            </a>';


            $html .= ' <a class="delete btn btn-danger" href="'.base_url().'Sale_return/deleteSaleReturn/'.($this->custom->encrypt_decrypt($return->id, 'encrypt')).'" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="'. lang('delete') .'"><i class="fa-regular fa-trash-can"></i></a>';
            $sub_array[] = '<div class="btn_group_wrap">
            '.$html.'
            </div>';
            $data[] = $sub_array;
        }
        $output = array(
            "recordsTotal" => $this->Sale_model->get_all_dataForSaleReturn($company_id, $outlet_id),
            "recordsFiltered" => $this->Sale_model->get_filtered_dataForSaleReturn($company_id, $outlet_id),
            "data" => $data
        );
        echo json_encode($output);
    }

    /**
     * print_invoice
     * @access public
     * @param int
     * @return void
     */
    public function print_invoice($id=""){
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $data = array();
        $data['sale_return'] = $this->Common_model->getDataById($id, 'tbl_sale_return');
        $data['outlet_info'] = $this->Common_model->getCurrentOutlet();
        $customer_id = $data['sale_return']->customer_id;
        $data['customer_info'] = $this->Common_model->getCustomerById($customer_id);
        $data['item_name'] = $this->Common_model->getDataByField($data['sale_return']->id, "tbl_sale_return_details", 'sale_return_id');
        $this->load->view('saleReturn/print_invoice_a4', $data);
    }
    /**
     * a4InvoicePDF
     * @access public
     * @param int
     * @return void
     */
    public function a4InvoicePDF($id=""){
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $pdfContent = array();
        $pdfContent['sale_return'] = $this->Common_model->getDataById($id, 'tbl_sale_return');
        $pdfContent['outlet_info'] = $this->Common_model->getCurrentOutlet();
        $customer_id = $pdfContent['sale_return']->customer_id;
        $pdfContent['customer_info'] = $this->Common_model->getCustomerById($customer_id);
        $pdfContent['item_name'] = $this->Common_model->getDataByField($pdfContent['sale_return']->id, "tbl_sale_return_details", 'sale_return_id');
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
        $html = $this->load->view('saleReturn/a4_invoice_pdf',$pdfContent,true);
        $mpdf->WriteHTML($html);
        $mpdf->Output('Sale Return Reference No -' . $pdfContent['sale_return']->reference_no . '.pdf', "D");

    }

    /**
     * getCustomerSales
     * @access public
     * @param no
     * @return string
     */
    public function getCustomerSales() {
        $customer_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('customer_id')));
        $old_slae_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('old_slae_id')));
        $customer_sales = $this->db->query("select id, customer_id, sale_no, total_items, total_payable, sale_date from tbl_sales where customer_id='$customer_id' and del_status='Live'")->result();
        $invoice_dropdown = '<option value="">'.lang('select').'</option>';
        if (!empty($customer_sales)) { 
            foreach ($customer_sales as $value){
                $invoice_dropdown .= '<option value="'. $value->id .'" '. ($old_slae_id == $value->id ? 'selected' : '') .'>Invoice: '. $value->sale_no .' Date: '. date($this->session->userdata('date_format'), strtotime($value->sale_date)) .' Total Item: '. $value->total_items .' Payable: '. $value->total_payable. $this->session->userdata('currency') .'</option>';
            }
        }
        echo $invoice_dropdown;
    }


    /**
     * getItemsOfSale
     * @access public
     * @param no
     * @return string
     */
    public function getItemsOfSale() {
        $sale_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('sale_id')));
        $this->db->select("sd.id, sd.food_menu_id, i.name as item_name,i.code, sd.sales_id, sd.menu_taxes, sd.item_type, sd.expiry_imei_serial");
        $this->db->from("tbl_sales_details sd");
        $this->db->join("tbl_items i", 'i.id = sd.food_menu_id', 'left');
        $this->db->where("sd.sales_id", $sale_id);
        $this->db->where("sd.del_status", "Live");
        $sale_items = $this->db->get()->result();
        $item_dropdown = '<option value="">'.lang('select').'</option>';
        if (!empty($sale_items)) { 
            foreach ($sale_items as $value){
                $string = getItemNameCodeBrandByItemId($value->food_menu_id);
                $item_dropdown .= '<option value="'. $value->food_menu_id."|". $value->sales_id. "|" . $string . "|" . $value->item_type . "|" . $value->expiry_imei_serial .'">'. $string .'</option>';
            }
        }
        echo $item_dropdown;
    }

    /**
     * getSaleItemDetails
     * @access public
     * @param no
     * @return json
     */
    public function getSaleItemDetails() {
        $item_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('item_id')));
        $sales_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('sales_id')));
        $sale_item_details = $this->Sale_model->saleItemDetails($item_id, $sales_id);
        echo json_encode($sale_item_details);
    }
}
