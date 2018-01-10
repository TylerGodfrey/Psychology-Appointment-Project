<html>
 <head>
  <title>PHP Test</title>
 </head>
<body>

<?php
	include('links.php');
	include ('general_connection.php');

	if (isset($_POST['year'])) {
		$year = $_POST['year'];
	}

	if (isset($_POST['month'])) {
		$month = $_POST['month'];
	}

	if (isset($_POST['day'])) {
		$day = $_POST['day'];
	}

	if (isset($_POST['startTime'])) {
		$startTime = $_POST['startTime'];
	}

	if (isset($_POST['endTime'])) {
		$endTime = $_POST['endTime'];
	}

	if (isset($_POST['studyID'])) {
		$studyID = $_POST['studyID'];
	}

	if (isset($_POST['proctorID'])) {
		$proctorID = $_POST['proctorID'];
	}

	$date = $year . '-' . date_format(date_create($month), "m") . '-' . $day;

	/*echo "Year: " . $year .
	"<br>Month: " . $month .
	"<br>Day: " . $day;
	if (empty($startTime)) echo "<br>No start time was given!"; 
	else echo "<br>Start Time: " . $startTime;
	if (empty($endTime)) echo "<br>No end time was given!";
	else echo "<br>End Time: " . $endTime;*/



	$availabilityConnection = new Connection();
	$availabilityConnection->createConnection();
	$availabilityConnection->sql = "SELECT StudyID, ExperimenterID FROM `studyexperimenterpairs` WHERE StudyID = $studyID AND ExperimenterID = $proctorID";
	$availabilityResult = mysqli_query($availabilityConnection->conn, $availabilityConnection->sql);
	if ($availabilityResult == false) {
		$availabilityConnection->sql = "INSERT INTO `studyexperimenterpairs` (StudyID, ExperimenterID) VALUES ($studyID, $proctorID)";
		$availabilityConnection->submit();
	}
	$availabilityConnection->sql = "INSERT INTO `experimenter availability` (StudyID, ExperimenterID, Date, StartTime, EndTime) VALUES ($studyID, $proctorID, '$date', '$startTime', '$endTime')";
	$availabilityConnection->submit();
	$availabilityConnection->closeConnection();

	echo "<form id='sendBack' action='refactoring_calendar.php' method='post'>
		<input type='hidden' name='studyID' value='" . $studyID . "'>
		<input type='hidden' name='proctorID' value='" . $proctorID . "'></form>
		<script type='text/javascript'>
		document.getElementById('sendBack').submit();
		alert('You have submitted your availability. Returning to availability page for additional availability submissions.');
		</script>"; 
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