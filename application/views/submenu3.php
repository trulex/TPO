<div>
	<ul class="menu">
	    <?php
		echo $active == 'unassignedtasks' ? '<li class="active">'.anchor('unassignedtasks','Unassigned tasks') : '<li class="menu">'.anchor('unassignedtasks','Unassigned tasks');
	    echo $active == 'assignedtasks' ? '<li class="active">'.anchor('assignedtasks','Assigned tasks') : '<li class="menu">'.anchor('assignedtasks','Assigned tasks');
	    echo $active == 'finishedtasks' ? '<li class="active">'.anchor('finishedtasks','Finished tasks') : '<li class="menu">'.anchor('finishedtasks','Finished tasks');
		echo $active == 'activetasks' ? '<li class="active">'.anchor('activetasks','Active tasks') : '<li class="menu">'.anchor('activetasks','Active tasks'); ?>
	</ul>
</div>