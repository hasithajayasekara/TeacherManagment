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
	$sql2= "UPDATE school SET
		censusid='".mysqli_real_escape_string($connection,$_POST['txtcensusid'])."',
		name='".mysqli_real_escape_string($connection,$_POST['txtschname'])."',
		address='".mysqli_real_escape_string($connection,$_POST['txtaddress'])."',
		tpnum='".mysqli_real_escape_string($connection,$_POST['txttpnum'])."',
		zoneid='".mysqli_real_escape_string($connection,$_POST['txtzone'])."'
		WHERE schoolid='".mysqli_real_escape_string($connection,$_POST['txtschoolid'])."'";
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
<title>School</title>
</head>
<body>
<form action="" method="post" name="school" id="school">
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            School Edit
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
  <table class="table table-striped table-bordered table-hover" width="200" border="0" align="center">
    <?php
	$schid=base64_decode($_GET["schid"]);
	$sql3 = "SELECT * FROM school WHERE schoolid='$schid'";
	$view = mysqli_query($connection,$sql3)or die("Error in sql3".mysqli_error($connection));
	$viewarr = mysqli_fetch_assoc($view);
	echo '<input type="hidden" name="txtschoolid" id="txtschoolid" value="'.$schid.'">';
	?>
    <tr>
      <td>Census ID</td>
      <td><input name="txtcensusid" value="<?php echo $viewarr["censusid"]; ?>" type="text" onKeyPress="return isNumberKey(event)"required class="form-control" id="txtcensusid" placeholder="Type Census ID"></td>
    </tr>
	<tr>
      <td>School Name</td>
      <td><input name="txtschname" value="<?php echo $viewarr["name"]; ?>" type="text" onKeyPress="return isTextKey(event)"required class="form-control" id="txtschname" placeholder="Type School Name"></td>
    </tr>
	<tr>
      <td>School Address</td>
      <td><input name="txtaddress" value="<?php echo $viewarr["address"]; ?>" type="text" required class="form-control" id="txtaddress" placeholder="Type School Address"></td>
    </tr>
	<tr>
      <td>Telephone Number</td>
      <td><input name="txttpnum" value="<?php echo $viewarr["tpnum"]; ?>" type="text" onKeyPress="return isNumberKey(event)"required class="form-control" id="txttpnum" placeholder="Type Telephone Number"></td>
    </tr>
	<tr>
      <td>Zone</td>
      <td>
		<select name="txtzone" required class="form-control" id="txtzone">
		<?php
		$sqlzone="SELECT * FROM zone";
		$resultzone=mysqli_query($connection,$sqlzone) or die("sql error in sqlzone ".mysqli_error($connection));
		while($rowzone=mysqli_fetch_assoc($resultzone))
		{
			if($viewarr["zoneid"]==$rowzone["zoneid"])
			{
				echo '<option selected value="'.$rowzone["zoneid"].'">'.$rowzone["zonename"].'</option>';
			}
			else
			{
				echo '<option value="'.$rowzone["zoneid"].'">'.$rowzone["zonename"].'</option>';
			}
		}
		?>
		</select>
	  </td>
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