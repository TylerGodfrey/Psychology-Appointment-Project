function submit(lineNumber, studyID, subjectID) {
	console.log(lineNumber);
	console.log(studyID);
	console.log(subjectID);

	var idStart = "#startTime" + lineNumber;
	var idEnd = "#endTime" + lineNumber;
	var idShow = "#show" + lineNumber;

	var startSelect = "$('" + idStart + "').val()";
	eval("console.log(" + startSelect + ")");

	var endSelect = "$('" + idEnd + "').val()";
	eval("console.log(" + endSelect + ")");

	var showSelect = "$('" + idShow + "').prop('checked')";
	eval("var showValue = " + showSelect);

	console.log(showValue);


	if (showSelect) {
		eval('window.location.href = "experimenter_verification_submission.php?StudyID=" + ' + studyID + ' + "&SubjectID=" + ' + subjectID + ' + "&StartTime=" + ' + startSelect + ' + "&EndTime=" + ' + endSelect + ' + "&ShowStatus=" + ' + showSelect);	
	}

	else {
		eval('window.location.href = "experimenter_verification_submission.php?StudyID=" + ' + studyID + ' + "&SubjectID=" + ' + subjectID + ' + &ShowStatus=" + ' + showSelect);	
	}

}