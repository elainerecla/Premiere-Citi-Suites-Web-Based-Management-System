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
		<script>
			var timer = setInterval(function(){MyTimer()}, 1000);
			
			function MyTimer(){
				var Time = new Date();
				document.getElementById("displayDate").innerHTML = Time.toLocaleDateString();
				document.getElementById("displayTime").innerHTML = Time.toLocaleTimeString();
			};
			
			function rowVal(getIndex){
				var rowIndex= getIndex.rowIndex;
				var rowValue = document.getElementById('dspTblRooms').rows[rowIndex].cells;
				txtUpdOrigRmNo.value = rowValue[0].innerHTML;
				txtUpdRmNo.value = rowValue[0].innerHTML;
				txtUpdFlrNo.value = rowValue[1].innerHTML;
				cmbUpdRmType.value = rowValue[2].innerHTML;
			};
			
			$(function(){
				$('#dspTblRooms .hoverTable').click(function(){
					$(this).addClass('selectedRow').siblings().removeClass('selectedRow');
				});
			});
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
						window.location.href = "managementRoom.php";
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
			
			if(isset($_POST['btnAddType'])){
				//Image
				$filetmp = $_FILES['typeImg']['tmp_name'];
				$filename = $_FILES['typeImg']['name'];
				$filetype = $_FILES['typeImg']['type'];
				$filepath = "Upload/".$filename;
				
				move_uploaded_file($filetmp, $filepath);
				
				$Name = $_POST['txtTypeName'];
				$Specification = $_POST['txtTypeSpecification'];
				$MaxPerson = $_POST['txtTypePerson'];
				$Rate = $_POST['txtTypeRate'];
				$XtraPerson = $_POST['txtTypeXtraPerson'];
				
				$query = "SELECT * FROM tblRoomType WHERE Name = '$Name' AND Status = 'available';";
				$run = mysqli_query($con, $query);
				
				if(mysqli_num_rows($run) > 0){?>
					<script type = "text/javascript">
						alert("Error, Room type already exist!");
					</script><?php
				}
				
				else{
					$query = "SELECT * FROM tblRoomType;";
					$run = mysqli_query($con, $query);
					
					$countRow = mysqli_num_rows($run) + 1;
					
					$query = "SELECT * FROM tblRoomType WHERE Name = '$Name' AND Status = 'removed';";
					$runCheckStatus = mysqli_query($con, $query);
					
					if(mysqli_num_rows($runCheckStatus) > 0){
						$query = "UPDATE tblRoomType SET Name = '$Name', Specification = '$Specification', MaxPerson = '$MaxPerson', Rate = '$Rate', Charge = '$XtraPerson', Img_Name = '$filename', ImageLink = '$filepath', Status = 'available' WHERE Name = '$Name';";
						$run = mysqli_query($con, $query);
						
						if($run){?>
							<script type = "text/javascript">
								alert("New room type is saved!");
							</script><?php
						}
						
						else{?>
							<script type = "text/javascript">
								alert("Something went wrong!");
							</script><?php
						}
					}
					
					else{
						$queryIns = "INSERT INTO tblRoomType (RoomType_ID, Name, Specification, MaxPerson, Rate, Charge, Img_Name, ImageLink, Status) VALUES('RmType#$countRow', '$Name', '$Specification', '$MaxPerson', '$Rate', '$XtraPerson', '$filename', '$filepath', 'available');";
						$run = mysqli_query($con, $queryIns);
						
						if($run){?>
							<script type = "text/javascript">
								alert("New room type is saved!");
							</script><?php
						}
					}
				}
			}
			
			if(isset($_POST['btnAddRoom'])){
				$RoomType = $_POST['cmbRoomType'];
				$RoomNo = $_POST['txtRoomNo'];
				$FloorNo = $_POST['txtFloorNo'];
				
				$querySel = "SELECT * FROM tblRooms;";
				$run = mysqli_query($con, $querySel);
				$countRow = mysqli_num_rows($run) + 1;
				
				$query = "SELECT RoomNo FROM tblRooms WHERE RoomNo = '$RoomNo';";
				$run = mysqli_query($con, $query);
				
				if(mysqli_num_rows($run) > 0){?>
					<script type = "text/javascript">
						alert("Error, Room number already exist!");
					</script><?php
				}
				
				else{
					$queGetRate = "SELECT Rate FROM tblRoomType WHERE Name = '$RoomType';";
					$run = mysqli_query($con, $queGetRate);
					
					$data = mysqli_fetch_assoc($run);
					$RoomRate = $data['Rate'];
					$query = "INSERT INTO tblRooms (Room_ID, RoomNo, FloorNo, RoomType, RoomRate) VALUES('$countRow', '$RoomNo', '$FloorNo', '$RoomType', '$RoomRate');";
					$run = mysqli_query($con, $query);
				}
			}
			
			if(isset($_POST['btnUpdateFieldType'])){
				if(empty($_FILES['typeImg']['tmp_name'])){
					$TypeName = $_POST['txtTypeName'];
					$DBTypeName = $_POST['txtDBTypeName'];
					$Specification = $_POST['txtTypeSpecification'];
					$MaxPerson = $_POST['txtTypePerson'];
					$Rate = $_POST['txtTypeRate'];
					$XtraPerson = $_POST['txtTypeXtraPerson'];
					
					$queryUpd = "UPDATE tblRoomType SET Name = '$TypeName', Specification = '$Specification', MaxPerson = '$MaxPerson', Rate = '$Rate', Charge = '$XtraPerson' WHERE Name = '$DBTypeName';";
					$run1 = mysqli_query($con, $queryUpd);
					
					$queryUpdRooms = "UPDATE tblRooms SET RoomType = '$TypeName', RoomRate = '$Rate' WHERE RoomType = '$DBTypeName';";
					$run2 = mysqli_query($con, $queryUpdRooms);
					
					if($run1 && $run2){?>
						<script type = "text/javascript">
							alert("Room type updated!");
						</script><?php
					}
					
					else{?>
						<script type = "text/javascript">
							alert("Something went wrong!");
						</script><?php
					}
				}
				
				else{
					//Image
					$filetmp = $_FILES['typeImg']['tmp_name'];
					$filename = $_FILES['typeImg']['name'];
					$filetype = $_FILES['typeImg']['type'];
					$filepath = "Upload/".$filename;
					
					move_uploaded_file($filetmp, $filepath);
					
					$TypeName = $_POST['txtTypeName'];
					$DBTypeName = $_POST['txtDBTypeName'];
					$Specification = $_POST['txtTypeSpecification'];
					$MaxPerson = $_POST['txtTypePerson'];
					$Rate = $_POST['txtTypeRate'];
					$XtraPerson = $_POST['txtTypeXtraPerson'];
					
					$queryUpd = "UPDATE tblRoomType SET Name = '$TypeName', Specification = '$Specification', MaxPerson = '$MaxPerson', Rate = '$Rate', Charge = '$XtraPerson', Img_Name = '$filename', ImageLink = '$filepath' WHERE Name = '$DBTypeName';";
					$run1 = mysqli_query($con, $queryUpd);
					$queryUpdRooms = "UPDATE tblRooms SET RoomType = '$TypeName', RoomRate = '$Rate' WHERE RoomType = '$DBTypeName';";
					$run2 = mysqli_query($con, $queryUpdRooms);
					
					if($run1 && $run2){?>
						<script type = "text/javascript">
							alert("Room type updated!");
						</script><?php
					}
					
					else{?>
						<script type = "text/javascript">
							alert("Something went wrong!");
						</script><?php
					}
				}
			}
			
			if(isset($_POST['btnRemoveRoomType'])){
				$RoomType = $_POST['dsplayRoomType'];
				$query = "UPDATE tblRoomType SET Status = 'removed' WHERE Name = '$RoomType';";
				$run = mysqli_query($con, $query);
			}
			
			if(isset($_POST['btnUpdateRm'])){
				$updOrig = $_POST['txtUpdOrigRmNo'];
				$updRmNo = $_POST['txtUpdRmNo'];
				$updFlrNo = $_POST['txtUpdFlrNo'];
				$updRmType = $_POST['cmbUpdRmType'];
				
				$queryRate = "SELECT Rate FROM tblRoomType WHERE Name = '$updRmType'";
				$run1 = mysqli_query($con, $queryRate);
				
				$data = mysqli_fetch_assoc($run1);
				$updRmRate = $data['Rate'];
				
				$query = "UPDATE tblRooms SET RoomNo = '$updRmNo', FloorNo = '$updFlrNo', RoomType = '$updRmType', RoomRate = '$updRmRate', Status = 'available' WHERE RoomNo = '$updOrig';";
				$run2 = mysqli_query($con, $query);
				
				if($run2){?>
					<script type = "text/javascript">
						alert("Room is updated!");
					</script><?php
				}
				
				else{?>
					<script type = "text/javascript">
						alert("Something went wrong!");
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
						?>
                        <li class = "active"><a href="managementRoom.php" class = "dropdown-toggle" data-toggle = "dropdown">Room</a></li>
						
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
		<div class = "container" style = "height: 800px;">
			<b><p class = "col-sm-4" style = "text-align: right">Current Time:</p></b>
			<i><p class = "col-sm-1" id = "displayDate"></p>
			<p class = "col-sm-2" id = "displayTime"></p></i>
			
			<!--Room Management-->
			<ul class = "nav nav-tabs">
				<li class = "pull-right"><a href = "roomStatus.php">Room's Status</a></li>
				<li class = "pull-right active"><a href = "managementRoom.php">Room Management</a></li>	
			</ul>
			</br>
			
			<div class = "col-sm-5" style = "height: 90%;">
				<form class = "form-horizontal" method = "POST">
					<div class = "form-group">
						<div class = "col-sm-9">
							<select class = "form-control" name = "cmbSelectRoomType" required>
								<option value = "">-Select room type-</option><?php
								$query = "SELECT RoomType_ID, Name FROM tblRoomType WHERE Status != 'removed';";
								$run = mysqli_query($con, $query);
									
								while($data = mysqli_fetch_assoc($run)){?>
									<option value = "<?php echo $data['RoomType_ID'];?>"><?php echo $data['Name'];?></option><?php
								}
								?>
							</select>
						</div>
						
						<button class = "btn btn-primary" name = "btnSelectType"><span class = "glyphicon glyphicon-ok"></span> Select</button>
					</div>
				</form>
				
				<?php
					if(isset($_POST['btnSelectType'])){
						$RoomID = $_POST['cmbSelectRoomType'];
						$query = "SELECT * FROM tblRoomType WHERE RoomType_ID = '$RoomID';";
						$run = mysqli_query($con, $query);
						
						$data = mysqli_fetch_assoc($run);
						$RoomType = $data['Name'];
						$MaxPerson = $data['MaxPerson'];
						$Specification = $data['Specification'];
						$Rate = $data['Rate'];
						$Charge = $data['Charge'];
						$Image = $data['ImageLink'];?>
						
						<div class = "panel panel-default">
							<div class = "panel-header"><center>
								<div class = "col-sm-12"></br>
									<img class = "img-thumbnail" width = "100%" src = "<?php echo $Image;?>"></img>
								</div></center>
							</div>
							</br></br></br></br></br>
							<div class = "panel-body">
								<div class = "full-width">
									</br><center><b><?php echo $RoomType;?></b></center></br></br>
									<div class = "form-group">
										<label class = "col-sm-8">Maximum no. of person: </label><p style = "text-align: left;"><?php echo $MaxPerson?> person(s)</p>
									</div>
									<div class = "form-group">
										<label class = "col-sm-12">Specification: </label>
									</div>
									
									<div class = "form-group col-sm-12">
										<div class = "col-sm-12 pull-right">
											<?php echo $Specification;?></br>
										</div>
									</div>
									
									<div class = "form-group">
										<div class = "col-sm-12">
											<label>Rate: </label> <span class = "label label-success">P <?php echo number_format($Rate, 2);?></span>
										</div>
										
										<div class = "col-sm-12">
											<label>Extra Person: </label> <span class = "label label-danger">P <?php echo number_format($Charge, 2);?></span></br></br>
										</div>
									</div>
								</div>
								<div class = "full-width">
									<form method = "POST" onSubmit = "return confirm('Delete <?php echo $RoomType?>?')">
										<input type = "hidden" name = "dsplayRoomType" value = "<?php echo $RoomType;?>">
										<button class = "pull-right btn btn-sm btn-link" name = "btnRemoveRoomType"><span class = "glyphicon glyphicon-trash"></span> Remove</button>
									</form>
									<form method = "POST">
										<input type = "hidden" name = "dsplayRoomType" value = "<?php echo $RoomType;?>">
										<button class = "pull-right btn btn-sm btn-link" name = "btnUpdateRoomType"><span class = "glyphicon glyphicon-edit"></span> Update</button>
									</form>
								</div>
							</div>
						</div><?php
					}
					
					else{?>
						<div class = "panel panel-default">
							<div class = "panel-header">
								<center>
									<div class = "col-sm-12"></br>
										<img class = "img-thumbnail" width = "200px" src = "Upload/no_image.jpg"></img>
									</div>
								</center>
							</div>
							</br></br></br></br></br>
							<div class = "panel-body">
								<div class = "full-width">
									</br><center><b>Room Type</b></center></br></br>
									<div class = "form-group">
										<label class = "col-sm-10">Maximum no. of person: </label>
									</div>
									<div class = "form-group">
										<label class = "col-sm-12">Specification: </label>
									</div>
									
									<div class = "form-group">
										<div class = "col-sm-12">
											<label>Rate: </label>
										</div>
										
										<div class = "col-sm-12">
											<label>Extra Person: </label>
										</div>
									</div>
								</div>
								<div class = "full-width">
									<button class = "pull-right btn btn-sm btn-link disabled"><span class = "glyphicon glyphicon-trash"></span> Remove</button>
									<button class = "pull-right btn btn-sm btn-link disabled"><span class = "glyphicon glyphicon-edit"></span> Update</button>
								</div>
							</div>
						</div><?php
					}?>
			</div>
			<div class = "col-sm-7" style = "height: 90%;">
				<div class = "panel panel-default">
					<div class = "panel-body">
						<div class = "col-sm-12"></br><?php
							if(isset($_POST['btnUpdateRoomType'])){
								$updateRoomType = $_POST['dsplayRoomType'];
								
								$query = "SELECT * FROM tblRoomType WHERE Name = '$updateRoomType';";
								$run = mysqli_query($con, $query);
								
								$data = mysqli_fetch_assoc($run);?>
								
								<form class = "form-horizontal" method = "POST" enctype = "multipart/form-data">
									<div class = "col-sm-1">
									</div>
									<div class = "col-sm-10">
										<div class = "col-sm-5">
											<img class = "img-thumbnail" name = "img_file" width = "100%" src = "<?php echo $data['ImageLink'];?>"></img>
										</div>
										<div class = "form-group col-sm-6">
											<label class = "col-sm-12">Change image:</label>	
											<div class = "col-sm-2">
												<input type = "file" name = "typeImg" accept = "image/*"></br>
											</div>
										</div>
									</div>
							
									<div class = "form-group">
										<label class = "col-sm-4" style = "text-align: right">Name: </label>
										<div class = "col-sm-7">
											<input type = "text" name = "txtTypeName" class = "form-control" value = "<?php echo $data['Name'];?>" required>
											<input type = "hidden" readonly name = "txtDBTypeName" class = "form-control" value = "<?php echo $data['Name'];?>" required>
										</div>
									</div>
									
									<div class = "form-group">
										<label class = "col-sm-4" style = "text-align: right;">Specification: </label>
										<div class = "col-sm-7">
											<textarea class = "form-control" name = "txtTypeSpecification" cols = "40" rows = "3" required><?php echo $data['Specification'];?></textarea>
										</div>
									</div>
									<div class = "form-group">
										<label class = "col-sm-4" style = "text-align: right;">Maximum no. of person: </label>
										<div class = "col-sm-3">
											<input type = "number" name = "txtTypePerson" value ="<?php echo $data['MaxPerson'];?>" class = "form-control" min = 1 required>
										</div>
										
										<label class = "col-sm-1">Rate: </label>
										<div class = "col-sm-3">
											<input type = "number" name = "txtTypeRate" value = "<?php echo $data['Rate'];?>" class = "form-control" step = "0.01" min = 1 required>
										</div>
									</div>
									<div class = "form-group">
										<label class = "col-sm-4" style = "text-align: right;">Extra person (Charge): </label>
										<div class = "col-sm-7">
											<input type = "number" name = "txtTypeXtraPerson" value = "<?php echo $data['Charge'];?>" class = "form-control" step = "0.01" min = 1 required>
										</div>
									</div>
									<button class = "btn btn-primary pull-right" name = "btnUpdateFieldType"><span class = "glyphicon glyphicon-edit"></span> Update</button>
								</form><?php
							}
							
							else{?>
								<form class = "form-horizontal" method = "POST" enctype = "multipart/form-data">
									<div class = "form-group">
										<label class = "col-sm-4" style = "text-align: right;">Import image:</label>	
										<div class = "col-sm-7">
											<input type = "file" name = "typeImg" accept = "image/*" required>
										</div>
									</div>
									<div class = "form-group">
										<label class = "col-sm-4" style = "text-align: right">Name: </label>
										<div class = "col-sm-7">
											<input type = "text" name = "txtTypeName" class = "form-control" required>
										</div>
									</div>
									
									<div class = "form-group">
										<label class = "col-sm-4" style = "text-align: right;">Specification: </label>
										<div class = "col-sm-7">
											<textarea class = "form-control" name = "txtTypeSpecification" cols = "40" rows = "3" required></textarea>
										</div>
									</div>
									<div class = "form-group">
										<label class = "col-sm-4" style = "text-align: right;">Maximum no. of person: </label>
										<div class = "col-sm-3">
											<input type = "number" name = "txtTypePerson" class = "form-control" min = 1 required>
										</div>
										
										<label class = "col-sm-1">Rate: </label>
										<div class = "col-sm-3">
											<input type = "number" name = "txtTypeRate" class = "form-control" step = "0.01" min = 1 required>
										</div>
									</div>
									<div class = "form-group">
										<label class = "col-sm-4" style = "text-align: right;">Extra person (Charge): </label>
										<div class = "col-sm-7">
											<input type = "number" name = "txtTypeXtraPerson" class = "form-control" step = "0.01" min = 1 required>
										</div>
									</div>
									<button class = "btn btn-success pull-right" name = "btnAddType"><span class = "glyphicon glyphicon-plus"></span> Add room type</button>
								</form><?php
							}?>
						</div>
					</div>
				</div>
				
				<div class = "form-group col-sm-4">
					<button class = "btn btn-success" data-toggle = "modal" data-target = "#AddRoom"><span class = "glyphicon glyphicon-home"></span> Add Room</button>
				</div>
				
				<form class = "form-horizontal" method = "POST">
					<div class = "col-sm-7 pull-right form-group has-feedback">
						<i class = "glyphicon glyphicon-search form-control-feedback"></i>
						<input class = "form-control" type = "text" name = "txtSearchRoom" placeholder = "Search here...">	
					</div>
				</form><?php
			
				if(!empty($_POST['txtSearchRoom'])){
					$SearchRm = $_POST['txtSearchRoom'];?>
					
					<div class = "col-sm-12" style = "overflow-y: scroll; height: 150px;">
						<table class = "table table-condensed" id = "dspTblRooms">
							<tr>
								<th>Room #</th>
								<th>Floor No.</th>
								<th>Room Type</th>
								<th>Room Rate</th>
								<th>Action</th>
							</tr><?php
							
							$queSearch = "SELECT RoomNo, FloorNo, RoomType FROM tblRooms WHERE (RoomNo LIKE '$SearchRm%' || FloorNo LIKE '$SearchRm%' || RoomType LIKE '$SearchRm%' || RoomRate LIKE '$SearchRm%') ORDER BY Room_ID ASC;";
							$runSearch = mysqli_query($con, $queSearch);
							
							if(mysqli_num_rows($runSearch) > 0){
								while($data = mysqli_fetch_assoc($runSearch)){?>
									<tr onClick = "rowVal(this)" class = "hoverTable">
										<td><?php echo $data['RoomNo'];?></td>
										<td><?php echo $data['FloorNo'];?></td><?php
										
										$TypeName = $data['RoomType'];
										$queryTblRoomType = "SELECT Name, Rate FROM tblRoomType WHERE Name = '$TypeName' AND Status = 'available'";
										$runTblRmType = mysqli_query($con, $queryTblRoomType);
										
										if(mysqli_num_rows($runTblRmType) > 0){
											while($data = mysqli_fetch_assoc($runTblRmType)){
												$RmType = $data['Name'];
												$RmRate = $data['Rate'];?>
												
												<td><?php echo $RmType;?></td>
												<td><b>P <?php echo number_format($RmRate, 2);?></b></td>
												<td>
													<button class = "btn btn-xs btn-link" name = "rowEdit" title = "Edit" data-toggle = "modal" data-target = "#UpdateRoom"><span class = "glyphicon glyphicon-edit"></span> Edit</button>
												</td><?php
											}
										}
										
										else{?>
											<td>---</td>
											<td>---</td>
											<td>
												<button class = "btn btn-xs btn-link" name = "rowEdit" title = "Edit" data-toggle = "modal" data-target = "#UpdateRoom"><span class = "glyphicon glyphicon-edit"></span> Edit</button>
											</td><?php
										}?>
									</tr><?php
								}
							}
							?>
						</table>
					</div></br>
						
					
					<b class = "pull-right col-sm-12">Record(s) found: <?php echo mysqli_num_rows($runSearch);?></b><?php
				}
				
				else{?>
					<div class = "col-sm-12" style = "overflow-y: scroll; height: 150px;">
						<table class = "table table-condensed" id = "dspTblRooms">
							<tr>
								<th>Room #</th>
								<th>Floor No.</th>
								<th>Room Type</th>
								<th>Room Rate</th>
								<th>Action</th>
							</tr><?php
							
							$queryTblRoom = "SELECT RoomNo, FloorNo, RoomType FROM tblRooms ORDER BY Room_ID ASC;";
							$runSel = mysqli_query($con, $queryTblRoom);
							
							if(mysqli_num_rows($runSel) > 0){
								while($data = mysqli_fetch_assoc($runSel)){?>
									<tr onClick = "rowVal(this)" class = "hoverTable">
										<td><?php echo $data['RoomNo'];?></td>
										<td><?php echo $data['FloorNo'];?></td><?php
										
										$TypeName = $data['RoomType'];
										$queryTblRoomType = "SELECT Name, Rate FROM tblRoomType WHERE Name = '$TypeName' AND Status = 'available'";
										$runTblRmType = mysqli_query($con, $queryTblRoomType);
										
										if(mysqli_num_rows($runTblRmType) > 0){
											while($data = mysqli_fetch_assoc($runTblRmType)){
												$RmType = $data['Name'];
												$RmRate = $data['Rate'];?>
												
												<td><?php echo $RmType;?></td>
												<td><b>P <?php echo number_format($RmRate, 2);?></b></td>
												<td>
													<button class = "btn btn-xs btn-link" name = "rowEdit" title = "Edit" data-toggle = "modal" data-target = "#UpdateRoom"><span class = "glyphicon glyphicon-edit"></span> Edit</button>
												</td><?php
											}
										}
										
										else{
											$queEmpty = "UPDATE tblRooms SET RoomType = '', RoomRate = '', Status = 'not available' WHERE RoomType = '$TypeName';";
											$run = mysqli_query($con, $queEmpty);?>
											
											<td>---</td>
											<td>---</td>
											<td>
												<button class = "btn btn-xs btn-link" name = "rowEdit" title = "Edit" data-toggle = "modal" data-target = "#UpdateRoom"><span class = "glyphicon glyphicon-edit"></span> Edit</button>
											</td><?php
										}?>
									</tr><?php
								}
							}
							?>
						</table>
					</div>
					
					<div class = "col-sm-12"></br>
						<b class = "pull-right">Record(s) found: <?php echo mysqli_num_rows($runSel);?></b>
					</div><?php
				}?>
			</div>
		<!--Room Management-->
		</div>
		
		<!--Add Room-->
		<center>
			<div class = "modal fade" id = "AddRoom">
				<div class = "modal-dialog">
					<div class = "modal-content" style = "width: 60%;">
						<div class = "modal-header">
							<h4><b><span class = "glyphicon glyphicon-plus"></span> Add Room</b>
							<button title = "Close" type = "button" class = "close" data-dismiss = "modal">
								&times;
							</button></h4>
						</div>
						
						<form class = "form-horizontal" method = "POST">
							<div class = "modal-body">
								<?php
									$query = "SELECT * FROM tblRooms;";
									$run = mysqli_query($con, $query);
									
									$RmNoCount = mysqli_num_rows($run) + 1;
								?>
								<div class = "form-group">
									<label class = "col-sm-5 control-label">Room No: </label>
									<div class = "col-sm-6">
										<input class = "form-control" type = "text" name = "txtRoomNo" value = "Rm#<?php echo $RmNoCount;?>" readonly required>
									</div>
								</div>
								
								<div class = "form-group">
									<label class = "col-sm-5 control-label">Floor No: </label>
									<div class = "col-sm-6">
										<input class = "form-control" type = "number" name = "txtFloorNo" min = 1 required>
									</div>
								</div>
								
								<div class = "form-group">
									<label class = "col-sm-5 control-label">Room type: </label>
									<div class = "col-sm-6">
										<select class = "form-control" name = "cmbRoomType" required>
											<option></option><?php
												$query = "SELECT Name FROM tblRoomType WHERE Status != 'removed' ORDER BY Name ASC;";
												$run = mysqli_query($con, $query);
												
												while($data = mysqli_fetch_assoc($run)){?>
													<option><?php echo $data['Name'];?></option><?php
												}
											?>
										</select>
									</div>
								</div>
							</div>
						
							<div class = "modal-footer">
								<button class = "btn btn-success" type = "submit" name = "btnAddRoom">Save</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</center>
		<!--Add Room-->		
		
		<!--Update Room-->
		<center>
			<div class = "modal fade" id = "UpdateRoom">
				<div class = "modal-dialog">
					<div class = "modal-content" style = "width: 60%;">
						<div class = "modal-header">
							<h4><b><span class = "glyphicon glyphicon-plus"></span> Update Room</b>
							<button title = "Close" type = "button" class = "close" data-dismiss = "modal">
								&times;
							</button></h4>
						</div>
						
						<form class = "form-horizontal" method = "POST">
							<div class = "modal-body">
								<input type = "hidden" name = "txtUpdOrigRmNo" id = "txtUpdOrigRmNo">
								<div class = "form-group">
									<label class = "col-sm-5 control-label">Room No: </label>
									<div class = "col-sm-6">
										<input class = "form-control" type = "text" name = "txtUpdRmNo" id = "txtUpdRmNo" readonly required>
									</div>
								</div>
								
								<div class = "form-group">
									<label class = "col-sm-5 control-label">Floor No: </label>
									<div class = "col-sm-6">
										<input class = "form-control" type = "number" name = "txtUpdFlrNo" id = "txtUpdFlrNo" min = 1 required>
									</div>
								</div>
								
								<div class = "form-group">
									<label class = "col-sm-5 control-label">Room type: </label>
									<div class = "col-sm-6">
										<select class = "form-control" name = "cmbUpdRmType" id = "cmbUpdRmType" required>
											<option></option><?php
												$query = "SELECT Name FROM tblRoomType WHERE Status != 'removed' ORDER BY Name ASC;";
												$run = mysqli_query($con, $query);
												
												while($data = mysqli_fetch_assoc($run)){?>
													<option><?php echo $data['Name'];?></option><?php
												}
											?>
										</select>
									</div>
								</div>
							</div>
						
							<div class = "modal-footer">
								<button class = "btn btn-primary" type = "submit" name = "btnUpdateRm">Update</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</center>
		<!--Update Room-->	
		
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