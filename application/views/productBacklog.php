<!-- views/productBacklog.php -->
<div id="content">
    <div id="left">
	<h2>Product backlog</h2>
    </div>
    <?php $this->load->view('selProject', array('projects'=>$projects));   ?>
</div>