<!--avtor:Lovrenc-->

<h2>Dodajanje nalog</h2>

<?php foreach ($stories as $story): ?>
	<h2> <?php echo $story->id.".)".$story->name ?></h2>
	<div> <?php echo $story->text ?>
	<ol><?php foreach ($tasks as $task): ?>
		<h3><li> <?php echo $task->task_name ?> </li></h3>
		 <?php echo $task->text ?> 
	<?php endforeach?></div>
<?php endforeach ?>

    