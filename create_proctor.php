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

if (isset($_POST['firstName'])) {
	$firstName = $_POST['firstName'];
}

if (isset($_POST['lastName'])) {
	$lastName = $_POST['lastName'];
}

if (isset($_POST['preferredContactMethod'])) {
	$preferredContactMethod = $_POST['preferredContactMethod'];
}

if (isset($_POST['phone'])) {
	$phone = $_POST['phone'];
}

if (isset($_POST['carrierID'])) {
	$carrierID = $_POST['carrierID'];
}

if (isset($_POST['email'])) {
	$email = $_POST['email'];
}

if (isset($_POST['password'])) {
	$password = $_POST['password'];
}

if (isset($_POST['studyID'])) {
	$studyID = $_POST['studyID'];
}

if (isset($_POST['destination'])) {
	$destination = $_POST['destination'];
}

if (isset($_POST['destination_two'])) {
	$destination_two = $_POST['destination_two'];
}

$proctorConnection = new Connection();
$proctorConnection->createConnection();
$proctorConnection->sql = "INSERT INTO `person info` (PersonPhoneNumber, PersonCarrier, PersonEmail, PrefContactMethod, PersonFirstName, PersonLastName, Password) VALUES ('$phone', '$carrierID', '$email', '$preferredContactMethod', '$firstName', '$lastName', '$password');";
$proctorConnection->submit();
$proctorConnection->closeConnection();

echo "<form id='sendToProctorLogin' action='$destination' method='post'> </form>";

echo "<script type='text/javascript'>
	document.getElementById('sendToProctorLogin').submit();
	</script>";

?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.7/js/tether.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</body>
</html>