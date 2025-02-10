$(function () {
  "use strict";
  function setDiv() {
      let  smtp_type = $(".smtp_type").val();
      //hide all div on first time
      if(smtp_type == "Gmail"){
          $(".hide_show_div").hide();
      }else{
          $(".hide_show_div").show(300);
      }
  }
  setDiv();
  $(document).on('change', '.smtp_type', function(e)    {
      setDiv();
  });
});