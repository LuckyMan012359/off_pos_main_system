$(function () {
      "use strict";

      $(document).on('click', '.action_button', function(e){
            let text_1 = $(this).val();
            let text_2 = $(this).text();
            
            $(this).addClass('btn_disable');             // Add blink effect
            $(this).addClass('blink');             // Add blink effect
         
            let counter = 0;
            let text = '';
            const $element = $(this);
            // Check if the element is a <button> or an <input> of type "button"
            if ($element.is('button') || $element.is('input[type="button"]')) {
                  counter = 1; // button
                  $(this).text('Please wait...');         // Change the button text 
                  text = text_2;
            } else {
                  counter = 2; // input field
                  text = text_1;
                  $(this).val('Please wait...');         // Change the button text 
            }
            let is_unlimited = $(this).attr('data-is_unlimited');
            let counter_timer = 5000;
            if(is_unlimited==1){
                  counter_timer = 50000;
            }

            setTimeout(() => {
                  if(counter==1){
                        $(this).text(text);
                  }else{
                        $(this).val(text);   
                  }     
                  $(this).removeClass('btn_disable'); // Remove blink effect and reset text
                  $(this).removeClass('blink'); // Remove blink effect and reset text
              }, counter_timer); // 5000 ms = 5 seconds

      });
  });