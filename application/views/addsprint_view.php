<!--avtor:BOSTJAN-->
<?php echo form_open('verifyaddsprint');
		if ($this->session->flashdata('flashSuccess') != ''): 
			$this->session->flashdata('flashSuccess'); 
		endif;
?>

<div id="content">
    <div id="left">
	<div id="add">
	<p>Add a new sprint</p>
		<span style="color:red">*</span><label>Start date</label>
		<input type="text" name="startdate" value="<?php echo set_value('startdate'); ?>" size="20" placeholder="(dd.mm.YYYY)"/><br>
		<small><span style="color:red;font-weight:normal"><?php echo form_error('startdate'); ?></span></small>

		<span style="color:red">*</span><label>Finish date</label>
		<input type="text" name="finishdate" value="<?php echo set_value('finishdate'); ?>" size="20" placeholder="(dd.mm.YYYY)"/><br>
		<small><span style="color:red;font-weight:normal"><?php echo form_error('finishdate'); ?></span></small>
			
		<span style="color:red">*</span><label>Sprint velocity</label>
		<input type="text" name="velocity" value="<?php echo set_value('velocity'); ?>" size="3"/>
		<small>(in story points)</small><br>
		<small><span style="color:red;font-weight:normal"><?php echo form_error('velocity'); ?></span></small>
		
		<div><form action="verifyaddsprint"><input type="submit" value="Create sprint" /></form></div>
		<span style="color:green;font-weight:normal"><?php echo $this->session->flashdata('flashSuccess') ?></span>	
	</div>
	</div>
</div>

<div id="content">
	<div id="left">
	<?php
		if($currentsprints ){
			echo '<p>Sprints: </p><br>';
			foreach($currentsprints as $name=>$row) { ?>
				<div class="sprintbox">
				<?php
				echo "<b>Sprint ".($name+1)."</b> ";
				echo date("d.m.Y", strtotime($row->start_date))." - ";
				echo date("d.m.Y", strtotime($row->finish_date));
				echo ", velocity: ".$row->velocity;
				$today = date("Y-m-d"); ?>
				
				<?php if($today >= $row->start_date && $today <= $row->finish_date){ ?>
					<span style="color:orange;font-weight:normal">IN PROGRESS</span>
					<div class="editbutton">
					<?php 
					echo form_open('verifyaddsprint/editSprint');
					echo form_submit('editbutton', 'Edit');
					echo form_hidden('sprintid', $row->id);
					echo form_close();					
					?>
					</div>
				<?php }elseif($today >= $row->start_date && $today >= $row->finish_date){ ?>
					<span style="color:green;font-weight:normal">FINISHED</span>
				<?php }else{ ?>
					<span style="color:red;font-weight:normal">FUTURE</span>
					<div class="editbutton">
					<?php 
					echo form_open('verifyaddsprint/editSprint');
					echo form_submit('editbutton', 'Edit');
					echo form_hidden('sprintid', $row->id);
					echo form_close();
					?>					
					</div>
					<div class="deletebutton">
					<?php
					echo form_open('verifyaddsprint/deleteSprint');
					echo form_submit('deletbutton', 'Delete');
					echo form_hidden('sprintid', $row->id);
					echo form_close(); ?>
					</div>
				<?php } ?>
				</div>
				 <?php
				 echo "<br>"; }
		} else { /* No sprints yet */
		echo '<p>Sprints: </p><br>';
		echo 'No sprints have been added yet.';
		}
	?>
	</div>
</div>
</form>