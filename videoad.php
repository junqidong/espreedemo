<?php
	session_start();
	if(!$_SESSION["email"]){
		header("Location: index.php");
	}
?>

<?php include_once "common/header.php" ?>
<?php include_once "common/navbar.php" ?>

<div align="center" class="embed-responsive embed-responsive-16by9">
	<!-- 
	poster: allows for image to show as a preview for video
	autoplay: self explantory 
	-->
    <video controls class="embed-responsive-item" poster="ads/image.jpg">
        <source src="ad.mp4" type="video/mp4">
        <!-- Fall Back-->
        <p>
  			Your browser doesn't support HTML5 video.
    	</p>
    </video>
</div>

<?php include_once "common/footer.php" ?>