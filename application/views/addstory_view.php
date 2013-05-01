<!--avtor:darko-->
<?php echo form_open('verifyaddstory'); 
$msg=strcmp($message,'');
$err=strcmp($noproject,'');
?>
<div id="content">
    <div id="left">
	<h3>Add a new user story</h3>
	<div id="add">
	    <span style="color:red">*</span><label>Name</label>
	    <input type="text" name="name" value="<?php if($msg==0) {echo set_value('name');} ?>" size="20"/>
	    <?php echo form_error('name','<div id="validation">','</div>'); ?><br />
	    
	    <span style="color:red;vertical-align:top">*</span><label>Text</label>
	    <textarea name="text" class="addstory" cols="19" rows="3"> <?php if($msg==0) {echo set_value('text');} ?> </textarea>
	    <?php echo form_error('text','<div id="validation">','</div>'); ?><br />
	    
	    <span style="color:red;vertical-align:top">*</span><label>Tests</label>
	    <textarea name="tests" class="addstory" cols="19" rows="3"><?php if($msg==0) {echo set_value('tests');} ?></textarea>
	    <?php echo form_error('tests','<div id="validation">','</div>'); ?><br />
	    
	    <span style="color:red">*</span><label>Business value</label>
	    <input type="text" name="business_value" value="<?php if($msg==0) {echo set_value('business_value');} ?>" size="20"/>
	    <?php echo form_error('business_value','<div id="validation">','</div>'); ?><br />
	    
	    <label>Priority</label>
	    <select name="priority" size="2">
		<option value="musthave" selected>Must have</option>
		<option value="shouldhave">Should have</option>
		<option value="couldhave">Could have</option>
		<option value="wonthave">Won't have this time</option>
	    </select>
	    
	    <div><form name="submit" action="verifyaddstory"><input type="submit" value="Submit" /></form></div>
	</div>
	<div id="validation">
	    <?php 
	    if($err!=0) { //no project chosen
		echo $noproject; }
	    ?>
	</div>
	<?php if($msg!=0) {
	    echo '<p style="color:blue;margin-left:25%">'.$message.'</p>'; }
    ?>
    </div>
</div>
</form>
