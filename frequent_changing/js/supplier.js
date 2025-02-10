$(document).ready(function(){
	"use strict";
	
	let baseURL = $("#base_url").val();
	let The_Supplier_Name_field_required = $('#The_Supplier_Name_field_required').val();
	let The_Contact_Person_field_required = $('#The_Contact_Person_field_required').val();
	let The_Phone_field_is_required = $('#The_Phone_field_is_required').val();

    $('#supplierModal').on('hidden.bs.modal', function() {
        $(this).find('form').trigger('reset');
    });
	
    $(document).on('click', '#addSupplier', function() {
		let name = $('input[name=name]').val();
		let contact_person = $('input[name=contact_person]').val();
		let phone = $('input[name=phone]').val();
		let emailAddress = $('input[name=emailAddress]').val();
		let supAddress = $('textarea[name=supAddress]').val();
		let description = $('textarea[name=description]').val();
		let error = 0;
		if(name == '') {
			error = 1;
            let cl1 = ".supplier_err_msg";
            let cl2 = ".supplier_err_msg_contnr";
            $(cl1).text(The_Supplier_Name_field_required);
            $(cl2).show(200).delay(6000).hide(200,function(){
            });
		} else {
			$('input[name=name]').css('border', '1px solid #ccc');
		}
		if(contact_person == '') {
			error = 1;
            let cl1 = ".customer_err_msg";
            let cl2 = ".customer_err_msg_contnr";
            $(cl1).text(The_Contact_Person_field_required);
            $(cl2).show(200).delay(6000).hide(200,function(){
            });
		} else {
			$('input[name=contact_person]').css('border', '1px solid #ccc');
		}
		if(phone == '') {
            error = 1;
            let cl1 = ".customer_phone_err_msg";
            let cl2 = ".customer_phone_err_msg_contnr";
            $(cl1).text(The_Phone_field_is_required);
            $(cl2).show(200).delay(6000).hide(200,function(){
            });
		} else {
			$('input[name=phone]').css('border', '1px solid #ccc');
		}
		if(error == 0) {
			$.ajax({
				url:baseURL+'Purchase/addNewSupplierByAjax',
				method:"GET",
				data: {
                    name:name,
                    contact_person:contact_person,
					phone:phone,
                    emailAddress:emailAddress,
                    supAddress:supAddress,
                    description:description
				},
				success:function(data){
					data=JSON.parse(data);
                    let supplier_id=data.supplier_id;
                    $.ajax({
			                url:baseURL+'Purchase/getSupplierList',
			                method:"GET",
			                data: { },
			                success:function(data){
			                	$("#supplier_id").empty();
                                $("#supplier_id").append(data);
                                $('#supplier_id').val(supplier_id).change();
			                }
			            });
                    $('.btn-close').click();
				}
			});
		}
	});
});




