<!-- requires projects -->

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
	    <?php if($this->session->userdata('PID')==0) echo '<p style="color:red">Please select<br> a project</p>';?>
    </div>
</div>