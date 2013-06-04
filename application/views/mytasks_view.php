<!-- views/mytasks.php -->
<!--avtor:darko-->
<!-- http://papermashup.com/jquery-show-hide-plugin/ -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js" type="text/javascript"></script>
<script type="text/javascript">
(function ($) {
    $.fn.showHide = function (options) {
    //default vars for the plugin
        var defaults = {
            speed: 10000,
            easing: '',
            changeText: 0,
            showText: 'Show',
            hideText: 'Hide'
        };
        var options = $.extend(defaults, options);
        $(this).click(function () {
// optionally add the class .toggleDiv to each div you want to automatically close
                      $('.toggleDiv').slideUp(options.speed, options.easing);
             // this var stores which button you've clicked
             var toggleClick = $(this);
             // this reads the rel attribute of the button to determine which div id to toggle
             var toggleDiv = $(this).attr('rel');
             // here we toggle show/hide the correct div at the right speed and using which easing effect
             $(toggleDiv).slideToggle(options.speed, options.easing, function() {
             // this only fires once the animation is completed
             if(options.changeText==1){
             $(toggleDiv).is(":visible") ? toggleClick.text(options.hideText) : toggleClick.text(options.showText);
             }
              });
          return false;
        });
    };
})(jQuery);
$(document).ready(function(){
   $('.show_hide').showHide({
        speed: 100,  // speed you want the toggle to happen
        easing: '',  // the animation effect you want. Remove this line if you dont want an effect and if you haven't included jQuery UI
        changeText: 0, // if you dont want the button text to change, set this to 0
        showText: 'View',// the button text to show when a div is closed
        hideText: 'Close' // the button text to show when a div is open
    });
});

</script>
<div id="content">
    <div id="left" style="width:600px">
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
	
		echo '<div align="right"><a href="#" class="show_hide" rel="#slidingDiv'.$tas->id.'" style="font-size:13">Work history</a></div><br />';
		echo '<div title="Work history" id="slidingDiv'.$tas->id.'" style="display:none;border:1px solid lightgrey">';
		echo '<form name="editWork" method="post" action="mytasks/editWork">';
		if (!empty($workHistory)) {
		foreach ($workHistory as $day) {
		    if( $day->TID == $tas->id ) {
			echo "<small>".$day->date."</small>&nbsp&nbsp&nbsp";
			echo 'Time spent: <input type="text" size="5" name="history[]" value="'.round($day->time_sum/3600,2).'"> hours, ';
			echo 'time remaining: <input type="text" size="5" name="history[]" value="'.round($day->remaining/3600,2).'"> hours';
			echo '<input name="history[]" type="hidden" value="'.$day->id.'" />';
			echo '<br />';
		    }
		}
		echo '<button type="submit" name="TID">Save changes</button>';
		echo '</form>';
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
		
		echo '<div align="right"><a href="#" class="show_hide" rel="#slidingDiv'.$tas->id.'" style="font-size:13">Work history</a></div><br />';
		echo '<div title="Work history" id="slidingDiv'.$tas->id.'" style="display:none;border:1px solid lightgrey">';
		echo '<form name="editWork" method="post" action="mytasks/editWork">';
		if ($workHistory) {
		foreach ($workHistory as $day) {
		    if( $day->TID == $tas->id ) {
		    echo "<small>".$day->date."</small>&nbsp&nbsp&nbsp";
		    echo 'Time spent: <input type="text" size="5" name="history[]" value="'.round($day->time_sum/3600,2).'"> hours, ';
		    echo 'time remaining: <input type="text" size="5" name="history[]" value="'.round($day->remaining/3600,2).'"> hours';
		    echo '<input name="history[]" type="hidden" value="'.$day->id.'" />';
		    echo '<br />';
		    }
		}
		echo '<button type="submit" name="TID">Save changes</button>';
		echo '</form>';
		}
		if(!$workHistory) {
		    echo 'There has not been any work on this task';
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
		echo '<button type="submit" value="'.$tas->id.'" name="TID">Mark task as completed</button>';
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
    <div id="history" style="display:inline-block">
    
    </div>
   	<?php $this->load->view('selProject', array('projects'=>$projects));   ?>
</div>