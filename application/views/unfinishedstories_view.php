<!--avtor:BOSTJAN-->
<div id="content">
    <div id="left">
		<div id="add">
			<p>Stories: </p><br>
			<?php foreach($results as $row):
				if($row->PID == $PID): ?>
					<div class="zgodba">
						<?php
							echo "<h4>".$row->name."(".$row->difficulty.")</h4><br>";
							if($role==1 && $row->SpID == 0){
								echo '<form name="chDifficulty" method="post" action="unfinishedstories/changeDifficulty">';
								echo '<input name="difficulty" type="text" size="3" value="'.$row->difficulty.'"/>';
								echo '<input name="redirect" type="hidden" value="'.$this->uri->uri_string().'" />';
								echo '<button type="submit" value="'.$row->id.'" name="StID">Change pts</button></form>';
							}
						?>
						</div>
						<div class="taski">
							<?php
								echo "<h5>".$row->text."</h5>";
								echo "<br>";
							?>
						</div>
						<?php if($row->SpID == 0 && $row->difficulty != 0): ?>
						<div class="gumb">
							<form action="unfinishedstories/entry_SpID" method="post">
								<input type="submit" name="submitbutton" value="Add to sprint" />
								<input type="hidden" name="submitstories" value=<?php echo $row->id ?> />
								<input name="redirect" type="hidden" value="<?= $this->uri->uri_string() ?>" />
							</form>
						</div>
					<?php endif ?>
				<?php endif ?>	
			<?php endforeach ?>	
			</div>
		</div>
	</div>
</form>