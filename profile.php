<?php
include("config.php");
if(!isset($_SESSION))
{
	session_start();
}
if(isset($_SESSION['usertype']))
{
	$usertype=$_SESSION['usertype'];
	$username=$_SESSION['username'];
}
else
{
	$usertype="guest";
}
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
               Profile
           </div>
            <div class="panel-body">
              <div class="table-responsive">
				<table class="table table-striped table-bordered table-hover" id="dataTables-example">

					<?php
						$sql3 = "SELECT * FROM school_staff WHERE SID='$username'";
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
				<tr>
				<th colspan="2"><center>Current Work School</center></th>
				</tr>
				<tr>
				<td colspan="2">
					<table class="table table-striped table-bordered table-hover" id="dataTables-example">
						<tr><th>School Name</th><th>Work From</th><th>POST</th></tr>
						<?php
						$sqlwork = "SELECT * FROM staffwork WHERE staffid='$username' AND enddate='0000-00-00'";
						$viewwork = mysqli_query($connection,$sqlwork)or die("Error in sqlwork".mysqli_error($connection));
						$viewarrwork = mysqli_fetch_assoc($viewwork);
						
						$sqlschool="SELECT name FROM school WHERE schoolid='$viewarrwork[schoolid]'";
						$resultsch=mysqli_query($connection,$sqlschool) or die("sql error in sqlschool ".mysqli_error($connection));
						$rowsch=mysqli_fetch_assoc($resultsch);
						echo '<tr>';
							echo '<td>'.$rowsch["name"].'</td>';
							echo '<td>'.$viewarrwork["startdate"].'</td>';
							echo '<td>'.$viewarrwork["post"].'</td>';
						echo '</tr>';
						?>
					</table>
				</td>
				</tr>
				<tr>
				<th colspan="2"><center>Salary</center></th>
				</tr>
				<tr>
				<td colspan="2">
					<table class="table table-striped table-bordered table-hover" id="dataTables-example">
						<tr><th></th><th>Year</th><th>Month</th><th>Net Salary</th><th>EPF</th><th>ETF</th></tr>
						<?php
						$x=1;
						$sqlsalary = "SELECT * FROM salary WHERE staffid='$username'";
						$viewsalary = mysqli_query($connection,$sqlsalary)or die("Error in sqlsalary".mysqli_error($connection));
						while($viewarrsalary = mysqli_fetch_assoc($viewsalary))
						{
							echo '<tr>';
								echo '<td>'.$x.'</td>';
								echo '<td>'.$viewarrsalary["year"].'</td>';
								echo '<td>'.$viewarrsalary["month"].'</td>';
								echo '<td>'.$viewarrsalary["netsalary"].'</td>';
								echo '<td>'.$viewarrsalary["epf"].'</td>';
								echo '<td>'.$viewarrsalary["etf"].'</td>';
							echo '</tr>';
							$x++;
						}
						?>
					</table>
				</td>
				</tr>
				<tr>
					<td colspan="2">
						<center>
						<a href="index.php"> <input type='button' name="gobutton" class="btn btn-success" id="gobutton"value='Go Back' class="buttonPro gray"></a>
						</center>
					</td>
				</tr>
			</table>
			</div>
			</div>
		</div>
	</div>
</div>