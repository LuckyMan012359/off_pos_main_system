<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/debit_customer.css">


<input type="hidden"  id="base_url_c" value="<?php echo base_url(); ?>">
<input type="hidden"  id="outlet_name" value="<?php echo escape_output($this->session->userdata('outlet_name')); ?>">
<input type="hidden"  id="outlet_phone" value="<?php echo escape_output($this->session->userdata('phone')); ?>">
<input type="hidden"  id="address" value="<?php echo escape_output($this->session->userdata('address')); ?>">
<input type="hidden"  id="currency" value="<?php echo ($this->session->userdata('currency')); ?>">
<input type="hidden"  id="please_select_1_customer" value="<?php echo lang('please_select_1_customer'); ?>">



<div class="main-content-wrapper">
<?php
if ($this->session->flashdata('exception')) {
    echo '<section class="alert-wrapper"><div class="alert alert-success alert-dismissible fade show"> 
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></button>
    <div class="alert-body"><i class="icon fa fa-check me-2"></i>';
    echo escape_output($this->session->flashdata('exception'));unset($_SESSION['exception']);
    echo '</div></div></section>';
}
?>

    <div id="ajax_message"></div>

    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header"><?php echo lang('list_debit_customer'); ?> </h3>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('list_debit_customer'); ?>" data-id_name="datatable">
                <div class="btn_list m-right d-flex">
                    <a class="new-btn me-1" href="<?php echo base_url() ?>Customer/customers">
                    <iconify-icon icon="solar:checklist-broken" width="22"></iconify-icon> <?php echo lang('customers'); ?>
                    </a>
                </div>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('customer'), 'secondSection'=> lang('list_debit_customer')])?>
        </div>
    </section>


    <div class="box-wrapper">
        <div class="table-box"> 
            <div class="box-body">
                <?php echo form_open_multipart(base_url('Customer/sendSMSForAllDueCustomer'), $arrayName = array('id' => 'due_customers')); ?>
                <div class="table-responsive debit_customer"> 
                    <table id="datatable" class="table">
                        <thead>
                            <tr>
                                <th class="w-10">
                                    <label class="check_container m-0"> <?php echo lang('select_all'); ?>
                                        <input class="checkbox_userAll" type="checkbox" id="checkbox_userAll">
                                        <span class="checkmark"></span>
                                    </label>
                                </th>
                                <th class="w-5"><?php echo lang('sn'); ?></th>
                                <th class="w-15"><?php echo lang('customer_name'); ?></th>
                                <th class="w-10"><?php echo lang('phone'); ?></th>
                                <th class="w-15"><?php echo lang('email'); ?></th>
                                <th class="w-20 text-center"><?php echo lang('Current_Debit_Amount'); ?></th>
                                <th class="w-10"><?php echo lang('added_by'); ?></th>
                                <th class="w-10"><?php echo lang('added_date'); ?></th>
                                <th class="w-5 op_center"><?php echo lang('actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $customer_due_total = 0;
                            if ($customers && !empty($customers)) {
                                $i = count($customers);
                            }
                            foreach ($customers as $cust) {
                                $customer_due_total+=  $cust->opening_balance;
                                ?>                        
                                <tr class="row_counter" data-id="<?php echo escape_output($cust->id); ?>"> 

                                    <td>
                                        <label class="check_container m-0"><?php echo lang('select'); ?>
                                            <input type="checkbox"  class="checkbox_user" id="customer_id" name="customer_id[]" value="<?php echo escape_output($cust->name)?>||<?php echo escape_output($cust->phone)?>||<?php echo escape_output($cust->opening_balance)?>">
                                            <small class="checkmark"></small>
                                        </label>
                                    </td>
                                    <td class="op_center"><?php echo $i--; ?></td>
                                    <td><?php echo escape_output($cust->name); ?></td> 
                                    <td><?php echo escape_output($cust->phone); ?></td> 
                                    <td><?php echo escape_output($cust->email); ?></td>
                                    <td class="text-center"><?php echo getAmtCustom($cust->opening_balance); ?></td>
                                    <td><?php echo escape_output($cust->added_by); ?></td>
                                    <td><?php echo date($this->session->userdata('date_format'), strtotime($cust->added_date != '' ? $cust->added_date : '')); ?></td>
                                    <td class="text-cneter">
                                        <?php if ($cust->name != "Walk-in Customer") { ?> 
                                            <div class="btn_group_wrap">
                                                <a type="button" data-bs-toggle="modal" data-bs-target="#myModal" class="send_single_sms btn btn-unique" mobile="<?php echo escape_output($cust->phone); ?>" customer_name="<?php echo escape_output($cust->name); ?>" customer_due="<?php echo escape_output($cust->opening_balance); ?>"><i class="far fa-clock" data-bs-toggle="tooltip" data-bs-placement="top"
                                                data-bs-original-title="<?php echo lang('Send_Payment_Reminder'); ?>"></i>
                                                <input type="hidden" class="mobile_hidden">
                                                </a>

                                                <a class="btn btn-cyan" href="<?php echo base_url() ?>Customer/customerDetails/<?php echo escape_output($this->custom->encrypt_decrypt($cust->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                                data-bs-original-title="<?php echo lang('view_details'); ?>">
                                                    <i class="far fa-eye"></i>
                                                </a>
                                                <a class="btn btn-warning" href="<?php echo base_url() ?>Customer/addEditCustomer/<?php echo escape_output($this->custom->encrypt_decrypt($cust->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                                data-bs-original-title="<?php echo lang('edit'); ?>">
                                                    <i class="far fa-edit"></i>
                                                </a>
                                                <a class="delete btn btn-danger" href="<?php echo base_url() ?>Customer/deleteCustomer/<?php echo escape_output($this->custom->encrypt_decrypt($cust->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php echo lang('delete'); ?>">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </a>
                                            </div>

                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?> 
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th><?php echo lang('Total_Debit_Amount');?> <?php echo getAmtCustom(absCustom($customer_due_total)); ?></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tbody>
                    </table>
                    <button type="button" id="bul_sms_modal_trigger" class="btn bg-blue-btn"><?php echo lang('Send_SMS_Reminder_To_All_Due_Customer');?></button>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div> 
    </div> 
</div>










<!-- Modal -->
<div class="modal fade" id="myModal"  aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="exampleModalLabel"><?php echo lang('Send_Messege_To_Due_Customer');?></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i data-feather="x"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <span class="color-red"><?php echo lang('Please_send_your_sms_balance');?></span>  
                </div>
                <div class="form-group">
                    <label for="form-label"><?php echo lang('message'); ?></label>
                    <textarea class="form-control message_text" name="message" placeholder="<?php echo lang('send_message_to_due_customer'); ?>" rows="7">
                    </textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-blue-btn send_sms_trigger"><?php echo lang('send');?></button>
                <button type="button" class="btn bg-blue-btn" data-bs-dismiss="modal"><?php echo lang('close');?></button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="bulkSMSSend"  aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="exampleModalLabel"><?php echo lang('Send_Messege_To_Due_Customer');?></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i data-feather="x"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <span class="color-red"><?php echo lang('Please_send_your_sms_balance');?></span><br>
                    <span>The System Will Send (<b class="counter"></b>) SMS to (<b class="counter"></b>) Customers</span><br>
                    <span class="color-red"><b>Warning:</b> [CUSTOMER_NAME], [CUSTOMER_DUE] Can't be delete!!!</span>
                </div>
                <div class="form-group">
                    <label for="form-label"><?php echo lang('message'); ?></label>
                    <textarea class="form-control bulk_message_text" name="message" placeholder="<?php echo lang('send_message_to_due_customer'); ?>" rows="7">
                    </textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-blue-btn bulk_send_sms_trigger"><?php echo lang('send');?></button>
                <button type="button" class="btn bg-blue-btn" data-bs-dismiss="modal"><?php echo lang('close');?></button>
            </div>
        </div>
    </div>
</div>


<?php $this->load->view('updater/reuseJs',true); ?>
<script src="<?php echo base_url(); ?>frequent_changing/js/debit_customer.js"></script>
