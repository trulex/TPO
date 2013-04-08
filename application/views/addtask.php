<!--avtor:Lovrenc-->

<h2>Dodajanje nalog</h2>

<?php foreach ($stories as $story): ?>
	<h2> <?php echo $story->name ?></h2>
	<div> <?php echo $story->text ?>
	<?php echo $story->id?></div>

<?php endforeach ?>

    