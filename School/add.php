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
	$sql1= "SELECT schoolid FROM school ORDER BY schoolid DESC LIMIT 1"; 
	$result1= mysqli_query($connection,$sql1) or die("Error in sql1".mysqli_error($connection));
	if (mysqli_num_rows($result1)> 0)
	{
		$row1= mysqli_fetch_assoc($result1);
		$schoolid=++$row1["schoolid"];
	}
	else
	{
		$schoolid="SCH00001";
	}
	$sql2= "INSERT INTO school(schoolid,censusid,name,address,tpnum,zoneid) VALUES (
	'".mysqli_real_escape_string($schoolid)."',
	'".mysqli_real_escape_string($_POST['txtcensusid'])."',
	'".mysqli_real_escape_string($_POST['txtschname'])."',
	'".mysqli_real_escape_string($_POST['txtaddress'])."',
	'".mysqli_real_escape_string($_POST['txttpnum'])."',
	'".mysqli_real_escape_string($_POST['txtzone'])."')";
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
<title>School</title>
</head>
<body>
<form action="" method="post" name="school" id="school">
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            School Add
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
  <table class="table table-striped table-bordered table-hover" width="200" border="0" align="center">
    
    <tr>
      <td>Census ID</td>
      <td><input name="txtcensusid" type="text" onKeyPress="return isNumberKey(event)"required class="form-control" id="txtcensusid" placeholder="Type Census ID"></td>
    </tr>
	<tr>
      <td>School Name</td>
      <td><input name="txtschname" type="text" onKeyPress="return isTextKey(event)"required class="form-control" id="txtschname" placeholder="Type School Name"></td>
    </tr>
	<tr>
      <td>School Address</td>
      <td><input name="txtaddress" type="text" required class="form-control" id="txtaddress" placeholder="Type School Address"></td>
    </tr>
	<tr>
      <td>Telephone Number</td>
      <td><input name="txttpnum" type="text" onKeyPress="return isNumberKey(event)"required class="form-control" id="txttpnum" placeholder="Type Telephone Number"></td>
    </tr>
	<tr>
      <td>Zone</td>
      <td>
		<select name="txtzone" required class="form-control" id="txtzone">
		<option value="select_zone">Select Zone</option>
		<?php
		$sqlzone="SELECT * FROM zone";
		$resultzone=mysqli_query($connection,$sqlzone) or die("sql error in sqlzone ".mysqli_error($connection));
		while($rowzone=mysqli_fetch_assoc($resultzone))
		{
			echo '<option value="'.$rowzone["zoneid"].'">'.$rowzone["zonename"].'</option>';
		}
		?>
		</select>
	  </td>
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