<div id="content">
    <div id="left">
		<div id="add">
			<p>Finished stories: </p><br>
			<?php foreach($results as $row):
				if($row->PID == $PID && $row->SpID == $SpID && $row->finished == 1): ?>
					<div class="zgodba">
						<?php echo "<h4>".$row->name." (Estimate: ".round($row->difficulty,2)." pts.)</h4><br>"; ?>
					</div>
					<div class="taski">
						<h5><?php echo $row->text ?></h5>
						<br>
					</div>
				<?php endif ?>	
			<?php endforeach ?>
			</div><br>
		</div>
	</div>
</form>