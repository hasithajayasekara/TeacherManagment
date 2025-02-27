<script>
function startTime() {
  var today = new Date();
  var h = today.getHours();
  var m = today.getMinutes();
  var s = today.getSeconds();
  m = checkTime(m);
  s = checkTime(s);
  document.getElementById('clock').innerHTML =
  h + ":" + m + ":" + s;
  var t = setTimeout(startTime, 500);
}
function checkTime(i) {
  if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
  return i;
}
</script>
<body onload="startTime()">
            <div class="well well-small">
                <ul class="list-unstyled">
                    <li>Date &nbsp; : <span><?php echo date("Y-m-d"); ?></span></li>
                    <li>Time &nbsp; : <span id="clock"></span></li>
                    <li>Day &nbsp; : <span><?php echo date("l"); ?></span></li>
                </ul>
            </div>
            <div class="well well-small">
                <div class="panel panel-default">
					<div class="panel-heading">
						Education Ministry
					</div>
					<div class="panel-body">
						Dr.Harini Amarasooriya
					</div>
				</div>
            </div>
			<div class="well well-small">
                <div class="panel panel-default">
					<div class="panel-heading">
						PDE Central
					</div>
					<div class="panel-body">
						Mr.Sthiyendra
					</div>
				</div>
            </div>
</body>