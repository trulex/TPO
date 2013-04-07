<!--avtor:darko-->
<?php

Class SelectProject extends CI_Controller {
    public function select() {
	$this->session->set_userdata('project', $this->input->post('project'));
	redirect($this->input->post('redirect'));
    }
}
?>
