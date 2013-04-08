<!--avtor:darko-->
<?php $this->load->helper('form'); ?>
<div id="content">
    <div id="left">
	<p id="title">Administration options</p>
	<ul>
	    <li><?php echo anchor('adduser','Add new users'); ?></li>
	    <li><?php echo anchor('addproject','Add new projects'); ?></li>
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
	    </form>
    </div>
</div><?
