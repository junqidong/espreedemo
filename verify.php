
<?php

require "dbinfo.php";
session_start();
$message = "";

if(isset($_GET["e"]) && !empty($_GET["e"]) && isset($_GET["a"]) && !empty($_GET["a"])){
	$email = $_GET["e"];
	$hash = $_GET["a"];
	
	$dbConnection = new mysqli($host, $username, $password, $database);
    
    if($dbConnection->connect_error)
	{
    	echo '<p>MYSQL Error: ' .$dbConnection->connect_error.'</p>';
    } else {
		$stmt = $dbConnection->prepare("SELECT hash, email, status FROM Users WHERE email = ? AND hash = ? AND status = '0'");
		$stmt->bind_param("ss", $email, $hash);
		
		if($stmt->execute()){
			$result = $stmt->get_result();
			$row = $result->fetch_assoc();
			
			if($row){
				$dbConnection->query("UPDATE Users SET status='1' WHERE email='".$email."'");
				$message = "<p>Your account has been activated. Return to login page <a href=\"index.php\">here</a>.</p>";
			} else {
				$message = "<p> An error has occured. Your account has not been activated. Please try again. </p>";
			}
		}
		$stmt->close();
		$dbConnection->close();	
	}
}

?>

<?php if(!empty($message)){?>
<?php include_once "common/header.php" ?>
<body style="padding-top: 20px">
	<div class="container">
		<div class="row">
			<div class="col-sm-8 col-md-offset-2">
				<div class="panel">
					<div class="panel-heading">
						<h1> Account Activation </h1>
					</div>
					<div class="panel-body">
						<?php echo $message;?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php include_once "common/footer.php" ?>
<?php } ?>
