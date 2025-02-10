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
  # This is Deposit_model Model
  ###########################################################
 */
class Deposit_model extends CI_Model {

    /**
     * generatePurRefNo
     * @access public
     * @param int
     * @return string
     */
    public function generatePurRefNo($outlet_id) {
        $count = $this->db->query("SELECT count(id) as count
               FROM tbl_deposits where outlet_id=$outlet_id")->row('count');
        $code = str_pad($count + 1, 6, '0', STR_PAD_LEFT);
        return $code;
    }

    /**
     * getRefInstall
     * @access public
     * @param int
     * @return string
     */
    public function getRefInstall($outlet_id) {
        $count = $this->db->query("SELECT count(id) as count
               FROM tbl_installments where outlet_id=$outlet_id")->row('count');
        $code = str_pad($count + 1, 6, '0', STR_PAD_LEFT);
        return $code;
    }

    /**
     * getItemListWithUnitAndPrice
     * @access public
     * @param int
     * @return object
     */
    public function getItemListWithUnitAndPrice($company_id) {
        $result = $this->db->query("SELECT tbl_items.id, tbl_items.name, tbl_items.code, tbl_items.purchase_price,tbl_items.conversion_rate,tbl_units.unit_name
          FROM tbl_items 
          LEFT JOIN tbl_units ON tbl_items.purchase_unit_id = tbl_units.id
          WHERE tbl_items.company_id=$company_id AND tbl_items.type = '1'  AND  tbl_items.del_status = 'Live'  
          ORDER BY tbl_items.name ASC")->result();
        return $result;
    }

    /**
     * getPurchaseItems
     * @access public
     * @param int
     * @return object
     */
    public function getPurchaseItems($id) {
        $this->db->select("*");
        $this->db->from("tbl_purchase_details");
        $this->db->order_by('id', 'ASC');
        $this->db->where("purchase_id", $id);
        $this->db->where("del_status", 'Live');
        return $this->db->get()->result();
    }

}

