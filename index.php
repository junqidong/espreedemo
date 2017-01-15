<?php
    require "dbinfo.php";
    session_start();
    $error = "";
    if(isset($_POST["email"]) && isset($_POST["password"]))
    {
    	if($_POST["email"] != "" && $_POST["password"] != ""){
    		
    		$dbConnection = new mysqli($host, $username, $password, $database);
    
    		if($dbConnection->connect_error)
			{
    			echo '<p>MYSQL Error: ' .$dbConnection->connect_error.'</p>';
    		} else {
			
				$stmt = $dbConnection->prepare("SELECT user_id, categories_picked, password, status FROM Users WHERE email = ?");
				$stmt->bind_param("s", $_POST["email"]);
				
				if($stmt->execute()){
					$result = $stmt->get_result();
					$row = $result->fetch_assoc();
					
					$password = $row['password'];
					$userid = $row['user_id'];
					$categories_picked = $row['categories_picked'];
					$status = $row['status'];
					
					if($password != md5($_POST["password"])){
						$error = "<div class=\"alert alert-danger\"> Invalid password. </div>";
					} else {
						$_SESSION["email"] = $_POST["email"];
						$_SESSION["userid"] = $userid;
						if(strcmp($status, "0")==0){
							$error = "<div class=\"alert alert-danger\"> Account not activated. Check your email for an activation link. </div>";
						} else {
							if(strcmp($categories_picked, "0")==0){
								header('Location: firstlogin.php');
							} else {
								header('Location: welcome.php');
							}
						}
					}
				} else {
					$error = "<div class=\"alert alert-danger\"> Invalid login. </div>";
				
				}
				$stmt->close();
				$dbConnection->close();
			}
    	} else{
    		$error = "<div class=\"alert alert-warning\"> Please enter your email and password.</div>";
    	}	
    }
?>

<?php include_once "common/header.php" ?>


<body style="padding-top: 20px">
	<div class="container">
		<div class="row">
			<div class="col-sm-4 col-md-offset-4">
				<div class="panel">
					<div class="panel-heading">
						<h1> Login </h1>
					</div>
					<div class="panel-body">
						<?php echo $error ?>
						<form action="index.php" method="post">
						<div class="form-group">
							<label for="email"> Email Address </label>
							<input class="form-control" type="email" name="email" />
						</div>
						<div class="form-group">
							<label for="password"> Password </label>
							<input class="form-control" type="password" name="password" />
						</div>
						<input type="submit" value="Login" />
						</form>
						<br />
						<p> If you don't already have an account, <a href="register.php"> register </a> now!</p>
						<p> <a href="forgotpassword.php" /> Forgot Password? </a></p>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php include_once "common/footer.php" ?>
