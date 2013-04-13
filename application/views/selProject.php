<!-- requires projects -->

<div id="projects">
	<p id="title">My projects</p>
	    <form name="selectp" method="post" action="selectProject/select">
	    <?php
		foreach ($projects as $project) {
			echo '<input name="PID" type="hidden" value="'.$project.'" />';
		    echo '<button type="submit" value="'.$this->projects->getProjectName($project).'" name="project">'.$this->projects->getProjectName($project).'</button>';
		    echo '<br />';
		}
	    ?>
	    <input name="redirect" type="hidden" value="<?= $this->uri->uri_string() ?>" />
	    </form>
    </div>
</div>