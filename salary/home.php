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
<title>Salary</title>
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
	$sql3 = "SELECT DISTINCT year,month FROM salary";
	$view = mysqli_query($connection,$sql3)or die("Error in sql3".mysqli_error($connection));
	echo '<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           <h4> Salary</h4>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">';
	$ida=base64_encode("add");
	$idv=base64_encode("view");
	echo '<a href="index.php?id='.$ida.'"><input type="button" class="btn btn-primary" value="Add New Salary"></a><br><br>';
	
	echo '<table  class="table table-striped table-bordered table-hover"  id="dataTables-example">
	<thead><tr><th></th><th>year</th><th>Month</th><th></th></tr></thead><tbody>';	
	$x=1;
	while($viewarr = mysqli_fetch_assoc($view))
	{
		echo '<tr><td>'.$x.'</td><td>'.$viewarr["year"].'</td><td>'.$viewarr["month"].'</td><td>';     
		
		echo '<a href="index.php?id='.$idv.'&year='.base64_encode($viewarr["year"]).'&month='.base64_encode($viewarr["month"]).'"><i class="icon-edit"></i></a>';
		
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