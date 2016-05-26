<!-- In here the chat stuff -->

<i class="chat-trigger fa fa-comments fa-5x" aria-hidden="true"></i>

<div class="chat">
	<h3>Chat<i class="fa fa-close right chat-closer"></i></h3>
	<div id="messages">
	<?php
		if(file_exists("src/chatLog.html") && filesize("src/chatLog.html") > 0){
		    $handle = fopen("src/chatLog.html", "r");
		    $contents = fread($handle, filesize("src/chatLog.html"));
		    fclose($handle);
		     
		    echo $contents;
		}
	 ?>
	</div>
	  <textarea id="submit-msg" placeholder="Type a message..."></textarea>
</div>