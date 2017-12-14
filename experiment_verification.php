<html>
<head>
<title>Appointment Creation</title>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.4/moment.min.js"></script> <!-- allows javascript to parse times -->
    <style> .input { width:75px; }
    		.inputCell { text-align:center; vertical-align:middle; }
    		td, th { padding: 5px; }
    		th { text-align:center; }
    		tr { height: 25px; }
</style>
</head>
<body>
<a href="example_study_creation.php">Create New Study</a>
<br><a href="refactoring_calendar.php">Proctor Availability Sign-up</a>
<br><a href="experiment_verification.php">Experiment Verification</a>
<?php

include ("general_connection.php");

echo "<p align='center'>WARNING: Only do one at a time; input into the other rows will be lost when you click Submit</p>";

$studyID = 61;
$date = date_create();
$timezone = new DateTimeZone('America/Chicago');
$time = $date->setTimezone($timezone);
$time = date_format($time, 'H:i:s');
echo $time;
$date = date_format($date, 'Y-m-d');
$printTimeFormat = "h:i A";
$internalTimeFormat = "H:i";
$columnNames = array('Study Name', 'Proctor Name', 'Subject Name', 'Date', 'Start Time', 'End Time', 'Show / No Show', 'Actual Start Time', 'Actual End Time', '');
$lineNumber = 0;

echo "<table border='2' width='100%'><tr>";

foreach ($columnNames as $column) {
	echo "<th>" . $column . "</th>";
}

echo "</tr>";

$appointments = new Connection();
$appointments->sql = "SELECT Study.StudyName AS 'Study Name', CONCAT(Proctor.PersonFirstName, ' ', Proctor.PersonLastName) AS 'Proctor Name', Subject.PersonID AS 'Subject ID', CONCAT(Subject.PersonFirstName, ' ', Subject.PersonLastName) AS 'Subject Name', App.Date AS 'Date', App.StartTime AS 'Expected Start Time', App.EndTime AS 'Expected End Time' FROM `cs 375`.`appointments` AS App LEFT OUTER JOIN `cs 375`.`study` AS Study ON Study.StudyID = App.StudyID LEFT OUTER JOIN `cs 375`.`person info` AS Subject ON Subject.PersonID = App.SubjectID LEFT OUTER JOIN `cs 375`.`person info` AS Proctor ON Proctor.PersonID = App.ExperimenterID WHERE App.Date <= '$date' AND App.EndTime <= '$time' AND App.StudyID = $studyID AND App.ShowOrNoShow IS NULL";
$appointments->createConnection();
$appointmentsResult = mysqli_query($appointments->conn, $appointments->sql);

if ($appointmentsResult != false) {
	if (mysqli_num_rows($appointmentsResult) > 0) {
		while ($row = mysqli_fetch_assoc($appointmentsResult)) {
			$lineNumber++;
			$subjectID = $row['Subject ID'];
			$results = array($row['Study Name'], $row['Proctor Name'], $row['Subject Name'], date_format(date_create($row['Date']), 'M d, Y'), date_format(date_create($row['Expected Start Time']), $printTimeFormat) , date_format(date_create($row['Expected End Time']), $printTimeFormat));
			$inputs = array("<input id='show" . $lineNumber . "' type='checkbox'></input>", "<input id='startTime" . $lineNumber . "' type='text' class='input'></input>", "<input id='endTime" . $lineNumber . "' type='text' class='input'></input>", "<button type='button' onclick='submit(" . $lineNumber . "," . $studyID . "," . $subjectID . ")'>Submit</button>");
			echo "<tr>";
			foreach ($results as $result) {
				echo "<td>" . $result . "</td>";
			}
			foreach ($inputs as $input) {
				echo "<td class='inputCell'>" . $input . "</td>";
			}
			echo "</tr>";
		}
	}
}

$appointments->closeConnection();

echo "</table>";





?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.7/js/tether.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/experiment_verification.js"></script>
</body>
</html>