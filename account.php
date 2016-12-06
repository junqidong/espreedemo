<?php
	session_start();
	if(!$_SESSION["email"]){
		header("Location: index.php");
	}
?>

<?php include_once "common/header.php" ?>
<?php include_once "common/navbar.php" ?>


<?php 

	require "dbinfo.php";
	$error = "";
	$email = $_POST["email"];
	
	$dbConnection = new mysqli($host, $username, $password, $database);
    
    if($dbConnection->connect_error)
	{
    	echo '<p>MYSQL Error: ' .$dbConnection->connect_error.'</p>';
    } 
	else 
	{
		$stmt = $dbConnection->prepare("SELECT email, reward_points, address1, address2, date_created, user_type FROM Users WHERE email = " . $email ." ;");
		
		if(!$stmt->execute())
		{
			echo $stmt->error;
			$error = "<div class=\"alert alert-danger\"> Error registering.</div>";
		} 
		else 
		{
			header('Location: index.php');
		}
		
		$stmt->bind_result($email, $reward_points, $address1, $address2, $date_created, $user_type );
		$stmt->close();
		$dbConnection->close();
		
	}


?>
<div class="panel-body">
	<?php echo $error ?>
	<div class="form-group">
		<label for="username"> Email Adress : </label> <?php $email ?>
	</div>
	<div class="form-group">
		<label for="username"> Reward Points : </label> <?php $reward_points ?>
	</div>
	<div class="form-group">
		<label for="username"> Adress 1 : </label> <?php $address1 ?>
	</div>
	<div class="form-group">
		<label for="username"> Adress 2 : </label> <?php $address2 ?>
	</div>
	<div class="form-group">
		<label for="username"> Date Created : </label> <?php $date_created ?>
	</div>
	<div class="form-group">
		<label for="username"> User Type : </label> <?php $user_type ?>
	</div>
</div>

<?php include_once "common/footer.php" ?>