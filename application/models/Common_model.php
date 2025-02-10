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
  # This is Common_model Model
  ###########################################################
 */

/**
 * Description of common_model
 *
 * @author user
 */

class Common_model extends CI_Model {


    /**
     * getDataCustomName
     * @access public
     * @param string
     * @param string
     * @param string
     * @return object
     */
    public function getDataCustomName($tbl, $db_field,$search_value){
        $this->db->select('i.name as menu_name, sd.food_menu_id, sd.menu_unit_price, sd.qty, sd.menu_discount_value, sd.menu_price_with_discount,sd.menu_price_without_discount');
        $this->db->from("$tbl sd");
        $this->db->join("tbl_items i", 'i.id = sd.food_menu_id', 'left');
        $this->db->where($db_field, $search_value);
        $this->db->where("sd.del_status", 'Live');
        return $this->db->get()->result();
    }
    /**
     * getAllBooking
     * @access public
     * @param string
     * @param string
     * @param string
     * @return object
     */
    public function getAllBooking(){
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
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }

    /**
     * getSaleById
     * @access public
     * @param int
     * @return object
     */
    public function getSaleById($id){
        $this->db->select('*');
        $this->db->from('tbl_sales');
        $this->db->where('id', $id);
        $this->db->where('del_status', 'Live');
        return $this->db->get()->row();
    }

    /**
     * getSaleDetailsBySaleById
     * @access public
     * @param int
     * @return object
     */
    public function getSaleDetailsBySaleById($id){
        $this->db->select('sd.*, u.unit_name, i.type, i.name as item_name, i.code as item_code, i.parent_id');
        $this->db->from('tbl_sales_details sd');
        $this->db->join('tbl_items i','sd.food_menu_id=i.id','left');
        $this->db->join('tbl_units u','u.id=i.sale_unit_id','left');
        $this->db->where('sd.sales_id', $id);
        $this->db->where('sd.promo_parent_id', '0');
        $this->db->where('sd.del_status', 'Live');
        return $this->db->get()->result();
    }

    /**
     * getAllByTable
     * @access public
     * @param string
     * @return object
     */
    public function getAllByTable($table_name) {
        $this->db->select("*");
        $this->db->from($table_name);
        if ($table_name == 'tbl_units') {
            $this->db->order_by('unit_name', 'ASC');
        }else{
            $this->db->order_by(2, 'ASC');
        }
        $this->db->where("del_status", 'Live');
        $result = $this->db->get();   
        if($result != false){  
            return $result->result();
        }else{
            return false;
        }
    }

    /**
     * getAllByTable
     * @access public
     * @param no
     * @return object
     */
    public function getAllAccess() {
        $company_id = $this->session->userdata('company_id');
        $this->db->select("*");
        $this->db->from('tbl_access');
        $this->db->where("parent_id !=", '');
        $this->db->where("del_status", 'Live');
        $result = $this->db->get();   
        if($result != false){  
            return $result->result();
        }else{
            return false;
        }
    }


    /**
     * getAllByCustomId
     * @access public
     * @param int
     * @param string
     * @param string
     * @param string
     * @return object
     */
    public function getAllByCustomId($id,$filed,$tbl,$order=''){
        $this->db->select('*');
        $this->db->from($tbl);
        $this->db->where($filed,$id);
        if($order!=''){
            $this->db->order_by('id',$order);
        }
        $this->db->where("del_status", 'Live');
        $result = $this->db->get();   
        
        if($result != false){  
            return $result->result();
        }else{
            return false;
        }
    }

    /**
     * getRolePermissionByRoleId
     * @access public
     * @param int
     * @return object
     */
    public function getRolePermissionByRoleId($role_id){
        $this->db->select('*');
        $this->db->from('tbl_role_access');
        $this->db->where('role_id', $role_id);
        $this->db->where("del_status", 'Live');
        $result = $this->db->get();   
        if($result != false){  
            return $result->result();
        }else{
            return false;
        }
    }

    /**
     * getAllByCustomRowId
     * @access public
     * @param int
     * @param string
     * @param string
     * @param string
     * @return object
     */
    public function getAllByCustomRowId($id,$filed,$tbl,$order=''){
        $this->db->select('*');
        $this->db->from($tbl);
        $this->db->where($filed,$id);
        if($order!=''){
            $this->db->order_by('id',$order);
        }
        $this->db->where("del_status", 'Live');
        return $this->db->get()->row();
    }

    /**
     * getAllCustomData
     * @access public
     * @param string
     * @param string
     * @param string
     * @param string
     * @param string
     * @return object
     */
    public function getAllCustomData($tbl,$order_colm,$order_type,$where_colm,$coln_value) {
        $this->db->select('*');
        $this->db->from($tbl);
        if($order_colm!=''){
            $this->db->order_by($order_colm,$order_type);
        }
        if($where_colm!=''){
            $this->db->where($where_colm,$coln_value);
        }
        $this->db->where("del_status", 'Live');
        $result = $this->db->get();   
        
        if($result != false){  
            return $result->result();
        }else{
            return false;
        }
    }

    /**
     * getAllAccessMainModule
     * @access public
     * @param no
     * @return object
     */
    public function getAllAccessMainModule() {
        $this->db->select('*');
        $this->db->from('tbl_access');
        $this->db->where('parent_id', NULL);
        $this->db->where('del_status', 'Live');
        $this->db->order_by('main_module_id', 'ASC');
        $result = $this->db->get();   
        if($result != false){  
            return $result->result();
        }else{
            return false;
        }
    }
    
    /**
     * getModuleManagement
     * @access public
     * @param no
     * @return object
     */
    public function getModuleManagement() {
        $this->db->select('*');
        $this->db->from('tbl_module_managements');
        $this->db->where('parent_id', NULL);
        $this->db->where('del_status', 'Live');
        $result = $this->db->get();   
        if($result != false){  
            return $result->result();
        }else{
            return false;
        }
    }


    /**
     * getAllAccessFunction
     * @access public
     * @param int
     * @return object
     */
    public function getAllAccessFunction($parent_id) {
        $this->db->select('*');
        $this->db->from('tbl_access');
        $this->db->where('parent_id', $parent_id);
        $this->db->where('del_status', 'Live');
        $this->db->order_by('label_name', 'ASC');
        $result = $this->db->get();   
        if($result != false){  
            return $result->result();
        }else{
            return false;
        }
    }


    /**
     * getAllByCompanyId
     * @access public
     * @param int
     * @param string
     * @return object
     */
    public function getAllByCompanyId($company_id, $table_name) {
		$this->db->select('*');
		$this->db->from($table_name);
		$this->db->where('company_id', $company_id);
		$this->db->where('del_status', 'Live');
		$this->db->order_by('id', 'DESC');
		$result = $this->db->get(); 
        if($result != false){  
            return $result->result();
        }else{
            return false;
        }
    }
    /**
     * getAllItemsWithoutCombo
     * @access public
     * @param int
     * @param string
     * @return object
     */
    public function getAllItemsWithoutCombo($company_id) {
		$this->db->select('id,code,name,type,sale_price');
		$this->db->from('tbl_items');
		$this->db->where('type !=', 'Combo_Product');
		$this->db->where('company_id', $company_id);
		$this->db->where('del_status', 'Live');
		$this->db->order_by('id', 'DESC');
		$result = $this->db->get(); 
        if($result != false){  
            return $result->result();
        }else{
            return false;
        }
    }
    /**
     * getComboChildItemByComboId
     * @access public
     * @param int
     * @param string
     * @return object
     */
    public function getComboChildItemByComboId($id) {
		$this->db->select('ci.*, i.name as item_name');
		$this->db->from('tbl_combo_items ci');
		$this->db->join('tbl_items i', 'ci.item_id = i.id', 'left');
		$this->db->where('ci.combo_id =', $id);
		$this->db->where('ci.del_status', 'Live');
		$this->db->group_by('ci.id', 'ASC');
		$result = $this->db->get(); 
        if($result != false){  
            return $result->result();
        }else{
            return false;
        }
    }

    /**
     * getCompanyPaymentGetway
     * @access public
     * @param no
     * @return object
     */
    public function getCompanyPaymentGetway() {
        $company_id = $this->session->userdata('company_id');
		$this->db->select('payment_api_setting');
		$this->db->from('tbl_companies');
		$this->db->where('id', $company_id);
		$this->db->where('del_status', 'Live');
		$result = $this->db->get(); 
        if($result != false){  
            return $result->row();
        }else{
            return false;
        }
    }

    /**
     * getCompanyPaymentGetway
     * @access public
     * @param no
     * @return object
     */
    public function getAllExpenseCategoryASC() {
        $company_id = $this->session->userdata('company_id');
		$this->db->select('id,name');
		$this->db->from('tbl_expense_items');
		$this->db->where('company_id', $company_id);
		$this->db->where('del_status', 'Live');
		$this->db->order_by('name', 'ASC');
		$result = $this->db->get(); 
        if($result != false){  
            return $result->result();
        }else{
            return false;
        }
    }



    /**
     * getAllCustomersWithOpeningBalance
     * @access public
     * @param no
     * @return object
     * Added By Azhar
     */
    public function getAllCustomersWithOpeningBalance(){
        $company_id = $this->session->userdata('company_id');
        $query = "SELECT 
        c.id, c.name, c.phone, c.email, c.address, c.opening_balance, c.opening_balance_type,
        c.credit_limit, c.gst_number, c.customer_type, c.discount, c.price_type,
        c.same_or_diff_state, c.del_status, c.added_date, u.full_name AS added_by,
        CASE 
            WHEN c.opening_balance_type = 'Credit' THEN 
                - c.opening_balance + COALESCE(sale_sum.due_amount_sum, 0) - COALESCE(due_receive_sum.amount_sum, 0) - COALESCE(return_sum.total_return_amount_sum, 0)
            ELSE 
                c.opening_balance + COALESCE(sale_sum.due_amount_sum, 0) - COALESCE(due_receive_sum.amount_sum, 0) - COALESCE(return_sum.total_return_amount_sum, 0)
        END AS opening_balance
        FROM 
            tbl_customers c
        LEFT JOIN 
            (SELECT customer_id, COALESCE(SUM(due_amount), 0) AS due_amount_sum FROM tbl_sales WHERE del_status = 'Live' GROUP BY customer_id) AS sale_sum ON c.id = sale_sum.customer_id
        LEFT JOIN 
            (SELECT customer_id, COALESCE(SUM(amount), 0) AS amount_sum FROM tbl_customer_due_receives WHERE del_status = 'Live' GROUP BY customer_id) AS due_receive_sum ON c.id = due_receive_sum.customer_id
        LEFT JOIN 
            (SELECT customer_id, COALESCE(SUM(due), 0) AS total_return_amount_sum FROM tbl_sale_return WHERE del_status = 'Live' GROUP BY customer_id) AS return_sum ON c.id = return_sum.customer_id
        LEFT JOIN 
            tbl_users u ON u.id = c.user_id
        WHERE
            c.company_id = ? AND c.del_status = 'Live'
        GROUP BY 
            c.id
        ORDER BY 
            c.id DESC";
        $result = $this->db->query($query, array($company_id))->result();
        return $result;  
    }

    /**
     * getAllDebitCustomers
     * @access public
     * @param no
     * @return object
     * Added By Azhar
     */
    public function getAllDebitCustomers(){
        $company_id = $this->session->userdata('company_id');
        $query = "SELECT 
        c.id, c.name, c.phone, c.email, c.address, c.opening_balance, c.opening_balance_type,
        c.credit_limit, c.gst_number, c.customer_type, c.discount, c.price_type,
        c.same_or_diff_state, c.del_status, c.added_date, u.full_name AS added_by,
        CASE 
            WHEN c.opening_balance_type = 'Credit' THEN 
                - c.opening_balance + COALESCE(sale_sum.due_amount_sum, 0) - COALESCE(due_receive_sum.amount_sum, 0) - COALESCE(return_sum.total_return_amount_sum, 0)
            ELSE 
                c.opening_balance + COALESCE(sale_sum.due_amount_sum, 0) - COALESCE(due_receive_sum.amount_sum, 0) - COALESCE(return_sum.total_return_amount_sum, 0)
        END AS opening_balance
        FROM 
            tbl_customers c
        LEFT JOIN 
            (SELECT customer_id, COALESCE(SUM(due_amount), 0) AS due_amount_sum FROM tbl_sales WHERE del_status = 'Live' GROUP BY customer_id) AS sale_sum ON c.id = sale_sum.customer_id
        LEFT JOIN 
            (SELECT customer_id, COALESCE(SUM(amount), 0) AS amount_sum FROM tbl_customer_due_receives WHERE del_status = 'Live' GROUP BY customer_id) AS due_receive_sum ON c.id = due_receive_sum.customer_id
        LEFT JOIN 
            (SELECT customer_id, COALESCE(SUM(due), 0) AS total_return_amount_sum FROM tbl_sale_return WHERE del_status = 'Live' GROUP BY customer_id) AS return_sum ON c.id = return_sum.customer_id
        LEFT JOIN 
            tbl_users u ON u.id = c.user_id
        WHERE
            c.company_id = ? AND c.del_status = 'Live'
        GROUP BY 
            c.id
        HAVING 
            opening_balance > 0
        ORDER BY 
            c.id DESC";
        $result = $this->db->query($query, array($company_id))->result();
        return $result;
    }


