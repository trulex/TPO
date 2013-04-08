<!--avtor:darko
Razred za izbiranje trenutnega projekta
-->
<?php

Class SelectProject extends CI_Controller {
    public function select() {
	$this->session->set_userdata('project', $this->input->post('project'));
	$this->session->set_userdata('noproject', '');
	redirect($this->input->post('redirect'));
    }
}
?>
