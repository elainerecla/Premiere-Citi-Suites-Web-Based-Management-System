<?php 
	include("connection.php");
	SESSION_START();
?>

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
			
			function getRowVal(getIndex){
				var index = getIndex.rowIndex;
				var rowDatas = document.getElementById('tblAccounts').rows[index].cells;
				txtAccountUID.value = rowDatas[0].innerHTML;
				txtAccountLastname.value = rowDatas[1].innerHTML;
				txtAccountFirstname.value = rowDatas[2].innerHTML;
				var AccountGender = rowDatas[3].innerHTML;
				if(AccountGender == "Male"){
					document.getElementById("male").checked = true;
				}
				
				if(AccountGender == "Female"){
					document.getElementById("female").checked = true;
				}
				cmbAccountUserType.value = rowDatas[6].innerHTML;
				cmbAccountCategory.value = rowDatas[7].innerHTML;
			}
			
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
					echo "Error";
				}
			}
		?>
		
		<?php
			if(isset($_POST['btnUpdateProfile'])){
				$UID = $_POST['txtUpdateUserID'];
				$Lastname = $_POST['txtUpdateLastname'];
				$Firstname = $_POST['txtUpdateFirstname'];
				$UType = $_POST['cmbUpdateUserType'];
				$Category = $_POST['cmbUpdateCategory'];
				$Gender = $_POST['rdbupdateGender'];
				$Email = $_POST['txtUpdateEmail'];
				$PhoneNumber = $_POST['txtUpdatePhone'];
				
				$query = "UPDATE tblUsers SET Lastname = '$Lastname', Firstname = '$Firstname', Type = '$UType', Category = '$Category', Gender = '$Gender', EmailAdd = '$Email', PhoneNumber = '$PhoneNumber' WHERE UserID = '$UID';";
				$result = mysqli_query($con, $query);
				
				if($result){?>
					<script type = "text/javascript">
						alert("Successfully updated!");
					</script><?php
				}
					
				else{?>
					<script type = "text/javascript">
						alert("Something went wrong!");
					</script><?php
				}
			}
			
			if(isset($_POST['btnUpdateAccount'])){
				$UID = $_POST['txtAccountUID'];
				$Lname = $_POST['txtAccountLastname'];
				$Fname = $_POST['txtAccountFirstname'];
				$Gender = $_POST['rdbAccountGender'];
				$UType = $_POST['cmbAccountUserType'];
				$Category = $_POST['cmbAccountCategory'];
				
				$query = "UPDATE tblUsers SET Lastname = '$Lname', Firstname = '$Fname', Gender = '$Gender', Type = '$UType', Category = '$Category' WHERE UserID = '$UID';";
				$run = mysqli_query($con, $query);
				
				if($run){?>
					<script type = "text/javascript">
						alert("Successfully updated!");
					</script><?php
				}
					
				else{?>
					<script type = "text/javascript">
						alert("Something went wrong!");
					</script><?php
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
			
			if(isset($_POST['btnAddAccount'])){
				include("connection.php");
				$UID = $_POST['txtUserID'];
				$Password = $_POST['txtPassword'];
				$Lastname = $_POST['txtLastname'];
				$Firstname = $_POST['txtFirstname'];
				$Gender = $_POST['rdbGender'];
				$UType = $_POST['cmbUserType'];
				$Category = $_POST['cmbCategory'];
				
				$query = "INSERT INTO tblUsers (UserID, Password, Lastname, Firstname, Gender, Type, Category, Status) VALUES ('$UID', '".md5($Password)."', '$Lastname','$Firstname', '$Gender', '$UType', '$Category', 'a');";
				$result = mysqli_query($con, $query);
						
				if($result){?>
					<script type = "text/javascript">
						alert("Successfully added to the database!");
						window.location.href = 'manageaccounts.php';
					</script><?php
				}
						
				else{
					echo "Something went wrong!";
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
						
						if ($_SESSION['Type'] == "Manager"){?>
							<li><a href="managerpage.php">Home</a></li><?php
						}
						
						if($_SESSION['Type'] == "Admin"){?>
							<li><a href="managementRoom.php">Room</a></li><?php
						}
						
						if($_SESSION['Type'] == "Manager"){?>
							<li><a href="roomStatus.php">Room</a></li><?php
						}?>
						
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
                        <li class = "active"><a href="#" class = "dropdown-toggle" data-toggle = "dropdown"><span class = "glyphicon glyphicon-user"></span> Hi, <?php echo $SessionFirstname ?> !<span class = "caret"></span></a>
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
			<!--Table Database -->
			<form method = "post">
				<div class="form-group has-feedback">
					<div class="col-sm-5 pull-right">
						<?php
							if(!isset($_POST['txtSearchUsers'])){?>
								<input name = "txtSearchUsers" id = "txtSearch" type = "text" class = "form-control" placeholder = "Search menu..." >
								<i class = "glyphicon glyphicon-search form-control-feedback" style = "text-align: left"></i><?php
							}
							
							else{?>
								<input name="txtSearchUsers" type="text" class="form-control" placeholder = "Search here.." value = "<?php echo $_POST['txtSearchUsers']?>"/>
								<i class = "glyphicon glyphicon-search form-control-feedback" style = "text-align: left"></i><?php
							}
						?>
					</div> <!--END: col-sm-5-->
				</div> <!--END: form-group-->
			</form> <!--END: FORM(Table Database)-->
			</br></br></br>
			<div class = "scrollTable">	
				<table class = "table" id = "tblAccounts">
					<tr class = "headerTable">
						<th>User ID</th>
						<th>Lastname</th>
						<th>Firstname</th>
						<th>Gender</th>
						<th>Email Add</th>	
						<th>Phone Number</th>	
						<th>User Type</th>	
						<th>Category</th>	
						<th>Action</th>	
					</tr> <!--END: headerTable-->
					<?php
					if(!empty($_POST['txtSearchUsers'])){
						$SearchUsers = $_POST['txtSearchUsers'];
						
						$query = "SELECT * FROM tblUsers WHERE (UserID LIKE '$SearchUsers%' || Lastname LIKE '$SearchUsers%' || Firstname LIKE '$SearchUsers%' || Gender LIKE '$SearchUsers%' || Type LIKE '$SearchUsers%' || Category LIKE '$SearchUsers%') && (UserID NOT LIKE '%$SessionUID%' && Type != 'Admin');";
						$run = mysqli_query($con, $query);
							
						if($run){
							while($list = mysqli_fetch_assoc($run)){
								$UserID = $list['UserID'];
								$Lastname = $list['Lastname'];
								$Firstname = $list['Firstname'];
								$Gender = $list['Gender'];
								$Email = $list['EmailAdd'];
								$Phone = $list['PhoneNumber'];
								$UType = $list['Type'];
								$Category = $list['Category'];
								$Status = $list['Status'];
							?>
								
							<tr onClick = "getRowVal(this)">
								<td><?php echo $UserID?></td>
								<td><?php echo $Lastname?></td>
								<td><?php echo $Firstname?></td>
								<td><?php echo $Gender?></td>
								<td><?php echo $Email?></td>
								<td><?php echo $Phone?></td>
								<td><?php echo $UType?></td>
								<td><?php echo $Category?></td>
								<?php
									if($Status == "d"){?>
										<td><a class = "btn btn-xs btn-link disabled" title = "Edit Account"><span class = "glyphicon glyphicon-edit"></a><?php
										echo "<a href = 'action.php?status=$Status&userid=$UserID' class = 'btn-xs btn btn-link' title = 'Activate Account'><span class = 'glyphicon glyphicon-ok'></span> </a></td>";
									}
												
									else{?>
										<td><a class = "btn btn-xs btn-link" id = "btnEditAccount" title = "Edit Account" data-toggle = "modal" data-target = "#EditAccount"><span class = "glyphicon glyphicon-edit"></a><?php
										echo "<a href = 'action.php?status=$Status&userid=$UserID' class = 'btn-xs btn btn-link' title = 'Deactivate Account'><span class = 'glyphicon glyphicon-ban-circle'></span> </a></td>";
									}
							}?>
							</tr><?php
						}
					}//END: !empty(txtSearchUsers)
						
					else{
						if($SessionType == "Admin"){
							$query = "SELECT * FROM tblUsers WHERE UserID != '$SessionUID' && Type != 'Admin';";
							$run = mysqli_query($con, $query);
							
							while($list = mysqli_fetch_assoc($run)){
								$UserID = $list['UserID'];
								$Lastname = $list['Lastname'];
								$Firstname = $list['Firstname'];
								$Gender = $list['Gender'];
								$Email = $list['EmailAdd'];
								$Phone = $list['PhoneNumber'];
								$UType = $list['Type'];
								$Category = $list['Category'];
								$Status = $list['Status'];
							?>
							<tr onClick = "getRowVal(this)">
								<td><?php echo $UserID?></td>
								<td><?php echo $Lastname?></td>
								<td><?php echo $Firstname?></td>
								<td><?php echo $Gender?></td>
								<td><?php echo $Email?></td>
								<td><?php echo $Phone?></td>
								<td><?php echo $UType?></td>
								<td><?php echo $Category?></td>
								<?php
									if($Status == "d"){?>
										<td><a class = "btn btn-xs btn-link disabled" title = "Edit Account"><span class = "glyphicon glyphicon-edit"></a><?php
										echo "<a href = 'action.php?status=$Status&userid=$UserID' class = 'btn-xs btn btn-link' title = 'Activate Account'><span class = 'glyphicon glyphicon-ok'></span> </a></th>";
									}
														
									else{?>
										<td><a class = "btn btn-xs btn-link" id = "btnEditAccount" title = "Edit Account" data-toggle = "modal" data-target = "#EditAccount"><span class = "glyphicon glyphicon-edit"></a><?php
										echo "<a href = 'action.php?status=$Status&userid=$UserID' class = 'btn-xs btn btn-link' title = 'Deactivate Account'><span class = 'glyphicon glyphicon-ban-circle'></span> </a></th>";
									}
							}	?>
							</tr>
				<?php	} //END: $SessionType is Admin
				
						else{
							$query = "SELECT * FROM tblUsers WHERE UserID != '$SessionUID' && Type = 'Staff';";
							$run = mysqli_query($con, $query);
							
							while($list = mysqli_fetch_assoc($run)){
								$UserID = $list['UserID'];
								$Lastname = $list['Lastname'];
								$Firstname = $list['Firstname'];
								$Gender = $list['Gender'];
								$Email = $list['EmailAdd'];
								$Phone = $list['PhoneNumber'];
								$UType = $list['Type'];
								$Category = $list['Category'];
								$Status = $list['Status'];
							?>
							<tr onClick = "getRowVal(this)">
								<td><?php echo $UserID;?></td>
								<td><?php echo $Lastname;?></td>
								<td><?php echo $Firstname;?></td>
								<td><?php echo $Gender;?></td>
								<td><?php echo $Email;?></td>
								<td><?php echo $Phone;?></td>
								<td><?php echo $UType;?></td>
								<td><?php echo $Category;?></td>
								<?php
									if($Status == "d"){?>
										<td><a class = "btn btn-xs btn-link disabled" title = "Edit Account"><span class = "glyphicon glyphicon-edit"></a><?php
										echo "<a href = 'action.php?status=$Status&userid=$UserID' class = 'btn-xs btn btn-link' title = 'Activate Account'><span class = 'glyphicon glyphicon-ok'></span> </a></th>";
									}
														
									else{?>
										<td><a class = "btn btn-xs btn-link" id = "btnEditAccount" title = "Edit Account" data-toggle = "modal" data-target = "#EditAccount"><span class = "glyphicon glyphicon-edit"></a><?php
										echo "<a href = 'action.php?status=$Status&userid=$UserID' class = 'btn-xs btn btn-link' title = 'Deactivate Account'><span class = 'glyphicon glyphicon-ban-circle'></span></a></th>";
									}
							}	?>
							</tr>
			<?php		}
					}?> <!--END: empty $txtSearchUsers-->
				</table> <!--END: table-->
			</div> <!--END: scrollTable-->
			</br><a data-target = "#AddAccount" class="btn btn-success pull-right" data-toggle = "modal"><span class = "glyphicon glyphicon-plus"></span> Add new account </a>
			<!--Table Database -->
			
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
			
			<!--Edit Account-->
			<div class = "modal fade" id = "EditAccount">
				<div class = "modal-dialog">
					<div class = "modal-content">
						<div class = "modal-header">
							<b><span class = "glyphicon glyphicon-edit"></span> Edit Account</b>
							<button type = "button" class = "close" data-dismiss = "modal">
								&times;
							</button>
						</div>
						
						<form class = "form-horizontal" method = "post">
							<div class = "modal-body">
								<div class="form-group"></br>
									<label class="col-sm-4 control-label"> User ID: </label>
									<div class="col-sm-6">
										<input name="txtAccountUID" id = "txtAccountUID" type="text" class="form-control" readonly>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-4 control-label"> Lastname: </label>
									<div class="col-sm-6">
										<input name="txtAccountLastname" id ="txtAccountLastname" type="text" class="form-control">
									</div>
								</div>
									
								<div class="form-group">
									<label class="col-sm-4 control-label"> Firstname: </label>
									<div class="col-sm-6">
										<input name="txtAccountFirstname" id ="txtAccountFirstname" type="text" class="form-control">
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-4 control-label"> Gender: </label>
									<div class="col-sm-6">
										<input type = "radio" name = "rdbAccountGender" id = "male" value = "Male">Male
										<input type = "radio" name = "rdbAccountGender" id = "female" value = "Female">Female
									</div>
								</div>
									
								<div class="form-group">
									<label class="col-sm-4 control-label"> User Type: </label>
									<div class="col-sm-6">
										<select id = "cmbAccountUserType" name = "cmbAccountUserType" class = "form-control" onInput = "getType()">
											<option></option>
											<option value = "Manager">Manager</option>
											<option value = "Staff">Staff</option>
										</select>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-4 control-label"> Category: </label>
									<div class="col-sm-6">
										<select  class = "form-control" name = "cmbAccountCategory" id = "cmbAccountCategory" required>
											<option value = "-">-For staff only-</option>
											<option value = "Front Desk">Front Desk</option>
											<option value = "Coffee Crew">Coffee Crew</option>
										</select>
									</div>
								</div>
							</div> <!--END: modal-body-->
						
							<div class = "modal-footer">
								<button type="submit" class="btn btn-success" id = "btnUpdateAccount" name = "btnUpdateAccount"> Update </button>
							</div> <!--END: modal-footer-->
						</form> <!--END: /form-->
					</div> <!--END: modal-content-->
				</div> <!--END: modal-dialog-->
			</div> <!--END: modal fade-->
			<!--Edit Account-->
			
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
			
			<!--Add Account -->
			<div class = "modal fade" id = "AddAccount">
				<div class= "modal-dialog">
					<div class = "modal-content">
						<div class = "modal-header">
							<b><span class = "glyphicon glyphicon-user"></span> Add Account</b>
							<button type = "button" class = "close" data-dismiss = "modal">
								&times;
							</button>
						</div> <!--END: modal-header-->
						
						<form class = "form-horizontal" method = "post">
							<div class = "modal-body">
								<div class="form-group"></br>
									<label class="col-sm-4 control-label"> User ID: </label>
									<div class="col-sm-6">
										<?php 
											$queryRow = "SELECT * FROM tblUsers;";
											$row = mysqli_query($con, $queryRow);
											
											
											if(mysqli_num_rows($row) >= 1 && mysqli_num_rows($row) < 10){
												$countRow = mysqli_num_rows($row);?>
												<input name="txtUserID" type="text" class="form-control" value = "<?php echo date("y")?>-00<?php echo $countRow ?>" readonly><?php
											}
											
											else if(mysqli_num_rows($row) >= 10 && mysqli_num_rows($row) < 100){
												$countRow = mysqli_num_rows($row);?>
												<input name="txtUserID" type="text" class="form-control" value = "<?php echo date("y")?>-0<?php echo $countRow ?>" readonly><?php
											}
											
											else if(mysqli_num_rows($row) >= 100 && mysqli_num_rows($row) < 1000){
												$countRow = mysqli_num_rows($row);?>
												<input name="txtUserID" type="text" class="form-control" value = "<?php echo date("y")?>-<?php echo $countRow ?>" readonly><?php
											}
											
											else{?>
												<script type = "text/javascript">
													alert("There is no enough space!");
												</script><?php
											}
										?>
									</div>
								</div>
										
								<div class="form-group">
									<label class="col-sm-4 control-label"> Password: </label>
									<div class="col-sm-6">
										<input name="txtPassword" type="text" class="form-control" value = "pcspass" readonly>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-4 control-label"> Lastname: </label>
									<div class="col-sm-6">
										<input name="txtLastname" type="text" class="form-control" required>
									</div>
								</div>
									
								<div class="form-group">
									<label class="col-sm-4 control-label"> Firstname: </label>
									<div class="col-sm-6">
										<input name="txtFirstname" type="text" class="form-control" required>
									</div>
								</div>
									
								<div class="form-group">
									<label class="col-sm-4 control-label"> Gender: </label>
									<div class="col-sm-6">
										<input type = "radio" name = "rdbGender" value = "Male" required>Male
										<input type = "radio" name = "rdbGender" value = "Female" required>Female
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-4 control-label"> User Type: </label>
									<div class="col-sm-6">
										<select class = "form-control" name = "cmbUserType" id = "cmbUserType" onInput = "getType()" required>
											<option></option>
											<option value = "Manager">Manager</option>
											<option value = "Staff">Staff</option>
										</select>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-4 control-label"> Category: </label>
									<div class="col-sm-6">
										<select  class = "form-control" name = "cmbCategory" id = "cmbCategory">
											<option value = "-">-For staff only-</option>
											<option value = "Front Desk">Front Desk</option>
											<option value = "Coffee Crew">Coffee Crew</option>
										</select>
									</div>
								</div>
							</div><!--END: modal-body-->
						
							<div class = "modal-footer">
								<button type="submit" class="btn btn-success" id = "btnAddAccount" name = "btnAddAccount"> Add Account</button>
							</div> <!--END: modal-footer-->
						</form> <!--END: /form-->
					</div> <!--END: modal-content-->
				</div> <!--END: modal-dialog-->
			</div> <!--END: modal fade-->
			<!--Add Account-->
		</div>	
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



