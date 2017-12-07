<html>
 <head>
  <title>PHP Test</title>
 </head>
<body>

<?php
	echo "Year: " . $_POST["year"] .
	"<br>Month: " . $_POST["month"] .
	"<br>Day: " . $_POST["day"];
	if (empty($_POST["startTime"])) echo "<br>No start time was given!"; 
	else echo "<br>Start Time: " . $_POST["startTime"];
	if (empty($_POST["endTime"])) echo "<br>No end time was given!";
	else echo "<br>End Time: " . $_POST['endTime'];
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
</body>
</html>