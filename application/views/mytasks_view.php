<!--avtor:darko-->
<div id="content">
    <div id="left">
    <p id="title">My tasks</p>
    <!-- V tabelo nalog se shrani trenutni cas-->
    <p>Currently working on: <input type="submit" value="Stop working"></p>
	<ul>
	    <form name="startTask" method="post" action="mytasks/startWork">
	    <? foreach ($tasks as $task) {
		echo '<li>'.$task.' <button type="submit" name="task" value="'.$task.'">Start working</button></li>';
	    } ?>
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