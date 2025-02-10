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
  # This is Fixed_asset_stock_model_out Model
  ###########################################################
 */
class Fixed_asset_stock_model_out extends CI_Model {

    /**
     * generatePurRefNo
     * @access public
     * @param int
     * @return string
     */
    public function generatePurRefNo($company_id) {
        $count = $this->db->query("SELECT count(id) as count
               FROM tbl_fixed_asset_stock_outs where company_id=$company_id")->row('count');
        $code = str_pad($count + 1, 6, '0', STR_PAD_LEFT);
        return $code;
    }

    /**
     * getItemList
     * @access public
     * @param int
     * @return object
     */
    public function getItemList($company_id) {
        $result = $this->db->query("SELECT i.id, i.name
          FROM tbl_fixed_asset_items as i
          WHERE i.company_id=$company_id AND  i.del_status = 'Live'  
          ORDER BY i.name ASC")->result();
        return $result;
    }


    /**
     * getPurchaseItems
     * @access public
     * @param int
     * @return object
     */
    public function getFixedAssetItems($id) {
        $this->db->select("fs.*, fi.name as item_name");
        $this->db->from("tbl_fixed_asset_stock_out_details fs");
        $this->db->join('tbl_fixed_asset_items fi','fs.item_id=fi.id','left');
        $this->db->where("fs.asset_stock_out_id", $id);
        $this->db->where("fs.del_status", 'Live');
        $this->db->order_by('fs.id', 'ASC');
        $result = $this->db->get()->result();
        return $result;
    }

}

