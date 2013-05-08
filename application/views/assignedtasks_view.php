<!--avtor:BOSTJAN-->
<div id="content">
    <div id="left">
		<div id="add">
			<p>Unassigned tasks: </p><br>
			<?php foreach($stories as $row):
				$tasks=$this->tasks->getCurrent($row->id)?>
				<div class="zgodba">
					<?php echo "<h4>".$row->name." (Estimate: ".round($row->difficulty,2)." pts.)</h4><br>"; ?>
				</div>
				<div class="taski">
				<?php
					echo "<h5>".$row->text."</h5><br>";
					echo "<h4><b>Tasks</b></h4>";
					echo "<hr>";
					foreach($tasks as $task):?>
						<?php
						if($task->UID != 0){
							echo '-'.$task->name;
							echo ' [Hours: '.$task->time_estimate.']';
							echo '<br>';
						?>
						<li name="female" class="workingLabel">Working: <?php echo $this->users->getUserName($task->UID)?></li>
						<?php } ?>
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