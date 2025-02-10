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
  # This is Promotion Controller
  ###########################################################
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Promotion extends Cl_Controller {


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
        $this->load->model('Promotion_model');
        $this->Common_model->setDefaultTimezone();
        $this->load->library('form_validation');
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        if (!$this->session->has_userdata('outlet_id')) {
            $this->session->set_flashdata('exception_2', lang('please_click_green_button'));
            $this->session->set_userdata("clicked_controller", $this->uri->segment(1));
            $this->session->set_userdata("clicked_method", $this->uri->segment(2));
            redirect('Outlet/outlets');
        }
        //start check access function
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $controller = "133";
        $function = "";

        if($segment_2=="addEditPromotion" ){
            $function = "add";
        }elseif($segment_2=="addEditPromotion" && $segment_3){
            $function = "edit";
        }elseif($segment_2=="deletePromotion"){
            $function = "delete";
        }elseif($segment_2=="promotions"){
            $function = "list";
        }else{
            $this->session->set_flashdata('exception_1', lang('no_access'));
            redirect('Authentication/userProfile');
        }
        if(!checkAccess($controller,$function)){
            $this->session->set_flashdata('exception_1', lang('no_access'));
            redirect('Authentication/userProfile');
        }
    }

    /**
     * add/Edit Promotion
     * @access public
     * @param int
     * @return void
     */
    public function addEditPromotion($encrypted_id = "") {
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        $outlet_id = $this->session->userdata('outlet_id');
        $company_id = $this->session->userdata('company_id');

        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $add_more = $this->input->post($this->security->xss_clean('add_more'));
            $this->form_validation->set_rules('type', lang('type'), 'required|max_length[50]');
            $this->form_validation->set_rules('title', lang('title'), 'required|max_length[255]');
            $this->form_validation->set_rules('start_date', lang('start_date'), 'required|max_length[50]');
            $this->form_validation->set_rules('end_date', lang('end_date'), 'required|max_length[50]');
            $type = htmlspecialcharscustom($this->input->post($this->security->xss_clean('type')));
            if($type=="1"){
                $this->form_validation->set_rules('food_menu_id', lang('item'), 'required|max_length[50]');
                $this->form_validation->set_rules('discount', lang('discount_pro'), 'required|max_length[11]');
            }else if($type=="2"){
                $this->form_validation->set_rules('buy_food_menu_id', lang('buy'), 'required|max_length[50]');
                $this->form_validation->set_rules('qty', lang('buy').' '.lang('quantity'), 'required|max_length[50]');
                $this->form_validation->set_rules('get_food_menu_id', lang('get'), 'required|max_length[50]');
                $this->form_validation->set_rules('get_qty', lang('get').' '.lang('quantity'), 'required|max_length[50]');
            }else if($type == "3"){
                $this->form_validation->set_rules('discount', lang('discount_pro'), 'required|max_length[11]');
                $this->form_validation->set_rules(
                    'coupon_code', 
                    lang('coupon_code'), 
                    'required|regex_match[#^(?=(?:\D*\d){2})(?=(?:\d*\D){2})[a-zA-Z0-9]{4}$#]',
                    array(
                        'required' => lang('The') . ' %s ' . lang('field_is_required'),
                        'regex_match' => lang('The') . ' %s ' . lang('coupon_validation_err'),
                    )
                );
            }
            if ($this->form_validation->run() == TRUE) {
                $promotion_info = array();
                $promotion_info['type'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('type')));
                $promotion_info['title'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('title')));
                $promotion_info['start_date'] = $this->input->post($this->security->xss_clean('start_date'));
                $promotion_info['end_date'] = $this->input->post($this->security->xss_clean('end_date'));
                $promotion_info['status'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('status')));
                $food_menu_checking_id = '';
                if($type=="1"){
                    $promotion_info['food_menu_id'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('food_menu_id')));
                    $promotion_info['discount'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('discount')));
                    $food_menu_checking_id = $promotion_info['food_menu_id'];

                    $promotion_info['coupon_code'] = NULL;
                    $promotion_info['qty'] = NULL;
                    $promotion_info['get_food_menu_id'] = NULL;
                    $promotion_info['get_qty'] = NULL;

                }else if($type=="2"){
                    $promotion_info['food_menu_id'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('buy_food_menu_id')));
                    $promotion_info['qty'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('qty')));
                    $promotion_info['get_food_menu_id'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('get_food_menu_id')));
                    $promotion_info['get_qty'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('get_qty')));
                    $food_menu_checking_id = $promotion_info['food_menu_id'];

                    $promotion_info['coupon_code'] = NULL;
                    $promotion_info['discount'] = NULL;
                } else if($type == "3"){
                    $promotion_info['coupon_code'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('coupon_code')));
                    $promotion_info['discount'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('discount')));

                    $promotion_info['food_menu_id'] = NULL;
                    $promotion_info['qty'] = NULL;
                    $promotion_info['get_food_menu_id'] = NULL;
                    $promotion_info['get_qty'] = NULL;
                }
                $promotion_info['user_id'] = $this->session->userdata('user_id');
                $promotion_info['outlet_id'] = $this->session->userdata('outlet_id');
                $promotion_info['company_id'] = $this->session->userdata('company_id');
                if ($id == "") {
                    $checker = $this->Promotion_model->checkPromotionWithinDate($promotion_info['start_date'],$promotion_info['end_date'],$food_menu_checking_id);
                    if(isset($checker) && $checker){
                        $this->session->set_flashdata('exception_err',lang('exception_exist_pro'));
                        redirect('Promotion/promotions');
                    }
                    $promotion_info['added_date'] = date('Y-m-d H:i:s');
                    $this->Common_model->insertInformation($promotion_info, "tbl_promotions");
                    $this->session->set_flashdata('exception', lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($promotion_info, $id, "tbl_promotions");
                    $this->session->set_flashdata('exception',lang('update_success'));
                }
                if($add_more == 'add_more'){
                    redirect('Promotion/addEditPromotion');
                }else{
                    redirect('Promotion/promotions');
                }
                
            } else {
                if ($id == "") {
                    $data = array();
                    $data['items'] = $this->Common_model->getAllItemNameCodeWithoutVariation();
                    $data['main_content'] = $this->load->view('promotion/addPromotion', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['items'] = $this->Common_model->getAllItemNameCodeWithoutVariation();
                    $data['promotion_details'] = $this->Common_model->getDataById($id, "tbl_promotions");
                    $data['main_content'] = $this->load->view('promotion/editPromotion', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['items'] = $this->Common_model->getAllItemNameCodeWithoutVariation();
                $data['main_content'] = $this->load->view('promotion/addPromotion', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['items'] = $this->Common_model->getAllItemNameCodeWithoutVariation();
                $data['promotion_details'] = $this->Common_model->getDataById($id, "tbl_promotions");
                $data['main_content'] = $this->load->view('promotion/editPromotion', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }


    /**
     * deletePromotion
     * @access public
     * @param int
     * @return void
     */
    public function deletePromotion($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $this->Common_model->deleteStatusChange($id, "tbl_promotions");
        $this->session->set_flashdata('exception', lang('delete_success'));
        redirect('Promotion/promotions');
    }

        
    /**
     * promotions
     * @access public
     * @param no
     * @return void
     */
    public function promotions() {
        $outlet_id = $this->session->userdata('outlet_id');
        $data = array();
        $data['promotions'] = $this->Common_model->getAllByOutletId($outlet_id, "tbl_promotions");
        $data['main_content'] = $this->load->view('promotion/promotions', $data, TRUE);
        $this->load->view('userHome', $data);
    }
}
