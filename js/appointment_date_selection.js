function goToAppointCreate(studyID, date) {
	console.log("Date: " + date);
	var day = date.substring(8,10);
	
	console.log("Day: " + day);
	
	if (parseInt(day) < 10) {
		day = day.substring(1,2);
	}
	console.log("Day: " + day);
	var id = "#day" + day;
	console.log("ID: " + id);

	var codeString = "console.log($('" + id + " option:selected').val());";

	eval(codeString);

	//console.log($("id").prop('selected', true));


	// window.location.href="appointment_creation_final.php?studyID=" + studyID + "&date=" + date + "&timeSlot=" + $(id);
}