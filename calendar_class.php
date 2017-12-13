<html>
<head>
</head>
<body>

<?php
class Calendar { // code pulled from: https://www.phpjabbers.com/how-to-make-a-php-calendar-php26.html    minor changes made, but largely based on this
private $monthNames = Array("January", "February", "March", "April", "May", "June", "July", 
"August", "September", "October", "November", "December");

function createTopOfCalendar ($studyID) {
	if (!isset($_POST["month"])) $_POST["month"] = date("n");
	if (!isset($_POST["year"])) $_POST["year"] = date("Y");

	$this->cMonth = $_POST["month"];
	$this->cYear = $_POST["year"];
	 
	$prev_year = $this->cYear;
	$next_year = $this->cYear;
	$prev_month = $this->cMonth-1;
	$next_month = $this->cMonth+1;
	 
	if ($prev_month == 0 ) {
	    $prev_month = 12;
	    $prev_year = $this->cYear - 1;
	}
	if ($next_month == 13 ) {
	    $next_month = 1;
	    $next_year = $this->cYear + 1;
	}

	echo "

	<table width='1200'>
	<tr align='center'>
	<td bgcolor='#999999' style='color:#FFFFFF'>
	<table width='100%' border='0' cellspacing='0' cellpadding='0'>
	<tr>
	
	<td width='50%' align='left'> <form action='" . $_SERVER['PHP_SELF'] . "' method='post'>
		<input type='hidden' name='month' value='" . $prev_month . "'>
		<input type='hidden' name='year' value='" . $prev_year . "'>
		<input type='hidden' name='studyID' value='" . $studyID . "'>
		<input type='submit' value='Prev'></input>
		</form> </td>

	<td width='50%' align='right'> <form action='" . $_SERVER['PHP_SELF'] . "' method='post'>
		<input type='hidden' name='month' value='" . $next_month . "'>
		<input type='hidden' name='year' value='" . $next_year . "'>
		<input type='hidden' name='studyID' value='" . $studyID . "'>
		<input type='submit' value='Next'></input>
		</form> </td>	

	</tr>
	</table>
	</td>
	</tr>
	<tr>
	<td align='center'>
	<table width='100%' border='0' cellpadding='2' cellspacing='2'>
	<tr align='center'>
	<td colspan='7' bgcolor='#999999' style='color:#FFFFFF'><strong>" . $this->monthNames[$this->cMonth-1].' '.$this->cYear . "</strong></td>
	</tr>
	<tr>
	<td align='center' bgcolor='#999999' style='color:#FFFFFF'><strong>Sunday</strong></td>
	<td align='center' bgcolor='#999999' style='color:#FFFFFF'><strong>Monday</strong></td>
	<td align='center' bgcolor='#999999' style='color:#FFFFFF'><strong>Tuesday</strong></td>
	<td align='center' bgcolor='#999999' style='color:#FFFFFF'><strong>Wednesday</strong></td>
	<td align='center' bgcolor='#999999' style='color:#FFFFFF'><strong>Thursday</strong></td>
	<td align='center' bgcolor='#999999' style='color:#FFFFFF'><strong>Friday</strong></td>
	<td align='center' bgcolor='#999999' style='color:#FFFFFF'><strong>Saturday</strong></td>
	</tr>
	";
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
	    	echo "<td align='left' valign='top' width='110px' height='110px'>". ($i - $startday + 1) .
	    	 "</td>";
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
?>

</body>
</html>