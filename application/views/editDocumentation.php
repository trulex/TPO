<!-- editDocumentation -->
<!-- avtor: Lovrenc -->

<div id="content">
	<div class="left">
		<div id="documentation">
			<h> <?php echo $pData->name; ?> </h>
		</div>
		<?php 
			if(isset($error)) {
				foreach($error as $err){
					echo $err;
				}
			
			}
		?>
		<br/>
		<div id="editDocumentation">
			<?php echo form_open('documentation/saveDocumentation'); ?>
			<textarea name="documentation" class="addTask" cols="60" rows="10"><?php echo $pData->documentation;?></textarea><br />	
			<button type="submit" name="doc">Save</button>
			</form>
		</div>
		<?php
		echo form_open('documentation/importStoryData');
		echo '<table border="0"><tr>';
		echo '<td>Story Descriptions:</td><td><input type="checkbox" name="storiesDescriptions" value="1"></td></tr><tr>';
		echo '<td>Story Tests:</td><td><input type="checkbox" name="storiesTests" value="1"></td></tr><tr>';
		echo '<td>Story Notes:</td><td><input type="checkbox" name="storiesNotes" value="1"></td></tr><tr>';
		echo '<td>Task Descriptions:</td><td><input type="checkbox" name="taskDescriptions" value="1"></td></tr></table>';
		echo '<button type="submit" name="import">Import story data</button></form>';
		?>
		<?php echo form_open_multipart('documentation/uploadDocumentation');?>
		<input type="file" name="userfile" size="25" />
		<br />
		<br />
		<input type="submit" value="upload" />
		</form>
	</div>
</div>