    /**
     * getAllCreditCustomers
     * @access public
     * @param no
     * @return object
     * Added By Azhar
     */
    public function getAllCreditCustomers(){
        $company_id = $this->session->userdata('company_id');
        $query = "SELECT 
        c.id, c.name, c.phone, c.email, c.address, c.opening_balance, c.opening_balance_type,
        c.credit_limit, c.gst_number, c.customer_type, c.discount, c.price_type,
        c.same_or_diff_state, c.del_status, c.added_date, u.full_name AS added_by,
        CASE 
            WHEN c.opening_balance_type = 'Credit' THEN 
                - c.opening_balance + COALESCE(sale_sum.due_amount_sum, 0) - COALESCE(due_receive_sum.amount_sum, 0) - COALESCE(return_sum.total_return_amount_sum, 0)
            ELSE 
                c.opening_balance + COALESCE(sale_sum.due_amount_sum, 0) - COALESCE(due_receive_sum.amount_sum, 0) - COALESCE(return_sum.total_return_amount_sum, 0)
        END AS opening_balance
        FROM 
            tbl_customers c
        LEFT JOIN 
            (SELECT customer_id, COALESCE(SUM(due_amount), 0) AS due_amount_sum FROM tbl_sales WHERE del_status = 'Live' GROUP BY customer_id) AS sale_sum ON c.id = sale_sum.customer_id
        LEFT JOIN 
            (SELECT customer_id, COALESCE(SUM(amount), 0) AS amount_sum FROM tbl_customer_due_receives WHERE del_status = 'Live' GROUP BY customer_id) AS due_receive_sum ON c.id = due_receive_sum.customer_id
        LEFT JOIN 
            (SELECT customer_id, COALESCE(SUM(due), 0) AS total_return_amount_sum FROM tbl_sale_return WHERE del_status = 'Live' GROUP BY customer_id) AS return_sum ON c.id = return_sum.customer_id
        LEFT JOIN 
            tbl_users u ON u.id = c.user_id
        WHERE
            c.company_id = ? AND c.del_status = 'Live'
        GROUP BY 
            c.id
        HAVING 
            opening_balance < 0
        ORDER BY 
            c.id DESC";
        $result = $this->db->query($query, array($company_id))->result();
        return $result;
    }

    

    /**
     * getAllSuppliersWithOpeningBalance
     * @access public
     * @param no
     * @return object
     * Added By Azhar
     */
    public function getAllSuppliersWithOpeningBalance(){
        $company_id = $this->session->userdata('company_id');
        $query = "SELECT 
        s.id, s.name, s.contact_person, s.phone, s.opening_balance, s.opening_balance_type,
        s.del_status, s.added_date, u.full_name AS added_by,
        CASE 
            WHEN s.opening_balance_type = 'Credit' THEN 
                (COALESCE(purchase_sum.due_amount_sum, 0) - COALESCE(supplier_payment_sum.amount_sum, 0)) + s.opening_balance - COALESCE(purchase_return_sum.total_return_amount_sum, 0)
            ELSE 
                (COALESCE(purchase_sum.due_amount_sum, 0) - COALESCE(supplier_payment_sum.amount_sum, 0)) - s.opening_balance - COALESCE(purchase_return_sum.total_return_amount_sum, 0)
        END AS opening_balance
        FROM 
            tbl_suppliers s
        LEFT JOIN 
            (SELECT supplier_id, COALESCE(SUM(due_amount), 0) AS due_amount_sum FROM tbl_purchase WHERE del_status = 'Live' GROUP BY supplier_id) AS purchase_sum ON s.id = purchase_sum.supplier_id
        LEFT JOIN 
            (SELECT supplier_id, COALESCE(SUM(amount), 0) AS amount_sum FROM tbl_supplier_payments WHERE del_status = 'Live' GROUP BY supplier_id) AS supplier_payment_sum ON s.id = supplier_payment_sum.supplier_id
        LEFT JOIN 
            (SELECT supplier_id, COALESCE(SUM(total_return_amount), 0) AS total_return_amount_sum FROM tbl_purchase_return WHERE return_status != 'draft' AND del_status = 'Live' GROUP BY supplier_id) AS purchase_return_sum ON s.id = purchase_return_sum.supplier_id
        LEFT JOIN 
            tbl_users u ON u.id = s.user_id
        WHERE
            s.company_id = ? AND s.del_status = 'Live' ORDER BY s.id DESC";
        $result = $this->db->query($query, array($company_id))->result();
        return $result;  
    }

    /**
     * getAllDebitSuppliers
     * @access public
     * @param no
     * @return object
     * Added By Azhar
     */
    public function getAllDebitSuppliers(){
        $company_id = $this->session->userdata('company_id');
        $query = "SELECT 
        s.id, s.name, s.contact_person, s.phone, s.opening_balance, s.opening_balance_type,
        s.del_status, s.added_date, u.full_name AS added_by,
        CASE 
            WHEN s.opening_balance_type = 'Credit' THEN 
                (COALESCE(purchase_sum.due_amount_sum, 0) - COALESCE(supplier_payment_sum.amount_sum, 0)) + s.opening_balance - COALESCE(purchase_return_sum.total_return_amount_sum, 0)
            ELSE 
                (COALESCE(purchase_sum.due_amount_sum, 0) - COALESCE(supplier_payment_sum.amount_sum, 0)) - s.opening_balance - COALESCE(purchase_return_sum.total_return_amount_sum, 0)
        END AS opening_balance
        FROM 
            tbl_suppliers s
        LEFT JOIN 
            (SELECT supplier_id, COALESCE(SUM(due_amount), 0) AS due_amount_sum FROM tbl_purchase WHERE del_status = 'Live' GROUP BY supplier_id) AS purchase_sum ON s.id = purchase_sum.supplier_id
        LEFT JOIN 
            (SELECT supplier_id, COALESCE(SUM(amount), 0) AS amount_sum FROM tbl_supplier_payments WHERE del_status = 'Live' GROUP BY supplier_id) AS supplier_payment_sum ON s.id = supplier_payment_sum.supplier_id
        LEFT JOIN 
            (SELECT supplier_id, COALESCE(SUM(total_return_amount), 0) AS total_return_amount_sum FROM tbl_purchase_return WHERE return_status != 'draft' AND del_status = 'Live' GROUP BY supplier_id) AS purchase_return_sum ON s.id = purchase_return_sum.supplier_id
        LEFT JOIN 
            tbl_users u ON u.id = s.user_id
        WHERE
            s.company_id = ? AND s.del_status = 'Live'
        GROUP BY 
            s.id
        HAVING 
            opening_balance < 0
        ORDER BY 
            s.id DESC";
        
        $result = $this->db->query($query, array($company_id))->result();
        return $result;
    }


    /**
     * getAllCreditSuppliers
     * @access public
     * @param no
     * @return object
     * Added By Azhar
     */
    public function getAllCreditSuppliers(){
        $company_id = $this->session->userdata('company_id');
        $query = "SELECT 
        s.id, s.name, s.contact_person, s.phone, s.opening_balance, s.opening_balance_type,
        s.del_status, s.added_date, u.full_name AS added_by,
        CASE 
            WHEN s.opening_balance_type = 'Credit' THEN 
                (COALESCE(purchase_sum.due_amount_sum, 0) - COALESCE(supplier_payment_sum.amount_sum, 0)) + s.opening_balance - COALESCE(purchase_return_sum.total_return_amount_sum, 0)
            ELSE 
                (COALESCE(purchase_sum.due_amount_sum, 0) - COALESCE(supplier_payment_sum.amount_sum, 0)) - s.opening_balance - COALESCE(purchase_return_sum.total_return_amount_sum, 0)
        END AS opening_balance
        FROM 
            tbl_suppliers s
        LEFT JOIN 
            (SELECT supplier_id, COALESCE(SUM(due_amount), 0) AS due_amount_sum FROM tbl_purchase WHERE del_status = 'Live' GROUP BY supplier_id) AS purchase_sum ON s.id = purchase_sum.supplier_id
        LEFT JOIN 
            (SELECT supplier_id, COALESCE(SUM(amount), 0) AS amount_sum FROM tbl_supplier_payments WHERE del_status = 'Live' GROUP BY supplier_id) AS supplier_payment_sum ON s.id = supplier_payment_sum.supplier_id
        LEFT JOIN 
            (SELECT supplier_id, COALESCE(SUM(total_return_amount), 0) AS total_return_amount_sum FROM tbl_purchase_return WHERE return_status != 'draft' AND del_status = 'Live' GROUP BY supplier_id) AS purchase_return_sum ON s.id = purchase_return_sum.supplier_id
        LEFT JOIN 
            tbl_users u ON u.id = s.user_id
        WHERE
            s.company_id = ? AND s.del_status = 'Live'
        GROUP BY 
            s.id
        HAVING 
            opening_balance > 0
        ORDER BY 
            s.id DESC";
        $result = $this->db->query($query, array($company_id))->result();
        return $result;
    }



    /**
     * getAllByCompanyIdWithAddedBy
     * @access public
     * @param int
     * @param string
     * @return object
     * Added By Azhar
     */
    public function getAllByCompanyIdWithAddedBy($company_id, $table_name) {
        $this->db->select("$table_name.*, tbl_users.full_name as added_by");
        $this->db->from($table_name);
        $this->db->join("tbl_users", "tbl_users.id = $table_name.user_id", 'left');
        $this->db->where("$table_name.company_id", $company_id);
        $this->db->where("$table_name.del_status", 'Live');
        $this->db->order_by("$table_name.id", 'DESC');
        $result = $this->db->get(); 
        if($result != false){  
            return $result->result();
        }else{
            return false;
        }
    }
    /**
     * getAllCounterListByOutletId
     * @access public
     * @param int
     * @param string
     * @return object
     * Added By Azhar
     */
    public function getAllCounterListByOutletId($outlet_id, $company_id) {
        $this->db->select("*");
        $this->db->from('tbl_counters');
        $this->db->where("outlet_id", $outlet_id);
        $this->db->where("company_id", $company_id);
        $this->db->where("del_status", 'Live');
        $this->db->order_by("id", 'DESC');
        $result = $this->db->get(); 
        if($result != false){  
            return $result->result();
        }else{
            return false;
        }
    }

    /**
     * getAllCounters
     * @access public
     * @param int
     * @param string
     * @return object
     * Added By Azhar
     */
    public function getAllCounters($company_id) {
        $this->db->select("c.id, c.name as counter_name, c.description, c.added_date, o.outlet_name, p.title as printer, u.full_name as added_by");
        $this->db->from('tbl_counters c');
        $this->db->join("tbl_outlets o", "o.id = c.outlet_id", 'left');
        $this->db->join("tbl_printers p", "p.id = c.printer_id", 'left');
        $this->db->join("tbl_users u", "u.id = c.user_id", 'left');
        $this->db->where("c.company_id", $company_id);
        $this->db->where("c.del_status", 'Live');
        $this->db->order_by("c.id", 'DESC');
        $result = $this->db->get(); 
        if($result != false){  
            return $result->result();
        }else{
            return false;
        }
    }


    /**
     * getAllByCompanyIdWithAddedBy
     * @access public
     * @param int
     * @return object
     * Added By Azhar
     */
    public function getRegisterStatus($user_id) {
        $this->db->select("register_status");
        $this->db->from("tbl_register");
        $this->db->where("user_id", $user_id);
        $this->db->where("del_status", 'Live');
        $this->db->order_by("id", 'DESC');
        $this->db->limit(1);
        $result = $this->db->get()->row(); 
        if($result != false){  
            return $result->register_status;
        }else{
            return false;
        }
    }

    /**
     * getCounterIdFromRegister
     * @access public
     * @param int
     * @return object
     * Added By Azhar
     */
    public function getCounterIdFromRegister($user_id) {
        $this->db->select("counter_id");
        $this->db->from("tbl_register");
        $this->db->where("user_id", $user_id);
        $this->db->where("del_status", 'Live');
        $this->db->order_by("id", 'DESC');
        $this->db->limit(1);
        $result = $this->db->get()->row(); 
        if($result != false){  
            return $result->counter_id;
        } else {
            return false;
        }
    }

    /**
     * bulkItemDeleteWithVariationAndOpeningStock
     * @access public
     * @param int
     * @return void
     * Added By Azhar
     */
    public function bulkItemDeleteWithVariationAndOpeningStock($id){
        $this->db->set('del_status', "Deleted");
        $this->db->where('id', $id);
        $this->db->or_where('parent_id', $id);
        $this->db->update('tbl_items');
        $master_id = $this->db->query("SELECT id FROM tbl_items WHERE parent_id = $id")->result();
        if($master_id){
            foreach($master_id as $m){
                $this->bulkItemOpeningStockDelete($m->id);
            }
        }else{
            $this->bulkItemOpeningStockDelete($id);
        }
        $this->Common_model->comboItemDeleteStatusChange($id);
    }

