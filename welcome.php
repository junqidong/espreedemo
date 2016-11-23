<?php
	session_start();
	if(!$_SESSION["email"]){
		header("Location: index.php");
	}
?>

<?php include_once "common/header.php" ?>
<?php include_once "common/navbar.php" ?>

<div class="container">
	<div class="row">
		<div class="col-sm-4">
		<a class="button-advert" href="#"> Example Ad</a>
		</div>
		<div class="col-sm-4">
		<a class="button-advert" href="#"> Example Ad</a>
		</div>
		<div class="col-sm-4">
		<a class="button-advert" href="#"> Example Ad</a>
		</div>
		<div class="col-sm-4">
		<a class="button-advert" href="#"> Example Ad</a>
		</div>
		<div class="col-sm-4">
		<a class="button-advert" href="#"> Example Ad</a>
		</div>
		<div class="col-sm-4">
		<a class="button-advert" href="#"> Example Ad</a>
		</div>
	</div>
</div>

<?php include_once "common/footer.php" ?>