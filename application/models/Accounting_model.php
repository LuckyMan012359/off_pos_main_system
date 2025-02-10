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

class Accounting_model extends CI_Model {

    /**
     * getOpeningBalance
     * @access public
     * @param int
     * @param string
     * @param string
     * @return array
     */
    public function getOpeningBalance($account_id='',$date='',$type='') {
        $where = '';
        if($account_id!=''){
            $where = "AND payment_method_id = ".$account_id;
        }
        $where1 = '';
        if($account_id!=''){
            $where1 = "AND payment_method_id = ".$account_id;
        }
        $where2 = '';
        if($account_id!=''){
            $where2 = "AND id = ".$account_id;
        }
        
        $where3 = '';
        if($account_id!=''){
            $where3 = "AND payment_id = ".$account_id;
        }


        $total_opening_amount_credit = 0;
        $total_opening_amount_debit = 0;
        $balance_createDate = '';
        if($type==1 || $type=="all"){
            $account_open_balance = $this->db->query("SELECT current_balance, added_date FROM tbl_payment_methods WHERE del_status='Live' $where2")->row();
            $order = $this->db->query("SELECT SUM(amount) as total_paid_order_credit FROM tbl_sale_payments WHERE del_status='Live' $where3 and date<'$date' ")->row();
            $order_due_received = $this->db->query("SELECT SUM(amount) as due_receive_credit FROM tbl_customer_due_receives WHERE del_status='Live' $where1 and date<'$date' ")->row();
            $balance_deposit = $this->db->query("SELECT SUM(amount) as total_deposit_credit FROM tbl_deposits WHERE del_status='Live' AND type='Deposit' $where1 and date<'$date' ")->row();
            $balance_installment = $this->db->query("SELECT SUM(paid_amount) as total_installment_credit FROM tbl_installment_items WHERE del_status='Live' AND paid_status='Paid' $where1 and paid_date<'$date' ")->row();
            $purchase_return = $this->db->query("SELECT SUM(total_return_amount) as total_return_credit FROM tbl_purchase_return WHERE del_status='Live' $where1 and date<'$date' ")->row();
            $income = $this->db->query("SELECT SUM(amount) as total_income_credit FROM tbl_incomes WHERE del_status='Live' $where1 and date<'$date' ")->row();
            $total_opening_amount_credit = (isset($purchase_return->total_return_credit) && $purchase_return->total_return_credit?$purchase_return->total_return_credit:0) + (isset($balance_installment->total_installment_credit) && $balance_installment->total_installment_credit?$balance_installment->total_installment_credit:0) + (isset($account_open_balance->current_balance) && $account_open_balance->current_balance?$account_open_balance->current_balance:0) + ($order->total_paid_order_credit+$order_due_received->due_receive_credit+$balance_deposit->total_deposit_credit) + $income->total_income_credit ? $income->total_income_credit : 0;
            $balance_createDate = $account_open_balance->added_date;
        }
        if($type==2 || $type=="all"){
            $balance_createDate = $date;
            $purchase = $this->db->query("SELECT SUM(amount) as total_paid_purchase_debit FROM tbl_purchase_payments WHERE del_status='Live' and payment_id=$account_id and added_date < '$date' ")->row();
            $purchase_due_payment = $this->db->query("SELECT SUM(amount) as total_due_purchase_payment_debit FROM tbl_supplier_payments WHERE del_status='Live' $where1 and date<'$date' ")->row();
            $order_return = $this->db->query("SELECT SUM(total_return_amount) as total_return_debit FROM tbl_sale_return WHERE del_status='Live' $where1 and date<'$date' ")->row();

            $balance_withdraw = $this->db->query("SELECT SUM(amount) as total_withdraw_debit FROM tbl_deposits WHERE del_status='Live' AND type='Withdraw' $where1 and date<'$date' ")->row();
            
            $expense = $this->db->query("SELECT SUM(amount) as total_expense_debit FROM tbl_expenses WHERE del_status='Live' $where1 and date<'$date' ")->row();
            $salaries_exp = $this->db->query("SELECT SUM(total_amount) as total_salaries_debit FROM tbl_salaries WHERE del_status='Live' $where3 and date<'$date' ")->row();
            $damage = $this->db->query("SELECT SUM(total_loss) as total_damage_debit FROM tbl_damages WHERE del_status='Live' and date<'$date' ")->row();
            $total_opening_amount_debit = $purchase->total_paid_purchase_debit + $purchase_due_payment->total_due_purchase_payment_debit + $order_return->total_return_debit + $balance_withdraw->total_withdraw_debit + $expense->total_expense_debit + $salaries_exp->total_salaries_debit + $damage->total_damage_debit;
        }
        return [$total_opening_amount_credit,$total_opening_amount_debit, $balance_createDate, $date];
    }

