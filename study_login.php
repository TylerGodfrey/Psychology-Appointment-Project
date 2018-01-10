<html>
<head>
<title>Example Study Selection</title>

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

if (isset($_POST['studyID'])) {
	$studyID = $_POST['studyID'];
}

if (isset($_POST['firstName'])) {
	$firstName = $_POST['firstName'];
}

if (isset($_POST['lastName'])) {
	$lastName = $_POST['lastName'];
}

if (isset($_POST['destination'])) {
	$destination = $_POST['destination'];
}

if (isset($_POST['destination_two'])) {
	$destination_two = $_POST['destination_two'];
}

if (isset($_POST['password'])) {
	$password = $_POST['password'];
}

$rightPerson = false;

$studyConnection = new Connection();

$studyConnection->createConnection();
$studyConnection->sql = "SELECT StudyName FROM `study` WHERE StudyID = $studyID";
$studyConnectionResult = mysqli_query($studyConnection->conn, $studyConnection->sql);
if ($studyConnectionResult != false) {
	if (mysqli_num_rows($studyConnectionResult) > 0) {
		while ($row = mysqli_fetch_assoc($studyConnectionResult)) {
			$studyName = $row['StudyName'];
		}
	}
}
$studyConnection->closeConnection();

$personConnection = new Connection();

$personConnection->createConnection();
$personConnection->sql = "SELECT PersonID FROM `person info` WHERE PersonFirstName = '$firstName' AND PersonLastName = '$lastName' AND Password = '$password'";
$personConnectionResult = mysqli_query($personConnection->conn, $personConnection->sql);
if ($personConnectionResult != false) {
	if (mysqli_num_rows($personConnectionResult) > 0) {
		$rightPerson = true;
		while ($row = mysqli_fetch_assoc($personConnectionResult)) {
			$personID = $row['PersonID'];
		}
	}
}

if ($rightPerson = true) {
	echo "<p align='center'>We have a profile for you setup, but you don't have access to this study yet.  Please log in below.</p><div style='position:absolute; top:30%; right:0; left:0;'><form align='center' style='vertical-align:center' action='verify_study_login.php' method='post'>
	First Name: $firstName <br>
	Last Name: $lastName <br>
	Study Name: " . $studyName . "
	Study Password: <input type='text' name='studyPassword'>
	<input type='hidden' name='personID' value='$personID'>
	<input type='hidden' name='studyID' value='$studyID'>
	<input type='hidden' name='destination' value='$destination'>
	<input type='hidden' name='destination_two' value='$destination_two'>
	<input type='submit' value='Log Into Study'>
	</form>";
}

else {


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

	echo "<p align='center'>Please fill out this form to create a proctor profile.  If you are not a proctor or already have a profile, please return to the study selection page with the link above.</p><div style='position:absolute; top:30%; right:0; left:0;'>
	<form align='center' style='vertical-align:center' action='create_proctor.php' method='post'>
	First Name: <input type='text' name='firstName'> <br>
	Last Name: <input type='text' name='lastName'> <br>
	Password: <input type='text' name='password'> <br>
	Preferred Contact Method: <select name='preferredContactMethod'> <option value='phone'>Phone</option> <option value='E-mail'>E-mail</option> </select> <br>
	Phone Number: <input type='text' name='phone'> <br>
	Cellphone Carrier: <select name='carrierID'> <option value=''></option>";
	foreach ($carrierArray as $carrier) {
		echo "<option value='" . $carrier[0] . "'>" . $carrier[1] . "</option>";
	}
	echo "</select> <br>
	Email Address: <input type='text' name='email'> <br>
	<input type='hidden' name='studyID' value='$studyID'>
	<input type='hidden' name='destination' value='$destination'>
	<input type='hidden' name='destination_two' value='$destination_two'>
	<input type='submit' value='Create Profile'>
	</form>
	";
}








?>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.7/js/tether.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</body>
</html>