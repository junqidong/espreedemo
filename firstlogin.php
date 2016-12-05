<?php
	require "dbinfo.php";
	session_start();
	$error = "";
	
	$dbConnection = new mysqli($host, $username, $password, $database);
	//mysqli_report(MYSQLI_REPORT_ALL);
	
		
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
				$stmt = $dbConnection->prepare("UPDATE Users SET categories_picked='1' WHERE user_id=?");
				$stmt->bind_param("s", $userid);
				
				if(!$stmt->execute()){
					$error = "<div class=\"alert alert-danger\"> Error picking coupon.</div>";
				} else {
					header('Location: welcome.php');
				}
			}	
		}
		// 
		$stmt = $dbConnection->prepare("SELECT Brand.brand_name, Coupons.coupon_id, Coupons.name, Coupons.price FROM Coupons LEFT JOIN Brand ON Coupons.brand_id = Brand.brand_id");
		if($stmt){
		
		if(!$stmt->execute()){
			$error = "<div class=\"alert alert-danger\"> Error. </div>";
		} else {
			$result = $stmt->get_result();
		}
		
		$stmt->close();
		} else {
			echo var_dump($stmt);

		}
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
