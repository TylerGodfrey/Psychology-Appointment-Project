<html>
 <head>
  <title>PHP Test</title>
 </head>
 <body>
 <?php

 /*
 include ("general_submission.php");

$study_submission = new Submission();
$study_submission->set_tablename("study");
$study_submission->set_columnNames(['StudyName','Password','Description','StartDate','EndDate','ExpectedPointValue','ExpectedTimeInMinutes','MultiTestingSupport','Lab2','Lab3','Lab4','Lab5','Lab6','Lab7']);
$study_submission->getValues();
$study_submission->createStatement(); */
class Submission {
	public $tableName;
	public $columnNames=array([]);
	public $columnValues=array([]);
	public $sql;
	public $conn;

	function setTableName($name) {
		$tableName = $name;
	}

	function isDate($value) {/*https://stackoverflow.com/questions/11029769/function-to-check-if-a-string-is-a-date*/

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

	function getValues () {
		$colNames = $this->columnNames;
		$colVals = $this->columnValues;
		foreach ($colNames as $value) {
			array_push($colVals,$_GET[$value]);
		}
		$this->columnValues = $colVals;
	}

	function createStatement () {
		$this->sql = "INSERT INTO `$this->tableName` (";
		$colNames = $this->columnNames;
		foreach ($colNames as $name) {
			$this->sql = $this->sql . $name . ',';
		}

		$this->sql = substr($this->sql, 0, -1) . ") VALUES (";

		$colVals = $this->columnValues;
		foreach ($colVals as $value)  {
			if (is_numeric($value) == true) $this->sql = $this->sql . $value;
			elseif ($this->isDate($value) == true) {
				$value = DateTime::createFromFormat('D M d Y', $value);
				$value = $value->format('Y-m-d');
				$this->sql = $this->sql . $value;
			}
			elseif (is_string($value) == true) $this->sql = $this->sql . '\''. $value . '\'';
			$this->sql = $this->sql . ",";
		}

		$this->sql = substr($this->sql, 0, -1) . ");";
	}

	function createConnection () {
		$servername = "localhost";
		$username = "root";
		$dbname = "cs 375";

		// Create connection
		$this->conn = new mysqli($servername, $username, NULL, $dbname);
		# Check connection
		if ($this->conn->connect_error) {
		    die("Connection failed: " . $this->conn->connect_error);
		}
	}

	function killConnection () {
		$this->conn.close();
	}

	function submit () {
		if ($this->conn->query($this->sql) === TRUE) {
		    echo "New study record created successfully";
		}
		else {
	    	echo "Error: " . $this->sql . "<br>" . $this->conn->error;
		}
	}

}

$studySub = new Submission();
$studySub->tableName = "study";
$studySub->columnNames = ['StudyName','Password','Description','StartDate','EndDate','ExpectedPointValue','ExpectedTimeInMinutes','MultiTestingSupport','Lab2','Lab3','Lab4','Lab5','Lab6','Lab7'];
$studySub->getValues();
$studySub->createStatement();
echo $studySub->sql;
$studySub->createConnection();
$studySub->submit();
$studySub->killConnection();


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