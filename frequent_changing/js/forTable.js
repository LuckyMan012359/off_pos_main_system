(function ($) {
  "use strict";
  const bodyElement = $("body");
  /**
   * Get All Export Button And Append Another Location
   */

  setTimeout(() => {
    bodyElement
      .find(".dt-buttons")
      .wrap(
        '<div class="left-btn-box"><div class="exportDropdown"></div></div>'
      );
    bodyElement
      .find("#datatable_filter")
      .wrap('<div class="right-btn-box"></div>');
    /**
     * Append Export Dropdown Btn And Delete Button
     */
    $(document)
      .find(".exportDropdown")
      .prepend(
        '<a href="javascript:void(0)" type="button" class="btn btn-block btn-primary toggleBtn parent_btn"><svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg> Export</a>'
      );

    /**
     * Append Add New Button And Filter by Button
     */
    let filter_status = $(".datatable_name").attr('data-filter');
    if(filter_status!="no"){
        $(document).find(".right-btn-box").prepend(`
      <a href="javascript:void(0)" type="button"  class="btn btn-block btn-primary dataFilterBy">
      <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg> Filter By
        </a>
      `);
    }

    justWorkForTable();
  }, 300);

  function justWorkForTable() {
    /**
     * Click to show Export Dropdown
     */
    bodyElement.on("click", ".toggleBtn", function () {
      $(this).next(".dt-buttons").slideToggle(200);
    });

    $(window).on("click", function (e) {
      if ($(e.target).closest(".exportDropdown").length === 0) {
        $(document).find(".dt-buttons").slideUp(200);
      }
    });
    /**
     * Append search icon on search field
     */
    bodyElement
      .find("#datatable_filter label")
      .prepend(
        `<svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>`
      );
    bodyElement
      .find("#datatable_filter label")
      .find("input")
      .attr("placeholder", "Search Here");

    /**
     * Select Multiple Item
     */
    bodyElement.on("click", ".selectColumnAll", function () {
      $(this).attr("data-allselect", "true");

      if ($(this).is(":checked")) {
        bodyElement
          .find("#datatable tbody")
          .find("input:checkbox")
          .prop("checked", true);
        bodyElement
          .find("#datatable tbody")
          .find("input:checkbox")
          .attr("data-select", "true");
        $(document)
          .find(".left-btn-box")
          .find(".deleteTableColumn")
          .css("opacity", 1);
        bodyElement
          .find("#datatable tbody")
          .find("input:checkbox")
          .parent()
          .parent()
          .addClass("active");
      } else {
        bodyElement
          .find("#datatable tbody")
          .find("input:checkbox")
          .prop("checked", false);
        bodyElement
          .find("#datatable tbody")
          .find("input:checkbox")
          .attr("data-select", "false");
        bodyElement
          .find("#datatable tbody")
          .find("input:checkbox")
          .parent()
          .parent()
          .removeClass("active");
        $(document)
          .find(".left-btn-box")
          .find(".deleteTableColumn")
          .css("opacity", 0.3);
      }
    });
    /**
     * Single Item Select
     */
    bodyElement
      .find("#datatable tbody")
      .find("input:checkbox")
      .on("click", function () {
        if ($(this).is(":checked")) {
          $(this).parent().parent().addClass("active");
          $(this).attr("data-select", "true");
          $(document)
            .find(".left-btn-box")
            .find(".deleteTableColumn")
            .css("opacity", 1);
        } else {
          $(this).attr("data-select", "false");
          $(this).parent().parent().removeClass("active");
          $(document)
            .find(".left-btn-box")
            .find(".deleteTableColumn")
            .css("opacity", 0.3);
        }
      });
  }

  /**
   * Filter Modal Open and CLose
   */
  $(document).on("click", ".dataFilterBy", function (e) {
    bodyElement.find(".filter-modal").addClass("active");
    bodyElement.find(".filter-overlay").fadeIn();
  });
  bodyElement.on("click", ".close-filter-modal", function () {
    $(this).parent().parent().parent().removeClass("active");
    bodyElement.find(".filter-overlay").fadeOut();
  });
  bodyElement.on("click", ".filter-overlay", function () {
    bodyElement.find(".filter-modal").removeClass("active");
    $(this).fadeOut();
  });

    /*get button html*/
    let btn_list = $(".btn_list").html();
    setTimeout(() => {
        /**
         * Append Add New Button And Filter by Button
         */
    $(document).find(".right-btn-box").append(`${btn_list}`);
    }, 300);




    





})(jQuery);
