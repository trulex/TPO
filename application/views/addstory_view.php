<!--avtor:darko-->
<?php echo form_open('verifyaddstory'); 
$msg=strcmp($message,'');
$err=strcmp($noproject,'');
?>
<div id="content">
    <div id="left">
	<div id="add">
	    <p>Add a new user story</p>
	    <span style="color:red">*</span><label>Name</label>
	    <input type="text" name="name" value="<?php if($msg==0) {echo set_value('name');} ?>" size="20"/><br />
	    
	    <span style="color:red;vertical-align:top">*</span><label>Text</label>
	    <textarea name="text" class="addstory" cols="19" rows="3"> <?php if($msg==0) {echo set_value('text');} ?> </textarea><br />
	    
	    <span style="color:red;vertical-align:top">*</span><label>Tests</label>
	    <textarea name="tests" class="addstory" cols="19" rows="3"><?php if($msg==0) {echo set_value('tests');} ?></textarea><br />
	    
	    <span style="color:red">*</span><label>Business value</label>
	    <input type="text" name="business_value" value="<?php if($msg==0) {echo set_value('business_value');} ?>" size="20"/><br />
	    
	    <label>Priority</label>
	    <select name="priority">
		<option value="musthave">Must have</option>
		<option value="shouldhave">Should have</option>
		<option value="couldhave">Could have</option>
		<option value="wonthave">Won't have this time</option>
	    </select>
	    
	    <div><form name="submit" action="verifyaddstory"><input type="submit" value="Submit" /></form></div>
	</div>
	<div id="validation">
	    <?php echo validation_errors(); 
	    
	    if($err!=0) { //no project chosen
		echo $noproject; }
	    ?>
	</div>
	<?php if($msg!=0) {
	    echo '<p style="color:blue;margin-left:25%">'.$message.'</p>'; }
    ?>
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
</form>
