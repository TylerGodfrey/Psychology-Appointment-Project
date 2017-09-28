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

	console.log(startDateFixed + ", " + endDateFixed);


	/*var startDate = $("#startdate").val();
	var startDateMonth = startDate.substring(0,2);
	var startDateDay = startDate.substring(3,5);
	var startDateYear = startDate.substring(6,10);
	var startDateFixed = startDateYear + "-" + startDateMonth + "-" + startDateDay;

	console.log(startDateFixed);*/
}

var submitButton = $('#submit');
submitButton.on("click", fixDateForDatabase);

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