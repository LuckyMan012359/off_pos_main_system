$(function () {
  "use strict";
  //preview the selected images
  $(document).on("click", ".show_preview", function (e) {
    e.preventDefault();
    $("#logo_preview").modal("show");
  });
  $(document).on("click", ".show_preview2", function (e) {
    e.preventDefault();
    $("#logo_preview_dark").modal("show");
  });
  $(document).on("click", ".show_fav_preview", function (e) {
    e.preventDefault();
    $("#fav_preview").modal("show");
  });

  function show_hide_loyalty(){
    let is_loyalty_enable = $("#is_loyalty_enable").val();
    if(is_loyalty_enable=="enable"){
      $(".div_loyalty").show(300);
    }else{
        $(".div_loyalty").hide(300);
    }
  }
  $(document).on("change", "#is_loyalty_enable", function (e) {
    e.preventDefault();
      show_hide_loyalty();
  });
    show_hide_loyalty();

  function set_printing_type() {
    let this_value_invoice = $("#invoice_print").val();
    if (this_value_invoice == "direct_print") {
      $(".receipt_printer_div_invoice").show();
      $(".print_server_url_div_invoice").hide();
      $(".print_format_div_invoice").css("display", "none");
      $(".print_format_div_invoice")
        .find("input")
        .css("pointer-events", "none");
    } else if (this_value_invoice == "live_server_print") {
      $(".print_server_url_div_invoice").show();
      $(".receipt_printer_div_invoice").show();
      $(".print_format_div_invoice").css("display", "none");
      $(".print_format_div_invoice")
        .find("input")
        .css("pointer-events", "none");
    } else {
      $(".print_server_url_div_invoice").hide();
      $(".receipt_printer_div_invoice").hide();
      $(".print_format_div_invoice").css("display", "block");
    }

    let this_value_bill = $("#printing_bill").val();
    if (this_value_bill == "direct_print") {
      $(".receipt_printer_div_bill").show();
      $(".print_server_url_div_bill").hide();
      $(".print_format_div_bill").css("opacity", "0");
      $(".print_format_div_bill").find("input").css("pointer-events", "none");
    } else if (this_value_bill == "live_server_print") {
      $(".print_server_url_div_bill").show();
      $(".receipt_printer_div_bill").show();
      $(".print_format_div_bill").css("opacity", "0");
      $(".print_format_div_bill").find("input").css("pointer-events", "none");
    } else {
      $(".print_server_url_div_bill").hide();
      $(".receipt_printer_div_bill").hide();
      $(".print_format_div_bill").css("opacity", "1");
    }

    let this_value_kot = $("#printing_kot").val();
    if (this_value_kot == "direct_print") {
      $(".receipt_printer_div_kot").show();
      $(".print_server_url_div_kot").hide();
      $(".print_format_div_kot").css("opacity", "0");
      $(".print_format_div_kot").find("input").css("pointer-events", "none");
    } else if (this_value_kot == "live_server_print") {
      $(".print_server_url_div_kot").show();
      $(".receipt_printer_div_kot").show();
      $(".print_format_div_kot").css("opacity", "0");
      $(".print_format_div_kot").find("input").css("pointer-events", "none");
    } else {
      $(".print_server_url_div_kot").hide();
      $(".receipt_printer_div_kot").hide();
      $(".print_format_div_kot").css("opacity", "1");
    }
  }
  $(document).on("change", ".printing", function (e) {
    set_printing_type();
  });
  set_printing_type();

});
