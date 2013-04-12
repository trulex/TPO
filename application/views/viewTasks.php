<!--avtor:Lovrenc-->

<div id="content">
	<h2>All task</h2>
	<div id="left">
		<?php $counter=1;
		foreach ($stories as $story): ?>
			<h3> <?php echo $counter.".)".$story->name; $counter++; ?></h3>
			<?php echo '"'.$story->text.'"'?>
			<ul><?php foreach ($tasks as $task):
			if($story->id==$task->StID){?>
				<li><b><?php echo $task->task_name ?></b>
				<div><?php echo '"'.$task->text.'"' ?></div></li>
			<?php } endforeach?></ul>
		<?php endforeach ?>
	</div>

   