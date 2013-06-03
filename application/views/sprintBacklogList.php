<!-- SprintBacklogList -->
<!--avtor:Lovrenc-->

<?php 
	switch($mode){
		case 0:
			$naslov="Unassigned Tasks";
		break;
		case 1:
			$naslov="Assigned Tasks";
		break;
		case 2:
			$naslov="All Tasks";
		break;
		case 3:
			$naslov="Finished Tasks";
		break;
		case 4:
			$naslov="Active Tasks";
		break;
	}
?>
<div id="content">
    <div id="left">
		<div id="add">
			<p><?php echo $naslov; ?> </p><br>
			<?php foreach($tuples as $tuple){
					$tasks=$tuple[1];
					$story=$tuple[0];
					?>
					<div class="zgodba">
						<?php echo "<h4>".$story->name." (Estimate: ".round($story->difficulty,1)." pts.)</h4>"; ?>
						<div class="gumbR">
						
						</div>
					</div>
					<div class="taski">
					<?php
						echo "<h5>".$story->text."</h5><br>";
						echo "<div style=color:001FFF;font-size:12;margin-top:-10;>";
						foreach(explode("\n", $story->tests) as $test) {
							echo $test.'<br>';
						}
						echo '</div>';
						echo '<hr>';
						if($mode==1){
							echo '<div style="float:left;font-weight:bold;">Tasks</div>';
							echo '<div style="float:right;font-weight:bold;margin-left:30px;margin-right:20px;">Remaining</div>';
							echo '<div style="float:right;font-weight:bold;margin-left:30px;margin-right:20px;">Member</div>';
							echo '<div style="float:right;font-weight:bold;margin-left:30px;margin-right:20px;">Status</div><br>';
							echo '<hr>';
						}else{
							echo '<div style="float:left;font-weight:bold;">Tasks</div><br>';
							echo '<hr>';
						}
						foreach($tasks as $task){
							if($mode==1){
								echo '-'.$task->name;
							}else{
								echo '-'.$task->name.'<br>';
							}
							
							if($mode==1){
								echo ' [Estimate: '.$task->time_estimate.'h]';
								echo '<div style="float:right;display:inline-block;margin-right:20px;min-width:85px;text-align:right">'.($task->time_estimate - $this->tasks->getTime($task->name, $task->UID))."h".'</div>';
								echo '<div style="float:right;display:inline-block;margin-right:52px;min-width:100px;text-align:right">'.$this->users->getUserName($task->UID).'</div>';
								if($task->completed == 1){
									echo '<div style="float:right;display:inline-block;margin-right:15px;min-width:90px;color:green;text-align:right">Completed</div><br>';
								}
								else{
									echo '<div style="float:right;display:inline-block;margin-right:15px;min-width:90px;color:orange;text-align:right">Assigned</div><br>'; 
								} 
							}
							else if(!$mode){
								if ( $rights || $role==1 ){			
									echo '<form name="asign" class="assignTaskUser" method="post" action="unassignedTasks/asignTask">';
									echo '<input name="redirect" type="hidden" value="'.$this->uri->uri_string().'" />';
									echo '<select name="UID">' ;
									foreach ($projectUsers as $user){
										echo ' <option value="'.$user->UID.'">'.$user->name.'</option>';
									}
									echo '</select>';
									echo '<input name="TID" type="hidden" value="'.$task->id.'"/>';
									echo '<button type="submit" value="'.$task->id.'" name="TID">Assign</button></form></b>';	
								}
								else{
									//take task
									echo '<form name="takeTask" class="takeTaskButton" method="post" action="unassignedTasks/takeTask">';
									echo '<input name="UID" type="hidden" value="'.$id.'" />';
									echo '<button type="submit" value="'.$task->id.'" name="TID">Take task</button>';
									echo '<input name="redirect" type="hidden" value="'.$this->uri->uri_string().'" /></form>';
								}
										
								echo '<form name="edittasks" class="editTaskButton" action="editTask" method="post">';
								echo '<input type="submit" name="TID" value="Edit" />';
								echo '<input type="hidden" name="TID" value='.$task->id.'" />';
								echo '</form>';
								//echo '<br>';
							}
						}
					?>
					</div>
					<div class="notes">
						<h5 id="note"><?php foreach(explode("\n", $story->note) as $note) { echo $note.'<br>';}?></h5>
						<div class="gumbR">
							<form name="editNote" method="post" action="editNote" style="display:inline;">
								<input name="redirect" type="hidden" value="<?php echo $this->uri->uri_string(); ?>" />
								<button type="submit" value="<?php echo $story->id; ?>" name="StID">Notes</button>
							</form>
						</div>
						<br>
					</div>
					<?php 
						if(!$mode){
							echo '<div class="gumbR">';
							echo '<form name="createTask" class="addTaskButton" action="verifyAddTask" method="post">';
							echo '<input type="submit" name="task" value="Add a task" />';
							echo '<input type="hidden" name="task" value='.$story->id.'/>';
							echo '</form>';
							echo '</div>';
						}
					} ?>	
		</div><br>
	</div>
    </div>
</form>