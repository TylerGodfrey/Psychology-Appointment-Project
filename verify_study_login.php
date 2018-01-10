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

if (isset($_POST['studyPassword'])) {
	$studyPassword = $_POST['studyPassword'];
}

if (isset($_POST['personID'])) {
	$personID = $_POST['personID'];
}

if (isset($_POST['destination'])) {
	$destination = $_POST['destination'];
}

if (isset($_POST['destination_two'])) {
	$destination_two = $_POST['destination_two'];
}

$verified = false;

$studyConnection = new Connection();
$studyConnection->createConnection();
$studyConnection->sql = "SELECT StudyID, Password FROM `study` WHERE StudyID = $studyID AND Password = '$studyPassword'";
$studyConnectionResult = mysqli_query($studyConnection->conn, $studyConnection->sql);

if ($studyConnectionResult != false) {
	if (mysqli_num_rows($studyConnectionResult) > 0) {
		$verified = true;
	}
}
$studyConnection->closeConnection();

if ($verified == true) {
	$pairingConnection = new Connection();
	$pairingConnection->createConnection();
	$pairingConnection->sql = "INSERT INTO `studyexperimenterpairs` (StudyID, ExperimenterID) VALUES ($studyID, $personID);";
	$pairingConnection->submit();
	$pairingConnection->closeConnection();

	echo "<form id='sendToProctorLogin' action='$destination' method='post'>
		<input type='hidden' name='studyID' value='$studyID'>
		<input type='hidden' name='destination' value='$destination_two'>
		</form>";
	echo "<script type='text/javascript'> document.getElementById('sendToProctorLogin').submit();
		alert('You have been linked to the study. Returning you to login'); 
		</script>";
}
else {
	echo "<form id='goToStudySelection' action='study_selection.php' method='post'></form>";
	echo "<script type='text/javascript'> document.getElementById('goToStudySelection').submit(); 
		alert('Login failed.  Returning you to study select');
		</script>";
}


?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.7/js/tether.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</body>
</html>