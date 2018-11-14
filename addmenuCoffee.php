<!DOCTYPE html>
<html>
    <head>
		<title>Premiere Citi Suites</title>
		
		<meta name="viewport" content="width=device-width, initial-scale: 1.0"/>
        
		<script type="text/javascript" src="Resources/JQUERY/jquery 1.9.1/jquery.js"></script>
		<script type="text/javascript" src="Resources/jquery-ui-1.9.1/jquery-1.8.2.js"></script>
		<script type="text/javascript" src="Resources/bootstrap-3.3.5-dist/js/bootstrap.js"></script>
		<script type="text/javascript" src="Resources/JQUERY/jquery 1.9.1/jquery.min.js"></script>
		<script type="text/javascript" src="Resources/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
		<link type="text/css" rel="stylesheet" href="Resources/bootstrap-3.3.5-dist/css/bootstrap.css"/>
        <link type="text/css" rel="stylesheet" href="Resources/bootstrap-3.3.5-dist/css/bootstrap.min.css"/>
        <link type="text/css" rel="stylesheet" href="Resources/bootstrap-3.3.5-dist/css/style.css"/>
		<script type = "text/javascript"></script>
		
		<?php
			SESSION_START();
			if(!isset($_SESSION['UserID']) &&!isset($_SESSION['Firstname'])){
				header("location:login.php");
			}
			
			else{
				include("connection.php");
				$UserID = $_SESSION['UserID'];
				$Firstname = $_SESSION['Firstname'];
				
				$queryType = "SELECT * FROM tblUsers WHERE UserID = '$UserID';";
				$result = mysqli_query($con, $queryType);
					
				if($result){
					while($list = mysqli_fetch_assoc($result))
					{
						$SessionUID = $list['UserID'];
						$SessionPass = $list['Password'];
						$SessionLastname = $list['Lastname'];
						$SessionFirstname = $list['Firstname'];
						$SessionGender = $list['Gender'];
						$SessionEmailAdd = $list['EmailAdd'];
						$SessionPhoneNumber = $list['PhoneNumber'];
						$SessionType = $list['Type'];
						$SessionCategory = $list['Category'];
						$SessionStatus = $list['Status'];
					}
				}
					
				else{
					 "Error";
				}
			}
		?>
		
		<?php
			if(isset($_POST['btnUpdateProfile'])){
				include("connection.php");
				$UID = $_POST['txtUpdateUserID'];
				$Email = $_POST['txtUpdateEmail'];
				$PhoneNumber = $_POST['txtUpdatePhone'];
					
				$query = "UPDATE tblUsers SET EmailAdd = '$Email', PhoneNumber = '$PhoneNumber' WHERE UserID = '$UID';";
				$result = mysqli_query($con, $query);

				if($result){?>
					<script type = "text/javascript">
						alert("Successfully updated!");
						window.location.href = "addmenuCoffee.php";
					</script><?php
				}
				
				else{
					echo "Error!!!";
				}
			}
			
			if(isset($_POST['btnChangePass'])){
				include("connection.php");
				$UID = $_POST['txtSessionUID'];
				$Password = $_POST['txtSessionPass'];
				$OldPass = md5($_POST['txtOldPass']);
				$NewPass = $_POST['txtNewPass'];
				$ConPass = $_POST['txtConPass'];

				if($Password == $OldPass && $NewPass == $ConPass){
					$query = "UPDATE tblUsers SET Password = '".md5($NewPass)."' WHERE UserID = '$UID';";
					$result = mysqli_query($con, $query);

					if($result){?>
						<script type = "text/javascript">
							alert("Password changed!");
						</script><?php
					}
						
					else{
						echo "Error!";
					}
				}
				
				else{?>
					<script type = "text/javascript">
						alert("Error, Password mismatch!");
					</script><?php
				}
			}
		?>
		
		<script>
			var timer = setInterval(function(){MyTimer()}, 1000);
			
			function MyTimer(){
				var Time = new Date();
				document.getElementById("displayDate").innerHTML = Time.toLocaleDateString();
				document.getElementById("displayTime").innerHTML = Time.toLocaleTimeString();
			};
			
			$(function(){
				$('#chkRegular').click(function(){
					if(document.getElementById("chkRegular").checked == true){
						document.getElementById("txtRegularPrice").disabled = false;
					}
					
					else{
						document.getElementById("txtRegularPrice").disabled = true;
						txtRegularPrice.value = "";
						txtSmallPrice.value = "";
						txtMediumPrice.value = "";
						txtLargePrice.value = "";
						txtXlargePrice.value = "";
					}
				});
			});
			
			function generatePrice(){
				var reg = document.getElementById("txtRegularPrice").value;
				if(parseInt(reg) <= 42 || reg == ""){
					document.getElementById("chkSmall").disabled = true;
					document.getElementById("chkMedium").disabled = true;
					document.getElementById("chkLarge").disabled = true;
					document.getElementById("chkXlarge").disabled = true;
					
					txtSmallPrice.value = "";
					txtMediumPrice.value = "";
					txtLargePrice.value = "";
					txtXlargePrice.value = "";
					
					document.getElementById("chkSmall").checked = false;
					document.getElementById("chkMedium").checked = false;
					document.getElementById("chkLarge").checked = false;
					document.getElementById("chkXlarge").checked = false;
				}
				
				else{
					var small = reg - (parseInt(reg) * .30);
					if(small < 30){
						//nothing to do...
					}
					
					else{
						var medium = parseInt(reg) + (parseInt(reg) * .40);
						var large = parseInt(medium) + (parseInt(reg) * .40);
						var xlarge = parseInt(large) + (parseInt(reg) * .40);
							
						document.getElementById("txtSmallPrice").value = small;
						document.getElementById("txtMediumPrice").value = medium;
						document.getElementById("txtLargePrice").value = large;
						document.getElementById("txtXlargePrice").value = xlarge;
							
						document.getElementById("chkSmall").disabled = false;
						document.getElementById("chkMedium").disabled = false;
						document.getElementById("chkLarge").disabled = false;
						document.getElementById("chkXlarge").disabled = false;
					}
				}
			};
		</script>
	</head>
    <body>
		<?php
			include("connection.php");
			if(isset($_POST['btnSaveMenu'])){
				$MenuName = $_POST['txtCoffeeName'];
				$query = "SELECT * FROM tblMenus WHERE CoffeeName = '$MenuName';";
				$resSelect = mysqli_query($con, $query);

				if(mysqli_num_rows($resSelect) == 0){
					$querySelectMID = "SELECT DISTINCT MenuID FROM tblMenus;";
					$res = mysqli_query($con, $querySelectMID);
					$MenuID = mysqli_num_rows($res) + 1;
				
					if(isset($_POST['chkRegular'])){
						$RegPrice = $_POST['txtRegularPrice'];
							if($MenuID >=1){
								if($MenuID >= 1 && $MenuID < 10){
									$queryInsert = "INSERT INTO tblMenus (MenuID, CoffeeName, Size, Price, Status) VALUES ('MID-00$MenuID', '$MenuName', 'regular', '$RegPrice', 'available');";
									$resIns = mysqli_query($con, $queryInsert);	
								}
								
								else if($MenuID >= 10 && $MenuID < 100){
									$queryInsert = "INSERT INTO tblMenus (MenuID, CoffeeName, Size, Price, Status) VALUES ('MID-0$MenuID', '$MenuName', 'regular', '$RegPrice', 'available');";
									$resIns = mysqli_query($con, $queryInsert);	
								}
									
								else{
									$queryInsert = "INSERT INTO tblMenus (MenuID, CoffeeName, Size, Price, Status) VALUES ('MID-$MenuID', '$MenuName', 'regular', '$RegPrice', 'available');";
									$resIns = mysqli_query($con, $queryInsert);	
								}
							}
					}
						
					if(isset($_POST['chkSmall'])){
						$SmPrice = $_POST['txtSmallPrice'];	
							
						if($MenuID >=1){
							if($MenuID >= 1 && $MenuID < 10){
								$queryInsert = "INSERT INTO tblMenus (MenuID, CoffeeName, Size, Price, Status) VALUES ('MID-00$MenuID', '$MenuName', 'small', '$SmPrice', 'available');";
								$resIns = mysqli_query($con, $queryInsert);	
							}
							
							else if($MenuID >= 10 && $MenuID < 100){
								$queryInsert = "INSERT INTO tblMenus (MenuID, CoffeeName, Size, Price, Status) VALUES ('MID-0$MenuID', '$MenuName', 'small', '$SmPrice', 'available');";
								$resIns = mysqli_query($con, $queryInsert);	
							}
							
							else{
								$queryInsert = "INSERT INTO tblMenus (MenuID, CoffeeName, Size, Price, Status) VALUES ('MID-$MenuID', '$MenuName', 'small', '$SmPrice', 'available');";
								$resIns = mysqli_query($con, $queryInsert);	
							}
						}
					}
						
					if(isset($_POST['chkMedium'])){
						$MedPrice = $_POST['txtMediumPrice'];	
							
						if($MenuID >=1){
							if($MenuID >= 1 && $MenuID < 10){
								$queryInsert = "INSERT INTO tblMenus (MenuID, CoffeeName, Size, Price, Status) VALUES ('MID-00$MenuID', '$MenuName', 'medium', '$MedPrice', 'available');";
								$resIns = mysqli_query($con, $queryInsert);	
							}
								
							else if($MenuID >= 10 && $MenuID < 100){
								$queryInsert = "INSERT INTO tblMenus (MenuID, CoffeeName, Size, Price, Status) VALUES ('MID-0$MenuID', '$MenuName', 'medium', '$MedPrice', 'available');";
								$resIns = mysqli_query($con, $queryInsert);	
							}
								
							else{
								$queryInsert = "INSERT INTO tblMenus (MenuID, CoffeeName, Size, Price, Status) VALUES ('MID-$MenuID', '$MenuName', 'medium', '$MedPrice', 'available');";
								$resIns = mysqli_query($con, $queryInsert);	
							}
						}
					}
						
					if(isset($_POST['chkLarge'])){
						$LrgPrice = $_POST['txtLargePrice'];	
							
						if($MenuID >=1){
							if($MenuID >= 1 && $MenuID < 10){
								$queryInsert = "INSERT INTO tblMenus (MenuID, CoffeeName, Size, Price, Status) VALUES ('MID-00$MenuID', '$MenuName', 'large', '$LrgPrice', 'available');";
								$resIns = mysqli_query($con, $queryInsert);	
							}
								
							else if($MenuID >= 10 && $MenuID < 100){
								$queryInsert = "INSERT INTO tblMenus (MenuID, CoffeeName, Size, Price, Status) VALUES ('MID-0$MenuID', '$MenuName', 'large', '$LrgPrice', 'available');";
								$resIns = mysqli_query($con, $queryInsert);	
							}
							
							else{
								$queryInsert = "INSERT INTO tblMenus (MenuID, CoffeeName, Size, Price, Status) VALUES ('MID-$MenuID', '$MenuName', 'large', '$LrgPrice', 'available');";
								$resIns = mysqli_query($con, $queryInsert);	
							}
						}
					}
					
					if(isset($_POST['chkXlarge'])){
						$XLPrice = $_POST['txtXlargePrice'];	
							
						if($MenuID >=1){
							if($MenuID >= 1 && $MenuID < 10){
								$queryInsert = "INSERT INTO tblMenus (MenuID, CoffeeName, Size, Price, Status) VALUES ('MID-00$MenuID', '$MenuName', 'xlarge', '$XLPrice', 'available');";
								$resIns = mysqli_query($con, $queryInsert);	
							}
								
							else if($MenuID >= 10 && $MenuID < 100){
								$queryInsert = "INSERT INTO tblMenus (MenuID, CoffeeName, Size, Price, Status) VALUES ('MID-0$MenuID', '$MenuName', 'xlarge', '$XLPrice', 'available');";
								$resIns = mysqli_query($con, $queryInsert);	
							}
								
							else{
								$queryInsert = "INSERT INTO tblMenus (MenuID, CoffeeName, Size, Price, Status) VALUES ('MID-$MenuID', '$MenuName', 'xlarge', '$XLPrice', 'available');";
								$resIns = mysqli_query($con, $queryInsert);	
							}
						}
					}
					
					if(isset($resIns)){?>
						<script type="text/javascript">
							alert("Menu has been successfully added to the database!");
						</script><?php
					}
				}
					
				else{
					$queryUpdateAvailability = "SELECT MenuID FROM tblMenus WHERE CoffeeName = '$MenuName' AND Status = 'not available';";
					$runUpdate = mysqli_query($con, $queryUpdateAvailability);
						
					if(mysqli_num_rows($runUpdate) == 0){?>
						<script type="text/javascript">
							alert("Error, Menu already exist, please try to input a new entry!");
						</script><?php
					}
						
					else{
						$result = mysqli_fetch_assoc($runUpdate);
						$id = $result['MenuID'];
						$queryUpdateStatus = "UPDATE tblMenus SET Status = 'available' WHERE MenuID = '$id' AND Status = 'not available';";
						$run = mysqli_query($con, $queryUpdateStatus);
							
						if(isset($_POST['chkRegular'])){
							$regPrice = $_POST['txtRegularPrice'];
							$queUpdate = "UPDATE tblMenus SET Price = '$regPrice' WHERE Size = 'regular' AND MenuID = '$id';";
							$run = mysqli_query($con, $queUpdate);
						}
							
						if(isset($_POST['chkSmall']) || !isset($_POST['chkSmall'])){
							if(isset($_POST['chkSmall'])){
								$smPrice = $_POST['txtSmallPrice'];
								$selSmall = "SELECT Size FROM tblMenus WHERE Size = 'small' AND MenuID = '$id';";
								$run = mysqli_query($con, $selSmall);
									
								if(mysqli_num_rows($run) == 0){
									$queIns = "INSERT INTO tblMenus(MenuID, CoffeeName, Size, Price, Status) VALUES('$id', '$MenuName', 'small', '$smPrice', 'available');";
									$run = mysqli_query($con, $queIns);
								}
									
								else{
									$queUpdate = "UPDATE tblMenus SET Price = '$smPrice' WHERE Size = 'small' AND MenuID = '$id';";
									$run = mysqli_query($con, $queUpdate);
								}
							}
								
							else{
								$selSmall = "SELECT Size FROM tblMenus WHERE Size = 'small' AND MenuID = '$id';";
								$run = mysqli_query($con, $selSmall);
									
								if(mysqli_num_rows($run) > 0){
									$queDel = "DELETE FROM tblMenus WHERE MenuID = '$id' AND Size = 'small' AND Status = 'available';";
									$run = mysqli_query($con, $queDel);
								}
							}
						}
							
						if(isset($_POST['chkMedium']) || !isset($_POST['chkMedium'])){
							if(isset($_POST['chkMedium'])){
								$medPrice = $_POST['txtMediumPrice'];
								$selMed = "SELECT Size FROM tblMenus WHERE Size = 'medium' AND MenuID = '$id';";
								$run = mysqli_query($con, $selMed);
									
								if(mysqli_num_rows($run) == 0){
									$queIns = "INSERT INTO tblMenus(MenuID, CoffeeName, Size, Price, Status) VALUES('$id', '$MenuName', 'medium', '$medPrice', 'available');";
									$run = mysqli_query($con, $queIns);
								}
									
								else{
									$queUpdate = "UPDATE tblMenus SET Price = '$medPrice' WHERE Size = 'medium' AND MenuID = '$id';";
									$run = mysqli_query($con, $queUpdate);
								}
							}
								
							else{
								$selMed = "SELECT Size FROM tblMenus WHERE Size = 'medium' AND MenuID = '$id';";
								$run = mysqli_query($con, $selMed);
									
								if(mysqli_num_rows($run) > 0){
									$queDel = "DELETE FROM tblMenus WHERE MenuID = '$id' AND Size = 'medium' AND Status = 'available';";
									$run = mysqli_query($con, $queDel);
								}
							}
						}
							
						if(isset($_POST['chkLarge']) || !isset($_POST['chkLarge'])){
							if(isset($_POST['chkLarge'])){
								$largePrice = $_POST['txtLargePrice'];
								$selLarge = "SELECT Size FROM tblMenus WHERE Size = 'large' AND MenuID = '$id';";
								$run = mysqli_query($con, $selLarge);
									
								if(mysqli_num_rows($run) == 0){
									$queIns = "INSERT INTO tblMenus(MenuID, CoffeeName, Size, Price, Status) VALUES('$id', '$MenuName', 'large', '$largePrice', 'available');";
									$run = mysqli_query($con, $queIns);
								}
								
								else{
									$queUpdate = "UPDATE tblMenus SET Price = '$largePrice' WHERE Size = 'large' AND MenuID = '$id';";
									$run = mysqli_query($con, $queUpdate);
								}
							}
								
							else{
								$selLarge = "SELECT Size FROM tblMenus WHERE Size = 'large' AND MenuID = '$id';";
								$run = mysqli_query($con, $selLarge);
									
								if(mysqli_num_rows($run) > 0){
									$queDel = "DELETE FROM tblMenus WHERE MenuID = '$id' AND Size = 'large' AND Status = 'available';";
									$run = mysqli_query($con, $queDel);
								}
							}
						}
							
						if(isset($_POST['chkXlarge']) || !isset($_POST['chkXlarge'])){
							if(isset($_POST['chkXlarge'])){
								$xlPrice = $_POST['txtXlargePrice'];
								$selXLarge = "SELECT Size FROM tblMenus WHERE Size = 'xlarge' AND MenuID = '$id';";
								$run = mysqli_query($con, $selXLarge);
									
								if(mysqli_num_rows($run) == 0){
									$queIns = "INSERT INTO tblMenus(MenuID, CoffeeName, Size, Price, Status) VALUES('$id', '$MenuName', 'xlarge', '$xlPrice', 'available');";
									$run = mysqli_query($con, $queIns);
								}
									
								else{
									$queUpdate = "UPDATE tblMenus SET Price = '$xlPrice' WHERE Size = 'xlarge' AND MenuID = '$id';";
									$run = mysqli_query($con, $queUpdate);
								}
							}
								
							else{
								$selXLarge = "SELECT Size FROM tblMenus WHERE Size = 'xlarge' AND MenuID = '$id';";
								$run = mysqli_query($con, $selXLarge);
									
								if(mysqli_num_rows($run) > 0){
									$queDel = "DELETE FROM tblMenus WHERE MenuID = '$id' AND Size = 'xlarge' AND Status = 'available';";
									$run = mysqli_query($con, $queDel);
								}
							}
						}
					}
				}
			}
		?>
        <!--navbar start-->
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-brand">
                    <img src = "Resources/images/jpg/premiere logo.jpg" class = "img-thumbnail">
                </div>
                
                <div class="navbar-toggle" data-toggle="collapse" data-target=".navCollapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </div>
                
                <div class="collapse navbar-collapse navCollapse">
                    <div class="nav navbar-nav navbar-right">
                        <?php
						if ($_SESSION['Type'] == "Admin"){?>
							<li><a href="adminpage.php">Home</a></li><?php
						}
						
						else if ($_SESSION['Type'] == "Manager"){?>
							<li><a href="managerpage.php">Home</a></li><?php
						}
						
						else{?>
							<li><a href="staffpage.php">Home</a></li><?php
						}
						
						if($_SESSION['Type'] == "Admin"){?>
							<li><a href="managementRoom.php">Room</a></li><?php
						}
						
						if($_SESSION['Type'] == "Manager"){?>
							<li><a href="roomStatus.php">Room</a></li><?php
						}
						
						if($_SESSION['Type'] == "Staff"){?>
							<li><a href="roomStatus.php">Room</a></li><?php
						}?>
						
                        <li><a href="#" class = "dropdown-toggle" data-toggle = "dropdown">Guests <span class = "caret"></span></a>
							<ul class = "dropdown-menu">
								<li><a href = "bookedCustomers.php"> Booked Customers</a></li>
								<li><a href = "#"> Cancelled Reservations</a></li>
							</ul>
						</li>
                        <li class = "active"><a href="#" class = "dropdown-toggle" data-toggle = "dropdown">Services <span class = "caret"></span></a>
							<ul class = "dropdown-menu">
								<li><a href = "billingCoffee.php"> Coffee Shop</a></li>
							</ul>
						</li>
                        <li><a href="#">Revenues</a></li>
                        <li><a href="#" class = "dropdown-toggle" data-toggle = "dropdown"><span class = "glyphicon glyphicon-user"></span> Hi, <?php echo $SessionFirstname ?> !<span class = "caret"></span></a>
							<ul class = "dropdown-menu"><?php
								if ($_SESSION['Type'] == "Admin" || $_SESSION['Type'] == "Manager"){?>
									<li><a href = "manageaccounts.php"><span class = "glyphicon glyphicon-user"></span> Manage Accounts</a></li><?php
								}?>
								<li><a href = "#EditProfile" data-toggle = "modal"><span class = "glyphicon glyphicon-list-alt"></span> Edit Profile</a></li>
								<li><a href = "#ChangePass" data-toggle = "modal"><span class = "glyphicon glyphicon-lock"></span> Change Password</a></li>
								<li class = "divider"></li>
								<li><a href = "logout.php"><span class = "glyphicon glyphicon-off"></span> Logout</a></li>
							</ul>
						</li>
                    </div>
                </div>
            </div>
        </div>
        <!--navbar end-->
        
        <!--body start-->
		</br></br></br></br>
		<div class = "container">
			<b><p class = "col-sm-4" style = "text-align: right">Current Time:</p></b>
			<i><p class = "col-sm-1" id = "displayDate"></p>
			<p class = "col-sm-2" id = "displayTime"></p></i>
			<!--Menus Coffee-->
				<ul class = "nav nav-tabs">
					<li class = "pull-right"><a href = "reportsCoffee.php">Reports</a></li>
					<li class = "pull-right"><a href = "billingCoffee.php">Billing</a></li>	
					<li class = "active pull-right"><a href = "menusCoffee.php">Menus</a></li>	
				</ul>
				</br>
				
				<ul class = "nav nav-pills col-sm-3"></br></br>
					<li class = "col-sm-12 pull-left active"><a href = "addmenuCoffee.php"><span class = "glyphicon glyphicon-plus"></span> Add Menu</a></li>
					<li class = "col-sm-12 pull-left"><a href = "updatemenuCoffee.php"><span class = "glyphicon glyphicon-edit"></span> Update Menu</a></li>
					<li class = "col-sm-12 pull-left"><a href = "removemenuCoffee.php"><span class = "glyphicon glyphicon-trash"></span> Remove Menu</a></li>
				</ul>
				
				<div class = "col-sm-9 panel panel-default">
					<div class = "panel-body" style = "height: 350px;"></br>
						<div id = "collapseAddMenu">
							<form class = "form-horizontal" method = "POST">
								<div class = "col-sm-12">
									<div class = "form-group">
										<label class = "col-sm-4 control-label">Menu Name:</label>
										<div class = "col-sm-6">
											<input name = "txtCoffeeName" id = "txtCoffeeName" type = "text" class = "form-control" required></br>
										</div>
									</div>
								</div>
								
								<div class = "col-sm-6">
									<div class = "form-group">
										<div class = "col-sm-7">
											<label class = "col-sm-5 control-label">Sizes:</label>
											<input class = "col-sm-2 control-label" id = "chkRegular" name = "chkRegular" type = "checkbox" value = "regular" required> Regular
										</div>
										
										<div class = "col-sm-5">
											<input id = "txtRegularPrice" name = "txtRegularPrice" class = "col-sm-12" type = "number" min = 43 onInput = "generatePrice()" disabled required>
										</div>
									</div>
									
									<div class = "form-group">
										<div class = "col-sm-7">
											<div class = "col-sm-5"></div>
											<input class = "col-sm-2 control-label" id = "chkSmall" name = "chkSmall" type = "checkbox"  value = "small" disabled> Small
										</div>
										
										<div class = "col-sm-5">
											<input id = "txtSmallPrice" name = "txtSmallPrice" class = "col-sm-12" type = "text" readonly>
										</div>
									</div>
									
									<div class = "form-group">
										<div class = "col-sm-7">
											<div class = "col-sm-5"></div>
											<input class = "col-sm-2 control-label" id = "chkMedium" name = "chkMedium" type = "checkbox" value = "medium" disabled> Medium
										</div>
										
										<div class = "col-sm-5">
											<input id  = "txtMediumPrice" name = "txtMediumPrice" class = "col-sm-12" type = "text" readonly>
										</div>
									</div>
								</div>
								
								<div class = "col-sm-5">
									<div class = "form-group">
										<div class = "col-sm-6">
											<input class = "col-sm-4 control-label" id = "chkLarge" name = "chkLarge" type = "checkbox" value = "large" disabled> Large
										</div>
										
										<div class = "col-sm-6">
											<input id = "txtLargePrice" name = "txtLargePrice" class = "col-sm-12" type = "text" readonly>
										</div>
									</div>
									
									<div class = "form-group">
										<div class = "col-sm-6">
											<input class = "col-sm-4 control-label" id = "chkXlarge" name = "chkXlarge" type = "checkbox" value = "xlarge" disabled> Xtra Large
										</div>
										
										<div class = "col-sm-6">
											<input id = "txtXlargePrice" name = "txtXlargePrice" class = "col-sm-12" type = "text" readonly>
										</div>
									</div>
								</div>
								
								<div class = "col-sm-12">
									</br><center><i><p style = "color: red;">( Kindly mark <span class = "glyphicon glyphicon-check"></span> your preferred size)</p></i></center>
									<div class = "col-sm-2  pull-right">
										<button class = "btn btn-success" type = "submit" name = "btnSaveMenu">Save Menu</button>
									</div>
								</div>
						</div>
							</form>
						</div>	
					</div>
				</div>
			<!--Menus Coffee-->
		</div>
			
		<!--Add new size-->
			<div class = "modal fade" id = "AddNewSize">
				<div class = "modal-dialog" style = "width: 50%;">
					<div class = "modal-content">
						<div class = "modal-header">
							<button type = "button" class = "close" data-dismiss = "modal" id = "btnCloseAddSize">
								&times;
							</button></br>
						</div>
						<div class = "modal-body">
							<form class = "form-horizontal">
								<div class = "form-group">
									<label class = "label-control col-sm-4">Add new size:</label>
									<div class = "col-sm-6">
										<input type = "text" class = "form-control" name = "txtAddNewSize" id = "txtAddNewSize" required></input>
									</div>
									
									<button class = "btn btn-success" id = "btnAddNewSize" name = "btnAddNewSize">Add</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		<!--Add new size-->
			
		<!--Edit Profile-->
		<div class = "modal fade" id = "EditProfile">
			<div class = "modal-dialog">
				<div class = "modal-content">
					<div class = "modal-header">
						<b><span class = "glyphicon glyphicon-edit"></span> Edit Profile</b>
						<button type = "button" class = "close" data-dismiss = "modal">
							&times;
						</button>
					</div>
					
					<form class = "form-horizontal" method = "post">
						<div class = "modal-body">
							<?php
								//if manager ang session
								if($SessionType != "Admin"){?>
									<div class="form-group"></br>
										<label class="col-sm-4 control-label"> User ID: </label>
										<div class="col-sm-6">
											<input name="txtUpdateUserID" type="text" class="form-control" value = "<?php echo $SessionUID?>" readonly required>
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-4 control-label"> Lastname: </label>
										<div class="col-sm-6">
											<input name="txtUpdateLastname" type="text" class="form-control" value = "<?php echo $SessionLastname?>" readonly required>
										</div>
									</div>
										
									<div class="form-group">
										<label class="col-sm-4 control-label"> Firstname: </label>
										<div class="col-sm-6">
											<input name="txtUpdateFirstname" type="text" class="form-control" value = "<?php echo $SessionFirstname?>" readonly required>
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-4 control-label"> Gender: </label>
										<div class="col-sm-6">
											<?php
											if($SessionGender == "Male"){?>
												<input type = "radio" name = "rdbupdateGender" value = "Male" checked required>Male
												<input type = "radio" name = "rdbupdateGender" value = "Female" disabled required>Female<?php
											}
												
											else{?>
												<input type = "radio" name = "rdbupdateGender" value = "Male" disabled required>Male
												<input type = "radio" name = "rdbupdateGender" value = "Female" checked required>Female<?php
											}
											?>
										</div>
									</div>
										
									<div class="form-group">
										<label class="col-sm-4 control-label"> User Type: </label>
										<div class="col-sm-6">
											<input name = "cmbUpdateUserType" type = "text" class = "form-control" value = "<?php echo $SessionType?>" readonly>
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-4 control-label"> Category: </label>
										<div class="col-sm-6">
											<input name = "cmbUpdateCategory" type = "text" class = "form-control" value = "<?php echo $SessionCategory?>" readonly>
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-4 control-label"> Email Add: </label>
										<div class="col-sm-6">
											<input name="txtUpdateEmail" type="email" class="form-control" value = "<?php echo $SessionEmailAdd?>" required>
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-4 control-label"> Phone Number: </label>
										<div class="col-sm-6">
											<input name="txtUpdatePhone" type="text" class="form-control" value = "<?php echo $SessionPhoneNumber?>" required>
										</div>
									</div>
						<?php	}
								
								//if admin ang session...
								else{?>
									<div class="form-group"></br>
										<label class="col-sm-4 control-label"> User ID: </label>
										<div class="col-sm-6">
											<input name="txtUpdateUserID" type="text" class="form-control" value = "<?php echo $SessionUID?>" readonly required>
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-4 control-label"> Lastname: </label>
										<div class="col-sm-6">
											<input name="txtUpdateLastname" type="text" class="form-control" value = "<?php echo $SessionLastname?>" required>
										</div>
									</div>
										
									<div class="form-group">
										<label class="col-sm-4 control-label"> Firstname: </label>
										<div class="col-sm-6">
											<input name="txtUpdateFirstname" type="text" class="form-control" value = "<?php echo $SessionFirstname?>" required>
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-4 control-label"> Gender: </label>
										<div class="col-sm-6">
											<?php
											if($SessionGender == "Male"){?>
												<input type = "radio" name = "rdbupdateGender" value = "Male" checked = "checked" required>Male
												<input type = "radio" name = "rdbupdateGender" value = "Female" required>Female<?php
											}
											
											else{?>
												<input type = "radio" name = "rdbupdateGender" value = "Male" required>Male
												<input type = "radio" name = "rdbupdateGender" value = "Female" checked = "checked" required>Female<?php
											}
											?>
										</div>
									</div>
										<input name="cmbUpdateUserType" type="hidden" class="form-control" value = "<?php echo $SessionType?>" readonly required>
										
									<div class="form-group">
										<label class="col-sm-4 control-label"> Email Add: </label>
										<div class="col-sm-6">
											<input name="txtUpdateEmail" type="email" class="form-control" value = "<?php echo $SessionEmailAdd?>" required>
										</div>
									</div>
										
									<div class="form-group">
										<label class="col-sm-4 control-label"> Phone Number: </label>
										<div class="col-sm-6">
											<input name="txtUpdatePhone" type="text" class="form-control" value = "<?php echo $SessionPhoneNumber?>" required>
										</div>
									</div>
						<?php	}?>
							
						</div> <!--END: modal-body-->
					
						<div class = "modal-footer">
							<button type="submit" class="btn btn-success" id = "btnUpdateProfile" name = "btnUpdateProfile"> Update </button>
						</div> <!--END: modal-footer-->
					</form> <!--END: /form-->
				</div> <!--END: modal-content-->
			</div> <!--END: modal-dialog-->
		</div> <!--END: modal fade-->
		<!--Edit Profile-->
			
		<!--Change Password-->
		<center>
			<div class = "modal fade" id = "ChangePass">
				<div class = "modal-dialog">
					<div class = "modal-content" style = "width: 70%">
						<div class = "modal-header">
							<h4><b><span class = "glyphicon glyphicon-edit"></span> Update Password</b>
							<button type = "button" class = "close" data-dismiss = "modal">
								&times;
							</button></h4>
						</div>
							
						<form class = "form-horizontal" method = "post">
							<div class = "modal-body">
								<input name="txtSessionUID" type="hidden" class="form-control" value = "<?php echo $SessionUID?>">
								<input name="txtSessionPass" type="hidden" class="form-control" value = "<?php echo $SessionPass?>">
								
								<div class="form-group">
									<label class="col-sm-5 control-label">Old Password: </label>
									<div class="col-sm-6">
										<input name="txtOldPass" type="password" class="form-control" required>
									</div>
								</div>
										
								<div class="form-group">
									<label class="col-sm-5 control-label">New Password: </label>
									<div class="col-sm-6">
										<input name="txtNewPass" type="password" class="form-control" required>
									</div>
								</div>
											
								<div class="form-group">
									<label class="col-sm-5 control-label">Confirm Password: </label>
									<div class="col-sm-6">
										<input name="txtConPass" type="password" class="form-control" required>
									</div>
								</div>
							</div>
							
							<div class = "modal-footer">
								<button type="submit" class="btn btn-success" id = "btnChangePass" name = "btnChangePass"> Change Password</button>
							</div>
						</form>
					</div><!--END:MODAL CONTENT-->
				</div><!--END:MODAL DIALOG-->
			</div>
		</center><!--END:MODAL FADE-->
		<!--Change Password-->
        <!--body end-->
		
		<!--footer start-->
		<div class = "container">
			<div class="navbar" id  = "bgFooter"></br>
				<div class = "row">	
					<div class = "pull-left">
						<h5><em><b>Login as: <?php echo $SessionType?></b></h5></em>
					</div>
						
					<div class = "pull-right">
						<h5><em>&copy Premiere Citi Suites 2015</em></h5>
					</div>
				</div>
			</div>
		</div>
        <!--footer end-->
    </body>
</html>



