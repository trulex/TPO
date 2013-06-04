<!-- views/viewtasks.php -->
<!--avtor:Lovrenc-->

<h2>Dodajanje nalog</h2>

<?php foreach ($stories as $story): ?>
	<h2> <?php echo $story->id.".)".$story->name ?></h2>
	<div> <?php echo '"'.$story->text.'"'?>
	<ul><?php foreach ($tasks as $task):
	$data['StID']=$story->id;
	if($story->id==$task->StID){?>
		<li><h3><?php echo $task->task_name ?></h3>
		<div><?php echo '"'.$task->text.'"' ?></div></li>
	<?php } endforeach?></div></ul>
	<div><?php echo anchor('addTask','add Tasks', 'StID'=$story->id); ?></div>
	<hr>
<?php endforeach ?>

   