<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class VerifyAddSprint extends CI_Controller { 

	private $date;

    function __construct(){
		parent::__construct();
    }
	
	function index() {
		if($this->session->userdata('logged_in')) {
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['name'] = $session_data['name'];
			$data['rights'] = $session_data['rights'];
			
			$this->load->view('header',$data);
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('startdate', 'Start date', 'required|callback_invaliddate_check|callback_date_check|callback_startdate_check|callback_startsprint_check');
			$this->form_validation->set_rules('finishdate', 'Finish date', 'required|callback_invaliddate_check|callback_date_check|callback_finishdate_check|callback_finishsprint_check');
			$this->form_validation->set_rules('velocity', 'Sprint velocity', 'required|numeric');
			
			if ($this->form_validation->run() == FALSE) {
				$this->load->view('addsprint_view',$data);
			} else {
				$startdate=$this->input->post('startdate');
				$finishdate=$this->input->post('finishdate');
				$velocity=$this->input->post('velocity');
				
				$userdata=array(
					'start_date'=>$startdate,
					'finish_date'=>$finishdate,
					'velocity'=>$velocity
					);
				$this->db->insert('sprints', $userdata);
				$this->load->view('sprintsuccess');
			}
			$this->load->view('footer');
		} else {
	    //If no session, redirect to login page
	    redirect('login', 'refresh');
		}
	}
	
	public function invaliddate_check($str) {
		$dolzina=strlen($str);
		
		if ($dolzina < 8) {
			$this->form_validation->set_message('invaliddate_check', 'This is not a date!');
			return FALSE;
		} else {
			return TRUE;
		}
    }
	
	public function date_check($str) {
		//$input_date = strtotime($str);
		$parse_date=date_parse($str);
		$day=$parse_date["day"];
		$month=$parse_date["month"];
		$year=$parse_date["year"];
		
		$days=array(31,28,31,30,31,30,31,31,30,31,30,31);
		
		if((($year % 4 == 0) && ($year % 100 != 0) || ($year % 400 == 0))){
			$days[1]="29";
		}
		
		if ($month > 12) {
			$this->form_validation->set_message('date_check', 'The inserted date is not possbile!');
			return FALSE;
		}else if($day > $days[$month-1]){
			$this->form_validation->set_message('date_check', 'The inserted date is not possbile!');
			return FALSE;
		} else {
			return TRUE;
		}
    }
	
	public function startdate_check($str) {
		$todays_date = date("Y-m-d");
		$this->date=$str;
		
		$today = strtotime($todays_date);
		$input_date = strtotime($str);

		
		if ($input_date < $today) {
			$this->form_validation->set_message('startdate_check', 'The date is invalid!');
			return FALSE;
		} else {
			return TRUE;
		}
    }
	
	public function finishdate_check($str) {
		$test = strtotime($this->date);
		$input_date = strtotime($str);

		if ($input_date <= $test) {
			$this->form_validation->set_message('finishdate_check', 'The finish date is invalid!');
			return FALSE;
		} else {
			return TRUE;
		}
    }
	
	public function startsprint_check($str) {
		
		$input_date = strtotime($str);
		$this->date=$input_date; 
		
		$this->db->select('start_date, finish_date');
		$this->db->from('sprints');
		$query=$this->db->get();
		$stevilo_vrstic=$query->num_rows();
		$index = 0;
		
		for($i=1; $i<=$stevilo_vrstic; $i++){
			$row=$query->row($i);
			$test1=strtotime($row->start_date);
			$test2=strtotime($row->finish_date);
			
			if($input_date >= $test1 && $input_date <= $test2){
				$index++;
			}			
		}

		if ($index > 0) {
			$this->form_validation->set_message('startsprint_check', 'The dates collide with an existing sprint!');
			return FALSE;
		} else {
			return TRUE;
		}
    }
	
	public function finishsprint_check($str) {
		
		$input_date = strtotime($str);
		
		$this->db->select('start_date, finish_date');
		$this->db->from('sprints');
		$query=$this->db->get();
		$stevilo_vrstic=$query->num_rows();
		$index = 0;
		
		for($i=1; $i<=$stevilo_vrstic; $i++){
			$row=$query->row($i);
			$start=strtotime($row->start_date);
			$finish=strtotime($row->finish_date);
			
			if($input_date >= $start && $input_date <= $finish || $input_date >= $start && $input_date >= $finish && $this->date <= $start && $this->date <= $finish ){
				$index++;
			}
		}

		if ($index > 0) {
			$this->form_validation->set_message('finishsprint_check', 'The dates collide with an existing sprint!');
			return FALSE;
		} else {
			return TRUE;
		}
    }
	
}