<?php
/**************************
 * File name: dbconnect.inc.php /inc file for DB connection
 * Added by :Britta Alex
 * Modified by:
 * Date:27-05-2014
 * Version:1.0
 **************************/
include_once 'classes/Database.class.php';
$DbObj = new Database();
if(!$DbObj->DbConnect())
    {
        echo "Error";
        exit();
    }

?>
