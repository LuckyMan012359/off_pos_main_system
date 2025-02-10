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
    # This is Unit Controller
    ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Unit extends Cl_Controller {

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
        $controller = "65";
        $function = "";
        if($segment_2=="addEditUnit"){
            $function = "add";
        }elseif($segment_2=="addEditUnit" && $segment_3){
            $function = "edit";
        }elseif($segment_2=="deleteUnit"){
            $function = "delete";
        }elseif($segment_2=="units"){
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
     * addEditUnit
     * @access public
     * @param int
     * @return void
     */
    public function addEditUnit($encrypted_id = "") {
        $company_id = $this->session->userdata('company_id');
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('unit_name', lang('unit_name'), 'required|max_length[50]');
            $this->form_validation->set_rules('description', lang('description'), 'max_length[250]');
            if ($this->form_validation->run() == TRUE) {
                $add_more = $this->input->post($this->security->xss_clean('add_more'));
                $vat = array();
                $vat['unit_name'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('unit_name')));
                $vat['description'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('description')));
                $vat['user_id'] = $this->session->userdata('user_id');
                $vat['company_id'] = $this->session->userdata('company_id');
                if ($id == "") {
                    $vat['added_date'] = date('Y-m-d H:i:s');
                    $this->Common_model->insertInformation($vat, "tbl_units");
                    $this->session->set_flashdata('exception',lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($vat, $id, "tbl_units");
                    $this->session->set_flashdata('exception', lang('update_success'));
                }
                if($add_more == 'add_more'){
                    redirect('Unit/addEditUnit');
                }else{
                    redirect('Unit/units');
                }
            } else {
                if ($id == "") {
                    $data = array();
                    $data['main_content'] = $this->load->view('master/Unit/addEditUnit', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['Units'] = $this->Common_model->getDataById($id, "tbl_units");
                    $data['main_content'] = $this->load->view('master/Unit/addEditUnit', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['main_content'] = $this->load->view('master/Unit/addEditUnit', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['Units'] = $this->Common_model->getDataById($id, "tbl_units");
                $data['main_content'] = $this->load->view('master/Unit/addEditUnit', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }


    /**
     * deleteUnit
     * @access public
     * @param int
     * @return void
     */
    public function deleteUnit($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $this->Common_model->deleteStatusChange($id, "tbl_units");
        $this->session->set_flashdata('exception', lang('delete_success'));
        redirect('Unit/units');
    }


    /**
     * units
     * @access public
     * @param no
     * @return void
     */
    public function units() {
        $company_id = $this->session->userdata('company_id');
        $data = array();
        $data['Units'] = $this->Common_model->getAllByCompanyIdWithAddedBy ($company_id, "tbl_units");
        $data['main_content'] = $this->load->view('master/Unit/Units', $data, TRUE);
        $this->load->view('userHome', $data);
    }
}
