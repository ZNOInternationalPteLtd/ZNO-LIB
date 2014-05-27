<?php
/**************************
 * File name: Database.class.php /class file for DB
 * Added by :Britta Alex
 * Modified by:
 * Date:27-05-2014
 * Version:1.0
 **************************/
include_once 'includes/constants.inc.php';
class Database
{
     var $host;
     var $user;
     var $password;
     var $database;
     var $dblink;
     var $error;
     
     
    function Database()
    {
        $this->host         = DB_HOST;
        $this->user         = DB_USER;
        $this->password     = DB_PASSWORD;
        $this->database     = DB_DB;
        
    }
    //Database connection
    public function DbConnect()
    {
        $this->dblink = mysql_connect($this->host,  $this->user, $this->password);
        if(!$this->dblink)
            {
                $this->error = "Connection error";
                exit();
            }
        else
            {
                if(!mysql_select_db($this->database))
                    {
                        $this->error = "Cannot select database";
                        return FALSE;
                    }
                else 
                    {
                        return TRUE;
                    }
            }
    }
    //Close Db Connection
    public function DbClose()
    {
        mysql_close($this->dblink);
    }
    //Set Query for query execution
    public function SetQuery($query)
    {
        $result = mysql_query($query);
        return $result;
    }
    //Read Values to fetch data as array
    public function ReadValues($query)
    {
        $qresult = $this->SetQuery($query);
        $Rows = array();
        $ArrIndex = 0;
        while($row = mysql_fetch_array($qresult))
            {
               
               $Rows[$ArrIndex] = $row;
               $ArrIndex++;
             
            }
            return $Rows;
    }
    //Query builder for select
    public function SelectQueryBuilder($select = array(),$cond = '',$join = array(),$table = '',$limit = '',$order='')
    {
        
        $fields = '';//field to be selected
        if(!empty($select))
        {
            for($i=0;$i<count($select);$i++)
            {
                $fields .= $select[$i].",";
            }
        }
        
        $fields = substr($fields,0,-1);
        $sql = "SELECT ".$fields." FROM ".$table;//query
        if(!empty($join))//join
        {
            
                $type = $join['type'];//wht type of join
                $jtable = $join['join_table'];//table to be joined
                $fieldjoin = $join['fieldjoin'];//fields to join
                $fieldjoin1 = $join['fieldjoin1'];
                $sql .= " ".$type." JOIN ".$jtable." ON ".$fieldjoin."=".$fieldjoin1;
        }
        
        $sql .= " WHERE 1=1";
        if($cond!="")
        {
            
            $sql .= "  AND ".$cond;//condition
        }
        if($order != '')
        {
        $sql .= " ORDER BY ".$order;//order by
        }
        $sql .= " ".$limit;//limit
      return $sql; 
    }
    //Insert Query Builder
    public function InsertQueryBuilder($fieldvalues = array(),$itable='')
    {
        $fvalues = '';
        $vals = '';
        $tot_count  = count($fieldvalues);
        $count = 0;
        foreach ($fieldvalues as $key => $values)//fieldnames & values
        {
            $count ++;
            if($count != $tot_count)
            {
            $vals  .= "'".$values."',";
            $fvalues .= $key.",";
            }
        }
        $fvalues = substr($fvalues,0,-1);
        $vals = substr($vals,0,-1);
        $ins_sql = "INSERT INTO ".$itable."(".$fvalues.") VALUES(".$vals.")";//query
        return $ins_sql;
    }
    //Update query Builder
    public function UpdateQueryBuilder($upfields = array(),$utable='',$condtn='')
    {
        $ufvalues = '';
        $uvals = '';
        $utot_count  = count($upfields);
        $ucount = 0;
        $up_sql = "UPDATE ".$utable." SET ";
        foreach ($upfields as $key => $uvalues)//fields & values
        {
            $ucount ++;
            if($ucount != $utot_count)
            {
            $uvals  = $uvalues;
            $ufvalues = $key;
            $up_sql .= $ufvalues."='".$uvals."'".",";
            }
        }
        $up_sql =  substr($up_sql,0,-1);
        if($condtn != '')
        {
            $up_sql .= " WHERE ".$condtn;
        }
        return $up_sql;
    }
    //Delete Query Builder
    public function DeleteQueryBuilder($tabletodel='',$condtndel='')
    {
        $delete_sql = "DELETE FROM ".$tabletodel." WHERE ".$condtndel;
        return $delete_sql;
    }
}
?>
