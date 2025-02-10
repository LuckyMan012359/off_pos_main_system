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
    # This is User Controller
    ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends Cl_Controller {


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
        $controller = "287";
        $function = "";

        if($segment_2=="addEditUser"){
            $function = "add";
        }elseif($segment_2=="addEditUser"  && $segment_3){
            $function = "edit";
        }elseif($segment_2=="deleteUser"){
            $function = "delete";
        }elseif($segment_2=="users"){
            $function = "list";
        }elseif($segment_2=="changeProfile"){
            $function = "change_profile";
        }elseif($segment_2=="changePassword"){
            $function = "change_password";
        }elseif($segment_2=="securityQuestion"){
            $function = "set_security_quatation";
        }elseif($segment_2=="activateUser"){
            $function = "activate_user";
        }elseif($segment_2=="deactivateUser"){
            $function = "deactivate_user";   
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
     * addEditUser
     * @access public
     * @param int
     * @return void
     */
    public function addEditUser($encrypted_id = "") {

        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        $outlet_id = $this->session->userdata('outlet_id');
        $user_id = $this->session->userdata('user_id');
        $company_id = $this->session->userdata('company_id');

        if($id == ''){
            if(isServiceAccess2($user_id, $company_id, 'sGmsJaFJE') == 'Saas Company'){
                $company_info = getCompanyInfo();
                $plan_details = $this->Common_model->getDataById($company_info->plan_id, 'tbl_pricing_plans');
                $user_count = $this->Common_model->getCountUser($company_info->id);
                if($plan_details->number_of_maximum_users == $user_count){
                    $this->session->set_flashdata('exception_2', "You can no longer create user, Your limitation is over! Upgrade Now");
                    redirect('Service/planDetails');
                }
            }

        }

        if ($id != '') {
            $user_details = $this->Common_model->getDataById($id, "tbl_users");
        }
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $add_more = $this->input->post($this->security->xss_clean('add_more'));
            $user_name = htmlspecialcharscustom($this->input->post($this->security->xss_clean('email_address')));
            $this->form_validation->set_rules('full_name',  lang('name'), 'required|max_length[50]');
            if ($id != '') {
                $post_phone = htmlspecialcharscustom($this->input->post($this->security->xss_clean('phone')));
                $existing_phone = $user_details->phone;
                if ($post_phone != $existing_phone) {
                    $this->form_validation->set_rules('phone',  lang('phone'), "required|max_length[30]|is_unique[tbl_users.phone]");
                } else {
                    $this->form_validation->set_rules('phone',  lang('phone'), "required|max_length[30]");
                }
                $this->form_validation->set_rules('email_address', lang('user_email_phone'), 'required|max_length[50]');
            } else {
                $this->form_validation->set_rules('phone', lang('phone'), "required|max_length[30]|is_unique[tbl_users.phone]");
                $this->form_validation->set_rules('email_address', lang('user_email_phone'), 'required|max_length[50]|is_unique[tbl_users.email_address.'.$user_name.']');
            }
            $this->form_validation->set_rules('salary',  lang('salary'), "max_length[11]");
            if($id != '1'){
                $this->form_validation->set_rules('designation',  lang('designation'), "required|max_length[11]");
            }
            $this->form_validation->set_rules('sale_price_modify',  lang('sale_price_modify'), "max_length[11]");
            $this->form_validation->set_rules('discount_permission_code', lang('discount_permission_code'), 'max_length[11]');
            $this->form_validation->set_rules('discount_amt', lang('discount_pro'), 'max_length[11]');
            $this->form_validation->set_rules('start_date', lang('start_date'), 'max_length[55]');
            $this->form_validation->set_rules('end_date', lang('end_date'), 'max_length[55]');
            if($this->input->post($this->security->xss_clean('will_login'))=='Yes' && $id == ""){
                $this->form_validation->set_rules('password',  lang('password'), "required|max_length[50]|min_length[6]");
                $this->form_validation->set_rules('confirm_password',  lang('confirm_password'), "required|max_length[50]|min_length[6]|matches[password]");
            }
            if($this->input->post($this->security->xss_clean('will_login'))=='Yes' && $id != ""){
                $getOldP = $this->input->post($this->security->xss_clean('getOldP'));
                if($getOldP == 0){
                    $this->form_validation->set_rules('password',  lang('password'), "required|max_length[50]|min_length[6]");
                    $this->form_validation->set_rules('confirm_password',  lang('confirm_password'), "required|max_length[50]|min_length[6]|matches[password]");
                }
            }
            if ($this->form_validation->run() == TRUE) {
                $user_info = array();
                $user_info['full_name'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('full_name')));
                $user_info['email_address'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('email_address')));
                $user_info['phone'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('phone')));
                $user_info['salary'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('salary')));
                $user_info['photo'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('photo')));
                if($id != '1'){
                    $user_info['role'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('designation')));
                }
                $user_info['commission'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('commission')));
                $user_info['discount_permission_code'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('discount_permission_code')));
                $user_info['sale_price_modify'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('sale_price_modify')));
                $user_info['discount_amt'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('discount_amt')));
                $user_info['start_date'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('start_date')));
                $user_info['end_date'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('end_date')));
                $outlet_id = $this->input->post($this->security->xss_clean('outlet_id'));
                if($outlet_id){
                    $outlet_list = implode(',', $outlet_id); 
                    $user_info['outlet_id'] = $outlet_list;
                }
                $user_info['will_login'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('will_login')));
                if($this->input->post($this->security->xss_clean('will_login'))=='Yes'){
                    $user_info['password'] = md5($this->input->post($this->security->xss_clean('password')));
                }
                $user_info['company_id'] = $this->session->userdata('company_id');
                if ($id == "") {
                    $user_info['account_creation_date'] = date('Y-m-d H:i:s');
                    $this->Common_model->insertInformation($user_info, "tbl_users");
                    $this->session->set_flashdata('exception',  lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($user_info, $id, "tbl_users");
                    $this->session->set_flashdata('exception', lang('update_success'));
                }
                if($add_more == 'add_more'){
                    redirect('User/addEditUser');
                }else{
                    redirect('User/users');
                }
            } else {
                if ($id == "") {
                    $data = array();
                    $data['outlets'] = $this->Common_model->getAllOutletByCompany();
                    $data['roles'] = $this->Common_model->getAllRoleByCompany();
                    $data['main_content'] = $this->load->view('user/addUser', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['user_details'] = $this->Common_model->getDataById($id, "tbl_users");
                    $data['outlets'] = $this->Common_model->getAllOutletByCompany();
                    $data['roles'] = $this->Common_model->getAllRoleByCompany();
                    $data['main_content'] = $this->load->view('user/editUser', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['outlets'] = $this->Common_model->getAllOutletByCompany();
                $data['roles'] = $this->Common_model->getAllRoleByCompany();
                $data['main_content'] = $this->load->view('user/addUser', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['user_details'] = $this->Common_model->getDataById($id, "tbl_users");
                $data['outlets'] = $this->Common_model->getAllOutletByCompany();
                $data['roles'] = $this->Common_model->getAllRoleByCompany();
                $data['main_content'] = $this->load->view('user/editUser', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }


    /**
     * validate_photo
     * @access public
     * @param no
     * @return void
     */
    public function validate_photo() {
        if ($_FILES['photo']['name'] != "") {
            $config['upload_path'] = './uploads/employees_image';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = '1000'; 
            $config['encrypt_name'] = TRUE;
            $config['detect_mime'] = TRUE;
            $this->load->library('upload', $config);

            if(createDirectory('uploads/employees_image')){
                // Delete the old file if it exists
                $old_file = $this->session->userdata('photo');
                if ($old_file && file_exists($config['upload_path'] . '/' . $old_file)) {
                    unlink($config['upload_path'] . '/' . $old_file);
                }
                if ($this->upload->do_upload("photo")) {
                    $upload_info = $this->upload->data();  
                    $file_name = $upload_info['file_name'];
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = './uploads/employees_image/' . $file_name;
                    $config['maintain_ratio'] = TRUE;
                    $config['width'] = 200;
                    $config['height'] = 350;
                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();
                    $this->session->set_userdata('photo', $file_name); 
                } else {
                    $this->form_validation->set_message('validate_photo', $this->upload->display_errors());
                    return FALSE;
                }
            } else {
                echo "Something went wrong";
            }
        }
    }

    /**
     * deleteUser
     * @access public
     * @param int
     * @return void
     */
    public function deleteUser($id) {
        if($id!=1):
            $id = $this->custom->encrypt_decrypt($id, 'decrypt');
            $this->Common_model->deleteStatusChange($id, "tbl_users");
            $this->session->set_flashdata('exception',  lang('delete_success'));
        endif;
        redirect('User/users');
    }

    /**
     * users
     * @access public
     * @param no
     * @return void
     */
    public function users() {
        $company_id = $this->session->userdata('company_id');
        $data = array();
        $data['users'] = $this->User_model->getUsersByCompanyId($company_id, "tbl_users");
        $data['main_content'] = $this->load->view('user/users', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    /**
     * changeProfile
     * @access public
     * @param int
     * @return void
     */
    public function changeProfile($id = '') {
        //end check access function
        $id = $this->session->userdata('user_id');
        $company_id = $this->session->userdata('company_id');
        $user_details = $this->Common_model->getDataById($id, "tbl_users");
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $post_email_address = htmlspecialcharscustom($this->input->post($this->security->xss_clean('email_address')));
            $existing_email_address = $user_details->email_address;
            if ($post_email_address != $existing_email_address) {
                $this->form_validation->set_rules('email_address', lang('email_address'), "required|valid_email|max_length[50]|is_unique[tbl_users.email_address]");
            } else {
                $this->form_validation->set_rules('email_address',lang('email_address'), "required|valid_email|max_length[50]");
            }
            $this->form_validation->set_rules('phone',lang('phone'), "required|max_length[30]");
            $this->form_validation->set_rules('photo', lang('photo'), 'callback_validate_photo|max_length[500]');
            if ($this->form_validation->run() == TRUE) {
                $user_info = array();
                $user_info['full_name'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('full_name')));
                $user_info['email_address'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('email_address')));
                $user_info['phone'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('phone')));
                if ($_FILES['photo']['name'] != "") {
                    $user_info['photo'] = $this->session->userdata('photo');
                    $this->session->unset_userdata('photo');
                }else{
                    $user_info['photo'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('photo_old')));
                }
                $this->Common_model->updateInformation($user_info, $id, "tbl_users");
                $this->session->set_flashdata('exception', lang('update_success'));
                $this->session->set_userdata('full_name', $user_info['full_name']);
                $this->session->set_userdata('phone', $user_info['phone']);
                $this->session->set_userdata('email_address', $user_info['email_address']);
                $this->session->set_userdata('photo', $user_info['photo']);
                redirect('User/changeProfile');
            } else {
                if ($id == "") {
                    $data = array();
                    $data['profile_info'] = $this->Authentication_model->getProfileInformation();
                    $data['main_content'] = $this->load->view('authentication/changeProfile', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['profile_info'] = $this->Authentication_model->getProfileInformation();
                    $data['main_content'] = $this->load->view('authentication/changeProfile', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['profile_info'] = $this->Authentication_model->getProfileInformation();
                $data['main_content'] = $this->load->view('authentication/changeProfile', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['profile_info'] = $this->Authentication_model->getProfileInformation();
                $data['main_content'] = $this->load->view('authentication/changeProfile', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }

    /**
     * changePassword
     * @access public
     * @param no
     * @return void
     */
    public function changePassword() {
        if ($this->input->post('submit') == 'submit') {
            $this->form_validation->set_rules('old_password',lang('old_password'), 'required|max_length[50]');
            $this->form_validation->set_rules('new_password', lang('new_password'), 'required|max_length[50]|min_length[6]');
            if ($this->form_validation->run() == TRUE) {
                $old_password = htmlspecialcharscustom($this->input->post($this->security->xss_clean('old_password')));
                $user_id = $this->session->userdata('user_id');
                $password_check = $this->Authentication_model->passwordCheck(md5($old_password), $user_id);
                if ($password_check) {
                    $new_password = htmlspecialcharscustom($this->input->post($this->security->xss_clean('new_password')));
                    $this->Authentication_model->updatePassword(md5($new_password), $user_id);
                    mail($this->session->userdata['email_address'], lang('change_password'), lang('Your_new_password_is') . $new_password);
                    $this->session->set_flashdata('exception',lang('password_changed'));
                    redirect('User/changePassword');
                } else {
                    $this->session->set_flashdata('exception_1',lang('old_password_not_match'));
                    redirect('User/changePassword');
                }
            } else {
                $data = array();
                $data['main_content'] = $this->load->view('authentication/changePassword', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        } else {
            $data = array();
            $data['main_content'] = $this->load->view('authentication/changePassword', $data, TRUE);
            $this->load->view('userHome', $data);
        }
    }


    /**
     * securityQuestion
     * @access public
     * @param no
     * @return void
     */
    public function securityQuestion(){
        //end check access function
        $json = file_get_contents("./assets/sample-questions/sampleQustions.json");
        $obj  = json_decode($json);
        $data = array();
        $data['question'] = $obj;
        if ($this->input->post('submit') == 'submit') {
            $this->form_validation->set_rules('answer', lang('SecurityAnswer'), 'required|max_length[50]');
            if ($this->form_validation->run() == TRUE) {
                $security_question = htmlspecialcharscustom($this->input->post($this->security->xss_clean('question')));
                $security_answer = htmlspecialcharscustom($this->input->post($this->security->xss_clean('answer')));
                $this->Authentication_model->updateSecurityQuestion($this->session->userdata('company_id'), $this->session->userdata('user_id'), $security_question, $security_answer);
                $this->session->set_flashdata('exception',lang('Security_Question_Answer_Set_Successful'));
                redirect('User/securityQuestion');
            } else {
                $data['profile_info'] = $this->Authentication_model->getProfileInformation();
                $data['main_content'] = $this->load->view('authentication/setQuestion', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        } else {
            $data['profile_info'] = $this->Authentication_model->getProfileInformation();
            $data['main_content'] = $this->load->view('authentication/setQuestion', $data, TRUE);
            $this->load->view('userHome', $data);
        }
    }



    /**
     * activateUser
     * @access public
     * @param int
     * @return void
     */
    public function activateUser($encrypted_id) {
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        $user_info = array();
        $user_info['active_status'] = 'Active';
        $this->Common_model->updateInformation($user_info, $id, "tbl_users");
        $this->session->set_flashdata('exception', lang('user_activate'));
        redirect('User/users');
    }

    /**
     * deactivateUser
     * @access public
     * @param int
     * @return void
     */
    public function deactivateUser($encrypted_id) {
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        $user_info = array();
        $user_info['active_status'] = 'Inactive';
        $this->Common_model->updateInformation($user_info, $id, "tbl_users");
        $this->session->set_flashdata('exception',lang('user_deactivate'));
        redirect('User/users');
    }
}
