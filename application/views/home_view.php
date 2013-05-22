<div id="content">
	<div id="left">
		<h2>Home</h2>
		<h3>Welcome <?php echo $username; ?>!</h3>
		It's time to work, pick a project and SCRUMMMMMMmmmm!!!! <br>
    </div>
	<?php $this->load->view('selProject', array('projects'=>$projects));   ?>
</div>