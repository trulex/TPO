<!--avtor:BOSTJAN-->
<?php echo form_open('verifyaddproject'); ?>

<div id="content">
    <div id="left">
	<div id="add">
	    <p>Create a new project</p>
	    <label>Project name</label>
		<input type="text" name="projectname" value="<?php echo set_value('projectname'); ?>" size="20"/><br>
		
	    <label>Project description</label>
		<textarea name="description" rows="5" value="<?php echo set_value('description'); ?>" cols="20"></textarea><br>

	<div><input type="submit" value="Create project" /></div>
	</div>
	<div id="content">
	<p>Projects: </p><br>
	<?php
		foreach($results as $row){
			echo $row->project_name;
			echo " ".anchor('editproject', 'Edit');
			echo "<br>";
		}
	?>
	</div>
	<div id="projectvalidation">
		<?php echo validation_errors(); ?>
	</div>
    </div>
</div>
</form>