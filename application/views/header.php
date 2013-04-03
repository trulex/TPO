<html>
<head>
    <title>ScrumPro</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/styles.css" media="screen" />
    <link rel="shortcut icon" href="favicon.ico" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<div class="glava">
    <p class="naslov">ScrumPro</p>
    <?php echo '<p class="welcome">Welcome, <a href="#">'.$name.'</a>' ?>
    <br/>
    <a href="home/logout">Logout</a>
    </p>
    <div style="clear: both;"></div>​
    <div id="menu">
	<ul class="menu">
	    <li class="menu"><a href="#">UserLink1</a>
	    <?php echo $active == 'productbacklog' ? '<li class="active">'.anchor('productbacklog','Product backlog') : '<li class="menu">'.anchor('productbacklog','Product backlog'); ?>
	    <?php echo $active == 'mytasks' ? '<li class="active">'.anchor('mytasks','My tasks') : '<li class="menu">'.anchor('mytasks','My tasks'); ?>
	    <?php if (strcmp($rights,"admin")==0) {
		echo $active == 'administration' ? '<li class="active">'.anchor('administration','Administration') : '<li class="menu">'.anchor('administration','Administration'); } ?>
	</ul>
    </div>
</div>
<hr>