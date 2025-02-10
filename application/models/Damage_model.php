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
  # This is Damage_model Model
  ###########################################################
 */
class Damage_model extends CI_Model {

    /**
     * getItemList
     * @access public
     * @param no
     * @return object
     */
    public function getItemList() {
        $company_id = $this->session->userdata('company_id');
        $this->db->select("i.id, i.type, i.name, i.code, i.purchase_price as sale_price, tbl_units.unit_name");
        $this->db->from("tbl_items i");
        $this->db->join("tbl_units", 'tbl_units.id = i.sale_unit_id', 'left');
        $this->db->where("i.p_type !=", 'Service_Product');
        $this->db->where("i.p_type !=", 'Variation_Product');
        $this->db->where("i.company_id", $company_id);
        $this->db->where("i.del_status", 'Live');
        $this->db->order_by("i.name", "ASC");
        $result = $this->db->get()->result();
        return $result;
    } 

    /**
     * getDamageItems
     * @access public
     * @param int
     * @return object
     */
    public function getDamageItems($id) {
        $this->db->select("dd.*, i.expiry_date_maintain");
        $this->db->from("tbl_damage_details dd");
        $this->db->join("tbl_items i", 'i.id = dd.item_id', 'left');
        $this->db->where("dd.damage_id", $id);
        $this->db->where("dd.del_status", 'Live');
        $this->db->order_by('dd.id', 'ASC');
        $this->db->group_by('dd.item_id');
        return $this->db->get()->result();
    }

    /**
     * generateDamageRefNo
     * @access public
     * @param int
     * @return string
     */
    public function generateDamageRefNo($outlet_id) {
        $damage_count = $this->db->query("SELECT count(id) as damage_count
               FROM tbl_damages where outlet_id=$outlet_id")->row('damage_count');
        $item_code = str_pad($damage_count + 1, 6, '0', STR_PAD_LEFT);
        return $item_code;
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
        $this->db->select("d.id,d.reference_no,d.date,d.total_loss,d.note,d.added_date,r.full_name as responsible_person, u.full_name as added_by, COUNT(dd.id) as total_items");
        $this->db->from('tbl_damages d');
        $this->db->join('tbl_damage_details dd', 'dd.damage_id = d.id', 'left');
        $this->db->join('tbl_users r', 'r.id = d.employee_id', 'left');
        $this->db->join('tbl_users u', 'u.id = d.user_id', 'left');
        if($_POST["search"]["value"]) {
            $this->db->group_start();
            $this->db->like("d.reference_no",$_POST["search"]["value"]);
            $this->db->or_like("d.total_loss",$_POST["search"]["value"]);
            $this->db->or_like("r.full_name",$_POST["search"]["value"]);
            $this->db->group_end();
        }
        $this->db->where("d.outlet_id", $outlet_id);
        $this->db->where("d.company_id", $company_id);
        $this->db->where("d.del_status", "Live");
        $this->db->group_by('d.id');
        $this->db->order_by('d.id', 'DESC');
    }


       /**
     * get_all_data
     * @access public
     * @param int
     * @return int
     */
    public function get_all_data($company_id){
        $this->db->select("*");
        $this->db->from('tbl_damages');
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
}

