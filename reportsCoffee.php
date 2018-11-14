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
					echo "Error";
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
						window.location.href = "reportsCoffee.php";
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
				displayDate.innerHTML = Time.toLocaleDateString();
				displayTime.innerHTML = Time.toLocaleTimeString();
			};
			
			$(function(){
				$('#dspTblReports .hoverTable').click(function(){
					$(this).addClass('selectedRow').siblings().removeClass('selectedRow');
				});
			});
		</script>
	</head>
    <body>
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
			<!--Reports Coffee-->
				<ul class = "nav nav-tabs">
					<li class = "active pull-right"><a href = "reportsCoffee.php">Reports</a></li>
					<li class = "pull-right"><a href = "billingCoffee.php">Billing</a></li>	
					<li class = "pull-right"><a href = "menusCoffee.php">Menus</a></li>	
				</ul>
				</br>
				
				<div class = "col-sm-12">
					<form class = "col-sm-4 form-horizontal" method = "POST">
						<div class = "form-group">
							<div class = "col-sm-8 pull-left">
								<select class = "form-control" name = "cmbSelectView" required>
									<option value = "">-View report as-</option>
									<option value = "custom">Custom</option>
									<option value = "monthly">Monthly</option>
									<option value = "annually">Annually</option>
								</select>
							</div>
									
							<button class = "btn btn-sm btn-primary pull-left" name = "btnSelectView" id = "btnSelectView"><span class = "glyphicon glyphicon-ok"></span> Select</button>
						</div>
					</form>
							
					<?php
						if(isset($_POST['btnSelectView'])){?>
							<form class = "form-horizontal pull-right col-sm-8" method = "POST">
								<div class = "form-group pull-right col-sm-12"><?php
									if($_POST['cmbSelectView'] == "custom"){?>
										<?php
											$queryFirst = "SELECT DatePurchased FROM tblPurchase WHERE DatePurchased != '0000-00-00' AND TimePurchased != '00:00:00' ORDER BY DatePurchased ASC LIMIT 1;";
											$runFirst = mysqli_query($con, $queryFirst);
											$data = mysqli_fetch_assoc($runFirst);
											$FirstDate = $data['DatePurchased'];
											
											$queryLast = "SELECT DatePurchased FROM tblPurchase WHERE DatePurchased != '0000-00-00' AND TimePurchased != '00:00:00' ORDER BY DatePurchased DESC LIMIT 1;";
											$runLast = mysqli_query($con, $queryLast);
											$data = mysqli_fetch_assoc($runLast);
											$LastDate = $data['DatePurchased'];
										?>
										
										<label class = "col-sm-1">From:</label>
										<div class = "col-sm-4">
											<input type = "date" class = "form-control" name = "txtDateFrom" style = "font-size: 13px;" min = <?php echo $FirstDate;?> max = <?php echo $LastDate;?> required>
										</div>
											
										<label class = "label-control col-sm-1">To: </label>
										<div class = "col-sm-4">
											<input type = "date" class = "form-control" name = "txtDateTo" style = "font-size: 13px;" min = <?php echo $FirstDate;?> max = <?php echo $LastDate;?> required>
										</div><?php
									}
									
									if($_POST['cmbSelectView'] == "monthly"){?>
										<label class = "col-sm-1">From:</label>
										<div class = "col-sm-4">
											<select class = "form-control" name = "cmbMonthFrom" required>
												<option value = "">-Year <?php echo date("Y")?>-</option>
												<option value = "01">January</option>
												<option value = "02">February</option>
												<option value = "03">March</option>
												<option value = "04">April</option>
												<option value = "05">May</option>
												<option value = "06">June</option>
												<option value = "07">July</option>
												<option value = "08">August</option>
												<option value = "09">September</option>
												<option value = "10">October</option>
												<option value = "11">November</option>
												<option value = "12">December</option>
											</select>
										</div>
											
										<label class = "label-control col-sm-1">To: </label>
										<div class = "col-sm-4">
											<select class = "form-control" name = "cmbMonthTo" required>
												<option value = "">-Year <?php echo date("Y")?>-</option>
												<option value = "01">January</option>
												<option value = "02">February</option>
												<option value = "03">March</option>
												<option value = "04">April</option>
												<option value = "05">May</option>
												<option value = "06">June</option>
												<option value = "07">July</option>
												<option value = "08">August</option>
												<option value = "09">September</option>
												<option value = "10">October</option>
												<option value = "11">November</option>
												<option value = "12">December</option>
											</select>
										</div><?php
									}
									
									if($_POST['cmbSelectView'] == "annually"){?>
										<label class = "col-sm-1">From:</label>
										<div class = "col-sm-4">
											<select class = "form-control" name = "cmbYearFrom" required>
												<option value = ""></option><?php
												$query = "SELECT DISTINCT EXTRACT(YEAR FROM DatePurchased) AS Year FROM tblPurchase WHERE DatePurchased != '0000-00-00' AND TimePurchased != '00:00:00';";
												$run = mysqli_query($con, $query);
												while($data = mysqli_fetch_assoc($run)){?>
													<option><?php echo $data['Year'];?></option><?php
												}?>
											</select>
										</div>
									
										<label class = "label-control col-sm-1">To: </label>
										<div class = "col-sm-4">
											<select class = "form-control" name = "cmbYearTo" required>
												<option value = ""></option><?php
												$query = "SELECT DISTINCT EXTRACT(YEAR FROM DatePurchased) AS Year FROM tblPurchase WHERE DatePurchased != '0000-00-00' AND TimePurchased != '00:00:00';";
												$run = mysqli_query($con, $query);
												while($data = mysqli_fetch_assoc($run)){?>
													<option><?php echo $data['Year'];?></option><?php
												}?>
											</select>
										</div><?php
									}?>
								
									<button class = "col-sm-2 btn btn-info" name = "btnViewReport" type = "submit"><span class = "glyphicon glyphicon-th-list"></span> View</button>
								</div>
							</form><?php
						}
								
						if(!isset($_POST['btnSelectView'])){?>
							<form class = "form-horizontal pull-right col-sm-8" method = "POST">
								<div class = "form-group col-sm-12 pull-right">
									<label class = "col-sm-1">From:</label>
									<div class = "col-sm-4">
										<input type = "text" class = "form-control" style = "font-size: 13px;" disabled>
									</div>
										
									<label class = "label-control col-sm-1">To: </label>
									<div class = "col-sm-4">
										<input type = "text" class = "form-control" style = "font-size: 13px;" disabled>
									</div>
										
									<button class = "col-sm-2 btn btn-info pull-right" type = "submit" disabled><span class = "glyphicon glyphicon-th-list"></span> View</button>
								</div>
							</form><?php
						}?>
				</div><?php
					
				if(!isset($_POST['btnViewReport']) && !isset($_POST['btnSelectView'])){?>
					<div class = "col-sm-12">
						<div style = "overflow-y: scroll; height: 220px;">
							<table id = "dspTblReports" class = "table table-condensed col-sm-12">
								<tr>
									<th>Date</th>
									<th>Day</th>
									<th>Menu ID</th>
									<th>Menu Name</th>
									<th>Size</th>
									<th>Qty</th>
									<th>VAT</th>
									<th>Selling Price</th>
									<th>Total</th>
								</tr><?php
										
								$query = "SELECT DISTINCT DatePurchased, MenuID, MenuName, Size, SUM(Qty) AS Qty, VAT, SellingPrice, SUM(Total) AS Total FROM tblPurchase WHERE DatePurchased != '0000-00-00' AND TimePurchased != '00:00:00' GROUP BY DatePurchased, MenuName, Size;";
								$run = mysqli_query($con, $query);
										
								while($data = mysqli_fetch_assoc($run)){
									$Date = strtotime($data['DatePurchased']);
									$wordDate = date("M-j-Y", $Date);
									$Day = date("D", $Date);
									$VAT = $data['VAT'];
									$SellingPrice = $data['SellingPrice'];
									$Total = $data['Total'];?>
									<tr class = "hoverTable">
										<td><?php echo $wordDate;?></td>
										<td><?php echo $Day;?></td>
										<td><?php echo $data['MenuID'];?></td>
										<td><?php echo $data['MenuName'];?></td>
										<td><?php echo $data['Size'];?></td>
										<td><?php echo $data['Qty'];?></td>
										<td>P <?php echo number_format($VAT, 2);?></td>
										<td>P <?php echo number_format($SellingPrice, 2);?></td>
										<td><b>P <?php echo number_format($Total, 2);?></b></td>
									</tr><?php
								}?>
							</table>
						</div></br><?php
						
						$rowCount = mysqli_num_rows($run);?>
						<b class = "pull-right" style = "font-size: 16px;">Records found: <?php echo $rowCount;?></b></br></br><?php
						$queryFirst = "SELECT DatePurchased FROM tblPurchase WHERE DatePurchased != '0000-00-00' AND TimePurchased != '00:00:00' ORDER BY DatePurchased ASC LIMIT 1;";
						$runFirst = mysqli_query($con, $queryFirst);
						$data = mysqli_fetch_assoc($runFirst);
						$date = strtotime($data['DatePurchased']);	
						$FirstDate = date("M j, Y", $date);

						$queryLast = "SELECT DatePurchased FROM tblPurchase WHERE DatePurchased != '0000-00-00' AND TimePurchased != '00:00:00' ORDER BY DatePurchased DESC LIMIT 1;";
						$runLast = mysqli_query($con, $queryLast);
						$data = mysqli_fetch_assoc($runLast);
						$date = strtotime($data['DatePurchased']);	
						$LastDate = date("M j, Y", $date);
									
						$query = "SELECT SUM(Total) AS Total FROM tblPurchase WHERE DatePurchased != '0000-00-00' AND TimePurchased != '00:00:00';";
						$run = mysqli_query($con, $query);
						$data = mysqli_fetch_assoc($run);
						$TotalSales = $data['Total'];?>
							
						<div class = "col-sm-12 pull-right" style = "text-align: right;">
							<b>Total Sales from <?php echo $FirstDate;?> to <?php echo $LastDate?>:</b>&nbsp;
							<span class = "label label-success pull-right" style = "font-size: 13px;">P <?php echo number_format($TotalSales, 2);?></span>
						</div>
					</div></br></br><?php
				}
					
				if(!empty($_POST['cmbSelectView'])){?>
					<div class = "col-sm-12">
						<div style = "overflow-y: scroll; height: 220px;">
							<table id = "dspTblReports" class = "table table-condensed col-sm-12"><?php
								if($_POST['cmbSelectView'] == "custom"){?>
									<tr>
										<th>Date</th>
										<th>Day</th>
										<th>Menu ID</th>
										<th>Menu Name</th>
										<th>Size</th>
										<th>Qty</th>
										<th>VAT</th>
										<th>Selling Price</th>
										<th>Total</th>
									</tr><?php
											
									$query = "SELECT DISTINCT DatePurchased, MenuID, MenuName, Size, SUM(Qty) AS Qty, SellingPrice, VAT, SUM(Total) AS Total FROM tblPurchase WHERE DatePurchased != '0000-00-00' AND TimePurchased != '00:00:00' GROUP BY DatePurchased, MenuName, Size;";
									$run = mysqli_query($con, $query);
											
										while($data = mysqli_fetch_assoc($run)){
											$Date = strtotime($data['DatePurchased']);
											$wordDate = date("M-j-Y", $Date);
											$Day = date("D", $Date);
											$VAT = $data['VAT'];
											$SellingPrice = $data['SellingPrice'];
											$Total = $data['Total'];?>
											<tr class = "hoverTable">
												<td><?php echo $wordDate;?></td>
												<td><?php echo $Day;?></td>
												<td><?php echo $data['MenuID'];?></td>
												<td><?php echo $data['MenuName'];?></td>
												<td><?php echo $data['Size'];?></td>
												<td><?php echo $data['Qty'];?></td>
												<td>P <?php echo number_format($VAT, 2);?></td>
												<td>P <?php echo number_format($SellingPrice, 2);?></td>
												<td><b>P <?php echo number_format($Total, 2);?></b></td>
											</tr><?php
										}?>
									</table>		
									</div></br><?php
									$rowCount = mysqli_num_rows($run);?>
									<b class = "pull-right" style = "font-size: 16px;">Records found: <?php echo $rowCount;?></b></br></br><?php
											
									$queryFirst = "SELECT DISTINCT DatePurchased FROM tblPurchase WHERE DatePurchased != '0000-00-00' AND TimePurchased != '00:00:00' ORDER BY DatePurchased ASC LIMIT 1;";
									$runFirst = mysqli_query($con, $queryFirst);
									$data = mysqli_fetch_assoc($runFirst);
									$date = strtotime($data['DatePurchased']);	
									$FirstDate = date("M j, Y", $date);

									$queryLast = "SELECT DISTINCT DatePurchased FROM tblPurchase WHERE DatePurchased != '0000-00-00' AND TimePurchased != '00:00:00' ORDER BY DatePurchased DESC LIMIT 1;";
									$runLast = mysqli_query($con, $queryLast);
									$data = mysqli_fetch_assoc($runLast);
									$date = strtotime($data['DatePurchased']);	
									$LastDate = date("M j, Y", $date);
											
									$query = "SELECT SUM(Total) AS Total FROM tblPurchase WHERE DatePurchased != '0000-00-00' AND TimePurchased != '00:00:00';";
									$run = mysqli_query($con, $query);
									$data = mysqli_fetch_assoc($run);
									$TotalSales = $data['Total'];?>
									
									<div class = "col-sm-12 pull-right" style = "text-align: right;"><?php
										if($FirstDate == $LastDate){?>
											<b>Total Sales of <?php echo $FirstDate;?>:</b>&nbsp;
											<span class = "label label-success pull-right" style = "font-size: 13px;">P <?php echo number_format($TotalSales, 2);?></span><?php
										}
										
										else{?>
											<b>Total Sales from <?php echo $FirstDate;?> to <?php echo $LastDate?>:</b>&nbsp;
											<span class = "label label-success pull-right" style = "font-size: 13px;">P <?php echo number_format($TotalSales, 2);?></span><?php
										}?>
									</div><?php
								}
								
								if($_POST['cmbSelectView'] == "monthly"){?>
									<tr>
										<th>Month</th>
										<th>Menu ID</th>
										<th>Menu Name</th>
										<th>Size</th>
										<th>Qty</th>
										<th>VAT</th>
										<th>Selling Price</th>
										<th>Total</th>
									</tr><?php
												
									$query = "SELECT DISTINCT EXTRACT(MONTH FROM DatePurchased) AS Month, DatePurchased, MenuID, MenuName, Size, SUM(Qty) AS Qty, SellingPrice, VAT, SUM(Total) AS Total FROM tblPurchase WHERE DatePurchased != '0000-00-00' AND TimePurchased != '00:00:00' GROUP BY MenuName, Size;";
									$run = mysqli_query($con, $query);
									
									while($data = mysqli_fetch_assoc($run)){
										$monthNum = strtotime($data['DatePurchased']);
										$MonthTotal = $data['Total'];?>
										<tr>
											<td><?php echo date("F", $monthNum);?></td>
											<td><?php echo $data['MenuID'];?></td>
											<td><?php echo $data['MenuName'];?></td>
											<td><?php echo $data['Size'];?></td>
											<td><?php echo $data['Qty'];?></td>
											<td>P <?php echo $data['VAT'];?></td>
											<td>P <?php echo $data['SellingPrice'];?></td>
											<td><b>P <?php echo number_format($MonthTotal, 2);?></b></td>
										</tr><?php
									}?>
									</table>		
									</div></br><?php
									$rowCount = mysqli_num_rows($run);?>
									<b class = "pull-right" style = "font-size: 16px;">Records found: <?php echo $rowCount;?></b></br></br><?php
											
									$queryFirst = "SELECT DISTINCT EXTRACT(MONTH FROM DatePurchased) AS Month, DatePurchased FROM tblPurchase WHERE DatePurchased != '0000-00-00' AND TimePurchased != '00:00:00' ORDER BY DatePurchased ASC LIMIT 1;";
									$runFirst = mysqli_query($con, $queryFirst);
									$data = mysqli_fetch_assoc($runFirst);
									$date = strtotime($data['DatePurchased']);	
									$FirstMonth = date("F", $date);

									$queryLast = "SELECT DISTINCT EXTRACT(MONTH FROM DatePurchased) AS Month, DatePurchased FROM tblPurchase WHERE DatePurchased != '0000-00-00' AND TimePurchased != '00:00:00' ORDER BY DatePurchased DESC LIMIT 1;";
									$runLast = mysqli_query($con, $queryLast);
									$data = mysqli_fetch_assoc($runLast);
									$date = strtotime($data['DatePurchased']);	
									$LastMonth = date("F", $date);
											
									$query = "SELECT SUM(Total) AS Total FROM tblPurchase WHERE DatePurchased != '0000-00-00' AND TimePurchased != '00:00:00';";
									$run = mysqli_query($con, $query);
									$data = mysqli_fetch_assoc($run);
									$TotalSales = $data['Total'];?>
									
									<div class = "col-sm-12 pull-right" style = "text-align: right;"><?php
										if($FirstMonth == $LastMonth){?>
											<b>Total Sales of <?php echo $FirstMonth;?>:</b>&nbsp;
											<span class = "label label-success pull-right" style = "font-size: 13px;">P <?php echo number_format($TotalSales, 2);?></span><?php
										}
										
										else{?>
											<b>Total Sales from <?php echo $FirstMonth;?> to <?php echo $LastMonth?>:</b>&nbsp
											<span class = "label label-success pull-right" style = "font-size: 13px;">P <?php echo number_format($TotalSales, 2);?></span><?php
										}?>
									</div><?php
								}
										
								if($_POST['cmbSelectView'] == "annually"){?>
									<tr>
										<th>Year</th>
										<th>Menu ID</th>
										<th>Menu Name</th>
										<th>Size</th>
										<th>Qty</th>
										<th>VAT</th>
										<th>Selling Price</th>
										<th>Total</th>
									</tr><?php
												
									$query = "SELECT DISTINCT EXTRACT(YEAR FROM DatePurchased) AS Month, DatePurchased, MenuID, MenuName, Size, SUM(Qty) AS Qty, SellingPrice, VAT, SUM(Total) AS Total FROM tblPurchase WHERE DatePurchased != '0000-00-00' AND TimePurchased != '00:00:00' GROUP BY MenuName, Size;";
									$run = mysqli_query($con, $query);
									
									while($data = mysqli_fetch_assoc($run)){
										$monthNum = strtotime($data['DatePurchased']);
										$YearTotal = $data['Total'];?>
										<tr>
											<td><?php echo date("Y", $monthNum);?></td>
											<td><?php echo $data['MenuID'];?></td>
											<td><?php echo $data['MenuName'];?></td>
											<td><?php echo $data['Size'];?></td>
											<td><?php echo $data['Qty'];?></td>
											<td>P <?php echo $data['VAT'];?></td>
											<td>P <?php echo $data['SellingPrice'];?></td>
											<td><b>P <?php echo number_format($YearTotal, 2);?></b></td>
										</tr><?php
									}?>
									</table>		
									</div></br><?php
									$rowCount = mysqli_num_rows($run);?>
									<b class = "pull-right" style = "font-size: 16px;">Records found: <?php echo $rowCount;?></b></br></br><?php
											
									$queryFirst = "SELECT DISTINCT EXTRACT(YEAR FROM DatePurchased) AS Month, DatePurchased FROM tblPurchase WHERE DatePurchased != '0000-00-00' AND TimePurchased != '00:00:00' ORDER BY DatePurchased ASC LIMIT 1;";
									$runFirst = mysqli_query($con, $queryFirst);
									$data = mysqli_fetch_assoc($runFirst);
									$date = strtotime($data['DatePurchased']);	
									$FirstYear = date("Y", $date);

									$queryLast = "SELECT DISTINCT EXTRACT(YEAR FROM DatePurchased) AS Month, DatePurchased FROM tblPurchase WHERE DatePurchased != '0000-00-00' AND TimePurchased != '00:00:00' ORDER BY DatePurchased DESC LIMIT 1;";
									$runLast = mysqli_query($con, $queryLast);
									$data = mysqli_fetch_assoc($runLast);
									$date = strtotime($data['DatePurchased']);	
									$LastYear = date("Y", $date);
											
									$query = "SELECT SUM(Total) AS Total FROM tblPurchase WHERE DatePurchased != '0000-00-00' AND TimePurchased != '00:00:00';";
									$run = mysqli_query($con, $query);
									$data = mysqli_fetch_assoc($run);
									$TotalSales = $data['Total'];?>
									
									<div class = "col-sm-12 pull-right" style = "text-align: right"><?php
										if($FirstYear == $LastYear){?>
											<b>Total Sales of <?php echo $FirstYear;?>:</b>&nbsp;
											<span class = "label label-success pull-right" style = "font-size: 13px;">P <?php echo number_format($TotalSales, 2);?></span><?php
										}
										
										else{?>
											<b>Total Sales from <?php echo $FirstYear;?> to <?php echo $LastYear;?>:</b>&nbsp;
											<span class = "label label-success pull-right" style = "font-size: 13px;">P <?php echo number_format($TotalSales, 2);?></span><?php
										}?>
									</div><?php
								}?>
						</div>
					</div><?php
				}
				
				if(isset($_POST['btnViewReport'])){
					if(!empty($_POST['txtDateTo']) || !empty($_POST['cmbMonthTo']) || !empty($_POST['cmbYearTo'])){
						if(!empty($_POST['txtDateTo'])){?>
							<div class = "col-sm-12">
								<div style = "overflow-y: scroll; height: 220px;">
									<table id = "dspTblReports" class = "table table-condensed col-sm-12">
										<tr>
											<th>Date</th>
											<th>Day</th>
											<th>Menu ID</th>
											<th>Menu Name</th>
											<th>Size</th>
											<th>Qty</th>
											<th>VAT</th>
											<th>Selling Price</th>
											<th>Total</th>
										</tr><?php
										
										$DateFrom = $_POST['txtDateFrom'];
										$DateTo = $_POST['txtDateTo'];
										
										$query = "SELECT DISTINCT DatePurchased, MenuID, MenuName, Size, SUM(Qty) AS Qty, SellingPrice, VAT, SUM(Total) AS Total FROM tblPurchase WHERE DatePurchased BETWEEN '$DateFrom' AND '$DateTo' AND (DatePurchased != '0000-00-00' AND TimePurchased != '00:00:00') GROUP BY DatePurchased, MenuName, Size;";
										$run = mysqli_query($con, $query);
												
										while($data = mysqli_fetch_assoc($run)){
											$Date = strtotime($data['DatePurchased']);
											$wordDate = date("M-j-Y", $Date);
											$Day = date("D", $Date);
											$VAT = $data['VAT'];
											$Price = $data['SellingPrice'];
											$Total = $data['Total'];?>
											<tr class = "hoverTable">
												<td><?php echo $wordDate;?></td>
												<td><?php echo $Day;?></td>
												<td><?php echo $data['MenuID'];?></td>
												<td><?php echo $data['MenuName'];?></td>
												<td><?php echo $data['Size'];?></td>
												<td><?php echo $data['Qty'];?></td>
												<td>P <?php echo number_format($VAT, 2);?></td>
												<td>P <?php echo number_format($Price, 2);?></td>
												<td><b>P <?php echo number_format($Total, 2);?></b></td>
											</tr><?php
										}?>
										</table>		
										</div></br><?php
										$rowCount = mysqli_num_rows($run);?>
										<b class = "pull-right" style = "font-size: 16px;">Records found: <?php echo $rowCount;?></b></br></br><?php
												
										$queryFirst = "SELECT DISTINCT DatePurchased FROM tblPurchase WHERE DatePurchased BETWEEN '$DateFrom' AND '$DateTo' AND (DatePurchased != '0000-00-00' AND TimePurchased != '00:00:00') ORDER BY DatePurchased ASC LIMIT 1;";
										$runFirst = mysqli_query($con, $queryFirst);
										$data = mysqli_fetch_assoc($runFirst);
										$date = strtotime($data['DatePurchased']);	
										$FirstDate = date("M j, Y", $date);

										$queryLast = "SELECT DISTINCT DatePurchased FROM tblPurchase WHERE DatePurchased BETWEEN '$DateFrom' AND '$DateTo' AND (DatePurchased != '0000-00-00' AND TimePurchased != '00:00:00') ORDER BY DatePurchased DESC LIMIT 1;";
										$runLast = mysqli_query($con, $queryLast);
										$data = mysqli_fetch_assoc($runLast);
										$date = strtotime($data['DatePurchased']);	
										$LastDate = date("M j, Y", $date);
												
										$query = "SELECT SUM(Total) AS Total FROM tblPurchase WHERE DatePurchased BETWEEN '$DateFrom' AND '$DateTo' AND (DatePurchased != '0000-00-00' AND TimePurchased != '00:00:00');";
										$run = mysqli_query($con, $query);
										$data = mysqli_fetch_assoc($run);
										$TotalSales = $data['Total'];?>
										
										<div class = "col-sm-12 pull-right" style = "text-align: right;"><?php
											if($FirstDate == $LastDate){?>
												<b>Total Sales of <?php echo $FirstDate;?>:</b>&nbsp;
												<span class = "label label-success pull-right" style = "font-size: 13px;">P <?php echo number_format($TotalSales, 2);?></span><?php
											}
											
											else{?>
												<b>Total Sales from <?php echo $FirstDate;?> to <?php echo $LastDate?>:</b>&nbsp;
												<span class = "label label-success pull-right" style = "font-size: 13px;">P <?php echo number_format($TotalSales, 2);?></span><?php
											}?>
										</div>
								</div>
							</div><?php
						}
						
						if(!empty($_POST['cmbMonthTo'])){?>
							<div class = "col-sm-12">
								<div style = "overflow-y: scroll; height: 220px;">
									<table id = "dspTblReports" class = "table table-condensed col-sm-12">
										<tr>
											<th>Month</th>
											<th>Menu ID</th>
											<th>Menu Name</th>
											<th>Size</th>
											<th>Qty</th>
											<th>VAT</th>
											<th>Selling Price</th>
											<th>Total</th>
										</tr><?php
										
										$cmbMonthFrom = $_POST['cmbMonthFrom'];
										$cmbMonthTo = $_POST['cmbMonthTo'];
										
										$MonthFrom = date("Y-$cmbMonthFrom-01");
										$MonthTo = date("Y-$cmbMonthTo-31");
										
										$query = "SELECT DISTINCT EXTRACT(MONTH FROM DatePurchased) AS Month, DatePurchased, MenuID, MenuName, Size, SUM(Qty) AS Qty, SellingPrice, VAT, SUM(Total) AS Total FROM tblPurchase WHERE DatePurchased BETWEEN '$MonthFrom' AND '$MonthTo' AND (DatePurchased != '0000-00-00' AND TimePurchased != '00:00:00') GROUP BY MenuName, Size";
										$run = mysqli_query($con, $query);
										
										while($data = mysqli_fetch_assoc($run)){
											$monthNum = strtotime($data['DatePurchased']);
											$VAT = $data['VAT'];
											$SellingPrice = $data['SellingPrice'];
											$MonthTotal = $data['Total'];?>
											<tr class = "hoverTable">
												<td><?php echo date("F", $monthNum);?></td>
												<td><?php echo $data['MenuID'];?></td>
												<td><?php echo $data['MenuName'];?></td>
												<td><?php echo $data['Size'];?></td>
												<td><?php echo $data['Qty'];?></td>
												<td>P <?php echo number_format($VAT, 2);?></td>
												<td>P <?php echo number_format($SellingPrice, 2);?></td>
												<td><b>P <?php echo number_format($MonthTotal, 2);?></b></td>
											</tr><?php
										}?>
										</table>		
										</div></br><?php
										$rowCount = mysqli_num_rows($run);?>
										<b class = "pull-right" style = "font-size: 16px;">Records found: <?php echo $rowCount;?></b></br></br><?php
												
										$queryFirst = "SELECT DISTINCT EXTRACT(MONTH FROM DatePurchased) AS Month, DatePurchased FROM tblPurchase WHERE DatePurchased BETWEEN '$MonthFrom' AND '$MonthTo' AND (DatePurchased != '0000-00-00' AND TimePurchased != '00:00:00') ORDER BY DatePurchased ASC LIMIT 1;";
										$runFirst = mysqli_query($con, $queryFirst);
										$data = mysqli_fetch_assoc($runFirst);
										$date = strtotime($data['DatePurchased']);	
										$FirstMonth = date("F", $date);

										$queryLast = "SELECT DISTINCT EXTRACT(MONTH FROM DatePurchased) AS Month, DatePurchased FROM tblPurchase WHERE DatePurchased BETWEEN '$MonthFrom' AND '$MonthTo' AND (DatePurchased != '0000-00-00' AND TimePurchased != '00:00:00') ORDER BY DatePurchased DESC LIMIT 1;";
										$runLast = mysqli_query($con, $queryLast);
										$data = mysqli_fetch_assoc($runLast);
										$date = strtotime($data['DatePurchased']);	
										$LastMonth = date("F", $date);
												
										$query = "SELECT SUM(Total) AS Total FROM tblPurchase WHERE DatePurchased BETWEEN '$MonthFrom' AND '$MonthTo' AND (DatePurchased != '0000-00-00' AND TimePurchased != '00:00:00');";
										$run = mysqli_query($con, $query);
										$data = mysqli_fetch_assoc($run);
										$TotalSales = $data['Total'];?>
										
										<div class = "col-sm-12 pull-right" style = "text-align: right;"><?php
											if($FirstMonth == $LastMonth){?>
												<b>Total Sales of <?php echo $FirstMonth;?>:</b>&nbsp;
												<span class = "label label-success pull-right" style = "font-size: 13px;">P <?php echo number_format($TotalSales, 2);?></span><?php
											}
											
											else{?>
												<b>Total Sales from <?php echo $FirstMonth;?> to <?php echo $LastMonth?>:</b>&nbsp
												<span class = "label label-success pull-right" style = "font-size: 13px;">P <?php echo number_format($TotalSales, 2);?></span><?php
											}?>
										</div>
									</div><?php
						}
						
						if(!empty($_POST['cmbYearTo'])){?>
							<div class = "col-sm-12">
								<div style = "overflow-y: scroll; height: 220px;">
									<table id = "dspTblReports" class = "table table-condensed col-sm-12">
										<tr>
											<th>Year</th>
											<th>Menu ID</th>
											<th>Menu Name</th>
											<th>Size</th>
											<th>Qty</th>
											<th>VAT</th>
											<th>Selling Price</th>
											<th>Total</th>
										</tr><?php
										
										$cmbYearFrom = $_POST['cmbYearFrom'];
										$cmbYearTo = $_POST['cmbYearTo'];
										
										$YearFrom = date("$cmbYearFrom-01-01");
										$YearTo = date("$cmbYearTo-12-31");
															
										$query = "SELECT DISTINCT EXTRACT(YEAR FROM DatePurchased) AS Month, DatePurchased, MenuID, MenuName, Size, SUM(Qty) AS Qty, SellingPrice, VAT, SUM(Total) AS Total FROM tblPurchase WHERE DatePurchased BETWEEN '$YearFrom' AND '$YearTo' AND (DatePurchased != '0000-00-00' AND TimePurchased != '00:00:00') GROUP BY MenuName, Size;";
										$run = mysqli_query($con, $query);
												
										while($data = mysqli_fetch_assoc($run)){
											$monthNum = strtotime($data['DatePurchased']);
											$VAT = $data['VAT'];
											$SellingPrice = $data['SellingPrice'];
											$YearTotal = $data['Total'];?>
											<tr class = "hoverTable">
												<td><?php echo date("Y", $monthNum);?></td>
												<td><?php echo $data['MenuID'];?></td>
												<td><?php echo $data['MenuName'];?></td>
												<td><?php echo $data['Size'];?></td>
												<td><?php echo $data['Qty'];?></td>
												<td>P <?php echo number_format($VAT, 2);?></td>
												<td>P <?php echo number_format($SellingPrice, 2);?></td>
												<td><b>P <?php echo number_format($YearTotal, 2);?></b></td>
											</tr><?php
										}?>
									</table>		
								</div></br><?php
								$rowCount = mysqli_num_rows($run);?>
								<b class = "pull-right" style = "font-size: 16px;">Records found: <?php echo $rowCount;?></b></br></br><?php
														
								$queryFirst = "SELECT DISTINCT EXTRACT(YEAR FROM DatePurchased) AS Month, DatePurchased FROM tblPurchase WHERE DatePurchased BETWEEN '$YearFrom' AND '$YearTo' AND (DatePurchased != '0000-00-00' AND TimePurchased != '00:00:00') ORDER BY DatePurchased ASC LIMIT 1;";
								$runFirst = mysqli_query($con, $queryFirst);
								$data = mysqli_fetch_assoc($runFirst);
								$date = strtotime($data['DatePurchased']);	
								$FirstYear = date("Y", $date);

								$queryLast = "SELECT DISTINCT EXTRACT(YEAR FROM DatePurchased) AS Month, DatePurchased FROM tblPurchase WHERE DatePurchased BETWEEN '$YearFrom' AND '$YearTo' AND (DatePurchased != '0000-00-00' AND TimePurchased != '00:00:00') ORDER BY DatePurchased DESC LIMIT 1;";
								$runLast = mysqli_query($con, $queryLast);
								$data = mysqli_fetch_assoc($runLast);
								$date = strtotime($data['DatePurchased']);	
								$LastYear = date("Y", $date);
														
								$query = "SELECT SUM(Total) AS Total FROM tblPurchase WHERE DatePurchased BETWEEN '$YearFrom' AND '$YearTo' AND (DatePurchased != '0000-00-00' AND TimePurchased != '00:00:00');";
								$run = mysqli_query($con, $query);
								$data = mysqli_fetch_assoc($run);
								$TotalSales = $data['Total'];?>
												
								<div class = "col-sm-12 pull-right" style = "text-align: right"><?php
									if($FirstYear == $LastYear){?>
										<b>Total Sales of <?php echo $FirstYear;?>:</b>&nbsp;
										<span class = "label label-success pull-right" style = "font-size: 13px;">P <?php echo number_format($TotalSales, 2);?></span><?php
									}
													
									else{?>
										<b>Total Sales from <?php echo $FirstYear;?> to <?php echo $LastYear;?>:</b>&nbsp;
										<span class = "label label-success pull-right" style = "font-size: 13px;">P <?php echo number_format($TotalSales, 2);?></span><?php
									}?>
								</div>
							</div><?php
						}
					}
				}?>
			<!--Reports Coffee-->
			
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



