<!--avtor:BOSTJAN-->
<div id="content">
    <div id="left">
	<div id="add">
	<p>Stories: </p><br>
	<?php foreach($results as $row): ?>
			<div class="zgodba">
			<?php
			echo "<h4>".$row->name."</h4><br>";
			?>
			</div><div class="taski">
			<?php
			echo "<h5>".$row->text."</h5>";
			echo "<br>";
			?>
			</div>
			<?php if($row->SpID == 0): ?>
				<div class="gumb">
					<form action="unfinishedstories/entry_SpID" method="post">
						<input type="submit" id=<?php echo $row->id ?> class="submitstorie" name="submitstories" value=<?php echo $row->id ?> />
						<input name="redirect" type="hidden" value="<?= $this->uri->uri_string() ?>" />
					</form>
				</div>
			<?php endif ?>
		<?php endforeach ?>
	</div>	
	</div>
</div>
</form>