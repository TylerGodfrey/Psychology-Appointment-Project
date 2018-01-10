<html>
<head>
</head>
<body>
<div>
<?php

include ('links.php');

$monthNames = Array("January", "February", "March", "April", "May", "June",  "July", "August", "September", "October", "November", "December");
$bgcolor = "#999999";
$color = "color:#FFFFFF";

if (!isset($_REQUEST["month"])) $_REQUEST["month"] = date("n");// Requesting the current month
if (!isset($_REQUEST["year"])) $_REQUEST["year"] = date("Y");// Requesting the current year

if (isset($_POST["studyID"])) {
    $studyID = $_POST["studyID"];
}

if (isset($_POST["proctorID"])) {
    $proctorID = $_POST["proctorID"];
}

$cMonth = $_REQUEST["month"];// Current month
$cYear = $_REQUEST["year"];// Current year
 
$prev_year = $cYear;
$next_year = $cYear;
$prev_month = $cMonth-1;
$next_month = $cMonth+1;
 
if ($prev_month == 0 ) {
    $prev_month = 12;
    $prev_year = $cYear - 1;
}
if ($next_month == 13 ) {
    $next_month = 1;
    $next_year = $cYear + 1;
}

echo "<table width='1200'>" . "<tr align='center'>" .
"<td bgcolor='" . $bgcolor . "' style='" . $color . "'>" .
"<table width='100%'' border='0' cellspacing='0' cellpadding='0'>" . "<tr>" .
"<td width='50%' align='left'>" . "<a href=" . $_SERVER["PHP_SELF"] . "?month=" . $prev_month . "&year=" . $prev_year . "&style='" . $color . "'>Previous</a></td>" . //to go to the previous month
"<td width='50%'' align='right'><a href=" . $_SERVER["PHP_SELF"] . "?month=". $next_month . "&year=" . $next_year . "&style='" . $color . "''>Next</a></td>" .   //To go to the next month
"</tr></table></td></tr>" .
"<tr><td align='center'>
<table width='100%' border='2' cellpadding='2' cellspacing='2'>" .
"<tr align='center'>
<td colspan='7' bgcolor='" . $bgcolor . "' style='" . $color . "'><strong>" . $monthNames[$cMonth-1] . ' ' . $cYear . "</strong></td></tr>" .

"<tr>";
// Looped through the days of the week instead of using multiple <td> tags
$dayNames = Array("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat");
for($i = 0; $i < count($dayNames); $i++)
{
    echo "<td align='center' bgcolor='" . $bgcolor ."' style='" . $color . "'><strong>" . $dayNames[$i] . "</strong></td>";
}
echo "</tr>";

$timestamp = mktime(0,0,0,$cMonth,1,$cYear);
$maxday = date("t",$timestamp);
$thismonth = getdate ($timestamp);
$startday = $thismonth['wday'];
$emptyDays = 0;
$currentDay = 0;
// Next four variables are arrays to loop through time oprions in <select> tags
$utcTimes = Array("",
'7:00', '7:30',
'8:00', '8:30',
'9:00', '9:30',
'10:00',    '10:30',
'11:00',    '11:30',
'12:00',    '12:30',
'13:00',    '13:30',
'14:00',    '14:30',
'15:00',    '15:30',
'16:00',    '16:30',
'17:00',    '17:30',
'18:00',    '18:30',
'19:00',    '19:30',
'20:00',    '20:30',
'21:00',    '21:30',
'22:00'
);

$periodTimes = Array("");

foreach($utcTimes as $time) {
    if ($time != "") {
        array_push($periodTimes, date_format(date_create($time), 'h:i A'));
    }
}

for ($i = 0; $i < ($maxday + $startday); $i++) 
{
    if(($i % 7) == 0 ) echo "<tr>";

    if($i < $startday)
    {
        $emptyDays++;
        echo "<td></td>";
    } 

    else 
    {
        $currentDay++;

        $day = DateTime::createFromFormat('d', $currentDay);
        $day = $day->format('d');

    	echo "<td align='left' valign='top' height='110px'>". $currentDay . "<br>" . "<form action='availability.php' method='post' name='proctorTime'>" . "<input type='hidden' name='day' value='" . $day . "'>";

        echo "Start:<select name='startTime'><option></option>";

        for ($f = 0; $f < count($utcTimes); $f++)
        {
            echo "<option value='" . $utcTimes[$f] . "'"; if($utcTimes[$f] == '') echo " style='display:none'"; echo "><time>" . $periodTimes[$f] . "</time></option>";
        } //time will end at the last day, in this case

        echo "</select>";

        echo "<br>End: <select name='endTime'" .
        "<option></option>";

        for ($f = 0; $f < count($utcTimes); $f++)
        {
            if(empty($utcTimes[$f]))   
                echo "<option value='default' style='display:none'></option>";
            else 
                echo "<option value='" . $utcTimes[$f] . "'><time>" . $periodTimes[$f] . "</time></option>";
        }

        echo "</select>";

        //$day = $currentDay - $emptyDays;

        echo "<input type='hidden' name='year' value='" . $cYear . "'>" .
        "<input type='hidden' name='month' value='" . $monthNames[$cMonth - 1] . "'>
        <input type='hidden' name='studyID' value='" . $studyID . "'>
        <input type='hidden' name='proctorID' value='" . $proctorID . "'>"
        . "<br><input type='submit' value='Submit'>" . "</form></td>" ;
    }

    if(($i % 7) == 6 ) echo "</tr>";
}
?>

</table>
</td>
</tr>
</table>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<!-- <script type="text/javascript" src="js/availability.php"></script> -->
</body>
</html>