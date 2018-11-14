<?php
	include("connection.php");
	SESSION_START();
	
	echo $SearchUsers = $_POST['txtSearchUsers'];
	echo $SessionID = $_SESSION['UserID'];
	
	$query = "SELECT * FROM tblUsers WHERE UserID LIKE '%$SearchUsers' || Lastname LIKE '%$SearchUsers' || Firstname LIKE '%$SearchUsers' || Gender LIKE '%$SearchUsers' || EmailAdd LIKE '%$SearchUsers' || PhoneNumber LIKE '%$SearchUsers' || Type LIKE '%$SearchUsers';";
	$run = mysqli_query($con, $query);
		
	if($run){
		while($list = mysqli_fetch_assoc($run)){
			echo $list['UserID'];
		}
	}
	
	else{
		echo "paita";
	}
?>
	
	