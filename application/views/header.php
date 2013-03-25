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
	    <li class="menu"><a href="#">UserLink2</a>
	    <li class="menu"><a href="#">UserLink3</a>
	    <?php if (strcmp($rights,"admin")==0) {
		echo '<li class="menu">'.anchor('administration','Administration'); } ?>
	</ul>
    </div>
</div>