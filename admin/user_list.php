<?php
/**************************
 * File name: user_list.php / list user
 * Added by :Britta Alex
 * Modified by:
 * Date:27-05-2014
 * Version:1.0
 **************************/
include_once("header.php");
include_once ("classes/item.class.php");
include_once ("classes/pagination.class.php");
$userObj = new item($DbObj);//initialization of the class
$p = new pagination();
$tablename = "admin_users";//table to be used
$msg = "";
$roleid = "";
$action = "";
$id = "";
$class = "";
$deact = "";
$deactp = "";
$pg = 1;
$sort = "";
$size = 10;
$sel1 = "";
$sel2 = "";
$sel3 = "";
$sel4 = "";
$sel5 = "";
if (isset($_REQUEST['size'])) {//for pagination request the size on change
    $size = $_REQUEST['size'];
}//end of pagination request
if (isset($_REQUEST['st'])) {//status check for the add/edit/delete function
            if ($_REQUEST['st'] == "success") {
                $msg = "User created successfully";
            } elseif ($_REQUEST['st'] == "esuccess") {
                $msg = "User updated successfully";
            } else {
                $msg = "User deleted successfully";
            }
} else {
            if (isset($_REQUEST['st']) && $_REQUEST['st'] == "failed") {
                $msg = "Some Error.Please try again.";
            }
       }//end of status check
if (isset($_REQUEST['type']) && $_REQUEST['type'] > 0) {//type of user
    $roleid = $_REQUEST['type'];
}//end type
if (isset($_REQUEST['id']) && $_REQUEST['id'] > 0) {//check for if id is set
    $id = $_REQUEST['id'];
}//end id check
if (isset($_REQUEST['action']) && $_REQUEST['action'] == "del") {//delete action
    if ($id > 0) {
        $condition = "users_userId=".$id;//condition for delete query builder
        $deleteuser = $userObj->DeleteItem($id,$tablename,$condition);
        if ($deleteuser == 1) {
            header("Location:user_list.php?type=" . $roleid . "&st=delsuccess");
        } else {
            header("Location:user_list.php?type=" . $roleid . "&st=failed");
        }
    }
}//end delete
if (isset($_REQUEST['sort']) && $_REQUEST['sort'] != "") {//for sorting
    $sort = $_REQUEST['sort'];
}//end sort
if (isset($_REQUEST['page'])) {//set page
    $pg = $_REQUEST['page'];
}//end page
if ($pg == 1) {// case for pg = 1
    $deactp = "disabled";
}
$join = array("type"=>'LEFT',"join_table"=>'admin_roles',"fieldjoin"=>'users_userRole',"fieldjoin1"=>'roles_roleId');//join array
$condtn = 'admin_users.users_userRole="'.$roleid.'"';//condition
$usercount = $userObj->GetListCount($tablename,$join,$condtn);//get the user count
$totpages = $p->calculate_pages($usercount, $size, $pg);//pagination  info array
$limit = $totpages['limit'];//limit
$userlist = $userObj->GetList($field='', $limit, $sort, $tablename,$join,$condtn);//get the list of users

//print_r($totpages);
?>

<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
<?php include_once 'left_menu.php'; ?>
    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <!-- BEGIN PAGE HEADER-->
            <div class="row">
                <div class="col-md-12">
                    <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                    <h3 class="page-title">
                        Dashboard 
                    </h3>
                    <ul class="page-breadcrumb breadcrumb">
                        <li>
                            <i class="fa fa-home"></i>
                            <a href="index.php">Home</a>
                            <i class="fa fa-angle-right"></i>
                        </li>
                        <li>
                            <a href="index.php">Technicians</a>
                        </li>
                        <li class="pull-right">
                            <div id="dashboard-report-range" class="dashboard-date-range tooltips" data-placement="top" data-original-title="Change dashboard date range">
                                <i class="fa fa-calendar"></i>
                                <span></span>
                                <i class="fa fa-angle-down"></i>
                            </div>
                        </li>
                    </ul>
                    <!-- END PAGE TITLE & BREADCRUMB-->
                </div>
            </div>
            <!-- END PAGE HEADER-->


            <div class="clearfix">
            </div>

            <div class="">
                <!-- BEGIN SAMPLE TABLE PORTLET-->
                <div class="portlet box">

                    <div class="portlet-body">
                        <div class="table-toolbar">
                            <a href="user_add.php?type=<?= $roleid; ?>" style="text-decoration:none">
                                <div class="btn green">
                                    Create User Account <i class="fa fa-plus"></i>
                                </div><?php if($size == "10"){ $sel1 = "selected";}if($size == "20"){ $sel2 = "selected";}if($size == "30"){ $sel3 = "selected";}if($size == "40"){ $sel4 = "selected";}if($size == $usercount){ $sel5 = "selected";}?>
                            </a><div class="dataTables_length" id="datatable_orders_length"><form id="frm_select" name="frm_select"><label style="float: right;
                                                                                                                                           display: flex;">View <select style="margin: 0 5px;" onchange="Callfun(<?php echo $roleid;?>,'<?php echo $sort;?>');return false;"  class="form-control input-xsmall input-sm" aria-controls="datatable_orders" size="1" id="records" name="records"><option <?php echo $sel1; ?> value="10">10</option><option <?php echo $sel2;?> value="20">20</option><option <?php echo $sel3; ?> value="30">30</option><option <?php echo $sel4; ?> value="40">40</option><option <?php ($size == 0)?"selected":""; ?> value="50">50</option><option <?php echo $sel5;?> value="<?php echo $usercount;?>">All</option></select> records</label></form></div>
                            <div style="color:green;text-align: center;margin-top: 10px;"><strong><?php echo $msg; ?></strong></div>
                        </div>
