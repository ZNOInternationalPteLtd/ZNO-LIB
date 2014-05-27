<?php
/**************************
 * File name: login.class.php/login check from DB
 * Added by :Britta Alex
 * Modified by:
 * Date:27-05-2014
 * Version:1.0
 **************************/
include_once 'includes/dbconnect.inc.php';
class login
{
    var $dblink;
    function login($dbObj)
    {
        $this->dblink = $dbObj;
    }
    public function Checklogin($uname,$pass)
    {
        $tablename = "admin_users";
        $selector_array = array('0'=>'users_userRole','1'=>'users_userName','2'=>'users_userPassword');
        $condition = "users_userName='".$uname."' AND users_userPassword='".$pass."'";
        $sql_login = $this->dblink->SelectQueryBuilder($selector_array,$condition,$join="",$tablename);
        $result_log = $this->dblink->readValues($sql_login);
        return $result_log;
        
    }
   
}