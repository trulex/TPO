<!-- documentation -->
<!-- avtor: Lovrenc -->

<div id="content">
	<div class="left">
		<h> <?php echo $pData->name; ?> </h>
		<div id="documentation">
			<?php echo $pData->documentation;?>
			<br>
		</div>
		<form name="editDocumentation" method="post" action="documentation/editDocumentation" style="display:inline;">
		<button type="submit" name="doc">Edit</button>
		</form>
	</div>
</div>