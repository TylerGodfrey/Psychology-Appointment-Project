<html>
 <head>
  <title>PHP Test</title>
 </head>
<body>

<?php
	$year = $_POST['year'];
	$month = $_POST['month'];
	$day = $_POST['day'];
	$startTime = $_POST["startTime" . $day];
	$_endTime = $_POST['endTime'];

	echo "Year: " . $year .
	"<br>Month: " . $month .
	"<br>Day: " . $day;
	if (empty($startTime)) echo "<br>No start time was given!"; 
	else echo "<br>Start Time: " . $endTime;
	if (empty($endTime)) echo "<br>No end time was given!";
	else echo "<br>End Time: " . $endTime;
?>
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
<br><a href="refactoring_calendar.php">Go Back</a>
<br><a href="experiment_verification.php">Verify Appointments</a>
</body>
</html>