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

include ('links.php');
include ('general_connection.php');

if(isset($_POST['studyID'])) {
	$studyID = $_POST['studyID'];
}

if(isset($_POST['date'])) {
	$date = $_POST['date'];
}

if(isset($_POST['startTime'])) {
	$startTime = $_POST['startTime'];
}

if(isset($_POST['endTime'])) {
	$endTime = $_POST['endTime'];
}

if(isset($_POST['preferredContactMethod'])) {
	$preferredContactMethod = $_POST['preferredContactMethod'];
}

if(isset($_POST['phone'])) {
	$phoneNumber = $_POST['phone'];
}

if(isset($_POST['email'])) {
	$email = $_POST['email'];
}

if(isset($_POST['firstName'])) {
	$firstName = $_POST['firstName'];
}

if(isset($_POST['lastName'])) {
	$lastName = $_POST['lastName'];
}

if(isset($_POST['roomID'])) {
	$roomID = $_POST['roomID'];
}

if(isset($_POST['carrierID'])) {
	$carrierID = $_POST['carrierID'];
}

if(isset($_POST['proctorID'])) {
	$proctorID = $_POST['proctorID'];
}

if(isset($_POST['classID'])) {
	$classID = $_POST['classID'];
}

$appointmentConnection = new Connection();
$appointmentConnection->createConnection();
$appointmentConnection->sql = "INSERT INTO `cs 375`.`person info` (PersonPhoneNumber, PersonCarrier, PersonEmail, PrefContactMethod, PersonFirstName, PersonLastName) VALUES ('$phoneNumber', $carrierID, '$email', '$preferredContactMethod', '$firstName', '$lastName')";
$appointmentConnection->submit();
$appointmentConnection->getInsertedId();
$subjectID = $appointmentConnection->inserted_id;
$appointmentConnection->sql = "INSERT INTO `cs 375`.`appointments` (RoomID, StudyID, SubjectID, StartTime, EndTime, ExperimenterID, Date, ClassRequested) VALUES ($roomID, $studyID, $subjectID, '$startTime', '$endTime', $proctorID, '$date', $classID)";
$appointmentConnection->submit();
$appointmentConnection->closeConnection();

echo "<script>alert('Your appointment has been made!  You will receive a notification by your preferred method.')</script>";

echo "<form id='sendToStudySelection' action='study_selection.php' method='post'></form>";

echo "<script type='text/javascript'>
	document.getElementById('sendToStudySelection').submit();
	</script>";
/*
header("Location: study_selection.php");
die();*/
?>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.7/js/tether.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>