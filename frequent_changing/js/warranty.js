$(function () {
    "use strict";
    let base_url = $('#base_url_').val();
    let status_change = $('#status_change').val();
    let do_you_save_the_change = $('#do_you_save_the_change').val();
    let warning = $('#warning').val();
    let save = $('#save').val();
    let dont_save = $('#dont_save').val();
    $(document).on('change', '#current_status', function (e) { 
        e.preventDefault();
        let id = $(this).attr('item-id');
        let current_status = $(this).val();
        Swal.fire({
            title: warning+" !",
            text: do_you_save_the_change,
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: save,
            denyButtonText: dont_save,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: base_url+"WarrantyProducts/changeStatus/"+id,
                    data: { current_status : current_status},
                    datatype: 'json',
                    success: function (response) {
                        if(response.status == '200'){
                            $('#message').append(`
                                <section class="alert-wrapper">
                                    <div class="alert alert-success alert-dismissible fade show"> 
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></button>
                                        <div class="alert-body"><i class="icon fa fa-check me-2"></i>${status_change}</div>
                                    </div>
                                </section>
                            `);
                            setTimeout(function() {
                                $('#message').html('');
                            }, 2000);
                        } 
                    }
                });
            } 
        });
    });
    $(document).on('click', '.printProduct', function() {
        viewChallan($(this).attr('print_product'));
    });

    function  viewChallan(id) {
        let print_format = $('#print_type').val();
        if (print_format == "Thermal Print") {
            let newWindow = open("printProduct/" + id, 'Print Warranty Product', 'width=450,height=550');
        } else if (print_format == "A4 Print") {
            let newWindow = open("printProduct/" + id, 'Print Warranty Product', 'width=1600,height=550');
        } else if (print_format == "Half A4 Print") {
            let newWindow = open("printProduct/" + id, 'Print Warranty Product', 'width=421,height=595');
        }
        newWindow.focus();
        newWindow.onload = function() {
          newWindow.document.body.insertAdjacentHTML('afterbegin');
        }; 
    }







})