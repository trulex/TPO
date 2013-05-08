<!--avtor:BOSTJAN-->

<div id="content">
    <div id="left">
		<div id="add">
			<p>Finished tasks: </p><br>
			<?php foreach($stories as $row):
				$tasks=$this->tasks->getCurrent($row->id)?>
				<div class="zgodba">
					<?php echo "<h4>".$row->name." (Estimate: ".round($row->difficulty,2)." pts.)</h4><br>"; ?>
						<?php
							if($role==2){
								if(!$row->finished && !$this->tasks->getCurrentUnfinished($row->id)){
									echo '<form name="endStory" method="post" action="unassignedtasks/endStory" style="display:inline;">';
									echo '<input name="redirect" type="hidden" value="'.$this->uri->uri_string().'" />';
									echo '<button type="submit" value="'.$row->id.'" name="StID">Confirm</button></form>';
								}
								echo '<form name="endStory" method="post" action="unassignedtasks/rejectStory" style="display:inline;">';
								echo '<input name="return" type="hidden" value="'.$this->uri->uri_string().'" />';
								echo '<button type="submit" value="'.$row->id.'" name="StID">Reject</button></form>';
								
							}
						?>
				</div>
				<div class="taski">
				<?php
					echo "<h5>".$row->text."</h5><br>";
					echo "<h4><b>Tasks</b></h4>";
					echo "<hr>";
					foreach($tasks as $task):?>
						<?php 
						if($task->completed == 1){	
							echo "-".$task->name;
							echo '<br>';
						}
						?>
					<?php endforeach ?>	
				</div>
				<div class="notes">
					<h5 id="note" onclick="editNote()"><?php echo $row->note?></h5>
					<br>
				</div>
		<?php endforeach ?>	
		</div><br>
	</div>
    </div>
</form>
