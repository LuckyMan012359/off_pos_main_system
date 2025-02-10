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
class Report_model extends CI_Model {


    /**
     * dailySummaryReport
     * @access public
     * @param string
     * @param int
     * @return array
     */

    public function dailySummaryReport($selectedDate='',$outlet_id='') {
        $company_id = $this->session->userdata('company_id');
        $this->db->select('p.reference_no, s.name as supplier_name, p.grand_total, p.paid, p.due_amount');
        $this->db->from('tbl_purchase p');
        $this->db->join('tbl_suppliers s', 's.id = p.supplier_id', 'left');
        if ($selectedDate != '') {
            $this->db->where('p.date', $selectedDate);
        } else {
            $today = date('Y-m-d');
            $this->db->where('p.date', $today);
        }
        if($outlet_id != ''){
            $this->db->where('p.outlet_id', $outlet_id);
        }
        $this->db->where("p.company_id", $company_id);
        $this->db->where("p.del_status", 'Live');
        $purchases = $this->db->get()->result(); 


        //Daily purchases Return
        $this->db->select('pr.reference_no, s.name as supplier_name, pr.total_return_amount, pr.note');
        $this->db->from('tbl_purchase_return pr');
        $this->db->join('tbl_suppliers s', 's.id = pr.supplier_id', 'left');
        if ($selectedDate != '') {
            $this->db->where('pr.date', $selectedDate);
        } else {
            $today = date('Y-m-d');
            $this->db->where('pr.date', $today);
        }
        if($outlet_id != ''){
            $this->db->where('pr.outlet_id', $outlet_id);
        }
        $this->db->where("pr.return_status", 'taken_by_sup_money_returned');
        $this->db->where("pr.company_id", $company_id);
        $this->db->where("pr.del_status", 'Live');
        $purchase_return = $this->db->get()->result(); 

        //Daily Supplier Due Payments
        $this->db->select('sp.reference_no, sp.amount,sp.note, s.name as supplier_name');
        $this->db->from('tbl_supplier_payments sp');
        $this->db->join('tbl_suppliers s', 's.id = sp.supplier_id', 'left');
        if ($selectedDate != '') {
            $this->db->where('sp.date', $selectedDate);
        } else {
            $today = date('Y-m-d');
            $this->db->where('sp.date', $today);
        }
        if($outlet_id != ''){
            $this->db->where('sp.outlet_id', $outlet_id);
        }
        $this->db->where("sp.del_status", 'Live');
        $this->db->where("sp.company_id", $company_id);
        $this->db->group_by('sp.id');
        $supplier_due_payments = $this->db->get()->result();



        //Daily Sales
        $this->db->select('s.sale_no, s.sub_total,s.vat,s.delivery_charge, c.name as customer_name, s.total_payable, s.total_discount_amount, s.paid_amount, s.due_amount');
        $this->db->from('tbl_sales s');
        $this->db->join('tbl_customers c', 'c.id = s.customer_id', 'left');
        if ($selectedDate != '') {
            $this->db->where('s.sale_date', $selectedDate);
        } else {
            $today = date('Y-m-d');
            $this->db->where('s.sale_date', $today);
        }
        if($outlet_id != ''){
            $this->db->where('s.outlet_id', $outlet_id);
        }
        $this->db->where("s.company_id", $company_id);
        $this->db->where("s.delivery_status !=", 'Returned');
        $this->db->where("s.del_status", 'Live');
        $sales = $this->db->get()->result();


        //Daily Sales Return
        $this->db->select('sr.id,sr.reference_no,sr.total_return_amount,sr.note,c.name as customer_name, c.phone');
        $this->db->from('tbl_sale_return sr');
        $this->db->join('tbl_customers c', 'sr.customer_id = c.id', 'left');
        if ($selectedDate != '') {
            $this->db->where('sr.date', $selectedDate);
        } else {
            $today = date('Y-m-d');
            $this->db->where('sr.date', $today);
        }
        if($outlet_id != ''){
            $this->db->where('sr.outlet_id', $outlet_id);
        }
        $this->db->where("sr.company_id", $company_id);
        $this->db->where("sr.del_status", 'Live');
        $sale_return = $this->db->get()->result();


        //Daily Customer Due Receives
        $this->db->select('cdr.reference_no, cdr.amount, c.name as customer_name, cdr.note');
        $this->db->from('tbl_customer_due_receives cdr');
        $this->db->join('tbl_customers c', 'c.id = cdr.customer_id', 'left');
        if ($selectedDate != '') {
            $this->db->where('cdr.date', $selectedDate);
        } else {
            $today = date('Y-m-d');
            $this->db->where('cdr.date', $today);
        }
        if($outlet_id != ''){
            $this->db->where('cdr.outlet_id', $outlet_id);
        }
        $this->db->where("cdr.company_id", $company_id);
        $this->db->where("cdr.del_status", 'Live');
        $this->db->group_by("cdr.id");
        $customer_due_receives = $this->db->get()->result(); 

        //Daily Expenses
        $this->db->select('e.amount,e.reference_no, e.note, ec.name as expense_category, p.name as payment_name, u.full_name as responsible_person_name');
        $this->db->from('tbl_expenses e');
        $this->db->join('tbl_expense_items ec', 'ec.id = e.category_id', 'left');
        $this->db->join('tbl_payment_methods p', 'p.id = e.payment_method_id', 'left');
        $this->db->join('tbl_users u', 'u.id = e.employee_id', 'left');
        if ($selectedDate != '') {
            $this->db->where('e.date =', $selectedDate);
        } else {
            $today = date('Y-m-d');
            $this->db->where('e.date =', $today);
        }
        if($outlet_id != ''){
            $this->db->where('e.outlet_id', $outlet_id);
        }
        $this->db->where("e.company_id", $company_id);
        $this->db->where("e.del_status", 'Live');
        $expenses = $this->db->get()->result();


        //Daily Incomes
        $this->db->select('i.amount,i.note, i.reference_no, ii.name as income_category_name, p.name as payment_name, u.full_name responsible_person_name');
        $this->db->from('tbl_incomes i');
        $this->db->join('tbl_income_items ii', 'ii.id = i.category_id', 'left');
        $this->db->join('tbl_payment_methods p', 'p.id = i.payment_method_id', 'left');
        $this->db->join('tbl_users u', 'u.id = i.employee_id', 'left');
        if ($selectedDate != '') {
            $this->db->where('i.date =', $selectedDate);
        } else {
            $today = date('Y-m-d');
            $this->db->where('i.date =', $today);
        }
        if($outlet_id != ''){
            $this->db->where('i.outlet_id', $outlet_id);
        }
        $this->db->where("i.company_id", $company_id);
        $this->db->where("i.del_status", 'Live');
        $incomes = $this->db->get()->result();

        //Daily Damages
        $this->db->select('d.id,d.reference_no, d.total_loss, u.full_name as responsible_person, d.note');
        $this->db->from('tbl_damages d');
        $this->db->join('tbl_users u', 'u.id = d.employee_id');
        if ($selectedDate != '') {
            $this->db->where('d.date', $selectedDate);
        } else {
            $today = date('Y-m-d');
            $this->db->where('d.date', $today);
        }
        if($outlet_id != ''){
            $this->db->where('d.outlet_id', $outlet_id);
        }
        $this->db->where("d.company_id", $company_id);
        $this->db->where("d.del_status", 'Live');
        $wastes = $this->db->get()->result();
		
		//Daily Installment
		$this->db->select("ii.*, i.reference_no, c.name as customer_name,c.phone,itm.name as item_name");
        $this->db->from("tbl_installment_items ii");
        $this->db->join('tbl_installments i', 'i.id = ii.installment_id', 'left');
        $this->db->join('tbl_customers c', 'c.id = i.customer_id', 'left');
        $this->db->join('tbl_items itm', 'itm.id = i.item_id', 'left');
        if ($selectedDate != '') {
            $this->db->where('ii.paid_date', $selectedDate);
        } else {
            $today = date('Y-m-d');
            $this->db->where('ii.paid_date', $today);
        }
        if($outlet_id != ''){
            $this->db->where('ii.outlet_id', $outlet_id);
        }
        $this->db->where("ii.company_id", $company_id);
        $this->db->where("ii.del_status", 'Live');
		$this->db->where("ii.paid_status", 'paid');
		$installments = $this->db->get()->result();


		$this->db->select("i.reference_no, i.down_payment,c.name as customer_name");
        $this->db->from("tbl_installments i");
        $this->db->join('tbl_customers c', 'c.id = i.customer_id', 'left');
        if ($selectedDate != '') {
            $this->db->where('i.date', $selectedDate);
        } else {
            $today = date('Y-m-d');
            $this->db->where('i.date', $today);
        }
        if($outlet_id != ''){
            $this->db->where('i.outlet_id', $outlet_id);
        }
        $this->db->where("i.company_id", $company_id);
        $this->db->where("i.del_status", 'Live');
		$installments_down_payment = $this->db->get()->result();


        $this->db->select('s.*, c.name as customer_name');
        $this->db->from('tbl_servicing s');
        $this->db->join('tbl_customers c', 'c.id = s.customer_id', 'left');
        if ($selectedDate != '') {
            $this->db->where('s.date', $selectedDate);
        } else {
            $today = date('Y-m-d');
            $this->db->where('s.date', $today);
        }
        if ($outlet_id != '') {
            $this->db->where('s.outlet_id', $outlet_id);
        }
        $this->db->where('s.company_id', $company_id);
        $this->db->where("s.del_status", 'Live');
        $total_servicing = $this->db->get()->result();

        $result = array();
        $result['outlet_name'] = getOutletName($outlet_id);
        $result['purchases'] = $purchases;
        $result['purchase_return'] = $purchase_return;
        $result['sales'] = $sales;
        $result['supplier_due_payments'] = $supplier_due_payments;
        $result['customer_due_receives'] = $customer_due_receives;
        $result['expenses'] = $expenses;
        $result['incomes'] = $incomes;
        $result['sale_return'] = $sale_return;
        $result['wastes'] = $wastes;
		$result['installments'] = $installments;
		$result['installments_down_payment'] = $installments_down_payment;
		$result['total_servicing'] = $total_servicing;
        return $result;
    }




    /**
     * installmentDueReport
     * @access public
     * @param int
     * @param int
     * @return object
     */
    public function installmentDueReport($outlet_id='', $customer_id='') {
        $this->db->select("i.*,c.name as customer_name,c.phone,it.name as item_name,it.code");
        $this->db->from("tbl_installments i");
        $this->db->join('tbl_customers c', 'c.id = i.customer_id', 'left');
        $this->db->join('tbl_items it', 'it.id = i.item_id', 'left');
        $this->db->order_by('i.id', 'DESC');
        $this->db->where("i.del_status", 'Live');
        if($outlet_id != ''){
            $this->db->where("i.outlet_id",$outlet_id);
        }
        if($customer_id != ''){
            $this->db->where("i.customer_id",$customer_id);
        }
        return $this->db->get()->result();
    }
    


   
    /**
     * productProfitReport
     * @access public
     * @param int
     * @param string
     * @param string
     * @param int
     * @return object
     */
    public function productProfitReport($item_id='',$startMonth = '', $endMonth = '', $outlet_id='') {
        $company_id = $this->session->userdata('company_id');
        $this->db->select('i.id as item_id,s.sale_no, s.date_time, (sd.qty) as totalQty,s.sale_date,sd.menu_unit_price as sale_price,sd.discount_amount as discount_amount,sd.purchase_price, i.last_three_purchase_avg, i.last_purchase_price, u.unit_name');
        $this->db->from('tbl_sales_details sd');
        $this->db->join('tbl_sales s', 's.id = sd.sales_id', 'left');
        $this->db->join('tbl_items i', 'i.id = sd.food_menu_id', 'left');
        $this->db->join('tbl_units u', 'u.id = i.purchase_unit_id', 'left');
        if ($startMonth != '' && $endMonth != '') {
            $this->db->where('s.sale_date>=', $startMonth);
            $this->db->where('s.sale_date <=', $endMonth);
        }
        if ($startMonth != '' && $endMonth == '') {
            $this->db->where('s.sale_date', $startMonth);
        }
        if ($startMonth == '' && $endMonth != '') {
            $this->db->where('s.sale_date', $endMonth);
        }
        if($outlet_id != ''){
            $this->db->where('sd.outlet_id', $outlet_id);
        }
        $this->db->where('sd.delivery_status', 'Cash Received');
        $this->db->where('sd.company_id', $company_id);
        $this->db->where('sd.food_menu_id', $item_id);
        $this->db->where('sd.del_status', 'Live');
        $this->db->group_by('sd.sales_id');
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }


   
    /**
     * taxReport
     * @access public
     * @param string
     * @param string
     * @param int
     * @return object
     */
    public function taxReport($startDate = '', $endDate = '',$outlet_id='') {
        $company_id = $this->session->userdata('company_id');
        $this->db->select('date_time,sale_no,sale_vat_objects,sale_date,sum(total_payable) as total_payable,sum(vat) as total_vat');
        $this->db->from('tbl_sales');
        if ($startDate != '' && $endDate != '') {
            $this->db->where('sale_date>=', $startDate);
            $this->db->where('sale_date <=', $endDate);
        }
        if ($startDate != '' && $endDate == '') {
            $this->db->where('sale_date', $startDate);
        }
        if ($startDate == '' && $endDate != '') {
            $this->db->where('sale_date', $endDate);
        }
        if($outlet_id != ''){
            $this->db->where('outlet_id', $outlet_id);
        }
        $this->db->where('del_status', "Live");
        $this->db->where('company_id', $company_id);
        $this->db->group_by('id');
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }



    /**
     * total_purchase
     * @access public
     * @param string
     * @param string
     * @param int
     * @return int
     */
    public function total_purchase($start_date,$end_date,$outlet_id=''){
        $this->db->select('sum(grand_total) as total_purchase');
        $this->db->from('tbl_purchase');
        $this->db->where('date>=', $start_date);
        $this->db->where('date <=', $end_date);
        $this->db->where('outlet_id', $outlet_id);
        $this->db->where("del_status", 'Live');
        $result = $this->db->get()->row();
        if(!empty($result->total_purchase)){
            return $result->total_purchase;
        }else{
            return 0;
        }
    }


    /**
     * purchase_due
     * @access public
     * @param string
     * @param string
     * @param int
     * @return int
     */
    public function purchase_due($start_date,$end_date,$outlet_id=''){
        $this->db->select('sum(due_amount) as purchase_due');
        $this->db->from('tbl_purchase');
        $this->db->where('date>=', $start_date);
        $this->db->where('date <=', $end_date);
        $this->db->where('outlet_id', $outlet_id);
        $this->db->where("del_status", 'Live');
        $result = $this->db->get()->row();
        if(!empty($result->purchase_due)){
            return $result->purchase_due;
        }else{
            return 0;
        }
        
    }


