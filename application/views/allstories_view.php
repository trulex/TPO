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
					<h5 id="note"><?php foreach(explode("\n", $row->note) as $note) { echo $note.'<br>';}?></h5>
					<div class="gumbR">
						<form name="editNote" method="post" action="editNote" style="display:inline;">
							<input name="redirect" type="hidden" value="<?php echo $this->uri->uri_string(); ?>" />
							<button type="submit" value="<?php echo $row->id; ?>" name="StID">Notes</button>
						</form>
					</div>
					<br>
				</div>
			<?php endif ?>	
		<?php endforeach ?>	
		</div><br>
	</div>
</div>
</form>