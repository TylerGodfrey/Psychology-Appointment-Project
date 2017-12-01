<html>
 <head>
  <title>PHP Test</title>
 </head>
<body>

Year: <?php echo $_POST["year"]; ?>
<br>Month: <?php echo $_POST["month"]; ?>
<br>Day: <?php echo $_POST["day"]; ?>
<br>Start Time: <?php echo $_POST["startTime"]; ?>
<!--<?php
/*function processInfo()
{
	$studyID = 44;
	$procID = 4;
	$date = $cYear . "-" . $cMonth . "-" . $day;
	$startTime = $_POST["startTime"];
	$endTime = $_POST["endTime"];

	if (!($startTime == "") && !($endTime == ""))
	{
		if ($startTime >= $endTime)
			alert("Start Time is greater than or equal to End Time");
	}

	else alert("One or both time boxes are empty!");
}

processInfo();*/
?> -->
</body>
</html>