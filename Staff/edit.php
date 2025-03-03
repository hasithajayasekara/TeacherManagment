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
	$sql2= "UPDATE school_staff SET
				Name='".mysqli_real_escape_string($connection,$_POST['txtstfname'])."',
				Gender='".mysqli_real_escape_string($connection,$_POST['txt_gend'])."',
				Date_of_birth='".mysqli_real_escape_string($connection,$_POST['txttdob'])."',
				Age='".mysqli_real_escape_string($connection,$_POST['txtage'])."',
				NIC_number='".mysqli_real_escape_string($connection,$_POST['txtnic'])."',
				Religion='".mysqli_real_escape_string($connection,$_POST['txtrelg'])."',
				Nationality='".mysqli_real_escape_string($connection,$_POST['txtnation'])."',
				Civil_status='".mysqli_real_escape_string($connection,$_POST['txtstcivel'])."',
				Address='".mysqli_real_escape_string($connection,$_POST['txtaddress'])."',
				Telephone_number='".mysqli_real_escape_string($connection,$_POST['txtphone'])."',
				First_appoinment_date='".mysqli_real_escape_string($connection,$_POST['txtapdate'])."',
				First_appoinment_school='".mysqli_real_escape_string($connection,$_POST['txtschool'])."',
				Subject_teach='".mysqli_real_escape_string($connection,$_POST['txtteach'])."',
				Post='".mysqli_real_escape_string($connection,$_POST['txtpost'])."'
				WHERE SID='".mysqli_real_escape_string($connection,$_POST['txtstaffid'])."'";
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
<title>School Staff</title>
</head>
<body>
<form action="" method="post" name="sch_staff" id="sch_staff">
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            School Staff Edit
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
  <table class="table table-striped table-bordered table-hover" width="200" border="0" align="center">
    <?php
	$stfid=base64_decode($_GET["staffid"]);
	$sql3 = "SELECT * FROM school_staff WHERE SID='$stfid'";
	$view = mysqli_query($connection,$sql3)or die("Error in sql3".mysqli_error($connection));
	$viewarr = mysqli_fetch_assoc($view);
	echo '<input type="hidden" name="txtstaffid" id="txtstaffid" value="'.$stfid.'">';
	?>
   
    <tr>
      <td>Staff Name</td>
      <td><input name="txtstfname" value="<?php echo $viewarr["Name"]; ?>" type="text" onKeyPress="return isTextKey(event)"required class="form-control" id="txtstfname" placeholder="Type Staff Name"></td>
    </tr>
	<tr>
      <td>Gender</td>
      <td>
      	<select name="txt_gend" id="txt_gend" class="form-control">
			<?php
				$paymode=array("Male","Female");
				for($x=0;$x<count($paymode);$x++)
				  {
					if($paymode[$x]==$viewarr["Gender"])
					{
						echo '<option selected value="'.$paymode[$x].'">'.$paymode[$x].'</option>';
					}
					else
					{
						echo '<option value="'.$paymode[$x].'">'.$paymode[$x].'</option>';
					}										
				  }
				?>
		</select>
      </td>
    </tr>
	<tr>
      <td>Date of birth</td>
      <td><input name="txttdob" value="<?php echo $viewarr["Date_of_birth"]; ?>" type="date" required class="form-control" id="txttdob"></td>
    </tr>
    <tr>
      <td>Age</td>
      <td><input name="txtage" value="<?php echo $viewarr["Age"]; ?>" type="text" onKeyPress="return isNumberKey(event)"required class="form-control" id="txtage" placeholder="Type Age"></td>
    </tr>
	<tr>
      <td>NIC Number</td>
      <td><input name="txtnic" value="<?php echo $viewarr["NIC_number"]; ?>" type="text" required class="form-control" id="txtnic" placeholder="Type NIC Number"></td>
    </tr>
    <tr>
      <td>Religion</td>
      <td><input name="txtrelg" value="<?php echo $viewarr["Religion"]; ?>" type="text" onKeyPress="return isTextKey(event)"required class="form-control" id="txtrelg" placeholder="Type Religion"></td>
    </tr>
	<tr>
      <td>Nationality</td>
      <td><input name="txtnation" value="<?php echo $viewarr["Nationality"]; ?>" type="text" onKeyPress="return isTextKey(event)"required class="form-control" id="txtnation" placeholder="Type Nationality"></td>
    </tr>
    <tr>
      <td>Civil Status</td>
      <td><input name="txtstcivel" value="<?php echo $viewarr["Civil_status"]; ?>" type="text" onKeyPress="return isTextKey(event)"required class="form-control" id="txtstcivel" placeholder="Type Civil Status"></td>
    </tr>
    <tr>
      <td>Staff Address</td>
      <td><input name="txtaddress" value="<?php echo $viewarr["Address"]; ?>" type="text" required class="form-control" id="txtaddress" placeholder="Type Staff Address"></td>
    </tr>
    <tr>
      <td>Phone Number</td>
      <td><input name="txtphone" value="<?php echo $viewarr["Telephone_number"]; ?>" type="text" onKeyPress="return isNumberKey(event)"required class="form-control" id="txtphone" placeholder="Type Phone Number"></td>
    </tr>
	<tr>
      <td>First Appoinment Date</td>
      <td><input name="txtapdate" value="<?php echo $viewarr["First_appoinment_date"]; ?>" type="date" required class="form-control" id="txtapdate"></td>
    </tr>
    <tr>
      <td>First Appoinment School</td>
      <td>
      	<select name="txtschool" required class="form-control" id="txtschool">
      		<?php
				$sqlsch="SELECT * FROM school";
          		$resultsch=mysqli_query($connection,$sqlsch) or die("sql error in sqlsch ".mysqli_error($connection));
					while($rowsch=mysqli_fetch_assoc($resultsch))
						{
							if($rowsch["schoolid"]==$viewarr["First_appoinment_school"])
							{
								echo '<option selected value="'.$rowsch["schoolid"].'">'.$rowsch["name"].'</option>';
							}
							else
							{
								echo '<option value="'.$rowsch["schoolid"].'">'.$rowsch["name"].'</option>';
							}
											
						}
				?>
		    </select>
      </td>
    </tr>
	<tr>
      <td>Subject Teach</td>
      <td>
        <select name="txtteach" id="txtteach" class="form-control">
        	<?php
				$subtch=array("Tamil","Religion","History","Science","Mathematics",);
				for($x=0;$x<count($subtch);$x++)
				  {
					if($subtch[$x]==$viewarr["Subject_teach"])
					{
						echo '<option selected value="'.$subtch[$x].'">'.$subtch[$x].'</option>';
					}
					else
					{
						echo '<option value="'.$subtch[$x].'">'.$subtch[$x].'</option>';
					}										
				  }
				?>
        </select>
      </td>
    </tr>
    <tr>
      <td>Post</td>
      <td>
        <select name="txtpost" id="txtpost" class="form-control">
        	<?php
				 $spost=array("Principal","Vice Principal","Sectional Head","Teacher");
				for($x=0;$x<count($spost);$x++)
				  {
					if($spost[$x]==$viewarr["Post"])
					{
						echo '<option selected value="'.$spost[$x].'">'.$spost[$x].'</option>';
					}
					else
					{
						echo '<option value="'.$spost[$x].'">'.$spost[$x].'</option>';
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