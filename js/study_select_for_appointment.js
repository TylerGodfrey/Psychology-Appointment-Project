function goToPage(studyID) {
	//console.log(StudyID);
	var date = new Date();
	var month = date.getMonth() + 1;
	var year = date.getFullYear();
	window.location.href = "appointment_date_selection.php?StudyID=" + studyID + "&month=" + month + "&year=" + year;
}