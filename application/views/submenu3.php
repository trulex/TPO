<!-- views/submenu3.php -->
<!-- avtor: BOSTJAN -->
<div>
	<ul class="menu">
	    <?php
		echo $activesubmenu3 == 'alltasks' ? '<li class="active">'.anchor('allTasks','All tasks') : '<li class="menu">'.anchor('allTasks','All tasks');
		echo $activesubmenu3 == 'unassignedtasks' ? '<li class="active">'.anchor('unassignedTasks','Unassigned tasks') : '<li class="menu">'.anchor('unassignedTasks','Unassigned tasks');
	    echo $activesubmenu3 == 'assignedtasks' ? '<li class="active">'.anchor('assignedTasks','Assigned tasks') : '<li class="menu">'.anchor('assignedTasks','Assigned tasks');
	    echo $activesubmenu3 == 'finishedtasks' ? '<li class="active">'.anchor('finishedTasks','Finished tasks') : '<li class="menu">'.anchor('finishedTasks','Finished tasks');
		echo $activesubmenu3 == 'activetasks' ? '<li class="active">'.anchor('activeTasks','Active tasks') : '<li class="menu">'.anchor('activeTasks','Active tasks'); ?>
	</ul>
</div>