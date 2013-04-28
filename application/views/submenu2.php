<div>
	<ul class="menu">
	    <?php
		echo $active == 'unassignedstories' ? '<li class="active">'.anchor('unassignedstories','Unassigned stories') : '<li class="menu">'.anchor('unassignedstories','Unassigned stories');
	    echo $active == 'assignedstories' ? '<li class="active">'.anchor('assignedstories','Assigned stories') : '<li class="menu">'.anchor('assignedstories','Assigned stories');
		?>
	</ul>
</div>