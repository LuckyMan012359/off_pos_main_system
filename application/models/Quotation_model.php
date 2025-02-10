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
  # This is Quotation_model Model
  ###########################################################
 */
class Quotation_model extends CI_Model {
	
    /**
     * generateQuotationRefNo
     * @access public
     * @param int
     * @return string
     */
    public function generateQuotationRefNo($outlet_id) {
        $count = $this->db->query("SELECT count(id) as count
               FROM tbl_quotations where outlet_id=$outlet_id")->row('count');
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
        $result = $this->db->query("SELECT i.id, i.parent_id, i.type, i.name, i.code, i.purchase_price,i.sale_price,i.last_three_purchase_avg, i.last_purchase_price,i.conversion_rate,pu.unit_name as purchase_unit, su.unit_name as sale_unit, b.name as brand_name
          FROM tbl_items as i
          LEFT JOIN tbl_units as pu ON i.purchase_unit_id = pu.id
          LEFT JOIN tbl_units as su ON i.sale_unit_id = su.id
          LEFT JOIN tbl_brands as b ON i.brand_id = b.id
          WHERE i.company_id=$company_id AND  i.del_status = 'Live'  AND  i.type != 'Variation_Product' AND  i.type != 'Service_Product'  
          ORDER BY i.name ASC")->result();
        return $result;
    }

    /**
     * getQuotationItems
     * @access public
     * @param int
     * @return object
     */
    public function getQuotationItems($id) {
        $this->db->select("qd.*, i.name as item_name, i.code as item_code,i.conversion_rate,i.unit_type, i.parent_id, b.name as brand_name, pui.unit_name as purchase_unit_name");
        $this->db->from("tbl_quotation_details qd");
        $this->db->join('tbl_items i','qd.item_id=i.id','left');
        $this->db->join('tbl_brands b','b.id = i.brand_id','left');
        $this->db->join('tbl_units pui','pui.id = i.purchase_unit_id','left');
        $this->db->where("qd.quotation_id", $id);
        $this->db->where("qd.del_status", 'Live');
        $this->db->order_by('qd.id', 'ASC');
        $result = $this->db->get()->result();
        return $result;
    }

    /**
     * make_datatables
     * @access public
     * @param int
     * @return object
     */
    public function make_datatables($company_id){
        $this->make_query($company_id);
        if($_POST["length"]!=-1){
            $this->db->limit($_POST["length"],$_POST["start"]);
        }
        return $this->db->get()->result();
    }
    /**
     * make_query
     * @access public
     * @param int
     * @return void
     */
    public function make_query($company_id){
        $outlet_id = $this->session->userdata('outlet_id');
        $this->db->select("q.id,q.reference_no,q.date,q.discount,q.grand_total,q.added_date, c.name as customer_name, u.full_name as added_by");
        $this->db->from('tbl_quotations q');
        $this->db->join('tbl_customers c', 'c.id = q.customer_id', 'left');
        $this->db->join('tbl_users u', 'u.id = q.user_id', 'left');
        if($_POST["search"]["value"]) {
            $this->db->group_start();
            $this->db->like("q.reference_no",$_POST["search"]["value"]);
            $this->db->or_like("c.name",$_POST["search"]["value"]);
            $this->db->or_like("u.full_name",$_POST["search"]["value"]);
            $this->db->group_end();
        }
        $this->db->where("q.outlet_id", $outlet_id);
        $this->db->where("q.company_id", $company_id);
        $this->db->where("q.del_status", "Live");
        $this->db->order_by('q.id', 'DESC');
    }
   

    /**
     * get_all_data
     * @access public
     * @param int
     * @return int
     */
    public function get_all_data($company_id){
        $this->db->select("*");
        $this->db->from('tbl_quotations');
        $this->db->where("company_id", $company_id);
        $this->db->where("del_status", "Live");
        return $this->db->count_all_results();
    }
       

    /**
     * get_filtered_data
     * @access public
     * @param int
     * @return int
     */
    public function get_filtered_data($company_id){
        $this->make_query($company_id);
        $result = $this->db->get();
        return $result->num_rows();
    }
    
    /**
     * getDrawData
     * @access public
     * @param no
     * @return void
     */
    public function getDrawData(){
        return $_POST["draw"];
    }
}

