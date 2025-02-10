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
  # This is Purchase_model Model
  ###########################################################
 */
class Purchase_model extends CI_Model {

    /**
     * generatePurRefNo
     * @access public
     * @param int
     * @return string
     */
    public function generatePurRefNo($outlet_id) {
        $count = $this->db->query("SELECT count(id) as count
            FROM tbl_purchase where outlet_id=$outlet_id")->row('count');
        $code = str_pad($count + 1, 6, '0', STR_PAD_LEFT);
        return $code;
    }

    /**
     * generatePurReturnRefNo
     * @access public
     * @param int
     * @return string
     */
    public function generatePurReturnRefNo($outlet_id) {
        $count = $this->db->query("SELECT count(id) as count
               FROM tbl_purchase_return where outlet_id=$outlet_id")->row('count');
        $code = str_pad($count + 1, 6, '0', STR_PAD_LEFT);
        return $code;
    }

    /**
     * getRefInstall
     * @access public
     * @param int
     * @return string
     */
    public function getRefInstall($outlet_id) {
        $count = $this->db->query("SELECT count(id) as count
            FROM tbl_installments where outlet_id=$outlet_id")->row('count');
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
     * getPurchaseItems
     * @access public
     * @param int
     * @return object
     */
    public function getPurchaseItems($id) {
        $this->db->select("pd.*, i.name as item_name, i.code as item_code,i.conversion_rate,i.unit_type, i.parent_id, i.expiry_date_maintain, b.name as brand_name, pui.unit_name as purchase_unit_name");
        $this->db->from("tbl_purchase_details pd");
        $this->db->join('tbl_items i','pd.item_id=i.id','left');
        $this->db->join('tbl_brands b','b.id = i.brand_id','left');
        $this->db->join('tbl_units pui','pui.id = i.purchase_unit_id','left');
        $this->db->where("pd.purchase_id", $id);
        $this->db->where("pd.del_status", 'Live');
        $this->db->order_by('pd.id', 'ASC');
        $result = $this->db->get()->result();
        return $result;
    }

    /**
     * purchasePayments
     * @access public
     * @param int
     * @return object
     */
    public function purchasePayments($id) {
        $this->db->select("pp.*, pm.name as payment_method_name");
        $this->db->from("tbl_purchase_payments as pp");
        $this->db->join('tbl_payment_methods pm','pm.id=pp.payment_id','left');
        $this->db->where("pp.purchase_id", $id);
        $this->db->where("pp.del_status", 'Live');
        $this->db->order_by('pp.id', 'ASC');
        return $this->db->get()->result();
    }

    /**
     * getPurchaseReturnItems
     * @access public
     * @param int
     * @return object
     */
    public function getPurchaseReturnItems($id) {
        $this->db->select("prd.*, i.name as item_name, i.code as item_code,i.conversion_rate,i.unit_type,i.expiry_date_maintain, b.name as brand_name, pui.unit_name as sale_unit_name");
        $this->db->from("tbl_purchase_return_details prd");
        $this->db->join("tbl_items i", "prd.item_id=i.id", 'left');
        $this->db->join("tbl_brands b", "i.brand_id=b.id", 'left');
        $this->db->join("tbl_units pui", "i.sale_unit_id=pui.id", 'left');
        $this->db->where("prd.pur_return_id", $id);
        $this->db->where("prd.del_status", 'Live');
        $this->db->order_by('prd.id', 'ASC');
        return $this->db->get()->result();
    }

    /**
     * getPurchaseReturnBySupplierAndStatus
     * @access public
     * @param int
     * @param string
     * @param int
     * @return object
     */
    public function getPurchaseReturnBySupplierAndStatus($supplier_id,$status,$outlet_id){
        $this->db->select("pr.*, u.full_name as added_by");
        $this->db->from('tbl_purchase_return pr');
        $this->db->join('tbl_users u', 'u.id = pr.user_id', 'left');
        if($supplier_id){
            $this->db->where("pr.supplier_id", $supplier_id);
        }
        if($status){
            $this->db->where("pr.return_status", $status);
        }
        if($outlet_id){
            $this->db->where("pr.outlet_id", $outlet_id);
        }
        $this->db->order_by('pr.id', 'DESC');
        return $this->db->get()->result();        
    }

    /**
     * make_datatables
     * @access public
     * @param int
     * @return object
     */
    public function make_datatables($company_id, $start_date, $endDate, $supplier_id, $outlet_id){
        $this->make_query($company_id, $start_date, $endDate, $supplier_id, $outlet_id);
        if($_POST["length"]!=-1){
            $this->db->limit($_POST["length"],$_POST["start"]);
        }
        return $this->db->get()->result();
    }

    /**
     * make_query
     * @access public
     * @param int
     * @param string
     * @param string
     * @param int
     * @param int
     * @return void
     */
    public function make_query($company_id, $start_date='', $endDate='', $supplier_id='', $outlet_id=''){

        

        if($outlet_id != ''){
            $outlet_id = $outlet_id;
        }else{
            $outlet_id = $this->session->userdata('outlet_id');
        }

        $this->db->select("p.id,p.reference_no,p.invoice_no,p.date,p.grand_total,p.paid,p.due_amount,p.attachment,p.added_date, s.name as supplier_name, u.full_name as added_by");
        $this->db->from('tbl_purchase p');
        $this->db->join('tbl_suppliers s', 's.id = p.supplier_id', 'left');
        $this->db->join('tbl_users u', 'u.id = p.user_id', 'left');

        if ($start_date != '' && $endDate != '') {
            $this->db->where('p.date >=', $start_date);
            $this->db->where('p.date <=', $endDate);
        }
        if ($start_date != '' && $endDate == '') {
            $this->db->where('p.date', $start_date);
        }
        if ($start_date == '' && $endDate != '') {
            $this->db->where('p.date', $endDate);
        }

        if($supplier_id != ''){
            $this->db->where("p.supplier_id", $supplier_id);
        }

        if($outlet_id != ''){
            $this->db->where("p.outlet_id", $outlet_id);
        }

        if($_POST["search"]["value"]) {
            $this->db->group_start();
            $this->db->like("p.reference_no",$_POST["search"]["value"]);
            $this->db->or_like("p.invoice_no",$_POST["search"]["value"]);
            $this->db->or_like("s.name",$_POST["search"]["value"]);
            $this->db->group_end();
        }

        $this->db->where("p.company_id", $company_id);
        $this->db->where("p.del_status", "Live");
        $this->db->order_by('p.id', 'DESC');
    }
    /**
     * make_datatablesForPurchaseReturn
     * @access public
     * @param int
     * @param int
     * @param string
     * @param int
     * @return object
     */
    public function make_datatablesForPurchaseReturn($company_id, $outlet_id, $status, $supplier_id){
        $this->make_queryForPurchaseReturn($company_id, $outlet_id, $status, $supplier_id);
        if($_POST["length"]!=-1){
            $this->db->limit($_POST["length"],$_POST["start"]);
        }
        return $this->db->get()->result();
    }

    /**
     * make_queryForPurchaseReturn
     * @access public
     * @param int
     * @param int
     * @param string
     * @param int
     * @return void
     */
    public function make_queryForPurchaseReturn($company_id, $outlet_id="", $status="", $supplier_id=""){
        $this->db->select("pr.id, pr.reference_no, pr.date, pr.total_return_amount, pr.note, pr.added_date, s.name as supplier_name, u.full_name as added_by");
        $this->db->from('tbl_purchase_return pr');
        $this->db->join('tbl_suppliers s', 's.id = pr.supplier_id', 'left');
        $this->db->join('tbl_users u', 'u.id = pr.user_id', 'left');
        if($_POST["search"]["value"]) {
            $this->db->group_start();
            $this->db->like("pr.reference_no",$_POST["search"]["value"]);
            $this->db->or_like("pr.total_return_amount",$_POST["search"]["value"]);
            $this->db->or_like("s.name",$_POST["search"]["value"]);
            $this->db->group_end();
        }
        if($status){
            $this->db->where("pr.return_status", $status);
        }
        if($supplier_id){
            $this->db->where("pr.supplier_id", $supplier_id);
        }
        if($outlet_id){
            $this->db->where("pr.outlet_id", $outlet_id);
        }
        $this->db->where("pr.company_id", $company_id);
        $this->db->where("pr.del_status", "Live");
        $this->db->order_by('pr.id', 'DESC');
    }


    /**
     * get_all_data
     * @access public
     * @param int
     * @return int
     */
    public function get_all_data($company_id){
        $this->db->select("*");
        $this->db->from('tbl_purchase');
        $this->db->where("company_id", $company_id);
        $this->db->where("del_status", "Live");
        return $this->db->count_all_results();
    }
    /**
     * get_all_dataForPurchaseReturn
     * @access public
     * @param int
     * @param int
     * @param string
     * @param string
     * @return int
     */
    public function get_all_dataForPurchaseReturn($company_id, $outlet_id="", $status="", $supplier_id=""){
        $this->db->select("*");
        $this->db->from('tbl_purchase_return');
        if($outlet_id){
            $this->db->where("outlet_id", $outlet_id);
        }
        if($status){
            $this->db->where("return_status", $status);
        }
        if($supplier_id){
            $this->db->where("supplier_id", $supplier_id);
        }
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
     * get_filtered_dataForPurchaseReturn
     * @access public
     * @param int
     * @param int
     * @param string
     * @param int
     * @return int
     */
    public function get_filtered_dataForPurchaseReturn($company_id, $outlet_id="", $status="", $supplier_id=""){
        $this->make_queryForPurchaseReturn($company_id, $outlet_id, $status, $supplier_id);
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

