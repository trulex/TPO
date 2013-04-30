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
    <p class="naslov">ScrumPro</p>
    <p class="welcome">Welcome, <?php echo anchor('profile',$name,'title="Edit profile"'); ?><br/>

	Current project: <?php echo $this->session->userdata('project'); ?> - (<?php if($this->session->userdata('PID')){ echo anchor('editproject','Edit');} ?>)<br>
	Current sprint: <?php	if($currentsprints){
		foreach($currentsprints as $row):
		    $today = strtotime(date("Y-m-d"));
		    if($today >= strtotime($row->start_date) && $today <= strtotime($row->finish_date)):
			echo $row->start_date." - ".$row->finish_date;
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
	<ul class="menu">
	    <?php echo $active == 'home' ? '<li class="active">'.anchor('home','Home') : '<li class="menu">'.anchor('home','Home'); ?>
		<?php echo $active == 'productbacklog' ? '<li class="active">'.anchor('productbacklog','Product Backlog') : '<li class="menu">'.anchor('productbacklog','Product Backlog'); ?>
	    <?php echo $active == 'sprintBacklog' ? '<li class="active">'.anchor('sprintBacklog','Sprint Backlog') : '<li class="menu">'.anchor('sprintBacklog','Sprint Backlog'); ?>
		<?php echo $active == 'mytasks' ? '<li class="active">'.anchor('mytasks','My tasks') : '<li class="menu">'.anchor('mytasks','My tasks'); ?>
	    <?php if ($rights) {
		echo $active == 'administration' ? '<li class="active">'.anchor('administration','Administration') : '<li class="menu">'.anchor('administration','Administration'); } ?>
	</ul>
    </div>
</div>
<hr>