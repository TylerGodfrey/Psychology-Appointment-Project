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

if (isset($_POST['destination'])) {
	$destination = $_POST['destination'];
}

if (isset($_POST['firstName'])) {
	$firstName = $_POST['firstName'];
}

if (isset($_POST['lastName'])) {
	$lastName = $_POST['lastName'];
}

if (isset($_POST['password'])) {
	$password = $_POST['password'];
}

$verified = false;

$checkPasswordConnection = new Connection();
$checkPasswordConnection->createConnection();
$checkPasswordConnection->sql = "SELECT ExperimenterID, PersonFirstName, PersonLastName, Password FROM `person info` AS PI INNER JOIN `studyexperimenterpairs` AS SEP ON SEP.ExperimenterID = PI.PersonID WHERE SEP.StudyID = $studyID AND PI.PersonFirstName='$firstName' AND PI.PersonLastName='$lastName'
	AND PI.Password = '$password'";
$checkPasswordResult = mysqli_query($checkPasswordConnection->conn, $checkPasswordConnection->sql);
if ($checkPasswordResult != false) {
	if (mysqli_num_rows($checkPasswordResult) > 0) {
		while ($row = mysqli_fetch_assoc($checkPasswordResult)) { // should only run once
			$verified = true;
			//$correctPassword = $row['Password'];
			$proctorID = $row['ExperimenterID'];
		}
	}
}

$checkPasswordConnection->closeConnection();

if ($verified == true) {
	echo "<form id='confirmationForm' action='$destination' method='post'>
		<input type='hidden' name='studyID' value='$studyID'>
		<input type='hidden' name='proctorID' value='$proctorID'>
		</form>
		";
	echo "<script type='text/javascript'> document.getElementById('confirmationForm').submit(); 
		</script>";
}
else {
/*	echo "<script type='text/javascript'>
		function sleep(milliseconds) {
		  var start = new Date().getTime();
		  for (var i = 0; i < 1e7; i++) {
		    if ((new Date().getTime() - start) > milliseconds){
		      break;
		    }
		  }
		}

		sleep(1000);
		</script>";*/


	echo "<form id='sendToStudyLogin' action='study_login.php' method='post'>
			<input type='hidden' name='studyID' value='$studyID'>
			<input type='hidden' name='firstName' value='$firstName'>
			<input type='hidden' name='lastName' value='$lastName'>
			<input type='hidden' name='destination' value='proctor_login.php'>
			<input type='hidden' name='destination_two' value='$destination'>
			<input type='hidden' name='password' value='$password'>
			</form>";
	echo "<script type='text/javascript'>
		document.getElementById('sendToStudyLogin').submit();
		alert('Couldn\'t find you for this study.  Sending you to study login.');
		</script>";
	/*echo "<form id='confirmationForm' action='study_selection.php' method='post'> </form>";
	echo "<script type='text/javascript'> 
		alert('It seems you\'ve put in an incorrect name or password for that study. Returning you to the study select page.');
		document.getElementById('confirmationForm').submit(); 
	</script>";*/

}

?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.7/js/tether.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</body>
</html>