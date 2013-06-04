<!-- views/homeSubmenu.php -->
<!-- avtor: Lovrenc -->
<div>
	<ul class="menu">
	    <?php
		echo $active2 == 'wall' ? '<li class="active">'.anchor('home','Wall') : '<li class="menu">'.anchor('home','Wall'); 
		echo $active2 == 'documentation' ? '<li class="active">'.anchor('documentation','Documentation') : '<li class="menu">'.anchor('documentation','Documentation'); ?>
	</ul>
</div>