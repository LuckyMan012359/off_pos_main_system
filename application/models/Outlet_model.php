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
  # This is Outlet_model Model
  ###########################################################
 */
class Outlet_model extends CI_Model {

    /**
     * generateOutletCode
     * @access public
     * @param no
     * @return string
     */
    public function generateOutletCode() {
        $company_id = $this->session->userdata('company_id');
        $count = $this->db->query("SELECT id as count
            FROM tbl_outlets WHERE company_id = $company_id ORDER BY id DESC")->row('count');
        $code = str_pad($count + 1, 6, '0', STR_PAD_LEFT);
        return $code;
    }

    /**
     * outlet_count
     * @access public
     * @param no
     * @return int
     */
    public function outlet_count() {
        $this->db->select("*");
        $this->db->from("tbl_outlets");
        $this->db->where("company_id", $this->session->userdata('company_id'));
        $this->db->where("del_status", 'Live');
        return $this->db->get()->num_rows();
    }

}

