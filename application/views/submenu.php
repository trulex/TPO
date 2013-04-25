<div id="submenu1">
	<ul class="menu">
	    <?php
		echo $active == 'allStories' ? '<li class="active">'.anchor('allStories','All stories') : '<li class="menu">'.anchor('allStories','All stories');
	    echo $active == 'unfinishedstories' ? '<li class="active">'.anchor('unfinishedstories','Unfinished Stories') : '<li class="menu">'.anchor('unfinishedstories','Unfinished Stories');
	    echo $active == 'finishedStories' ? '<li class="active">'.anchor('finishedStories','Finished stories') : '<li class="menu">'.anchor('finishedStories','Finished stories'); 
	    echo $active == 'freleases' ? '<li class="active">'.anchor('freleases','Future releases') : '<li class="menu">'.anchor('freleases','Future releases');
		echo $active == 'addstory' ? '<li class="active">'.anchor('addstory','Add new user stories') : '<li class="menu">'.anchor('addstory','Add new user stories'); ?>
	</ul>
</div>