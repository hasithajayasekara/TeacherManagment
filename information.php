<?php
$sql3 = "SELECT * FROM school";
$view = mysqli_query($connection,$sql3)or die("Error in sql3".mysqli_error($connection));
echo '<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-primary">
					<div class="panel-heading">
					   <h4> School Teachers</h4>
					</div>
					<div class="panel-body">
						<div class="table-responsive">';


echo '<table  class="table table-striped table-bordered table-hover"  id="dataTables-example">
<thead><tr><th></th><th>Census ID</th><th>School Name</th><th>Male Teachers</th><th>Female Teachers</th><th>Total</th></tr></thead><tbody>';	
$x=1;
$totalmale=0;
$totalfemale=0;
$total=0;
while($viewarr = mysqli_fetch_assoc($view))
{
	$sqlstafffemale="SELECT ss.SID FROM school_staff as ss, staffwork as sw WHERE ss.Gender='Female' AND ss.SID=sw.staffid AND sw.enddate='0000-00-00' AND sw.schoolid='$viewarr[schoolid]'";
	$resultstafffemale=mysqli_query($connection,$sqlstafffemale) or die("sql error in sqlstafffemale");
	$numsstafffemale=mysqli_num_rows($resultstafffemale);
	$totalfemale=$totalfemale+$numsstafffemale;

	$sqlstaffmale="SELECT ss.SID FROM school_staff as ss, staffwork as sw WHERE ss.Gender='Male' AND ss.SID=sw.staffid AND sw.enddate='0000-00-00' AND sw.schoolid='$viewarr[schoolid]'";
	$resultstaffmale=mysqli_query($connection,$sqlstaffmale) or die("sql error in sqlstaffmale");
	$numsstaffmale=mysqli_num_rows($resultstaffmale);
	$totalmale=$totalmale+$numsstaffmale;

	$totalstaff=$numsstafffemale+$numsstaffmale;
	$total=$total+$totalstaff;
	echo '<tr><td>'.$x.'</td><td>'.$viewarr["censusid"].'</td><td>'.$viewarr["name"].'</td>
	<td>'.$numsstaffmale.'</td><td>'.$numsstafffemale.'</td><td>'.$totalstaff.'</td></tr>';
	$x++;
}
echo '<tr><td>'.$x.'</td><td>Total</td><td></td>
	<td>'.$totalmale.'</td><td>'.$totalfemale.'</td><td>'.$total.'</td></tr>';
echo '</tbody></table></div></div></div></div></div>';

$sql3 = "SELECT DISTINCT Subject_teach FROM school_staff";
$view = mysqli_query($connection,$sql3)or die("Error in sql3".mysqli_error($connection));
echo '<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-primary">
					<div class="panel-heading">
					   <h4> Subject Teachers</h4>
					</div>
					<div class="panel-body">
						<div class="table-responsive">';


echo '<table  class="table table-striped table-bordered table-hover"  id="dataTables-example1">
<thead><tr><th></th><th>Subject Name</th><th>Teachers</th></tr></thead><tbody>';	
$x=1;;
$total=0;
while($viewarr = mysqli_fetch_assoc($view))
{
	$sqlstaff="SELECT SID FROM school_staff WHERE Subject_teach='$viewarr[Subject_teach]'";
	$resultstaff=mysqli_query($connection,$sqlstaff) or die("sql error in sqlstaff");
	$numsstaff=mysqli_num_rows($resultstaff);
	
	$total=$total+$numsstaff;
	echo '<tr><td>'.$x.'</td><td>'.$viewarr["Subject_teach"].'</td><td>'.$numsstaff.'</td></tr>';
	$x++;
}
echo '<tr><td>'.$x.'</td><td>Total</td><td>'.$total.'</td></tr>';
echo '</tbody></table></div></div></div></div></div>';

$sql3 = "SELECT * FROM seminar ORDER BY date DESC";
$view = mysqli_query($connection,$sql3)or die("Error in sql3".mysqli_error($connection));
echo '<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-primary">
					<div class="panel-heading">
					   <h4> Seminar Details</h4>
					</div>
					<div class="panel-body">
						<div class="table-responsive">';


echo '<table  class="table table-striped table-bordered table-hover"  id="dataTables-example2">
<thead><tr><th></th><th>Date</th><th>Details</th></tr></thead><tbody>';	
$x=1;;
while($viewarr = mysqli_fetch_assoc($view))
{
	echo '<tr><td>'.$x.'</td><td>'.$viewarr["date"].'</td><td>'.$viewarr["details"].'</td></tr>';
	$x++;
}
echo '</tbody></table></div></div></div></div></div>';

?>