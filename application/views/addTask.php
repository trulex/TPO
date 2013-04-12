<!--avtor:Lovrenc-->

<div id="content">
    <div id="left">
	<div id="add">
	<p>Add Task </p>
	    <form name="addTask" method="post" action="verifyAddTask/taskCreator">
			<span style="color:red">*</span><label>Task name</label>
			<input type="text" name="task_name" size="30"/><br>
			<span style="color:red;vertical-align:top;vertical-align:left">*</span><label>Text</label>
			<textarea name="text" class="addTask" cols="20" rows="3"> </textarea><br />
			<label>Time estimate</label>
			<input type="text" name="time_estimate"  size="6"/><br>
			<input name="StID" type="hidden" value="<?php echo $StID?>" />
			<input type="submit" value="submit" />
		</form>
	</div>
	</div>
</div>