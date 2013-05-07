<div id="content">
	<div id="left">
		<h2>Home</h2>
		<h3>Welcome <?php echo $username; ?>!</h3>
		Get your shit together it's time to work, pick a project and SCRUMMMMMMmmmm!!!! <br>
		<img border="0" src="../pics/magic.jpg" alt="Pulpit rock" width="460" height="1335">
    </div>
	<?php $this->load->view('selProject', array('projects'=>$projects));   ?>
</div>