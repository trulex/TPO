<!--avtor:BOSTJAN-->
<div id="content">
	<?php 
				if( $this->session->userdata('varError')==1){
					echo '<span style="color:red">Time must be non-negative!</span>';
				}
				else if($this->session->userdata('varError')==2){
					echo '<span style="color:red">Time must be numeric</span>';
				}
				$this->session->set_userdata('varError',0);?>
    <div id="left">
		<div id="add">
			<p>Assigned stories: </p><br>
			<?php foreach($results as $row):
				if($row->PID == $PID && $row->SpID == $SpID): ?>
					<div class="zgodba">
						<?php echo "<h4>".$row->name." (Estimate: ".round($row->difficulty,2)." pts.)</h4><br>"; ?>
					</div>
					<div class="taski">
						<h5><?php echo $row->text ?></h5>
						<br>
					</div>
				<?php endif ?>	
			<?php endforeach ?>	
			</div><br>
		</div>
	</div>
</form>