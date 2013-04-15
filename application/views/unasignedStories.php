<!--avtor:Lovrenc-->

<div id="menu">
	<ul class="menu">
	    <?php echo $active == 'productBacklog' ? '<li class="active">'.anchor('productBacklog','All stories') : '<li class="menu">'.anchor('productBacklog','All stories'); ?>
	    <?php if (strcmp($rights,"admin")==0) {
			echo $active == 'productBacklog' ? '<li class="active">'.anchor('unasignedStories','Unasigned stories') : '<li class="menu">'.anchor('unasignedStories','Unasigned Stories'); } ?>
	</ul>
</div>
<div id="content">
	<h2>Unasigned stories</h2>
	<div id="left">
		<?php $counter=1;
		foreach ($storyTuple as $Tuple):
			$story=$Tuple[0];
			$tasks=$Tuple[1];
			echo "<h3>".$counter.".)".$story->name."[".$story->difficulty."]"; 
			$counter++;
			echo "</h3>";
			echo '<form name="chDifficulty" method="post" action="unasignedStories/changeDifficulty">';
			echo '<input name="difficulty" type="text" size="3" value="'.$story->difficulty.'"/>';
// 			echo '<input name="StID" type="hidden" value="'.$story->id.'"/>';
			echo '<input name="redirect" type="hidden" value="'.$this->uri->uri_string().'" />';
			echo '<button type="submit" value="'.$story->id.'" name="StID">Change difficulty</button></form></b>';
			echo "All tasks/done: ".$tasks[0]."/".$tasks[1];
		endforeach ?>
	</div>
	<?php $this->load->view('selProject', array('projects'=>$projects));   ?>
</div>
   