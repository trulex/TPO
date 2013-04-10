<!--avtor:Lovrenc-->
<?php echo form_open('verifyAddTask',$StID);?>
<div id="content">
    <div id="left">
	<div id="add">
	<p>Add Task <?php echo $StID ?></p>
	    <span style="color:red">*</span><label>Task name</label>
		<input type="text" name="task_name" value="<?php echo set_value('task_name'); ?>" size="30"/><br>
		<small><span style="color:red;font-weight:normal"><?php echo form_error('task_name'); ?></span></small>

		<span style="color:red;vertical-align:top;vertical-align:left">*</span><label>Text</label>
	    <textarea name="text" class="addTask" cols="19" rows="3"> <?php echo set_value('text'); ?> </textarea><br />
		<label>Time estimate</label>
		<input type="text" name="task_name" value="<?php echo set_value('time_estimate'); ?>" size="6"/><br>
	    <div><form action="verifyAddTask"><input type="submit" value="Create task" /></form></div>
	    <span style="color:red;font-weight"><?php echo $this->session->flashdata('flashSuccess') ?></span>
	</div>
	</div>
</div>
</form>