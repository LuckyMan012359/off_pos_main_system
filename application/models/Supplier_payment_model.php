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
  # This is Accounting_model Model
  ###########################################################
 */
class Supplier_payment_model extends CI_Model {

    /**
     * getSupplierDue
     * @access public
     * @param int
     * @return int
     */
    public function getSupplierDue($supplier_id) {
        $outlet_id = $this->session->userdata('outlet_id');
        $supplier = $this->db->query("SELECT * FROM tbl_suppliers WHERE id=$supplier_id")->row();
        $supplier_due = $this->db->query("SELECT SUM(due_amount) as due FROM tbl_purchase WHERE supplier_id=$supplier_id and outlet_id=$outlet_id and del_status='Live'")->row();
        $supplier_payment = $this->db->query("SELECT SUM(amount) as amount FROM tbl_supplier_payments WHERE supplier_id=$supplier_id and outlet_id=$outlet_id and del_status='Live'")->row();
        $remaining_due = $supplier_due->due - $supplier_payment->amount;
        return $remaining_due+$supplier->opening_balance;
    }
    

    /**
     * getSupplierGrantTotalByDate
     * @access public
     * @param int
     * @param string
     * @param int
     * @return object
     */
    public function getSupplierGrantTotalByDate($supplier_id,$date,$outlet_id="") {
        $company_id = $this->session->userdata('company_id');
        $this->db->select('p.reference_no, p.grand_total as total, p.paid, p.due_amount as due, o.outlet_name');
        $this->db->from('tbl_purchase p');
		$this->db->join('tbl_outlets o', 'o.id = p.outlet_id');
		$this->db->where('p.supplier_id', $supplier_id);
        if($outlet_id != ''){
            $this->db->where('p.outlet_id', $outlet_id);
        }
        if($date != ''){
            $this->db->where('p.date', $date);
        }
		$this->db->where('p.company_id', $company_id);
		$this->db->where('p.del_status', 'Live');
		$purchase_info = $this->db->get()->result(); 
        return $purchase_info;
    }


    /**
     * getCustomerOpeningDueByDate
     * @access public
     * @param int
     * @param string
     * @param int
     * @return int
     */
    public function getCustomerOpeningDueByDate($customer_id,$date,$outlet_id="") {
        if(empty($outlet_id)){
            $outlet_id = $this->session->userdata('outlet_id');
        }else{
            $outlet_id = $outlet_id;
        }
        $outlet_id = $this->session->userdata('outlet_id');
        $customer = $this->db->query("SELECT * FROM tbl_customers WHERE id=$customer_id")->row();
        $customer_due = $this->db->query("SELECT SUM(due_amount) as due FROM tbl_sales WHERE customer_id=$customer_id and outlet_id=$outlet_id and del_status='Live' and sale_date<'$date' ")->row();
        $customer_payment = $this->db->query("SELECT SUM(amount) as amount FROM tbl_customer_due_receives WHERE customer_id=$customer_id and outlet_id=$outlet_id and del_status='Live' and date<'$date'")->row();
        $remaining_due = $customer_due->due - $customer_payment->amount;
        return $remaining_due+$customer->opening_balance;
    }