    /**
     * getCustomerDue
     * @access public
     * @param string
     * @return object
     */
    public function getCustomerDue($startMonth) {
        if ($startMonth):
            $this->db->select('sum(due_amount) as total_amount');
            $this->db->from('tbl_sales');
            $this->db->where('sale_date<=', $startMonth);
            $this->db->where('del_status', "Live");
            $query_result = $this->db->get();
            $result = $query_result->result();
            return $result;
        endif;
    }


    /**
     * getCustomerDue
     * @access public
     * @param string
     * @return object
     */
    public function trialBalance($date) {
        $company_id = $this->session->userdata('company_id');
        $result = $this->db->query("SELECT t.* FROM ( 
            (SELECT 0 as debit, SUM(amount) as credit, date, 'Customer Receive' as type FROM tbl_customer_due_receives WHERE company_id = $company_id AND del_status='Live')

            UNION
            (SELECT SUM(amount) as debit, 0 as credit, date, 'Supplier Payment' as type FROM tbl_supplier_payments WHERE company_id = $company_id AND del_status='Live')

            UNION
            (SELECT SUM(paid) as debit, 0 as credit, date, 'Purchase' as type FROM tbl_purchase WHERE company_id = $company_id AND del_status='Live')

            UNION
            (SELECT 0 as debit, SUM(total_return_amount) as credit, date, 'Purchase Return' as type FROM tbl_purchase_return WHERE return_status = 'taken_by_sup_money_returned' AND company_id = $company_id AND del_status='Live')

            UNION
            (SELECT 0 as debit, SUM(total_payable) as credit, sale_date as date, 'Sale' as type FROM tbl_sales  WHERE delivery_status = 'Cash Received' AND company_id = $company_id AND del_status='Live')

            UNION
            (SELECT SUM(total_return_amount) as debit, 0 as credit, date, 'Sale Return' as type FROM tbl_sale_return WHERE company_id = $company_id AND del_status='Live')

            UNION
            (SELECT 0 as debit, SUM(amount) as credit, date, 'Income' as type FROM tbl_incomes WHERE company_id = $company_id AND del_status='Live')

            UNION
            (SELECT SUM(amount) as debit, 0 as credit, date, 'Expense' as type FROM tbl_expenses WHERE company_id = $company_id AND del_status='Live')
            
        ) as t ORDER BY t.date ASC")->result();
        return $result;
        
    }

    /**
     * getSupplierDue
     * @access public
     * @param string
     * @return object
     */
    public function getSupplierDue($startMonth) {
        if ($startMonth):
            $this->db->select('sum(due_amount) as total_amount');
            $this->db->from('tbl_purchase');
            $this->db->where('date<=', $startMonth);
            $this->db->where('del_status', "Live");
            $query_result = $this->db->get();
            $result = $query_result->result();
            return $result;
        endif;
    }


    /**
     * getPaidOrder
     * @access public
     * @param string
     * @param string
     * @param int
     * @return object
     */
    public function getPaidOrder($startMonth = '', $endMonth = '', $account_id = '') {
        if ($startMonth || $endMonth || $account_id):
            $this->db->select('s.sale_date as date,sum(s.paid_amount) as total_amount');
            $this->db->from('tbl_sales s');
            $this->db->join('tbl_sale_payments sp', 'sp.sale_id = s.id', 'left');

            if ($startMonth != '' && $endMonth != '') {
                $this->db->where('s.sale_date>=', $startMonth);
                $this->db->where('s.sale_date <=', $endMonth);
            }
            if ($startMonth != '' && $endMonth != '') {
                $this->db->where('sp.added_date>=', $startMonth);
                $this->db->where('sp.added_date <=', $endMonth);
            }
            if ($account_id != '') {
                $this->db->where('sp.payment_id', $account_id);
            }
            $this->db->where('s.del_status', "Live");
            $this->db->group_by('s.id');
            $query_result = $this->db->get();
            $result = $query_result->result();
            return $result;
        endif;
    }

