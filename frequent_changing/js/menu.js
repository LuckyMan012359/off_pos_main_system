$(function(){
    "use strict";
    let base_url = $('#base_url_').val();
    /** add active class and stay opened when selected */
    let url = window.location;
    
    $('.set_collapse').on('click', function() {
        let status = Number($('.set_collapse').attr("data-status"));
        let outlet_responsive = Number($('.outlet_responsive').attr("data-status"));
        let status_tmp = '';
        if(status==1 || outlet_responsive == 1){
            $('.set_collapse').attr('data-status',2);
            $('.outlet_responsive').attr('data-status',2);
            $('.outlet_large').addClass('d-none');
            $('.outlet_large').removeClass('d-block');
            $('.outlet_small').addClass('d-block');
            $('.outlet_small').removeClass('d-none');
            $('#menu-search').parent().show();
            status_tmp = "No";
            $(this).css('transform', 'rotate(0deg)');
        }else{
            $('.set_collapse').attr('data-status',1);
            $('.outlet_responsive').attr('data-status',1);
            $('.outlet_large').addClass('d-block');
            $('.outlet_large').removeClass('d-none');
            $('.outlet_small').addClass('d-none');
            $('.outlet_small').removeClass('d-block');
            $('#menu-search').parent().hide();
            status_tmp = "Yes";
            $(this).css('transform', 'rotate(180deg)');
        }
        $(this).css('transition', '0.7s all ease');
        $.ajax({
            url: base_url+'Ajax_View/set_collapse',
            method: "POST",
            data: {
                status: status_tmp,
            },
            success: function(response) {
            }
        });
    });

    function setActiveCurrentURL(){
        // Get the current URL
        let currentUrl = window.location.href;
        // Find the active_sub_menu when the current location matches the link
        $('.treeview').has('a[href="' + currentUrl + '"]').addClass('active_sub_menu');
        $('.treeview2').has('a[href="' + currentUrl + '"]').addClass('active_sub_menu');
        $('.treeview').has('a[href="' + currentUrl + '"]').addClass('menu-open');
        $('.treeview2').has('a[href="' + currentUrl + '"]').addClass('menu-open');
        $('.treeview').has('a[href="' + currentUrl + '"]').find('a[href="' + currentUrl + '"]').parent().addClass('treeMenuActive');
        $('.treeview2').has('a[href="' + currentUrl + '"]').find('a[href="' + currentUrl + '"]').parent().addClass('treeMenuActive');
    }
    setActiveCurrentURL();

    $(document).ready(function(){
        $(".menu-open").click(function(e){
          // Toggle the visibility of the inner UL with animation
          $(this).children(".treeview-menu").slideToggle();
        });
    });

    let activeSubMenu = $(".menu-open");
    if (activeSubMenu.length) {
        let scrollPosition = activeSubMenu.position().top - 100;
        $(".sidebar-menu").scrollTop(scrollPosition);
    }


    $(document).on('click', '.biponi_silver', function(e){
        e.preventDefault();
        toastr['error'](('Available for Gold, Pharmacy and Enterprise  packages.'), '');
    });








});
