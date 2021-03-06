<!-- controllers/selectProject.php -->
<!--avtor:darko
Razred za izbiranje trenutnega projekta
-->
<?php

Class SelectProject extends CI_Controller {
	public function __construct()	{
		parent::__construct();
		$this->load->model("sprints");
		$this->load->model("projects");
		$this->load->model('users');
		$this->load->model("project_user");
	}

    public function select() {
		$this->session->set_userdata('project', $this->input->post('project'));
		$PID=$this->input->post('PID');
		$this->session->set_userdata('PID', $PID);
		$sprints=$this->sprints->getProjectSprints($PID);
		$today =date("Y-m-d"); /*in tukej dodamo še podatek o trenutnem sprintu*/
		$found=FALSE;
		if($sprints){
			foreach ($sprints as $sprint){
				if($today >= $sprint->start_date && $today <= $sprint->finish_date){
					$SpID=$sprint->id;
					$found=TRUE;
				}
			}
			if(!$found){
				$SpID=0;
			}
		}
		else{
			$SpID=0;
		}
		$this->session->set_userdata('SpID', $SpID);
		$this->users->storeLastPID($PID,$this->session->userdata('UID'));
		$this->session->set_userdata('noproject', '');
		redirect($this->input->post('redirect'));
    }
}
?>

