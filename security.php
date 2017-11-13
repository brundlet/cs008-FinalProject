<?php
print PHP_EOL. '<!--Begin Security-->'. PHP_EOL;
function securityCheck($myFormUrl=""){
    $debugThis=false;
    $status=true;
    if($myFormURL!=""){
        $fromPage=htmlentities($_SERVER['HTTP_REFERER'],ENT_QUOTES, 'UTF-8');
        $fromPage=preg_replace('#^https?:#','',$fromPage);
        if($debugThis){
            print '<p>From: '.$fromPage. ' should match your URL: ' .$myFormURl;
        }
        if($fromPage != $myFormURL){
            $status=false;
        }
    }
    
    return $status;
}
print PHP_EOL.'<!-- END include security-->'. PHP_EOL;
?>