<?php
/*
  ###########################################################
  # PRODUCT NAME:   OFF POS
  ###########################################################
  # AUTHER:   Doorsoft
  ###########################################################
  # EMAIL:   info@doorsoft.co
  ###########################################################
  # COPYRIGHTS:   RESERVED BY Door Soft
  ###########################################################
  # WEBSITE:   http://www.doorsoft.co
  ###########################################################
  # This is Authentication_model Model
  ###########################################################
 */

class Authentication_model extends CI_Model {

    /**
     * load constructor
     * @access public
     * @return void
     */    
    public function __construct(){
        parent::__construct(); 
        if ($this->session->has_userdata('language')) {
            $language = $this->session->userdata('language');
        }else{
            $language = 'english';
        }  
        $this->lang->load("$language", "$language");
        if($language=='spanish'){
            $this->config->set_item('language', 'spanish');
        }
    }

    /**
     * getWhiteLabel
     * @access public
     * @param int
     * @return object
     */
    public function getWhiteLabel($company_id) {
        $this->db->select("*");
        $this->db->from("tbl_setting");
        $this->db->where("company_id", $company_id);
        return $this->db->get()->row();
    }
    /**
     * getUserInformation
     * @access public
     * @param string
     * @param string
     * @return object
     */
    public function getUserInformation($email_address, $password) {
        $this->db->select("*");
        $this->db->from("tbl_users");
        $this->db->where("email_address", $email_address);
        $this->db->where("password", $password);
        $this->db->where("del_status", 'Live');
        $this->db->or_where("phone", $email_address);
        return $this->db->get()->row();
    }

    /**
     * updateUserInfo
     * @access public
     * @param int 
     * @param int 
     * @return void
     */
    public function updateUserInfo($company_id, $user_id) {
        $this->db->set('company_id', $company_id);
        $this->db->where('id', $user_id);
        $this->db->update('tbl_users');
    }
    /**
     * saveCompanyInfo
     * @access public
     * @param string
     * @return int
     */
    public function saveCompanyInfo($company_info) {
        $this->db->insert('tbl_companies', $company_info);
        return $this->db->insert_id();
    }
    
    /**
     * getAccountByMobileNo
     * @access public
     * @param string
     * @return object
     */
    public function getAccountByMobileNo($email_address) {
        $this->db->select("*");
        $this->db->from("tbl_users");
        $this->db->where("email_address", $email_address);
        $this->db->where("del_status", 'Live');
        $this->db->or_where("phone", $email_address);
        return $this->db->get()->row();
    }
    /**
     * getCompanyInformation
     * @access public
     * @param int
     * @return object
     */
    public function getCompanyInformation($company_id) {
        $this->db->select("*");
        $this->db->from("tbl_companies");
        $this->db->where("id", $company_id);
        return $this->db->get()->row();
    }
    /**
     * saveUserInfo
     * @access public
     * @param string
     * @return int
     */
    public function saveUserInfo($user_info) {
        $this->db->insert('tbl_users', $user_info);
        return $this->db->insert_id();
    }
    /**
     * passwordCheck
     * @access public
     * @param string
     * @param int
     * @return object
     */
    public function passwordCheck($old_password, $user_id) {
        $row = $this->db->query("SELECT * FROM tbl_users WHERE id=$user_id AND password='$old_password'")->row();
        return $row;
    }

    /**
     * updatePassword
     * @access public
     * @param string
     * @param int
     * @return void
     */
    public function updatePassword($new_password, $user_id) {
        $this->db->set('password', $new_password);
        $this->db->where('id', $user_id);
        $this->db->update('tbl_users');
    }

    /**
     * getSettingInformation
     * @access public
     * @param no
     * @return json
     */
    public function getSettingInformation() {
        $company_info = getCompanyInfo();
        $getWhiteLabel = json_decode($company_info->white_label);
        return $getWhiteLabel;
    }
    /**
     * getSMSSignupUrl
     * @access public
     * @param int
     * @return void
     */
    function getSMSSignupUrl($operator) {
        if($operator==1){
            //return the url for signup to user sms gateway
            return escape_output("https://www.twilio.com/messaging/sms");
        }else if($operator==2){
            //return the url for signup to user sms gateway
            return escape_output("http://mobishastra.com/");
        }else if($operator==3){
            //return the url for signup to user sms gateway
            return escape_output("https://esms.mimsms.com");
        }else if($operator==4){
            //return the url for signup to user sms gateway
            return escape_output("https://textlocal.com/");
        }
    }
    
    /**
     * getSMSInformation
     * @access public
     * @param int
     * @return object
     */
    public function getSMSInformation($company_id) {
        $this->db->select("*");
        $this->db->from("tbl_companies");
        $row = $this->db->get()->row();
        return $row;
    }
    /**
     * getProfileInformation
     * @access public
     * @param no
     * @return object
     */
    public function getProfileInformation() {
        $user_id = $this->session->userdata('user_id');
        $this->db->select("*");
        $this->db->from("tbl_users");
        $this->db->where("id", $user_id);
        return $this->db->get()->row();
    }
    /**
     * updateSecurityQuestion
     * @access public
     * @param int
     * @param int
     * @param string
     * @param string
     * @return void
     */
    public function updateSecurityQuestion($company_id, $user_id, $security_question, $security_answer) {
        $this->db->set(array('question' => $security_question, 'answer'=> $security_answer));
        $this->db->where('id', $user_id);
        $this->db->where("del_status", 'Live');
        $this->db->update('tbl_users');
    }
}

