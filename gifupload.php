<?php require 'header.php'; ?>

		
		<h3>Gif Upload</h3>
		<p>This is how it works: Cat ipsum dolor sit amet, groom yourself 4 hours - checked, have your beauty sleep 18 hours - checked, be fabulous for the rest of the day - checked! yet lay on arms while you're using the keyboard but caticus cuteicus for wake up human for food at 4am.</p>
		
		<!-- <form>
			<!--TODO: Make nice. --
			<label class="control-label">Select GIF:</label>
			<span class="btn btn-default btn-file">
			    Browse <input type="file">
			</span>
			<br>
			<input class="btn btn-primary" type="submit">
		</form> -->
			
		<!-- <form>	
	  <div class="fileupload fileupload-new" data-provides="fileupload">
	    <span class="btn btn-default btn-lg btn-file"><span class="fileupload-new">Select a Gif</span>
	    <span class="fileupload-exists">Change</span><input type="file" /></span>
	    <span class="fileupload-preview"></span>
	    <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>
	  </div>
		
			<input class="btn btn-primary" type="submit">
		</form> -->
		<br>
		<a href="gifwall.php">See Gif Wall</a>


        <form action="/src/ajax.php?function=upload-file" method='post' enctype='multipart/form-data'>
		    Select image to upload:
		    <input type="file" name="fileToUpload" id="fileToUpload"> | <input type="text" name="linkToUpload" id="linkToUpload" placeholder="URL: (http://www.example.com/path-to-gif)"> <br />
		    <input type="submit" value="Upload Image" name="submit">
		</form>
		
		
<?php require 'footer.php'; ?>