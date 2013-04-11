<!--avtor:Lovrenc-->


<div id="content">
	<h2>Sprint backlog <?php echo "(".$project.")"?></h2>
	<div id="left">
		<?php foreach ($stories as $story): ?>
			<h3> <?php echo $story->id.".)".$story->name ?></h3>
			<?php echo '"'.$story->text.'"'?>
			<ul><?php foreach ($tasks as $task):
			if($story->id==$task->StID){?>
				<li><b><?php echo $task->task_name ?></b>
				<div><?php echo '"'.$task->text.'"' ?></div></li>
			<?php } endforeach?></ul>
			<button type="submit" name="task" action="addTask" value="<?php echo $story->id?>">add task</button>
			<div><?php echo anchor('addTask','add Tasks', "$story->id"); ?></div>
		<?php endforeach ?>
	</div>
</div>