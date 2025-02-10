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
    # This is Delivery_partner Controller
    ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Delivery_partner extends Cl_Controller {

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
        $controller = "159";
        $function = "";
        if($segment_2=="addEditPartner"){
            $function = "add";
        }elseif($segment_2=="addEditPartner" && $segment_3){
            $function = "edit";
        }elseif($segment_2=="deletePartner"){
            $function = "delete";
        }elseif($segment_2=="listPartner"){
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
     * addEditPartner
     * @access public
     * @param int
     * @return void
     */

    public function addEditPartner($encrypted_id = "") {
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $add_more = $this->input->post($this->security->xss_clean('add_more'));
            $this->form_validation->set_rules('partner_name', lang('partner_name'), 'required|max_length[50]');
            $this->form_validation->set_rules('description', lang('description'), 'max_length[250]');
            if ($this->form_validation->run() == TRUE) {
                $fmc_info = array();
                $fmc_info['partner_name'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('partner_name')));
                $fmc_info['description'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('description')));
                $fmc_info['user_id'] = $this->session->userdata('user_id');
                $fmc_info['company_id'] = $this->session->userdata('company_id');
                if ($id == "") {
                    $fmc_info['added_date'] = date('Y-m-d H:i:s');
                    $this->Common_model->insertInformation($fmc_info, "tbl_delivery_partners");
                    $this->session->set_flashdata('exception', lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($fmc_info, $id, "tbl_delivery_partners");
                    $this->session->set_flashdata('exception', lang('update_success'));
                }
                if($add_more == 'add_more'){
                    redirect('Delivery_partner/addEditPartner');
                }else{
                    redirect('Delivery_partner/listPartner');
                }
            } else {
                if ($id == "") {
                    $data = array();
                    $data['main_content'] = $this->load->view('master/deliveryPartner/addEditPartner', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['partners_info'] = $this->Common_model->getDataById($id, "tbl_delivery_partners");
                    $data['main_content'] = $this->load->view('master/deliveryPartner/editPartner', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['main_content'] = $this->load->view('master/deliveryPartner/addEditPartner', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['partners_info'] = $this->Common_model->getDataById($id, "tbl_delivery_partners");
                $data['main_content'] = $this->load->view('master/deliveryPartner/editPartner', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }

    /**
     * deletePartner
     * @access public
     * @param int
     * @return void
     */
    public function deletePartner($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $this->Common_model->deleteStatusChange($id, "tbl_delivery_partners");
        $this->session->set_flashdata('exception',lang('delete_success'));
        redirect('Delivery_partner/listPartner');
        
    }

    /**
     * lists
     * @access public
     * @param no
     * @return void
     */
    public function listPartner() {
        $company_id = $this->session->userdata('company_id');
        $data = array();
        $data['partners_info'] = $this->Common_model->getAllByCompanyIdWithAddedBy($company_id, "tbl_delivery_partners");
        $data['main_content'] = $this->load->view('master/deliveryPartner/listPartner', $data, TRUE);
        $this->load->view('userHome', $data);
    }

}
