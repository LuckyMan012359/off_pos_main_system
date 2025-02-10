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
  # This is Sale_model Model
  ###########################################################
 */
class Sale_model extends CI_Model {

  /**
   * getSaleList
   * @access public
   * @param int
   * @return object
   */
  public function getSaleList($outlet_id) {
      $result = $this->db->query("SELECT s.*,u.full_name,c.name as customer_name
        FROM tbl_sales s
        INNER JOIN tbl_customers c ON(s.customer_id=c.id)
        LEFT JOIN tbl_users u ON(s.user_id=u.id)
        WHERE s.del_status = 'Live' AND s.outlet_id=$outlet_id ORDER BY s.id DESC")->result();
      return $result;
  }

   /**
   * getFreeItemBySaleDetailsId
   * @access public
   * @param int
   * @return object
   */
  public function getFreeItemBySaleDetailsId($id){
    $this->db->select('*');
    $this->db->from('tbl_holds_details');
    $this->db->where('promo_parent_id', $id);
    $this->db->where('del_status', "Live");
    $result = $this->db->get()->result();
    if(isset($result) && $result){
        return $result;
    }else{
        return false;
    }
  }


  /**
   * todaysSummary
   * @access public
   * @param no
   * @return object
   */
  public function todaysSummary(){
    $todayDate = date('Y-m-d');
    $company_id = $this->session->userdata('company_id');
    $todaysPurchase = $this->db->query("SELECT SUM(paid) as paid_purchase FROM tbl_purchase WHERE `date` = ? AND `company_id` = ? AND `del_status`='Live'", array($todayDate, $company_id))->row();
    $todaysSales = $this->db->query("SELECT SUM(paid_amount) as paid_sale FROM tbl_sales WHERE `sale_date`= ? AND `company_id` = ? AND `del_status`='Live'", array($todayDate, $company_id))->row();
    $todaysExpense = $this->db->query("SELECT SUM(amount) as expense  FROM tbl_expenses WHERE `date`= ? AND `company_id` = ? AND `del_status`='Live'", array($todayDate, $company_id))->row();
    $todaysSupplierPayment = $this->db->query("SELECT SUM(amount) as supplier_payment FROM tbl_supplier_payments WHERE `date` = ? AND `company_id` = ? AND `del_status`='Live'", array($todayDate, $company_id))->row();
    $todaysCustomerReceive = $this->db->query("SELECT SUM(amount) as due_receive FROM tbl_customer_due_receives WHERE `date` = ? AND `company_id` = ? AND `del_status`='Live'", array($todayDate, $company_id))->row();
    $todaysPurchaseReturn = $this->db->query("SELECT SUM(total_return_amount) as purchase_return FROM tbl_purchase_return WHERE `date` = ? AND `company_id` = ? AND `del_status`='Live'", array($todayDate, $company_id))->row();
    $todaysSaleReturn = $this->db->query("SELECT SUM(total_return_amount) as sale_return FROM tbl_sale_return WHERE `date` = ? AND `company_id` = ? AND `del_status`='Live'", array($todayDate, $company_id))->row();
    $todaysDamage = $this->db->query("SELECT SUM(total_loss) as damage FROM tbl_damages WHERE `date` = ? AND `company_id` = ? AND `del_status`='Live'", array($todayDate, $company_id))->row();
    $todaysDownpayment = $this->db->query("SELECT SUM(down_payment) as down_payment FROM tbl_installments WHERE `date`= ? AND `company_id` = ? AND `del_status`='Live'",  array($todayDate, $company_id))->row();
    $todaysInstallmentPaid = $this->db->query("SELECT SUM(paid_amount) as paid_amount FROM tbl_installment_items WHERE `paid_date`= ? AND `company_id` = ? AND del_status='Live'",  array($todayDate, $company_id))->row();
    $result = [];
    $result['todaysPurchase'] = $todaysPurchase->paid_purchase;
    $result['todaysSales'] = $todaysSales->paid_sale;
    $result['todaysExpense'] = $todaysExpense->expense;
    $result['todaysSupplierPayment'] = $todaysSupplierPayment->supplier_payment;
    $result['todaysCustomerReceive'] = $todaysCustomerReceive->due_receive;
    $result['todaysPurchaseReturn'] = $todaysPurchaseReturn->purchase_return;
    $result['todaysSaleReturn'] = $todaysSaleReturn->sale_return;
    $result['todaysDamage'] = $todaysDamage->damage;
    $result['todaysDownpayment'] = $todaysDownpayment->down_payment;
    $result['todaysInstallmentPaid'] = $todaysInstallmentPaid->paid_amount;
    return $result;
  }


  /**
   * getItemCategories
   * @access public
   * @param int
   * @return object
   */
  public function getItemCategories($company_id) {
      $result = $this->db->query("SELECT * 
        FROM tbl_item_categories 
        WHERE company_id=$company_id AND del_status = 'Live'  
        ORDER BY name")->result();
      return $result;
  }

  /**
   * getItemCategoriesBySorted
   * @access public
   * @param int
   * @return object
   */
  public function getItemCategoriesBySorted($company_id) {
      $result = $this->db->query("SELECT * 
        FROM tbl_item_categories 
        WHERE company_id=$company_id AND del_status = 'Live'  
        ORDER BY sort_id")->result();
      return $result;
  }


   /**
   * getItemBrand
   * @access public
   * @param int
   * @return object
   */
  public function getItemBrand($company_id) {
      $result = $this->db->query("SELECT * 
        FROM tbl_brands 
        WHERE company_id=$company_id AND del_status = 'Live'  
        ORDER BY name")->result();
      return $result;
  }

  /**
   * getAllItemCategories
   * @access public
   * @param no
   * @return object
   */
  public function getAllItemCategories(){
    $this->db->select("*");
    $this->db->from("tbl_item_categories");
    $this->db->where("del_status", 'Live');
    $this->db->order_by('name', 'ASC');
    return $this->db->get()->result();
  }

  /**
   * getSaleBySaleId
   * @access public
   * @param int
   * @return object
   */
  public function getSaleBySaleId($sales_id){
    $this->db->select("s.*,s.id as sales_id,c.name as customer_name,c.gst_number,c.phone as c_phone,c.email as c_email,c.address as c_address,u.full_name as user_name, d.partner_name as partner_name, s.due_date as due_date"); #outlet invoice footer is removed we use companies invoice footer
    $this->db->from('tbl_sales s');
    $this->db->join('tbl_customers c', 'c.id = s.customer_id', 'left');
    $this->db->join('tbl_users u', 'u.id = s.user_id', 'left');
    $this->db->join('tbl_outlets o', 'o.id = s.outlet_id', 'left');
    $this->db->join('tbl_delivery_partners d', 'd.id = s.delivery_partner_id', 'left');
    $this->db->where("s.id", $sales_id);
    $this->db->order_by('s.id', 'ASC');
    return $this->db->get()->row();
  }


   /**
   * getSaleBySaleCode
   * @access public
   * @param string
   * @return object
   */
  public function getSaleBySaleCode($code){
    $this->db->select("tbl_sales.*,tbl_sales.id as sales_id,tbl_customers.name as customer_name,tbl_customers.gst_number,tbl_customers.phone as c_phone,tbl_customers.email as c_email,tbl_customers.address as c_address,tbl_users.full_name as user_name"); #outlet invoice footer is removed we use companies invoice footer
    $this->db->from('tbl_sales');
    $this->db->join('tbl_customers', 'tbl_customers.id = tbl_sales.customer_id', 'left');
    $this->db->join('tbl_users', 'tbl_users.id = tbl_sales.user_id', 'left');
    $this->db->join('tbl_outlets', 'tbl_outlets.id = tbl_sales.outlet_id', 'left');
    $this->db->where("tbl_sales.random_code", $code);
    $this->db->order_by('tbl_sales.id', 'ASC');
    return $this->db->get()->result();
  }
 
   /**
   * getHoldsByOutletAndUserId
   * @access public
   * @param int
   * @param int
   * @return object
   */
  public function getHoldsByOutletAndUserId($outlet_id,$user_id){
    $this->db->select("tbl_holds.*,tbl_customers.name as customer_name,tbl_customers.phone as customer_phone");
    $this->db->from('tbl_holds');
    $this->db->join('tbl_customers', 'tbl_customers.id = tbl_holds.customer_id', 'left');
    $this->db->where("tbl_holds.outlet_id", $outlet_id);
    $this->db->where("tbl_holds.user_id", $user_id);
    $this->db->where("tbl_holds.del_status", "Live");
    $this->db->order_by('tbl_holds.id', 'ASC');
    return $this->db->get()->result();
  }
  /**
   * getLastTenSalesByOutletAndUserId
   * @access public
   * @param int
   * @return object
   */
  public function getLastTenSalesByOutletAndUserId($outlet_id){
    $user_id = $this->session->userdata('user_id');
    $current_date = date("Y-m-d",strtotime('today'));
    $date_c = $_GET['date_c'];
    $customer_c = $_GET['customer_c'];
    $invoice_c = $_GET['invoice_c'];
    $status = $_GET['status'];
    $this->db->select("tbl_sales.*,tbl_customers.name as customer_name");
    $this->db->from('tbl_sales');
    $this->db->join('tbl_customers', 'tbl_customers.id = tbl_sales.customer_id', 'left');
    $this->db->where("tbl_sales.outlet_id", $outlet_id);
    if($this->session->userdata('role') != '1'){
      $this->db->where("tbl_sales.user_id", $user_id);
    }
    if($date_c!=''){
      $this->db->where("tbl_sales.sale_date", $date_c);
    }
    if($invoice_c!=''){
      $this->db->like("tbl_sales.sale_no", $invoice_c);
    }
    if($customer_c !=''){
      $this->db->where("tbl_sales.customer_id", $customer_c);
    }
    if($status=="default"){
      $this->db->where("tbl_sales.sale_date", $current_date);
    }
    $this->db->where("tbl_sales.del_status", "Live");
    $this->db->order_by('tbl_sales.id', 'DESC');
    return $this->db->get()->result();
  }
  /**
   * getAllItemsFromSalesDetailBySalesId
   * @access public
   * @param int
   * @return object
   */
  public function getAllItemsFromSalesDetailBySalesId($sales_id){
    $this->db->select("s.sale_date,sd.*,sd.id as sales_details_id,i.code as code,i.warranty,i.warranty_date,i.guarantee,i.guarantee_date,b.name as brand_name, i.name as item_name, i.alternative_name, i.code, i.type as item_type, i.photo");
    $this->db->from('tbl_sales_details sd');
    $this->db->join('tbl_sales s', 's.id = sd.sales_id', 'left');
    $this->db->join('tbl_items i', 'i.id = sd.food_menu_id', 'left');
    $this->db->join('tbl_brands b', 'b.id = i.brand_id', 'left');
    $this->db->where("sd.sales_id", $sales_id);
    $this->db->order_by('sd.id', 'ASC');
    return $this->db->get()->result();
  }

 


   /**
   * saleItemDetails
   * @access public
   * @param int
   * @param int
   * @return object
   */
  public function saleItemDetails($item_id,$sale_id){
    $this->db->select("ii.name as parent_name,sd.qty, sd.menu_price_with_discount, s.id as sale_id, i.id as item_id, i.name, u.unit_name, b.name as brand_name");
    $this->db->from('tbl_sales_details sd');
    $this->db->join('tbl_items i', 'i.id = sd.food_menu_id', 'left');
    $this->db->join('tbl_items ii', 'i.parent_id = ii.id', 'left');
    $this->db->join("tbl_units u", 'u.id = i.sale_unit_id', 'left');
    $this->db->join('tbl_sales s', 's.id = sd.sales_id', 'left');
    $this->db->join('tbl_brands b', 'b.id = i.brand_id', 'left');
    $this->db->where("sd.food_menu_id", $item_id);
    $this->db->where('i.id', $item_id);
    $this->db->where("sd.sales_id", $sale_id);
    $this->db->where("sd.del_status", "Live");
    return $this->db->get()->row();
  }

  /**
   * getNumberOfHoldsByUserAndOutletId
   * @access public
   * @param int
   * @param int
   * @return object
   */
  public function getNumberOfHoldsByUserAndOutletId($outlet_id,$user_id)
  {
    $this->db->select('id');
    $this->db->from('tbl_holds');
    $this->db->where("outlet_id", $outlet_id);
    $this->db->where("user_id", $user_id);
    return $this->db->get()->num_rows();
  }

  /**
   * get_hold_info_by_hold_id
   * @access public
   * @param int
   * @return object
   */
  public function get_hold_info_by_hold_id($hold_id)
  {
    $this->db->select("h.*,c.name as customer_name, dp.partner_name as partner_name");
    $this->db->from('tbl_holds h');
    $this->db->join('tbl_customers c', 'c.id = h.customer_id', 'left');
    $this->db->join('tbl_delivery_partners dp', 'dp.id = h.delivery_partner_id', 'left');
    $this->db->where("h.id", $hold_id);
    $this->db->order_by('h.id', 'ASC');
    return $this->db->get()->result();
  }
  /**
   * getAllItemsFromHoldsDetailByHoldsId
   * @access public
   * @param int
   * @return object
   */
  public function getAllItemsFromHoldsDetailByHoldsId($hold_id)
  {
    $this->db->select("hd.*,hd.id as holds_details_id,u.unit_name, i.type as item_type, i.name as item_name, i.code, ii.name as parent_name, ii.id as parent_id");
    $this->db->from('tbl_holds_details hd');
    $this->db->join('tbl_items i', 'i.id = hd.food_menu_id', 'left');
    $this->db->join('tbl_items ii', 'i.parent_id = ii.id', 'left');
    $this->db->join('tbl_units u', 'u.id = i.sale_unit_id', 'left');
    $this->db->where("hd.holds_id", $hold_id);
    $this->db->order_by('hd.id', 'ASC');
    return $this->db->get()->result();
  }
  /**
   * getAllHoldComboItems
   * @access public
   * @param int
   * @return object
   */
  public function getAllHoldComboItems($hold_id)
  {
    $this->db->select('i.name as item_name, i.code, cs.combo_item_id,cs.show_in_invoice,cs.combo_item_seller_id,cs.combo_item_type,cs.combo_item_qty, cs.combo_item_price, u.unit_name');
    $this->db->from('tbl_hold_combo_items cs');
    $this->db->join('tbl_holds_details sd', 'sd.id = cs.combo_sale_item_id', 'left');
    $this->db->join('tbl_items i', 'i.id = cs.combo_item_id', 'left');
    $this->db->join('tbl_units u', 'u.id = i.sale_unit_id', 'left');
    $this->db->where("cs.combo_sale_item_id", $hold_id);
    $this->db->where("cs.del_status", 'Live');
    $this->db->group_by("cs.combo_item_id");
    return $this->db->get()->result();
  }
   /**
   * getCustomerInfoBySaleId
   * @access public
   * @param int
   * @return object
   */
  public function getCustomerInfoBySaleId($sale_id)
  {
    $this->db->select("tbl_customers.*,tbl_sales.sale_date,tbl_sales.order_time");
    $this->db->from('tbl_sales');
    $this->db->join('tbl_customers', 'tbl_customers.id = tbl_sales.customer_id', 'left');
    $this->db->where("tbl_sales.id", $sale_id);
    return $this->db->get()->row();
  }
  
  /**
   * getCustomerInfoById
   * @access public
   * @param int
   * @return object
   */
  public function getCustomerInfoById($customer_id)
  {
    $this->db->select("*");
    $this->db->from('tbl_customers');
    $this->db->where("id", $customer_id);
    $this->db->order_by('id', 'ASC');
    return $this->db->get()->row();
  }
  /**
   * getAllPaymentMethods
   * @access public
   * @param no
   * @return object
   */
  public function getAllPaymentMethods(){
    $this->db->select('*');
    $this->db->from('tbl_payment_methods');
    $this->db->where("del_status", 'Live');
    return $this->db->get()->result();
  }
   /**
   * getAllPaymentMethodsForPOS
   * @access public
   * @param no
   * @return object
   */
  public function getAllPaymentMethodsForPOS(){
    $company_id = $this->session->userdata('company_id');
    $this->db->select('*');
    $this->db->from('tbl_payment_methods');
    $this->db->where("status", 'Enable');
    $this->db->where("company_id", $company_id);
    $this->db->where("del_status", 'Live');
    $this->db->order_by("sort_id");
    return $this->db->get()->result();
  }

   /**
   * getSummationOfPaidPurchase
   * @access public
   * @param int
   * @param int
   * @param string
   * @return object
   */
  public function getSummationOfPaidPurchase($user_id, $outlet_id, $date)
  {
    $this->db->select("SUM(paid) as purchase_paid");
    $this->db->from('tbl_purchase');
    $this->db->where("user_id", $user_id);
    $this->db->where("outlet_id", $outlet_id);
    $this->db->where("date", $date);
    return $this->db->get()->row();
  }
  
  /**
   * getSummationOfSupplierPayment
   * @access public
   * @param int
   * @param int
   * @param string
   * @return object
   */
  public function getSummationOfSupplierPayment($user_id, $outlet_id, $date)
  {
    $this->db->select("SUM(amount) as payment_amount");
    $this->db->from('tbl_supplier_payments');
    $this->db->where("user_id", $user_id);
    $this->db->where("outlet_id", $outlet_id);
    $this->db->where("date", $date);
    return $this->db->get()->row();
  }

  /**
   * getSummationOfCustomerDueReceive
   * @access public
   * @param int
   * @param int
   * @param string
   * @return object
   */
  public function getSummationOfCustomerDueReceive($user_id, $outlet_id, $date)
  {
    $this->db->select("SUM(amount) as receive_amount");
    $this->db->from('tbl_customer_due_receives');
    $this->db->where("user_id", $user_id);
    $this->db->where("outlet_id", $outlet_id);
    $this->db->where("added_date>=", $date);
    $this->db->where("added_date<=", date('Y-m-d H:i:s'));
    return $this->db->get()->row();
  }


  

  /**
   * getSalePaidSum
   * @access public
   * @param int
   * @param int
   * @param string
   * @return object
   */
  public function getSalePaidSum($user_id, $outlet_id, $date)
  {
    $this->db->select("SUM(paid_amount) as amount");
    $this->db->from('tbl_sales');
    $this->db->where("user_id", $user_id);
    $this->db->where("outlet_id", $outlet_id);
    $this->db->where("date_time>=", $date);
    $this->db->where("date_time<=", date('Y-m-d H:i:s'));
    return $this->db->get()->row();
  }


  /**
   * getSaleDueSum
   * @access public
   * @param int
   * @param int
   * @param string
   * @return object
   */
  public function getSaleDueSum($user_id, $outlet_id, $date)
  {
    $this->db->select("SUM(due_amount) as amount");
    $this->db->from('tbl_sales');
    $this->db->where("user_id", $user_id);
    $this->db->where("outlet_id", $outlet_id);
    $this->db->where("date_time>=", $date);
    $this->db->where("date_time<=", date('Y-m-d H:i:s'));
    return $this->db->get()->row();
  }


  /**
   * getPurchaseAmountSum
   * @access public
   * @param int
   * @param int
   * @param string
   * @return object
   */
  public function getPurchaseAmountSum($user_id, $outlet_id, $date)
  {
    $this->db->select("SUM(paid) as amount");
    $this->db->from('tbl_purchase');
    $this->db->where("user_id", $user_id);
    $this->db->where("outlet_id", $outlet_id);
    $this->db->where("added_date>=", $date);
    $this->db->where("added_date<=", date('Y-m-d H:i:s'));
    return $this->db->get()->row();
  }

  /**
   * getPurchaseReturnAmountSum
   * @access public
   * @param int
   * @param int
   * @param string
   * @return object
   */
  public function getPurchaseReturnAmountSum($user_id, $outlet_id, $date)
  {
    $this->db->select("SUM(total_return_amount) as amount");
    $this->db->from('tbl_purchase_return');
    $this->db->where("user_id", $user_id);
    $this->db->where("outlet_id", $outlet_id);
    $this->db->where("added_date>=", $date);
    $this->db->where("added_date<=", date('Y-m-d H:i:s'));
    return $this->db->get()->row();
  }

  /**
   * getSaleReturnAmountSum
   * @access public
   * @param int
   * @param int
   * @param string
   * @return object
   */
  public function getSaleReturnAmountSum($user_id, $outlet_id, $date)
  {
    $this->db->select("SUM(total_return_amount) as amount");
    $this->db->from('tbl_sale_return');
    $this->db->where("user_id", $user_id);
    $this->db->where("outlet_id", $outlet_id);
    $this->db->where("added_date>=", $date);
    $this->db->where("added_date<=", date('Y-m-d H:i:s'));
    return $this->db->get()->row();
  }


   /**
   * getExpenseAmountSum1
   * @access public
   * @param int
   * @param int
   * @param string
   * @return object
   */
  public function getExpenseAmountSum1($user_id, $outlet_id, $date)
  {
    $this->db->select("SUM(amount) as amount");
    $this->db->from('tbl_expenses');
    $this->db->where("user_id", $user_id);
    $this->db->where("outlet_id", $outlet_id);
    $this->db->where("added_date>=", $date);
    $this->db->where("added_date<=", date('Y-m-d H:i:s'));
    return $this->db->get()->row();
  }

  
  


  /**
   * getSaleInCashSum
   * @access public
   * @param int
   * @param int
   * @param string
   * @return object
   */
  public function getSaleInCashSum($user_id, $outlet_id, $date)
  {
    $this->db->select("SUM(paid_amount) as amount");
    $this->db->from('tbl_sales');
    $this->db->where("user_id", $user_id);
    $this->db->where("outlet_id", $outlet_id);
    $this->db->where("date_time>=", $date);
    $this->db->where("date_time<=", date('Y-m-d H:i:s'));
    $this->db->where("payment_method_id", 3);
    return $this->db->get()->row();
  }

   /**
   * getDownPaymentSum
   * @access public
   * @param int
   * @param int
   * @param string
   * @return object
   */
  public function getDownPaymentSum($user_id, $outlet_id, $date)
  {
    $this->db->select("SUM(down_payment) as amount");
    $this->db->from('tbl_installments');
    $this->db->where("user_id", $user_id);
    $this->db->where("outlet_id", $outlet_id);
    $this->db->where("added_date>=", $date);
    $this->db->where("added_date<=", date('Y-m-d H:i:s'));
    return $this->db->get()->row();
  }


  /**
   * getInstallmentPaidAmountSum
   * @access public
   * @param int
   * @param int
   * @param string
   * @return object
   */
  public function getInstallmentPaidAmountSum($user_id, $outlet_id, $date)
  {
    $this->db->select("SUM(paid_amount) as amount");
    $this->db->from('tbl_installment_items');
    $this->db->where("user_id", $user_id);
    $this->db->where("outlet_id", $outlet_id);
    $this->db->where("paid_status", "Paid");
    $this->db->where("added_date>=", $date);
    $this->db->where("added_date<=", date('Y-m-d H:i:s'));
    return $this->db->get()->row();
  }


   /**
   * getSaleInPaypalSum
   * @access public
   * @param int
   * @param int
   * @param string
   * @return object
   */
  public function getSaleInPaypalSum($user_id, $outlet_id, $date)
  {
    $this->db->select("SUM(paid_amount) as amount");
    $this->db->from('tbl_sales');
    $this->db->where("user_id", $user_id);
    $this->db->where("outlet_id", $outlet_id);
    $this->db->where("date_time>=", $date);
    $this->db->where("date_time<=", date('Y-m-d H:i:s'));
    $this->db->where("payment_method_id", 5);
    return $this->db->get()->row();
  }

  /**
   * getSaleReportByPayments
   * @access public
   * @param int
   * @param int
   * @param string
   * @return object
   */
  public function getSaleReportByPayments($user_id, $outlet_id, $date)
  {
    $this->db->select("SUM(paid_amount) as amount,tbl_payment_methods.name");
    $this->db->from('tbl_sales');
      $this->db->join('tbl_payment_methods', 'tbl_payment_methods.id = tbl_sales.payment_method_id', 'left');
    $this->db->where("tbl_sales.user_id", $user_id);
    $this->db->where("tbl_sales.outlet_id", $outlet_id);
    $this->db->where("tbl_sales.date_time>=", $date);
    $this->db->where("tbl_sales.date_time<=", date('Y-m-d H:i:s'));
      $this->db->group_by("tbl_sales.payment_method_id");
    return $this->db->get()->result();
  }


   /**
   * getSaleInStripeSum
   * @access public
   * @param int
   * @param int
   * @param string
   * @return object
   */
  public function getSaleInStripeSum($user_id, $outlet_id, $date)
  {
    $this->db->select("SUM(paid_amount) as amount");
    $this->db->from('tbl_sales');
    $this->db->where("user_id", $user_id);
    $this->db->where("outlet_id", $outlet_id);
    $this->db->where("sale_date", $date);
    $this->db->where("payment_method_id", null);
    return $this->db->get()->row();
  }

  /**
   * getOpeningBalance
   * @access public
   * @param int
   * @param int
   * @param string
   * @return object
   */
  public function getOpeningBalance($user_id, $outlet_id, $date)
  {
    $this->db->select("opening_balance as amount");
    $this->db->from('tbl_register');
    $this->db->where("user_id", $user_id);
    $this->db->where("outlet_id", $outlet_id);
    $this->db->where("DATE(opening_balance_date_time)", $date);
    $this->db->order_by('id', 'DESC');
    return $this->db->get()->row();
  }


  /**
   * getOpeningDateTime
   * @access public
   * @param int
   * @param int
   * @param string
   * @return object
   */
  public function getOpeningDateTime($user_id, $outlet_id, $date)
  {
    $this->db->select("opening_balance_date_time as opening_date_time");
    $this->db->from('tbl_register');
    $this->db->where("user_id", $user_id);
    $this->db->where("outlet_id", $outlet_id);
    $this->db->where("register_status", 1);
    $this->db->order_by('id', 'DESC');
    return $this->db->get()->row();
  }


  /**
   * getClosingDateTime
   * @access public
   * @param int
   * @param int
   * @param string
   * @return object
   */
  public function getClosingDateTime($user_id, $outlet_id, $date)
  {
    $this->db->select("closing_balance_date_time as closing_date_time");
    $this->db->from('tbl_register');
    $this->db->where("user_id", $user_id);
    $this->db->where("outlet_id", $outlet_id);
    $this->db->where("register_status", 1);
    $this->db->order_by('id', 'DESC');
    $this->db->where("DATE(opening_balance_date_time)", $date);
    return $this->db->get()->row();
  }

  
 
  /**
   * make_query
   * @access public
   * @param int
   * @param string
   * @return object
   */
  public function make_query($outlet_id, $delivery_status=""){
    $company_id = $this->session->userdata('company_id');
    $this->db->select("s.id,s.sale_no,s.sale_date,s.date_time,s.total_payable,s.delivery_status,s.added_date,s.online_yes_no,u.full_name,c.name as customer_name");
    $this->db->from('tbl_sales s');
    $this->db->join('tbl_customers c', 'c.id = s.customer_id', 'left');
    $this->db->join('tbl_users u', 'u.id = s.user_id', 'left');
    $this->db->join('tbl_sale_payments sp', 'sp.sale_id = s.id', 'left');
    $this->db->join('tbl_payment_methods pm', 'pm.id = sp.payment_id', 'left');
    if($_POST["search"]["value"]) {
      $this->db->group_start();
      $this->db->like("sale_no",$_POST["search"]["value"]);
      $this->db->or_like("sale_date",$_POST["search"]["value"]);
      $this->db->or_like("date_time",$_POST["search"]["value"]);
      $this->db->or_like("order_time",$_POST["search"]["value"]);
      $this->db->or_like("c.name",$_POST["search"]["value"]);
      $this->db->or_like("pm.name",$_POST["search"]["value"]);
      $this->db->or_like("u.full_name",$_POST["search"]["value"]);
      $this->db->group_end();
    }
    if($delivery_status){
      $this->db->where("s.delivery_status", $delivery_status);
    }
    $this->db->where("s.outlet_id", $outlet_id);
    $this->db->where("s.company_id", $company_id);
    $this->db->where("s.del_status", "Live");
    $this->db->order_by('s.id', 'DESC');
    $this->db->group_by('s.id');
  }

  /**
   * make_datatables
   * @access public
   * @param int
   * @param string
   * @return object
   */
  public function make_datatables($outlet_id, $delivery_status=""){
      $this->make_query($outlet_id, $delivery_status);
      if($_POST["length"]!=-1){
          $this->db->limit($_POST["length"],$_POST["start"]);
      }
      return $this->db->get()->result();
  }
  /**
   * getDrawData
   * @access public
   * @param no
   * @return string
   */
  public function getDrawData(){
      return $_POST["draw"];
  }

   /**
   * get_filtered_data
   * @access public
   * @param int
   * @param string
   * @return object
   */
  public function get_filtered_data($outlet_id, $delivery_status=""){
      $this->make_query($outlet_id, $delivery_status);
      $result = $this->db->get();
      return $result->num_rows();
  }

   /**
   * get_all_data
   * @access public
   * @param int
   * @param string
   * @return object
   */
  public function get_all_data($outlet_id, $delivery_status=""){
      $company_id = $this->session->userdata('company_id');
      $this->db->select("*");
      $this->db->from('tbl_sales');
      if($delivery_status){
        $this->db->where("tbl_sales.delivery_status", $delivery_status);
      }
      $this->db->where("tbl_sales.outlet_id", $outlet_id);
      $this->db->where("tbl_sales.company_id", $company_id);
      $this->db->where("tbl_sales.del_status", "Live");
      return $this->db->count_all_results();
  }
  /**
   * getAllPurchaseByPayment
   * @access public
   * @param string
   * @param int
   * @return object
   */
  public function getAllPurchaseByPayment($date,$payment_id)
  {
    $outlet_id = $this->session->userdata('outlet_id');
    $user_id = $this->session->userdata('user_id');
    $company_id = $this->session->userdata('company_id');
    $this->db->select("sum(tbl_purchase_payments.amount) as total_amount");
    $this->db->from('tbl_purchase');
    $this->db->join('tbl_purchase_payments', 'tbl_purchase_payments.purchase_id = tbl_purchase.id', 'left');
    $this->db->where("tbl_purchase.user_id", $user_id);
    $this->db->where("tbl_purchase.outlet_id", $outlet_id);
    $this->db->where("tbl_purchase.company_id", $company_id);
    $this->db->where("tbl_purchase.del_status", 'Live');
    $this->db->where("tbl_purchase.added_date>=", $date);
    $this->db->where("tbl_purchase.added_date<=", date('Y-m-d H:i:s'));
    $this->db->where("tbl_purchase_payments.payment_id", $payment_id);
    $data =  $this->db->get()->row();
    return (isset($data->total_amount) && $data->total_amount?$data->total_amount:0);
  }


  /**
   * getAllPurchaseReturnByPayment
   * @access public
   * @param string
   * @param int
   * @return object
   */
  public function getAllPurchaseReturnByPayment($date,$payment_id)
  {
    $outlet_id = $this->session->userdata('outlet_id');
    $user_id = $this->session->userdata('user_id');
    $company_id = $this->session->userdata('company_id');
    $this->db->select("sum(total_return_amount) as total_amount");
    $this->db->from('tbl_purchase_return');
    $this->db->where("return_status", 'taken_by_sup_money_returned');
    $this->db->where("payment_method_id", $payment_id);
    $this->db->where("added_date>=", $date);
    $this->db->where("added_date<=", date('Y-m-d H:i:s'));
    $this->db->where("outlet_id", $outlet_id);
    $this->db->where("user_id", $user_id);
    $this->db->where("company_id", $company_id);
    $this->db->where("del_status", 'Live');
    $data =  $this->db->get()->row();
    return (isset($data->total_amount) && $data->total_amount?$data->total_amount:0);
  }

  /**
   * getAllPurchaseByReturn
   * @access public
   * @param string
   * @param int
   * @return object
   */
  public function getAllPurchaseByReturn($date,$payment_id)
  {
    $outlet_id = $this->session->userdata('outlet_id');
    $user_id = $this->session->userdata('user_id');
    $company_id = $this->session->userdata('company_id');
    $this->db->select("sum(total_return_amount) as total_amount");
    $this->db->from('tbl_purchase_return');
    $this->db->where("payment_method_id", $payment_id);
    $this->db->where("added_date>=", $date);
    $this->db->where("added_date<=", date('Y-m-d H:i:s'));
    $this->db->where("return_status", "taken_by_sup_money_returned");
    $this->db->where("outlet_id", $outlet_id);
    $this->db->where("user_id", $user_id);
    $this->db->where("company_id", $company_id);
    $this->db->where("del_status", 'Live');
    $data =  $this->db->get()->row();
    return (isset($data->total_amount) && $data->total_amount?$data->total_amount : 0);
  }

  /**
   * getAllDueReceiveByPayment
   * @access public
   * @param string
   * @param int
   * @return object
   */
  public function getAllDueReceiveByPayment($date,$payment_id)
  {
    $outlet_id = $this->session->userdata('outlet_id');
    $user_id = $this->session->userdata('user_id');
    $company_id = $this->session->userdata('company_id');
    $this->db->select("sum(amount) as total_amount");
    $this->db->from('tbl_customer_due_receives');
    $this->db->where("payment_method_id", $payment_id);
    $this->db->where("added_date>=", $date);
    $this->db->where("added_date<=", date('Y-m-d H:i:s'));
    $this->db->where("outlet_id", $outlet_id);
    $this->db->where("user_id", $user_id);
    $this->db->where("company_id", $company_id);
    $this->db->where("del_status", 'Live');
    $data =  $this->db->get()->row();
    return (isset($data->total_amount) && $data->total_amount?$data->total_amount:0);
  }

  /**
   * getAllDuePaymentByPayment
   * @access public
   * @param string
   * @param int
   * @return object
   */
  public function getAllDuePaymentByPayment($date,$payment_id)
  {
    $outlet_id = $this->session->userdata('outlet_id');
    $user_id = $this->session->userdata('user_id');
    $company_id = $this->session->userdata('company_id');
    $this->db->select("sum(amount) as total_amount");
    $this->db->from('tbl_supplier_payments');
    $this->db->where("payment_method_id", $payment_id);
    $this->db->where("added_date>=", $date);
    $this->db->where("added_date<=", date('Y-m-d H:i:s'));
    $this->db->where("outlet_id", $outlet_id);
    $this->db->where("user_id", $user_id);
    $this->db->where("company_id", $company_id);
    $this->db->where("del_status", 'Live');
    $data =  $this->db->get()->row();
    return (isset($data->total_amount) && $data->total_amount?$data->total_amount:0);
  }

  /**
   * getAllExpenseByPayment
   * @access public
   * @param string
   * @param int
   * @return object
   */
  public function getAllExpenseByPayment($date,$payment_id)
  {
    $outlet_id = $this->session->userdata('outlet_id');
    $user_id = $this->session->userdata('user_id');
    $company_id = $this->session->userdata('company_id');
    $this->db->select("sum(amount) as total_amount");
    $this->db->from('tbl_expenses');
    $this->db->where("payment_method_id", $payment_id);
    $this->db->where("added_date	>=", $date);
    $this->db->where("added_date	<=", date('Y-m-d H:i:s'));
    $this->db->where("outlet_id", $outlet_id);
    $this->db->where("user_id", $user_id);
    $this->db->where("company_id", $company_id);
    $this->db->where("del_status", 'Live');
    $data =  $this->db->get()->row();
    return (isset($data->total_amount) && $data->total_amount?$data->total_amount:0);
  }
  /**
   * getAllSaleByPayment
   * @access public
   * @param string
   * @param int
   * @return object
   */
  public function getAllSaleByPayment($date,$payment_id){
    $user_id = $this->session->userdata('user_id');
    $this->db->select("sum(sp.amount) as total_amount");
    $this->db->from('tbl_sale_payments sp');
    $this->db->join('tbl_sales s', 's.id = sp.sale_id', 'left');
    $this->db->where("sp.user_id", $user_id);
    $this->db->where("sp.payment_id", $payment_id);
    $this->db->where("s.delivery_status", 'Cash Received');
    $this->db->where("sp.added_date	>=", $date);
    $this->db->where("sp.added_date	<=", date('Y-m-d H:i:s'));
    $this->db->where("currency_type", null);
    $data =  $this->db->get()->row();
    return (isset($data->total_amount) && $data->total_amount?$data->total_amount:0);
  }

  /**
   * getAllRefundByPayment
   * @access public
   * @param string
   * @param int
   * @return object
   */
  public function getAllRefundByPayment($date,$payment_id=""){
    $company_id = $this->session->userdata('company_id');
    $user_id = $this->session->userdata('user_id');
    $outlet_id = $this->session->userdata('outlet_id');
    $this->db->select("sum(total_return_amount) as total_amount");
    $this->db->from('tbl_sale_return');
    $this->db->where("user_id", $user_id);
    $this->db->where("added_date >=", $date);
    $this->db->where("added_date <=", date('Y-m-d H:i:s'));
    $this->db->where("payment_method_id", $payment_id);
    $this->db->where("outlet_id", $outlet_id);
    $this->db->where("company_id", $company_id);
    $this->db->where("del_status", "Live");
    $data =  $this->db->get()->row();
    return (isset($data->total_amount) && $data->total_amount?$data->total_amount:0);
  }

  /**
   * getAllServicingAmount
   * @access public
   * @param string
   * @param int
   * @return object
   */
  public function getAllServicingAmount($date,$payment_id="")
  {
    $company_id = $this->session->userdata('company_id');
    $user_id = $this->session->userdata('user_id');
    $outlet_id = $this->session->userdata('outlet_id');
    $this->db->select("sum(paid_amount) as total_amount");
    $this->db->from('tbl_servicing');
    $this->db->where("added_date >=", $date);
    $this->db->where("added_date <=", date('Y-m-d H:i:s'));
    $this->db->where("payment_method_id", $payment_id);
    $this->db->where("outlet_id", $outlet_id);
    $this->db->where("user_id", $user_id);
    $this->db->where("company_id", $company_id);
    $this->db->where("del_status", "Live");
    $data =  $this->db->get()->row();
    return (isset($data->total_amount) && $data->total_amount?$data->total_amount:0);
  }

  /**
   * getAllDownPayment
   * @access public
   * @param string
   * @param int
   * @return object
   */
  public function getAllDownPayment($date,$payment_id="")
  {
    $user_id = $this->session->userdata('user_id');
    $outlet_id = $this->session->userdata('outlet_id');
    $company_id = $this->session->userdata('company_id');
    $this->db->select("sum(down_payment) as total_down_payment");
    $this->db->from('tbl_installments');
    $this->db->where("user_id", $user_id);
    $this->db->where("added_date >=", $date);
    $this->db->where("added_date <=", date('Y-m-d H:i:s'));
    $this->db->where("payment_method_id", $payment_id);
    $this->db->where("outlet_id", $outlet_id);
    $this->db->where("company_id", $company_id);
    $this->db->where("del_status", "Live");
    $data =  $this->db->get()->row();
    return (isset($data->total_down_payment) && $data->total_down_payment?$data->total_down_payment:0);
  }

  /**
   * getAllInstallmentCollectionPayment
   * @access public
   * @param string
   * @param int
   * @return object
   */
  public function getAllInstallmentCollectionPayment($date,$payment_id="")
  {
    $user_id = $this->session->userdata('user_id');
    $outlet_id = $this->session->userdata('outlet_id');
    $company_id = $this->session->userdata('company_id');
    $this->db->select("sum(paid_amount) as total_installment_collection");
    $this->db->from('tbl_installment_items');
    $this->db->where("added_date >=", $date);
    $this->db->where("added_date <=", date('Y-m-d H:i:s'));
    $this->db->where("payment_method_id", $payment_id);
    $this->db->where("outlet_id", $outlet_id);
    $this->db->where("user_id", $user_id);
    $this->db->where("company_id", $company_id);
    $this->db->where("del_status", "Live");
    $data =  $this->db->get()->row();
    return (isset($data->total_installment_collection) && $data->total_installment_collection ?$data->total_installment_collection : 0);
  }


  /**
   * getOpeningDetails
   * @access public
   * @param int
   * @param int
   * @param string
   * @return object
   */
  public function getOpeningDetails($user_id, $outlet_id, $date)
  {
    $this->db->select("opening_details");
    $this->db->from('tbl_register');
    $this->db->where("user_id", $user_id);
    $this->db->where("outlet_id", $outlet_id);
    $this->db->where("register_status", 1);
    $this->db->order_by('id', 'DESC');
    return $this->db->get()->row();
  }

  /**
   * generateSaleReturnRefNo
   * @access public
   * @param int
   * @return string
   */
  public function generateSaleReturnRefNo($outlet_id) {
    $count = $this->db->query("SELECT count(id) as count
            FROM tbl_sale_return where outlet_id=$outlet_id")->row('count');
    $code = str_pad($count + 1, 6, '0', STR_PAD_LEFT);
    return $code;
  }

  /**
   * getAllSaleByPaymentMultiCurrencyRows
   * @access public
   * @param string
   * @param int
   * @return object
   */
  public function getAllSaleByPaymentMultiCurrencyRows($date,$payment_id){
    $user_id = $this->session->userdata('user_id');
    $this->db->select("sum(amount) as total_amount,multi_currency");
    $this->db->from('tbl_sale_payments');
    $this->db->where("payment_id", $payment_id);
    $this->db->where("user_id", $user_id);
    $this->db->where("added_date>=", $date);
    $this->db->where("added_date<=", date('Y-m-d H:i:s'));
    $this->db->where("currency_type", 1);
    $this->db->group_by('multi_currency');
    $data =  $this->db->get()->result();
    return $data;
  }



  /**
   * make_datatablesForSaleReturn
   * @access public
   * @param int
   * @param int
   * @return object
   */
  public function make_datatablesForSaleReturn($company_id, $outlet_id){
    $this->make_queryForSaleReturn($company_id, $outlet_id);
    if($_POST["length"]!=-1){
        $this->db->limit($_POST["length"],$_POST["start"]);
    }
    return $this->db->get()->result();
  }
  /**
   * make_queryForSaleReturn
   * @access public
   * @param int
   * @param int
   * @return void
   */
  public function make_queryForSaleReturn($company_id, $outlet_id=""){
    $this->db->select("sr.id,sr.reference_no,sr.date,sr.note,sr.total_return_amount,sr.added_date, sr.paid, sr.due, u.full_name as added_by, c.name as customer_name");
    $this->db->from('tbl_sale_return sr');
    $this->db->join('tbl_users u', 'u.id = sr.user_id', 'left');
    $this->db->join('tbl_customers c', 'c.id = sr.customer_id', 'left');
    if($_POST["search"]["value"]) {
      $this->db->group_start();
      $this->db->like("sr.reference_no",$_POST["search"]["value"]);
      $this->db->or_like("sr.total_return_amount",$_POST["search"]["value"]);
      $this->db->or_like("sr.paid",$_POST["search"]["value"]);
      $this->db->or_like("c.name",$_POST["search"]["value"]);
      $this->db->group_end();
    }
    if($outlet_id){
      $this->db->where("sr.outlet_id", $outlet_id);
    }
    $this->db->where("sr.company_id", $company_id);
    $this->db->where("sr.del_status", "Live");
    $this->db->order_by('sr.id', 'DESC');
  }

  /**
   * get_all_dataForSaleReturn
   * @access public
   * @param int
   * @param int
   * @return void
   */
  public function get_all_dataForSaleReturn($company_id, $outlet_id=""){
    $this->db->select("*");
    $this->db->from('tbl_sale_return');
    if($outlet_id){
        $this->db->where("outlet_id", $outlet_id);
    }
    $this->db->where("company_id", $company_id);
    $this->db->where("del_status", "Live");
    return $this->db->count_all_results();
  }

  /**
   * get_filtered_dataForSaleReturn
   * @access public
   * @param int
   * @param int
   * @return int
   */
  public function get_filtered_dataForSaleReturn($company_id, $outlet_id=""){
    $this->make_queryForSaleReturn($company_id, $outlet_id);
    $result = $this->db->get();
    return $result->num_rows();
  }



  /**
   * stockInoDBSetter
   * @access public
   * @param int
   * @param int
   * @return int
   */
  public function stockInoDBSetter($item_id="",$item_code="",$brand_id="",$category_id="",$supplier_id="", $generic_name = "", $outlet_id="") {
    $where = '';
    $where_item_parent = '';
    if($item_id!=''){
        $parent_id = getItemParentId($item_id);
        if($parent_id){
            $where.= " AND p.id = '$parent_id'";
            $where_item_parent.= " AND p_var.id = '$item_id'";
        }else{
            $where.= " AND p.id = '$item_id'";
        }
    }else{
        $where.= " AND p.parent_id = '0'"; 
    }
    if($item_code!=''){
        $where.= "  AND p.code = '$item_code'";
    }

    if($brand_id!=''){
        $where.= " AND p.brand_id = '$brand_id'";
    }
    if($category_id!=''){
        $where.= " AND p.category_id = '$category_id'";
    }
    
    if($supplier_id!=''){
        $where.= "  AND p.supplier_id = '$supplier_id'";
    }
    if($generic_name!=''){
        $where.= "  AND p.generic_name = '$generic_name'";
    }

    if($outlet_id){
        $outlet_id = $outlet_id;
    }else{
        $outlet_id = $this->session->userdata('outlet_id');
    }
    $company_id = $this->session->userdata('company_id');
    $data = $this->db->query("SELECT 
        p.id, p.parent_id, p.name, p.code, p.type, p.expiry_date_maintain, p.conversion_rate, su.unit_name as sale_unit,
        (
            SELECT GROUP_CONCAT(st.expiry_imei_serial SEPARATOR '||') as dd
            FROM tbl_stock_detail st
            WHERE p.id = st.item_id AND st.type = 1 AND st.expiry_imei_serial != '' AND st.outlet_id = '$outlet_id'
            AND st.expiry_imei_serial NOT IN (
                SELECT st2.expiry_imei_serial 
                FROM tbl_stock_detail2 st2 
                WHERE st2.item_id = p.id AND st2.type = 2 
                AND st2.expiry_imei_serial != '' AND st2.outlet_id = '$outlet_id'
            )
        ) as allimei,
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
            SELECT GROUP_CONCAT(
                CONCAT(p_var.id, '|', p_var.name, '|', p_var.code, '|', p_var.alert_quantity, '|', COALESCE(p_var.last_three_purchase_avg, 0), '|', 
                COALESCE((SELECT IFNULL(SUM(vst1.stock_quantity), 0) 
                        FROM tbl_stock_detail vst1
                        WHERE p_var.id = vst1.item_id AND vst1.type = 1 AND vst1.outlet_id = '$outlet_id'), 0), '|',
                COALESCE((SELECT IFNULL(SUM(vst2.stock_quantity), 0) 
                        FROM tbl_stock_detail vst2
                        WHERE p_var.id = vst2.item_id AND vst2.type = 2 AND vst2.outlet_id = '$outlet_id'), 0)
            ) SEPARATOR '||')
            FROM tbl_items p_var
            WHERE p_var.parent_id = p.id AND p_var.type = '0' AND p_var.del_status = 'Live' $where_item_parent
        ) as variations,
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
        WHERE p.type != 'Service_Product' AND p.type != '0' AND p.company_id='$company_id' AND p.enable_disable_status = 'Enable' AND p.del_status = 'Live' $where 
        ORDER BY p.name ASC")->result();
        return $data;
  }


}