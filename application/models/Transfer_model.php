<?php
/*
  ###########################################################
  # PRODUCT NAME:   Off POS
  ###########################################################
  # AUTHER:   Doorsoft
  ###########################################################
  # EMAIL:   info@doorsoft.co
  ###########################################################
  # COPYRIGHTS:   RESERVED BY Door Soft
  ###########################################################
  # WEBSITE:   http://www.doorsoft.co
  ###########################################################
  # This is Transfer_model Model
  ###########################################################
 */
class Transfer_model extends CI_Model {

    /**
     * generatePurRefNo
     * @access public
     * @param int
     * @return string
     */
    public function generatePurRefNo($outlet_id) {
        $transfer_count = $this->db->query("SELECT count(id) as transfer_count
               FROM tbl_transfer where outlet_id=$outlet_id")->row('transfer_count');
        $ingredient_code = str_pad($transfer_count + 1, 6, '0', STR_PAD_LEFT);
        return $ingredient_code;
    }

    /**
     * getIngredientListWithUnitAndPrice
     * @access public
     * @param int
     * @return object
     */
    public function getIngredientListWithUnitAndPrice($company_id) {
        $result = $this->db->query("SELECT i.id, i.name, i.code, i.parent_id, i.purchase_price, i.type, u.unit_name, b.name as brand_name
            FROM tbl_items as i
            LEFT JOIN tbl_units as u ON i.sale_unit_id = u.id
            LEFT JOIN tbl_brands as b ON i.brand_id = b.id
            WHERE i.company_id=$company_id AND i.del_status = 'Live' AND  i.type != 'Variation_Product' AND i.type != 'Service_Product' 
            GROUP By i.id ORDER BY i.name ASC")->result();
        return $result;
    }

    /**
     * getTransferIngredients
     * @access public
     * @param int
     * @return object
     */
    public function getTransferIngredients($id) {
        $this->db->select("*");
        $this->db->from("tbl_transfer_items");
        $this->db->order_by('id', 'ASC');
        $this->db->where("transfer_id", $id);
        $this->db->where("del_status", 'Live');
        return $this->db->get()->result();
    }

    /**
     * getFoodDetails
     * @access public
     * @param int
     * @return object
     */
    public function getFoodDetails($id) {
        $this->db->select("ti.*, i.expiry_date_maintain");
        $this->db->from("tbl_transfer_items ti");
        $this->db->join("tbl_items i", 'i.id = ti.ingredient_id', 'left');
        $this->db->where("ti.transfer_id", $id);
        $this->db->where("ti.del_status", 'Live');
        $this->db->order_by('ti.id', 'ASC');
        $this->db->group_by('ti.ingredient_id');
        return $this->db->get()->result();
    }

    /**
     * getAllTrasferData
     * @access public
     * @param int
     * @return object
     */
    public function getAllTrasferData($outlet_id){
        $this->db->select("tbl_transfer.*, tbl_users.full_name as added_by");
        $this->db->from('tbl_transfer');
        $this->db->join('tbl_users', 'tbl_users.id = tbl_transfer.user_id');
        $this->db->where("(tbl_transfer.outlet_id = $outlet_id OR tbl_transfer.to_outlet_id = $outlet_id AND (tbl_transfer.status='1' OR tbl_transfer.status='3'))");
        $this->db->order_by('tbl_transfer.id', 'DESC');
        $this->db->where("tbl_transfer.del_status", 'Live');
        $result = $this->db->get();
        if($result != false){
            return $result->result();
        }else{
            return false;
        }
    }

    /**
     * getTotalCostAmount
     * @access public
     * @param int
     * @return object
     */
    public function getTotalCostAmount($food_menu_id) {
        $this->db->select('purchase_price,conversion_rate,tbl_items.id as ingredient_id');
        $this->db->from('tbl_items');
        $this->db->where('id', $food_menu_id);
        $this->db->where('enable_disable_status', 'Enable');
        $this->db->where('del_status', 'Live');
        return $this->db->get()->result();
    }


     /**
     * make_datatables
     * @access public
     * @param int
     * @param int
     * @return object
     */
    public function make_datatables($company_id, $outlet_id){
        $this->make_query($company_id, $outlet_id);
        if($_POST["length"]!=-1){
            $this->db->limit($_POST["length"],$_POST["start"]);
        }
        return $this->db->get()->result();
    }

    /**
     * make_query
     * @access public
     * @param int
     * @param int
     * @return void
     */
    public function make_query($company_id, $outlet_id=""){
        $outlet_id = $this->db->escape($outlet_id);
        $this->db->select("t.id, t.reference_no, t.date, t.status, t.from_outlet_id, t.to_outlet_id, t.received_date, t.added_date, u.full_name AS added_by, fo.outlet_name AS from_outlet_name, to.outlet_name AS to_outlet_name");
        $this->db->from('tbl_transfer t');
        $this->db->join('tbl_users u', 'u.id = t.user_id', 'left');
        $this->db->join('tbl_outlets fo', 'fo.id = t.from_outlet_id', 'left');
        $this->db->join('tbl_outlets to', 'to.id = t.to_outlet_id', 'left');
        if($_POST["search"]["value"]) {
            $this->db->group_start();
            $this->db->like("t.reference_no",$_POST["search"]["value"]);
            $this->db->or_like("t.status",$_POST["search"]["value"]);
            $this->db->or_like("fo.outlet_name",$_POST["search"]["value"]);
            $this->db->or_like("to.outlet_name",$_POST["search"]["value"]);
            $this->db->or_like("u.full_name",$_POST["search"]["value"]);
            $this->db->group_end();
        }
        $this->db->where("t.company_id", $company_id);
        $this->db->where("t.del_status", "Live");
        $this->db->where("
            CASE 
                WHEN t.from_outlet_id = $outlet_id THEN 
                    CASE 
                        WHEN t.status IN ('1', '2', '3') THEN 1
                        ELSE 0
                    END
                ELSE 
                    CASE 
                        WHEN t.status IN ('1', '3') THEN 1
                        ELSE 0
                    END
            END = 1
        ", NULL, FALSE);
        $this->db->order_by('t.id', 'DESC');
    }


    /**
     * get_all_data
     * @access public
     * @param int
     * @param int
     * @return int
     */
    public function get_all_data($company_id, $outlet_id=""){
        $this->db->select("*");
        $this->db->from('tbl_transfer');
        if($outlet_id){
            $this->db->where("outlet_id", $outlet_id);
        }
        $this->db->where("company_id", $company_id);
        $this->db->where("del_status", "Live");
        return $this->db->count_all_results();
    }


    /**
     * get_filtered_data
     * @access public
     * @param int
     * @param int
     * @return int
     */
    public function get_filtered_data($company_id, $outlet_id=""){
        $this->make_query($company_id, $outlet_id);
        $result = $this->db->get();
        return $result->num_rows();
    }
}

