<html>
<head>
<title>Appointment Creation</title>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
</head>
<body>

<?php

include ('general_connection.php');

$studyID = $_POST['studyID'];
$dateGet = $_POST['date'];
$timeSlotInfo = $_POST['timeSlotInfo'];
// $roomID = $_POST['RoomID'];
// $proctorID = $_POST['ProctorID'];

$timeSlotInfoArray = preg_split('/\|/', $timeSlotInfo, -1, PREG_SPLIT_NO_EMPTY);

// chooses a proctor at random from those available for that study at that time; the same is done for the rooms down below
$proctorArray = preg_split('/,/', $timeSlotInfoArray[1], -1, PREG_SPLIT_NO_EMPTY);
$proctorIDs = array_unique($proctorArray); // eliminates duplicates
$proctorSelector = mt_rand(0, count($proctorIDs) - 1); // chooses a random number to choose which of the proctors is assigned to the appointment
$selectedProctor = $proctorIDs[$proctorSelector]; // gets the appropriate proctor's ID and assigns the value to a variable for later use


$roomArray = preg_split('/,/', $timeSlotInfoArray[2], -1, PREG_SPLIT_NO_EMPTY);
$roomIDs = array_unique($roomArray);
foreach($roomIDs as $room) {
	echo "Room number " . $room . " is available.<br>";
}
$roomSelector = mt_rand(0, count($roomIDs) - 1);
echo "Array location " . $roomSelector . " selected.";
$selectedRoom = $roomIDs[$roomSelector];


$timeSlot = preg_split('/-/', $timeSlotInfoArray[0], -1, PREG_SPLIT_NO_EMPTY);

$date = date_create($dateGet);
$printDate = date_format($date, 'D M d Y');
$submitDate = date_format($date, 'Y-m-d');

$studyConnection = new Connection();

$studyConnection->sql = "SELECT * FROM `study` WHERE StudyID = $studyID;";
$studyConnection->createConnection();

$result = mysqli_query($studyConnection->conn, $studyConnection->sql);

if (mysqli_num_rows($result) > 0) {
	$studyInfo = mysqli_fetch_assoc($result);

	$getClasses = new Connection();

	$getClasses->sql = "SELECT * FROM `class study pairings` AS CSP
						INNER JOIN `classes` AS Classes ON CSP.ClassID = Classes.ClassID
						WHERE StudyID = $studyID";

	$getClasses->createConnection();

	$result = mysqli_query($getClasses->conn, $getClasses->sql);

	$class_select = "<select name='classID'> <option value=''></option>";

	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$class_select = $class_select . "<option value='" . $row['ClassID'] . "'>" . $row['ClassName'] . "</option>";
		}
	} 

	$getClasses->closeConnection();

	$class_select = $class_select . "</select>";
}

$carrierArray = array();

$carrierConnection = new Connection();

$carrierConnection->createConnection();
$carrierConnection->sql = "SELECT * FROM `cellphone carriers`";

$carrierResult = mysqli_query($carrierConnection->conn, $carrierConnection->sql);

if (mysqli_num_rows($carrierResult) > 0) {
	while ($row = mysqli_fetch_assoc($carrierResult)) {
		array_push($carrierArray, array($row['CarrierID'], $row['CarrierName']));
	}
}
echo "<form id='submit-form' align='center' action='appointment_creation_submit.php' method='POST'>
	Study Name: " . $studyInfo['StudyName'] . "<br>
	<input type='hidden' name='studyID' value='" . $studyID . "'>
	Description: " . $studyInfo['Description'] . "<br>
	Expected Points Earned: " . $studyInfo['ExpectedPointValue'] . "<br>
	Expected Duration: " . $studyInfo['ExpectedTimeInMinutes'] . " minutes <br>
	Date Selected: " . $printDate . "<br>
	<input type='hidden' name='date' value='" . $submitDate . "'>
	Time Slot Selected: " . $timeSlot[0] . "-" . $timeSlot[1] . "<br>
	<input type='hidden' name='startTime' value='" . $timeSlot[0] . "'>
	<input type='hidden' name='endTime' value='" . $timeSlot[1] . "'> <br>
	First Name: <input type='text' name='firstName'> <br>
	Last Name: <input type='text' name='lastName'> <br>
	Class for Credit: " . $class_select . "<br>
	Preferred Contact Method: <select name='preferredContactMethod'> <option value='phone'>Phone</option> <option value='E-mail'>E-mail</option> </select> <br>
	Phone Number: <input type='text' name='phone'> <br>
	Cellphone Carrier: <select name='carrierID'> <option value=''></option>";
	foreach ($carrierArray as $carrier) {
		echo "<option value='" . $carrier[0] . "'>" . $carrier[1] . "</option>";
	}
	echo "</select> <br>
	Email Address: <input type='text' name='email'> <br>
	<input type='hidden' name='roomID' value='" . $selectedRoom . "'>
	<input type='hidden' name='proctorID' value='". $selectedProctor . "'>
	<input type='submit'></input>
	 ";

$studyConnection->closeConnection();

?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.7/js/tether.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>