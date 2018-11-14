<?php
	include("connection.php");
	
	$queryUpdate = "UPDATE tblPurchase SET DatePurchased = (CURDATE()), TimePurchased = (CURTIME()) WHERE DatePurchased = '0000-00-00' AND TimePurchased = '00:00:00';";
	$run = mysqli_query($con, $queryUpdate);
	?>
	<script type="text/javascript">
		alert("Successfully added to database, thank you!");
		window.location.href = "billingCoffee.php";
	</script><?php 
?>
	
	