<?php
	if(!empty($_POST['searchMenu'])){
		include ("connection.php");
		$searchMenu = $_POST['searchMenu'];
		$querySearchMenu = "SELECT DISTINCT CoffeeName FROM tblMenus WHERE CoffeeName LIKE '$searchMenu%' AND Status = 'available' ORDER BY CoffeeName ASC LIMIT 5;";
		$searchRes = mysqli_query($con, $querySearchMenu);
										
		if($searchRes){
			echo "Suggestions: ";
			while($result = mysqli_fetch_assoc($searchRes)){
				$MenuName = $result['CoffeeName'];
				echo "&nbsp;&nbsp; $MenuName &nbsp;";
			}
		}
	}
								
	else{
		echo "Suggestions:";
	}
?>