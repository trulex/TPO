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
	<?php $this->load->view('selProject', array('projects'=>$projects));   ?>
</div>

<div id="content">
	<?php
		if($currentsprints ){
			echo '<p>Sprints: </p><br>';
			foreach($currentsprints as $row) {
				echo $row->start_date." - ";
				echo $row->finish_date;
				echo ", velocity: ".$row->velocity;
				$today = strtotime(date("Y-m-d")); ?>
				
				<?php if($today >= strtotime($row->start_date) && $today <= strtotime($row->finish_date)){ ?>
					<span style="color:orange;font-weight:normal">IN PROGRESS</span>
					<form action="verifyaddsprint/editSprint" method="post">
						<input type="submit" name="editbutton" value="Edit" />
						<input type="hidden" name="sprintid" value=<?php echo $row->id ?> />
					</form>
				<?php }elseif($today >= strtotime($row->start_date) && $today >= strtotime($row->finish_date)){ ?>
					<span style="color:green;font-weight:normal">FINISHED</span>
				<?php }else{ ?>
					<span style="color:red;font-weight:normal">FUTURE</span>
					<form action="verifyaddsprint/editSprint" method="post">
						<input type="submit" name="editbutton" value="Edit" />
						<input type="hidden" name="sprintid" value=<?php echo $row->id ?> />
					</form>
					<form action="verifyaddsprint/deleteSprint" method="post">
						<input type="submit" name="deletebutton" value="Delete" />
						<input type="hidden" name="sprintid" value=<?php echo $row->id ?> />
					</form>
				<?php }
				 echo "<br>"; }
		} else { /* No sprints yet */
		echo '<p>Sprints: </p><br>';
		echo 'No sprints have been added yet.';
		}
	?>
</div>
</form>

