<!--avtor:Lovrenc-->

<h2>Dodajanje nalog</h2>

<?php foreach ($stories as $story): ?>

    <h2><?php echo $story['name']?></h2>
    <div id="main"> <?php echo $story['text']?> </div>
    <label>Task name</label>
    <input type="text" name=taskName value=<?php echo set_value('taskName')/>;

<?php endforeach ?>