    /**
     * total_purchase_return
     * @access public
     * @param string
     * @param string
     * @param int
     * @return int
     */
    public function total_purchase_return($start_date,$end_date,$outlet_id=''){
        $this->db->select('sum(total_return_amount) as total_purchase_return');
        $this->db->from('tbl_purchase_return');
        $this->db->where('date>=', $start_date);
        $this->db->where('date <=', $end_date);
        $this->db->where('outlet_id', $outlet_id);
        $this->db->where("del_status", 'Live');
        $result = $this->db->get()->row();
        if(!empty($result->total_purchase_return)){
            return $result->total_purchase_return;
        }else{
            return 0;
        }
        
    }


    /**
     * total_sales
     * @access public
     * @param string
     * @param string
     * @param int
     * @return int
     */
    public function total_sales($start_date,$end_date,$outlet_id=''){
        $this->db->select('sum(paid_amount) as total_sales');
        $this->db->from('tbl_sales');
        $this->db->where('sale_date>=', $start_date);
        $this->db->where('sale_date <=', $end_date);
        $this->db->where('outlet_id', $outlet_id);
        $this->db->where("del_status", 'Live');
        $result = $this->db->get()->row();
        if(!empty($result->total_sales)){
            return $result->total_sales;
        }else{
            return 0;
        }
    }


    /**
     * total_sales_return
     * @access public
     * @param string
     * @param string
     * @param int
     * @return int
     */
    public function total_sales_return($start_date,$end_date,$outlet_id=''){
        $this->db->select('sum(total_return_amount) as total_sales_return');
        $this->db->from('tbl_sale_return');
        $this->db->where('added_date>=', $start_date);
        $this->db->where('added_date <=', $end_date);
        $this->db->where('outlet_id', $outlet_id);
        $this->db->where("del_status", 'Live');
        $result = $this->db->get()->row();
        if(!empty($result->total_sales_return)){
            return $result->total_sales_return;
        }else{
            return 0;
        }
    }


    /**
     * sales_due
     * @access public
     * @param string
     * @param string
     * @param int
     * @return int
     */
    public function sales_due($start_date,$end_date,$outlet_id=''){
        $this->db->select('sum(due_amount) as sales_due');
        $this->db->from('tbl_sales');
        $this->db->where('sale_date>=', $start_date);
        $this->db->where('sale_date <=', $end_date);
        $this->db->where('outlet_id', $outlet_id);
        $this->db->where("del_status", 'Live');
        $result = $this->db->get()->row();
        if(!empty($result->sales_due)){
            return $result->sales_due;
        }else{
            return 0;
        }
    }


    /**
     * expense
     * @access public
     * @param string
     * @param string
     * @param int
     * @return int
     */
    public function expense($start_date,$end_date,$outlet_id=''){
        $this->db->select('sum(amount) as expense');
        $this->db->from('tbl_expenses');
        $this->db->where('date>=', $start_date);
        $this->db->where('date <=', $end_date);
        $this->db->where('outlet_id', $outlet_id);
        $this->db->where("del_status", 'Live');
        $result = $this->db->get()->row();
        if(!empty($result->expense)){
            return $result->expense;
        }else{
            return 0;
        }
    }


    /**
     * income
     * @access public
     * @param string
     * @param string
     * @param int
     * @return int
     */
    public function income($start_date,$end_date,$outlet_id=''){
        $this->db->select('sum(amount) as income');
        $this->db->from('tbl_incomes');
        $this->db->where('date>=', $start_date);
        $this->db->where('date <=', $end_date);
        $this->db->where('outlet_id', $outlet_id);
        $this->db->where("del_status", 'Live');
        $result = $this->db->get()->row();
        if(!empty($result->income)){
            return $result->income;
        }else{
            return 0;
        }
    }


    /**
     * profitLossReport
     * @access public
     * @param string
     * @param string
     * @param int
     * @param string
     * @return array
     */
    public function profitLossReport($start_date, $end_date,$outlet_id, $calculation_formula='') {
        if ($calculation_formula):
            $company_id = $this->session->userdata('company_id');
            $this->db->select('sale_vat_objects, delivery_charge, total_discount_amount');
            $this->db->from('tbl_sales');
            if ($start_date != '' && $end_date != '') {
                $this->db->where('sale_date>=', $start_date);
                $this->db->where('sale_date <=', $end_date);
            }
            if ($start_date != '' && $end_date == '') {
                $this->db->where('sale_date', $start_date);
            }
            if ($start_date == '' && $end_date != '') {
                $this->db->where('sale_date', $end_date);
            }
            if($outlet_id != ''){
                $this->db->where('outlet_id', $outlet_id);
            }
            $this->db->where("delivery_status", 'Cash Received');
            $this->db->where("company_id", $company_id);
            $this->db->where("del_status", 'Live');
            $sales_main = $this->db->get()->result();

            $total_vat  = 0;
            $delivery_charge  = 0;
            $total_discount = 0;
            foreach ($sales_main as $value){
                if ($this->session->userdata('collect_tax')=='Yes' && $value->sale_vat_objects != NULL):
                    foreach(json_decode($value->sale_vat_objects) as $single_tax):
                        if($single_tax->tax_field_amount && $single_tax->tax_field_amount != "0.00"):
                            $total_vat += $single_tax->tax_field_amount;
                        endif;
                    endforeach;
                endif;
                $delivery_charge += $value->delivery_charge;
                $total_discount += $value->total_discount_amount;
            }

            $this->db->select('sd.food_menu_id, sum(sd.menu_price_without_discount) as total_sales_amount, sum(sd.purchase_price * sd.qty) as total_cost_of_sale, sum(i.last_three_purchase_avg * sd.qty) as total_three_purchase_avg, sum(i.last_purchase_price * sd.qty) as last_purchase_price, i.type');
            $this->db->from('tbl_sales_details sd');
            $this->db->join('tbl_sales s', 's.id = sd.sales_id', 'left');
            $this->db->join('tbl_items i', 'i.id = sd.food_menu_id', 'left');
            if ($start_date != '' && $end_date != '') {
                $this->db->where('s.sale_date>=', $start_date);
                $this->db->where('s.sale_date <=', $end_date);
            }
            if ($start_date != '' && $end_date == '') {
                $this->db->where('s.sale_date', $start_date);
            }
            if ($start_date == '' && $end_date != '') {
                $this->db->where('s.sale_date', $end_date);
            }
            
            if($outlet_id != ''){
                $this->db->where('sd.outlet_id', $outlet_id);
            }
            $this->db->where("sd.delivery_status", 'Cash Received');
            $this->db->where("sd.company_id", $company_id);
            $this->db->where("sd.del_status", 'Live');
            $sales = $this->db->get()->result();


            //Expense report
            $this->db->select('sum(amount) as expense_amount');
            $this->db->from('tbl_expenses');
            if ($start_date != '' && $end_date != '') {
                $this->db->where('date>=', $start_date);
                $this->db->where('date <=', $end_date);
            }
            if ($start_date != '' && $end_date == '') {
                $this->db->where('date', $start_date);
            }
            if ($start_date == '' && $end_date != '') {
                $this->db->where('date', $end_date);
            }
            if($outlet_id != ''){
                $this->db->where('outlet_id', $outlet_id);
            }
            $this->db->where("company_id", $company_id);
            $this->db->where("del_status", 'Live');
            $expense = $this->db->get()->row();

            //Sell Return report
            $this->db->select('sum(total_return_amount) as total_sell_return');
            $this->db->from('tbl_sale_return');
            if ($start_date != '' && $end_date != '') {
                $this->db->where('date>=', $start_date);
                $this->db->where('date <=', $end_date);
            }
            if ($start_date != '' && $end_date == '') {
                $this->db->where('date', $start_date);
            }
            if ($start_date == '' && $end_date != '') {
                $this->db->where('date', $end_date);
            }
            if($outlet_id != ''){
                $this->db->where('outlet_id', $outlet_id);
            }
            $this->db->where('company_id', $company_id);
            $this->db->where("del_status", 'Live');
            $total_sell_return = $this->db->get()->row();

            //Installment Sale
            $this->db->select('sum(total) as total_installment_sale');
            $this->db->from('tbl_installments');
            if ($start_date != '' && $end_date != '') {
                $this->db->where('date>=', $start_date);
                $this->db->where('date <=', $end_date);
            }
            if ($start_date != '' && $end_date == '') {
                $this->db->where('date', $start_date);
            }
            if ($start_date == '' && $end_date != '') {
                $this->db->where('date', $end_date);
            }
            if($outlet_id != ''){
                $this->db->where('outlet_id', $outlet_id);
            }
            $this->db->where('company_id', $company_id);
            $this->db->where("del_status", 'Live');
            $total_installment_sale = $this->db->get()->row();

            // Incomems
            $this->db->select('sum(amount) as total_income');
            $this->db->from('tbl_incomes');
            if ($start_date != '' && $end_date != '') {
                $this->db->where('date>=', $start_date);
                $this->db->where('date <=', $end_date);
            }
            if ($start_date != '' && $end_date == '') {
                $this->db->where('date', $start_date);
            }
            if ($start_date == '' && $end_date != '') {
                $this->db->where('date', $end_date);
            }
            if($outlet_id != ''){
                $this->db->where('outlet_id', $outlet_id);
            }
            $this->db->where("del_status", 'Live');
            $total_income = $this->db->get()->row();
            
        


            //Salaries Cost
            $this->db->select('sum(total_amount) as total_salaries');
            $this->db->from('tbl_salaries');
            if ($start_date != '' && $end_date != '') {
                $this->db->where('date>=', $start_date);
                $this->db->where('date <=', $end_date);
            }
            if ($start_date != '' && $end_date == '') {
                $this->db->where('date', $start_date);
            }
            if ($start_date == '' && $end_date != '') {
                $this->db->where('date', $end_date);
            }
            if($outlet_id != ''){
                $this->db->where('outlet_id', $outlet_id);
            }
            $this->db->where('company_id', $company_id);
            $this->db->where("del_status", 'Live');
            $total_salaries = $this->db->get()->row();


            $this->db->select('sum(servicing_charge) as servicing_charge');
            $this->db->from('tbl_servicing');
            if ($start_date != '' && $end_date != '') {
                $this->db->where('date>=', $start_date);
                $this->db->where('date <=', $end_date);
            }
            if ($start_date != '' && $end_date == '') {
                $this->db->where('date', $start_date);
            }
            if ($start_date == '' && $end_date != '') {
                $this->db->where('date', $end_date);
            }
            if($outlet_id != ''){
                $this->db->where('outlet_id', $outlet_id);
            }
            $this->db->where('company_id', $company_id);
            $this->db->where("del_status", 'Live');
            $total_servicing = $this->db->get()->row();

            $result['profit_sale_with_tax_discount'] = (isset($sales[0]->total_sales_amount) && $sales[0]->total_sales_amount ? $sales[0]->total_sales_amount : 0) + $total_vat;
            if($calculation_formula == 'AVG'){
                if($sales[0]->total_three_purchase_avg != ''){
                    $result['profit_cost_of_sale'] = isset($sales[0]->total_three_purchase_avg) && $sales[0]->total_three_purchase_avg ? $sales[0]->total_three_purchase_avg : '0.0';
                }else{
                    $result['profit_cost_of_sale'] = isset($sales[0]->total_cost_of_sale) && $sales[0]->total_cost_of_sale ? $sales[0]->total_cost_of_sale : '0.0';
                }
                
            }else if($calculation_formula == 'PP_Price'){
                if($sales[0]->last_purchase_price != ''){
                    $result['profit_cost_of_sale'] = isset($sales[0]->last_purchase_price) && $sales[0]->last_purchase_price ? $sales[0]->last_purchase_price : '0.0';
                }else{
                    $result['profit_cost_of_sale'] = isset($sales[0]->total_cost_of_sale) && $sales[0]->total_cost_of_sale ? $sales[0]->total_cost_of_sale : '0.0';
                }
            }else{
                $result['profit_cost_of_sale'] = isset($sales[0]->total_cost_of_sale) && $sales[0]->total_cost_of_sale ? $sales[0]->total_cost_of_sale : '0.0';
            }
            $result['profit_total_sale'] = (isset($sales[0]->total_sales_amount) && $sales[0]->total_sales_amount ? $sales[0]->total_sales_amount : 0);
            $result['profit_total_tax'] = $total_vat;
            $result['profit_total_delivery'] = $delivery_charge;
            $result['profit_total_discount'] = $total_discount ?? 0;
            if(!moduleIsHideCheck('Installment Sale-YES')){ 
                $result['profit_total_installment_sale'] = $total_installment_sale->total_installment_sale ?? 0;
            }else {
                $result['profit_total_installment_sale'] = 0;
            }
            $result['profit_total_income'] = $total_income->total_income ?? 0;
            $result['profit_total_sale_return'] = $total_sell_return->total_sell_return ?? 0;
            $result['profit_total_servicing'] = $total_servicing->servicing_charge ?? 0;
            $result['profit_gross'] = ($result['profit_sale_with_tax_discount'] + $result['profit_total_delivery'] + $result['profit_total_installment_sale'] + $result['profit_total_income'] + $result['profit_total_servicing']) - ($result['profit_cost_of_sale'] + $result['profit_total_tax'] + $result['profit_total_discount'] + $result['profit_total_sale_return']);
            $result['profit_total_salaries'] = $total_salaries->total_salaries ?? 0;
            $result['profit_total_expense'] = $expense->expense_amount ?? 0;
            $result['profit_net'] = ($result['profit_gross']) - ($result['profit_total_salaries'] + $result['profit_total_expense']);
            return $result;
        endif;
    }


    /**
     * customerDueReceiveReport
     * @access public
     * @param string
     * @param string
     * @param int
     * @param int
     * @return object
     */
    public function customerDueReceiveReport($startMonth = '', $endMonth = '', $customer_id = '', $outlet_id='') {
        $company_id = $this->session->userdata('company_id');
        if ($startMonth || $endMonth || $customer_id){
            $this->db->select('cr.reference_no,cr.date,cr.amount,cr.note,cr.added_date, c.name as customer_name, u.full_name as user_name');
            $this->db->from('tbl_customer_due_receives cr');
            $this->db->join('tbl_customers c', 'c.id = cr.customer_id', 'left');
            $this->db->join('tbl_users u', 'u.id = cr.user_id', 'left');
            if ($startMonth != '' && $endMonth != '') {
                $this->db->where('cr.date>=', $startMonth);
                $this->db->where('cr.date <=', $endMonth);
            }
            if ($startMonth != '' && $endMonth == '') {
                $this->db->where('cr.date', $startMonth);
            }
            if ($startMonth == '' && $endMonth != '') {
                $this->db->where('cr.date', $endMonth);
            }
            if ($customer_id != '') {
                $this->db->where('cr.customer_id', $customer_id);
            }
            if($outlet_id != ''){
                $this->db->where('cr.outlet_id', $outlet_id);
            }
            $this->db->where('cr.company_id', $company_id);
            $this->db->where('cr.del_status', "Live");
            $query_result = $this->db->get();
            $result = $query_result->result();
            return $result;
        }
    }


