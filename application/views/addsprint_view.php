<?php echo form_open('verifyaddsprint'); ?>

<div id="add">
	<p>Add a new sprint</p>
    <label>Start date</label>
	<input type="text" name="startdate" value="<?php echo set_value('startdate'); ?>" size="20"/>
	<label>(dd.mm.YYYY)</label><br>
	
    <label>Finish date</label>
	<input type="text" name="finishdate" value="<?php echo set_value('finishdate'); ?>" size="20"/>
	<label>(dd.mm.YYYY)</label><br>
	
    <label>Sprint velocity</label>
	<input type="text" name="velocity" value="<?php echo set_value('velocity'); ?>" size="3"/>
	<label>(in story points)</label><br>
	
    <div><input type="submit" value="Create sprint" /></div>
</div>
<div id="sprintvalidation">
	<?php echo validation_errors(); ?>
</div>
</form>