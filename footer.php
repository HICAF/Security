<!-- In here the common footer stuff -->
		</div>
		
		<footer>
			<p>Fredags Bar is opened on Fridays 2pm - 11pm at Lygten 16</p>
			&copy; MICC | <?php echo date("Y"); ?>
		</footer>

<?php 
	if (isset($_SESSION['user'])) {
	 	require 'chat.php';
	 }  
 ?>

		<!-- JQuery -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script> 
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script> 

		<!-- Latest compiled and minified JavaScript bootstrap -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script> 


		<!-- Latest compiled and minified JavaScript SweetAlert -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script> 
		
		<script type="text/javascript" src="slick/slick.js"></script>
		<script type="text/javascript" src="js/fileupload.js"></script>
		<script src="js/script.js"></script>
	</body>

</html>	