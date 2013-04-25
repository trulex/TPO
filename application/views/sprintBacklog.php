<!-- avtor:Lovrenc -->


<div id="content">
	<div id="left">
	<h2>Sprint backlog <?php echo "(".$project.")"; $counter=1;?></h2>
		<?php foreach ($storyTuple as $tuple):
			$story=$tuple[0];
			$tasks=$tuple[1];
			echo '<div class="zgodba"><h3>'.$counter.".)".$story->name.'</h3>'; 
			$counter++;
			echo '"'.$story->text.'"</div>';
			echo '<div class="taski">';
			 foreach ($tasks as $task){
				if($story->id == $task->StID){
					echo '<b>'.$task->name;
					echo ' ['.$task->time_estimate.'] </b>';
// 					Edit task form
					if($task->UID == 0){
						if ( $rights || $role==1 ){			
							echo '<form name="asign" method="post" action="sprintBacklog/asignTask">';
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
// 							take task
							echo '<form name=cts method="post" action="sprintBacklog/takeTask">';
							echo '<input name="UID" type="hidden" value="'.$id.'" />';
							echo '<button type="submit" value="'.$task->id.'" name="TID">Take task</button>';
							echo '<input name="redirect" type="hidden" value="'.$this->uri->uri_string().'" /></form>';
						}
					}
					else{ 
						if($id == $task->UID){ 
// 							release task
							echo "(My task)";
						}
						else{
							if ($task->accepted==1){
								echo "(Handled by user: ".$this->users->getUserName($task->UID).")";
							}
							else{
								echo "(Asigned to user: ".$this->users->getUserName($task->UID).")";
							}
						}
					}
					echo '<form name="editTask" method="post" action="editTask">';
					echo '<input name="TID" type="hidden" value="'.$task->id.'"/>';
					echo '<button type="submit">Edit</button></form></b>';
					echo $task->text;
					echo "<br><br>";
				}
			}
			
			echo '</div><form name=cts method="post" action="verifyAddTask">';
			echo '<button type="submit" value="'.$story->id.'" name="task" >Add a task</button></form><hr>';
		endforeach ?>
	</div>
		<?php $this->load->view('selProject', array('projects'=>$projects));   ?>

</div>
