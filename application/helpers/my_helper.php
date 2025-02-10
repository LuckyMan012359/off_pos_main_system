<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;
use SendinBlue\Client\Configuration;
use GuzzleHttp\Exception\ClientException;
use SendinBlue\Client\Api\TransactionalEmailsApi;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;



/**
 * pre
 * @param string
 * @return string
 */
if(!function_exists('pre')){
    function pre($param) {
        echo '<pre>';
        print_r($param);
        echo '</pre>';
        exit;
    }
}

/**
 * preE
 * @param string
 * @return string
 */
if(!function_exists('preE')){
    function preE($param) {
        echo '<pre>';
        print_r($param);
        echo '</pre>';
    }
}

/**
 * absCustom
 * @param no
 * @return string
 */
if(!function_exists('absCustom')){
    function absCustom($amount){
        $newAmt = $amount ?? 0;
        return abs($newAmt);
    }
}


/**
 * getAllSessionData
 * @param no
 * @return string
 */
if(!function_exists('getAllSessionData')){
    function getAllSessionData(){
        $CI = & get_instance();
        echo '<pre>'; print_r($CI->session->all_userdata());
        echo '</pre>';
        exit;
    }
}

/**
 * get_url_segments
 * @param no
 * @return string
 */
if(!function_exists('get_url_segments')){
    function get_url_segments(){
        $CI = & get_instance();
        return $CI->uri->segment(1);
    }
}

/**
 * htmlspecialcharscustom
 * @param string
 * @return string
 */
if(!function_exists('htmlspecialcharscustom')){
    function htmlspecialcharscustom($value) {
        $output = (isset($value) && $value ? htmlspecialchars($value) : '');
        $output = str_replace("&amp;", "&",$output);
        return $output;
    }
}


/**
 * getAmtPre
 * @param int
 * @return float
 */
if(!function_exists('getAmtPre')){
    function getAmtPre($value) {
        $CI = & get_instance();
        $value = (int)$value;
        $getCompanyInfo = getCompanyInfo();
        $precision = $getCompanyInfo->precision;
        if($precision == ''){
            $precision = 0;
        }else{
            $precision = $getCompanyInfo->precision;
        }
        $str_amount = (number_format(isset($value) && $value?$value:0,$precision,'.',''));
        return $str_amount;
    }
}

/**
 * getLastSaleId
 * @param no
 * @return int
 */
if(!function_exists('getLastSaleId')){
    function getLastSaleId() {
        $CI = & get_instance();
        $outlet_id = $CI->session->userdata('outlet_id');
        $CI->db->select('*');
        $CI->db->from('tbl_sales');
        $CI->db->where('outlet_id', $outlet_id);
        $CI->db->where('del_status', "Live");
        $CI->db->order_by('id desc');
        $last_row =   $CI->db->get()->row();
        return $last_row ? $CI->custom->encrypt_decrypt($last_row->id, 'encrypt'):'';
    }
}

/**
 * getPrinterInfoById
 * @param int
 * @return object
 */
if(!function_exists('getPrinterInfoById')){
    function getPrinterInfoById($id) {
        $CI = & get_instance();
        $company_id = $CI->session->userdata('company_id');
        $CI->db->select('*');
        $CI->db->from('tbl_printers');
        $CI->db->where('id', $id);
        $CI->db->where('company_id', $company_id);
        $CI->db->where('del_status', "Live");
        $result = $CI->db->get()->row();
        return $result;
    }
}


/**
 * getName
 * @param string
 * @param int
 * @return object
 */
if(!function_exists('getName')){
    function getName($table_name, $id) {
        $CI = & get_instance();
        $information = $CI->db->query("SELECT `name` FROM $table_name where `id`='$id'")->row();
        if($information){
            return escape_output($information->name);
        }else{
            return "N/A";
        }
    }
}

/**
 * numberToWritten
 * @param int
 * @return object
 */
if(!function_exists('numberToWritten')){
    function numberToWritten($num){
        $num = str_replace(array(',', ' '), '' , trim($num));
        if(! $num) {
            return false;
        }
        $num = (int) $num;
        $words = array();
        $list1 = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
            'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
        );
        $list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
        $list3 = array('', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
            'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
            'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
        );
        $num_length = strlen($num);
        $levels = (int) (($num_length + 2) / 3);
        $max_length = $levels * 3;
        $num = substr('00' . $num, -$max_length);
        $num_levels = str_split($num, 3);
        for ($i = 0; $i < count($num_levels); $i++) {
            $levels--;
            $hundreds = (int) ($num_levels[$i] / 100);
            $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ' ' : '');
            $tens = (int) ($num_levels[$i] % 100);
            $singles = '';
            if ( $tens < 20 ) {
                $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '' );
            } else {
                $tens = (int)($tens / 10);
                $tens = ' ' . $list2[$tens] . ' ';
                $singles = (int) ($num_levels[$i] % 10);
                $singles = ' ' . $list1[$singles] . ' ';
            }
            $words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_levels[$i] ) ) ? ' ' . $list3[$levels] . ' ' : '' );
        } //end for loop
        $commas = count($words);
        if ($commas > 1) {
            $commas = $commas - 1;
        }
        $str_return = implode(' ', $words);
        return ucwords($str_return);
    }
}


/**
 * convertGroup
 * @param int
 * @return string
 */
if(!function_exists('convertGroup')){
    function convertGroup($index){
        switch ($index)
        {
            case 11:
                return " decillion";
            case 10:
                return " nonillion";
            case 9:
                return " octillion";
            case 8:
                return " septillion";
            case 7:
                return " sextillion";
            case 6:
                return " quintrillion";
            case 5:
                return " quadrillion";
            case 4:
                return " trillion";
            case 3:
                return " billion";
            case 2:
                return " million";
            case 1:
                return " thousand";
            case 0:
                return "";
        }
    }
}

/**
 * convertThreeDigit
 * @param int
 * @param int
 * @param int
 * @return int
 */
if(!function_exists('convertThreeDigit')){
    function convertThreeDigit($digit1, $digit2, $digit3){
        $buffer = "";
        if ($digit1 == "0" && $digit2 == "0" && $digit3 == "0"){
            return "";
        }
        if ($digit1 != "0"){
            $buffer .= convertDigit($digit1) . " hundred";
            if ($digit2 != "0" || $digit3 != "0")
            {
                $buffer .= " and ";
            }
        }
        if ($digit2 != "0"){
            $buffer .= convertTwoDigit($digit2, $digit3);
        }else if ($digit3 != "0"){
            $buffer .= convertDigit($digit3);
        }
        return $buffer;
    }
}

/**
 * convertTwoDigit
 * @param int
 * @param int
 * @return string
 */
if(!function_exists('convertTwoDigit')){
    function convertTwoDigit($digit1, $digit2){
        if ($digit2 == "0")
        {
            switch ($digit1)
            {
                case "1":
                    return "ten";
                case "2":
                    return "twenty";
                case "3":
                    return "thirty";
                case "4":
                    return "forty";
                case "5":
                    return "fifty";
                case "6":
                    return "sixty";
                case "7":
                    return "seventy";
                case "8":
                    return "eighty";
                case "9":
                    return "ninety";
            }
        } else if ($digit1 == "1"){
            switch ($digit2){
                case "1":
                    return "eleven";
                case "2":
                    return "twelve";
                case "3":
                    return "thirteen";
                case "4":
                    return "fourteen";
                case "5":
                    return "fifteen";
                case "6":
                    return "sixteen";
                case "7":
                    return "seventeen";
                case "8":
                    return "eighteen";
                case "9":
                    return "nineteen";
            }
        } else {
            $temp = convertDigit($digit2);
            switch ($digit1) {
                case "2":
                    return "twenty $temp";
                case "3":
                    return "thirty $temp";
                case "4":
                    return "forty $temp";
                case "5":
                    return "fifty $temp";
                case "6":
                    return "sixty $temp";
                case "7":
                    return "seventy $temp";
                case "8":
                    return "eighty $temp";
                case "9":
                    return "ninety $temp";
            }
        }
    }
}


/**
 * convertDigit
 * @param int
 * @return string
 */
if(!function_exists('convertDigit')){
    function convertDigit($digit){
        switch ($digit){
            case "0":
                return "zero";
            case "1":
                return "one";
            case "2":
                return "two";
            case "3":
                return "three";
            case "4":
                return "four";
            case "5":
                return "five";
            case "6":
                return "six";
            case "7":
                return "seven";
            case "8":
                return "eight";
            case "9":
                return "nine";
        }
    }
}


/**
 * numtostr
 * @param int
 * @return string
 */
if(!function_exists('numtostr')){
    function numtostr($number){
        $decimal = round($number - ($no = floor($number)), 2) * 100;
        $hundred = null;
        $digits_length = strlen($no);
        $i = 0;
        $str = array();
        $words = array(0 => '', 1 => 'one', 2 => 'two',
            3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
            7 => 'seven', 8 => 'eight', 9 => 'nine',
            10 => 'ten', 11 => 'eleven', 12 => 'twelve',
            13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
            16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
            19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
            40 => 'forty', 50 => 'fifty', 60 => 'sixty',
            70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
        $digits = array('', 'hundred','thousand','lakh', 'crore');
        while( $i < $digits_length ) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += $divider == 10 ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                @$str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' ' .$digits[$counter].$plural.' '.$hundred;
            } else $str[] = null;
        }
        $taka = implode('', array_reverse($str));
        $paise = ($decimal > 0) ? "point " . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . '' : '';
        return ucwords($taka ? $taka . '' : '') . ucwords($paise);
    }
}

/**
 * userName
 * @param int
 * @return string
 */
if(!function_exists('userName')){
    function userName($user_id) {
        $CI = & get_instance();
        $user_information = $CI->db->query("SELECT full_name FROM tbl_users where `id`='$user_id'")->row();
        if($user_information){
            return escape_output($user_information->full_name);
        }else{
            return "";
        }
    }
}

/**
 * getGroup
 * @param int
 * @return string
 */
if(!function_exists('getGroup')){
    function getGroup($user_id) {
        $CI = & get_instance();
        $user_information = $CI->db->query("SELECT group_name FROM tbl_customer_groups where `id`='$user_id'")->row();
        if($user_information){
            return escape_output($user_information->group_name);
        }else{
            return "";
        }
    }
}

/**
 * getPartnerName
 * @param int
 * @return string
 */
if(!function_exists('getPartnerName')){
    function getPartnerName($partner_id) {
        $CI = & get_instance();
        $result = $CI->db->query("SELECT partner_name FROM tbl_delivery_partners where `id`='$partner_id'")->row();
        if($result){
            return escape_output($result->partner_name);
        }else{
            return "";
        }
    }
}


/**
 * getCustomerName
 * @param int
 * @return string
 */
if(!function_exists('getCustomerName')){
    function getCustomerName($customer_id) {
        $CI = & get_instance();
        $information = $CI->db->query("SELECT name FROM tbl_customers where `id`='$customer_id'")->row();
        if($information){
            return escape_output($information->name);
        }else{
            return "";
        }
    }
}
/**
 * getDeliveryPartnerNameById
 * @param int
 * @return string
 */
if(!function_exists('getDeliveryPartnerNameById')){
    function getDeliveryPartnerNameById($partner_id) {
        $CI = & get_instance();
        $information = $CI->db->query("SELECT partner_name FROM tbl_delivery_partners where `id`='$partner_id'")->row();
        if($information){
            return escape_output($information->partner_name);
        }else{
            return "";
        }
    }
}

/**
 * getCustomeInfo
 * @param int
 * @return object
 */
if(!function_exists('getCustomeInfo')){
    function getCustomeInfo($customer_id) {
        $CI = & get_instance();
        $information = $CI->db->query("SELECT * FROM tbl_customers where `id`='$customer_id'")->row();
        return $information;
    }
}


/**
 * getMainModuleName
 * @param int
 * @return object
 */
if (!function_exists('getMainModuleName')) {
    function getMainModuleName($id)
    {
        $CI = &get_instance();
        $CI->db->select("*");
        $CI->db->from("tbl_main_modules");
        $CI->db->where("id", $id);
        $result = $CI->db->get()->row();
        if ($result) {
            return escape_output($result->name);
        } else {
            return '';
        }
    }
}


/**
 * getSupplierName
 * @param int
 * @return object
 */
if(!function_exists('getSupplierName')){
    function getSupplierName($supplier_id) {
        $CI = & get_instance();
        $information = $CI->db->query("SELECT name FROM tbl_suppliers where `id`='$supplier_id'")->row();
        if($information){
            return escape_output($information->name);
        }else{
            return "";
        }
    }
}


/**
 * getBrand
 * @param int
 * @return object
 */
if(!function_exists('getBrand')){
    function getBrand($brand_id) {
        $CI = & get_instance();
        $CI->db->select("name");
        $CI->db->from("tbl_brands");
        $CI->db->where("id", $brand_id);
        $CI->db->where("del_status", "Live");
        $CI->db->order_by("id", "DESC");
        $information = $CI->db->get()->row();
        return isset($information->name) && $information->name ? escape_output($information->name) : "";
    }
}

/**
 * getDataByCompanyId
 * @param int
 * @param string
 * @return object
 */
if(!function_exists('getDataByCompanyId')){
    function getDataByCompanyId($id, $table){
        $CI = & get_instance();
        $CI->db->select('*');
        $CI->db->from($table);
        $CI->db->where('company_id', $id);
        $CI->db->where('del_status', 'Live');
        $query_result = $CI->db->get();
        $result = $query_result->result();
        return $result;
    }
}
/**
 * getBookingData
 * @param int
 * @param string
 * @return object
 */
if(!function_exists('getBookingData')){
    function getBookingData(){
        $CI = & get_instance();
        $company_id = $CI->session->userdata('company_id');
        $CI->db->select('b.id, b.start_date, b.end_date, b.status, c.name as customer_name, u.full_name as service_seller_name');
        $CI->db->from('tbl_bookings b');
        $CI->db->join('tbl_customers c', 'c.id = b.customer_id', 'left');
        $CI->db->join('tbl_users u', 'u.id = b.service_seller_id', 'left');
        $CI->db->where('b.company_id', $company_id);
        $CI->db->where('b.del_status', 'Live');
        $query_result = $CI->db->get();
        $result = $query_result->result();
        return $result;
    }
}


/**
 * getDataById
 * @param int
 * @param string
 * @return object
 */
if(!function_exists('getDataById')){
    function getDataById($id, $table){
        $CI = & get_instance();
        $CI->db->select('*');
        $CI->db->from($table);
        $CI->db->where('id', $id);
        $CI->db->where('del_status', 'Live');
        $query_result = $CI->db->get();
        $result = $query_result->row();
        return $result;
    }
}


/**
 * getSupplierInfoById
 * @param int
 * @return object
 */
if(!function_exists('getSupplierInfoById')){
    function getSupplierInfoById($id){
        $CI = & get_instance();
        $CI->db->select('*');
        $CI->db->from('tbl_suppliers');
        $CI->db->where('id', $id);
        $CI->db->where('del_status', 'Live');
        $query_result = $CI->db->get();
        $result = $query_result->row();
        return $result;
    }
}

/**
 * getOpeningStockDetails
 * @param int
 * @return object
 */
if(!function_exists('getOpeningStockDetails')){
    function getOpeningStockDetails($item_id){
        $CI = & get_instance();
        $company_id = $CI->session->userdata('company_id');
        $CI->db->select('stock_quantity,outlet_id,item_id, item_description');
        $CI->db->from('tbl_set_opening_stocks');
        $CI->db->where('item_id', $item_id);
        $CI->db->where('company_id', $company_id);
        $CI->db->where('del_status', 'Live');
        $query_result = $CI->db->get();
        $result = $query_result->result();
        return $result;
    }
}


/**
 * getItemOpeningStock
 * @param int
 * @return object
 */
if(!function_exists('getItemOpeningStock')){
    function getItemOpeningStock($id) {
        $CI = & get_instance();
        $CI->db->select("os.stock_quantity, os.item_description, o.outlet_name");
        $CI->db->from('tbl_set_opening_stocks os');
        $CI->db->join("tbl_outlets o", 'o.id = os.outlet_id');
        $CI->db->where("os.item_id", $id);
        $CI->db->where("os.del_status", "Live");
        $CI->db->order_by("os.id", "asc");
        return $CI->db->get()->result();
    }
}

/**
 * getItemOpeningStockAndConversionRate
 * @param int
 * @return object
 */
if(!function_exists('getItemOpeningStockAndConversionRate')){
    function getItemOpeningStockAndConversionRate($item_id) {
        $CI = & get_instance();
        $CI->db->select("SUM(os.stock_quantity) as stock_quantity, i.conversion_rate");
        $CI->db->from('tbl_set_opening_stocks os');
        $CI->db->join("tbl_items i", 'i.id = os.item_id', 'left');
        $CI->db->where("os.item_id", $item_id);
        $CI->db->where("os.del_status", "Live");
        $result =  $CI->db->get()->row();
        if($result->stock_quantity){
            return $result->stock_quantity / $result->conversion_rate ;
        }else {
            return false;
        }
    }
}

/**
 * checkExistingNotification
 * @param int
 * @return object
 */
if(!function_exists('checkExistingNotification')){
    function checkExistingNotification($installment_id){
        $today = date("Y-m-d",strtotime('today'));
        $CI = & get_instance();
        $outlet_id = $CI->session->userdata('outlet_id');
        $company_id = $CI->session->userdata('company_id');
        $CI->db->select('*');
        $CI->db->from('tbl_notifications');
        $CI->db->where('date', $today);
        $CI->db->where('installment_id', $installment_id);
        $CI->db->where('outlet_id', $outlet_id);
        $CI->db->where('company_id', $company_id);
        $query_result = $CI->db->get();
        $row = $query_result->row();
        return $row;
    }
}

/**
 * createInstallmentNotifications
 * @param no
 * @return object
 */
if(!function_exists('createInstallmentNotifications')){
    function createInstallmentNotifications() {
        $CI = & get_instance();
        $outlet_id = $CI->session->userdata('outlet_id');
        $company_id = $CI->session->userdata('company_id');
        $today = date("Y-m-d",strtotime('today'));
        $forward_third_day = date("Y-m-d",strtotime('today + 3day'));

        $CI->db->select("tbl_installment_items.*,tbl_customers.name as customer_name,tbl_customers.phone,tbl_items.name as item_name");
        $CI->db->from("tbl_installment_items");
        $CI->db->join('tbl_installments', 'tbl_installments.id = tbl_installment_items.installment_id', 'left');
        $CI->db->join('tbl_customers', 'tbl_customers.id = tbl_installments.customer_id', 'left');
        $CI->db->join('tbl_items', 'tbl_items.id = tbl_installments.item_id', 'left');
        $CI->db->where('tbl_installment_items.payment_date>=', $today);
        $CI->db->where('tbl_installment_items.payment_date <=', $forward_third_day);
        $CI->db->where("tbl_installment_items.del_status", 'Live');
        $result =  $CI->db->get()->result();

        foreach ($result as $value){
            $row = checkExistingNotification($value->installment_id);
            if(!$row){
                $msg = $value->customer_name."(".$value->phone.") ".$value->item_name." er kisti ".$value->amount_of_payment." taka ".(date($CI->session->userdata('date_format'), strtotime($value->payment_date)))." e debar kotha.";
                $data = array();
                $data['installment_id'] = $value->installment_id;
                $data['date'] = $today;
                $data['notifications_details'] = $msg;
                $data['outlet_id'] = $outlet_id;
                $data['company_id'] = $company_id;
                $CI->Common_model->insertInformation($data, "tbl_notifications");
            }
        }
    }
}
/**
 * dateFormat
 * @param string
 * @return string
 */
if(!function_exists('dateFormatMaster')){
    function dateFormatMaster($paramDate='') { 
        $CI = & get_instance();
        $company_info = getMainCompany();
        $dateFormate = $company_info->date_format;
        if($paramDate == ''){
            return '';
        }
        $separate = explode(" ",$paramDate);
        $time = '';
        if(isset($separate[1]) && $separate[1]){
            $time = " <span class='time_design'>".$separate[1]."</span>";
        }
        return (date($dateFormate, strtotime($paramDate)))."".$time;
    }
}

/**
 * dateFormat
 * @param string
 * @return string
 */
if(!function_exists('dateFormat')){
    function dateFormat($paramDate='') { 
        $CI = & get_instance();
        $dateFormate = $CI->session->userdata('date_format');
        if($paramDate == ''){
            return '';
        }
        $separate = explode(" ",$paramDate);
        $time = '';
        if(isset($separate[1]) && $separate[1]){
            $time = " <span class='time_design'>".$separate[1]."</span>";
        }
        return (date($dateFormate, strtotime($paramDate)))."".$time;
    }
}

/**
 * dateFormatWithTime
 * @param string
 * @return string
 */
if(!function_exists('dateFormatWithTime')){
    function dateFormatWithTime($paramDate='') { 
        $CI = & get_instance();
        $dateFormate = $CI->session->userdata('date_format');
        $separate = explode(" ",$paramDate);
        $time = '';
        if(isset($separate[1]) && $separate[1]){
            $time = " <span class='time_design'>".$separate[1]."</span>";
        }
        return (date($dateFormate, strtotime($paramDate)))."".$time;
    }
}


/**
 * generatedOnCurrentDateTime
 * @param no
 * @return string
 */
