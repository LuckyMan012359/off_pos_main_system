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
    # This is Damage Controller
    ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Damage extends Cl_Controller {


    /**
     * load constructor
     * @access public
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('Authentication_model');
        $this->load->model('Common_model');
        $this->load->model('Stock_model');
        $this->load->model('Damage_model');
        $this->Common_model->setDefaultTimezone();
        $this->load->library('form_validation');
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        if (!$this->session->has_userdata('outlet_id')) {
            $this->session->set_flashdata('exception_2',lang('please_click_green_button'));
            $this->session->set_userdata("clicked_controller", $this->uri->segment(1));
            $this->session->set_userdata("clicked_method", $this->uri->segment(2));
            redirect('Outlet/outlets');
        }
        //start check access function
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $controller = "166";
        $function = "";

        if(($segment_2=="addEditDamage") || ($segment_2 == "stockCheck")){
            $function = "add";
        }elseif(($segment_2=="addEditDamage" && $segment_3) || ($segment_2 == "stockCheck")){
            $function = "edit";
        }elseif($segment_2=="damageDetails"){
            $function = "view";
        }elseif($segment_2=="deleteDamage"){
            $function = "delete";
        }elseif($segment_2=="damages" || $segment_2 == "getAjaxData"){
            $function = "list";
        }else{
            $this->session->set_flashdata('exception_1',lang('no_access'));
            redirect('Authentication/userProfile');
        }
        if(!checkAccess($controller,$function)){
            $this->session->set_flashdata('exception_1',lang('no_access'));
            redirect('Authentication/userProfile');
        }
        //end check access function
    }


    /**
     * addEditDamage
     * @access public
     * @param int
     * @return void
     */
    public function addEditDamage($encrypted_id = "") {
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        $outlet_id = $this->session->userdata('outlet_id');
        $company_id = $this->session->userdata('company_id');
        $damage_info = array();
        if ($id == "") {
            $damage_info['reference_no'] = $this->Damage_model->generateDamageRefNo($outlet_id);
        } else {
            $damage_info['reference_no'] = $this->Common_model->getDataById($id, "tbl_damages")->reference_no;
        }
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $add_more = $this->input->post($this->security->xss_clean('add_more'));
            $this->form_validation->set_rules('date', lang('date'), 'required|max_length[50]');
            $this->form_validation->set_rules('total_loss', lang('total_loss'), 'required|numeric|max_length[11]');
            $this->form_validation->set_rules('note', lang('note'), 'max_length[255]');
            $this->form_validation->set_rules('employee_id',lang('responsible_person'), 'required|numeric|max_length[11]');
            if ($this->form_validation->run() == TRUE) {
                $damage_info = array();
                $damage_info['reference_no'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('reference_no')));
                $damage_info['date'] = $this->input->post($this->security->xss_clean('date'));
                $damage_info['total_loss'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('total_loss')));
                $damage_info['note'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('note')));
                $damage_info['employee_id'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('employee_id')));
                $damage_info['user_id'] = $this->session->userdata('user_id');
                $damage_info['outlet_id'] = $this->session->userdata('outlet_id'); 
                $damage_info['company_id'] = $this->session->userdata('company_id'); 
                if ($id == "") {
                    $damage_info['added_date'] = date('Y-m-d H:i:s');
                    $damage_id = $this->Common_model->insertInformation($damage_info, "tbl_damages");
                    $this->saveDamageDetails($_POST['item_id'], $damage_id, 'tbl_damage_details');
                    $this->session->set_flashdata('exception', lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($damage_info, $id, "tbl_damages");
                    $this->Common_model->deletingMultipleFormData('damage_id', $id, 'tbl_damage_details');
                    $this->saveDamageDetails($_POST['item_id'], $id, 'tbl_damage_details');
                    $this->session->set_flashdata('exception',lang('update_success'));
                }
                if($add_more == 'add_more'){
                    redirect('Damage/addEditDamage');
                }else{
                    redirect('Damage/damages');
                }

            } else {
                if ($id == "") {
                    $data = array();
                    $data['reference_no'] = $this->Damage_model->generateDamageRefNo($outlet_id);
                    $data['items'] = $this->Common_model->getItemWithVariationForDrowdown();
                    $data['employees'] = $this->Common_model->getAllUsersNameMobile();
                    $data['main_content'] = $this->load->view('damage/addDamage', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['items'] = $this->Common_model->getItemWithVariationForDrowdown();
                    $data['employees'] = $this->Common_model->getAllUsersNameMobile();
                    $data['damage_details'] = $this->Common_model->getDataById($id, "tbl_damages");
                    $data['damage_items'] = $this->Damage_model->getDamageItems($id);
                    $data['main_content'] = $this->load->view('damage/editDamage', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['reference_no'] = $this->Damage_model->generateDamageRefNo($outlet_id);
                $data['items'] = $this->Common_model->getItemWithVariationForDrowdown();
                $data['employees'] = $this->Common_model->getAllUsersNameMobile();
                $data['main_content'] = $this->load->view('damage/addDamage', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['items'] = $this->Common_model->getItemWithVariationForDrowdown();
                $data['employees'] = $this->Common_model->getAllUsersNameMobile();
                $data['damage_details'] = $this->Common_model->getDataById($id, "tbl_damages");
                $data['damage_items'] = $this->Damage_model->getDamageItems($id);
                $data['main_content'] = $this->load->view('damage/editDamage', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }


    /**
     * saveDamageDetails
     * @access public
     * @param string
     * @param int
     * @param string
     * @return void
     */
    public function saveDamageDetails($damage_items, $damage_id, $table_name) {
        foreach ($damage_items as $row => $item_id):
            $fmi = array();
            $fmi['item_id'] = $item_id;
            $fmi['date'] = date('Y-m-d');
            $fmi['damage_quantity'] = $_POST['damage_quantity'][$row];
            $fmi['last_purchase_price'] = $_POST['last_purchase_price'][$row];
            $fmi['loss_amount'] = $_POST['loss_amount'][$row];
            $fmi['total_amount'] = $_POST['total_amount'][$row];
            $fmi['damage_id'] = $damage_id;
            $fmi['item_type'] = $_POST['item_type'][$row];
            if (isset($_POST['expiry_imei_serial'])){
                $fmi['expiry_imei_serial'] = $_POST['expiry_imei_serial'][$row];
            }
            $fmi['outlet_id'] = $this->session->userdata('outlet_id');
            $fmi['company_id'] = $this->session->userdata('company_id');
            $this->Common_model->insertInformation($fmi, "tbl_damage_details");
        endforeach;
    }


    /**
     * DamageDetails
     * @access public
     * @param int
     * @return void
     */
    public function damageDetails($id) {
        $encrypted_id = $id;
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $data = array();
        $data['encrypted_id'] = $encrypted_id;
        $data['damage_details'] = $this->Common_model->getDataById($id, "tbl_damages");
        $data['damage_items'] = $this->Damage_model->getDamageItems($id);
        $data['main_content'] = $this->load->view('damage/damageDetails', $data, TRUE);
        $this->load->view('userHome', $data);
    }


    /**
     * deleteDamage
     * @access public
     * @param int
     * @return void
     */
    public function deleteDamage($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $this->Common_model->deleteStatusChangeWithChild($id, $id, "tbl_damages", "tbl_damage_details", 'id', 'damage_id');
        $this->session->set_flashdata('exception', lang('delete_success'));
        redirect('Damage/damages');
    }

    /**
     * damages
     * @access public
     * @param no
     * @return void
     */
    public function damages() {
        $outlet_id = $this->session->userdata('outlet_id');
        $data = array();
        $data['damages'] = $this->Common_model->getAllByOutletId($outlet_id, "tbl_damages");
        $data['main_content'] = $this->load->view('damage/damages', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    
    /**
     * getAjaxData
     * @access public
     * @param no
     * @return json
     */
    public function getAjaxData() {
        $company_id = $this->session->userdata('company_id');
        $damages = $this->Damage_model->make_datatables($company_id);
        if ($damages && !empty($damages)) {
            $i = count($damages);
        }
        $data = array();
        foreach($damages as $damage){
            $sub_array = array();
            $sub_array[] = $i--;
            $sub_array[] = escape_output($damage->reference_no);
            $sub_array[] = dateFormat($damage->date);
            $sub_array[] = getAmtCustom($damage->total_loss);
            $sub_array[] = getAmtPCustom($damage->total_items);
            $sub_array[] = escape_output($damage->responsible_person);
            $sub_array[] = escape_output($damage->note);
            $sub_array[] = escape_output($damage->added_by);
            $sub_array[] = dateFormat($damage->added_date);
            $html = '';
            $html .= ' <a class="btn btn-cyan" href="'.base_url().'Damage/damageDetails/'.($this->custom->encrypt_decrypt($damage->id, 'encrypt')).'" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="'. lang('view_details') .'">
            <i class="far fa-eye"></i></a>';
            $html .= ' <a class="btn btn-warning" href="'.base_url().'Damage/addEditDamage/'.($this->custom->encrypt_decrypt($damage->id, 'encrypt')).'" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="'. lang('edit') .'">
                    <i class="far fa-edit"></i></a>';
            $html .= ' <a class="delete btn btn-danger" href="'.base_url().'Damage/deleteDamage/'.($this->custom->encrypt_decrypt($damage->id, 'encrypt')).'" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="'. lang('delete') .'">
            <i class="fa-regular fa-trash-can"></i></a>';
            $sub_array[] = '
            <div class="btn_group_wrap">
                '. $html .'
            </div>';
            $data[] = $sub_array;
        }
        $output = array(
            "recordsTotal" => $this->Damage_model->get_all_data($company_id),
            "recordsFiltered" => $this->Damage_model->get_filtered_data($company_id),
            "data" => $data
        );
        echo json_encode($output);
    }


    
    /**
     * stockCheck
     * @access public
     * @param int
     * @return json
     */
    public function stockCheck($id){
        $stock = $this->Stock_model->getStock('', $id, '','','');
        $totalStock = 0;
        if (!empty($stock) && isset($stock)):
            foreach ($stock as $key => $value):
                $i_sale = $this->session->userdata('i_sale');
                $total_installment_sale = 0;
                if(isset($i_sale) && $i_sale=="Yes"){
                    $total_installment_sale = $value->total_installment_sale;
                }
                $totalStock = ($value->total_purchase * $value->conversion_rate) - $total_installment_sale - $value->total_damage - $value->total_sale  - $value->total_purchase_return + $value->total_sale_return  + $value->total_opening_stock;
            endforeach;
        endif;
        echo json_encode($totalStock);
    }



}
