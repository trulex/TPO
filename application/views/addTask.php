<!--avtor:Lovrenc-->
<?php echo form_open('verifyAddTask'); 
$msg=strcmp($message,'');
$err=strcmp($noTask,'');
?>
<div id="content">
    <div id="left">
	<div id="add">
	<p>Add story</p>
	    <span style="color:red">*</span><label>Ime</label>
		<input type="text" name="task_name" value="<?php echo set_value('task_name'); ?>" size="30"/><br>
		<small><span style="color:red;font-weight:normal"><?php echo form_error('task_name'); ?></span></small>

		<span style="color:red;vertical-align:top">*</span><label>Text</label>
	    <textarea name="text" class="addTask" cols="19" rows="3"> <?php if($msg==0) {echo set_value('text');} ?> </textarea><br />
	    <div><form action="verifyAddTask"><input type="submit" value="Create task" /></form></div>
	    <span style="color:red;font-weight:normal"><?php echo $this->session->flashdata('flashSuccess') ?></span>
	</div>
</div>
</form>