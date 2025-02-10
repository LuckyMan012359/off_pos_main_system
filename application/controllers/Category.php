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
    # This is Category Controller
    ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends Cl_Controller {


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
        $controller = "";
        $function = "";
        if($segment_2=="addEditItemCategory"){
            $controller = "60";
            $function = "add";
        }elseif($segment_2=="addEditItemCategory" && $segment_3){
            $controller = "60";
            $function = "edit";
        }elseif($segment_2=="deleteItemCategory"){
            $controller = "60";
            $function = "delete";
        }elseif($segment_2=="itemCategories"){
            $controller = "60";
            $function = "list";
        }elseif($segment_2 == "sortCategory" || $segment_2 == "sortCategoryUpdate"){
            $controller = "302";
            $function = "sort";
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
     * addEditItemCategory
     * @access public
     * @param int
     * @return void
     */

    public function addEditItemCategory($encrypted_id = "") {
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $add_more = $this->input->post($this->security->xss_clean('add_more'));
            $this->form_validation->set_rules('name', lang('name'), 'required|max_length[50]');
            $this->form_validation->set_rules('description', lang('description'), 'max_length[250]');
            if ($this->form_validation->run() == TRUE) {
                $fmc_info = array();
                $fmc_info['name'] = getPlanText(htmlspecialcharscustom($this->input->post($this->security->xss_clean('name'))));
                $fmc_info['description'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('description')));
                $fmc_info['user_id'] = $this->session->userdata('user_id');
                $fmc_info['company_id'] = $this->session->userdata('company_id');
                if ($id == "") {
                    $fmc_info['added_date'] = date('Y-m-d H:i:s');
                    $this->Common_model->insertInformation($fmc_info, "tbl_item_categories");
                    $this->session->set_flashdata('exception', lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($fmc_info, $id, "tbl_item_categories");
                    $this->session->set_flashdata('exception', lang('update_success'));
                }
                if($add_more == 'add_more'){
                    redirect('Category/addEditItemCategory');
                }else{
                    redirect('Category/itemCategories');
                }
            } else {
                if ($id == "") {
                    $data = array();
                    $data['main_content'] = $this->load->view('master/itemCategory/addItemCategory', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['category_information'] = $this->Common_model->getDataById($id, "tbl_item_categories");
                    $data['main_content'] = $this->load->view('master/itemCategory/editItemCategory', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['main_content'] = $this->load->view('master/itemCategory/addItemCategory', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['category_information'] = $this->Common_model->getDataById($id, "tbl_item_categories");
                $data['main_content'] = $this->load->view('master/itemCategory/editItemCategory', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }

    /**
     * deleteItemCategory
     * @access public
     * @param int
     * @return void
     */
    public function deleteItemCategory($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $this->Common_model->deleteStatusChange($id, "tbl_item_categories");
        $this->session->set_flashdata('exception',lang('delete_success'));
        redirect('Category/itemCategories');
        
    }

    /**
     * itemCategories
     * @access public
     * @param no
     * @return void
     */
    public function itemCategories() {
        $company_id = $this->session->userdata('company_id');
        $data = array();
        $data['itemCategories'] = $this->Common_model->getAllByCompanyIdWithAddedBy ($company_id, "tbl_item_categories");
        $data['main_content'] = $this->load->view('master/itemCategory/itemCategories', $data, TRUE);
        $this->load->view('userHome', $data);
    }


    /**
     * sortCategory
     * @access public
     * @param no
     * @return void
     */
    public function sortCategory() {
        $company_id = $this->session->userdata('company_id');
        $data = array();
        $data['itemCategories'] = $this->Common_model->getItemCategoriesBySorted($company_id, 'tbl_item_categories');
        $data['main_content'] = $this->load->view('master/itemCategory/sort_category', $data, TRUE);
        $this->load->view('userHome', $data);
    }


    /**
     * sortCategoryUpdate
     * @access public
     * @param no
     * @return void
     */
    public function sortCategoryUpdate() {
        $data = array();
        if($this->input->post($this->security->xss_clean('ids'))){
            $arr = explode(',',$this->input->post('ids'));
            foreach($arr as $sortOrder => $id){
                $category = $this->db->query("SELECT id, sort_id FROM tbl_item_categories where id=$id")->row();
                $data['sort_id'] = $sortOrder+1;
                $this->Common_model->updateInformation($data, $id, 'tbl_item_categories');
            }
            $response = [
                'success'=>true,'message'=>'Caegory Successfully Sorted'
            ];
            $this->output->set_content_type('application/json')->set_output(json_encode($response));
        }
    }
}
