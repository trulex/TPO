<?php echo form_open('verifyadduser'); ?>
<div id="adduser">
    <p>Add a new user</p>
    <label>Username</label>
    <input type="text" name="username" value="<?php echo set_value('username'); ?>" size="20"/><br />
    <label>Password</label>
    <input type="text" name="password" value="<?php echo set_value('password'); ?>" size="20"/><br />
    <label>Name</label>
    <input type="text" name="name" value="<?php echo set_value('name'); ?>" size="20"/><br />
    <label>Surname
    <input type="text" name="surname" value="<?php echo set_value('surname'); ?>" size="20"/><br />
    <label>Email</label>
    <input type="text" name="email" value="<?php echo set_value('email'); ?>" size="20"/><br />
    <label>Rights</label>
    <select name="rights">
	<option value="user">User</option>
	<option value="admin">Administrator</option>
    </select>
    <div><input type="submit" value="Submit" /></div>
</div>
<div id="uservalidation">
    <?php echo validation_errors(); ?>
</div>
</form>