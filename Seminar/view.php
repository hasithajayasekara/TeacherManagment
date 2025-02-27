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
if($usertype=="zone" || $usertype=="clerk" || $usertype=="teach")
{
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Staff Salary</title>
</head>
<body>
	<div class="row">
       <div class="col-lg-12">
         <div class="panel panel-default">
           <div class="panel-heading">
               Seminar View
           </div>
            <div class="panel-body">
              <div class="table-responsive">
				<table class="table table-striped table-bordered table-hover" id="dataTables-example">

						<thead><tr><th></th><th>Staff</th><th>Participant</th>
						<?php
						if($usertype=="zone")
						{
						?>
						<th></th>
						<?php
						}
						?>
						</tr></thead><tbody>	
					<?php
						$semid=base64_decode($_GET["semid"]);
						$sql3 = "SELECT * FROM seminarparticipant WHERE seminarid='$semid'";
						$view = mysqli_query($connection,$sql3)or die("Error in sql3".mysqli_error($connection));
						$x=1;
						while($viewarr = mysqli_fetch_assoc($view))
						{
							$sqlstaff = "SELECT name FROM school_staff WHERE SID='$viewarr[staffid]'";
							$viewstaff = mysqli_query($connection,$sqlstaff)or die("Error in sqlstaff".mysqli_error($connection));
							$viewarrstaff = mysqli_fetch_assoc($viewstaff);
							echo'<tr><td>'.$x.'</td><td>'.$viewarrstaff["name"].'</td>
							<td>Yes</td>';
							if($usertype=="zone")
							{
							echo '<td>';
							echo '<a onClick="return deletedata()" href="index.php?id='.base64_encode("deletes").'&semid='.base64_encode($viewarr["seminarid"]).'&staffid='.base64_encode($viewarr["staffid"]).'"><i class="icon-remove"></i></a>';
							echo '</td>';
							}
							echo '</tr>';
							$x++;
						}
					?>
					</tbody>
			</table>
			<table>

				<tr>
					<td>
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