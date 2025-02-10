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
  # This is User_model Model
  ###########################################################
 */
class User_model extends CI_Model {

    /**
     * getUsersByCompanyId
     * @access public
     * @param int
     * @return object
     */
    public function getUsersByCompanyId($company_id) {
        $this->db->select("u.*,o.outlet_name, r.role_name");
        $this->db->from("tbl_users u");
        $this->db->join('tbl_roles r', 'r.id = u.role', 'left');
        $this->db->join('tbl_outlets o', 'o.id = u.outlet_id', 'left');
        $this->db->where("u.company_id", $company_id);
        $this->db->where("u.del_status", 'Live');
        return $this->db->get()->result();
    }
    /**
     * getUsersByCompanyId
     * @access public
     * @param int
     * @return object
     */
    public function getRolesByCompanyId($company_id) {
        $this->db->select("*");
        $this->db->from("tbl_roles");
        $this->db->where("company_id", $company_id);
        $this->db->where("del_status", 'Live');
        return $this->db->get()->result();
    }

}

