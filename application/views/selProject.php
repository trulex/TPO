<!-- requires: projects -->

<div id="projects">
	<p id="title">My projects</p>
	    
	    <?php
		foreach ($projects as $project) {
			echo '<form name="selectp" method="post" action="selectProject/select">';
			echo '<input name="PID" type="hidden" value="'.$project.'" />';
		    echo '<button type="submit" value="'.$this->projects->getProjectName($project).'" name="project">'.$this->projects->getProjectName($project).'</button>';
		    echo '<br />';
		}
	    ?>
	    
    </div>
</div>