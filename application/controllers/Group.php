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
    # This is Group Controller
    ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Group extends Cl_Controller {


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
        $controller = "154";
        $function = "";

        if($segment_2=="addEditGroup"){
            $function = "add";
        }elseif($segment_2=="addEditGroup" && $segment_3){
            $function = "edit";
        }elseif($segment_2=="deleteGroup"){
            $function = "delete";
        }elseif($segment_2=="groups"){
            $function = "list";
        }else{
            $this->session->set_flashdata('exception_1',lang('no_access'));
            redirect('Authentication/userProfile');
        }
        if(!checkAccess($controller,$function)){
            $this->session->set_flashdata('exception_1',lang('no_access'));
            redirect('Authentication/userProfile');
        }
        //end check access function
    }

    /**
     * addEditGroup
     * @access public
     * @param int
     * @return void
     */
    public function addEditGroup($encrypted_id = "") {
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $add_more = $this->input->post($this->security->xss_clean('add_more'));
            $this->form_validation->set_rules('group_name', lang('group_name'), 'required|max_length[50]');
            $this->form_validation->set_rules('description', lang('description'), 'max_length[255]');
            if ($this->form_validation->run() == TRUE) {
                $vat = array();
                $vat['group_name'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('group_name')));
                $vat['description'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('description')));
                $vat['company_id'] = $this->session->userdata('company_id');
                $vat['user_id'] = $this->session->userdata('user_id');
                if ($id == "") {
                    $vat['added_date'] = date('Y-m-d H:i:s');
                    $this->Common_model->insertInformation($vat, "tbl_customer_groups");
                    $this->session->set_flashdata('exception',lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($vat, $id, "tbl_customer_groups");
                    $this->session->set_flashdata('exception', lang('update_success'));
                }
                if($add_more == 'add_more'){
                    redirect('Group/addEditGroup');
                }else{
                    redirect('Group/groups');
                }
            } else {
                if ($id == "") {
                    $data = array();
                    $data['main_content'] = $this->load->view('master/Group/addEditGroup', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['Groups'] = $this->Common_model->getDataById($id, "tbl_customer_groups");
                    $data['main_content'] = $this->load->view('master/Group/addEditGroup', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['main_content'] = $this->load->view('master/Group/addEditGroup', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['Groups'] = $this->Common_model->getDataById($id, "tbl_customer_groups");
                $data['main_content'] = $this->load->view('master/Group/addEditGroup', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }


    /**
     * deleteGroup
     * @access public
     * @param int
     * @return void
     */
    public function deleteGroup($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $this->Common_model->deleteStatusChange($id, "tbl_customer_groups");
        $this->session->set_flashdata('exception', lang('delete_success'));
        redirect('Group/groups');
    }

    /**
     * Groups
     * @access public
     * @param no
     * @return void
     */
    public function groups() {
        $company_id = $this->session->userdata('company_id');
        $data = array();
        $data['Groups'] = $this->Common_model->getAllByCompanyIdWithAddedBy($company_id, "tbl_customer_groups");
        $data['main_content'] = $this->load->view('master/Group/Groups', $data, TRUE);
        $this->load->view('userHome', $data);
    }

}
