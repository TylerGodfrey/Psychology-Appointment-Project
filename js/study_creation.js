function checkValues() {
	var studyName = $('#studyname').val();
	var password = $('#password').val();
	var description = $('#description').val();
	var classes = $('#classes').val();
	var points = parseInt($('#points').val());
	var time = parseInt($('#time').val());

	var multiTest;
	var lab2;
	var lab3;
	var lab4;
	var lab5;
	var lab6;
	var lab7;

	if ($('#multitest').prop('checked')) {
		multiTest = 1;
	}
	else {
		multiTest = 0;
	}
	if ($('lab2').prop('checked')) {
		lab2 = 1;
	}
	else {
		lab2 = 0;
	}
	if ($('#lab3').prop('checked')) {
		lab3 = 1;
	}
	else {
		lab3 = 0;
	}
	if ($('#lab4').prop('checked')) {
		lab4 = 1;
	}
	else {
		lab4 = 0;
	}
	if ($('#lab5').prop('checked')) {
		lab5 = 1;
	}
	else {
		lab5 = 0;
	}
	if ($('#lab6').prop('checked')) {
		lab6 = 1;
	}
	else {
		lab6 = 0;
	}
	if ($('#lab7').prop('checked')) {
		lab7 = 1;
	}
	else {
		lab7 = 0;
	}

	var listOfDates = fixDateForDatabase();

	/*var listOfDates = fixDateForDatabase();

	var listOfInput = [];

	
	listOfInput.push(studyName);
	listOfInput.push(password);
	listOfInput.push(description);
	listOfInput.push(listOfDates[0]);
	listOfInput.push(listOfDates[1]);
	listOfInput.push(points);
	listOfInput.push(time);
	listOfInput.push(multiTest);
	listOfInput.push(lab2);
	listOfInput.push(lab3);
	listOfInput.push(lab4);
	listOfInput.push(lab5);
	listOfInput.push(lab6);
	listOfInput.push(lab7);

	console.log(listOfInput);*/

	window.location.href = "submission.php?StudyName=" + studyName + "&Password=" + password + "&Description=" + description + "&ClassesAvailable=" + classes + "&StartDate=" + listOfDates[0] + "&EndDate=" + listOfDates[1] + "&ExpectedPointValue=" + points + "&ExpectedTimeInMinutes=" + time + "&MultiTestingSupport=" + multiTest + "&Lab2=" + lab2 + "&Lab3=" + lab3 + "&Lab4=" + lab4 + "&Lab5=" + lab5 + "&Lab6=" + lab6 + "&Lab7=" + lab7; //https://stackoverflow.com/questions/8191124/send-javascript-variable-to-php-variable
}

function fixDateForDatabase() {


	var startDate = $('#startdate').val();
	var startDateMonth = startDate.substring(0,2);
	var startDateDay = startDate.substring(3,5);
	var startDateYear = startDate.substring(6,10);
	var startDateFixed = startDateYear + "-" + startDateMonth + "-" + startDateDay;

	var endDate = $('#enddate').val();
	var endDateMonth = endDate.substring(0,2);
	var endDateDay = endDate.substring(3,5);
	var endDateYear = endDate.substring(6,10);
	var endDateFixed = endDateYear + "-" + endDateMonth + "-" + endDateDay;

	startDateFixed = new Date(startDateFixed);
	endDateFixed = new Date(endDateFixed);
	startDateFixed.setDate(startDateFixed.getDate() + 1);
	endDateFixed.setDate(endDateFixed.getDate() + 1);
	startDateFixed = startDateFixed.toDateString("yyyy-MM-dd");
	endDateFixed = endDateFixed.toDateString("yyyy-MM-dd");

	console.log(startDateFixed + ", " + endDateFixed);

	return [startDateFixed, endDateFixed];
}

var submitButton = $('#submit');
submitButton.on("click", checkValues);