    /**
     * getInstallment
     * @access public
     * @param string
     * @param string
     * @param int
     * @return object
     */
    public function getInstallment($startMonth = '', $endMonth = '', $account_id = '') {
        if ($startMonth || $endMonth || $account_id):
            $this->db->select('tbl_payment_methods.name as account_name,paid_date as date,sum(paid_amount) as total_amount');
            $this->db->from('tbl_installment_items');
            $this->db->join('tbl_payment_methods', 'tbl_payment_methods.id = tbl_installment_items.payment_method_id', 'left');
            if ($startMonth != '' && $endMonth != '') {
                $this->db->where('paid_date>=', $startMonth);
                $this->db->where('paid_date <=', $endMonth);
            }
            if ($account_id != '') {
                $this->db->where('payment_method_id', $account_id);
            }
            $this->db->group_by('tbl_installment_items.id');
            $this->db->where('tbl_installment_items.del_status', "Live");
            $query_result = $this->db->get();
            $result = $query_result->result();
            return $result;
        endif;
    }


    /**
     * getOrderDueReceived
     * @access public
     * @param string
     * @param string
     * @param int
     * @return object
     */
    public function getOrderDueReceived($startMonth = '', $endMonth = '', $account_id = '') {
        if ($startMonth || $endMonth || $account_id):
            $this->db->select('tbl_payment_methods.name as account_name,date,sum(amount) as total_amount,note');
            $this->db->from('tbl_customer_due_receives');
            $this->db->join('tbl_payment_methods', 'tbl_payment_methods.id = tbl_customer_due_receives.payment_method_id', 'left');
            if ($startMonth != '' && $endMonth != '') {
                $this->db->where('date>=', $startMonth);
                $this->db->where('date <=', $endMonth);
            }

            if ($account_id != '') {
                $this->db->where('payment_method_id', $account_id);
            }

            $this->db->group_by('tbl_customer_due_receives.id');
            $this->db->where('tbl_customer_due_receives.del_status', "Live");
            $query_result = $this->db->get();
            $result = $query_result->result();
            return $result;
        endif;
    }

    /**
     * getTotalDepositCredit
     * @access public
     * @param string
     * @param string
     * @param int
     * @return object
     */
    public function getTotalDepositCredit($startMonth = '', $endMonth = '', $account_id = '') {
        if ($startMonth || $endMonth || $account_id):
            $this->db->select('tbl_payment_methods.name as account_name,date as date,sum(amount) as total_amount,note');
            $this->db->from('tbl_deposits');
            $this->db->join('tbl_payment_methods', 'tbl_payment_methods.id = tbl_deposits.payment_method_id', 'left');
            if ($startMonth != '' && $endMonth != '') {
                $this->db->where('date>=', $startMonth);
                $this->db->where('date <=', $endMonth);
            }

            if ($account_id != '') {
                $this->db->where('payment_method_id', $account_id);
            }

            $this->db->group_by('tbl_deposits.id');
            $this->db->where('tbl_deposits.type', "Deposit");
            $this->db->where('tbl_deposits.del_status', "Live");
            $query_result = $this->db->get();
            $result = $query_result->result();
            return $result;
        endif;
    }

