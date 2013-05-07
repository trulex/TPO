<!--avtor:BOSTJAN-->
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Unassignedstories extends CI_Controller { 

    function __construct() {
		parent::__construct();
		$this->load->model('projects');
		$this->load->model("sprints");
		$this->load->model("stories");
		$this->load->model('project_user');
    }
	
	function index() {
		if ( $this->session->userdata('PID')==0) redirect('home', 'refresh');
		if($this->session->userdata('logged_in')) {
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['name'] = $session_data['name'];
			$data['rights'] = $session_data['rights'];
			$data['active']='productbacklog';
			$data['activesubmenu1']='unfinishedstories';
			$data['activesubmenu2']='unassignedstories';
			$data['id']=$session_data['id'];
			$data['PID']=$this->session->userdata('PID');
			$data['project']=$session_data['project'];
			$data['projects']=$this->projects->getProjects($data['rights']);
			$data['currentsprints']=$this->sprints->getProjectSprints($this->session->userdata('PID'));
			$data['role']=$this->project_user->getRole($this->session->userdata['UID'],$data['PID']);
			$data['UID']=$this->session->userdata('UID');
			$data['ScrumMaster']=$this->project_user->getScrumMaster($this->session->userdata('PID'));
			$data['results']= $this->stories->getAll();

			$this->load->view('header', $data);
			$this->load->helper(array('form'));
			$this->load->view('productbacklog',$data);
			$this->load->view('submenu1');
			$this->load->view('submenu2');
			$this->load->view('unassignedstories_view',$data);
			$this->load->view('footer');
		} else {
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
    }
	
	
	function entry_SpID(){ 
		$this->load->database();

		$name=$this->input->post('submitstories');
		$data = array(
			'SpID'=>$this->session->userdata('SpID')
		); 

		$this->db->where('id',$name); 
		$this->db->update('stories',$data);
		redirect($this->input->post('redirect'));
	} 
	
	function changeDifficulty(){
		$difficulty=$this->input->post('difficulty');
		if (is_numeric($difficulty)){
			if ( $difficulty>=0){
				$this->stories->setDifficulty($this->input->post('StID'), $difficulty);
			}
		else{
			echo '<script alert("Time must numeric");</script>';
				$this->session->set_userdata("varError",1);
			}
		}
		else{
			$this->session->set_userdata("varError",2);
		}
		redirect($this->input->post('redirect'));
		
	}
	
	function deleteStory() {
	    $storyId=$this->input->post('StID');
	    $this->db->where('id', $storyId);
	    $this->db->delete('stories');
	    redirect($this->input->post('redirect'));
	}
}
?>