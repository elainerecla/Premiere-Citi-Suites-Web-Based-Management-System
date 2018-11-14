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
			}
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
						<li class = "active"><a href="index.php">Home</a></li>
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
		</br>
		
		<!--Carousel Slider-->
			<div class = "col-sm-8"></br>
				<div id = "carousel-example-generic" class = "carousel slide" data-ride = "carousel">
					<ol class = "carousel-indicators">
						<li data-target = "#carousel-example-generic" data-slide-to = "0" class = "active"></li>
						<li data-target = "#carousel-example-generic" data-slide-to = "1"></li>
						<li data-target = "#carousel-example-generic" data-slide-to = "2"></li>
						<li data-target = "#carousel-example-generic" data-slide-to = "3"></li>
						<li data-target = "#carousel-example-generic" data-slide-to = "4"></li>
					</ol>
					
					<div class = "carousel-inner" role = "listbox">
						<div class = "item active">
							<img src = "Upload/ame01.jpg" class = "img-thumbnail">
						</div>
						
						<div class = "item">
							<img src = "Upload/ame02.jpg" class = "img-thumbnail">
						</div>
						
						<div class = "item">
							<img src = "Upload/ame03.jpg" class = "img-thumbnail">
						</div>
						
						<div class = "item">
							<img src = "Upload/ex03.jpg" class = "img-thumbnail">
						</div>
						
						<div class = "item">
							<img src = "Upload/del01.jpg" class = "img-thumbnail">
						</div>
					</div>
					
					<a class = "left carousel-control" href = "#carousel-example-generic" role = "button" data-slide = "prev">
						<span class = "glyphicon glyphicon-chevron-left" aria-hidden = "true"></span>
						<span class = "sr-only"></span>
					</a>
					
					<a class = "right carousel-control" href = "#carousel-example-generic" role = "button" data-slide = "next">
						<span class = "glyphicon glyphicon-chevron-right" aria-hidden = "true"></span>
						<span class = "sr-only"></span>
					</a>
				</div>
			</div>
			<!--Carousel Slider-->
			
			<!--Make a reservation-->
			<div class = "col-sm-4"></br>
				<div class = "panel panel-default"></br>
					<div class = "panel-header">
						<b class = "col-sm-12" style = "text-align: center; font-size: 18px;"><span class = "glyphicon glyphicon-edit"></span> Make a reservation</b>
					</div>
					</br><hr>
					<div class = "panel-body">
						<div class = "full-width"><?php
							if(isset($_POST['btnBookNow'])){
								$RmType = $_POST['cmbRmType'];
								$toTimeCheckIn = strtotime($_POST['txtCheckIn']);
								$toTimeCheckOut = strtotime($_POST['txtCheckOut']);
								$CheckIn = $_POST['txtCheckIn'];
								$CheckOut = $_POST['txtCheckOut'];
								
								//Check if pila ka buok offered rooms ang naa sa iyang roomtype 
								$query = "SELECT * FROM tblRooms WHERE RoomType = '$RmType';";
								$run = mysqli_query($con, $query);
								$RoomsOfRoomType = mysqli_num_rows($run);
								
								//COUUNT ALL ROOM TYPE WITH THE SAME CHECK IN NGA NAA SA DB 
								$query = "SELECT * FROM tblRoomStatus WHERE RoomType = '$RmType' AND CheckIn = '$CheckIn';";
								$run = mysqli_query($con, $query);
								$countCheckIn1 = mysqli_num_rows($run);
								
								//count all room type nga ang check in is between sa uban reservation
								$query = "SELECT * FROM tblRoomStatus WHERE ('$CheckIn' BETWEEN CheckIn AND CheckOut) AND CheckIn != '$CheckIn';";
								$run = mysqli_query($con, $query);
								$countCheckIn2 = mysqli_num_rows($run);
								
								//count ang checkout nga mu between sa uban reservation
								$query = "SELECT * FROM tblRoomStatus WHERE ('$CheckOut' BETWEEN CheckIn AND CheckOut) AND CheckIn != '$CheckIn';";
								$run = mysqli_query($con, $query);
								$countCheckOut = mysqli_num_rows($run);
								
								//check if ang room type is ni equal na sa max count having the same check in
								if(($countCheckIn1 + $countCheckIn2 + $countCheckOut) >= $RoomsOfRoomType){?>
									<div class = "alert alert-danger" role = "alert">
										<span class = "glyphicon glyphicon-exclamation-sign"></span> No <?php echo $RmType;?> available from <?php echo date("M d, Y", $toTimeCheckIn)?> to <?php echo date("M d, Y", $toTimeCheckOut)?>
									</div><?php
								}
								
								else{
									$_SESSION['CheckIn'] = date("M d, Y", $toTimeCheckIn);
									$_SESSION['CheckOut'] = date("M d, Y", $toTimeCheckOut);
									$_SESSION['RoomType'] = $RmType;
									$_SESSION['dbDateIn'] = $CheckIn;
									$_SESSION['dbDateOut'] = $CheckOut;?>
									
									<script type = "text/javascript">
										window.location.href = "rules_and_guidelines.php";
									</script><?php
								}
							}?>
							<form method = "POST" class = "form-horizontal">
								<div class = "form-group">
									<label class = "col-sm-5">Room Type:</label>
									<div class = "col-sm-7">
										<select name = "cmbRmType" style = "font-size: 80%;" class = "form-control" required>
											<option></option><?php
											$query = "SELECT Name FROM tblRoomType WHERE Status= 'available';";
											$run = mysqli_query($con, $query);
											
											while($data = mysqli_fetch_assoc($run)){?>
												<option><?php echo $data['Name']?></option><?php
											}?>
										</select>
									</div>
								</div>
								
								<div class = "form-group"><?php
									$today = strtotime(date("m/j/Y"));
									$addOneDay = strtotime("+1 day", $today);
									$addThreeMonths = strtotime("+3 months", $today);
									$tomorrow = date("Y-m-d", $addOneDay);
									$threeMonths = date("Y-m-d", $addThreeMonths);?>
									
									<label class = "col-sm-5">Check-in:</label>
									<div class = "col-sm-7">
										<input class = "form-control" name = "txtCheckIn" id = "txtCheckIn" type = "date" style = "font-size: 80%;" onBlur = "getCheckInDate()" min = "<?php echo $tomorrow;?>" max = "<?php echo $threeMonths;?>" required>
									</div>
								</div>
								
								<div class = "form-group">
									<label class = "col-sm-5">Check-out:</label>
									<div class = "col-sm-7">
										<input class = "form-control" name = "txtCheckOut" id = "txtCheckOut" type = "date" style = "font-size: 80%;" max = "<?php echo $threeMonths;?>" required></br>
									</div>
								</div>
								
								<center><button class = "btn btn-success" name = "btnBookNow"><span class = "glyphicon glyphicon-ok"></span> Book Now!</button></center>
							</form>
						</div>
					</div>
				</div>
			</div>
			<!--Make a reservation-->
		</div>
		<!--body end-->
			
		<!--footer start-->
			<div class = "container">
				<div class="navbar" id  = "bgFooter"></br>
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