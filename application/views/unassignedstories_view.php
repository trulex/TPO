<!--avtor:BOSTJAN-->
<div id="content">
	<?php 
		if( $this->session->userdata('varError')==1){
			echo '<span style="color:red">Time must be non-negative!</span>';
		}
		else if($this->session->userdata('varError')==2){
			echo '<span style="color:red">Time must be numeric</span>';
		}
		$this->session->set_userdata('varError',0);
	?>
    <div id="left">
	<div id="add">
		<p>Unassigned stories: </p><br>
		<?php foreach($results as $row):
			if($row->PID == $PID && $row->SpID == 0): ?>
				<div class="zgodba">
					<?php echo "<h4>".$row->name." (Estimate: ".round($row->difficulty,2)." pts.)</h4><br>"; 
					 if($row->SpID == 0): ?>
						<div class="difficulty">
						<?php 
						if($rights == 1 || $ScrumMaster == $UID){
							echo '<form name="chDifficulty" method="post" action="unassignedstories/changeDifficulty" style="display:inline;">';
							echo '<input name="difficulty" type="text" size="3" value="'.$row->difficulty.'"/>';
							echo '<input name="redirect" type="hidden" value="'.$this->uri->uri_string().'" />';
							echo '<button type="submit" value="'.$row->id.'" name="StID">Change pts</button></form>';
							
							echo '<form name="deleteStory" method="post" action="unassignedstories/deleteStory" style="display:inline;margin-left:10px;">';
							echo '<input name="redirect" type="hidden" value="'.$this->uri->uri_string().'" />';
							echo '<button type="submit" value="'.$row->id.'" name="StID">Delete</button></form>';
							
							echo '<form name="editStory" method="post" action="editStory" style="display:inline;">';
							echo '<input name="redirect" type="hidden" value="'.$this->uri->uri_string().'" />';
							echo '<button type="submit" value="'.$row->id.'" name="StID">Edit</button></form>';
							
						}
						?>
						</div>
					<?php endif	?>
				</div>
				<div class="taski">
					<h5><?php echo $row->text ?></h5>
					<br>
				</div>
				<div class="notes">
					<h5 id="note" onclick="editNote()"><?php echo $row->note?></h5>
					<div class="gumbR">
						<form name="editNote" method="post" action="editNote" style="display:inline;">
							<input name="redirect" type="hidden" value="<?php echo $this->uri->uri_string(); ?>" />
							<button type="submit" value="<?php echo $row->id; ?>" name="StID">Edit</button>
						</form>
					</div>
					<br>
				</div>
				<?php if($rights == 1 || $ScrumMaster == $UID){
						if($row->difficulty != 0): ?>
						<div class="gumb">
							<form action="unassignedstories/entry_SpID" method="post">
								<input type="submit" name="submitbutton" value="Add to sprint" />
								<input type="hidden" name="submitstories" value="<?php echo $row->id ?>" />
								<input name="redirect" type="hidden" value="<?= $this->uri->uri_string() ?>" />
							</form>
						</div>
						<?php endif ?>
					<?php } ?>
			<?php endif ?>	
		<?php endforeach ?>	
		</div><br>
		<?php if($rights == 1 || $ScrumMaster == $UID){ ?>
		<form action="addsprint" method="post">
			<input type="submit" name="submitbutton" value="Manage sprints" />
		</form>
		<?php } ?>
    </div>
</div>
</form>