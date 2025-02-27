<?php
$sql3 = "SELECT * FROM staffwork WHERE enddate='0000-00-00'";
$view = mysqli_query($connection,$sql3)or die("Error in sql3".mysqli_error($connection));
echo '<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-primary">
					<div class="panel-heading">
					   <h4> Transfer Notification</h4>
					</div>
					<div class="panel-body">
						<div class="table-responsive">';


echo '<table  class="table table-striped table-bordered table-hover"  id="dataTables-example">
<thead><tr><th></th><th>Teacher</th><th>Census ID</th><th>School Name</th><th>Work From</th><th>Years</th><th>Action</th></tr></thead><tbody>';	
$x=1;
$ida=base64_encode("add");
$today=date("Y-m-d");
while($viewarr = mysqli_fetch_assoc($view))
{
	$workstart=$viewarr["startdate"];
	$diff = strtotime($today) - strtotime($workstart);
	$diffyears = floor($diff / (365*60*60*24));
	if($diffyears>=5)
	{
		$sqlstaff="SELECT Name FROM school_staff WHERE SID='$viewarr[staffid]'";
		$resultstaff=mysqli_query($connection,$sqlstaff) or die("sql error in sqlstaff");
		$rowstaff=mysqli_fetch_assoc($resultstaff);

		$sqlschool="SELECT censusid,name FROM school WHERE schoolid='$viewarr[schoolid]'";
		$resultschool=mysqli_query($connection,$sqlschool) or die("sql error in sqlschool");
		$rowschool=mysqli_fetch_assoc($resultschool);
		
		echo '<tr><td>'.$x.'</td><td>'.$rowstaff["Name"].'</td><td>'.$rowschool["censusid"].'</td><td>'.$rowschool["name"].'</td>
		<td>'.$viewarr["startdate"].'</td><td>'.$diffyears.'</td>';
		echo '<td>';
		echo '<a href="Transfer/index.php?id='.$ida.'&transtaffid='.base64_encode($viewarr["staffid"]).'"><button class="btn btn-info"><i class="icon-edit"></i>Transfer</button></a>';
		echo '</td></tr>';
		$x++;
	}
}
echo '</tbody></table></div></div></div></div></div>';
?>