<!-- views/editTask.php -->
<!--avtor:Lovrenc-->
<div id="content">
    <div id="left">
		<div id="add">
		<p>Edit Task </p>
			<?php	$this->load->helper('form');
				echo form_open('editTask/taskModifier'); ?>
				<span style="color:red">*</span><label>Task name</label>
				<input type="text" name="task_name" required value="<?php echo $TName ?>" size="30"/><br>
				<span style="color:red;vertical-align:top;vertical-align:left">*</span><label>Text</label>
				<textarea name="text" class="addTask" required cols="20" rows="3"><?php echo $TText?> </textarea><br />
				<label>Time estimate</label>
				<input type="text" name="time_estimate" value="<?php echo $TTimeEstimate?>" size="6"/><br>
				<label>Work done</label>
				<input type="text" name="time_sum" value="<?php echo $TTimeSum?>" size="6"/><br>
				<label>assigned to</label>
				<?php echo '<select name="UID">' ;
								echo ' <option value="0"><not asigned></option>';
								foreach ($projectUsers as $user){
									if($user->UID == $TUID){
										$selected=" selected ";
									}
									else{
										$selected='';
									}
									echo ' <option '.$selected.' value="'.$user->UID.'">'.$this->users->getUserName($user->UID).'</option>';
								}
								echo '</select>';?>
				<label>accepted</label>
				<input type="checkbox" name="accepted" value="1" <?php if($TAccepted) echo 'checked="checked"';?> /><br>
				<label>Completed</label>
				<input type="checkbox" name="completed" value="1" <?php if($TCompleted) echo 'checked="checked"';?> /><br>
				<input name="TID" type="hidden" value="<?php echo $TID?>" />
				<input type="submit" value="Submit" />
			</form>
			<?php if (!$TUID){
					echo form_open('editTask/taskDestroyer');
					echo '<input name="TID" type="hidden" value="'.$TID.'" />';
					echo '<input type="submit" value="Delete task" />';
					echo '</form>';
				}
			?>
			<?php echo $message ?>
		</div>
	</div>
</div>