<!--avtor:Lovrenc-->


<div id="content">
	<h2>Sprint backlog <?php echo "(".$project.")"; $counter=1;?></h2>
	<div id="left">
	
		<?php foreach ($stories as $story): ?>
			<h3> <?php echo $counter.".)".$story->name; $counter++; ?></h3>
			<?php echo '"'.$story->text.'"'?>
			<ul><?php foreach ($tasks as $task){
				if($story->id == $task->StID){
					echo '<li><div><b>'.$task->task_name;
					if(!$task->accepted ){
						echo '<form name="chTime" method="post" action="sprintBacklog/changeTime">';
						echo '<input name="timeEstimate" type="text" size="3" value="'.$task->time_estimate.'"/>';
						echo '<input name="TID" type="hidden" value="'.$task->id.'"/>';
						echo '<button type="submit" value="'.$task->id.'" name="TID">Change time</button></form></b>';
					}
					else{
						echo ' ['.$task->time_estimate.'] </b>';
					}
					if($task->UID == 0){
						echo '<form name=cts method="post" action="sprintBacklog/takeTask">';
						echo '<input name="UID" type="hidden" value="'.$id.'" />';
						echo '<button type="submit" value="'.$task->id.'" name="TID">Accept task</button></form>';
					}
					else{ 
						if($id == $task->UID){
							echo "(My task)";
							echo '<form name=cts method="post" action="sprintBacklog/releaseTask">';
							echo '<button type="submit" value="'.$task->id.'" name="TID">Release task</button></form>';
						}
						else{
							echo "(Handled by user: ".$this->users->getUserName($task->UID).")";
						}
					}
					echo "</div>";
					echo '<div>"'.$task->text.'"</div></li>';
					echo "<br><br>";
					echo '</form>';
			}}?></ul>
			<form name=cts method="post" action="verifyAddTask">
			<button type="submit" value="<?php echo $story->id ?>" name="task" >add task</button></form><hr>
		<?php endforeach ?>
	</div>