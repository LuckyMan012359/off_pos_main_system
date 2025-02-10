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
  # This is Customer_due_receive_model Model
  ###########################################################
 */
class Customer_due_receive_model extends CI_Model {


    /**
     * getCustomerDue
     * @access public
     * @param int
     * @return int
     */
    public function getCustomerDue($customer_id) {
        $outlet_id = $this->session->userdata('outlet_id');
        $customer = $this->db->query("SELECT * FROM tbl_customers WHERE id=$customer_id")->row();
        $customer_due = $this->db->query("SELECT SUM(due_amount) as due FROM tbl_sales WHERE customer_id=$customer_id and outlet_id=$outlet_id and del_status='Live'")->row();
        $customer_payment = $this->db->query("SELECT SUM(amount) as amount FROM tbl_customer_due_receives WHERE customer_id=$customer_id and outlet_id=$outlet_id and del_status='Live'")->row();
        $remaining_due = $customer_due->due - $customer_payment->amount;
        return $remaining_due+$customer->opening_balance;
 
    }

    /**
     * generateReferenceNo
     * @access public
     * @param int
     * @return string
     */
    public function generateReferenceNo($outlet_id) {
        $reference_no = $this->db->query("SELECT count(id) as reference_no
               FROM tbl_customer_due_receives where outlet_id=$outlet_id")->row('reference_no');
        $reference_no = str_pad($reference_no + 1, 6, '0', STR_PAD_LEFT);
        return $reference_no;
    }
    
    /**
     * getAllById
     * @access public
     * @param int
     * @param string
     * @return object
     */
    public function getAllById($id, $table_name) {
        $result = $this->db->query("SELECT s.*,c.phone,c.address,c.name
          FROM tbl_customer_due_receives s 
          INNER JOIN tbl_customers c ON(s.customer_id=c.id)
          WHERE s.id=$id AND s.del_status = 'Live'  
          ORDER BY id DESC")->result();
        return $result;
    }
}

