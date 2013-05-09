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
						echo "<div style=color:001FFF;font-size:12;margin-top:-10;>".$row->tests."</div><br>";
						echo "<hr>";
						echo "<div style=float:left;font-weight:bold;>Tasks</div><br>";
						echo "<hr>";
						foreach($tasks as $task):?>
							<?php echo "-".$task->name ?><br>
						<?php endforeach ?>	
					</div>	
					<div class="notes">
					<h5 id="note" onclick="editNote()"><?php echo $row->note?></h5>
					<div class="gumbR">
						<form name="editNote" method="post" action="editNote" style="display:inline;">
							<input name="redirect" type="hidden" value="<?php echo $this->uri->uri_string(); ?>" />
							<button type="submit" value="<?php echo $row->id; ?>" name="StID">Notes</button>
						</form>
					</div>
					<br>
				</div>
		<?php endforeach ?>	
		</div><br>
	</div>
    </div>
</form>