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

if (isset($_POST['studyID'])) {
	$studyID = $_POST['studyID'];
}

if (isset($_POST['destination'])) {
	$destination = $_POST['destination'];
}

echo "<div style='position:absolute; top:30%; right:0; left:0;'><form align='center' style='vertical-align:center' action='verify_identity.php' method='post'>
		First Name: <input type='text' name='firstName'><br>
		Last Name: <input type='text' name='lastName'><br>
		Password: <input type='text' name='password'><br>
		<input type='hidden' name='studyID' value=" . $studyID . ">
		<input type='hidden' name='destination' value='" . $destination . "'>
		<input type='submit' value='Submit'>
		</form></div>";




?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.7/js/tether.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</body>
</html>