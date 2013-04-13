<!--avtor:darko-->
<div id="content">
    <div id="left" style="width:500px">
    <p id="title">My tasks</p>
    <?php if(strcmp($this->session->userdata('taskActive'),'')!=0) {
	echo '<p style="color:red">'.$this->session->userdata('taskActive').'</p>';
    }?>
    <?php if(strcmp($activeTask,'')!=0) {
     echo '<form name="stopWork" method="post" action="mytasks/stopWork">';
     echo '<p>Currently working on: <span style="text-decoration:underline">'.$activeTask.'</span> <input type="submit" name="stopWork"value="Stop working" style="float:right"></p></form>'; }?>
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
			echo '<hr><div style="font-weight:bold">'.$storyData['name'].'</div>';
			echo '<div style="color:grey;font-size:12">'.$storyData['text'].'</div>';
			echo '<div style="color:00CC66;font-size:12">'.$storyData['tests'].'</div>';
		    }
		    echo '<li style="list-style-type:square"><span style="font-size:small;color:blue">(Completed) </span>'.$task.'  <span style="font-size:12px">['.$time.' hours spent]</span><button class="task" type="submit" name="task" value="'.$task.'">Start working</button></li>';
		
		} else if ($accepted==1){
		    if(strcmp($previousStory,$storyData['name'])!=0) {
			echo '<hr><div style="font-weight:bold">'.$storyData['name'].'</div>';
			echo '<div style="color:grey;font-size:12">'.$storyData['text'].'</div>';
			echo '<div style="color:00CC66;font-size:12">'.$storyData['tests'].'</div>';
		    }
		    echo '<li style="list-style-type:square">'.$task.' <span style="font-size:12px">['.$time.' hours spent]</span><button class="task" type="submit" name="task" value="'.$task.'">Start working</button></li>';
		
		} else if ($accepted==0) {
		    if(strcmp($previousStory,$storyData['name'])!=0) {
			echo '<hr><div style="font-weight:bold">'.$storyData['name'].'</div>';
			echo '<div style="color:grey;font-size:12">'.$storyData['text'].'</div>';
			echo '<div style="color:00CC66;font-size:12">'.$storyData['tests'].'</div>';
		    }
		    echo '<li style="list-style-type:square">'.$task.'</span> <span style="font-size:small;color:orange">(Not yet accepted)</span></li>';
		}
		$previousStory=$storyData['name'];
	    } ?>
	    </form>
	</ul>
    </div>
   <?php $this->load->view('selProject', array('projects'=>$projects));   ?>
</div>