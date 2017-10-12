<html>
 <head>
  <title>PHP Test</title>
 </head>
 <body>
 <?php
 	class Submission {
		private $tableName;
		private $columnNames=array();
		private $columnValues=array();
		private $sql;

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

		function getValues ($columnNames) {
			foreach ($columnNames as $value) {
				array_push($columnValues,$_GET['$value']);
			}
		}

		function createStatement ($tableName, $columnNames, $columnValues) {
			$sql = "INSERT INTO `$tableName` (";
			foreach ($columnNames as $name) {
				$sql = $sql . $name . ',';
			}

			$sql = substr($sql, 0, -1) . ") VALUES ("

			foreach ($columnValues as $value)  {
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
		}
	}
?>
</body>
</html>