<?php if (!empty($userlist)) { ?>                           
                            <table class="table table-striped table-hover table-bordered" id="sample_editable_1">
                                <thead>
                                    <tr>
                                        <th >#</th>
                                        <th  >First Name<span><a href="user_list.php?type=<?= $roleid; ?>&sort=users_userFullname ASC"><img title="ascending" src="assets/global/plugins/data-tables/images/sort_asc.png"/></a><a href="user_list.php?type=<?= $roleid; ?>&sort=users_userFullname DESC"><img  title="descending" src="assets/global/plugins/data-tables/images/sort_desc.png"/></a></span></th>
                                        <th >Username<span><a href="user_list.php?type=<?= $roleid; ?>&sort=users_userFullname ASC"><img title="ascending" src="assets/global/plugins/data-tables/images/sort_asc.png"/></a><a href="user_list.php?type=<?= $roleid; ?>&sort=users_userFullname DESC"><img  title="descending" src="assets/global/plugins/data-tables/images/sort_desc.png"/></a></span></th>
                                        <th>Password</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
    <?php
    $count = $pg;
    for ($k = 0; $k < count($userlist); $k++) {
        ?>
                                        <tr>
                                            <td><?php echo $count; ?></td>
                                            <td><?php echo $userlist[$k]['users_userFullname']; ?></td>
                                            <td><?php echo $userlist[$k]['users_userName']; ?></td>
                                            <td><?php echo $userlist[$k]['users_userPassword']; ?></td>
                                            <td><?php echo $userlist[$k]['users_userEmail']; ?></td>
                                            <td><?php echo $userlist[$k]['roles_roleName']; ?></td>
                                            <td ><a style="color: #269abc;" href="user_add.php?type=<?= $roleid; ?>&id=<?= $userlist[$k]['users_userId']; ?>">Edit</a>&nbsp;|&nbsp;<a style="color: #E00000;" href="user_list.php?action=del&type=<?= $roleid; ?>&id=<?= $userlist[$k]['users_userId']; ?>">Delete</a></span>
                                            </td>
                                        </tr>
        <?php $count ++;
    } ?>
                                </tbody>
                            </table>	<?php } else {
    echo "<div style='text-align:center;'><strong style='color:red;'>No Records</strong></div>";
} ?>
                    </div>
                    <div class="row"><div class="col-md-5 col-sm-12">
                            <div id="sample_editable_1_info" style="margin-top:5px;" class="dataTables_info">Showing <?= $totpages['info']; ?></div></div>
                        <div class="col-md-7 col-sm-12"><div class="dataTables_paginate paging_bootstrap" style="float:right;">
                                <ul class="pagination"><?php $totpages; ?>
                                    <li class="prev <?= $deactp; ?>"><a href="user_list.php?type=<?= $roleid; ?>&page=<?= $totpages['previous']; ?>&sort=<?= $sort; ?>" title="Prev">
                                            <i class="fa fa-angle-left"></i></a></li>
<?php
for ($p = 0; $p < count($totpages['pages']); $p++) {
    $class = "";
    if ($totpages['current'] == $totpages['pages'][$p]) {
        $class = "active";
    }
    if ($pg == count($totpages['pages'])) {
        $deact = "disabled";
    }
    ?>
                                        <li class="<?= $class; ?>"><a href="user_list.php?type=<?= $roleid; ?>&page=<?= $totpages['pages'][$p]; ?>&sort=<?= $sort; ?>"><?= $totpages['pages'][$p]; ?></a></li>
<?php } ?>
                                    <li class="next <?= $deact; ?>"><a href="user_list.php?type=<?= $roleid; ?>&page=<?= $totpages['next']; ?>&sort=<?= $sort; ?>" title="Next"><i class="fa fa-angle-right"></i></a></li>
                                </ul>
                            </div></div></div>
                </div>
            </div>

        </div>
    </div>
                                    <?php include_once("footer.php"); ?>
    <script type="text/javascript">

        function Callfun(type,sort)
        {
            //alert(1);
            var val = $("#records").val();
            window.location.href = "user_list.php?type="+type+"&sort="+sort+"&size="+val;
          //alert(type+"---"+sort);
        }
    </script>