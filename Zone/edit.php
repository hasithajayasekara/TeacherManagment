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
if(isset($_POST['btnsubmitedit']))
{
	$sql2= "UPDATE zone SET
		zonename='".mysqli_real_escape_string($_POST['txtzonename'])."'
		WHERE zoneid='".mysqli_real_escape_string($_POST['zonid'])."'";
	$result2= mysqli_query($connection,$sql2) or die("Error in sql2".mysqli_error($connection));
	if($result2)
	{
		echo "<script> alert('Successfully update into Database');window.location.href='index.php'; </script>";
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
<form action="" method="post" name="zone" id="zone">
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Zone Edit
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
  <table class="table table-striped table-bordered table-hover" width="200" border="0" align="center">
    <?php
	$zoid=base64_decode($_GET["zoid"]);
	$sql3 = "SELECT * FROM zone WHERE zoneid='$zoid'";
	$view = mysqli_query($connection,$sql3)or die("Error in sql3".mysqli_error($connection));
	$viewarr = mysqli_fetch_assoc($view);
	echo '<input type="hidden" name="zonid" id="zonid" value="'.$zoid.'">';
	?>
    <tr>
      <td>Zone Name</td>
      <td><input name="txtzonename" value="<?php echo $viewarr["zonename"]; ?>" type="text" onKeyPress="return isTextKey(event)"required class="form-control" id="txtcensusid" placeholder="Type Census ID"></td>
    </tr>
    <tr>
      <td colspan="2">
		<center><a href="index.php"> <input type='button' name="gobutton" class="btn btn-success" id="gobutton"value='Go Back' class="buttonPro gray"></a>
		<input type="reset" name="btnreset" id="btnreset" class="btn btn-danger" value="Reset">
		<input type="submit" name="btnsubmitedit" id="btnsubmitedit" class="btn btn-primary" value="Submit">
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