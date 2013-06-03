<?php
echo form_open('editStory/verifyEdit'); 
$msg=strcmp($message,'');
?>
<div id="content">
    <div id="left">
	<h3>Edit user story</h3>
	<div id="add">
	    <span style="color:red;vertical-align:top">*</span><label>Name</label>
	    <input type="text" name="name" value="<?php echo $storyData->name; ?>" size="20"/>
	    <?php echo form_error('name','<div id="validation">','</div>'); ?><br />
	    
	    <span style="color:red;vertical-align:top">*</span><label>Text</label>
	    <textarea name="text" class="addstory" cols="19" rows="3"><?php echo $storyData->text; ?> </textarea>
	    <?php echo form_error('text','<div id="validation">','</div>'); ?><br />
	    
	    <span style="color:red;vertical-align:top">*</span><label>Tests</label>
	    <textarea name="tests" class="addstory" cols="19" rows="3"><?php echo $storyData->tests; ?></textarea>
	    <?php echo form_error('tests','<div id="validation">','</div>'); ?><br />
	    
	    <span style="color:red;vertical-align:top">*</span><label>Business value</label>
	    <input type="text" name="business_value" value="<?php echo $storyData->busvalue; ?>" size="20"/>
	    <?php echo form_error('business_value','<div id="validation">','</div>'); ?><br />
	    
	    <label>Priority</label>
	    <?php 
		$priority=array('musthave'=>'Must have', 'shouldhave'=>'Should have', 'couldhave'=>'Could have', 'wonthave'=>'Won\'t have this time' );
		echo form_dropdown('priority',$priority,$storyData->priority,'size="2"');
	    ?>
	    <div><form name="submit" action="editStory/verifyEdit"><input type="submit" value="Submit" /></form></div>
	</div>
    </div>
</div>
<?php if($msg!=0) {
	echo '<p style="color:green;margin-left:15%">'.$message.'</p>';
} ?>
</form>