<!--avtor:darko-->
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="<?php echo base_url(); ?>scripts/jquery-ui.js"></script>
<!--<link rel="stylesheet" href="/resources/demos/style.css" />-->
<script>
$(function() {
    $( ".dialog" ).dialog({
	autoOpen: false,
	show: {
	effect: "fade",
	duration: 100
	},
	hide: {
	effect: "fade",
	duration: 100
	}
    });
    $( ".opener" ).click(function() {
	var toggleDiv = $(this).attr('id');
	var name="#".concat(toggleDiv);
	$( name ).dialog({ autoOpen: false });
	$( name ).dialog({ buttons: [ { text: "Save changes", 
	    click: function() { 
		getInput(toggleDiv);
		$( this ).dialog( "close" ); 
		
		} } ] 
	    });
// 	$( name ).dialog({ buttons: [ { text: "Save changes", click: function() { $( this ).dialog( "close" ); } } ] });
	$(name).dialog( "open" );
    });

});

function getInput(name) {
//     var nam="'".concat(name);
//     var nam = nam.concat("'");
//     var values = $(nam).serialize();
    var values=document.getElementById(name).innerHTML;
    var inputs=$("sum").val();
    console.log(inputs);
    console.log(values);
}
</script>

<div id="content">
    <div id="left" style="width:500px">
    <h2>My tasks</h2>
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
    if($tasks){
	foreach ($tasks as $tas) {
	    $task=$tas->name;
	    $accepted=$tas->accepted;
	    $storyData=$this->tasks->getStory($task,$id); //get story name,text and tests
	    $completed=$this->tasks->isCompleted($task,$id); //check if task is completed
	    $time=$this->tasks->getTime($task,$id); //get time spent on task
	    $taskId=$tas->id;
	    if($accepted && $completed) {
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
		echo '<button class="left" type="submit" value="'.$tas->id.'" name="TID">Release task</button>';
		echo '<input name="redirect" type="hidden" value="'.$this->uri->uri_string().'" /></form>';
		
		echo '<button class="opener" type="submit" value="'.$tas->id.'" id="dialog'.$tas->id.'">Work history</button>';
		echo '<div class="dialog" title="Work history" id="dialog'.$tas->id.'">';
		foreach ($workHistory as $day) {
		    if( $day->TID == $tas->id ) {
			echo "<small>".$day->date."</small>&nbsp&nbsp&nbsp";
			echo 'Work spent: <input type="text" size="5" name="timeSum" value="'.round($day->time_sum/3600,2).'"> hours, ';
			echo 'time remaining: <input type="text" size="5" name="timeRemaining" value="'.round($day->remaining/3600,2).'"> hours';
			echo '<br />';
		    }
		}
		echo '</div>';
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
		echo '<button class="left" type="submit" value="'.$tas->id.'" name="TID">Release task</button>';
		echo '<input name="redirect" type="hidden" value="'.$this->uri->uri_string().'" /></form>';
		
		echo '<button class="opener" type="submit" value="'.$tas->id.'" style="float:left" id="dialog'.$tas->id.'">Work history</button>';
		echo '<div class="dialog" title="Work history" id="dialog'.$tas->id.'" >';
		foreach ($workHistory as $day) {
		    if( $day->TID == $tas->id ) {
			echo "<small>".$day->date."</small>&nbsp&nbsp&nbsp";
			echo 'Work spent: <input type="text" size="5" name="timeSum" value="'.round($day->time_sum/3600,2).'"> hours, ';
			echo 'time remaining: <input type="text" size="5" name="timeRemaining" value="'.round($day->remaining/3600,2).'"> hours';
			echo '<br />';
		    }
		}
		echo '</div>';
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
	    if (!$completed && $accepted){
		echo '<form name="finishTask" method="post" action="sprintBacklog/finishTask">';
		echo '<button class="left" type="submit" value="'.$tas->id.'" name="TID">Mark task as completed</button>';
		echo '<input name="redirect" type="hidden" value="'.$this->uri->uri_string().'" /></form>';
	    }
	    $previousStory=$storyData['name'];
	    echo "</form>";
	    echo '<div style="clear:both"></div>';
	    echo '<hr style="background-color:lightgrey">';
	}
    }
    else{
	echo "You have no tasks to do at the moment.";
    }
    
    ?>
</ul>
    </div>
<!--    <div style="display:inline-block">
    AAAAA
    </div>-->
   	<?php $this->load->view('selProject', array('projects'=>$projects));   ?>
</div>