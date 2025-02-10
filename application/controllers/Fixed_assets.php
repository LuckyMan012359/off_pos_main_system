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
    # This is Fixed_assets Controller
    ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Fixed_assets extends Cl_Controller {


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
        //start check access function
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);

        $controller = "32";
        $function = "";
        if($segment_2=="addEditItem"){
            $function = "add";
        }elseif($segment_2=="addEditItem" && $segment_3){
            $function = "edit";
        }elseif($segment_2=="deleteItem"){
            $function = "delete";
        }elseif($segment_2=="listItem"){
            $function = "list";
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
     * addEditItem
     * @access public
     * @param int
     * @return void
     */

    public function addEditItem($encrypted_id = "") {
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $add_more = $this->input->post($this->security->xss_clean('add_more'));
            $this->form_validation->set_rules('name', lang('name'), 'required|max_length[50]');
            $this->form_validation->set_rules('description', lang('description'), 'max_length[250]');
            if ($this->form_validation->run() == TRUE) {
                $fmc_info = array();
                $fmc_info['name'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('name')));
                $fmc_info['description'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('description')));
                $fmc_info['user_id'] = $this->session->userdata('user_id');
                $fmc_info['company_id'] = $this->session->userdata('company_id');
                if ($id == "") {
                    $fmc_info['added_date'] = date('Y-m-d H:i:s');
                    $this->Common_model->insertInformation($fmc_info, "tbl_fixed_asset_items");
                    $this->session->set_flashdata('exception', lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($fmc_info, $id, "tbl_fixed_asset_items");
                    $this->session->set_flashdata('exception', lang('update_success'));
                }
                if($add_more == 'add_more'){
                    redirect('Fixed_assets/addEditItem');
                }else{
                    redirect('Fixed_assets/listItem');
                }
            } else {
                if ($id == "") {
                    $data = array();
                    $data['main_content'] = $this->load->view('master/fixedAssets/items/addItem', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['item_info'] = $this->Common_model->getDataById($id, "tbl_fixed_asset_items");
                    $data['main_content'] = $this->load->view('master/fixedAssets/items/editItem', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['main_content'] = $this->load->view('master/fixedAssets/items/addItem', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['item_info'] = $this->Common_model->getDataById($id, "tbl_fixed_asset_items");
                $data['main_content'] = $this->load->view('master/fixedAssets/items/editItem', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }

    /**
     * deleteItem
     * @access public
     * @param int
     * @return void
     */
    public function deleteItem($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $this->Common_model->deleteStatusChange($id, "tbl_fixed_asset_items");
        $this->session->set_flashdata('exception',lang('delete_success'));
        redirect('Fixed_assets/listItem');
    }

    /**
     * listItem
     * @access public
     * @param no
     * @return void
     */
    public function listItem() {
        $company_id = $this->session->userdata('company_id');
        $data = array();
        $data['item_info'] = $this->Common_model->getAllByCompanyIdWithAddedBy($company_id, "tbl_fixed_asset_items");
        $data['main_content'] = $this->load->view('master/fixedAssets/items/listItem', $data, TRUE);
        $this->load->view('userHome', $data);
    }
}
