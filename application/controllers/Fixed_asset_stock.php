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
    # This is Fixed_asset_stock Controller
    ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Fixed_asset_stock extends Cl_Controller {
    /**
     * load constructor
     * @access public
     * @return void
     */    
    public function __construct() {
        parent::__construct();
        $this->load->model('Authentication_model');
        $this->load->model('Fixed_asset_stock_model');
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


        if($segment_2 == "addEditStock" || $segment_2 == "saveFixedAssetStockDetails"){
            $controller = "37";
            $function = "add";
        }elseif($segment_2 == "addEditStock" && $segment_3){
            $controller = "37";
            $function = "edit";
        }elseif($segment_2 == "deleteStock"){
            $controller = "37";
            $function = "delete";
        }elseif($segment_2 == "listStock"){
            $controller = "37";
            $function = "list";
        }elseif($segment_2 == "stocks"){
            $controller = "47";
            $function = "view";
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
     * addEditStock
     * @access public
     * @param int
     * @return void
     */
    public function addEditStock($encrypted_id = "") {
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        $company_id = $this->session->userdata('company_id');
        $stock_info = array();
        if ($id == "") {
            $stock_info['reference_no'] = $this->Fixed_asset_stock_model->generatePurRefNo($company_id);
        } else {
            $stock_info['reference_no'] = $this->Common_model->getDataById($id, "tbl_fixed_asset_stocks")->reference_no;
        }
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $add_more = $this->input->post($this->security->xss_clean('add_more'));
            $this->form_validation->set_rules('reference_no', lang('ref_no'), 'required|max_length[50]');
            $this->form_validation->set_rules('date', lang('date'), 'required|max_length[50]');
            $this->form_validation->set_rules('note', lang('note'), 'max_length[300]');
            if ($this->form_validation->run() == TRUE) {
                $stock_info['reference_no'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('reference_no')));
                $stock_info['date'] = $this->input->post($this->security->xss_clean('date'));
                $stock_info['note'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('note')));
                $stock_info['grand_total'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('grand_total')));
                $stock_info['user_id'] = $this->session->userdata('user_id');
                $stock_info['company_id'] = $this->session->userdata('company_id');
                if ($id == "") {
                    $stock_info['added_date'] = date('Y-m-d H:i:s');
                    $fixed_asset_stock = $this->Common_model->insertInformation($stock_info, "tbl_fixed_asset_stocks");
                    $this->saveFixedAssetStockDetails($_POST['item_id'], $fixed_asset_stock, 'tbl_fixed_asset_stock_details');
                    $this->session->set_flashdata('exception', lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($stock_info, $id, "tbl_fixed_asset_stocks");
                    $this->Common_model->deletingMultipleFormData('asset_stocks_id', $id, 'tbl_fixed_asset_stock_details');
                    $this->saveFixedAssetStockDetails($_POST['item_id'], $id, 'tbl_fixed_asset_stock_details');
                    $this->session->set_flashdata('exception',lang('update_success'));
                }
                if($add_more == 'add_more'){
                    redirect('Fixed_asset_stock/addEditStock');
                }else{
                    redirect('Fixed_asset_stock/listStock');
                }
            } else {
                if ($id == "") {
                    $data = array();
                    $data['stock_ref_no'] = $this->Fixed_asset_stock_model->generatePurRefNo($company_id);
                    $data['items'] = $this->Fixed_asset_stock_model->getItemList($company_id);
                    $data['main_content'] = $this->load->view('master/fixedAssets/stockin/addStock', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['fixed_stock_details'] = $this->Common_model->getDataById($id, "tbl_fixed_asset_stocks");
                    $data['items'] = $this->Fixed_asset_stock_model->getItemList($company_id);
                    $data['stock_items'] = $this->Fixed_asset_stock_model->getFixedAssetItems($id);
                    $data['main_content'] = $this->load->view('master/fixedAssets/stockin/editStock', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['stock_ref_no'] = $this->Fixed_asset_stock_model->generatePurRefNo($company_id);
                $data['items'] = $this->Fixed_asset_stock_model->getItemList($company_id);
                $data['main_content'] = $this->load->view('master/fixedAssets/stockin/addStock', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['fixed_stock_details'] = $this->Common_model->getDataById($id, "tbl_fixed_asset_stocks");
                $data['items'] = $this->Fixed_asset_stock_model->getItemList($company_id);
                $data['stock_items'] = $this->Fixed_asset_stock_model->getFixedAssetItems($id);
                $data['main_content'] = $this->load->view('master/fixedAssets/stockin/editStock', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }


    /**
     * deleteStock
     * @access public
     * @param int
     * @return void
     */
    public function deleteStock($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $this->Common_model->deleteStatusChangeWithChild($id, $id, "tbl_fixed_asset_stocks", "tbl_fixed_asset_stock_details", 'id', 'asset_stocks_id');
        $this->session->set_flashdata('exception', lang('delete_success'));
        redirect('Fixed_asset_stock/listStock');
    }

    /**
     * listStock
     * @access public
     * @param no
     * @return void
     */
    public function listStock() {
        $company_id = $this->session->userdata('company_id');
        $data = array();
        $data['fixed_items_stock'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_fixed_asset_stocks");
        $data['main_content'] = $this->load->view('master/fixedAssets/stockin/listStock', $data, TRUE);
        $this->load->view('userHome', $data);
    }



    
    

    /**
     * saveFixedAssetStockDetails
     * @access public
     * @param string
     * @param int
     * @param string
     * @return void
     */
    public function saveFixedAssetStockDetails($stock_items, $fixed_asset_stock, $table_name) {
        foreach ($stock_items as $row => $item_id):
            $fmi = array();
            $fmi['item_id'] = $_POST['item_id'][$row];
            $fmi['unit_price'] = $_POST['unit_price'][$row];
            $fmi['quantity_amount'] = $_POST['quantity_amount'][$row];
            $fmi['total'] = $_POST['total'][$row];
            $fmi['asset_stocks_id'] = $fixed_asset_stock;
            $fmi['user_id'] = $this->session->userdata('user_id');
            $fmi['company_id'] = $this->session->userdata('company_id');
            $this->Common_model->insertInformation($fmi, "$table_name");
        endforeach;
    } 



    /**
     * stocks
     * @access public
     * @param no
     * @return void
     */
    public function stocks() {
        $company_id = $this->session->userdata('company_id');
        $data = array();
        $data['stocks'] = $this->Fixed_asset_stock_model->fixedAssetStocks($company_id);
        $data['main_content'] = $this->load->view('master/fixedAssets/fixed-asset-stocks', $data, TRUE);
        $this->load->view('userHome', $data);
    }



}
