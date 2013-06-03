<!-- controllers/editSprint.php -->
<!--avtor:BOSTJAN-->
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class editSprint extends CI_Controller { 

    function __construct() {
		parent::__construct();
		$this->load->model('projects');
		$this->load->model('sprints');
		$this->load->model("project_user");
    }
	
	function index() {
		if ( $this->session->userdata('PID')==0) redirect('home', 'refresh');
		if($this->session->userdata('logged_in')) {
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['name'] = $session_data['name'];
			$data['rights'] = $session_data['rights'];
			$data['active']='productBacklog';
			$data['activesubmenu1']='';
			$data['activesubmenu2']='';
			$data['id']=$session_data['id'];
			$data['project']=$session_data['project'];
			$data['projects']=$this->projects->getProjects($data['rights']);
			
			$data['currentsprints']=$this->sprints->getProjectSprints($this->session->userdata('PID'));
			$data['role']=$this->project_user->getRole($this->session->userdata['UID'],$this->session->userdata('PID'));
			
			$this->load->view('header',$data);
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('startdate', 'Start date', 'required|min_length[8]|callback_date_check|callback_startsprint_check');
			$this->form_validation->set_rules('finishdate', 'Finish date', 'required|min_length[8]|callback_date_check|callback_finishdate_check|callback_finishsprint_check');
			$this->form_validation->set_rules('velocity', 'Sprint velocity', 'required|is_natural_no_zero');
			
			if ($this->form_validation->run() == FALSE) {
				$data['startdate']=$this->sprints->getStartDate($this->session->userdata('sprint'));
				$data['finishdate']=$this->sprints->getFinishDate($this->session->userdata('sprint'));
				$data['velocity']=$this->sprints->getVelocity($this->session->userdata('sprint'));
				$this->load->view('productBacklog',$data);
				$this->load->view('editSprint_view',$data);
			} else {
				$startdate=$this->input->post('startdate');
				$finishdate=$this->input->post('finishdate');
				$velocity=$this->input->post('velocity');
				
				$userdata=array(
					'start_date'=>date("Y-m-d" , strtotime($startdate)),
					'finish_date'=>date("Y-m-d", strtotime($finishdate)),
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
	
	public function date_check($str) {
		$parse_date=date_parse($str);
		$day=$parse_date["day"];
		$month=$parse_date["month"];
		$year=$parse_date["year"];
		
		$days=array(31,28,31,30,31,30,31,31,30,31,30,31);
		
		if((($year % 4 == 0) && ($year % 100 != 0) || ($year % 400 == 0))){
			$days[1]="29";
		}
		
		if ($month > 12 || $day == 0) {
			$this->form_validation->set_message('date_check', 'The inserted date is not possible!');
			return FALSE;
		}else if($day > $days[$month-1]){
			$this->form_validation->set_message('date_check', 'The inserted date is not possible!');
			return FALSE;
		} else {
			return TRUE;
		}
    }
	
	public function finishdate_check($str) {
		$start_date = date("Y-m-d", strtotime($this->input->post('startdate')));
		$input_date = date("Y-m-d", strtotime($str));

		if ($input_date <= $start_date) {
			$this->form_validation->set_message('finishdate_check', 'The finish date is invalid!');
			return FALSE;
		} else {
			return TRUE;
		}
    }
	
	public function startsprint_check($str) {
		$pid=$this->session->userdata('PID');
		$sprint=$this->session->userdata('sprint');
		$input_date = date("Y-m-d", strtotime($str));
		
		$this->db->select('start_date, finish_date');
		$this->db->from('sprints');
		$this->db->where('PID', $pid);
		$this->db->where('id !=', $sprint);
		
		$query=$this->db->get();
		$stevilo_vrstic=$query->num_rows();
		$index = 0;
		
		for($i=1; $i<=$stevilo_vrstic; $i++){
			$row=$query->row($i);
			$test1=$row->start_date;
			$test2=$row->finish_date;
			
			if($input_date >= $test1 && $input_date <= $test2){
				$index++;
			}			
		}

		if ($index > 0) {
			$this->form_validation->set_message('startsprint_check', 'The date collide with an existing sprint!');
			return FALSE;
		} else {
			return TRUE;
		}
    }
	
	public function finishsprint_check($str) {
		$pid=$this->session->userdata('PID');
		$sprint=$this->session->userdata('sprint');
		$input_date = date("Y-m-d", strtotime($str));
		$zacetek = date("Y-m-d", strtotime($this->input->post('startdate')));
		
		$this->db->select('start_date, finish_date');
		$this->db->from('sprints');
		$this->db->where('PID', $pid);
		$this->db->where('id !=', $sprint);
		
		$query=$this->db->get();
		$stevilo_vrstic=$query->num_rows();
		$index = 0;
		
		for($i=1; $i<=$stevilo_vrstic; $i++){
			$row=$query->row($i);
			$start=$row->start_date;
			$finish=$row->finish_date;
			
			if($input_date >= $start && $input_date <= $finish || $input_date >= $start && $input_date >= $finish && $zacetek <= $start && $zacetek <= $finish ){
				$index++;
			}
		}

		if ($index > 0) {
			$this->form_validation->set_message('finishsprint_check', 'The date collide with an existing sprint!');
			return FALSE;
		} else {
			return TRUE;
		}
    }
}
?>