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
		<option value="user">User</option>
		<option value="admin">Administrator</option>
	    </select>
	    <div><form name="submit" action="verifyadduser"><input type="submit" value="Submit"/></form></div>
	</div>
	<div id="validation">
	    <?php echo validation_errors(); ?>
	</div>
    </div>
        <div id="projects">
	    <p id="title">My projects</p>
	    <form name="selectp" method="post" action="selectProject/select">
	    <?php	    
		foreach ($projects as $project) {
		    echo '<button type="submit" value="'.$this->projects->getProjectName($project).'" name="project">'.$this->projects->getProjectName($project).'</button>';
		    echo '<br />';
		}
	    ?>
	    <input name="redirect" type="hidden" value="<?= $this->uri->uri_string() ?>" />
	    </form>
	</div>
</div>
<?php if($msg!=0) {
	echo '<p style="color:blue;margin-left:15%">'.$message.'</p>';
    } ?>
</form>