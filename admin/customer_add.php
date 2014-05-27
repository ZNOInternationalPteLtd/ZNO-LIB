<?php
/**************************
 * File name: customer_add.php / add customer
 * Added by :Britta Alex
 * Modified by:
 * Date:27-05-2014
 * Version:1.0
 **************************/
include_once("header.php");
include_once ("classes/item.class.php");
$userObj = new item($DbObj);
$tablename = "admin_customers";
$id = "";
$cond = "";
if(isset($_REQUEST['id']) && $_REQUEST['id']>0)//id in case of edit
{
    $id = $_REQUEST['id'];
    
}
$customers_customerName = "";
$customers_customerAddress = "";
$customers_customerContact = "";
$customers_customerDesignation = "";
$customers_customerStatus = "";
$error = ""; 
if($id >0)//case edit
{
    $cond = "customers_customerId=".$id;//condition
    $getuserdetails = $userObj->GetListDetails($id,$tablename,$cond);//get details of customer
    foreach ($getuserdetails as $details)
    {
        $customers_customerName = $details['customers_customerName'];
        $customers_customerAddress = $details['customers_customerAddress'];
        $customers_customerContact = $details['customers_customerContact'];
        $customers_customerDesignation = $details['customers_customerDesignation'];
        $customers_customerStatus = $details['customers_customerStatus'];
    }
}//end
if(isset($_POST['user_add']) && $_POST['user_add']=="ADD")//add /edit customer
{
    $customers_customerName = $_POST['customers_customerName'];
    $customers_customerAddress = $_POST['customers_customerAddress'];
    $customers_customerContact = $_POST['customers_customerContact'];
    $customers_customerDesignation = $_POST['customers_customerDesignation'];
    $customers_customerStatus = $_POST['customers_customerStatus'];
    if($customers_customerName == "")//validation
    {
        $error = "Please enter the full name!";
    }
    elseif($customers_customerAddress == "")
    {
        $error = "Please enter the address!";
    }
    elseif($customers_customerContact == "")
    {
        $error = "Please enter the contact!";
    }
    elseif($customers_customerDesignation == "")
    {
        $error = "Please enter the designation!";
        
    }
 else {
        $error = "";
    }
    if($error == "")
    {
        $adduser = $userObj->AddList($_POST,$id,$tablename,$cond);//add/update function
        if($adduser == 1)
        {
            if($id >0)
            {
                 $param = "esuccess";
            }
            else {
                $param = "success";
            }
            
            header("Location:customer_list.php?st=".$param);
        }
        else {
            $param = "failed";
            header("Location:customer_list.php?st=".$param);
        }
    }
}//end add/edit

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
							<a href="customer_add.php">Add Customer</a>
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
                    <form name="frm_customer" method="post">
                <table border="0" style="border-collapse:collapse; font-size:13px; margin-left:10px; margin-top:20px; margin-bottom:20px;" width="90%" height="auto">
                        <tr>
                        <td width="20%" height="45px" style="font-weight:600">Full Name</td>
                        <td width="80%" height="45px">
                            <input type="text" name="customers_customerName" value="<?=$customers_customerName;?>" style="width:50%; height:35px; border-radius:5px; padding-left:5px; font-family:Arial, Helvetica, sans-serif" placeholder="Full Name" required autofocus />
                        </td>
                    </tr>
                   <tr>
                        <td width="20%" height="45px" style="font-weight:600">Address</td>
                        <td width="80%" height="45px">
                            <input type="text" name="customers_customerAddress" value="<?=$customers_customerAddress;?>" style="width:50%; height:35px; border-radius:5px; padding-left:5px; font-family:Arial, Helvetica, sans-serif" placeholder="Address" required />
                        </td>
                    </tr>
                    <tr>
                        <td width="20%" height="45px" style="font-weight:600">Contact</td>
                        <td width="80%" height="45px">
                            <input type="text" name="customers_customerContact" value="<?=$customers_customerContact;?>" style="width:50%; height:35px; border-radius:5px; padding-left:5px; font-family:Arial, Helvetica, sans-serif" placeholder="Contact" required />
                        </td>
                    </tr>
                    <tr>
                        <td width="20%" height="45px" style="font-weight:600">Designation</td>
                        <td width="80%" height="45px">
                                <input type="text" name="customers_customerDesignation" value="<?=$customers_customerDesignation;?>" style="width:50%; height:35px; border-radius:5px; padding-left:5px; font-family:Arial, Helvetica, sans-serif" placeholder="Designation" required />
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