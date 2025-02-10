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
    # This is Attendance Controller
    ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance extends Cl_Controller {

    /**
     * load constructor
     * @access public
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('Authentication_model');
        $this->load->model('Common_model'); 
        $this->load->model('Attendance_model');
        $this->load->library('form_validation');
        $this->Common_model->setDefaultTimezone();
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        //start check access function
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $controller = "234";
        $function = "";
        if($segment_2=="addEditAttendance"){
            $function = "add";
        }elseif($segment_2=="addEditAttendance" && $segment_3){
            $function = "edit";
        }elseif($segment_2=="deleteAttendance"){
            $function = "delete";
        }elseif($segment_2=="attendances"){
            $function = "list";
        }else{
            $this->session->set_flashdata('exception_1',lang('no_access'));
            redirect('Authentication/userProfile');
        }
        if(!checkAccess($controller,$function)){
            $this->session->set_flashdata('exception_1',lang('no_access'));
            redirect('Authentication/userProfile');
        }
    }



    /**
     * addEditAttendance
     * @access public
     * @param int
     * @return void
     */
    public function addEditAttendance($encrypted_id='') { 
        $encrypted_id = $encrypted_id;
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt'); 
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $add_more = $this->input->post($this->security->xss_clean('add_more'));
            $this->form_validation->set_rules('reference_no',lang('ref_no'), 'required|max_length[50]');
            $this->form_validation->set_rules('employee_id', lang('employee'), 'required|max_length[50]');
            $this->form_validation->set_rules('date', lang('date'), 'required|max_length[50]');
            $this->form_validation->set_rules('in_time',lang('in_time'), 'required|max_length[50]');
            if ($encrypted_id != '') {
                $this->form_validation->set_rules('out_time', lang('out_time'), 'required|max_length[10]');
            } 
            $this->form_validation->set_rules('note', lang('note'), 'max_length[255]');
            if ($this->form_validation->run() == TRUE) {
                $information = array();
                $information['reference_no'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('reference_no')));
                $information['date'] = date("Y-m-d", strtotime($this->input->post($this->security->xss_clean('date'))));
                $information['employee_id'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('employee_id')));
                $information['in_time'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('in_time')));
                $information['out_time'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('out_time')));
                $information['note'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('note')));
                $information['user_id'] = $this->session->userdata('user_id');
                $information['company_id'] = $this->session->userdata('company_id');
                if ($id == "") {
                    $information['added_date'] = date('Y-m-d H:i:s');
                    $this->Common_model->insertInformation($information, "tbl_attendance");
                    $this->session->set_flashdata('exception', lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($information, $id, "tbl_attendance");
                    $this->session->set_flashdata('exception', lang('update_success'));
                }
                if($add_more == 'add_more'){
                    redirect('Attendance/addEditAttendance');
                }else{
                    redirect('Attendance/attendances');
                }
            } else {
                if ($id=='') {
                    $data = array();
                    $data['encrypted_id'] = '';
                    $data['reference_no'] = $this->Attendance_model->generateReferenceNo();
                    $data['customers'] = $this->Common_model->getAllByTable("tbl_users");
                    $data['employees'] = $this->Common_model->getAllByTable("tbl_users");
                    $data['main_content'] = $this->load->view('attendance/addEditAttendance', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id=='') { 
                $data = array();
                $data['encrypted_id'] = '';
                $data['reference_no'] = $this->Attendance_model->generateReferenceNo(); 
                $data['employees'] = $this->Common_model->getAllByTable("tbl_users");
                $data['main_content'] = $this->load->view('attendance/addEditAttendance', $data, TRUE); 
                $this->load->view('userHome', $data);
            }else{
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['reference_no'] = $this->Common_model->getDataById($id, 'tbl_attendance')->reference_no;
                $data['attendance_details'] = $this->Common_model->getDataById($id, 'tbl_attendance');
                $data['employees'] = $this->Common_model->getAllByTable("tbl_users");
                $data['main_content'] = $this->load->view('attendance/addEditAttendance', $data, TRUE); 
                $this->load->view('userHome', $data);
            }
            
        }
    } 
    
    /**
     * deleteAttendance
     * @access public
     * @param int
     * @return void
     */
    public function deleteAttendance($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $this->Common_model->deleteStatusChange($id, "tbl_attendance");
        $this->session->set_flashdata('exception', lang('delete_success'));
        redirect('Attendance/attendances');
    }

    /**
     * attendances
     * @access public
     * @param no
     * @return void
     */
    public function attendances() { 
        $company_id = $this->session->userdata('company_id');
        $data = array();
        $data['attendances'] = $this->Common_model->getAllByCompanyIdWithAddedBy($company_id,"tbl_attendance");
        $data['main_content'] = $this->load->view('attendance/attendances', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    
}