    /**
     * getCustomerGrantTotalByDate
     * @access public
     * @param int
     * @param string
     * @param int
     * @return object
     */
    public function getCustomerGrantTotalByDate($customer_id,$date,$outlet_id=""){
        $company_id = $this->session->userdata('company_id');
        $this->db->select('s.sale_no, s.total_payable as total,s.paid_amount as paid,s.due_amount as due, o.outlet_name');
		$this->db->from('tbl_sales s');
		$this->db->join('tbl_outlets o', 'o.id = s.outlet_id');
		$this->db->where('s.customer_id', $customer_id);
		$this->db->where('s.due_amount !=', 0);
        if($outlet_id != ''){
            $this->db->where('s.outlet_id', $outlet_id);
        }
        if($date != ''){
            $this->db->where('s.sale_date =', $date);
        }
		$this->db->where('s.company_id', $company_id);
		$this->db->where('s.del_status', 'Live');
		$sale_info = $this->db->get()->result();
        return $sale_info;
    }
    /**
     * getCustomerDuePaymentByDate
     * @access public
     * @param int
     * @param string
     * @param int
     * @return object
     */
    public function getCustomerDuePaymentByDate($customer_id,$date,$outlet_id=""){
        $company_id = $this->session->userdata('company_id');
        $this->db->select('cdr.reference_no, cdr.amount, o.outlet_name');
		$this->db->from('tbl_customer_due_receives cdr');
		$this->db->join('tbl_outlets o', 'o.id = cdr.outlet_id');
		$this->db->where('cdr.customer_id', $customer_id);
        if($outlet_id != ''){
            $this->db->where('cdr.outlet_id', $outlet_id);
        }
        if($date != ''){
            $this->db->where('cdr.date =', $date);
        }
		$this->db->where('cdr.company_id', $company_id);
		$this->db->where('cdr.del_status', 'Live');
		$customer_due_rec = $this->db->get()->result();
        return $customer_due_rec;
    }

    /**
     * getSupplierDuePaymentByDate
     * @access public
     * @param int
     * @param string
     * @param int
     * @return object
     */
    public function getSupplierDuePaymentByDate($supplier_id,$date,$outlet_id="") {
        $company_id = $this->session->userdata('company_id');
        $this->db->select('sp.reference_no, sp.amount, o.outlet_name');
        $this->db->from('tbl_supplier_payments sp');
        $this->db->join('tbl_outlets o', 'o.id = sp.outlet_id');
        $this->db->where('sp.supplier_id', $supplier_id);
        if($outlet_id != ''){
            $this->db->where('sp.outlet_id', $outlet_id);
        }
        if($date != ''){
            $this->db->where('sp.date', $date);
        }
        $this->db->where('sp.company_id', $company_id);
        $this->db->where('sp.del_status', 'Live');
        $supplier_payment = $this->db->get()->result();
        return $supplier_payment;
    }

    /**
     * getAllById
     * @access public
     * @param int
     * @param string
     * @return object
     */
    public function getAllById($id, $table_name) {
        $result = $this->db->query("SELECT s.*,c.phone,c.address
          FROM tbl_supplier_payments s 
          INNER JOIN tbl_suppliers c ON(s.supplier_id=c.id)
          WHERE s.id=$id AND s.del_status = 'Live'  
          ORDER BY id DESC")->result();
        return $result;
    }


    /**
     * getSaleReturnByDate
     * @access public
     * @param int
     * @param string
     * @param int
     * @return object
     */
    public function getSaleReturnByDate($customer_id,$date,$outlet_id="") {
        $company_id = $this->session->userdata('company_id');
        $this->db->select('sr.reference_no, sr.total_return_amount, o.outlet_name');
		$this->db->from('tbl_sale_return sr');
		$this->db->join('tbl_outlets o', 'o.id = sr.outlet_id');
		$this->db->where('sr.customer_id', $customer_id);
        if($outlet_id != ''){
            $this->db->where('sr.outlet_id', $outlet_id);
        }
        if($date != ''){
            $this->db->where('sr.date =', $date);
        }
		$this->db->where('sr.company_id', $company_id);
		$this->db->where('sr.del_status', 'Live');
		$sale_return = $this->db->get()->result();
        return $sale_return;
    }




    /**
     * generateSupplierPaymentRefNo
     * @access public
     * @param int
     * @return string
     */
    public function generateSupplierPaymentRefNo($outlet_id) {
        $count = $this->db->query("SELECT count(id) as count
            FROM tbl_supplier_payments where outlet_id=$outlet_id")->row('count');
        $code = str_pad($count + 1, 6, '0', STR_PAD_LEFT);
        return $code;
    }
}

