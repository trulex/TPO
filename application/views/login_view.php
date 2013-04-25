<center>
    <?php echo validation_errors(); ?>
    <?php echo form_open('verifylogin'); ?>
    <form>
	<input type="text" size="20" id="username" name="username" placeholder="Username" />
	<br/>
	<input type="password" size="20" id="password" name="password" placeholder="Password" />
	<br/>
	<input type="submit" value="Login"/>
    </form> 
</center>