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
  # This is Promotion_model Model
  ###########################################################
 */
class Promotion_model extends CI_Model {

    /**
     * getIngredientList
     * @access public
     * @param no
     * @return object
     */
    public function getIngredientList() {
        $outlet_id = $this->session->userdata('outlet_id');
        $company_id = $this->session->userdata('company_id');
        $this->db->select("tbl_items.id, tbl_items.name, tbl_items.code, tbl_purchase_details.unit_price as purchase_price, tbl_units.unit_name");
        $this->db->from("tbl_items");
        $this->db->join("tbl_purchase_details", 'tbl_purchase_details.item_id = tbl_items.id', 'left');
        $this->db->join("tbl_units", 'tbl_units.id = tbl_items.unit_id', 'left');
        $this->db->order_by("tbl_items.name", "ASC");
        $this->db->where("tbl_items.company_id", $company_id);
        $this->db->where("tbl_purchase_details.del_status", 'Live');
        $this->db->where("tbl_purchase_details.outlet_id", $outlet_id);
        $result = $this->db->get()->result();
        return $result;
    }
    /**
     * getFoodMenuList
     * @access public
     * @param no
     * @return object
     */
    public function getFoodMenuList() {
        $outlet_id = $this->session->userdata('outlet_id');
        $company_id = $this->session->userdata('company_id');
        $this->db->select("id,name,code");
        $this->db->from("tbl_items");
        $this->db->order_by("tbl_items.name", "ASC");
        $this->db->where("type !=", 'Service_Product');
        $this->db->where("company_id", $company_id);
        $this->db->where("del_status", 'Live');
        $result = $this->db->get()->result();
        return $result;
    }

    /**
     * checkPromotionWithinDate
     * @access public
     * @param string 
     * @param string 
     * @param int 
     * @return object
     */
    public function checkPromotionWithinDate($start_date,$end_date,$food_menu_id) {
        $outlet_id = $this->session->userdata('outlet_id');
        $this->db->select('*');
        $this->db->from('tbl_promotions');
        if ($start_date != '' && $end_date != '') {
            $this->db->where('start_date>=', $start_date);
            $this->db->where('start_date <=', $end_date);
        }
        if($food_menu_id){
            $this->db->where('food_menu_id', $food_menu_id);
        }
        $this->db->where('status', 1);
        $this->db->where('outlet_id', $outlet_id);
        $this->db->where('del_status', 'Live');
        $query_result = $this->db->get();
        $result = $query_result->result();
        if(isset($result) && $result){
            return $result;
        }

        $this->db->select('*');
        $this->db->from('tbl_promotions');
        if ($start_date != '' && $end_date != '') {
            $this->db->where('end_date>=', $start_date);
            $this->db->where('end_date <=', $end_date);
        }
        if($food_menu_id){
            $this->db->where('food_menu_id', $food_menu_id);
        }
        $this->db->where('outlet_id', $outlet_id);
        $this->db->where('status', 1);
        $this->db->where('del_status', 'Live');
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }

    /**
     * generatePromotionRefNo
     * @access public
     * @param int
     * @return string
     */
    public function generatePromotionRefNo($outlet_id) {
        $promotion_count = $this->db->query("SELECT count(id) as promotion_count
               FROM tbl_promotions where outlet_id=$outlet_id")->row('promotion_count');
        $ingredient_code = str_pad($promotion_count + 1, 6, '0', STR_PAD_LEFT);
        return $ingredient_code;
    }

}

