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
  # This is Variation Controller
  ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Variation extends Cl_Controller {

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
        $controller = "70";
        $function = "";
        if($segment_2=="addEditVariation"){
            $function = "add";
        }elseif($segment_2=="addEditVariation" && $segment_3){
            $function = "edit";
        }elseif($segment_2=="deleteVariation"){
            $function = "delete";
        }elseif($segment_2=="variations"){
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
     * addEditVariation
     * @access public
     * @param int
     * @return void
     */
    public function addEditVariation($encrypted_id = "") {
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $add_more = $this->input->post($this->security->xss_clean('add_more'));
            $this->form_validation->set_rules('variation_name', lang('variation_name'), 'required|max_length[50]');
            if ($this->form_validation->run() == TRUE) {
                $data_value = array();
                $data_value['variation_name'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('variation_name')));
                $tmp_variable = '';
                //This field should not be escaped, because this is an array field
                $variation_value = $this->input->post($this->security->xss_clean('variation_value'));
                if(isset($variation_value) && $variation_value){
                    foreach ($variation_value as $ky=>$value){
                        $tmp_variable .= $value;
                        if($ky < (sizeof($variation_value) -1)){
                            $tmp_variable .= ",";
                        }
                    }
                }
                $data_value['variation_value'] = json_encode($variation_value);
                $data_value['user_id'] = $this->session->userdata('user_id');
                $data_value['company_id'] = $this->session->userdata('company_id');
                if ($id == "") {
                    $data_value['added_date'] = date('Y-m-d H:i:s');
                    $this->Common_model->insertInformation($data_value, "tbl_variations");
                    $this->session->set_flashdata('exception',lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($data_value, $id, "tbl_variations");
                    $this->session->set_flashdata('exception', lang('update_success'));
                }
                if($add_more == 'add_more'){
                    redirect('Variation/addEditVariation');
                }else{
                    redirect('Variation/variations');
                }
            } else {
                if ($id == "") {
                    $data = array();
                    $data['main_content'] = $this->load->view('master/Variation/addEditVariation', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['Variations'] = $this->Common_model->getDataById($id, "tbl_variations");
                    $data['main_content'] = $this->load->view('master/Variation/addEditVariation', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['main_content'] = $this->load->view('master/Variation/addEditVariation', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['Variations'] = $this->Common_model->getDataById($id, "tbl_variations");
                $data['main_content'] = $this->load->view('master/Variation/addEditVariation', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }


    /**
     * deleteVariation
     * @access public
     * @param int
     * @return void
     */
    public function deleteVariation($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $this->Common_model->deleteStatusChange($id, "tbl_variations");
        $this->session->set_flashdata('exception', lang('delete_success'));
        redirect('Variation/variations');
    }

    /**
     * variations
     * @access public
     * @param no
     * @return void
     */
    public function variations() {
        $company_id = $this->session->userdata('company_id');
        $data = array();
        $data['Variations'] = $this->Common_model->getAllByCompanyIdWithAddedBy ($company_id, "tbl_variations");
        $data['main_content'] = $this->load->view('master/Variation/Variations', $data, TRUE);
        $this->load->view('userHome', $data);
    }
}