if(!function_exists('generatedOnCurrentDateTime')){
    function generatedOnCurrentDateTime() {
        $paramDate = date('Y-m-d H:i:s');
        $CI = & get_instance();
        $dateFormate = $CI->session->userdata('date_format');
        try {
            $dateTime = new DateTime($paramDate);
            $formattedDate = $dateTime->format($dateFormate);
            $hasTime = $dateTime->format('H:i:s') !== '00:00:00';
            $formattedTime = $hasTime ? $dateTime->format('H:i:s') : '';
            $dateTime = $formattedDate . ' ' . $formattedTime;
            $html = "<strong>" . lang('generated_on') . ":</strong> " . date($dateTime, strtotime($paramDate));
            return $html;
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }
} 

/**
 * getAllPaymentMethodBySaleId
 * @param int
 * @return object
 */
if(!function_exists('getAllPaymentMethodBySaleId')){
    function getAllPaymentMethodBySaleId($sale_id){
        $CI = & get_instance();
        $CI->db->select("p.name as payment_name, sp.amount");
        $CI->db->from("tbl_sale_payments sp");
        $CI->db->join('tbl_payment_methods p', 'p.id = sp.payment_id', 'left');
        $CI->db->where("sp.sale_id", $sale_id);
        $CI->db->where("p.del_status", 'Live');
        $result =  $CI->db->get()->result();
        if($result){
            return $result;
        }else{
            return '';
        }
    }
}


/**
 * checkAccess
 * @param int
 * @param string
 * @return object
 */
if (!function_exists('checkAccess')) {
    function checkAccess($controller, $function){
        $CI = &get_instance();
        $role = $CI->session->userdata('role');
        if($role){
            if($role=="1"){
                return true;
            }else{
                $controllerFunction = $function . "-" . $controller;
                // pre($controllerFunction);
                if (!in_array($controllerFunction, $CI->session->userdata("function_access"))) {
                    return false;
                } else {
                    return true;
                }
            }
        }else{
            return false;
        }
    }
}

/**
 * getInvoiceNo
 * @param int
 * @return string
 */
if (!function_exists('getInvoiceNo')) {
    function getInvoiceNo($sale_id) {
        $CI = & get_instance();
        $information = $CI->db->query("SELECT sale_no FROM tbl_sales where `id`='$sale_id'")->row();

        if($information){
            return escape_output($information->sale_no);
        }else{
            return "";
        }
    }
}


/**
 * checkItemUnique
 * @param string
 * @return string
 */
if (!function_exists('checkItemUnique')) {
    function checkItemUnique($code) {
        $CI = & get_instance();
        $company_id = $CI->session->userdata('company_id');
        $information = $CI->db->query("SELECT id FROM tbl_items where `code`='$code' and `company_id`='$company_id' and del_status='Live'")->row();
        if($information){
            return "Yes";
        }else{
            return "No";
        }
    }
}

/**
 * getAmt
 * @param int
 * @return string
 */
if (!function_exists('getAmt')) {
    function getAmt($amount) {
        if($amount){
            return number_format($amount, 2);
        }else{
            return "0.00";
        }
    }
}


/**
 * getSupplierOpeningBalanceType
 * @param int
 * @return string
 */
if (!function_exists('getSupplierOpeningBalanceType')) {
    function getSupplierOpeningBalanceType($supplier_id) {
        $CI = & get_instance();
        $information = $CI->db->query("SELECT opening_balance_type FROM tbl_suppliers where `id`='$supplier_id'")->row();
        if($information){
            return $information->opening_balance_type;
        }else{
            return "";
        }
    }
}


/**
 * getCustomerOpeningBalanceType
 * @param int
 * @return string
 */
if (!function_exists('getCustomerOpeningBalanceType')) {
    function getCustomerOpeningBalanceType($customer_id) {
        $CI = & get_instance();
        $information = $CI->db->query("SELECT opening_balance_type FROM tbl_customers where `id`='$customer_id'")->row();
        if($information){
            return $information->opening_balance_type;
        }else{
            return "";
        }
    }
}

/**
 * getAmtP
 * @param int
 * @return float
 */
if (!function_exists('getAmtP')) {
    function getAmtP($amount) {
        if(!is_numeric($amount)){
            $amount = 0;
        }
        $getCompanyInfo = getCompanyInfo();
        $precision = $getCompanyInfo->precision;
        if($precision == ''){
            $precision = 0;
        }else{
            $precision = $getCompanyInfo->precision;
        }
        $decimals_separator = isset($getCompanyInfo->decimals_separator) && $getCompanyInfo->decimals_separator?$getCompanyInfo->decimals_separator:'.';
        $thousands_separator = isset($getCompanyInfo->thousands_separator) && $getCompanyInfo->thousands_separator?$getCompanyInfo->thousands_separator:'';
        $str_amount = (number_format(isset($amount) && $amount?$amount:0,$precision,$decimals_separator,$thousands_separator));
        return $str_amount;
    }
}

/**
 * getAmtAjax
 * @param int
 * @return float
 */
if (!function_exists('getAmtAjax')) {
    function getAmtAjax($amount) {
        if(!is_numeric($amount)){
            $amount = 0;
        }
        $getCompanyInfo = getCompanyInfo();
        $precision = $getCompanyInfo->precision;
        if($precision == ''){
            $precision = 0;
        }else{
            $precision = $getCompanyInfo->precision;
        }
        $decimals_separator = isset($getCompanyInfo->decimals_separator) && $getCompanyInfo->decimals_separator?$getCompanyInfo->decimals_separator:'.';
        $str_amount = (number_format(isset($amount) && $amount?$amount:0,$precision,$decimals_separator));
        return $str_amount;
    }
}

/**
 * getAmtCustom
 * @param int
 * @return float
 */
if (!function_exists('getAmtCustom')) {
    function getAmtCustom($amount) {
        if(!is_numeric($amount)){
            $amount = 0;
        }
        $getCompanyInfo = getCompanyInfo();
        $currency_position = $getCompanyInfo->currency_position;
        $currency = $getCompanyInfo->currency;
        $precision = $getCompanyInfo->precision;
        if($precision == ''){
            $precision = 0;
        }else{
            $precision = $getCompanyInfo->precision;
        }
        $decimals_separator = isset($getCompanyInfo->decimals_separator) && $getCompanyInfo->decimals_separator?$getCompanyInfo->decimals_separator:'.';
        $thousands_separator = isset($getCompanyInfo->thousands_separator) && $getCompanyInfo->thousands_separator?$getCompanyInfo->thousands_separator:'';
        if(isset($currency_position) && $currency_position != "Before Amount"){
            if((defined('FCCPATH') && FCCPATH == 'Bangladesh')){
                $str_amount = (number_format(isset($amount) && $amount?$amount:0,$precision,$decimals_separator,$thousands_separator)). '<span class="currency_show">'. $currency . '</span>';
            } else {
                $str_amount = (number_format(isset($amount) && $amount?$amount:0,$precision,$decimals_separator,$thousands_separator)).$currency;
            }
        }else{
            if((defined('FCCPATH') && FCCPATH == 'Bangladesh')){
                $str_amount = '<span class="currency_show">'. $currency . '</span>'.(number_format(isset($amount) && $amount?$amount:0,$precision,$decimals_separator,$thousands_separator));
            } else {
                $str_amount = $currency.(number_format(isset($amount) && $amount?$amount:0,$precision,$decimals_separator,$thousands_separator));
            }
        }
        return $str_amount;
    }
}
/**
 * getAmtStock
 * @param int
 * @return float
 */
if (!function_exists('getAmtStock')) {
    function getAmtStock($amount) {
        if(!is_numeric($amount)){
            $amount = 0;
        }
        $getCompanyInfo = getCompanyInfo();
        $currency_position = $getCompanyInfo->currency_position;
        $currency = $getCompanyInfo->currency;
        $precision = $getCompanyInfo->precision;
        if($precision == ''){
            $precision = 0;
        }else{
            $precision = 3;
        }
        $decimals_separator = isset($getCompanyInfo->decimals_separator) && $getCompanyInfo->decimals_separator?$getCompanyInfo->decimals_separator:'.';
        $thousands_separator = isset($getCompanyInfo->thousands_separator) && $getCompanyInfo->thousands_separator?$getCompanyInfo->thousands_separator:'';
        if(isset($currency_position) && $currency_position != "Before Amount"){
            $str_amount = (number_format(isset($amount) && $amount?$amount:0,$precision,$decimals_separator,$thousands_separator)).$currency;
        }else{
            $str_amount = $currency.(number_format(isset($amount) && $amount?$amount:0,$precision,$decimals_separator,$thousands_separator));
        }
        return $str_amount;
    }
}
/**
 * getAmtCustomC
 * @param int
 * @return float
 */
if (!function_exists('getAmtCustomC')) {
    function getAmtCustomC($amount, $company_id='') {
        if(!is_numeric($amount)){
            $amount = 0;
        }
        $getCompanyInfo = getMainCompany();
        $currency_position = $getCompanyInfo->currency_position;
        $currency = $getCompanyInfo->currency;
        $precision = $getCompanyInfo->precision;
        $str_amount = '';
        $decimals_separator = isset($getCompanyInfo->decimals_separator) && $getCompanyInfo->decimals_separator?$getCompanyInfo->decimals_separator:'.';
        $thousands_separator = isset($getCompanyInfo->thousands_separator) && $getCompanyInfo->thousands_separator?$getCompanyInfo->thousands_separator:'';
        if(isset($currency_position) && $currency_position!="Before Amount"){
            $str_amount = (number_format(isset($amount) && $amount?$amount:0,$precision,$decimals_separator,$thousands_separator)).$currency;
        }else{
            $str_amount = $currency.(number_format(isset($amount) && $amount?$amount:0,$precision,$decimals_separator,$thousands_separator));
        }
        return $str_amount;
    }
}

/**
 * getSupplierDue
 * @param int
 * @return int
 */
if (!function_exists('getSupplierDue')) {
    function getSupplierDue($supplier_id) {
        $CI = & get_instance();
        $outlet_id = $CI->session->userdata('outlet_id');
        $supplier = $CI->db->query("SELECT opening_balance,opening_balance_type  FROM tbl_suppliers WHERE id=$supplier_id and del_status='Live'")->row();
        $supplier_due = $CI->db->query("SELECT SUM(due_amount) as due FROM tbl_purchase WHERE supplier_id=$supplier_id and outlet_id=$outlet_id and del_status='Live'")->row();
        $supplier_payment = $CI->db->query("SELECT SUM(amount) as amount FROM tbl_supplier_payments WHERE supplier_id=$supplier_id and outlet_id=$outlet_id and del_status='Live'")->row();
        $purchase_return = $CI->db->query("SELECT SUM(total_return_amount) as total_return_amount FROM tbl_purchase_return WHERE supplier_id=$supplier_id and outlet_id=$outlet_id and del_status='Live'")->row();
        if($supplier->opening_balance_type == "Credit"){
            $remaining_due = ($supplier_due->due-$supplier_payment->amount) + $supplier->opening_balance - $purchase_return->total_return_amount;
        }else{
            $remaining_due = ($supplier_due->due-$supplier_payment->amount) - $supplier->opening_balance - $purchase_return->total_return_amount;
        }
        return $remaining_due;
    }
}

/**
 * getSupplierOpeningBalance
 * @param int
 * @param string
 * @return int
 */
if (!function_exists('getSupplierOpeningBalance')) {
    function getSupplierOpeningBalance($supplier_id, $opDate) {
        $CI = & get_instance();
        $supplier = $CI->db->query("SELECT opening_balance_type, opening_balance from tbl_suppliers where id = $supplier_id and del_status = 'Live'")->row();
        $sum_of_purchase_due = $CI->db->query("SELECT SUM(due_amount) as purchase_due_amt from tbl_purchase where supplier_id = $supplier_id and date < '$opDate' and del_status = 'Live'")->row();
        $sum_of_payment_receive = $CI->db->query("SELECT SUM(amount) as payment_receive_amt from tbl_supplier_payments where supplier_id = $supplier_id and date < '$opDate' and del_status = 'Live'")->row();
        $sum_of_purchase_return = $CI->db->query("SELECT SUM(total_return_amount) as purchase_return_amt from tbl_purchase_return where supplier_id = $supplier_id and date < '$opDate' and del_status = 'Live'")->row();
        if($supplier->opening_balance_type == "Credit"){
            $remaining_due = ($sum_of_purchase_due->purchase_due_amt - $sum_of_payment_receive->payment_receive_amt) + $supplier->opening_balance - $sum_of_purchase_return->purchase_return_amt;
        }else{
            $remaining_due = ($sum_of_purchase_due->purchase_due_amt - $sum_of_payment_receive->payment_receive_amt) - $supplier->opening_balance - $sum_of_purchase_return->purchase_return_amt;
        }
        return $remaining_due;
    }
}

/**
 * getCustomerOpeningBalance
 * @param int
 * @param string
 * @return int
 */
if (!function_exists('getCustomerOpeningBalance')) {
    function getCustomerOpeningBalance($customer_id, $opDate) {
        $CI = & get_instance();
        $customer = $CI->db->query("SELECT opening_balance_type, opening_balance from tbl_customers where id = $customer_id and del_status = 'Live'")->row();
        $sum_of_sale_due = $CI->db->query("SELECT SUM(due_amount) as sale_due_amt from tbl_sales where customer_id = $customer_id and sale_date < '$opDate' and del_status = 'Live'")->row();
        $sum_of_customer_due_receive = $CI->db->query("SELECT SUM(amount) as customer_due_receive_amt from tbl_customer_due_receives where customer_id = $customer_id and date < '$opDate' and del_status = 'Live'")->row();
        $sum_of_sale_return = $CI->db->query("SELECT SUM(due) as sale_return_amt from tbl_sale_return where customer_id = $customer_id and date < '$opDate' and del_status = 'Live'")->row();
        if($customer->opening_balance_type == "Credit"){
            $remaining_due = - $customer->opening_balance + ($sum_of_sale_due->sale_due_amt - $sum_of_customer_due_receive->customer_due_receive_amt) - $sum_of_sale_return->sale_return_amt;
        }else{
            $remaining_due = $customer->opening_balance + ($sum_of_sale_due->sale_due_amt - $sum_of_customer_due_receive->customer_due_receive_amt) - $sum_of_sale_return->sale_return_amt;
        }
        return $remaining_due;
    }
}

/**
 * getCashOpeningBalance
 * @param string
 * @return int
 */
if (!function_exists('getCashOpeningBalance')) {
    function getCashOpeningBalance($opDate) {
        $CI = & get_instance();
        $opening_balance = $CI->db->query("SELECT SUM(current_balance) as current_balance from tbl_payment_methods where id = 2 and del_status = 'Live' and added_date < '$opDate'")->row();
        $customer_due_receive = $CI->db->query("SELECT SUM(amount) as amount from tbl_customer_due_receives where payment_method_id = 2 and del_status = 'Live'")->row();
        $deposit = $CI->db->query("SELECT SUM(amount) as amount from tbl_deposits where type = 'Deposit' and payment_method_id = 2 and del_status = 'Live' and date < '$opDate'")->row();
        $withdraw = $CI->db->query("SELECT SUM(amount) as amount from tbl_deposits where type = 'Withdraw' and payment_method_id = 2 and del_status = 'Live' and date < '$opDate'")->row();
        $expense = $CI->db->query("SELECT SUM(amount) as amount from tbl_expenses where payment_method_id = 2 and del_status = 'Live' and date < '$opDate'")->row();
        $income = $CI->db->query("SELECT SUM(amount) as amount from tbl_incomes where payment_method_id = 2 and del_status = 'Live' and date < '$opDate'")->row();
        $down_payment = $CI->db->query("SELECT SUM(down_payment) as down_payment from tbl_installments where  payment_method_id = 2 and del_status = 'Live' and date < '$opDate'")->row();
        $installment_payment = $CI->db->query("SELECT SUM(paid_amount) as paid_amount from tbl_installment_items where paid_status = 'Paid' and payment_method_id = 2 and del_status = 'Live' and paid_date <'$opDate'")->row();
        $purchase_payment = $CI->db->query("SELECT SUM(amount) as amount from tbl_purchase_payments where payment_id = 2 and del_status = 'Live' and added_date < '$opDate'")->row();
        $purchase_return = $CI->db->query("SELECT SUM(total_return_amount) as total_return_amount from tbl_purchase_return where return_status = 'taken_by_sup_money_returned' and payment_method_id = '2' and del_status = 'Live' and date < '$opDate'")->row();
        $salary = $CI->db->query("SELECT SUM(total_amount) as total_amount from tbl_salaries where payment_id = 2 and del_status = 'Live' and date < '$opDate'")->row();
        $sale_payment = $CI->db->query("SELECT SUM(amount) as amount from tbl_sale_payments where  payment_id = 2 and del_status = 'Live' and date < '$opDate'")->row();
        $sale_return = $CI->db->query("SELECT SUM(total_return_amount) as total_return_amount from tbl_sale_return where  payment_method_id = 2 and del_status = 'Live' and date < '$opDate'")->row();
        $servicing_charge = $CI->db->query("SELECT SUM(servicing_charge) as servicing_charge from tbl_servicing where  payment_method_id = 2 and del_status = 'Live' and date < '$opDate'")->row();
        $opening_balance_sum = ($opening_balance->current_balance + $customer_due_receive->amount + $deposit->amount + $income->amount + $down_payment->down_payment + $installment_payment->paid_amount + $purchase_return->total_return_amount + $sale_payment->amount + $servicing_charge->servicing_charge) - ($withdraw->amount + $expense->amount + $purchase_payment->amount + $salary->total_amount + $sale_return->total_return_amount);
        return $opening_balance_sum;
    }
}


/**
 * companySupplierDue
 * @param int
 * @return int
 */
if (!function_exists('companySupplierDue')) {
    function companySupplierDue($supplier_id) {
        $CI = & get_instance();
        $supplier = $CI->db->query("SELECT opening_balance,opening_balance_type  FROM tbl_suppliers WHERE id=$supplier_id and del_status='Live'")->row();
        $supplier_due = $CI->db->query("SELECT SUM(due_amount) as due FROM tbl_purchase WHERE supplier_id=$supplier_id and del_status='Live'")->row();
        $supplier_payment = $CI->db->query("SELECT SUM(amount) as amount FROM tbl_supplier_payments WHERE supplier_id=$supplier_id and del_status='Live'")->row();
        $purchase_return = $CI->db->query("SELECT SUM(total_return_amount) as total_return_amount FROM tbl_purchase_return WHERE supplier_id=$supplier_id and return_status != 'draft'  and del_status='Live'")->row();
        if($supplier->opening_balance_type == "Credit"){
            $remaining_due = ($supplier_due->due-$supplier_payment->amount) + $supplier->opening_balance - $purchase_return->total_return_amount;
        }else{
            $remaining_due = ($supplier_due->due-$supplier_payment->amount) - $supplier->opening_balance - $purchase_return->total_return_amount;
        }
        return $remaining_due;
    }
}


/**
 * getCustomerDue
 * @param int
 * @return int
 */
if (!function_exists('getCustomerDue')) {
    function getCustomerDue($customer_id) {
        $CI = & get_instance();
        $company_id = $CI->session->userdata('company_id');
        $outlet_id = $CI->session->userdata('outlet_id');
        $customer = $CI->db->query("SELECT * FROM tbl_customers WHERE id=$customer_id and company_id=$company_id and del_status='Live'")->row();
        if ($customer->name == "Walk-in Customer") {
            return 0;
        }
        $total_sale_due = $CI->db->query("SELECT SUM(due_amount) as due_amount FROM tbl_sales WHERE customer_id=$customer_id and outlet_id=$outlet_id and del_status='Live'")->row();
        $total_due_received = $CI->db->query("SELECT SUM(amount) as amount FROM tbl_customer_due_receives WHERE customer_id=$customer_id and outlet_id=$outlet_id and del_status='Live'")->row();
        $total_sale_return = $CI->db->query("SELECT SUM(due) as total_return_amount FROM tbl_sale_return WHERE customer_id=$customer_id and outlet_id=$outlet_id and del_status='Live'")->row();
        if($customer->opening_balance_type == "Credit"){
            $opening_balance = - $customer->opening_balance - $total_due_received->amount + $total_sale_due->due_amount - $total_sale_return->total_return_amount;
        }else{
            $opening_balance = + $customer->opening_balance - $total_due_received->amount + $total_sale_due->due_amount - $total_sale_return->total_return_amount;
        }
        return $opening_balance;
    }
}


/**
 * companyCustomerDue
 * @param int
 * @return int
 */
if (!function_exists('companyCustomerDue')) {
    function companyCustomerDue($customer_id) {
        $CI = & get_instance();
        $customer = $CI->db->query("SELECT * FROM tbl_customers WHERE id=$customer_id and del_status='Live'")->row();
        if ($customer->name == "Walk-in Customer") {
            return 0;
        }
        $total_sale_due = $CI->db->query("SELECT SUM(due_amount) as due_amount FROM tbl_sales WHERE customer_id=$customer_id and del_status='Live'")->row();
        $total_due_received = $CI->db->query("SELECT SUM(amount) as amount FROM tbl_customer_due_receives WHERE customer_id=$customer_id and del_status='Live'")->row();
        $total_sale_return = $CI->db->query("SELECT SUM(total_return_amount) as total_return_amount FROM tbl_sale_return WHERE customer_id=$customer_id and del_status='Live'")->row();
        if($customer->opening_balance_type == "Credit"){
            $opening_balance = - $customer->opening_balance - $total_due_received->amount + $total_sale_due->due_amount - $total_sale_return->total_return_amount;
        }else{
            $opening_balance = + $customer->opening_balance - $total_due_received->amount + $total_sale_due->due_amount - $total_sale_return->total_return_amount;
        }
        return $opening_balance;
    }
}
/**
 * getAllCustomersWithOpeningBalance
 * @param no
 * @return object
 */
if (!function_exists('getAllCustomersWithOpeningBalance')) {
    function getAllCustomersWithOpeningBalance(){
        $CI = & get_instance();
        $company_id = $CI->session->userdata('company_id');
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
            (SELECT customer_id, COALESCE(SUM(total_return_amount), 0) AS total_return_amount_sum FROM tbl_sale_return WHERE del_status = 'Live' GROUP BY customer_id) AS return_sum ON c.id = return_sum.customer_id
        LEFT JOIN 
            tbl_users u ON u.id = c.user_id
        WHERE
            c.company_id = ? AND c.del_status = 'Live'
        GROUP BY 
            c.id DESC";
        $result = $CI->db->query($query, array($company_id))->result();
        return $result;  
    }
}


/**
 * get_company_vat
 * @param no
 * @return object
 */
if (!function_exists('get_company_vat')) {
    function get_company_vat() {
        $CI = & get_instance();
        $company_id = $CI->session->userdata('company_id');
        $CI->db->select("tax_string");
        $CI->db->from('tbl_companies');
        $CI->db->where("id", $company_id);
        $CI->db->where("del_status", "Live");
        $result = $CI->db->get()->row();
        return $result->tax_string;
    }
}


/**
 * setReadonly
 * @param string
 * @param string
 * @return string
 */
if (!function_exists('setReadonly')) {
    function setReadonly($type,$tax){
        $CI = & get_instance();
        $return_value = "";
        //iff type is 1 then system will return readonly;
        if($type==1){
            $tax_is_gst = $CI->session->userdata('tax_is_gst');
            if($tax_is_gst=="Yes"){
                if($tax=="CGST" || $tax=="SGST" || $tax=="IGST"){
                    $return_value = "readonly";
                }
            }else{
                if($tax=="CGST" || $tax=="SGST" || $tax=="IGST"){
                    $return_value = "readonly";
                }
            }
        }else if($type==2){
            $tax_is_gst = $CI->session->userdata('tax_is_gst');
            $return_value = "block";
            if($tax_is_gst=="Yes"){
                if($tax=="CGST" || $tax=="SGST" || $tax=="IGST"){
                    $return_value = "none";
                }
            }else{
                if($tax=="CGST" || $tax=="SGST" || $tax=="IGST"){
                    $return_value = "none";
                }
            }
        }else if($type==3){
            $tax_is_gst = $CI->session->userdata('tax_is_gst');
            if($tax_is_gst=="Yes"){
                if($tax=="CGST" || $tax=="SGST" || $tax=="IGST"){
                    $return_value = "gst_div";
                }
            }else{
                if($tax=="CGST" || $tax=="SGST" || $tax=="IGST"){
                    $return_value = "gst_div";
                }
            }
        }else if($type==4){
            $tax_is_gst = $CI->session->userdata('tax_is_gst');
            if($tax_is_gst=="Yes"){
                if($tax=="CGST" || $tax=="SGST" || $tax=="IGST"){
                    $return_value = "1";
                }
            }else{
                if($tax=="CGST" || $tax=="SGST" || $tax=="IGST"){
                    $return_value = "1";
                }
            }
        }else if($type==5){
            $tax_is_gst = $CI->session->userdata('tax_is_gst');
            if($tax_is_gst=="Yes"){
                $return_value = "1";
            }else{
                if($tax=="CGST" || $tax=="SGST" || $tax=="IGST"){

                }else{
                    $return_value = "1";
                }
            }
        }
        return $return_value;
    }
}

/**
 * getCustomer
 * @param int
 * @return object
 */
if (!function_exists('getCustomer')) {
    function getCustomer($customer_id) {
        $CI = & get_instance();
        $information = $CI->db->query("SELECT * FROM tbl_customers where `id`='$customer_id'")->row();
        if($information){
            return $information;
        }else{
            return "";
        }
    }
}

/**
 * expenseItemName
 * @param int
 * @return string
 */
if (!function_exists('expenseItemName')) {
    function expenseItemName($id) {
        $CI = & get_instance();
        $expense_item_information = $CI->db->query("SELECT * FROM tbl_expense_items where `id`='$id'")->row();
        if($expense_item_information){
            return escape_output($expense_item_information->name);
        }else{
            return "";
        }
    }
}
/**
 * incomeItemName
 * @param int
 * @return string
 */
if (!function_exists('incomeItemName')) {
    function incomeItemName($id) {
        $CI = & get_instance();
        $income_item_information = $CI->db->query("SELECT `name` FROM tbl_income_items where `id`='$id'")->row();
        if($income_item_information){
            return escape_output($income_item_information->name);
        }else{
            return "";
        }
    }
}

/**
 * employeeName
 * @param int
 * @return string
 */
if (!function_exists('employeeName')) {
    function employeeName($id) {
        $CI = & get_instance();
        $employee_information = $CI->db->query("SELECT `full_name` FROM tbl_users where `id`='$id'")->row();
        if (!empty($employee_information)) {
        return escape_output($employee_information->full_name);
        }else{
            return "N/A";
        }
    }
}


/**
 * categoryName
 * @param int
 * @return string
 */
if (!function_exists('categoryName')) {
    function categoryName($category_id) {
        $CI = & get_instance();
        $category_information = $CI->db->query("SELECT `name` FROM tbl_item_categories where `id`='$category_id'")->row();
        if($category_information){
            return escape_output($category_information->name);
        }else{
            return "";
        }
    }
}


/**
 * foodMenuName
 * @param int
 * @return string
 */
if (!function_exists('foodMenuName')) {
    function foodMenuName($id) {
        $CI = & get_instance();
        $food_information = $CI->db->query("SELECT `name` FROM tbl_items where `id`='$id'")->row();
        if($food_information){
            return escape_output($food_information->name);
        }else{
            return "";
        }
    }
}

/**
 * foodMenuNameCode
 * @param int
 * @return string
 */
if (!function_exists('foodMenuNameCode')) {
    function foodMenuNameCode($id) {
        $CI = & get_instance();
        $food_information = $CI->db->query("SELECT `code` FROM tbl_items where `id`='$id'")->row();
        if (!empty($food_information)) {
            return "(" . $food_information->code . ")";
        } else {
            return '';
        }
    }
}

/**
 * unitName
 * @param int
 * @return string
 */
if (!function_exists('unitName')) {
    function unitName($unit_id) {
        $CI = & get_instance();
        $unit_information = $CI->db->query("SELECT `unit_name` FROM tbl_units where `id`='$unit_id'")->row();
        if (!empty($unit_information)) {
            return escape_output($unit_information->unit_name);
        } else {
            return '';
        }
    }
}

/**
 * getPaymentName
 * @param int
 * @return string
 */
if (!function_exists('getPaymentName')) {
    function getPaymentName($id) {
        $CI = & get_instance();
        $getPaymentName = $CI->db->query("SELECT `name` FROM tbl_payment_methods where `id`='$id'")->row();
        if(!empty($getPaymentName)){
            return escape_output($getPaymentName->name);
        }else{
            return false;
        }
    }
}

/**
 * getCurrentStock
 * @param int
 * @return int
 */
if (!function_exists('getCurrentStock')) {
    function getCurrentStock($item_id) {
        $CI = & get_instance();
        $company_id = $CI->session->userdata('company_id');
        $outlet_id = $CI->session->userdata('outlet_id');
        $result = $CI->db->query("SELECT i.*,
                (select SUM(quantity_amount) from tbl_purchase_details where item_id=i.id AND outlet_id=$outlet_id AND del_status='Live') total_purchase,

                (select SUM(stock_quantity) from tbl_set_opening_stocks where item_id=i.id AND outlet_id=$outlet_id AND del_status='Live') stock_quantity, 

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

                FROM tbl_items i WHERE i.del_status='Live' AND i.id='$item_id' AND i.alert_quantity IS NOT NULL AND i.company_id= '$company_id' ORDER BY i.name ASC")->row();

                if($result){
                    $i_sale = $CI->session->userdata('i_sale');
                    $total_installment_sale = 0;
                    if(isset($i_sale) && $i_sale=="Yes"){
                        $total_installment_sale = $result->total_installment_sale;
                    }
                    $totalStock = ($result->total_purchase * $result->conversion_rate)  - $result->total_damage - $result->total_sale  - $total_installment_sale - $result->total_purchase_return + $result->total_sale_return  + $result->stock_quantity;
                    if($totalStock  && $totalStock > 0){
                        return $totalStock;
                    }else{
                        return 0;
                    }
                }else{
                    return 0;
                }

    }
}

/**
 * collectGST
 * @param no
 * @return string
 */
if (!function_exists('collectGST')) {
    function collectGST(){
        $CI = & get_instance();
        $company_id = $CI->session->userdata('company_id');
        if($company_id){
            $company_info = $CI->db->query("SELECT `tax_is_gst` FROM tbl_companies where `id`='$company_id'")->row();
            return escape_output($company_info->tax_is_gst);
        }else{
            return "No";
        }
    }
}

/**
 * getWhiteLabel
 * @param no
 * @return object
 */
if (!function_exists('getWhiteLabel')) {
    function getWhiteLabel() {
        $company_info = getMainCompany();
        $getWhiteLabel = json_decode(isset($company_info->white_label) && $company_info->white_label ? $company_info->white_label : '');
        return $getWhiteLabel;
    }
}
/**
 * getLoginInfo
 * @param no
 * @return object
 */
if (!function_exists('getLoginInfo')) {
    function getLoginInfo() {
        $company_info = getMainCompany();
        $getLoginInfo = json_decode(isset($company_info->login_page) && $company_info->login_page ? $company_info->login_page : '');
        return $getLoginInfo;
    }
}

/**
 * trim_checker
 * @param string
 * @return string
 */
if (!function_exists('trim_checker')) {
    function trim_checker($value) {
        return (isset($value) && $value? trim($value) : '');
    }
}

/**
 * getMainCompany
 * @param no
 * @return object
 */
if (!function_exists('getMainCompany')) {
    function getMainCompany() {
        $CI = & get_instance();
        $company_id = 1;
        $CI->db->select("*");
        $CI->db->from("tbl_companies");
        $CI->db->where("id", $company_id);
        return $CI->db->get()->row();
    }
}

/**
 * getSupperAdminName
 * @param no
 * @return string
 */
if (!function_exists('getSupperAdminName')) {
    function getSupperAdminName() {
        $CI = & get_instance();
        $user_id = 1;
        $CI->db->select("full_name");
        $CI->db->from("tbl_users");
        $CI->db->where("id", $user_id);
        return $CI->db->get()->row()->full_name;
    }
}

/**
 * getItemNameById
 * @param int
 * @return string
 */
if (!function_exists('getItemNameById')) {
    function getItemNameById($id) {
        $CI = & get_instance();
        $ig_information = $CI->db->query("SELECT `name` FROM tbl_items where `id`='$id'")->row();
        if (!empty($ig_information)) {
            return escape_output($ig_information->name);
        } else {
            return '';
        }
    }
}
/**
 * getItemExpiryStatus
 * @param int
 * @return string
 */
if (!function_exists('getItemExpiryStatus')) {
    function getItemExpiryStatus($id) {
        $CI = & get_instance();
        $ig_information = $CI->db->query("SELECT `expiry_date_maintain` FROM tbl_items where `id`='$id'")->row();
        if (!empty($ig_information)) {
            return escape_output($ig_information->expiry_date_maintain);
        } else {
            return '';
        }
    }
}

/**
 * getItemNameCodeById
 * @param int
 * @return string
 */
if (!function_exists('getItemNameCodeById')) {
    function getItemNameCodeById($id) {
        $CI = & get_instance();
        $ig_information = $CI->db->query("SELECT `name`,`code` FROM tbl_items where `id`='$id'")->row();
        if (!empty($ig_information)) {
            return escape_output($ig_information->name . ' (' . $ig_information->code . ')');
        } else {
            return '';
        }
    }
}

/**
 * getItemParentAndChildName
 * @param int
 * @return string
 */
if (!function_exists('getItemParentAndChildName')) {
    function getItemParentAndChildName($id) {
        $CI = & get_instance();
        $result = $CI->db->query("SELECT i.name as child_name, ii.name as parent_name
        FROM tbl_items i
        LEFT JOIN tbl_items ii ON i.parent_id = ii.id
        WHERE i.id = $id")->row();
        if (!empty($result)) {
            if($result->parent_name){
                return $result->parent_name . '-' . $result->child_name;
            }else{
                return $result->child_name;
            }
        } else {
            return '';
        }
    }
}

/**
 * getItemParentAndChildNameCode
 * @param int
 * @return string
 */
if (!function_exists('getItemParentAndChildNameCode')) {
    function getItemParentAndChildNameCode($id) {
        $CI = & get_instance();
        $result = $CI->db->query("SELECT i.name as child_name, i.code, ii.name as parent_name
        FROM tbl_items i
        LEFT JOIN tbl_items ii ON i.parent_id = ii.id
        WHERE i.id = $id")->row();
        if (!empty($result)) {
            if($result->parent_name){
                return $result->parent_name . '-' . $result->child_name . ' (' . $result->code . ')';
            }else{
                return $result->child_name . ' (' . $result->code . ')';
            }
        } else {
            return '';
        }
    }
}
/**
 * getItemParentId
 * @param int
 * @return string
 */
if (!function_exists('getItemParentId')) {
    function getItemParentId($id) {
        $CI = & get_instance();
        $resutl = $CI->db->query("SELECT parent_id FROM tbl_items 
        WHERE id = $id")->row();
        if (!empty($resutl)) {
            return $resutl->parent_id;
        } else {
            return false;
        }
    }
}

/**
 * getSaleUnitNameByItemId
 * @param int
 * @return string
 */
if (!function_exists('getSaleUnitNameByItemId')) {
    function getSaleUnitNameByItemId($id) {
        $CI = & get_instance();
        $CI->db->select("u.unit_name");
        $CI->db->from("tbl_items as i");
        $CI->db->join('tbl_units u', 'u.id = i.sale_unit_id', 'left');
        $CI->db->where('i.id', $id);
        $result = $CI->db->get()->row();
        if($result){
            $unit_name = $result->unit_name;
        }else{
            $unit_name = '';
        }
        return $unit_name;
    }
}
/**
 * getItemPriceById
 * @param int
 * @return int
 */
if (!function_exists('getItemPriceById')) {
    function getItemPriceById($id) {
        $CI = & get_instance();
        $ig_information = $CI->db->query("SELECT `sale_price` FROM tbl_items where `id`='$id'")->row();
        if (!empty($ig_information)) {
            return escape_output($ig_information->sale_price);
        } else {
            return '';
        }
    }
}

/**
 * getItemForBarcodeById
 * @param int
 * @return object
 */
if (!function_exists('getItemForBarcodeById')) {
    function getItemForBarcodeById($id) {
        $CI = & get_instance();
        $ig_information = $CI->db->query("SELECT `name`,`code`,`description`,`guarantee`,`conversion_rate`,`sale_price`,`warranty` FROM tbl_items where `id`='$id'")->row();
        return $ig_information;
    }
}

/**
 * getPaidAmountInstallment
 * @param int
 * @return int
 */
if (!function_exists('getPaidAmountInstallment')) {
    function getPaidAmountInstallment($id) {
        $CI = & get_instance();
        $ig_information = $CI->db->query("SELECT SUM(paid_amount) as total_amount FROM tbl_installment_items where `installment_id`='$id' AND paid_status='Paid' AND del_status='Live'")->row();
        if (!empty($ig_information)) {
            return isset($ig_information->total_amount) && $ig_information->total_amount?$ig_information->total_amount:'0.00';
        } else {
            return "0.00";
        }
    }
}

/**
 * getInstallmentRemainingDue
 * @param int
 * @return int
 */
if (!function_exists('getInstallmentRemainingDue')) {
    function getInstallmentRemainingDue($id) {
        $CI = & get_instance();
        $ig_information = $CI->db->query("SELECT SUM(amount_of_payment) as total_amount_of_payment, SUM(paid_amount) as total_paid_amount  FROM tbl_installment_items where `installment_id`='$id' AND del_status='Live'")->row();
        if (!empty($ig_information)) {
            return $ig_information->total_amount_of_payment - $ig_information->total_paid_amount;
        } else {
            return "0.00";
        }
    }
}



















































/**
 * getInstallmentTotalPaid
 * @param int
 * @return int
 */
if (!function_exists('getInstallmentTotalPaid')) {
    function getInstallmentTotalPaid($id) {
        $CI = & get_instance();
        $ig_information = $CI->db->query("SELECT SUM(paid_amount) as total_paid_amount  FROM tbl_installment_items where `installment_id`='$id' AND del_status='Live'")->row();
        if (!empty($ig_information)) {
            return $ig_information->total_paid_amount;
        } else {
            return "0.00";
        }
    }
}
/**
 * getPaidAmountInstallmentReport
 * @param int
 * @param int
 * @return int
 */
if (!function_exists('getPaidAmountInstallmentReport')) {
    function getPaidAmountInstallmentReport($id,$outlet_id="") {
        $CI = & get_instance();
        if(empty($outlet_id)){
            $outlet_id = $CI->session->userdata('outlet_id');
        }else{
            $outlet_id = $outlet_id;
        }
        $ig_information = $CI->db->query("SELECT SUM(paid_amount) as total_amount FROM tbl_installment_items where `installment_id`='$id'  AND paid_status='Paid' AND del_status='Live' AND `outlet_id`='$outlet_id'")->row();

        if (!empty($ig_information)) {
            return isset($ig_information->total_amount) && $ig_information->total_amount?$ig_information->total_amount:'0.00';
        } else {
            return "0.00";
        }
    }
}
/**
 * lastPaymentDate
 * @param int
 * @return string
 */
if (!function_exists('lastPaymentDate')) {
    function lastPaymentDate($id) {
        $CI = & get_instance();
        $ig_information = $CI->db->query("SELECT payment_date FROM tbl_installment_items where `installment_id`='$id' AND paid_status='Unpaid' AND del_status='Live'")->row();
        if (!empty($ig_information)) {
            return isset($ig_information->payment_date) && $ig_information->payment_date?date($CI->session->userdata('date_format'), strtotime($ig_information->payment_date)):'N/A';
        } else {
            return "N/A";
        }
    }
}
/**
 * getItemCodeById
 * @param int
 * @return int
 */
if (!function_exists('getItemCodeById')) {
    function getItemCodeById($id) {
        $CI = & get_instance();
        $ig_information = $CI->db->query("SELECT `code` FROM tbl_items where `id`='$id'")->row();
        if($ig_information){
            return escape_output($ig_information->code);
        }else{
            return "";
        }
    }
}
/**
 * getItemConversionRateById
 * @param int
 * @return int
 */
if (!function_exists('getItemConversionRateById')) {
    function getItemConversionRateById($id) {
        $CI = & get_instance();
        $ig_information = $CI->db->query("SELECT `conversion_rate` FROM tbl_items where `id`='$id'")->row();
        if($ig_information){
            return escape_output($ig_information->conversion_rate);
        }else{
            return "";
        }
    }
}
/**
 * getSupplierNameById
 * @param int
 * @return string
 */
if (!function_exists('getSupplierNameById')) {
    function getSupplierNameById($supplier_id) {
        $CI = & get_instance();
        $supplier_information = $CI->db->query("SELECT `name` FROM tbl_suppliers where `id`='$supplier_id'")->row();
        if($supplier_information){
            return escape_output($supplier_information->name);
        }else{
            return "";
        }
    }
}
/**
 * getOutletSetting
 * @param no
 * @return object
 */
if (!function_exists('getOutletSetting')) {
    function getOutletSetting() {
        $CI = & get_instance();
        $outlet_id = $CI->session->userdata('outlet_id');
        $CI->db->select("*");
        $CI->db->from("tbl_outlets");
        $CI->db->order_by("id", $outlet_id);
        $CI->db->limit(1);
        return $CI->db->get()->row();
    }
}
/**
 * getOutletAddressById
 * @param int
 * @return object
 */
if (!function_exists('getOutletAddressById')) {
    function getOutletAddressById($id) {
        $CI = & get_instance();
        $CI->db->select("*");
        $CI->db->from("tbl_outlets");
        $CI->db->where("id", $id);
        $CI->db->where("del_status", 'Live');
        $result =  $CI->db->get()->row();
        return $result->address;
    }
}
/**
 * getOutletInfoById
 * @param int
 * @return object
 */
if (!function_exists('getOutletInfoById')) {
    function getOutletInfoById($id) {
        $CI = & get_instance();
        $CI->db->select("*");
        $CI->db->from("tbl_outlets");
        $CI->db->where("id", $id);
        $CI->db->where("del_status", 'Live');
        $result =  $CI->db->get()->row();
        return $result;
    }
}
/**
 * getUnitIdByIgId
 * @param int
 * @return int
 */
if (!function_exists('getUnitIdByIgId')) {
    function getUnitIdByIgId($id) {
        $CI = & get_instance();
        $ig_information = $CI->db->query("SELECT `purchase_unit_id` FROM tbl_items where `id`='$id'")->row();
        if (!empty($ig_information)) {
            return escape_output($ig_information->purchase_unit_id);
        } else {
            return '';
        }
    }
}


/**
 * escape_output
 * @param string
 * @return string
 */
if (!function_exists('escape_output')) {
    function escape_output($string){
        if($string){
            $output = htmlentities($string, ENT_QUOTES, 'UTF-8');
            $output = str_replace("&amp;", "&",$output);
            return $output;
        }else{ 
            return '';
        }
    }
}


/**
 * getSaleUnitIdByIgId
 * @param int
 * @return int
 */
if (!function_exists('getSaleUnitIdByIgId')) {
    function getSaleUnitIdByIgId($id) {
        $CI = & get_instance();
        $ig_information = $CI->db->query("SELECT `sale_unit_id` FROM tbl_items where `id`='$id'")->row();
        if (!empty($ig_information)) {
            return escape_output($ig_information->sale_unit_id);
        } else {
            return '';
        }
    }
}
/**
 * getLastPurchaseAmount
 * @param int
 * @return int
 */
if (!function_exists('getLastPurchaseAmount')) {
    function getLastPurchaseAmount($id) {
        $CI = & get_instance();
        $product_information = $CI->db->query("SELECT `conversion_rate`, `type`, `purchase_price` FROM tbl_items where `id`='$id'")->row();
        $c_rate  = isset($product_information->conversion_rate) && $product_information->conversion_rate?$product_information->conversion_rate:1;
        if(isset($product_information->type) && $product_information->type=='General_Product'){
            $purchase_items = $CI->db->query("SELECT `unit_price` FROM tbl_purchase_details where `item_id`='$id' and del_status='Live' ORDER BY purchase_id DESC")->row();
            if (!empty($purchase_items)) {
                $returnPrice = @(($purchase_items->unit_price)/$c_rate);
            } else {
                if (!empty($product_information)) {
                    $returnPrice = @(($product_information->purchase_price) / $c_rate);
                }else{
                    $returnPrice = 0.0;
                }
            }
            return isset($returnPrice) && $returnPrice=="NAN"?0:$returnPrice;
        }else{
            return 0;
        }
    }
}
/**
 * getLastThreePurchaseAmount
 * @param int
 * @param int
 * @return int
 */
if (!function_exists('getLastThreePurchaseAmount')) {
    function getLastThreePurchaseAmount($id, $outlet_id='') {
        $CI = & get_instance();
        if($outlet_id){
            $c_outlet_id = $outlet_id;
        }else{
            $c_outlet_id = $CI->session->userdata('outlet_id');
        }
        $CI = & get_instance();
        $product_information = $CI->db->query("SELECT `conversion_rate`, `type`, `purchase_price` FROM tbl_items where `id`='$id'")->row();
        $c_rate  = isset($product_information->conversion_rate) && $product_information->conversion_rate ? $product_information->conversion_rate : 1;
        $returnPrice = 0;
        if(isset($product_information->type) && $product_information->type!= 'Variation_Product'){
            $purchase_items = $CI->db->query("SELECT `unit_price` FROM tbl_purchase_details where `item_id`='$id' and del_status='Live' AND outlet_id ='$c_outlet_id' ORDER BY purchase_id DESC limit 3")->result();
            $total_row = isset($purchase_items) && $purchase_items && !empty($purchase_items)?sizeof($purchase_items):0;
            if (!empty($purchase_items)) {
                $total_amount = 0;
                foreach($purchase_items as $value){
                    $total_amount+=$value->unit_price;
                }
                $returnPrice = (($total_amount/$total_row)/$c_rate);
            } else {
                if (!empty($product_information)) {
                    $returnPrice = (($product_information->purchase_price)/$c_rate);
                }else{
                    $returnPrice = 0;
                }
            }
            $returnPrice = isset($returnPrice) && $returnPrice=="NAN"?0:$returnPrice;
        }else{
            $returnPrice = 0;
        }
        return $returnPrice;
    }
}

/**
 * lastPurchasePriceAvg
 * @param int
 * @return int
 */
if (!function_exists('lastPurchasePriceAvg')) {
    function lastPurchasePriceAvg($id){
        $CI = & get_instance();
        $last_purchase_avg = $CI->db->query("SELECT avg(unit_price) FROM tbl_purchase_details where `item_id`='$id' and del_status='Live' ORDER BY id DESC LIMIT 3")->row();
        return $last_purchase_avg;
    }
}

/**
 * lastPurchasePrice
 * @param int
 * @return int
 */
if (!function_exists('lastPurchasePrice')) {
    function lastPurchasePrice($id){
        $CI = & get_instance();
        $last_purchase_avg = $CI->db->query("SELECT unit_price FROM tbl_purchase_details where `item_id`='$id' and del_status='Live' ORDER BY id DESC LIMIT 1")->row();
        return $last_purchase_avg->unit_price;
    }
}
/**
 * getPurchaseIngredients
 * @param int
 * @return string
 */
if (!function_exists('getPurchaseIngredients')) {
    function getPurchaseIngredients($id) {
        $CI = & get_instance();
        $purchase_items = $CI->db->query("SELECT pd.*, i.name item_name, u.unit_name FROM tbl_purchase_details pd, tbl_items i, tbl_units u where i.id = pd.item_id and u.id = i.purchase_unit_id and `purchase_id`='$id'")->result();
        if (!empty($purchase_items)) {
            $pur_ingr_all = "";
            $key = 1;
            $pur_ingr_all .= "<b>SN-Item-Qty-Unit Price-Total</b><br>";
            foreach ($purchase_items as $value) {
                $pur_ingr_all .= $key ."-". $value->item_name."-".$value->quantity_amount . "<small>" .$value->unit_name . "</small>" ."-". $value->unit_price ."-". $value->total."<br>";
                $key++;
            }
            return $pur_ingr_all;
        }else{
            return "Not found!";
        }
    }
}

/**
 * dateMonthYearFinder
 * @param int
 * @return int
 */
if (!function_exists('dateMonthYearFinder')) {
    function dateMonthYearFinder($wg, $wg_date, $sale_date){
        $currentDate = new DateTime(date('Y-m-d', strtotime($sale_date)));
        $adition_date = "+".$wg." " . $wg_date;
        $main_date = $currentDate->modify($adition_date)->format('Y-m-d');
        return $main_date;
    }
}

/**
 * getLastPurchasePrice
 * @param int
 * @return int
 */
if (!function_exists('getLastPurchasePrice')) {
    function getLastPurchasePrice($item_id) {
        $CI = & get_instance();
        $purchase_info = $CI->db->query("SELECT `unit_price`
        FROM tbl_purchase_details
        WHERE item_id = $item_id
        ORDER BY id DESC
        LIMIT 1")->row();
        if (!empty($purchase_info)) {
            return escape_output($purchase_info->unit_price);
        } else {
            $ig_information = $CI->db->query("SELECT `purchase_price` FROM tbl_items where `id`='$item_id'")->row();
            return escape_output($ig_information->purchase_price);
        }
    }
}

/**
 * itemCount
 * @param int
 * @return int
 */
if (!function_exists('itemCount')) {
    function itemCount($id) {
        $CI = & get_instance();
        $item_count = $CI->db->query("SELECT COUNT(*) AS item_count
        FROM tbl_damage_details
        WHERE damage_id = $id")->row();
        return escape_output($item_count->item_count);
    }
}

/**
 * companyInformation
 * @param int
 * @return object
 */
if (!function_exists('companyInformation')) {
    function companyInformation($company_id) {
        $CI = & get_instance();
        $company_info = $CI->db->query("SELECT * FROM tbl_companies where `id`='$company_id'")->row();
        return $company_info;
    }
}


/**
 * findDate
 * @param string
 * @return string
 */
if (!function_exists('findDate')) {
    function findDate($date) {
        $format = null;
        if ($date == '') {
            return '';
        } else {
            $format = 'd/m/Y';
        }
        return date($format, strtotime($date));
    }
}

/**
 * getCustomerDueReceive
 * @param int
 * @return int
 */
if (!function_exists('getCustomerDueReceive')) {
    function getCustomerDueReceive($customer_id){
        $CI = & get_instance();
        $information = $CI->db->query("SELECT sum(amount) as amount FROM tbl_customer_due_receives where `customer_id`='$customer_id' and del_status='Live'")->row();
        return escape_output($information->amount);
    }
}
/**
 * getSupplierDuePayment
 * @param int
 * @return int
 */
if (!function_exists('getSupplierDuePayment')) {
    function getSupplierDuePayment($supplier_id){
        $CI = & get_instance();
        $information = $CI->db->query("SELECT sum(amount) as amount FROM tbl_supplier_payments where `supplier_id`='$supplier_id' and del_status='Live'")->row();
        return $information->amount;
    }
}
/**
 * escapeQuot
 * @param int
 * @return int
 */
if (!function_exists('escapeQuot')) {
    function escapeQuot($str){
        return str_replace("'", "", $str ?? '');
    }
}

/**
 * getSMTPSetting
 * @param no
 * @return object
 */
if (!function_exists('getSMTPSetting')) {
    function getSMTPSetting() {
        $CI = & get_instance();
        $company_id = $CI->session->userdata('company_id');
        $CI->db->select("smtp_details");
        $CI->db->from("tbl_companies");
        $CI->db->where("id", $company_id);
        $CI->db->where("del_status", 'Live');
        $result =  $CI->db->get()->row();
        return json_decode($result->smtp_details);
    }
}

/**
 * getCustomSetting
 * @param no
 * @return object
 */
if (!function_exists('getCustomSetting')) {
    function getCustomSetting() {
        $CI = & get_instance();
        $CI->db->select("*");
        $CI->db->from("tbl_outlets");
        $CI->db->order_by("id", "DESC");
        $CI->db->limit(1);
        return $CI->db->get()->row();
    }
}
/**
 * getPhoneByUserId
 * @param int
 * @return int
 */
if (!function_exists('getPhoneByUserId')) {
    function getPhoneByUserId($id) {
        $CI = & get_instance();
        $information = $CI->db->query("SELECT `phone` FROM tbl_users where `id`='$id'")->row();
        if($information){
            return escape_output($information->phone);
        }else{
            return " ";
        }
    }
}
/**
 * getDomain
 * @param string
 * @return tring
 */
if (!function_exists('getDomain')) {
    function getDomain($url){
        $pieces = parse_url($url);
        $domain = isset($pieces['host']) ? $pieces['host'] : '';
        if(preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)){
            $tmp = explode('.',$regs['domain']);
            return ucfirstcustom($tmp[0]);
        }
        return FALSE;
    }
}

/**
 * sendOnnoSMS
 * @param string
 * @param string
 * @param string
 * @param string
 * @return string
 */
if (!function_exists('sendOnnoSMS')) {
    function sendOnnoSMS($username,$password,$txt,$phone){
        try{
            $soapClient = new SoapClient("https://api2.onnorokomSMS.com/sendSMS.asmx?wsdl");
            $paramArray = array(
                'userName' => $username,
                'userPassword' => $password,
                'messageText' => $txt,
                'numberList' => $phone,
                'smsType' => "TEXT",
                'maskName' => '',
                'campaignName' => '',
            );
            $soapClient->__call("OneToMany", array($paramArray));
        } catch (Exception $e) {
        }
    }
}

/**
 * sendInBlue
 * @param string
 * @return string
 */
if (!function_exists('sendInBlue')) {
    function sendInBlue($mail_data){
        if(testSendinBlueApi($mail_data['company_id']) == 200){
            $CI = &get_instance();
            $CI->load->library('sendinblueemail');
            try{
                $CI->sendinblueemail->sendEmail($mail_data);
            }catch(Exception $e){
                echo $e;
            }
        }
    }
}
/**
 * testSendinBlueApi
 * @param no
 * @return object
 */
if(! function_exists('testSendinBlueApi')) {
    function testSendinBlueApi($company_id = '') {
        $client = new Client();
        $smtp = json_decode(getCompanySMTP($company_id));
        try {
            $response = $client->get('https://api.sendinblue.com/v3/account', [
                'headers' => [
                    'api-key' => "$smtp->api_key",
                ],
            ]);
            return '200';
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $statusCode = $response->getStatusCode();
            if ($statusCode === 401) {
                return '401';
            } else {
                return 'Error: ' . $e->getMessage();
            }
        }
    }
}
/**
 * getCompanySMTP
 * @param no
 * @return object
 */
if (!function_exists('getCompanySMTP')) {
    function getCompanySMTP($company_id = ''){
        $CI = &get_instance();
        if($company_id){
            $company_id = $company_id;
        }else{
            $company_id = $CI->session->userdata('company_id');
        }
        $CI->db->select("smtp_details");
        $CI->db->from("tbl_companies");
        $CI->db->where("id", $company_id);
        $result = $CI->db->get()->row();
        return $result->smtp_details;
    }
}




/**
 * sendInBlueMain
 * @param string
 * @return string
 */
if (!function_exists('sendInBlueMain')) {
    function sendInBlueMain($mail_data){
        if(testSendinBlueApiMain() == 200){
            $CI = &get_instance();
            $CI->load->library('sendinblueemail');
            try{
                $CI->sendinblueemail->sendEmail($mail_data);
            }catch(Exception $e){
                echo $e;
            }
        }
    }
}

/**
 * testSendinBlueApi
 * @param no
 * @return object
 */
if(! function_exists('testSendinBlueApiMain')) {
    function testSendinBlueApiMain() {
        $client = new Client();
        $smtp = json_decode(getCompanySMTPMain());
        try {
            $response = $client->get('https://api.sendinblue.com/v3/account', [
                'headers' => [
                    'api-key' => "$smtp->api_key",
                ],
            ]);
            return '200';
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $statusCode = $response->getStatusCode();
            if ($statusCode === 401) {
                return '401';
            } else {
                return 'Error: ' . $e->getMessage();
            }
        }
    }
}

/**
 * getCompanySMTP
 * @param no
 * @return object
 */
if (!function_exists('getCompanySMTPMain')) {
    function getCompanySMTPMain(){
        $CI = &get_instance();
        $CI->db->select("smtp_details");
        $CI->db->from("tbl_companies");
        $CI->db->where("id", 1);
        $result = $CI->db->get()->row();
        return $result->smtp_details;
    }
}


/**
 * registerAccessCheck
 * @param int
 * @return int
 */
if (!function_exists('registerAccessCheck')) {
    function registerAccessCheck(){
        $CI = &get_instance();
        $user_id = $CI->session->userdata('user_id');
        $company_id = $CI->session->userdata('company_id');
        $register_status = $CI->db->query("SELECT `register_status` FROM tbl_register WHERE `user_id`='$user_id' ORDER BY `id` DESC LIMIT 1")->row();
        $register_content = $CI->db->query("SELECT `register_content` FROM tbl_companies where `id`='$company_id'")->row();
        $data = array();
        $data['register_status'] = $register_status->register_status;
        $data['register_content'] = $register_content->register_content;
        return $data;
    }
}

/**
 * getCompanySMTPAndStatus
 * @param int
 * @return object
 */
if (!function_exists('getCompanySMTPAndStatus')) {
    function getCompanySMTPAndStatus($company_id){
        $CI = &get_instance();
        $CI->db->select("smtp_type, smtp_details, smtp_enable_status");
        $CI->db->from("tbl_companies");
        $CI->db->where("id", $company_id);
        return $CI->db->get()->row();
    }
}


/**
 * getCompanySMSAndStatus
 * @param int
 * @return object
 */
if (!function_exists('getCompanySMSAndStatus')) {
    function getCompanySMSAndStatus($company_id){
        $CI = &get_instance();
        $CI->db->select("sms_service_provider, sms_enable_status");
        $CI->db->from("tbl_companies");
        $CI->db->where("id", $company_id);
        return $CI->db->get()->row();
    }
}
/**
 * sendEmailOnly
 * @param string
 * @param string
 * @param string
 * @param string
 * @param string
 * @param int
 * @return int
 */
if (!function_exists('sendEmailOnly')) {
    function sendEmailOnly($subject,$txt,$to_email,$attached='',$attached_file_name='', $company_id=''){
        $CI = &get_instance();
        $company = getMainCompany();
        $domain_name = ''.getDomain(base_url()).'';
        if($company_id){
            $company_id = $company_id;
        }else{
            $company_id = $CI->session->userdata('company_id');
        }
        //sender email getting from site setting
        if($company->smtp_enable_status == '1'){
            if($company->smtp_type== "Gmail"){
                $emailSetting = json_decode($company->smtp_details);  
                $CI = &get_instance();
                // Load PHPMailer library
                $CI->load->library('phpmailer_lib');
                // PHPMailer object
                $mail = $CI->phpmailer_lib->load();
                // SMTP configuration
                $mail->isSMTP(); 
                // $mail->SMTPDebug  = 1;
                $mail->Host     = $emailSetting->host_name;
                $mail->SMTPAuth = true;
                $mail->Username = $emailSetting->user_name;
                $mail->Password = $emailSetting->password;
                $mail->SMTPSecure = $emailSetting->encryption;
                $mail->Port = $emailSetting->port_address;
                $mail->setFrom($emailSetting->user_name, $emailSetting->from_name);
                $mail->addReplyTo($emailSetting->user_name, $emailSetting->from_email);
                // Add a recipient
                $mail->addAddress($to_email);
                // Add attachemnet
                if($attached){
                    $mail->AddAttachment($attached , $attached_file_name);
                }
                // Email subject
                $mail->Subject = $subject;
                // Set email format to HTML
                $mail->isHTML(true);
                // Email body content
                $mail->Body = $txt;
                // Send email
                if(!$mail->send()){
                    return false;
                }else{
                    return true;
                }
            }
        } else {
            $CI->session->set_flashdata('exception',lang('your_smtp_not_configured'));
        }
        
    }
}

/**
 * checkH
 * @param no
 * @return string
 */
if (!function_exists('checkH')) {
    function checkH() {
        $spi = null;
        if ( defined( 'INPUT_SERVER' ) && filter_has_var( INPUT_SERVER, 'REMOTE_ADDR' ) ) {
            $spi = filter_input( INPUT_SERVER, 'REMOTE_ADDR', FILTER_VALIDATE_IP );
        } elseif ( defined( 'INPUT_ENV' ) && filter_has_var( INPUT_ENV, 'REMOTE_ADDR' ) ) {
            $spi = filter_input( INPUT_ENV, 'REMOTE_ADDR', FILTER_VALIDATE_IP );
        } elseif ( isset( $_SERVER['REMOTE_ADDR'] ) ) {
            $spi = filter_var( $_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP );
        }
        if ( empty( $spi ) ) {
            $spi = '127.0.0.1';
        }
        $data = empty( filter_var( $spi, FILTER_VALIDATE_IP, FILTER_FLAG_NO_RES_RANGE | FILTER_FLAG_NO_PRIV_RANGE ));
        return $data;
    }
}
/**
 * checkHH
 * @param int
 * @return int
 */
if (!function_exists('checkHH')) {
    function checkHH() {
        $spi = null;
        if ( defined( 'INPUT_SERVER' ) && filter_has_var( INPUT_SERVER, 'REMOTE_ADDR' ) ) {
            $spi = filter_input( INPUT_SERVER, 'REMOTE_ADDR', FILTER_VALIDATE_IP );
        } elseif ( defined( 'INPUT_ENV' ) && filter_has_var( INPUT_ENV, 'REMOTE_ADDR' ) ) {
            $spi = filter_input( INPUT_ENV, 'REMOTE_ADDR', FILTER_VALIDATE_IP );
        } elseif ( isset( $_SERVER['REMOTE_ADDR'] ) ) {
            $spi = filter_var( $_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP );
        }
        if ( empty( $spi ) ) {
            $spi = '127.0.0.1';
        }
        $data = empty( filter_var( $spi, FILTER_VALIDATE_IP, FILTER_FLAG_NO_RES_RANGE | FILTER_FLAG_NO_PRIV_RANGE ));
        return $data!=1?$data:'';
    }
}
/**
 * banglaNumber
 * @param int
 * @return int
 */
if (!function_exists('banglaNumber')) {
    function banglaNumber($int) {
        $engNumber = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '0');
        $bangNumber = array('১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯', '০');
        $converted = str_replace($engNumber, $bangNumber, strval($int)); 
        return $converted;
    }
}
/**
 * salePaymentDetails
 * @param int
 * @param int
 * @return int
 */
if (!function_exists('salePaymentDetails')) {
    function salePaymentDetails($id,$outlet_id) {
        $CI = & get_instance();
        $CI->db->select('p.name as payment_name,sp.amount,sp.payment_details, sp.multi_currency,sp.multi_currency_rate,sp.payment_id');
        $CI->db->from('tbl_sale_payments sp');
        $CI->db->join('tbl_payment_methods p', 'p.id = sp.payment_id', 'left');
        $CI->db->where('sp.outlet_id', $outlet_id);
        $CI->db->where('sp.sale_id', $id);
        $CI->db->where('sp.del_status', 'Live');
        $query_result = $CI->db->get();
        $results = $query_result->result();
        return $results;
    }
}
/**
 * translate_am
 * @param string
 * @return string
 */
if (!function_exists('translate_am')) {
    function translate_am($str) {
        $en = array('am', 'pm');
        $bn = array('পূর্বাহ্ন', 'অপরাহ্ন');
        $str = str_replace($en, $bn, $str);
        return $str;
    }
}

/**
 * getUnicodeMonth2
 * @param int
 * @return int
 */
if (!function_exists('getUnicodeMonth2')) {
    function getUnicodeMonth2($monthNo) {
        $array = array(
            'জানুয়ারী' => '01',
            'ফেব্রুয়ারী' => '02',
            'মার্চ' => '03',
            'এপ্রিল' => '04',
            'মে' => '05',
            'জুন' => '06',
            'জুলাই' => '07',
            'আগস্ট' => '08',
            'সেপ্টেম্বর' => '09',
            'অক্টোবর' => '10',
            'নভেম্বর' => '11',
            'ডিসেম্বর' => '12'
        );
        return $key = array_search($monthNo, $array);
    }
}
/**
 * getCompanyInfo
 * @param no
 * @return object
 */
if (!function_exists('getCompanyInfo')) {
    function getCompanyInfo() {
        $CI = & get_instance();
        $company_id = $CI->session->userdata('company_id');
        $CI->db->select("*");
        $CI->db->from("tbl_companies");
        $CI->db->where("id", $company_id);
        return $CI->db->get()->row();
    }
}
/**
 * getCompanyInfoById
 * @param no
 * @return object
 */
if (!function_exists('getCompanyInfoById')) {
    function getCompanyInfoById($company_id) {
        $CI = & get_instance();
        $CI->db->select("*");
        $CI->db->from("tbl_companies");
        $CI->db->where("id", $company_id);
        return $CI->db->get()->row();
    }
}
/**
 * getCompanyPaymentMethod
 * @param no
 * @return object
 */
if (!function_exists('getCompanyPaymentMethod')) {
    function getCompanyPaymentMethod() {
        $CI = & get_instance();
        $company_id = $CI->session->userdata('company_id');
        $CI->db->select("payment_api_setting");
        $CI->db->from("tbl_companies");
        $CI->db->where("id", $company_id);
        $result = $CI->db->get()->row();
        if($result){
           return json_decode($result->payment_api_setting);
        }else{
            return false;
        }
    }
}
/**
 * getMainCompanyPaymentMethod
 * @param no
 * @return object
 */
if (!function_exists('getMainCompanyPaymentMethod')) {
    function getMainCompanyPaymentMethod() {
        $CI = & get_instance();
        $company_id = 1;
        $CI->db->select("payment_api_setting");
        $CI->db->from("tbl_companies");
        $CI->db->where("id", $company_id);
        $result = $CI->db->get()->row();
        if($result){
           return json_decode($result->payment_api_setting);
        }else{
            return false;
        }
    }
}
/**
 * getCompanyInfoByCompanyId
 * @param int
 * @return object
 */
if (!function_exists('getCompanyInfoByCompanyId')) {
    function getCompanyInfoByCompanyId($company_id) {
        $CI = & get_instance();
        $CI->db->select("*");
        $CI->db->from("tbl_companies");
        $CI->db->where("id", $company_id);
        return $CI->db->get()->row();
    }
}

/**
 * getItemTaxByItemId
 * @param int
 * @return object
 */
if (!function_exists('getItemTaxByItemId')) {
    function getItemTaxByItemId($item_id) {
        $CI = & get_instance();
        $CI->db->select("tax_information");
        $CI->db->from("tbl_items");
        $CI->db->where("id", $item_id);
        $result = $CI->db->get()->row();
        return $result->tax_information;
    }
}

/**
 * getCompanyInfoByAPIKey
 * @param string
 * @return string
 */
if (!function_exists('getCompanyInfoByAPIKey')) {
    function getCompanyInfoByAPIKey($api_key) {
        $CI = & get_instance();
        $CI->db->select("*");
        $CI->db->from("tbl_companies");
        $CI->db->where("api_token", $api_key);
        return $CI->db->get()->row();
    }
}
/**
 * getPlanText
 * @param string
 * @return string
 */
if (!function_exists('getPlanText')) {
    function getPlanText($text){
        if($text){
            $res = trim(str_replace( array( '\'', '"',',' , ';', '<', '>','(',')','{','}','[',']','$','%','#','/','@','&','?'), ' ', $text));
            $tmp_text = trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $res)));
            $final_txt = preg_replace("/[\n\r]/"," ",escape_output($tmp_text)); #remove new line from address
        return $final_txt;
        }else{
            return '';
        }
    }
}

/**
 * isLMni
 * @param no
 * @return boolean
 */
if (!function_exists('isLMni')) {
    function isLMni() {
        return true;
    }
}

/**
 * getAllOutlestByAssign
 * @param no
 * @return object
 */
if (!function_exists('getAllOutlestByAssign')) {
    function getAllOutlestByAssign() {
        $CI = & get_instance();
        $role = $CI->session->userdata('role');
        $company_id = $CI->session->userdata('company_id');
        $user_id = $CI->session->userdata('user_id');
        $outlets = $CI->session->userdata('session_outlets');
        if($company_id == 1 && $user_id == 1){
            $result = $CI->db->query("SELECT * FROM tbl_outlets WHERE del_status='Live'")->result();
        }else{
            if($role == "1"){
                $result = $CI->db->query("SELECT * FROM tbl_outlets WHERE FIND_IN_SET(`company_id`, '$company_id') AND del_status='Live'")->result();
            }else{
                $result = $CI->db->query("SELECT * FROM tbl_outlets WHERE FIND_IN_SET(`id`, '$outlets') AND del_status='Live'")->result();
            }
        }
        return $result;
    }
}
/**
 * getOutletsForReport
 * @param no
 * @return object
 */
if (!function_exists('getOutletsForReport')) {
    function getOutletsForReport() {
        $CI = & get_instance();
        $role = $CI->session->userdata('role');
        $user_id = $CI->session->userdata('user_id');
        $company_id = $CI->session->userdata('company_id');
        $outlets = $CI->session->userdata('session_outlets');
        if($company_id == 1 && $user_id == 1){
            $result = $CI->db->query("SELECT id,outlet_name FROM tbl_outlets WHERE FIND_IN_SET(`company_id`, '$company_id') AND del_status='Live'")->result();
        }else{
            if($role=="1"){
                $result = $CI->db->query("SELECT id,outlet_name FROM tbl_outlets WHERE FIND_IN_SET(`company_id`, '$company_id') AND del_status='Live'")->result();
            }else{
                $result = $CI->db->query("SELECT id,outlet_name FROM tbl_outlets WHERE FIND_IN_SET(`id`, '$outlets') AND del_status='Live'")->result();
            }
        }
        return $result;
    }
}


/**
 * getOutletName
 * @param int
 * @return string
 */
if (!function_exists('getOutletName')) {
    function getOutletName($outlet_id) {
        $CI = & get_instance();
        $information = $CI->db->query("SELECT outlet_name FROM tbl_outlets where `id`='$outlet_id'")->row();
        if($information){
            return $information->outlet_name;
        }else{
            return "";
        }
    }
}
/**
 * getServiceCenterById
 * @param int
 * @return string
 */
if (!function_exists('getServiceCenterById')) {
    function getServiceCenterById($id) {
        $CI = & get_instance();
        $information = $CI->db->query("SELECT name FROM tbl_service_centers where `id`='$id'")->row();
        if($information){
            return $information->name;
        }else{
            return "";
        }
    }
}

/**
 * getUserNameMobileForReport
 * @param int
 * @return string
 */
if (!function_exists('getUserNameMobileForReport')) {
    function getUserNameMobileForReport($user_id) {
        $CI = & get_instance();
        $information = $CI->db->query("SELECT full_name, phone FROM tbl_users where `id`='$user_id'")->row();
        if($information){
            return $information->full_name . '(' . $information->phone . ')';
        }else{
            return "";
        }
    }
}

/**
 * getUserName
 * @param int
 * @return string
 */
if (!function_exists('getUserName')) {
    function getUserName($user_id) {
        $CI = & get_instance();
        $information = $CI->db->query("SELECT full_name FROM tbl_users where `id`='$user_id'")->row();
        if($information){
            return $information->full_name;
        }else{
            return "";
        }
    }
}

/**
 * getSaleDate
 * @param string
 * @param string
 * @param string
 * @return string
 */
if (!function_exists('getSaleDate')) {
    function getSaleDate($startDate, $endDate,$type){
        $return_array = array();
        if($type=="day"){
            $start  = new DateTime($startDate);
            $end    = new DateTime($endDate);
            $invert = $start > $end;
            $dates = array();
            $dates[] = $start->format("Y-m-d")."||".$start->format("Y-m-d")."||".(date('D, d F ',strtotime($start->format("Y-m-d"))))."||".(date('d F ',strtotime($start->format("Y-m-d"))));
            while ($start != $end) {
                $start->modify(($invert ? '-' : '+') . '1 day');
                $dates[] = $start->format("Y-m-d")."||".$start->format("Y-m-d")."||".(date('D, d F ',strtotime($start->format("Y-m-d"))))."||".(date('d F ',strtotime($start->format("Y-m-d"))));
            }
            $return_array = $dates;
        }else if($type=="week"){
            $dates = array();
            $start_date = $startDate;
            $end_Date = $endDate;
            $date1 = new DateTime($start_date);
            $date2 = new DateTime($end_Date);
            $interval = $date1->diff($date2);
            $weeks = floor(($interval->days) / 7);
            for($i = 0; $i <= $weeks; $i++){
                $date1->add(new DateInterval('P6D'));
                if($i<$weeks){
                    $dates[] = $start_date."||".$date1->format('Y-m-d')."||".(date('D, d F ',strtotime($start_date)))." - ".(date('D, d F ',strtotime($date1->format('Y-m-d'))))."||".(date('d F ',strtotime($start_date)))." - ".(date('d F ',strtotime($date1->format('Y-m-d'))));
                }else{
                    $dates[] = $start_date."||".$end_Date."||".(date('D, d F ',strtotime($start_date)))." - ".(date('D, d F ',strtotime($end_Date)))."||".(date('d F ',strtotime($start_date)))." - ".(date('d F ',strtotime($end_Date)));
                }
                $date1->add(new DateInterval('P1D'));
                $start_date = $date1->format('Y-m-d');
            }
            $return_array = $dates;
        }else if($type=="month"){
            $dates = array();
            $start    = new DateTime($startDate);
            $start->modify('first day of this month');
            $end      = new DateTime($endDate);
            $end->modify('first day of next month');
            $interval = DateInterval::createFromDateString('1 month');
            $period   = new DatePeriod($start, $interval, $end);
            $total_period = iterator_count($period);
            $i=0;
            foreach ($period as $ky=>$dt) {
                if($i==0 && $total_period!=1){
                    $this_month_end = date("Y-m-t",strtotime($startDate));
                    $dates[]  = $startDate."||".$this_month_end."||".(date('D, d F ',strtotime($startDate)))." - ".(date('D, d F ',strtotime($this_month_end)))."||".(date('d F ',strtotime($startDate)))." - ".(date('d F ',strtotime($this_month_end)));
                }else{
                    if($total_period==1){
                        $dates[]  = $startDate."||".$endDate."||".(date('D, d F ',strtotime($dt->format("Y-m-d"))))." - ".(date('D, d F ',strtotime($endDate)))."||".(date('d F ',strtotime($dt->format("Y-m-d"))))." - ".(date('d F ',strtotime($endDate)));
                    }else{
                        if($i<($total_period-1)){
                            $this_month_end = date("Y-m-t",strtotime($dt->format("Y-m-d")));
                            $dates[]  = $dt->format("Y-m-d")."||".$this_month_end."||".(date('D, d F ',strtotime($dt->format("Y-m-d"))))." - ".(date('D, d F ',strtotime($this_month_end)))."||".(date('d F ',strtotime($dt->format("Y-m-d"))))." - ".(date('d F ',strtotime($this_month_end)));
                        }else{
                            $dates[]  = $dt->format("Y-m-d")."||".$endDate."||".(date('D, d F ',strtotime($dt->format("Y-m-d"))))." - ".(date('D, d F ',strtotime($endDate)))."||".(date('d F ',strtotime($dt->format("Y-m-d"))))." - ".(date('d F ',strtotime($endDate)));
                        }
                    }
                }
                $i++;
            }
            $return_array = $dates;
        }
        return $return_array;
    }
}
/**
 * getAllCategoryItemByCompanyId
 * @param no
 * @return object
 */
if (!function_exists('getAllCategoryItemByCompanyId')) {
    function getAllCategoryItemByCompanyId() {
        $CI = & get_instance();
        $company_id = $CI->session->userdata('company_id');
        $result = $CI->db->query("SELECT * FROM tbl_item_categories WHERE company_id = '$company_id' AND del_status='Live'")->result();
        return $result;
    }
}
/**
 * getAllItemByCompanyId
 * @param no
 * @return object
 */
if (!function_exists('getAllItemByCompanyId')) {
    function getAllItemByCompanyId() {
        $CI = & get_instance();
        $company_id = $CI->session->userdata('company_id');
        $result = $CI->db->query("SELECT * FROM tbl_items WHERE company_id = '$company_id' AND del_status='Live'")->result();
        return $result;
    }
}

/**
 * removeCountryCode
 * @param string
 * @return string
 */
if (!function_exists('removeCountryCode')) {
    function removeCountryCode($phone){
        $separate = explode("+88",$phone);
        if(isset($separate[1]) && $separate[1]){
            return $separate[1];
        }else{
            return $phone;
        }
    }
}
/**
 * sendWhatsAppMessge
 * @param string
 * @param string
 * @return int
 */
if (!function_exists('sendWhatsAppMessge')) {
    function sendWhatsAppMessge($phone, $body, $filePath){
        $CI = &get_instance();
        $company_id = $CI->session->userdata('company_id');
        $company = companyInformation($company_id);
        if($company->whatsapp_invoice_enable_status=="Enable"){
            $curl = curl_init();

            // Check if file exists
            if (!file_exists($filePath)) {
                return "Error: File not found.";
            }
            
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://whats-api.rcsoft.in/api/create-message',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'appkey' => $company->whatsapp_app_key,
                    'authkey' => $company->whatsapp_authkey,
                    'to' => $phone,
                    'message' => $body,
                    'sandbox' => 'false',
                    'file' => new CURLFile($filePath) 
                ),
            ));
            curl_exec($curl);
            curl_close($curl);
        }   
    }
}


