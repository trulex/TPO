<!--avtor:darko
Razred za izbiranje trenutnega projekta
-->
<?php

Class SelectProject extends CI_Controller {
	public function __construct()	{
		parent::__construct();
		$this->load->model("sprints");
	}

    public function select() {
	$this->session->set_userdata('project', $this->input->post('project'));
	$PID=$this->input->post('PID');
	$this->session->set_userdata('PID', $PID);
	$sprints=$this->sprints->getProjectSprints($PID);
	$today =strtotime(date("Y-d-m")); /*in tukej dodamo še podatek o trenutnem sprintu*/
	foreach ($sprints as $sprint){
		 if($today >= strtotime($sprint->start_date) && $today <= strtotime($sprint->finish_date)){
			$this->session->set_userdata('SpID', $sprint->id);
			
		 }	}
	$this->session->set_userdata('noproject', '');
	echo $this->session->userdata('SpID');
// 	redirect($this->input->post('redirect'));
    }
}
?>

