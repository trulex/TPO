<div id="content">
    <div id="left">
	<p id="title">Product backlog</p>
	<ul>
	    <li><?php echo anchor('unfinishedstories','Unfinished stories'); ?></li>
	    <li><?php echo anchor('fstories','Finished stories'); ?></li>
	    <li><?php echo anchor('freleases','Future releases'); ?></li>
	    <li><?php echo anchor('addstory','Add new user stories'); ?></li>
	    <li><?php echo anchor('addsprint','Add new sprints'); ?></li>
	    <li><?php echo anchor('viewTasks','View all Tasks'); ?></li>
	    <li><?php echo anchor('sprintBacklog','Sprint backlog-za enkrat vsi storyji trenutnega projekta'); ?></li>
	</ul>
    </div>
    <div id="projects">
	<p id="title">My projects</p>
	    <form name="selectp" method="post" action="selectProject/select">
	    <?php
		foreach ($projects as $project) {
		    echo '<button type="submit" value="'.$this->project->getProjectName($project).'" name="project">'.$this->project->getProjectName($project).'</button>';
		    echo '<br />';
		}
	    ?>
	    <input name="redirect" type="hidden" value="<?= $this->uri->uri_string() ?>" />
	    </form>
    </div>
</div>