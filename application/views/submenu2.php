<div>
	<ul class="menu">
	    <?php
		echo $activesubmenu2 == 'unassignedstories' ? '<li class="active">'.anchor('unassignedstories','Unassigned stories') : '<li class="menu">'.anchor('unassignedstories','Unassigned stories');
	    echo $activesubmenu2 == 'assignedstories' ? '<li class="active">'.anchor('assignedstories','Assigned stories') : '<li class="menu">'.anchor('assignedstories','Assigned stories');
		?>
	</ul>
</div>