    /**
     * saleReport
     * @access public
     * @param string
     * @param string
     * @param int
     * @return object
     */
    public function saleReport($startMonth = '', $endMonth = '', $outlet_id='') {
        $company_id = $this->session->userdata('company_id');
        $this->db->select('s.date_time,s.id,s.sale_no,s.sub_total,s.vat,s.delivery_charge,s.total_payable,s.paid_amount, s.due_amount,s.total_discount_amount, s.grand_total, c.name as customer_name');
        $this->db->from('tbl_sales s');
        $this->db->join('tbl_customers c', 'c.id = s.customer_id', 'left');
        if ($startMonth != '' && $endMonth != '') {
            $this->db->where('s.sale_date >=', $startMonth);
            $this->db->where('s.sale_date <=', $endMonth);
        }
        if ($startMonth != '' && $endMonth == '') {
            $this->db->where('s.sale_date', $startMonth);
        }
        if ($startMonth == '' && $endMonth != '') {
            $this->db->where('s.sale_date', $endMonth);
        } 
        if($outlet_id != ''){
            $this->db->where('s.outlet_id', $outlet_id);
        }
        $this->db->where('s.delivery_status', 'Cash Received');
        $this->db->where('s.company_id', $company_id);
        $this->db->where('s.del_status', 'Live');
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }
    /**
     * dueSaleReport
     * @access public
     * @param string
     * @param string
     * @param int
     * @return object
     */
    public function dueSaleReport($startMonth = '', $endMonth = '', $outlet_id='') {
        $company_id = $this->session->userdata('company_id');
        $this->db->select('s.date_time,s.id,s.sale_no,s.sub_total,s.vat,s.delivery_charge,s.total_payable,s.paid_amount, s.due_amount,s.total_discount_amount, s.grand_total, c.name as customer_name');
        $this->db->from('tbl_sales s');
        $this->db->join('tbl_customers c', 'c.id = s.customer_id', 'left');
        if ($startMonth != '' && $endMonth != '') {
            $this->db->where('s.sale_date >=', $startMonth);
            $this->db->where('s.sale_date <=', $endMonth);
        }
        if ($startMonth != '' && $endMonth == '') {
            $this->db->where('s.sale_date', $startMonth);
        }
        if ($startMonth == '' && $endMonth != '') {
            $this->db->where('s.sale_date', $endMonth);
        } 
        if($outlet_id != ''){
            $this->db->where('s.outlet_id', $outlet_id);
        }
        $this->db->where('s.due_amount >', 0);
        $this->db->where('s.delivery_status', 'Cash Received');
        $this->db->where('s.company_id', $company_id);
        $this->db->where('s.del_status', 'Live');
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }

    /**
     * serviceSaleReport
     * @access public
     * @param string
     * @param string
     * @param int
     * @return object
     */
    public function serviceSaleReport($startMonth = '', $endMonth = '',$outlet_id='') {
        $company_id = $this->session->userdata('company_id');
        $this->db->select('s.id,s.sale_no,s.added_date, c.name as customer_name, i.name as item_name,i.code, sd.qty, sd.menu_unit_price');
        $this->db->from('tbl_sales_details sd');
        $this->db->join('tbl_sales s', 's.id = sd.sales_id', 'left');
        $this->db->join('tbl_items i', 'i.id = sd.food_menu_id', 'left');
        $this->db->join('tbl_customers c', 'c.id = s.customer_id', 'left');
        if ($startMonth != '' && $endMonth != '') {
            $this->db->where('s.sale_date>=', $startMonth);
            $this->db->where('s.sale_date <=', $endMonth);
        }
        if ($startMonth != '' && $endMonth == '') {
            $this->db->where('s.sale_date', $startMonth);
        }
        if ($startMonth == '' && $endMonth != '') {
            $this->db->where('s.sale_date', $endMonth);
        }
        if($outlet_id != ''){
            $this->db->where('sd.outlet_id', $outlet_id);
        }
        $this->db->where('sd.company_id', $company_id);
        $this->db->where('sd.del_status', 'Live');
        $this->db->where('sd.item_type', 'Service_Product');
        $this->db->group_by('sd.id');
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;

    }
    /**
     * comboServiceReport
     * @access public
     * @param string
     * @param string
     * @param int
     * @return object
     */
    public function comboServiceReport($startMonth = '', $endMonth = '',$outlet_id='') {
        $company_id = $this->session->userdata('company_id');
        $this->db->select('sd.id, sd.food_menu_id, sd.qty,sd.menu_unit_price,s.sale_no, s.date_time, c.name as customer_name, i.name as item_name, i.code');
        $this->db->from('tbl_sales_details sd');
        $this->db->join('tbl_sales s', 's.id = sd.sales_id', 'left');
        $this->db->join('tbl_customers c', 'c.id = s.customer_id', 'left');
        $this->db->join('tbl_items i', 'i.id = sd.food_menu_id', 'left');
        if ($startMonth != '' && $endMonth != '') {
            $this->db->where('s.sale_date>=', $startMonth);
            $this->db->where('s.sale_date <=', $endMonth);
        }
        if ($startMonth != '' && $endMonth == '') {
            $this->db->where('s.sale_date', $startMonth);
        }
        if ($startMonth == '' && $endMonth != '') {
            $this->db->where('s.sale_date', $endMonth);
        }
        if($outlet_id != ''){
            $this->db->where('sd.outlet_id', $outlet_id);
        }
        $this->db->where('i.type', 'Combo_Product');
        $this->db->where('sd.company_id', $company_id);
        $query_result = $this->db->get();
        return $query_result->result();
    }

    /**
     * detailedSaleReport
     * @access public
     * @param string
     * @param string
     * @param int
     * @param int
     * @return object
     */

    public function detailedSaleReport($startMonth = '', $endMonth = '', $user_id = '', $outlet_id='') {
        $company_id = $this->session->userdata('company_id');
        $this->db->select('s.date_time,s.id,s.sale_no,s.total_items,s.sale_date,s.sub_total,s.total_discount_amount,s.vat,s.total_payable,s.paid_amount, s.due_amount,u.full_name');
        $this->db->from('tbl_sales s');
        $this->db->join('tbl_users u', 'u.id = s.employee_id', 'left');
        if ($startMonth != '' && $endMonth != '') {
            $this->db->where('s.sale_date>=', $startMonth);
            $this->db->where('s.sale_date <=', $endMonth);
        }
        if ($startMonth != '' && $endMonth == '') {
            $this->db->where('s.sale_date', $startMonth);
        }
        if ($startMonth == '' && $endMonth != '') {
            $this->db->where('s.sale_date', $endMonth);
        }
        if ($user_id != '') {
            $this->db->where('s.employee_id', $user_id);
        }
        if ($outlet_id != '') {
            $this->db->where('s.outlet_id', $outlet_id);
        }
        $this->db->where('s.company_id', $company_id);
        $this->db->where('s.delivery_status', 'Cash Received');
        $this->db->where('s.del_status', 'Live');
        $this->db->group_by('s.id');
        $this->db->order_by('s.sale_date', 'ASC');
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }

    /**
     * employeeSaleReport
     * @access public
     * @param string
     * @param string
     * @param int
     * @param int
     * @return object
     */
    public function employeeSaleReport($startMonth = '', $endMonth = '', $user_id = '', $outlet_id='') {
        if ($startMonth || $endMonth || $user_id):
            $company_id = $this->session->userdata('company_id');
            $this->db->select('s.id,s.sale_no,s.total_items,s.sale_date,s.sub_total,s.total_discount_amount,s.vat,s.total_payable,u.full_name,c.name as customer_name');
            $this->db->from('tbl_sales s');
            $this->db->join('tbl_users u', 'u.id = s.employee_id', 'left');
            $this->db->join('tbl_customers c', 'c.id = s.customer_id', 'left');
            if ($startMonth != '' && $endMonth != '') {
                $this->db->where('s.sale_date>=', $startMonth);
                $this->db->where('s.sale_date <=', $endMonth);
            }
            if ($startMonth != '' && $endMonth == '') {
                $this->db->where('s.sale_date', $startMonth);
            }
            if ($startMonth == '' && $endMonth != '') {
                $this->db->where('s.sale_date', $endMonth);
            }

            if ($user_id != '') {
                $this->db->where('s.employee_id', $user_id);
            }
            if ($outlet_id != '') {
                $this->db->where('s.outlet_id', $outlet_id);
            }
            $this->db->where('s.company_id', $company_id);
            $this->db->where('s.del_status', 'Live');
            $this->db->order_by('s.sale_date', 'ASC');
            $query_result = $this->db->get();
            $result = $query_result->result();
            return $result;
        endif;
    }

    /**
     * purchaseReportByDate
     * @access public
     * @param string
     * @param string
     * @param int
     * @param int
     * @return object
     */
    public function purchaseReportByDate($startDate = '', $endDate = '', $supplier_id ='', $outlet_id='') {
        $company_id = $this->session->userdata('company_id');
        $this->db->select('p.id,p.reference_no, p.date,p.added_date, s.name as supplier_name,p.grand_total,p.paid,p.due_amount, u.full_name as user_name');
        $this->db->from('tbl_purchase p');
        $this->db->join('tbl_suppliers s', 's.id = p.supplier_id', 'left');
        $this->db->join('tbl_users u', 'u.id = p.user_id', 'left');
        if ($startDate != '' && $endDate != '') {
            $this->db->where('p.date>=', $startDate);
            $this->db->where('p.date <=', $endDate);
        }
        if ($startDate != '' && $endDate == '') {
            $this->db->where('p.date', $startDate);
        }
        if ($startDate == '' && $endDate != '') {
            $this->db->where('p.date', $endDate);
        }
        if($supplier_id != ''){
            $this->db->where('p.supplier_id', $supplier_id);
        }
        if($outlet_id != ''){
            $this->db->where('p.outlet_id', $outlet_id);
        }
        $this->db->where('p.company_id', $company_id);
        $this->db->where('p.del_status', "Live");
        $this->db->group_by('p.id');
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }



    /**
     * productPurchaseReport
     * @access public
     * @param string
     * @param string
     * @param int
     * @param int
     * @param string
     * @return object
     */
    public function productPurchaseReport($startMonth = '', $endMonth = '', $item_id = '', $supplier_id = '', $expiry_imei_serial = '', $outlet_id='') {
        $company_id = $this->session->userdata('company_id');
        if ($item_id):
            $this->db->select('p.reference_no,p.added_date,sum(pd.quantity_amount) as totalQuantity_amount,pd.unit_price,pd.expiry_imei_serial,pd.item_id,i.name,i.code,i.type,i.unit_type,p.date,s.name as supplier_name, u.unit_name as purchase_unit_name');
            $this->db->from('tbl_purchase_details pd');
            $this->db->join('tbl_purchase p', 'p.id = pd.purchase_id', 'left');
            $this->db->join('tbl_suppliers s', 's.id = p.supplier_id', 'left');
            $this->db->join('tbl_items i', 'i.id = pd.item_id', 'left');
            $this->db->join('tbl_units u', 'u.id = i.purchase_unit_id', 'left');
            if ($startMonth != '' && $endMonth != '') {
                $this->db->where('p.date>=', $startMonth);
                $this->db->where('p.date <=', $endMonth);
            }
            if ($startMonth != '' && $endMonth == '') {
                $this->db->where('p.date', $startMonth);
            }
            if ($startMonth == '' && $endMonth != '') {
                $this->db->where('p.date', $endMonth);
            }
            if ($expiry_imei_serial != '') {
                $this->db->where('pd.expiry_imei_serial', $expiry_imei_serial);
            }else{
                if($item_id!=''){
                    $this->db->where('pd.item_id', $item_id);
                }
                if($supplier_id != ''){
                    $this->db->where('p.supplier_id', $supplier_id);
                }
                if($outlet_id != ''){
                    $this->db->where('p.outlet_id', $outlet_id);
                }
            }
            $this->db->where('pd.company_id', $company_id);
            $this->db->where('pd.del_status', 'Live');
            $this->db->order_by('p.date', 'ASC');
            $this->db->group_by('pd.item_id');
            $this->db->group_by('p.date');
            $query_result = $this->db->get();
            $result = $query_result->result();
            return $result;
        endif;
    }


    /**
     * productSaleReport
     * @access public
     * @param string
     * @param string
     * @param int
     * @param int
     * @param int
     * @return object
     */
    public function productSaleReport($startMonth = '', $endMonth = '', $item_id = '', $customer_id = '', $outlet_id='') {
        $company_id = $this->session->userdata('company_id');
        if ($item_id):
            $this->db->select('s.sale_no,sum(sd.qty) as totalQuantity_amount,sd.menu_price_with_discount as unit_price,sd.menu_note, sd.food_menu_id,i.name,i.code,i.type,s.sale_date as date, u.unit_name, s.date_time');
            $this->db->from('tbl_sales_details sd');
            $this->db->join('tbl_sales s', 's.id = sd.sales_id', 'left');
            $this->db->join('tbl_items i', 'i.id = sd.food_menu_id', 'left');
            $this->db->join('tbl_units u', 'u.id = i.sale_unit_id', 'left');
            if ($startMonth != '' && $endMonth != '') {
                $this->db->where('s.sale_date>=', $startMonth);
                $this->db->where('s.sale_date <=', $endMonth);
            }
            if ($startMonth != '' && $endMonth == '') {
                $this->db->where('s.sale_date', $startMonth);
            }
            if ($startMonth == '' && $endMonth != '') {
                $this->db->where('s.sale_date', $endMonth);
            }
            if ($item_id !=''){
                $this->db->where('sd.food_menu_id', $item_id);
            }
            if ($customer_id !=''){
                $this->db->where('s.customer_id', $customer_id);
            }
            if ($outlet_id !=''){
                $this->db->where('sd.outlet_id', $outlet_id);
            }
            $this->db->where('i.type !=', 'Service_Product');
            $this->db->where('sd.delivery_status', 'Cash Received');
            $this->db->where('sd.company_id', $company_id);
            $this->db->where('sd.del_status', 'Live');
            $this->db->group_by('sd.food_menu_id');
            $query_result = $this->db->get();
            $result = $query_result->result();
            return $result;
        endif;
    }



