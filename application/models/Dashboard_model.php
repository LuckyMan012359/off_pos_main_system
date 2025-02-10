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
  # This is Accounting_model Model
  ###########################################################
 */
class Dashboard_model extends CI_Model {
 

    /**
     * top_ten_food_menu
     * @access public
     * @param string
     * @param string
     * @return object
     */
    public function top_ten_food_menu($start_date='', $end_date='') {
        $outlet_id = $this->session->userdata('outlet_id');
        $company_id = $this->session->userdata('company_id');
        $this->db->select('sum(sd.qty) as totalQty, sd.food_menu_id, s.sale_date, i.type, i.name as menu_name, ii.name as parent_name');
        $this->db->from('tbl_sales_details sd');
        $this->db->join('tbl_sales s', 's.id = sd.sales_id', 'left');
        $this->db->join('tbl_items i', 'i.id = sd.food_menu_id', 'left');
        $this->db->join('tbl_items ii', 'i.parent_id = ii.id', 'left');
        $this->db->where('s.sale_date >=', $start_date);
        $this->db->where('s.sale_date <=', $end_date); 
        $this->db->where('sd.outlet_id', $outlet_id);
        $this->db->where('sd.company_id', $company_id);
        $this->db->where('sd.del_status', 'Live');
        $this->db->group_by('sd.food_menu_id');
        $this->db->order_by('totalQty', 'desc'); // Order by totalQty in descending order
        $this->db->limit(10); // Limit to 10 best-selling items
        return $this->db->get()->result();
    }

    /**
     * top_ten_customer
     * @access public
     * @param string
     * @param string
     * @return object
     */
    public function top_ten_customer($start_date='', $end_date='') {
        $outlet_id = $this->session->userdata('outlet_id'); 
        $company_id = $this->session->userdata('company_id');
        $this->db->select('sum(s.total_payable) as total_payable, s.customer_id, c.name, c.phone as customer_phone, s.sale_date');
        $this->db->from('tbl_sales s');
        $this->db->join('tbl_customers c', 's.customer_id = c.id', 'left');
        $this->db->where('s.sale_date>=', $start_date);
        $this->db->where('s.sale_date <=', $end_date); 
        $this->db->where('s.outlet_id', $outlet_id);
        $this->db->where('s.company_id', $company_id);
        $this->db->where('s.del_status', 'Live');
        $this->db->group_by('customer_id');
        $this->db->order_by('total_payable', 'desc');
        $this->db->limit(10);
        return $this->db->get()->result();
    }


    /**
     * purchase_sum
     * @access public
     * @param string
     * @param string
     * @return object
     */
    public function purchase_sum($first_day_this_month='', $last_day_this_month='') {
        $outlet_id = $this->session->userdata('outlet_id');
        $this->db->select('sum(paid) as purchase_sum');
        $this->db->from('tbl_purchase');  
        $this->db->where('tbl_purchase.date>=', $first_day_this_month);
        $this->db->where('tbl_purchase.date <=', $last_day_this_month);         
        $this->db->where('tbl_purchase.outlet_id', $outlet_id);
        $this->db->where('tbl_purchase.del_status', 'Live'); 
        $result = $this->db->get()->row();
        if (empty($result->purchase_sum)) {
            $result->purchase_sum = 0;
        }
        return $result;
    }

    /**
     * sale_sum
     * @access public
     * @param string
     * @param string
     * @return object
     */
    public function sale_sum($first_day_this_month, $last_day_this_month) {
        $outlet_id = $this->session->userdata('outlet_id');
        $this->db->select('sum(paid_amount) as sale_sum');
        $this->db->from('tbl_sales');  
        $this->db->where('tbl_sales.sale_date>=', $first_day_this_month);
        $this->db->where('tbl_sales.sale_date <=', $last_day_this_month);         
        $this->db->where('tbl_sales.outlet_id', $outlet_id);
        $this->db->where('tbl_sales.del_status', 'Live'); 
        $result = $this->db->get()->row();
        if (empty($result->sale_sum)) {
            $result->sale_sum = 0;
        }
        return $result;
    }

