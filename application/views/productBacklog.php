<!--avtor:Lovrenc-->
<div id="menu">
	<ul class="menu">
	    <?php echo $active == 'productBacklog' ? '<li class="active">'.anchor('productBacklog','All stories') : '<li class="menu">'.anchor('productBacklog','All stories'); ?>
	    <?php if (strcmp($rights,"admin")==0) {
		echo $active == 'productBacklog' ? '<li class="active">'.anchor('unasignedStories','Unasigned stories') : '<li class="menu">'.anchor('unasignedStories','Unasigned Stories'); } ?>
	</ul>
</div>
<div id="content">
	<h2>Product Backlog</h2>
	<div id="left">
		<?php $counter=1;
		foreach ($storyTuple as $Tuple):
			$story=$Tuple[0];
			$tasks=$Tuple[1];?>
			<h3> <?php echo $counter.".)".$story->name; $counter++; ?></h3>
			<?php echo '"'.$story->text.'"'?>
			<ul><?php foreach ($tasks as $task):
			if($story->id==$task->StID){?>
				<li><b><?php echo $task->task_name ?></b>
				<div><?php echo '"'.$task->text.'"' ?></div></li>
			<?php } endforeach?></ul>
		<?php endforeach ?>
	</div>
	<?php $this->load->view('selProject', array('projects'=>$projects));   ?>
</div>
   