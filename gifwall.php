<?php
	require 'src/dbconnect.php';
	require 'src/functions.php';
 ?>

<?php
	$file_dir = "/src/gifs/";

	$gif = $oDb->query("SELECT * FROM gifs WHERE accepted = '1' ");
	$aGifs = $gif->fetchAll(PDO::FETCH_ASSOC);
 ?>
<!DOCTYPE html>

<html>

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="shortcut icon" href="favicon.ico" />	
		<link rel="stylesheet" href="css/normalize.css">
		<link rel="stylesheet" href="slick/slick.css">
		<link rel="stylesheet" href="css/style.css"> 
		<title>Gif Wall</title>
	</head>

	<body>
		
		<div class="info left">
			<div class="menu">
				<h2>Menu</h2>
				<table>
					<tr>
						<td>Beer</td>
						<td>12kr</td>
					</tr>
					<tr>
						<td>Shots</td>
						<td>10kr</td>
					</tr>
					<tr>
						<td>Drinks</td>
						<td>25kr</td>
					</tr>
					<tr>
						<td>etc!</td>
						<td>0kr</td>
					</tr>
				</table>
			</div>
			<div class="instructions">
				<h2>Wanna contribute a Gif?</h2>
				<p>Go to www.blabla.bla, create an account and go nuts!</p>
			</div>
		</div>
		
		
		<div class="gif-wrap right">
	  		<div class="slider">
		  		<?php 
		  			for ($i=0; $i < count($aGifs); $i++) { 
		  				$file_name = $aGifs[$i]['name'];
						$file_path = $file_dir.$file_name;
						$gif_id = $aGif[$i]['gif_id'];
		  		?>
		  			<div>
		  				<img class="slider-gif" data-id="<?php echo $gif_id; ?>" src="<?php echo $file_path; ?>">
		  			</div>
		  		<?php } ?>
	  		</div>
		</div>
		
		<!--  -->

		<script src="js/jquery-2.1.1.min.js"></script>
		<!-- // <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script> -->


		<script type="text/javascript" src="slick/slick.min.js"></script>
		<script type="text/javascript" src="js/fileupload.js"></script>
		
		<script src="js/script.js"></script>
	</body>

</html>	