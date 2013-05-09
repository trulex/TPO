<!--avtor:BOSTJAN-->
<div id="content">
    <div id="left">
		<div id="add">
			<p>Active tasks: </p><br>
			<?php foreach($stories as $row):
					$tasks=$this->tasks->getCurrent($row->id);
					$active=$this->tasks->getStoryActive($row->id);
					
					if($active == 1){
					?>
					<div class="zgodba">
						<?php echo "<h4>".$row->name." (Estimate: ".round($row->difficulty,2)." pts.)</h4><br>"; ?>
					</div>
					<div class="taski">
					<?php
						echo "<h5>".$row->text."</h5><br>";
						echo "<hr>";
						echo "<div style=float:left;font-weight:bold;>Tasks</div><br>";
						echo "<hr>";
						foreach($tasks as $task):?>
							<?php 
							if($task->active == 1){	
								echo "-".$task->name;
								echo '<br>';
							}
							?>
						<?php endforeach ?>	
					</div>
					<?php } ?>
		<?php endforeach ?>	
		</div><br>
	</div>
    </div>
</form>