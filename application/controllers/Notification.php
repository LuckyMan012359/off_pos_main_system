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
    # This is Notification Controller
    ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends Cl_Controller {


    /**
     * load constructor
     * @access public
     * @return void
     */    
    public function __construct() {
        parent::__construct();
        $this->load->model('Authentication_model');
        $this->load->model('Common_model');
        $this->load->library('form_validation');
        $this->Common_model->setDefaultTimezone();
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        if (!$this->session->has_userdata('outlet_id')) {
            $this->session->set_flashdata('exception_2',lang('please_click_green_button'));
            $this->session->set_userdata("clicked_controller", $this->uri->segment(1));
            $this->session->set_userdata("clicked_method", $this->uri->segment(2));
            redirect('Outlet/outlets');
        }
    }

    /**
     * notificationsAjax
     * @access public
     * @param no
     * @return json
     */
    public function notificationsAjax(){
        $notifications = $this->Common_model->getAllNotification();
        $countNotification = $this->Common_model->getNotificationCount();
        $response = [
            'status' => 'success',
            'data' => $notifications,
            'count' => $countNotification,
        ];	
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }


    /**
     * unreadNotificationsAjax
     * @access public
     * @param no
     * @return json
     */
    public function unreadNotificationsAjax(){
        $notifications = $this->Common_model->getDataByColumnValue('read_status', '0', "tbl_notifications");
        $response = [
            'status' => 'success',
            'data' => $notifications,
        ];	
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    /**
     * markAsAllReadNotificationsAjax
     * @access public
     * @param no
     * @return json
     */
    public function markAsAllReadNotificationsAjax(){
        $this->Common_model->markAsAllReadNotification();
        $response = [
            'status' => 'success',
        ];	
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    /**
     * deleteNotificationsAjax
     * @access public
     * @param no
     * @return json
     */
    public function deleteNotificationsAjax(){
        $notification_id = $this->input->post($this->security->xss_clean('notification_id'));
        $this->Common_model->hardDeleteById($notification_id, 'tbl_notifications');
        $response = [
            'status' => 'success',
        ];	
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }


    /**
     * readNotification
     * @access public
     * @param no
     * @return json
     */
    public function readNotification(){
        $notification_id = $this->input->post($this->security->xss_clean('notification_id'));
        $read_status = $this->input->post($this->security->xss_clean('read_status'));
        $company_id = $this->session->userdata('company_id');
        $this->Common_model->notificationReadById($read_status, $notification_id, $company_id);
        $response = [
            'status' => 'success',
        ];	
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

}
