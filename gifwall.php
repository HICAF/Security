<?php
	require 'src/dbconnect.php';
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
		
		<div class="info left half">
			<div class="header"><img class="logo-inv left" src="img/logo-inv.jpg" alt="KEA Fredagsbar">
								<h2>PRICELIST</h2>
								<h3>Creative Suite Edition</h3>
								</div>
			<div class="special">
				2 PILSNER<br><span>25,-</span>
			</div>
			
			<h4>ALL DRINGS 40CL (EXCEPT MS PAINT)</h4>
			
			<div class="menu">
				<div class="left half">
					<table>
						<tr>
							<td>15,-</td>
							<td>
								<h5>TAP BEER</h5>
								<div class="details">
									Royal Pilsner<br>
									Royal Classic
								</div>
							</td>
						</tr>
						<tr>
							<td>15,-</td>
							<td>
								<h5>CIDER</h5>
								<div class="details">
									Tempt 69
								</div>
							</td>
						</tr>
						<tr>
							<td>20,-</td>
							<td>
								<h5>JÄGERBOMB</h5>
								<div class="details">
									2: 35,-
								</div>
							</td>
						</tr>
						<tr>
							<td>50,-</td>
							<td>
								<h5>10 SHOTS</h5>
								<div class="details">
									Små Grønne<br>
									Små Sure<br>
									Fisk (40,-)
								</div>
							</td>
						</tr>
						<tr>
							<td>10,-</td>
							<td>
								<h5>1 SHOT</h5>
								<div class="details">
									Små Gronne - Fisk<br>
									Små Sure - Vodka - Gin<br>
									Dark Rhum - Kahlua<br>
									Sambucca - Fernet Branca<br>
									Kleiner Feigling - Jägermeister<br>
									Southern Comfort
								</div>
							</td>
						</tr>
					</table>
				</div>
				
				<div class="right half">
					<table>
						<tr>
							<td>
								<h5>PHOTOSHOP</h5>
								<div class="details">
									Vodka + Faxekondi + Curacao (blue colour)
								</div>
							</td>
							<td>
								<img src="img/ps.png">
							</td>
							<td>25,-</td>
						</tr>
						<tr>
							<td>
								<h5>ILLUSTRATOR</h5>
								<div class="details">
									Vodka + Orange Juice + Grenadine
								</div>
							</td>
							<td>
								<img src="img/ai.png">
							</td>
							<td>25,-</td>
						</tr>
						<tr>
							<td>
								<h5>FLASH</h5>
								<div class="details">
									Rhum + Ginger Ale + Grenadine
								</div>
							</td>
							<td>
								<img src="img/fl.png">
							</td>
							<td>25,-</td>
						</tr>
						<tr>
							<td>
								<h5>DREAMWEAVER</h5>
								<div class="details">
									Vodka + Energu Drink + Faxekondi
								</div>
							</td>
							<td>
								<img src="img/dw.png">
							</td>
							<td>25,-</td>
						</tr>
						<tr>
							<td>
								<h5>INDESIGN</h5>
								<div class="details">
									Gin + Bitter Lemon + Grenadine
								</div>
							</td>
							<td>
								<img src="img/id.png">
							</td>
							<td>25,-</td>
						</tr>
						<tr>
							<td>
								<h5>MS PAINT</h5>
								<div class="details">
									2cl Vodka + 2cl Gin + 25cl SoCo + 2cl Rhum + Pepsi
								</div>
							</td>
							<td>
								<img src="img/ms.png">
							</td>
							<td>40,-</td>
						</tr>
					</table>
				</div>
			</div>
			
			<div class="instructions">
				<h2>Wanna contribute a Gif?</h2>
				<p>Go to 188.166.160.44, create an account and go nuts!</p>
			</div>
			
		</div>
		
		
		<div class="gif-wrap right half">
	  		<div class="slider">
		  		<?php 
		  			for ($i=0; $i < count($aGifs); $i++) { 
		  				$file_name = $aGifs[$i]['name'];
						$file_path = $file_dir.$file_name;
						$gif_id = $aGif[$i]['gif_id'];
		  		?>
		  			<div>
		  				<img class="slider-gif" data-id="<?php echo $gif_id; ?>" src="<?php echo $file_path; ?>" alt="Funny.">
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