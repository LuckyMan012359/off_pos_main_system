<?php
/*
  ###########################################################
  # PRODUCT NAME: 	OFF POS
  ###########################################################
  # AUTHER:		Doorsoft
  ###########################################################
  # EMAIL:		info@doorsoft.co
  ###########################################################
  # COPYRIGHTS:		RESERVED BY Door Soft
  ###########################################################
  # WEBSITE:		http://www.doorsoft.co
  ###########################################################
  # This is Ajax_model Model
  ###########################################################
 */
class Ajax_model extends CI_Model {

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
        $this->db->where("active_status", 'Active');
        $this->db->where("del_status", 'Live');
        return $this->db->get()->row();
    }

}

