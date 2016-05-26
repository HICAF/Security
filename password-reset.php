<?php	require 'header.php'; ?>

<?php $id = $_GET['id']; ?>

<h1>Reset your password</h1>

			<div class="form-group">
			  <label for="password">Change your password:</label>
				<input type="password" id="passwordReset" class="form-control" placeholder="New password" value="" />
				<br>
				<input type="password" id="passwordCheckReset" class="form-control" placeholder="Retype password" value="" />				
			</div>

<button data-id="<?php echo $id; ?>" class="btn btn-success" id="btn-password-reset">Go!</button>



<?php require 'footer.php'; ?>