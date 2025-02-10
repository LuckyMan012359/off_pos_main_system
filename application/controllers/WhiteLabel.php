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
    # This is WhiteLabel Controller
    ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class WhiteLabel extends CI_Controller {

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
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $controller = "23";
        $function = "";
        if($segment_2=="index" || $segment_2 == "validate_site_logo" || $segment_2 == "validate_site_favicon"){
            $function = "edit";
        }else{
            $this->session->set_flashdata('exception_1', lang('no_access'));
            redirect('Authentication/userProfile');
        }
        if(!checkAccess($controller,$function)){
            $this->session->set_flashdata('exception_1', lang('no_access'));
            redirect('Authentication/userProfile');
        }
    }
    /**
     * index
     * @access public
     * @param int
     * @return void
     */
    public function index($id = '') {
        $company_id = $this->session->userdata('company_id');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('site_name', lang('site_name'), 'required|max_length[50]');
            $this->form_validation->set_rules('site_footer', lang('site_footer'), 'required|max_length[250]');
            $this->form_validation->set_rules('site_title', lang('site_title'), 'required|max_length[50]');
            $this->form_validation->set_rules('site_link', lang('site_link'), 'required|max_length[50]');
            $this->form_validation->set_rules('site_logo', lang('site_logo'), 'callback_validate_site_logo|max_length[500]');
            $this->form_validation->set_rules('site_favicon', lang('site_favicon'), 'callback_validate_site_favicon|max_length[500]');
            if ($this->form_validation->run() == TRUE) {
                $outlet_info = array();
                $outlet_info['site_name'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('site_name')));
                $outlet_info['site_footer'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('site_footer')));
                $outlet_info['site_title'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('site_title')));
                $outlet_info['site_link'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('site_link')));
                if ($_FILES['site_logo']['name'] != "") {
                    $outlet_info['site_logo'] = $this->session->userdata('site_logo');
                    $this->session->unset_userdata('site_logo');
                }else{
                    $outlet_info['site_logo'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('site_logo_p')));
                }
                if ($_FILES['site_favicon']['name'] != "") {
                    $outlet_info['site_favicon'] = $this->session->userdata('site_favicon');
                    $this->session->unset_userdata('site_favicon');
                }else{
                    $outlet_info['site_favicon'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('site_favicon_p')));
                }
                $return['white_label']  = json_encode($outlet_info);
                $this->Common_model->updateInformation($return, $company_id, "tbl_companies");
                $this->session->set_flashdata('exception', lang('update_success'));
                $this->session->set_userdata($outlet_info);
                //update for progressive app.
                updateAppInfo();
                redirect('WhiteLabel/index');
            } else {
                $data = array();
                $data['outlet_information'] = $this->Common_model->getDataById($company_id, "tbl_companies");
                $data['main_content'] = $this->load->view('shop_setting/WhiteLabel', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        } else {
            $data = array();
            $data['outlet_information'] = $this->Common_model->getDataById($company_id, "tbl_companies");
            $data['main_content'] = $this->load->view('shop_setting/WhiteLabel', $data, TRUE);
            $this->load->view('userHome', $data);
        }
    }

    /**
     * validate_site_logo
     * @access public
     * @param no
     * @return void
     */
    public function validate_site_logo() {
        if ($_FILES['site_logo']['name'] != "") {
            $config['upload_path'] = './uploads/site_settings';
            $config['allowed_types'] = 'jpg|jpeg|png|ico';
            $config['max_size'] = '1000';
            $config['encrypt_name'] = TRUE;
            $config['detect_mime'] = TRUE;
            $this->load->library('upload', $config);


            if(createDirectory('uploads/site_settings')){
                // Delete the old file if it exists
                $old_file = $this->session->userdata('site_logo');
                if ($old_file && file_exists($config['upload_path'] . '/' . $old_file)) {
                    unlink($config['upload_path'] . '/' . $old_file);
                }

                if ($this->upload->do_upload("site_logo")) {
                    $upload_info = $this->upload->data();
                    $file_name = $upload_info['file_name'];
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = './uploads/site_settings/' . $file_name;
                    $config['maintain_ratio'] = false;
                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();
                    $this->session->set_userdata('site_logo', $file_name);
                } else {
                    $this->form_validation->set_message('validate_site_logo', $this->upload->display_errors());
                    return TRUE;
                }
            } else {
                echo "Something went wrong";
            }
        }
    }
    

    /**
     * validate_site_favicon
     * @access public
     * @param no
     * @return void
     */
    public function validate_site_favicon() {
        if ($_FILES['site_favicon']['name'] != "") {
            $config['upload_path'] = './uploads/site_settings';
            $config['allowed_types'] = 'jpg|jpeg|png|ico';
            $config['max_size'] = '1000';
            $config['max_width'] = 16;
            $config['max_height'] = 16;
            $config['encrypt_name'] = TRUE;
            $config['detect_mime'] = TRUE;
            $this->load->library('upload', $config);

            if(createDirectory('uploads/site_settings')){
                // Delete the old file if it exists
                $old_file = $this->session->userdata('site_favicon');
                if ($old_file && file_exists($config['upload_path'] . '/' . $old_file)) {
                    unlink($config['upload_path'] . '/' . $old_file);
                }

                if ($this->upload->do_upload("site_favicon")) {
                    $upload_info = $this->upload->data();
                    $file_name = $upload_info['file_name'];
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = './uploads/site_settings/' . $file_name;
                    $config['maintain_ratio'] = false;
                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();
                    $this->session->set_userdata('site_favicon', $file_name);
                } else {
                    $this->form_validation->set_message('validate_site_favicon', $this->upload->display_errors());
                    return TRUE;
                }
            } else {
                echo "Something went wrong";
            }
        }
    }
}
