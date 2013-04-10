<!--avtor:BOSTJAN-->
<?php echo form_open('unfinishedstories');
		if ($this->session->flashdata('flashSuccess') != ''): 
			$this->session->flashdata('flashSuccess'); 
		endif;
?>

<div id="content">
    <div id="left">
	<div id="add">
	<p>Stories: </p><br>
	<?php foreach($results as $row): ?>
			<div id="zgodba">
			<input name="listofmembers[]" type="checkbox" value=<?php $row->id; ?>>
			<?php
			echo "<h4>".$row->name."</h4></input><br>";
			echo "<h5>".$row->text."</h5>";
			echo "<br>";
			?>
			</div>
		<?php endforeach ?>
		
		<div><input type="submit" value="Add to current sprint" /></div>
		<span style="color:red"><?php echo $this->session->flashdata('flashSuccess') ?></span>
	</div>	
	</div>
</div>
</form>