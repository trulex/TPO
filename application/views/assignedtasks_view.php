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
					echo "<div style=color:001FFF;font-size:12;margin-top:-10;>".$row->tests."</div><br>";
					echo "<hr>";
					?>
					<div style="float:left;font-weight:bold;">Tasks</div>
					<div style="float:right;font-weight:bold;margin-left:30px;margin-right:20px;">Remaining</div>
					<div style="float:right;font-weight:bold;margin-left:30px;margin-right:20px;">Member</div>
					<div style="float:right;font-weight:bold;margin-left:30px;margin-right:20px;">Status</div><br>
					<?php echo "<hr>";
					foreach($tasks as $task):?>
						<?php
						if($task->UID != 0){
							echo '-'.$task->name;
							echo ' [Estimate: '.$task->time_estimate.'h]';
						?>
						<div style="float:right;display:inline-block;margin-right:20px;min-width:85px;text-align:right"><?php echo ($task->time_estimate - $this->tasks->getTime($task->name, $task->UID))."h";?></div>
						<div style="float:right;display:inline-block;margin-right:52px;min-width:100px;text-align:right"><?php echo $this->users->getUserName($task->UID)?></div>
						<?php if($task->completed == 1){ ?>
							<div style="float:right;display:inline-block;margin-right:15px;min-width:90px;color:green;text-align:right">Completed</div><br>
						<?php }else{?>
							<div style="float:right;display:inline-block;margin-right:15px;min-width:90px;color:orange;text-align:right">Assigned</div><br>
							<?php } ?>
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