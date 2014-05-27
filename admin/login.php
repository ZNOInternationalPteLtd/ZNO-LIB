<?php
/**************************
 * File name: login.php / login for user 
 * Added by :Britta Alex
 * Modified by:
 * Date:27-05-2014
 * Version:1.0
 **************************/
ob_start();
session_start();
include_once 'classes/login.class.php';
$objLogin = new login($DbObj);
$username = "";
$password = "";
$error = "";
if (isset($_SESSION['uname']) && isset($_SESSION['pass']))
{
    header("Location:index.php");
}
/******Login Action*******/
if(isset($_POST['login_button'])&&$_POST['login_button'] == "SIGN IN")
{
     $username = $_POST['users_userName'];
     $password = $_POST['users_userPassword'];
    if(isset($username) && $username == "")
        {
            $error = "Username is mandatory!";
        }
    elseif (isset ($password)&& $password == "")
        {
            $error = "Password mandatory!";
        }
    else 
        {
            $error = "";
        }
     if($error == "")
     {
         $login = $objLogin->Checklogin($username,$password);
         if(count($login)>0)
         { 
             foreach ($login  as $vals)
             {
             $_SESSION['uname'] = $vals['users_userName'];
             $_SESSION['pass'] = $vals['users_userPassword'];
             }
             header('Location:index.php');
            exit;
         }
        else {
                $error = "Invalid Login.Please try again.";
             }
     }
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Becker - Log In</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="includes/favicon.ico" />
<style type="text/css">
	.sign_in_but_wrp{
		width:57px;
		height:27px;
		cursor:pointer;
		border-style:none;
		border-radius:2px;
		background-image:url("img/signin.png");
                color: #FFF;
	}
</style>
</head>

<body>
	<table border="0" style="border-collapse:collapse; margin-top:15%" align="center" width="115px" height="auto">
    	<tr>
            <td><img src="img/beckerlogo.png" /></td>
        </tr>
    </table>
    <form  name="frm_login" id="frm_login" method="post">
    <table border="0" style="border-collapse:collapse; margin-top:10px;" align="center" width="250px" height="auto">
    	<tr>
        	<td width="250px" height="45px">
                    <input type="text" name="users_userName" id="users_userName" value="<?=$username;?>" placeholder="Username" style="border-radius:3px; border:1px solid #a1a0a0; padding-left:5px; width:240px; height:30px;" autocomplete="off" autofocus required />	
            </td>
        </tr>
        <tr>
        	<td width="250px" height="45px">
                    <input type="password" name="users_userPassword" value="<?=$password;?>" placeholder="Password" style="border-radius:3px; border:1px solid #a1a0a0; padding-left:5px; width:240px; height:30px;" autocomplete="off" required />
            </td>
        </tr>
        <tr>
        	<td width="250px" height="45px" align="center">
                    <input type="submit"  value="SIGN IN" class="sign_in_but_wrp" name="login_button" />
            </td>
        </tr>
        <?php
			if(!empty($error)){
		?>
        <tr>
        	<td width="250px" height="45px" align="center" style="color:#F00; font-family:Arial, Helvetica, sans-serif; font-size:13px;">
            	<?php echo $error; ?>
            </td>
        </tr>
        <?php
			}
		?>
    </table>
    </form>
</body>
</html>