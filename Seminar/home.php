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
	$sql3 = "SELECT * FROM seminar ORDER BY date DESC";
	$view = mysqli_query($connection,$sql3)or die("Error in sql3".mysqli_error($connection));
	echo '<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           <h4> Seminar Details</h4>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">';
	$ida=base64_encode("add");
	$idv=base64_encode("view");
	$ide=base64_encode("edit");
	$idd=base64_encode("delete");
	if($usertype=="zone" || $usertype=="clerk")
	{
	echo '<a href="index.php?id='.$ida.'"><input type="button" class="btn btn-primary" value="Add New Seminar"></a><br><br>';
	}
	echo '<table  class="table table-striped table-bordered table-hover"  id="dataTables-example">
	<thead><tr><th></th><th>Date</th><th>Details</th><th></th></tr></thead><tbody>';	
	$x=1;
	while($viewarr = mysqli_fetch_assoc($view))
	{
		echo '<tr><td>'.$x.'</td><td>'.$viewarr["date"].'</td><td>'.$viewarr["details"].'</td><td>';
		echo '<a href="index.php?id='.$idv.'&semid='.base64_encode($viewarr["seminarid"]).'"><i class="fa fa-eye"></i></a> ';
		if($usertype=="zone" || $usertype=="clerk")
		{
			if($viewarr["date"]>=date("Y-m-d"))
			{
				echo '<a href="index.php?id='.$ide.'&semid='.base64_encode($viewarr["seminarid"]).'"><i class="icon-edit"></i></a>  ';
				if($usertype=="zone")
				{
					echo '<a onClick="return deletedata()" href="index.php?id='.$idd.'&semid='.base64_encode($viewarr["seminarid"]).'"><i class="icon-remove"></i></a>';
				}
			}
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