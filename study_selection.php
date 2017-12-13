<html>
<head>
<title>Example Study Selection</title>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
</head>
<body>

<?php

include ("general_connection.php");

$gather = new Connection();

$gather->sql = "SELECT * FROM `study`";
$gather->createConnection();
$result = mysqli_query($gather->conn, $gather->sql);

$study_number = mysqli_num_rows($result);
if ($study_number > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        $classes = new Connection();

        $classes->sql = "SELECT * FROM `class study pairings` AS CSP INNER JOIN `classes` AS Classes ON Classes.ClassID = CSP.ClassID WHERE StudyID ="  . $row['StudyID'] . ";";
        $classes->createConnection();
        $classes = mysqli_query($classes->conn, $classes->sql);

        $class_concat = '';

        if (mysqli_num_rows($classes) > 0) {
            while($class_row = mysqli_fetch_assoc($classes)) {
                $class_concat = $class_concat . "<br>" . $class_row['ClassName'] . ', ';
            }
            $class_concat = substr($class_concat, 0, -2);
        }
        else {
            $class_concat = "<br>None available.";
        }
        
        echo "
        <table border=\"2\">
        <col width=\"200\">
        <col width=\"200\">

        <tr>
            <td colspan='2'>" . 
            $row['StudyName'] .
            "<form action='appointment_date_selection.php' method='POST'>
            <input type='hidden' name='studyID' value=" . $row['StudyID'] . ">
            <input type='hidden' name='year' value=" . date_format(date_create(), 'Y') . ">
            <input type='hidden' name='month' value=" . date_format(date_create(), 'm') . "><input type='submit' value='Make An Appointment'></input></form>
            </td> 
        </tr>
        <tr>
            <td colspan=\"2\">" .
            $row['Description'] .
            "</td>
        </tr>
        <tr>
            <td>Points Available:<br>" .
            $row['ExpectedPointValue'] .
            " points</td>
            <td>Expected Duration:<br>" .
            $row['ExpectedTimeInMinutes'] . 
            " minutes</td>
        </tr>
        <tr>
            <td colspan='2'>
            Eligible Classes: " .
            $class_concat .
            "
            </td>
        </tr>
        </table>";

    }
} else {
    echo "0 results";
}

$gather->closeConnection();

?>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.7/js/tether.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/study_select_for_appointment.js"></script>

</body>
</html>