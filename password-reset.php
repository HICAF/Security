<?php	require 'header.php'; ?>

<?php $id = $_GET['id']; ?>

<h1>Reset your password</h1><br />
<label>Change your password</label><br />
		<input type="password" id="passwordReset" placeholder="New password" value="" /><br />
		<input type="password" id="passwordCheckReset" placeholder="Retype password" value="" /><br />
		<button data-id="<?php echo $id; ?>" class="btn btn-success" id="btn-password-reset">Go! &nbsp;<i class="fa fa-arrow-right"></i></button>



<?php require 'footer.php'; ?>