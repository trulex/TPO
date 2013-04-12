<div id="content">
	<div id=left>
    <h1>Home</h1>
    <h2>Welcome <?php echo $username; ?>!</h2>
     Get your shit together it's time to work, pick a project and SCRUMMMMMMmmmm!!!!
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
