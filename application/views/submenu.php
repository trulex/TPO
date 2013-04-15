<div id="submenu1">
	<ul class="menu">
	    <?php 
	    echo $active == 'productBacklog' ? '<li class="active">'.anchor('productBacklog','All stories') : '<li class="menu">'.anchor('productBacklog','All stories'); 
	    echo $active == 'unfinishedstories' ? '<li class="active">'.anchor('unfinishedstories','Unfinished Stories') : '<li class="menu">'.anchor('unfinishedstories','Unfinished Stories');
	    echo $active == 'fstories' ? '<li class="active">'.anchor('fstories','Finished stories') : '<li class="menu">'.anchor('fstories','Finished stories'); 
	    echo $active == 'freleases' ? '<li class="active">'.anchor('freleases','Future releases') : '<li class="menu">'.anchor('freleases','Future releases'); ?>
	</ul>
</div>