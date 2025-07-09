<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<body>
<?php
include "DB_Functions.php";
	//creation data base ***************
	$dbc=connectServer('localhost','root','',1);	
	createDB($dbc,"Quizzify");
	mysqli_close($dbc); // Close the connection.
?>

</body>
</html>
