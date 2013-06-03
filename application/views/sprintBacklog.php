<!-- views/sprintBacklog.php -->
<!-- avtor:Lovrenc -->

<div id="content">
	<div id="left">
		<h2>Sprint backlog</h2>
    </div>
	<?php $this->load->view('selProject', array('projects'=>$projects));   ?>
</div>