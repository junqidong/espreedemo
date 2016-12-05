<?php
	require "dbinfo.php";
	session_start();
	$error = "";
	
	$dbConnection = new mysqli($host, $username, $password, $database);

	
		
	if(!$dbConnection->connect_error)
	{
		if(isset($_POST["coupons"])){
			$coupons = $_POST["coupons"];
			$userid = $_SESSION["userid"];
			
			$stmt = $dbConnection->prepare("INSERT INTO User_Coupons(user_id, coupon_id) VALUES (?,?)");
			
			foreach ($coupons as $coupon=>$value) {
				$stmt->bind_param("ss", $userid, $value);
				if(!$stmt->execute()){
					echo $stmt->error;
					$error = "<div class=\"alert alert-danger\"> Error picking coupon.</div>";
				}
			}
			if(strcmp($error, "")==0){
				header('Location: welcome.php');
			}	
		}
		
		$stmt = $dbConnection->prepare("SELECT brand.brand_name, coupons.coupon_id, coupons.name, coupons.price FROM Coupons LEFT JOIN Brand ON coupons.brand_id = brand.brand_id");
		
		if(!$stmt->execute()){
			$error = "<div class=\"alert alert-danger\"> Error. </div>";
		} else {
			$result = $stmt->get_result();
		}
		$stmt->close();
		$dbConnection->close();
	}


?>
<?php include_once "common/header.php" ?>

<body style="padding-top: 20px">
	<div class="container">
		<div class="row">
			<div class="col-sm-8 col-md-offset-2">
				<div class="panel">
					<div class="panel-heading">
						<h1> Coupons </h1>
					</div>
					<div class="panel-body">
						<?php echo $error ?>
						<form action="firstlogin.php" method="post">
						<?php 
						$count = 0;
						while($row = $result->fetch_assoc()){
							$count++;
							echo '<div class="checkbox coupon" unselectable="on">
								  <p class="lead">'.$row['brand_name'].'</p>
								  <label><input type="checkbox" name="coupons[]" value="'.$row["coupon_id"].'">'.$row['name'].'</label>
								  <span class="price">$ '.$row['price'].'
								  </div>';
						} ?>
						<input type="submit" value="Save" />
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php include_once "common/footer.php" ?>
