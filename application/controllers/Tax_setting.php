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
  # This is Tax_setting Controller
  ###########################################################
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Tax_setting extends Cl_Controller {

    /**
     * load constructor
     * @access public
     * @return void
     */   
    public function __construct() {
        parent::__construct();
        $this->load->model('Authentication_model');
        $this->load->model('Common_model');
        $this->load->model('Outlet_model');
        $this->load->library('form_validation');
        $this->Common_model->setDefaultTimezone();
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        //start check access function
        $segment_2 = $this->uri->segment(2);
        $controller = "8";
        $function = "";
        if($segment_2 == "tax" || $segment_2 == "saveOutletTaxes"){
            $function = "edit";
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
     * tax
     * @access public
     * @param int
     * @return void
     */
    public function tax($id = '') {
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('collect_tax', 'Collect Tax', 'required|max_length[10]');
            if ($this->input->post('collect_tax') == "Yes") {
                $this->form_validation->set_rules('tax_title', 'Tax Title', 'required|max_length[50]');
                $this->form_validation->set_rules('tax_registration_no', 'Tax Registration No', 'required|max_length[50]');
                $this->form_validation->set_rules('tax_is_gst', 'Tax is GST', 'required|max_length[50]');
                $this->form_validation->set_rules('taxes[]', 'Taxes', 'required|max_length[10]');
            }
            if ($this->form_validation->run() == TRUE) {
                $outlet_info = array();
                $outlet_info['collect_tax'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('collect_tax')));
                if ($this->input->post('collect_tax') == "Yes") {
                    $outlet_info['tax_title'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('collect_tax')));
                    $outlet_info['tax_registration_no'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('collect_tax')));
                    $outlet_info['tax_is_gst'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('collect_tax')));
                }
                $outlet_info['tax_type'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('tax_type')));
                $outlet_info['tax_title'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('tax_title')));
                $outlet_info['tax_registration_no'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('tax_registration_no')));
                $outlet_info['tax_is_gst'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('tax_is_gst')));
                $this->session->set_userdata($outlet_info);
                $this->Common_model->updateInformation($outlet_info, $id, "tbl_companies");
                if(!empty($_POST['taxes'])){
                    $this->saveOutletTaxes($_POST['taxes'], $id);
                }
                $this->session->set_flashdata('exception', 'Information has been updated successfully!');
                redirect('Tax_setting/tax');
            } else {
                $data = array();
                $data['company'] = getCompanyInfo();
                $data['main_content'] = $this->load->view('shop_setting/tax', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        } else {
            $data = array();
            $data['company'] = getCompanyInfo();
            $data['main_content'] = $this->load->view('shop_setting/tax', $data, TRUE);
            $this->load->view('userHome', $data);
        }
    }

    /**
     * saveOutletTaxes
     * @access public
     * @param string
     * @param int
     * @return void
     */

    public function saveOutletTaxes($outlet_taxes, $company_id) {
        $main_arr = array();
        $tax_string ='';
        foreach($outlet_taxes as $key=>$single_tax){
            $oti = array();
            if(isset($_POST['p_tax_id'][$key]) && $_POST['p_tax_id'][$key]){
                $oti['id'] = $_POST['p_tax_id'][$key];
            }else{
                $oti['id'] = 1;
            }
            $oti['tax'] = $single_tax;
            $oti['tax_rate'] = $_POST['tax_rate'][$key];
            $main_arr[] = $oti;
            $tax_string.=$single_tax.":";
        }
        $data['tax_setting'] = json_encode($main_arr);
        $data['tax_string'] = $tax_string;
        $this->Common_model->updateInformation($data, $company_id, "tbl_companies");
    }
}