    /**
     * bulkItemOpeningStockDelete
     * @access public
     * @param int
     * @return void
     * Added By Azhar
     */
    public function bulkItemOpeningStockDelete($id){
        $this->db->set('del_status', "Deleted");
        $this->db->where('item_id', $id);
        $this->db->update('tbl_set_opening_stocks');
    }

   
    /**
     * openingStockCheck
     * @access public
     * @param int
     * @param int
     * @return object
     * Added By Azhar
     */
    public function openingStockCheck($item_id, $outlet_id) {
        $this->db->select("stock_quantity");
        $this->db->from("tbl_set_opening_stocks");
        $this->db->where("item_id", $item_id);
        $this->db->where("outlet_id", $outlet_id);
        $this->db->where("del_status", 'Live');
        $result = $this->db->get()->row();
        return $result;
    } 

    /**
     * openingStockCheck
     * @access public
     * @param int
     * @return object
     * Added By Azhar
     */
    public function getAllCashier($company_id) {
		$this->db->select('*');
		$this->db->from('tbl_users');
		$this->db->where('company_id', $company_id);
		$this->db->where('id!=', '1');
		$this->db->where('del_status', 'Live');
		$result = $this->db->get(); 
        if($result != false){  
            return $result->result();
        }else{
            return false;
        }
    }


    /**
     * getAllPrinter
     * @access public
     * @param int
     * @return object
     * Added By Azhar
     */
    public function getAllPrinter($company_id) {
		$this->db->select('*');
		$this->db->from('tbl_printers');
		$this->db->where('company_id', $company_id);
		$this->db->where('del_status', 'Live');
		$result = $this->db->get(); 
        if($result != false){  
            return $result->result();
        }else{
            return false;
        }
    }

