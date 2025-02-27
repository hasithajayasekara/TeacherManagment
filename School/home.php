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
<title>School</title>
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
	$sql3 = "SELECT * FROM school";
	$view = mysqli_query($connection,$sql3)or die("Error in sql3".mysqli_error($connection));
	echo '<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           <h4> Schools</h4>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">';
	$ida=base64_encode("add");
	$ide=base64_encode("edit");
	$idd=base64_encode("delete");
	echo '<a href="index.php?id='.$ida.'"><input type="button" class="btn btn-primary" value="Add New School"></a><br><br>';
	
	echo '<table  class="table table-striped table-bordered table-hover"  id="dataTables-example">
	<thead><tr><th></th><th>Census ID</th><th>School Name</th><th>Address</th><th>Telephone Number</th><th>Zone</th><th></th></tr></thead><tbody>';	
	$x=1;
	while($viewarr = mysqli_fetch_assoc($view))
	{
		$sqlzone="SELECT zonename FROM zone WHERE zoneid='$viewarr[zoneid]'";
		$resultzone=mysqli_query($connection,$sqlzone) or die("sql error in sqlzone ".mysqli_error($connection));
		$rowzone=mysqli_fetch_assoc($resultzone);
		echo '<tr><td>'.$x.'</td><td>'.$viewarr["censusid"].'</td><td>'.$viewarr["name"].'</td><td>'.$viewarr["address"].'</td>
		<td>'.$viewarr["tpnum"].'</td><td>'.$rowzone["zonename"].'</td><td>';     
		
		echo '<a href="index.php?id='.$ide.'&schid='.base64_encode($viewarr["schoolid"]).'"><i class="icon-edit"></i></a>  ';
		echo '<a onClick="return deletedata()" href="index.php?id='.$idd.'&schid='.base64_encode($viewarr["schoolid"]).'"><i class="icon-remove"></i></a>';
		
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