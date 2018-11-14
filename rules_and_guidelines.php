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
						<li><a href="home.php">Home</a></li>
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
					<div class = "panel-header"></br></br>
						<b style = "font-size: 18px; margin: 8%;">Booking Policy and Guidelines</b>
					</div>
					
					<div class = "panel-body">
						<div style = "width: 85%;"></br>
							<ul class = "list-group pull-right">
								<li><p>
									A 50% deposit of the total room cost is required using Paypal to 
									secure your reservation</p>
								</li>
								
								<li><p>
									There are no refunds and additional payment issued for early checkouts</p>
								</li>
								
								<li><p>
									Additional charge is incurred for late checkouts</p>
								</li>
								
								<li><p>
									Any cancellation received within seven(7) days prior to arrival date will incur
									the first night charge</p>
								</li>
							
								<li><p>
									Any cancellation received within three(3) days prior to arrival date will incur 
									the full period charge.</p>
								</li>
								
								<li><p>
									Failure to arrive in the hotel will be treated as a No-Show and no refund 
									will be given.</p>
								</li>
							</ul>
						</div>
						
						<div class = "col-sm-12">
							<b class = "pull-right">- Premiere Citi Suites</b>
						</div>
						
						
					</div>
					<nav class = "pull-right">
						<ul class = "pagination pagination-md">
							<li class = "previous disabled"><a href = "#"><span class = "glyphicon glyphicon-arrow-left"><span> Back</a></li>
							<li class = "next"><a href = "room_and_guestinfo.php">Next <span class = "glyphicon glyphicon-arrow-right"><span></a></li>
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