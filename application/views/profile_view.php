<!--avtor:darko-->
<?php echo form_open('profile/verifyEdit'); 
$msg=strcmp($message,'');
?>
<div id="content">
    <div id="left">
	<div id="add">
	    <p>Edit profile</p>
	    <span style="color:red;vertical-align:top">*</span><label>Username</label>
	    <input type="text" name="username" value="<?php echo set_value('username',$userData->username); ?>" size="20" />
	    <?php echo form_error('username','<div id="validation">','</div>'); ?><br />
	    
	    <span style="color:red;vertical-align:top">*</span><label>Name</label>
	    <input type="text" name="name" value="<?php echo set_value('name',$userData->name) ?>" size="20"/><?php echo form_error('name','<div id="validation">','</div>'); ?><br />
	    
	    <span style="color:red;vertical-align:top">*</span><label>Surname</label>
	    <input type="text" name="surname" value="<?php echo set_value('surname',$userData->surname) ?>" size="20"/><?php echo form_error('surname','<div id="validation">','</div>'); ?><br />
	    
	    <label>Email</label>
	    <input type="text" name="email" value="<?php echo set_value('email',$userData->email) ?>" size="20"/><?php echo form_error('email','<div id="validation">','</div>'); ?><br />
	    
	    <span style="color:orange;vertical-align:top">*</span><label>New password</label>
	    <input type="password" name="password" size="20" /><?php echo form_error('password','<div id="validation">','</div>'); ?><br />
	    
	    <span style="color:orange;vertical-align:top">*</span><label>Confirm new password</label>
	    <input type="password" name="confirm_password" size="20" /><?php echo form_error('confirm_password','<div id="validation">','</div>'); ?><br />
	    
	    <span style="color:orange;vertical-align:top">*</span><small>Enter only if you want to change your current password.</small>
	    
	    <div><form name="submit" action="profile/verifyEdit"><input type="submit" value="Submit"/></form></div>
	</div>
   </div>
</div>
<?php if($msg!=0) {
	echo '<p style="color:blue;margin-left:15%">'.$message.'</p>';
    } ?>
</form>