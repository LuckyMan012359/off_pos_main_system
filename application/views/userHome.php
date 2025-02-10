<?php
    $biiPP = biiPP();
    if($biiPP){
        $pakl = 'diamond';
    }else{
        $pakl = '';
    }
    $is_arabic = isArabic();
    $uri = $this->uri->segment(2);
    $is_collapse = $this->session->userdata('is_collapse');
    $wl = getWhiteLabel();
    $site_name = '';
    $site_footer = '';
    $site_title = '';
    $site_link = '';
    $site_logo = '';
    $site_favicon = '';
    if($wl){
        if($wl->site_name){
            $site_name = $wl->site_name;
        }
        if($wl->site_footer){
            $site_footer = $wl->site_footer;
        }
        if($wl->site_title){
            $site_title = $wl->site_title;
        }
        if(isset($wl->site_link) && $wl->site_link){
            $site_link = $wl->site_link;
        }
        if($wl->site_logo){
            $site_logo = base_url()."uploads/site_settings/".$wl->site_logo;
        }
        if($wl->site_favicon){
            $site_favicon = base_url()."uploads/site_settings/".$wl->site_favicon;
        }
    }
    $company_info = getCompanyInfo();
    $company_short_name =  $company_info->short_name;
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo escape_output($site_name); ?></title>
        <!-- Fav Icon -->
        <link rel="shortcut icon" href="<?php echo escape_output($site_favicon); ?>" type="image/x-icon">
        <link rel="icon" href="<?php echo escape_output($site_favicon); ?>" type="image/x-icon">
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- jQuery 3.7.1 -->
        <script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
        <!-- Iconify Font -->
        <script src="<?php echo base_url(); ?>assets/iconify/js/iconify.min.js"></script>
        <!-- Select2 -->
        <script src="<?php echo base_url(); ?>assets/bower_components/select2/dist/js/select2.full.min.js"></script>
        <!-- Select2 -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/select2/dist/css/select2.min.css?var=1.6">
        <!-- Sweet alert -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/POS/css/sweetalert2-new.min.css?var=1.6" type="text/css">
        <script src="<?php echo base_url(); ?>assets/POS/js/sweetalert2-new.all.min.js"></script>
        <!-- Off POS Common CSS -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/common.css?var=1.6">
        <!-- bootstrap datepicker -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/datepicker/datepicker.css?var=1.6">
        <!-- bootstrap datepicker -->
        <script src="<?php echo base_url(); ?>assets/bower_components/datepicker/bootstrap-datepicker.js"></script>
        <!-- Bootstrap 5.0.1 -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/bootstrap.min.css?var=1.6">
        <!-- Font Awesome 6.5.1-->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/fontawesome-free-6.5.1-web/css/all.min.css?var=1.6">

        <!-- Toastr -->
        <script src="<?php echo base_url(); ?>assets/notify/toastr.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/notify/toastr.css?var=1.6" type="text/css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/AdminLTE.css?var=1.6">
        <!-- Google Font -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/local/google_font.css?var=1.6">
        <script src="<?php echo base_url(); ?>frequent_changing/js/user_home.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/userHome.css?var=1.6">
        <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/notification_drawer.css?var=1.6">
        <!-- Off POS Custom CSS -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/newDesign/lib/perfect-scrollbar/dist/perfect-scrollbar.css?var=1.6">
        <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/newDesign/style.css?var=1.6">
        <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/custom_theme.css?var=1.6">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/tippy/tippy.css?var=1.6">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/tippy/scale.css?var=1.6">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/tippy/theme_light.css?var=1.6">
        <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/new_design.css?var=1.6">
        <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/preloader.css?var=1.6">
        <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/userHomeResponsive.css?var=1.6">

        <style>
            /* for dynamic language font load, used internal css */
            /* for check change of bangla language font */
            <?php 
            if ($this->session->has_userdata('language')) {
                $font_detect = $this->session->userdata('language');
                $bd_font = "bd_font";
            } else {
                $font_detect = 'english';
            }
            if ($font_detect == "bangla") { ?>
                @font-face {
                    font-family: bd_font;
                    src: url(<?= base_url('/assets/SolaimanLipi.ttf') ?>);
                }
                body,
                h1,
                h2,
                h3,
                h4,
                h5,
                button,
                h6 {
                    font-family: <?= $bd_font ?>;
                }

                * {
                    font-family: <?= $bd_font ?>;
                }

                .showSweetAlert {
                    font-family: <?= $bd_font ?>;
                }
                .treeview-menu-in a {
                    font-size: 20px;
                }
                .main-sidebar .sidebar-menu li a, .main-sidebar2 .sidebar-menu li a {
                    font-size: 20px;
                }
                .main-sidebar .sidebar-menu li.treeview a span, .main-sidebar2 .sidebar-menu li.treeview a span {
                    font-size: 20px;
                }
                .bg-blue-btn, .bg-red-btn {
                    font-size: 20px;
                }
                .form-group label {
                    color: #32363E;
                    font-size: 18px !important;
                    margin-bottom: 4px;
                }
                .currency_show{
                    font-size: 25px;
                    margin-right: 2px;
                }
                .table-box table.dataTable thead th, .table-box table.table thead th {
                    font-size: 16px;
                }
                .logo-lg img{
                    height: 45px;
                }
            <?php } else { ?>
                * {
                    font-family: Outfit, sans-serif;
                }
                .slimScrollDivCategory .category_button {
                    font-family: Outfit, sans-serif;
                }
            <?php } ?>
            .biponi_silver iconify-icon{
                color: #d1440c !important;
            }
        </style>
        <!-- End new design css file -->
    </head>
    <?php 
		$s_status = ((defined('FCCPATH') && FCCPATH) ? FCCPATH : '');
	?>
    <input type="hidden" id="fccpath" value="<?php echo $s_status?>">
    <!-- ADD THE CLASS sidebar-collapse TO HIDE THE SIDEBAR PRIOR TO LOADING THE SITE -->
    <body class="hold-transition skin-blue sidebar-mini <?php echo isset($is_collapse) && $is_collapse=="No"? '' : 'sidebar-collapse'?>">
    <div class="loader"></div>   
    <!-- This file coming from  this path : applications/views/updater/ -->
        <?php $this->view('updater/hidden-input')?>

        <div class="main-preloader">
            <div class="loadingio-spinner-spin-nq4q5u6dq7r"><div class="ldio-x2uulkbinbj">
            <div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div>
            </div></div>
        </div>

        <!-- Site wrapper -->
        <div class="wrapper <?php echo escape_output($is_arabic) == 'Yes' ? 'arabic-lang' : ''?>">
            <header class="main-header  <?php echo escape_output($is_arabic) == 'Yes' ? 'sidebar2_active' : ''?>">
                <nav class="navbar navbar-static-top">
                    <div class="wrapper_up_wrapper">
                        <div class="hh_wrapper">
                            <div class="navbar-custom-menu navbar-menu-left">
                                <div class="menu-trigger-box ">
                                    <div class="d-flex">
                                        <button data-toggle="push-menu" type="button" class="st new-btn mobile_sideber_hide_show">
                                            <iconify-icon icon="ri:menu-fold-fill" width="22"></iconify-icon>
                                        </button>
                                        <div class="navbar-custom-menu navbar-menu-right">
                                            <div class="d-inline-flex align-items-center">
                                                <div class="dropdown ms-1 language-dropdown">
                                                    <button class="btn dropdown-toggle top_5px_padding more-link-btn new-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <iconify-icon icon="solar:link-round-line-duotone" width="22"></iconify-icon>
                                                    </button>
                                                    <ul dir="ltr" class="dropdown-menu dropdown-menu-light">
                                                        
                                                        <li>
                                                            <a class="new-btn" href="<?php echo base_url() ?>Sale/POS">
                                                                <iconify-icon icon="solar:cart-large-broken" width="15"></iconify-icon>
                                                                <?php echo lang('pos');?>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="new-btn" href="<?php echo base_url() ?>authentication/checkInOut">
                                                                <iconify-icon icon="solar:clock-square-broken" width="15"></iconify-icon>
                                                                <?php echo lang('check_in_out') ?>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="new-btn" target="_blank" href="<?php echo base_url()?>Register/registerDetails" >
                                                                <iconify-icon icon="solar:book-broken" width="15"></iconify-icon>
                                                                    <?php echo lang('register_details');?>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="new-btn quick_menus_trigger" href="javascript:void(0)" >
                                                                <iconify-icon icon="solar:quit-full-screen-circle-broken" width="15"></iconify-icon>
                                                                    <?php echo lang('quick_menus');?>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="shortcut-menus">
                                    <div class="d-flex">
                                    <?php if ($this->session->userdata('outlet_id')) { ?>
                                        <a class="new-btn" href="<?php echo base_url() ?>Sale/POS" data-bs-toggle="tooltip" data-bs-placement="right"
                                        data-bs-original-title="<?php echo lang('pos'); ?>">
                                            <iconify-icon icon="solar:cart-large-broken" width="22"></iconify-icon>
                                        </a>
                                        <a class="new-btn" href="<?php echo base_url() ?>authentication/checkInOut" data-bs-toggle="tooltip" data-bs-placement="right"
                                        data-bs-original-title="<?php echo lang('check_in_out'); ?>">
                                            <iconify-icon icon="solar:clock-square-broken" width="22"></iconify-icon>
                                        </a>
                                        <?php if ($this->session->userdata('role') == "1") { ?>
                                        <a class="new-btn todays_summary_trigger" href="javascrip:void(0)" data-bs-toggle="tooltip" data-bs-placement="right"
                                        data-bs-original-title="<?php echo lang('todays_summary_report'); ?>">
                                            <iconify-icon icon="solar:layers-broken" width="22"></iconify-icon>
                                        </a>
                                        <a class="new-btn" href="<?php echo $this->session->userdata('register_status') == '2' ? base_url() . 'Register/openRegister' : base_url() . 'Register/registerDetails' ?>" data-bs-toggle="tooltip" data-bs-placement="right"
                                        data-bs-original-title="<?php echo $this->session->userdata('register_status') == '2' ? lang('register') : lang('register_details') ?>">
                                            <iconify-icon icon="solar:document-add-broken" width="22"></iconify-icon>
                                        </a>
                                        <?php } ?>
                                        <a class="new-btn quick_menus_trigger" href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="right"
                                        data-bs-original-title="<?php echo lang('quick_menus'); ?>">
                                            <iconify-icon icon="solar:quit-full-screen-circle-broken" width="22"></iconify-icon>
                                        </a>
                                    <?php } ?>
                                    <?php if (APPLICATION_MODE == 'demo') {?>
                                        <a target="_blank" class="new-btn" href="<?php echo defined('FCCPATH') && FCCPATH != 'Bangladesh' ? 'https://youtu.be/wtrn0uUxfC8?si=RKwcjlHSixegQeX3': 'https://rumble.com/v5r88e8-348064640.html'?>" data-bs-toggle="tooltip" data-bs-placement="right"
                                        data-bs-original-title="<?php echo defined('FCCPATH') && FCCPATH != 'Bangladesh' ? 'How to begin with Off POS': 'বিপনি কিভাবে শুরু করবেন?'?>">
                                            <iconify-icon icon="solar:videocamera-record-broken" width="22"></iconify-icon>
                                        </a>
                                    <?php } ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="navbar-custom-menu navbar-menu-right d-flex">
                                <?php if ($this->session->userdata('outlet_id')) { ?>
                                <div class="navbar-menu-center me-2">
                                    <div class="header-outlet-name">
                                        <?php echo limitWords($this->session->userdata('outlet_name'), '1') ?>
                                        <small><?php echo lang('outlet');?></small>
                                    </div>
                                </div>
                                <?php } ?>
                                <div class="d-inline-flex align-items-center custom_gap_2">
                                    <!-- Language And Dropdown -->
                                    <div class="dropdown language-dropdown me-2">
                                        <?php $language=$this->session->userdata('language');?>
                                        <button class="dropdown-toggle new-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <iconify-icon icon="ion:language" width="22"></iconify-icon>
                                            <span class="mobile-d-ln-none"><?php echo ucfirstcustom($language) ?></span>
                                        </button>
                                        <ul dir="ltr" class="dropdown-menu dropdown-menu-light dropdown-menu-lang language_dropdown">
                                            <?php
                                            $dir = glob("application/language/*",GLOB_ONLYDIR);
                                            foreach ($dir as $value):
                                                $separete = explode("language/",$value);
                                            ?>
                                            <li class="lang_list">
                                                <a class="dropdown-item <?php echo ucfirstcustom($language) == ucfirstcustom($separete[1]) ? 'ln-active' : '' ?> " href="<?php echo base_url()?>Authentication/setlanguage/<?php echo escape_output($separete[1])?>">
                                                    <?php echo ucfirstcustom($separete[1])?>
                                                </a>
                                            </li>
                                            <?php
                                                endforeach;
                                            ?>
                                        </ul>
                                    </div>

                                    <!--Bell notification -->
                                    <?php 
                                        $notifications_read_count = $this->db->where('del_status','Live')->where('company_id', $this->session->userdata('company_id'))->where('outlet_id',$this->session->userdata('outlet_id'))->where('read_status','0')->get('tbl_notifications')->result();
                                    ?>
                                    <div class="dropdown notification-bell me-2" id="notification_wrap">
                                        <button class="btn-none dropdown-toggle notification_bell_icon_  position-relative icon-button" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                                            <iconify-icon class="notification-icon" icon="solar:bell-bing-broken" width="24"></iconify-icon>
                                            <span id="notification-bell-count" class="b-badge user-notification_1">
                                                <?php echo sizeof($notifications_read_count)?>
                                            </span>
                                        </button>
                                    </div>
                                    <div class="offcanvas <?php echo $is_arabic == 'Yes' ? 'offcanvas-start' : 'offcanvas-end' ?> visibility-visible" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel" aria-modal="true" role="dialog">
                                        <div class="offcanvas-header" >
                                            <div class="d-sm-block d-md-flex  justify-content-between" >
                                                <h5 id="offcanvasRightLabel" class="notification_heading" ><?php echo lang('notifications'); ?></h5>
                                            </div>
                                            <button type="button" class="btn notification-close-btn text-reset" data-bs-dismiss="offcanvas" aria-label="Close" >
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x" ><line x1="18" y1="6" x2="6" y2="18" ></line><line x1="6" y1="6" x2="18" y2="18" ></line></svg>
                                            </button>
                                        </div>
                                        <div class="offcanvas-body" >
                                            <ul class="list-group list-group-flush" id="all_notifications_show_div" >
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- User Image And Dropdown -->
                                    <ul class="menu-list">
                                        <!-- User Profile And Dropdown -->
                                        <li class="user-info-box">
                                            <div class="user-profile">
                                                <?php 
                                                    $user_image = $this->session->userdata('photo');
                                                    if($user_image){
                                                ?>
                                                    <img class="user-avatar" src="<?php echo base_url()?>uploads/employees_image/<?php echo $user_image;?>" alt="user-image">
                                                <?php } else { ?>
                                                    <img class="user-avatar" src="<?php echo base_url()?>uploads/site_settings/<?php echo 'default-admin.png';?>" alt="user-image">
                                                <?php } ?>
                                            </div>
                                            <div class="c-dropdown-menu user_profile_active">
                                                <ul>
                                                    <li class="common-margin">
                                                        <div>
                                                            <div class="user-info d-flex align-items-center">
                                                                <?php if($user_image){ ?>
                                                                    <img class="user-avatar-inner" src="<?php echo base_url()?>uploads/employees_image/<?php echo $user_image;?>" alt="user-image">
                                                                <?php } else { ?>
                                                                    <img class="user-avatar-inner" src="<?php echo base_url()?>uploads/site_settings/<?php echo 'default-admin.png';?>" alt="user-image">
                                                                <?php } ?>
                                                                <div class="ps-2">
                                                                    <p class="user-name mb-0 font-weight-700"><?php echo escape_output($this->session->userdata('full_name')); ?></p>
                                                                    <?php
                                                                        $role = getRoleNameById($this->session->userdata('role'));
                                                                    ?>
                                                                    <span class="user-role user-role-second"><?php echo escape_output($role)?></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li> 
                                                    <li><div class="dropdown-divider"></div></li>
                                                    <li class="common-margin d-flex align-items-center"><a href="<?php echo base_url()?>User/changeProfile">
                                                        <iconify-icon icon="solar:user-check-broken" width="22" class="me-2"></iconify-icon>
                                                        <?php echo lang('change_profile')?></a>
                                                    </li>
                                                    <li class="common-margin"><a href="<?php echo base_url()?>User/changePassword">
                                                        <iconify-icon icon="solar:key-broken" width="22" class="me-2"></iconify-icon>
                                                        <?php echo lang('change_password')?>
                                                        </a>
                                                    </li>
                                                    <li class="common-margin"><a href="<?php echo base_url()?>User/securityQuestion">
                                                        <iconify-icon icon="solar:question-circle-broken" width="22" class="me-2"></iconify-icon>
                                                        <?php echo lang('SetSecurityQuestion')?>
                                                        </a>
                                                    </li>
                                                    <li><div class="dropdown-divider"></div></li>
                                                    <li class="common-margin"><a href="javascript:void(0)" class="logOutTrigger">
                                                        <iconify-icon icon="solar:logout-broken" width="22" class="me-2"></iconify-icon>
                                                        <?php echo lang('logout')?></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            </header>

            <!-- // TODO: Sidebar For All Language -->
            <aside class="<?php echo $is_arabic == 'Yes' ? 'main-sidebar2' : 'main-sidebar' ?>">

                <div class="logo_Section_main_sidebar">
                    <a href="<?php echo base_url();?>Authentication/userProfile" class="logo-wrapper"
                        <?php echo isset($is_arabic) && $is_arabic == 'arabic' ? 'd-none' : '' ?>>
                        <span class="logo-lg">
                            <img src="<?php echo $site_logo;?>" class="img-circle" alt="Logo Image">
                        </span>
                        <span class="logo-mini">
                            <img src="<?php echo $site_logo;?>" class="img-circle" alt="Logo Image">
                        </span>
                    </a>
                    <a href="#" class="sidebar-toggle set_collapse" data-status="<?php echo isset($is_collapse) && $is_collapse == "No" ? '2' : '1'?>"
                        data-toggle="push-menu" role="button"
                        <?php echo isset($language) && $language == 'arabic' ? 'd-none' : '' ?>>
                        <iconify-icon icon="solar:round-alt-arrow-left-broken" width="25"></iconify-icon>
                    </a>
                </div>

                <!-- Admin Logo Part End -->
                <section class="sidebar">
                    <h3 class="display_none">&nbsp;</h3>
                    <div class="user-panel">
                        <div class="pull-left image">
                            <?php
                                if (escape_output($this->session->userdata('photo')) != '') {
                                    $photo = "uploads/employees_image/".$this->session->userdata('photo');
                                }else{
                                    $photo = '';
                                }
                            ?>
                            <img src="<?php echo base_url() . $photo; ?>" class="img-circle" alt="User Image">
                        </div>
                        <div class="pull-left info">
                            <p><?php echo escape_output($this->session->userdata('outlet_name')); ?></p>
                            <p><?php echo escape_output($this->session->userdata('full_name')); ?></p>
                        </div>
                    </div>
                    <div id="left_menu_to_scroll">
                        <ul class="sidebar-menu" data-widget="tree">
                            <li class="parent-menu treeview2">
                                <a href="<?php echo base_url(); ?>Authentication/userProfile" class="child-menu">
                                    <iconify-icon icon="solar:home-broken" width="22"></iconify-icon>
                                    <span> <?php echo lang('home'); ?></span>
                                </a>
                            </li>
                            <?php if(isServiceAccess('','','sGmsJaFJE') && (defined('FCCPATH') && FCCPATH != 'Bangladesh')){ ?>
                            <li class="treeview parent-menu">
                                <a href="javascript:void(0)">
                                    <iconify-icon icon="solar:floor-lamp-broken" width="22"></iconify-icon>
                                    <span><?php echo lang('saas'); ?></span>
                                </a>
                                
                                <ul class="treeview-menu">
                                    <li data-access="list-25" class="menu_assign_class">
                                        <a class="child-menu " href="<?php echo base_url(); ?>Service/addEditCompany">
                                            
                                            <?php echo lang('add_company'); ?>
                                        </a>
                                    </li>
                                    <li data-access="list-25" class="menu_assign_class">
                                        <a class="child-menu " href="<?php echo base_url(); ?>Service/companies">
                                            
                                            <?php echo lang('list_company'); ?>
                                        </a>
                                    </li>
                                    <li data-access="list-25" class="menu_assign_class">
                                        <a class="child-menu " href="<?php echo base_url(); ?>Service/addManualPayment">
                                            
                                            <?php echo lang('add_manual_payment'); ?>
                                        </a>
                                    </li>
                                    <li data-access="list-25" class="menu_assign_class">
                                        <a class="child-menu " href="<?php echo base_url(); ?>Service/paymentHistory">
                                            
                                            <?php echo lang('list_manual_payment'); ?>
                                        </a>
                                    </li>
                                    <li data-access="list-25" class="menu_assign_class">
                                        <a class="child-menu " href="<?php echo base_url(); ?>Service/addPricingPlan">
                                            
                                            <?php echo lang('add_pricing_plan'); ?>
                                        </a>
                                    </li>
                                    <li data-access="list-25" class="menu_assign_class">
                                        <a class="child-menu " href="<?php echo base_url(); ?>Service/pricingPlans">
                                            
                                            <?php echo lang('list_pricing_plan'); ?>
                                        </a>
                                    </li>
                                    <li data-access="edit-23" class="menu_assign_class <?= getWhiteLabelStatus() == 1 ?  'd-block' : 'd-none'?>">
                                        <a class="child-menu " href="<?php echo base_url(); ?>WhiteLabel/index">
                                            <?php echo lang('white_label'); ?>
                                        </a>
                                    </li>
                                    <li class="menu_assign_class">
                                        <a class="child-menu " href="<?php echo base_url(); ?>Authentication/logingPage">
                                            <?php echo lang('login_page'); ?>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <?php } ?>
                            <li class="treeview parent-menu">
                                <a href="javascript:void(0)">
                                    <iconify-icon icon="solar:widget-2-broken" width="22"></iconify-icon>
                                    <span><?php echo lang('outlets'); ?></span>
                                </a>
                                <ul class="treeview-menu">
                                    <li data-access="add-25" class="menu_assign_class" module-is-hide="Outlet-YES">
                                        <a class="child-menu" href="<?php echo base_url(); ?>Outlet/addEditOutlet">
                                            <?php echo lang('add_outlet'); ?>
                                        </a>
                                    </li>
                                    <li data-access="list-25" class="menu_assign_class" module-is-hide="Outlet-YES">
                                        <a class="child-menu" href="<?php echo base_url(); ?>Outlet/outlets">
                                            <?php echo lang('list_outlet'); ?>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="treeview parent-menu">
                                <a href="javascript:void(0)">
                                    <iconify-icon icon="solar:cart-large-broken" width="22"></iconify-icon>
                                    <span><?php echo lang('sale'); ?></span>
                                </a>
                                
                                <ul class="treeview-menu">
                                    <li data-access="pos-138" class="menu_assign_class" module-is-hide="Sale-YES">
                                        <a class="child-menu" href="<?php echo base_url(); ?>Sale/POS">
                                            <?php echo lang('pos_screen'); ?>
                                        </a>
                                    </li>
                                    <li data-access="list-138" class="menu_assign_class" module-is-hide="Sale-YES">
                                        <a class="child-menu" href="<?php echo base_url(); ?>Sale/sales">
                                            <?php echo lang('list_sale'); ?>
                                        </a>
                                    </li>
                                    <li data-access="add-147" class="menu_assign_class" module-is-hide="Customer-YES">
                                        <a class="child-menu" href="<?php echo base_url(); ?>Customer/addEditCustomer">
                                            <?php echo lang('add_customer'); ?>
                                        </a>
                                    </li>
                                    <li data-access="list-147" class="menu_assign_class" module-is-hide="Customer-YES">
                                        <a class="child-menu" href="<?php echo base_url(); ?>Customer/customers">
                                            <?php echo lang('list_customer'); ?>
                                        </a>
                                    </li>
                                    <li data-access="add-154" class="menu_assign_class" module-is-hide="Customer Group-YES">
                                        <a class="child-menu" href="<?php echo base_url(); ?>Group/addEditGroup">
                                            <?php echo lang('add_customer_group'); ?>
                                        </a>
                                    </li>
                                    <li data-access="list-154" class="menu_assign_class" module-is-hide="Customer Group-YES">
                                        <a class="child-menu" href="<?php echo base_url(); ?>Group/groups">
                                            <?php echo lang('list_customer_group'); ?>
                                        </a>
                                    </li>
                                    <li data-access="add-133" class="menu_assign_class " module-is-hide="Promotion-YES">
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Promotion/addEditPromotion'?>">
                                            <?php echo lang('add_promotion'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <li data-access="add-133" class="menu_assign_class " module-is-hide="Promotion-YES">
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Promotion/promotions'?>">
                                            <?php echo lang('list_promotion'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <li data-access="add-159" class="menu_assign_class " module-is-hide="Delivery Partner-YES">
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Delivery_partner/addEditPartner'?>">
                                            <?php echo lang('add_delivery_partner'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <li data-access="add-159" class="menu_assign_class " module-is-hide="Delivery Partner-YES">
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Delivery_partner/listPartner'?>">
                                            <?php echo lang('list_delivery_partner'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="treeview parent-menu">
                                <a href="javascript:void(0)" class="align-middle">
                                    <iconify-icon icon="solar:list-heart-broken" width="22"></iconify-icon>
                                    <span><?php echo lang('Item_Product'); ?></span>
                                </a>
                                
                                <ul class="treeview-menu">
                                    <li data-access="add-49" class="menu_assign_class" module-is-hide="Item-YES">
                                        <a class="child-menu " href="<?php echo base_url(); ?>Item/addEditItem">
                                            <?php echo lang('add_item'); ?>
                                        </a>
                                    </li>
                                    <li data-access="list-49" class="menu_assign_class" module-is-hide="Item-YES">
                                        <a class="child-menu " href="<?php echo base_url(); ?>Item/items">
                                            <?php echo lang('list_item'); ?>
                                        </a>
                                    </li>
                                    
                                    <li data-access="list-49" class="menu_assign_class " module-is-hide="Item-YES">
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Item/bulkItemUpdate'?>">
                                            <?php echo lang('bulk_item_update'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>


                                    <li data-access="add-60" class="menu_assign_class" module-is-hide="Item Category-YES">
                                        <a class="child-menu " href="<?php echo base_url(); ?>Category/addEditItemCategory">
                                            <?php echo lang('add_item_category'); ?>
                                        </a>
                                    </li>
                                    <li data-access="list-60" class="menu_assign_class" module-is-hide="Item Category-YES">
                                        <a class="child-menu " href="<?php echo base_url(); ?>Category/itemCategories">
                                            <?php echo lang('list_item_category'); ?>
                                        </a>
                                    </li>

                                    <li data-access="add-304" class="menu_assign_class " module-is-hide="Rack-YES">
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Rack/addEditRack'?>">
                                            <?php echo lang('add_rack'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <li data-access="list-304" class="menu_assign_class " module-is-hide="Rack-YES">
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Rack/rackList'?>">
                                            <?php echo lang('list_rack'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <li data-access="add-65" class="menu_assign_class" module-is-hide="Unit-YES">
                                        <a class="child-menu " href="<?php echo base_url(); ?>Unit/addEditUnit">
                                            <?php echo lang('add_unit'); ?>
                                        </a>
                                    </li>
                                    <li data-access="list-65" class="menu_assign_class" module-is-hide="Unit-YES">
                                        <a class="child-menu " href="<?php echo base_url(); ?>Unit/units">
                                            <?php echo lang('list_unit'); ?>
                                        </a>
                                    </li>

                                    <li data-access="add-70" class="menu_assign_class " module-is-hide="Variation Attribute-YES">
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Variation/addEditVariation'?>">
                                            <?php echo lang('add_variation_attribute'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>

                                    <li data-access="list-70" class="menu_assign_class " module-is-hide="Variation Attribute-YES">
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Variation/variations'?>">
                                            <?php echo lang('list_variation_attribute'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>

                                    <li data-access="add-297" class="menu_assign_class" module-is-hide="Brand-YES">
                                        <a class="child-menu " href="<?php echo base_url(); ?>Brand/addEditBrand">
                                            <?php echo lang('add_brand'); ?>
                                        </a>
                                    </li>
                                    <li data-access="list-297" class="menu_assign_class" module-is-hide="Brand-YES">
                                        <a class="child-menu " href="<?php echo base_url(); ?>Brand/brands">
                                            <?php echo lang('list_brand'); ?>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="parent-menu menu_assign_class treeview2" data-access="view-30" module-is-hide="Dashboard-YES">
                                <a class="child-menu " href="<?php echo base_url(); ?>Dashboard/dashboard">
                                    <iconify-icon icon="solar:chart-2-broken" width="22"></iconify-icon> 
                                    <span><?php echo lang('dashboard'); ?></span>
                                </a>
                            </li>
                            
                            <li class="parent-menu menu_assign_class treeview2" data-access="view-164" module-is-hide="Stock-YES">
                                <a class="child-menu " href="<?php echo base_url(); ?>Stock/stock">
                                    <iconify-icon icon="solar:database-broken" width="22"></iconify-icon> 
                                    <span><?php echo lang('stock'); ?></span>
                                </a>
                            </li>
                            <li class="treeview parent-menu">
                                <a href="javascript:void(0)">
                                    <iconify-icon icon="solar:archive-broken" width="22"></iconify-icon>
                                    <span><?php echo lang('purchase'); ?></span>
                                </a>
                                
                                <ul class="treeview-menu">
                                    <li data-access="add-109" class="menu_assign_class" module-is-hide="Purchase-YES">
                                        <a class="child-menu " href="<?php echo base_url(); ?>Purchase/addEditPurchase">
                                            <?php echo lang('add_purchase'); ?>
                                        </a>
                                    </li>
                                    <li data-access="list-109" class="menu_assign_class" module-is-hide="Purchase-YES">
                                        <a class="child-menu " href="<?php echo base_url(); ?>Purchase/purchases">
                                            <?php echo lang('list_purchase'); ?>
                                        </a>
                                    </li>
                                    <li data-access="add-117" class="menu_assign_class" module-is-hide="Supplier-YES">
                                        <a class="child-menu " href="<?php echo base_url(); ?>Supplier/addEditSupplier">
                                            <?php echo lang('add_supplier'); ?>
                                        </a>
                                    </li>
                                    <li data-access="list-117" class="menu_assign_class" module-is-hide="Supplier-YES">
                                        <a class="child-menu " href="<?php echo base_url(); ?>Supplier/suppliers">
                                            <?php echo lang('list_supplier'); ?>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="treeview parent-menu">
                                <a href="javascript:void(0)">
                                    <iconify-icon icon="solar:card-recive-broken" width="22"></iconify-icon>
                                    <span><?php echo lang('customer_receive'); ?></span>
                                </a>
                                
                                <ul class="treeview-menu">
                                    <li data-access="add-198" class="menu_assign_class" module-is-hide="Customer Receive-YES">
                                        <a class="child-menu " href="<?php echo base_url(); ?>Customer_due_receive/addCustomerDueReceive">
                                            <?php echo lang('add_customer_due_receive'); ?>
                                        </a>
                                    </li>
                                    <li data-access="list-198" class="menu_assign_class" module-is-hide="Customer Receive-YES">
                                        <a class="child-menu " href="<?php echo base_url(); ?>Customer_due_receive/customerDueReceives">
                                            <?php echo lang('list_customer_due_receive'); ?>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="treeview parent-menu">
                                <a href="javascript:void(0)">
                                    <iconify-icon icon="solar:card-send-broken" width="22"></iconify-icon>
                                    <span><?php echo lang('supplier_payment'); ?></span>
                                </a>
                                
                                <ul class="treeview-menu">
                                    <li data-access="add-192" class="menu_assign_class" module-is-hide="Supplier Payment-YES">
                                        <a class="child-menu " href="<?php echo base_url(); ?>SupplierPayment/addSupplierPayment">
                                            <?php echo lang('add_supplier_payment'); ?>
                                        </a>
                                    </li>
                                    <li data-access="list-192" class="menu_assign_class" module-is-hide="Supplier Payment-YES">
                                        <a class="child-menu " href="<?php echo base_url(); ?>SupplierPayment/supplierPayments">
                                            <?php echo lang('list_supplier_payment'); ?>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="treeview parent-menu">
                                <a href="javascript:void(0)">
                                    <iconify-icon icon="solar:wallet-money-broken" width="22"></iconify-icon>
                                    <span><?php echo lang('Accounting'); ?></span> 
                                </a>
                                
                                <ul class="treeview-menu">
                                    <li data-access="add-218" class="menu_assign_class" module-is-hide="Account-YES">
                                        <a class="child-menu " href="<?php echo base_url(); ?>PaymentMethod/addEditPaymentMethod">
                                            <?php echo lang('add_account'); ?>
                                        </a>
                                    </li>
                                    <li data-access="list-218" class="menu_assign_class" module-is-hide="Account-YES">
                                        <a class="child-menu " href="<?php echo base_url(); ?>PaymentMethod/paymentMethods">
                                            <?php echo lang('list_account'); ?>
                                        </a>
                                    </li>
                                    <li data-access="add-223" class="menu_assign_class " module-is-hide="Diposit-YES">
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Deposit/addEditDeposit'?>">
                                            <?php echo lang('add_deposit_or_withdraw'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>

                                    <li data-access="list-223" class="menu_assign_class " module-is-hide="Diposit-YES">
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Deposit/deposits'?>">
                                            <?php echo lang('list_deposit_or_withdraw'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <li data-access="list-228" class="menu_assign_class " module-is-hide="Balance Sheet-YES">
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Accounting/balanceStatement'?>">
                                            <?php echo lang('Balance_Statement'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <li data-access="list-230" class="menu_assign_class " module-is-hide="Trial Balance-YES">
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Accounting/trialBalance'?>">
                                            <?php echo lang('Trial_Balance'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <li data-access="list-232" class="menu_assign_class " module-is-hide="Balance Statement-YES">
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Accounting/balanceSheet'?>">
                                            <?php echo lang('Balance_Sheet'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                   
                                </ul>
                            </li>
                            <li class="treeview parent-menu">
                                <a href="javascript:void(0)">
                                    <iconify-icon icon="solar:clock-square-broken" width="22"></iconify-icon>
                                    <span><?php echo lang('attendance'); ?></span>
                                </a>
                                
                                <ul class="treeview-menu">

                                    <li data-access="add-234" class="menu_assign_class " module-is-hide="Attendance-YES">
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Attendance/addEditAttendance'?>">
                                            <?php echo lang('add_attendance'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <li data-access="list-234" class="menu_assign_class " module-is-hide="Attendance-YES">
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Attendance/attendances'?>">
                                            <?php echo lang('list_attendance'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    
                                </ul>
                            </li>
                            <li class="treeview parent-menu">
                                <a href="javascript:void(0)">
                                    <iconify-icon icon="solar:diagram-down-broken" width="22"></iconify-icon>
                                    <span><?php echo lang('report'); ?></span>
                                </a>
                                
                                <ul class="treeview-menu">
                                    <li data-access="register_report-249" class="menu_assign_class " module-is-hide="Register Report-YES">
                                        <a class="child-menu " href="<?php echo base_url(); ?>Report/registerReport">
                                            <?php echo lang('register_report'); ?>
                                        </a>
                                    </li>

                                    <li data-access="zReport-249" class="menu_assign_class " module-is-hide="Z Report-YES">
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Report/zReport'?>">
                                            <?php echo lang('z_report'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <li data-access="daily_summary_report-249" class="menu_assign_class " module-is-hide="Daily Summary Report-YES">
                                        <a class="child-menu " href="<?php echo base_url(); ?>Report/dailySummaryReport">
                                            <?php echo lang('daily_summary_report'); ?>
                                        </a>
                                    </li>
                                    <li data-access="sale_report-249" class="menu_assign_class" module-is-hide="Sale Report-YES">
                                        <a class="child-menu " href="<?php echo base_url(); ?>Report/saleReport">
                                            <?php echo lang('sale_report'); ?>
                                        </a>
                                    </li>
                                    <li data-access="sale_report-249" class="menu_assign_class" module-is-hide="Sale Report-YES">
                                        <a class="child-menu " href="<?php echo base_url(); ?>Report/dueSaleReport">
                                            <?php echo lang('due_sale_report'); ?>
                                        </a>
                                    </li>

                                    <li data-access="service_sale_report-249" class="menu_assign_class" module-is-hide="Service Sale Report-YES">
                                        <a class="child-menu " href="<?php echo base_url(); ?>Report/serviceSaleReport">
                                            <?php echo lang('service_sale_report'); ?>
                                        </a>
                                    </li>
                                    <li data-access="service_sale_report-249" class="menu_assign_class " module-is-hide="Combo Service Report-YES">
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Report/comboServiceReport'?>">
                                            <?php echo lang('combo_service_report'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <li data-access="stock_report-249" class="menu_assign_class" module-is-hide="Stock Report-YES">
                                        <a class="child-menu " href="<?php echo base_url(); ?>Report/stockReport">
                                            <?php echo lang('stock_report'); ?>
                                        </a>
                                    </li>
                                    <li data-access="stock_report-249" class="menu_assign_class " module-is-hide="Stock Report-YES">
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Report/expiryStock'?>">
                                            <?php echo lang('medicine_expire_report'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <li data-access="employee_sale_report-249" class="menu_assign_class " module-is-hide="Employee Sale Report-YES">
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Report/employeeSaleReport'?>">
                                            <?php echo lang('employee_sale_report'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <li data-access="customer_receive_report-249" class="menu_assign_class" module-is-hide="Customer Receive Report-YES">
                                        <a class="child-menu " href="<?php echo base_url(); ?>Report/customerDueReceiveReport">
                                            <?php echo lang('customer_due_receive_report'); ?>
                                        </a>
                                    </li>

                                    <li data-access="attendance_report-249" class="menu_assign_class " module-is-hide="Attandance Report-YES">
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Report/attendanceReport'?>">
                                            <?php echo lang('attendance_report'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <li data-access="product_profit_report-249" class="menu_assign_class " module-is-hide="Product Profit Report-YES">
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Report/productProfitReport'?>">
                                            <?php echo lang('productProfitReport'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    
                                    <li data-access="supplier_ledger-249" class="menu_assign_class" module-is-hide="Supplier Ledger Report-YES">
                                        <a class="child-menu " href="<?php echo base_url(); ?>Company_report/supplierLedgerReport">
                                            <?php echo lang('supplier_ledger_report'); ?>
                                        </a>
                                    </li>
                                    <li data-access="supplier_balance_report-249" class="menu_assign_class " module-is-hide="Supplier Balance Report-YES">
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Company_report/supplierBalanceReport'?>">
                                            <?php echo lang('supplier_balance_report'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <li data-access="customer_ledger-249" class="menu_assign_class " module-is-hide="Customer Ledger Report-YES">
                                        <a class="child-menu " href="<?php echo base_url(); ?>Company_report/customerLedgerReport">
                                            <?php echo lang('customer_ledger_report'); ?>
                                        </a>
                                    </li>
                                    <li data-access="customer_balance_report-249" class="menu_assign_class " module-is-hide="Customer Balance Report-YES">
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Company_report/customerBalanceReport'?>">
                                            <?php echo lang('customer_balance_report'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <?php if(!moduleIsHideCheck('Servicing-YES')){ ?>
                                    <li data-access="servicing_report-249" class="menu_assign_class " module-is-hide="Servicing Report-YES">
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Report/servicingReport'?>">
                                            <?php echo lang('servicing_report'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <?php } ?>
                                    <li data-access="product_sale_report-249" class="menu_assign_class " module-is-hide="Product Sale Report-YES">
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Report/productSaleReport'?>">
                                            <?php echo lang('productSaleReport'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <?php 
                                    $collect_tax = $this->session->userdata('collect_tax');
                                    if($collect_tax=="Yes"){
                                    ?>
                                    <li data-access="tax_report-249" class="menu_assign_class " module-is-hide="Tax Report-YES">
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Report/taxReport'?>">
                                            <?php echo lang('tax'); ?> <?php echo lang('report'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <?php } ?>
                                    <li data-access="detailed_sale_report-249" class="menu_assign_class " module-is-hide="Detailed Sale Report-YES">
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Report/detailedSaleReport'?>">
                                            <?php echo lang('detailed_sale_report'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <li data-access="low_stock_report-249" class="menu_assign_class " module-is-hide="Low Stock Report-YES">
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Report/getStockAlertList'?>">
                                            <?php echo lang('low_stock_report'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    
                                    <li data-access="profit_loss_report-249" class="menu_assign_class" module-is-hide="Profit Loss Report-YES">
                                        <a class="child-menu " href="<?php echo base_url(); ?>Report/profitLossReport">
                                            <?php echo lang('profit_loss_report'); ?>
                                        </a>
                                    </li>
                                    <li data-access="purchase_report-249" class="menu_assign_class " module-is-hide="Purchase Report-YES">
                                        <a class="child-menu " href="<?php echo base_url(); ?>Report/purchaseReportByDate">
                                            <?php echo lang('purchase_report'); ?>
                                        </a>
                                    </li>
                                    <li data-access="product_purchase_report-249" class="menu_assign_class " module-is-hide="Product Purchase Report-YES">
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Report/productPurchaseReport'?>">
                                            <?php echo lang('productPurchaseReport'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <li data-access="expense_report-249" class="menu_assign_class" module-is-hide="Expense Report-YES">
                                        <a class="child-menu " href="<?php echo base_url(); ?>Report/expenseReport">
                                            <?php echo lang('expense_report'); ?>
                                        </a>
                                    </li>
                                    <li data-access="income_report-249" class="menu_assign_class " module-is-hide="Income Report-YES">
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Report/incomeReport'?>">
                                            <?php echo lang('income_report'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <li data-access="salary_report-249" class="menu_assign_class " module-is-hide="Salary Report-YES">
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Report/salaryReport'?>">
                                            <?php echo lang('salary_report'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <li data-access="purchase_return_report-249" class="menu_assign_class " module-is-hide="Purchase Return Report-YES">
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Report/purchaseReturnReport'?>">
                                            <?php echo lang('purchase_return_report'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <li data-access="sale_return_report-249" class="menu_assign_class " module-is-hide="Sale Return Report-YES">
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Report/saleReturnReport'?>">
                                            <?php echo lang('sale_return_report'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <?php if(!moduleIsHideCheck('Damage-YES')){ ?>
                                    <li data-access="damage_report-249" class="menu_assign_class " module-is-hide="Damage Report-YES">
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Report/damageReport'?>">
                                            <?php echo lang('damage_report'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <?php } ?>
                                    <?php if(!moduleIsHideCheck('Installment-YES')){ ?>
                                    <li data-access="installment_report-249" class="menu_assign_class " module-is-hide="Installment Report-YES">
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Report/installmentReport'?>">
                                            <?php echo lang('Installment Report'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <li data-access="installment_due_report-249" class="menu_assign_class " module-is-hide="Installment Due Report-YES">
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Report/installmentDueReport'?>">
                                            <?php echo lang('installmentDueReport'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <?php } ?>
                                    
                                    <li data-access="item_tracing_report-249" class="menu_assign_class " module-is-hide="Item Tracing Report-YES">
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Report/itemMoving'?>">
                                            <?php echo lang('Item_Tracing'); ?> <?php echo lang('report'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <li data-access="price_history_report-249" class="menu_assign_class " module-is-hide="Price History Report-YES">
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Report/priceHistory'?>">
                                            <?php echo lang('price_history'); ?> <?php echo lang('report'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <li data-access="cash_flow_report-249" class="menu_assign_class " module-is-hide="Cash Flow Report-YES">
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Company_report/cashFlowReport'?>">
                                            <?php echo lang('cash_flow'); ?> <?php echo lang('report'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <li data-access="available_loyalty_point-249" class="menu_assign_class " module-is-hide="Available Loyalty Point Report-YES">
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Report/availableLoyaltyPointReport'?>">
                                            <?php echo lang('available_loyalty_point_report'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <li data-access="usage_loyalty_point-249" class="menu_assign_class " module-is-hide="Usages Loyalty Point Report-YES">
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Report/usageLoyaltyPointReport'?>">
                                            <?php echo lang('usage_loyalty_point_report'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="treeview parent-menu">
                                <a href="javascript:void(0)">
                                    <iconify-icon icon="solar:rewind-forward-broken" width="22"></iconify-icon>
                                    <span><?php echo lang('expense'); ?></span> 
                                </a>
                                
                                <ul class="treeview-menu">
                                    <li data-access="add-172" class="menu_assign_class" module-is-hide="Expense-YES">
                                        <a class="child-menu " href="<?php echo base_url(); ?>Expense/addEditExpense">
                                            <?php echo lang('add_expense'); ?>
                                        </a>
                                    </li>
                                    <li data-access="list-172" class="menu_assign_class" module-is-hide="Expense-YES">
                                        <a class="child-menu " href="<?php echo base_url(); ?>Expense/expenses">
                                            <?php echo lang('list_expense'); ?>
                                        </a>
                                    </li>
                                    <li data-access="add-177" class="menu_assign_class" module-is-hide="Expense Category-YES">
                                        <a class="child-menu " href="<?php echo base_url(); ?>ExpenseItem/addEditExpenseItem">
                                            <?php echo lang('add_expense_item'); ?>
                                        </a>
                                    </li>
                                    <li data-access="list-177" class="menu_assign_class" module-is-hide="Expense Category-YES">
                                        <a class="child-menu " href="<?php echo base_url(); ?>ExpenseItem/expenseItems">
                                            <?php echo lang('list_expense_item'); ?>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="treeview parent-menu">
                                <a href="javascript:void(0)">
                                    <iconify-icon icon="solar:rewind-back-broken" width="22"></iconify-icon>
                                    <span><?php echo lang('income'); ?></span>
                                </a>
                                
                                <ul class="treeview-menu ">
                                    <li data-access="add-182" class="menu_assign_class " module-is-hide="Income-YES">
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Income/addEditIncome'?>">
                                            <?php echo lang('add_income'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <li data-access="list-182" class="menu_assign_class " module-is-hide="Income-YES">
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Income/incomes'?>">
                                            <?php echo lang('list_income'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <li data-access="add-187" class="menu_assign_class " module-is-hide="Income Category-YES">
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'IncomeItem/addEditIncomeItem'?>">
                                            <?php echo lang('add_income_item'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <li data-access="list-187" class="menu_assign_class " module-is-hide="Income Category-YES">
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'IncomeItem/incomeItems'?>">
                                            <?php echo lang('list_income_item'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="treeview parent-menu ">
                                <a href="javascript:void(0)">
                                    <iconify-icon icon="solar:multiple-forward-left-broken" width="22"></iconify-icon>
                                    <span><?php echo lang('sale_return'); ?></span>
                                </a>
                                
                                <ul class="treeview-menu">
                                    <li data-access="add-204" class="menu_assign_class " module-is-hide="Sale Return-YES">
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Sale_return/addEditSaleReturn'?>">
                                            <?php echo lang('add_sale_return'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <li data-access="list-204" class="menu_assign_class " module-is-hide="Sale Return-YES">
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Sale_return/saleReturns'?>">
                                            <?php echo lang('list_sale_return'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="treeview parent-menu ">
                                <a href="javascript:void(0)">
                                    <iconify-icon icon="solar:multiple-forward-right-broken" width="22"></iconify-icon>
                                    <span><?php echo lang('purchase_ruturn'); ?></span>
                                </a>
                                <ul class="treeview-menu">


                                    <li data-access="add-211" class="menu_assign_class " module-is-hide="Purchase Return-YES">
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Purchase_return/addEditPurchaseReturn'?>">
                                            <?php echo lang('add_purchase_ruturn'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <li data-access="list-211" class="menu_assign_class " module-is-hide="Purchase Return-YES">
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Purchase_return/purchaseReturns'?>">
                                            <?php echo lang('list_purchase_ruturn'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="treeview parent-menu">
                                <a href="javascript:void(0)" class="child-menu ">
                                    <iconify-icon icon="solar:settings-broken" width="22"></iconify-icon>
                                    <span><?php echo lang('setting'); ?></span>
                                </a>
                                
                                <ul class="treeview-menu">
                                    <?php 
                                    $user_id = $this->session->userdata('user_id');
                                    $company_id = $this->session->userdata('company_id');
                                    if(isServiceAccess2($user_id, $company_id, 'sGmsJaFJE') == 'Saas Company'){ ?>
                                    <li data-access="edit-1" class="menu_assign_class ">
                                        <a class="child-menu " href="<?php echo base_url(); ?>Service/planDetails">
                                            <?php echo lang('plan_details'); ?>
                                        </a>
                                    </li>
                                    <?php } ?>
                                    <li data-access="edit-1" class="menu_assign_class" module-is-hide="Setting-YES">
                                        <a class="child-menu" href="<?php echo base_url(); ?>Setting/index">
                                            <?php echo lang('setting'); ?>
                                        </a>
                                    </li>
                                    <li data-access="edit-1" class="menu_assign_class" module-is-hide="Setting-YES">
                                        <a class="child-menu" href="<?php echo base_url(); ?>Setting/invoiceSetting">
                                            <?php echo lang('invoice_configuration'); ?>
                                        </a>
                                    </li>
                                   
                                    <li data-access="edit-1" class="menu_assign_class ">
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Setting/moduleManagement'?>">
                                            <?php echo lang('module_management'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <li data-access="whatsappSetting-327" class="menu_assign_class " module-is-hide="Whatsapp Setting-YES"> 
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Setting/whatsappSetting'?>">
                                            <?php echo lang('whatsapp_setting'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <li data-access="add-3" class="menu_assign_class" module-is-hide="Denomination-YES">
                                        <a class="child-menu " href="<?php echo base_url(); ?>Denomination/addEditDenomination">
                                            <?php echo lang('add'); ?> <?php echo lang('denomination'); ?>
                                        </a>
                                    </li>
                                    <li data-access="list-3" class="menu_assign_class" module-is-hide="Denomination-YES">
                                        <a class="child-menu " href="<?php echo base_url(); ?>Denomination/denominations"> 
                                            <?php echo lang('list'); ?> <?php echo lang('denomination'); ?>
                                        </a>
                                    </li>
                                    <li data-access="add-340" class="menu_assign_class" module-is-hide="Counter-YES">
                                        <a class="child-menu " href="<?php echo base_url(); ?>Counter/addEditCounter">
                                            <?php echo lang('add_counter'); ?>
                                        </a>
                                    </li>
                                    <li data-access="list-340" class="menu_assign_class" module-is-hide="Counter-YES">
                                        <a class="child-menu " href="<?php echo base_url(); ?>Counter/counters">
                                            <?php echo lang('list_counter'); ?>
                                        </a>
                                    </li>
                                    <li data-access="edit-8" class="menu_assign_class " module-is-hide="Tax Setting-YES"> 
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Tax_setting/tax'?>">
                                            <?php echo lang('Tax_Setting'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <li data-access="edit-10" class="menu_assign_class " module-is-hide="Email Setting-YES"> 
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Email_setting/emailConfiguration'?>">
                                            <?php echo lang('Email_Setting'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <li data-access="edit-12" class="menu_assign_class " module-is-hide="SMS Setting-YES"> 
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Short_message_service/smsService'?>">
                                            <?php echo lang('SMS_Setting'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <li data-access="edit-14" class="menu_assign_class " module-is-hide="Printer Setup-YES"> 
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Printer/printerSetup'?>">
                                            <?php echo lang('printer_setup'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>

                                    <?php if(!isServiceAccess('','','sGmsJaFJE') && (defined('FCCPATH') && FCCPATH != 'Bangladesh')){ ?>
                                    <li data-access="edit-23" class="menu_assign_class <?= getWhiteLabelStatus() == 1 ?  'd-block' : 'd-none'?>" module-is-hide="White Label-YES">
                                        <a class="child-menu " href="<?php echo base_url(); ?>WhiteLabel/index">
                                            <?php echo lang('white_label'); ?>
                                        </a>
                                    </li>
                                    <li data-access="edit-23" class="menu_assign_class " module-is-hide="Login Page-YES">
                                        <a class="child-menu " href="<?php echo base_url(); ?>Authentication/logingPage">
                                            <?php echo lang('login_page'); ?>
                                        </a>
                                    </li>
                                    <?php } ?>

                                    <li data-access="edit-335" class="menu_assign_class " module-is-hide="Payment Getway-YES"> 
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Payment_getway/paymentGetway'?>">
                                            <?php echo lang('payment_getway'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>

                                    <li data-access="edit-311" class="menu_assign_class " module-is-hide="Multiple Currency-YES"> 
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'MultipleCurrency/addEditMultipleCurrency'?>">
                                            <?php echo lang('add_multiple_currency'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <li data-access="edit-311" class="menu_assign_class " module-is-hide="Multiple Currency-YES"> 
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'MultipleCurrency/multipleCurrencies'?>">
                                            <?php echo lang('list_multiple_currency'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <li data-access="add_dummy_data-325" class="menu_assign_class " module-is-hide="Import Dummy Data-YES"> 
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : 'add_dummy_data'?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Setting/add_dummy_data'?>">
                                            <?php echo lang('add_dummy_data'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <li data-access="deleteDummyData-329" class="menu_assign_class " module-is-hide="Delete Dummy Data-YES"> 
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : 'delete'?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Setting/deleteDummyData'?>">
                                            <?php echo lang('delete_dummy_data'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <li data-access="wipeTransactionalData-331" class="menu_assign_class " module-is-hide="Wipe Transactional Data-YES"> 
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : 'delete'?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Setting/wipeTransactionalData'?>">
                                            <?php echo lang('wipe_transactional_data'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <li data-access="wipeAllData-333" class="menu_assign_class " module-is-hide="Wipe All Data-YES"> 
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : 'delete'?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Setting/wipeAllData'?>">
                                            <?php echo lang('wipe_all_data'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="treeview parent-menu">
                                <a href="javascript:void(0)">
                                    <iconify-icon icon="solar:shield-keyhole-minimalistic-broken" width="22"></iconify-icon>
                                    <span><?php echo lang('authentication'); ?></span>
                                </a>
                                
                                <ul class="treeview-menu">
                                    <li data-access="add-282" class="menu_assign_class" module-is-hide="Role Management-YES">
                                        <a class="child-menu " href="<?php echo base_url(); ?>Role/addEditRole">
                                            <?php echo lang('add_role'); ?>
                                        </a>
                                    </li>
                                    <li data-access="list-282" class="menu_assign_class" module-is-hide="Role Management-YES">
                                        <a class="child-menu " href="<?php echo base_url(); ?>Role/listRole">
                                            <?php echo lang('list_role'); ?>
                                        </a>
                                    </li>
                                    <li data-access="add-287" class="menu_assign_class" module-is-hide="Employee Management-YES">
                                        <a class="child-menu " href="<?php echo base_url(); ?>User/addEditUser">
                                            <?php echo lang('add_employee'); ?>
                                        </a>
                                    </li>
                                    <li data-access="list-287" class="menu_assign_class" module-is-hide="Employee Management-YES">
                                        <a class="child-menu " href="<?php echo base_url(); ?>User/users">
                                            <?php echo lang('list_employee'); ?>
                                        </a>
                                    </li>
                                    <li data-access="change_profile-287" class="menu_assign_class" module-is-hide="Employee Management-YES">
                                        <a class="child-menu " href="<?php echo base_url(); ?>User/changeProfile">
                                            <?php echo lang('change_profile'); ?>
                                        </a>
                                    </li>
                                    <li data-access="change_password-287" class="menu_assign_class" module-is-hide="Employee Management-YES">
                                        <a class="child-menu " href="<?php echo base_url(); ?>User/changePassword">
                                            <?php echo lang('change_password'); ?>
                                        </a>
                                    </li>
                                    <li data-access="set_security_quatation-287" class="menu_assign_class" module-is-hide="Employee Management-YES">
                                        <a class="child-menu " href="<?php echo base_url(); ?>User/securityQuestion">
                                            <?php echo lang('SetSecurityQuestion'); ?>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            
                            <?php
                            $i_sale = $this->session->userdata('i_sale');
                            if(isset($i_sale) && $i_sale=="Yes"){ ?>
                                <li class="treeview parent-menu">
                                    <a href="javascript:void(0)">
                                        <iconify-icon icon="solar:layers-broken" width="22"></iconify-icon>
                                        <span><?php echo lang('installment_sales'); ?></span>
                                    </a>
                                    
                                    <ul class="treeview-menu">
                                        
                                        <li data-access="add-93" class="menu_assign_class " module-is-hide="Installment Customer-YES"> 
                                            <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Installment/addEditCustomer'?>">
                                                <?php echo lang('add_installment_customer'); ?>
                                                <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                            </a>
                                        </li>
                                        <li data-access="list-93" class="menu_assign_class " module-is-hide="Installment Customer-YES"> 
                                            <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Installment/customers'?>">
                                                <?php echo lang('list_installment_customer'); ?>
                                                <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                            </a>
                                        </li>
                                        <li data-access="add-100" class="menu_assign_class " module-is-hide="Installment Sale-YES"> 
                                            <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Installment/addEditInstallmentSale'?>">
                                                <?php echo lang('add_installment_sale'); ?>
                                                <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                            </a>
                                        </li>
                                        <li data-access="list-100" class="menu_assign_class " module-is-hide="Installment Sale-YES"> 
                                            <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Installment/installmentSales'?>">
                                                <?php echo lang('list_installment_sales'); ?>
                                                <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                            </a>
                                        </li>
                                        <li data-access="installment_collection-100" class="menu_assign_class " module-is-hide="Installment Sale-YES"> 
                                            <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Installment/installmentCollections'?>">
                                                <?php echo lang('installment_collection'); ?>
                                                <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                            </a>
                                        </li>
                                        <li data-access="due_installment-100" class="menu_assign_class " module-is-hide="Installment Sale-YES"> 
                                            <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Installment/listDueInstallment'?>">
                                                <?php echo lang('installment_collection'); ?>
                                                <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                            </a>
                                        </li>
                                        
                                    </ul>
                                </li>
                            <?php } ?>
                            <li class="treeview parent-menu">
                                <a href="javascript:void(0)">
                                    <iconify-icon icon="solar:sunset-broken" width="22"></iconify-icon>
                                    <span><?php echo lang('warranty_servicing'); ?></span>
                                </a>
                                
                                <ul class="treeview-menu">
                                    <li data-access="add-75" class="menu_assign_class" module-is-hide="Servicing-YES">
                                        <a class="child-menu " href="<?php echo base_url();?>Servicing/addEditServicing">
                                            <?php echo lang('add_servicing'); ?>
                                        </a>
                                    </li>
                                    <li data-access="list-75" class="menu_assign_class" module-is-hide="Servicing-YES">
                                        <a class="child-menu " href="<?php echo base_url();?>Servicing/listServicing">
                                            <?php echo lang('list_servicing'); ?>
                                        </a>
                                    </li>
                                    
                                    <li data-access="filter-85" class="menu_assign_class " module-is-hide="Warranty-YES"> 
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Warranty/checkWarranty'?>">
                                            <?php echo lang('warranty_checking'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <li data-access="add-80" class="menu_assign_class " module-is-hide="Warranty-YES"> 
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'WarrantyProducts/addEditWarrantyProduct'?>">
                                            <?php echo lang('add_warranty'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <li data-access="list-80" class="menu_assign_class " module-is-hide="Warranty-YES"> 
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'WarrantyProducts/listWarrantyProduct'?>">
                                            <?php echo lang('list_warranty'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            
                            <li class="treeview parent-menu ">
                                <a href="javascript:void(0)">
                                    <iconify-icon icon="solar:transmission-broken" width="22"></iconify-icon>
                                    <span><?php echo lang('salary_payroll'); ?></span>
                                </a>
                                
                                <ul class="treeview-menu">
                                    <li data-access="list-87" class="menu_assign_class " module-is-hide="Salary-YES"> 
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Salary/generate'?>">
                                            <?php echo lang('list_salary_payroll'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="treeview parent-menu ">
                                <a href="javascript:void(0)" class="align-middle">
                                    <iconify-icon icon="solar:cassette-broken" width="22"></iconify-icon>
                                    <span><?php echo lang('fixed_assets'); ?></span>
                                </a>
                                
                                <ul class="treeview-menu">
                                    <li data-access="add-32" class="menu_assign_class " module-is-hide="Fixed Item-YES"> 
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Fixed_assets/addEditItem'?>">
                                            <?php echo lang('add_item'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <li data-access="list-32" class="menu_assign_class " module-is-hide="Fixed Item-YES"> 
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Fixed_assets/listItem'?>">
                                            <?php echo lang('list_item'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <li data-access="add-37" class="menu_assign_class " module-is-hide="Stock In-YES"> 
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Fixed_asset_stock/addEditStock'?>">
                                            <?php echo lang('add_stock_in'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <li data-access="list-37" class="menu_assign_class " module-is-hide="Stock In-YES"> 
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Fixed_asset_stock/listStock'?>">
                                            <?php echo lang('list_stock_in'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <li data-access="add-42" class="menu_assign_class " module-is-hide="Stock Out-YES"> 
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Fixed_asset_stock_out/addEditStockOut'?>">
                                            <?php echo lang('add_stock_out'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <li data-access="list-42" class="menu_assign_class " module-is-hide="Stock Out-YES"> 
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Fixed_asset_stock_out/listStockOut'?>">
                                            <?php echo lang('list_stock_out'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <li data-access="view-47" class="menu_assign_class " module-is-hide="Stock Out-YES"> 
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Fixed_asset_stock/stocks'?>">
                                            <?php echo lang('stock'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="parent-menu menu_assign_class treeview2" data-access="list-350" module-is-hide="Booking-YES">
                                <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Booking/booking'?>">
                                    <iconify-icon icon="solar:bookmark-broken" width="22"></iconify-icon>
                                    <span><?php echo lang('booking'); ?></span>
                                </a>
                            </li>
                            <li class="treeview parent-menu ">
                                <a href="javascript:void(0)">
                                    <iconify-icon icon="solar:ruler-pen-broken" width="22"></iconify-icon>
                                    <span><?php echo lang('quotation'); ?></span>
                                </a>
                                
                                <ul class="treeview-menu">
                                    <li data-access="add-239" class="menu_assign_class " module-is-hide="Quatation-YES"> 
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Quotation/addEditQuotation'?>">
                                            <?php echo lang('add_quotation'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <li data-access="list-239" class="menu_assign_class " module-is-hide="Quatation-YES"> 
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Quotation/quotations'?>">
                                            <?php echo lang('list_quotation'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="treeview parent-menu ">
                                <a href="javascript:void(0)">
                                    <iconify-icon icon="solar:bicycling-round-broken" width="22"></iconify-icon>
                                    <span><?php echo lang('transfer'); ?></span>
                                </a>
                                
                                <ul class="treeview-menu">
                                    <li data-access="add-125" class="menu_assign_class " module-is-hide="Transfer-YES"> 
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Transfer/addEditTransfer'?>">
                                            <?php echo lang('add_transfer'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <li data-access="list-125" class="menu_assign_class " module-is-hide="Transfer-YES"> 
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Transfer/transfers'?>">
                                            <?php echo lang('list_transfer'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="treeview parent-menu ">
                                <a href="javascript:void(0)">
                                    <iconify-icon icon="solar:trash-bin-minimalistic-broken" width="22"></iconify-icon>
                                    <span><?php echo lang('damage'); ?></span>
                                </a>
                                
                                <ul class="treeview-menu">
                                    <li data-access="add-166" class="menu_assign_class " module-is-hide="Damage-YES"> 
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Damage/addEditDamage'?>">
                                            <?php echo lang('add_damage'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                    <li data-access="list-166" class="menu_assign_class " module-is-hide="Damage-YES"> 
                                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Damage/damages'?>">
                                            <?php echo lang('list_damage'); ?>
                                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <?php 
                            $company_id = $this->session->userdata('company_id');
                            $user_id = $this->session->userdata('user_id');
                            if((isServiceAccess2($user_id, $company_id,'sGmsJaFJE') == 'Not SaaS') && FCCPATH != 'Bangladesh'){ ?>
                            <li data-access="update-247" class="menu_assign_class parent-menu treeview2" module-is-hide="Update Software-YES">
                                <a class="child-menu " href="<?php echo base_url(); ?>Update/index">
                                    <iconify-icon icon="solar:cloud-download-broken" width="22"></iconify-icon>
                                    <span><?php echo lang('update_software'); ?></span>
                                </a>
                            </li>
                            <li data-access="uninstall-318" class="menu_assign_class parent-menu treeview2" module-is-hide="Uninstall Licence-YES">
                                <a class="child-menu " href="<?php echo base_url(); ?>Update/UninstallLicense">
                                    <iconify-icon icon="solar:cloud-cross-broken" width="22"></iconify-icon>
                                    <span><?php echo lang('UninstallLicense') ?></span>
                                </a>
                            </li>
                            <?php }  ?>

                            <?php if((defined('FCCPATH') && FCCPATH == 'Bangladesh')){?>
                            <li data-access="uninstall-318" class="menu_assign_class parent-menu treeview2" module-is-hide="Uninstall Licence-YES">
                                <a class="child-menu " href="<?php echo base_url(); ?>Update/upgradeLicense">
                                    <iconify-icon icon="solar:cloud-download-broken" width="22"></iconify-icon>
                                    <span><?php echo lang('upgrade_package') ?></span>
                                </a>
                            </li>
                            <?php }  ?>
                        </ul>
                    </div>
                </section>
                <!-- /.sidebar -->
            </aside>


            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper <?php echo $is_arabic == 'Yes' ? 'content-wrapper-2' : 'content-wrapper-1' ?>">
                <div class="sidebar_sub_menu">
                </div>
                <!-- Main content -->
                <?php
                if (isset($main_content)) {
                    echo $main_content;
                }
                ?>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
            <footer class="main-footer">
                <div class="footer-inner-area">
                    <p>
                        <?php echo escape_output($site_footer); ?> <?php echo lang('by');?> 
                        <a class="text-decoration-none site-color footer_link" target="_blank" href="<?php echo escape_output($site_link); ?>"><?php echo escape_output($site_title); ?></a>  
                        <span class="footer_version"><?php echo lang('version');?> <?php echo getVersionNumber();?></span>  
                    </p>
                </div>
            </footer>
            <?php if(APPLICATION_MODE == 'demo'){ ?>
            <a href="<?php echo isServiceAccess2('', '', 'sGmsJaFJE') == 'Not SaaS' ? ((defined('FCCPATH') && FCCPATH == 'Bangladesh') ? 'https://dsbeta.work/lcdemo/biponi.php' : 'https://dsbeta.work/dsdemo/off_pos.php') : 'https://api.whatsapp.com/send?phone=880181231633'?>" target="_blank" class="btn buy-now"><iconify-icon icon="solar:cart-large-broken" width="18" class="me-2"></iconify-icon> Buy Now</a>
            <?php } ?>
        </div>

        <div class="modal fade" id="todaysSummary" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h3 class="modal-title"><?php echo lang('todays_summary'); ?></h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i data-feather="x"></i></span></button>
                    </div>
                    <div class="modal-body scroll_body">
                        <div class="table-responsive">

                            <table class="table">
                                <tr>
                                    <td class="w-80"><?php echo lang('total'); ?>  <?php echo lang('purchase'); ?>(<?php echo lang('only_paid_amount'); ?>)</td>
                                    <td><span id="purchase"></span></td>
                                </tr>
                                <tr>
                                    <td><?php echo lang('total'); ?>  <?php echo lang('sale'); ?>(<?php echo lang('only_paid_amount'); ?>)</td>
                                    <td><span id="sale"></span></td>
                                </tr>
                                <tr>
                                    <td><?php echo lang('total'); ?>  <?php echo lang('expense'); ?></td>
                                    <td><span id="Expense"></span></td>
                                </tr>
                                <tr>
                                    <td><?php echo lang('total'); ?>  <?php echo lang('supplier_payment'); ?></td>
                                    <td><span id="supplierDuePayment"></span></td>
                                </tr>
                                <tr>
                                    <td><?php echo lang('total'); ?>  <?php echo lang('customer_due_receive'); ?></td>
                                    <td><span id="customerDueReceive"></span></td>
                                </tr>
                                <tr>
                                    <td><?php echo lang('total'); ?> <?php echo lang('purchase_return'); ?></td>
                                    <td><span id="purchaseReturn"></span></td>
                                </tr>
                                <tr>
                                    <td><?php echo lang('total'); ?>  <?php echo lang('sale_return'); ?></td>
                                    <td><span id="saleReturn"></span></td>
                                </tr>
                                <tr>
                                    <td><?php echo lang('total'); ?>  <?php echo lang('damage'); ?></td>
                                    <td><span id="waste"></span></td>
                                </tr>
                                <?php
                                $i_sale = $this->session->userdata('i_sale');

                                if(isset($i_sale) && $i_sale=="Yes"){
                                    $txt = " + ".lang('down_payment')." + ".lang('installment_paid_amount');
                                }else{
                                    $txt = '';
                                }
                                ?>
                                <tr class="<?=isset($i_sale) && $i_sale=="No"?'op_display_none':''?>">
                                    <td><?php echo lang('total'); ?>  <?php echo lang('down_payment'); ?></td>
                                    <td><span id="down_payment_today_summery"></span></td>
                                </tr>
                                <tr class="<?=isset($i_sale) && $i_sale=="No"?'op_display_none':''?>">
                                    <td><?php echo lang('total'); ?>  <?php echo lang('installment_paid_amount'); ?></td>
                                    <td><span id="installment_paid_amount"></span></td>
                                </tr>
                                <tr>
                                    <td>Balance = (<?php echo lang('sale'); ?> + <?php echo lang('customer_due_receive') . $txt; ?>+<?php echo lang('purchase_return');?>) - (<?php echo lang('purchase'); ?> + <?php echo lang('supplier_payment'); ?> + <?php echo lang('expense'); ?> + <?php echo lang('expense'); ?> + <?php echo lang('sale_return');?>)</td>
                                    <td><span id="balance"></span></td>
                                </tr>
                            </table>
                            <br>
                            <div id="showCashStatus"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="overlay-alert"></div>

        <div class="modal fade" id="quick_menus" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h3 class="modal-title"><?php echo lang('quick_menus'); ?></h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i data-feather="x"></i></span></button>
                    </div>
                    <div class="modal-body scroll_body quick_modal_wrap">
                        <div class="single_item_wrapper">
                            <div class="q-parent-wrap">
                                <iconify-icon icon="solar:clock-circle-broken" width="22"></iconify-icon>
                                <span class="q-parent-item"><?php echo lang('attendances');?></span>
                            </div>
                            <ul class="quick_menu_inner_ul">
                                <li>
                                    <a href="<?php echo base_url();?>Attendance/addEditAttendance" class="d-flex align-items-center">
                                        <span class="f-icon d-flex align-items-center">
                                            <iconify-icon icon="solar:add-circle-broken" width="22"></iconify-icon>
                                        </span>
                                        <span class="d-flex align-items-center"><?php echo lang('add_attendance');?></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url();?>Attendance/attendances" class="d-flex align-items-center">
                                        <span class="f-icon d-flex align-items-center">
                                            <iconify-icon icon="solar:server-line-duotone" width="22"></iconify-icon>
                                        </span>
                                        <span class="d-flex align-items-center"><?php echo lang('list_attendance');?></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="single_item_wrapper">
                            <div class="q-parent-wrap">
                                <iconify-icon icon="material-symbols:storefront-outline" width="22"></iconify-icon>
                                <span class="q-parent-item"><?php echo lang('outlets');?></span>
                            </div>
                            <ul class="quick_menu_inner_ul">
                                <li>
                                    <a href="<?php echo base_url();?>Outlet/addEditOutlet" class="d-flex align-items-center">
                                        <span class="f-icon d-flex align-items-center">
                                            <iconify-icon icon="solar:add-circle-broken" width="22"></iconify-icon>
                                        </span>
                                        <span class="d-flex align-items-center"><?php echo lang('add_outlet');?></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url();?>Outlet/outlets" class="d-flex align-items-center">
                                        <span class="f-icon d-flex align-items-center">
                                            <iconify-icon icon="solar:server-line-duotone" width="22"></iconify-icon>
                                        </span>
                                        <span class="d-flex align-items-center"><?php echo lang('list_outlet');?></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="single_item_wrapper">
                            <div class="q-parent-wrap">
                                <iconify-icon icon="solar:cart-3-broken" width="22"></iconify-icon>
                                <span class="q-parent-item"><?php echo lang('sale');?></span>
                            </div>
                            <ul class=" quick_menu_inner_ul">
                                <li>
                                    <a href="<?php echo base_url();?>Sale/POS" class="d-flex align-items-center">
                                        <span class="f-icon d-flex align-items-center">
                                            <iconify-icon icon="solar:add-circle-broken" width="22"></iconify-icon>
                                        </span>
                                        <span class="d-flex align-items-center"><?php echo lang('pos');?></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url();?>Sale/sales" class="d-flex align-items-center">
                                        <span class="f-icon d-flex align-items-center">
                                            <iconify-icon icon="solar:server-line-duotone" width="22"></iconify-icon>
                                        </span>
                                        <span class="d-flex align-items-center"><?php echo lang('list_sale');?></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="single_item_wrapper">
                            <div class="q-parent-wrap">
                                <iconify-icon icon="solar:minus-circle-broken" width="22"></iconify-icon>
                                <span class="q-parent-item"><?php echo lang('expenses');?></span>
                            </div>
                            <ul class=" quick_menu_inner_ul">
                                <li>
                                    <a href="<?php echo base_url();?>Expense/addEditExpense" class="d-flex align-items-center">
                                        <span class="f-icon d-flex align-items-center">
                                            <iconify-icon icon="solar:add-circle-broken" width="22"></iconify-icon>
                                        </span>
                                        <span class="d-flex align-items-center"><?php echo lang('add_expense');?></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url();?>Expense/expenses" class="d-flex align-items-center">
                                        <span class="f-icon d-flex align-items-center">
                                            <iconify-icon icon="solar:server-line-duotone" width="22"></iconify-icon>
                                        </span>
                                        <span class="d-flex align-items-center"><?php echo lang('list_expense');?></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="single_item_wrapper">
                            <div class="q-parent-wrap">
                                <iconify-icon icon="solar:database-outline" width="22"></iconify-icon>
                                <span class="q-parent-item"><?php echo lang('stock');?></span>
                            </div>
                            <ul class=" quick_menu_inner_ul">
                                <li>
                                    <a href="<?php echo base_url();?>Stock/stock" class="d-flex align-items-center">
                                        <span class="f-icon d-flex align-items-center">
                                            <iconify-icon icon="solar:server-line-duotone" width="22"></iconify-icon>
                                        </span>
                                        <span class="d-flex align-items-center"><?php echo lang('list_stock_in');?></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="single_item_wrapper">
                            <div class="q-parent-wrap">
                                <iconify-icon icon="solar:suitcase-tag-line-duotone" width="22"></iconify-icon>
                                <span class="q-parent-item"><?php echo lang('purchase');?></span>
                            </div>
                            <ul class=" quick_menu_inner_ul">
                                <li>
                                    <a href="<?php echo base_url();?>Purchase/addEditPurchase" class="d-flex align-items-center">
                                        <span class="f-icon d-flex align-items-center">
                                            <iconify-icon icon="solar:add-circle-broken" width="22"></iconify-icon>
                                        </span>
                                        <span class="d-flex align-items-center"><?php echo lang('add_purchase');?></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url();?>Purchase/purchases" class="d-flex align-items-center">
                                        <span class="f-icon d-flex align-items-center">
                                            <iconify-icon icon="solar:server-line-duotone" width="22"></iconify-icon>
                                        </span>
                                        <span class="d-flex align-items-center"><?php echo lang('list_purchase');?></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="single_item_wrapper">
                            <div class="q-parent-wrap">
                                <iconify-icon icon="solar:hand-money-outline" width="22"></iconify-icon>
                                <span class="q-parent-item"><?php echo lang('supplier_payment');?></span>
                            </div>
                            <ul class=" quick_menu_inner_ul">
                                <li>
                                    <a href="<?php echo base_url();?>SupplierPayment/addSupplierPayment" class="d-flex align-items-center">
                                        <span class="f-icon d-flex align-items-center">
                                            <iconify-icon icon="solar:add-circle-broken" width="22"></iconify-icon>
                                        </span>
                                        <span class="d-flex align-items-center"><?php echo lang('add_supplier_payment');?></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url();?>SupplierPayment/supplierPayments" class="d-flex align-items-center">
                                        <span class="f-icon d-flex align-items-center">
                                            <iconify-icon icon="solar:server-line-duotone" width="22"></iconify-icon>
                                        </span>
                                        <span class="d-flex align-items-center"><?php echo lang('list_supplier_payment');?></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="single_item_wrapper">
                            <div class="q-parent-wrap">
                                <iconify-icon icon="solar:hand-money-outline" width="22"></iconify-icon>
                                <span class="q-parent-item"><?php echo lang('customer_receive');?></span>
                            </div>
                            <ul class=" quick_menu_inner_ul">
                                <li>
                                    <a href="<?php echo base_url();?>Customer_due_receive/addCustomerDueReceive" class="d-flex align-items-center">
                                        <span class="f-icon d-flex align-items-center">
                                            <iconify-icon icon="solar:add-circle-broken" width="22"></iconify-icon>
                                        </span>
                                        <span class="d-flex align-items-center"><?php echo lang('add_customer_due_receive');?></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url();?>Customer_due_receive/customerDueReceives" class="d-flex align-items-center">
                                        <span class="f-icon d-flex align-items-center">
                                            <iconify-icon icon="solar:server-line-duotone" width="22"></iconify-icon>
                                        </span>
                                        <span class="d-flex align-items-center"><?php echo lang('list_customer_due_receive');?></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="single_item_wrapper">
                            <div class="q-parent-wrap">
                                <iconify-icon icon="solar:rewind-back-broken" width="22"></iconify-icon>
                                <span class="q-parent-item"><?php echo lang('sale_return');?></span>
                            </div>
                            <ul class=" quick_menu_inner_ul">
                                <li>
                                    <a href="<?php echo base_url();?>Sale_return/addEditSaleReturn" class="d-flex align-items-center">
                                        <span class="f-icon d-flex align-items-center">
                                            <iconify-icon icon="solar:add-circle-broken" width="22"></iconify-icon>
                                        </span>
                                        <span class="d-flex align-items-center"><?php echo lang('add_sale_return');?></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url();?>Sale_return/saleReturns" class="d-flex align-items-center">
                                        <span class="f-icon d-flex align-items-center">
                                            <iconify-icon icon="solar:server-line-duotone" width="22"></iconify-icon>
                                        </span>
                                        <span class="d-flex align-items-center"><?php echo lang('list_sale_return');?></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="single_item_wrapper">
                            <div class="q-parent-wrap">
                                <iconify-icon icon="solar:lock-unlocked-outline" width="22"></iconify-icon>
                                <span class="q-parent-item"><?php echo lang('Accounting');?></span>
                            </div>
                            <ul class=" quick_menu_inner_ul">
                                <li>
                                    <a href="<?php echo base_url();?>Accounting/balanceStatement" class="d-flex align-items-center">
                                        <span class="f-icon d-flex align-items-center">
                                            <iconify-icon icon="solar:dollar-broken" width="22"></iconify-icon>
                                        </span>
                                        <span class="d-flex align-items-center"><?php echo lang('Balance_Statement');?></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url();?>Accounting/trialBalance" class="d-flex align-items-center">
                                        <span class="f-icon d-flex align-items-center">
                                            <iconify-icon icon="solar:home-angle-2-broken" width="22"></iconify-icon>
                                        </span>
                                        <span class="d-flex align-items-center"><?php echo lang('Trial_Balance');?></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url();?>Accounting/balanceSheet" class="d-flex align-items-center">
                                        <span class="f-icon d-flex align-items-center">
                                            <iconify-icon icon="solar:shuffle-broken" width="22"></iconify-icon>
                                        </span>
                                        <span class="d-flex align-items-center"><?php echo lang('Balance_Sheet');?></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ./wrapper -->

        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><?php echo lang('register_details'); ?> <span id="opening_closing_register_time">(<span id="opening_register_time"></span> <?php echo lang('to'); ?> <span id="closing_register_time"></span>)</span></h4>
                    </div>
                    <div class="modal-body" id="register_details_body">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-blue-btn" data-bs-dismiss="modal"><?php echo lang('close'); ?></button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Message Mdodal -->
        <!-- <div id="message-modal" class="message-modal">
            <div class="modal-content">
                <span class="close" id="closeModalBtn">&times;</span>
                <h2><iconify-icon icon="solar:shield-warning-broken"></iconify-icon></h2>
                <h4 class="pb-4">You are using a pirated copy of this software. To avoid future trouble please purchase the original copy from <a href="https://codecanyon.net/item/off-pos-retail-pos-and-stock-software/24326862?srsltid=AfmBOoqMEy1BHa0mFO5WJTa7EynzWWuSHEZLlgyvzM-eAVQVP1Q-OFV7" target="_blank" class="link-color">here</a>.</h4>
            </div>
        </div> -->


        <!-- ################ Script Start ################ -->
        <?php
        //generating object for access module show/hide
        $j = 1;
        $menu_objects = "";
        $access = $this->session->userdata('function_access');
        if(isset($access) && $access):
            foreach($access as $value){
                if($j==count($access)){
                    $menu_objects .="'".$value."'";
                }else{
                    $menu_objects .="'".$value."',";
                }
                $j++;
            }
        endif;


        $module_objects = [];
        $module_show_hide = $this->session->userdata('module_show_hide');
        if(isset($module_show_hide) && $module_show_hide){
            foreach($module_show_hide as $value){
                if($value){
                    array_push($module_objects, $value);
                }
            }
        }
        ?>
        <script>
            /*This variable could not be escaped because this is building object*/
            window.menu_objects = <?php echo json_encode($menu_objects); ?>;
            window.module_objects = <?php echo json_encode($module_objects); ?>;
        </script>

        <script src="<?php echo base_url(); ?>assets/bootstrap/bootstrap.bundle.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/adminLTE/adminlte.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/feather/feather.min.js"></script>
        <script src="<?php echo base_url(); ?>frequent_changing/newDesign/lib/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script>
        <script src="<?php echo base_url(); ?>frequent_changing/newDesign/js/new-script.js"></script>
        <script src="<?php echo base_url(); ?>frequent_changing/js/menu.js"></script>
        <script src="<?php echo base_url(); ?>assets/origin.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/tippy/popper.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/tippy/tippy-bundle.umd.min.js"></script>
        <!-- ################ Script End ################ -->
    </body>
</html>


