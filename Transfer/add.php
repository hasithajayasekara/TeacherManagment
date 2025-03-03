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

	$sql2= "INSERT INTO transfer(staffid,transferdate,schoolid) VALUES (
	'".mysqli_real_escape_string($connection,$_POST['txtstaff'])."',
	'".mysqli_real_escape_string($connection,$_POST['txtTransferdate'])."',
	'".mysqli_real_escape_string($connection,$_POST['txtschool'])."')";
	$result2= mysqli_query($connection,$sql2) or die("Error in sql2".mysqli_error($connection));
	
	$staffid=$_POST['txtstaff'];
	$sqlpreschool="SELECT * FROM staffwork WHERE staffid='$staffid' AND enddate='0000-00-00'";
	$resultpreschool=mysqli_query($connection,$sqlpreschool) or die("sql error in sqlpreschool ".mysqli_error($connection));
	$rowpreschool=mysqli_fetch_assoc($resultpreschool);
	
	$transdate=$_POST['txtTransferdate'];
	$previdate=date("Y-m-d", strtotime($transdate) - (3600*24));
	
	$sqlupdate="UPDATE staffwork SET enddate='$previdate' WHERE staffid='$staffid' AND startdate='$rowpreschool[startdate]'";
	$resultupdate=mysqli_query($connection,$sqlupdate) or die("sql error in sqlupdate ".mysqli_error($connection));
	
	 $sql2= "INSERT INTO staffwork(staffid,startdate,schoolid,post) VALUES (
	  '".mysqli_real_escape_string($connection,$_staffid)."',
	  '".mysqli_real_escape_string($connection,$_transdate)."',
	  '".mysqli_real_escape_string($connection,$_POST['txtschool'])."',
	  '".mysqli_real_escape_string($connection,$_POST['txtpost'])."')";
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
<title>Transfer</title>
</head>
<body>
<form action="" method="post" name="school" id="school">
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Transfer Add
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
  <table class="table table-striped table-bordered table-hover" width="200" border="0" align="center">
  	<tr>
      <td>Staff Name</td>
      <td>
      	<select name="txtstaff" required class="form-control" id="txtstaff">
        		
          		<?php
				if(isset($_GET["transtaffid"]))
				{
					$staffid=base64_decode($_GET["transtaffid"]);
					$sqlsch="SELECT ss.SID,ss.Name FROM school_staff as ss WHERE ss.SID='$staffid'";
				}
				else
				{
					$sqlsch="SELECT ss.SID,ss.Name FROM school_staff as ss, staffwork as sw WHERE ss.SID=sw.staffid AND sw.enddate='0000-00-00'";
					echo '<option value="select_School">Select Staff Name</option>';
				}
          		
          		$resultsch=mysqli_query($connection,$sqlsch) or die("sql error in sqlsch ".mysqli_error($connection));
          		while($rowsch=mysqli_fetch_assoc($resultsch))
          		{
          			echo '<option value="'.$rowsch["SID"].'">'.$rowsch["Name"].'</option>';
          		}
          		?>
		    </select>
      </td>
    </tr>
	<tr>
      <td>Transfer Date</td>
      <td><input name="txtTransferdate" type="date" value="<?php echo date("Y-m-d"); ?>" required class="form-control" id="txtTransfer"></td>
    </tr>
    <tr>
      <td>School</td>
      <td>
      	<select name="txtschool" required class="form-control" id="txtschool">
        		<option value="select_School">Select School</option>
          		<?php
          		$sqlsch="SELECT schoolid,name FROM school";
          		$resultsch=mysqli_query($connection,$sqlsch) or die("sql error in sqlsch ".mysqli_error($connection));
          		while($rowsch=mysqli_fetch_assoc($resultsch))
          		{
          			echo '<option value="'.$rowsch["schoolid"].'">'.$rowsch["name"].'</option>';
          		}
          		?>
		    </select>
      </td>
    </tr>
	<tr>
      <td>Post</td>
      <td>
        <select name="txtpost" id="txtpost" class="form-control">
                <option>Select The Post</option>
                <?php
                  $spost=array("Principal","Vice Principal","Sectional Head","Teacher");
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