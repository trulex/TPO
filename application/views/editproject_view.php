<!--avtor:BOSTJAN-->
<?php echo form_open('editproject'); ?>

<head>
	<style type="text/css">

	.container {
		border:2px solid #ccc; 
		width:300px; 
		height: 100px;
		overflow-y: 
		scroll;
	}
	</style>
</head>

<div id="add">
    <p>Edit project</p>
    <label>Project name</label>
	<input type="text" name="startdate" value="<?php echo set_value('projectname'); ?>" size="20"/><br>
	
    <label>Project description</label>
	<textarea name="projectdescription" rows="4" value="<?php echo set_value('description'); ?>" cols="50"></textarea><br>
	
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
	
	<div><input type="submit" value="Save changes" /></div>
</div>

<div id="projectvalidation">
	<?php echo validation_errors(); ?>
</div>
</form>