<!-- editDocumentation -->
<!-- avtor: Lovrenc -->

<div id="content">
	<div class="left">
		<div id="documentation">
			<h> <?php echo $pData->name; ?> </h>
			<?php echo $pData->documentation;?>
		</div>
		<br/>
		<hr/>
		<div id="editDocumentation">
			<textarea name="text" class="addTask" cols="60" rows="10"><?php echo $pData->documentation;?></textarea><br />		
		</div>
		<?php
		echo '<form name="importStoryData" method="post" action="documentation/storyDataImport" style="display:inline;">';
		echo '<input name="return" type="hidden" value="'.$this->uri->uri_string().'" />';
		echo '<button type="submit" name="import">Import story data</button></form>';
		?>
	</div>
</div>