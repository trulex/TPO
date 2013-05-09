<!-- submenu3 -->
<!-- avtor: BOSTJAN -->
<div>
	<ul class="menu">
	    <?php
		echo $activesubmenu3 == 'alltasks' ? '<li class="active">'.anchor('alltasks','All tasks') : '<li class="menu">'.anchor('alltasks','All tasks');
		echo $activesubmenu3 == 'unassignedtasks' ? '<li class="active">'.anchor('unassignedtasks','Unassigned tasks') : '<li class="menu">'.anchor('unassignedtasks','Unassigned tasks');
	    echo $activesubmenu3 == 'assignedtasks' ? '<li class="active">'.anchor('assignedtasks','Assigned tasks') : '<li class="menu">'.anchor('assignedtasks','Assigned tasks');
	    echo $activesubmenu3 == 'finishedtasks' ? '<li class="active">'.anchor('finishedtasks','Finished tasks') : '<li class="menu">'.anchor('finishedtasks','Finished tasks');
		echo $activesubmenu3 == 'activetasks' ? '<li class="active">'.anchor('activetasks','Active tasks') : '<li class="menu">'.anchor('activetasks','Active tasks'); ?>
	</ul>
</div>