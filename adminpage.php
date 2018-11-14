<!doctype html>
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
		
		<script>
			var timer = setInterval(function(){MyTimer()}, 1000);
			
			function MyTimer(){
				var Time = new Date();
				document.getElementById("displayDate").innerHTML = Time.toLocaleDateString();
				document.getElementById("displayTime").innerHTML = Time.toLocaleTimeString();
			};
			
			function getType(){
				if(document.getElementById('cmbUserType').value == "Manager" || document.getElementById('cmbAccountUserType').value == "Manager" ){
					if(document.getElementById('cmbUserType').value == "Manager"){
						document.getElementById('cmbCategory').options[0].selected = true;
						document.getElementById('cmbCategory').options[1].disabled = true;
						document.getElementById('cmbCategory').options[2].disabled = true;
					}
					
					else{
						document.getElementById('cmbAccountCategory').options[0].selected = true;
						document.getElementById('cmbAccountCategory').options[1].disabled = true;
						document.getElementById('cmbAccountCategory').options[2].disabled = true;
					}
				}
				
				else{
					if(document.getElementById('cmbUserType').value == "Staff"){
						cmbCategory.value = "";
						document.getElementById('cmbCategory').options[0].disabled = true;
						document.getElementById('cmbCategory').options[1].disabled = false;
						document.getElementById('cmbCategory').options[2].disabled = false;
					}
					
					else{
						cmbAccountCategory.value = "";
						document.getElementById('cmbAccountCategory').options[0].disabled = true;
						document.getElementById('cmbAccountCategory').options[1].disabled = false;
						document.getElementById('cmbAccountCategory').options[2].disabled = false;
					}
				}
			}
		</script>
    </head>
	
    <body>
        <?php
			SESSION_START();
			include("connection.php");

			if(!empty($_SESSION['Type'])){
				if($_SESSION['Type'] == "Admin"){
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
								$SessionStatus = $list['Status'];
							}
						}
							
						else{
							echo "Error";
						}
				
			?>
			
			<?php
				if(isset($_POST['btnUpdateProfile'])){
					include("connection.php");
					$UID = $_POST['txtUpdateUserID'];
					$Lastname = $_POST['txtUpdateLastname'];
					$Firstname = $_POST['txtUpdateFirstname'];
					$UType = $_POST['cmbUpdateUserType'];
					$Gender = $_POST['rdbupdateGender'];
					$Email = $_POST['txtUpdateEmail'];
					$PhoneNumber = $_POST['txtUpdatePhone'];
					
					$query = "UPDATE tblUsers SET Lastname = '$Lastname', Firstname = '$Firstname', Type = '$UType', Gender = '$Gender', EmailAdd = '$Email', PhoneNumber = '$PhoneNumber' WHERE UserID = '$UID';";
					$result = mysqli_query($con, $query);

					if($result){?>
						<script type = "text/javascript">
							alert("Successfully updated!");
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
							<li class = "active"><a href="adminpage.php">Home</a></li>
							<li><a href="managementRoom.php">Room</a></li>
							
							<li><a href="#" class = "dropdown-toggle" data-toggle = "dropdown">Guests <span class = "caret"></span></a>
								<ul class = "dropdown-menu">
									<li><a href = "bookedCustomers.php"> Booked Customers</a></li>
									<li><a href = "#"> Cancelled Reservations</a></li>
								</ul>
							</li>
							<li><a href="#" class = "dropdown-toggle" data-toggle = "dropdown">Services <span class = "caret"></span></a>
								<ul class = "dropdown-menu">
									<li><a href = "menusCoffee.php"> Coffee Shop</a></li>
								</ul>
							</li>
							<li><a href="#">Revenues</a></li>
							<li><a href="#" class = "dropdown-toggle" data-toggle = "dropdown"><span class = "glyphicon glyphicon-user"></span> Hi, <?php echo $SessionFirstname ?> !<span class = "caret"></span></a>
								<ul class = "dropdown-menu">
									<li><a href = "manageaccounts.php"><span class = "glyphicon glyphicon-user"></span> Manage Accounts</a></li>
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
					<div class="navbar" id  = "bgFooter"></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br>
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
		<?php	}
					
				else if($_SESSION['Type'] == "Manager"){
					header("location: managerpage.php");
				}
					
				else{
					header("location: staffpage.php");
				}
			}
				
			else{
				header("location:login.php");
			}
		?>
    </body>
</html>

	