    /**
     * saleWiseEmployeeReport
     * @access public
     * @param string
     * @param string
     * @param int
     * @param int
     * @return object
     */
    public function saleWiseEmployeeReport($startMonth = '', $endMonth = '', $outlet_id='', $user_id = '') {
        $company_id = $this->session->userdata('company_id');
        $this->db->select('s.date_time,s.id,s.sale_no,s.total_items,s.sub_total,s.paid_amount,s.total_payable,u.full_name as user_name, u.phone as user_phone, u.commission, c.name as customer_name, c.phone as customer_phone');
        $this->db->from('tbl_sales s');
        $this->db->join('tbl_customers c', 'c.id = s.customer_id', 'left');
        $this->db->join('tbl_users u', 'u.id = s.employee_id', 'left');
        if ($startMonth != '' && $endMonth != '') {
            $this->db->where('s.sale_date>=', $startMonth);
            $this->db->where('s.sale_date <=', $endMonth);
        }
        if ($startMonth != '' && $endMonth == '') {
            $this->db->where('s.sale_date', $startMonth);
        }
        if ($startMonth == '' && $endMonth != '') {
            $this->db->where('s.sale_date', $endMonth);
        }
        if($user_id != ''){
            $this->db->where('s.employee_id', $user_id);
        }
        if($outlet_id != ''){
            $this->db->where('s.outlet_id', $outlet_id);
        }
        $this->db->where('s.delivery_status', 'Cash Received');
        $this->db->where('s.company_id', $company_id);
        $this->db->order_by('s.sale_date', 'ASC');
        $query_result = $this->db->get();
        return $query_result->result();
    }


    /**
     * productWiseEmployeeReport
     * @access public
     * @param string
     * @param string
     * @param int
     * @param int
     * @return object
     */
    public function productWiseEmployeeReport($startMonth = '', $endMonth = '', $outlet_id='', $user_id = '') {
        $company_id = $this->session->userdata('company_id');
        $this->db->select('s.date_time,s.sale_no,u.commission, c.name as customer_name, c.phone as customer_phone, i.name as item_name, i.code,sd.qty,sd.menu_unit_price,sd.menu_price_with_discount as total_payable, ut.unit_name');
        $this->db->from('tbl_sales_details sd');
        $this->db->join('tbl_sales s', 's.id = sd.sales_id', 'left');
        $this->db->join('tbl_customers c', 'c.id = s.customer_id', 'left');
        $this->db->join('tbl_users u', 'u.id = sd.item_seller_id', 'left');
        $this->db->join('tbl_items i', 'i.id = sd.food_menu_id', 'left');
        $this->db->join('tbl_units ut', 'ut.id = i.sale_unit_id', 'left');
        if ($startMonth != '' && $endMonth != '') {
            $this->db->where('s.sale_date>=', $startMonth);
            $this->db->where('s.sale_date <=', $endMonth);
        }
        if ($startMonth != '' && $endMonth == '') {
            $this->db->where('s.sale_date', $startMonth);
        }
        if ($startMonth == '' && $endMonth != '') {
            $this->db->where('s.sale_date', $endMonth);
        }
        if($user_id != ''){
            $this->db->where('sd.item_seller_id', $user_id);
        }
        if($outlet_id != ''){
            $this->db->where('sd.outlet_id', $outlet_id);
        }
        $this->db->where('sd.delivery_status', 'Cash Received');
        $this->db->where('sd.company_id', $company_id);
        $this->db->order_by('sd.id', 'ASC');
        $query_result = $this->db->get();
        return $query_result->result();
    }
    /**
     * commboWiseEmployeeReport
     * @access public
     * @param string
     * @param string
     * @param int
     * @param int
     * @return object
     */
    public function commboWiseEmployeeReport($startMonth = '', $endMonth = '', $outlet_id='', $user_id = '') {
        $company_id = $this->session->userdata('company_id');
        $this->db->select('s.date_time,s.sale_no,u.commission, c.name as customer_name, c.phone as customer_phone, i.name as item_name, i.code,cs.combo_item_qty as qty, sum(cs.combo_item_price * cs.combo_item_qty) as total_payable, cs.combo_item_price as single_price, ut.unit_name');
        $this->db->from('tbl_combo_item_sales cs');
        $this->db->join('tbl_sales_details sd', 'sd.id = cs.combo_sale_item_id', 'left');
        $this->db->join('tbl_sales s', 's.id = sd.sales_id', 'left');
        $this->db->join('tbl_customers c', 'c.id = s.customer_id', 'left');
        $this->db->join('tbl_users u', 'u.id = cs.combo_item_seller_id', 'left');
        $this->db->join('tbl_items i', 'i.id = cs.combo_item_id', 'left');
        $this->db->join('tbl_units ut', 'ut.id = i.sale_unit_id', 'left');
        if ($startMonth != '' && $endMonth != '') {
            $this->db->where('s.sale_date>=', $startMonth);
            $this->db->where('s.sale_date <=', $endMonth);
        }
        if ($startMonth != '' && $endMonth == '') {
            $this->db->where('s.sale_date', $startMonth);
        }
        if ($startMonth == '' && $endMonth != '') {
            $this->db->where('s.sale_date', $endMonth);
        }
        if($user_id != ''){
            $this->db->where('cs.combo_item_seller_id', $user_id);
        }
        if($outlet_id != ''){
            $this->db->where('sd.outlet_id', $outlet_id);
        }
        $this->db->where('sd.company_id', $company_id);
        $this->db->group_by('cs.combo_item_id');
        $query_result = $this->db->get();
        return $query_result->result();
    }



    


    /**
     * damageReport
     * @access public
     * @param string
     * @param string
     * @param int
     * @param int
     * @return object
     */
    public function damageReport($startMonth = '', $endMonth = '', $employee_id = '', $outlet_id='') {
        $company_id = $this->session->userdata('company_id');
        $this->db->select('d.id,d.reference_no,d.added_date,d.total_loss,u.full_name as responsible_person');
        $this->db->from('tbl_damages d');
        $this->db->join('tbl_users as u', 'u.id = d.employee_id', 'left');
        if ($startMonth != '' && $endMonth != '') {
            $this->db->where('d.date>=', $startMonth);
            $this->db->where('d.date <=', $endMonth);
        }
        if ($startMonth != '' && $endMonth == '') {
            $this->db->where('d.date', $startMonth);
        }
        if ($startMonth == '' && $endMonth != '') {
            $this->db->where('d.date', $endMonth);
        }
        if ($employee_id != '') {
            $this->db->where('d.employee_id', $employee_id);
        }
        if($outlet_id != ''){
            $this->db->where('d.outlet_id', $outlet_id);
        }
        $this->db->where('d.company_id', $company_id);
        $this->db->where('d.del_status', 'Live');
        $this->db->order_by('d.date', 'ASC');
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }

    

    /**
     * getSupplierOpeningBalance
     * @access public
     * @param int
     * @return object
     */
    public function getSupplierOpeningBalance($supplier_id){
        $supplier = $this->db->query("SELECT opening_balance,opening_balance_type  FROM tbl_suppliers WHERE id=$supplier_id and del_status='Live'")->row();
        return $supplier;
    }



    /**
     * getRegisterInformation
     * @access public
     * @param int
     * @return object
     */
    public function getRegisterInformation($register_id){
        $this->db->select("r.*,u.full_name as user_name");
        $this->db->from('tbl_register r');
        $this->db->join('tbl_users u', 'u.id = r.user_id', 'left');
        $this->db->where("r.id", $register_id);
        return $this->db->get()->result();        
    }




    /**
     * expenseReport
     * @access public
     * @param string
     * @param string
     * @param int
     * @param int
     * @return object
     */
    public  function expenseReport($startMonth='',$endMonth='',$category_id='', $outlet_id=''){
        $company_id = $this->session->userdata('company_id');
        $this->db->select('e.date,e.reference_no,e.added_date, e.amount,emp.full_name as EmployeedName,ec.name as categoryName');
        $this->db->from('tbl_expenses e');
        $this->db->join('tbl_users as emp', 'emp.id = e.employee_id','left');
        $this->db->join('tbl_expense_items ec', 'ec.id = e.category_id','left');
        if($startMonth!='' && $endMonth!=''){
            $this->db->where('e.date>=', $startMonth);
            $this->db->where('e.date <=', $endMonth);
        }
        if($startMonth!='' && $endMonth==''){
            $this->db->where('e.date', $startMonth);
        }
        if($startMonth=='' && $endMonth!=''){
            $this->db->where('e.date', $endMonth);
        }
        if($category_id!=''){
            $this->db->where('e.category_id', $category_id);
        }
        if($outlet_id != ''){
            $this->db->where('e.outlet_id',$outlet_id);
        }
        $this->db->where('e.company_id',$company_id);
        $this->db->where('e.del_status','Live');
        $this->db->order_by('e.date', 'ASC');
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }

    /**
     * salaryReport
     * @access public
     * @param string
     * @param string
     * @param string
     * @param string
     * @param int
     * @return object
     */
    public  function salaryReport($startMonthNo='', $endMonthNo='', $startYear='', $endYear ='', $outlet_id=''){
        $company_id = $this->session->userdata('company_id');
        $this->db->select('s.date,s.added_date, s.year, s.month, s.total_amount, pm.name as payment_method_name');
        $this->db->from('tbl_salaries s');
        $this->db->join('tbl_payment_methods pm', 'pm.id = s.payment_id', 'left');
        if($startMonthNo != '' && $endMonthNo != ''){
            $this->db->where('s.month_no>=', $startMonthNo);
            $this->db->where('s.month_no <=', $endMonthNo);
        }
        if($startMonthNo != '' && $endMonthNo == ''){
            $this->db->where('s.month_no', $startMonthNo);
        }
        if($startMonthNo == '' && $endMonthNo != ''){
            $this->db->where('s.date', $endMonthNo);
        }
        if($startYear != '' && $endYear != ''){
            $this->db->where('s.year>=', $startYear);
            $this->db->where('s.year <=', $endYear);
        }
        if($startYear != '' && $endYear == ''){
            $this->db->where('s.year', $startYear);
        }
        if($startYear == '' && $endYear != ''){
            $this->db->where('s.year', $endYear);
        }
        if($outlet_id != ''){
            $this->db->where('s.outlet_id',$outlet_id);
        }
        $this->db->where('s.company_id',$company_id);
        $this->db->where('s.del_status','Live');
        $this->db->order_by('s.date', 'ASC');
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }

    /**
     * incomeReport
     * @access public
     * @param string
     * @param string
     * @param int
     * @param int
     * @return object
     */
    public  function incomeReport($startMonth='',$endMonth='',$category_id='', $outlet_id=''){
        $company_id = $this->session->userdata('company_id');
        $this->db->select('i.date,i.added_date, i.reference_no, i.amount,emp.full_name as EmployeedName,ii.name as categoryName');
        $this->db->from('tbl_incomes i');
        $this->db->join('tbl_users as emp', 'emp.id = i.employee_id','left');
        $this->db->join('tbl_income_items ii', 'ii.id = i.category_id','left');
        if($startMonth!='' && $endMonth!=''){
            $this->db->where('i.date>=', $startMonth);
            $this->db->where('i.date <=', $endMonth);
        }
        if($startMonth!='' && $endMonth==''){
            $this->db->where('i.date', $startMonth);
        }
        if($startMonth=='' && $endMonth!=''){
            $this->db->where('i.date', $endMonth);
        }

        if($category_id!=''){
            $this->db->where('i.category_id', $category_id);
        }
        if($outlet_id != ''){
            $this->db->where('i.outlet_id',$outlet_id);
        }
        $this->db->where('i.company_id', $company_id);
        $this->db->where('i.del_status','Live');
        $this->db->order_by('i.date', 'ASC');
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }

    /**
     * servicingReport
     * @access public
     * @param string
     * @param string
     * @param string
     * @param int
     * @param int
     * @return object
     */
    public  function servicingReport($startdate='',$enddate='',$status='', $employee_id='', $outlet_id=''){
        $company_id = $this->session->userdata('company_id');
        $this->db->select('s.*, c.name as customer_name, e.full_name as employee_name, a.full_name as added_by');
        $this->db->from('tbl_servicing s');
        $this->db->join('tbl_customers c', 'c.id = s.customer_id', 'left');
        $this->db->join('tbl_users e', 'e.id = s.employee_id', 'left');
        $this->db->join('tbl_users a', 'a.id = s.user_id', 'left');
        if($startdate!='' && $enddate!=''){
            $this->db->where('s.added_date>=', $startdate);
            $this->db->where('s.added_date <=', $enddate);
        }
        if($startdate!='' && $enddate==''){
            $this->db->where('s.added_date', $startdate);
        }
        if($startdate=='' && $enddate!=''){
            $this->db->where('s.added_date', $enddate);
        }
        if($status){
            $this->db->where('s.status', $status);
        }
        if($employee_id){
            $this->db->where('s.employee_id', $employee_id);
        }
        if($outlet_id){
            $this->db->where('s.outlet_id', $outlet_id);
        }
        $this->db->where('s.company_id', $company_id);
        $this->db->where('s.del_status','Live');
        $result = $this->db->get()->result();
        return $result;
    }


    /**
     * purchaseReturnReport
     * @access public
     * @param string
     * @param string
     * @param int
     * @param int
     * @return object
     */
    public  function purchaseReturnReport($startMonth='',$endMonth='', $supplier_id ='', $outlet_id=''){
        $company_id = $this->session->userdata('company_id');
        $this->db->select('pr.id,pr.reference_no, pr.added_date, pr.total_return_amount, s.name as supplier_name, p.name as payment_name');
        $this->db->from('tbl_purchase_return pr'); 
        $this->db->join('tbl_payment_methods p', 'p.id = pr.payment_method_id', 'left'); 
        $this->db->join('tbl_suppliers s', 's.id = pr.supplier_id', 'left'); 
        if($startMonth!='' && $endMonth!=''){
            $this->db->where('pr.date>=', $startMonth);
            $this->db->where('pr.date <=', $endMonth);
        }
        if($startMonth!='' && $endMonth==''){
            $this->db->where('pr.date', $startMonth);
        }
        if($startMonth=='' && $endMonth!=''){
            $this->db->where('pr.date', $endMonth);
        }
        if($supplier_id != ''){
            $this->db->where('pr.supplier_id',$supplier_id);
        }
        if($outlet_id != ''){
            $this->db->where('pr.outlet_id',$outlet_id);
        }
        $this->db->where('pr.return_status !=','draft');
        $this->db->where('pr.del_status','Live');
        $this->db->where('pr.company_id',$company_id);
        $this->db->order_by('pr.date', 'ASC');
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }

    /**
     * saleReturnReport
     * @access public
     * @param string
     * @param string
     * @param int
     * @param int
     * @return object
     */
    public  function saleReturnReport($startMonth='',$endMonth='', $customer_id ='', $outlet_id=''){
        $company_id = $this->session->userdata('company_id');
        $this->db->select('s.sale_no,sr.id,sr.reference_no,sr.date, c.name as customer_name, p.name as payment_name, sr.total_return_amount, sr.added_date');
        $this->db->from('tbl_sale_return sr'); 
        $this->db->join('tbl_sale_return_details srd', 'srd.sale_return_id = sr.id', 'left');
        $this->db->join('tbl_customers c', 'sr.customer_id = c.id', 'left');
        $this->db->join('tbl_sales s', 's.id = srd.sale_id', 'left');
        $this->db->join('tbl_payment_methods p', 'p.id = sr.payment_method_id', 'left');
        if($startMonth!='' && $endMonth!=''){
            $this->db->where('sr.date>=', $startMonth);
            $this->db->where('sr.date <=', $endMonth);
        }
        if($startMonth!='' && $endMonth==''){
            $this->db->where('sr.date', $startMonth);
        }
        if($startMonth=='' && $endMonth!=''){
            $this->db->where('sr.date', $endMonth);
        }
        if($customer_id  != ''){
            $this->db->where('sr.customer_id',$customer_id);
        }
        if($outlet_id  != ''){
            $this->db->where('sr.outlet_id',$outlet_id);
        }
        $this->db->where('sr.company_id',$company_id);
        $this->db->where('sr.del_status','Live');
        $this->db->order_by('sr.date', 'ASC');
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }


