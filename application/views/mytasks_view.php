<!--avtor:darko-->
<div id="content">
    <div id="left">
    <p id="title">My tasks</p>
    <?php if(strcmp($this->session->userdata('taskActive'),'')!=0) {
	echo '<p style="color:red">'.$this->session->userdata('taskActive').'</p>';
    }?>
    <?php if(strcmp($activeTask,'')!=0) {
     echo '<form name="stopWork" method="post" action="mytasks/stopWork">';
     echo '<p>Currently working on: <span style="text-decoration:underline">'.$activeTask.'</span> <input type="submit" name="stopWork" value="Stop working"></p></form>'; }?>
	<ul>
	    <form name="startTask" method="post" action="mytasks/startWork">
	    <?php  
		$previousStory='';
		foreach ($tasks as $task=>$accepted) {
		$storyData=$this->tasks->getStory($task,$id); //get story name,text and tests
		$completed=$this->tasks->isCompleted($task,$id); //check if task is completed
		$time=$this->tasks->getTime($task,$id); //get time spent on task
		if($accepted==1 && $completed==1) {
		    if(strcmp($previousStory,$storyData['name'])!=0) {
			echo '<br /><div style="font-weight:bold">'.$storyData['name'].'</div>';
			echo '<div style="color:grey;font-size:12">'.$storyData['text'].'</div>';
			echo '<div style="color:00CC66;font-size:12">'.$storyData['tests'].'</div>';
		    }
		    echo '<li><span style="font-size:small;color:blue">(Completed) </span>'.$task.' <button class="task" type="submit" name="task" value="'.$task.'">Start working</button></li>';
		
		} else if ($accepted==1){
		    if(strcmp($previousStory,$storyData['name'])!=0) {
			echo '<br /><div style="font-weight:bold">'.$storyData['name'].'</div>';
			echo '<div style="color:grey;font-size:12">'.$storyData['text'].'</div>';
			echo '<div style="color:00CC66;font-size:12">'.$storyData['tests'].'</div>';
		    }
		    echo '<li>'.$task.' <button class="task" type="submit" name="task" value="'.$task.'">Start working</button></li>';
		
		} else if ($accepted==0) {
		    if(strcmp($previousStory,$storyData['name'])!=0) {
			echo '<br /><div style="font-weight:bold">'.$storyData['name'].'</div>';
			echo '<div style="color:grey;font-size:12">'.$storyData['text'].'</div>';
			echo '<div style="color:00CC66;font-size:12">'.$storyData['tests'].'</div>';
		    }
		    echo '<li>'.$task.' <span style="font-size:small;color:orange">(Not yet accepted)</span></li>';
		}
		$previousStory=$storyData['name'];
	    } ?>
	    </form>
	</ul>
    </div>
    <div id="projects">
	<p id="title">My projects</p>
	    <form name="selectp" method="post" action="selectProject/select">
	    <?php
		foreach ($projects as $project) {
		    echo '<button type="submit" value="'.$this->projects->getProjectName($project).'" name="project">'.$this->projects->getProjectName($project).'</button>';
		    echo '<br />';
		}
	    ?>
	    <input name="redirect" type="hidden" value="<?= $this->uri->uri_string() ?>" />
	    </form>
    </div>
</div>