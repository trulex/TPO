<!-- views/notes.php -->

<div class="notes">
	<h5 id="note"><?php foreach(explode("\n", $story->note) as $note) { echo $note.'<br>';}?></h5>
	<div class="gumbR">
		<form name="editNote" method="post" action="editNote" style="display:inline;">
			<input name="redirect" type="hidden" value="<?php echo $this->uri->uri_string(); ?>" />
			<button type="submit" value="<?php echo $story->id; ?>" name="StID">Notes</button>
		</form>
	</div>
	<br>
</div>