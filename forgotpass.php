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
    </head>
		<!--navbar start-->
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-brand">
                    <img src = "Resources/images/jpg/premiere logo.jpg" class = "img-thumbnail">
                </div>
            </div>
        </div>
        <!--navbar end-->
		
        <!--body start--><?php
		include("connection.php");
		
		if(isset($_POST['btnRecover'])){
			$UserID = $_POST['txtUserID'];
			$Email = $_POST['txtEmail'];
			
			$query = "SELECT * FROM tblUsers WHERE UserID = '$UserID' AND EmailAdd = '$Email';";
			$run = mysqli_query($con, $query);
			$check = mysqli_num_rows($run);
			
			if($check > 0){?></br></br></br></br></br></br></br><?php
				$subject = "Testing 101";
				echo $newPass = bin2hex(openssl_random_pseudo_bytes(4));
				$headers = "From: Premiere Citi Suites";
				
				$queUpdate = "UPDATE tblUsers SET Password = '".md5($newPass)."' WHERE UserID = '$UserID' AND EmailAdd = '$Email';";
				$run = mysqli_query($con, $queUpdate);
				
				//mail($Email, $subject, $newPass, $headers);?>
				<script type = 'text/javascript'>
					alert("Your new password has been reset, please check your email!");
				</script><?php
			}
			
			else{?>
				<script type = 'text/javascript'>
					alert("Error, Your UserID and Email didn't match!");
					window.location.href = 'forgotpass.php';
				</script><?php
			}
		}
		?>
		<div class = "container bodyContent">
			<div class = "row" ></br></br>
				<div class = "col-md-6 pull-left">
					<form method = "post">
						<b><span class="glyphicon glyphicon-edit"></span> Recover Password</b><hr class = "col-md-10"></br>
						<div class="form-group">
							<label class="col-sm-4 control-label"> User ID: </label>
							<div class="col-sm-6">
								<input name="txtUserID" type="text" class="form-control" required></br>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-4 control-label"> Your email add: </label>
							<div class="col-sm-6">
								<input name="txtEmail" type="email" class="form-control" required></br>
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-md-6 col-md-offset-3"></br>
								<button type="submit" class="btn btn-primary" name = "btnRecover"> Recover </button>
								<a class = "btn btn-default" href = "login.php">Back to home</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
        <!--body end-->
    </body>
</html>



