<!--avtor:darko-->
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class VerifyLogin extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('users','',TRUE);
		$this->load->model("projects");
		$this->load->model("project_user");
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
			$this->session->set_userdata('varError',0);
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
			$sess_array = array(
			'id' => $result->id,
			'username' => $result->username,
			'name' => $result->name,
			'rights' => $result->rights,
			'project' => '');
			$this->session->set_userdata('logged_in', $sess_array);
			$this->session->set_userdata('UID',$result->id);
			$this->session->set_userdata('PID', $this->users->getLastPID($result->id));
			if($this->session->userdata('PID')){
				$this->session->set_userdata('project', $this->projects->getProjectName($this->session->userdata('PID')));
			}
			else{
				$this->session->set_userdata('project',"No project selected");
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