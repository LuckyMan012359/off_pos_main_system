<?php
/*
  ###########################################################
  # PRODUCT NAME: 	Off POS
  ###########################################################
  # AUTHER:		Door Soft
  ###########################################################
  # EMAIL:		info@doorsoft.co
  ###########################################################
  # COPYRIGHTS:		RESERVED BY Door Soft
  ###########################################################
  # WEBSITE:		https://www.doorsoft.co
  ###########################################################
  # This is Denomination Controller
  ###########################################################
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Denomination extends Cl_Controller {

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
        $controller = "3";
        $function = "";
        if($segment_2 == "addEditDenomination"){
            $function = "add";
        }elseif($segment_2 == "addEditDenomination" && $segment_3){
            $function = "edit";
        }elseif($segment_2 == "deleteDenomination"){
            $function = "delete";
        }elseif($segment_2 == "denominations"){
            $function = "list";
        }else{
            $this->session->set_flashdata('exception_1', lang('no_access'));
            redirect('Authentication/userProfile');
        }
        if(!checkAccess($controller,$function)){
            $this->session->set_flashdata('exception_1', lang('no_access'));
            redirect('Authentication/userProfile');
        }
        //end check access function
    }
    
    /**
     * addEditDenomination
     * @access public
     * @param int
     * @return void
     */
    public function addEditDenomination($encrypted_id = "") {
        $company_id = $this->session->userdata('company_id');
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('amount',lang('amount'), 'required|max_length[11]');
            $this->form_validation->set_rules('description',lang('description'), 'max_length[250]');
            if ($this->form_validation->run() == TRUE) {
                $add_more = $this->input->post($this->security->xss_clean('add_more'));
                $igc_info = array();
                $igc_info['amount'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('amount')));
                $igc_info['description'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('description')));
                $igc_info['company_id'] = $this->session->userdata('company_id');
                $igc_info['user_id'] = $this->session->userdata('user_id');
                if ($id == "") {
                    $igc_info['added_date'] = date('Y-m-d H:i:s');
                    $this->Common_model->insertInformation($igc_info, "tbl_denominations");
                    $this->session->set_flashdata('exception', lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($igc_info, $id, "tbl_denominations");
                    $this->session->set_flashdata('exception', lang('update_success'));
                }
                if($add_more == 'add_more'){
                    redirect('denomination/addEditDenomination');
                }else{
                    redirect('denomination/denominations');
                }
            } else {
                if ($id == "") {
                    $data = array();
                    $data['main_content'] = $this->load->view('master/denomination/addDenomination', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['denomination'] = $this->Common_model->getDataById($id, "tbl_denominations");
                    $data['main_content'] = $this->load->view('master/denomination/editDenomination', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['main_content'] = $this->load->view('master/denomination/addDenomination', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['denomination'] = $this->Common_model->getDataById($id, "tbl_denominations");
                $data['main_content'] = $this->load->view('master/denomination/editDenomination', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }

    /**
     * deleteDenomination
     * @access public
     * @param int
     * @return void
     */
    public function deleteDenomination($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $this->Common_model->deleteStatusChange($id, "tbl_denominations");
        $this->session->set_flashdata('exception', lang('delete_success'));
        redirect('denomination/denominations');
    }



    /**
     * denominations
     * @access public
     * @param no
     * @return void
     */
    public function denominations() {
        $company_id = $this->session->userdata('company_id');
        $data = array();
        $data['denominations'] = $this->Common_model->getAllByCompanyIdWithAddedBy($company_id, "tbl_denominations");
        $data['main_content'] = $this->load->view('master/denomination/denominations', $data, TRUE);
        $this->load->view('userHome', $data);
    }
    
}
