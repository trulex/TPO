<div id="submenu1">
	<ul class="menu">
	    <?php  
	    echo $active == 'unfinishedstories' ? '<li class="active">'.anchor('unfinishedstories','Unfinished Stories') : '<li class="menu">'.anchor('unfinishedstories','Unfinished Stories');
	    echo $active == 'fstories' ? '<li class="active">'.anchor('fstories','Finished stories') : '<li class="menu">'.anchor('fstories','Finished stories'); 
	    echo $active == 'freleases' ? '<li class="active">'.anchor('freleases','Future releases') : '<li class="menu">'.anchor('freleases','Future releases');
		echo $active == 'addstory' ? '<li class="active">'.anchor('addstory','Add new user stories') : '<li class="menu">'.anchor('addstory','Add new user stories'); ?>
	</ul>
</div>