    /**
     * getDataByColumnValue
     * @access public
     * @param string
     * @param string
     * @param string
     * @return object
     * Added By Azhar
     */
    public function getDataByColumnValue($field_name, $field_value, $table_name) {
        $company_id = $this->session->userdata('company_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $this->db->select('*');
        $this->db->from($table_name);
        $this->db->where($field_name, $field_value);
        $this->db->where('company_id', $company_id);
        $this->db->where('outlet_id', $outlet_id);
        $this->db->where('del_status', 'Live');
        $this->db->order_by('id', 'DESC');
        $result = $this->db->get(); 
        if($result != false){  
            return $result->result();
        }else{
            return false;
        }
    }


    /**
     * getAll
     * @access public
     * @param int
     * @param string
     * @return object
     * Added By Azhar
     */
    
    public function getAll($company_id, $table_name) {
        $result = $this->db->query("SELECT i.*,
                (SELECT SUM(sp.amount) 
                    FROM tbl_sale_payments sp 
                    INNER JOIN tbl_sales s ON s.id = sp.sale_id 
                    WHERE sp.payment_id = i.id 
                    AND sp.del_status = 'Live' 
                    AND s.delivery_status = 'Cash Received') AS total_sale, 
    
                (SELECT SUM(amount) 
                    FROM tbl_purchase_payments 
                    WHERE payment_id = i.id 
                    AND tbl_purchase_payments.del_status = 'Live') AS total_purchase,            
                
                (SELECT SUM(down_payment) 
                    FROM tbl_installments 
                    WHERE payment_method_id = i.id 
                    AND tbl_installments.del_status = 'Live') AS total_down_payment,
    
                (SELECT SUM(paid_amount) 
                    FROM tbl_installment_items 
                    WHERE payment_method_id = i.id 
                    AND tbl_installment_items.del_status = 'Live') AS total_installment_collection,       
                    
                (SELECT SUM(amount) 
                    FROM tbl_customer_due_receives 
                    WHERE payment_method_id = i.id 
                    AND tbl_customer_due_receives.del_status = 'Live') AS total_customer_due_receive,
    
                (SELECT SUM(amount) 
                    FROM tbl_supplier_payments 
                    WHERE payment_method_id = i.id 
                    AND tbl_supplier_payments.del_status = 'Live') AS total_supplier_due_payment,
    
                (SELECT SUM(total_return_amount) 
                    FROM tbl_sale_return 
                    WHERE payment_method_id = i.id 
                    AND tbl_sale_return.del_status = 'Live') AS total_sale_return,
    
                (SELECT SUM(total_return_amount) 
                    FROM tbl_purchase_return 
                    WHERE payment_method_id = i.id 
                    AND tbl_purchase_return.del_status = 'Live') AS total_purchase_return_amount,
    
                (SELECT SUM(amount) 
                    FROM tbl_expenses 
                    WHERE payment_method_id = i.id 
                    AND tbl_expenses.del_status = 'Live') AS total_expense,

                (SELECT SUM(amount) 
                    FROM tbl_incomes 
                    WHERE payment_method_id = i.id 
                    AND tbl_incomes.del_status = 'Live') AS total_income,
    
                (SELECT SUM(total_amount) 
                    FROM tbl_salaries 
                    WHERE payment_id = i.id 
                    AND tbl_salaries.del_status = 'Live') AS total_salary_amount,
                
                (SELECT SUM(amount) 
                    FROM tbl_deposits 
                    WHERE payment_method_id = i.id 
                    AND tbl_deposits.type = 'Deposit' 
                    AND tbl_deposits.del_status = 'Live') AS total_deposit,
                    
                (SELECT SUM(amount) 
                    FROM tbl_deposits 
                    WHERE payment_method_id = i.id 
                    AND tbl_deposits.type = 'Withdraw' 
                    AND tbl_deposits.del_status = 'Live') AS total_withdraw
    
            FROM tbl_payment_methods i 
            WHERE i.del_status = 'Live' 
            AND i.company_id = '$company_id' 
            ORDER BY i.id DESC
        ")->result();
    
        return $result;
    }
    
    /**
     * getCustomerByType
     * @access public
     * @param int
     * @param string
     * @param string
     * @return object
     * Added By Azhar
     */
    public function getCustomerByType($company_id, $table_name,$type) {
        $this->db->select("$table_name.*, tbl_users.full_name as added_by");
        $this->db->from($table_name);
        $this->db->join("tbl_users", "tbl_users.id = $table_name.user_id");
        $this->db->where("$table_name.company_id", $company_id);
        $this->db->where("$table_name.customer_type", $type);
        $this->db->where("$table_name.del_status", 'Live');
        $this->db->order_by("$table_name.id", 'DESC');
        $result = $this->db->get();
        if($result != false){
            return $result->result();
        }else{
            return false;
        }
    }

    /**
     * getItemsForInstallmentSale
     * @access public
     * @param no
     * @return object
     * Added By Azhar
     */
    public function getItemsForInstallmentSale() {
        $company_id = $this->session->userdata('company_id');
        $this->db->select('i.id,i.name,i.code,i.type,i.sale_price, b.name as brand_name');
        $this->db->from('tbl_items i');
        $this->db->join('tbl_brands b', 'b.id = i.brand_id', 'left');
        $this->db->where("i.company_id", $company_id);
        $this->db->where("i.type", 'Installment_Product');
        $this->db->where("i.enable_disable_status", 'Enable');
        $this->db->where("i.del_status", 'Live');
        $this->db->or_where("i.type", 'IMEI_Product');
        $this->db->or_where("i.type", 'Serial_Product');
        $result = $this->db->get();
        if($result != false){
            return $result->result();
        }else{
            return false;
        }
    }


    /**
     * getCustomerById
     * @access public
     * @param int
     * @return object
     * Added By Azhar
     */
    public function getCustomerById($customer_id) {
        $this->db->select('*');
        $this->db->from('tbl_customers');
        $this->db->where("id", $customer_id);
        $this->db->where("del_status", 'Live');
        $result = $this->db->get();
        if($result != false){
            return $result->row();
        }else{
            return false;
        }
    }


    /**
     * getDenomination
     * @access public
     * @param int
     * @return object
     * Added By Azhar
     */
    public function getDenomination($company_id) {
        $this->db->select("*");
        $this->db->from("tbl_denominations");
        $this->db->where("del_status", 'Live');
        $this->db->where("company_id", $company_id);
        $this->db->order_by("amount", 'asc');
        return $this->db->get()->result();
    }


    /**
     * getByCompanyId
     * @access public
     * @param int
     * @param string
     * @return object
     * Added By Azhar
     */
    public function getByCompanyId($company_id, $table_name) {
        $result = $this->db->query("SELECT * 
          FROM $table_name 
          WHERE id=$company_id AND del_status = 'Live'  
          ORDER BY id DESC")->row();
        return $result;
    }


    /**
     * getAllByCompanyIdForDropdown
     * @access public
     * @param int
     * @param string
     * @return object
     * Added By Azhar
     */
    public function getAllByCompanyIdForDropdown($company_id, $table_name) {
		$this->db->select('*');
		$this->db->from($table_name);
		$this->db->where('company_id', $company_id);
		$this->db->where('del_status', 'Live');
		$this->db->order_by('id', 'DESC');
		$result = $this->db->get(); 
        if($result != false){
            return $result->result();
        }else{
            return false;
        }
    }


    /**
     * getAllByCustomerByCompanyIdASC
     * @access public
     * @param int
     * @return object
     * Added By Azhar
     */
    public function getAllByCustomerByCompanyIdASC($company_id) {
		$this->db->select('id, name, phone');
		$this->db->from('tbl_customers');
		$this->db->where('company_id', $company_id);
		$this->db->where('del_status', 'Live');
		$this->db->order_by('id', 'ASC');
		$result = $this->db->get(); 
        if($result != false){
            return $result->result();
        }else{
            return false;
        }
    }

    /**
     * getAllByCustomerASC
     * @access public
     * @param no
     * @return object
     * Added By Azhar
     */
    public function getAllByCustomerASC() {
        $company_id = $this->session->userdata('company_id');
		$this->db->select('id, name, phone');
		$this->db->from('tbl_customers');
		$this->db->where('company_id', $company_id);
		$this->db->where('del_status', 'Live');
		$this->db->order_by('name', 'ASC');
		$result = $this->db->get(); 
        if($result != false){
            return $result->result();
        }else{
            return false;
        }
    }

    /**
     * getAllDropdownItemByCompanyId
     * @access public
     * @param int
     * @param string
     * @return object
     * Added By Azhar
     */
    public function getAllDropdownItemByCompanyId($company_id, $table_name) {
		$this->db->select('id,name,code,parent_id');
		$this->db->from($table_name);
		$this->db->where('p_type !=', 'Variation_Product');
		$this->db->where('type !=', 'Service_Product');
		$this->db->where('enable_disable_status', 'Enable');
		$this->db->where('del_status', 'Live');
		$this->db->where('company_id', $company_id);
		$this->db->order_by('id', 'ASC');
		$result = $this->db->get(); 
        if($result != false){
            return $result->result();
        }else{
            return false;
        }
    }


    /**
     * getAllForDropdown
     * @access public
     * @param string
     * @return object
     * Added By Azhar
     */
    public function getAllForDropdown($table_name) {
        $result = $this->db->query("SELECT * 
              FROM $table_name 
              WHERE del_status = 'Live'  
              ORDER BY 2")->result();
        return $result;
    }


    /**
     * getAllByOutletId
     * @access public
     * @param int
     * @param string
     * @return object
     * Added By Azhar
     */
    public function getAllByOutletId($outlet_id, $table_name) {
        $company_id = $this->session->userdata('company_id');
        $this->db->select("$table_name.*, tbl_users.full_name as added_by");
		$this->db->from($table_name);
		$this->db->join("tbl_users", "tbl_users.id = $table_name.user_id", "left");
		$this->db->where("$table_name.outlet_id", $outlet_id);
		$this->db->where("$table_name.company_id", $company_id);
		$this->db->where("$table_name.del_status", 'Live');
		$this->db->order_by("$table_name.id", 'DESC');
		$result = $this->db->get(); 
        if($result != false){  
            return $result->result();
        }else{
            return false;
        }
    }

    /**
     * getAllWarrantyList
     * @access public
     * @param int
     * @param string
     * @return object
     * Added By Azhar
     */
    public function getAllWarrantyList() {
        $company_id = $this->session->userdata('company_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $this->db->select("w.*, u.full_name as added_by, c.name as customer_name, c.phone as customer_phone");
		$this->db->from('tbl_warranties w');
		$this->db->join("tbl_users u", "u.id = w.user_id", "left");
		$this->db->join("tbl_customers c", "c.id = w.customer_id", "left");
		$this->db->where("w.outlet_id", $outlet_id);
		$this->db->where("w.company_id", $company_id);
		$this->db->where("w.del_status", 'Live');
		$this->db->order_by("w.id", 'DESC');
		$result = $this->db->get(); 
        if($result != false){  
            return $result->result();
        }else{
            return false;
        }
    }

    /**
     * warrantyAvailableStock
     * @access public
     * @param string
     * @return object
     * Added By Azhar
     */
    public function warrantyAvailableStock($table_name) {
        $outlet_id = $this->session->userdata('outlet_id');
        $company_id = $this->session->userdata('company_id');
		$this->db->select('*');
		$this->db->from($table_name);
		$this->db->where('current_status', 'R_F_C');
		$this->db->where('outlet_id', $outlet_id);
		$this->db->where('company_id', $company_id);
		$this->db->where('del_status', 'Live');
		$this->db->or_where('current_status', 'R_T_V');
		$this->db->order_by('id', 'DESC');
		$result = $this->db->get(); 
        if($result != false){
            return $result->result();
        }else{
            return false;
        }
    }

    /**
     * warrantyAllStock
     * @access public
     * @param string
     * @return object
     * Added By Azhar
     */
    public function warrantyAllStockByStatus($R_F_C, $S_T_V, $R_T_V, $outlet_id) {
        $company_id = $this->session->userdata('company_id');
		$this->db->select('*');
		$this->db->from("tbl_warranties");
        if($R_F_C){
            $this->db->where('current_status', 'R_F_C');
        }
        if($outlet_id){
            $this->db->where('outlet_id', $outlet_id);
        }
		$this->db->where('company_id', $company_id);
		$this->db->where('del_status', 'Live');
        if($S_T_V){
            $this->db->or_where('current_status', 'S_T_V');
        }
        if($R_T_V){
            $this->db->or_where('current_status', 'R_T_V');
        }
		$this->db->order_by('id', 'DESC');
		$result = $this->db->get(); 
        if($result != false){
            return $result->result();
        }else{
            return false;
        }
    }
    /**
     * warrantyAllStock
     * @access public
     * @param string
     * @return object
     * Added By Azhar
     */
    public function warrantyAllStock($table_name) {
        $outlet_id = $this->session->userdata('outlet_id');
        $company_id = $this->session->userdata('company_id');
		$this->db->select('*');
		$this->db->from($table_name);
		$this->db->where('current_status', 'R_F_C');
		$this->db->where('outlet_id', $outlet_id);
		$this->db->where('company_id', $company_id);
		$this->db->where('del_status', 'Live');
		$this->db->or_where('current_status', 'S_T_V');
		$this->db->or_where('current_status', 'R_T_V');
		$this->db->order_by('id', 'DESC');
		$result = $this->db->get(); 
        if($result != false){
            return $result->result();
        }else{
            return false;
        }
    }

    /**
     * getAllOutletsASC
     * @access public
     * @param no
     * @return object
     * Added By Azhar
     */
    public function getAllOutletsASC() {
        $company_id = $this->session->userdata('company_id');
        $this->db->select('*');
		$this->db->from('tbl_outlets');
		$this->db->where('company_id', $company_id);
		$this->db->where('active_status', 'active');
		$this->db->where('del_status', 'Live');
		$this->db->order_by('outlet_name', 'ASC');
        $result = $this->db->get(); 
        if($result != false){
            return $result->result();
        }else{
            return false;
        }
    }


    /**
     * getAllItemsWithVariation
     * @access public
     * @param no
     * @return object
     * Added By Azhar
     */
    public function getAllItemsWithVariation() {
        $company_id = $this->session->userdata('company_id');
		$this->db->select('*');
		$this->db->from('tbl_items');
		$this->db->where('type !=', 'Variaton_Product');
		$this->db->where('company_id', $company_id);
		$this->db->where('enable_disable_status', 'Enable');
		$this->db->where('del_status', 'Live');
		$this->db->order_by('name', 'ASC');
	    return $this->db->get()->result(); 
        
    }

    /**
     * imeiSerialCheck
     * @access public
     * @param string
     * @param string
     * @return object
     * Added By Azhar
     */
    public function imeiSerialCheck($type,$imeiSerial){
        $company_id = $this->session->userdata('company_id');
		$this->db->select('item_description');
		$this->db->from('tbl_set_opening_stocks');
		$this->db->where('item_type', $type);
		$this->db->where('item_description', $imeiSerial);
		$this->db->where('company_id', $company_id);
		$this->db->where('del_status', 'Live');
	    $result = $this->db->get()->row(); 
        if($result){
            return $result->item_description;
        }else{
            return false;
        }
    }

    /**
     * kepOldVariation
     * @access public
     * @param int
     * @return object
     * Added By Azhar
     */
    public function kepOldVariation($item_id){
        $company_id = $this->session->userdata('company_id');
		$this->db->select('os.stock_quantity, i.conversion_rate,os.outlet_id,os.item_id, os.item_description');
		$this->db->from('tbl_set_opening_stocks os');
		$this->db->join('tbl_items i', 'i.id = os.item_id', 'left');
		$this->db->where('os.item_id', $item_id);
		$this->db->where('os.company_id', $company_id);
		$this->db->where('os.del_status', 'Live');
	    $result = $this->db->get()->result(); 
        if($result){
            return $result;
        }else{
            return false;
        }
    }

    /**
     * stockQtyCheck
     * @access public
     * @param int
     * @param int
     * @return object
     * Added By Azhar
     */
    public function stockQtyCheck($item_id, $outlet_id){
        $company_id = $this->session->userdata('company_id');
		$this->db->select('SUM(os.stock_quantity) as stock_quantity, i.conversion_rate');
		$this->db->from('tbl_set_opening_stocks os');
		$this->db->join('tbl_items i', 'i.id = os.item_id', 'left');
		$this->db->where('os.item_id', $item_id);
		$this->db->where('os.outlet_id', $outlet_id);
		$this->db->where('os.del_status', 'Live');
	    $result = $this->db->get()->row(); 
        if($result){
            return $result;
        }else{
            return false;
        }
    }

    /**
     * imeiSerialStockCheck
     * @access public
     * @param int
     * @param int
     * @return object
     * Added By Azhar
     */
    public function imeiSerialStockCheck($item_id, $outlet_id){
        $company_id = $this->session->userdata('company_id');
		$this->db->select('os.item_id,os.item_type,os.item_description,os.stock_quantity,os.outlet_id, i.conversion_rate');
		$this->db->from('tbl_set_opening_stocks os');
		$this->db->join('tbl_items i', 'i.id = os.item_id', 'left');
		$this->db->where('os.item_id', $item_id);
		$this->db->where('os.outlet_id', $outlet_id);
		$this->db->where('os.del_status', 'Live');
		$this->db->order_by('os.id', 'desc');
	    $result = $this->db->get()->result();
        if($result){
            return $result;
        }else{
            return false;
        }
    }

    /**
     * deleteStatusChange
     * @access public
     * @param int
     * @param string
     * @return object
     * Added By Azhar
     */
    public function deleteStatusChange($id, $table_name) {
        $this->db->set('del_status', "Deleted");
        $this->db->where('id', $id);
        $this->db->update($table_name);
    }

    /**
     * enableDisableStatusChange
     * @access public
     * @param int
     * @param string
     * @return object
     * Added By Azhar
     */
    public function enableDisableStatusChange($id, $status) {
        $this->db->set('enable_disable_status', $status);
        $this->db->where('id', $id);
        $this->db->update('tbl_items');
    }

    /**
     * deleteStatusChangeByFieldName
     * @access public
     * @param int
     * @param string
     * @param string
     * @return object
     * Added By Azhar
     */
    public function deleteStatusChangeByFieldName($id, $field_name, $table_name) {
        $this->db->set('del_status', "Deleted");
        $this->db->where($field_name, $id);
        $this->db->update($table_name);
    }


    /**
     * childItemDeleteStatusChange
     * @access public
     * @param int
     * @param string
     * @return object
     * Added By Azhar
     */
    public function childItemDeleteStatusChange($id, $table_name) {
        $this->db->set('del_status', "Deleted");
        $this->db->where('parent_id', $id);
        $this->db->update($table_name);
    }
    /**
     * childItemEnableDisableStatusChange
     * @access public
     * @param int
     * @param string
     * @return object
     * Added By Azhar
     */
    public function childItemEnableDisableStatusChange($id, $status) {
        $this->db->set('enable_disable_status', $status);
        $this->db->where('parent_id', $id);
        $this->db->update('tbl_items');
    }

    /**
     * comboItemDeleteStatusChange
     * @access public
     * @param int
     * @param string
     * @return object
     * Added By Azhar
     */
    public function comboItemDeleteStatusChange($id) {
        $this->db->set('del_status', "Deleted");
        $this->db->where('combo_id', $id);
        $this->db->update('tbl_combo_items');
    }

    /**
     * openingStockItemDeleteStatusChange
     * @access public
     * @param int
     * @return object
     * Added By Azhar
     */
    public function openingStockItemDeleteStatusChange($id) {
        $this->db->set('del_status', "Deleted");
        $this->db->where('item_id', $id);
        $this->db->update('tbl_set_opening_stocks');
    }

    /**
     * statusChange
     * @access public
     * @param int
     * @param string
     * @param string
     * @param string
     * @return object
     * Added By Azhar
     */
    public function statusChange($id, $field_name, $val, $table_name) {
        $this->db->set($field_name, $val);
        $this->db->where('id', $id);
        $this->db->update($table_name);
    }

    /**
     * deleteCustomRow
     * @access public
     * @param int
     * @param string
     * @param string
     * @return object
     * Added By Azhar
     */
    public function deleteCustomRow($id,$colm,$tbl) {
        $this->db->set('del_status', "Deleted");
        $this->db->where($colm, $id);
        $this->db->update($tbl);
    }

    /**
     * deleteStatusChangeWithChild
     * @access public
     * @param int
     * @param int
     * @param string
     * @param string
     * @param string
     * @param string
     * @return object
     * Added By Azhar
     */
    public function deleteStatusChangeWithChild($id, $id1, $table_name, $table_name2, $field_name, $field_name1) {
        $this->db->set('del_status', "Deleted");
        $this->db->where($field_name, $id);
        $this->db->update($table_name);
        $this->db->set('del_status', "Deleted");
        $this->db->where($field_name1, $id1);
        $this->db->update($table_name2);
    }

    /**
     * insertInformation
     * @access public
     * @param string
     * @param string
     * @return object
     * Added By Azhar
     */
    public function insertInformation($data, $table_name) {
        $this->db->insert($table_name, $data);
        return $this->db->insert_id();
    }

    /**
     * getDataById
     * @access public
     * @param int
     * @param string
     * @return object
     * Added By Azhar
     */
    public function getDataById($id, $table_name) {
        $this->db->select("*");
        $this->db->from($table_name);
        $this->db->where("id", $id);
        $this->db->where("del_status", "Live");
        return $this->db->get()->row();
    }
    /**
     * getDataById
     * @access public
     * @param int
     * @param string
     * @return object
     * Added By Azhar
     */
    public function getSingleBookingData($id) {
        $this->db->select("b.*, o.outlet_name, c.name as customer_name, u.full_name as service_seller_name");
        $this->db->from('tbl_bookings b');
        $this->db->join('tbl_outlets o', 'o.id = b.outlet_id', 'left');
        $this->db->join('tbl_customers c', 'c.id = b.customer_id', 'left');
        $this->db->join('tbl_users u', 'u.id = b.service_seller_id', 'left');
        $this->db->where("b.id", $id);
        $this->db->where("b.del_status", "Live");
        return $this->db->get()->row();
    }
    /**
     * checkExistingAdmin
     * @access public
     * @return object
     * @param string
     */
    public function checkExistingAdmin($email) {
        $this->db->select("email_address");
        $this->db->from("tbl_users");
        $this->db->where("email_address", $email);
        $this->db->where("del_status", 'Live');
        return $this->db->get()->row();
    }
    /**
     * checkExistingAdmin
     * @access public
     * @return object
     * @param string
     */
    public function checkExistingAdminAll($email) {
        $this->db->select("email_address");
        $this->db->from("tbl_users");
        $this->db->where("email_address", $email);
        return $this->db->get()->row();
    }

    /**
     * getFindId
     * @access public
     * @param int
     * @param string
     * @return object
     * Added By Azhar
     */
    public function getFindId($id, $table_name) {
        $this->db->select("id");
        $this->db->from($table_name);
        $this->db->where("id", $id);
        $this->db->where("del_status", "Live");
        return $this->db->get()->row();
    }

    /**
     * getItemDetailsWithOpeningStockByItemId
     * @access public
     * @param int
     * @return object
     * Added By Azhar
     */
    public function getItemDetailsWithOpeningStockByItemId($id) {
        $outlet_id = $this->session->userdata('outlet_id');
        $this->db->select("i.*, SUM(os.stock_quantity) as opening_stock");
        $this->db->from("tbl_items i");
        $this->db->join("tbl_set_opening_stocks os", "os.item_id=i.id", 'left');
        $this->db->where("i.id", $id);
        $this->db->where("i.del_status", "Live");
        return $this->db->get()->row();
    }

    /**
     * getItemOpeningStock
     * @access public
     * @param int
     * @return object
     * Added By Azhar
     */
    public function getItemOpeningStock($id) {
        $this->db->select("os.stock_quantity, os.item_description, o.outlet_name");
        $this->db->from('tbl_set_opening_stocks os');
        $this->db->join("tbl_outlets o", 'o.id = os.outlet_id');
        $this->db->where("os.item_id", $id);
        $this->db->where("os.del_status", "Live");
        $this->db->order_by("os.id", "desc");
        return $this->db->get()->result();
    }

    /**
     * getItemDetailsDataById
     * @access public
     * @param int
     * @param string
     * @param string
     * @return object
     * Added By Azhar
     */
    public function getItemDetailsDataById($id, $field_name, $table_name) {
        $this->db->select("*");
        $this->db->from($table_name);
        $this->db->where($field_name, $id);
        $this->db->where("del_status", "Live");
        return $this->db->get()->result();
    }

    /**
     * getAllOutlets
     * @access public
     * @param int
     * @return object
     * Added By Azhar
     */
    public function getAllOutlets($id) {
        if($id){
            $company_id = $this->session->userdata('company_id');
            $this->db->select("*");
            $this->db->from('tbl_outlets');
            $this->db->where_in("id", $id);
            $this->db->where("company_id", $company_id);
            $this->db->where("del_status", "Live");
            return $this->db->get()->result();
        }else{
            return false;
        }
    }

    /**
     * getCurrentOutlet
     * @access public
     * @param no
     * @return object
     * Added By Azhar
     */
    public function getCurrentOutlet() {
        $id = $this->session->userdata('outlet_id');
        $this->db->select("*");
        $this->db->from('tbl_outlets');
        $this->db->where("id", $id);
        $this->db->where("del_status", "Live");
        return $this->db->get()->row();
    }

    /**
     * getAllOutletByCompany
     * @access public
     * @param no
     * @return object
     * Added By Azhar
     */
    public function getAllOutletByCompany() {
        $company_id = $this->session->userdata('company_id');
        $this->db->select("id,outlet_name");
        $this->db->from('tbl_outlets');
        $this->db->where("company_id", $company_id);
        $this->db->where("del_status", "Live");
        $this->db->order_by('outlet_name', 'ASC');
        return $this->db->get()->result();
    }
    /**
     * getAllServiceCenterByCompany
     * @access public
     * @param no
     * @return object
     * Added By Azhar
     */
    public function getAllServiceCenterByCompany() {
        $company_id = $this->session->userdata('company_id');
        $this->db->select("id,name,code");
        $this->db->from('tbl_service_centers');
        $this->db->where("company_id", $company_id);
        $this->db->where("del_status", "Live");
        $this->db->order_by('name', 'ASC');
        return $this->db->get()->result();
    }

    /**
     * getAllRoleByCompany
     * @access public
     * @param no
     * @return object
     * Added By Azhar
     */
    public function getAllRoleByCompany() {
        $company_id = $this->session->userdata('company_id');
        $this->db->select("id,role_name");
        $this->db->from('tbl_roles');
        $this->db->where("company_id", $company_id);
        $this->db->where("del_status", "Live");
        return $this->db->get()->result();
    }

    /**
     * getAssignedOutletDataById
     * @access public
     * @param int
     * @return object
     * Added By Azhar
     */
    public function getAssignedOutletDataById($id) {
        $this->db->select("outlet_id");
        $this->db->from('tbl_users');
        $this->db->where("id", $id);
        $this->db->where("del_status", "Live");
        return $this->db->get()->row();
    }

    /**
     * getPurchaseReturnDetailsByReturnId
     * @access public
     * @param int
     * @param string
     * @return object
     * Added By Azhar
     */
    public function getPurchaseReturnDetailsByReturnId($id, $table_name) {
        $this->db->select("*");
        $this->db->from($table_name);
        $this->db->where("pur_return_id", $id);
        $this->db->where("del_status", "Live");
        return $this->db->get()->result();
    }


    /**
     * getDataByField
     * @access public
     * @param int
     * @param string
     * @param string
     * @return object
     * Added By Azhar
     */
    public function getDataByField($id, $table_name, $filed_name) {
        $this->db->select("*");
        $this->db->from($table_name);
        $this->db->where($filed_name, $id);
        $this->db->where("del_status", "Live");
        return $this->db->get()->result();
    }

    /**
     * outletWithoutSessionOutlet
     * @access public
     * @param int
     * @return object
     * Added By Azhar
     */
    public function outletWithoutSessionOutlet($id) {
        $company_id = $this->session->userdata('company_id');
        $this->db->select("*");
        $this->db->from('tbl_outlets');
        $this->db->where("id !=", $id);
        $this->db->where("company_id", $company_id);
        $this->db->where("del_status", "Live");
        $this->db->order_by('outlet_name', 'ASC');
        return $this->db->get()->result();
    }

    /**
     * getVariationItem
     * @access public
     * @param int
     * @return object
     * Added By Azhar
     */
    public function getVariationItem($id) {
        $this->db->select("id,name,code,type,parent_id, sale_price, purchase_price");
        $this->db->from('tbl_items');
        $this->db->where("parent_id", $id);
        $this->db->where("del_status", "Live");
        return $this->db->get()->result();
    }

    /**
     * getItemNameById
     * @access public
     * @param int
     * @return object
     * Added By Azhar
     */
    public function getItemNameById($id) {
        $this->db->select("name");
        $this->db->from('tbl_items');
        $this->db->where("id", $id);
        $this->db->where("del_status", "Live");
        return $this->db->get()->row();
    }

    /**
     * getItemCategoriesBySorted
     * @access public
     * @param int
     * @return object
     * Added By Azhar
     */
    public function getItemCategoriesBySorted($company_id) {
        $result = $this->db->query("SELECT * 
          FROM tbl_item_categories 
          WHERE company_id=$company_id AND del_status = 'Live'  
          ORDER BY sort_id")->result();
        return $result;
    }
    /**
     * getPaymentMethodBySortedId
     * @access public
     * @param int
     * @return object
     * Added By Azhar
     */
    public function getPaymentMethodBySortedId($company_id) {
        $result = $this->db->query("SELECT * 
          FROM tbl_payment_methods 
          WHERE company_id=$company_id AND del_status = 'Live'  
          ORDER BY sort_id")->result();
        return $result;
    }
    
    /**
     * updateInformation
     * @access public
     * @param array
     * @param int
     * @param string
     * @return void
     * Added By Azhar
     */
    public function updateInformation($data, $id, $table_name) {
        $this->db->where('id', $id);
        $this->db->update($table_name, $data);
    }

    /**
     * updateInformationByCompanyId
     * @access public
     * @param array
     * @param int
     * @param string
     * @return void
     * Added By Azhar
     */
    public function updateInformationByCompanyId($data, $company_id, $table_name) {
        $this->db->where('company_id', $company_id);
        $this->db->update($table_name, $data);
    }

    /**
     * updateInformationByColumn
     * @access public
     * @param array
     * @param int
     * @param string
     * @param string
     * @return void
     * Added By Azhar
     */
    public function updateInformationByColumn($data, $id, $field, $table_name) {
        $this->db->where($field, $id);
        $this->db->update($table_name, $data);
    }

    /**
     * deletingMultipleFormData
     * @access public
     * @param string
     * @param int
     * @param string
     * @return void
     * Added By Azhar
     */
    public function deletingMultipleFormData($field_name, $primary_table_id, $table_name) {
        $this->db->delete($table_name, array($field_name => $primary_table_id));
    }

    /**
     * updatingMultipleFormData
     * @access public
     * @param string
     * @param int
     * @param string
     * @return void
     * Added By Azhar
     */
    public function updatingMultipleFormData($field_name, $primary_table_id, $table_name) {
        $this->db->set('del_status', "Deleted");
        $this->db->update($table_name, array($field_name => $primary_table_id));
    }

    /**
     * getAllCustomers
     * @access public
     * @param no
     * @return object
     * Added By Azhar
     */
    public function getAllCustomers() {
        return $this->db->get("tbl_customers")->result();
    }

    /**
     * getSalaryUsers
     * @access public
     * @param no
     * @return object
     * Added By Azhar
     */
    public function getSalaryUsers(){
        $company_id = $this->session->userdata('company_id');
        $this->db->select('*');
        $this->db->from("tbl_users");
        $this->db->where("id!=", "1");
        $this->db->where("salary >", 0);
        $this->db->where("company_id", $company_id);
        $this->db->where("del_status", 'Live');
        return $this->db->get()->result();
    }
    /**
     * change_status_notification
     * @access public
     * @param int
     * @return json
     * Added By Azhar
     */
    public function change_status_notification($id) {
        $this->db->set('visible_status', '0');
        $this->db->where('id', $id);
        $this->db->update('tbl_notifications');
        $notifications_read_count = $this->db->where('del_status','Live')->where('outlet_id',$this->session->userdata('outlet_id'))->where('visible_status','1')->get('tbl_notifications')->result();
        $total = sizeof($notifications_read_count);
        $data['total_unread'] = $total;
        echo json_encode($data);
    }

    /**
     * findCustomerCreditLimit
     * @access public
     * @param int
     * @return object
     * Added By Azhar
     */
    public function findCustomerCreditLimit($id) {
        $this->db->select('credit_limit');
        $this->db->from('tbl_customers');
        $this->db->where('id', $id);
        $this->db->where('del_status', 'Live');
        $result = $this->db->get()->row();
        return $result;
    }

   
    /**
     * comparison_sale_report
     * @access public
     * @param string
     * @param string
     * @return object
     * Added By Azhar
     */
    public function comparison_sale_report($start_date, $end_date) {
        $outlet_id = $this->session->userdata('outlet_id');
        $query = $this->db->query("select year(sale_date) as year, month(sale_date) as month, sum(total_payable) as total_amount from tbl_sales WHERE `sale_date` BETWEEN '$start_date' AND '$end_date' AND outlet_id='$outlet_id' group by year(sale_date), month(sale_date)");
        if($query->row()){
            return $query->row()->total_amount;
        }else{
            return  0 ;
        }
    }

    /**
     * installDownAndPaidAmount
     * @access public
     * @param string
     * @param string
     * @return object
     * Added By Azhar
     */
    public function installDownAndPaidAmount($start_date, $end_date) {
        $outlet_id = $this->session->userdata('outlet_id');
        $query1 = $this->db->query("select sum(down_payment) as total_amount from tbl_installments WHERE DATE(date) BETWEEN '$start_date' AND '$end_date' AND outlet_id='$outlet_id'  AND del_status='Live'  group by year(date), month(date)");
        $total_1 = 0;
        $total_2 = 0;
        if($query1->row()){
            $total_1 = $query1->row()->total_amount;
        }
        $query2 = $this->db->query("select sum(paid_amount) as total_amount from tbl_installment_items WHERE DATE(added_date) BETWEEN '$start_date' AND '$end_date' AND outlet_id='$outlet_id' AND del_status='Live' AND paid_status='Paid' group by year(added_date), month(added_date)");
        if($query2->row()){
            $total_2 = $query2->row()->total_amount;
        }
        return $total_1+$total_2;
    }

    /**
     * setDefaultTimezone
     * @access public
     * @param no
     * @return string
     * Added By Azhar
     */
    public function setDefaultTimezone() {
        $this->db->select("zone_name");
        $this->db->from('tbl_companies'); 
        $this->db->where('id', $this->session->userdata('company_id'));
        $zoneName = $this->db->get()->row();
        if ($zoneName)
            date_default_timezone_set($zoneName->zone_name);
    }

    /**
     * delete_row
     * @access public
     * @param string
     * @param string
     * @return void
     * Added By Azhar
     */
    function delete_row($table_name, $where_param) {
        $this->db->where($where_param);
        $this->db->delete($table_name);
        return $this->db->affected_rows();
    }



    /**
     * getAllByCompanyIdForDropdownProduct
     * @access public
     * @param int
     * @param string
     * @return object
     */
    public function getAllByCompanyIdForDropdownProduct($company_id, $table_name) {
        $company_id = $this->session->userdata('company_id');
        $this->db->select('*');
        $this->db->from($table_name);
        $this->db->where('del_status', 'Live');
        $this->db->where('company_id', $company_id);
        $this->db->order_by('name', 'ASC');
        $result = $this->db->get();
        if($result != false){
            return $result->result();
        }else{
            return false;
        }
    }
    /**
     * getAllItemByComapnyIdForDropdown
     * @access public
     * @param int
     * @param string
     * @return object
     */
    public function getAllItemByComapnyIdForDropdown($company_id, $table_name) {
        $company_id = $this->session->userdata('company_id');
        $this->db->select('*');
        $this->db->from($table_name);
        $this->db->where('enable_disable_status', 'Enable');
        $this->db->where('del_status', 'Live');
        $this->db->where('company_id', $company_id);
        $this->db->order_by('name', 'ASC');
        $result = $this->db->get();
        if($result != false){
            return $result->result();
        }else{
            return false;
        }
    }


    /**
     * getItemVariationDetails
     * @access public
     * @param int
     * @return  object
     */
    public function getItemVariationDetails($id){
        $this->db->select('variation_details');
        $this->db->from('tbl_items');
        $this->db->where('id', $id);
        $this->db->where('del_status', 'Live');
        $result = $this->db->get();
        if($result != false){
            return $result->result();
        }else{
            return false;
        }
    }

    /**
     * notificationReadById
     * @access public
     * @param string
     * @param int
     * @param int
     * @return int
     */
    public function notificationReadById($read_status, $id, $company_id)
    {
        if($read_status == '0'){
            $this->db->set('read_status', 1);
        }else if($read_status == '1'){
            $this->db->set('read_status', 0);
        }
        $this->db->where('id', $id);
		$this->db->where('company_id',$company_id);
        $this->db->update('tbl_notifications');
        return $this->db->insert_id();
    }

    /**
     * notificationUnReadById
     * @access public
     * @param int
     * @param int
     * @return int
     */
    public function notificationUnReadById($id, $company_id)
    {
        $outlet_id = $this->session->userdata('outlet_id');
        $this->db->set('read_status', 0);
        $this->db->where('id', $id);
		$this->db->where('company_id',$company_id);
		$this->db->where('outlet_id',$outlet_id);
        $this->db->update('tbl_notifications');
        return $this->db->insert_id();
    }
    /**
     * hardDeleteById
     * @access public
     * @param int
     * @param string
     * @return object
     */
    public function hardDeleteById($id, $table_name) {
        return $this->db->delete($table_name, ['id'=> $id]);
    }


    /**
     * installmentNotification
     * @access public
     * @param string
     * @return int
     */
    public function installmentNotification($end_date){
        $company_id = $this->session->userdata('company_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $this->db->select('*');
        $this->db->from('tbl_installment_items');
        $this->db->where('payment_date <=', $end_date);
        $this->db->where('notification_status', '1');
		$this->db->where('company_id',$company_id);
		$this->db->where('del_status','Live');
        $result = $this->db->get()->result();
        foreach ($result as $r){
            // Notification Insert
            $data = array ();
            $data['notifications_details'] = 'Installment Notification';
            $data['date'] = date('Y-m-d');
            $data['outlet_id'] = $outlet_id;
            $data['company_id'] = $company_id;
            $this->db->insert('tbl_notifications', $data);
            $this->db->insert_id();

            // Notification Status Update
            $this->db->set('notification_status', 2);
            $this->db->where('id', $r->id);
            $this->db->update('tbl_installment_items');
            return $this->db->insert_id();
        }
    }

    /**
     * getAllCustomerNameMobile
     * @access public
     * @param no
     * @return object
     */
    public function getAllCustomerNameMobile(){
        $company_id = $this->session->userdata('company_id');
        $this->db->select('id,name,phone');
        $this->db->from('tbl_customers');
        $this->db->where('company_id', $company_id);
		$this->db->where('del_status','Live');
		$this->db->order_by('name', 'ASC');
        $result = $this->db->get()->result();
        return $result;
    }
    /**
     * getAllSupplierNameMobile
     * @access public
     * @param no
     * @return object
     */
    public function getAllSupplierNameMobile(){
        $company_id = $this->session->userdata('company_id');
        $this->db->select('id,name,phone');
        $this->db->from('tbl_suppliers');
        $this->db->where('company_id', $company_id);
		$this->db->where('del_status','Live');
		$this->db->order_by('name', 'ASC');
        $result = $this->db->get()->result();
        return $result;
    }

    /**
     * getAllItemNameCodeWithoutVariation
     * @access public
     * @param no
     * @return object
     */
    public function getAllItemNameCodeWithoutVariation(){
        $company_id = $this->session->userdata('company_id');
        $sql = "SELECT ii.name AS parent_name, i.id, i.name, i.code, b.name AS brand_name, i.parent_id
                FROM tbl_items i
                LEFT JOIN tbl_items ii ON i.parent_id = ii.id
                LEFT JOIN tbl_brands b ON b.id = i.brand_id
                WHERE i.type != 'Variation_Product' AND i.enable_disable_status = 'Enable' AND i.company_id = ? AND i.del_status = 'Live'
                ORDER BY COALESCE(parent_name, i.name) ASC";
        $result = $this->db->query($sql, array($company_id))->result();
        return $result;
    }



    /**
     * getItemWithVariationForDrowdown
     * @access public
     * @param no
     * @return object
     */
    public function getItemWithVariationForDrowdown() {
        $company_id = $this->session->userdata('company_id');
        $sql = "SELECT ii.name AS parent_name, i.id, i.name, i.code, i.type, i.expiry_date_maintain, i.purchase_price,i.sale_price,i.last_three_purchase_avg, i.last_purchase_price, i.conversion_rate, pu.unit_name as purchase_unit, su.unit_name as sale_unit, b.name AS brand_name, i.parent_id
                FROM tbl_items i
                LEFT JOIN tbl_items ii ON i.parent_id = ii.id
                LEFT JOIN tbl_brands b ON b.id = i.brand_id
                LEFT JOIN tbl_units as pu ON i.purchase_unit_id = pu.id
                LEFT JOIN tbl_units as su ON i.sale_unit_id = su.id
                WHERE i.type != 'Variation_Product' AND  i.type != 'Service_Product' AND i.company_id = ? AND i.enable_disable_status = 'Enable' AND i.del_status = 'Live'
                ORDER BY COALESCE(parent_name, i.name) ASC";
        $result = $this->db->query($sql, array($company_id))->result();
        return $result;
    }


    /**
     * getAllExpenseCategory
     * @access public
     * @param no
     * @return object
     */
    public function getAllExpenseCategory(){
        $company_id = $this->session->userdata('company_id');
        $this->db->select('id,name');
        $this->db->from('tbl_expense_items');
        $this->db->where('company_id', $company_id);
		$this->db->where('del_status','Live');
        $result = $this->db->get()->result();
        return $result;
    }

    /**
     * getAllIncomeCategory
     * @access public
     * @param no
     * @return object
     */
    public function getAllIncomeCategory(){
        $company_id = $this->session->userdata('company_id');
        $this->db->select('id,name');
        $this->db->from('tbl_income_items');
        $this->db->where('company_id', $company_id);
		$this->db->where('del_status','Live');
        $result = $this->db->get()->result();
        return $result;
    }

    /**
     * getAllUsersNameMobile
     * @access public
     * @param no
     * @return object
     */
    public function getAllUsersNameMobile(){
        $company_id = $this->session->userdata('company_id');
        $this->db->select('id,full_name,phone');
        $this->db->from('tbl_users');
        $this->db->where('company_id', $company_id);
		$this->db->where('del_status','Live');
		$this->db->order_by('full_name', 'ASC');
        $result = $this->db->get()->result();
        return $result;
    }

     /**
     * getAllUsersNameMobileForReportDropdown
     * @access public
     * @param no
     * @return object
     */
    public function getAllUsersNameMobileForReportDropdown(){
        $company_id = $this->session->userdata('company_id');
        $user_id = $this->session->userdata('user_id');
        $role = $this->session->userdata('role');
        $this->db->select('id,full_name,phone');
        $this->db->from('tbl_users');
        if($role != '1'){
            $this->db->where('id', $user_id);
        }
        $this->db->where('company_id', $company_id);
		$this->db->where('del_status','Live');
		$this->db->order_by('full_name','ASC');
        $result = $this->db->get()->result();
        return $result;
    }

    /**
     * getQuotationInfo
     * @access public
     * @param int
     * @return object
     */
    public function getQuotationInfo($quatation_id){
        $company_id = $this->session->userdata('company_id');
        $this->db->select('q.*, c.name as customer_name, c.email as customer_email, c.id as customer_id');
        $this->db->from('tbl_quotations q');
        $this->db->join('tbl_customers c', 'c.id = q.customer_id', 'left');
        $this->db->where('q.id', $quatation_id);
        $this->db->where('q.company_id', $company_id);
		$this->db->where('q.del_status','Live');
        $result = $this->db->get()->row();
        return $result;
    }

    /**
     * getAllQuotationDetails
     * @access public
     * @param int
     * @return object
     */
    public function getAllQuotationDetails($quatation_id){
        $company_id = $this->session->userdata('company_id');
        $this->db->select('qd.*, i.name as item_name, i.type as item_type, i.code as item_code, u.unit_name');
        $this->db->from('tbl_quotation_details qd');
        $this->db->join('tbl_items i', 'i.id = qd.item_id', 'left');
        $this->db->join('tbl_units u', 'u.id = i.purchase_unit_id', 'left');
        $this->db->where('qd.quotation_id', $quatation_id);
        $this->db->where('qd.company_id', $company_id);
		$this->db->where('qd.del_status','Live');
        $result = $this->db->get()->result();
        return $result;
    }

    /**
     * getSaleInvoiceByCustomerId
     * @access public
     * @param int
     * @return object
     */
    public function getSaleInvoiceByCustomerId($customer_id){
        $company_id = $this->session->userdata('company_id');
        $this->db->select('id,sale_no,total_payable, sale_date, total_items');
        $this->db->from('tbl_sales');
        $this->db->where('customer_id', $customer_id);
        $this->db->where('company_id', $company_id);
		$this->db->where('del_status','Live');
        $result = $this->db->get()->result();
        return $result;
    }


    /**
     * getSaleInfoByUserId
     * @access public
     * @param int
     * @return object
     */
    public function getSaleInfoByUserId($user_id){
        $company_id = $this->session->userdata('company_id');
        $this->db->select('s.id, s.sale_no, s.total_items, s.total_payable, s.paid_amount, s.date_time, c.name as customer_name, c.phone as customer_phone');
        $this->db->from('tbl_sales s');
        $this->db->join('tbl_customers c', 'c.id = s.customer_id', 'left');
        $this->db->where('s.user_id', $user_id);
        $this->db->where('s.company_id', $company_id);
		$this->db->where('s.del_status','Live');
        $result = $this->db->get()->result();
        return $result;
    }

     /**
     * generateReferenceNoForExpense
     * @access public
     * @param int
     * @return string
     */
    public function generateReferenceNoForExpense($outlet_id) {
        $reference_no = $this->db->query("SELECT count(id) as reference_no
               FROM tbl_expenses where outlet_id=$outlet_id")->row('reference_no');
        $reference_no = str_pad($reference_no + 1, 6, '0', STR_PAD_LEFT);
        return $reference_no;
    }

    /**
     * generateReferenceNoForIncome
     * @access public
     * @param int
     * @return string
     */
    public function generateReferenceNoForIncome($outlet_id) {
        $reference_no = $this->db->query("SELECT count(id) as reference_no
               FROM tbl_incomes where outlet_id=$outlet_id")->row('reference_no');
        $reference_no = str_pad($reference_no + 1, 6, '0', STR_PAD_LEFT);
        return $reference_no;
    }

    /**
     * getAllPaymentMethod
     * @access public
     * @param no
     * @return object
     */
    public function getAllPaymentMethod(){
        $company_id = $this->session->userdata('company_id');
        $this->db->select('id, name, account_type');
        $this->db->from('tbl_payment_methods');
        $this->db->where('company_id', $company_id);
        $this->db->where('del_status', 'Live');
		$this->db->order_by('name', 'ASC');
        $result = $this->db->get()->result();
        return $result;
    }

    /**
     * getAllEnablePaymentMethod
     * @access public
     * @param no
     * @return object
     */
    public function getAllEnablePaymentMethod(){
        $company_id = $this->session->userdata('company_id');
        $this->db->select('*');
        $this->db->from('tbl_payment_methods');
        $this->db->where('company_id', $company_id);
        $this->db->where('status', 'Enable');
        $this->db->where('del_status', 'Live');
		$this->db->order_by('name', 'ASC');
        $result = $this->db->get()->result();
        return $result;
    }
    
     /**
     * getAllServicingProduct
     * @access public
     * @param string
     * @param int
     * @return object
     */
    public function getAllServicingProduct($status='', $customer_id=''){
        $outlet_id = $this->session->userdata('outlet_id');
        $company_id = $this->session->userdata('company_id');
        $this->db->select('s.*, c.name as customer_name, e.full_name as employee_name, a.full_name as added_by');
        $this->db->from('tbl_servicing s');
        $this->db->join('tbl_customers c', 'c.id = s.customer_id', 'left');
        $this->db->join('tbl_users e', 'e.id = s.employee_id', 'left');
        $this->db->join('tbl_users a', 'a.id = s.user_id', 'left');
        if($status){
            $this->db->where('s.status', $status);
        }
        if($customer_id){
            $this->db->where('s.customer_id', $customer_id);
        }
        $this->db->where('s.outlet_id', $outlet_id);
        $this->db->where('s.company_id', $company_id);
        $this->db->where('s.del_status','Live');
        $this->db->order_by('s.id','DESC');
        $result = $this->db->get()->result();
        return $result;
    }



    /**
     * getExpiryByOutlet
     * @access public
     * @param int
     * @return object
     */
    public function getExpiryByOutlet($item_id){
        $outlet_id = $this->session->userdata('outlet_id');
        $result = $this->db->query("SELECT s.item_id, s.expiry_imei_serial,IFNULL(SUM(s.stock_quantity),0) as stock_quantity
        FROM tbl_stock_detail2 s
        WHERE s.outlet_id='$outlet_id'  AND s.item_id='$item_id'
        GROUP BY s.expiry_imei_serial ORDER BY s.expiry_imei_serial ASC")->result();
        if($result){
            return $result;
        }else{
            return false;
        }
    }


    /**
     * singleExpiryDateStockCheck
     * @access public
     * @param int
     * @param string
     * @return object
     */
    public function singleExpiryDateStockCheck($item_id, $expiry_date){
        $outlet_id = $this->session->userdata('outlet_id');
        $result = $this->db->query("SELECT s.item_id, s.expiry_imei_serial,IFNULL(SUM(s.stock_quantity),0) as stock_quantity
        FROM tbl_stock_detail2 s
        WHERE s.outlet_id='$outlet_id'  AND s.item_id='$item_id' AND s.expiry_imei_serial = '$expiry_date'
        GROUP BY s.expiry_imei_serial ORDER BY s.expiry_imei_serial ASC")->row();
        if($result){
            return $result;
        }else{
            return false;
        }
    }

    /**
     * getVariationByItemId
     * @access public
     * @param int
     * @return object
     */
    function getVariationByItemId($item_id){
        $this->db->select('i.*, ii.name as parent_name, u.unit_name as sale_unit_name');
        $this->db->from('tbl_items i');
        $this->db->join('tbl_items ii', 'i.parent_id = ii.id');
        $this->db->join('tbl_units u', 'u.id = i.sale_unit_id');
        $this->db->where('i.parent_id', $item_id);
        $this->db->where('i.del_status', 'Live');
        $result = $this->db->get()->result();
        if($result){
            // Loop through each index and push the promo data
            foreach ($result as $single_menus) {
                $is_promo = 'No';
                $today = date("Y-m-d",strtotime('today'));
                $promo_checker = (Object)checkPromotionWithinDatePOS($today,$single_menus->id);
                $get_food_menu_id = '';
                $string_text = '';
                $get_qty = 0;
                $qty = 0;
                $discount = '';
                $promo_type = '';
                $modal_item_name_row = '';
                if(isset($promo_checker) && $promo_checker && $promo_checker->status){
                    $get_food_menu_id = $promo_checker->get_food_menu_id;
                    $string_text = $promo_checker->string_text;
                    $get_qty = $promo_checker->get_qty;
                    $qty = $promo_checker->qty;
                    $discount = $promo_checker->discount;
                    $promo_type = $promo_checker->type;
                    $modal_item_name_row = getParentNameTemp($single_menus->parent_id).getFoodMenuNameCodeById($get_food_menu_id);
                    $is_promo = "Yes";
                }
                $single_menus->is_promo = $is_promo;
                $single_menus->promo_item_name = $modal_item_name_row;
                $single_menus->promo_type = $promo_type;
                $single_menus->promo_discount = $discount;
                $single_menus->promo_qty = $qty;
                $single_menus->promo_get_qty = $get_qty;
                $single_menus->promo_description = $string_text;
                $single_menus->promo_item_id = $get_food_menu_id;
                $single_menus->parent_id = $single_menus->parent_id; // Use the existing parent_id
            }
            return $result;
        }else{
            return false;
        }
    }

    /**
     * getSingleVariationItemWithStock
     * @access public
     * @param int
     * @return object
     */
    public function getSingleVariationItemWithStock($item_id) {
        $where_item_parent = '';
        $where_item_parent .= " AND p_var.parent_id = '$item_id'";
        $outlet_id = $this->session->userdata('outlet_id');
        $company_id = $this->session->userdata('company_id');
        $data = $this->db->query("SELECT 
                p.id, p.name, p.code, p.type, p.expiry_date_maintain, p.alert_quantity, p.unit_type,
                p.last_three_purchase_avg, p.last_purchase_price, p.conversion_rate, pu.unit_name as purchase_unit, su.unit_name as sale_unit,
                (
                    SELECT GROUP_CONCAT(
                        CONCAT(p_var.name, '|', p_var.code, '|', p_var.alert_quantity, '|', COALESCE(p_var.last_three_purchase_avg, 0), '|', 
                        COALESCE((SELECT IFNULL(SUM(vst1.stock_quantity), 0) 
                                FROM tbl_stock_detail vst1
                                WHERE p_var.id = vst1.item_id AND vst1.type = 1 AND vst1.outlet_id = '$outlet_id'), 0), '|',
                        COALESCE((SELECT IFNULL(SUM(vst2.stock_quantity), 0) 
                                FROM tbl_stock_detail vst2
                                WHERE p_var.id = vst2.item_id AND vst2.type = 2 AND vst2.outlet_id = '$outlet_id'), 0)
                    ) SEPARATOR '||')
                    FROM tbl_items p_var
                    WHERE p_var.parent_id = p.id AND p_var.type = '0' AND p_var.del_status = 'Live' $where_item_parent
                ) as variations
            FROM tbl_items p
            
            LEFT JOIN tbl_units pu ON pu.id = p.purchase_unit_id
            LEFT JOIN tbl_units su ON su.id = p.sale_unit_id
            WHERE p.id='$item_id' AND p.company_id='$company_id' AND p.enable_disable_status = 'Enable' AND p.del_status = 'Live'
            ORDER BY p.name ASC")->row();
        return $data;
    }

    /**
     * getSingleExpiryItemWithStock
     * @access public
     * @param int
     * @return object
     */
    public function getSingleExpiryItemWithStock($item_id){
        $where = '';
        if($item_id!=''){
            $where.= " AND p.id = '$item_id'";
        }
        $outlet_id = $this->session->userdata('outlet_id');
        $company_id = $this->session->userdata('company_id');
        $data = $this->db->query("SELECT 
            p.id, p.name, p.code, p.type, p.expiry_date_maintain, p.alert_quantity, p.unit_type,
            p.last_three_purchase_avg, p.last_purchase_price, p.conversion_rate, 
            c.name as category_name, pu.unit_name as purchase_unit, su.unit_name as sale_unit,
            (
                SELECT IFNULL(SUM(st3.stock_quantity), 0) 
                FROM tbl_stock_detail st3
                WHERE p.id = st3.item_id AND st3.type = 1 AND st3.outlet_id = '$outlet_id'
            ) as stock_qty,
            (
                SELECT IFNULL(SUM(st4.stock_quantity), 0) 
                FROM tbl_stock_detail st4
                WHERE p.id = st4.item_id AND st4.type = 2 AND st4.outlet_id = '$outlet_id'
            ) as out_qty,
            (
                SELECT GROUP_CONCAT(c.stockq SEPARATOR '||') FROM (
                    SELECT exp.item_id,CONCAT(exp.expiry_imei_serial, '|', COALESCE(SUM(exp.stock_quantity), 0)) as stockq
                        FROM tbl_stock_detail2 exp
                        WHERE  exp.outlet_id = '$outlet_id'
                        GROUP BY exp.expiry_imei_serial, item_id) 
                    as c WHERE c.item_id=p.id GROUP BY c.item_id
            ) as allexpiry
        FROM tbl_items p
        LEFT JOIN tbl_item_categories c ON p.category_id = c.id
        LEFT JOIN tbl_units pu ON pu.id = p.purchase_unit_id
        LEFT JOIN tbl_units su ON su.id = p.sale_unit_id
        WHERE p.company_id='$company_id' AND p.enable_disable_status = 'Enable' AND p.del_status = 'Live' $where
        ORDER BY p.name ASC")->row();
        return $data;
    }
    


    /**
     * getComboItemCheck
     * @access public
     * @param int
     * @return object
     */
    function getComboItemCheck($item_id){
        $this->db->select('i.name as item_name, i.type, ci.unit_price as unit_price, ci.quantity as quantity, ci.show_invoice, ci.item_id as child_combo_item_id, ci.combo_id as combo_parent_id');
        $this->db->from('tbl_combo_items ci');
        $this->db->join('tbl_items i', 'i.id = ci.item_id', 'left');
        $this->db->where('ci.combo_id', $item_id);
        $this->db->where('ci.del_status', 'Live');
        // $this->db->group_by('ci.combo_id');
        $result = $this->db->get()->result();
        if($result){
            return $result;
        }else{
            return false;
        }
    }

    

    /**
     * getAllNotification
     * @access public
     * @param no
     * @return object
     */
    function getAllNotification(){
        $company_id = $this->session->userdata('company_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $this->db->select('*');
        $this->db->from('tbl_notifications');
        $this->db->where('outlet_id', $outlet_id);
        $this->db->where('company_id', $company_id);
        $this->db->where('del_status', 'Live');
        $result = $this->db->get()->result();
        if($result){
            return $result;
        }else{
            return false;
        }
    }

    /**
     * getNotificationCount
     * @access public
     * @param no
     * @return int
     */
    public function getNotificationCount() {
        $company_id = $this->session->userdata('company_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $this->db->from('tbl_notifications');
        $this->db->where('read_status','0');
        $this->db->where('company_id', $company_id);
        $this->db->where('outlet_id', $outlet_id);
        $this->db->where('del_status', 'Live');
        return $this->db->count_all_results();
    }

    /**
     * markAsAllReadNotification
     * @access public
     * @param no
     * @return boolean
     */
    function markAsAllReadNotification(){
        $company_id = $this->session->userdata('company_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $this->db->set('read_status', "1");
        $this->db->where('outlet_id', $outlet_id);
        $this->db->where('company_id', $company_id);
        $this->db->update('tbl_notifications');
        return true;
    }

    /**
     * fieldNameCheckingByFieldNameForAPI
     * @access public
     * @param string
     * @param string
     * @param string
     * @param int
     * @param int
     * @return void
     */
    public function fieldNameCheckingByFieldNameForAPI($name, $field_name, $table_name, $user_id="", $company_id=""){
        $field_name_filter = escape_output($field_name);
        $this->db->select("id, $field_name_filter");
        $this->db->from("$table_name");
        $this->db->where($field_name_filter, $name);
        $this->db->where('company_id', $company_id);
        $this->db->where('del_status', 'Live');
        $result = $this->db->get()->row();
        if($result){
            return $result->id;
        }else{
            $data = [];
            $data["$field_name"] = $name;
            $data["added_date"] = date('Y-m-d H:i:s');
            $data["user_id"] = $user_id;
            $data["company_id"] = $company_id;
            return $this->insertInformation($data, $table_name);
        }
    }

    /**
     * getCounterIdByRegisterId
     * @access public
     * @param int
     * @return int
     */
    public function getCounterIdByRegisterId($register_id){
        $this->db->select("counter_id");
        $this->db->from("tbl_register");
        $this->db->where('id', $register_id);
        $this->db->where('del_status', 'Live');
        $result = $this->db->get()->row();
        if($result){
            return $result->counter_id;
        }
    }

    /**
     * getPrinterIdByCounterId
     * @access public
     * @param int
     * @return int
     */
    public function getPrinterIdByCounterId($counter_id){
        $this->db->select("printer_id");
        $this->db->from("tbl_counters");
        $this->db->where('id', $counter_id);
        $this->db->where('del_status', 'Live');
        $result = $this->db->get()->row();
        if($result){
            return $result->printer_id;
        }
    }

    /**
     * getPrinterInfoById
     * @access public
     * @param int
     * @return object
     */
    public function getPrinterInfoById($printer_id){
        $this->db->select("*");
        $this->db->from("tbl_printers");
        $this->db->where('id', $printer_id);
        $this->db->where('del_status', 'Live');
        $result = $this->db->get()->row();
        if($result){
            return $result;
        }
    }

    /**
     * stockCheckingForThisOutletById
     * @access public
     * @param int
     * @return int
     */
    public function stockCheckingForThisOutletById($item_id){
        $outlet_id = $this->session->userdata('outlet_id');
        $result = $this->db->query("SELECT p.name as item_name,
        (SELECT GROUP_CONCAT(st.expiry_imei_serial SEPARATOR '||') as dd
        FROM tbl_stock_detail st
        WHERE p.id=st.item_id AND st.type=1  AND st.expiry_imei_serial!='' AND st.outlet_id='$outlet_id'
        AND st.expiry_imei_serial NOT IN (SELECT st2.expiry_imei_serial FROM tbl_stock_detail st2 
            WHERE st2.item_id=p.id AND st2.type=2 
            AND st2.expiry_imei_serial!='' AND st2.outlet_id='$outlet_id')) as allimei,
        (SELECT IFNULL(SUM(st3.stock_quantity),0) FROM tbl_stock_detail st3
        WHERE p.id=st3.item_id   AND st3.type=1 AND st3.outlet_id='$outlet_id') as stock_qty,
        (SELECT IFNULL(SUM(st4.stock_quantity),0) FROM tbl_stock_detail st4
        WHERE p.id=st4.item_id AND st4.type=2 AND st4.outlet_id='$outlet_id') as out_qty
        FROM tbl_items p WHERE p.id='$item_id' AND p.del_status='Live'")->row();

        if($result){
            return (float)$result->stock_qty - (float)$result->out_qty;
        }else{
            return false;
        }
    }

    /**
     * getIMEINumber
     * @access public
     * @param int
     * @return object
     */
    public function getIMEINumber($item_id){
        $outlet_id = $this->session->userdata('outlet_id');
        $result = $this->db->query("SELECT p.name as item_name, p.code as item_code, p.type as item_type,
        (SELECT GROUP_CONCAT(st.expiry_imei_serial SEPARATOR '||') as dd
        FROM tbl_stock_detail st
        WHERE p.id=st.item_id AND st.type=1  AND st.expiry_imei_serial!='' AND st.outlet_id='$outlet_id'
        AND st.expiry_imei_serial NOT IN (SELECT st2.expiry_imei_serial FROM tbl_stock_detail st2 
            WHERE st2.item_id=p.id AND st2.type=2 
            AND st2.expiry_imei_serial!='' AND st2.outlet_id='$outlet_id')) as allimei,
        (SELECT IFNULL(SUM(st3.stock_quantity),0) FROM tbl_stock_detail st3
        WHERE p.id=st3.item_id   AND st3.type=1 AND st3.outlet_id='$outlet_id') as stock_qty,
        (SELECT IFNULL(SUM(st4.stock_quantity),0) FROM tbl_stock_detail st4
        WHERE p.id=st4.item_id AND st4.type=2 AND st4.outlet_id='$outlet_id') as out_qty
        FROM tbl_items p WHERE p.id='$item_id' AND p.del_status='Live'")->row();
        if($result){
            return $result;
        }else{
            return false;
        }
    }
    

    /**
     * getIMEISerialByOutlet
     * @access public
     * @param int
     * @param int
     * @return object
     */
    public function getIMEISerialByOutlet($item_id, $outlet_id){
        $result = $this->db->query("SELECT p.name as item_name, p.code as item_code, p.type as item_type,
        (SELECT GROUP_CONCAT(st.expiry_imei_serial SEPARATOR '||') as dd
        FROM tbl_stock_detail st
        WHERE p.id=st.item_id AND st.type=1  AND st.expiry_imei_serial!='' AND st.outlet_id='$outlet_id'
        AND st.expiry_imei_serial NOT IN (SELECT st2.expiry_imei_serial FROM tbl_stock_detail st2 
            WHERE st2.item_id=p.id AND st2.type=2 
            AND st2.expiry_imei_serial!='' AND st2.outlet_id='$outlet_id')) as allimei,
        (SELECT IFNULL(SUM(st3.stock_quantity),0) FROM tbl_stock_detail st3
        WHERE p.id=st3.item_id   AND st3.type=1 AND st3.outlet_id='$outlet_id') as stock_qty,
        (SELECT IFNULL(SUM(st4.stock_quantity),0) FROM tbl_stock_detail st4
        WHERE p.id=st4.item_id AND st4.type=2 AND st4.outlet_id='$outlet_id') as out_qty
        FROM tbl_items p WHERE p.id='$item_id' AND p.del_status='Live'")->row();
        if($result){
            return $result;
        }else{
            return false;
        }
    }

    /**
     * checkingExisOrNotIMEISerial
     * @access public
     * @param int
     * @return object
     */
    public function checkingExisOrNotIMEISerial($item_id){
        $result = $this->db->query("SELECT p.name as item_name, p.code as item_code, p.type as item_type,
        (SELECT GROUP_CONCAT(st.expiry_imei_serial SEPARATOR '||') as dd
        FROM tbl_stock_detail st
        WHERE p.id=st.item_id AND st.type=1  AND st.expiry_imei_serial!=''
        AND st.expiry_imei_serial NOT IN (SELECT st2.expiry_imei_serial FROM tbl_stock_detail st2 
            WHERE st2.item_id=p.id AND st2.type=2 
            AND st2.expiry_imei_serial!='')) as allimei,
        (SELECT IFNULL(SUM(st3.stock_quantity),0) FROM tbl_stock_detail st3
        WHERE p.id=st3.item_id   AND st3.type=1) as stock_qty,
        (SELECT IFNULL(SUM(st4.stock_quantity),0) FROM tbl_stock_detail st4
        WHERE p.id=st4.item_id AND st4.type=2) as out_qty
        FROM tbl_items p WHERE p.id='$item_id' AND p.del_status='Live'")->row();
        if($result){
            return $result;
        }else{
            return false;
        }
    }



    /**
     * getServiceCompanies
     * @access public
     * @return object
     * @param no
     */
    public function getServiceCompanies() {
        $this->db->select("c.id, c.business_name, c.phone, c.is_block_all_user, c.plan_cost, c.expired_date, p.plan_name, p.free_trial_status");
        $this->db->from("tbl_companies c");
        $this->db->join("tbl_pricing_plans p", 'p.id = c.plan_id', 'left');
        $this->db->where("c.del_status", 'Live');
        // $this->db->where("p.free_trial_status", 'Paid');
        $this->db->group_by("c.id", 'ASC');
        return $this->db->get()->result();
    }
    /**
     * getServiceCompaniesYes
     * @access public
     * @return object
     * @param no
     */
    public function getServiceCompaniesYes() {
        $this->db->select("*");
        $this->db->from("tbl_companies");
        $this->db->where("del_status", 'Live');
        $this->db->where("payment_clear", 'Yes');
        $this->db->order_by("id", 'DESC');
        return $this->db->get()->result();
    }


    /**
     * getServiceCompaniesYes
     * @access public
     * @return object
     * @param no
     */
    public function getCustomDataByParams($field_name, $value, $table_name) {
        $this->db->select("*");
        $this->db->from($table_name);
        $this->db->where($field_name, $value);
        return $this->db->get()->row();
    }

    /**
     * get AdminInfo For Company
     * @access public
     * @return object
     * @param int
     */
    public function getAdminInfoForCompany($company_id) {
        $this->db->select("*");
        $this->db->from("tbl_users");
        $this->db->where("del_status", 'Live');
        $this->db->where("role", '1');
        $this->db->where("company_id", $company_id);
        $this->db->order_by("id", 'ASC');
        $this->db->limit(1);
        return $this->db->get()->row();
    }


    /**
     * top ten supplier payable
     * @access public
     * @return object
     * @param no
     */
    public function getPaymentHistory($company_id='') {
        $this->db->select('ph.*,c.business_name');
        $this->db->from('tbl_payment_histories ph');
        $this->db->join('tbl_companies c', 'c.id = ph.company_id', 'left');
        if($company_id!=''){
            $this->db->where('ph.company_id', $company_id);
        }
        $this->db->where('ph.del_status', 'Live');
        $this->db->order_by('ph.id',"DESC");
        return $this->db->get()->result();
    }


    /**
     * delStatusLiveForCompanyActive
     * @access public
     * @param int
     * @return object
     */
    public function delStatusLiveForCompanyActive($company_id, $table_name){
        $this->db->set('del_status', "Live");
        $this->db->where('company_id', $company_id);
        $this->db->where('del_status', 'Deleted');
        $this->db->update($table_name);
    }

    /**
     * delStatusDeleteForCompanyDelete
     * @access public
     * @param int
     * @return object
     */
    public function delStatusDeleteForCompanyDelete($company_id, $table_name){
        $this->db->set('del_status', "Deleted");
        $this->db->where('company_id', $company_id);
        $this->db->where('del_status', 'Live');
        $this->db->update($table_name);
    }

    /**
     * getLastPayment
     * @access public
     * @return object
     * @param int
     * @param string
     */
    public function getLastPayment($company_id) {
        $this->db->select("payment_date");
        $this->db->from('tbl_payment_histories');
        $this->db->where("company_id", $company_id);
        $this->db->order_by('id', 'DESC'); 
        $this->db->limit(1);
        return $this->db->get()->row();
    }
    /**
     * getCountSaleNo
     * @access public
     * @return object
     * @param int
     * @param string
     */
    public function getCountSaleNo($company_id) {
        $this->db->where('company_id', $company_id);
        $this->db->from('tbl_sales');
        $this->db->where('del_status', 'Live');
        $count = $this->db->count_all_results();
        return $count;
    }
    /**
     * get Data By Id
     * @access public
     * @return object
     * @param int
     * @param string
     */
    public function getCountUser($company_id) {
        $this->db->where('company_id', $company_id);
        $this->db->from('tbl_users');
        $this->db->where('del_status', 'Live');
        $count = $this->db->count_all_results();
        return $count;
    }
    /**
     * get Data By Id
     * @access public
     * @return object
     * @param int
     * @param string
     */
    public function getCountOutlet($company_id) {
        $this->db->where('company_id', $company_id);
        $this->db->from('tbl_outlets');
        $this->db->where('del_status', 'Live');
        $count = $this->db->count_all_results();
        return $count;
    }


    /**
     * getItemForBulkUpdate
     * @access public
     * @return void
     */
    public function getItemForBulkUpdate() {
        $company_id = $this->session->userdata('company_id');
        $this->db->select('id, enable_disable_status, photo, name, code, type, sale_price, whole_sale_price');
        $this->db->from('tbl_items');
        $this->db->where("type !=", 'Variation_Product');
        $this->db->where("type !=", '0');
        $this->db->where("type !=", 'Combo_Product');
        $this->db->where("company_id", $company_id);
        $this->db->where("del_status", 'Live');
        return $this->db->get()->result();
    }

    /**
     * delStatusLiveByCompanyId
     * @access public
     * @return void
     * @param int
     * @param int
     */
    public function delStatusLiveByCompanyId($company_id, $table_name){
        $this->db->select('*');
        $this->db->from($table_name);
        $this->db->where("company_id", $company_id);
        $this->db->where("del_status", 'Live');
        return $this->db->get()->result();
    }




    /**
     * saleReturnItems
     * @access public
     * @param int
     * @return object
     */
    public function saleReturnItems($id) {
        $this->db->select("srd.*, i.name as item_name, i.code as item_code,i.conversion_rate,i.unit_type, i.parent_id, i.expiry_date_maintain, b.name as brand_name, sui.unit_name as sale_unit_name");
        $this->db->from("tbl_sale_return_details srd");
        $this->db->join('tbl_items i','srd.item_id=i.id','left');
        $this->db->join('tbl_brands b','b.id = i.brand_id','left');
        $this->db->join('tbl_units sui','sui.id = i.sale_unit_id','left');
        $this->db->where("srd.sale_return_id", $id);
        $this->db->where("srd.del_status", 'Live');
        $this->db->order_by('srd.id', 'ASC');
        $result = $this->db->get()->result();
        return $result;
    }

    /**
     * reminder List
     * @access public
     * @return object
     * @param int
     */
    public function reminderList($company_id) {
        $data = $this->db->query("SELECT * FROM tbl_reminders 
        WHERE del_status = 'Live' AND company_id = $company_id
          ORDER BY id DESC")->result();
        return $data;
    }

    /**
     * update Notification Information
     * @access public
     * @return object
     * @param int
     */
    public function reminderCalendar($company_id) {
        $this->db->select("*");
        $this->db->from('tbl_reminders');
        $this->db->where("company_id", $company_id);
        $this->db->where("reminder_status", 1);
		$this->db->where('del_status', "Live");
        $data = $this->db->get()->result();
        return $data;
    }


    /**
     * getSupplierPayment
     * @access public
     * @param int
     * @param string
     * @return object
     * Added By Azhar
     */
    public function getSupplierPayment($start_date = '', $end_date = '', $supplier_id ='', $outlet_id = '') {
        $company_id = $this->session->userdata('company_id');
        $this->db->select("s.*, u.full_name as added_by");
		$this->db->from('tbl_supplier_payments s');
		$this->db->join("tbl_users u", "u.id = s.user_id", "left");
        if ($start_date != '' && $end_date != '') {
            $this->db->where('s.date >=', $start_date);
            $this->db->where('s.date <=', $end_date);
        }
        if ($start_date != '' && $end_date == '') {
            $this->db->where('s.date', $start_date);
        }
        if ($start_date == '' && $end_date != '') {
            $this->db->where('s.date', $end_date);
        }
        if($outlet_id != ''){
            $this->db->where("s.outlet_id", $outlet_id);
        }
        if($supplier_id != ''){
            $this->db->where("s.supplier_id", $supplier_id);
        }
		$this->db->where("s.company_id", $company_id);
		$this->db->where("s.del_status", 'Live');
		$this->db->order_by("s.id", 'DESC');
		$result = $this->db->get(); 
        if($result != false){  
            return $result->result();
        }else{
            return false;
        }
    }



    /**
     * getCustomerDueReceive
     * @access public
     * @param int
     * @param string
     * @return object
     * Added By Azhar
     */
    public function getCustomerDueReceive($start_date = '', $end_date = '', $customer_id ='', $outlet_id = '') {
        $company_id = $this->session->userdata('company_id');
        $this->db->select("c.*, u.full_name as added_by");
		$this->db->from('tbl_customer_due_receives c');
		$this->db->join("tbl_users u", "u.id = c.user_id", "left");
        if ($start_date != '' && $end_date != '') {
            $this->db->where('c.date >=', $start_date);
            $this->db->where('c.date <=', $end_date);
        }
        if ($start_date != '' && $end_date == '') {
            $this->db->where('c.date', $start_date);
        }
        if ($start_date == '' && $end_date != '') {
            $this->db->where('c.date', $end_date);
        }
        if($outlet_id != ''){
            $this->db->where("c.outlet_id", $outlet_id);
        }
        if($customer_id != ''){
            $this->db->where("c.customer_id", $customer_id);
        }
		$this->db->where("c.company_id", $company_id);
		$this->db->where("c.del_status", 'Live');
		$this->db->order_by("c.id", 'DESC');
		$result = $this->db->get(); 
        if($result != false){  
            return $result->result();
        }else{
            return false;
        }
    }

    

    /**
     * generateServiceCenterCode
     * @access public
     * @param no
     * @return string
     */
    public function generateServiceCenterCode() {
        $company_id = $this->session->userdata('company_id');
        $count = $this->db->query("SELECT id as count
            FROM tbl_service_centers WHERE company_id = $company_id ORDER BY id DESC")->row('count');
        $code = str_pad($count + 1, 6, '0', STR_PAD_LEFT);
        return $code;
    }



}

?>
