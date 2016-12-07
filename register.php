<?php
	require "dbinfo.php";
	$error = "";

	if(isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["address1"]) && isset($_POST["dob"]))
	{
		if($_POST["email"] != ""  && $_POST["password"] != "" && $_POST["address1"] != "")
		{		
			$dbConnection = new mysqli($host, $username, $password, $database);
			//mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
		
			if(!$dbConnection->connect_error)
			{
				date_default_timezone_set("America/Toronto");
				$date = date("Y-m-d h:i:s");
				if(isset($_POST["address2"])){
					$stmt = $dbConnection->prepare("INSERT INTO Users(email, password, address1, address2, date_of_birth, date_created) VALUES (?,?,?,?,?,?)");
					$stmt->bind_param("ssssss", $_POST["email"], md5($_POST["password"]), $_POST["address1"], $_POST["address2"], $_POST["dob"], $date);
				} else {
					$stmt = $dbConnection->prepare("INSERT INTO Users(email, password, address1, date_of_birth, date_created) VALUES (?,?,?,?,?)");
					$stmt->bind_param("sssss", $_POST["email"], md5($_POST["password"]), $_POST["address1"], $_POST["dob"], $date);
				}
				
				if(!$stmt->execute()){
					if($stmt->errno == 1062){
						$error = "<div class=\"alert alert-warning\"> Error registering. Email already exists. </div>";
					} else {
						$error = "<div class=\"alert alert-danger\"> Error registering.</div>";
					}
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
			<div class="col-sm-8 col-md-offset-2">
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
						<div class="form-group">
							<label for="username"> Firstname </label>
							<input class="form-control" type="text" name="firstname" />
						</div>
						<div class="form-group">
							<label for="username"> Lastname </label>
							<input class="form-control" type="text" name="lastname" />
						</div>
						<div class="form-group">
							<label for="username"> Date Of Birth </label>
							<input class="form-control" type="date" name="dob" />
						</div>
						<div class="form-group">
							<label for="username"> Address 1</label>
							<input class="form-control" type="text" name="address1" />
						</div>
						<div class="form-group">
							<label for="username"> Address 2</label>
							<input class="form-control" type="text" name="address2" />
						</div>
						<input type="submit" value="Register" />
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php include_once "common/footer.php" ?>
