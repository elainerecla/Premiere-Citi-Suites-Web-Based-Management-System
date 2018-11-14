<?php
	include("connection.php");
	
	$Status = $_GET['status'];
	$UID = $_GET['userid'];
	
	if($Status == "d"){
		$query = "UPDATE tblUsers SET Status = 'a' WHERE UserID = '$UID';";
		$run = mysqli_query($con, $query);
		
		if($run){?>
			<script type="text/javascript">
				alert("The account has been activated!");
				window.location.href = "manageaccounts.php";
			</script><?php
		}
	}
	
	else{
		$query = "UPDATE tblUsers SET Status = 'd' WHERE UserID = '$UID';";
		$run = mysqli_query($con, $query);
		
		if($run){?>
			<script type="text/javascript">
				alert("The account has been deactivated!");
				window.location.href = "manageaccounts.php";
			</script><?php
		}
		
		else{
			echo "Error!";
		}
	}?>
	
	