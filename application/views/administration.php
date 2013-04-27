<!--avtor:darko-->
<?php $this->load->helper('form'); ?>
<div id="content">
    <div id="left">
	<p id="title">Administration options</p>
	<ul>
	    <li><?php echo anchor('adduser','Add new users'); ?></li>
	    <li><?php echo anchor('addproject','Add new projects'); ?></li>
	    <li><?php echo anchor('editUsers','Edit users'); ?></li>
	</ul>
    </div>
</div>
