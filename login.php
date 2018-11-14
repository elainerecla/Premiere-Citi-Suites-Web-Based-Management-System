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
		
        <!--body start-->
		<?php
			SESSION_START();
			include("connection.php");
			
			if(isset($_SESSION['UserID'])){
				if($_SESSION['Type'] == "Admin" || $_SESSION['Type'] == "Manager" || $_SESSION['Type'] == "Staff"){
					if($_SESSION['Type'] == "Admin"){
						$_SESSION['Type'] = "Admin";
						header("location: adminpage.php");
					}
					
					else if($_SESSION['Type'] == "Manager"){
					$_SESSION['Type'] = "Manager";
						header("location: managerpage.php");
					}
					
					else{
						$_SESSION['Type'] = "Staff";
						header("location: staffpage.php");
					}
				}
				
				else{
					echo "Error!";
				}
			}
			
			else{
				if(isset($_POST['btnLogin'])){
					$UserID = $_POST['txtUserID'];
					$Password =  md5($_POST['txtPassword']);
					
					$query = "SELECT Firstname, Lastname, Type, Category, Status FROM tblUsers WHERE UserID = '$UserID' AND Password = '$Password'";
					$run = mysqli_query($con, $query);
					
					if($run){
						if(mysqli_num_rows($run)>0){
							while($row = mysqli_fetch_assoc($run)){
								$UserType = $row['Type'];
								$UserStatus = $row['Status'];
								$Firstname = $row['Firstname'];
								$Category = $row['Category'];
							}
							
							if($UserStatus == "a"){
								if($UserType == "Admin"){
									$_SESSION['UserID'] = $UserID;
									$_SESSION['Type'] = $UserType;
									$_SESSION['Category'] = $Category;
									$_SESSION['Firstname'] = $Firstname;?>
									<script type = "text/javascript">
										alert("Welcome <?php echo $_SESSION['Firstname'] ?>!");
										window.location.href = 'adminpage.php';
									</script><?php
								}
									
								else if($UserType == "Manager"){
									$_SESSION['UserID'] = $UserID;
									$_SESSION['Type'] = $UserType;
									$_SESSION['Category'] = $Category;
									$_SESSION['Firstname'] = $Firstname;?>
									<script type = "text/javascript">
										alert("Welcome <?php echo $_SESSION['Firstname'] ?>!");
										window.location.href = 'managerpage.php';
									</script><?php
								}
								
								else{
									$_SESSION['UserID'] = $UserID;
									$_SESSION['Type'] = $UserType;
									$_SESSION['Category'] = $Category;
									$_SESSION['Firstname'] = $Firstname;?>
									<script type = "text/javascript">
										alert("Welcome <?php echo $_SESSION['Firstname'] ?>!");
										window.location.href = 'staffpage.php';
									</script><?php
								}
							}
									
							else{?>
								<script type = 'text/javascript'>
									alert('Your account has been deactivated!');
									window.location.href = 'login.php';
								</script><?php
							}
						}
					
						else{?>
							<script type = 'text/javascript'>
								alert('Your account does not exist, please contact your admin to resolve this.');
								window.location.href = 'login.php';
							</script><?php
						}
					}
				}
			}
		?>
		
		<div class = "container bodyContent">
			<div class = "row" ></br></br>
				<div class = "col-md-4 col-md-offset-4 loginForm">
					<form method = "post">
						<h2><span class="glyphicon glyphicon-edit"></span> Member Login</h2><hr></br>
						<div class="form-group">
							<label class="col-sm-4 control-label"> User ID: </label>
							<div class="col-sm-8">
								<input name="txtUserID" type="text" class="form-control" required></br>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-4 control-label"> Password: </label>
							<div class="col-sm-8">
								<input name="txtPassword" type="password" class="form-control" required></br>
							</div>
						</div>
						
						<div class="form-group">
							<div class="pull-right">
								<button type="submit" class="btn btn-primary" name = "btnLogin"> Login </button>
								
								<button type="reset" class="btn btn-default">
								Clear
								</button>
							</div>
						</div>
					</form>	
						
					<a class = "btn" href = "forgotpass.php">Forgot Password?</a>
				</div>
			</div>
		</div>
        <!--body end-->
    </body>
</html>



