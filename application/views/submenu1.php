<!-- submenu 1 -->
<!-- avtor: BOSTJAN -->
<div>
	<ul class="menu">
	    <?php
		echo $activesubmenu1 == 'allStories' ? '<li class="active">'.anchor('allStories','All stories') : '<li class="menu">'.anchor('allStories','All stories');
	    echo $activesubmenu1 == 'unfinishedStories' ? '<li class="active">'.anchor('unassignedStories','Unfinished Stories') : '<li class="menu">'.anchor('unassignedStories','Unfinished Stories');
	    echo $activesubmenu1 == 'finishedStories' ? '<li class="active">'.anchor('finishedStories','Finished stories') : '<li class="menu">'.anchor('finishedStories','Finished stories');
		if($rights  || $role){
			echo $activesubmenu1 == 'addstory' ? '<li class="active">'.anchor('addstory','Add new user stories') : '<li class="menu">'.anchor('addstory','Add new user stories');
		}
		?>
	</ul>
</div>