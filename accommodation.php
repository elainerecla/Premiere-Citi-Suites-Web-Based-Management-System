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
						<li class = "active"><a href="accommodation.php">Accommodation</a></li>
						<li><a href="amenities.php">Amenities</a></li>
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
			<div class = "alert alert-warning col-sm-12" role = 'alert' style = "font-weight: bold; text-align: center; font-size: 12px;">
				Note: Children 12 yrs. old and below free of charge when
				staying with parents. No breakfast will be provided. Maximum of two(2)
				children per room only
			</div></br></br></br><?php
			$query = "SELECT * FROM tblRoomType WHERE Status != 'removed';";
			$run = mysqli_query($con, $query);
			
			while($data = mysqli_fetch_assoc($run)){
				$RmTypeImg = $data['ImageLink'];
				$RmRate = $data['Rate'];
				$RmXtraPerson = $data['Charge'];?>
				<div class = "panel panel-default">
					<div class = "panel-body">
						<div class = "col-sm-7">
							<img class = "img-thumbnail" src = "<?php echo $RmTypeImg;?>"/>
						</div>
						
						<div class = "col-sm-5">
							<form class = "form-horizontal">
								<center><b style = "font-size: 18px;"><?php echo $data['Name']?></b></center></br>
								<form class = "form-group">
									<label class = "col-sm-8">Maximum number of person: </label><p><?php echo $data['MaxPerson'];?> person(s)</p>
								</form>
								</br>
								<form class = "form-group">
									<label class = "col-sm-12">Specification: </label></br><p class = "col-sm-12"><?php echo $data['Specification'];?></p>
									</br></br></br></br></br></br>
								</form>
								
								<form class = "form-group">
									<div class = "col-sm-12">
										<label class = "col-sm-5">Room Rate: </label><span class = "label label-success">P <?php echo number_format($RmRate, 2)?></span>
									</div>
									
									<div class = "col-sm-12">
										<label class = "col-sm-5">Extra person: </label><span class = "label label-danger">P <?php echo number_format($RmXtraPerson, 2)?></span>
									</div>
								</form>
							</form>
						</div>
					</div>
				</div><?php
			}
		?>
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