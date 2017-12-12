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
		/*$timeDifferenceOne = date_diff($newAppointmentTime[1], $existingAppointmentTime[0]);
		$timeDifferenceTwo = date_diff($newAppointmentTime[0], $existingAppointmentTime[1]);
		$timeDifferenceOne->format("%R%a minutes");
		$timeDifferenceTwo->format("%R%a minutes");*/
		if ( $newAppointmentTime[1] <= $existingAppointmentTime[0] || $newAppointmentTime[0] >= $existingAppointmentTime[1] ) { // checks to see if the new appointment is either completely before or completely after the existing appointment - if the new appointment ends before the existing appointment or starts after the existing appointment, a false value is returned indicating that it does not conflict with the existing appointment. This will be run for each existing appointment on that day
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
		$timeFormat = "H:i";

		$roomNumbers = array();
		$roomNumberFetcher = new Connection();
		$roomNumberFetcher->sql = "SELECT RoomID FROM `cs 375`.`study lab pairings` WHERE StudyID = $studyID";
		$roomNumberFetcher->createConnection();
		$roomNumbersResult = mysqli_query($roomNumberFetcher->conn, $roomNumberFetcher->sql);
		if (mysqli_num_rows($roomNumbersResult) > 0) {
			while ($row = mysqli_fetch_assoc($roomNumbersResult)) {
				array_push($roomNumbers, $row['RoomID']);
			}
		}
		$roomNumberFetcher->closeConnection();

		$experimentDuration = "";
		$getExperimentDuration = new Connection();
    	$getExperimentDuration->sql = "SELECT ExpectedTimeInMinutes FROM `study` WHERE StudyID = $studyID"; // creates query to get expected time of experiment for study in question
    	$getExperimentDuration->createConnection();
    	$getExperimentDuration = mysqli_query($getExperimentDuration->conn, $getExperimentDuration->sql); // runs the query on the database
    	if (mysqli_num_rows($getExperimentDuration) > 0) {
    		while ($row = mysqli_fetch_assoc($getExperimentDuration)) { // since the query should only return one row, this will only run once
    			$experimentDuration = $row['ExpectedTimeInMinutes']; // sets variable to the time the experiment is expected to take
    		}
    	}

		for ($i=0; $i<($maxday+$startday); $i++) {
		    if(($i % 7) == 0 ) echo "<tr>";
		    if($i < $startday) echo "<td></td>";
		    else {
		    	$dateObject = date_create(strval($this->cYear) . '-' . strval($thismonth['mon']) . '-' . strval($i - $startday + 1));
		    	$date = date_format($dateObject, 'Y-m-d');

		    	$availabilitiesConnection = new Connection();  // creates Connection object for getting the available times
		    	$availabilitiesConnection->sql = "SELECT * FROM `experimenter availability` WHERE StudyID = $studyID AND Date = '$date'"; // gets experimenter availabilities for that study and date
		    	$availabilitiesConnection->createConnection();
		    	$availabilities = mysqli_query($availabilitiesConnection->conn, $availabilitiesConnection->sql); // runs query
		    	$availabilityArray = array(); // create array object for start times and end times of different availabilities to be put into
		    	if (mysqli_num_rows($availabilities) > 0) {
		    		while ($row = mysqli_fetch_assoc($availabilities)) {
		    			$startTime = date_create($row['StartTime']);
		    			$endTime = date_create($row['EndTime']);
		    			$individualAvailability = array($startTime, $endTime, $row['ExperimenterID']);
		    			array_push($availabilityArray, $individualAvailability);
		    		}
		    	}
		    	$availabilitiesConnection->closeConnection();


		    	// MODIFYING CALENDAR SO THAT THE ROOM NUMBERS ARE PUT TOGETHER WITH THE TIME SLOTS, NEED TO RE-DO HOW ROOM TIMES ARE CHECKED



		    	/*$roomTimes = array();
		    	$rooms = new Connection();
		    	$rooms->sql = "SELECT Room.RoomID, App.StartTime, App.EndTime
		    					FROM `cs 375`.`appointments` AS App 
		    					INNER JOIN `cs 375`.`study lab pairings` AS Room 
		    						ON Room.StudyID = App.StudyID AND App.RoomID = Room.RoomID
		    					WHERE App.Date = '$date'";
				$rooms->createConnection();
				$roomsResult = mysqli_query($rooms->conn, $rooms->sql);
				if ($roomsResult != false) {
					if (mysqli_num_rows($roomsResult) > 0) {
						while ($row = mysqli_fetch_assoc($roomsResult)) {
							$startTime = date_create($row['StartTime']);
							$endTime = date_create($row['EndTime']);
							array_push($roomTimes, array($startTime, $endTime, $row['RoomID']));
						}
					}
				}
				$rooms->closeConnection();*/

		    	$experimenterTimeSlots = array(); // array of time slots that work for the experimenter
		    	$roomTimeSlots = array(); // array of time slots after room availability is checked
		    	$finalTimeSlots = array(); // used for a simpler removal of duplicates
		    	$getExistingAppointments = new Connection();
		    	$getExistingAppointments->createConnection();
		    	foreach($availabilityArray as $individualAvailability) {
		    		$startOfTimeSlot = $individualAvailability[0];
		    		$endOfTimeSlot = date_create(date_format($startOfTimeSlot, $timeFormat)); // set this way so that we can change the end time without changing the start time
		    		$endOfTimeSlot->modify('+' . $experimentDuration . ' minutes');  // end of time slot is 30 minutes after start of time slot
		    		$endOfAvailability = $individualAvailability[1];
		    		$proctorID = $individualAvailability[2];
		    		$existingAppointments = array();
		    		$getExistingAppointments->sql = "SELECT * FROM `appointments` AS App WHERE App.ExperimenterID = $proctorID AND App.Date = '$date'";
		    		$existingAppointmentsResult = mysqli_query($getExistingAppointments->conn, $getExistingAppointments->sql);
		    		if (mysqli_num_rows($existingAppointmentsResult) > 0) {
		    			while ($row = mysqli_fetch_assoc($existingAppointmentsResult)) {
		    				$appointment = array(date_create($row['StartTime']), date_create($row['EndTime']));
		    				array_push($existingAppointments, $appointment);
		    			}
		    		}
		    		
		    		while ($endOfTimeSlot <= $endOfAvailability) {
		    			$individualSlot = array($startOfTimeSlot, $endOfTimeSlot);
    					$startTime = date_create(date_format($individualSlot[0], $timeFormat));
    					$endTime = date_create(date_format($individualSlot[1], $timeFormat));
		    			if (count($existingAppointments) > 0) {
			    			foreach ($existingAppointments as $appointment) {
			    				if (!$this->checkIfConflicting($individualSlot, $appointment)) {
			    					array_push($experimenterTimeSlots, array($startTime, $endTime, $proctorID));
			    				}	
			    			}
		    			}
		    			else {
		    				array_push($experimenterTimeSlots, array($startTime, $endTime, $proctorID));
		    			}

		    			$startOfTimeSlot->modify('+15 minutes');
		    			$endOfTimeSlot->modify('+15 minutes');
		    		}

		    		foreach($experimenterTimeSlots as $slot) {
		    			$startTime = date_create(date_format($slot[0], $timeFormat));
			    		$endTime = date_create(date_format($slot[1], $timeFormat));
		    			if (count($roomTimes) > 0) {
			    			foreach($roomTimes as $roomTime) {
			    				if (!$this->checkIfConflicting($slot, $roomTime)) {
			    					array_push($roomTimeSlots, array($startTime, $endTime, $slot[2], $roomTime[2]));
			    				}
			    			}
			    		}
			    		else {
			    			array_push($roomTimeSlots, array($startTime, $endTime, $slot[2], ));
			    		}
		    		}
		    	}
		    	

		    	foreach($roomTimeSlots as $slot) {
		    		$equal = false;
		    		//$proctorArray = array();
		    		//$roomArray = array();
		    		if (count($finalTimeSlots) > 0) {
		    			foreach($finalTimeSlots as $final) {
			    			if ($slot[0] == $final[0]) {
			    				$equal = true;
			    				//array_push($proctorArray, $slot[2]);
			    				//array_push($roomArray, $slot[3]);
			    				break;
			    			}
			    			else {
			    				$equal = false;
			    			}
			    		}
			    	}
		    		if ($equal == false) {
		    			array_push($finalTimeSlots, array($slot[0], $slot[1]));
		    		}
		    	}

		    	$timeSlotsWithPairings = array(); // time slots paired with the experimenters and rooms available at the time

		    	foreach($finalTimeSlots as $final) {
		    		$proctorArray = array();
		    		$roomArray = array();
		    		foreach($roomTimeSlots as $room) {
		    			if ($final[0] == $room[0]) {
		    				array_push($proctorArray, $room[2]);
		    				array_push($roomArray, $room[3]);
		    			}
		    		}
		    		array_push($timeSlotsWithPairings, array($final[0], $final[1], $proctorArray, $roomArray));
		    	}

		    	$day = $i - $startday + 1;
		    	$dateInsert = "<td align='left' valign='top' width='100px' height='100px'>" . ($day) . "<br>";
		    	if (count($finalTimeSlots) > 0) {
		    		$dateInsert = $dateInsert . "<select id='day" . $day . "'> <option value=''></option>";
		    		foreach ($finalTimeSlots as $slot) {
		    			$string = date_format($slot[0], $timeFormat) . "-" . date_format($slot[1], $timeFormat);
		    			$dateInsert = $dateInsert . "<option value'" . $string . "'>" . $string . "</option>";
		    		}
		    		$dateInsert = $dateInsert . "</select><br><button type='button' class='btn btn-primary' style='float: right' onclick='goToAppointCreate(". "$studyID" . ", \"" . $date . "\")'>Submit</button>";
		    	}
		    	else {
		    		$dateInsert = $dateInsert . "No times available.";
		    	}
		    	$dateInsert = $dateInsert . "</td>";
		    	echo $dateInsert;
		    	/*echo "<td align='left' valign='top' width='100px' height='100px'>". ($i - $startday + 1) . "<br> <select name='timeSlots'> <option value=''></option>";
		    	foreach ($finalTimeSlots as $slot) {
		    		$string = date_format($slot[0], $timeFormat) . "-" . date_format($slot[1], $timeFormat);
		    	 	echo "<option value='" . $string . "'>" . $string . "</option>";
		    	}
		    	echo "</select></td>";*/
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

$studyConnection->sql = "SELECT * FROM `study` WHERE StudyID = $studyID;";
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

	echo "<form align='center'>
	Study Name: " . $studyInfo['StudyName'] . "<br>
	Description: " . $studyInfo['Description'] . "<br>
	Expected Points Earned: " . $studyInfo['ExpectedPointValue'] . "<br>
	Expected Duration: " . $studyInfo['ExpectedTimeInMinutes'] . " minutes <br>
	Class for Credit: " . $class_select . "<br>
	Preferred Contact Method:
	<input type='checkbox' id='prefPhone' value='Phone'> Phone
	<input type='checkbox' id='prefEmail' value='Email'> Email <br>
	Phone Number: <input type='text' id='phone'> <br>
	Email Address: <input type='text' id='email'> <br>
	 ";
	$appCal = new AppCalendar();
	$appCal->createTopOfCalendar($studyInfo['StudyID']);
	$appCal->createBottomOfCalendar($studyInfo['StudyID']);
}

?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.7/js/tether.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/appointment_date_selection.js"></script>
</body>
</html>