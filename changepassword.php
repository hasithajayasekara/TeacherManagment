<?php
include("config.php");
if(!isset($_SESSION))
{
	session_start();
}
if(isset($_SESSION['usertype']))
{
	$usertype=$_SESSION['usertype'];
}
else
{
	$usertype="guest";
}
if($usertype!="guest")
{
if(isset($_POST['btnsubmit']))
{
	$sql1="SELECT * FROM login WHERE user_id='$_POST[txtusername]'";
	$result1=mysql_query($sql1) or die("error in sql1 section:".mysql_error());
	$row1=mysql_fetch_assoc($result1);
	if ($row1["password"]==$_POST["txtcurrentpassword"])
	{
		if($_POST["txtnewpassword"]==$_POST["txtrenewpassword"])
		{
			$sql2="Update login SET password='$_POST[txtnewpassword]' WHERE user_id='$_POST[txtusername]'";
			$result2=mysql_query($sql2) or die("error in sql2 section:".mysql_error());
			echo"<script> alert ('Your new password is update successfully'); window.location.href='index.php?pg=signout.php&cp' </script>";
		}
		else
		{
			echo"<script> alert ('Your new password is mismatch'); </script>";
		}
	}
	else
	{
		echo"<script> alert ('Your current password is wrong'); </script>";
	}
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<script type="text/javascript">
function checkpwd()
	{	
		var ne= document.getElementById("txtnewpassword").value;
		var rne= document.getElementById("txtrenewpassword").value;
		
		if(ne==rne)
		{
		}
		else 
		{
		document.getElementById("txtnewpassword").value="";
		document.getElementById("txtrenewpassword").value="";
		alert("Your New Password is Not Match");
		}
	}
</script>
</head>
<?php
$username= $_SESSION['username'];
?>
<body>
<form id="forget" name="forget" method="post" action="">
  <table width="376" border="0" align="center">
    <tr>
      <td width="178"><b>User Name</b></td>
      <td width="188"><input name="txtusername" type="text" value="<?php echo $username; ?>" readonly required   class="form-control" id="txtusername"></td>
    </tr>
    <tr>
      <td><b>Current password</b></td>
      <td width="188"><input name="txtcurrentpassword" type="password" required   class="form-control" id="txtcurrentpassword"></td>
    </tr>
    <tr>
      <td><b>New password</b></td>
      <td width="188"><input name="txtnewpassword" onBlur="password()" type="password" required   class="form-control" id="txtnewpassword"></td>
    </tr>
    <tr>
      <td><b>Re Enter New password</b></td>
      <td width="188"><input name="txtrenewpassword" type="password" required onBlur="checkpwd()"   class="form-control" id="txtrenewpassword"></td>
    </tr>
    <tr>
      <td><input class="btn btn-danger" type="reset" name="btnreset" id="btnreset" value="Clear" button class='btn-primary'></td>
      <td><input class="btn btn-success" type="submit" name="btnsubmit" id="btnsubmit" value="Submit" button class='btn-success'></td>
    </tr>
  </table>
</form>
</body>
</html>
<?php
}
else
{
header("location:index.php");	
}
?>