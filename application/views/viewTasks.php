<!--avtor:Lovrenc-->

<h2>Dodajanje nalog</h2>

<?php foreach ($stories as $story): ?>
	<h2> <?php echo $story->name ?></h2>
	<div> <?php echo $story->text ?>
	<?php foreach ($tasks as $task): ?>
		<h3> <?php echo $task->task_name ?> </h3>
		 <?php echo $task->text ?> 
	<?php endforeach?></div>
<?php endforeach ?>

    