<!-- views/documentation.php -->
<!-- avtor: Lovrenc -->

<div id="content">
	<div class="left">
		<h> <?php echo $pData->name; ?> </h>
		<div id="documentation">
			<?php echo $pData->documentation;?>
			<br>
		</div>
		<?php echo form_open('documentation/editDocumentation'); ?>
		<button type="submit" name="doc">Edit</button>
		</form>
		<?php echo form_open('documentation/downloadDocumentation'); ?>
		<button type="submit" name="doc">Download</button>
		</form>
	</div>
</div>