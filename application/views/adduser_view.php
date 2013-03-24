<?php echo validation_errors();
echo form_open('verifyadduser');
?>
<p>Add a new user</p>
Username
<input type="text" name="username" value="" size="20" /><br />
Password
<input type="text" name="password" value="" size="20" /><br />
Name
<input type="text" name="name" value="" size="20" /><br />
Surname
<input type="text" name="surname" value="" size="20" /><br />
Email
<input type="text" name="email" value="" size="20" /><br />
Rights
<select name="rights">
    <option value="user">User</option>
    <option value="admin">Administrator</option>
</select>
<div><input type="submit" value="Submit" /></div>
</form>