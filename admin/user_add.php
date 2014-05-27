<?php
/**************************
 * File name: user_add.php / add user
 * Added by :Britta Alex
 *  Modified by:
 * Date:27-05-2014
 * Version:1.0
 **************************/
include_once("header.php");
include_once ("classes/item.class.php");
$userObj = new item($DbObj);
$tablename2 = "admin_users";//tables
$tablename1 = "admin_roles";
$roles = $userObj->GetUserRoles($tablename1);//get user roles
$users_userRole = "";
$id = "";
$cond = "";
if(isset($_REQUEST['type']) && $_REQUEST['type']>0)//type of user
{
    $roleid = $_REQUEST['type'];
    $users_userRole = $roleid;
}
if(isset($_REQUEST['id']) && $_REQUEST['id']>0)//id set
{
    $id = $_REQUEST['id'];
    
}//end
$users_userFullname = "";
$users_userName = "";
$users_userPassword = "";
$users_userEmail = "";
$error = "";
if($id >0)//edit
{
    $cond =  "users_userId=".$id;
    $getuserdetails = $userObj->GetListDetails($id,$tablename2,$cond);//get details
    foreach ($getuserdetails as $details)
    {
        $users_userFullname = $details['users_userFullname'];
        $users_userName = $details['users_userName'];
        $users_userPassword = $details['users_userPassword'];
        $users_userEmail = $details['users_userEmail'];
        $users_userRole = $details['users_userRole'];
    }
}//end
if(isset($_POST['user_add']) && $_POST['user_add']=="ADD")//Add/Update
{
    $users_userFullname = $_POST['users_userFullname'];
    $users_userName = $_POST['users_userName'];
    $users_userPassword = $_POST['users_userPassword'];
    $users_userEmail = $_POST['users_userEmail'];
    $users_userRole = $_POST['users_userRole'];
    if($users_userFullname == "")//validation
    {
        $error = "Please enter the full name!";
    }
    elseif($users_userName == "")
    {
        $error = "Please enter the user name!";
    }
    elseif($users_userPassword == "")
    {
        $error = "Please enter the user password!";
    }
    elseif($users_userEmail == "")
    {
        $error = "Please enter the user email!";
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $error = "E-mail is not valid";
        }
    }
 else {
        $error = "";
    }
    if($error == "")
    {
        $adduser = $userObj->AddList($_POST,$id,$tablename2,$cond);
        if($adduser == 1)
        {
            if($id >0)
            {
                 $param = "esuccess";
            }
            else {
                $param = "success";
            }
            
            header("Location:user_list.php?type=".$roleid."&st=".$param);
        }
        else {
            $param = "failed";
            header("Location:user_list.php?type=".$roleid."&st=".$param);
        }
    }
}//end

?>

<!-- BEGIN CONTAINER -->
<div class="page-container">
	<!-- BEGIN SIDEBAR -->
<?php include_once 'left_menu.php';?>
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
							<a href="user_add.php">Add User</a>
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
                        <div class="row">
                        <div class="col-md-12">
					<!-- BEGIN SAMPLE TABLE PORTLET-->
                       
					
						<div class="portlet-body">
                      
        <div class="content_main_wrp">
                <div class="inside_cont_wrp">
                    <form name="frm_user" method="post">
                <table border="0" style="border-collapse:collapse; font-size:13px; margin-left:10px; margin-top:20px; margin-bottom:20px;" width="90%" height="auto">
                        <tr>
                        <td width="20%" height="45px" style="font-weight:600">Full Name</td>
                        <td width="80%" height="45px">
                            <input type="text" name="users_userFullname" value="<?=$users_userFullname;?>" style="width:50%; height:35px; border-radius:5px; padding-left:5px; font-family:Arial, Helvetica, sans-serif" placeholder="Full Name" required autofocus />
                        </td>
                    </tr>
                   <tr>
                        <td width="20%" height="45px" style="font-weight:600">User Name</td>
                        <td width="80%" height="45px">
                            <input type="text" name="users_userName" value="<?=$users_userName;?>" style="width:50%; height:35px; border-radius:5px; padding-left:5px; font-family:Arial, Helvetica, sans-serif" placeholder="User Name" required />
                        </td>
                    </tr>
                    <tr>
                        <td width="20%" height="45px" style="font-weight:600">Password</td>
                        <td width="80%" height="45px">
                            <input type="password" name="users_userPassword" value="<?=$users_userPassword;?>" style="width:50%; height:35px; border-radius:5px; padding-left:5px; font-family:Arial, Helvetica, sans-serif" placeholder="Password" required />
                        </td>
                    </tr>
                    <tr>
                        <td width="20%" height="45px" style="font-weight:600">Email Address</td>
                        <td width="80%" height="45px">
                                <input type="text" name="users_userEmail" value="<?=$users_userEmail;?>" style="width:50%; height:35px; border-radius:5px; padding-left:5px; font-family:Arial, Helvetica, sans-serif" placeholder="Email Address" required />
                        </td>
                    </tr>
                    
                    
                   
                    <tr>
                        <td width="20%" height="45px" style="font-weight:600">Role</td>
                        <td width="80%" height="45px">
                                <select name="users_userRole" style="width:50%; height:35px;" required>
                                        <?php 
                                        $selected = "";
                                        foreach($roles as $role){
                                           if($users_userRole == $role['roles_roleId'])
                                           {
                                               $selected = "selected";
                                           }
                                           else {
                                               $selected = "";
                                           }
                                            ?>
                                        
                                        <option <?=$selected;?> value="<?=$role['roles_roleId'];?>"><?=$role['roles_roleName'];?></option>
                                        <?php }?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td width="20%" height="50px" style="font-weight:600">&nbsp;</td>
                        <td width="80%" height="50px">
                                <input type="submit" value="ADD" name="user_add" style="width:20%; height:35px; background-color:#4b8df8; cursor:pointer; border-style:solid; border:1px solid #004e7b; color:#FFF;" />
                        </td>
                    </tr>
                   
                    <tr>
                        <td width="20%" height="auto">&nbsp;</td>
                        <td align="left" width="80%" height="auto" style="color:#F00"><?php echo $error; ?></td>
                    </tr>
                    
                </table>
            </form>
            </div><!-- inside content wrp -->
        </div><!-- Content main Wrp -->
   </div>
                        
                </div>
                        </div>
        </div>
</div>
<?php include_once("footer.php");?>