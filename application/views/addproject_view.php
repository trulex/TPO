<!--avtor:BOSTJAN-->
<?php echo form_open('verifyaddproject');
		if ($this->session->flashdata('flashSuccess') != ''): 
			$this->session->flashdata('flashSuccess'); 
		endif;
?>

<div id="content">
    <div id="left">
	<div id="add">
	    <p>Create a new project</p>
<<<<<<< HEAD
	    <span style="color:red">*</span><label>Project name</label>
=======
		<span style="color:red">*</span><label>Project name</label>
>>>>>>> origin/boco
		<input type="text" name="projectname" value="<?php echo set_value('projectname'); ?>" size="20"/><br>
		<small><span style="color:red;font-weight:normal"><?php echo form_error('projectname'); ?></span></small>
		
		<label>Project description</label>
		<textarea name="description" rows="5" value="<?php echo set_value('description'); ?>" cols="20"></textarea><br>
		
		<label>Scrum master</label>
		<?php
			$sql="SELECT id, username FROM users"; 
			$result=mysql_query($sql); 

			$options=""; 

			while ($row=mysql_fetch_array($result)) { 
				$id=$row["id"]; 
				$username=$row["username"]; 
				$options.="<option value=\"$id\">".$username; 
			} 
		?> 
		<select name="scrummaster"> 
		<option value=0>- 
			<?=$options?> 
		</select><br> 

		<label>Product owner</label>
		<?php
			$sql="SELECT id, username FROM users"; 
			$result=mysql_query($sql); 

			$options=""; 

			while ($row=mysql_fetch_array($result)) { 
				$id=$row["id"]; 
				$username=$row["username"]; 
				$options.="<option value=\"$id\">".$username; 
			} 
		?> 
		<select name="productowner"> 
		<option value=0>- 
			<?=$options?> 
		</select><br> 

<<<<<<< HEAD
		<label>Team members</label>
		<?php
			$sql="SELECT id, username FROM users"; 
			$result=mysql_query($sql); 

			$input=""; 

			while ($row=mysql_fetch_array($result)) { 
				$id=$row["id"]; 
				$username=$row["username"]; 
				$input.="<input type=checkbox>".$username."</input><br>";
			} 
		?> 
		<div class="container">
			<?=$input?>
		</div>

		<div><form action="verifyaddproject"><input type="submit" value="Create project" /></form></div>
		<span style="color:red"><?php echo $this->session->flashdata('flashSuccess') ?></span>
	</div>
	<div id="content">
	<p>Projects: </p><br>
	<?php
		foreach($results as $row){
			echo $row->project_name;
			echo " ".anchor('editproject', 'Edit');
			echo "<br>";
		}
	?>
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
=======
		<div><input type="submit" value="Create project" /></div>
		<span style="color:red"><?php echo $this->session->flashdata('flashSuccess') ?></span>
	</div>
	</div>	
>>>>>>> origin/boco
</div>
</form>