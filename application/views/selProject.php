<!-- requires projects -->

<div id="projects">
	<p id="title">My projects</p>
	    <?php
		foreach ($projects as $project) {
		    if(!isset($project->role)) {
			$role='Administrator';
		    } else {
			switch($project->role) {
			case 0: $role='Team member';
			break;
			case 1: $role='Scrum master';
			break;
			default: $role='Product owner';
			break;
			}
		    }
		    echo '<form name="selectp" method="post" action="selectProject/select">';
		    echo '<input name="PID" type="hidden" value="'.$project->id.'" />';
		    echo '<div class="selectProject"><button type="submit" value="'.$project->name.'" name="project">'.$project->name.'</button>';
		    echo '<br />';
		    echo 'as '.$role.'</div>';
		    echo '<input name="redirect" type="hidden" value="'.$this->uri->uri_string().'" />';
		    echo '</form>';
		}
	    ?>
	    <?php if($this->session->userdata('PID')==0) echo '<p style="color:red">Please select<br> a project</p>';?>
</div>
</div>