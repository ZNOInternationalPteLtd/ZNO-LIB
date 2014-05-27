<?php
/**************************
 * File name: user.class.php /user insert/update/select/delete DB
 * Added by :Britta Alex
 *  Modified by:
 * Date:27-05-2014
 * Version:1.0
 **************************/
include_once 'includes/dbconnect.inc.php';
class item
{
    var $dblink;
    function item($dbObj)
    {
        $this->dblink = $dbObj;
    }
    //retrieve the user roles - parameter req : tablename
    public function GetUserRoles($tablename1)
    {
        $fields = array('0'=>'*');
        $condtn = '';
        $join = array();
        $sql_role = $this->dblink->SelectQueryBuilder($fields,$condtn,$join,$tablename1);
        $result_roles = $this->dblink->readValues($sql_role);
        return $result_roles;
    }
    //add/edit user : parameter required : post fieldnames & values,id in the case of edit,tablename & condition to apply for tables
    public function AddList($formfields,$ID,$tablename2,$condition='')
    {
        
        if($ID >0)
        {
            
            $sql_ins = $this->dblink->UpdateQueryBuilder($formfields,$tablename2,$condition);
        }
        else
        {
             $sql_ins = $this->dblink->InsertQueryBuilder($formfields,$tablename2);
        }
        $result_add = $this->dblink->SetQuery($sql_ins);
        return $result_add;
    }
    //get the user details when id supplied - parameter req : id ,tablename & condition
    public function GetListDetails($uID,$tablenamedet,$condtn='')
    {
        $fields = array('0'=>'*');
        //$condtn = 'users_userId="'.$uID.'"';
        $sql_ulistdet = $this->dblink->SelectQueryBuilder($fields,$condtn,$join='',$tablenamedet);
        $result_ulistdet = $this->dblink->readValues($sql_ulistdet);
        return $result_ulistdet;
    }
    //get the list of users - parameter required : fields,limit,sort,tablename,join array,condition
    public function GetList($fieldslist,$limit,$sort,$tablename3,$join,$condtn)
    {
        if(!empty($fieldslist))
        {
            $fields = $fieldslist;
        }
        else {
            $fields = array('0'=>'*');
        }
        $limit_user = $limit;
        $sql_ulist = $this->dblink->SelectQueryBuilder($fields,$condtn,$join,$tablename3,$limit_user,$sort);
        $result_ulist = $this->dblink->readValues($sql_ulist);
        return $result_ulist;
    }
    //get the total user count - parameter required: tablename, join array, condition
    public function GetListCount($tbname,$join,$condtn)
    {
        $fields = array('0'=>'*');
        
        $sql_ulist = $this->dblink->SelectQueryBuilder($fields,$condtn,$join,$tbname);
        $result_ulist = $this->dblink->readValues($sql_ulist);
        return count($result_ulist);
    }
    //delete user - parameter required id,tabelname,condition
    public function DeleteItem($ID,$dtbname,$condition)
    {
        
        $sql_del = $this->dblink->DeleteQueryBuilder($dtbname,$condition);
        $result_del = $this->dblink->SetQuery($sql_del);
        return $result_del;
    }
   
     
}
