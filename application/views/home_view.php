<div id="content">
    <div id="left">
	<h2>Project wall</h2>
	<div>
	    <?php if($this->session->userdata('PID')) { 
	    echo form_open('home/wallPost'); ?>
		<?php $textArea=array( 'name'=>'wallPost', 'placeholder'=>'Post something to the wall', 'rows'=>'4', 'cols'=>'60'); 
		echo form_textarea($textArea,'','required');
		echo form_submit('', 'Post'); ?>
	    </form>
	</div>
	<div>
	<?php foreach ($wallPosts as $post) {
	    echo '<small>';
	    echo date('d.m.y, H:i:s', strtotime($post->date)).' </small><b>';
	    echo $post->username.': </b>';
	    echo $post->text;
	    echo '<br />';
	    }
	    }
	?>
	</div>
    </div>
    <?php $this->load->view('selProject', array('projects'=>$projects));   ?>
</div>
