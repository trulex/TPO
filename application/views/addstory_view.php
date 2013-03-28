<?php echo form_open('verifyaddstory'); ?>
<div id="adduser">
    <p>Add a new user story</p>
    <label>Name</label>
    <input type="text" name="name" value="<?php echo set_value('name'); ?>" size="20"/><br />
    <label>Text</label>
    <textarea name="text" value="<?php echo set_value('text'); ?>" /></textarea><br />
    <label>Tests</label>
    <textarea name="tests" value="<?php echo set_value('tests'); ?>"/></textarea><br />
    <label>Business value</label>
    <input type="text" name="business_value" value="<?php echo set_value('business_value'); ?>" size="20"/><br />
    <label>Priority</label>
    <select name="priority">
	<option value="musthave">Must have</option>
	<option value="shouldhave">Should have</option>
	<option value="couldhave">Could have</option>
    </select><br />
    <div><input type="submit" value="Submit" /></div>
</div>
<div id="uservalidation">
    <?php echo validation_errors(); ?>
</div>
</form> 