    /**
     * waste_sum
     * @access public
     * @param string
     * @param string
     * @return object
     */
    public function waste_sum($first_day_this_month, $last_day_this_month) {
        $outlet_id = $this->session->userdata('outlet_id');
        $this->db->select('sum(total_loss) as waste_sum');
        $this->db->from('tbl_damages');
        $this->db->where('tbl_damages.date>=', $first_day_this_month);
        $this->db->where('tbl_damages.date <=', $last_day_this_month);
        $this->db->where('tbl_damages.outlet_id', $outlet_id);
        $this->db->where('tbl_damages.del_status', 'Live');
        $result = $this->db->get()->row(); 
        if (empty($result->waste_sum)) {
            $result->waste_sum = 0;
        }
        return $result;
    }

    /**
     * expense_sum
     * @access public
     * @param string
     * @param string
     * @return object
     */
    public function expense_sum($first_day_this_month, $last_day_this_month) {
        $outlet_id = $this->session->userdata('outlet_id');
        $this->db->select('sum(amount) as expense_sum');
        $this->db->from('tbl_expenses');  
        $this->db->where('tbl_expenses.date>=', $first_day_this_month);
        $this->db->where('tbl_expenses.date <=', $last_day_this_month); 
        $this->db->where('tbl_expenses.outlet_id', $outlet_id);
        $this->db->where('tbl_expenses.del_status', 'Live');  
        $result = $this->db->get()->row();
        if (empty($result->expense_sum)) {
            $result->expense_sum = 0;
        }
        return $result;
    }

    /**
     * income_sum
     * @access public
     * @param string
     * @param string
     * @return object
     */
    public function income_sum($first_day_this_month, $last_day_this_month) {
        $outlet_id = $this->session->userdata('outlet_id');
        $this->db->select('sum(amount) as income_sum');
        $this->db->from('tbl_incomes');  
        $this->db->where('tbl_incomes.date>=', $first_day_this_month);
        $this->db->where('tbl_incomes.date <=', $last_day_this_month); 
        $this->db->where('tbl_incomes.outlet_id', $outlet_id);
        $this->db->where('tbl_incomes.del_status', 'Live');  
        $result = $this->db->get()->row();
        if (empty($result->income_sum)) {
            $result->income_sum = 0;
        }
        return $result;
    }

    /**
     * customer_due_receive_sum
     * @access public
     * @param string
     * @param string
     * @return object
     */
    public function customer_due_receive_sum($first_day_this_month='', $last_day_this_month='') {
        $outlet_id = $this->session->userdata('outlet_id');
        $this->db->select('sum(amount) as customer_due_receive_sum');
        $this->db->from('tbl_customer_due_receives');  
        $this->db->where('tbl_customer_due_receives.added_date>=', $first_day_this_month);
        $this->db->where('tbl_customer_due_receives.added_date <=', $last_day_this_month);
        $this->db->where('tbl_customer_due_receives.outlet_id', $outlet_id);
        $this->db->where('tbl_customer_due_receives.del_status', 'Live'); 
        $result = $this->db->get()->row();
        if (empty($result->customer_due_receive_sum)) {
            $result->customer_due_receive_sum = 0;
        }
        return $result;
    } 

    /**
     * supplier_due_payment_sum
     * @access public
     * @param string
     * @param string
     * @return object
     */
    public function supplier_due_payment_sum($first_day_this_month='', $last_day_this_month='') {
        $outlet_id = $this->session->userdata('outlet_id');
        $this->db->select('sum(amount) as supplier_due_payment_sum');
        $this->db->from('tbl_supplier_payments');  
        $this->db->where('tbl_supplier_payments.date>=', $first_day_this_month);
        $this->db->where('tbl_supplier_payments.date <=', $last_day_this_month);         
        $this->db->where('tbl_supplier_payments.outlet_id', $outlet_id);
        $this->db->where('tbl_supplier_payments.del_status', 'Live'); 
        $result = $this->db->get()->row();
        if (empty($result->supplier_due_payment_sum)) {
            $result->supplier_due_payment_sum = 0;
        }
        return $result;
    }


    /**
     * getDownPayment
     * @access public
     * @param string
     * @param string
     * @return object
     */
    public function getDownPayment($start_date='', $end_date='') {
        $outlet_id = $this->session->userdata('outlet_id');
        $query1 = $this->db->query("select sum(down_payment) as total_amount from tbl_installments WHERE date BETWEEN '$start_date' AND '$end_date' AND outlet_id='$outlet_id' AND del_status='Live'  group by year(date), month(date)");
        $total_1 = 0;
        if($query1->row()){
            $total_1 = $query1->row()->total_amount;
        }
        return $total_1;
    }


