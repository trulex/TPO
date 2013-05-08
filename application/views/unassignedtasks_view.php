<!--avtor:BOSTJAN-->
<div id="content">
    <div id="left">
		<div id="add">
			<p>Unassigned tasks: </p><br>
			<?php foreach($stories as $row):
					$tasks=$this->tasks->getCurrent($row->id)?>
					<div class="zgodba">
						<?php echo "<h4>".$row->name." (Estimate: ".round($row->difficulty,2)." pts.)</h4>"; ?>
						<div class="gumbR">
						
						</div>
					</div>
					<div class="taski">
					<?php
						echo "<h5>".$row->text."</h5><br>";
						
						echo "<h4><b>Tasks</b></h4>";
						echo "<hr>";
						
						foreach($tasks as $task):
							if($task->UID == 0){
								echo "-".$task->name;
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
									echo '<form name="takeTask" class="takeTaskButton" method="post" action="unassignedtasks/takeTask">';
									echo '<input name="UID" type="hidden" value="'.$id.'" />';
									echo '<button type="submit" value="'.$task->id.'" name="TID">Take task</button>';
									echo '<input name="redirect" type="hidden" value="'.$this->uri->uri_string().'" /></form>';
								}
								
								echo '<form name="edittasks" class="editTaskButton" action="editTask" method="post">';
								echo '<input type="submit" name="TID" value="Edit" />';
								echo '<input type="hidden" name="TID" value='.$task->id.'" />';
								echo '</form>';
							}
							echo '<br>';
						 endforeach ?>
					</div>
					<div class="notes">
						<h5 id="note" onclick="editNote()"><?php echo $row->note?></h5>
						<br>
					</div>
					<div class="gumbR">
						<form name="createTask" class="addTaskButton" action="verifyAddTask" method="post">
							<input type="submit" name="task" value="Add a task" />
							<input type="hidden" name="task" value=<?php echo $row->id ?> />
						</form>
					</div>
		<?php endforeach ?>	
		</div><br>
	</div>
    </div>
</form>