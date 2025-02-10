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
  # This is Admin_model Model
  ###########################################################
 */
class Admin_model extends CI_Model {

    /**
     * getAllCompanies
     * @access public
     * @param no
     * @return object
     */
    public function getAllCompanies() {
        $this->db->select("*");
        $this->db->from("tbl_users");
        $this->db->order_by('tbl_companies.id', 'desc');
        $this->db->where("tbl_users.role", "1");
        $this->db->join('tbl_companies', 'tbl_users.company_id = tbl_companies.id');
        return $this->db->get()->result();
    }
}

?>
