<html>
 <head>
  <title>PHP Test</title>
 </head>
 <body>
 <?php


include ("general_connection.php");

$studySub = new Connection();
$studySub->tableName = "study";
$studySub->columnNames = ['StudyName','Password','Description','StartDate','EndDate','ExpectedPointValue','ExpectedTimeInMinutes','MultiTestingSupport'];
$studySub->getValues();
$studySub->createInsertStatement();
$studySub->createConnection();
$studySub->submit();
$studySub->getInsertedId();
$studySub->tableName = "class study pairings";
$studySub->bridgeName = "ClassID";
$studySub->idName = "StudyId";
$studySub->getBridge();
$studySub->submitBridge();
$studySub->tableName = "study lab pairings";
$studySub->bridgeName = "RoomID";
$studySub->idName = "StudyId";
$studySub->getBridge();
$studySub->submitBridge();
$studySub->closeConnection();


/*	function isDate($value) {// https://stackoverflow.com/questions/11029769/function-to-check-if-a-string-is-a-date

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

$inputs = array();
$listOfInputs = ['StudyName', 'Password', 'Description', 'StartDate', 'EndDate', 'ExpectedPointValue', 'ExpectedTimeInMinutes', 'MultiTestingSupport', 'Lab2', 'Lab3', 'Lab4', 'Lab5', 'Lab6', 'Lab7'];
foreach ($listOfInputs as $value) {
	array_push($inputs, $_GET[$value]);
}
$classes = $_GET['ClassesAvailable'];
$classes = preg_split('/\|/', $classes, -1, PREG_SPLIT_NO_EMPTY);
$tableName = 'study';

$sql = "INSERT INTO `$tableName` (";
foreach ($listOfInputs as $name) {
	$sql = $sql . $name . ',';
}

$sql = substr($sql, 0, -1) . ") VALUES (";

foreach ($inputs as $value)  {
	if (is_numeric($value) == true) $sql = $sql . $value;
	elseif (isDate($value) == true) {
		$value = DateTime::createFromFormat('D M d Y', $value);
		$value = $value->format('Y-m-d');
		$sql = $sql . $value;
	}
	elseif (is_string($value) == true) $sql = $sql . '\''. $value . '\'';
	$sql = $sql . ",";
}

$sql = substr($sql, 0, -1) . ");";

$servername = "localhost";
$username = "root";
$dbname = "cs 375";

// Create connection
$conn = new mysqli($servername, $username, NULL, $dbname);
# Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

if ($conn->query($sql) === TRUE) {
    echo "New study record created successfully";
    $studyid = $conn->insert_id;
    $tableName = 'class study pairings';
    $listOfInputs = ['StudyId', 'ClassCode'];
    foreach ($classes as $class) {
    	$sql = "INSERT INTO `class study pairings` (";
    	foreach ($listOfInputs as $value) {
    		$sql = $sql . $value . ',';
    	}
    	$sql = substr($sql, 0, -1) . ") VALUES ($studyid, '$class');";
    	    if ($conn->query($sql) === TRUE) {
    			echo "New study class pairing record created successfully";
    		}
    		else {
    			echo "Error: " . $sql . "<br>" . $conn->error;
    	}
    }
    //echo count($classes);
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
*/
?>
 </body>
</html>