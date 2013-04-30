<!--avtor:darko-->
<?php echo form_open('editUser/verifyEdit'); 
$msg=strcmp($message,'');
?>
<div id="content">
    <div id="left">
    <h2>Edit user</h2>
	<div id="add">
	    <label>Username</label>
	    <input type="text" name="username" value="<?php echo set_value('username',$username1); ?>" size="20" />
	    <?php echo form_error('username','<div id="validation">','</div>'); ?><br />
	    
	    <label>Name</label>
	    <input type="text" name="name" value="<?php echo set_value('name',$name1) ?>" size="20"/><?php echo form_error('name','<div id="validation">','</div>'); ?><br />
	    
	    <label>Surname</label>
	    <input type="text" name="surname" value="<?php echo set_value('surname',$surname1) ?>" size="20"/><?php echo form_error('surname','<div id="validation">','</div>'); ?><br />
	    
	    <label>Email</label>
	    <input type="text" name="email" value="<?php echo set_value('email',$email1) ?>" size="20"/><?php echo form_error('email','<div id="validation">','</div>'); ?><br />
	    
	    <label>System rights</label>
	    <?php 
		$rights=array('0'=>'user', '1'=>'administrator' );
		echo form_dropdown('rights',$rights,$rights1,'size="2"');
	    ?>
	    <br />
	    
	    <label>New password</label>
	    <input type="password" name="password" size="20" /><?php echo form_error('password','<div id="validation">','</div>'); ?><br />
	    
	    <span style="color:red">*</span><label>Confirm new password</label>
	    <input type="password" name="confirm_password" size="20" /><?php echo form_error('confirm_password','<div id="validation">','</div>'); ?><br />
	    
	    <small><span style="color:red">*</span>Enter only if you want to change the current password.</small>
	    
	    <div><form name="submit" action="editUser/verifyEdit"><input type="submit" value="Submit"/></form></div>
	</div>
	<?php echo anchor('editUsers', 'Edit users'); ?>
    </div>
</div>
<?php if($msg!=0) {
	echo '<p style="color:blue;margin-left:15%">'.$message.'</p>';
} ?>
</form>