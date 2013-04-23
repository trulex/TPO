<!--avtor:darko-->
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class VerifyLogin extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('users','',TRUE);
		$this->load->model("projects");
		$this->load->model("sprints");
	}

	function index()
	{
		$this->load->view('header_login');
		//This method will have the credentials validation
		$this->load->library('form_validation');

		$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');
		if($this->form_validation->run() == FALSE)
		{
		//Field validation failed.  User redirected to login page
			$this->load->view('login_view');
		}
		else
		{
		//Go to private area
			redirect('home', 'refresh');
		}
		$this->load->view('footer');
	}

	function check_database($password)
	{
	//Field validation succeeded.  Validate against database
	$username = $this->input->post('username');

	//query the database
	$result = $this->users->login($username, $password);

	if($result)
	{
		$sess_array = array();
		foreach($result as $row)
		{
			$sess_array = array(
			'id' => $row->id,
			'username' => $row->username,
			'name' => $row->name,
			'rights' => $row->rights,
			'project' => '');
			$this->session->set_userdata('logged_in', $sess_array);
			$this->session->set_userdata('UID',$row->id);
			$this->session->set_userdata('PID', $this->users->getLastPID($row->id));
			$this->session->set_userdata('project', $this->projects->getProjectName($this->session->userdata('PID')));
			$sprints=$this->sprints->getProjectSprints($this->session->userdata('PID'));
			$today =strtotime(date("Y-m-d")); /*in tukej dodamo še podatek o trenutnem sprintu*/
			$found=FALSE;
			if($sprints){
				foreach ($sprints as $sprint){
					if($today >= strtotime($sprint->start_date) && $today <= strtotime($sprint->finish_date)){
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
		}
		session_start();
		$_SESSION['project']='';
		return TRUE;
	}
	else
	{
		$this->form_validation->set_message('check_database', 'Invalid username or password');
		return false;
	}
	}
}
?>