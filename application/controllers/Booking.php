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
    # This is Booking Controller
    ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Booking extends Cl_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->model('Master_model');
        $this->Common_model->setDefaultTimezone();
        $this->load->library('form_validation');
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        //start check access function
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $controller = "350";
        $function = "";
        if($segment_2=="addBooking"){
            $function = "add";
        }elseif($segment_2=="editBooking" || $segment_2=="addBooking"){
            $function = "edit";
        }elseif($segment_2=="deleteBooking"){
            $function = "delete";
        }elseif($segment_2=="bookingData" || $segment_2 == 'booking' || $segment_2 == 'getAllBooking'){
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
     * bookingData
     * @access public
     * @return json
     * @param no
     */

    function bookingData(){
        $booking_data = getBookingData();
        foreach ($booking_data as $item) {
            $startDateTime = $item->start_date;
            $endDateTime = $item->end_date;
            $start_time = (new DateTime($startDateTime))->format('H:i');
            $end_time = (new DateTime($endDateTime))->format('H:i');
            $data[] = [
                "title" => $start_time . '-' . $end_time . ':' . $item->customer_name,
                "start" => $item->start_date,
                "end" => $item->end_date,
                "status" => $item->status,
                "id" => $item->id,
            ];
        }
        $response = [
            'status' => 'success',
            'message' => $data,
        ];
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }
    
    /**
     * addBooking
     * @access public
     * @return json
     * @param no
     */
    public function addBooking(){
        $this->form_validation->set_rules('outlet_id', lang('outlet'), 'required|integer');
        $this->form_validation->set_rules('customer_id', lang('customer'), 'required|integer');
        $this->form_validation->set_rules('service_seller_id', lang('employee'), 'required|integer');
        $this->form_validation->set_rules('start_date', lang('start_date'), 'required|max_length[35]');
        $this->form_validation->set_rules('end_date', lang('end_date'), 'required|max_length[35]');
        $this->form_validation->set_rules('status', lang('status'), 'required|max_length[25]');
        $this->form_validation->set_rules('note', lang('note'), 'max_length[300]');
        if ($this->form_validation->run() == TRUE) {
            $booking = array();
            $edit_booking_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('edit_booking_id')));
            $customer_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('customer_id')));
            $is_sent_invoice = htmlspecialcharscustom($this->input->post($this->security->xss_clean('is_sent_invoice')));
            $booking['outlet_id'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('outlet_id')));
            $booking['customer_id'] = $customer_id;
            $booking['service_seller_id'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('service_seller_id')));
            $booking['start_date'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('start_date')));
            $booking['end_date'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('end_date')));
            $booking['note'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('note')));
            $booking['status'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('status')));
            $booking['user_id'] = $this->session->userdata('user_id');
            $booking['company_id'] = $this->session->userdata('company_id');
            if($edit_booking_id){
                $id = $this->custom->encrypt_decrypt($edit_booking_id, 'decrypt');
                $this->Common_model->updateInformation($booking, $id, "tbl_bookings");
                $message = lang('update_success');
            }else{

                $booking['added_date'] = date('Y-m-d H:i:s');
                $id = $this->Common_model->insertInformation($booking, "tbl_bookings");
                $message = lang('insertion_success');
            }

            $booking = $this->Common_model->getSingleBookingData($id);


            if($is_sent_invoice){
                $customer_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('customer_id')));
                $customer_info = $this->Common_model->getCustomerById($customer_id);
                if($customer_info->email){
                    $mail_data = [];
                    $mail_data['to'] = ["$customer_info->email"];
                    $mail_data['subject'] = 'Booking confirmation';
                    $mail_data['customer_name'] = $customer_info->name; 
                    $mail_data['company_id'] = $this->session->userdata('company_id');
                    $mail_data['booking_data'] = $booking;
                    $mail_data['file_name'] = '';
                    $file_v_path2 = '';
                    $mail_data['file_path'] = '';
                    $mail_data['template'] = $this->load->view('mail-template/booking-template', $mail_data, TRUE);
                    $company = getCompanyInfo();
                    if($company->smtp_enable_status == 1){
                        if($company->smtp_type == "Sendinblue"){
                            sendInBlue($mail_data);
                        }else{
                            sendEmailOnly($mail_data['subject'],$mail_data['template'],$customer_info->email,$file_v_path2,$mail_data['file_name'], $company->id);
                        }
                    }else{
                        $this->session->set_flashdata('exception_1', lang('your_smtp_not_configured'));
                    }
                }
               
            }
            $response = [
                'status' => 'success',
                'message' => $message,
            ];
        }else{
            $response = [
                'status' => 'error',
                'errors' => [
                    'status' => form_error('status'),
                    'outlet_id' => form_error('outlet_id'),
                    'customer_id' => form_error('customer_id'),
                    'service_seller_id' => form_error('service_seller_id'),
                    'start_date' => form_error('start_date'),
                    'end_date' => form_error('end_date'),
                    'note' => form_error('note')
                ]
            ];
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
        
    }


    /**
     * editBooking
     * @access public
     * @return json
     * @param no
     */
    public function editBooking(){
        $book_id = $this->input->post($this->security->xss_clean('book_id'));
        if(ctype_digit($book_id)){
            $id = $book_id;
        }else{
            $id = $this->custom->encrypt_decrypt($book_id, 'decrypt');
        }
        $booking = $this->Common_model->getSingleBookingData($id);
        if($booking){
            $response = [
                'status' => 'success',
                'data' => $booking,
            ];
        }else{
            $response = [
                'status' => 'error',
                'data' => 'No data found!',
            ];
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }


    /**
     * deleteBooking
     * @access public
     * @return json
     * @param no
     */
    public function deleteBooking(){
        $book_id = $this->input->post($this->security->xss_clean('book_id'));
        $id = $this->custom->encrypt_decrypt($book_id, 'decrypt');
        $this->Common_model->deleteStatusChange($id, "tbl_bookings");
        $response = [
            'status' => 'success',
            'data' => lang('delete_success'),
        ];
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }


    /**
     * booking
     * @access public
     * @return void
     * @param no
     */
    function booking(){
        $company_id = $this->session->userdata('company_id');
        $data = array();
        $data['outlets'] = getDataByCompanyId($company_id, 'tbl_outlets'); 
        $data['customers'] = getDataByCompanyId($company_id, 'tbl_customers'); 
        $data['sellers'] = getDataByCompanyId($company_id, 'tbl_users'); 
        $data['booking'] = $this->Common_model->getAllBooking();
        $data['main_content'] = $this->load->view('booking/booking', $data, TRUE);
        $this->load->view('userHome', $data);
    }
    /**
     * getAllBooking
     * @access public
     * @return html
     * @param no
     */
    function getAllBooking()
    {
        $data = $this->Common_model->getAllBooking();
        $html = '<table id="datatable" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th class="width_p_5">'.lang('sn').'</th>
                <th class="width_p_20">'.lang('customer').'</th>
                <th>'.lang('outlet').'</th>
                <th class="width_p_5">'.lang('service_seller').'</th>
                <th class="width_p_5">'.lang('start_date_time').'</th>
                <th class="width_p_5">'.lang('end_date_time').'</th>
                <th class="width_p_5">'.lang('added_by').'</th>
                <th class="width_p_5">'.lang('added_date').'</th>
                <th class="width_p_25">'.lang('actions').'</th>
            </tr>
        </thead>
        <tbody>';
            $i = count($data);
            foreach ($data as $value){
                $html.='<tr> 
                    <td>'.$i--.'</td>
                    <td>'.$value->customer_name.'</td>
                    <td>'.$value->outlet_name.'</td>
                    <td>'.$value->service_seller_name.'</td>
                    <td>'.$value->start_date.'</td>
                    <td>'.$value->end_date.'</td>
                    <td>'.$value->added_by.'</td>
                    <td>'.date($this->session->userdata('date_format'), strtotime($value->added_date != '' ? $value->added_date : '')).'</td>
                    <td>
                        <div class="btn_group_wrap">
                            <a class="btn btn-warning edit_booking" data-id="'.$this->custom->encrypt_decrypt($value->id, 'encrypt').'" href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-original-title="'.lang('edit').'">
                                <i class="far fa-edit"></i>
                            </a>
                            <a class="btn btn-danger delete_booking" data-id="'.$this->custom->encrypt_decrypt($value->id, 'encrypt').'" href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="'.lang('delete').'">
                                <i class="fa-regular fa-trash-can"></i>
                            </a>
                        </div>
                    </td>
                </tr>';
            }
        $html.='</tbody>
        </table>';
        echo json_encode($html);
    }


}
