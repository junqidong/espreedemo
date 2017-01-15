<?php
	require "dbinfo.php";
	$error = "";
	mysqli_report(MYSQLI_REPORT_ALL);

	if(isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["address1"]) && isset($_POST["dob"]) &&
	   !empty($_POST["email"]) && !empty($_POST["password"]) && !empty($_POST["address1"]) && !empty($_POST["dob"]))
	{
		if($_POST["email"] != ""  && $_POST["password"] != "" && $_POST["address1"] != "")
		{		
			$dbConnection = new mysqli($host, $username, $password, $database);
		
			if(!$dbConnection->connect_error)
			{
				date_default_timezone_set("America/Toronto");
				$date = date("Y-m-d h:i:s");
				
				$hash = md5(rand(0,1000));
				if(isset($_POST["address2"]) && !empty($_POST["address2"])){
					$stmt = $dbConnection->prepare("INSERT INTO Users(email, password, address1, address2, date_of_birth, date_created, hash) VALUES (?,?,?,?,?,?,?)");
					$stmt->bind_param("sssssss", $_POST["email"], md5($_POST["password"]), $_POST["address1"], $_POST["address2"], $_POST["dob"], $date, $hash);
				} else {
					$stmt = $dbConnection->prepare("INSERT INTO Users(email, password, address1, date_of_birth, date_created, hash) VALUES (?,?,?,?,?,?)");
					$stmt->bind_param("ssssss", $_POST["email"], md5($_POST["password"]), $_POST["address1"], $_POST["dob"], $date, $hash);
				}
						
				$emailto = $_POST["email"];
				$subject = "Thank you for registering to Espree.";
					
				$emailmessage = '
				<html>
				<head>
				<title> Verify Email </title>
				</head>
				<body>
				<p> Thank you for registering for an account with Espree.
				</p>
				<hr />
				<p>Your login information is: </p>
				<p>Email: '.$_POST["email"].'</p>
				<p>Password: '.$_POST["password"].'</p>
				<hr />
				<p>Please visit the link to activate your account before you get started. <a href="http://test.algcetcs2.org/verify.php?e='.$_POST["email"].'&a='.$hash.'">http://test.algcetcs2.org/verify.php?e='.$_POST["email"].'&a='.$hash.'</a></p>
				';
					
				$headers = "MIME-Version: 1.0". "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
				$headers .= 'From: noreply@algcetcs2.org' . "\r\n";
					
				if(mail($emailto, $subject, $emailmessage, $headers)){
					if(!$stmt->execute()){
						$error = "<div class=\"alert alert-danger\"> Error registering.</div>";
					} else {
					$error = "<div class=\"alert alert-success\"> Thank you for registering. An email has been sent to ".$_POST["email"]." regarding activating your account. Don't forget to check your junk mail. Return to <a href=\"index.php\">login</a>.</div>";
					}
				} else {
					$error = "<div class=\"alert alert-danger\"> Error sending activation email. </div>";
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
						<form action="register.php" onsubmit="return confirmPassword()" method="post">
						<div class="form-group">
							<label for="username"> Email Address </label>
							<input class="form-control" type="email" name="email" />
						</div>
						<div class="form-group">
							<label for="password"> Password </label>
							<input id="password" class="form-control" type="password" name="password" />
						</div>
						<div class="form-group">
							<label for="confirm-password"> Confirm Password </label>
							<input id="confirm-password" class="form-control" type="password" name="confirm-password" />
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
