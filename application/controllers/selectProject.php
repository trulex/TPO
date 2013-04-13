<!--avtor:darko
Razred za izbiranje trenutnega projekta
-->
<?php

Class SelectProject extends CI_Controller {
	public function __construct()	{
		parent::__construct();
		$this->load->model("sprints");
		$this->load->model("projects");
	}

    public function select() {
		$this->session->set_userdata('project', $this->input->post('project'));
		$PID= $this->projects->getProjectID($this->input->post('project'));
		$this->session->set_userdata('PID', $PID);
		$sprints=$this->sprints->getProjectSprints($PID);
		$today =strtotime(date("Y-m-d")); /*in tukej dodamo še podatek o trenutnem sprintu*/
		echo $PID.">>>>";
		$found=FALSE;
		if($sprints){
			foreach ($sprints as $sprint){
				if($today >= strtotime($sprint->start_date) && $today <= strtotime($sprint->finish_date)){
					$this->session->set_userdata('SpID', $sprint->id);
					$found=TRUE;
				}
			}
			if(!$found){
				$this->session->set_userdata('SpID', '0');
			}
		}
		else{
			$this->session->set_userdata('SpID', '0');
		}
		$this->session->set_userdata('noproject', '');
		redirect($this->input->post('redirect'));
    }
}
?>

