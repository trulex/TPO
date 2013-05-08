<!--avtor:Lovrenc-->
<div id="content">
    <div id="left">
	<div id="add">
	<p><?php echo $story->name; ?></p>
		<?php  
		echo form_open('editNote/edit'); ?>
			<textarea name="text" class="addTask" cols="60" rows="10"><?php echo $story->note?> </textarea><br />
			<input name="StID" type="hidden" value="<?php echo $story->id?>" />
			<input name="return" type="hidden" value="<?php echo $return; ?>"/>
			<button type="submit" value="Submit" >Submit</button>
		</form>
	</div>
	</div>
</div>
