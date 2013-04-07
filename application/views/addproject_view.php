<!--avtor:BOSTJAN-->
<?php echo form_open('verifyaddproject');
		if ($this->session->flashdata('flashSuccess') != ''): 
			$this->session->flashdata('flashSuccess'); 
		endif;
?>

<div id="add">
    <p>Create a new project</p>
    <span style="color:red">*</span><label>Project name</label>
	<input type="text" name="projectname" value="<?php echo set_value('projectname'); ?>" size="20"/><br>
	<small><span style="color:red"><?php echo form_error('projectname'); ?></span></small>
	
    <label>Project description</label>
	<textarea name="description" rows="5" value="<?php echo set_value('description'); ?>" cols="20"></textarea><br>
	
	<label>Scrum master</label>
	<select name="scrummaster">-
		<option value="-" selected>-</option>
		<option value="saab">Saab</option>
		<option value="mercedes">Mercedes</option>
		<option value="audi">Audi</option>
	</select><br> 
	
	<label>Product owner</label>
	<select name="productowner">-
		<option value="-" selected>-</option>
		<option value="saab">Saab</option>
		<option value="mercedes">Mercedes</option>
		<option value="audi">Audi</option>
	</select><br>
	
	<label>Team members</label>
	<div class="container">
		<input type="checkbox" /> test <br />
		<input type="checkbox" /> test <br />
		<input type="checkbox" /> test <br />
		<input type="checkbox" /> test <br />
		<input type="checkbox" /> test <br />
		<input type="checkbox" /> test <br />
		<input type="checkbox" /> test <br />
		<input type="checkbox" /> test <br />		
	</div>

    <div><input type="submit" value="Create project" /></div>
	<span style="color:red"><?php echo $this->session->flashdata('flashSuccess') ?></span>
</div>
<div id="add">
	<p>Projects: </p><br>
	<?php
		foreach($results as $row){
			echo $row->project_name;
			echo " ".anchor('editproject', 'Edit');
			echo "<br>";
		}
	?>
</div>
</form>