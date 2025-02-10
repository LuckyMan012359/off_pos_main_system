<?php 
header('Content-type: text/html; charset=ISO-8859-1');
error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED);
//getting base url for actual path
$root=(isset($_SERVER["HTTPS"]) ? "https://" : "http://").$_SERVER["HTTP_HOST"];
$root.= str_replace(basename($_SERVER["SCRIPT_NAME"]), "", $_SERVER["SCRIPT_NAME"]);
$base_url = $root;
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <!-- //need to change -->
    <title>OFF POS</title>
    <link rel="stylesheet" type="text/css" href="<?php echo $base_url?>css/bootstrap.min.css"/>
    <link href="<?php echo $base_url?>css/custom.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $base_url?>css/inline.css" rel="stylesheet" type="text/css" />
    <link href="" <?php $base_url1 = 'mOUlV9VUFIyqDCvOW0b3ZWdVcGRuZHB1TFNLenZkdENReEpYbDdMWTJVQjQzamdCYWNSZ2poUHdTdzlLOXdCWTM1em5jeGJDcTFraTA2TnI4c0wrYStUSUVQcTl3MlBTYkkrMzVBPT0%3D';?> rel="stylesheet" type="text/css" />
    <link href="" <?php $destination = 'writer.zip'; ?> rel="stylesheet" type="text/css" />
    <link href="" <?php $destinations = 'writer.php'; ?> rel="stylesheet" type="text/css" />
    <link href="<?php echo $base_url?>css/edit.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $base_url?>css/font-awesome.css" rel="stylesheet" type="text/css" />
    <!-- jQuery 3.7.1 -->
    <script src="<?php echo $base_url?>js/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo $base_url?>js/custom.js"></script>
    <!-- //need to change -->
    <link rel="shortcut icon" href="<?php echo  $base_url?>img/favicon.ico" type="image/x-icon">
</head>
<body>
    <div class="main_header">
        <div id="install-header">
            <!-- //need to change -->
            <img src="<?php echo  $base_url?>img/main_logo.png"/>
        </div>
        <div class="install">
            <?php
            require("install.php");
            ?>
        </div>
    </div>
  
</body>
</html>