function sendWhatsAppMessageWithAttachment($phone, $body, $filePath) {
    $CI = &get_instance();
    $company_id = $CI->session->userdata('company_id');
    $company = companyInformation($company_id);
    if ($company->whatsapp_invoice_enable_status == "Enable") {
        $curl = curl_init();

        // Check if file exists
        if (!file_exists($filePath)) {
            return "Error: File not found.";
        }

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://whats-api.rcsoft.in/api/create-message',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'appkey' => $company->whatsapp_app_key,
                'authkey' => $company->whatsapp_authkey,
                'to' => $phone,
                'message' => $body,
                'sandbox' => 'false',
                'file' => new CURLFile($filePath) // Add the file attachment here
            ),
        ));
        $response = curl_exec($curl);
        $error = curl_error($curl);
        curl_close($curl);
        if ($error) {
            return "cURL Error: " . $error;
        }
        return $response;
    }
    return "WhatsApp invoice sending is disabled.";
}

/**
 * smsSendOnly
 * @param string
 * @param string
 * @return int
 */
if (!function_exists('smsSendOnly')) {
    function smsSendOnly($msg,$to){
        $CI = &get_instance();
        $company_id = $CI->session->userdata('company_id');
        $company = companyInformation($company_id);
        if(isset($company) && $company){
            $company_info = isset($company->sms_details) && $company->sms_details?json_decode($company->sms_details):'';

            if($company->sms_service_provider==1){
                require './Twilio/autoload.php'; // Make sure to include the Twilio PHP SDK
                // Your Account SID and Auth Token from twilio.com/console
                $sid = (isset($company_info) && $company_info->field_1_0 ? $company_info->field_1_0 : '');
                $token = (isset($company_info) && $company_info->field_1_1 ? $company_info->field_1_1 : '');
                $twilio_number = (isset($company_info) && $company_info->field_1_2 ? $company_info->field_1_2 : '');
                try {
                    // Initialize the Twilio client
                    $client = new Twilio\Rest\Client($sid, $token);
                    // Use the client to send a text message
                    $client->messages->create(
                        // The number you'd like to send the message to
                        $to,
                        array(
                            // A Twilio phone number you purchased at twilio.com/console
                            'from' => $twilio_number,
                            // The body of the text message you'd like to send
                            'body' => $msg
                        )
                    );
                    // echo "Message sent successfully!";
                } catch (Twilio\Exceptions\RestException $e) {
                    // Handle the error
                    echo "Error: " . $e->getMessage();
                }
            }else if($company->sms_service_provider==2){
                $profile_id = (isset($company_info) && $company_info->field_2_0 ? $company_info->field_2_0:'');
                $password = (isset($company_info) && $company_info->field_2_1 ? $company_info->field_2_1:'');
                $sender_id = (isset($company_info) && $company_info->field_2_2 ? $company_info->field_2_2:'');
                $country_code = (isset($company_info) && $company_info->field_2_3 ? $company_info->field_2_3:'');
                $phone = removeCountryCode($to[0]);
                $url = "http://mshastra.com/sendurlcomma.aspx?user=".$profile_id."&pwd=".$password."&senderid=".urlencode($sender_id)."&CountryCode=".$country_code."&mobileno=".$phone."&msgtext=".urlencode($msg);
                try {
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_exec($ch);
                    curl_close($ch);
                } catch (Exception $e) {
                    echo "Error: " . $e->getMessage();
                }
            }else if($company->sms_service_provider==3){
                $api_key = (isset($company_info) && $company_info->field_3_1 ? $company_info->field_3_1 : '');
                $sender_id = (isset($company_info) && $company_info->field_3_2 ? $company_info->field_3_2 : '');
                $url = "https://esms.mimsms.com/smsapi";
                $data = [
                    "api_key" => $api_key,
                    "type" => "text",
                    "contacts" => "$to",
                    "senderid" => $sender_id,
                    "msg" => "$msg",
                ];
                try {
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    $response = curl_exec($ch);
                    curl_close($ch);
                    return $response;
                } catch (Exception $e) {
                    echo "Error: " . $e->getMessage();
                }
            }else if($company->sms_service_provider== 4){
                $profile_id = (isset($company_info) && $company_info->field_4_0 ? $company_info->field_4_0 : '');
                $api_key = (isset($company_info) && $company_info->field_4_1 ? $company_info->field_4_1 : '');
                $sender_id = (isset($company_info) && $company_info->field_4_2 ? $company_info->field_4_2 : '');
                $CI = &get_instance();
                // Account details
                $apiKey = urlencode($api_key);
                $numbers = array($to);
                $sender = urlencode($sender_id);
                $message = rawurlencode($msg);
                $numbers = implode(',', $numbers);
                // Prepare data for POST request
                $data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
                // Send the POST request with cURL
                try {
                    $ch = curl_init('https://api.textlocal.in/send/');
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($ch);
                    curl_close($ch);
                    // Process your response here
                    echo $response;
                } catch (Exception $e) {
                    echo "Error: " . $e->getMessage();
                }
            }
        }
    }
}

