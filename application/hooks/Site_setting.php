<?php
class Site_setting { 
    function setSetting(){   
        
        /**
         * BIPONI CHECKER
         * YES
         * NO
         */
        define('APPLICATION_IS_BIPONI', 'NO');

        /**
         * BIPONI PLAN CHECKER
         * G FOR GOLD
         * P FOR PHARMACY
         * D FOR DIAMOND
         */
        define('APPLICATION_BIPONI_PLAN', 'G');

        /**
         * There is some demo of 'OFF POS' don't delete theme
         * All Type
         * General Store
         * Fashion Shop
         * Mobile Shop
         * Computer Shop
         * Pharmacy
         * Service Center
         * Installment Sale
         * Beauty Pourlar
         */
        define('APPLICATION_DEMO_TYPE', 'All Type');

        /**
         * Application SaaS Type Checker
         * SaaS
         * Not SaaS
         */
        define('APPLICATION_SaaS_TYPE', 'Not SaaS');

        /**
         * Application Mode Checker
         * live
         * demo
         */
        define('APPLICATION_MODE', 'live'); 

        if (APPLICATION_MODE == 'demo') {
            # Load the URI core class
            $uri =& load_class('URI', 'core');
            // getting base url
            $root=(isset($_SERVER["HTTPS"]) ? "https://" : "http://").$_SERVER["HTTP_HOST"];
            $root.= str_replace(basename($_SERVER["SCRIPT_NAME"]), "", $_SERVER["SCRIPT_NAME"]);
            $base_url = $root;
            # Get the third segment
            $get_second_uri = $uri->segment(2)??''; // returns the id
            $get_first_uri = ucfirst($uri->segment(1)??""); // returns the id
            $first_six_letter = substr($get_second_uri, 0, 6); 
            if ($first_six_letter == "delete") {
                //There are no view page that's why used the inline css
                echo "<h2 style='color: red; margin-top: 15%; text-align: center;'>For security and data consistency this features disabled in demo mode.!</h2>";
                echo "<p style='color: red; text-align: center;'><a href='".$base_url."Authentication/userProfile'</a>Click to Return</p>";
                    exit;
            }
            if ($get_second_uri == "bulkDelete") {
                //There are no view page that's why used the inline css
                echo "<h2 style='color: red; margin-top: 15%; text-align: center;'>For security and data consistency this features disabled in demo mode.!</h2>";
                echo "<p style='color: red; text-align: center;'><a href='".$base_url."Authentication/userProfile'</a>Click to Return</p>";
                    exit;
            }
            $concate_url = $get_first_uri."_".$get_second_uri;

            // echo $get_second_uri;exit;
            if ($get_second_uri == 'setting' || $get_second_uri == 'changeProfile' || $get_second_uri == 'changePassword'  || $get_second_uri == 'TaxSetting'  || $get_second_uri == 'whiteLabel'  || $get_second_uri == 'securityQuestion' || $concate_url == 'Setting_index' | $concate_url == 'WhiteLabel_index' || $get_second_uri == 'whatsappSetting' || $get_second_uri == 'emailSetting' || $get_second_uri == 'SMSSetting' || $get_second_uri == 'add_dummy_data' || $get_second_uri == 'deleteDummyData' || $get_second_uri == 'wipeTransactionalData' || $get_second_uri == 'wipeAllData' || $get_second_uri == 'bulkDelete' || $get_second_uri == 'uploadItem' || $get_second_uri == 'uploadItemPhoto') {
                if (!empty($_POST['submit'])) {
                    //There are no view page that's why used the inline css
                      echo "<h2 style='color: red; margin-top: 15%; text-align: center;'>For security and data consistency this features disabled in demo mode.!</h2>";
                      echo "<p style='color: red; text-align: center;'><a href='".$base_url."Authentication/userProfile'</a>Click to Return</p>";
                    exit;
                }
            }
            if ($get_second_uri == 'deleteDummyData' || $get_second_uri == 'wipeTransactionalData' || $get_second_uri == 'wipeAllData' || $get_second_uri == 'add_dummy_data') {
                //There are no view page that's why used the inline css
                echo "<h2 style='color: red; margin-top: 15%; text-align: center;'>For security and data consistency this features disabled in demo mode.!</h2>";
                echo "<p style='color: red; text-align: center;'><a href='".$base_url."Authentication/userProfile'</a>Click to Return</p>";
                exit;
            }
            if ($get_first_uri == 'Update') {
                //There are no view page that's why used the inline css
                echo "<h2 style='color: red; margin-top: 15%; text-align: center;'>For security and data consistency this features disabled in demo mode.!</h2>";
                  echo "<p style='color: red; text-align: center;'><a href='".$base_url."Authentication/userProfile'</a>Click to Return</p>";
                exit;
            }
        }

        /**
         */
        define('APPLICATION_L', true); 

        if(APPLICATION_L){
            // Ensure the biiPP() function is defined and available
            if (function_exists('biiPP')) {
                $biiPP = biiPP();
                if(isset($biiPP->ilt) && function_exists('currentIC') && $biiPP->ilt <= currentIC()){
                    define('APPLICATION_LI', true);
                }else{
                    define('APPLICATION_LI', false);
                }

                if(isset($biiPP->olt) && function_exists('currentO') && $biiPP->olt <= currentO()){
                    define('APPLICATION_LO', true);
                }else{
                    define('APPLICATION_LO', false);
                }

                if(isset($biiPP->clt) && function_exists('currentC') && $biiPP->clt <= currentC()){
                    define('APPLICATION_LC', true);
                }else{
                    define('APPLICATION_LC', false);
                }
            } else {
                // Handle the case where biiPP() function is not available
                error_log('biiPP() function is not defined');
                define('APPLICATION_LI', false);
                define('APPLICATION_LO', false);
                define('APPLICATION_LC', false);
            }
        }else{
            define('APPLICATION_LI', false);
            define('APPLICATION_LO', false);
            define('APPLICATION_LC', false);
        }

        // Ensure base_url() function is available
        if (!function_exists('base_url')) {
            function base_url($uri = '') {
                $CI =& get_instance();
                return $CI->config->base_url($uri);
            }
        }

        

        

    }
}
?>