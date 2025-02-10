<?php
defined('BASEPATH') OR exit('No direct script access allowed');
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
  # This is API_model Model
  ###########################################################
 */


/**
 * Description of common_model
 *
 * @author user
 */
class API_model extends CI_Model {
    


    /**
     * getItemList
     * @access public
     * @param no
     * @return object
     */
    public function getItemList() {
        $this->db->select('i.id,i.code as item_code,i.name as item_name,i.alternative_name,i.generic_name,i.type as item_type, i.category_id,c.name as category_name, i.rack_id, i.brand_id, b.name as brand_name, i.supplier_id, s.name as supplier_name, i.alert_quantity, i.unit_type, i.purchase_unit_id,pu.unit_name as purchase_unit, i.sale_unit_id, su.unit_name as sale_unit, i.conversion_rate, i.purchase_price, i.last_three_purchase_avg, i.last_purchase_price, i.sale_price, i.whole_sale_price, i.description, i.warranty, i.warranty_date, i.guarantee, i.guarantee_date, i.tax_information, i.tax_string, i.variation_details, i.parent_id, i.loyalty_point, i.added_date, i.user_id,i.company_id,i.del_status');
        $this->db->from('tbl_items i');
        $this->db->join('tbl_item_categories c', 'c.id = i.category_id', 'left');
        $this->db->join('tbl_brands b', 'b.id = i.brand_id', 'left');
        $this->db->join('tbl_suppliers s', 's.id = i.supplier_id', 'left');
        $this->db->join('tbl_units pu', 'pu.id = i.purchase_unit_id', 'left');
        $this->db->join('tbl_units su', 'su.id = i.sale_unit_id', 'left');
        $this->db->where('i.del_status', 'Live');
        $this->db->order_by('i.id', 'DESC');
        return $this->db->get()->result();     
    }

    /**
     * getSaleList
     * @access public
     * @param no
     * @return object
     */
    public function getSaleList() {
        $this->db->select('*');
        $this->db->from('tbl_sales');
        $this->db->where('del_status', 'Live');
        $this->db->order_by('id', 'DESC');
        return $this->db->get()->result();     
    }







    
}

?>
