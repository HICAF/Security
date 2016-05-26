<?php require 'header.php'; 

	if ($_SESSION['admin'] == 0) {
		header("location: index.php");
		echo "
			<script>
				alert('YOU DO NOT HAVE ACCESS TO THIS SITE!');
				window.location.href='gifupload.php';
			</script>";
	}

	$file_dir = "/src/gifs/";

	$gif = $oDb->query("SELECT * FROM gifs WHERE pending = '1' ");
	$aGifs = $gif->fetchAll(PDO::FETCH_ASSOC);

	$oldestGif = $aGifs[0];

	for ($i=1; $i < count($aGifs); $i++) { 
		if ($oldestGif['uploaded'] > $aGifs[$i]['uploaded']) {
			$oldestGif = $aGifs[$i];
		}
	}

	$file_name = $oldestGif['name'];
	$file_path = $file_dir.$file_name;
	$gif_id = $oldestGif['gif_id'];

?>

	<h2>Do you approve of this gif?</h2>
	
	<div class="gif-approver-wrapper">
	<?php if (count($aGifs) == 0 ) { ?>
		<h2>No new gifs to be checked.</h2>
	<?php } else { ?>
		<img class="current-gif" data-id="<?php echo $gif_id; ?>" src="<?php echo $file_path; ?>" alt="Current Gif">
	<?php } ?>
		<button class="gif-rejected btn btn-danger btn-lg" id="btn-gif-rejected">X</button>		
		<button class="gif-accepted btn btn-success btn-lg" id="btn-gif-accepted">√</button>
		<br><br><a href="gifwall.php">See Gif Wall</a>
	</div>
<!-- TODO: add Swipe option for touch devices -->
		
		
<?php require 'footer.php'; ?>