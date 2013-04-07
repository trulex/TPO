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
	    <input type="text" name="startdate" value="<?php echo set_value('startdate'); ?>" size="20"/>
	    <small>(dd.mm.YYYY)</small><br>
	    <small><span style="color:red"><?php echo form_error('startdate'); ?></span></small>

	    <span style="color:red">*</span><label>Finish date</label>
	    <input type="text" name="finishdate" value="<?php echo set_value('finishdate'); ?>" size="20"/>
	    <small>(dd.mm.YYYY)</small><br>	
	    <small><span style="color:red"><?php echo form_error('finishdate'); ?></span></small>
		    
	    <span style="color:red">*</span><label>Sprint velocity</label>
	    <input type="text" name="velocity" value="<?php echo set_value('velocity'); ?>" size="3"/>
	    <small>(in story points)</small><br>
	    <small><span style="color:red"><?php echo form_error('velocity'); ?></span></small>
	    
	    <div><form action="verifyaddsprint"><input type="submit" value="Create sprint" /></form></div>
	    <span style="color:red"><?php echo $this->session->flashdata('flashSuccess') ?></span>
	</div>
    </div>
        <div id="projects">
	    <p id="title">My projects</p>
	    <form name="selectp" method="post" action="selectProject/select">
	    <?php	    
		foreach ($projects as $project) {
		    echo '<button type="submit" value="'.$this->project->getProjectName($project).'" name="project">'.$this->project->getProjectName($project).'</button>';
		    echo '<br />';
		}
	    ?>
	    <input name="redirect" type="hidden" value="<?= $this->uri->uri_string() ?>" />
	    </form>
	</div>    
</div>

<div id="content">
	<p>Sprints: </p><br>
	<?php
		foreach($results as $row):
			echo $row->start_date." - ";
			echo $row->finish_date;
			echo ", velocity: ".$row->velocity;
			echo "<br>";
		endforeach
	?>
</div>
</form>