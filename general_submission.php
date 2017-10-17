<html>
 <head>
  <title>PHP Test</title>
 </head>
 <body>
 <?php
 class Submission {
	public $tableName;
	public $columnNames=array();
	public $columnValues=array();
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

		$this->sql = substr($this->sql, 0, -1);
		$this->sql = $this->sql . ") VALUES (";

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
		$this->conn->close();
		echo "Connection closed successfully.";
	}

	function submit () {
		if ($this->conn->query($this->sql) === TRUE) {
		    echo "New record created successfully";
		}
		else {
	    	echo "Error: " . $this->sql . "<br>" . $this->conn->error;
		}
	}

	function getBridge () {
		$this->inserted_id = $this->conn->insert_id;
		$this->bridge_values = $_GET[$this->bridgeName];
		$this->bridge_values = preg_split('/\|/', $this->bridge_values, -1, PREG_SPLIT_NO_EMPTY);
	}

	function submitBridge () {
		foreach ($this->bridge_values as $value) {
			$this->sql = "INSERT INTO `$this->tableName` ($this->idName, $this->bridgeName) VALUES ($this->inserted_id,'" . $value . "');";
			$this->submit();
		}
	}
}
?>
</body>
</html>