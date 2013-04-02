<?php echo form_open('verifyaddstory'); 
$msg=strcmp($message,'');
?>
<div id="add">
    <p>Add a new user story</p>
    <label>Name</label>
    <input type="text" name="name" value="<?php if($msg==0) {echo set_value('name');} ?>" size="20"/><br />
    <label>Text</label>
    <textarea name="text" class="addstory" cols="19" rows="3"> <?php if($msg==0) {echo set_value('text');} ?> </textarea><br />
    <label>Tests</label>
    <textarea name="tests" class="addstory" cols="19" rows="3"><?php if($msg==0) {echo set_value('tests');} ?></textarea><br />
    <label>Business value</label>
    <input type="text" name="business_value" value="<?php if($msg==0) {echo set_value('business_value');} ?>" size="20"/><br />
    <label>Priority</label>
    <select name="priority">
	<option value="musthave">Must have</option>
	<option value="shouldhave">Should have</option>
	<option value="couldhave">Could have</option>
	<option value="wonthave">Won't have this time</option>
    </select>
    <!--
    <?php
    $priorities=array('Must have','Should have','Could have', 'Won\'t have this time');
    echo form_dropdown('priority', $priorities, $this->input->post('priority'));
    ?>
    -->
    <div><input type="submit" value="Submit" /></div>
</div>
<div id="uservalidation">
    <?php echo validation_errors(); ?>
</div>
<?php if($msg!=0) {
	echo '<p style="color:blue;margin-left:25%">'.$message.'</p>';
    } ?>
</form> 
