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
						<li><a href="index.php">Home</a></li>
						<li><a href="accommodation.php">Accommodation</a></li>
						<li class = "active"><a href="amenities.php">Amenities</a></li>
						<li><a href="contactus.php">Contact us</a></li>
					</div>
				</div>
			</div>
		</div>
		<!--navbar end-->
			
		<!--body start-->
		</br></br></br></br>
		<div class = "col-sm-12 pull-left">
			<b><p class = "col-sm-4" style = "text-align: right;">Current Time:</p></b>
			<i><p class = "col-sm-1" id = "displayDate"></p>
			<p class = "col-sm-2" id = "displayTime"></p></i>
		</div>
		</br>
		<!--body start-->
		<div class = "col-sm-12"></br>
			<div class = "panel panel-default">
				<div class = "panel-body"></br></br>
					<div class = "col-sm-4">
						<img class = "img-thumbnail" src = "Upload/ame01.jpg"/>
					</div>
					
					<div class = "col-sm-4">
						<img class = "img-thumbnail" src = "Upload/ame02.jpg"/>
					</div>
					
					<div class = "col-sm-4">
						<img class = "img-thumbnail" src = "Upload/ame03.jpg"/></br></br></br>
					</div>
					
				</div>
			</div>
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