function checkTimes()
{
	var startTime = $('#startTime').val();
	var endTime = $('#endTime').val();

	if (!(startTime == "") && !(endTime == ""))
	{	
		if (startTime >= endTime)
		{
			alert("Start Time is lesser than or equal to End Time");
		}

		else
		{

		}
	}
}

var submitButton = $('#submit');
submitButton.on("click", checkTimes);