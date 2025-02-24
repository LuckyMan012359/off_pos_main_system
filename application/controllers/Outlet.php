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
    # This is Outlet Controller
    ###########################################################
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Outlet extends Cl_Controller
{

    /**
     * load constructor
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Authentication_model');
        $this->load->model('Common_model');
        $this->load->model('Outlet_model');
        $this->load->library('form_validation');
        $this->Common_model->setDefaultTimezone();
        //start check access function

        // pre($this->session->userdata('invoice_configuration'));
        // pre(getAllSessionData());
        // pre(saleNoGenerator());

        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $controller = "25";
        $function = "";
        if ($segment_2 == "addEditOutlet") {
            $function = "add";
        } elseif ($segment_2 == "addEditOutlet" && $segment_3) {
            $function = "edit";
        } elseif ($segment_2 == "deleteOutlet") {
            $function = "delete";
        } elseif ($segment_2 == "outlets") {
            $function = "list";
        } elseif ($segment_2 == "setOutletSession") {
            $function = "list";
        } else {
            $this->session->set_flashdata('exception_1', lang('no_access'));
            redirect('Authentication/userProfile');
        }
        if (!checkAccess($controller, $function)) {
            $this->session->set_flashdata('exception_1', lang('no_access'));
            redirect('Authentication/userProfile');
        }
    }
    /**
     * addEditOutlet
     * @access public
     * @param int
     * @return void
     */

    public function encryptData($data, $secretKey)
    {
        $data = urlencode($data);

        $iv = openssl_random_pseudo_bytes(16);
        $key = hash('sha256', $secretKey, true);
        $encrypted = openssl_encrypt($data, 'AES-256-CBC', $key, 0, $iv);

        return base64_encode($iv . $encrypted);
    }


    public function addEditOutlet($encrypted_id = "")
    {
        $encrypted_id = $encrypted_id;
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');

        $user_id = $this->session->userdata('user_id');
        $company_id = $this->session->userdata('company_id');
        if ($id == '') {
            if (isServiceAccess2($user_id, $company_id, 'sGmsJaFJE') == 'Saas Company') {
                $company_info = getCompanyInfo();
                $plan_details = $this->Common_model->getDataById($company_info->plan_id, 'tbl_pricing_plans');
                $outlet_count = $this->Common_model->getCountOutlet($company_info->id);
                if ($plan_details->number_of_maximum_outlets == $outlet_count) {
                    $this->session->set_flashdata('exception_2', "You can no longer create outlet, Your limitation is over! Upgrade Now");
                    redirect('Service/planDetails');
                }
            }
        }
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('outlet_code', lang('outlet_code'), 'required|max_length[50]');
            $this->form_validation->set_rules('outlet_name', lang('outlet_name'), 'required|max_length[50]');
            $this->form_validation->set_rules('email', lang('email'), 'max_length[50]');
            $this->form_validation->set_rules('address', lang('address'), 'required|max_length[250]');
            $this->form_validation->set_rules('phone', lang('phone'), 'required|max_length[30]');
            $this->form_validation->set_rules('active_status', lang('active_status'), 'required|max_length[25]');

            if ($this->form_validation->run() == TRUE) {
                $add_more = $this->input->post($this->security->xss_clean('add_more'));
                $outlet_info = array();
                $outlet_info['outlet_code'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('outlet_code')));
                $outlet_info['outlet_name'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('outlet_name')));
                $c_address = htmlspecialcharscustom($this->input->post($this->security->xss_clean('address')));
                $outlet_info['address'] = preg_replace("/[\n\r]/", " ", $c_address);
                $outlet_info['phone'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('phone')));
                $outlet_info['email'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('email')));
                $outlet_info['active_status'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('active_status')));
                $outlet_info['domain'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('domain')));

                $outlet_email = $outlet_info['email'];
                $outlet_name = $outlet_info['outlet_name'];
                $outlet_domain = str_replace("/", " ", $outlet_info['domain']);
                $outlet_phone = $outlet_info['phone'];
                $outlet_address = $outlet_info['address'];

                $outlet_data = json_encode(["email" => $outlet_email, "name" => $outlet_name, "domain" => $outlet_domain, "phone" => $outlet_phone, "address" => $outlet_address]);

                $key = $this->encryptData($outlet_data, "pos_system");
                $outlet_info['token'] = $key;

                if ($id == "") {
                    $outlet_info['user_id'] = $this->session->userdata('user_id');
                    $outlet_info['company_id'] = $this->session->userdata('company_id');
                    $outlet_info['outlet_code'] = $this->Outlet_model->generateOutletCode();
                    $outlet_info['added_date'] = date('Y-m-d H:i:s');
                    if (APPLICATION_L) {
                        if (APPLICATION_LO) {
                            $this->session->set_flashdata('exception_2', lang('insert_err_o'));
                            redirect('Outlet/outlets');
                        } else {
                            $outlet_id = $this->Common_model->insertInformation($outlet_info, "tbl_outlets");
                            $this->session->set_flashdata('exception', lang('insertion_success'));
                        }
                    } else {
                        $outlet_id = $this->Common_model->insertInformation($outlet_info, "tbl_outlets");
                        $this->session->set_flashdata('exception', lang('insertion_success'));
                    }
                } else {
                    $this->Common_model->updateInformation($outlet_info, $id, "tbl_outlets");
                    $this->session->set_flashdata('exception', lang('update_success'));
                }
                if ($add_more == 'add_more') {
                    redirect('Outlet/addEditOutlet');
                } else {
                    redirect('Outlet/outlets');
                }
            } else {
                if ($id == "") {
                    $data = array();
                    $data['outlet_code'] = $this->Outlet_model->generateOutletCode();
                    $data['main_content'] = $this->load->view('outlet/addOutlet', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['outlet_information'] = $this->Common_model->getDataById($id, "tbl_outlets");
                    $data['main_content'] = $this->load->view('outlet/editOutlet', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['outlet_code'] = $this->Outlet_model->generateOutletCode();
                $data['main_content'] = $this->load->view('outlet/addOutlet', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['outlet_information'] = $this->Common_model->getDataById($id, "tbl_outlets");
                $data['main_content'] = $this->load->view('outlet/editOutlet', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }

    /**
     * deleteOutlet
     * @access public
     * @param int
     * @return void
     */
    public function deleteOutlet($id)
    {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $this->Common_model->deleteStatusChange($id, "tbl_outlets");
        $this->session->set_flashdata('exception', lang('delete_success'));
        redirect('Outlet/outlets');
    }


    /**
     * outlets
     * @access public
     * @param no
     * @return void
     */
    public function outlets()
    {
        $data = array();
        $company_id = $this->session->userdata('company_id');
        $user_id = $this->session->userdata('user_id');
        $role = $this->session->userdata('role');
        if ($role == '1') {
            $data['outlets'] = getDataByCompanyId($company_id, 'tbl_outlets');
        } else {
            $assigned_outlet = $this->Common_model->getAssignedOutletDataById($user_id);
            $selected_outlet_id = array();
            if ($assigned_outlet->outlet_id) {
                $outlet = explode(",", $assigned_outlet->outlet_id);
                foreach ($outlet as $value) {
                    array_push($selected_outlet_id, $value);
                }
            }
            $data['outlets'] = $this->Common_model->getAllOutlets($selected_outlet_id);
        }
        $data['main_content'] = $this->load->view('outlet/outlets', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    /**
     * setOutletSession
     * @access public
     * @param int
     * @return void
     */
    public function setOutletSession($encrypted_id)
    {
        $outlet_id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        $outlet_details = $this->Common_model->getDataById($outlet_id, 'tbl_outlets');
        echo json_encode($outlet_details);
        $outlet_session = array();
        $outlet_session['outlet_id'] = $outlet_details->id;
        $outlet_session['outlet_name'] = $outlet_details->outlet_name;
        $outlet_session['address'] = $outlet_details->address;
        $outlet_session['phone'] = $outlet_details->phone;
        $outlet_session['outlet_email'] = $outlet_details->email;
        $this->session->set_userdata($outlet_session);
        dueInstallmentNotify();
        if (!$this->session->has_userdata('clicked_controller')) {
            if ($this->session->userdata('role') == '1') {
                redirect('Dashboard/dashboard');
            } else {
                redirect('Authentication/userProfile');
            }
        } else {
            redirect('Dashboard/dashboard');
        }
    }
}
