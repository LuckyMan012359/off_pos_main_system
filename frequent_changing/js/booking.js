document.addEventListener('DOMContentLoaded', function() {

    let copy_db = jQuery('#copy_db_exp').val();
    let print_db = jQuery('#print_db_exp').val();
    let excel_db = jQuery('#excel_db_exp').val();
    let csv_db = jQuery('#csv_db_exp').val();
    let pdf_db = jQuery('#pdf_db_exp').val();

    flatpickr('.customDateTimePicker', {
        enableTime: true,
        dateFormat: 'Y-m-d H:i',
        time_24hr: true
    });

    // Calender Call
    let base_url = jQuery("#base_url").val();

    function calanderCall() {
        let calendarEl = document.getElementById('calendar');
        let calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: function(fetchInfo, successCallback, failureCallback) {
                // Fetch events from the server
                $.ajax({
                    url: base_url + 'Booking/bookingData',
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            // Modify events to include color based on status
                            let events = response.message.map(event => {
                                event.textColor = event.id
                                if (event.status === 'Booked') {
                                    event.backgroundColor = '#1572e8';
                                    event.borderColor = '#1572e8'; 
                                } else if (event.status === 'Waiting') {
                                    event.backgroundColor = '#ffad46';
                                    event.borderColor = '#ffad46';
                                } else if (event.status === 'Completed') {
                                    event.backgroundColor = '#2dce89';
                                    event.borderColor = '#2dce89';
                                } else if (event.status === 'Cancelled') {
                                    event.backgroundColor = '#f5365c';
                                    event.borderColor = '#f5365c';
                                }
                                return event;
                            });
                            successCallback(events); // Pass the modified events array
                        } else {
                            failureCallback();
                        }
                    },
                    error: function() {
                        failureCallback();
                    }
                });
            },
            eventContent: function(info) {
                // Customize the event title color
                let statusColor = '';
                if (info.event.extendedProps.status === 'Booked') {
                    statusColor = '#1572e8';
                } else if (info.event.extendedProps.status === 'Waiting') {
                    statusColor = '#ffad46';
                } else if (info.event.extendedProps.status === 'Completed') {
                    statusColor = '#2dce89';
                } else if (info.event.extendedProps.status === 'Cancelled') {
                    statusColor = '#f5365c';
                }
                return {
                    html: `<div class="edit_booking_id" data-id="${info.event.textColor}" style="background-color: ${statusColor}; color:white; border-radius: 3px; padding-left: 2px; padding-right: 2px;">${info.event.title}</div>`
                };
            }
        });
        calendar.render();
    }
    calanderCall();




    jQuery(document).on('click', '.booking_calender_trigger', function() {
        window.location.href = base_url+"Booking/booking";
    });








    // Booking Modal Call
    jQuery(document).on('click', '#add_booking_triger', function(){
        jQuery('#add_booking').modal('show');
        jQuery('#booking_edit_hidden_id').val('');
        jQuery('#add_booking .modal-title').text('Add Booking');
    });

    // Booking Modal Call
    jQuery(document).on('click', '.edit_booking', function(){
        jQuery('#add_booking').modal('show');
        jQuery('#add_booking .modal-title').text('Edit Booking');
        let book_id = jQuery(this).attr('data-id');
        jQuery('#booking_edit_hidden_id').val(book_id);
        $.ajax({
            url: base_url + "Booking/editBooking",
            method: "POST",
            data: {
                book_id: book_id,
            },
            success: function (response) {
                if(response.status == 'success'){
                    jQuery("#customer_id").val(response.data.customer_id).trigger("change");
                    jQuery("#service_seller_id").val(response.data.service_seller_id).trigger("change");
                    jQuery("#outlet_id").val(response.data.outlet_id).trigger("change");
                    jQuery("#status").val(response.data.status).trigger("change");
                    setTimeout(function(){
                        jQuery(".customer_id .select2-selection__rendered").text('').text(response.data.customer_name);
                        jQuery(".service_seller_id .select2-selection__rendered").text(response.data.service_seller_name);
                        jQuery(".outlet_id .select2-selection__rendered").text(response.data.outlet_name);
                        jQuery(".status .select2-selection__rendered").text(response.data.status);
                    }, 200);
                    jQuery("#start_date").val(response.data.start_date);
                    jQuery("#end_date").val(response.data.end_date);
                    jQuery("#note").val(response.data.note);
                }else if(response.status == 'error'){
                    toastr['error'](response.data, 'Error');
                }
            }
        });
    });

    

    // Booking Modal Call
    jQuery(document).on('click', '.delete_booking', function(){
        let book_id = jQuery(this).attr('data-id');
        Swal.fire({
            title: 'Alert!',
            text: 'Are you sure you want to delete this booking?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: 'Yes',
            denyButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: base_url + "Booking/deleteBooking",
                    method: "POST",
                    data: {
                        book_id: book_id,
                    },
                    success: function (response) {
                        if(response.status == 'success'){
                            toastr['success'](response.data, 'Success');
                            getAllBooking();
                        }
                    }
                });
            }
        });
    });


    jQuery(document).on('click', '.add_booking_submit', function(){
        let status = jQuery('#status').val();
        let outlet_id = jQuery('#outlet_id').val();
        let customer_id = jQuery('#customer_id').val();
        let service_seller_id = jQuery('#service_seller_id').val();
        let start_date = jQuery('#start_date').val();
        let end_date = jQuery('#end_date').val();
        let note = jQuery('#note').val();
        let is_sent_invoice = jQuery('#is_sent_invoice').is(':checked');
        let edit_booking_id = jQuery('#booking_edit_hidden_id').val();
        $.ajax({
            url: base_url + "Booking/addBooking",
            method: "POST",
            data: {
                status: status,
                outlet_id: outlet_id,
                customer_id: customer_id,
                service_seller_id: service_seller_id,
                start_date: start_date,
                end_date: end_date,
                note: note,
                is_sent_invoice: is_sent_invoice,
                edit_booking_id: edit_booking_id,
            },
            success: function (response) {
                if(response.status == 'success'){
                    jQuery('#add_booking').modal('hide');
                    clearBookingModal();
                    getAllBooking();
                    calanderCall();
                    toastr['success'](response.message, 'Success');
                }else if(response.status == 'error'){
                    $.each(response.errors, function (ind, val) { 
                        if(ind == 'outlet_id' && val != ''){
                            jQuery("#outlet_id_err_msg").html(`${val}`);
                            jQuery(".outlet_id_err_msg_contnr").show(200).delay(6000).hide(200, function () {});
                        }else if(ind == 'customer_id' && val != ''){
                            jQuery("#customer_id_err_msg").html(`${val}`);
                            jQuery(".customer_id_err_msg_contnr").show(200).delay(6000).hide(200, function () {});
                        }else if(ind == 'service_seller_id' && val != ''){
                            jQuery("#service_seller_id_err_msg").html(`${val}`);
                            jQuery(".service_seller_id_err_msg_contnr").show(200).delay(6000).hide(200, function () {});
                        }else if(ind == 'start_date' && val != ''){
                            jQuery("#start_date_err_msg").html(`${val}`);
                            jQuery(".start_date_err_msg_contnr").show(200).delay(6000).hide(200, function () {});
                        }else if(ind == 'end_date' && val != ''){
                            jQuery("#end_date_err_msg").html(`${val}`);
                            jQuery(".end_date_err_msg_contnr").show(200).delay(6000).hide(200, function () {});
                        }else if(ind == 'note' && val != ''){
                            jQuery("#note_err_msg").html(`${val}`);
                            jQuery(".note_err_msg_contnr").show(200).delay(6000).hide(200, function () {});
                        }else if(ind == 'status' && val != ''){
                            jQuery("#status_err_msg").html(`${val}`);
                            jQuery(".status_err_msg_contnr").show(200).delay(6000).hide(200, function () {});
                        }
                    });
                }

            }
        });
    });

    function clearBookingModal(){
        jQuery('#status').val('').trigger("change");
        jQuery('#outlet_id').val('').trigger("change");
        jQuery('#customer_id').val('').trigger("change");
        jQuery('#service_seller_id').val('').trigger("change");
        jQuery('#start_date').val('');
        jQuery('#end_date').val('');
        jQuery('#note').val('');
        setTimeout(function(){
            jQuery(".customer_id .select2-selection__rendered").text('').text('Select Customer');
            jQuery(".service_seller_id .select2-selection__rendered").text('Select Employee');
            jQuery(".outlet_id .select2-selection__rendered").text('Select Outlet');
            jQuery(".status .select2-selection__rendered").text('Status');
        }, 200);
    }

    function getAllBooking(){
        $.ajax({
            type: "GET",
            url: base_url + 'Booking/getAllBooking',
            dataType: "json", 
            success: function (response) {
                jQuery(".html_content").html(response); 
                jQuery('#datatable').DataTable({
                    'autoWidth': false,
                    'ordering': false,
                    'paging': true, 
                    'language': {
                        'paginate': {
                            'next': 'Next', 
                            'previous': 'Previous'
                        }
                    }
                });
            }
        });
    }
    getAllBooking();

    

    jQuery(document).on('click', '.fc-event', function(){
        let book_id = $(this).find('.edit_booking_id').attr('data-id');
        $.ajax({
            url: base_url + "Booking/editBooking",
            method: "POST",
            data: {
                book_id: book_id,
            },
            success: function (response) {
                if(response.status == 'success'){
                    jQuery('#add_booking').modal('show');
                    jQuery('#add_booking .modal-title').text('Edit Booking');
                    let book_id = jQuery(this).attr('data-id');
                    jQuery('#booking_edit_hidden_id').val(book_id);
                    jQuery("#customer_id").val(response.data.customer_id).trigger("change");
                    jQuery("#service_seller_id").val(response.data.service_seller_id).trigger("change");
                    jQuery("#outlet_id").val(response.data.outlet_id).trigger("change");
                    jQuery("#status").val(response.data.status).trigger("change");
                    setTimeout(function(){
                        jQuery(".customer_id .select2-selection__rendered").text('').text(response.data.customer_name);
                        jQuery(".service_seller_id .select2-selection__rendered").text(response.data.service_seller_name);
                        jQuery(".outlet_id .select2-selection__rendered").text(response.data.outlet_name);
                        jQuery(".status .select2-selection__rendered").text(response.data.status);
                    }, 200);
                    jQuery("#start_date").val(response.data.start_date);
                    jQuery("#end_date").val(response.data.end_date);
                    jQuery("#note").val(response.data.note);
                }else if(response.status == 'error'){
                    toastr['error'](response.data, 'Error');
                }
            }
        });
    });
});