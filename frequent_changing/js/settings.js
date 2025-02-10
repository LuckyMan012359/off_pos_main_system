$(document).ready(function() {
    "use strict";
    CKEDITOR.replace('term_conditions', {
        toolbar: [
            ['Bold', 'Italic', 'Underline', 'Strike', 'TextColor','BGColor', '-', 'NumberedList', 'BulletedList', '-', 'FontSize']
        ],
    });
    CKEDITOR.replace('invoice_footer', {
        toolbar: [
            ['Bold', 'Italic', 'Underline', 'Strike', 'TextColor','BGColor', '-', 'NumberedList', 'BulletedList', '-', 'FontSize']
        ],
    });
    CKEDITOR.replace('refund_and_return', {
        toolbar: [
            ['Bold', 'Italic', 'Underline', 'Strike', 'TextColor','BGColor', '-', 'NumberedList', 'BulletedList', '-', 'FontSize']
        ],
    });


    function generateUUID() {
        let d = new Date().getTime();
        let uuid = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
            let r = (d + Math.random() * 16) % 16 | 0;
            d = Math.floor(d / 16);
            return (c == 'x' ? r : (r & 0x3 | 0x8)).toString(16);
        });
        return uuid;
    }
    $(document).on("click", "#generateKey", function() {
        let uniqueKey = generateUUID();
        $('#api_key').val(uniqueKey);
    });


    $(document).on("click", "#inv-icon", function() {
        $('#invoice_schema').modal('show');
    });

    $(document).on("click", ".numbering_format_element", function() {
        $(".numbering_format_element").removeClass("active");
        $(this).addClass("active");
        $(".numbering_format_element input").attr('checked', false);
        $(this).find('input').attr('checked', true);
    });
    $(document).on("click", ".invoice_format_element", function() {
        $(".invoice_format_element").removeClass("active");
        $(this).addClass("active");
        $(".invoice_format_element input").attr('checked', false);
        $(this).find('input').attr('checked', true);
    });

    function showLetterHead(){
        let show_letter_head = $('#show_letter_head').val();
        if(show_letter_head == 'No'){
            $('.letter_head_gap_wrap').hide();
            $('.letter_footer_gap_wrap').hide();
            $('.letter_head_image').hide();
        }else{
            $('.letter_head_gap_wrap').show();
            $('.letter_footer_gap_wrap').show();
            $('.letter_head_image').show();
        }
    }
    showLetterHead();

    $(document).on('change', '#show_letter_head', function(){
        showLetterHead();
    });


    // preview the selected images
    $(document).on("click", ".show_letterhead_preview", function (e) {
        e.preventDefault();
        let preview_old = $("#show_id").attr("src");
        
        $("#letter_head_preview").modal("show");
    });

    
    function numberingConfigure() {
        let numberformating = $('.numbering_wrap .active .schema_type').val();
        let inv_number_of_digit = parseInt($('#inv_number_of_digit').val());
        let inv_prefix = $('#inv_prefix').val();
        let inv_numbering_type = $('#inv_numbering_type').val();
        let inv_start_from = parseInt($('#inv_start_from').val());
        let currentYear = new Date().getFullYear();
        let output = "";
        if (inv_numbering_type === 'Sequential') {
            if (numberformating == 'XXXX') {
                if (inv_prefix != '') {
                    output = inv_prefix + inv_start_from.toString().padStart(inv_number_of_digit, '0');
                } else {
                    output = inv_start_from.toString().padStart(inv_number_of_digit, '0');
                }
            } else if (numberformating == currentYear + '-XXXX') {
                let formattedNumber = inv_start_from.toString().padStart(inv_number_of_digit, '0');
                if (inv_prefix != '') {
                    output = inv_prefix + currentYear + '-' + formattedNumber;
                } else {
                    output = currentYear + '-' + formattedNumber;
                }
            }
        } else if (inv_numbering_type === 'Random') {
            let randomDigits = Array.from({ length: inv_number_of_digit }, () =>
                Math.floor(Math.random() * 10)
            ).join('');
            if (numberformating == 'XXXX') {
                if (inv_prefix != '') {
                    output = inv_prefix + randomDigits;
                } else {
                    output = randomDigits;
                }
            } else if (numberformating == currentYear + '-XXXX') {
                if (inv_prefix != '') {
                    output = inv_prefix + currentYear + '-' + randomDigits;
                } else {
                    output = currentYear + '-' + randomDigits;
                }
            }
        }
        $('.inv-format-number').text(output);
    }
    numberingConfigure();
    


    

    $(document).on('keyup', '#inv_prefix', function(){
        numberingConfigure();
    });

    $(document).on('keyup', '#inv_start_from', function(){
        numberingConfigure();
    });

    $(document).on('change', '#inv_number_of_digit', function(){
        numberingConfigure();
    });


    $(document).on('click', '.numbering_format_element ', function(){
        numberingConfigure(); 
    });



    $(document).on('change', '#inv_numbering_type ', function(){
        numberingFieldShowHide(); 
        numberingConfigure();
    });

    function numberingFieldShowHide(){
        let inv_numbering_type = $('#inv_numbering_type').val();
        if(inv_numbering_type == 'Random'){
            $('.start_from_wrap').hide();
        }else{
            $('.start_from_wrap').show();
        }
    }
    numberingFieldShowHide();

});