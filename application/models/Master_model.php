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
  # This is Master_model Model
  ###########################################################
 */
class Master_model extends CI_Model { 

    /**
     * generateItemCode
     * @access public
     * @param no
     * @return string
     */
    public function generateItemCode() {
        $company_id = $this->session->userdata('company_id');
        $item_count = $this->db->query("SELECT count(id) as item_count
             FROM tbl_items where company_id='$company_id'")->row('item_count');
        $food_menu_code = str_pad($item_count + 1, 3, '0', STR_PAD_LEFT);
        return $food_menu_code;
    }

    /**
     * generateItemCode
     * @access public
     * @param no
     * @return string
     */
    public function generateItemCodeByCompanyId($company_id) {
        $item_count = $this->db->query("SELECT count(id) as item_count
             FROM tbl_items where company_id='$company_id'")->row('item_count');
        $food_menu_code = str_pad($item_count + 1, 3, '0', STR_PAD_LEFT);
        return $food_menu_code;
    }

    /**
     * getLastRow
     * @access public
     * @param no
     * @return string
     */
    public function getLastRow() {
        $item_count = $this->db->query("SELECT id
             FROM tbl_sales ORDER BY id DESC ")->row('id');
        $sale_no = str_pad($item_count + 1, 6, '0', STR_PAD_LEFT);
        return $sale_no;
    }

    /**
     * getIngredientListWithUnit
     * @access public
     * @param int
     * @return object
     */
    public function getIngredientListWithUnit($company_id) {
        $result = $this->db->query("SELECT tbl_items.id, tbl_items.name, tbl_items.code, tbl_units.unit_name 
          FROM tbl_items 
          JOIN tbl_units ON tbl_items.unit_id = tbl_units.id
          WHERE tbl_items.company_id=$company_id AND tbl_items.del_status = 'Live'  
          ORDER BY tbl_items.name ASC")->result();
        return $result;
    }

   

    /**
     * getCategoryId
     * @access public
     * @param int
     * @return int
     */
    function getCategoryId($category) {
        $company_id = $this->session->userdata('company_id');
        $user_id = $this->session->userdata('user_id');
        $this->db->select('id');
        $this->db->from('tbl_item_categories');
        $this->db->where('company_id',$company_id);
        $this->db->where('name', $category);
        $value =  $this->db->get()->row();
        if($value){
            return $value->id;
        }else{
            $data =  array('name' => $category, 'company_id'=>$company_id, 'user_id'=>$user_id);
            $this->db->insert('tbl_item_categories',$data);
            $id=$this->db->insert_id();
            return $id;
        }
    }
    /**
     * getSupplierId
     * @access public
     * @param int
     * @return int
     */
    function getSupplierId($supplier) {
        $company_id = $this->session->userdata('company_id');
        $user_id = $this->session->userdata('user_id');
        $this->db->select('id');
        $this->db->from('tbl_suppliers');
        $this->db->where('company_id',$company_id);
        $this->db->where('name', $supplier);
        $value =  $this->db->get()->row();
        if($value){
            return $value->id;
        }else{
            $data =  array('name' => $supplier, 'company_id'=>$company_id, 'user_id'=>$user_id);
            $this->db->insert('tbl_suppliers',$data);
            $id=$this->db->insert_id();
            return $id;
        }
    }
    
    /**
     * getBrandId
     * @access public
     * @param int
     * @return int
     */
    function getBrandId($brand) {
        $company_id = $this->session->userdata('company_id');
        $user_id = $this->session->userdata('user_id');
        $this->db->select('id');
        $this->db->from('tbl_brands');
        $this->db->where('company_id',$company_id);
        $this->db->where('name',$brand);
        $value =  $this->db->get()->row();
        if($value){
            return $value->id;
        }else{
            $data =  array('name' => $brand, 'company_id'=>$company_id, 'user_id'=>$user_id);
            $this->db->insert('tbl_brands',$data);
            $id=$this->db->insert_id();
            return $id;
        }
    }

    /**
     * sendEmail
     * @access public
     * @param string
     * @param string
     * @param string
     * @return boolean
     */
    function sendEmail($to,$subject,$msg){
        mail($to,$subject,$msg);
        return true;
    }

    /**
     * make_query
     * @access public
     * @param int
     * @param int
     * @param int
     * @param int
     * @return void
     */
    public function make_query($company_id,$category_id='',$supplier_id=''){
        $this->db->select("i.id,i.name,i.code,i.type,i.purchase_price,i.sale_price,i.enable_disable_status,i.del_status,i.added_date,u.full_name, c.name as category_name");
        $this->db->from('tbl_items i');
        $this->db->join('tbl_users u', 'u.id = i.user_id', 'left');
        $this->db->join('tbl_item_categories c', 'c.id = i.category_id', 'left');
        if($category_id !=''){
            $this->db->where("i.category_id", $category_id);
        }
        if($supplier_id !=''){
            $this->db->where("i.supplier_id", $supplier_id);
        }
        $this->db->where("i.company_id", $company_id);
        $this->db->where("i.parent_id", '0');
        $this->db->where("i.del_status", "Live");
        if($_POST["search"]["value"]) {
            $this->db->group_start();
            $this->db->like("i.name",$_POST["search"]["value"]);
            $this->db->or_like("i.code",$_POST["search"]["value"]);
            $this->db->or_like("i.type",$_POST["search"]["value"]);
            $this->db->or_like("c.name",$_POST["search"]["value"]);
            $this->db->or_like("i.description",$_POST["search"]["value"]);
            $this->db->or_like("u.full_name",$_POST["search"]["value"]);
            $this->db->group_end();
        }
        $this->db->order_by('i.id', 'DESC');
    }
    /**
     * make_queryForBooking
     * @access public
     * @param int
     * @param int
     * @param int
     * @param int
     * @return void
     */
    public function make_queryForBooking(){
        $company_id = $this->session->userdata('company_id');
        $this->db->select('b.id, b.start_date, b.end_date, b.added_date, c.name as customer_name, u.full_name as service_seller_name, o.outlet_name, uu.full_name as added_by');
        $this->db->from('tbl_bookings b');
        $this->db->join('tbl_customers c', 'c.id = b.customer_id', 'left');
        $this->db->join('tbl_users u', 'u.id = b.service_seller_id', 'left');
        $this->db->join('tbl_users uu', 'uu.id = b.user_id', 'left');
        $this->db->join('tbl_outlets o', 'o.id = b.outlet_id', 'left');
        $this->db->where('b.company_id', $company_id);
        $this->db->where('b.del_status', 'Live');
        $this->db->order_by('b.id', 'DESC');
    }

    /**
     * make_query
     * @access public
     * @param int
     * @param int
     * @param int
     * @param int
     * @return void
     */
    public function make_queryBulks($company_id){
        $company_id = $this->session->userdata('company_id');
        $this->db->select('id, name, code, type, sale_price, whole_sale_price, enable_disable_status, photo');
        $this->db->from('tbl_items');
        $this->db->where("type !=", 'Variation_Product');
        $this->db->where("type !=", '0');
        $this->db->where("type !=", 'Combo_Product');
        $this->db->where("company_id", $company_id);
        $this->db->where("del_status", 'Live');
        $this->db->order_by('id', 'DESC');
    }


    /**
     * make_datatables
     * @access public
     * @param int
     * @param int
     * @param int
     * @return object
     */
    public function make_datatables($company_id,$category_id,$supplier_id){
        $this->make_query($company_id,$category_id,$supplier_id);
        if($_POST["length"]!=-1){
            $this->db->limit($_POST["length"],$_POST["start"]);
        }
        return $this->db->get()->result();
    }
    /**
     * make_datatables
     * @access public
     * @param int
     * @param int
     * @param int
     * @return object
     */
    public function make_datatablesForBooking(){
        $this->make_queryForBooking();
        if($_POST["length"]!=-1){
            $this->db->limit($_POST["length"],$_POST["start"]);
        }
        return $this->db->get()->result();
    }
    /**
     * make_bulkdatatables
     * @access public
     * @param int
     * @param int
     * @param int
     * @return object
     */
    public function make_bulkdatatables($company_id){
        $this->make_queryBulks($company_id);
        if($_POST["length"]!=-1){
            $this->db->limit($_POST["length"],$_POST["start"]);
        }
        return $this->db->get()->result();
    }
    /**
     * get_all_data
     * @access public
     * @param int
     * @param int
     * @param int
     * @return int
     */
    public function get_all_data($company_id,$category_id='',$supplier_id=''){
        $this->db->select("*");
        $this->db->from('tbl_items');
        $this->db->where("company_id", $company_id);
        if($category_id!=''){
            $this->db->where("category_id", $category_id);
        }
        if($supplier_id!=''){
            $this->db->where("supplier_id", $supplier_id);
        }
        $this->db->where("enable_disable_status", "Enable");
        $this->db->where("del_status", "Live");
        return $this->db->count_all_results();
    }
    /**
     * get_all_data
     * @access public
     * @param int
     * @param int
     * @param int
     * @return int
     */
    public function get_all_booking_data(){
        $company_id = $this->session->userdata('company_id');
        $this->db->select("*");
        $this->db->from('tbl_bookings');
        $this->db->where("company_id", $company_id);
        $this->db->where("del_status", "Live");
        return $this->db->count_all_results();
    }

    /**
     * get_filtered_data
     * @access public
     * @param int
     * @param int
     * @param int
     * @return int
     */
    public function get_filtered_data($company_id,$category_id='',$supplier_id=''){
        $this->make_query($company_id,$category_id,$supplier_id);
        $result = $this->db->get();
        return $result->num_rows();
    }
    /**
     * get_filtered_data
     * @access public
     * @param int
     * @param int
     * @param int
     * @return int
     */
    public function get_filtered_data_for_booking(){
        $this->make_queryForBooking();
        $result = $this->db->get();
        return $result->num_rows();
    }

}

