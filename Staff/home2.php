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
<script type="text/javascript">
function deletedata() // make alert for delete branch details 
{
	var x=confirm("Are You Sure delete this record");
	if(x)
	{
		return true;
	}
	else
	{
		return false;
	}
}
</script>
</head>
<body>
<?php	
	$sql3 = "SELECT * FROM school_staff";
	$view = mysqli_query($connection,$sql3)or die("Error in sql3".mysqli_error($connection));
	echo '<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           <h4> School Staff</h4>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">';
	$ida=base64_encode("add");
	$idv=base64_encode("view");
	$ide=base64_encode("edit");
	$idd=base64_encode("delete");
	echo '<a href="index.php?id='.$ida.'"><input type="button" class="btn btn-primary" value="Add New School Staff"></a><br><br>';
	
	echo '<table  class="table table-striped table-bordered table-hover"  id="dataTables-example">
	<thead><tr><th></th><th>Name</th><th>NIC Number</th><th>Address</th><th>School</th><th>Post</th><th></th></tr></thead><tbody>';	
	$x=1;
	while($viewarr = mysqli_fetch_assoc($view))
	{
		$sqlschool="SELECT name FROM school WHERE schoolid='$viewarr[First_appoinment_school]'";
		$resultsch=mysqli_query($connection,$sqlschool) or die("sql error in sqlschool ".mysqli_error($connection));
		$rowsch=mysqli_fetch_assoc($resultsch);
		echo '<tr><td>'.$x.'</td><td>'.$viewarr["Name"].'</td><td>'.$viewarr["NIC_number"].'</td><td>'.$viewarr["Address"].'</td>
		<td>'.$rowsch["name"].'</td><td>'.$viewarr["Post"].'</td><td>';     
		
		echo '<a href="index.php?id='.$idv.'&staffid='.base64_encode($viewarr["SID"]).'"><i class="icon-eye-open"></i></a>
		<a href="index.php?id='.$ide.'&staffid='.base64_encode($viewarr["SID"]).'"><i class="icon-edit"></i></a>  ';
		if($usertype=="zone")
		{
			echo '<a onClick="return deletedata()" href="index.php?id='.$idd.'&staffid='.base64_encode($viewarr["SID"]).'"><i class="icon-remove"></i></a>';
		}
		echo '</td></tr>';
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