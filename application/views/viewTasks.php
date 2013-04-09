<!--avtor:Lovrenc-->

<h2>Dodajanje nalog</h2>

<?php foreach ($stories as $story): ?>
	<h2> <?php echo $story->id.".)".$story->name ?></h2>
	<div> <?php echo '"'.$story->text.'"'?>
	<ul><?php foreach ($tasks as $task): 
	if($story->id==$task->StID){?>
		<li><h3><?php echo $task->task_name ?></h3>
		<div><?php echo '"'.$task->text.'"' ?></div></li>
	<?php } endforeach?></div></ul>
<?php endforeach ?>

    