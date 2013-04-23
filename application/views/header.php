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

	Current project: <?php echo $this->session->userdata('project'); ?> - (<?php echo anchor('editproject','Edit'); ?>)<br>
	Current sprint: <?php	if($currentsprints){
		foreach($currentsprints as $row):
		    $today = strtotime(date("Y-m-d"));
		    if($today >= strtotime($row->start_date) && $today <= strtotime($row->finish_date)):
				echo $row->start_date." - ".$row->finish_date;
				$this->session->set_userdata('SpID', $row->id);
			endif;
		endforeach;
	}
	?>
    </p>
    <div style="clear: both;"></div>​
    <div id="menu">
	<ul class="menu">
	    <?php echo $active == 'home' ? '<li class="active">'.anchor('home','Home') : '<li class="menu">'.anchor('home','Home'); ?>
		<?php echo $active == 'productBacklog' ? '<li class="active">'.anchor('productBacklog','Product Backlog') : '<li class="menu">'.anchor('productBacklog','Product Backlog'); ?>
	    <?php echo $active == 'sprintBacklog' ? '<li class="active">'.anchor('sprintBacklog','Sprint Backlog') : '<li class="menu">'.anchor('sprintBacklog','Sprint Backlog'); ?>
		<?php echo $active == 'mytasks' ? '<li class="active">'.anchor('mytasks','My tasks') : '<li class="menu">'.anchor('mytasks','My tasks'); ?>
	    <?php if (strcmp($rights,"admin")==0) {
		echo $active == 'administration' ? '<li class="active">'.anchor('administration','Administration') : '<li class="menu">'.anchor('administration','Administration'); } ?>
	</ul>
    </div>
</div>
<hr>