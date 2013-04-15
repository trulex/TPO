<div id="content">
    <div id="left">
	<p id="title">Menu</p>
	<ul>
	    <li><?php echo anchor('unfinishedstories','Unfinished stories'); ?></li>
	    <li><?php echo anchor('unasignedStories','Unasigned stories'); ?></li>
	    <li><?php echo anchor('fstories','Finished stories'); ?></li>
	    <li><?php echo anchor('freleases','Future releases'); ?></li>
	    <li><?php echo anchor('addstory','Add new user stories'); ?></li>
	    <li><?php echo anchor('addsprint','Add new sprints'); ?></li>
	</ul>
    </div>
    <?php $this->load->view('selProject', array('projects'=>$projects));   ?>
</div>