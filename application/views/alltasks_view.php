<!--avtor:BOSTJAN-->
<div id="content">
    <div id="left">
		<div id="add">
			<p>All tasks: </p><br>
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
							<?php echo "-".$task->name ?><br>
						<?php endforeach ?>	
					</div>	
		<?php endforeach ?>	
		</div><br>
	</div>
    </div>
</form>