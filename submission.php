<html>
 <head>
  <title>PHP Test</title>
 </head>
 <body>
 <?php
function isDate($value) /*https://stackoverflow.com/questions/11029769/function-to-check-if-a-string-is-a-date*/
{
    if (!$value) {
        return false;
    }

    try {
        new \DateTime($value);
        return true;
    } catch (\Exception $e) {
        return false;
    }
}

$listOfInput = $_GET['listOfInput'];
$listOfInput = preg_split('/,/', $listOfInput, -1, PREG_SPLIT_NO_EMPTY);
/*print_r($listOfInput);*/

$sql = "INSERT INTO `study` (StudyName, Password, Description, ClassesAvailable, StartDate, EndDate, ExpectedPointValue, ExpectedTimeInMinutes, MultiTestingSupport, Lab2, Lab3, Lab4, Lab5, Lab6, Lab7) VALUES (";
foreach ($listOfInput as $value) {
	if (is_numeric($value) == true) $sql = $sql . $value . ',';
	elseif (isDate($value) == true) {
		$value = DateTime::createFromFormat('D M d Y', $value);
		$value = $value->format('Y-m-d');
		$sql = $sql . $value . ','; 
	}
	elseif (is_string($value) == true) $sql = $sql . '\''. $value . '\'' . ',';
}	

$sql = substr($sql, 0, -1) . ');';

echo $sql;

/*for ($listOfInput as $value) {
	if is_string($value) == true
}*/
$servername = "localhost";
$username = "root";
$dbname = "cs 375";

// Create connection
$conn = new mysqli($servername, $username, NULL, $dbname);
# Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

/*$sql = "INSERT INTO study (StudyName, Description, StartDate, EndDate, Password, MultiTestingSupport, ExpectedPointValue, ExpectedTimeInMinutes, Lab2, Lab3, Lab4, Lab5, Lab6, Lab7)
VALUES ('The Effect of Sleep Deprivation on Reflexes In Young Adults', 'Come in, tell us how much sleep you have had during the last three nights, take a reflex test using flashing lights', 2018-01-01, 2018-12-31, 'LeftRightCenter', 1, 1, 15, 0, 0, 1, 1, 1, 1)";*/

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
 </body>
</html>