    /**
     * attendanceReport
     * @access public
     * @param string
     * @param string
     * @param int
     * @return object
     */
    public function attendanceReport($start_date = '', $end_date = '', $employee_id = '') {
        $company_id = $this->session->userdata('company_id');
        $this->db->select('a.reference_no, a.date, a.in_time, a.out_time, emp.full_name as employee_name, a.added_date');
        $this->db->from('tbl_attendance a');
        $this->db->join('tbl_users as emp', 'emp.id = a.employee_id', 'left'); 
        if ($start_date != '' && $end_date != '') {
            $this->db->where('a.date>=', $start_date);
            $this->db->where('a.date <=', $end_date);
        }
        if ($start_date != '' && $end_date == '') {
            $this->db->where('a.date', $start_date);
        }
        if ($start_date == '' && $end_date != '') {
            $this->db->where('a.date', $end_date);
        }
        if ($employee_id != '') {
            $this->db->where('a.employee_id', $employee_id);
        } 
        $this->db->where('a.company_id', $company_id);
        $this->db->where('a.del_status', 'Live');
        $this->db->order_by('a.date', 'ASC');
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }


    



    /**
     * getAllCustomersWithOpeningBalance
     * @access public
     * @param int
     * @return object
     * Added By Azhar
     */
    public function getAllCustomersWithOpeningBalance($customer_group = ''){
        $where = '';
        if($customer_group != ''){
            $where = "AND group_id = $customer_group";
        }else{
            $where = '';
        }
        $company_id = $this->session->userdata('company_id');
        $query = "SELECT 
        c.id, c.name, c.opening_balance, g.group_name,
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
            tbl_customer_groups g ON g.id = c.group_id
        LEFT JOIN 
            tbl_users u ON u.id = c.user_id
        WHERE
            c.company_id = ? AND c.del_status = 'Live' AND c.name != 'Walk-in Customer' $where
        GROUP BY 
            c.id";
        $result = $this->db->query($query, array($company_id))->result();
        return $result;  
    }



