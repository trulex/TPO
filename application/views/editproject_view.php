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
		<input type="text" name="projectname" value="<?php echo set_value('projectname',$projectname); ?>" size="20"/><br>
		<small><span style="color:red;font-weight:normal"><?php echo form_error('projectname'); ?></span></small>
		
		<label>Project description</label>
		<textarea name="description" rows="7" cols="22"><?php echo set_value('description',$description); ?></textarea><br>
		
		<label>Scrum master</label>
		<?php
			$sql="SELECT id, username FROM users ORDER BY username asc"; 
			$result=mysql_query($sql); 

			$options="";

			if($scrummaster != 0){
				$id=0; 
				$username="-"; 
				$options.="<option value=\"$id\">".$username;
			}	

			while ($row=mysql_fetch_array($result)) { 
				$id=$row["id"]; 
				$username=$row["username"];
				if($scrummaster != $id){
					$options.="<option value=\"$id\">".$username;
				}		
			} 
		?> 
		<select name="scrummaster"> 
		<option value="<?php echo set_value('scrummaster',$scrummaster); ?>"><?php echo set_value('mastername',$mastername); ?> 
			<?=$options ?> 
		</select><br> 

		<label>Product owner</label>
		<?php
			$sql="SELECT id, username FROM users ORDER BY username asc"; 
			$result=mysql_query($sql); 

			$options="";

			if($productowner != 0){
				$id=0; 
				$username="-"; 
				$options.="<option value=\"$id\">".$username;
			} 

			while ($row=mysql_fetch_array($result)) { 
				$id=$row["id"]; 
				$username=$row["username"];
				if($productowner != $id){
					$options.="<option value=\"$id\">".$username;
				}	
			} 
		?> 
		<select name="productowner"> 
		<option value="<?php echo set_value('productowner',$productowner); ?>"><?php echo set_value('ownername',$ownername); ?> 
			<?=$options ?> 
		</select><br> 

		<label>Team members</label>
		<?php
			$sql="SELECT id, username FROM users ORDER BY username asc"; 
			$result=mysql_query($sql); 

			$input=""; 

			while ($row=mysql_fetch_array($result)) { 
				$id=$row["id"]; 
				$username=$row["username"];
				
				$query=$this->db->query("SELECT user_id FROM project_user WHERE project_id=$PID AND user_id=$id AND role=0");
				if($query->num_rows() > 0){
					$input.="<input type=checkbox name=listofmembers[] value=\"$id\" checked=yes>".$username."</input><br>";
				}else{
					$input.="<input type=checkbox name=listofmembers[] value=\"$id\">".$username."</input><br>";
				}
			} 
		?> 
		<div class="container">
			<?=$input?>
		</div>

		<div><input type="submit" value="Save changes" /></div><br>
		<span style="color:green;font-weight:normal"><?php echo $this->session->flashdata('flashSuccess') ?></span>
	</div>
	</div>
</div>
</form>