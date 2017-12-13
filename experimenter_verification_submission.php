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

$studyID = $_GET['StudyID'];
$subjectID = $_GET['SubjectID'];
$startTime = $_GET['StartTime'];
$endTime = $_GET['EndTime'];
$showStatus = $_GET['ShowStatus'];

$verificationConnection = new Connection();
$verificationConnection->createConnection();


if ($showStatus == 'true') {
	// echo "You are verifying that subject number $subjectID attended study number $studyID, arriving at $startTime and leaving at $endTime.";
	$verificationConnection->sql="UPDATE `cs 375`.`appointments` SET ActualStartTime='$startTime', ActualEndTime='$endTime', ShowOrNoShow=1 WHERE StudyID=$studyID AND SubjectID=$subjectID";
}
else if ($showStatus == 'false') {
	// echo "You have indicated that subject number $subjectID failed to attend their appointment for study number $studyID.";
	$verificationConnection->sql="UPDATE `cs 375`.`appointments` SET ShowOrNoShow=0 WHERE StudyID=$studyID AND SubjectID=$subjectID";
}
$verificationConnection->submit();
$verificationConnection->closeConnection();

echo '<script type="text/javascript">
			alert("You have successfully verified the subject\'s participation in the experiment.")
           window.location.href = "experiment_verification.php"
      </script>';
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.7/js/tether.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!-- <script type="text/javascript" src="js/experiment_verification.js"></script> -->
</body>
</html>