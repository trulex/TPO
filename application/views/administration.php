<!--avtor:darko-->
<?php $this->load->helper('form'); ?>
<div id="content">
    <div id="left">
	<h2>Administration</h2>
	<ul>
	    <li><?php echo anchor('adduser','Add new users'); ?></li>
	    <li><?php echo anchor('addproject','Add new projects'); ?></li>
	</ul>
    </div>
    <?php $this->load->view('selProject', array('projects'=>$projects));   ?>
</div>
