<div>
	<ul class="menu">
	    <?php
		echo $activesubmenu1 == 'allStories' ? '<li class="active">'.anchor('allStories','All stories') : '<li class="menu">'.anchor('allStories','All stories');
	    echo $activesubmenu1 == 'unfinishedstories' ? '<li class="active">'.anchor('unfinishedstories','Unfinished Stories') : '<li class="menu">'.anchor('unfinishedstories','Unfinished Stories');
	    echo $activesubmenu1 == 'finishedStories' ? '<li class="active">'.anchor('finishedStories','Finished stories') : '<li class="menu">'.anchor('finishedStories','Finished stories');
		if($rights == 1 || $ScrumMaster == $UID){
			echo $activesubmenu1 == 'addstory' ? '<li class="active">'.anchor('addstory','Add new user stories') : '<li class="menu">'.anchor('addstory','Add new user stories');
		}
		?>
	</ul>
</div>