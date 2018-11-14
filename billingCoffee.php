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
						window.location.href = "billingCoffee.php";
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
			
			function getRowVal(row){
				var rowNum = row.rowIndex;
				var purchaseData = document.getElementById('tblPurchase').rows[rowNum].cells;
				txtRemoveMenuName.value = purchaseData[0].innerHTML;
				txtRemoveMenuSize.value = purchaseData[1].innerHTML;
				txtRemoveMenuQty.value = purchaseData[2].innerHTML;
			}
			
			$(function(){
				$('table #rowTable').click(function(){
					$(this).addClass('selectedRow').siblings().removeClass('selectedRow');
				});
				
				$('#btnRemovePurchase').on('click', function(){
					return confirm("Delete this item?");
					$('table #rowTable.selectedRow').remove();
				});
			});
		
			function generateChange(){
				var GrandTotal = document.getElementById("txtGrandTotal").value;
				var Cash = document.getElementById("txtCash").value;
				var Change = parseFloat(Cash) - parseFloat(GrandTotal);
				
				if(Change >= 0){
					txtChange.value = Change.toFixed(2);
				}
				
				else{
					txtChange.value = "";
				}
			};
			
			function getSize(){
				var sizeValue = document.getElementById("cmbSize").value;
				if(sizeValue == "small"){
					var regularPrice = document.getElementById("txtHiddenRegPrice").value;
					var smallPrice = parseInt(regularPrice) - (parseInt(regularPrice) * .30);
					txtPrice.value = smallPrice.toFixed(2);
					txtVAT.value = (smallPrice * .12).toFixed(2);
					txtSellingPrice.value = (smallPrice + (smallPrice * .12)).toFixed(2);
					txtTotal.value = (smallPrice + (smallPrice * .12)).toFixed(2);
				}
				
				if(sizeValue == "regular"){
					var regPrice = document.getElementById("txtHiddenRegPrice").value;
					var finalRegPrice = regPrice/1;
					txtPrice.value = finalRegPrice.toFixed(2);
					txtVAT.value = (finalRegPrice * .12).toFixed(2);
					txtSellingPrice.value = (finalRegPrice + (finalRegPrice * .12)).toFixed(2);
					txtTotal.value = (finalRegPrice + (finalRegPrice * .12)).toFixed(2);
				}
				
				if(sizeValue == "medium"){
					var regularPrice = document.getElementById("txtHiddenRegPrice").value;
					var medPrice = parseInt(regularPrice) + (parseInt(regularPrice) * .40);
					txtPrice.value = medPrice.toFixed(2);
					txtVAT.value = (medPrice * .12).toFixed(2);
					txtSellingPrice.value = (medPrice + (medPrice * .12)).toFixed(2);
					txtTotal.value = (medPrice + (medPrice * .12)).toFixed(2);
				}
				
				if(sizeValue == "large"){
					var regularPrice = document.getElementById("txtHiddenRegPrice").value;
					var medPrice = parseInt(regularPrice) + (parseInt(regularPrice) * .40);
					var largePrice = parseInt(medPrice) + (parseInt(regularPrice) * .40);
					txtPrice.value = largePrice.toFixed(2);
					txtVAT.value = (largePrice * .12).toFixed(2);
					txtSellingPrice.value = (largePrice + (largePrice * .12)).toFixed(2);
					txtTotal.value = (largePrice + (largePrice * .12)).toFixed(2);
				}
				
				if(sizeValue == "xlarge"){
					var regularPrice = document.getElementById("txtHiddenRegPrice").value;
					var medPrice = parseInt(regularPrice) + (parseInt(regularPrice) * .40);
					var largePrice = parseInt(medPrice) + (parseInt(regularPrice) * .40);
					var xlPrice = parseInt(largePrice) + (parseInt(regularPrice) * .40);
					txtPrice.value = xlPrice.toFixed(2);
					txtVAT.value = (xlPrice * .12).toFixed(2);
					txtSellingPrice.value = (xlPrice + (xlPrice * .12)).toFixed(2);
					txtTotal.value = (xlPrice + (xlPrice * .12)).toFixed(2);
				}
			};
			
			function getTotalAmount(){
				var txtQty = document.getElementById('txtQty').value;
				var txtSellingPrice = document.getElementById('txtSellingPrice').value;
				
				txtTotal.value = (txtQty * txtSellingPrice).toFixed(2);
			};
		</script>
		
		<style>
			.selectedRow{
				background-color: #edebeb;
			}
		</style>
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
						
						if($_SESSION['Type'] == "Staff" && $_SESSION['Category'] == "Front Desk"){?>
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
			
			<!--Billing Coffee-->
				<ul class = "nav nav-tabs"><?php
					if ($_SESSION['Type'] == "Staff"){?>
						<li class = "active pull-right"><a href = "billingCoffee.php">Billing</a></li><?php
					}
					
					else{?>
						<li class = "pull-right"><a href = "reportsCoffee.php">Reports</a></li>
						<li class = "active pull-right"><a href = "billingCoffee.php">Billing</a></li>	
						<li class = "pull-right"><a href = "menusCoffee.php">Menus</a></li><?php
					}?>
				</ul></br>
				
				<div class = "col-sm-5">
					<div class = "col-sm-12 panel panel-default" ></br>
						<form class = "form-horizontal" method = "POST">
							<div class = "col-sm-12">
								<div class = "form-group">
									<div class = "col-sm-9">
									<select class = "form-control" name = "cmbMenus"  required>
										<option value = "">-Choose a menu-</option>
										<?php
										include("connection.php");
										$querySelMenus = "SELECT DISTINCT CoffeeName FROM tblMenus WHERE Status = 'available' ORDER BY CoffeeName ASC;";
										$run = mysqli_query($con, $querySelMenus);
										
										while($menuList = mysqli_fetch_assoc($run)){
											$menus = $menuList['CoffeeName'];?>
											<option value = "<?php echo $menus; ?>"><?php echo $menus; ?></option><?php
										}
										?>
									</select>
									</div>
									<button class = " col-sm-3 btn btn-primary" name = "btnSelectMenu" id = "btnSelectMenu"><span class = "glyphicon glyphicon-ok"></span> Select</button>
								</div>
							</div>
						</form>
						<?php
							if(!empty($_POST['cmbMenus'])){?>
								<h4 id = "labelMenuName" class = "col-sm-12 control-label" style = "text-align: center"><?php echo $_POST['cmbMenus']?> </h4></br></br></br></br><?php
							}
							
							else{?>
								<h4 id = "labelMenuName" class = "col-sm-12 control-label" style = "text-align: center">Menu Name</h4></br></br></br></br><?php
							}
						?>
						<form method = "post">
							<div class = "form-group">
								<label class = "col-sm-4 control-label" style = "text-align: right">Size: </label>
								<div class = "col-sm-7">
									<select class = "form-control" id = "cmbSize" name = "cmbSize" onInput = "getSize()" required>
										<option value = ""></option>
										<?php
											if(isset($_POST['btnSelectMenu'])){
												$menuName = $_POST['cmbMenus'];
												$querySelSize = "SELECT Size FROM tblMenus WHERE CoffeeName = '$menuName' AND Status = 'available' ORDER BY find_in_set(Size, 'xlarge, large, medium, small');";
												$run = mysqli_query($con, $querySelSize);
													
												while($sizesList = mysqli_fetch_assoc($run)){
													$size = $sizesList['Size'];?>
													<option value = "<?php echo $size;?>"><?php echo "$size";?></option><?php
												}
											}
										?>
									</select></br>
								</div>
							</div>
							
							<?php
								if(isset($_POST['btnSelectMenu'])){
									$menuName = $_POST['cmbMenus'];
									$selectPriceReg = "SELECT Price, MenuID FROM tblMenus WHERE Size = 'regular' AND CoffeeName = '$menuName' AND Status = 'available'";
									$run = mysqli_query($con, $selectPriceReg);
									
									$result = mysqli_fetch_assoc($run);
									$regPrice = $result['Price'];
									$menuid = $result['MenuID'];?>
									
									<input type = "hidden" name = "txtHiddenMenuName" class = "form-control" value = "<?php echo $menuName;?>"></input>
									<input type = "hidden" name = "txtHiddenMenuID" class = "form-control" value = "<?php echo $menuid;?>"></input>
									<input type = "hidden" id = "txtHiddenRegPrice" class = "form-control" value = "<?php echo $regPrice;?>"></input><?php
								}
							?>
							<div class = "form-group">
								<label class = "col-sm-4 control-label" style = "text-align: right">Qty: </label>
								<div class = "col-sm-7">
									<input type = "number" id = "txtQty" name = "txtQty" class = "form-control" onInput = "getTotalAmount()" min = 1 required></input></br>
								</div>
							</div>
								
							<div class = "form-group">
								<label class = "col-sm-4 control-label" style = "text-align: right">Item Price: </label>
								<div class = "col-sm-7">
									<input type = "text" id  = "txtPrice" name = "txtPrice" class = "form-control" readonly></input></br>
								</div>
							</div>
							
							<div class = "form-group">
								<label class = "col-sm-4 control-label" style = "text-align: right">VAT (12%): </label>
								<div class = "col-sm-7">
									<input type = "text" id  = "txtVAT" name = "txtVAT" class = "form-control" readonly></input></br>
								</div>
							</div>
							
							<div class = "form-group">
								<label class = "col-sm-4 control-label" style = "text-align: right">Selling Price: </label>
								<div class = "col-sm-7">
									<input type = "text" id = "txtSellingPrice" name = "txtSellingPrice" class = "form-control" style = "font-weight: bold; size: 30px;" readonly></input></br>
								</div>
							</div>
							
							<div class = "form-group">
								<label class = "col-sm-4 control-label" style = "text-align: right">Total: </label>
								<div class = "col-sm-7">
									<input type = "text" id = "txtTotal" name = "txtTotal" class = "form-control" style = "font-weight: bold; size: 30px;" readonly></input></br>
								</div>
							</div>
							
							<div class = "form-group">
								<center><button type = "submit" class = "btn btn-success" name = "btnAddPurchase"><span class = "glyphicon glyphicon-plus"></span> Add Purchase</button></center>
							</div>
						</form>
					</div>
				</div>
				
				<div class = "col-sm-7">
					<div class = "col-sm-12">
						<?php
							//default display
							if(!isset($_POST['btnSelectMenu']) && !isset($_POST['btnAddPurchase']) && !isset($_POST['btnRemovePurchase'])){
								//select total for GRAND TOTAL
								$queSel = "SELECT SUM(Total) as GrandTotal FROM tblPurchase WHERE DatePurchased = '0000-00-00' AND TimePurchased = '00:00:00';";
								$run3 = mysqli_query($con, $queSel);?>
												
								<p style = "text-align: right; font-weight: bold; font-size: 20px;">Grand Total: P
									<?php
										$data = mysqli_fetch_assoc($run3);
										$GrandTotal = $data['GrandTotal'];
										echo number_format($GrandTotal, 2);
									?>
								</p>
				
								<div class = "scrollTable" style = "overflow-y: scroll; height: 290px;">
									<table id = "tblPurchase" class = "table table-condensed">
										<tr>
											<th>Item</th>
											<th>Size</th>
											<th>Qty</th>
											<th>Selling Price</th>
											<th>Total</th>
										</tr>
										
										<?php
										$querySelect = "SELECT * FROM tblPurchase WHERE DatePurchased = '0000-00-00' AND TimePurchased = '00:00:00';";
										$run = mysqli_query($con, $querySelect);
										
										while($data = mysqli_fetch_assoc($run)){
											$dbSellingPrice = $data['SellingPrice'];
											$dbMenuTotal = $data['Total'];?>
											
											<tr class = "hoverTable" id = "rowTable" onClick = "getRowVal(this)">
												<td id = "tdMenuName"><?php echo $data['MenuName'];?></td>
												<td id = "tdMenuSize"><?php echo $data['Size'];?></td>
												<td id = "tdMenuQty"><?php echo $data['Qty'];?></td>
												<td id = "tdMenuPrice"><?php echo "P"; echo number_format($dbSellingPrice, 2);?></td>
												<b><td id = "tdMenuTotal"><?php echo "P"; echo number_format($dbMenuTotal, 2);?></td></b>
											</tr><?php
										}?>
									</table>
								</div><?php
							}
							
							//check if btnSelectMenu is clicked
							if(isset($_POST['btnSelectMenu'])){
								//select total for GRAND TOTAL
								$queSel = "SELECT SUM(Total) as GrandTotal FROM tblPurchase WHERE DatePurchased = '0000-00-00' AND TimePurchased = '00:00:00';";
								$run = mysqli_query($con, $queSel);?>
												
								<p style = "text-align: right; font-weight: bold; font-size: 20px;">Grand Total:  P 
									<?php
										$data = mysqli_fetch_assoc($run);
										$GrandTotal = $data['GrandTotal'];
										echo number_format($GrandTotal, 2);
									?>
								</p>
									
								<div class = "scrollTable" style = "overflow-y: scroll; height: 290px;">
									<table id = "tblPurchase" class = "table table-condensed">
										<tr>
											<th>Item</th>
											<th>Size</th>
											<th>Qty</th>
											<th>Selling Price</th>
											<th>Total</th>
										</tr>
										<?php
											$querySelect = "SELECT * FROM tblPurchase WHERE DatePurchased = '0000-00-00' AND TimePurchased = '00:00:00';";
											$run = mysqli_query($con, $querySelect);	
											
											while($data = mysqli_fetch_assoc($run)){
												$dbSellingPrice = $data['SellingPrice'];
												$dbMenuTotal = $data['Total'];?>
													
												<tr class = "hoverTable" id = "rowTable" onClick = "getRowVal(this)">
													<td id = "tdMenuName"><?php echo $data['MenuName'];?></td>
													<td id = "tdMenuSize"><?php echo $data['Size'];?></td>
													<td id = "tdMenuQty"><?php echo $data['Qty'];?></td>
													<td id = "tdMenuPrice"><?php echo "P"; echo number_format($dbSellingPrice, 2);?></td>
													<b><td id = "tdMenuTotal"><?php echo "P"; echo number_format($dbMenuTotal, 2);?></td></b>
												</tr><?php
											}
										?>
									</table>
								</div><?php
							}
							
							//check if btnAddPurchase is clicked
							if(isset($_POST['btnAddPurchase'])){
								$MenuID = $_POST['txtHiddenMenuID'];
								$MenuName = $_POST['txtHiddenMenuName'];
								$MenuSize = $_POST['cmbSize'];
								$MenuQty = $_POST['txtQty'];
								$Price = $_POST['txtPrice'];
								$VAT = $_POST['txtVAT'];
								$SellingPrice = $_POST['txtSellingPrice'];
								$Total = $_POST['txtTotal'];
										
								//check if size of the same menu exist to avoid duplication
								$queCheckSize = "SELECT Qty, SellingPrice, VAT FROM tblPurchase WHERE Size = '$MenuSize' AND MenuID = '$MenuID' AND MenuName = '$MenuName' AND DatePurchased = '0000-00-00' AND TimePurchased = '00:00:00';";
								$run = mysqli_query($con, $queCheckSize);
								
								if(mysqli_num_rows($run) > 0){
									//get the qty and price from tblPurchase
									$data = mysqli_fetch_assoc($run);
									$dbQty = $data['Qty'];
									$dbSellingPrice = $data['SellingPrice'];
									$dbVAT = $data['VAT'];
									
									//formulate a new total
									$newQty = $dbQty + $MenuQty;
									$newTotal = $dbSellingPrice * $newQty;
									
									//update new total
									$queUpdate = "UPDATE tblPurchase SET Qty = '$newQty', Total = '$newTotal' WHERE Size = '$MenuSize' AND MenuID = '$MenuID' AND MenuName = '$MenuName' AND DatePurchased = '0000-00-00' AND TimePurchased = '00:00:00';";
									$run = mysqli_query($con, $queUpdate);
											
									//--DISPLAY GRAND TOTAL AND TABLE--//
									$queSel = "SELECT SUM(Total) as GrandTotal FROM tblPurchase WHERE DatePurchased = '0000-00-00' AND TimePurchased = '00:00:00';";
									$run = mysqli_query($con, $queSel);?>
												
									<p style = "text-align: right; font-weight: bold; font-size: 20px;">Grand Total:  P
										<?php
											$data = mysqli_fetch_assoc($run);
											$GrandTotal = $data['GrandTotal'];
											echo number_format($GrandTotal, 2);
										?>
									</p>
										
									<div class = "scrollTable" style = "overflow-y: scroll; height: 290px;">
										<table id = "tblPurchase" class = "table table-condensed">
											<tr>
												<th>Item</th>
												<th>Size</th>
												<th>Qty</th>
												<th>SellingPrice</th>
												<th>Total</th>
											</tr><?php
											
											$querySelect = "SELECT * FROM tblPurchase WHERE DatePurchased = '0000-00-00' AND TimePurchased = '00:00:00';";
											$runSelect = mysqli_query($con, $querySelect);
											
											while($data = mysqli_fetch_assoc($runSelect)){
												$dbSellingPrice = $data['SellingPrice'];
												$dbMenuTotal = $data['Total'];?>
												
												<tr class = "hoverTable" id = "rowTable" onClick = "getRowVal(this)">
													<td id = "tdMenuName"><?php echo $data['MenuName'];?></td>
													<td id = "tdMenuSize"><?php echo $data['Size'];?></td>
													<td id = "tdMenuQty"><?php echo $data['Qty'];?></td>
													<td id = "tdMenuPrice"><?php echo "P"; echo number_format($dbSellingPrice, 2);?></td>
													<b><td id = "tdMenuTotal"><?php echo "P"; echo number_format($dbMenuTotal, 2);?></td></b>
												</tr><?php
											}?>
										</table>
									</div><?php
								}
										
								else{
									//Select tblPurchase, count the num of rows
									$querySelTable = "SELECT DISTINCT OrderNo FROM tblPurchase WHERE DatePurchased != '0000-00-00' AND TimePurchased != '00:00:00';";
									$run = mysqli_query($con, $querySelTable);
									$maxCountofRow = mysqli_num_rows($run);
									
									$countPlus = $maxCountofRow + 1;
									$queIns = "INSERT INTO tblPurchase(OrderNo, MenuID, MenuName, Size, Qty, ItemPrice, VAT, SellingPrice, Total) VALUES('Ord#$countPlus', '$MenuID', '$MenuName', '$MenuSize', '$MenuQty', '$Price', '$VAT', '$SellingPrice', '$Total');";
									$run = mysqli_query($con, $queIns);
									
									//select total for GRAND TOTAL
									$queSel = "SELECT SUM(Total) as GrandTotal FROM tblPurchase WHERE DatePurchased = '0000-00-00' AND TimePurchased =  '00:00:00';";
									$run = mysqli_query($con, $queSel);?>
												
									<p style = "text-align: right; font-weight: bold; font-size: 20px;">Grand Total:  P
										<?php
											$data = mysqli_fetch_assoc($run);
											$GrandTotal = $data['GrandTotal'];
											echo number_format($GrandTotal, 2);
										?>
									</p><?php?>
										
									<div class = "scrollTable" style = "overflow-y: scroll; height: 290px;">
										<table id = "tblPurchase" class = "table table-condensed">
											<tr>
												<th>Item</th>
												<th>Size</th>
												<th>Qty</th>
												<th>Selling Price</th>
												<th>Total</th>
											</tr><?php
											
											$querySelect = "SELECT * FROM tblPurchase WHERE DatePurchased = '0000-00-00' AND TimePurchased = '00:00:00';";
											$run = mysqli_query($con, $querySelect);
											
											while($data = mysqli_fetch_assoc($run)){
												$dbSellingPrice = $data['SellingPrice'];
												$dbMenuTotal = $data['Total'];?>
												
												<tr class = "hoverTable" id = "rowTable" onClick = "getRowVal(this)">
													<td id = "tdMenuName"><?php echo $data['MenuName'];?></td>
													<td id = "tdMenuSize"><?php echo $data['Size'];?></td>
													<td id = "tdMenuQty"><?php echo $data['Qty'];?></td>
													<td id = "tdMenuPrice"><?php echo "P"; echo number_format($dbSellingPrice, 2);?></td>
													<b><td id = "tdMenuTotal"><?php echo "P"; echo number_format($dbMenuTotal, 2);?></td></b>
												</tr><?php
											}?>
										</table>
									</div><?php
								} 
							}
							
							if(isset($_POST['btnRemovePurchase'])){
								$removeMenuName = $_POST['txtRemoveMenuName'];
								$removeMenuSize = $_POST['txtRemoveMenuSize'];
								$removeMenuQty = $_POST['txtRemoveMenuQty'];
							
								$query = "DELETE FROM tblPurchase WHERE MenuName = '$removeMenuName' AND Size = '$removeMenuSize' AND Qty = '$removeMenuQty' AND DatePurchased = '0000-00-00' AND TimePurchased = '00:00:00'";
								$run = mysqli_query($con, $query);
								
								//select total for GRAND TOTAL
								$queSel = "SELECT SUM(Total) as GrandTotal FROM tblPurchase WHERE DatePurchased = '0000-00-00' AND TimePurchased = '00:00:00';";
								$run3 = mysqli_query($con, $queSel);?>
												
								<p style = "text-align: right; font-weight: bold; font-size: 20px;">Grand Total: P
									<?php
										$data = mysqli_fetch_assoc($run3);
										$GrandTotal = $data['GrandTotal'];
										echo number_format($GrandTotal, 2);
									?>
								</p>
				
								<div class = "scrollTable" style = "overflow-y: scroll; height: 290px;">
									<table id = "tblPurchase" class = "table table-condensed">
										<tr>
											<th>Item</th>
											<th>Size</th>
											<th>Qty</th>
											<th>Selling Price</th>
											<th>Total</th>
										</tr>
										
										<?php
										$querySelect = "SELECT * FROM tblPurchase WHERE DatePurchased = '0000-00-00' AND TimePurchased = '00:00:00';";
										$run = mysqli_query($con, $querySelect);
										
										while($data = mysqli_fetch_assoc($run)){
											$dbSellingPrice = $data['SellingPrice'];
											$dbMenuTotal = $data['Total'];?>
											
											<tr class = "hoverTable" id = "rowTable" onClick = "getRowVal(this)">
												<td id = "tdMenuName"><?php echo $data['MenuName'];?></td>
												<td id = "tdMenuSize"><?php echo $data['Size'];?></td>
												<td id = "tdMenuQty"><?php echo $data['Qty'];?></td>
												<td id = "tdMenuPrice"><?php echo "P"; echo number_format($dbSellingPrice, 2);?></td>
												<b><td id = "tdMenuTotal"><?php echo "P"; echo number_format($dbMenuTotal, 2);?></td></b>
											</tr><?php
										}?>
									</table>
								</div><?php
							}
						?>
						</br>
						
						<?php
							$queTotal = "SELECT SUM(Total) as GrandTotal FROM tblPurchase WHERE DatePurchased = '0000-00-00' AND TimePurchased = '00:00:00';";
							$run = mysqli_query($con, $queTotal);
							
							$data = mysqli_fetch_assoc($run);
							$GrandTotal = $data['GrandTotal'];
							
							if(!empty($GrandTotal)){?>
								<div class = "col-sm-7"></div>
								<button data-toggle = "modal" href = "#orderCoffee"  style = "width: 100px;" class = "col-sm-2 btn btn-primary" id = "btnOrder" name = "btnOrder"><span class = "glyphicon glyphicon-shopping-cart"></span> Order</button>
								<form method = "POST" class = "pull-right">
									<input type = "hidden" id = "txtRemoveMenuName" name = "txtRemoveMenuName"/>
									<input type = "hidden" id = "txtRemoveMenuSize" name = "txtRemoveMenuSize"/>
									<input type = "hidden" id = "txtRemoveMenuQty" name = "txtRemoveMenuQty"/>
									<button id = "btnRemovePurchase" name = "btnRemovePurchase" class = "btn btn-danger"><span class = "glyphicon glyphicon-remove"></span> Remove</button>	
								</form><?php
							}
							
							else{?>
								<div class = "col-sm-7"></div>
								<button style = "width: 100px;" class = "col-sm-2 btn btn-primary" disabled><span class = "glyphicon glyphicon-shopping-cart"></span> Order</button>
								<form method = "POST" class = "pull-right">
									<button class = "btn btn-danger" disabled><span class = "glyphicon glyphicon-remove"></span> Remove</button>	
								</form><?php
							}
						?>
					</div>
				</div>
			<!--Billing Coffee-->
			
			<!--Order Modal-->
			<center>
			<div class = "modal fade" id = "orderCoffee">
				<div class = "modal-dialog">
					<div class = "modal-content" style = "width: 70%;">
						<div class = "modal-header">
							<h4><b><span class = "glyphicon glyphicon-edit"></span> Payment Order</b>
							<button type = "button" class = "close" data-dismiss = "modal">
								&times;
							</button></h4>
						</div>
						
						<form class = "form-horizontal" action = "payOrder.php">
							<div class = "modal-body">
								<div class="form-group">
									<label class="col-sm-5 control-label">Grand Total: </label>
									<div class="col-sm-6"><?php
										//select total for GRAND TOTAL
										$queGrandTotal = "SELECT SUM(Total) as GrandTotal FROM tblPurchase WHERE DatePurchased = '0000-00-00' AND TimePurchased = '00:00:00';";
										$run = mysqli_query($con, $queGrandTotal);
										
										$data = mysqli_fetch_assoc($run);
										$GrandTotal = $data['GrandTotal'];
										?>
										
										<input id = "txtGrandTotal" name = "txtGrandTotal" type = "text" class = "form-control" style = "font-weight: bold;" value = "<?php echo $GrandTotal;?>" readonly>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-5 control-label">Cash: </label>
									<div class="col-sm-6">
										<input id = "txtCash" name = "txtCash" type = "number" class = "form-control" onInput = "generateChange()" step = "0.01" min = <?php echo $GrandTotal;?> required>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-5 control-label">Change: </label>
									<div class="col-sm-6">
										<input id = "txtChange" name = "txtChange" type = "text" class = "form-control" readonly min = 0>
									</div>
								</div>
							</div>
							
							<div class = "modal-footer">
								<button class = "btn btn-success" id = "txtDone" type = "submit">Done</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			</center>
			<!--Order Modal-->
			
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
			<div class="navbar" id  = "bgFooter">
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