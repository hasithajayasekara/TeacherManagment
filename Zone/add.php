<?php
include("../config.php");
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
if($usertype=="zone" || $usertype=="clerk")
{
if(isset($_POST['btnsubmitadd']))
{
	$sql1= "SELECT zoneid FROM zone ORDER BY zoneid DESC LIMIT 1"; 
	$result1= mysqli_query($connection,$sql1) or die("Error in sql1".mysqli_error($connection));
	if (mysqli_num_rows($result1)> 0)
	{
		$row1= mysqli_fetch_assoc($result1);
		$zonid=++$row1["zoneid"];
	}
	else
	{
		$zonid="Z00001";
	}
	$sql2= "INSERT INTO zone(zoneid,zonename) VALUES (
	'".mysqli_real_escape_string($zonid)."',
	'".mysqli_real_escape_string($_POST['txtzonename'])."')";
	$result2= mysqli_query($connection,$sql2) or die("Error in sql2".mysqli_error($connection));
	if($result2)
	{
		echo "<script> alert('Successfully Insert into Database');window.location.href='index.php'; </script>";
	}
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Zone</title>
</head>
<body>
<form action="" method="post" name="school" id="school">
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Zone Add
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
  <table class="table table-striped table-bordered table-hover" width="200" border="0" align="center">
	<tr>
      <td>Zone Name</td>
      <td><input name="txtzonename" type="text" onKeyPress="return isTextKey(event)"required class="form-control" id="txtschname" placeholder="Type School Name"></td>
    </tr>
    <tr>
      <td colspan="2">
		<center><a href="index.php"> <input type='button' name="gobutton" class="btn btn-success" id="gobutton"value='Go Back' class="buttonPro gray"></a>
		<input type="reset" name="btnreset" id="btnreset" class="btn btn-danger" value="Reset">
		<input type="submit" name="btnsubmitadd" id="btnsubmitadd" class="btn btn-primary" value="Submit">
		</center>
	</td>
    </tr>
  </table></div></div></div></div></div>
</form>
<?php
//usertype check end
}
else
{
	header("location:../index.php");
}
?>
</body>
</html>