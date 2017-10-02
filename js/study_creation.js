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


	var listOfInput = [];

	listOfInput.push(studyName);
	listOfInput.push(password);
	listOfInput.push(description);
	listOfInput.push(classes);
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

	console.log(listOfInput);

	window.location.href = "submission.php?listOfInput=" + listOfInput;


	/*if ($('#multitest').prop('checked')) {
		console.log('Multitest: true');
		multiTest = true;
	}
	else {
		console.log('Multitest: false');
	}
	if ($('#lab2').prop('checked')) {
		console.log('Lab 2: Access granted');
		lab2 = true;
	}
	else {
		console.log('Lab 2: Access denied');
	}
	if ($('#lab3').prop('checked')) {
		console.log('Lab 3: Access granted');
		lab3 = true;
	}
	else {
		console.log('Lab 3: Access denied');
	}
	if ($('#lab4').prop('checked')) {
		console.log('Lab 4: Access granted');
		lab4 = true;
	}
	else {
		console.log('Lab 4: Access denied');
	}
	if ($('#lab5').prop('checked')) {
		console.log('Lab 5: Access granted');
		lab5 = true;
	}
	else {
		console.log('Lab 5: Access denied');
	}
	if ($('#lab6').prop('checked')) {
		console.log('Lab 6: Access granted');
		lab6 = true;
	}
	else {
		console.log('Lab 6: Access denied');
	}
	if ($('#lab7').prop('checked')) {
		console.log('Lab 7: Access granted');
		lab7 = true;
	}
	else {
		console.log('Lab 7: Access denied');
	} */
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


	/*var startDate = $("#startdate").val();
	var startDateMonth = startDate.substring(0,2);
	var startDateDay = startDate.substring(3,5);
	var startDateYear = startDate.substring(6,10);
	var startDateFixed = startDateYear + "-" + startDateMonth + "-" + startDateDay;

	console.log(startDateFixed);*/
}

var submitButton = $('#submit');
submitButton.on("click", checkValues);

/*function fixDateForDatabase() {
	//var startDate = $("#startdate").val();
	//var startDateMonth = startDate.substring(0,2);
	//var startDateDay = startDate.substring(3,5);
	//var startDateYear = startDate.substring(6,10);
	//var startDateFixed = startDateYear + "-" + startDateMonth + "-" + startDateDay;

	//console.log(startDateFixed);
	//console.log(startDateMonth);
	console.log($("#startdate").val());
}

console.log("hello");

var submitButton = $('#submit');
submitButton.on("click", fixDateForDatabase);*/