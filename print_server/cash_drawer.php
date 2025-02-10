<?php
//error_reporting( 0 );
require __DIR__ . '/escpos-php/autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\CapabilityProfile;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;

/* Do some printing */
try{
    $printer_type_value = isset($_GET['printer_type_value']) && $_GET['printer_type_value']?$_GET['printer_type_value']:'';
    $printer_port = isset($_GET['port']) && $_GET['port']?$_GET['port']:'';
    $type = isset($_GET['type']) && $_GET['type']?$_GET['type']:'';
    if ($type == 'network') {
        $connector = new NetworkPrintConnector($printer_type_value, $printer_port);
    } elseif ($type == 'linux') {
        $connector = new FilePrintConnector($printer_type_value);
    } else {
        $connector = new WindowsPrintConnector($printer_type_value);
    }

    $printer = new Printer($connector);
    $printer->setJustification(Printer::JUSTIFY_CENTER);
    $printer-> text("Hello World!\n");
    $printer-> cut();
    $printer->pulse();
    $printer-> close();

    if(isset($printer) && $printer){
        echo "<h2 style='text-align: center;color:green'>Print Success, check your printer</h2>";
    }
    $printer-> close();
}catch(Exception $e){
    echo "<h2 style='text-align: center;color:red;margin-top:5%'>Printer not connected</h2>";
}