    /**
     * getAllDebitCustomers
     * @access public
     * @param int
     * @return object
     * Added By Azhar
     */
    public function getAllDebitCustomers($customer_group = ''){
        $where = '';
        if($customer_group != ''){
            $where = "AND group_id = $customer_group";
        }else{
            $where = '';
        }
        $company_id = $this->session->userdata('company_id');
        $query = "SELECT 
        c.id, c.name, c.opening_balance, g.group_name,
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
            tbl_customer_groups g ON g.id = c.group_id
        LEFT JOIN 
            tbl_users u ON u.id = c.user_id
        WHERE
            c.company_id = ? AND c.del_status = 'Live' AND c.name != 'Walk-in Customer' $where
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
     * @param int
     * @return object
     * Added By Azhar
     */
    public function getAllCreditCustomers($customer_group = ''){
        $where = '';
        if($customer_group != ''){
            $where = "AND group_id = $customer_group";
        }else{
            $where = '';
        }
        $company_id = $this->session->userdata('company_id');
        $query = "SELECT 
        c.id, c.name, c.opening_balance, g.group_name,
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
            tbl_customer_groups g ON g.id = c.group_id
            LEFT JOIN 
            tbl_users u ON u.id = c.user_id
        WHERE
            c.company_id = ? AND c.del_status = 'Live' AND c.name != 'Walk-in Customer' $where
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
     * @param int
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
            s.company_id = ? AND s.del_status = 'Live'";
        $result = $this->db->query($query, array($company_id))->result();
        return $result;     
    }



    /**
     * getAllDebitSuppliers
     * @access public
     * @param int
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
     * @param int
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
     * supplierLedgerReportWithDateRange
     * @access public
     * @param string
     * @param string
     * @param string
     * @param int
     * @param int
     * @return object
     * Added By Azhar
     */
    public function supplierLedgerReportWithDateRange($start_date, $end_date, $s_type, $supplier_id, $outlet_id){
        $company_id = $this->session->userdata('company_id');
        $selectString = '';
        if($s_type == 'Debit'){
            $selectString.= "0 as credit, opening_balance as debit";
        }else{
            $selectString.= "opening_balance as credit, 0 as debit";
        }
        if($outlet_id){
            $p_outlet_id = " and p.outlet_id ='$outlet_id'";
        }else{
            $p_outlet_id = '';
        }
        if($outlet_id){
            $pr_outlet_id = " and pr.outlet_id ='$outlet_id'";
        }else{
            $pr_outlet_id = '';
        }
        if($outlet_id){
            $r_outlet_id = " and r.outlet_id ='$outlet_id'";
        }else{
            $r_outlet_id = '';
        }
        $purchaseDateRange = '';
        if($start_date != '' && $end_date != ''){
            $purchaseDateRange.= " and p.date BETWEEN '".$start_date."' and '".$end_date."'";
        }
        $supplierPaymentDateRange = '';
        if($start_date != '' && $end_date != ''){
            $supplierPaymentDateRange.= "and pr.date BETWEEN '".$start_date."' and '".$end_date."'";
        }
        $purchaseReturnDateRange = '';
        if($start_date != '' && $end_date != ''){
            $purchaseReturnDateRange.= "and r.date BETWEEN '".$start_date."' and '".$end_date."'";
        }
        $result = $this->db->query("SELECT s.* FROM ( 
            (SELECT $selectString, '' as date, '' as id, 'Opening Balance' as type, '' as reference_no, '' as outlet_name FROM tbl_suppliers WHERE id=$supplier_id AND company_id = $company_id)
            UNION 
            (SELECT due_amount as credit, 0 as debit, p.date, p.id, 'Purchase Due Amount' as type, reference_no, o.outlet_name FROM tbl_purchase p, tbl_outlets o WHERE p.supplier_id=$supplier_id AND p.outlet_id = o.id AND p.due_amount != 0 AND p.del_status='Live' AND p.company_id = $company_id $purchaseDateRange $p_outlet_id) 
            UNION 
            (SELECT 0 as credit, pr.amount as debit, pr.date, pr.id, 'Supplier Due Payment' as type, pr.reference_no, o.outlet_name FROM tbl_supplier_payments pr, tbl_outlets o WHERE pr.supplier_id=$supplier_id AND pr.outlet_id = o.id AND pr.del_status='Live' AND pr.company_id = $company_id $supplierPaymentDateRange $pr_outlet_id) 
            UNION 
            (SELECT 0 as credit,r.total_return_amount as debit, r.date, r.id,  'Purchase Return' as type, r.reference_no, o.outlet_name FROM tbl_purchase_return r, tbl_purchase per, tbl_outlets o WHERE r.supplier_id=$supplier_id AND r.outlet_id = o.id AND r.del_status='Live' AND r.supplier_id=per.supplier_id AND r.company_id = $company_id $purchaseReturnDateRange $r_outlet_id) 
        ) as s ORDER BY s.date ASC")->result();
        return $result;
    }

    /**
     * customerLedgerReportWithDateRange
     * @access public
     * @param string
     * @param string
     * @param string
     * @param int
     * @param int
     * @return object
     * Added By Azhar
     */
    public function customerLedgerReportWithDateRange($start_date='', $end_date='', $c_type='', $customer_id='', $outlet_id=''){
        $company_id = $this->session->userdata('company_id');
        $selectString = '';
        if($c_type == 'Debit'){
            $selectString.= "0 as credit, opening_balance as debit";
        }else{
            $selectString.= "opening_balance as credit, 0 as debit";
        }
        if($outlet_id){
            $s_outlet_id = " and s.outlet_id = '$outlet_id'";
        }else{
            $s_outlet_id = '';
        }
        if($outlet_id){
            $cr_outlet_id = " and cr.outlet_id = '$outlet_id'";
        }else{
            $cr_outlet_id = '';
        }
        if($outlet_id){
            $sr_outlet_id = " and sr.outlet_id = '$outlet_id'";
        }else{
            $sr_outlet_id = '';
        }
        $saleDateRange = "";
        if($start_date != '' && $end_date != ''){
            $saleDateRange.= " and s.sale_date BETWEEN '".$start_date."' and '".$end_date."'";
        }
        $customerDueReceiveDateRange = "";
        if($start_date != '' && $end_date != ''){
            $customerDueReceiveDateRange.= " and cr.date BETWEEN '".$start_date."' and '".$end_date."'";
        }
        $saleReturnDateRange = "";
        if($start_date != '' && $end_date != ''){
            $saleReturnDateRange.= " and sr.date BETWEEN '".$start_date."' and '".$end_date."'";
        }
        $result = $this->db->query("SELECT c.* FROM (
            (SELECT $selectString, '' as date, '' as id, 'Opening Balance' as type, '' as reference_no, '' as outlet_name FROM tbl_customers WHERE id=$customer_id AND company_id = $company_id)

            UNION 
            (SELECT 0 as credit, due_amount as debit, s.sale_date as date, s.id, 'Sale Due Amount' as type, s.sale_no as reference_no, o.outlet_name
            FROM tbl_sales s 
            JOIN tbl_outlets o ON s.outlet_id = o.id 
            WHERE s.customer_id=$customer_id and s.due_amount != 0 and s.del_status='Live' AND s.company_id = $company_id $saleDateRange $s_outlet_id) 

            UNION 
            (SELECT cr.amount as credit, 0 as debit, cr.date as date, cr.id, 'Customer Due Receive' as type, cr.reference_no as reference_no, o.outlet_name
            FROM tbl_customer_due_receives cr 
            JOIN tbl_outlets o ON cr.outlet_id = o.id 
            WHERE cr.customer_id=$customer_id and cr.del_status='Live' AND cr.company_id = $company_id $customerDueReceiveDateRange $cr_outlet_id) 

            UNION 
            (SELECT sr.due as credit, 0 as debit, sr.date as date, sr.id, 'Sale Return' as type, sr.reference_no, o.outlet_name
            FROM tbl_sale_return sr 
            JOIN tbl_outlets o ON sr.outlet_id = o.id 
            WHERE sr.customer_id=$customer_id and sr.due != 0 and sr.del_status='Live' AND sr.company_id = $company_id $saleReturnDateRange $sr_outlet_id) 
        ) as c ORDER BY c.date ASC")->result();
        return $result;
    }


    /**
     * getTotalTransaction
     * @access public
     * @param string
     * @param string
     * @param int
     * @return object
     */
    public function getTotalTransaction($start_date, $end_date,$outlet_id='') {
        $company_id = $this->session->userdata('company_id');
        if ($start_date || $end_date):
            $this->db->select('count(id) as total_transaction');
            $this->db->from('tbl_sales');
            if ($start_date != '' && $end_date != '') {
                $this->db->where('sale_date>=', $start_date);
                $this->db->where('sale_date <=', $end_date);
            }
            if ($start_date != '' && $end_date == '') {
                $this->db->where('sale_date', $start_date);
            }
            if ($start_date == '' && $end_date != '') {
                $this->db->where('sale_date', $end_date);
            }
            $this->db->where('outlet_id', $outlet_id);
            $this->db->where('company_id', $company_id);
            $this->db->where("del_status", 'Live');
            $sales = $this->db->get()->row();
            return $sales;
        endif;
    }

    /**
     * getTotalCustomer
     * @access public
     * @param string
     * @param string
     * @param int
     * @return object
     */
    public function getTotalCustomer($start_date, $end_date,$outlet_id='') {
        $company_id = $this->session->userdata('company_id');
        if ($start_date || $end_date):
            $this->db->select('count(id) as total_customers');
            $this->db->from('tbl_sales');
            if ($start_date != '' && $end_date != '') {
                $this->db->where('sale_date>=', $start_date);
                $this->db->where('sale_date <=', $end_date);
            }
            if ($start_date != '' && $end_date == '') {
                $this->db->where('sale_date', $start_date);
            }
            if ($start_date == '' && $end_date != '') {
                $this->db->where('sale_date', $end_date);
            }
            $this->db->where('outlet_id', $outlet_id);
            $this->db->where('company_id', $company_id);
            $this->db->where("del_status", 'Live');
            $sales = $this->db->get()->row();
            return $sales;
        endif;
    }


    /**
     * itemMoving
     * @access public
     * @param string
     * @param string
     * @param string
     * @param int
     * @param int
     * @return object
     * Added By Azhar
     */
    public function itemMoving($start_date='', $end_date='', $item_id='', $outlet_id=''){
        if($item_id){
            $company_id = $this->session->userdata('company_id');
            if($outlet_id){
                $s_outlet_id = " and s.outlet_id = '$outlet_id'";
            }else{
                $s_outlet_id = '';
            }
            if($outlet_id){
                $sr_outlet_id = " and sr.outlet_id = '$outlet_id'";
            }else{
                $sr_outlet_id = '';
            }
            if($outlet_id){
                $i_outlet_id = " and i.outlet_id = '$outlet_id'";
            }else{
                $i_outlet_id = '';
            }
            if($outlet_id){
                $p_outlet_id = " and p.outlet_id = '$outlet_id'";
            }else{
                $p_outlet_id = '';
            }
            if($outlet_id){
                $pr_outlet_id = " and pr.outlet_id = '$outlet_id'";
            }else{
                $pr_outlet_id = '';
            }
            if($outlet_id){
                $d_outlet_id = " and d.outlet_id = '$outlet_id'";
            }else{
                $d_outlet_id = '';
            }
            if($outlet_id){
                $t_outlet_id = " and t.from_outlet_id = '$outlet_id'";
            }else{
                $t_outlet_id = '';
            }
            // Date Dynamic Select
            $saleDateRange = "";
            if($start_date != '' && $end_date != ''){
                $saleDateRange.= " and s.sale_date BETWEEN '".$start_date."' and '".$end_date."'";
            }
            $saleReturnDateRange = "";
            if($start_date != '' && $end_date != ''){
                $saleReturnDateRange.= " and sr.date BETWEEN '".$start_date."' and '".$end_date."'";
            }
            $installmentDateRange = "";
            if($start_date != '' && $end_date != ''){
                $installmentDateRange.= " and i.date BETWEEN '".$start_date."' and '".$end_date."'";
            }
            $purchaseDateRange = "";
            if($start_date != '' && $end_date != ''){
                $purchaseDateRange.= " and p.date BETWEEN '".$start_date."' and '".$end_date."'";
            }
            $purchaseReturnDateRange = "";
            if($start_date != '' && $end_date != ''){
                $purchaseReturnDateRange.= " and pr.date BETWEEN '".$start_date."' and '".$end_date."'";
            }
            $damageDateRange = "";
            if($start_date != '' && $end_date != ''){
                $damageDateRange.= " and d.date BETWEEN '".$start_date."' and '".$end_date."'";
            }
            $transferDateRange = "";
            if($start_date != '' && $end_date != ''){
                $transferDateRange.= " and t.date BETWEEN '".$start_date."' and '".$end_date."'";
            }
            $transferOutDateRange = "";
            if($start_date != '' && $end_date != ''){
                $transferOutDateRange.= " and tt.date BETWEEN '".$start_date."' and '".$end_date."'";
            }
            

            $result = $this->db->query("SELECT it.* FROM (
                (SELECT 0 as in_qty, 0 as out_qty, '' as date, 'Opening Stock' as type, '' as reference_no, '' as outlet_name
                FROM tbl_set_opening_stocks 
                WHERE company_id = $company_id) 

                UNION
                (SELECT 0 as in_qty, SUM(sd.qty) as out_qty, s.date_time as date, 'Sale' as type, s.sale_no as reference_no, o.outlet_name
                FROM tbl_sales s 
                JOIN tbl_outlets o ON s.outlet_id = o.id 
                JOIN tbl_sales_details sd ON sd.sales_id = s.id 
                WHERE sd.food_menu_id=$item_id and s.del_status='Live' AND s.company_id = $company_id $saleDateRange $s_outlet_id GROUP BY s.outlet_id HAVING out_qty > 0) 

                UNION
                (SELECT SUM(srd.return_quantity_amount) as in_qty, 0 as out_qty, sr.added_date as date, 'Sale Return' as type, sr.reference_no as reference_no, o.outlet_name
                FROM tbl_sale_return sr 
                JOIN tbl_outlets o ON sr.outlet_id = o.id 
                JOIN tbl_sale_return_details srd ON srd.sale_return_id = sr.id 
                WHERE srd.item_id=$item_id and sr.del_status='Live' AND sr.company_id = $company_id $saleReturnDateRange $sr_outlet_id HAVING in_qty > 0)  

                UNION
                (SELECT 0 as in_qty, '1' as out_qty, i.added_date as date, 'Installment Sale' as type, i.reference_no as reference_no, o.outlet_name
                FROM tbl_installments i 
                JOIN tbl_outlets o ON i.outlet_id = o.id 
                WHERE i.item_id=$item_id and i.del_status='Live' AND i.company_id = $company_id $installmentDateRange $i_outlet_id HAVING out_qty > 0) 

                UNION
                (SELECT SUM(pd.quantity_amount) as in_qty, 0 as out_qty, p.added_date as date, 'Purchase' as type, p.reference_no as reference_no, o.outlet_name
                FROM tbl_purchase p
                JOIN tbl_outlets o ON p.outlet_id = o.id 
                JOIN tbl_purchase_details pd ON pd.purchase_id = p.id 
                WHERE pd.item_id=$item_id and p.del_status='Live' AND p.company_id = $company_id $purchaseDateRange $p_outlet_id HAVING in_qty > 0)

                UNION
                (SELECT 0 as in_qty, SUM(prd.return_quantity_amount) as out_qty, pr.added_date as date, 'Purchase Return' as type, pr.reference_no as reference_no, o.outlet_name
                FROM tbl_purchase_return pr 
                JOIN tbl_outlets o ON pr.outlet_id = o.id 
                JOIN tbl_purchase_return_details prd ON prd.pur_return_id = pr.id 
                WHERE prd.item_id=$item_id and pr.del_status='Live' AND pr.company_id = $company_id $purchaseReturnDateRange $pr_outlet_id HAVING out_qty > 0) 

                UNION
                (SELECT 0 as in_qty, SUM(dd.damage_quantity) as out_qty, d.added_date as date, 'Damage' as type, d.reference_no as reference_no, o.outlet_name
                FROM tbl_damages d 
                JOIN tbl_outlets o ON d.outlet_id = o.id 
                JOIN tbl_damage_details dd ON dd.damage_id = d.id 
                WHERE dd.item_id=$item_id and d.del_status='Live' AND d.company_id = $company_id $damageDateRange $d_outlet_id HAVING out_qty > 0) 

                UNION
                (SELECT SUM(td.quantity_amount) as in_qty, 0 as out_qty, t.added_date as date, 'Transfer In' as type, t.reference_no as reference_no, o.outlet_name
                FROM tbl_transfer t
                JOIN tbl_outlets o ON t.outlet_id = o.id 
                JOIN tbl_transfer_items td ON td.transfer_id = t.id 
                WHERE td.ingredient_id=$item_id and td.status='1' and td.to_outlet_id='$outlet_id' and t.del_status='Live' AND t.company_id = $company_id $transferDateRange  HAVING in_qty > 0)

                UNION
                (SELECT 0 as in_qty, SUM(tdo.quantity_amount) as out_qty, tt.added_date as date, 'Transfer Out' as type, tt.reference_no as reference_no, o.outlet_name
                FROM tbl_transfer tt
                JOIN tbl_outlets o ON tt.outlet_id = o.id 
                JOIN tbl_transfer_items tdo ON tdo.transfer_id = tt.id 
                WHERE tdo.ingredient_id=$item_id and tdo.status='3' and tdo.from_outlet_id='$outlet_id' and tt.del_status='Live' AND tt.company_id = $company_id $transferOutDateRange  HAVING out_qty > 0)

            ) as it ORDER BY it.date ASC")->result();
            return $result;
        }
    }

    /**
     * priceHistory
     * @access public
     * @param string
     * @param string
     * @param int
     * @param int
     * @return object
     * Added By Azhar
     */
    public function priceHistory($start_date='', $end_date='', $item_id='', $outlet_id=''){
        if($item_id){
            $company_id = $this->session->userdata('company_id');
            if($outlet_id){
                $s_outlet_id = " and sd.outlet_id = '$outlet_id'";
            }else{
                $s_outlet_id = '';
            }
            if($outlet_id){
                $sr_outlet_id = " and srd.outlet_id = '$outlet_id'";
            }else{
                $sr_outlet_id = '';
            }
            if($outlet_id){
                $i_outlet_id = " and i.outlet_id = '$outlet_id'";
            }else{
                $i_outlet_id = '';
            }
            if($outlet_id){
                $p_outlet_id = " and p.outlet_id = '$outlet_id'";
            }else{
                $p_outlet_id = '';
            }
            if($outlet_id){
                $pr_outlet_id = " and pr.outlet_id = '$outlet_id'";
            }else{
                $pr_outlet_id = '';
            }
            if($outlet_id){
                $d_outlet_id = " and d.outlet_id = '$outlet_id'";
            }else{
                $d_outlet_id = '';
            }
            // Date Dynamic Select
            $saleDateRange = "";
            if($start_date != '' && $end_date != ''){
                $saleDateRange.= " and s.sale_date BETWEEN '".$start_date."' and '".$end_date."'";
            }
            $saleReturnDateRange = "";
            if($start_date != '' && $end_date != ''){
                $saleReturnDateRange.= " and sr.date BETWEEN '".$start_date."' and '".$end_date."'";
            }
            $installmentDateRange = "";
            if($start_date != '' && $end_date != ''){
                $installmentDateRange.= " and i.date BETWEEN '".$start_date."' and '".$end_date."'";
            }
            $purchaseDateRange = "";
            if($start_date != '' && $end_date != ''){
                $purchaseDateRange.= " and p.date BETWEEN '".$start_date."' and '".$end_date."'";
            }
            $purchaseReturnDateRange = "";
            if($start_date != '' && $end_date != ''){
                $purchaseReturnDateRange.= " and pr.date BETWEEN '".$start_date."' and '".$end_date."'";
            }
            $damageDateRange = "";
            if($start_date != '' && $end_date != ''){
                $damageDateRange.= " and d.date BETWEEN '".$start_date."' and '".$end_date."'";
            }
            $result = $this->db->query("SELECT it.* FROM (

                (SELECT (i.purchase_price / i.conversion_rate) as item_price, '' as date, 'Opening Stock Price' as type, '' as reference_no, '' as outlet_name
                FROM tbl_items i 
                WHERE i.id=$item_id and i.enable_disable_status and i.del_status='Live' AND i.company_id = $company_id) 

                UNION
                (SELECT sd.menu_unit_price as item_price,s.date_time as date, 'Sale' as type, s.sale_no as reference_no, o.outlet_name
                FROM tbl_sales_details sd
                JOIN tbl_sales s ON sd.sales_id = s.id 
                JOIN tbl_outlets o ON s.outlet_id = o.id 
                WHERE sd.food_menu_id=$item_id and sd.del_status='Live' AND sd.company_id = $company_id $saleDateRange $s_outlet_id GROUP BY sd.outlet_id) 

                UNION
                (SELECT srd.unit_price_in_sale as item_price, sr.added_date as date, 'Sale Return' as type, sr.reference_no as reference_no, o.outlet_name
                FROM tbl_sale_return_details srd 
                JOIN tbl_sale_return sr ON srd.sale_return_id = sr.id 
                JOIN tbl_outlets o ON sr.outlet_id = o.id 
                WHERE srd.item_id=$item_id and sr.del_status='Live' AND sr.company_id = $company_id $saleReturnDateRange $sr_outlet_id)  

                UNION
                (SELECT i.price as item_price,i.added_date as date, 'Installment Sale' as type, i.reference_no as reference_no, o.outlet_name
                FROM tbl_installments i 
                JOIN tbl_outlets o ON i.outlet_id = o.id 
                WHERE i.item_id=$item_id and i.del_status='Live' AND i.company_id = $company_id $installmentDateRange $i_outlet_id) 

                UNION
                (SELECT pd.divided_price as item_price, p.added_date as date, 'Purchase' as type, p.reference_no as reference_no, o.outlet_name
                FROM tbl_purchase_details pd 
                JOIN tbl_purchase p ON pd.purchase_id = p.id 
                JOIN tbl_outlets o ON p.outlet_id = o.id 
                WHERE pd.item_id=$item_id and p.del_status='Live' AND p.company_id = $company_id $purchaseDateRange $p_outlet_id)

                UNION
                (SELECT prd.unit_price as item_price, pr.added_date as date, 'Purchase Return' as type, pr.reference_no as reference_no, o.outlet_name
                FROM tbl_purchase_return_details prd 
                JOIN tbl_purchase_return pr ON prd.pur_return_id = pr.id 
                JOIN tbl_outlets o ON pr.outlet_id = o.id 
                WHERE prd.item_id=$item_id and pr.del_status='Live' AND pr.company_id = $company_id $purchaseReturnDateRange $pr_outlet_id) 

                UNION
                (SELECT dd.loss_amount as item_price, d.added_date as date, 'Damage' as type, d.reference_no as reference_no, o.outlet_name
                FROM tbl_damage_details dd 
                JOIN tbl_damages d ON dd.damage_id = d.id 
                JOIN tbl_outlets o ON d.outlet_id = o.id 
                WHERE dd.item_id=$item_id and d.del_status='Live' AND d.company_id = $company_id $damageDateRange $d_outlet_id) 

            ) as it ORDER BY it.date ASC")->result();
            return $result;
        }
        
    }
    


    /**
     * cashFlowReport
     * @access public
     * @param string
     * @param string
     * @param int
     * @param int
     * @return object
     * Added By Azhar
     */
    public function cashFlowReport($start_date='', $end_date='', $outlet_id=''){
        $company_id = $this->session->userdata('company_id');        

        if($outlet_id){
            $cr_outlet_id = " and cr.outlet_id = '$outlet_id'";
            $dp_outlet_id = " and dp.outlet_id = '$outlet_id'";
            $dpd_outlet_id = " and dpd.outlet_id = '$outlet_id'";
            $e_outlet_id = " and e.outlet_id = '$outlet_id'";
            $i_outlet_id = " and i.outlet_id = '$outlet_id'";
            $dow_outlet_id = " and dow.outlet_id = '$outlet_id'";
            $ins_outlet_id = " and ins.outlet_id = '$outlet_id'";
            $pp_outlet_id = " and pp.outlet_id = '$outlet_id'";
            $pr_outlet_id = " and pr.outlet_id = '$outlet_id'";
            $sl_outlet_id = " and sl.outlet_id = '$outlet_id'";
            $sp_outlet_id = " and sp.outlet_id = '$outlet_id'";
            $sr_outlet_id = " and sr.outlet_id = '$outlet_id'";
            $ser_outlet_id = " and ser.outlet_id = '$outlet_id'";
        }else{
            $cr_outlet_id = '';
            $dp_outlet_id = '';
            $dpd_outlet_id = '';
            $e_outlet_id = '';
            $i_outlet_id = '';
            $dow_outlet_id = '';
            $ins_outlet_id = '';
            $pp_outlet_id = '';
            $pr_outlet_id = '';
            $sl_outlet_id = '';
            $sp_outlet_id = '';
            $sr_outlet_id = '';
            $ser_outlet_id = '';
        }

        $dueReceiveDateRange = "";
        $depositDateRange = "";
        $withdrawDateRange = "";
        $expenseDateRange = "";
        $incomeDateRange = "";
        $dowDateRange = "";
        $insDateRange = "";
        $ppDateRange = "";
        $prDateRange = "";
        $slDateRange = "";
        $spDateRange = "";
        $srDateRange = "";
        $serDateRange = "";

        if($start_date != '' && $end_date != ''){
            $dueReceiveDateRange.= " and cr.date BETWEEN '".$start_date."' and '".$end_date."'";
            $depositDateRange.= " and dp.date BETWEEN '".$start_date."' and '".$end_date."'";
            $withdrawDateRange.= " and dpd.date BETWEEN '".$start_date."' and '".$end_date."'";
            $expenseDateRange.= " and e.date BETWEEN '".$start_date."' and '".$end_date."'";
            $incomeDateRange.= " and i.date BETWEEN '".$start_date."' and '".$end_date."'";
            $dowDateRange.= " and dow.date BETWEEN '".$start_date."' and '".$end_date."'";
            $insDateRange.= " and ins.paid_date BETWEEN '".$start_date."' and '".$end_date."'";
            $ppDateRange.= " and pp.added_date BETWEEN '".$start_date."' and '".$end_date."'";
            $prDateRange.= " and pr.date BETWEEN '".$start_date."' and '".$end_date."'";
            $slDateRange.= " and sl.date BETWEEN '".$start_date."' and '".$end_date."'";
            $spDateRange.= " and sp.date BETWEEN '".$start_date."' and '".$end_date."'";
            $srDateRange.= " and sr.date BETWEEN '".$start_date."' and '".$end_date."'";
            $serDateRange.= " and ser.date BETWEEN '".$start_date."' and '".$end_date."'";
        }

        $query = '';
        if(!moduleIsHideCheck('Installment Sale-YES')){ 
            $query .="UNION 
            (SELECT dow.down_payment as credit, '' as debit, dow.date as date, 'Installment Payment' as type, dow.reference_no as reference_no, o.outlet_name
            FROM tbl_installments dow
            JOIN tbl_outlets o ON dow.outlet_id = o.id 
            WHERE dow.payment_method_id=2 and dow.down_payment != 0 and dow.del_status='Live' $dowDateRange $dow_outlet_id) 

            UNION 
            (SELECT ins.paid_amount as credit, '' as debit, ins.paid_date as date, 'Installment Payment' as type, '' as reference_no, o.outlet_name
            FROM tbl_installment_items ins
            JOIN tbl_outlets o ON ins.outlet_id = o.id 
            WHERE ins.payment_method_id=2 and ins.paid_amount != 0 and ins.paid_status = 'Paid' and ins.del_status='Live' $insDateRange $ins_outlet_id)"; 
        }

        $query2 = '';
        if(!moduleIsHideCheck('Servicing-YES')){ 
            $query2 .="UNION 
            (SELECT ser.servicing_charge as credit, '' as debit, ser.date as date, 'Servicing' as type, '' as reference_no, o.outlet_name
            FROM tbl_servicing ser
            JOIN tbl_outlets o ON ser.outlet_id = o.id 
            WHERE ser.payment_method_id=2 and ser.servicing_charge != 0 and ser.del_status='Live' $serDateRange $ser_outlet_id)"; 
        }


        

        $result = $this->db->query("SELECT c.* FROM (
            (SELECT current_balance as credit, '' as debit, '' as date, 'Opening Balance' as type, '' as reference_no, '' as outlet_name FROM tbl_payment_methods WHERE id=2 AND company_id = $company_id)

            UNION 
            (SELECT cr.amount as credit, '' as debit, cr.date as date, 'Customer Due Receive' as type, cr.reference_no as reference_no, o.outlet_name
            FROM tbl_customer_due_receives cr 
            JOIN tbl_outlets o ON cr.outlet_id = o.id 
            WHERE cr.payment_method_id=2 and cr.amount != 0 and cr.del_status='Live' $dueReceiveDateRange $cr_outlet_id) 

            UNION 
            (SELECT dp.amount as credit, '' as debit, dp.date as date, 'Deposit' as type, dp.reference_no as reference_no, o.outlet_name
            FROM tbl_deposits dp 
            JOIN tbl_outlets o ON dp.outlet_id = o.id 
            WHERE dp.payment_method_id=2 and dp.amount != 0 and dp.type = 'Deposit' and dp.del_status='Live' $depositDateRange $dp_outlet_id) 

            UNION 
            (SELECT 0 as credit, dpd.amount as debit, dpd.date as date, 'Deposit' as type, dpd.reference_no as reference_no, o.outlet_name
            FROM tbl_deposits dpd 
            JOIN tbl_outlets o ON dpd.outlet_id = o.id 
            WHERE dpd.payment_method_id=2 and dpd.amount != 0 and dpd.type = 'Withdraw' and dpd.del_status='Live' $withdrawDateRange $dpd_outlet_id) 
            
            UNION 
            (SELECT 0 as credit, e.amount as debit, e.date as date, 'Expense' as type, e.reference_no as reference_no, o.outlet_name
            FROM tbl_expenses e 
            JOIN tbl_outlets o ON e.outlet_id = o.id 
            WHERE e.payment_method_id=2 and e.amount != 0 and e.del_status='Live' $expenseDateRange $e_outlet_id)

            UNION 
            (SELECT 0 as credit, i.amount as debit, i.date as date, 'Income' as type, i.reference_no as reference_no, o.outlet_name
            FROM tbl_incomes i
            JOIN tbl_outlets o ON i.outlet_id = o.id 
            WHERE i.payment_method_id=2 and i.amount != 0 and i.del_status='Live' $incomeDateRange $i_outlet_id) 

            $query 

            UNION 
            (SELECT '' as credit, pp.amount as debit, pp.added_date as date, 'Purchase Payment' as type, '' as reference_no, o.outlet_name
            FROM tbl_purchase_payments pp
            JOIN tbl_outlets o ON pp.outlet_id = o.id 
            JOIN tbl_purchase p ON p.id = pp.purchase_id 
            WHERE pp.payment_id=2 and pp.amount != 0 and pp.del_status='Live' $ppDateRange $pp_outlet_id) 

            UNION 
            (SELECT pr.total_return_amount as credit, '' as debit, pr.date as date, 'Purchase Return' as type, pr.reference_no as reference_no, o.outlet_name
            FROM tbl_purchase_return pr
            JOIN tbl_outlets o ON pr.outlet_id = o.id 
            WHERE pr.payment_method_id=2 and pr.total_return_amount != 0 and pr.return_status = 'taken_by_sup_money_returned'  and pr.del_status='Live' $prDateRange $pr_outlet_id) 

            UNION 
            (SELECT  '' as credit, sl.total_amount as debit, sl.date as date, 'Salary' as type, '' as reference_no, o.outlet_name
            FROM tbl_salaries sl
            JOIN tbl_outlets o ON sl.outlet_id = o.id 
            WHERE sl.payment_id=2  and sl.del_status='Live' $slDateRange $sl_outlet_id) 

            UNION 
            (SELECT sp.amount as credit, '' as debit, sp.date as date, 'Sale Payment' as type, s.sale_no as reference_no, o.outlet_name
            FROM tbl_sale_payments sp
            JOIN tbl_outlets o ON sp.outlet_id = o.id 
            JOIN tbl_sales s ON s.id = sp.sale_id 
            WHERE sp.payment_id=2 and sp.amount != 0 and sp.del_status='Live' $spDateRange $sp_outlet_id) 

            UNION 
            (SELECT '' as credit, sr.total_return_amount as debit, sr.date as date, 'Sale Return' as type, sr.reference_no as reference_no, o.outlet_name
            FROM tbl_sale_return sr
            JOIN tbl_outlets o ON sr.outlet_id = o.id 
            WHERE sr.payment_method_id=2 and sr.total_return_amount != 0 and sr.del_status='Live' $srDateRange $sr_outlet_id)
            
            $query2
            
        ) as c ORDER BY c.date ASC")->result();
        return $result;
    }

    /**
     * registerDetailsByDate
     * @access public
     * @param string
     * @param int
     * @param int
     * @return object
     */
    public function registerDetailsByDate($date, $user_id='', $outlet_id=''){
        $company_id = $this->session->userdata('company_id');
        $this->db->select("id,opening_balance_date_time,closing_balance_date_time");
        $this->db->from('tbl_register');
        $this->db->where("DATE(opening_balance_date_time)", $date);
        if($outlet_id != ''){
            $this->db->where("outlet_id", $outlet_id);
        }
        if($user_id != ''){
            $this->db->where("user_id", $user_id);
        }
        $this->db->where('company_id', $company_id);
        $this->db->where('del_status','Live');
        return $this->db->get()->result();   
    }


    /**
     * getStockReport
     * @access public
     * @param int
     * @param string
     * @param int
     * @param int
     * @param int
     * @param string
     * @return object
     */
    public function getStockReport($item_id="",$item_code="",$brand_id="",$category_id="",$supplier_id="", $generic_name = "", $outlet_id="") {
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
            p.id, p.name, p.code, p.type, p.alert_quantity, p.unit_type, p.expiry_date_maintain, p.last_three_purchase_avg, p.last_purchase_price, p.conversion_rate, 
            c.name as category_name, pu.unit_name as purchase_unit, su.unit_name as sale_unit,
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
    /**
     * getExpiryStock
     * @access public
     * @param int
     * @param string
     * @param int
     * @param int
     * @param int
     * @param string
     * @return object
     */
    public function getExpiryStock($generic_name = "", $outlet_id="") {
        $where = '';
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
            p.id, p.name, p.code, p.type, p.alert_quantity, p.unit_type, p.expiry_date_maintain, p.last_three_purchase_avg, p.last_purchase_price, p.conversion_rate, 
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
            WHERE p.type = 'Medicine_Product' AND p.company_id='$company_id' AND p.enable_disable_status = 'Enable' AND p.del_status = 'Live' $where 
            ORDER BY p.name ASC")->result();
            return $data;
    }
    /**
     * getStockReport
     * @access public
     * @param int
     * @param string
     * @param int
     * @param int
     * @param int
     * @param string
     * @return object
     */
    public function getStockAlertList($item_id="",$item_code="",$brand_id="",$category_id="",$supplier_id="", $generic_name = "", $outlet_id="") {
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
            p.id, p.name, p.code, p.type, p.alert_quantity, p.unit_type, p.expiry_date_maintain, p.last_three_purchase_avg, p.last_purchase_price, p.conversion_rate, 
            c.name as category_name, pu.unit_name as purchase_unit, su.unit_name as sale_unit,
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
            GROUP BY p.id
            HAVING 
                CASE 
                    WHEN p.type = 'Variation_Product' THEN TRUE
                    WHEN p.type = 'Medicine_Product' THEN TRUE
                    ELSE (stock_qty - out_qty) < p.alert_quantity
                END
            ORDER BY p.name ASC")->result();
            return $data;
    }


    /**
     * sub_total_foods
     * @access public
     * @param string
     * @param int
     * @return object
     */
    public function sub_total_foods($startMonth = '', $outlet_id = '') {
        $company_id =  $this->session->userdata('company_id');
    
        // First, calculate sub_total_foods
        $this->db->select('SUM(sd.menu_price_without_discount) as sub_total_foods');
        $this->db->from('tbl_sales_details sd');
        $this->db->join('tbl_sales s', 's.id = sd.sales_id', 'left');
        $this->db->where('s.sale_date', $startMonth);
        $this->db->where('sd.outlet_id', $outlet_id);
        $this->db->where('sd.company_id', $company_id); 
        $this->db->where('sd.del_status', 'Live');
        $query_subtotal = $this->db->get();
        $sub_total_foods = $query_subtotal->row()->sub_total_foods;
  
    
        // Then, calculate total_due independently to avoid duplicate sums
        $this->db->select('SUM(s.due_amount) as total_due');
        $this->db->from('tbl_sales s');
        $this->db->where('s.sale_date', $startMonth);
        $this->db->where('s.outlet_id', $outlet_id);
        $this->db->where('s.company_id', $company_id);
        $query_due = $this->db->get();
        $total_due = $query_due->row()->total_due;

        //Daily Sales Return
        $this->db->select('SUM(sr.paid) as total_return');
        $this->db->from('tbl_sale_return sr');
        $this->db->where('sr.date', $startMonth);
        $this->db->where('sr.outlet_id', $outlet_id);
        $this->db->where("sr.company_id", $company_id);
        $this->db->where("sr.del_status", 'Live');
        $query_sale_return = $this->db->get();
        $sale_return = $query_sale_return->row()->total_return;


    
        // Return both results as an object or array
        return (object) [
            'sub_total_foods' => $sub_total_foods,
            'total_due' => $total_due,
            'total_return' => $sale_return,
        ];
    }


    /**
     * totalDueReceived
     * @access public
     * @param string
     * @param int
     * @return object
     */
    public function totalDueReceived($startMonth = '',$outlet_id='') {
        $company_id =  $this->session->userdata('company_id');
        $this->db->select("sum(amount) as total_amount");
        $this->db->from('tbl_customer_due_receives');
        $this->db->where('date', $startMonth);
        $this->db->where("outlet_id", $outlet_id);
        $this->db->where("company_id", $company_id);
        $this->db->where('del_status', 'Live');
        $data =  $this->db->get()->row();
        return (isset($data->total_amount) && $data->total_amount?$data->total_amount:0);
    }
    
    /**
     * taxes_foods
     * @access public
     * @param string
     * @param int
     * @return object
     */
    public function taxes_foods($startMonth = '',$outlet_id='') {
        $company_id =  $this->session->userdata('company_id');
        $this->db->select('sale_vat_objects');
        $this->db->from('tbl_sales');
        $this->db->where('sale_date', $startMonth);
        $this->db->where('outlet_id', $outlet_id);
        $this->db->where('company_id', $company_id);
        $this->db->where('del_status', 'Live');
        $query_result = $this->db->get();
        $result = $query_result->result();
        $array_tax = array();
        foreach ($result as $value){
            foreach (json_decode($value->sale_vat_objects) as $tax){
                if((float)$tax->tax_field_amount){
                    $preview_vat_amount = isset($array_tax[$tax->tax_field_type]) && $array_tax[$tax->tax_field_type]?$array_tax[$tax->tax_field_type]:0;
                    $array_tax[$tax->tax_field_type] = $preview_vat_amount + ($tax->tax_field_amount);
                }
            }
        }
        return (Object)$array_tax;
    }

    /**
     * total_discount_amount_foods
     * @access public
     * @param string
     * @param int
     * @return object
     */
    public function total_discount_amount_foods($startMonth = '',$outlet_id='') {
        $company_id =  $this->session->userdata('company_id');
        $this->db->select('sum(total_discount_amount) as total_discount_amount_foods');
        $this->db->from('tbl_sales');
        $this->db->where('sale_date', $startMonth);
        $this->db->where('outlet_id', $outlet_id);
        $this->db->where('company_id', $company_id);
        $this->db->where('del_status', 'Live');
        $query_result = $this->db->get();
        $result = $query_result->row();
        return $result;
    }

    /**
     * totalFoodSales
     * @access public
     * @param string
     * @param string
     * @param int
     * @param string
     * @return object
     */
    public function totalFoodSales($startMonth = '', $endMonth = '',$outlet_id='',$top_less='') {
        $company_id =  $this->session->userdata('company_id');
        if ($startMonth || $endMonth):
            $this->db->select('sum(sd.qty) as totalQty,sum(sd.menu_price_without_discount) net_sales, sd.food_menu_id, ii.name as parent_name, i.name as menu_name, i.code, s.sale_date');
            $this->db->from('tbl_sales_details sd');
            $this->db->join('tbl_sales s', 's.id = sd.sales_id', 'left');
            $this->db->join('tbl_items i', 'i.id = sd.food_menu_id', 'left');
            $this->db->join('tbl_items ii', 'ii.id = i.parent_id', 'left');
            if ($startMonth != '' && $endMonth != '') {
                $this->db->where('s.sale_date>=', $startMonth);
                $this->db->where('s.sale_date <=', $endMonth);
            }
            if ($startMonth != '' && $endMonth == '') {
                $this->db->where('s.sale_date', $startMonth);
            }
            if ($startMonth == '' && $endMonth != '') {
                $this->db->where('s.sale_date', $endMonth);
            }
            $this->db->where('sd.outlet_id', $outlet_id);
            $this->db->where('sd.company_id', $company_id);
            $this->db->where('sd.del_status', 'Live');
            $this->db->order_by('totalQty', $top_less);
            $this->db->group_by('sd.food_menu_id');
            $query_result = $this->db->get();
            $result = $query_result->result();
            return $result;
        endif;
    }


    /**
     * totalTaxDiscountChargeTips
     * @access public
     * @param string
     * @param int
     * @return object
     */
    public function totalTaxDiscountChargeTips($startDate = '',$outlet_id='') {
        $company_id =  $this->session->userdata('company_id');
        $this->db->select('sum(vat) as total_tax,sum(total_discount_amount) as total_discount');
        $this->db->from('tbl_sales');
        $this->db->where('sale_date', $startDate);
        $this->db->where('outlet_id', $outlet_id);
        $this->db->where('company_id', $company_id);
        $this->db->where('del_status', "Live");
        $query_result = $this->db->get();
        $result = $query_result->row();
        return $result;
    }

    /**
     * totalCharge
     * @access public
     * @param string
     * @param int
     * @param string
     * @return object
     */
    public function totalCharge($startDate = '',$outlet_id = '',$type = '') {
        $company_id =  $this->session->userdata('company_id');
        $this->db->select('sum(delivery_charge) as total_charge');
        $this->db->from('tbl_sales');
        $this->db->where('sale_date', $startDate);
        $this->db->where('outlet_id', $outlet_id);
        $this->db->where('company_id', $company_id);
        $this->db->where('charge_type', $type);
        $this->db->where('del_status', "Live");
        $query_result = $this->db->get();
        $result = $query_result->row();
        return $result;
    }


     /**
     * getAllSalePaymentZReport
     * @access public
     * @param string
     * @param int
     * @return object
     */
    public function getAllSalePaymentZReport($startMonth = '',$outlet_id='') {
        $company_id =  $this->session->userdata('company_id');
        $this->db->select('sum(amount) as total_amount,sum(usage_point) as usage_point,tbl_payment_methods.name,payment_id');
        $this->db->from('tbl_sale_payments');
        $this->db->join('tbl_sales', 'tbl_sales.id = tbl_sale_payments.sale_id', 'left');
        $this->db->join('tbl_payment_methods', 'tbl_payment_methods.id = tbl_sale_payments.payment_id', 'left');
        $this->db->where('sale_date', $startMonth);
        $this->db->where('tbl_sale_payments.currency_type', null);
        $this->db->where('tbl_sale_payments.outlet_id', $outlet_id);
        $this->db->where('tbl_sale_payments.company_id', $company_id);
        $this->db->where('tbl_sale_payments.del_status', 'Live');
        $this->db->group_by('payment_id');
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }

     /**
     * getAllOtherSalePaymentZReport
     * @access public
     * @param string
     * @param int
     * @return object
     */
    public function getAllOtherSalePaymentZReport($startMonth = '',$outlet_id='') {
        $company_id =  $this->session->userdata('company_id');
        $this->db->select('sum(amount) as total_amount,multi_currency,payment_id');
        $this->db->from('tbl_sale_payments');
        $this->db->join('tbl_sales', 'tbl_sales.id = tbl_sale_payments.sale_id', 'left');
        $this->db->where('sale_date', $startMonth);
        $this->db->where('tbl_sale_payments.outlet_id', $outlet_id);
        $this->db->where('tbl_sale_payments.company_id', $company_id);
        $this->db->where('tbl_sale_payments.currency_type', 1);
        $this->db->where('tbl_sale_payments.del_status', 'Live');
        $this->db->group_by('payment_id');
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }


     /**
     * getAllPurchasePaymentZreport
     * @access public
     * @param string
     * @param int
     * @return object
     */
    public function getAllPurchasePaymentZreport($startMonth = '',$outlet_id='') {
        $company_id =  $this->session->userdata('company_id');
        $this->db->select('sum(amount) as total_amount,tbl_payment_methods.name,payment_id');
        $this->db->from('tbl_purchase_payments');
        $this->db->join('tbl_payment_methods', 'tbl_payment_methods.id = tbl_purchase_payments.payment_id', 'left');
        $this->db->where('tbl_purchase_payments.added_date', $startMonth);
        $this->db->where('tbl_purchase_payments.outlet_id', $outlet_id);
        $this->db->where('tbl_purchase_payments.company_id', $company_id);
        $this->db->where('tbl_payment_methods.del_status', 'Live');
        $this->db->group_by('tbl_purchase_payments.payment_id');
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }


    /**
     * getAllExpensePaymentZreport
     * @access public
     * @param string
     * @param int
     * @return object
     */
    public function getAllExpensePaymentZreport($startMonth = '',$outlet_id='') {
        $company_id =  $this->session->userdata('company_id');
        $this->db->select('sum(amount) as total_amount,tbl_payment_methods.name,payment_method_id');
        $this->db->from('tbl_expenses');
        $this->db->join('tbl_payment_methods', 'tbl_payment_methods.id = tbl_expenses.payment_method_id', 'left');
        $this->db->where('date', $startMonth);
        $this->db->where('tbl_expenses.outlet_id', $outlet_id);
        $this->db->where('tbl_expenses.company_id', $company_id);
        $this->db->where('tbl_expenses.del_status', 'Live');
        $this->db->group_by('tbl_expenses.payment_method_id');
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }


    /**
     * getAllSupplierPaymentZreport
     * @access public
     * @param string
     * @param int
     * @return object
     */
    public function getAllSupplierPaymentZreport($startMonth = '',$outlet_id='') {
        $company_id =  $this->session->userdata('company_id');
        $this->db->select('sum(amount) as total_amount,tbl_payment_methods.name,payment_method_id');
        $this->db->from('tbl_supplier_payments');
        $this->db->join('tbl_payment_methods', 'tbl_payment_methods.id = tbl_supplier_payments.payment_method_id', 'left');
        $this->db->where('date', $startMonth);
        $this->db->where('tbl_supplier_payments.outlet_id', $outlet_id);
        $this->db->where('tbl_supplier_payments.company_id', $company_id);
        $this->db->where('tbl_supplier_payments.del_status', 'Live');
        $this->db->group_by('payment_method_id');
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }

    /**
     * getAllCustomerDueReceiveZreport
     * @access public
     * @param string
     * @param int
     * @return object
     */
    public function getAllCustomerDueReceiveZreport($startMonth = '',$outlet_id='') {
        $company_id =  $this->session->userdata('company_id');
        $this->db->select('sum(amount) as total_amount,tbl_payment_methods.name,payment_method_id');
        $this->db->from('tbl_customer_due_receives');
        $this->db->join('tbl_payment_methods', 'tbl_payment_methods.id = tbl_customer_due_receives.payment_method_id', 'left');
        $this->db->where('date', $startMonth);
        $this->db->where('tbl_customer_due_receives.outlet_id', $outlet_id);
        $this->db->where('tbl_customer_due_receives.company_id', $company_id);
        $this->db->where('tbl_customer_due_receives.del_status', 'Live');
        $this->db->group_by('payment_method_id');
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }

     /**
     * getAllSaleByPayment
     * @access public
     * @param string
     * @param int
     * @param int
     * @return object
     */
    public function getAllSaleByPayment($date,$payment_id,$outlet_id=''){
        $company_id =  $this->session->userdata('company_id');
        $this->db->select("sum(amount) as total_amount, sum(usage_point) as total_usage_point");
        $this->db->from('tbl_sale_payments');
        $this->db->where("payment_id", $payment_id);
        $this->db->where("outlet_id", $outlet_id);
        $this->db->where("company_id", $company_id);
        $this->db->where("date", $date);
        $this->db->where("currency_type", null);
        $data =  $this->db->get()->row();
        if($payment_id!=5){
            return (isset($data->total_amount) && $data->total_amount?$data->total_amount:0);
        }else{
            return (isset($data->total_usage_point) && $data->total_usage_point?$data->total_usage_point:0);
        }
    }
    /**
     * getAllSaleReturnByPayment
     * @access public
     * @param string
     * @param int
     * @param int
     * @return object
     */
    public function getAllSaleReturnByPayment($date, $payment_id, $outlet_id=''){
        $company_id =  $this->session->userdata('company_id');
        $this->db->select("sum(paid) as total_amount");
        $this->db->from('tbl_sale_return');
        $this->db->where("payment_method_id", $payment_id);
        $this->db->where("outlet_id", $outlet_id);
        $this->db->where("company_id", $company_id);
        $this->db->where("date", $date);
        $data =  $this->db->get()->row();
        return (isset($data->total_amount) && $data->total_amount ? $data->total_amount : 0);
    }
    /**
     * getAllPurchaseReturnByPayment
     * @access public
     * @param string
     * @param int
     * @param int
     * @return object
     */
    public function getAllPurchaseReturnByPayment($date, $payment_id='', $outlet_id=''){
        $company_id =  $this->session->userdata('company_id');
        $this->db->select("sum(total_return_amount) as total_amount");
        $this->db->from('tbl_purchase_return');
        if($payment_id != ''){
            $this->db->where("payment_method_id", $payment_id);
        }
        $this->db->where("return_status", 'taken_by_sup_money_returned');
        if($outlet_id != ''){
            $this->db->where("outlet_id", $outlet_id);
        }
        $this->db->where("company_id", $company_id);
        $this->db->where("date", $date);
        $data =  $this->db->get()->row();
        return (isset($data->total_amount) && $data->total_amount ? $data->total_amount : 0);
    }
    /**
     * getAllInstallmentDownPaymentAndCollectionByPayment
     * @access public
     * @param string
     * @param int
     * @param int
     * @return object
     */
    public function getAllInstallmentDownPaymentAndCollectionByPayment($date, $payment_id='', $outlet_id=''){
        $company_id =  $this->session->userdata('company_id');
        $this->db->select("sum(down_payment) as total_amount");
        $this->db->from('tbl_installments');
        if($payment_id != ''){
            $this->db->where("payment_method_id", $payment_id);
        }
        if($outlet_id != ''){
            $this->db->where("outlet_id", $outlet_id);
        }
        $this->db->where("company_id", $company_id);
        $this->db->where("date", $date);
        $data =  $this->db->get()->row();

        $this->db->select("sum(paid_amount) as total_amount");
        $this->db->from('tbl_installment_items');
        if($payment_id != ''){
            $this->db->where("payment_method_id", $payment_id);
        }
        if($outlet_id != ''){
            $this->db->where("outlet_id", $outlet_id);
        }
        $this->db->where("company_id", $company_id);
        $this->db->where("paid_date", $date);
        $data2 =  $this->db->get()->row();

        $amount_1 =  (isset($data->total_amount) && $data->total_amount ? $data->total_amount : 0);
        $amount_2 =  (isset($data2->total_amount) && $data2->total_amount ? $data2->total_amount : 0);

        return $amount_1 + $amount_2;
    }

     /**
     * getAllPurchaseByPayment
     * @access public
     * @param string
     * @param int
     * @param int
     * @return object
     */
    public function getAllPurchaseByPayment($date,$payment_id='',$outlet_id=''){
        $company_id =  $this->session->userdata('company_id');
        $this->db->select("sum(amount) as total_amount");
        $this->db->from('tbl_purchase_payments');
        if($payment_id != ''){
            $this->db->where("payment_id", $payment_id);
        }
        if($outlet_id != ''){
            $this->db->where("outlet_id", $outlet_id);
        }
        $this->db->where("company_id", $company_id);
        $this->db->where("added_date", $date);
        $this->db->group_by('purchase_id');
        $data =  $this->db->get()->row();
        return (isset($data->total_amount) && $data->total_amount?$data->total_amount:0);
    }


    /**
     * getAllDueReceiveByPayment
     * @access public
     * @param string
     * @param int
     * @param int
     * @return object
     */
    public function getAllDueReceiveByPayment($date,$payment_id,$outlet_id=''){
        $company_id =  $this->session->userdata('company_id');
        $this->db->select("sum(amount) as total_amount");
        $this->db->from('tbl_customer_due_receives');
        $this->db->where("payment_method_id", $payment_id);
        $this->db->where("outlet_id", $outlet_id);
        $this->db->where("company_id", $company_id);
        $this->db->where("date", $date);
        $data =  $this->db->get()->row();
        return (isset($data->total_amount) && $data->total_amount?$data->total_amount:0);
    }

    /**
     * getAllDuePaymentByPayment
     * @access public
     * @param string
     * @param int
     * @param int
     * @return object
     */
    public function getAllDuePaymentByPayment($date,$payment_id,$outlet_id=''){
        $company_id =  $this->session->userdata('company_id');
        $this->db->select("sum(amount) as total_amount");
        $this->db->from('tbl_supplier_payments');
        $this->db->where("payment_method_id", $payment_id);
        $this->db->where("outlet_id", $outlet_id);
        $this->db->where("company_id", $company_id);
        $this->db->where("date", $date);
        $data =  $this->db->get()->row();
        return (isset($data->total_amount) && $data->total_amount?$data->total_amount:0);
    }

    /**
     * getAllExpenseByPayment
     * @access public
     * @param string
     * @param int
     * @param int
     * @return object
     */
    public function getAllExpenseByPayment($date,$payment_id,$outlet_id=''){
        $company_id =  $this->session->userdata('company_id');
        $this->db->select("sum(amount) as total_amount");
        $this->db->from('tbl_expenses');
        $this->db->where("date", $date);
        $this->db->where("payment_method_id", $payment_id);
        $this->db->where("outlet_id", $outlet_id);
        $this->db->where("company_id", $company_id);
        $data =  $this->db->get()->row();
        return (isset($data->total_amount) && $data->total_amount?$data->total_amount:0);
    }


    /**
     * availableLoyaltyPointReport
     * @access public
     * @param int
     * @return object
     */
    public function availableLoyaltyPointReport($customer_id = '') {
        $this->db->select('*');
        $this->db->from('tbl_customers');
        if ($customer_id != '') {
            $this->db->where('id', $customer_id);
        }
        $this->db->where('del_status', "Live");
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }


     /**
     * usageLoyaltyPointReport
     * @access public
     * @param string
     * @param string
     * @param int
     * @param int
     * @return object
     */
    public function usageLoyaltyPointReport($startMonth = '', $endMonth = '', $customer_id = '',$outlet_id='') {
        if ($startMonth || $endMonth || $customer_id):
        $payment_id = getPaymentIdByPaymentName('Loyalty Point');
        $this->db->select('tbl_sale_payments.*,tbl_customers.name, tbl_customers.phone,tbl_sales.sale_no,tbl_sales.date_time');
        $this->db->from('tbl_sale_payments');
        $this->db->join('tbl_sales', 'tbl_sales.id = tbl_sale_payments.sale_id', 'left');
        $this->db->join('tbl_customers', 'tbl_customers.id = tbl_sales.customer_id', 'left');
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
        if ($customer_id != '') {
            $this->db->where('customer_id', $customer_id);
        }
        $this->db->where('tbl_sales.outlet_id', $outlet_id);
        $this->db->where('tbl_sale_payments.payment_id', $payment_id);
        $this->db->where('tbl_sale_payments.del_status', 'Live');
        $query_result = $this->db->get();
        $data = $query_result->result();
            return $data;
        endif;

    }
}