    /**
     * getTotalDepositDebit
     * @access public
     * @param string
     * @param string
     * @param int
     * @return object
     */
    public function getTotalDepositDebit($startMonth = '', $endMonth = '', $account_id = '') {
        if ($startMonth || $endMonth || $account_id):
            $this->db->select('tbl_payment_methods.name as account_name,date as date,sum(amount) as total_amount,note');
            $this->db->from('tbl_deposits');
            $this->db->join('tbl_payment_methods', 'tbl_payment_methods.id = tbl_deposits.payment_method_id', 'left');
            if ($startMonth != '' && $endMonth != '') {
                $this->db->where('date>=', $startMonth);
                $this->db->where('date <=', $endMonth);
            }

            if ($account_id != '') {
                $this->db->where('payment_method_id', $account_id);
            }

            $this->db->group_by('tbl_deposits.id');
            $this->db->where('tbl_deposits.type', "Withdraw");
            $this->db->where('tbl_deposits.del_status', "Live");
            $query_result = $this->db->get();
            $result = $query_result->result();
            return $result;
        endif;
    }


    /**
     * getTotalPurchaseDebit
     * @access public
     * @param string
     * @param string
     * @param int
     * @return object
     */
    public function getTotalPurchaseDebit($startMonth = '', $endMonth = '', $account_id = '') {
        if ($startMonth || $endMonth || $account_id):
            $this->db->select('date as date,sum(tbl_purchase_payments.amount) as total_amount,note');
            $this->db->from('tbl_purchase');
            $this->db->join('tbl_purchase_payments', 'tbl_purchase_payments.purchase_id = tbl_purchase.id', 'left');
            if ($startMonth != '' && $endMonth != '') {
                $this->db->where('date>=', $startMonth);
                $this->db->where('date <=', $endMonth);
            }
            if ($startMonth != '' && $endMonth != '') {
                $this->db->where('tbl_purchase_payments.added_date>=', $startMonth);
                $this->db->where('tbl_purchase_payments.added_date <=', $endMonth);
            }
            if ($account_id != '') {
                $this->db->where('tbl_purchase_payments.payment_id', $account_id);
            }
            $this->db->group_by('tbl_purchase.id');
            $this->db->where('tbl_purchase.del_status', "Live");
            $query_result = $this->db->get();
            $result = $query_result->result();
            return $result;
        endif;
    }


    /**
     * getTotalPurchaseDuePaymentDebit
     * @access public
     * @param string
     * @param string
     * @param int
     * @return object
     */
    public function getTotalPurchaseDuePaymentDebit($startMonth = '', $endMonth = '', $account_id = '') {
        if ($startMonth || $endMonth || $account_id):
            $this->db->select('tbl_payment_methods.name as account_name,date as date,sum(amount) as total_amount,note');
            $this->db->from('tbl_supplier_payments');
            $this->db->join('tbl_payment_methods', 'tbl_payment_methods.id = tbl_supplier_payments.payment_method_id', 'left');
            if ($startMonth != '' && $endMonth != '') {
                $this->db->where('date>=', $startMonth);
                $this->db->where('date <=', $endMonth);
            }
            if ($account_id != '') {
                $this->db->where('payment_method_id', $account_id);
            }
            $this->db->group_by('tbl_supplier_payments.id');
            $this->db->where('tbl_supplier_payments.del_status', "Live");
            $query_result = $this->db->get();
            $result = $query_result->result();
            return $result;
        endif;
    }


    /**
     * getTotalOrderReturnDebit
     * @access public
     * @param string 
     * @param string 
     * @param int 
     * @return object
     */
    public function getTotalOrderReturnDebit($startMonth = '', $endMonth = '', $account_id = '') {
        if ($startMonth || $endMonth || $account_id):
            $this->db->select('tbl_payment_methods.name as account_name,date as date,sum(total_return_amount) as total_amount,note');
            $this->db->from('tbl_sale_return');
            $this->db->join('tbl_payment_methods', 'tbl_payment_methods.id = tbl_sale_return.payment_method_id', 'left');
            if ($startMonth != '' && $endMonth != '') {
                $this->db->where('date>=', $startMonth);
                $this->db->where('date <=', $endMonth);
            }
            if ($account_id != '') {
                $this->db->where('payment_method_id', $account_id);
            }
            $this->db->group_by('tbl_sale_return.id');
            $this->db->where('tbl_sale_return.del_status', "Live");
            $query_result = $this->db->get();
            $result = $query_result->result();
            return $result;
        endif;
    }


