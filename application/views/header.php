<html>
<head>
    <title>ScrumPRO</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/styles.css" media="screen" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<div class="glava">
    <p class="naslov">ScrumPRO</p>
    <?php 
    if (empty($username)) {
	echo '<p class="welcome">Please login to continue</p>'; 
    }
    else {
	echo '<p class="welcome">Welcome, <a href="#">'.$username.'</a></p>';
    }
    ?>
    <div style="clear: both;"></div>​
    <div id="menu">
	<ul>
	    <li><a href="#">Link1</a>
	    <li><a href="#">Link2</a>
	    <li><a href="#">Link3</a>
	</ul>
    </div>
</div>