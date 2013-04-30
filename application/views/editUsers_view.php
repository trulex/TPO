<!--avtor:darko-->
<div id="content">
    <div id="left" style="width:400px">
	<h2>Edit users</h2>
	<?php 
	    foreach($users as $user) {
		echo '<div class="editUsers">';
		    echo '<div style="float:left">'.$user->username.' ('.$user->name.' '.$user->surname.')</div>
		    
		    <div style="float:right;margin-bottom:5px">
		    '.form_open('editUsers/deleteUser','style="display:inline" name="deleteUser"').'
		    <button type="submit" name="deleteUser" value="'.$user->username.'">Delete</button>
		    </form>
		    
		    '.form_open('editUser','style="display:inline" name="editUser"').'
		    <button type="submit" name="editUser" value='.$user->username.'">Edit</button>
		    </form>
		    </div>
		    
		    <div style="clear:both"></div>';
		echo '</div>';
	    }
	    if(strcmp($message,'')!=0) {
	    echo '<br />';
	    echo '<p style="color:blue">'.$message.'</p>';
	}
	?>
    </div>
</div>