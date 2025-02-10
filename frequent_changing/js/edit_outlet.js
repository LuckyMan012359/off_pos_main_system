$(function () {
    "use strict";
    $('#vat_reg_no_container').hide();
    let collect_tax = $('#collect_tax').val();

    if (collect_tax == 'Yes') {
        $('#vat_reg_no_container').show();
    }
    
    $(document).on('change', 'input[type=radio][name=collect_tax]', function() {
        if (this.value == 'Yes') {
            $('#vat_reg_no_container').show();
        }else if (this.value == 'No') {
            $('#vat_reg_no_container').hide();
        }
    });
});
