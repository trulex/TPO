<!--avtor:Lovrenc-->
<!-- Ta view je narejen za celoten Product Backlog. V spremenljivki $results se vrne storyje s pravilnim querijem, kateri controller se uporablja pa se tukaj v switchu spodaj nastavi z spremenljivko $mode -->

<div id="content">
	<?php 
		if( $this->session->userdata('varError')==1){
			echo '<span style="color:red">Time must be non-negative!</span>';
		}
		else if($this->session->userdata('varError')==2){
			echo '<span style="color:red">Time must be numeric</span>';
		}
		$this->session->set_userdata('varError',0);
		
// 		Mode selects the right controller
		switch($mode){
			case 0:
			$naslov="Unassigned Stories";
			break;
			case 1:
			$naslov="Assigned Stories";
			break;
			case 2:
			$naslov="All Stories";
			break;
			case 3:
			$naslov="Finished Stories";
			break;
		}
	?>
    <div id="left">
	<div id="add">
	    <p> <?php echo $naslov ?></p>
	    <br>
		<?php if( !$mode && ($rights || $role == 1)){ ?>
		<form action="addsprint" method="post">
			<input style="margin-right:100%;" type="submit" name="submitbutton" value="Manage sprints" />
		</form>
		<?php } ?>
	    <?php 
			foreach($results as $story){
				echo '<div class="zgodba">';
						echo "<h4>".$story->name." (Estimate: ".round($story->difficulty,2)." pts.)</h4><br>";
						if($role>1 && $mode==2){
							if(!$story->finished && !$this->tasks->getCurrentUnfinished($story->id)){
								echo '<form name="endStory" method="post" action="unassignedTasks/endStory" style="display:inline;">';
								echo '<input name="redirect" type="hidden" value="'.$this->uri->uri_string().'" />';
								echo '<button type="submit" value="'.$story->id.'" name="StID">Confirm</button></form>';
							}
							if(!$this->tasks->getCurrentUnfinished($story->id)){
								echo '<form name="endStory" method="post" action="unassignedTasks/rejectStory" style="display:inline;">';
								echo '<input name="return" type="hidden" value="'.$this->uri->uri_string().'" />';
								echo '<button type="submit" value="'.$story->id.'" name="StID">Reject</button></form>';
							}
						}
						if(!$mode){
							echo '<div class="difficulty">';
							if($rights  || $role){
								echo '<form name="chDifficulty" method="post" action="unassignedStories/changeDifficulty" style="display:inline;">';
								echo '<input name="difficulty" type="text" size="3" value="'.$story->difficulty.'"/>';
								echo '<input name="redirect" type="hidden" value="'.$this->uri->uri_string().'" />';
								echo '<button type="submit" value="'.$story->id.'" name="StID">Change pts</button></form>';
							}
							if($rights  || $role){
								echo '<form name="deleteStory" method="post" action="unassignedStories/deleteStory" style="display:inline;margin-left:15px">';
								echo '<input name="redirect" type="hidden" value="'.$this->uri->uri_string().'" />';
								echo '<button type="submit" value="'.$story->id.'" name="StID">Delete</button></form>'; 
								
								echo '<form name="editStory" method="post" action="editStory" style="display:inline;">';
								echo '<input name="redirect" type="hidden" value="'.$this->uri->uri_string().'" />';
								echo '<button type="submit" value="'.$story->id.'" name="StID">Edit</button></form>';
							}
						echo '</div>';
						}?>
					</div>
				<div class="taski">
					<h5><?php echo $story->text ?></h5><br>
					<?php
					echo "<div style=color:001FFF;font-size:12;margin-top:-10;>";
						foreach(explode("\n", $story->tests) as $test) {
							echo $test.'<br>';
						}?>
					<br>
					</div>
				</div>
				<div class="notes">
					<h5 id="note"><?php foreach(explode("\n", $story->note) as $note) { echo $note.'<br>';}?></h5>
					<div class="gumbR">
						<form name="editNote" method="post" action="editNote" style="display:inline;">
							<input name="redirect" type="hidden" value="<?php echo $this->uri->uri_string(); ?>" />
							<button type="submit" value="<?php echo $story->id; ?>" name="StID">Notes</button>
						</form>
					</div>
					<br>
				</div>
				<?php 
					if(!$mode && ($rights || $role == 1)){
						if($story->difficulty ){
				?>
							<div class="gumb">
								<form action="unassignedStories/entry_SpID" method="post">
									<input type="submit" name="submitbutton" value="Add to sprint" />
									<input type="hidden" name="submitstories" value="<?php echo $story->id ?>" />
									<input name="redirect" type="hidden" value="<?= $this->uri->uri_string() ?>" />
								</form>
							</div>
							<?php
						}
					}
		}
	?>	
		</div><br>
		<?php if( !$mode && ($rights || $role == 1)){ ?>
		<form action="addsprint" method="post">
			<input type="submit" name="submitbutton" value="Manage sprints" />
		</form>
		<?php } ?>
    </div>
</div>
</form>