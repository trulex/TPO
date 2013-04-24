<!-- avtor:Lovrenc -->


<div id="content">
	<div id="left">
	<h2>Sprint backlog <?php echo "(".$project.")"; $counter=1;?></h2>
		<?php foreach ($storyTuple as $tuple):
			$story=$tuple[0];
			$tasks=$tuple[1];?>
			<h3> <?php echo $counter.".)".$story->name; $counter++; ?></h3>
			<?php echo '"'.$story->text.'"'?>
			<ul><?php foreach ($tasks as $task){
				if($story->id == $task->StID){
					echo '<li><div><b>'.$task->task_name;
					echo ' ['.$task->time_estimate.'] </b>';
					if($task->UID == 0){
						if ( $rights=="admin" || $role==1 ){
							echo '<form name="chTime" method="post" action="sprintBacklog/changeTime">';
							echo '<input name="timeEstimate" type="text" size="3" value="'.$task->time_estimate.'"/>';
							echo '<input name="TID" type="hidden" value="'.$task->id.'"/>';
							echo '<input name="redirect" type="hidden" value="'.$this->uri->uri_string().'" />';
							echo '<button type="submit" value="'.$task->id.'" name="TID">Change time</button></form></b>';
							echo '<form name="asign" method="post" action="sprintBacklog/asignTask">';
							echo '<input name="redirect" type="hidden" value="'.$this->uri->uri_string().'" />';
							echo '<select name="UID">' ;
							foreach ($projectUsers as $user){
								echo ' <option value="'.$user->user_id.'">'.$this->users->getUserName($user->user_id).'</option>';
							}
							echo '</select>';
							echo '<input name="TID" type="hidden" value="'.$task->id.'"/>';
							echo '<button type="submit" value="'.$task->id.'" name="TID">Assign</button></form></b>';
						}
						else{
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
							echo '<form name=cts method="post" action="sprintBacklog/releaseTask">';
							echo '<button type="submit" value="'.$task->id.'" name="TID">Release task</button>';
							echo '<input name="redirect" type="hidden" value="'.$this->uri->uri_string().'" /></form>';
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
					echo "</div>";
					echo '<div>"'.$task->text.'"</div></li>';
					echo "<br><br>";
			}}?></ul>
			<form name="cts" method="post" action="verifyAddTask">
			<button type="submit" value="<?php echo $story->id ?>" name="task" >Add a task</button></form><hr>
		<?php endforeach ?>
	</div>
	<?php $this->load->view('selProject', array('projects'=>$projects));   ?>
</div>