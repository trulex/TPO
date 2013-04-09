<!--avtor:BOSTJAN-->
<?php echo form_open('editproject');
		if ($this->session->flashdata('flashSuccess') != ''): 
			$this->session->flashdata('flashSuccess'); 
		endif;
?>

<div id="content">
    <div id="left">
	<div id="add">
		<p>Edit project</p>
		<span style="color:red">*</span><label>Project name</label>
		<input type="text" name="projectname" value="<?php echo set_value($this->session->userdata('project')); ?>" size="20"/><br>
		<small><span style="color:red;font-weight:normal"><?php echo form_error('projectname'); ?></span></small>
		
		<label>Project description</label>
		<textarea name="description" rows="5" value="<?php echo set_value('description'); ?>" cols="20"></textarea><br>
		
		<label>Scrum master</label>
		<?php
			$sql="SELECT id, username FROM users ORDER BY username asc"; 
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
			$sql="SELECT id, username FROM users ORDER BY username asc"; 
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

		<label>Team members</label>
		<?php
			$sql="SELECT id, username FROM users ORDER BY username asc"; 
			$result=mysql_query($sql); 

			$input=""; 

			while ($row=mysql_fetch_array($result)) { 
				$id=$row["id"]; 
				$username=$row["username"]; 
				$input.="<input name=listofmembers[] type=checkbox value=\"$id\">".$username."</input><br>";
			} 
		?> 
		<div class="container">
			<?=$input?>
		</div>

		<div><input type="submit" value="Save changes" /></div>
		<span style="color:red"><?php echo $this->session->flashdata('flashSuccess') ?></span>
	</div>
	</div>
>>>>>>> origin/boco
</div>
</form>