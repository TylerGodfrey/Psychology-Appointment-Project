<html>
 <head>
  <title>PHP Test</title>
 </head>
<body>
<?php
include ("general_connection.php");

$procSub = new Connection();
$procSub->tableName = "experimenter availability";
$procSub->columnNames = ['StudyID', 'ExperimenterID', 'Date', 'StartTime',    															'EndTime'];
$procSub->getValues();
$procSub->createStatement();
$procSub->createConnection();
$procSub->submit();
$procSub->killConnection();

?>
</body>
</html>