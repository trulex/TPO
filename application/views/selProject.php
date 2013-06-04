<!-- views/selProjects.php -->
<!-- requires projects -->

<div id="projects">
	<p id="title">My projects</p>
	    <?php
		foreach ($projects as $project) {
		    if(!isset($project->role)) {
			$prole='Administrator';
		    } else {
			switch($project->role) {
			case 0: $prole='Team member';
			break;
			case 1: $prole='Scrum master';
			break;
			default: $prole='Product owner';
			break;
			}
		    }
		    echo '<form name="selectp" method="post" action="selectProject/select">';
		    echo '<input name="PID" type="hidden" value="'.$project->id.'" />';
		    echo '<div class="selectProject"><button type="submit" value="'.$project->name.'" name="project">'.$project->name.'</button>';
		    echo '<br />';
		    echo 'as '.$prole.'</div>';
		    echo '<input name="redirect" type="hidden" value="'.$this->uri->uri_string().'" />';
		    echo '</form>';
		    
		}
	    ?>
	    <?php 
	    if($this->session->userdata('PID')==0) echo '<p style="color:red">Please select<br> a project</p>';
			if( $rights || $role%2){ 
				echo '<form action="addsprint" method="post">';
				echo '<input style="margin-top:20;margin-bottom:-40;" type="submit" name="submitbutton" value="Manage sprints" />';
				echo '</form>';
			}
		?>
</div>
</div>
