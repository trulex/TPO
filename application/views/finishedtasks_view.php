<!--avtor:BOSTJAN-->

<div id="content">
    <div id="left">
		<div id="add">
			<p>Finished tasks: </p><br>
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
					echo "<div style=float:left;font-weight:bold;>Tasks</div><br>";
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
					<h5 id="note"><?php foreach(explode("\n", $row->note) as $note) { echo $note.'<br>';}?></h5>
					<br>
				</div>
		<?php endforeach ?>	
		</div><br>
	</div>
    </div>
</form>
