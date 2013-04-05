<?php echo form_open('verifyaddproject'); ?>

<div id="add">
    <p>Create a new project</p>
    <label>Project name</label>
	<input type="text" name="projectname" value="<?php echo set_value('projectname'); ?>" size="20"/><br>
	
    <label>Project description</label>
	<textarea name="description" rows="5" value="<?php echo set_value('description'); ?>" cols="20"></textarea><br>

    <div><input type="submit" value="Create project" /></div>
</div>
<div id="add">
	<p>Projects: </p><br>
	<?php
		foreach($results as $row){
			echo $row->project_name;
			echo " ".anchor('editproject', 'Edit!');
			echo "<br>";
		}
	?>
</div>
<div id="validation">
	<?php echo validation_errors(); ?>
</div>
</form>