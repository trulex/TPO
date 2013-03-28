<?php echo form_open('verifyaddstory'); ?>
<div id="adduser">
    <p>Add a new user story</p>
    <label>Name</label>
    <input type="text" name="name" value="<?php echo set_value('name'); ?>" size="20"/><br />
    <label>Text</label>
    <textarea name="text" class="addstory" cols="19" rows="3"> <?php echo set_value('text'); ?> </textarea><br />
    <label>Tests</label>
    <textarea name="tests" class="addstory" cols="19" rows="3"><?php echo set_value('tests'); ?></textarea><br />
    <label>Business value</label>
    <input type="text" name="business_value" value="<?php echo set_value('business_value'); ?>" size="20"/><br />
    <label>Priority</label>
    <?php
    $priorities=array('Must have','Should have','Could have', 'Won\'t have this time');
    echo form_dropdown('priority', $priorities, $this->input->post('priority'));
    ?>
    <br />
    <div><input type="submit" value="Submit" /></div>
</div>
<div id="uservalidation">
    <?php echo validation_errors(); ?>
</div>
</form> 
