<html>
<head>
</head>
<body>
	<?php
	include ('links.php');
	?>
<center>Study Creation</center>
<form>
Study Name:<br>
<input type="text" id="studyname"><br>
Password:<br>
<input type="text" id="password"><br>
Study Description:<br>
<input type="text" id="description"><br><br>

<?php 
include ('general_connection.php');
$classesQuery = new Connection();
$classesQuery->createConnection();
$classesQuery->sql = "SELECT * FROM `classes`";
$classesResult = mysqli_query($classesQuery->conn, $classesQuery->sql);
$classesDropdown = "";
if (mysqli_num_rows($classesResult) > 0) {
	$classesDropdown = $classesDropdown . "<select multiple id='classes'>";
	while ($row = mysqli_fetch_assoc($classesResult)) {
		$classesDropdown = $classesDropdown . "<option value='" . $row['ClassID'] . "'>" . $row['ClassName'] . "</option>";
	}
	$classesDropdown = $classesDropdown . "</select>";
}
else {
	$classesDropdown = "None Available.";
}
echo "Classes Available: <br>" . $classesDropdown . "<br><br>";
?>
Date (MM/DD/YYYY): <br>
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


</form>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript" src="js/study_creation.js"></script>
</body>
</html>