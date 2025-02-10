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
  # This is Installment_model Model
  ###########################################################
 */
class Installment_model extends CI_Model {

    /**
     * getInstallmentPayments
     * @access public
     * @param int
     * @return object
     */
    public function getInstallmentPayments($id) {
        $this->db->select("i.*");
        $this->db->from("tbl_installment_items i");
        $this->db->where("i.installment_id", $id);
        $this->db->where("i.del_status", 'Live');
        $this->db->order_by('i.id', 'ASC');
        return $this->db->get()->result();
    }

    /**
     * getAllInstallmentPayments
     * @access public
     * @param int
     * @param int
     * @param string
     * @param int
     * @return object
     */
    public function getAllInstallmentPayments($customer_id='', $installment_id='', $payment_type='', $outlet_id='') {
        $company_id = $this->session->userdata('company_id');
        $this->db->select("ii.*, i.reference_no, c.name as customer_name, c.phone, it.name as item_name, it.code");
        $this->db->from("tbl_installment_items ii");
        $this->db->join('tbl_installments i', 'i.id = ii.installment_id', 'left');
        $this->db->join('tbl_customers c', 'c.id = i.customer_id', 'left');
        $this->db->join('tbl_items it', 'it.id = i.item_id', 'left');
        if($customer_id!=''){
            $this->db->where("i.customer_id", $customer_id);
        }
        if($payment_type!=''){
            $this->db->where("ii.paid_status", $payment_type);
        }
        if($installment_id!=''){
            $this->db->where("i.id", $installment_id);
        }
        if($outlet_id!=''){
            $this->db->where("i.outlet_id",$outlet_id);
            $this->db->where("ii.outlet_id",$outlet_id);
        }
        $this->db->where("ii.del_status", 'Live');
        $this->db->order_by('ii.id', 'ASC');
        $this->db->group_by('ii.id');
        return $this->db->get()->result();
    }

    /**
     * getInvoiceInfo
     * @access public
     * @param int
     * @return object
     */
    public function getInvoiceInfo($customer_id) {
        $company_id = $this->session->userdata('company_id');
        $this->db->select("tbl_installments.*,tbl_customers.name as customer_name,tbl_items.name as item_name");
        $this->db->from("tbl_installments");
        $this->db->join('tbl_customers', 'tbl_customers.id = tbl_installments.customer_id', 'left');
        $this->db->join('tbl_items', 'tbl_items.id = tbl_installments.item_id', 'left');
        $this->db->order_by('tbl_installments.id', 'ASC');
        $this->db->where("tbl_installments.customer_id", $customer_id);
        $this->db->where("tbl_installments.company_id", $company_id);
        $this->db->where("tbl_installments.del_status", 'Live');
        return $this->db->get()->result();
    }

    /**
     * dueInstallment
     * @access public
     * @param no
     * @return object
     */
    public function dueInstallment() {
        $company_id = $this->session->userdata('company_id');
        $this->db->select("tbl_installment_items.*,tbl_installments.customer_id, tbl_installments.down_payment,tbl_customers.name as customer_name, tbl_customers.phone as customer_phone, tbl_installments.item_id,tbl_items.name as item_name, tbl_installments.added_date");
        $this->db->from("tbl_installment_items");
        $this->db->join('tbl_installments', 'tbl_installments.id = tbl_installment_items.installment_id', 'right');
        $this->db->join('tbl_customers', 'tbl_customers.id = tbl_installments.customer_id', 'left');
        $this->db->join('tbl_items', 'tbl_items.id = tbl_installments.item_id', 'left');
        $this->db->where("tbl_installment_items.company_id", $company_id);
        $this->db->where("tbl_installment_items.del_status", 'Live');
        $this->db->where("tbl_installment_items.paid_status", 'Unpaid');
        $this->db->or_where("tbl_installment_items.paid_status", 'Partially Paid');
        $resutl =  $this->db->get()->result();
        return $resutl;
    }

    /**
     * dueInstallmentWithin
     * @access public
     * @param int
     * @param string
     * @param int
     * @param int
     * @return object
     */
    public function dueInstallmentWithin($customer_id='', $start_date='', $due_within='', $outlet_id='') {
        $company_id = $this->session->userdata('company_id');
        $this->db->select("tbl_installment_items.*,tbl_installments.customer_id, tbl_installments.down_payment, tbl_customers.name as customer_name, tbl_customers.phone as customer_phone, tbl_installments.item_id, tbl_items.name as item_name, tbl_installments.added_date");
        $this->db->from("tbl_installment_items");
        $this->db->join('tbl_installments', 'tbl_installments.id = tbl_installment_items.installment_id', 'left');
        $this->db->join('tbl_customers', 'tbl_customers.id = tbl_installments.customer_id', 'left');
        $this->db->join('tbl_items', 'tbl_items.id = tbl_installments.item_id', 'left');
        if($customer_id != ''){
            $this->db->where("tbl_installments.customer_id", $customer_id);
        }
        if($start_date){
            $this->db->where("tbl_installment_items.payment_date >=", $start_date);
        }
        if($due_within != ''){
            $this->db->where("tbl_installment_items.payment_date <=", $due_within);
        }
        if($outlet_id != ''){
            $this->db->where("tbl_installment_items.outlet_id", $outlet_id);
        }
        $this->db->where("tbl_installment_items.company_id", $company_id);
        $this->db->where("tbl_installment_items.paid_status", 'Unpaid');
        $this->db->where("tbl_installment_items.del_status", 'Live');
        $this->db->or_where("tbl_installment_items.paid_status", 'Partially Paid');
        $resutl =  $this->db->get()->result();
        return $resutl;
    }

    /**
     * getInstallmentPaymentInfo
     * @access public
     * @param int
     * @return object
     */
    public function getInstallmentPaymentInfo($id) {
        $company_id = $this->session->userdata('company_id');
        $this->db->select("ii.*,c.name as customer_name,c.phone,it.name as item_name");
        $this->db->from("tbl_installment_items ii");
        $this->db->join('tbl_installments i', 'i.id = ii.installment_id', 'left');
        $this->db->join('tbl_customers c', 'c.id = i.customer_id', 'left');
        $this->db->join('tbl_items it', 'it.id = i.item_id', 'left');
        $this->db->where("ii.id", $id);
        $this->db->where("ii.del_status", 'Live');
        $this->db->where("ii.company_id", $company_id);
        return $this->db->get()->row();
    }

}

