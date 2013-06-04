<!-- views/submenu 2.php -->
<!-- avtor: BOSTJAN -->
<div>
	<ul class="menu">
	    <?php
		echo $activesubmenu2 == 'unassignedStories' ? '<li class="active">'.anchor('unassignedStories','Unassigned stories') : '<li class="menu">'.anchor('unassignedStories','Unassigned stories');
	    echo $activesubmenu2 == 'assignedStories' ? '<li class="active">'.anchor('assignedStories','Assigned stories') : '<li class="menu">'.anchor('assignedStories','Assigned stories');
		?>
	</ul>
</div>