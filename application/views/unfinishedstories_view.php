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
			<div><input type="submit" value="Add to sprint" /></div>
		<?php endforeach ?>
	</div>	
	</div>
</div>
</form>