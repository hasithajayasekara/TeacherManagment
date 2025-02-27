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
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>School Staff</title>
</head>
<body>
	<div class="row">
       <div class="col-lg-12">
         <div class="panel panel-default">
           <div class="panel-heading">
               School Staff View
           </div>
            <div class="panel-body">
              <div class="table-responsive">
				<table class="table table-striped table-bordered table-hover" id="dataTables-example">

					<?php
						$stfid=base64_decode($_GET["staffid"]);
						$sql3 = "SELECT * FROM school_staff WHERE SID='$stfid'";
						$view = mysqli_query($connection,$sql3)or die("Error in sql3".mysqli_error($connection));
						$viewarr = mysqli_fetch_assoc($view);
					?>

				<tr><th>Staff Name</th><td><?php echo $viewarr["Name"]; ?></td></tr>
				<tr><th>Gender</th><td><?php echo $viewarr["Gender"]; ?></td></tr>
				<tr><th>Date of birth</th><td><?php echo $viewarr["Date_of_birth"]; ?></td></tr>
				<tr><th>Age</th><td><?php echo $viewarr["Age"]; ?></td></tr>
				<tr><th>NIC Number</th><td><?php echo $viewarr["NIC_number"]; ?></td></tr>
				<tr><th>Religion</th><td><?php echo $viewarr["Religion"]; ?></td></tr>
				<tr><th>Nationality</th><td><?php echo $viewarr["Nationality"]; ?></td></tr>
				<tr><th>Civil Status</th><td><?php echo $viewarr["Civil_status"]; ?></td></tr>
				<tr><th>Staff Address</th><td><?php echo $viewarr["Address"]; ?></td></tr>
				<tr><th>Phone Number</th><td><?php echo $viewarr["Telephone_number"]; ?></td></tr>
				<tr><th>First Appoinment Date</th><td><?php echo $viewarr["First_appoinment_date"]; ?></td></tr>
					<?php
					$sqlschool="SELECT name FROM school WHERE schoolid='$viewarr[First_appoinment_school]'";
					$resultsch=mysqli_query($connection,$sqlschool) or die("sql error in sqlschool ".mysqli_error($connection));
					$rowsch=mysqli_fetch_assoc($resultsch);
					?>
				<tr><th>First Appoinment School</th><td><?php echo $rowsch["name"]; ?></td></tr>
				<tr><th>Subject Teach</th><td><?php echo $viewarr["Subject_teach"]; ?></td></tr>
				<tr><th>Post</th><td><?php echo $viewarr["Post"]; ?></td></tr>
				<?php
				?>
				<tr>
					<td colspan="2">
						<center>
						<a href="index.php"> <input type='button' name="gobutton" class="btn btn-success" id="gobutton"value='Go Back' class="buttonPro gray"></a>
						<a href="index.php?id=<?php echo base64_encode("edit"); ?>&staffid=<?php echo base64_encode($viewarr["SID"]); ?>"><button class="btn btn-info"><i class="icon-edit"></i>Edit</button></a>
						</center>
					</td>
				</tr>
			</table>
			</div>
			</div>
		</div>
	</div>
</div>
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