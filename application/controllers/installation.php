<!-- controllers/install.php -->
<!-- avtor: Lovrenc -->

<?php


class Installation extends CI_Controller {
	
	public function __construct()	{
		parent::__construct();
		$this->load->model('install');
	}
	
	public function index()	{	
		$this->load->helper(array('form'));
		$this->load->library('form_validation');
		$this->load->view("installation");
		
	}
	
	function reboot(){
		$this->load->helper(array('form'));
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|alpha');
	    $this->form_validation->set_rules('password', 'Password', 'trim|required|alpha_numeric');
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('installation');
		} 
		else {
			$this->install->dumpData();
			$this->install->initializeDatabase();
			$username=$this->input->post('username');
			$password=md5($this->input->post('password'));
			$userdata=array(
				'username'=>$username,
				'password'=>$password,
				'name'=>"",
				'surname'=>"",
				'email'=>"",
				'rights'=>1 );
			$this->db->insert('users', $userdata);
			redirect('home/logout', 'refresh');
		}
	}
}
?>