<?php require 'header.php'; ?>

		
		<h3>Gif Upload</h3>
		<p>You can either upload a gif from your own device or provide a link. Remember guys, keep it (almost) PG.</p>
			
		<form action="/src/ajax.php?uploadFile=true" method='post' enctype='multipart/form-data'>
	  <div class="fileupload fileupload-new" data-provides="fileupload">
	    <span class="btn btn-default btn-lg btn-file"><span class="fileupload-new">Upload a Gif</span>
	    <span class="fileupload-exists">Change</span><input type="file" name="fileToUpload" id="fileToUpload"/></span>
	    <span class="fileupload-preview"></span>
	    <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>
	  </div>
		<div class="form-group">
		  <label for="linkToUpload">Or pass the URL:</label>
		  <input type="text" name="linkToUpload" class="form-control" id="linkToUpload" placeholder="URL: (http://www.example.com/path-to-gif)">
		</div>
			<input class="btn btn-primary" type="submit" value="Upload Image" name="submit">
		</form>
		<br>
		<!-- <a href="gifwall.php">See Gif Wall</a> -->
		
<?php require 'footer.php'; ?>