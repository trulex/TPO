<!-- header -->
<!--avtor:darko-->
<html>
<head>
    <title>ScrumPro</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/styles.css" media="screen" />
    <link rel="shortcut icon" href="<?php echo base_url(); ?>favicon.ico" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<div class="glava">
    <p class="naslov"><a href="<?php echo base_url(); ?>"><font color="black">ScrumPro</font></a></p>
    <p class="welcome">Welcome, <?php echo anchor('profile',$name,'title="Edit profile"'); ?><br/>

	Current project: <?php echo $this->session->userdata('project'); ?><?php if($this->session->userdata('PID') && ($rights || $role==1)){ echo " - (".anchor('editproject','Edit').")";} ?><br>
	Current sprint: <?php	if($currentsprints){
		$this->session->set_userdata('SpID', 0);
		foreach($currentsprints as $row):
		    $today = date("Y-m-d");
		    if($today >= $row->start_date && $today <= $row->finish_date):
				echo date("d.m.Y", strtotime($row->start_date))." - ".date("d.m.Y", strtotime($row->finish_date));
			$this->session->set_userdata('SpID', $row->id);
		endif;
		endforeach;
	}
	else{
		$this->session->set_userdata('SpID', 0);
	}
	?>
    </p>
    <div style="clear: both;"></div>​
    <div id="menu">
	<ul id="menu">
	    <?php echo $active == 'wall' ? '<li class="active">'.anchor('home','Wall') : '<li class="menu">'.anchor('home','Wall'); ?>
		<?php echo $active == 'productBacklog' ? '<li class="active">'.anchor('allStories','Product Backlog') : '<li class="menu">'.anchor('allStories','Product Backlog'); ?>
	    <?php echo $active == 'sprintBacklog' ? '<li class="active">'.anchor('allTasks','Sprint Backlog') : '<li class="menu">'.anchor('allTasks','Sprint Backlog'); ?>
		<?php echo $active == 'mytasks' ? '<li class="active">'.anchor('mytasks','My tasks') : '<li class="menu">'.anchor('mytasks','My tasks'); ?>
		<?php echo $active == 'progressReport' ? '<li class="active">'.anchor('progressReport','Progress report') : '<li class="menu">'.anchor('progressReport','Progress report'); ?>
	    <?php if ($rights) {
		?>
		<li class="menu"><a href="#">Administration</a>
		<ul class="sub-menu">
		    <li><?php echo anchor('adduser','Add users'); ?></li>
		    <li><?php echo anchor('addproject','Add projects'); ?></li>
		    <li><?php echo anchor('editUsers','Edit users'); ?></li>
		</ul>
		</li>
		<?
		} ?>
	</ul>
    </div>
</div>
<hr>