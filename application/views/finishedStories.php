<div id="content">
    <div id="left">
		<div id="add">
			<p>Finished stories: </p><br>
			<?php foreach($results as $row):?>
				<div class="zgodba">
					<?php echo "<h4>".$row->name." (Estimate: ".round($row->difficulty,2)." pts.)</h4><br>"; ?>
				</div>
				<div class="taski">
					<h5><?php echo $row->text ?></h5><br>
					<div style="color:001FFF;font-size:12;margin-top:-10;"><?php echo $row->tests ?></div>
					<br>
				</div>
				<div class="notes">
					<h5 id="note" onclick="editNote()"><?php echo $row->note?></h5>
					<div class="gumbR">
						<form name="editNote" method="post" action="editNote" style="display:inline;">
							<input name="redirect" type="hidden" value="<?php echo $this->uri->uri_string(); ?>" />
							<button type="submit" value="<?php echo $row->id; ?>" name="StID">Notes</button>
						</form>
					</div>
				</div>
			<?php endforeach ?>
			</div><br>
		</div>
	</div>
</form>