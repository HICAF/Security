<?php require 'header.php'; ?>

 <?php
	if ($_SESSION['admin'] == 0) {
		echo "
			<script>
				alert('YOU DO NOT HAVE ACCESS TO THIS SITE!');
				window.location.href='gifupload.php';
			</script>";
	}
 ?>

	<h2>Do you approve of this Gif?</h2>
	
	<div class="gif-approver-wrapper">
		<img class="current-gif" src="img/test.gif" alt="Current Gif">
	
		<button class="gif-rejected btn btn-danger btn-lg">X</button>			
		<button class="gif-accepted btn btn-success btn-lg">√</button>
		<br><br><a href="gifwall.php">See Gif Wall</a>
	</div>
<!-- TODO: add Swipe option for touch devices -->
		
<?php require 'chat.php'; ?>
		
<?php require 'footer.php'; ?>