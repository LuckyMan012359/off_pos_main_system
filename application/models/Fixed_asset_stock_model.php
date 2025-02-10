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
  # This is Fixed_asset_stock_model Model
  ###########################################################
 */
class Fixed_asset_stock_model extends CI_Model {

    /**
     * generatePurRefNo
     * @access public
     * @param int
     * @return string
     */
    public function generatePurRefNo($company_id) {
        $count = $this->db->query("SELECT count(id) as count
               FROM tbl_fixed_asset_stocks where company_id=$company_id")->row('count');
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
        $this->db->from("tbl_fixed_asset_stock_details fs");
        $this->db->join('tbl_fixed_asset_items fi','fs.item_id=fi.id','left');
        $this->db->where("fs.asset_stocks_id", $id);
        $this->db->where("fs.del_status", 'Live');
        $this->db->order_by('fs.id', 'ASC');
        $result = $this->db->get()->result();
        return $result;
    }


    /**
     * fixedAssetStocks
     * @access public
     * @param int
     * @return object
     */
    public function fixedAssetStocks($company_id) {
        $this->db->select("i.id, i.name, SUM(s.quantity_amount) - SUM(o.quantity_amount) as current_stock_qty, SUM(s.unit_price * s.quantity_amount) - SUM(o.unit_price * o.quantity_amount) as current_stock_price");
        $this->db->from("tbl_fixed_asset_items i");
        $this->db->join('tbl_fixed_asset_stock_details s', 's.item_id = i.id', 'left');
        $this->db->join('tbl_fixed_asset_stock_out_details o', 'o.item_id = i.id', 'left');
        $this->db->where('i.del_status', 'Live');
        $this->db->where('i.company_id', $company_id);
        $this->db->group_by('i.id, i.name');
        $this->db->order_by('i.name', 'ASC');
        $result = $this->db->get()->result();
        return $result;
    }
    
}

