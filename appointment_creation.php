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

include ("general_connection.php");
include ("calendar_class.php");

class AppCalendar extends Calendar {

	function checkIfConflicting($newAppointmentTime, $existingAppointmentTime) {
		if (($newAppointmentTime[1] < $existingAppointmentTime[0]) || ($newAppointmentTime[0] > $existingAppointmentTime[1])) { // checks to see if the new appointment is either completely before or completely after the existing appointment - if the new appointment ends before the existing appointment or starts after the existing appointment, a false value is returned indicating that it does not conflict with the existing appointment. This will be run for each existing appointment on that day
			return false;
		}
		else return true;
	}

	function createBottomOfCalendar ($studyID) {

		$studyID = $studyID;
		$timestamp = mktime(0,0,0,$this->cMonth,1,$this->cYear);
		$maxday = date("t",$timestamp);
		$thismonth = getdate ($timestamp);
		$startday = $thismonth['wday'];
		for ($i=0; $i<($maxday+$startday); $i++) {
		    if(($i % 7) == 0 ) echo "<tr>";
		    if($i < $startday) echo "<td></td>";
		    else {
		    	$date = date_create(strval($this->cYear) . '-' . strval($thismonth['mon']) . '-' . strval($i - $startday + 1));
		    	$getExperimentDuration = new Connection();
		    	$getExperimentDuration->sql = "SELECT ExpectedTimeInMinutes FROM `study` WHERE StudyID = $studyID"; // creates query to get expected time of experiment for study in question
		    	$getExperimentDuration->createConnection();
		    	$getExperimentDuration = mysqli_query($getExperimentDuration->conn, $getExperimentDuration->sql); // runs the query on the database
		    	if (mysqli_num_rows($getExperimentDuration) > 0) {
		    		while ($row = mysqli_fetch_assoc($getExperimentDuration)) { // since the query should only return one row, this will only run once
		    			$experimentDuration = $row['ExpectedTimeInMinutes']; // sets variable to the time the experiment is expected to take
		    		}
		    	}

		    	$availabilities = new Connection();  // creates Connection object for getting the available times
		    	$availabilities->sql = "SELECT * FROM `experimenter availability` WHERE StudyID = $studyID AND Date = $date"; // gets experimenter availabilities for that study and date
		    	$availabilities->createConnection();
		    	$availabilities = mysqli_query($availabilities->conn, $availabilities->sql); // runs query
		    	$availabilityArray = array(); // create array object for start times and end times of different availabilities to be put into
		    	if (mysqli_num_rows($availabilities) > 0) {
		    		while ($row = mysqli_fetch_assoc($availabilities)) {
		    			$individualAvailability = array($row['startTime'], $row['endTime'], $row['ExperimenterID']);
		    			array_push($availabilityArray, $individualAvailability);
		    		}
		    	}
		    	$availabilities->closeConnection();

		    	$roomTimes = array();
		    	$rooms = new Connection();
		    	$rooms->sql = "SELECT Room.RoomID, App.StartTime, App.EndTime
		    					FROM `appointments` AS App 
		    					INNER JOIN `room info` AS Room ON Room.StudyID = App.StudyID
		    					WHERE Date = $date";
				$rooms->createConnection();
				$roomsResult = mysqli_query($rooms->conn, $rooms->sql);
				if (mysqli_num_rows($roomTimes) > 0) {
					while ($row = mysqli_fetch_assoc($roomsResult)) {
						$appointmentTime = array($row['StartTime'], $row['EndTime']);
						array_push($roomTimes, $appointmentTime);
					}
				}

		    	$experimenterTimeSlots = array(); // array of time slots that work for the experimenter
		    	$roomTimeSlots = array(); // array of time slots after room availability is checked
		    	$finalTimeSlots = array(); // used for a simpler removal of duplicates
		    	$getExistingAppointments = new Connection();
		    	$getExistingAppointments->createConnection();
		    	foreach($availabilityArray as $individualAvailability) {
		    		$startOfTimeSlot = $individualAvailability[0];
		    		$endOfTimeSlot = date("H:i", strtotime('+' . $experimentDuration . ' minutes', $startOfTimeSlot));
		    		$endOfAvailability = $individualAvailability[1];
		    		$proctorID = $individualAvailability[2];
		    		$existingAppointments = array();
		    		$getExistingAppointments->sql = "SELECT * FROM `appointments` WHERE ExperimenterID = $proctorID AND Date = $date";
		    		$existingAppointmentsResult = mysqli_query($getexistingAppointments->conn, $availabilities->sql);
		    		if (mysqli_num_rows($existingAppointmentsResult) > 0) {
		    			while ($row = mysqli_fetch_assoc($existingAppointmentsResult)) {
		    				$appointment = array($row['StartTime'], $row['EndTime']);
		    				array_push($existingAppointments, $appointment);
		    			}
		    		}
		    		while ($endOfTimeSlot < $endOfAvailability) {
		    			$individualSlot = array($startOfTimeSlot, date("H:i", strtotime('+' . $duration . ' minutes'), strtotime($startOfTimeSlot)));
		    			foreach ($existingAppointments as $appointment) {
		    				if (!checkIfConflicting($individualSlot, $appointment)) {
		    					array_push($experimenterTimeSlots, $individualSlot);	
		    				}	
		    			}
		    			$startOfTimeSlot = date("H:i", strtotime('+15 minutes'), strtotime($startOfTimeSlot));
		    			$endOftimeSlot = date("H:i", strtotime('+' . $experimentDuration . ' minutes', $startOfTimeSlot));
		    		}

		    		foreach($experimenterTimeSlots as $slot) {
		    			foreach($roomTimes as $roomTime) {
		    				if (!checkIfConflicting($slot, $roomTime)) {
		    					array_push($roomTimeSlots, $roomTime);
		    				}
		    			}
		    		}
		    	}

		    	foreach($roomTimeSlots as $slot) {
		    		$equal == false;
		    		if (count($finalTimeSlots) > 0) {
		    			foreach($finalTimeSlots as $final) {
			    			if ($slot[0] == $final[0]) {
			    				$equal = true;
			    				break;
			    			}
			    			else {
			    				$equal = false;
			    			}
			    		}
			    	}
		    		if ($equal == false) {
		    			array_push($finalTimeSlots, $slot);
		    		}
		    	}
		    	echo "<td align='left' valign='top' width='100px' height='100px'>". ($i - $startday + 1) . "<br> <select name='timeSlots'>";
		    	foreach ($finalTimeSlots as $slot) {
		    		$string = $slot[0] . "-" . $slot[1];
		    	 	echo "<option value='" . $string . "'>" . $string . "</option>";
		    	}
		    	echo "</td>";
		    }
		    if(($i % 7) == 6 ) echo "</tr>";
		}

	echo "
	</table>
	</td>
	</tr>
	</table>
	";
	}
}

$studyID = $_GET['StudyID'];

$studyConnection = new Connection();

$studyConnection->sql = "SELECT * FROM `$study` WHERE StudyID = $studyID;";
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

	$class_select = "<select name='classes'>";

	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$class_select = $class_select . "<option value='" . $row['ClassID'] . "'>" . $row['ClassName'] . "</option>";
		}
	} 

	$class_select = $class_select . "</select>";

	echo "<form>
	Study Name: " . $studyInfo['StudyName'] . "<br>
	Description: " . $studyInfo['Description'] . "<br>
	Expected Points Earned: " . $studyInfo['ExpectedPointValue'] . "<br>
	Expected Duration: " . $studyInfo['ExpectedTimeInMinutes'] . " minutes <br>
	Class for Credit: " . $class_select . "<br>
	Preferred Contact Method: 
	<table> <tr> <td> <input type='checkbox' id='prefPhone' value='Phone'> Phone </td>
	<td> <input type='checkbox' id='prefEmail' value='Email'> Email </td> </tr> </table> <br>
	Phone Number: <input type='text' id='phone'> <br>
	Email Address: <input type='text' id='email'> <br>
	 ";
}

?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.7/js/tether.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</body>
</html>