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
    # This is Role Controller
    ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends Cl_Controller {


    /**
     * load constructor
     * @access public
     * @return void
     */    

    public function __construct() {
        parent::__construct();
        $this->load->model('Common_model');
         $this->load->model('Authentication_model');
        $this->load->model('User_model');
        $this->Common_model->setDefaultTimezone();
        $this->load->library('form_validation');
        if (!$this->session->userdata('user_id')) {
            redirect('Authentication/index');
        }
        //start check access function
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $controller = "282";
        $function = "";

        if($segment_2=="addEditRole"){
            $function = "add";
        }elseif($segment_2=="addEditRole" && $segment_3){
            $function = "edit";
        }elseif($segment_2=="deleteRole"){
            $function = "delete";
        }elseif($segment_2=="listRole"){
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
     * addEditRole
     * @access public
     * @param int
     * @return void
     */
    public function addEditRole($encrypted_id = "") {
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        $company_id = $this->session->userdata('company_id');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $add_more = $this->input->post($this->security->xss_clean('add_more'));
            $this->form_validation->set_rules('role_name',  lang('role_name'), 'required|max_length[55]');
            if ($this->form_validation->run() == TRUE) {
                $role_info = array();
                $role_info['role_name'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('role_name')));
                $role_info['company_id'] = $this->session->userdata('company_id');
                $role_info['user_id'] = $this->session->userdata('user_id');
                if ($id == "") {
                    $role_info['added_date'] = date('Y-m-d H:i:s');
                    $access_id = $this->input->post($this->security->xss_clean('access_id'));
                    $role_id = $this->Common_model->insertInformation($role_info, "tbl_roles");
                    $access_id = ($this->input->post($this->security->xss_clean('access_id')));
                    if($access_id){
                        for($i=0;$i<sizeof($access_id);$i++){
                            $original_value = explode('|',$access_id[$i]);
                            $data = array();
                            $data['role_id'] = $role_id;
                            $data['access_parent_id'] = $original_value[0];
                            $data['access_child_id'] = $original_value[1];
                            $this->Common_model->insertInformation($data, "tbl_role_access");
                        }
                    }
                    $this->session->set_flashdata('exception',  lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($role_info, $id, "tbl_roles");
                    // This is array type data thats why we skip scape
                    $access_id = ($this->input->post($this->security->xss_clean('access_id')));
                    if($access_id){
                        //delete previous access before add
                        $this->Common_model->deleteCustomRow($id,"role_id","tbl_role_access");
                        for($i=0; $i<sizeof($access_id); $i++){
                            $original_value = explode('|',$access_id[$i]);
                            $data = array();
                            $data['role_id'] = $id;
                            $data['access_parent_id'] = $original_value[0];
                            $data['access_child_id'] = $original_value[1];
                            $this->Common_model->insertInformation($data, "tbl_role_access");
                        }
                    }
                    $this->session->set_flashdata('exception', lang('update_success'));
                }
                if($add_more == 'add_more'){
                    redirect('Role/addEditRole');
                }else{
                    redirect('Role/listRole');
                }
            } else {
                if ($id == "") {
                    $data = array();
                    $data['access_modules'] = $this->Common_model->getAllCustomData("tbl_access",'main_module_id','asc','parent_id', NULL);
                    foreach ($data['access_modules'] as $key=>$value){
                        $data['access_modules'][$key]->functions = $this->Common_model->getAllCustomData("tbl_access",'label_name','asc','parent_id',$value->id);
                    }
                    $data['main_content'] = $this->load->view('role/addRole', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['role_details'] = $this->Common_model->getDataById($id, "tbl_roles");
                    $data['access_modules'] = $this->Common_model->getAllCustomData("tbl_access",'main_module_id','asc','parent_id', NULL);
                    foreach ($data['access_modules'] as $key=>$value){
                        $data['access_modules'][$key]->functions = $this->Common_model->getAllCustomData("tbl_access",'label_name','asc','parent_id',$value->id);
                    }
                    $selected_modules =  $this->Common_model->getAllByCustomId($id,'role_id','tbl_role_access');
                    $selected_modules_arr = array();
                    foreach ($selected_modules as $value) {
                        $selected_modules_arr[] = $value->access_child_id;
                    }
                    $data['selected_modules_arr'] = $selected_modules_arr;
                    $data['main_content'] = $this->load->view('user/editRole', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['access_modules'] = $this->Common_model->getAllAccessMainModule();
                foreach ($data['access_modules'] as $key=>$value){
                    $data['access_modules'][$key]->functions = $this->Common_model->getAllAccessFunction($value->id);
                }
                $data['main_content'] = $this->load->view('role/addRole', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['role_details'] = $this->Common_model->getDataById($id, "tbl_roles");
                $data['access_modules'] = $this->Common_model->getAllAccessMainModule();
                foreach ($data['access_modules'] as $key=>$value){
                    $data['access_modules'][$key]->functions = $this->Common_model->getAllAccessFunction($value->id);
                }
                $selected_modules =  $this->Common_model->getAllByCustomId($id,'role_id','tbl_role_access');
                $selected_modules_arr = array();
                foreach ($selected_modules as $value) {
                    $selected_modules_arr[] = $value->access_child_id;
                }
                $data['selected_modules_arr'] = $selected_modules_arr;
                $data['main_content'] = $this->load->view('role/editRole', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }

    /**
     * deletRole
     * @access public
     * @param int
     * @return void
     */
    public function deleteRole($id) {
        if($id!= 1):
            $id = $this->custom->encrypt_decrypt($id, 'decrypt');
            $this->Common_model->deleteStatusChange($id, "tbl_roles");
            $this->session->set_flashdata('exception',  lang('delete_success'));
        endif;
        redirect('Role/listRole');
    }

    
    /**
     * listRole
     * @access public
     * @param no
     * @return void
     */
    public function listRole() {
        $company_id = $this->session->userdata('company_id');
        $data = array();
        $data['roles'] = $this->User_model->getRolesByCompanyId($company_id, "tbl_roles");
        $data['main_content'] = $this->load->view('role/listRole', $data, TRUE);
        $this->load->view('userHome', $data);
    }


    /**
     * check_menu_access
     * @access public
     * @param no
     * @return boolean
     */
    public function check_menu_access() {
        $menu_id = $this->input->post($this->security->xss_clean('menu_id'));
        if (count($menu_id) <= 0) {
            $this->form_validation->set_message('check_menu_access', lang('At_least_1_menu_access_should_be_selected'));
            return false;
        } else {
            return true;
        }
    }
}
