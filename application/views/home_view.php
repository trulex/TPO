<!-- http://papermashup.com/jquery-show-hide-plugin/ -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js" type="text/javascript"></script>
<script type="text/javascript">
(function ($) {
    $.fn.showHide = function (options) {
    //default vars for the plugin
        var defaults = {
            speed: 10000,
            easing: '',
            changeText: 0,
            showText: 'Show',
            hideText: 'Hide'
        };
        var options = $.extend(defaults, options);
        $(this).click(function () {
// optionally add the class .toggleDiv to each div you want to automatically close
                      $('.toggleDiv').slideUp(options.speed, options.easing);
             // this var stores which button you've clicked
             var toggleClick = $(this);
             // this reads the rel attribute of the button to determine which div id to toggle
             var toggleDiv = $(this).attr('rel');
             // here we toggle show/hide the correct div at the right speed and using which easing effect
             $(toggleDiv).slideToggle(options.speed, options.easing, function() {
             // this only fires once the animation is completed
             if(options.changeText==1){
             $(toggleDiv).is(":visible") ? toggleClick.text(options.hideText) : toggleClick.text(options.showText);
             }
              });
          return false;
        });
    };
})(jQuery);
$(document).ready(function(){
   $('.show_hide').showHide({
        speed: 100,  // speed you want the toggle to happen
        easing: '',  // the animation effect you want. Remove this line if you dont want an effect and if you haven't included jQuery UI
        changeText: 0, // if you dont want the button text to change, set this to 0
        showText: 'View',// the button text to show when a div is closed
        hideText: 'Close' // the button text to show when a div is open
    });
});
</script>
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
	<div style="width:600px">
	    <?php $i=1; foreach ($wallPosts as $post) {
		echo '<b>'.$post->username.'</b>';
		echo ' <small>'.date('d.m.y, H:i:s', strtotime($post->date)).' </small><br />';
		echo $post->text;
		echo '<br />';
		echo '<div id="comments"></div>';
		echo '<br />';
		echo '<a href="#" class="show_hide" rel="#slidingDiv'.$i.'">Comment</a>';
		$textAreaComment=array('name'=>'comment', 'placeholder'=>'Write a comment', 'rows'=>'2', 'cols'=>'40');
		echo form_open('home/comment');
		    echo '<div class="toggleDiv" id="slidingDiv'.$i.'" style="display:none">'.form_textarea($textAreaComment,'','required');
		    echo form_submit('', 'Post');
		    echo '</div>';
		echo '</form>';
		echo '<hr>';
		$i++;
		    }
		}
	    ?>
	</div>
    </div>
    <?php $this->load->view('selProject', array('projects'=>$projects));   ?>
</div>
