<?php SESSION_START();?>
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
			include("connection.php");
		?>
		<script>
			var timer = setInterval(function(){MyTimer()}, 1000);
			
			function MyTimer(){
				var Time = new Date();
				document.getElementById("displayDate").innerHTML = Time.toLocaleDateString();
				document.getElementById("displayTime").innerHTML = Time.toLocaleTimeString();
			};
			
			function getCheckInDate(){
				var checkIn = $("#txtCheckIn").val();
				var newDate = new Date(checkIn);
				
				var addOneDay = new Date(newDate.setDate(newDate.getDate() + 1));
				var finalNewDate = addOneDay.getFullYear() + '-' + (('0' + (addOneDay.getMonth() + 1)).slice(-2)) + '-' + (('0' + (addOneDay.getDate())).slice(-2));
				
				document.getElementById("txtCheckOut").min = finalNewDate;
			};
			
			function computePayment(){
				var DateIn = new Date(document.getElementById('txtDateIn').value);
				var DateOut = new Date(document.getElementById('txtDateOut').value);
				var RmRate = document.getElementById('txtRmRate').value;
				var RmCharge = document.getElementById('txtRmCharge').value;
				var Children = document.getElementById('txtCountChildren').value;
				var Adult = document.getElementById('txtCountAdult').value;
				
				var DateDiff = DateOut.getDate() - DateIn.getDate();
							
				if(Children <= 2 && Adult <= 1){
					var addCharge = 0;
					txtGrandTotal.value = ((RmRate * DateDiff)).toFixed(2);
					var GrandTotal = (RmRate * DateDiff);
					txtDownPay.value = (GrandTotal - (GrandTotal * .5)).toFixed(2);
					paypalDownPayment.value = (GrandTotal - (GrandTotal * .5)).toFixed(2);
				}
				
				else{
					var CountChildren = Children - 2;
					var CountAdult = Adult - 1;
					
					if(CountChildren < 0 || CountAdult < 0){
						if(CountChildren < 0){
							var addCharge = CountAdult * RmCharge;
							txtGrandTotal.value = ((DateDiff * RmRate) + addCharge).toFixed(2);
							var GrandTotal = (DateDiff * RmRate) + addCharge;
							txtDownPay.value = (GrandTotal - (GrandTotal * .5)).toFixed(2);
							paypalDownPayment.value = (GrandTotal - (GrandTotal * .5)).toFixed(2);
						}
						
						else{
							var addCharge = CountChildren * RmCharge;
							txtGrandTotal.value = ((DateDiff * RmRate) + addCharge).toFixed(2);
							var GrandTotal = (DateDiff * RmRate) + addCharge;
							txtDownPay.value = (GrandTotal - (GrandTotal * .5)).toFixed(2);
							paypalDownPayment.value = (GrandTotal - (GrandTotal * .5)).toFixed(2);
						}
					}
					
					else{
						var addCharge = (CountChildren + CountAdult) * RmCharge;
						txtGrandTotal.value = ((DateDiff * RmRate) + addCharge).toFixed(2);
						var GrandTotal = (DateDiff * RmRate) + addCharge;
						txtDownPay.value = (GrandTotal - (GrandTotal * .5)).toFixed(2);
						paypalDownPayment.value = (GrandTotal - (GrandTotal * .5)).toFixed(2);
					}
				}
			}
		</script>
    </head>
	
    <body><?php
		if(isset($_POST['btnPayment'])){
			//get all the customer details
			$CustID = $_POST['txtCustID'];
			$LName = $_POST['txtLastName'];
			$FName = $_POST['txtFirstName'];
			$Gender = $_POST['cmbGender'];
			$Age = $_POST['txtAge'];
			$Email = $_POST['txtEmailAdd'];
			$ContactNo = $_POST['txtContactNo'];
			$RmType = $_SESSION['RoomType'];
			$CheckIn = $_SESSION['dbDateIn'];
			$CheckOut = $_SESSION['dbDateOut'];
			$Children = $_POST['txtCountChildren'];
			$Adult = $_POST['txtCountAdult'];
			$Downpayment = $_POST['txtDownPay'];
			
			//set status
			$Status = "Pending 50%";
			
			$queSelect = "SELECT * FROM tblRoomType WHERE Name = '$RmType' AND Status = 'available';";
			$run = mysqli_query($con, $queSelect);
			
			//get Rate and Charge
			$data = mysqli_fetch_assoc($run);
			$RmRate = $data['Rate'];
			$Charge = $data['Charge'];
			
			//days from checkout and checkin
			$Days = (strtotime($CheckOut) - strtotime($CheckIn))/(60*60*24);
			
			//NO CHARGE
			if($Children <= 2 && $Adult <= 1){
				$AdditionalPay = 0;
				$TotalPayment = $Days * $RmRate;
			}
			
			//ADD CHARGE
			//possible TRUE and FALSE, FALSE and TRUE, FALSE and FALSE
			else{
				$CountChildren = $Children - 2;
				$CountAdult = $Adult - 1;
				
				//TRUE and FALSE || FALSE and True
				if($CountChildren < 0 || $CountAdult < 0){
					if($CountChildren < 0){
						$AdditionalPay = $CountAdult * $Charge;
						$TotalPayment = ($Days * $RmRate) + $AdditionalPay;
					}
					
					else{
						$AdditionalPay = $CountChildren * $Charge;
						$TotalPayment = ($Days * $RmRate) + $AdditionalPay;
					}
				}
				
				//FALSE and FALSE
				else{
					$AdditionalPay = ($CountChildren + $CountAdult) * $Charge;
					$TotalPayment = ($Days * $RmRate) + $AdditionalPay;
				}
			}
			
			$query = "SELECT Room_ID FROM `tblrooms` WHERE RoomType = '$RmType' ORDER BY Room_ID ASC LIMIT 1";
			$run = mysqli_query($con, $query);
			$data = mysqli_fetch_assoc($run);
			$minRmNo = $data['Room_ID'];
			
			$query = "SELECT * FROM tblRoomStatus WHERE RoomType = '$RmType' AND CheckIn = '$CheckIn';";
			$run = mysqli_query($con, $query);
			$CountRecords = mysqli_num_rows($run);
			
			//use to insert room no
			$RoomNo = ($CountRecords + ($minRmNo-1)) + 1;
			
			//get the floor no of the room no
			$queryCheckFlrno = "SELECT FloorNo FROM tblRooms WHERE RoomNo = 'Rm#$RoomNo';";
			$run = mysqli_query($con, $queryCheckFlrno);
			$data = mysqli_fetch_assoc($run);
			$FlrNo = $data['FloorNo'];
			
			//insert into tblRoomStatus
			$queryInsRmStat = "INSERT INTO tblRoomStatus(RoomNo, FloorNo, RoomType, CustomerID, CheckIn, CheckOut, Status) VALUES('Rm#$RoomNo', '$FlrNo', '$RmType', '$CustID', '$CheckIn', '$CheckOut', 'Reserved')";
			$runInsRmStat = mysqli_query($con, $queryInsRmStat);
			
			//insert to tblCustomer
			$queryInsCust = "INSERT INTO tblCustomers(CustomerID, Lastname, Firstname, Gender, Age, EmailAdd, ContactNo, RoomType, RmRate, CheckInDate, CheckOutDate, Children, Adult, Charge, AdditionalPayment, TotalPayment, Downpayment, Status)
			VALUES('$CustID', '$LName', '$FName', '$Gender', '$Age', '$Email', '$ContactNo', '$RmType', '$RmRate', '$CheckIn', '$CheckOut', '$Children', '$Adult', '$Charge','$AdditionalPay', '$TotalPayment', '$Downpayment', '$Status')";
			$runInsCust = mysqli_query($con, $queryInsCust); 
			
			if($runInsRmStat && $runInsCust){?>
				<script type = "text/javascript">
					alert("Thank you, your reservation is successfully processed!");
					window.location.href = "index.php";
				</script><?php
			}
			
			else{?>
				<script type = "text/javascript">
					alert("Something went wrong!");
				</script><?php
			}
		}?>
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
						<li><a href="index.php">Home</a></li>
						<li><a href="accommodation.php">Accommodation</a></li>
						<li><a href="amenities.php">Amenities</a></li>
						<li><a href="contactus.php">Contact us</a></li>
					</div>
				</div>
			</div>
		</div>
		<!--navbar end-->
			
		<!--body start-->
		</br></br></br></br>
		<div class = "container">
			<div class = "col-sm-8 pull-left">
				<b><p class = "col-sm-6" style = "text-align: right;">Current Time:</p></b>
				<i><p class = "col-sm-2" id = "displayDate"></p>
				<p class = "col-sm-3" id = "displayTime"></p></i>
			</div>
			</br></br></br>
			<div class = "col-sm-12">
				<div class = "col-sm-7">
					<b class = "col-sm-6" style = "text-align: left">Arrival Date: <?php echo $_SESSION['CheckIn'];?></b>
					<b class = "col-sm-6" style = "text-align: left">Departure Date: <?php echo $_SESSION['CheckOut'];?></b>
				</div></br>
				</br>
				<div class = "panel panel-default">
					<div class = "panel-body">
						<div class = "col-sm-6">
							<form class = "form-horizontal" method = "POST" onInput = "computePayment()"></br>
								<div class = "col-sm-12">
									<b style = "font-size: 18px;">Booked by:</b><?php
										$QueSelect = "SELECT * FROM tblCustomers;";
										$run = mysqli_query($con, $QueSelect);
										
										$CustomerID = mysqli_num_rows($run) + 1;
									?>
									
									<div class = "form-group"></br>
										<label class = "col-sm-4 control-label">Customer ID:</label>
										<div class = "col-sm-8">
											<input class = "form-control" name = "txtCustID" type = "text" value = "CUST<?php echo date("y").'-'.$CustomerID;?>" readonly required>
										</div>
									</div>
									
									<div class = "form-group">
										<label class = "col-sm-4 control-label">Lastname:</label>
										<div class = "col-sm-8">
											<input class = "form-control" name = "txtLastName" type = "text" required>
										</div>
									</div>
									
									<div class = "form-group">
										<label class = "col-sm-4 control-label">Firstname:</label>
										<div class = "col-sm-8">
											<input class = "form-control" name = "txtFirstName" type = "text" required>
										</div>
									</div>
									
									<div class = "form-group">
										<label class = "col-sm-4 control-label">Gender:</label>
										<div class = "col-sm-4">
											<select class = "form-control" name = "cmbGender" required>
												<option></option>
												<option>Male</option>
												<option>Female</option>
											</select>
										</div>
										
										<label class = "col-sm-1 control-label">Age:</label>
										<div class = "col-sm-3">
											<input class = "form-control" name = "txtAge" type = "number" required min = 18>
										</div>
									</div>
									
									<div class = "form-group">
										<label class = "col-sm-4 control-label">Email Add:</label>
										<div class = "col-sm-8">
											<input class = "form-control" name = "txtEmailAdd" type = "email" required>
										</div>
									</div>
									
									<div class = "form-group">
										<label class = "col-sm-4 control-label">Contact #:</label>
										<div class = "col-sm-8">
											<input class = "form-control" name = "txtContactNo" type = "text" required>
										</div>
									</div>
								</div>
								
								<div class = "col-sm-12"></br>
									<b class = "col-sm-12" style = "font-size: 18px;">Participants:</b></br></br>
									
									<div class = "form-group col-sm-12 pull-right">
										<div class = "col-sm-6">
											<label class = "col-sm-10 control-label" style = "text-align: left;">Children:</label>
											<p class = "col-sm-12" style = "font-size: 75%; text-align: left; color: red;">*12 yrs. old and below</p>
										</div>
										<div class = "col-sm-5">
											<input class = "form-control" name = "txtCountChildren" id = "txtCountChildren" type = "number" required min = 0>
										</div>
									</div>
									
									<div class = "form-group col-sm-12 pull-right">
										<div class = "col-sm-6">
											<label class = "col-sm-10 control-label" style = "text-align: left;">Adult:</label>
											<p class = "col-sm-12" style = "font-size: 75%; text-align: left; color: red;">*13 yrs. old and above</p>
										</div>
										<div class = "col-sm-5">
											<input class = "form-control" name = "txtCountAdult" id = "txtCountAdult" type = "number" required min = 0>
										</div>
									</div>
								</div>
								
								<div class = "form-group">
									<label class = "col-sm-8 control-label" style = "text-align: right">Grand Total:</label>
									<div class = "col-sm-4">
										<input type = "number" class = "form-control" id = "txtGrandTotal" style = "font-weight: bold;" name = "txtGrandTotal" min = 0 step = "0.01" required>
									</div>
								</div>
								
								<div class = "form-group">
									<label class = "col-sm-8 control-label" style = "text-align: right">Downpayment (50%):</label>
									<div class = "col-sm-4">
										<input type = "number" class = "form-control" id = "txtDownPay" style = "font-weight: bold;" name = "txtDownPay" min = 0 step = "0.01" required>
									</div>
								</div><?php
								
								$RmType = $_SESSION['RoomType'];
								$query = "SELECT Rate, Charge, Specification FROM tblRoomType WHERE Name = '$RmType' AND Status = 'available';";
								$run = mysqli_query($con, $query);
								
								$data = mysqli_fetch_assoc($run);
								$RmRate = $data['Rate'];
								$RmCharge = $data['Charge'];?>
								
								<!--To paypal-->
								<input class = "form-control" name = "itemname" type = "hidden" value = "<?php echo $RmType;?>"  readonly required>
								<input class = "form-control" name = "itemnumber" type = "hidden" value = "CUST<?php echo date("y").'-'.$CustomerID;?>" readonly required>
								<input class = "form-control" name = "itemdesc" type = "hidden" value = "<?php echo $data['Specification'];?>"  readonly required>
								<input class = "form-control" name = "itemprice" id = "paypalDownPayment" type = "hidden" readonly required>
								<input class = "form-control" type="hidden" name="itemQty" value="1" readonly required/>
								<!--To paypal-->
								
								<input type = "hidden" name = "txtRmRate" id = "txtRmRate" value = "<?php echo $RmRate;?>">
								<input type = "hidden" name = "txtRmCharge" id = "txtRmCharge" value = "<?php echo $RmCharge;?>">
								<input type = "hidden" name = "txtDateIn" id = "txtDateIn" value = "<?php echo $_SESSION['dbDateIn'];?>">
								<input type = "hidden" name = "txtDateOut" id = "txtDateOut" value = "<?php echo $_SESSION['dbDateOut'];?>">
								
								<button name = "btnPayment" class = "btn btn-primary pull-right">Proceed to payment <span class = "glyphicon glyphicon-send"></span></button>
							</form>
						</div>
						<div class = "col-sm-6"><?php
							$RmType = $_SESSION['RoomType'];
							$query = "SELECT * FROM tblRoomType WHERE Name = '$RmType' AND Status = 'available'";
							$run = mysqli_query($con, $query);
							
							$data = mysqli_fetch_assoc($run);
							$RoomType = $data['Name'];
							$MaxPerson = $data['MaxPerson'];
							$Specification = $data['Specification'];
							$Rate = $data['Rate'];
							$XtraPerson = $data['Charge'];
							$ImageLink = $data['ImageLink'];?>
							
							<div class = "col-sm-12">
								<img src = "<?php echo $ImageLink;?>" class = "img-thumbnail">
							</div>
							
							<div class = "col-sm-12"></br>
								<form class = "form-horizontal">
									<center><b style = "font-size: 18px;"><?php echo $RoomType;?></b></center></br>
									<form class = "form-group">
										<label class = "col-sm-9">Maximum number of person: </label><p><?php echo $MaxPerson;?> person(s)</p>
									</form>
									</br>
									<form class = "form-group">
										<label class = "col-sm-12">Specification: </label></br><p class = "col-sm-12"><?php echo $Specification;?></p>
										</br></br></br></br></br>
									</form>
									
									<form class = "form-group col-sm-9">
										<label class = "col-sm-8">Room Rate: </label>
										<span class = "label label-success">P <?php echo number_format($Rate, 2)?></span>
											
										<label class = "col-sm-8">Extra person: </label>
										<span class = "label label-danger">P <?php echo number_format($XtraPerson, 2)?></span>
									</form>
								</form>
								<div class = "alert alert-warning col-sm-12" role = 'alert' style = "font-weight: bold; font-size: 12px;">
									Note: Children 12 yrs. old and below free of charge when
									staying with parents. No breakfast will be provided. Maximum of two(2)
									children per room only
								</div>
							</div>
						</div>
					</div>
					
					<nav class = "pull-right">
						<ul class = "pagination pagination-md">
							<li class = "previous"><a href = "rules_and_guidelines.php"><span class = "glyphicon glyphicon-arrow-left"><span> Back</a></li>
							<li class = "next"><a href = "#">Next <span class = "glyphicon glyphicon-arrow-right"><span></a></li>
						</ul>
					</nav>
				</div>
			</div>
		</div>
		<!--body end-->
			
			<!--footer start-->
				<div class = "container">
					<div class="navbar" id  = "bgFooter">
						<div class = "row">	
							<div class = "pull-right">
								<h5><em>&copy Premiere Citi Suites <?php echo date("Y")?></em></h5>
							</div>
						</div>
					</div>
				</div>
			<!--footer end-->
    </body>
</html>