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
  # This is Stock_model Model
  ###########################################################
 */
class Stock_model extends CI_Model {

    /**
     * getDataByCatId
     * @access public
     * @param int
     * @param string
     * @return object
     */
    public function getDataByCatId($cat_id, $table_name) {
        $this->db->select("id,name,code");
        $this->db->from($table_name);
        $this->db->where("category_id", $cat_id);
        $this->db->where("type !=", '0');
        $this->db->order_by("name", "ASC");
        $this->db->where("del_status", 'Live');
        return $this->db->get()->result();
    }


    /**
     * getStock
     * @access public
     * @param int
     * @param int
     * @param int
     * @param int
     * @param string
     * @return object
     */
    public function getStock($category_id = "", $item_id = "", $brand_id = "",$supplier_id='',$item_code='') {
        $outlet_id = $this->session->userdata('outlet_id');
        $company_id = $this->session->userdata('company_id');
        $where = '';
        $where2 = '';
        if($brand_id!=''){
            $where.= " AND i.brand_id = '$brand_id'";
        }
        if($category_id!=''){
            $where.= " AND i.category_id = '$category_id'";
        }
        if($item_id!=''){
            $where.= " AND i.id = '$item_id'";
        }else{
            $where.= " AND i.parent_id = '0'"; 
        }
        if($supplier_id!=''){
            $where.= "  AND i.supplier_id = '$supplier_id'";
        }
        if($item_code!=''){
            $where.= "  AND i.code = '$item_code'";
        }
        // $installment_sale = 
        $result = $this->db->query("SELECT i.*,i.name as item_name, i.purchase_price as last_purchase_price,

            (select SUM(stock_quantity) from tbl_set_opening_stocks where item_id=i.id AND outlet_id=$outlet_id AND del_status='Live') total_opening_stock, 

            (select SUM(quantity_amount) from tbl_purchase_details where item_id=i.id AND outlet_id=$outlet_id AND del_status='Live') total_purchase, 

            (select SUM(qty) from tbl_sales_details  where food_menu_id=i.id AND outlet_id=$outlet_id AND tbl_sales_details.del_status='Live') total_sale,

            (select SUM(damage_quantity) from tbl_damage_details  where item_id=i.id AND outlet_id=$outlet_id AND tbl_damage_details.del_status='Live') total_damage,

            (select COUNT(id) from tbl_installments  where item_id=i.id AND outlet_id=$outlet_id AND tbl_installments.del_status='Live') total_installment_sale,

            (select SUM(return_quantity_amount) from tbl_purchase_return_details  where item_id=i.id AND outlet_id=$outlet_id AND tbl_purchase_return_details.del_status='Live' AND (tbl_purchase_return_details.return_status ='taken_by_sup_pro_not_returned' OR tbl_purchase_return_details.return_status ='taken_by_sup_money_returned')) total_purchase_return,

            (select SUM(return_quantity_amount) from tbl_sale_return_details  where item_id=i.id AND outlet_id=$outlet_id AND tbl_sale_return_details.del_status='Live') total_sale_return,

            (select SUM(quantity_amount) from tbl_transfer_items  where ingredient_id=i.id AND to_outlet_id=$outlet_id AND tbl_transfer_items.status=1 AND  tbl_transfer_items.del_status='Live') total_transfer_plus,

            (select SUM(quantity_amount) from tbl_transfer_items  where ingredient_id=i.id AND from_outlet_id=$outlet_id AND tbl_transfer_items.status=1  AND tbl_transfer_items.del_status='Live') total_transfer_minus,
            
            (select name from tbl_item_categories where id=i.category_id AND del_status='Live') category_name,

            (select unit_name from tbl_units where id=i.purchase_unit_id AND del_status='Live') purchse_unit_name,

            (select unit_name from tbl_units where id=i.sale_unit_id AND del_status='Live')  sale_unit_name
            
            FROM tbl_items i WHERE i.del_status='Live' AND i.type != 'Service_Product' AND i.company_id= '$company_id' $where ORDER BY i.id DESC")->result();
        return $result;
    }
    /**
     * getStockFromMasterTable
     * @access public
     * @param int
     * @param string
     * @param int
     * @param int
     * @param int
     * @param string
     * @return object
     */
    public function getStockFromMasterTable($item_id="",$item_code="",$brand_id="",$category_id="",$supplier_id="", $generic_name = "") {
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

        $outlet_id = $this->session->userdata('outlet_id');
        $company_id = $this->session->userdata('company_id');
        $result = $this->db->query("SELECT 
            p.id, p.name, p.code, p.type, p.alert_quantity, p.unit_type,p.last_three_purchase_avg, p.last_purchase_price, p.conversion_rate, 
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
                SELECT GROUP_CONCAT(
                    CONCAT(exp.expiry_imei_serial, '|', COALESCE(exp_sum.sum_quantity, 0)) SEPARATOR '||')
                FROM tbl_stock_detail2 exp
                LEFT JOIN (
                    SELECT expiry_imei_serial, COALESCE(SUM(stock_quantity), 0) as sum_quantity
                    FROM tbl_stock_detail2
                    WHERE outlet_id = '$outlet_id'
                    GROUP BY expiry_imei_serial
                ) exp_sum ON exp.expiry_imei_serial = exp_sum.expiry_imei_serial
                WHERE exp.item_id = p.id AND exp.outlet_id = '$outlet_id'
            ) as allexpiry
        FROM tbl_items p
        LEFT JOIN tbl_item_categories c ON p.category_id = c.id
        LEFT JOIN tbl_units pu ON pu.id = p.purchase_unit_id
        LEFT JOIN tbl_units su ON su.id = p.sale_unit_id
        WHERE p.type != 'Service_Product' AND p.type != '0' AND p.company_id='$company_id' AND p.enable_disable_status = 'Enable' AND p.del_status = 'Live' $where ORDER BY p.name ASC")->result();

        $this->db->last_query(); exit;

        if ($result) {
            return $result;
        } else {
            return false;
        } 




    }
    /**
     * getItemForPOS
     * @access public
     * @param int
     * @param int
     * @param int
     * @param int
     * @param string
     * @return object
     */
    public function getItemForPOS($category_id = "", $item_id = "", $brand_id = "",$supplier_id='',$item_code='') {
        $grocerexp  = $this->session->userdata('grocery_experience');
        $company_id = $this->session->userdata('company_id');
        $where = '';
        $order_statgus = "i.id DESC";

        if ($grocerexp) {
            $order_statgus = "i.name ASC";  // Use table alias 'i' for consistency
        }

        if ($brand_id != '') {
            $where .= " AND i.brand_id = '$brand_id'";
        }

        if ($category_id != '') {
            $where .= " AND i.category_id = '$category_id'";
        }

        if ($item_id != '') {
            $where .= " AND i.id = '$item_id'";
        }

        if ($supplier_id != '') {
            $where .= " AND i.supplier_id = '$supplier_id'";
        }

        if ($item_code != '') {
            $where .= " AND i.code = '$item_code'";
        }

        $query = "SELECT 
                i.id, i.code, i.name as item_name, i.type, i.expiry_date_maintain, i.conversion_rate, i.generic_name, 
                i.brand_id, i.sale_price, i.whole_sale_price, i.purchase_price, i.last_purchase_price, i.tax_information, i.photo, 
                i.warranty, i.guarantee, i.description, i.category_id, i.parent_id, i.supplier_id,
                b.name as brand_name, sup.name as supplier_name, 
                pu.unit_name as purchase_unit_name, su.unit_name as sale_unit_name, 
                ic.name as category_name, r.name as rack_name
            FROM 
                tbl_items i 
            LEFT JOIN
                tbl_brands b ON i.brand_id = b.id
            LEFT JOIN
                tbl_racks r ON i.rack_id = r.id
            LEFT JOIN
                tbl_suppliers sup ON i.supplier_id = sup.id
            LEFT JOIN
                tbl_units pu ON i.purchase_unit_id = pu.id
            LEFT JOIN
                tbl_units su ON i.sale_unit_id = su.id
            LEFT JOIN
                tbl_item_categories ic ON i.category_id = ic.id
            WHERE 
                i.enable_disable_status = 'Enable' 
                AND
                i.del_status = 'Live' 
                AND i.company_id = '$company_id' 
                $where 
            ORDER BY 
                $order_statgus";
        $result = $this->db->query($query)->result();
        return $result;
    }

    /**
     * getPullLowStock
     * @access public
     * @param int
     * @param int
     * @param int
     * @param int
     * @param string
     * @return object
     */
    public function getPullLowStock($category_id = "", $item_id = "", $brand_id = "",$supplier_id='',$item_code='') {
        $where = '';
        if($supplier_id != ''){
            $where.= "  AND p.supplier_id = '$supplier_id'";
        }

        $outlet_id = $this->session->userdata('outlet_id');
        $company_id = $this->session->userdata('company_id');
        $result = $this->db->query("SELECT p.id, p.name, p.code, p.type, p.alert_quantity, p.unit_type,p.last_three_purchase_avg, p.last_purchase_price, p.conversion_rate, c.name as category_name, pu.unit_name as purchase_unit, su.unit_name as sale_unit,
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

        FROM tbl_items p
        LEFT JOIN tbl_item_categories c ON p.category_id = c.id
        LEFT JOIN tbl_units pu ON pu.id = p.purchase_unit_id
        LEFT JOIN tbl_units su ON su.id = p.sale_unit_id
        WHERE p.type = 'General_Product' AND p.company_id='$company_id' AND p.enable_disable_status = 'Enable' AND p.del_status = 'Live' $where 
        GROUP BY p.id
        HAVING (stock_qty - out_qty) < p.alert_quantity
        ORDER BY p.name ASC")->result();
        return $result;
    }


    /**
     * getStockByItemId
     * @access public
     * @param int
     * @return object
     */
    public function getStockByItemId($item_id = "") {
        $outlet_id = $this->session->userdata('outlet_id');
        $company_id = $this->session->userdata('company_id');
        $where = '';
        if($item_id!=''){
            $where.= "  AND i.id = '$item_id'";
        }
        $result = $this->db->query("SELECT i.*,i.name as item_name, i.purchase_price as last_purchase_price,
        (select SUM(stock_quantity) from tbl_set_opening_stocks where item_id=i.id AND outlet_id=$outlet_id AND del_status='Live') total_opening_stock, 
        (select SUM(quantity_amount) from tbl_purchase_details where item_id=i.id AND outlet_id=$outlet_id AND del_status='Live') total_purchase, 
        (select SUM(qty) from tbl_sales_details  where food_menu_id=i.id AND outlet_id=$outlet_id AND tbl_sales_details.del_status='Live') total_sale,
        (select SUM(damage_quantity) from tbl_damage_details  where item_id=i.id AND outlet_id=$outlet_id AND tbl_damage_details.del_status='Live') total_damage,
        (select COUNT(id) from tbl_installments  where item_id=i.id AND outlet_id=$outlet_id AND tbl_installments.del_status='Live') total_installment_sale,
        (select SUM(return_quantity_amount) from tbl_purchase_return_details  where item_id=i.id AND outlet_id=$outlet_id AND tbl_purchase_return_details.del_status='Live' AND (tbl_purchase_return_details.return_status ='taken_by_sup_pro_not_returned' OR tbl_purchase_return_details.return_status ='taken_by_sup_money_returned')) total_purchase_return,
        (select SUM(return_quantity_amount) from tbl_sale_return_details  where item_id=i.id AND outlet_id=$outlet_id AND tbl_sale_return_details.del_status='Live') total_sale_return,
        (select SUM(quantity_amount) from tbl_transfer_items  where ingredient_id=i.id AND to_outlet_id=$outlet_id AND  tbl_transfer_items.del_status='Live' AND  tbl_transfer_items.status=1) total_transfer_plus,
        (select SUM(quantity_amount) from tbl_transfer_items  where ingredient_id=i.id AND from_outlet_id=$outlet_id AND  tbl_transfer_items.del_status='Live' AND tbl_transfer_items.status=2) total_transfer_minus,
            (select name from tbl_item_categories where id=i.category_id AND del_status='Live') category_name,
            (select unit_name from tbl_units where id=i.purchase_unit_id AND del_status='Live') purchse_unit_name,
            (select unit_name from tbl_units where id=i.sale_unit_id AND del_status='Live') sale_unit_name
            FROM tbl_items i WHERE i.del_status='Live' AND i.company_id= '$company_id' $where ORDER BY i.name ASC")->row();
        return $result;
    }
    
    /**
     * get_variation_products
     * @access public
     * @param int
     * @return object
     */
    public function get_variation_products($item_id = "") {
        $outlet_id = $this->session->userdata('outlet_id');
        
        $result = $this->db->query("SELECT i.*,i.name as item_name, i.purchase_price as last_purchase_price, 
        
        (select SUM(stock_quantity) from tbl_set_opening_stocks where item_id=i.id AND outlet_id=$outlet_id AND del_status='Live') total_opening_stock, 


        (select SUM(quantity_amount) from tbl_purchase_details where item_id=i.id AND outlet_id=$outlet_id AND del_status='Live') total_purchase, 

        (select SUM(qty) from tbl_sales_details  where food_menu_id=i.id AND outlet_id=$outlet_id AND tbl_sales_details.del_status='Live') total_sale,

        (select SUM(damage_quantity) from tbl_damage_details  where item_id=i.id AND outlet_id=$outlet_id AND tbl_damage_details.del_status='Live') total_damage,

        (select COUNT(id) from tbl_installments  where item_id=i.id AND outlet_id=$outlet_id AND tbl_installments.del_status='Live') total_installment_sale,

        (select SUM(return_quantity_amount) from tbl_purchase_return_details  where item_id=i.id AND outlet_id=$outlet_id AND tbl_purchase_return_details.del_status='Live' AND (tbl_purchase_return_details.return_status ='taken_by_sup_pro_not_returned' OR tbl_purchase_return_details.return_status ='taken_by_sup_money_returned')) total_purchase_return,

        (select SUM(return_quantity_amount) from tbl_sale_return_details  where item_id=i.id AND outlet_id=$outlet_id AND tbl_sale_return_details.del_status='Live') total_sale_return,

        (select SUM(quantity_amount) from tbl_transfer_items  where ingredient_id=i.id AND to_outlet_id=$outlet_id AND  tbl_transfer_items.del_status='Live' AND  tbl_transfer_items.status=1) total_transfer_plus,

        (select SUM(quantity_amount) from tbl_transfer_items  where ingredient_id=i.id AND from_outlet_id=$outlet_id AND  tbl_transfer_items.del_status='Live' AND tbl_transfer_items.status=2) total_transfer_minus,

        (select name from tbl_item_categories where id=i.category_id AND del_status='Live') category_name,

        (select unit_name from tbl_units where id=i.purchase_unit_id AND del_status='Live') purchse_unit_name,

        (select unit_name from tbl_units where id=i.sale_unit_id AND del_status='Live')  sale_unit_name
        
        FROM tbl_items i WHERE i.del_status='Live' AND i.parent_id='$item_id' AND i.alert_quantity IS NOT NULL  ORDER BY i.name ASC")->result();
            return $result;
    }


    /**
     * getAllByCompanyIdForDropdown
     * @access public
     * @param int
     * @param string
     * @return object
     */
    public function getAllByCompanyIdForDropdown($company_id, $table_name) {
        $result = $this->db->query("SELECT * 
          FROM $table_name 
          WHERE company_id=$company_id AND del_status = 'Live'  
          ORDER BY name ASC")->result();
        return $result;
    }



    /**
     * make_datatables
     * @access public
     * @param int
     * @param string
     * @param int
     * @param int
     * @param int
     * @param string
     * @return object
     */
    public function make_datatables($item_id,$item_code,$brand_id,$category_id,$supplier_id,$generic_name){
        $where = '';
        $search_string =  $_POST['search']['value'];
        if ($search_string) {
            $where .= " AND (p.code LIKE '%$search_string%' OR p.name LIKE '%$search_string%' OR c.name LIKE '%$search_string%')";
        }
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
        $start = $_POST["start"];
        $length = $_POST["length"];
        $outlet_id = $this->session->userdata('outlet_id');
        $company_id = $this->session->userdata('company_id');
        $data = $this->db->query("SELECT 
            p.id, p.name, p.code, p.type, p.expiry_date_maintain, p.alert_quantity, p.unit_type,
            p.last_three_purchase_avg, p.last_purchase_price, p.conversion_rate, 
            c.name as category_name, pu.unit_name as purchase_unit, su.unit_name as sale_unit,
            (
                SELECT GROUP_CONCAT(DISTINCT st.expiry_imei_serial SEPARATOR '||') as dd
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
        ORDER BY p.name ASC 
        LIMIT $start, $length")->result();
        return $data;
    }


    /**
     * make_datatablesLowStock
     * @access public
     * @param int
     * @param string
     * @param int
     * @param int
     * @param int
     * @param string
     * @return object
     */
    public function make_datatablesLowStock($item_id,$item_code,$brand_id,$category_id,$supplier_id,$generic_name){
        $where = '';
        $search_string =  $_POST['search']['value'];
        if ($search_string) {
            $where .= " AND (p.code LIKE '%$search_string%' OR p.name LIKE '%$search_string%' OR c.name LIKE '%$search_string%')";
        }
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
      
        $start = $_POST["start"];
        $length = $_POST["length"];

        $outlet_id = $this->session->userdata('outlet_id');
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
            ORDER BY p.name ASC LIMIT $start, $length")->result();
            return $data;
    }

    /**
     * get_all_data
     * @access public
     * @param int
     * @param string
     * @param int
     * @param int
     * @param int
     * @param string
     * @return int
     */
    public function get_all_data($item_id="",$item_code="",$brand_id="",$category_id="",$supplier_id="", $generic_name=""){
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

        $outlet_id = $this->session->userdata('outlet_id');
        $company_id = $this->session->userdata('company_id');
        $data = $this->db->query("SELECT COUNT(*) AS count,
        p.id, p.name, p.code, p.type, p.alert_quantity, p.unit_type,p.last_three_purchase_avg, p.last_purchase_price, p.conversion_rate, 
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
                    GROUP BY exp.expiry_imei_serial ) 
                as c WHERE c.item_id=p.id GROUP BY c.item_id
        ) as allexpiry
        FROM tbl_items p
        LEFT JOIN tbl_item_categories c ON p.category_id = c.id
        LEFT JOIN tbl_units pu ON pu.id = p.purchase_unit_id
        LEFT JOIN tbl_units su ON su.id = p.sale_unit_id
        WHERE p.type != 'Service_Product' AND p.type != '0' AND p.company_id='$company_id' AND p.enable_disable_status = 'Enable' AND p.del_status = 'Live' $where ORDER BY p.name ASC")->row();
        $count = (int)$data->count;
        return $count;
    }



    /**
     * getLowStockItems
     * @access public
     * @param int
     * @param string
     * @param int
     * @param int
     * @param int
     * @param string
     * @return object
     */
    public function getLowStockItems($item_id="",$item_code="",$brand_id="",$category_id="",$supplier_id="", $generic_name = ""){
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
        
        $outlet_id = $this->session->userdata('outlet_id');
        $company_id = $this->session->userdata('company_id');

        $result = $this->db->query("SELECT 
            p.id, p.name, p.code, p.type, p.alert_quantity, p.unit_type,p.last_three_purchase_avg, p.expiry_date_maintain, p.last_purchase_price, p.conversion_rate, 
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
                        GROUP BY exp.expiry_imei_serial ) 
                    as c WHERE c.item_id=p.id GROUP BY c.item_id
            ) as allexpiry
            FROM tbl_items p
            LEFT JOIN tbl_item_categories c ON p.category_id = c.id
            LEFT JOIN tbl_units pu ON pu.id = p.purchase_unit_id
            LEFT JOIN tbl_units su ON su.id = p.sale_unit_id
            WHERE p.type != 'Service_Product' AND p.type != '0' AND p.company_id = '$company_id' AND p.enable_disable_status = 'Enable' AND p.del_status = 'Live' $where
            GROUP BY p.id
            HAVING 
                CASE 
                    WHEN p.type = 'Variation_Product' THEN TRUE
                    WHEN p.type = 'Medicine_Product' THEN TRUE
                    ELSE (stock_qty - out_qty) < p.alert_quantity
                END
            ORDER BY p.name ASC")->result();
            if ($result) {
                return $result;
            } else {
                return false;
            } 
    }


}

?>
