<html>
<head>
Example
</head>
<body>
<center>Study Creation</center>
<form>
Study Name:<br>
<input type="text" id="studyname"><br>
Password:<br>
<input type="text" id="password"><br>
Study Description:<br>
<input type="text" id="description"><br>
Classes Available (separate by "|"): <br>
<input type="text" id="classes"><br>
Start Date (MM/DD/YYYY): <br>
<input type="text" id="startdate"><br>
End Date (MM/DD/YYYY): <br>
<input type="text" id="enddate"><br>
Expected Points: <br>
<input type="text" id="points"> <br>
Expected Time (in minutes): <br>
<input type="text" id="time"> <br>
Multi-Testing Support (would the proctor be able to run multiple experiments like it at the same time?): <br>
<input type="checkbox" id="multitest" value="multitest"> <br>
Rooms: <br>
<input type="checkbox" id="lab2" value="Lab 2"> Lab 2 <br>
<input type="checkbox" id="lab3" value="Lab 3"> Lab 3 <br>
<input type="checkbox" id="lab4" value="Lab 4"> Lab 4 <br>
<input type="checkbox" id="lab5" value="Lab 5"> Lab 5 <br>
<input type="checkbox" id="lab6" value="Lab 6"> Lab 6 <br>
<input type="checkbox" id="lab7" value="Lab 7"> Lab 7 <br>

<button id="submit" type="button">Submit</button>
<!--
<?php
$listOfInput = $_GET['listOfInput'];

$servername = "localhost";
$username = "root";
$dbname = "cs 375";

// Create connection
$conn = new mysqli($servername, $username, NULL, $dbname);
# Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "INSERT INTO study (StudyName, Description, StartDate, EndDate, Password, MultiTestingSupport, ExpectedPointValue, ExpectedTimeInMinutes, Lab2, Lab3, Lab4, Lab5, Lab6, Lab7)
VALUES ('The Effect of Sleep Deprivation on Reflexes In Young Adults', 'Come in, tell us how much sleep you have had during the last three nights, take a reflex test using flashing lights', 2018-01-01, 2018-12-31, 'LeftRightCenter', 1, 1, 15, 0, 0, 1, 1, 1, 1)";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
-->


</form>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript" src="js/study_creation.js"></script>
</body>
</html>