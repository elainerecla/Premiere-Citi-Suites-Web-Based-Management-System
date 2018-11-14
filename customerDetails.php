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
			
			if(isset($_POST['btnCancelReserve'])){?>
				<script>
					alert("lalalalalalaljhklsdfjkl");
				</script><?php
			}
		?>
		<script>
			var timer = setInterval(function(){MyTimer()}, 1000);
			
			function MyTimer(){
				var Time = new Date();
				document.getElementById("displayDate").innerHTML = Time.toLocaleDateString();
				document.getElementById("displayTime").innerHTML = Time.toLocaleTimeString();
			};
			
			function generateChange(){
				var balance = document.getElementById('txtBalance').value;
				var cash = document.getElementById('txtCashHand').value;
				var change = parseFloat(cash) - parseFloat(balance);
							
				if(change >= 0){
					txtChange.value = change.toFixed(2);
				}
				
				else{
					txtChange.value = "";
				}
			}
		</script>
		
		<style>
			.selectedRow{
				background-color: #edebeb;
			}
		</style>
	</head>
    <body>
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
						window.location.href = "roomStatus.php";
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
			
			if(isset($_POST['btnStartCheckIn'])){
				$dateToday = date("Y-m-d");
				$CustomerID = $_POST['txtCustomerID'];
				
				$query = "UPDATE tblCustomers SET Status = 'Fully paid' WHERE CustomerID = '$CustomerID' AND CheckInDate = '$dateToday';";
				$run1 = mysqli_query($con, $query);
				
				$query = "UPDATE tblRoomStatus SET TimeIn = (CURTIME()), TimeOut = (CURTIME()), Status = 'Occupied' WHERE CustomerID = '$CustomerID' AND CheckIn = '$dateToday';";
				$run2 = mysqli_query($con, $query);?>
				
				<script type = "text/javascript">
					alert("The check in time start for <?php echo $CustomerID?>, thank you!");
				</script><?php
				header("location: bookedCustomers.php");
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
						}?>
						
						<li><a href="managementRoom.php" class = "dropdown-toggle" data-toggle = "dropdown">Room</a></li>
												
                        <li class = "active"><a href="#" class = "dropdown-toggle" data-toggle = "dropdown">Guests <span class = "caret"></span></a>
							<ul class = "dropdown-menu">
								<li><a href = "bookedCustomers.php"> Booked Customers</a></li>
								<li><a href = "#"> Cancelled Reservations</a></li>
							</ul>
						</li><?php
						if($_SESSION['Category'] != "Front Desk" || $_SESSION['Type'] == "Admin" || $_SESSION['Type'] == "Manager"){?>
							<li><a href="#" class = "dropdown-toggle" data-toggle = "dropdown">Services <span class = "caret"></span></a>
								<ul class = "dropdown-menu"><?php
									if($_SESSION['Type'] == "Admin"){?>
										<li><a href = "menusCoffee.php"> Coffee Shop</a></li><?php
									}
									
									if($_SESSION['Type'] == "Manager"){?>
										<li><a href = "menusCoffee.php"> Coffee Shop</a></li><?php
									}
									
									if($_SESSION['Type'] == "Staff"){?>
										<li><a href = "billingCoffee.php"> Coffee Shop</a></li><?php
									}?>
								</ul>
							</li><?php
						}?>
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
			</br></br>
			<?php
				$CustomerID = $_POST['txtHiddenCustID'];
				$query = "SELECT * FROM tblCustomers WHERE CustomerID = '$CustomerID';";
				$run = mysqli_query($con, $query);
				
				$data = mysqli_fetch_assoc($run);
			?></br>
			<div class = "col-sm-7"><?php
				$CheckIn = strtotime($data['CheckInDate']);
				$CheckOut = strtotime($data['CheckOutDate']);?>
				<b class = "col-sm-6" style = "text-align: left">Arrival Date: <?php echo date("M j, Y", $CheckIn);?></b>
				<b class = "col-sm-6" style = "text-align: left">Departure Date: <?php echo date("M j, Y", $CheckOut);?></b>
			</div>
			
			<a href = "bookedCustomers.php" class = "btn btn-default pull-right"><span class = "glyphicon glyphicon-arrow-left"></span> Back to previous page</a></br>
			</br>
			
			<div class = "panel panel-default">
				<div class = "panel-body">
					<div class = "col-sm-6">
						<form class = "form-horizontal"></br>
							<div class = "col-sm-12">
								<b style = "font-size: 18px;">Booked by:</b>
								
								<div class = "form-group"></br>
									<label class = "col-sm-4 control-label">Customer ID:</label>
									<div class = "col-sm-8">
										<input class = "form-control" name = "txtCustID" type = "text" value = "<?php echo $data['CustomerID']; ?>" readonly required>
									</div>
								</div>
								
								<div class = "form-group">
									<label class = "col-sm-4 control-label">Lastname:</label>
									<div class = "col-sm-8">
										<input class = "form-control" name = "txtLastName" type = "text" value = "<?php echo $data['Lastname']?>" readonly required>
									</div>
								</div>
								
								<div class = "form-group">
									<label class = "col-sm-4 control-label">Firstname:</label>
									<div class = "col-sm-8">
										<input class = "form-control" name = "txtFirstName" type = "text" value = "<?php echo $data['Firstname']?>" readonly required>
									</div>
								</div>
								
								<div class = "form-group">
									<label class = "col-sm-4 control-label">Gender:</label>
									<div class = "col-sm-4">
										<input class = "form-control" name = "txtGender" type = "text" value = "<?php echo $data['Gender']?>" readonly required>
									</div>
									
									<label class = "col-sm-1 control-label">Age:</label>
									<div class = "col-sm-3">
										<input class = "form-control" name = "txtAge" type = "number" value = "<?php echo $data['Age']?>" readonly required min = 18>
									</div>
								</div>
								
								<div class = "form-group">
									<label class = "col-sm-4 control-label">Email Add:</label>
									<div class = "col-sm-8">
										<input class = "form-control" name = "txtEmailAdd" type = "email" value = "<?php echo $data['EmailAdd']?>" readonly required>
									</div>
								</div>
								
								<div class = "form-group">
									<label class = "col-sm-4 control-label">Contact #:</label>
									<div class = "col-sm-8">
										<input class = "form-control" name = "txtContactNo" type = "text" value = "<?php echo $data['ContactNo']?>" readonly  required>
									</div>
								</div>
							</div>
							
							<div class = "col-sm-12"></br>
								<b class = "col-sm-12" style = "font-size: 18px;">Participants:</b></br></br>
								
								<div class = "form-group col-sm-12 pull-right">
									<div class = "col-sm-3">
										<label class = "col-sm-8 control-label" style = "text-align: left;">Children:</label>
									</div>
									<div class = "col-sm-5">
										<input class = "form-control" name = "txtCountChildren" id = "txtCountChildren" type = "number" value = "<?php echo $data['Children']?>" disabled  required min = 0>
									</div>
								</div>
								
								<div class = "form-group col-sm-12 pull-right">
									<div class = "col-sm-3">
										<label class = "col-sm-8 control-label" style = "text-align: left;">Adult:</label>
									</div>
									<div class = "col-sm-5">
										<input class = "form-control" name = "txtCountAdult" id = "txtCountAdult" type = "number" value = "<?php echo $data['Adult']?>" disabled required min = 0>
									</div></br></br>
								</div>
							</div>
						</form>
						
						<div class = "form-group pull-right"><?php
							$dateToday = date("Y-m-d");
							$CustomerID = $data['CustomerID'];
							
							$query = "SELECT * FROM tblCustomers WHERE CustomerID = '$CustomerID' AND CheckInDate = '$dateToday'";
							$run =	 mysqli_query($con, $query);
							$data = mysqli_fetch_assoc($run);
							
							$countRow = mysqli_num_rows($run);
							if($countRow == 0 || $data['Status'] == "Fully paid"){?>
								<button name = "btnPayment" class = "btn btn-success" data-toggle = "modal" data-target = "#BookPayment" disabled><span class = "glyphicon glyphicon-check"></span> Go to Payment</button><?php
							}
							
							else{?>
								<button name = "btnPayment" class = "btn btn-success" data-toggle = "modal" data-target = "#BookPayment"><span class = "glyphicon glyphicon-check"></span> Go to Payment</button><?php
							}?>
							
						</div>
					</div>
					<div class = "col-sm-6"><?php
						$CustomerID = $_POST['txtHiddenCustID'];
						$query = "SELECT * FROM tblCustomers WHERE CustomerID = '$CustomerID';";
						$run = mysqli_query($con, $query);
						$data = mysqli_fetch_assoc($run);
						$RmType = $data['RoomType'];
						
						$query = "SELECT * FROM tblRoomType WHERE Name = '$RmType';";
						$run = mysqli_query($con, $query);
						$dataRmType = mysqli_fetch_assoc($run);
						?>
						<div class = "col-sm-12">
							<img src = "<?php echo $dataRmType['ImageLink'];?>" class = "img-thumbnail">
						</div>
						
						<div class = "col-sm-12"></br>
							<form class = "form-horizontal">
								<center><b style = "font-size: 18px;"><?php echo $dataRmType['Name'];?></b></center></br>
								<form class = "form-group">
									<label class = "col-sm-9">Maximum number of person: </label><p><?php echo $dataRmType['MaxPerson'];?> person(s)</p>
								</form>
								</br>
								<form class = "form-group">
									<label class = "col-sm-12">Specification: </label></br><p class = "col-sm-12"><?php echo $dataRmType['Specification'];?></p>
									</br></br></br></br></br>
								</form>
								
								<form class = "form-group col-sm-9"><?php
									$RmRate = $dataRmType['Rate'];
									$RmCharge = $dataRmType['Charge'];?>
									
									<label class = "col-sm-8">Room Rate: </label>
									<span class = "label label-success">P <?php echo number_format($RmRate, 2)?></span>
										
									<label class = "col-sm-8">Extra person: </label>
									<span class = "label label-danger">P <?php echo number_format($RmCharge, 2)?></span>
								</form>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class = "modal fade" id = "BookPayment">
			<div class = "modal-dialog">
				<div class = "modal-content" style = "width: 85%; margin: 0 auto;">
					<div class = "modal-header">
						<b><span class = "glyphicon glyphicon-edit"></span> Booking Payment</b>
						<button type = "button" class = "close" data-dismiss = "modal">
							&times;
						</button>
					</div>
					
					<?php
						$AdditionalPayment = $data['AdditionalPayment'];
						$TotalPay = $data['TotalPayment'];
						$Downpay = $data['Downpayment'];
						$Balance = $TotalPay - $Downpay;
					?>
					<form class = "form-horizontal" method = "POST">
						<div class = "modal-body">
							<input type = "hidden" name = "txtCustomerID" value = "<?php echo $data['CustomerID'];?>">
							<div class = "form-group"></br>
								<label class = "col-sm-4 control-label">Room Rate:</label>
								<div class = "col-sm-3">
									<input class = "form-control" name = "txtRmRate" type = "text" value = "<?php echo number_format($RmRate, 2);?>" readonly  required>
								</div><?php
								
								$Days = ($CheckOut - $CheckIn)/(60*60*24);?>
								<label class = "col-sm-1 control-label">Days:</label>
								<div class = "col-sm-3">
									<input class = "form-control" name = "txtDays" type = "text" value = "<?php echo $Days;?>" readonly  required>
								</div>
							</div>
							
							<div class = "form-group">
								<label class = "col-sm-4 control-label">Charged:</label>
								<div class = "col-sm-7">
									<input class = "form-control" name = "txtCharged" type = "text" value = "<?php echo number_format($AdditionalPayment, 2);?>" readonly  required>
								</div>
							</div>
							</br>
							<div class = "form-group">
								<label class = "col-sm-4 control-label">Total Payment:</label>
								<div class = "col-sm-7">
									<input class = "form-control" name = "txtTotalPayment" type = "text" value = "<?php echo number_format($TotalPay, 2);?>" readonly  required>
								</div>
							</div>
							
							<div class = "form-group">
								<label class = "col-sm-4 control-label">Downpayment:</label>
								<div class = "col-sm-7"><?php
									$TotalPay = $data['TotalPayment'];?>
									<input class = "form-control" name = "txtDownPay" type = "text" value = "<?php echo number_format($Downpay, 2);?>" readonly  required>
								</div>
							</div>
							
							<div class = "form-group">
								<label class = "col-sm-4 control-label">Balance:</label>
								<div class = "col-sm-7">
									<input class = "form-control" name = "txtBalance" id = "txtBalance" type = "text" value = "<?php echo $Balance;?>" readonly  required>
								</div>
							</div>
							
							<div class = "form-group">
								<label class = "col-sm-4 control-label">Cash on hand:</label>
								<div class = "col-sm-7">
									<input class = "form-control" name = "txtCashHand" id = "txtCashHand" type = "text" onInput = "generateChange()" min = <?php echo $Balance;?> required>
								</div>
							</div>
							
							<div class = "form-group">
								<label class = "col-sm-4 control-label">Change:</label>
								<div class = "col-sm-7">
									<input class = "form-control" name = "txtChange" id = "txtChange" type = "text" readonly  required>
								</div>
							</div>
						</div>
						
						<div class = "modal-footer">
							<button class = "btn btn-success" name = "btnStartCheckIn">Start Check-in</button>
						</div>
					</form>
				</div>
			</div>
		</div>
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
								//if manager or staff ang session
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