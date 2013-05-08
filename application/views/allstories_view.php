<!--avtor:BOSTJAN-->
<div id="content">
    <div id="left">
		<div id="add">
			<p>All stories: </p><br>
			<?php foreach($results as $row):
				if($row->PID == $PID): ?>
					<div class="zgodba">
						<?php echo "<h4>".$row->name." (Estimate: ".round($row->difficulty,2)." pts.)</h4><br>"; ?>
					</div>
					<div class="taski">
					<?php
						echo "<h5>".$row->text."</h5>";
						echo "<br>";
					?>
					</div>
					<div class="notes">
						<h5 id="note" onclick="editNote()"><?php echo $row->note?></h5>
						<br>
					</div>
			<?php endif ?>	
		<?php endforeach ?>	
		</div><br>
	</div>
</div>
</form>