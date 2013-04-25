<!--avtor:BOSTJAN-->
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class editSprint extends CI_Controller { 

    function __construct() {
		parent::__construct();
		$this->load->model('projects');
		$this->load->model('sprints');
    }
	
	function index() {
		if ( $this->session->userdata('PID')==0) redirect('home', 'refresh');
		if($this->session->userdata('logged_in')) {
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['name'] = $session_data['name'];
			$data['rights'] = $session_data['rights'];
			$data['active']='meni';
			$data['id']=$session_data['id'];
			$data['project']=$session_data['project'];
			$data['projects']=$this->projects->getProjects($data['id']);
			
			$data['currentsprints']=$this->sprints->getProjectSprints($this->session->userdata('PID'));
			
			$this->load->view('header',$data);
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('startdate', 'Start date', 'required|min_length[8]|callback_date_check|callback_startdate_check|callback_startsprint_check');
			$this->form_validation->set_rules('finishdate', 'Finish date', 'required|min_length[8]|callback_date_check|callback_finishdate_check|callback_finishsprint_check');
			$this->form_validation->set_rules('velocity', 'Sprint velocity', 'required|is_natural_no_zero');
			
			if ($this->form_validation->run() == FALSE) {
				$data['startdate']=$this->sprints->getStartDate($this->session->userdata('sprint'));
				$data['finishdate']=$this->sprints->getFinishDate($this->session->userdata('sprint'));
				$data['velocity']=$this->sprints->getVelocity($this->session->userdata('sprint'));
				$this->load->view('editSprint_view',$data);
			} else {
				$startdate=$this->input->post('startdate');
				$finishdate=$this->input->post('finishdate');
				$velocity=$this->input->post('velocity');
				
				$userdata=array(
					'start_date'=>$startdate,
					'finish_date'=>$finishdate,
					'velocity'=>$velocity,
					);
				$this->db->where('id', $this->session->userdata('sprint'));
				$this->db->update('sprints', $userdata);
				$this->session->set_flashdata('flashSuccess', 'Sprint successfully changed.');
				redirect('addsprint');
			}
			$this->load->view('footer');
		} else {
	    //If no session, redirect to login page
	    redirect('login', 'refresh');
		}
    }
}
?>