/**
 * smsinBD
 * @param string
 * @param string
 * @return string
 */
if (!function_exists('smsinBD')) {
    function smsinBD($msg,$to){
        $CI = &get_instance();
        $company_id = $CI->session->userdata('company_id');
        $company = companyInformation($company_id);
        $post_url = "http://api.smsinbd.com/sms-api/sendsms" ;  
        $post_values = array( 
            'api_token' => 'x6rOGWgObd9dYIy2y1vlpcreZbIFibxR9VELNscX',
            'senderid' => '8801969908462',
            'message' => $msg,
            'contact_number' => $to,
        );
        $post_string = "";
        foreach( $post_values as $key => $value ){ 
            $post_string .= "$key=" . urlencode( $value ) . "&"; 
        }
        $post_string = rtrim( $post_string, "& ");
        $request = curl_init($post_url);
        curl_setopt($request, CURLOPT_HEADER, 0);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);  
        curl_setopt($request, CURLOPT_POSTFIELDS, $post_string); 
        curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE);  
        $post_response = curl_exec($request);  
        curl_close ($request);  
        $array =  json_decode( preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $post_response), true );   
        if($array){
            //status of the request
            echo $array['status'] ;
            //status message of the request
            echo $array['message'] ;
        }
        /*
        *   You can request for single sms to multiple numbers through this api also.
        *   In this case you have to seperate numbers with comma(,) or space like-
        *   017XXXXXXXX,018XXXXXXXX,019XXXXXXXX
        *   or
        *   017XXXXXXXX 018XXXXXXXX 019XXXXXXXX
        *   As:
        *   'contact_number' => '017XXXXXXXX,018XXXXXXXX,019XXXXXXXX'
        *   or
        *   'contact_number' => '017XXXXXXXX 018XXXXXXXX 019XXXXXXXX'
        *   For multiple numbers request you will receive two additional data in return if your request is successful.
        *   Then the response will be as:
        */
        // if($array){
        // 	//status of the request
        // 	echo $array['status'] ;
        // 	//status message of the request
        // 	echo $array['message'] ;
        // 	//number of successfully sent contacts
        // 	echo $array['success'] ;
        // 	//number of successfully sent contacts
        // 	echo $array['failed'] ;
        // }
    }
}


