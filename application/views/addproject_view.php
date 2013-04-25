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

		<span style="color:red">*</span><label>Project name</label>
		<input type="text" name="projectname" value="<?php echo set_value('projectname'); ?>" size="20"/><br>
		<small><span style="color:red;font-weight:normal"><?php echo form_error('projectname'); ?></span></small>
		
		<label>Project description</label>
		<textarea name="description" rows="5" value="<?php echo set_value('description'); ?>" cols="20"></textarea><br>

		<div><input type="submit" value="Create project" /></div>
		<span style="color:green; font-weight:normal"><?php echo $this->session->flashdata('flashSuccess') ?></span>
	</div>
	</div>	
</div>
</form>