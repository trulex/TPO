<!-- views/installation.php -->
<!-- avtor: lovrenca -->
<div>
	<h>INSTALATION</h>
	<p> Welcome to the the install page, if you feel you arrived here by mistake, retun to the homepage.</p>
	<p> Type your desired administrator username and password below, and click "submit"<p>
	<?php echo form_open('installation/reboot'); ?>
		<label>Username</label>
		<input type="text" name="username" size="30" required/><br>
		<label>Password</label>
		<input type="password" name="password" size="20" required/><br />
		<input type="submit" value="Submit" />
	</form>
	<p style="color:red"> WARNING: This will set up empty database, erasing all existing data</p>
</div>