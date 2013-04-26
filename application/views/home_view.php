<div id="content">
	<div id="left">
    <h1>Home</h1>
    <h2>Welcome <?php echo $username; ?>!</h2>
     Get your shit together it's time to work, pick a project and SCRUMMMMMMmmmm!!!! <br>
	<img border="0" src="/pics/magic.jpg" alt="Pulpit rock" width="460" height="1335">
     </div>
	<?php $this->load->view('selProject', array('projects'=>$projects));   ?>
</div>