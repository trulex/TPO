<!--avtor:darko-->
<?php echo form_open('verifyadduser'); 
$msg=strcmp($message,'');
?>
<div id="content">
    <div id="left">
	<div id="add">
	    <p>Add a new user</p>
	    <span style="color:red">*</span><label>Username</label>
	    <input type="text" name="username" value="<?php if($msg==0) {echo set_value('username');} ?>" size="20"/><br />
	    <span style="color:red">*</span><label>Password</label>
	    <input type="password" name="password" value="<?php if($msg==0) {echo set_value('password');} ?>" size="20"/><br />
	    <span style="color:red">*</span><label>Confirm password</label>
	    <input type="password" name="confirm_password" value="<?php if($msg==0) {echo set_value('confirm_password');} ?>" size="20"/><br />
	    <span style="color:red">*</span><label>Name</label>
	    <input type="text" name="name" value="<?php if($msg==0) {echo set_value('name');} ?>" size="20"/><br />
	    <span style="color:red">*</span><label>Surname</label>
	    <input type="text" name="surname" value="<?php if($msg==0) {echo set_value('surname');} ?>" size="20"/><br />
	    <label>Email</label>
	    <input type="text" name="email" value="<?php if($msg==0) {echo set_value('email');} ?>" size="20"/><br />
	    <label>Rights</label>
	    <select name="rights">
		<option value="0">User</option>
		<option value="1">Administrator</option>
	    </select>
	    <div><form name="submit" action="verifyadduser"><input type="submit" value="Submit"/></form></div>
	</div>
	<div id="validation">
	    <?php echo validation_errors(); ?>
	</div>
    </div>
</div>
<?php if($msg!=0) {
	echo '<p style="color:blue;margin-left:15%">'.$message.'</p>';
    } ?>
</form>