<!--avtor:BOSTJAN-->
<div id="content">
    <div id="left">
		<div id="add">
			<p>Unassigned tasks: </p><br>
			<?php foreach($stories as $row):
					$tasks=$this->tasks->getCurrent($row->id)?>
					<div class="zgodba">
						<?php echo "<h4>".$row->name." (Estimate: ".round($row->difficulty,2)." pts.)</h4><br>"; ?>
					</div>
					<div class="taski">
					<?php
						echo "<h5>".$row->text."</h5><br>";
						echo "<h4><b>Tasks</b></h4>";
						echo "<hr>";
						foreach($tasks as $task):?>
							<?php if($task->UID == 0){ ?>
								<?php echo "-".$task->name ?>
								<?php
								if ( $rights || $role==1 ){			
									echo '<form name="asign" class="assignTaskUser" method="post" action="unassignedtasks/asignTask">';
									echo '<input name="redirect" type="hidden" value="'.$this->uri->uri_string().'" />';
									echo '<select name="UID">' ;
									foreach ($projectUsers as $user){
										echo ' <option value="'.$user->UID.'">'.$this->users->getUserName($user->UID).'</option>';
									}
									echo '</select>';
									echo '<input name="TID" type="hidden" value="'.$task->id.'"/>';
									echo '<button type="submit" value="'.$task->id.'" name="TID">Assign</button></form></b>';	
								}
								else{
									//take task
									echo '<form name="takeTask" method="post" action="unassignedtasks/takeTask">';
									echo '<input name="UID" type="hidden" value="'.$id.'" />';
									echo '<button type="submit" value="'.$task->id.'" name="TID">Take task</button>';
									echo '<input name="redirect" type="hidden" value="'.$this->uri->uri_string().'" /></form>';
								}
								?>
							<form name="edittasks" class="editTaskButton" action="editTask" method="post">
								<input type="submit" name="TID" value="Edit" />
								<input type="hidden" name="TID" value=<?php echo $task->id ?> />
							</form>
							<?php } ?>
						<?php endforeach ?>
					</div>
					<form name="createTask" class="addTaskButton" action="verifyAddTask" method="post">
						<input type="submit" name="task" value="Add a task" />
						<input type="hidden" name="task" value=<?php echo $row->id ?> />
					</form>
		<?php endforeach ?>	
		</div><br>
	</div>
    </div>
</form>