    /**
     * getPaidAmount
     * @access public
     * @param string
     * @param string
     * @return object
     */
    public function getPaidAmount($start_date='', $end_date='') {
        $outlet_id = $this->session->userdata('outlet_id');
        $query2 = $this->db->query("select sum(paid_amount) as total_amount from tbl_installment_items WHERE DATE(added_date) BETWEEN '$start_date' AND '$end_date' AND del_status='Live'  AND paid_status='Paid' AND outlet_id='$outlet_id' group by year(added_date), month(added_date)");
        $total_2 = 0;
        if($query2->row()){
            $total_2 = $query2->row()->total_amount;
        }
        return $total_2;
    }


    /**
     * comparison_sale_report
     * @access public
     * @param string
     * @param string
     * @return object
     */
    public function comparison_sale_report($start_date, $end_date) {
        $outlet_id = $this->session->userdata('outlet_id');
        $query = $this->db->query("select year(sale_date) as year, month(sale_date) as month, sum(total_payable) as total_amount from tbl_sales WHERE `sale_date` BETWEEN '$start_date' AND '$end_date' AND del_status='Live' AND outlet_id='$outlet_id' group by year(sale_date), month(sale_date)");
        return $query->row();
    }


    /**
     * setDefaultTimezone
     * @access public
     * @param no
     * @return object
     */
    public function setDefaultTimezone() {
        $this->db->select("zone_name");
        $this->db->from('tbl_companies');
        $this->db->order_by('id', 'DESC');
        $this->db->where('company_id', $this->session->userdata('company_id'));
        $zoneName = $this->db->get()->row();
        if ($zoneName)
            date_default_timezone_set($zoneName->time_zone);
    }


    /**
     * serviceSaleTotalAmount
     * @access public
     * @param string
     * @param string
     * @return object
     */
    public function serviceSaleTotalAmount($startMonth,$endMonth) {
        $outlet_id = $this->session->userdata('outlet_id');
        $this->db->select('sum(paid_amount) as sale_sum');
        $this->db->from('tbl_sales_details');
        $this->db->join('tbl_sales', 'tbl_sales.id = tbl_sales_details.sales_id', 'left');
        $this->db->join('tbl_items', 'tbl_items.id = tbl_sales_details.food_menu_id', 'left');
        if ($startMonth != '' && $endMonth != '') {
            $this->db->where('sale_date>=', $startMonth);
            $this->db->where('sale_date <=', $endMonth);
        }
        if ($startMonth != '' && $endMonth == '') {
            $this->db->where('sale_date', $startMonth);
        }
        if ($startMonth == '' && $endMonth != '') {
            $this->db->where('sale_date', $endMonth);
        }
        $this->db->where('tbl_sales_details.outlet_id', $outlet_id);
        $this->db->where('tbl_sales_details.del_status', 'Live');
        $this->db->where('tbl_items.type', '2');
        $this->db->order_by('code', 'ASC');
        $this->db->group_by('tbl_sales_details.food_menu_id');
        $result = $this->db->get()->row();
        return $result;
    }


    /**
     * productSaleTotalAmount
     * @access public
     * @param string
     * @param string
     * @return object
     */
    public function productSaleTotalAmount($startMonth,$endMonth) {
        $outlet_id = $this->session->userdata('outlet_id');
        $this->db->select('sum(paid_amount) as sale_sum');
        $this->db->from('tbl_sales_details');
        $this->db->join('tbl_sales', 'tbl_sales.id = tbl_sales_details.sales_id', 'left');
        $this->db->join('tbl_items', 'tbl_items.id = tbl_sales_details.food_menu_id', 'left');
        if ($startMonth != '' && $endMonth != '') {
            $this->db->where('sale_date>=', $startMonth);
            $this->db->where('sale_date <=', $endMonth);
        }
        if ($startMonth != '' && $endMonth == '') {
            $this->db->where('sale_date', $startMonth);
        }
        if ($startMonth == '' && $endMonth != '') {
            $this->db->where('sale_date', $endMonth);
        }
        $this->db->where('tbl_sales_details.outlet_id', $outlet_id);
        $this->db->where('tbl_sales_details.del_status', 'Live');
        $this->db->where('tbl_items.type', '1');
        $this->db->order_by('code', 'ASC');
        $this->db->group_by('tbl_sales_details.food_menu_id');
        $result = $this->db->get()->row();
        if($result){
            return $result->sale_sum;
        }else{
            return 0;
        }
    }
} 
