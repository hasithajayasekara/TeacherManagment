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
	$seminarid=$_POST["txtseminarid"];
	
	$sql2= "UPDATE seminar SET 
		date='".mysqli_real_escape_string($connection,$_POST['txtdate'])."',
		details='".mysqli_real_escape_string($connection,$_POST['txtdetails'])."'
		WHERE seminarid='".mysqli_real_escape_string($connection,$seminarid)."'";
	$result2= mysqli_query($connection,$sql2) or die("Error in sql2".mysqli_error($connection));
	
	$totalloop=$_POST['txtloop'];
    $submit=0;
    for ($x=1; $x < $totalloop ; $x++) 
    { 
		if($_POST['txtstaffatten'.$x]=="Yes")
		{
		  $sql2= "INSERT INTO seminarparticipant(seminarid,staffid) VALUES (
		  '".mysqli_real_escape_string($connection,$seminarid)."',
		  '".mysqli_real_escape_string($connection,$_POST['txtstaffid'.$x])."')";
		  $result2= mysqli_query($connection,$sql2) or die("Error in sql2".mysqli_error($connection));
		  $submit++;
		}
    }
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
<title>Seminar</title>
</head>
<body>
<form action="" method="post" name="seminar" id="seminar">
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Seminar Edit
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
  <table class="table table-striped table-bordered table-hover" width="200" border="0" align="center">
    <?php
	$semid=base64_decode($_GET["semid"]);
	$sql3 = "SELECT * FROM seminar WHERE seminarid='$semid'";
	$view = mysqli_query($connection,$sql3)or die("Error in sql3".mysqli_error($connection));
	$viewarr = mysqli_fetch_assoc($view);
	echo '<input type="hidden" name="txtseminarid" id="txtseminarid" value="'.$semid.'">';
	?>
    <tr>
      <td>Date</td>
      <td><input name="txtdate" type="date" value="<?php echo $viewarr["date"]; ?>" min="<?php echo date("Y-m-d"); ?>" required class="form-control" id="txtdate" ></td>
    </tr>
	<tr>
      <td>Details</td>
      <td><textarea name="txtdetails" required class="form-control" id="txtdetails" placeholder="Type Details">
	  <?php echo $viewarr["details"]; ?></textarea></td>
    </tr>
	<tr>
      <td colspan="2"> Staff Details</td>
    </tr>
	<tr>
      <td colspan="2">
		<table class="table table-striped table-bordered table-hover" width="200" border="0" align="center">
		<tr><th>Staff Name</th><th>Participant</th></tr>
		<?php
      $sql1 = "SELECT SID,Name FROM school_staff";
      $result = mysqli_query($connection,$sql1)or die("Error in sql1".mysqli_error($connection));
      $x=1;
      while($view = mysqli_fetch_assoc($result))
        {
		$sqlcheck="SELECT * FROM seminarparticipant WHERE seminarid='$semid' AND staffid='$view[SID]'";
		$resultcheck=mysqli_query($connection,$sqlcheck) or die("sql error in sqlcheck ".mysqli_error($connection));
		if(mysqli_num_rows($resultcheck)==0)
		{
          echo '<tr><td>';
          echo '<input type="hidden" value="'.$view["SID"].'" name="txtstaffid'.$x.'" class="form-control" id="txtstaffid'.$x.'">';
          echo '<input type="text" value="'.$view["Name"].'" name="txtstaffname'.$x.'" readonly class="form-control" id="txtstaffname'.$x.'">';
          echo '</td>';
          echo '<td>';
          echo '<select name="txtstaffatten'.$x.'" required class="form-control" id="txtstaffatten">
		  <option value="No">No</option>
		  <option value="Yes">Yes</option>	  
		  </select>';
          echo '</td>';
          echo '</tr>';
          $x++;
		}
        }

        echo '<input type="hidden" value="'.$x.'" name="txtloop"class="form-control" id="txtloop">';
    ?>
		</table>
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