<?php
$servername = "localhost";
$username = "root";
$password = "37ENa.AbcxyZ";
$databasename = "dbOnlineBookingSystem";

$con = mysqli_connect($servername, $username, $password, $databasename);

if ($con){

}

else {
	die ("Error, you are not connected!".mysqli_connect_error());
}
?>