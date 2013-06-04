<!-- views/login_view.php -->

<center>
    <?php echo validation_errors(); ?>
    <?php echo form_open('verifylogin'); ?>
    <form>
	<input type="text" size="20" id="username" name="username" placeholder="Username" autofocus="autofocus" required/>
	<br/>
	<input type="password" size="20" id="password" name="password" placeholder="Password" required/>
	<br/>
	<input type="submit" value="Login"/>
    </form> 
</center>