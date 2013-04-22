<!--avtor:darko-->
<div id="content">
    <div id="left" style="width:500px">
    <p id="title">My tasks</p>
    <?php if(strcmp($this->session->userdata('taskActive'),'')!=0) {
	echo '<p style="color:red">'.$this->session->userdata('taskActive').'</p>';
    }?>
    <?php if($activeTask!=0) {
     echo '<form name="stopWork" method="post" action="mytasks/stopWork">';
     echo '<p>Currently working on: <span style="text-decoration:underline">'.$this->tasks->getTaskName($activeTask).'</span> <input type="submit" name="stopWork" value="Stop working" style="float:right"></p>
     <input name="taskID" type="hidden" value="'.$activeTask.'" /></form>'; }?>
	<ul>
	    <?php  
		$previousStory='';
		foreach ($tasks as $tas) {
			$task=$tas->task_name;
			$accepted=$tas->accepted;
			$storyData=$this->tasks->getStory($task,$id); //get story name,text and tests
			$completed=$this->tasks->isCompleted($task,$id); //check if task is completed
			$time=$this->tasks->getTime($task,$id); //get time spent on task
			$taskId=$tas->id;
			if($accepted==1 && $completed==1) {
				if(strcmp($previousStory,$storyData['name'])!=0) {
				echo '<hr><div style="font-weight:bold">'.$storyData['name'].'</div>';
				echo '<div style="color:grey;font-size:12">'.$storyData['text'].'</div>';
				echo '<div style="color:00CC66;font-size:12">'.$storyData['tests'].'</div>';
				}
				echo '<form name="startTask" method="post" action="mytasks/startWork">';
				echo '<li style="list-style-type:square"><span style="font-size:small;color:blue">(Completed) </span>'.$task.'  <span style="font-size:12px">['.$time.' hours spent]</span><button class="task" type="submit" name="task" value="'.$task.'">Start working</button></li>
				<input name="taskID" type="hidden" value="'.$taskId.'" />
				</form>';
				
				echo '<form name="releaseTask" method="post" action="sprintBacklog/releaseTask">';
				echo '<button type="submit" value="'.$tas->id.'" name="TID">Release task</button>';
				echo '<input name="redirect" type="hidden" value="'.$this->uri->uri_string().'" /></form>';
			
			} else if ($accepted==1){
				if(strcmp($previousStory,$storyData['name'])!=0) {
					echo '<hr><div style="font-weight:bold">'.$storyData['name'].'</div>';
					echo '<div style="color:grey;font-size:12">'.$storyData['text'].'</div>';
					echo '<div style="color:00CC66;font-size:12">'.$storyData['tests'].'</div>';
				}
				echo '<form name="startTask" method="post" action="mytasks/startWork">';
				echo '<li style="list-style-type:square">'.$task.' <span style="font-size:12px">['.$time.' hours spent]</span><button class="task" type="submit" name="task" value="'.$task.'">Start working</button></li>
				<input name="taskID" type="hidden" value="'.$taskId.'" />
				</form>';
				
				echo '<form name="releaseTask" method="post" action="sprintBacklog/releaseTask">';
				echo '<button type="submit" value="'.$tas->id.'" name="TID">Release task</button>';
				echo '<input name="redirect" type="hidden" value="'.$this->uri->uri_string().'" /></form>';
				
			} else if ($accepted==0) {
				if(strcmp($previousStory,$storyData['name'])!=0) {
					echo '<hr><div style="font-weight:bold">'.$storyData['name'].'</div>';
					echo '<div style="color:grey;font-size:12">'.$storyData['text'].'</div>';
					echo '<div style="color:00CC66;font-size:12">'.$storyData['tests'].'</div>';
				}
				echo '<li style="list-style-type:square">'.$task.'</li>';
				
				echo '<form name="acceptTask" method="post" action="sprintBacklog/acceptTask">';
				echo '<input name="UID" type="hidden" value="'.$id.'" />';
				echo '<button type="submit" value="'.$tas->id.'" name="TID">Accept task</button>';
				echo '<input name="redirect" type="hidden" value="'.$this->uri->uri_string().'" /></form>';

			}
			$previousStory=$storyData['name'];
			echo "</form>";
		}
	    ?>
	</ul>
    </div>
   	<?php $this->load->view('selProject', array('projects'=>$projects));   ?>
</div>

