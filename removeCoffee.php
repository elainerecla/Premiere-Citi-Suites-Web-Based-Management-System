<?php
	include("connection.php");
	
	$MenuName = $_POST['btnRemove'];
	$queryUpdate = "UPDATE tblMenus SET Status = 'not available' WHERE CoffeeName = '$MenuName';";
	$run = mysqli_query($con, $queryUpdate);
	
	?>
	<script type = "text/javascript">
		window.location.href = "removemenuCoffee.php";
	</script><?php
?>