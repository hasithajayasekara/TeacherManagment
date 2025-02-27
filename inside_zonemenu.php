<?php
$sql3 = "SELECT * FROM staffwork WHERE enddate='0000-00-00'";
$view = mysqli_query($connection,$sql3)or die("Error in sql3".mysqli_error($connection));
$n=0;
$today=date("Y-m-d");
while($viewarr = mysqli_fetch_assoc($view))
{
	$workstart=$viewarr["startdate"];
	$diff = strtotime($today) - strtotime($workstart);
	$diffyears = floor($diff / (365*60*60*24));
	if($diffyears>=5)
	{
		$n++;
	}
}
?>
<li><a href="../index.php?id=<?php echo base64_encode("notification"); ?>"><i class="icon-map-marker"></i> Notification (<?php echo $n; ?>)</a></li>
<li><a href="../index.php?id=<?php echo base64_encode("changepassword"); ?>"><i class="icon-map-marker"></i> Change Password</a></li>
<li><a href="../Zone"><i class="icon-map-marker"></i> Zone </a></li>
<li><a href="../School"><i class="icon-table"></i> School </a></li>
<li><a href="../Staff"><i class="icon-map-marker"></i> School Staff </a></li>
<li><a href="../salary"><i class="icon-map-marker"></i> Salary </a></li>
<li><a href="../Seminar"><i class="icon-map-marker"></i> Seminar </a></li>
<li><a href="../Transfer"><i class="icon-map-marker"></i> Transfer </a></li>
<li><a href="../Office Staff"><i class="icon-film"></i> Office Staff </a></li>
<li><a href="../logout.php"><i class="icon-signin"></i> Logout </a></li>