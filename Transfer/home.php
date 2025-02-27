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
<title>Transfer</title>
</head>
<body>
<?php	
	$sql3 = "SELECT * FROM transfer";
	$view = mysqli_query($connection,$sql3)or die("Error in sql3".mysqli_error($connection));
	echo '<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           <h4> Transfer</h4>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">';
	$ida=base64_encode("add");
	echo '<a href="index.php?id='.$ida.'"><input type="button" class="btn btn-primary" value="Add New Transfer"></a><br><br>';
	
	echo '<table  class="table table-striped table-bordered table-hover"  id="dataTables-example">
	<thead><tr><th></th><th>Staff name</th><th>School</th><th>Transfer Date</th></tr></thead><tbody>';	
	$x=1;
	while($viewarr = mysqli_fetch_assoc($view))
	{
		$sqlstf="SELECT Name FROM school_staff WHERE SID='$viewarr[staffid]'";
		$resultstf=mysqli_query($connection,$sqlstf) or die("sql error in sqlschool ".mysqli_error($connection));
		$rowstf=mysqli_fetch_assoc($resultstf);

		$sqlschool="SELECT name FROM school WHERE schoolid='$viewarr[schoolid]'";
		$resultsch=mysqli_query($connection,$sqlschool) or die("sql error in sqlschool ".mysqli_error($connection));
		$rowsch=mysqli_fetch_assoc($resultsch); 

		echo '<tr><td>'.$x.'</td><td>'.$rowstf["Name"].'</td><td>'.$rowsch["name"].'</td><td>'.$viewarr["transferdate"].'</td>';   
		
		echo '</tr>';
		$x++;
	}
	echo '</tbody></table></div></div></div></div></div>';

//usertype check end
}
else
{
	header("location:../index.php");
}
?>
</body>
</html>