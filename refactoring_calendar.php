<html>
<head>
</head>
<body>
<div>
<?php include 'links.php';?>

<?php
echo "<form action='availability.php' method='post' name='proctorTime'>";

$monthNames = Array("January", "February", "March", "April", "May", "June",  "July", "August", "September", "October", "November", "December");
$bgcolor = "#999999";
$color = "color:#FFFFFF";

if (!isset($_REQUEST["month"])) $_REQUEST["month"] = date("n");// Requesting the current month
if (!isset($_REQUEST["year"])) $_REQUEST["year"] = date("Y");// Requesting the current year

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
$startTimes = Array("", "5:00", "5:30", "6:00", "6:30", "7:00");
$endTimes = Array("", "5:30", "6:00", "6:30", "7:00", "7:30");

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

    	echo "<td align='left' valign='top' height='110px'>". $currentDay . "<br>" . "<input type='hidden' name='day' value='" . $currentDay . "'>";

        echo "Start:<select name='startTime'" .
        "<option></option>";

        for ($f = 0; $f < count($startTimes); $f++)
        {
            echo "<option value='" . $startTimes[$f] . "'"; if($startTimes[$f] == '') echo " style='display:none'"; echo "><time>" . $startTimes[$f] . "</time></option>";
        }

        echo "</select>";

        echo "<br>End: <select name='endTime'" .
        "<option></option>";

        for ($f = 0; $f < count($endTimes); $f++)
        {
            echo "<option value='" . $endTimes[$f] . "'"; if($endTimes[$f] == '') echo " style='display:none'"; echo "><time>" . $endTimes[$f] . "</time></option>";
        }

        echo "</select>";

        $day = $currentDay - $emptyDays;

        echo "<br><input type='submit' value='Submit'>" . "</td>" .
        "<input type='hidden' name='year' value='" . $cYear . "'>" .
        "<input type='hidden' name='month' value='" . $monthNames[$cMonth - 1] . "'>";
    }

    if(($i % 7) == 6 ) echo "</tr>" . "</form>";
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