    /**
     * getTotalPurchaseReturnDebit
     * @access public
     * @param string
     * @param string
     * @param int
     * @return object
     */
    public function getTotalPurchaseReturnDebit($startMonth = '', $endMonth = '', $account_id = '') {
        if ($startMonth || $endMonth || $account_id):
            $this->db->select('tbl_payment_methods.name as account_name,date as date,sum(total_return_amount) as total_amount,note');
            $this->db->from('tbl_purchase_return');
            $this->db->join('tbl_payment_methods', 'tbl_payment_methods.id = tbl_purchase_return.payment_method_id', 'left');
            if ($startMonth != '' && $endMonth != '') {
                $this->db->where('date >=', $startMonth);
                $this->db->where('date <=', $endMonth);
            }
            if ($account_id != '') {
                $this->db->where('payment_method_id', $account_id);
            }
            $this->db->group_by('tbl_purchase_return.id');
            $this->db->where('tbl_purchase_return.return_status', "taken_by_sup_money_returned");
            $this->db->where('tbl_purchase_return.del_status', "Live");
            $query_result = $this->db->get();
            $result = $query_result->result();
            return $result;
        endif;
    }

    /**
     * getBalanceSheet
     * @access public
     * @param int
     * @return array
     */
    public function getBalanceSheet($account_id='') {
        $company_id = $this->session->userdata('company_id');
        $where = '';
        if($account_id != ''){
            $where = "AND payment_method_id = ".$account_id;
        }
        $where1 = '';
        if($account_id != ''){
            $where1 = "AND payment_method_id = ".$account_id;
        }
        $where2 = '';
        if($account_id != ''){
            $where2 = "AND id = ".$account_id;
        }
        
        $where3 = '';
        if($account_id != ''){
            $where3 = "AND payment_id = ".$account_id;
        }

        $account_open_balance = $this->db->query("SELECT current_balance FROM tbl_payment_methods WHERE del_status='Live' AND company_id = $company_id $where2")->row();
        $order = $this->db->query("SELECT SUM(amount) as total_paid_order_credit
            FROM tbl_sale_payments sp
            LEFT JOIN tbl_sales s ON sp.sale_id = s.id
                WHERE sp.del_status = 'Live'
            AND sp.company_id = $company_id
            AND s.delivery_status = 'Cash Received'
            $where3")->row();




        $order_due_received = $this->db->query("SELECT SUM(amount) as due_receive_credit FROM tbl_customer_due_receives WHERE del_status='Live' $where1")->row();
        
        $balance_deposit = $this->db->query("SELECT SUM(amount) as total_deposit_credit FROM tbl_deposits WHERE del_status='Live'  AND company_id = $company_id AND type='Deposit' $where1")->row();

        $balance_installment = $this->db->query("SELECT SUM(paid_amount) as total_installment_credit FROM tbl_installment_items WHERE del_status='Live' AND company_id = $company_id AND paid_status='Paid' $where1")->row();

        $purchase_return = $this->db->query("SELECT SUM(total_return_amount) as total_return_credit FROM tbl_purchase_return WHERE del_status='Live' AND company_id = $company_id AND return_status ='taken_by_sup_money_returned' $where1")->row();

        $total_opening_amount_credit = (isset($purchase_return->total_return_credit) && $purchase_return->total_return_credit?$purchase_return->total_return_credit:0)+(isset($balance_installment->total_installment_credit) && $balance_installment->total_installment_credit?$balance_installment->total_installment_credit:0)+(isset($account_open_balance->current_balance) && $account_open_balance->current_balance?$account_open_balance->current_balance:0)+($order->total_paid_order_credit+$order_due_received->due_receive_credit+$balance_deposit->total_deposit_credit);

        $purchase = $this->db->query("SELECT SUM(amount) as total_paid_purchase_debit FROM 	tbl_purchase_payments WHERE payment_id=$account_id AND company_id = $company_id AND del_status='Live'")->row();
        
        $purchase_due_payment = $this->db->query("SELECT SUM(amount) as total_due_purchase_payment_debit FROM tbl_supplier_payments WHERE del_status='Live' AND company_id = $company_id $where1")->row();

        $order_return = $this->db->query("SELECT SUM(total_return_amount) as total_return_debit FROM tbl_sale_return WHERE del_status='Live' AND company_id = $company_id $where1")->row();


        $balance_withdraw = $this->db->query("SELECT SUM(amount) as total_withdraw_debit FROM tbl_deposits WHERE del_status='Live' AND type='Withdraw' AND company_id = $company_id $where1")->row();

        $expense = $this->db->query("SELECT SUM(amount) as total_expense_debit FROM tbl_expenses WHERE del_status='Live' AND company_id = $company_id $where1")->row();
        
        $salaries_exp = $this->db->query("SELECT SUM(total_amount) as total_salaries_debit FROM tbl_salaries WHERE del_status='Live' AND company_id = $company_id $where3")->row();
        
        $total_opening_amount_debit = $purchase->total_paid_purchase_debit + $purchase_due_payment->total_due_purchase_payment_debit + $order_return->total_return_debit + $balance_withdraw->total_withdraw_debit + $expense->total_expense_debit + $salaries_exp->total_salaries_debit;
        
        return [$total_opening_amount_credit,$total_opening_amount_debit];
    }


    /**
     * getTotalExpenseDebit
     * @access public
     * @param string
     * @param string
     * @param int
     * @return object
     */
    public function getTotalExpenseDebit($startMonth = '', $endMonth = '', $account_id = '') {
        if ($startMonth || $endMonth || $account_id):
            $this->db->select('tbl_payment_methods.name as account_name,date as date,sum(amount) as total_amount,note');
            $this->db->from('tbl_expenses');
            $this->db->join('tbl_payment_methods', 'tbl_payment_methods.id = tbl_expenses.payment_method_id', 'left');
            if ($startMonth != '' && $endMonth != '') {
                $this->db->where('date>=', $startMonth);
                $this->db->where('date <=', $endMonth);
            }
            if ($account_id != '') {
                $this->db->where('payment_method_id', $account_id);
            }
            $this->db->group_by('tbl_expenses.id');
            $this->db->where('tbl_expenses.del_status', "Live");
            $query_result = $this->db->get();
            $result = $query_result->result();
            return $result;
        endif;
    }


    /**
     * creditBalanceStatement
     * @access public
     * @param string
     * @param string
     * @param int
     * @return object
     */
    public function creditBalanceStatement($start_date, $end_date, $account_id){
        if($account_id){
            $s_account_type = " and sp.payment_id = '$account_id'";
        }else{
            $s_account_type = '';
        }
        if($account_id){
            $i_account_type = " and i.payment_method_id = '$account_id'";
        }else{
            $i_account_type = '';
        }
        if($account_id){
            $pr_account_type = " and pr.payment_method_id = '$account_id'";
        }else{
            $pr_account_type = '';
        }
        if($account_id){
            $cr_account_type = " and cr.payment_method_id = '$account_id'";
        }else{
            $pr_account_type = '';
        }
        if($account_id){
            $d_account_type = " and d.payment_method_id = '$account_id'";
        }else{
            $d_account_type = '';
        }
        if($account_id){
            $in_account_type = " and inc.payment_method_id = '$account_id'";
        }else{
            $in_account_type = '';
        }

        $saleDateRange = "";
        if($start_date != '' && $end_date != ''){
            $saleDateRange.= " and s.sale_date BETWEEN '".$start_date."' and '".$end_date."'";
        }
        $installmentDateRange = "";
        if($start_date != '' && $end_date != ''){
            $installmentDateRange.= " and i.paid_date BETWEEN '".$start_date."' and '".$end_date."'";
        }
        $purchaseReturnDateRange = "";
        if($start_date != '' && $end_date != ''){
            $purchaseReturnDateRange.= " and pr.date BETWEEN '".$start_date."' and '".$end_date."'";
        }
        $customerDueReceiveDateRange = "";
        if($start_date != '' && $end_date != ''){
            $customerDueReceiveDateRange.= " and cr.date BETWEEN '".$start_date."' and '".$end_date."'";
        }
        $depositDateRange = "";
        if($start_date != '' && $end_date != ''){
            $depositDateRange.= " and d.date BETWEEN '".$start_date."' and '".$end_date."'";
        }
        $incomeDateRange = "";
        if($start_date != '' && $end_date != ''){
            $incomeDateRange.= " and inc.date BETWEEN '".$start_date."' and '".$end_date."'";
        }

        $balanceStatement = $this->db->query("SELECT b.* FROM (
            (SELECT 'Sale' as type, s.sale_date as date, p.name as account_type, s.note as note, sum(sp.amount) as credit, 0 as debit 
            FROM tbl_sales s 
            JOIN tbl_sale_payments sp ON s.id = sp.sale_id 
            JOIN tbl_payment_methods p ON p.id = sp.payment_id 
            WHERE s.delivery_status = 'Cash Received' AND s.del_status='Live' $saleDateRange $s_account_type HAVING sum(sp.amount) > 0) 

            UNION 
            (SELECT 'Installment Sale' as type, i.paid_date as date, p.name as account_type, '' as note, sum(i.paid_amount) as credit, '' as debit
            FROM tbl_installment_items i
            JOIN tbl_payment_methods p ON i.payment_method_id = p.id 
            WHERE i.del_status='Live' $installmentDateRange $i_account_type HAVING sum(i.paid_amount) > 0) 

            UNION 
            (SELECT 'Purchase Return' as type, pr.date, p.name as account_type, pr.note as note, sum(pr.total_return_amount) as credit, '' as debit
            FROM tbl_purchase_return pr
            JOIN tbl_payment_methods p ON pr.payment_method_id = p.id 
            WHERE pr.del_status='Live' $purchaseReturnDateRange $pr_account_type HAVING sum(pr.total_return_amount) > 0) 

            UNION 
            (SELECT 'Customer Due Receive' as type, cr.date, p.name as account_type, cr.note as note, sum(cr.amount) as credit, '' as debit
            FROM tbl_customer_due_receives cr
            JOIN tbl_payment_methods p ON cr.payment_method_id = p.id 
            WHERE cr.del_status='Live' $customerDueReceiveDateRange $cr_account_type HAVING sum(cr.amount) > 0)  

            UNION 
            (SELECT 'Deposit' as type, d.date, p.name as account_type, d.note as note, sum(d.amount) as credit, '' as debit
            FROM tbl_deposits d
            JOIN tbl_payment_methods p ON d.payment_method_id = p.id 
            WHERE d.del_status='Live' AND type='Deposit' $depositDateRange $d_account_type HAVING sum(d.amount) > 0)


            UNION 
            (SELECT 'Income' as type, inc.date, p.name as account_type, inc.note as note, sum(inc.amount) as credit, '' as debit
            FROM tbl_incomes inc
            JOIN tbl_payment_methods p ON inc.payment_method_id = p.id 
            WHERE inc.del_status='Live' $incomeDateRange $in_account_type HAVING sum(inc.amount) > 0)


        ) as b ORDER BY b.date ASC")->result();


        return $balanceStatement;
    }

    /**
     * debitBalanceStatement
     * @access public
     * @param string
     * @param string
     * @param int
     * @return object
     */
    public function debitBalanceStatement($start_date, $end_date, $account_id){
        if($account_id){
            $w_account_type = " and w.payment_method_id = '$account_id'";
        }else{
            $w_account_type = '';
        }
        if($account_id){
            $p_account_type = " and pp.payment_id = '$account_id'";
        }else{
            $p_account_type = '';
        }
        if($account_id){
            $sp_account_type = " and sp.payment_method_id = '$account_id'";
        }else{
            $sp_account_type = '';
        }
        if($account_id){
            $sr_account_type = " and sr.payment_method_id = '$account_id'";
        }else{
            $sr_account_type = '';
        }
        if($account_id){
            $e_account_type = " and e.payment_method_id = '$account_id'";
        }else{
            $e_account_type = '';
        }

        if($account_id){
            $s_account_type = " and s.payment_id = '$account_id'";
        }else{
            $s_account_type = '';
        }

        $withdrawDangeRange = "";
        if($start_date != '' && $end_date != ''){
            $withdrawDangeRange.= " and w.date BETWEEN '".$start_date."' and '".$end_date."'";
        }
        $purchaseDateRange = "";
        if($start_date != '' && $end_date != ''){
            $purchaseDateRange.= " and p.date BETWEEN '".$start_date."' and '".$end_date."'";
        }
        $supplierPayment = "";
        if($start_date != '' && $end_date != ''){
            $supplierPayment.= " and sp.date BETWEEN '".$start_date."' and '".$end_date."'";
        }
        $saleReturnDateRange = "";
        if($start_date != '' && $end_date != ''){
            $saleReturnDateRange.= " and sr.date BETWEEN '".$start_date."' and '".$end_date."'";
        }
        $expenseDateRange = "";
        if($start_date != '' && $end_date != ''){
            $expenseDateRange.= " and e.date BETWEEN '".$start_date."' and '".$end_date."'";
        }

        $damageDateRange = "";
        if($start_date != '' && $end_date != ''){
            $damageDateRange.= " and d.date BETWEEN '".$start_date."' and '".$end_date."'";
        }

        $salaryDateRange = "";
        if($start_date != '' && $end_date != ''){
            $salaryDateRange.= " and s.date BETWEEN '".$start_date."' and '".$end_date."'";
        }

        $balanceStatement = $this->db->query("SELECT b.* FROM (
            (SELECT 'Withdraw' as type, w.date as date, p.name as account_type, w.note as note, 0 as credit, sum(w.amount) as debit 
            FROM tbl_deposits w
            JOIN tbl_payment_methods p ON p.id = w.payment_method_id 
            WHERE w.del_status='Live' AND type='Withdraw' $withdrawDangeRange $w_account_type HAVING sum(w.amount) > 0) 

            UNION 
            (SELECT 'Purchase' as type, p.date as date, pm.name as account_type, p.note as note, 0 as credit, sum(pp.amount) as debit
            FROM tbl_purchase p
            JOIN tbl_purchase_payments pp ON p.id = pp.purchase_id
            JOIN tbl_payment_methods pm ON pm.id = pp.payment_id 
            WHERE p.del_status='Live' $purchaseDateRange $p_account_type HAVING sum(pp.amount) > 0) 

            UNION 
            (SELECT 'Supplier Payment' as type, sp.date, p.name as account_type, sp.note as note, 0 as credit, sum(sp.amount) as debit
            FROM tbl_supplier_payments sp
            JOIN tbl_payment_methods p ON sp.payment_method_id = p.id 
            WHERE sp.del_status='Live' $supplierPayment $sp_account_type HAVING sum(sp.amount) > 0) 

            UNION 
            (SELECT 'Sale Return' as type, sr.date, p.name as account_type, sr.note as note, 0 as credit, sum(sr.total_return_amount) as debit
            FROM tbl_sale_return sr
            JOIN tbl_payment_methods p ON sr.payment_method_id = p.id 
            WHERE sr.del_status='Live' $saleReturnDateRange $sr_account_type HAVING sum(sr.total_return_amount) > 0)  

            UNION 
            (SELECT 'Expense' as type, e.date, p.name as account_type, e.note, 0 as credit, sum(e.amount) as debit
            FROM tbl_expenses e
            JOIN tbl_payment_methods p ON e.payment_method_id = p.id 
            WHERE e.del_status='Live' $expenseDateRange $e_account_type HAVING sum(e.amount) > 0)

            UNION 
            (SELECT 'Salary' as type, s.date, p.name as account_type, '' as note, 0 as credit, sum(s.total_amount) as debit
            FROM tbl_salaries s
            JOIN tbl_payment_methods p ON s.payment_id = p.id 
            WHERE s.del_status='Live' $salaryDateRange $s_account_type HAVING sum(s.total_amount) > 0)

            UNION 
            (SELECT 'Damage' as type, d.date, '' as account_type, d.note, 0 as credit, sum(d.total_loss) as debit
            FROM tbl_damages d
            WHERE d.del_status='Live' $damageDateRange HAVING sum(d.total_loss) > 0)

        ) as b ORDER BY b.date ASC")->result();
        return $balanceStatement;
    }

}

