<html>
<head>
</head>
<body>

<?php
$monthNames = Array("January", "February", "March", "April", "May", "June",   "July", "August", "September", "October", "November", "December");
?>

<?php
if (!isset($_REQUEST["month"])) $_REQUEST["month"] = date("n");
if (!isset($_REQUEST["year"])) $_REQUEST["year"] = date("Y");
?>

<?php
$cMonth = $_REQUEST["month"];
$cYear = $_REQUEST["year"];
 
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
?>

<table width="1200">
<tr align="center">
<td bgcolor="#999999" style="color:#FFFFFF">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td width="50%" align="left">  <a href="<?php echo $_SERVER["PHP_SELF"] . "?month=". $prev_month . "&year=" . $prev_year; ?>" style="color:#FFFFFF">Previous</a></td>
<td width="50%" align="right"><a href="<?php echo $_SERVER["PHP_SELF"] . "?month=". $next_month . "&year=" . $next_year; ?>" style="color:#FFFFFF">Next</a>  </td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center">
<table width="100%" border="2" cellpadding="2" cellspacing="2">
<tr align="center">
<td colspan="7" bgcolor="#999999" style="color:#FFFFFF"><strong><?php echo $monthNames[$cMonth-1].' '.$cYear; ?></strong></td>
</tr>
<tr>
<td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>Sun</strong></td>
<td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>Mon</strong></td>
<td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>Tue</strong></td>
<td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>Wed</strong></td>
<td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>Thu</strong></td>
<td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>Fri</strong></td>
<td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>Sat</strong></td>
</tr>

<?php 
$timestamp = mktime(0,0,0,$cMonth,1,$cYear);
$maxday = date("t",$timestamp);
$thismonth = getdate ($timestamp);
$startday = $thismonth['wday'];
for ($i = 0; $i < ($maxday + $startday); $i++) 
{
    if(($i % 7) == 0 ) echo "<tr>";

    if($i < $startday) echo "<td></td>";
    else 
    {
        $day = $i - $startday + 1;//Made into variable for JavaScript reference

    	echo "<td align='left' valign='top' height='110px'>". $day;

    	echo "<br>Start:<select id='startTime'" .
    		 "<option selected disabled hidden style='display: none' value='blank'><time></time></option>" .
	         "<option value='five'><time>5:00</time></option>" .
	         "<option value='five-thirty'><time>5:30</time></option>" .
	         "<option value='six'><time>6:00</time></option>" .
	         "<option value='six-thirty'><time>6:30</time></option>" .
    		 "<option value='seven'><time>7:00</time></option></select>" .

    		 "<br>End: <select id='endTime'" .
    		 "<option selected disabled hidden style='display: none' value='blank'><time></time></option>" .
    		 "<option value='five-thirty'><time>5:30</time></option>" .
    		 "<option value='six'><time>6:00</time></option>" .
    		 "<option value='six-thrity'><time>6:30</time></option>" .
    		 "<option value='seven'><time>7:00</time></option>" .
    		 "<option value='seven-thirty'><time>7:30</time></option></select>";

        echo "<br><button id='submit' type='button'>Submit</button></td>";
    }

    if(($i % 7) == 6 ) echo "</tr>";
}
?>

</table>
</td>
</tr>
</table>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript" src="js/availability.js"></script>
</body>
</html>