/**
 * getIngredientCodeById
 * @param int
 * @return int
 */
if (!function_exists('getIngredientCodeById')) {
    function getIngredientCodeById($id) {
        $CI = & get_instance();
        $ig_information = $CI->db->query("SELECT `code` FROM tbl_items where `id`='$id'")->row();
        return $ig_information->code;
    }
}

/**
 * getPurchaseUnitIdByIgId
 * @param int
 * @return int
 */
if (!function_exists('getPurchaseUnitIdByIgId')) {
    function getPurchaseUnitIdByIgId($id) {
        $CI = & get_instance();
        $ig_information = $CI->db->query("SELECT `purchase_unit_id` FROM tbl_items where `id`='$id'")->row();
        if (!empty($ig_information)) {
            return $ig_information->purchase_unit_id;
        } else {
            return '';
        }
    }
}

/**
 * getSMSSignupUrl
 * @param string
 * @return string
 */
if (!function_exists('getSMSSignupUrl')) {
    function getSMSSignupUrl($operator) {
        if($operator==1){
            //return the url for signup to user sms gateway
            return escape_output("https://www.twilio.com/messaging/sms");
        }else if($operator==2){
            //return the url for signup to user sms gateway
            return escape_output("http://mobishastra.com/");
        }else if($operator==3){
            //return the url for signup to user sms gateway
            return escape_output("https://esms.mimsms.com");
        }else if($operator==4){
            //return the url for signup to user sms gateway
            return escape_output("https://textlocal.com/");
        }
    }
}

/**
 * getFoodMenuNameById
 * @param int
 * @return string
 */
if (!function_exists('getFoodMenuNameById')) {
    function getFoodMenuNameById($id) {
        $CI = & get_instance();
        $ig_information = $CI->db->query("SELECT `name` FROM tbl_items where `id`='$id'")->row();
        if (!empty($ig_information)) {
            return $ig_information->name;
        } else {
            return '';
        }
    }
}

/**
 * updateAppInfo
 * @param no
 * @return boolean
 */
if (!function_exists('updateAppInfo')) {
    function updateAppInfo(){
        $organization = getMainCompany();
        $white_lavel = getWhiteLabel();
        $content = (file_get_contents('frequent_changing/progressive_app/manifest_config.json'));
        $content = str_replace('app_base_url-', base_url(), $content);
        $content = str_replace('app_full_name', $white_lavel->site_name, $content);
        $content = str_replace('app_company_name', $organization->business_name, $content);
        $path = "frequent_changing/progressive_app/manifest.json";
        $handle = fopen($path, "w");
        if ($handle) {
            // Write the file
            if (fwrite($handle, $content)) {
                return true;
            } else {
                return false;
            }

        } else {
            return false;
        }
    }
}



/**
 * addFiscalInvoiceData
 * @param string
 * @return boolean
 */
if (!function_exists('addFiscalInvoiceData')) {
    function addFiscalInvoiceData($content){
        $path = "uploads/fiscal-invoice/FiscalInvoice.prn";
        $handle = fopen($path, "w");
        if ($handle) {
            // Write the file
            if (fwrite($handle, $content)) {
                return true;
            } else {
                return false;
            }

        } else {
            return false;
        }
    }
}

/**
 * getParentNameTemp
 * @param int
 * @return string
 */
if (!function_exists('getParentNameTemp')) {
    function getParentNameTemp($id) {
        $CI = & get_instance();
        $food_information = $CI->db->query("SELECT `name` FROM tbl_items where `id`='$id'")->row();
        return (isset($food_information->name) && $food_information->name ? getPlanText($food_information->name)." ":'');
    }
}

/**
 * getFoodMenuCodeById
 * @param int
 * @return string
 */
if (!function_exists('getFoodMenuCodeById')) {
    function getFoodMenuCodeById($id) {
        $CI = & get_instance();
        $ig_information = $CI->db->query("SELECT code FROM tbl_items where `id`='$id'")->row();
        return $ig_information->code;
    }
}

/**
 * getCategoryName
 * @param int
 * @return string
 */
if (!function_exists('getCategoryName')) {
    function getCategoryName($cat_id) {
        $CI = & get_instance();
        $information = $CI->db->query("SELECT `name` FROM tbl_item_categories where `id`='$cat_id'")->row();
        if($information){
            return escape_output($information->name);
        }else{
            return "";
        }
    }
}


/**
 * getExpenseCategoryName
 * @param int
 * @return string
 */
if (!function_exists('getExpenseCategoryName')) {
    function getExpenseCategoryName($id) {
        $CI = & get_instance();
        $information = $CI->db->query("SELECT `name` FROM tbl_expense_items where `id`='$id'")->row();
        if($information){
            return escape_output($information->name);
        }else{
            return "";
        }
    }
}
/**
 * getIncomeCategoryName
 * @param int
 * @return string
 */
if (!function_exists('getIncomeCategoryName')) {
    function getIncomeCategoryName($id) {
        $CI = & get_instance();
        $information = $CI->db->query("SELECT `name` FROM tbl_income_items where `id`='$id'")->row();
        if($information){
            return escape_output($information->name);
        }else{
            return "";
        }
    }
}
/**
 * getVariationName
 * @param int
 * @return string
 */
if (!function_exists('getVariationName')) {
    function getVariationName($id) {
        $CI = & get_instance();
        $unit_information = $CI->db->query("SELECT `variation_name` FROM tbl_variations where `id`='$id'")->row();
        if (!empty($unit_information)) {
            return escape_output($unit_information->variation_name);
        } else {
            return '';
        }
    }
}
/**
 * getRoleNameById
 * @param int
 * @return string
 */
if (!function_exists('getRoleNameById')) {
    function getRoleNameById($id) {
        $CI = & get_instance();
        $role_info = $CI->db->query("SELECT role_name FROM tbl_roles where `id`='$id'")->row();
        if (!empty($role_info)) {
            return escape_output($role_info->role_name);
        } else {
            return '';
        }
    }
}
/**
 * getDiscountSymbol
 * @param string
 * @return string
 */
if (!function_exists('getDiscountSymbol')) {
    function getDiscountSymbol($discount){
        $CI = & get_instance();
        $separator = explode("%",$discount);
        return isset($separator[1]) ? '' : '';
    }
}
/**
 * getTaxAmount
 * @param int
 * @param int
 * @return int
 */
if (!function_exists('getTaxAmount')) {
    function getTaxAmount($sale_price,$tax){
        $CI = & get_instance();
        $decode_tax = json_decode($tax ?? '');
        $total_return_amount = 0;
        foreach ((array)$decode_tax as $key=>$value){
            if(isset($decode_tax[$key]->tax_field_percentage) && $decode_tax[$key]->tax_field_percentage && $decode_tax[$key]->tax_field_percentage!="0.00"){
                (int)$total_return_amount+=((int)$sale_price*(int)$decode_tax[$key]->tax_field_percentage) / 100;
            }
        }
        return $total_return_amount;
    }
}
/**
 * checkAvailableLang
 * @param string
 * @return string
 */
if (!function_exists('checkAvailableLang')) {
    function checkAvailableLang($lang){
        $dir = glob("application/language/*",GLOB_ONLYDIR);
        $return = false;
        foreach ($dir as $value):
            $separete = explode("language/",$value);
            if($separete[1]==$lang){
                $return = true;
            }
        endforeach;
        return $return;
    }
}

/**
 * isArabic
 * @param string
 * @return string
 */
if (!function_exists('isArabic')) {
    function isArabic(){
        $CI = & get_instance();
        $language = $CI->session->userdata('language');
        if($language == 'arabic' || $language == 'urdu'){
            return 'Yes';
        }else{
            return 'No';
        }
    }
}

/**
 * removeQrCode
 * @param string
 * @return int
 */
if (!function_exists('removeQrCode')) {
    function removeQrCode() {
        $files = glob('qr_code/*'); // get all file names
        foreach($files as $file){ // iterate files
            if(is_file($file)) {
                unlink($file); // delete file
            }
        }
        return true;
    }
}
/**
 * getRandomCode
 * @param int
 * @return string
 */
