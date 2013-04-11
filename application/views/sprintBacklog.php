<!--avtor:Lovrenc-->


<div id="content">
	<h2>Sprint backlog <?php echo "(".$project.")"; $counter=1;?></h2>
	<div id="left">
		<?php foreach ($stories as $story): ?>
			<h3> <?php echo $counter.".)".$story->name; $counter++; ?></h3>
			<?php echo '"'.$story->text.'"'?>
			<ul><?php foreach ($tasks as $task){
				if($story->id == $task->StID){
					echo '<li><div><b>'.$task->task_name.'</b>';
					if($task->UID == 0){
						echo '<button type="submit" value="'.$task->id.'" name="'.$task->id.'">Accept task</button>';
					}
					else{ 
						if($id == $task->UID){
							echo "(My task)";
							echo '<button type="submit" value="0" name="'.$task->id.'">Release task</button>';
							echo '<button type="submit" value="0" name="'.$task->id.'">Release task</button>';
						}
						else{
							echo "(Handled by user: ".$this->get_users->getUserName($task->UID).")";
						}
					}
					echo "</div>";
					echo '<div>"'.$task->text.'"</div></li>';
				
			}}?></ul>
			<button type="submit" action="sprintBacklog/addTask/<?php echo $story->id?>" name="task" action="addTask" value="<?php echo $story->id?>">add task</button>
		<?php endforeach ?>
	</div>