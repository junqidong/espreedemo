<?php
	require "dbinfo.php";
	$error = "";

	if(isset($_POST["email"]) && isset($_POST["password"]))
	{
		if($_POST["email"] != ""  && $_POST["password"] != "")
		{		
			$dbConnection = new mysqli($host, $username, $password, $database);
		
			if($dbConnection->connect_error)
			{
				echo '<p>MYSQL error: '.$dbConnection->connect_error.'</p>';
			} else {
				date_default_timezone_set("America/New_York");
				$date = date("Y-m-d h:i:s");
				
				$stmt = $dbConnection->prepare("INSERT INTO Users(email, password, date_created) VALUES (?,?,?)");

				$stmt->bind_param("sss", $_POST["email"], md5($_POST["password"]), $date);
				
				
				if(!$stmt->execute()){
					echo $stmt->error;
					$error = "<div class=\"alert alert-danger\"> Error registering.</div>";
				} else {
					header('Location: index.php');
				}
				
				$stmt->close();
				$dbConnection->close();
			}
		} else {	
			$error = "<div class=\"alert alert-warning\">Please fill the following option.</div>";
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
						<h1> Register </h1>
					</div>
					<div class="panel-body">
						<?php echo $error ?>
						<form action="register.php" method="post">
						<div class="form-group">
							<label for="username"> Email Address </label>
							<input class="form-control" type="email" name="email" />
						</div>
						<div class="form-group">
							<label for="password"> Password </label>
							<input class="form-control" type="password" name="password" />
						</div>
						<input type="submit" value="Register" />
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php include_once "common/footer.php" ?>