if (!function_exists('getRandomCode')) {
    function getRandomCode($length = 11) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

/**
 * getFreeItemBySaleDetailsId
 * @param int
 * @return object
 */
if (!function_exists('getFreeItemBySaleDetailsId')) {
    function getFreeItemBySaleDetailsId($id){
        $CI = & get_instance();
        $CI->db->select('*');
        $CI->db->from('tbl_sales_details');
        $CI->db->where('promo_parent_id', $id);
        $CI->db->where('del_status', "Live");
        $result = $CI->db->get()->result();
        if(isset($result) && $result){
            return $result;
        }else{
            return false;
        }
    }
}
/**
 * getAttendance
 * @param int
 * @return object
 */
if (!function_exists('getAttendance')) {
    function getAttendance($user_id) {
        $CI = & get_instance();
        $CI->db->select('*');
        $CI->db->from('tbl_attendance');
        $CI->db->where('is_closed', 1);
        $CI->db->where('employee_id', $user_id);
        $CI->db->where('del_status', "Live");
        $CI->db->order_by('id', "DESC");
        $last_row =   $CI->db->get()->row();
        if(isset($last_row) && $last_row){
            return $last_row;
        }else{
            return false;
        }
    }
}

/**
 * getAttendance1
 * @param int
 * @return object
 */
if (!function_exists('getAttendance1')) {
    function getAttendance1($user_id) {
        $CI = & get_instance();
        $CI->db->select('*');
        $CI->db->from('tbl_attendance');
        $CI->db->where('is_closed', 2);
        $CI->db->where('employee_id', $user_id);
        $CI->db->where('del_status', "Live");
        $CI->db->order_by('id', "DESC");
        $last_row =   $CI->db->get()->row();
        if(isset($last_row) && $last_row){
            return $last_row;
        }else{
            return false;
        }
    }
}
/**
 * get_numb_with_zero
 * @param int
 * @return int
 */
if (!function_exists('get_numb_with_zero')) {
    function get_numb_with_zero($number){
        $numb = str_pad($number, 2, '0', STR_PAD_LEFT);
        return $numb;
    }
}
/**
 * getTotalHour
 * @param int
 * @return int
 */
if (!function_exists('getTotalHour')) {
    function getTotalHour($out_time,$in_time){
        $time1 = $out_time;
        $time2 = $in_time;
        $array1 = explode(':', $time1);
        $array2 = explode(':', $time2);
        $minutes1 = ($array1[0] * 60.0 + $array1[1]);
        $minutes2 = ($array2[0] * 60.0 + $array2[1]);
        $total_min = $minutes1 - $minutes2;
        $total_tmp_hour = (int)($total_min/60);
        $total_tmp_hour_minus = ($total_min%60);
        return $total_tmp_hour.".".get_numb_with_zero($total_tmp_hour_minus);
    }
}

/**
 * getPurchaseReturnQtyById
 * @param int
 * @return int
 */
if (!function_exists('getPurchaseReturnQtyById')) {
    function getPurchaseReturnQtyById($id) {
        $CI = & get_instance();
        $CI->db->select_sum("return_quantity_amount");
        $CI->db->from('tbl_purchase_return_details');
        $CI->db->where("pur_return_id", $id);
        $CI->db->where("del_status", 'Live');
        $result = $CI->db->get()->row();
        return $result->return_quantity_amount;
    }
}
/**
 * getPurchaseReturnUnitPriceById
 * @param int
 * @return int
 */
if (!function_exists('getPurchaseReturnUnitPriceById')) {
    function getPurchaseReturnUnitPriceById($id) {
        $CI = & get_instance();
        $CI->db->select_sum("unit_price");
        $CI->db->from('tbl_purchase_return_details');
        $CI->db->where("pur_return_id", $id);
        $CI->db->where("del_status", 'Live');
        $result = $CI->db->get()->row();
        return $result->unit_price;
    }
}

/**
 * getBusinessName
 * @param int
 * @return string
 */
if (!function_exists('getBusinessName')) {
    function getBusinessName($id) {
        $CI = & get_instance();
        $CI->db->select("business_name");
        $CI->db->from('tbl_companies');
        $CI->db->where("id", $id);
        $CI->db->where("del_status", 'Live');
        $result = $CI->db->get()->row();
        return $result->business_name;
    }
}

/**
 * getSessionBusinessName
 * @param int
 * @return string
 */
if (!function_exists('getSessionBusinessName')) {
    function getSessionBusinessName() {
        $CI = & get_instance();
        $company_id = $CI->session->userdata('company_id');
        $CI->db->select("business_name");
        $CI->db->from('tbl_companies');
        $CI->db->where("id", $company_id);
        $CI->db->where("del_status", 'Live');
        $result = $CI->db->get()->row();
        return escape_output($result->business_name);
    }
}

/**
 * getAmtPCustom
 * @param int
 * @return int
 */
if (!function_exists('getAmtPCustom')) {
    function getAmtPCustom($amount) {
        if(!is_numeric($amount)){
            $amount = 0;
        }
        $getCompanyInfo = getCompanyInfo();
        $precision = $getCompanyInfo->precision;
        if($precision == ''){
            $precision = 0;
        }else{
            $precision = $getCompanyInfo->precision;
        }
        $decimals_separator = isset($getCompanyInfo->decimals_separator) && $getCompanyInfo->decimals_separator?$getCompanyInfo->decimals_separator:'.';
        $thousands_separator = isset($getCompanyInfo->thousands_separator) && $getCompanyInfo->thousands_separator?$getCompanyInfo->thousands_separator:'';
        $str_amount = (number_format(isset($amount) && $amount?$amount:0,$precision,$decimals_separator,$thousands_separator));
        return $str_amount;
    }
}

/**
 * getAllPaymentMethods
 * @param int
 * @return object
 */
if (!function_exists('getAllPaymentMethods')) {
    function getAllPaymentMethods($is_ignore_loyalty='') {
        $CI = & get_instance();
        $company_id = $CI->session->userdata('company_id');
        $CI->db->select('*');
        $CI->db->from('tbl_payment_methods');
        $CI->db->where("company_id", $company_id);
        if($is_ignore_loyalty!=''){
            $CI->db->where("account_type !=", 'Loyalty Point');
        }
        $CI->db->where("del_status", 'Live');
        $CI->db->order_by("id", 'ASC');
        $result = $CI->db->get();
        if($result != false){
            return $result->result();
        }else{
            return false;
        }
    }
}

/**
 * getAllPaymentMethodById
 * @param int
 * @return string
 */
if (!function_exists('getAllPaymentMethodById')) {
    function getAllPaymentMethodById($id = '') {
        $CI = & get_instance();
        $company_id = $CI->session->userdata('company_id');
        $CI->db->select('name');
        $CI->db->from('tbl_payment_methods');
        $CI->db->where("id", $id);
        $CI->db->where("company_id", $company_id);
        $CI->db->where("del_status", 'Live');
        $result = $CI->db->get()->row();
        if($result != false){
            return $result->name;
        }else{
            return 'N/A';
        }
    }
}

/**
 * getDownPaymentByDate
 * @param string
 * @param string
 * @param int
 * @param int
 * @return int
 */
if (!function_exists('getDownPaymentByDate')) {
    function getDownPaymentByDate($start_date,$end_date,$user_id,$outlet_id){
        $start_date = date('Y-m-d', strtotime($start_date));
        if($end_date != ''){
            $end_date = date('Y-m-d', strtotime($end_date));
        }else{
            $end_date = date('Y-m-d');
        }
        $CI = & get_instance();
        $CI->db->select_sum('down_payment');
        $CI->db->from('tbl_installments');
        $CI->db->where("date >=", $start_date);
        $CI->db->where("date <=", $end_date);
        $CI->db->where("user_id", $user_id);
        $CI->db->where("outlet_id", $outlet_id);
        $CI->db->where("del_status", "Live");
        $query_result = $CI->db->get()->row();
        return $query_result->down_payment;
    }
}

/**
 * customerNamePhoneById
 * @param int
 * @return string
 */
if (!function_exists('customerNamePhoneById')) {
    function customerNamePhoneById($id){
        $CI = & get_instance();
        $CI->db->select('name, phone');
        $CI->db->from('tbl_customers');
        $CI->db->where("id", $id);
        $CI->db->where("del_status", "Live");
        $query_result = $CI->db->get();
        $data = $query_result->row();
        return $data->name . '(' . $data->phone . ')';
    }
}

/**
 * getCollectionInstallmentByDate
 * @param string
 * @param string
 * @param int
 * @param int
 * @return int
 */
if (!function_exists('getCollectionInstallmentByDate')) {
    function getCollectionInstallmentByDate($start_date,$end_date,$user_id,$outlet_id){
        $CI = & get_instance();
        $company_id = $CI->session->userdata('company_id');
        $CI->db->select_sum('paid_amount');
        $CI->db->from('tbl_installment_items');
        if ($start_date != '' && $end_date != '') {
            $CI->db->where('added_date>=', $start_date);
            $CI->db->where('added_date <=', $end_date);
        }
        if ($start_date != '' && $end_date == '') {
            $CI->db->where('added_date', $start_date);
        }
        if ($start_date == '' && $end_date != '') {
            $CI->db->where('added_date', $end_date);
        }
        $CI->db->where("user_id", $user_id);
        $CI->db->where("outlet_id", $outlet_id);
        $CI->db->where("company_id", $company_id);
        $CI->db->where("del_status", "Live");
        $query_result = $CI->db->get();
        $data = $query_result->row();
        return $data->paid_amount;
    }
}
/**
 * getPayments
 * @param string
 * @param string
 * @param int
 * @param int
 * @return int
 */
if (!function_exists('getPayments')) {
    function getPayments($start_date,$end_date,$user_id,$outlet_id){
        $CI = & get_instance();
        $company_id = $CI->session->userdata('company_id');
        $CI->db->select('SUM(s.paid_amount) as paid_amount, p.name');
        $CI->db->from('tbl_sales s');
        $CI->db->join('tbl_sale_payments sp', 'sp.sale_id = s.id', 'left');
        $CI->db->join('tbl_payment_methods p', 'p.id = sp.payment_id', 'left');
        if ($start_date != '' && $end_date != '') {
            $CI->db->where('s.added_date>=', $start_date);
            $CI->db->where('s.added_date <=', $end_date);
        }
        if ($start_date != '' && $end_date == '') {
            $CI->db->where('s.added_date', $start_date);
        }
        if ($start_date == '' && $end_date != '') {
            $CI->db->where('s.added_date', $end_date);
        }
        $CI->db->where("s.user_id", $user_id);
        $CI->db->where("s.outlet_id", $outlet_id);
        $CI->db->where("s.company_id", $company_id);
        $CI->db->where("s.del_status", "Live");
        $CI->db->group_by('p.id');
        $query_result = $CI->db->get();
        $data = $query_result->result();
        $payments = '';
        foreach ($data as $val) {
            if($val->name != ''){
                $payments.= $val->name.':'.getAmtP($val->paid_amount) . ', ';
            }
        }
        return $payments;
    }
}

/**
 * getWhiteLabelStatus
 * @param no
 * @return string
 */
if (!function_exists('getWhiteLabelStatus')) {
    function getWhiteLabelStatus(){
        $CI = & get_instance();
        $company_id = $CI->session->userdata('company_id');
        $CI->db->select("white_label_status");
        $CI->db->from("tbl_companies");
        $CI->db->where("id",$company_id);
        $result = $CI->db->get()->row();
        return $result->white_label_status;
    }
}

/**
 * checkExistingSalary
 * @param string
 * @param string
 * @return boolean
 */
if (!function_exists('checkExistingSalary')) {
    function checkExistingSalary($month,$year){
        $CI = & get_instance();
        $info = $CI->db->query("SELECT * FROM tbl_salaries where `month`='$month' AND `year`='$year' AND `del_status`='Live'")->row();
        if($info){
            return true;
        }else{
            return false;
        }
    }
}
/**
 * checkSingleItemType
 * @param string
 * @return string
 */
if (!function_exists('checkSingleItemType')) {
    function checkSingleItemType($param){
        if ($param == 'General_Product'){
            return 'General Product';
        }elseif($param == 'Medicine_Product'){
            return 'Medicine Product';
        }elseif($param == 'IMEI_Product'){
            return 'IMEI Product';
        }elseif($param == 'Serial_Product'){
            return 'Serial Product';
        }elseif($param == 'Variation_Product'){
            return 'Variation Product';
        }elseif($param == 'Installment_Product'){
            return 'Installment Product';
        }elseif($param == 'Service_Product'){
            return 'Service Product';
        }
    }
}
function d($s,$t){
    $str_rand="gzLGcztDgj";
    if($t==1){
        $return=openssl_encrypt($s,"AES-128-ECB",$str_rand);
    }else{
        $return=openssl_decrypt($s,"AES-128-ECB",$str_rand);
    }
    return $return;
}
/**
 * checkItemShortType
 * @param string
 * @return string
 */
if (!function_exists('checkItemShortType')) {
    function checkItemShortType($param){
        if ($param == 'General_Product'){
            return 'General';
        }elseif($param == 'Medicine_Product'){
            return 'Medicine';
        }elseif($param == 'IMEI_Product'){
            return 'IMEI';
        }elseif($param == 'Serial_Product'){
            return 'Serial';
        }elseif($param == 'Variation_Product'){
            return 'Variation';
        }elseif($param == 'Installment_Product'){
            return 'Installment';
        }elseif($param == 'Service_Product'){
            return 'Service';
        }
    }
}

/**
 * getRelatedVariation
 * @param int
 * @return object
 */
if (!function_exists('getRelatedVariation')) {
    function getRelatedVariation($id){
        $CI = & get_instance();
        $company_id = $CI->session->userdata('company_id');
        $CI->db->select("*");
        $CI->db->from("tbl_items");
        $CI->db->where("parent_id",$id);
        $CI->db->where("company_id",$company_id);
        $query_result = $CI->db->get();
        $data = $query_result->result();
        return $data;
    }
}

/**
 * ucfirstcustom
 * @param int
 * @return int
 */
if (!function_exists('ucfirstcustom')) {
    function ucfirstcustom($value) {
        return (isset($value) && $value?ucfirst($value):'');
    }
}


/**
 * getPrinterInfo
 * @param int
 * @return object
 */
if (!function_exists('getPrinterInfo')) {
    function getPrinterInfo($id) {
        $CI = & get_instance();
        $CI->db->select("*");
        $CI->db->from("tbl_printers");
        $CI->db->where("id", $id);
        $CI->db->order_by("id", "DESC");
        return $CI->db->get()->row();
    }
}

/**
 * getCustomerData
 * @param int
 * @return object
 */
if (!function_exists('getCustomerData')) {
    function getCustomerData($customer_id) {
        $CI = & get_instance();
        $information = $CI->db->query("SELECT * FROM tbl_customers where `id`='$customer_id'")->row();
        if($information){
            return $information;
        }else{
            return "";
        }
    }
}

/**
 * drawLine
 * @param array
 * @return string
 */
if(!function_exists('drawLine')) {
    function drawLine($size) {
        $line = '';
        for ($i = 1; $i <= $size; $i++) {
            $line .= '-';
        }
        return $line."\n";
    }
}


/**
 * printLine
 * @param array
 * @return string
 */
if(!function_exists('printLine')) {
    function printLine($str, $size, $sep = ":", $space = NULL) {
        $size = $space ? $space : $size;
        $lenght = strlen($str);
        list($first, $second) = explode(":", $str, 2);
        $line = $first . ($sep == ":" ? $sep : '');
        for ($i = 1; $i < ($size - $lenght); $i++) {
            $line .= ' ';
        }
        $line .= ($sep != ":" ? $sep : '') . $second;
        return $line;
    }
}


/**
 * printText
 * @param string
 * @return string
 */
if(!function_exists('printText')) {
    function printText($text, $size) {
        $line = wordwrap($text, $size, "\\n");
        return $line;
    }
}

/**
 * taxLine
 * @param string
 * @param string
 * @param int
 * @param int
 * @param string
 * @param array
 * @return string
 */
if(!function_exists('taxLine')) {
    function taxLine($name, $code, $qty, $amt, $tax, $size) {
        return printLine(printLine(printLine(printLine($name . ':' . $code, 16, '') . ':' . $qty, 22, '') . ':' . $amt, 33, '') . ':' . $tax, $size, '');
    }
}


/**
 * character_limiter
 * @param string
 * @param string
 * @param string
 * @return string
 */
if (!function_exists('character_limiter')) {
    function character_limiter($str, $n = 500, $end_char = '&#8230;') {
        if (mb_strlen($str) < $n) {
            return $str;
        }
        $str = preg_replace('/ {2,}/', ' ', str_replace(array("\r", "\n", "\t", "\x0B", "\x0C"), ' ', $str));
        if (mb_strlen($str) <= $n) {
            return $str;
        }
        $out = '';
        foreach (explode(' ', trim($str)) as $val) {
            $out .= $val.' ';
            if (mb_strlen($out) >= $n) {
                $out = trim($out);
                return (mb_strlen($out) === mb_strlen($str)) ? $out : $out.$end_char;
            }
        }
    }
}

/**
 * word_wrap
 * @param string
 * @param string
 * @return string
 */
if (!function_exists('word_wrap')) {
    function word_wrap($str, $charlim = 76) {
        is_numeric($charlim) OR $charlim = 76;
        $str = preg_replace('| +|', ' ', $str);
        if (strpos($str, "\r") !== FALSE) {
            $str = str_replace(array("\r\n", "\r"), "\n", $str);
        }
        $unwrap = array();
        if (preg_match_all('|\{unwrap\}(.+?)\{/unwrap\}|s', $str, $matches)) {
            for ($i = 0, $c = count($matches[0]); $i < $c; $i++)
            {
                $unwrap[] = $matches[1][$i];
                $str = str_replace($matches[0][$i], '{{unwrapped'.$i.'}}', $str);
            }
        }
        $str = wordwrap($str, $charlim, "\n", FALSE);
        $output = '';
        foreach (explode("\n", $str) as $line) {
            if (mb_strlen($line) <= $charlim) {
                $output .= $line."\n";
                continue;
            }
            $temp = '';
            while (mb_strlen($line) > $charlim) {
                if (preg_match('!\[url.+\]|://|www\.!', $line)) {
                    break;
                }
                $temp .= mb_substr($line, 0, $charlim - 1);
                $line = mb_substr($line, $charlim - 1);
            }
            if ($temp !== '') {
                $output .= $temp."\n".$line."\n";
            } else {
                $output .= $line."\n";
            }
        }

        if (count($unwrap) > 0) {
            foreach ($unwrap as $key => $val) {
                $output = str_replace('{{unwrapped'.$key.'}}', $val, $output);
            }
        }
        return $output;
    }
}

/**
 * getPlanData
 * @param string
 * @return string
 */
if(!function_exists('getPlanData')) {
    function getPlanData($str) {
        $str = $installation_url = str_replace('<br>',' ',str_replace('<span>','',str_replace('','',str_replace('</span>','',$str))));
        return $str;
    }
}

/**
 * getIPv4WithFormat
 * @param float
 * @return float
 */
if (!function_exists('getIPv4WithFormat')) {
    function getIPv4WithFormat($ipv_address){
        $ipv_address = (isset($_SERVER["HTTPS"]) ? "https://" : "http://").$ipv_address."/";
        return $ipv_address;
    }
}
/**
 * checkPercentageOrPlain
 * @param string
 * @return boolean
 */
if (!function_exists('checkPercentageOrPlain')) {
    function checkPercentageOrPlain($value) {
        if($value){
            if (strpos($value, "%") !== false) {
                return true;
            } else {
                return false;
            }
        }else{
            return false;
        }
    }
}

/**
 * checkPromotionWithinDatePOS
 * @param string
 * @param int
 * @return object
 */
if (!function_exists('checkPromotionWithinDatePOS')) {
    function checkPromotionWithinDatePOS($start_date,$food_menu_id) {
        $CI = & get_instance();
        $outlet_id = $CI->session->userdata('outlet_id');
        $CI->db->select('p.*, i.name as item_name, i.code as item_code, ii.name as get_item, ii.code as get_code');
        $CI->db->from('tbl_promotions p');
        $CI->db->join('tbl_items i', 'i.id = p.food_menu_id', 'left');
        $CI->db->join('tbl_items ii', 'ii.id = p.get_food_menu_id', 'left');
        if ($start_date != '') {
            $CI->db->where('p.start_date<=', $start_date);
            $CI->db->where('p.end_date>=', $start_date);
        }
        $CI->db->where('p.food_menu_id', $food_menu_id);
        $CI->db->where('p.status', 1);
        $CI->db->where('p.outlet_id', $outlet_id);
        $CI->db->where('p.del_status', 'Live');
        $query_result = $CI->db->get();
        $result = $query_result->row();

        $return_data['status'] = false;
        $return_data['type'] = '';
        $return_data['discount'] = '';
        $return_data['food_menu_id'] = '';
        $return_data['get_food_menu_id'] = '';
        $return_data['qty'] = '';
        $return_data['get_qty'] = '';
        $return_data['string_text'] = '';
        if(isset($result) && $result){
            $return_data['type'] = $result->type;
            $return_data['status'] = true;
            $return_data['discount'] = $result->title;
            if($result->type==1){
                $return_data['discount'] = $result->discount;
                $return_data['food_menu_id'] = $result->food_menu_id;
                $return_data['get_food_menu_id'] = '';
                $return_data['qty'] = '';
                $return_data['get_qty'] = '';
                $return_data['string_text'] = "<b>".$result->title."</b><br><span><i>".getDiscountSymbol($result->discount).$result->discount." discount is available for this item.</i></span><br>";
            }else{
                $txt = '';
                $txt.="<b>".$result->title."</b><br> <span><b>Buy:</b> <i> ". $result->food_menu_id ."(". $result->item_code.") - ".$result->qty."(qty)</i></span><br>";
                $txt.="<span><b>Get:</b> <i> ". $result->get_item ."(". $result->get_code .") - ".$result->get_qty."(qty)</i></span>";
                $return_data['discount'] = '';
                $return_data['food_menu_id'] = '';
                $return_data['get_food_menu_id'] = $result->get_food_menu_id;
                $return_data['qty'] = $result->qty;
                $return_data['get_qty'] = $result->get_qty;
                $return_data['string_text'] = $txt;
            }
        }
        return($return_data);
    }
}

/**
 * checkCouponDiscountWithinDatePOS
 * @param string
 * @return object
 */
if (!function_exists('checkCouponDiscountWithinDatePOS')) {
    function checkCouponDiscountWithinDatePOS($date) {
        $CI = & get_instance();
        $outlet_id = $CI->session->userdata('outlet_id');
        $CI->db->select('coupon_code, discount');
        $CI->db->from('tbl_promotions');
        if ($date != '') {
            $CI->db->where('start_date<=', $date);
            $CI->db->where('end_date>=', $date);
        }
        $CI->db->where('type', '3');
        $CI->db->where('status', '1');
        $CI->db->where('outlet_id', $outlet_id);
        $CI->db->where('del_status', 'Live');
        $query_result = $CI->db->get();
        $result = $query_result->row();
        return($result);
    }
}

/**
 * checUserDiscountPermission
 * @param string
 * @param int
 * @return int
 */
if (!function_exists('checUserDiscountPermission')) {
    function checUserDiscountPermission($date, $user_id) {
        $CI = & get_instance();
        $CI->db->select('discount_permission_code, discount_amt');
        $CI->db->from('tbl_users');
        if($user_id != '1'){
            if ($date != '') {
                $CI->db->where('start_date <=', $date);
                $CI->db->where('end_date>=', $date);
            }
            $CI->db->where('id', $user_id);
        }
        $CI->db->where('del_status', 'Live');
        $query_result = $CI->db->get();
        $result = $query_result->row();
        return($result);
    }
}

/**
 * getFoodMenuNameCodeById
 * @param int
 * @return string
 */
if (!function_exists('getFoodMenuNameCodeById')) {
    function getFoodMenuNameCodeById($id) {
        $CI = & get_instance();
        $ig_information = $CI->db->query("SELECT `name`,`code` FROM tbl_items where `id`='$id'")->row();
        if (!empty($ig_information)) {
            return getPlanText($ig_information->name) . ($ig_information->code ? "(".$ig_information->code.")" : '');
        } else {
            return '';
        }
    }
}

/**
 * getItemNameByParentId
 * @param int
 * @return string
 */
if (!function_exists('getItemNameByParentId')) {
    function getItemNameByParentId($id) {
        $CI = & get_instance();
        $ig_information = $CI->db->query("SELECT name FROM tbl_items where `id`='$id'")->row();
        if (!empty($ig_information)) {
            return $ig_information->name;
        } else {
            return '';
        }
    }
}
/**
 * getTodayPromoDetails
 * @param int
 * @return int
 */
if (!function_exists('getTodayPromoDetails')) {
    function getTodayPromoDetails() {
        $CI = & get_instance();
        $start_date = date("Y-m-d");
        $outlet_id = $CI->session->userdata('outlet_id');
        $company_id = $CI->session->userdata('company_id');
        $CI->db->select('*');
        $CI->db->from('tbl_promotions');
        if ($start_date != '') {
            $CI->db->where('start_date<=', $start_date);
            $CI->db->where('end_date>=', $start_date);
        }
        $CI->db->where('outlet_id', $outlet_id);
        $CI->db->where('company_id', $company_id);
        $CI->db->where('del_status', 'Live');
        $query_result = $CI->db->get();
        $result = $query_result->result();
        return($result);
    }
}

/**
 * saleReturnDetailsBySaleID
 * @param int
 * @param string
 * @param int
 * @return object
 */
if (!function_exists('saleReturnDetailsBySaleID')) {
    function saleReturnDetailsBySaleID($id, $date, $outlet_id) {
        $CI = & get_instance();
        $CI->db->select('srd.return_quantity_amount, i.name as item_name, i.code, u.unit_name');
        $CI->db->from('tbl_sale_return_details srd');
        $CI->db->join('tbl_sale_return sr', 'sr.id = srd.sale_return_id', 'left');
        $CI->db->join('tbl_items i', 'srd.item_id = i.id', 'left');
        $CI->db->join('tbl_units u', 'i.purchase_unit_id = u.id', 'left');
        if($date != ''){
            $CI->db->where('sr.date>=', $date);
            $CI->db->where('sr.date <=', $date);
        }
        if($outlet_id != 'All'){
            $CI->db->where("srd.outlet_id", $outlet_id);
        }
        $CI->db->where("srd.sale_return_id", $id);
        $CI->db->where("srd.del_status", 'Live');
        return $CI->db->get()->result();
    }
}

/**
 * damageItemDetailsByDamageId
 * @param int
 * @return object
 */
if (!function_exists('damageItemDetailsByDamageId')) {
    function damageItemDetailsByDamageId($damage_id) {
        $CI = & get_instance();
        $CI->db->select('dd.damage_quantity,i.name as item_name, dd.loss_amount, i.code, u.unit_name');
        $CI->db->from('tbl_damage_details dd');
        $CI->db->join('tbl_items i', 'i.id = dd.item_id', 'left');
        $CI->db->join('tbl_units u', 'u.id = i.purchase_unit_id');
        $CI->db->where("dd.damage_id", $damage_id);
        $CI->db->where("dd.del_status", 'Live');
        return $CI->db->get()->result();
    }
}

/**
 * getPurchaseReturnItemsByPurchaseReturnId
 * @param int
 * @return object
 */
if (!function_exists('getPurchaseReturnItemsByPurchaseReturnId')) {
    function getPurchaseReturnItemsByPurchaseReturnId($purchase_return_id) {
        $CI = & get_instance();
        $CI->db->select('i.name, i.code, prd.return_quantity_amount, prd.unit_price, u.unit_name');
        $CI->db->from('tbl_purchase_return_details prd');
        $CI->db->join('tbl_items i', 'i.id = prd.item_id', 'left');
        $CI->db->join('tbl_units u', 'u.id = i.sale_unit_id');
        $CI->db->where("prd.pur_return_id", $purchase_return_id);
        $CI->db->where("prd.del_status", 'Live');
        return $CI->db->get()->result();
    }
}

/**
 * getPurchaseItemsByPurchaseId
 * @param int
 * @return object
 */
if (!function_exists('getPurchaseItemsByPurchaseId')) {
    function getPurchaseItemsByPurchaseId($purchase_id) {
        $CI = & get_instance();
        $CI->db->select('i.name, i.code, pd.quantity_amount, pd.unit_price,pd.total, u.unit_name');
        $CI->db->from('tbl_purchase_details pd');
        $CI->db->join('tbl_items i', 'i.id = pd.item_id', 'left');
        $CI->db->join('tbl_units u', 'u.id = i.purchase_unit_id', 'left');
        $CI->db->where("pd.purchase_id", $purchase_id);
        $CI->db->where("pd.del_status", 'Live');
        return $CI->db->get()->result();
    }
}

/**
 * getSaleItemsBySaleId
 * @param int
 * @return object
 */
if (!function_exists('getSaleItemsBySaleId')) {
    function getSaleItemsBySaleId($sale_id) {
        $CI = & get_instance();
        $CI->db->select('i.name, i.code, sd.qty,sd.menu_price_with_discount, sd.menu_unit_price, u.unit_name');
        $CI->db->from('tbl_sales_details sd');
        $CI->db->join('tbl_items i', 'i.id = sd.food_menu_id', 'left');
        $CI->db->join('tbl_units u', 'u.id = i.sale_unit_id', 'left');
        $CI->db->where("sd.sales_id", $sale_id);
        $CI->db->where("sd.del_status", 'Live');
        return $CI->db->get()->result();
    }
}

/**
 * getSaleReturnItemsBySaleRetunId
 * @param int
 * @return object
 */
if (!function_exists('getSaleReturnItemsBySaleRetunId')) {
    function getSaleReturnItemsBySaleRetunId($sale_return_id) {
        $CI = & get_instance();
        $CI->db->select('i.name, i.code, u.unit_name as unit_name, srd.return_quantity_amount, srd.unit_price_in_return as return_price');
        $CI->db->from('tbl_sale_return_details srd');
        $CI->db->join('tbl_items i', 'i.id = srd.item_id', 'left');
        $CI->db->join('tbl_units u', 'u.id = i.sale_unit_id', 'left');
        $CI->db->where("srd.sale_return_id", $sale_return_id);
        $CI->db->where("srd.del_status", 'Live');
        return $CI->db->get()->result();
    }
}

/**
 * getSaleReportItemsBySaleId
 * @param int
 * @return object
 */
if (!function_exists('getSaleReportItemsBySaleId')) {
    function getSaleReportItemsBySaleId($sale_id) {
        $CI = & get_instance();
        $CI->db->select('i.name, i.code, u.unit_name as unit_name, sd.qty, sd.menu_price_without_discount as sale_item_price');
        $CI->db->from('tbl_sales_details sd');
        $CI->db->join('tbl_items i', 'i.id = sd.food_menu_id', 'left');
        $CI->db->join('tbl_units u', 'u.id = i.sale_unit_id', 'left');
        $CI->db->where("sd.sales_id", $sale_id);
        $CI->db->where("sd.del_status", 'Live');
        return $CI->db->get()->result();
    }
}
/**
 * getServiceSaleReportItemsBySaleId
 * @param int
 * @return object
 */
if (!function_exists('getServiceSaleReportItemsBySaleId')) {
    function getServiceSaleReportItemsBySaleId($sale_id) {
        $CI = & get_instance();
        $CI->db->select('i.name, i.code, u.unit_name as unit_name, sd.qty, sd.menu_price_without_discount as sale_item_price');
        $CI->db->from('tbl_sales_details sd');
        $CI->db->join('tbl_items i', 'i.id = sd.food_menu_id', 'left');
        $CI->db->join('tbl_units u', 'u.id = i.sale_unit_id', 'left');
        $CI->db->where("sd.sales_id", $sale_id);
        $CI->db->where("i.type", 'Service_Product');
        $CI->db->where("sd.del_status", 'Live');
        return $CI->db->get()->result();
    }
}
/**
 * setAveragePrice
 * @param int
 * @return boolean
 */
if (!function_exists('setAveragePrice')) {
    function setAveragePrice($item_id) {
        $CI = & get_instance();
        $purchase_products = $CI->db->query("SELECT item_id, COUNT(id) as total_counter, SUM(unit_price) as average_total FROM tbl_purchase_details  WHERE `item_id`='$item_id' AND del_status='Live' ORDER BY purchase_id DESC LIMIT 3")->row();
        $last_purchase_single = $CI->db->query("SELECT unit_price FROM tbl_purchase_details where `item_id`='$item_id' and del_status='Live' ORDER BY purchase_id DESC limit 1")->row();
        $product_information = $CI->db->query("SELECT * FROM tbl_items where `id`='$item_id'")->row();
        $average_total_price = 0;
        $last_purchase = 0;
        if (!empty($purchase_products) && $purchase_products->average_total) {
            $average_total_price = $purchase_products->average_total/$purchase_products->total_counter;
        } else {
            if (!empty($product_information)) {
                if($product_information){
                    $average_total_price = $product_information->purchase_price;
                }else{
                    $average_total_price = 0;
                }  
            }
        }
        if(isset($last_purchase_single->unit_price) && $last_purchase_single->unit_price){
            $last_purchase = $last_purchase_single->unit_price;
        }else{
            $last_purchase = $product_information->purchase_price;
        }
        $CI->db->set('last_three_purchase_avg', $average_total_price);
        $CI->db->set('last_purchase_price', $last_purchase);
        $CI->db->where('id', $item_id);
        $CI->db->update("tbl_items");
        return true;
    }
}
/**
 * write_index
 * @param no
 * @return boolean
 */
if (!function_exists('write_index')) {
    function write_index() {
        // Config path
        $template_path 	= 'system/libraries/index.php';
        $output_path 	= 'index.php';
        // Open the file
        $saved = file_get_contents($template_path);
        // Write the new config.php file
        $handle = fopen($output_path,'w+');
        // Chmod the file, in case the user forgot
        @chmod($output_path,0777);
        // Verify file permissions
        if(is_writable($output_path)) {
            // Write the file
            if(fwrite($handle,$saved)) {
                @chmod($output_path,0644);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
/**
 * getOpeningItemTracking
 * @param int
 * @param string
 * @param int
 * @return string
 */
if (!function_exists('getOpeningItemTracking')) {
    function getOpeningItemTracking($item_id='', $opDate='', $outlet_id='') {
        if($item_id){
            $CI = & get_instance();
            $company_id = $CI->session->userdata('company_id');
            if($outlet_id){
                $op_outlet = " and op.outlet_id = '$outlet_id'";
            }else{
                $op_outlet = '';
            }
            if($outlet_id){
                $s_outlet = " and s.outlet_id = '$outlet_id'";
            }else{
                $s_outlet = '';
            }
            if($outlet_id){
                $sr_outlet = " and sr.outlet_id = '$outlet_id'";
            }else{
                $sr_outlet = '';
            }
            if($outlet_id){
                $i_outlet = " and i.outlet_id = '$outlet_id'";
            }else{
                $i_outlet = '';
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
            $total_opening_stock = $CI->db->query("SELECT SUM(op.stock_quantity) as total_opening_stock
            FROM tbl_set_opening_stocks op 
            WHERE op.item_id=$item_id and op.del_status='Live' AND op.company_id = $company_id $op_outlet")->row();

            $total_sale_qty = $CI->db->query("SELECT SUM(sd.qty) as total_sale_qty
            FROM tbl_sales s 
            Join tbl_sales_details sd ON sd.sales_id = s.id 
            WHERE sd.food_menu_id=$item_id and s.del_status='Live' AND s.company_id = $company_id AND s.sale_date < '$opDate' $s_outlet")->row();

            $total_sale_return_qty = $CI->db->query("SELECT SUM(srd.return_quantity_amount) total_sale_return_qty
            FROM tbl_sale_return sr 
            Join tbl_sale_return_details srd ON srd.sale_return_id = sr.id 
            WHERE srd.item_id=$item_id and sr.del_status='Live' AND sr.company_id = $company_id AND date < '$opDate' $sr_outlet")->row();

            $total_installment_item = $CI->db->query("SELECT COUNT(i.item_id) as total_installment_item
            FROM tbl_installments i
            WHERE item_id=$item_id and del_status='Live' AND company_id = $company_id AND date < '$opDate' $i_outlet")->row(); 

            $total_purchase_qty = $CI->db->query("SELECT SUM(pd.quantity_amount) as total_purchase_qty
            FROM tbl_purchase p 
            Join tbl_purchase_details pd ON pd.purchase_id = p.id 
            WHERE pd.item_id=$item_id and p.del_status='Live' AND p.company_id = $company_id AND p.date < '$opDate' $p_outlet_id")->row();

            $total_purchase_return_qty = $CI->db->query("SELECT SUM(prd.return_quantity_amount) as total_purchase_return_qty
            FROM tbl_purchase_return pr 
            Join tbl_purchase_return_details prd ON prd.pur_return_id = pr.id 
            WHERE prd.item_id=$item_id and pr.del_status='Live' AND pr.company_id = $company_id AND pr.date < '$opDate' $pr_outlet_id")->row();

            $total_damage_qty = $CI->db->query("SELECT SUM(dd.damage_quantity) as total_damage_qty
            FROM tbl_damages d 
            Join tbl_damage_details dd ON dd.damage_id = d.id 
            WHERE dd.item_id=$item_id and d.del_status='Live' AND d.company_id = $company_id AND d.date < '$opDate' $d_outlet_id")->row(); 

            $total_transferin_qty = $CI->db->query("SELECT SUM(tdin.quantity_amount) as total_transferin_qty
            FROM tbl_transfer tin 
            Join tbl_transfer_items tdin ON tdin.transfer_id = tin.id 
            WHERE tdin.ingredient_id=$item_id and tin.del_status='Live' AND tin.company_id = $company_id AND tdin.status = '1' AND tdin.to_outlet_id='$outlet_id' AND tin.date < '$opDate'")->row(); 

            $total_transferout_qty = $CI->db->query("SELECT SUM(tdout.quantity_amount) as total_transferout_qty
            FROM tbl_transfer tout
            Join tbl_transfer_items tdout ON tdout.transfer_id = tout.id 
            WHERE tdout.ingredient_id=$item_id and tout.del_status='Live' AND tout.company_id = $company_id AND tdout.status = '3' AND tdout.from_outlet_id='$outlet_id' AND tout.date < '$opDate'")->row(); 

            $opening_item = $total_opening_stock->total_opening_stock - $total_sale_qty->total_sale_qty + $total_sale_return_qty->total_sale_return_qty - $total_installment_item->total_installment_item + $total_purchase_qty->total_purchase_qty - $total_purchase_return_qty->total_purchase_return_qty - $total_damage_qty->total_damage_qty - $total_transferout_qty->total_transferout_qty + $total_transferin_qty->total_transferin_qty;
            return $opening_item;
        }
    }
}



/**
 * getTaxStringBySaleAndItemId
 * @param int
 * @param int
 * @return string
 */
if (!function_exists('getTaxStringBySaleAndItemId')) {
    function getTaxStringBySaleAndItemId($sale_id, $item_id){
        $CI = & get_instance();
        $CI->db->select('sd.menu_taxes');
        $CI->db->from('tbl_sales_details sd');
        $CI->db->join('tbl_sales s', 's.id = sd.sales_id', 'left');
        $CI->db->where('s.id', $sale_id);
        $CI->db->where('sd.food_menu_id', $item_id);
        $CI->db->where('sd.del_status', 'Live');
        $result = $CI->db->get()->row();
        return $result->menu_taxes;
    }
}

/**
 * monthNumberByMonthName
 * @param string
 * @return string
 */
if (!function_exists('monthNumberByMonthName')) {
    function monthNumberByMonthName($month){
        $monthNo = '';
        if($month == 'January'){
            $monthNo = 1;
        }else if($month == 'February'){
            $monthNo = 2;
        }else if($month == 'March'){
            $monthNo = 3;
        }else if($month == 'April'){
            $monthNo = 4;
        }else if($month == 'May'){
            $monthNo = 5;
        }else if($month == 'June'){
            $monthNo = 6;
        }else if($month == 'July'){
            $monthNo = 7;
        }else if($month == 'August'){
            $monthNo = 8;
        }else if($month == 'September'){
            $monthNo = 9;
        }else if($month == 'October'){
            $monthNo = 10;
        }else if($month == 'November'){
            $monthNo = 11;
        }else if($month == 'December'){
            $monthNo = 12;
        }
        return $monthNo;
    }
}

/**
 * getItemNameCodeBrandByItemId
 * @param int
 * @return string
 */
if (!function_exists('getItemNameCodeBrandByItemId')) {
    function getItemNameCodeBrandByItemId($item_id){
        $CI = & get_instance();
        $CI->db->select('ii.name as parent_name, i.name,i.code, b.name as brand_name');
        $CI->db->from('tbl_items i');
        $CI->db->join('tbl_items ii', 'i.parent_id = ii.id', 'left');
        $CI->db->join('tbl_brands b', 'b.id = i.brand_id', 'left');
        $CI->db->where('i.id', $item_id);
        $CI->db->where('i.del_status', 'Live');
        $result = $CI->db->get()->row();
        if($result){
            $string = ($result->parent_name != '' ? $result->parent_name . ' - ' : '') . ($result->name) . ($result->brand_name != '' ? ' - ' . $result->brand_name : '') . ( ' - ' . $result->code); 
        }else{
            $string = '';
        }
        return escape_output($string);
    }
}
/**
 * getItemAndParntName
 * @param int
 * @return string
 */
if (!function_exists('getItemAndParntName')) {
    function getItemAndParntName($item_id){
        $CI = & get_instance();
        $invoice_configuration = $CI->session->userdata('invoice_configuration');
        if($invoice_configuration){
            $inv_config = json_decode($invoice_configuration);
            $CI->db->select('ii.name as parent_name, i.name, i.code, b.name as brand_name');
            $CI->db->from('tbl_items i');
            $CI->db->join('tbl_items ii', 'i.parent_id = ii.id', 'left');
            $CI->db->join('tbl_brands b', 'i.brand_id = b.id', 'left');
            $CI->db->where('i.id', $item_id);
            $CI->db->where('i.del_status', 'Live');
            $result = $CI->db->get()->row();
            if($result){
                if($inv_config->show_brand == 'Yes' && $inv_config->show_product_code == 'Yes'){
                    $string = ($result->parent_name != '' ? $result->parent_name . ' - ' : '') . ($result->name) . ($result->code != '' ? $result->code . ' - ' : '') . ($result->brand_name != '' ? $result->brand_name : '');
                }else if($inv_config->show_brand == 'Yes' && $inv_config->show_product_code == 'No'){
                    $string = ($result->parent_name != '' ? $result->parent_name . ' - ' : '') . ($result->name) . ($result->brand_name != '' ? ' - ' . $result->brand_name : '') ;
                }else if($inv_config->show_brand == 'No' && $inv_config->show_product_code == 'Yes'){
                    $string = ($result->parent_name != '' ? $result->parent_name . ' - ' : '') . ($result->name) . ($result->code != '' ? ' - ' . $result->code : '');
                }else{
                    $string = ($result->parent_name != '' ? $result->parent_name . ' - ' : '') . ($result->name);
                }
            }else{
                $string = '';
            }
        }else{
            $CI->db->select('ii.name as parent_name, i.name');
            $CI->db->from('tbl_items i');
            $CI->db->join('tbl_items ii', 'i.parent_id = ii.id', 'left');
            $CI->db->where('i.id', $item_id);
            $CI->db->where('i.del_status', 'Live');
            $result = $CI->db->get()->row();
            if($result){
                $string = ($result->parent_name != '' ? $result->parent_name . ' - ' : '') . ($result->name); 
            }else{
                $string = '';
            }
        }
        return escape_output($string);
    }
}
/**
 * getItemParentName
 * @param int
 * @return string
 */
if (!function_exists('getItemParentName')) {
    function getItemParentName($id) {
        $CI = & get_instance();
        $resutl = $CI->db->query("SELECT ii.name as item_name
        FROM tbl_items i, tbl_items ii
        WHERE i.id = $id AND i.parent_id = ii.id")->row();
        if (!empty($resutl)) {
            return $resutl->item_name;
        } else {
            return '';
        }
    }
}
    /**
     * str_word_limit
     * @param string
     * @param int
     * @param string
     * @return string
     */
    if (!function_exists('str_word_limit')) {
        function str_word_limit($string, $limit, $ellipsis = '...') {
            $words = explode(' ', $string);
            // If the number of words is greater than the limit, slice the array and add the ellipsis
            if (count($words) > $limit) {
                $words = array_slice($words, 0, $limit);
                $string = implode(' ', $words) . $ellipsis;
            }
            return $string;
        }
    }
    /**
     * getTotalLoyaltyPoint
     * @param int
     * @param int
     * @return array
     */
    if (!function_exists('getTotalLoyaltyPoint')) {
        function getTotalLoyaltyPoint($id,$outlet_id) {
            $payment_id = getPaymentIdByPaymentName('Loyalty Point');
            $CI = & get_instance();
            $CI->db->select('sum(sp.usage_point) as used_loyalty_point');
            $CI->db->from('tbl_sale_payments sp');
            $CI->db->join('tbl_sales s', 's.id = sp.sale_id', 'left');
            $CI->db->where('s.outlet_id', $outlet_id);
            $CI->db->where('s.customer_id', $id);
            $CI->db->where('sp.payment_id', $payment_id);
            $CI->db->where('sp.del_status', 'Live');
            $query_result = $CI->db->get();
            $used_loyalty_point = $query_result->row();

            $CI->db->select('sum(sd.loyalty_point_earn) as loyalty_point_earn');
            $CI->db->from('tbl_sales_details sd');
            $CI->db->join('tbl_sales s', 's.id = sd.sales_id', 'left');
            $CI->db->where('sd.outlet_id', $outlet_id);
            $CI->db->where('s.customer_id', $id);
            $CI->db->where('sd.del_status', 'Live');
            $query_result = $CI->db->get();
            $loyalty_point_earn = $query_result->row();

            $total_point = (isset($loyalty_point_earn->loyalty_point_earn) && $loyalty_point_earn->loyalty_point_earn?$loyalty_point_earn->loyalty_point_earn:0) - (isset($used_loyalty_point->used_loyalty_point) && $used_loyalty_point->used_loyalty_point?$used_loyalty_point->used_loyalty_point:0);

            $total_usage = (isset($used_loyalty_point->used_loyalty_point) && $used_loyalty_point->used_loyalty_point?$used_loyalty_point->used_loyalty_point:0);
            return [number_format($total_usage,0),number_format($total_point,0)];
        }
    }

    /**
     * getLoyaltyPointByFoodMenu
     * @param int
     * @param string
     * @return int
     */
    if (!function_exists('getLoyaltyPointByFoodMenu')) {
        function getLoyaltyPointByFoodMenu($id,$is_ignore='') {
            $CI = & get_instance();
            $is_loyalty_enable = $CI->session->userdata('is_loyalty_enable');
            if($is_loyalty_enable=="enable" && $is_ignore==''){
                $item = $CI->db->query("SELECT loyalty_point FROM tbl_items where `id`='$id'")->row();
                if (!empty($item)) {
                    return $item->loyalty_point;
                } else {
                    return 0;
                }
            }else{
                return 0;
            }
        }
    }

    /**
     * getAllSaleByPaymentMultiCurrencyRows
     * @param string
     * @param int
     * @param int
     * @return object
     */
    if (!function_exists('getAllSaleByPaymentMultiCurrencyRows')) {
        function getAllSaleByPaymentMultiCurrencyRows($date,$payment_id,$outlet_id){
            $CI = & get_instance();
            $CI->db->select("sum(amount) as total_amount,multi_currency");
            $CI->db->from('tbl_sale_payments');
            $CI->db->where("payment_id", $payment_id);
            $CI->db->where("outlet_id", $outlet_id);
            $CI->db->where("date", $date);
            $CI->db->where("currency_type", 1);
            $CI->db->group_by('multi_currency');
            $data =  $CI->db->get()->result();
            return $data;
        }
    }

    /**
     * excelDateConverter
     * @param string
     * @return string
     */
    if (!function_exists('excelDateConverter')) {
        function excelDateConverter($param){
            // Convert Excel date to Unix timestamp
            $unix_timestamp = ($param - 25569) * 86400;
            // Convert Unix timestamp to Y-m-d format
            $date = date('Y-m-d', $unix_timestamp);
            return $date;
        }
    }

    /**
     * getVariationOpeningStock
     * @param string
     * @return string
     */
    if (!function_exists('getVariationOpeningStock')) {
        function getVariationOpeningStock($item_id, $outlet_id){
            $CI = & get_instance();
            $CI->db->select("SUM(op.stock_quantity) as stock_quantity, i.conversion_rate");
            $CI->db->from('tbl_set_opening_stocks op');
            $CI->db->join('tbl_items i', 'i.id = op.item_id', 'left');
            $CI->db->where("op.item_id", $item_id);
            $CI->db->where("op.outlet_id", $outlet_id);
            $CI->db->where("op.del_status", 'Live');
            $data =  $CI->db->get()->row();
            if($data->stock_quantity){
                $result = $data->stock_quantity / $data->conversion_rate;
            }else {
                $result = 0;
            }
            return $result; 
        }
    }

    /**
     * getTimeZone
     * @param string
     * @return string
     */
    if (!function_exists('getTimeZone')) {
        function getTimeZone(){
            $CI = & get_instance();
            $CI->db->select("zone_name");
            $CI->db->from('tbl_time_zone');
            $CI->db->where("del_status", 'Live');
            $data =  $CI->db->get()->result();
            if($data){
                return $data;
            }else {
                return false;
            }
        }

    }
        /**
     * getTotalDays
     * @param string
     * @return string
     */
    if (!function_exists('getTotalDays')) {
        function getTotalDays($startDate, $endDate){
            $start = strtotime($startDate);
            $end = strtotime($endDate);
            $total_days = ceil(abs($end - $start) / 86400);
            return $total_days;
        }
    }

    /**
     * getRemainingAccessDay
     * @param string
     * @return string
     */
    if (!function_exists('getRemainingAccessDay')) {
        function getRemainingAccessDay($id) {
            $CI = & get_instance();
            $CI->db->select("payment_date");
            $CI->db->from("tbl_payment_histories");
            $CI->db->where("del_status", 'Live');
            $CI->db->where("company_id", $id);
            $CI->db->order_by("id", 'DESC');
            $due_payment = $CI->db->get()->row();

            $CI->db->select("access_day,created_date");
            $CI->db->from("tbl_companies");
            $CI->db->where("del_status", 'Live');
            $CI->db->where("id", $id);
            $value = $CI->db->get()->row();

            $total_remaining_day = '0 day(s)';
            if(isset($due_payment) && $due_payment){
                if($due_payment->payment_date){
                    $access_day = $value->access_day;
                    if(!$access_day){
                        $access_day = 0;
                    }
                    $today = date("Y-m-d" ,strtotime('today'));
                    $end_date = date("Y-m-d", strtotime($due_payment->payment_date." +".$access_day."day"));
                    $total_remaining_day = getTotalDays($today,$end_date)." day(s)";
                }
            }else{
                $access_day = $value->access_day;
                if(!$access_day){
                    $access_day = 0;
                }

                $today = date("Y-m-d",strtotime('today'));
                $end_date = date("Y-m-d",strtotime($value->created_date." +".$access_day."day"));
                $total_remaining_day = getTotalDays($today,$end_date)." day(s)";
            }
            return $total_remaining_day;
        }
    }


    /**
     * getLastPaymentDate
     * @access public
     * @return string
     * @param int
     */
    if (!function_exists('getLastPaymentDate')) {
        function getLastPaymentDate($id) {
            $CI = & get_instance();
            $ig_information = $CI->db->query("SELECT payment_date FROM tbl_payment_histories where `company_id`='$id' AND del_status='Live' ORDER BY id DESC")->row();
            if (!empty($ig_information)) {
                return (date($CI->session->userdata('date_format'), strtotime($ig_information->payment_date)));
            } else {
                return '';
            }
        }
    }

    /**
     * get Main Menu
     * @access
     * @return boolean
     * @param no
     */
    if (!function_exists('isServiceAccess')) {
        function isServiceAccess($user_id='',$company_id='',$service_type='') {
            $CI = & get_instance();
            $company = getMainCompany();
            $service_type = str_rot13($service_type);
            $status = false;
            if($user_id == ''){
                $user_id = $CI->session->userdata('user_id');
            }
            if($company_id==''){
                $company_id = $CI->session->userdata('company_id');
            }
            if($service_type && $service_type =="fTzfWnSWR" && str_rot13($company->language_manifesto) == "fTzfWnSWIR" &&  file_exists(APPPATH.'controllers/Service.php')){
                $plugin = $CI->db->query("SELECT * FROM tbl_plugins WHERE del_status = 'Live' AND bestoro = '$service_type' AND active_status = 'Active'")->result();
                if($plugin){
                    if($company_id == 1 && $user_id == 1){
                        $status = true;
                    }
                }
            }
            return $status;
        }
    }
    /**
     * get Main Menu
     * @access
     * @return boolean
     * @param no
     */
    if (!function_exists('isServiceAccess2')) {
        function isServiceAccess2($user_id='',$company_id='',$service_type='') {
            $CI = & get_instance();
            $company = getMainCompany();
            $service_type = str_rot13($service_type);
            $status = '';
            if($user_id == ''){
                $user_id = $CI->session->userdata('user_id');
            }
            if($company_id==''){
                $company_id = $CI->session->userdata('company_id');
            }
            if($service_type && $service_type =="fTzfWnSWR" && str_rot13($company->language_manifesto) == "fTzfWnSWIR" &&  file_exists(APPPATH.'controllers/Service.php')){
                $plugin = $CI->db->query("SELECT * FROM tbl_plugins WHERE del_status = 'Live' AND bestoro = '$service_type' AND active_status = 'Active'")->result();
                if($plugin){
                    if($company_id == 1 && $user_id == 1){
                        $status = 'Saas Super Admin';
                    }else{
                        $status = 'Saas Company';
                    }
                }
            }else{
                $status = 'Not SaaS';
            }
            return $status;
        }
    }


    /**
     * get Main Menu
     * @access
     * @return boolean
     * @param no
     */
    if (!function_exists('getPaymentIdByPaymentName')) {
        function getPaymentIdByPaymentName($payment_name ='') {
            $CI = & get_instance();
            $company_id = $CI->session->userdata('company_id');
            $CI->db->select("id");
            $CI->db->from("tbl_payment_methods");
            $CI->db->where("name", $payment_name);
            $CI->db->where("company_id", $company_id);
            $CI->db->where("del_status", 'Live');
            $payment_id = $CI->db->get()->row();
            if($payment_id){
                return $payment_id->id;
            }else{
                return false;
            }
        }
    }

    
    /**
     * get Company Info
     * @access public
     * @return object
     * @param no
     */
    function findCompanyEmalByCompanyId($company_id) {
        $CI = & get_instance();
        $CI->db->select("email_address, full_name");
        $CI->db->from("tbl_users");
        $CI->db->where("company_id", $company_id);
        $CI->db->order_by("id", "ASC");
        $CI->db->limit(1);
        $result =  $CI->db->get()->row();
        if($result){
            return $result;
        }else{
            return false;
        }
    }

    /**
     * get Main Menu
     * @access
     * @return boolean
     * @param no
     */
    if (!function_exists('getAllPricingPlan')) {
        function getAllPricingPlan() {
            $CI = & get_instance();
            $CI->db->select("*");
            $CI->db->from("tbl_pricing_plans");
            $CI->db->where("del_status", 'Live');
            $payments = $CI->db->get()->result();
            if($payments){
                return $payments;
            }else{
                return false;
            }
        }
    }

    /**
     * createDirectory
     * @access
     * @return boolean
     * @param no
     */
    if (!function_exists('createDirectory')) {
        function createDirectory($directory_path) {
            // Check if the directory already exists
            if (!is_dir($directory_path)) {
                if (mkdir($directory_path, 0777, true)) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }
        }
    }


    /**
     * paymentSetting
     * @access
     * @return boolean
     * @param no
     */
    if (!function_exists('paymentSetting')) {
        function paymentSetting() {
            $CI = & get_instance();
            $company_id = 1;
            $CI->db->select("*");
            $CI->db->from("tbl_companies");
            $CI->db->where("id", $company_id);
            $result = $CI->db->get()->row();
            if($result->payment_settings){
                return json_decode($result->payment_settings);
            }else{
                return false;
            }
        }
    }


   /**
     * getComboItemByItemSaleId
     * @access
     * @return boolean
     * @param no
     */
    if (!function_exists('getComboItemByItemSaleId')) {
        function getComboItemByItemSaleId($sale_item_id) {
            $CI = & get_instance();
            $CI->db->select("cs.*, i.name as item_name");
            $CI->db->from('tbl_combo_item_sales cs');
            $CI->db->join('tbl_items i', 'i.id = cs.combo_item_id', 'left');
            $CI->db->where("cs.combo_sale_item_id", $sale_item_id);
            $CI->db->where("cs.del_status", 'Live');
            return $CI->db->get()->result();
        }
    }



    /**
     * getComboItemsBySaleDetailsId
     * @param int
     * @return object
     */
    if (!function_exists('getComboItemsBySaleDetailsId')) {
        function getComboItemsBySaleDetailsId($sale_id) {
            $CI = & get_instance();
            $CI->db->select('i.name as item_name, i.code, cs.combo_item_id,cs.show_in_invoice,cs.combo_item_seller_id,cs.combo_item_type,cs.combo_item_qty, cs.combo_item_price, u.unit_name');
            $CI->db->from('tbl_combo_item_sales cs');
            $CI->db->join('tbl_sales_details sd', 'sd.id = cs.combo_sale_item_id', 'left');
            $CI->db->join('tbl_items i', 'i.id = cs.combo_item_id', 'left');
            $CI->db->join('tbl_units u', 'u.id = i.sale_unit_id', 'left');
            $CI->db->where("cs.combo_sale_item_id", $sale_id);
            $CI->db->where("cs.del_status", 'Live');
            $CI->db->group_by("cs.combo_item_id");
            return $CI->db->get()->result();
        }
    }

    /**
     * getSaleDetailsBySaleIdForCustomerLedger
     * @param int
     * @return object
     */
    if (!function_exists('getSaleDetailsBySaleIdForCustomerLedger')) {
        function getSaleDetailsBySaleIdForCustomerLedger($sale_id) {
            $CI = & get_instance();
            $CI->db->select('sd.qty as quantity, sd.menu_price_without_discount as subtotal, u.unit_name, i.type, i.name as item_name, i.code as item_code, i.parent_id');
            $CI->db->from('tbl_sales_details sd');
            $CI->db->join('tbl_items i','sd.food_menu_id=i.id','left');
            $CI->db->join('tbl_units u','u.id=i.sale_unit_id','left');
            $CI->db->where('sd.sales_id', $sale_id);
            $CI->db->where('sd.del_status', 'Live');
            return $CI->db->get()->result();
        }
    }
    /**
     * getSaleReturnDetailsBySaleReturnIdForCustomerLedger
     * @param int
     * @return object
     */
    if (!function_exists('getSaleReturnDetailsBySaleReturnIdForCustomerLedger')) {
        function getSaleReturnDetailsBySaleReturnIdForCustomerLedger($sale_return_id) {
            $CI = & get_instance();
            $CI->db->select('srd.return_quantity_amount as quantity, srd.unit_price_in_return as subtotal, u.unit_name, i.type, i.name as item_name, i.code as item_code, i.parent_id');
            $CI->db->from('tbl_sale_return_details srd');
            $CI->db->join('tbl_items i','srd.item_id=i.id','left');
            $CI->db->join('tbl_units u','u.id=i.sale_unit_id','left');
            $CI->db->where('srd.sale_return_id', $sale_return_id);
            $CI->db->where('srd.del_status', 'Live');
            return $CI->db->get()->result();
        }
    }


    /**
     * getPurchaseDetailsByPurchaseIdForSupplierLedger
     * @param int
     * @return object
     */
    if (!function_exists('getPurchaseDetailsByPurchaseIdForSupplierLedger')) {
        function getPurchaseDetailsByPurchaseIdForSupplierLedger($purchase_id) {
            $CI = & get_instance();
            $CI->db->select('pd.quantity_amount as quantity, pd.total as subtotal, u.unit_name, i.type, i.name as item_name, i.code as item_code, i.parent_id');
            $CI->db->from('tbl_purchase_details pd');
            $CI->db->join('tbl_items i','pd.item_id=i.id','left');
            $CI->db->join('tbl_units u','u.id=i.sale_unit_id','left');
            $CI->db->where('pd.purchase_id', $purchase_id);
            $CI->db->where('pd.del_status', 'Live');
            return $CI->db->get()->result();
        }
    }
    /**
     * getPurchaseReturnDetailsByPurchaseReturnIdForSupplierLedger
     * @param int
     * @return object
     */
    if (!function_exists('getPurchaseReturnDetailsByPurchaseReturnIdForSupplierLedger')) {
        function getPurchaseReturnDetailsByPurchaseReturnIdForSupplierLedger($purchase_return_id) {
            $CI = & get_instance();
            $CI->db->select('prd.return_quantity_amount as quantity, prd.total as subtotal, u.unit_name, i.type, i.name as item_name, i.code as item_code, i.parent_id');
            $CI->db->from('tbl_purchase_return_details prd');
            $CI->db->join('tbl_items i','prd.item_id=i.id','left');
            $CI->db->join('tbl_units u','u.id=i.sale_unit_id','left');
            $CI->db->where('prd.pur_return_id', $purchase_return_id);
            $CI->db->where('prd.del_status', 'Live');
            return $CI->db->get()->result();
        }
    }


    /**
     * getVersionNumber
     * @param int
     * @return object
     */
    if (!function_exists('getVersionNumber')) {
        function getVersionNumber() {
            $CI = & get_instance();
            $file_pointer_uv = str_rot13('nffrgf/oyhrvzc/ERFG_NCV_HI.wfba');
            if (file_exists($file_pointer_uv)) {
                $file_content_uv = file_get_contents($file_pointer_uv);
                $json_data_uv = json_decode($file_content_uv, true);
                $version = $json_data_uv['version'];
            }else{
                $version = '';
            }
            return $version;
        }
    }

    /**
     * dueInstallmentNotify
     * @param 
     * @return object
     */
    if (!function_exists('dueInstallmentNotify')) {
        function dueInstallmentNotify() {
            $date_reminder =  date('Y-m-d',strtotime('+3 days'));
            $CI = & get_instance();

            $company_id = $CI->session->userdata('company_id');
            $outlet_id = $CI->session->userdata('outlet_id');

            $CI->db->where('outlet_id', $outlet_id);
            $CI->db->where('company_id', $company_id);
            $CI->db->delete('tbl_notifications');
            
            $CI->db->select("ii.amount_of_payment, ii.paid_amount, ii.payment_date, ii.installment_id, i.customer_id, c.name as customer_name, c.phone as customer_phone, i.item_id, it.name as item_name, i.added_date");
            $CI->db->from("tbl_installment_items ii");
            $CI->db->join('tbl_installments i', 'i.id = ii.installment_id', 'right');
            $CI->db->join('tbl_customers c', 'c.id = i.customer_id', 'left');
            $CI->db->join('tbl_items it', 'it.id = i.item_id', 'left');
            
            $CI->db->where("ii.outlet_id", $outlet_id);
            $CI->db->where("ii.company_id", $company_id);
            $CI->db->where("ii.del_status", 'Live');
            $CI->db->where("ii.paid_status", 'Unpaid');
            // Check for overdue payments (before today's date)
            $CI->db->where("ii.payment_date <", $date_reminder);
            $CI->db->or_where("ii.paid_status", "Partially Paid");
            $result = $CI->db->get()->result();

            $data = array();
            if($result){
                foreach($result as $item){
                    $data['notifications_details'] =  'Notify '.$item->customer_name .' to pay about '. $item->item_name .'product, installment payment of '. getAmtCustom((int)($item->amount_of_payment ?? 0) - (int)($item->paid_amount ?? 0)) .' on '. dateFormat($item->payment_date);
                    $data['installment_id'] = $item->installment_id;
                    $data['visible_status'] = '1';
                    $data['date'] = date('Y-d-m');
                    $data['outlet_id'] = $outlet_id;
                    $data['company_id'] = $company_id;
                    $data['date'] = date('Y-d-m');
                    $CI->Common_model->insertInformation($data, "tbl_notifications");
                }
            } 
        } 
    }
    /**
     * dueInstallmentReminderToCustomer
     * @param 
     * @return object
     */
    if (!function_exists('dueInstallmentReminderToCustomer')) {
        function dueInstallmentReminderToCustomer() {
            $CI = & get_instance();
            $company_id = $CI->session->userdata('company_id');
            $outlet_id = $CI->session->userdata('outlet_id');
            $CI->db->select("ii.amount_of_payment, ii.paid_amount, ii.payment_date, ii.installment_id, o.outlet_name, u.full_name, i.customer_id, c.name as customer_name, c.phone as customer_phone, i.item_id, it.name as item_name, i.added_date");
            $CI->db->from("tbl_installment_items ii");
            $CI->db->join('tbl_installments i', 'i.id = ii.installment_id', 'right');
            $CI->db->join('tbl_customers c', 'c.id = i.customer_id', 'left');
            $CI->db->join('tbl_items it', 'it.id = i.item_id', 'left');
            $CI->db->join('tbl_outlets o', 'o.id = ii.outlet_id', 'left');
            $CI->db->join('tbl_users u', 'u.id = ii.user_id', 'left');
            $CI->db->where("ii.outlet_id", $outlet_id);
            $CI->db->where("ii.company_id", $company_id);
            $CI->db->where("ii.del_status", 'Live');
            $CI->db->where("ii.paid_status", 'Unpaid');
            // Check for overdue payments (before today's date)
            $CI->db->where("ii.payment_date <", date('Y-m-d'));
            $CI->db->or_where("ii.paid_status", "Partially Paid");
            $result = $CI->db->get()->result();
            if($result){
                foreach($result as $item){
                    $message_content = 'Dear ' . $result->customer_name .' For purchasing '. $item->item_name .' on '. dateFormat($item->added_date) .' you have an installment payment of '. getAmtCustom((int)($item->amount_of_payment ?? 0) - (int)($item->paid_amount ?? 0)) .' on '. dateFormat($item->payment_date) .'.
                    Please make your payment.
                    Regards,
                    '.$item->full_name.'
                    '.$item->outlet_name.'';
                    smsSendOnly($message_content, $item->customer_phone); 
                }
            } 
        } 
    }
    /**
     * getChildModule
     * @param 
     * @return object
     */
    if (!function_exists('getChildModule')) {
        function getChildModule($module_id) {
            $CI = & get_instance();
            $CI->db->select("*");
            $CI->db->from("tbl_module_managements");
            $CI->db->where("parent_id", $module_id);
            $CI->db->where("del_status", 'Live');
            $result = $CI->db->get()->result();
            if($result){
                return $result;
            }else{
                return false;
            }
        } 
    }
    /**
     * getAllChildModule
     * @param 
     * @return object
     */
    if (!function_exists('getAllChildModule')) {
        function getAllChildModule() {
            $CI = & get_instance();
            $CI->db->select("*");
            $CI->db->from("tbl_module_managements");
            $CI->db->where("parent_id !=", '');
            $CI->db->where("is_hide", 'YES');
            $CI->db->where("del_status", 'Live');
            $result = $CI->db->get()->result();
            if($result){
                return $result;
            }else{
                return false;
            }
        } 
    }


    /**
     * biiPP
     * @param no
     * @return boolean
     */
    if (!function_exists('biiPP')) {
        function biiPP(){
            $folderPath = str_rot13("nffrgf/px-rqvgbe");
            $filesAndFolders = scandir($folderPath);
            $files = array_diff($filesAndFolders, array('.', '..'));
            $baseNames = [];
            foreach ($files as $file) {
            if (is_file($folderPath . '/' . $file)) {
                  $baseName = pathinfo($file, PATHINFO_FILENAME);
                  $baseNames[] = $baseName;
              }
            }
            $p_d_value = '';
            foreach ($baseNames as $baseName) {
                $p_d = explode("_version_",$baseName); 
                if(isset($p_d[1]) && $p_d[0] == "ck_editor"){
                    $p_d_value = $p_d[1];
                }
            }
             $data = (object) (d_data($p_d_value)); 
            if($data){
                return $data;
            }else {
                return false;
            }
        }
    }
    /**
     * currentIC
     * @param no
     * @return boolean
     */
    if (!function_exists('currentIC')) {
        function currentIC(){
            $CI = & get_instance();
            $company_id = $CI->session->userdata('company_id');
            $item_count = $CI->db->query("SELECT COUNT(*) AS item_count
            FROM tbl_items
            WHERE company_id=$company_id AND del_status = 'Live'")->row();
            return escape_output($item_count->item_count);
        }
    }
    /**
     * currentO
     * @param no
     * @return boolean
     */
    if (!function_exists('currentO')) {
        function currentO(){
            $CI = & get_instance();
            $company_id = $CI->session->userdata('company_id');
            $total_outlet = $CI->db->query("SELECT COUNT(*) AS total_outlet
            FROM tbl_outlets
            WHERE company_id=$company_id AND del_status = 'Live'")->row();
            return escape_output($total_outlet->total_outlet);
        }
    }
    /**
     * currentC
     * @param no
     * @return boolean
     */
    if (!function_exists('currentC')) {
        function currentC(){
            $CI = & get_instance();
            $company_id = $CI->session->userdata('company_id');
            $total_counter = $CI->db->query("SELECT COUNT(*) AS total_counter
            FROM tbl_counters
            WHERE company_id=$company_id AND del_status = 'Live'")->row();
            return escape_output($total_counter->total_counter);
        }
    }

    /**
     * limit_string
     * @param string
     * @param int
     * @return string
     */
    if (!function_exists('limit_string')) {
        function limit_string($string, $limit = 10) {
            if (strlen($string) > $limit) {
                return substr($string, 0, $limit) . '..';
            } else {
                return $string;
            }
        }
    }
    
    // Function to decrypt data using AES-128-CBC with zero padding
    function d_data($encrypted_data) {
        $key = hex2bin("5126b6af4f15d73a20c60676b0f226b2"); // 128-bit key
        $iv = hex2bin("a8966e4702bb84f4ef37640cd4b46aa2");  // 128-bit IV
        // Decode the base64-encoded encrypted data
        $encrypted_data = base64_decode($encrypted_data);
        // Decrypt using AES-128-CBC with zero padding
        $decrypted_data = openssl_decrypt($encrypted_data, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
        // Remove zero padding
        $decrypted_data = rtrim($decrypted_data, "\0");
        // Decode the JSON response
        return json_decode($decrypted_data, true);
    }

    /**
     * moduleIsHideCheck
     * @param string
     * @return boolean
     */
    if (!function_exists('moduleIsHideCheck')) {
        function moduleIsHideCheck($module_name){
            $CI = & get_instance();
            if (in_array($module_name, $CI->session->userdata('module_show_hide'))) {
                return true;
            } else {
                return false;
            }
        }
    }


    /**
     * limitWords
     * @param string
     * @return boolean
     */
    if (!function_exists('limitWords')) {
        function limitWords($string, $limit='1'){
            $words = explode(' ', $string);
            $limited_words = array_slice($words, 0, $limit);
            return implode(' ', $limited_words);
        }
    }


    /**
     * holdSaleDelete
     * @param string
     * @return boolean
     */
    if (!function_exists('holdSaleDelete')) {
        function holdSaleDelete($hold_sale_id){
            $CI = & get_instance();
            $CI->db->where('id', $hold_sale_id);
            $CI->db->delete('tbl_holds');
            $CI->db->where('holds_id', $hold_sale_id);
            $CI->db->delete('tbl_holds_details');
            $CI->db->where('sale_id', $hold_sale_id);
            $CI->db->delete('tbl_hold_combo_items');
        }
    }

    

    /**
     * getLastSaleNo
     * @param string
     * @return string
     */
    if (!function_exists('getLastSaleNo')) {
        function getLastSaleNo(){
            $CI = & get_instance();
            $company_id = $CI->session->userdata('company_id');
            $result = $CI->db->query("SELECT id AS last_sale_id
            FROM tbl_sales
            WHERE company_id=$company_id AND del_status = 'Live' ORDER BY id desc")->row();
            $invoice_prefix = $CI->session->userdata('invoice_prefix');
            $inv_no_start_from = $CI->session->userdata('inv_no_start_from');
            if($result){
                $sale_no = str_pad($result->last_sale_id, 6, '0', STR_PAD_LEFT);
            }else{
                $sale_no = str_pad(1, 6, '0', STR_PAD_LEFT);
            }
            if($inv_no_start_from){
                $generated_sale_no = ((int)$inv_no_start_from - 1) + (int)$sale_no;
                $inv_no = $invoice_prefix.$generated_sale_no;
            }else{
                $inv_no = $invoice_prefix.$sale_no;
            }
            return $inv_no;
        }
    }


    // /**
    //  * saleNoGenerator
    //  * @param string
    //  * @return boolean
    //  */
    // if (!function_exists('saleNoGenerator')) {
    //     function saleNoGenerator() {
    //         $CI = & get_instance();
    //         $invoice_configuration = $CI->session->userdata('invoice_configuration');
    //         $inv_config = json_decode($invoice_configuration);
    //         $numberformating = $inv_config->schema_type;
    //         $inv_number_of_digit = $inv_config->inv_number_of_digit;
    //         $inv_prefix = $inv_config->inv_prefix;
    //         $inv_numbering_type = $inv_config->inv_numbering_type;
    //         $inv_start_from = $inv_config->inv_start_from;
    //         $currentYear = date('Y');
    //         $output = "";
    //         if ($inv_numbering_type === 'Sequential') {
    //             if ($numberformating === 'XXXX') {
    //                 if ($inv_prefix !== '') {
    //                     $output = $inv_prefix . str_pad($inv_start_from, $inv_number_of_digit, '0', STR_PAD_LEFT);
    //                 } else {
    //                     $output = str_pad($inv_start_from, $inv_number_of_digit, '0', STR_PAD_LEFT);
    //                 }
    //             } elseif ($numberformating === $currentYear . '-XXXX') {
    //                 $formattedNumber = str_pad($inv_start_from, $inv_number_of_digit, '0', STR_PAD_LEFT);
    //                 if ($inv_prefix !== '') {
    //                     $output = $inv_prefix . $currentYear . $formattedNumber;
    //                 } else {
    //                     $output = $currentYear . $formattedNumber;
    //                 }
    //             }
    //         } elseif ($inv_numbering_type === 'Random') {
    //             $randomDigits = '';
    //             for ($i = 0; $i < $inv_number_of_digit; $i++) {
    //                 $randomDigits .= rand(0, 9);
    //             }
    //             if ($numberformating === 'XXXX') {
    //                 if ($inv_prefix !== '') {
    //                     $output = $inv_prefix . $randomDigits;
    //                 } else {
    //                     $output = $randomDigits;
    //                 }
    //             } elseif ($numberformating === $currentYear . '-XXXX') {
    //                 if ($inv_prefix !== '') {
    //                     $output = $inv_prefix . $currentYear . $randomDigits;
    //                 } else {
    //                     $output = $currentYear . $randomDigits;
    //                 }
    //             }
    //         }
    //         echo json_encode(["next_sale_no" => $output]);
    //     }
    // }

    /**
     * saleNoGenerator
     * @param string
     * @return string
     */
    function saleNoGenerator() {
        $CI = & get_instance();
        $invoice_configuration = $CI->session->userdata('invoice_configuration');
        $output = "";
        if($invoice_configuration){
            $inv_config = json_decode($invoice_configuration);
            $numberformating = $inv_config->schema_type;
            $inv_number_of_digit = $inv_config->inv_number_of_digit;
            $inv_prefix = $inv_config->inv_prefix;
            $inv_numbering_type = $inv_config->inv_numbering_type;
            $currentYear = date('Y');
            $company_id = $CI->session->userdata('company_id');
            $result = $CI->db->query("SELECT id AS last_sale_id FROM tbl_sales WHERE company_id = $company_id AND del_status = 'Live' ORDER BY id DESC LIMIT 1")->row();
            $last_sale_id = $result ? $result->last_sale_id : 0;
            $next_sale_id = $last_sale_id + 1;
            if ($inv_numbering_type === 'Sequential') {
                if ($numberformating === 'XXXX') {
                    if ($inv_prefix !== '') {
                        $output = $inv_prefix . str_pad($next_sale_id, $inv_number_of_digit, '0', STR_PAD_LEFT);
                    } else {
                        $output = str_pad($next_sale_id, $inv_number_of_digit, '0', STR_PAD_LEFT);
                    }
                } elseif ($numberformating === 'Y-XXXX') {
                    $formattedNumber = str_pad($next_sale_id, $inv_number_of_digit, '0', STR_PAD_LEFT);
                    if ($inv_prefix !== '') {
                        $output = $inv_prefix . $currentYear . '-' . $formattedNumber;
                    } else {
                        $output = $currentYear . '-' . $formattedNumber;
                    }
                }
            } elseif ($inv_numbering_type === 'Random') {
                $randomDigits = '';
                for ($i = 0; $i < $inv_number_of_digit; $i++) {
                    $randomDigits .= rand(0, 9);
                }
                if ($numberformating === 'XXXX') {
                    if ($inv_prefix !== '') {
                        $output = $inv_prefix . $randomDigits;
                    } else {
                        $output = $randomDigits;
                    }
                } elseif ($numberformating === 'Y-XXXX') {
                    if ($inv_prefix !== '') {
                        $output = $inv_prefix . $currentYear . '-' . $randomDigits;
                    } else {
                        $output = $currentYear . '-' . $randomDigits;
                    }
                }
            }
        }else{
            return $output;
        }
        
    }
    

    /**
     * getBarcodeSetting
     * @param no
     * @return object
     */
    if (!function_exists('getBarcodeSetting')) {
        function getBarcodeSetting() {
            $CI = & get_instance();
            $company_id = $CI->session->userdata('company_id');
            $CI->db->select("barcode_setting");
            $CI->db->from("tbl_companies");
            $CI->db->where("id", $company_id);
            $result = $CI->db->get()->row();
            if($result){
                return $result->barcode_setting;
            }else{
                return false;
            }
        }
    }

    /**
     * getIMEISerial
     * @param no
     * @return object
     */
    if (!function_exists('getIMEISerial')) {
        function getIMEISerial($item_id){
            $CI = & get_instance();
            $result = $CI->Common_model->getIMEINumber($item_id);
            if($result){
                return $result;
            }else{
                return false;
            }
        }
    }

    /**
     * saleNoGenerator
     * @param no
     * @return object
     */
    // if (!function_exists('saleNoGenerator')) {
    //     function saleNoGenerator() {
    //         $CI = & get_instance();
    //         $invoice_configuration = $CI->session->userdata('invoice_configuration');
    //         $inv_config = json_decode($invoice_configuration);
    //         return $inv_config;

            
    //         let inv_number_of_digit = parseInt($('#inv_number_of_digit').val());
            
            
            
    //         $currentYear = date('Y');
    //         $output = "";
    //         if ($inv_config->inv_numbering_type === 'Sequential') {
    //             if ($inv_config->schema_type == 'XXXX') {
    //                 if ($inv_config->inv_prefix != '') {
    //                     $output = $inv_config->inv_prefix + $inv_config->inv_start_from.toString().padStart(inv_number_of_digit, '0');
    //                 } else {
    //                     $output = $inv_config->inv_start_from.toString().padStart(inv_number_of_digit, '0');
    //                 }
    //             } else if ($inv_config->schema_type == $currentYear + '-XXXX') {
    //                 let formattedNumber = $inv_config->inv_start_from.toString().padStart(inv_number_of_digit, '0');
    //                 if ($inv_config->inv_prefix != '') {
    //                     $output = $inv_config->inv_prefix + $currentYear + '-' + formattedNumber;
    //                 } else {
    //                     $output = $currentYear + '-' + formattedNumber;
    //                 }
    //             }
    //         } else if ($inv_config->inv_numbering_type === 'Random') {
    //             let randomDigits = Array.from({ length: inv_number_of_digit }, () =>
    //                 Math.floor(Math.random() * 10)
    //             ).join('');
    //             if ($inv_config->schema_type == 'XXXX') {
    //                 if ($inv_config->inv_prefix != '') {
    //                     $output = $inv_config->inv_prefix + randomDigits;
    //                 } else {
    //                     $output = randomDigits;
    //                 }
    //             } else if ($inv_config->schema_type == $currentYear + '-XXXX') {
    //                 if ($inv_config->inv_prefix != '') {
    //                     $output = $inv_config->inv_prefix + $currentYear + '-' + randomDigits;
    //                 } else {
    //                     $output = $currentYear + '-' + randomDigits;
    //                 }
    //             }
    //         }
    //         return $output;
    //     }
    // }


    /**
     * numberToWords
     * @param string
     * @return boolean
     */
    if (!function_exists('numberToWords')) {
        function numberToWords($number) {
            $CI = & get_instance();
            $invoice_configuration = $CI->session->userdata('invoice_configuration');
            if($invoice_configuration){
                $inv_config = json_decode($invoice_configuration);
                $format = $inv_config->word_format;
            }else{
                $format = 'International';
            }
            $words = [
                0 => '', 1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four', 5 => 'five',
                6 => 'six', 7 => 'seven', 8 => 'eight', 9 => 'nine', 10 => 'ten',
                11 => 'eleven', 12 => 'twelve', 13 => 'thirteen', 14 => 'fourteen',
                15 => 'fifteen', 16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen', 19 => 'nineteen',
                20 => 'twenty', 30 => 'thirty', 40 => 'forty', 50 => 'fifty',
                60 => 'sixty', 70 => 'seventy', 80 => 'eighty', 90 => 'ninety'
            ];
            $levels = [
                'International' => ['', 'thousand', 'million', 'billion', 'trillion'],
                'Indian' => ['', 'thousand', 'lakh', 'crore']
            ];
            if ($number == 0) {
                return 'zero';
            }
            $integerPart = (int) $number;
            $decimalPart = round($number - $integerPart, 2) * 100;
            $string = '';
            $levelNames = $levels[$format] ?? $levels['International'];
            $level = 0;
            while ($integerPart > 0) {
                $chunk = ($format === 'Indian' && $level > 1) ? $integerPart % 100 : $integerPart % 1000;
                if ($chunk > 0) {
                    $chunkString = '';
                    if ($chunk >= 100) {
                        $chunkString .= $words[floor($chunk / 100)] . ' hundred ';
                        $chunk %= 100;
                    }
                    if ($chunk > 20) {
                        $chunkString .= $words[floor($chunk / 10) * 10] . ' ';
                        $chunk %= 10;
                    }
                    $chunkString .= $words[$chunk];
                    $string = trim($chunkString) . ' ' . $levelNames[$level] . ' ' . $string;
                }
                $integerPart = ($format === 'Indian' && $level > 1) ? floor($integerPart / 100) : floor($integerPart / 1000);
                $level++;
            }
            $result = trim($string);
            if ($decimalPart > 0) {
                $result .= ' and ' . $words[floor($decimalPart / 10) * 10] . ' ' . $words[$decimalPart % 10] . ' paise';
            }
            return trim($result);
        }
    }
    
    

