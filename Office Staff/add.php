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
	$sql1= "SELECT SID FROM office_staff ORDER BY SID DESC LIMIT 1"; 
	$result1= mysqli_query($connection,$sql1) or die("Error in sql1".mysqli_error($connection));
	if (mysqli_num_rows($result1)> 0)
	{
		$row1= mysqli_fetch_assoc($result1);
		$stfid=++$row1["SID"];
	}
	else
	{
		$stfid="OS000001";
	}
	$sql2= "INSERT INTO office_staff(SID,Name,Gender,Date_of_birth,Age,NIC_number,Religion,Nationality,Civil_status,Address,Telephone_number,First_appoinment_date,Post) VALUES (
	'".mysqli_real_escape_string($stfid)."',
	'".mysqli_real_escape_string($_POST['txtstfname'])."',
	'".mysqli_real_escape_string($_POST['txt_gend'])."',
	'".mysqli_real_escape_string($_POST['txttdob'])."',
	'".mysqli_real_escape_string($_POST['txtage'])."',
	'".mysqli_real_escape_string($_POST['txtnic'])."',
	'".mysqli_real_escape_string($_POST['txtrelg'])."',
	'".mysqli_real_escape_string($_POST['txtnation'])."',
	'".mysqli_real_escape_string($_POST['txtstcivel'])."',
	'".mysqli_real_escape_string($_POST['txtaddress'])."',
	'".mysqli_real_escape_string($_POST['txtphone'])."',
	'".mysqli_real_escape_string($_POST['txtapdate'])."',
	'".mysqli_real_escape_string($_POST['txtpost'])."')";
	$result2= mysqli_query($connection,$sql2) or die("Error in sql2".mysqli_error($connection));
	if($_POST['txtpost']=="ZDE")
	{
		$desi="zone";
	}
	else
	{
		$desi="clerk";
	}
   $sql2= "INSERT INTO login(user_id,password,user_type,attempt) VALUES (
  '".mysqli_real_escape_string($stfid)."',
  '".mysqli_real_escape_string($_POST['txtnic'])."',
  '".mysqli_real_escape_string($desi)."',
  '".mysqli_real_escape_string('0')."')";
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
<title>Office Staff</title>
</head>
<body>
<form action="" method="post" name="offi_staff" id="offi_staff">
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Office Staff Add
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
  <table class="table table-striped table-bordered table-hover" width="200" border="0" align="center">
    
    <tr>
      <td>Staff Name</td>
      <td><input name="txtstfname" type="text" onKeyPress="return isTextKey(event)"required class="form-control" id="txtstfname" placeholder="Type Staff Name"></td>
    </tr>
	<tr>
      <td>Gender</td>
      <td>
      	<select name="txt_gend" id="txt_gend" class="form-control">
			<option>Select The Gender</option>
			<option>Male</option>
			<option>Female</option>
		</select>
      </td>
    </tr>
	<tr>
      <td>Date of birth</td>
      <td><input name="txttdob" type="date" required class="form-control" id="txttdob"></td>
    </tr>
    <tr>
      <td>Age</td>
      <td><input name="txtage" type="text" onKeyPress="return isNumberKey(event)"required class="form-control" id="txtage" placeholder="Type Age"></td>
    </tr>
	<tr>
      <td>NIC Number</td>
      <td><input name="txtnic" type="text" required class="form-control" id="txtnic" placeholder="Type NIC Number"></td>
    </tr>
    <tr>
      <td>Religion</td>
      <td><input name="txtrelg" type="text" onKeyPress="return isTextKey(event)"required class="form-control" id="txtrelg" placeholder="Type Religion"></td>
    </tr>
	<tr>
      <td>Nationality</td>
      <td><input name="txtnation" type="text" onKeyPress="return isTextKey(event)"required class="form-control" id="txtnation" placeholder="Type Nationality"></td>
    </tr>
    <tr>
      <td>Civil Status</td>
      <td><input name="txtstcivel" type="text" onKeyPress="return isTextKey(event)"required class="form-control" id="txtstcivel" placeholder="Type Civil Status"></td>
    </tr>
    <tr>
      <td>Staff Address</td>
      <td><input name="txtaddress" type="text" required class="form-control" id="txtaddress" placeholder="Type Staff Address"></td>
    </tr>
    <tr>
      <td>Phone Number</td>
      <td><input name="txtphone" type="text" onKeyPress="return isNumberKey(event)"required class="form-control" id="txtphone" placeholder="Type Phone Number"></td>
    </tr>
	<tr>
      <td>First Appoinment Date</td>
      <td><input name="txtapdate" type="date" required class="form-control" id="txtapdate"></td>
    </tr>
    <tr>
      <td>Post</td>
      <td>
        <select name="txtpost" id="txtpost" class="form-control">
                <option>Select The Post</option>
                <?php
                  $spost=array("ZDE","Clerk","MA");
                  for($x=0;$x<count($spost);$x++)
                  {
                    echo '<option value="'.$spost[$x].'">'.$spost[$x].'</option>';
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