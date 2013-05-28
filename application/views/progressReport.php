<div id="content">
    <div id="left">
	<h2>Progress report</h2>
		<b>X-axis: </b>days since project start (<?php if($startDate){echo date("d.m.Y",strtotime($startDate));}else{ echo "Sprints not declared yet";}?>)<br>
		<b>Y-axis: </b>hours of work<br>
		<img border="0" src="../pics/graf.png" alt="Pulpit rock" width="720" height="400"><br>
		<b>Project status: </b><span style="color:#006699;font-weight:bold"><?php echo round($hoursTotal-$hoursWorked,2) ?></span> of work remaining / <span style="color:#006699;font-weight:bold"><?php echo round($hoursWorked,2) ?></span> of work spent
		<br>
	</div>
</div>