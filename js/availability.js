function checkInfo()
{
	<?php include("refactoring_calendar.php");?> //get the date from this

	var studyID = 44;
	var procID = 4;
	var date = new Date(<?php $cYear . " - " . $cMonth . " - " . $day);
	var startTime = $('#startTime').val();
	var endTime = $('#endTime').val();

	if (!(startTime == "") && !(endTime == ""))
	{	
		if (startTime >= endTime)
			alert("Start Time is greater than or equal to End Time");

		else window.location.href = "submission.php?StudyID" 
				+ studyID + "&ExperimenterID" + procID + "&Date"
				+ date + "&StartTime" + startTime + "&EndTime" + endTime;
	}

	else alert("One or both boxes are empty!");
}

var submitButton = $('#submit');
submitButton.on("click", checkInfo);