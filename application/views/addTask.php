<!-- views/addTask.php -->
<!--avtor:Lovrenc-->
<div id="content">
    <div id="left">
	<div id="add">
	<p>Add Task </p>
		<?php echo form_open('verifyAddTask/taskCreator'); ?>
			<span style="color:red">*</span><label>Task name</label>
			<input type="text"  required name="task_name" value="<?php echo $task_name ?>" size="30"/><br>
			<span style="color:red;vertical-align:top;vertical-align:left">*</span><label>Text</label>
			<textarea name="text" required class="addTask" cols="20" rows="3"><?php echo $text?> </textarea><br />
			<label>Time estimate</label>
			<input type="text" required name="time_estimate"  size="6"/><br>
			<input name="StID" type="hidden" value="<?php echo $StID;?>" />
			<input type="submit" value="Submit" />
		</form>
		<?php echo $message?>
	</div>
	</div>
</div>